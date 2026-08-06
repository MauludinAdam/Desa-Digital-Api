<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Helpers\ResponseHelper;

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

       return ResponseHelper::jsonResponse(
        true,
        'Login Berhasil',
        [
            'token' => $token,
            'data'  => new AuthResource($user),
            
        ], 200
       );
   }

   public function logout(Request $request)
   {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message'   => 'Logout berhasi',
        ]);
   }

   public function me()
   {
        return response()->json($request->user());
   }
}
