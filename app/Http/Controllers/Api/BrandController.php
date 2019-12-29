<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $data = Brand::with('products')->select()->get();
        return response()->json(['success' => true, 'message' => 'These are all Brands', 'data' => $data], 200);
    }

    public function create()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'These are all Brands';
        return response()->json($data, 200);

    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3|unique:brands,name',
            'status' =>'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $data = Brand::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json(['success' => true, 'message' => 'Brand created successfully', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }


    public function show($id)
    {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Brand Details given';
            $data['brand'] = Brand::with('products')->findOrFail($id);
            return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3|unique:brands,name,' . $id,
            'status' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        $data = Brand::find($id);
        $data->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'status' => $request->input('status'),
            'description'=> $request->input('description'),
        ]);
        return response()->json(['success' => true, 'message' => 'Brand Updated Successfully', 'data' => $data], 200);
    }

    public function delete($id)
    {
        $data = [];
        $data['brand'] = Brand::with('products')->findOrFail($id);
        if($data['brand']['products']->count()>0){
            return response()->json([
                'success' => true,
                'message' => 'Delete all these '.$data['brand']['products']->count().' products'
            ],200);
        }
        $data['brand']->delete();
        return response()->json([
            'success' => true,
            'message' => 'Brand Deleted Successfully'
        ],200);
    }
}
