<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
   public function login(LoginRequest $request)
   {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message' => 'Email atau password salah',
            ], 400);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token'     => $token,
            'data'      => $user,
        ]);
   }

   public function logout(Request $request)
   {
        $request->user()->currentAccessToke()->delete();

        return response()->json([
            'message'   => 'Logout berhasi',
        ]);
   }

   public function me()
   {
        return response()->json($request->user());
   }
}
