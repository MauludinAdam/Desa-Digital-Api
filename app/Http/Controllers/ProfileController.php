<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProfileRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Resources\ProfileResource;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    private ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository) {
        $this->profileRepository = $profileRepository;
    }

    public function index()
    {
        try {
            $profile = $this->profileRepository->get();

            if(!$profile){
                return ResponseHelper::jsonResponse(false, 'Data Profile Tidak Ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Profile Berhasil Diambil', new ProfileResource($profile), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function store(ProfileStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $profile    = $this->profileRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Data Profile Berhasil Ditambahkan', new ProfileResource($profile), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();

        try {
            $profile = $this->profileRepository->update($data);

            return ResponseHelper::jsonResponse(true, 'Data Profile Berhasil Diupdate', new ProfileResource($profile), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
