<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function index()
    {
        $data = User::where('user_type','employee')->where('id','!=',Auth::id())->get();
        return $this->respondWithSuccess('All Data Shown', $data);
    }

    public function create()
    {
        return response()->json(['message' => 'Inside Create Function'],200);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:8',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone',
            'gender' => 'required|numeric',
            'password' => 'required|min:8',
            'password_confirmation' => 'same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $data = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'phone' => $request->input('phone'),
                'gender' => $request->input('gender'),
                'password' => bcrypt($request->input('password')),
                'user_type' => $request->input('user_type'),
            ]);
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => $data
                ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }

    }

    public function show($id)
    {
            $data = User::findOrFail($id);
            return $this->respondWithSuccess('Individual Data', $data);
    }

    public function edit($id)
    {
        $data = User::findorfail($id);
        return $this->respondWithSuccess('Individual Data', $data);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:8',
            'email' => 'required|email|unique:users,email,' . $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:users,phone,' . $id,
            'user_type'=> 'required',
            'gender' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        if ($request->has('password')){
            return response()->json([
                'error' => true,
                'message' => 'User information updated unsuccessful.'
            ], 200);
        }
            $user = User::findorfail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->user_type = $request->user_type;
            $user->gender = $request->gender;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'User information updated successfully.'
            ], 200);
    }

    public function delete($id)
    {
        $users = User::findorfail($id);
        $users->delete();
        return response()->json(['message' => 'User Deleted Successfully'], 200);
    }
}
