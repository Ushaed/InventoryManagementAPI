<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'All Suppliers List';
        $data['suppliers'] = Supplier::all();
        return response()->json($data,200);
    }

    public function create()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'All Suppliers List';
        return response()->json($data,200);
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:4',
            'address' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:4|unique:suppliers,phone',
            'email' => 'required|email|unique:suppliers,email',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $data = Supplier::create([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Supplier Added successfully',
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        $data = Supplier::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Supplier Details',
            'data' => $data
        ], 200);
    }

    public function edit($id)
    {
        $data = Supplier::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Supplier Details', 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:4',
            'address' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:suppliers,phone,'.$id,
            'email' => 'required|email|unique:suppliers,email,'.$id,
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $data = Supplier::findOrFail($id);
            $data ->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);
            return response()->json(['success' => true, 'message' => 'Supplier Updated successfully', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(Supplier $supplier)
    {
        //
    }

    public function emailexist($email)
    {
        $exist = Supplier::where('email',$email)->first();
        if($exist){
            return response()->json(false,200);
        }else{
            return response()->json(true,200);
        }
    }
    public function phoneexist($phone)
    {
        $exist = Supplier::where('phone',$phone)->first();
        if($exist){
            return response()->json(false,200);
        }else{
            return response()->json(true,200);
        }
    }
}
