<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        return response()->json([
            'message' => 'Berhasil Membuat User',
            'user' => $user,
            'status' => 'success',
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
                'status' => 'error',
            ], 422);
        }

        //Mencocokan username dan pass apakah valid / tidak
        $credentials = request(['username', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 'error',
            ], 401);
        }

        $user = $request->user();
        
        //untuk membuat token / generate token
        $tokenResult = $user->createToken('Personal Access Token')->plainTextToken;
        
        return response()->json([
            'message' => 'Berhasil Login',
            'user' => $user,
            'access_token' => $tokenResult,
            'status' => 'success',
        ]);
    }

    //menghapus token 
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout',
            'status' => 'success',
            'user' => $request->user(),
        ]);
    }
}
