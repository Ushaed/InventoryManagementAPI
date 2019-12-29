<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Purchase;
use App\Sale;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public $successStatus = 200;
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $token = $user->createToken('access-token')->accessToken;
            $data['success'] = true;
            $data['message'] = 'Login Successful';
            $data['user'] = $user;
            $data['access-token'] = $token;
            return response()->json($data, 200);
        } else {
            return response()->json(['error' => true, 'message' => 'These credentials do not match our records.'], 401);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::user();
            $data['success'] = true;
            $data['message'] = 'User Profile data';
            $data['user'] = $user;
            return response()->json($data, 200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage()
            ],401);
        }

    }

    public function updateSetting(Request $request)
    {
        $id = Auth::id();
        $rules = [
            'name' => 'required|min:8',
            'email' => 'required|email|unique:users,email,' . $id,
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|min:8|numeric',
            'gender' => 'required|numeric',
            'password'=>'min:8',
            'password_confirmation' => 'same:password',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()], 422);
        }
        try {
            $user = User::findorfail(Auth::id());
            $newPassword = $request->get('password');

            if (empty($newPassword)) {
                $user->update($request->except('password'));
            } else {
                $user->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'phone' => $request->input('phone'),
                    'gender' => $request->input('gender'),
                    'password' => bcrypt($request->input('password')),
                ]);
            }
            return response()->json(['message' => 'Personal information updated successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function logout()
    {
        try {
            $accessToken = Auth::user()->token();
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out',
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'error' => true,
                'message' => 'Unknown Error',
            ], 401);
        }
    }

    public function dashboard()
    {
        try {
            $data = [];
            $data['success'] = true;
            $data['message'] = 'Inside Dashboard Function';
            $data['users'] = User::all()->count();
            $data['products'] = Product::all()->count();
            $data['purchases'] = Purchase::all()->count();
            $data['sales'] = Sale::all()->count();
            return response()->json($data,200);
        }catch (\Exception $exception){
            return response()->json([
                'error'=>true,
                'message'=>$exception->getMessage(),
            ],401);
        }

    }
}

