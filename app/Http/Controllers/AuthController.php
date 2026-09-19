<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Helpers\ResponseHelper;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\users\UserUpdateRequest;
use App\Http\Requests\users\ForgotPasswordRequest;
use App\Http\Requests\users\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;

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

        if($user->status !== 'Active'){
            return ResponseHelper::jsonResponse(false, 'Akun anda sedang tidak aktif', null, 403);
        }

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

   public function me(Request $request)
   {
        // $user = $request->user();

        $user = $request->user()->load('roles');

        return ResponseHelper::jsonResponse(true, 'Data profile user berhasil diambil', new UserResource($user), 200);
   }

   public function update(UserUpdateRequest $request)
   {
        try {
            $data = $request->validated();


            $user = $request->user()->load('role');

            if(empty($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = Hash::make($data['password']);
            }

            unset(
                $data['current_password'],
                $data['password_confirmation']
            );
                
            $user->update($data);

            return ResponseHelper::jsonResponse(true, 'Data profile user berhasil diperbarui', new UserResource($user), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
   }

   public function forgotPassword(ForgotPasswordRequest $request)
   {
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if($status !== Password::RESET_LINK_SENT){
                return ResponseHelper::jsonResponse(false, _($status), null, 422);
            }

            return ResponseHelper::jsonResponse(true, 'Link reset password berhasil dikirim ke email.', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
   }

   public function resetPassword(ResetPasswordRequest $request)
   {
        try {
            $status = Password::reset(
                $request->only('email','password','password_confirmation','token'),

                function ($user, $password){
                    $user->forceFill(['password' => Hash::make($password),])->save();
                }
            );

            if($status !== Password::PASSWORD_RESET){
                return ResponseHelper::jsonResponse(false, _($status), null, 422);
            }

            return ResponseHelper::jsonResponse(true, 'Password berhasil direset.', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
   }
}
