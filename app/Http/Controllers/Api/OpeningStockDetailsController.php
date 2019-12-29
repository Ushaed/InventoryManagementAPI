<?php

namespace App\Http\Controllers\Api;

use App\CurrentStock;
use App\Http\Controllers\Controller;
use App\OpeningStockDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class OpeningStockDetailsController extends Controller
{
    public function index()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'All the opening stock products details';
        $data['openingStockDetails'] = OpeningStockDetails::with(['product'])->get();
        return response()->json($data,200);
    }
    public function store(Request $request)
    {
        $rules = [
            'product_id'=>'required',
            'quantity'=>'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->getMessageBag()->all()], 400);
        }
        try {
            foreach ($request->product_id as $key => $value) {
                $opening_stock_details = OpeningStockDetails::findOrFail($request->product_id[$key]);
                $opening_stock_details->quantity = $request->quantity[$key];
                $opening_stock_details->status = 1;
                if ($opening_stock_details->save()){
                        $current_stock = CurrentStock::findOrFail($request->product_id[$key]);
                        $current_stock->quantity = $request->quantity[$key];
                        $current_stock->save();
                }
            }
            return response()->json(['message' => 'Product added to opening stock Successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}
