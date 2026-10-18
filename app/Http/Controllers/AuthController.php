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
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
   public function login(LoginRequest $request)
   {
        $email = Str::lower($request->email);
        $key = 'login:' . $email . '|' . $request->ip();

        // Cek Apakah sudah terlalu banyak percobaan
        if(RateLimiter::tooManyAttempts($key, 3)){
            $seconds = RateLimiter::availableIn($key);

            return ResponseHelper::jsonResponse(false, "Maaf, kesalahan saat login maksimal 3 kali. Silahkan coba lagi dalam {$seconds} detik.", null, 429);
        };


        if(!Auth::attempt($request->only('email','password'))){

            RateLimiter::hit($key, 60);

            return response()->json([
                'message' => 'Email atau password salah',
            ], 400);
        }

        $user = Auth::user();

        RateLimiter::clear($key);

        if($user->status !== 'Active'){
            return ResponseHelper::jsonResponse(false, 'Akun anda sedang tidak aktif', null, 403);
        }

        // Load relasi role dan roles untuk userResource
        $user->load('role', 'roles');

        $token = $user->createToken('auth_token')->plainTextToken;

       return ResponseHelper::jsonResponse(
        true,
        'Login Berhasil',
        [
            'token' => $token,
            'data'  => new UserResource($user),
            
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
