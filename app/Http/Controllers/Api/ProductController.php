<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Category;
use App\CurrentStock;
use App\Http\Controllers\Controller;
use App\OpeningStock;
use App\OpeningStockDetails;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'All products are given in here';
            $data['products'] = Product::with('category', 'brand')->select()->orderBy('id', 'desc')->get();
            $data['deleted_products'] = Product::with('category', 'brand')->onlyTrashed()->get();
            return response()->json($data, 200);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

    }

    public function create()
    {
        $data = [];
        $data['category'] = Category::select('id', 'name')->where('status', 1)->get();
        $data['brand'] = Brand::select('id', 'name')->where('status', 1)->get();
        return response()->json(['success' => true, 'message' => 'All Category', 'data' => $data], 200);
    }

    public function store(Request $request)
    {

//        return response()->json($opening_stock_details);
        $rules = [
            'name' => 'required|min:4|unique:products,name',
            'category_id' => 'required',
            'brand_id' => 'required',
            'buy_price' => 'required|numeric|min:1',
            'sell_price' => 'required|numeric|min:1',
            'status' => 'required',
        ];
        $message = [
            'brand_id.required' => 'Brand field is required',
            'category_id.required' => 'Category field is required',
            'buy_price.required' => 'Buying price field is required',
            'sell_price.required' => 'Selling price field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->status = $request->status;
            $product->buy_price = $request->buy_price;
            $product->sell_price = $request->sell_price;
            $product->description = $request->description;
            if ($product->save()){
                $current_stock = new CurrentStock();
                $current_stock->product_id = $product->id;
                $current_stock->quantity = 0;
                $current_stock->save();
                $opening_stock = OpeningStockDetails::first();
                if(empty($opening_stock) || $opening_stock->status == 0){
                    $opening_stock_details = new OpeningStockDetails();
                    $opening_stock_details->product_id = $product->id;
                    $opening_stock_details->quantity = 0;
                    $opening_stock_details->save();
                }
                return response()->json(['success' => true, 'message' => 'Product created successfully', 'data' => $product], 200);
            }
            return response()->json(['success' => true, 'message' => 'Unsuccessful Attempt From Product', 'data' => $product], 404);

        }catch (\Exception $e){
            return response()->json(['success' => true, 'message' => $e->getMessage()], 404);

        }
    }

    public function show($id)
    {
        $data = Product::with('category', 'brand')->select()->findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Product Shown', 'data' => $data], 200);

    }

    public function edit($id)
    {
        $data = [];
        $data['product'] = Product::with('category', 'brand')->select()->findOrFail($id);
        $data['categories'] = Category::select('id', 'name')->where('status', 1)->get();
        $data['brands'] = Brand::select('id', 'name')->where('status', 1)->get();
        return response()->json(['success' => true, 'message' => 'Product Shown', 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:4|unique:products,name,' . $id,
            'category_id' => 'required',
            'brand_id' => 'required',
            'status' => 'required',
            'buy_price' => 'required|numeric|min:1',
            'sell_price' => 'required|numeric|min:1',
        ];
        $message = [
            'brand_id.required' => 'Brand field is required',
            'category_id.required' => 'Category field is required',
            'buy_price.required' => 'Buying price field is required',
            'sell_price.required' => 'Selling price field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);

        }
        $data = Product::with('category', 'brand')->select()->findOrFail($id);
        $data->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'category_id' => $request->input('category_id'),
            'brand_id' => $request->input('brand_id'),
            'status' => $request->input('status'),
            'buy_price' => $request->input('buy_price'),
            'sell_price' => $request->input('sell_price'),
            'description' => $request->input('description'),
        ]);
        return response()->json(['success' => true, 'message' => 'Product updated successfully', 'data' => $data], 200);

    }

    public function delete($id)
    {
        $data = Product::findOrFail($id);
        if ($data->status == 1) {
            $data->update([
                'status' => 2,
            ]);
        }
        $data->delete();
        return response()->json(['success' => true, 'message' => 'Product deleted successfully'], 200);

    }

    public function restore($id)
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'Product is restored successfully';
        $data['restored_products'] = Product::withTrashed()->find($id)->restore();
        return response()->json($data, 200);
    }

    public function search($query)
    {
        $product = Product::with('stock')->where('name', 'LIKE', "%".$query."%")->where('status',1)
            ->get();
//        if ($product->stock['quantity'] >= 1){
//            return response()->json($product,200);
//        }

//        return response()->json([
//            'error'=> true,
//            'message'=>'Out of Stock'
//        ],404);
        return response()->json($product,200);

    }
}
