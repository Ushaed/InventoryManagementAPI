<?php

namespace App\Http\Controllers\Api;

use App\CurrentStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrentStockController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'All the available current stock product details';
            $data['stock_products'] = CurrentStock::with('product')->get();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],404);
        }

    }

    public function check($product_id)
    {
        $data = CurrentStock::findOrFail($product_id);
        return response()->json($data,200);
    }
}
