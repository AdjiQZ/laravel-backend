<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Use 3 dibawah ini digunakan apabila mengalami eror
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\facades\JWTAuth;

class Authcontroller extends Controller
{
    // Untuk register
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'jenis_kelamin' => 'required',
            'password' => 'required',
            'alamat' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->erors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
        ]);

        if($user){
            return response()->json([
                'status' => true,
                'message' => 'User berhasil registrasi',
                'user' => $user
            ], 201);
        }

        return response()->json([
            'status' => false
        ], 409);
    }
    // Untuk Login
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('username', 'password');

        if(!$token = auth()->guard('api')->attempt($credentials)){
            return response()->json([
                'succes' => false,
                'message' => 'username atau password anda salah'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token
        ], 200);
    }
    public function logout(){
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken){
            return response()->json([
                'status' => true,
                'message' => 'user berhasil logout'
            ], 200);
        }
    }
}
