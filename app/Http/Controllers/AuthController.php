<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\LoginStoreRequest;

class AuthController extends Controller
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository) {
        $this->authRepository = $authRepository;
    }

    public function login(LoginStoreRequest $request)
    {
        $data = $request->validated();

        return $this->authRepository->login($data);
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }

    public function me()
    {
        return $this->authRepository->me();
    }
}
