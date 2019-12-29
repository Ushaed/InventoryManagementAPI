<?php

namespace App\Http\Controllers\Api;

use App\CurrentStock;
use App\CurrentStockDetails;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SaleDetails;
use Exception;
use Illuminate\Http\Request;

class SaleController extends Controller
{

    public function index()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'All purchase are given';
        $data['sales'] = Sale::where('status', 1)->latest()->get();
        $data['approved_sales'] = Sale::where('status', 2)->latest()->get();

        return response()->json($data, 200);
    }


    public function create()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'Sale Create';
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        foreach ($request->product_id as $key => $value) {
            $stock = CurrentStock::findOrFail($request->product_id[$key]);
            if ($request->quantity[$key] > $stock->quantity){
                return response()->json(['error'=>true,'message'=>'Selected product quantity is out of stock'],404);
            }
        }
        try {
            if ($request->has('product_id')) {
                $sales = new Sale();
                $sales->customer_name = $request->customer_name;
                $sales->customer_phone = $request->customer_phone;
                $sales->gross_total = $request->gross_total;
                if ($request->has('discount')) {
                    $sales->discount = $request->discount;
                } else {
                    $sales->discount = 0;
                }
                $sales->net_total = $request->net_total;
                $sales->invoice_code = 'SAL-' . date("dmy") . time();
                $sales->remarks = $request->remarks;
                $sales->status = 1;

                if ($sales->save()) {
                    foreach ($request->product_id as $key => $value) {
                        $details = new SaleDetails();
                        $details->product_id = $request->product_id[$key];
                        $details->sale_id = $sales->id;
                        $details->quantity = $request->quantity[$key];
                        $details->price = $request->price[$key];
                        $details->quantity = $request->quantity[$key];
                        $details->subtotal = $request->subtotal[$key];
                        $details->save();
                    }
                    return response()->json([
                        'success' => true,
                        'message' => 'Sales has been created successfully',
                        'sale_product' => $sales
                    ], 200);
                }
                return response()->json([
                    'error' => true,
                    'message' => 'Sale was not successful(unknown reason)'
                ], 404);
            }
            return response()->json([
                'error' => true,
                'message' => 'Select at least one product'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Sales Unsuccessful'
            ], 404);
        }
    }

    public function show($id)
    {
        $sales = Sale::with(['sales_details'=>function($query){
            $query->with('product');
        }])->findOrFail($id);
        $data = [];
        $data['success'] = true;
        $data['message'] = "Sales Information of " . $sales['invoice_code'];
        $data['sales'] = $sales;
        $data['sales_products'] = SaleDetails::with('product')->where('sale_id', $id)->get();

        return response()->json($data, 200);
    }


    public function edit($id)
    {
        $data = [];
        $data['sales'] = Sale::with('sales_details')->findOrFail($id);
        $data['sales_products'] = SaleDetails::with(['product'=>function($query){
            $query->with('stock');
        }])->where('sale_id', $id)->get();
        $data['success'] = true;
        $data['message'] = "Sales Information of " . $data['sales']['invoice_code'];
        return response()->json($data, 200);
    }


    public function update(Request $request, $id)
    {
        foreach ($request->product_id as $key => $value) {
        $stock = CurrentStock::findOrFail($request->product_id[$key]);
        if ($request->quantity[$key] > $stock->quantity){
            return response()->json(['error'=>true,'message'=>'Selected product quantity is out of stock'],404);
            }
        }
        try {
            if ($request->has('product_id')) {
                $sales = Sale::findOrFail($id);
                $sales->customer_name = $request->customer_name;
                $sales->customer_phone = $request->customer_phone;
                $sales->gross_total = $request->gross_total;
                if ($request->has('discount')) {
                    $sales->discount = $request->discount;
                } else {
                    $sales->discount = 0;
                }
                $sales->net_total = $request->net_total;
                $sales->remarks = $request->remarks;
                $sales->status = $request->status;
                if ($sales->save()) {
                    $deletes = SaleDetails::where('sale_id', $sales->id)->delete();
                    foreach ($request->product_id as $key => $value) {
                        $details = new SaleDetails();
                        $details->product_id = $request->product_id[$key];
                        $details->sale_id = $sales->id;
                        $details->quantity = $request->quantity[$key];
                        $details->price = $request->price[$key];
                        $details->quantity = $request->quantity[$key];
                        $details->subtotal = $request->subtotal[$key];
                        $details->save();
                        if ($sales->status == 2) {
                            $stock_details = new CurrentStockDetails();
                            $stock_details->product_id = $details->product_id;
                            $stock_details->type = "sale";
                            $stock_details->date = date('Y-m-d');
                            $stock_details->quantity = $details->quantity;
                            $stock_details->invoice = $sales->invoice_code;
                            if ($stock_details->save()) {
                                $stock = CurrentStock::findOrFail($stock_details->product_id);
                                $stock_old_quantity = $stock->quantity;
                                $stock->quantity = (int)$stock_old_quantity - $stock_details->quantity;
                                $stock->save();
                            }
                        }
                    }
                    if ($sales->status == 2) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Sale has been approved successfully',
                            'sales' => $sales
                        ], 200);
                    }
                    return response()->json([
                        'error' => true,
                        'message' => 'Sale has not been approved yet??'
                    ], 404);
                }
                return response()->json([
                    'error' => true,
                    'message' => 'Sales was not successfully updated'
                ], 404);
            }
            return response()->json([
                'error' => true,
                'message' => 'Select at least one product'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Sales Unsuccessful'
            ], 404);
        }
    }


    public function delete($id)
    {
        $delete_sale = Sale::findOrFail($id);
        if ($delete_sale->status == 2) {
            return response()->json([
                'error' => true,
                'message' => 'Can not delete a approved Sale',
            ],401);
        }
        $delete_sale_details = SaleDetails::where('sale_id', $delete_sale->id)->delete();
        $delete_sale->delete();
        return response()->json([
            'success' => true,
            'message' => 'Sale has been deleted successfully',
        ],200);
    }
}
