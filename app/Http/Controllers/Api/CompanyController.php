<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = "Company details information";
            $data['company'] = Company::first();
            return response()->json($data,200);
        }catch (\Exception $e){
            return response()->json('data',200);
        }

    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|min:4',
            'phone' => 'required|numeric',
            'address' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $company = Company::first();
            $company->name = $request->name;
            $company->phone = $request->phone;
            $company->address = $request->address;
            $company->message = $request->message;
            $company->save();
            return response()->json(['success' => true, 'message' => "Company information updated successfully"], 200);
        }catch (\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 404);
        }

    }

}
