<?php

namespace App\Http\Controllers\Api;

use App\CurrentStock;
use App\CurrentStockDetails;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\PurchaseDetails;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        $data = [];
        $data['purchases'] = Purchase::with('supplier', 'purchase_details')->where('status', 1)->latest()->get();
        $data['approved_purchases'] = Purchase::with('supplier', 'purchase_details')->where('status', 2)->latest()->get();
        $data['success'] = true;
        $data['message'] = 'All purchase are given';
        return response()->json($data, 200);
    }

    public function create()
    {
        $data = [];
        $data['supplier'] = Supplier::all();
        $data['success'] = true;
        $data['message'] = 'Supplier information given';
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        try {
            if ($request->has('product_id') && $request->has('supplier_id')) {
                $purchase = new Purchase();
                $purchase->supplier_id = $request->supplier_id;
                $purchase->gross_total = $request->gross_total;
                if ($request->has('discount')) {
                    $purchase->discount = $request->discount;
                } else {
                    $purchase->discount = 0;
                }
                $purchase->net_total = $request->net_total;
                $purchase->invoice_code = 'INV-' . date("dmy") . time();
                $purchase->remarks = $request->remarks;
                $purchase->status = 1;
                if ($purchase->save()) {
                    foreach ($request->product_id as $key => $value) {
                        $details = new PurchaseDetails();
                        $details->product_id = $request->product_id[$key];
                        $details->purchase_id = $purchase->id;
                        $details->quantity = $request->quantity[$key];
                        $details->price = $request->price[$key];
                        $details->quantity = $request->quantity[$key];
                        $details->subtotal = $request->subtotal[$key];
                        $details->save();
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'Purchase has been created successfully',
                        'purchase' => $purchase
                    ], 200);
                }
                return response()->json([
                    'error' => true,
                    'message' => 'Purchase was not successfully created',
                ], 404);
            }
            return response()->json([
                'error' => true,
                'message' => 'Select at least one product'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => "Sales Unsuccessful"
            ], 404);
        }


    }

    public function show($id)
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'Individual purchase data given';
        $data['purchases'] = Purchase::with(['supplier', 'purchase_details'=>function($query){
            $query->with('product');
        }])->findOrFail($id);
//        $data['purchase_products'] = PurchaseDetails::with('product', 'purchase')->where('purchase_id', $id)->get();
        return response()->json($data, 200);
    }

    public function edit($id)
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'Individual purchase data given';
        $data['supplier'] = Supplier::all();
        $data['purchases'] = Purchase::with('supplier', 'purchase_details')->findOrFail($id);
        $data['purchase_products'] = PurchaseDetails::with('product', 'purchase')->where('purchase_id', $id)->get();
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->has('product_id') && $request->has('supplier_id')) {
                $purchase = Purchase::findOrFail($id);
                if ($purchase['status'] ==2){
                    return response()->json(['type'=>'error','message'=>'Purchase already been updated'],400);
                }
                $purchase->supplier_id = $request->supplier_id;
                $purchase->gross_total = $request->gross_total;
                if ($request->has('discount')) {
                    $purchase->discount = $request->discount;
                } else {
                    $purchase->discount = 0;
                }
                $purchase->net_total = $request->net_total;
                $purchase->remarks = $request->remarks;
                $purchase->status = $request->status;
                if ($purchase->save()) {
                    $deletes = PurchaseDetails::where('purchase_id', $purchase->id)->delete();
                    foreach ($request->product_id as $key => $value) {
                        $details = new PurchaseDetails();
                        $details->product_id = $request->product_id[$key];
                        $details->purchase_id = $purchase->id;
                        $details->quantity = $request->quantity[$key];
                        $details->price = $request->price[$key];
                        $details->quantity = $request->quantity[$key];
                        $details->subtotal = $request->subtotal[$key];
                        $details->save();
                        if ($purchase->status == 2) {
                            $stock_details = new CurrentStockDetails();
                            $stock_details->product_id = $details->product_id;
                            $stock_details->type = "purchase";
                            $stock_details->date = date('Y-m-d');
                            $stock_details->quantity = $details->quantity;
                            $stock_details->invoice = $purchase->invoice_code;
                            if ($stock_details->save()) {
                                $stock = CurrentStock::findOrFail($stock_details->product_id);
                                $stock_old_quantity = $stock->quantity;
                                $stock->quantity = (int)$stock_old_quantity + $stock_details->quantity;
                                $stock->save();
                            }
                        }
                    }
                    if ($purchase->status == 2) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Purchase has been approved successfully',
                            'purchases' => $purchase
                        ], 200);
                    }
                    return response()->json([
                        'error' => true,
                        'message' => 'Purchase has not been approved yet??'
                    ], 404);
                }
                return response()->json([
                    'error' => true,
                    'message' => 'Purchase update unsuccessful'
                ], 404);
            }
            return response()->json([
                'error' => true,
                'message' => 'Select at least one product'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Purchase Unsuccessful'
            ], 404);
        }
    }

    public function delete($id)
    {
        $delete_purchase = Purchase::findOrFail($id);
        if ($delete_purchase->status == 2) {
            return response()->json([
                'error' => true,
                'message' => 'Can not delete a approved purchase',
            ],401);
        }
        $delete_purchase_details = PurchaseDetails::where('purchase_id', $delete_purchase->id)->delete();
        $delete_purchase->delete();
        return response()->json([
            'success' => true,
            'message' => 'Purchase has been deleted successfully',
        ],200);
    }
}
