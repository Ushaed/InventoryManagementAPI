<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;


class CategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = "These are all Category";
        $data['data'] = Category::all();
//        dd($data);
        return response()->json($data, 200);
    }

    public function create()
    {
        $data = [];
        $data['success'] = true;
        $data['message'] = 'Category Create Function';
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:4|unique:categories,name',
            'status' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $data = Category::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'status' => $request->input('status'),
                'description' => $request->input('description'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json(['success' => true, 'message' => 'Category created successfully', 'data' => $data], 200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        return new CategoryResource(Category::findOrFail($id));
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return response()->json(['success' => true, 'message' => 'Single Category', 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:8|unique:categories,name,' . $id,
            'status' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        $data = Category::find($id);
        $data->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'status' => $request->input('status'),
            'description' => $request->input('description'),
        ]);
        return response()->json(['success' => true, 'message' => 'Category Updated Successfully', 'data' => $data], 200);
    }

    public function delete($id)
    {
        $data = [];
        $data['category'] = Category::with('products')->findOrFail($id);
        if ($data['category']['products']->count() > 0) {
            return response()->json(['success' => true, 'message' => 'Delete all these ' . $data['category']['products']->count() . ' products'], 200);
        }
        $data['category']->delete();
        return response()->json(['success' => true, 'message' => 'Category Deleted Successfully'], 200);

    }

}
