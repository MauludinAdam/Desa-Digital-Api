<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileVillage;
use App\Helpers\ResponseHelper;
use App\Http\Resources\ProfileVillageResource;
use App\Http\Requests\ProfileVillageUpdateRequest;
use Illuminate\Support\Facades\Storage;

class ProfileVillageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profileVillage = ProfileVillage::first();

        return ResponseHelper::jsonResponse(true, 'Data profile desa berhasil diambil', new ProfileVillageResource($profileVillage), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $profileVillage = ProfileVillage::firstOrFail();


        return ResponseHelper::jsonResponse(true, 'Profile desa berhasil ditampilkan', new ProfileVillageResource($profileVillage), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileVillageUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            
            $profileVillage = ProfileVillage::firstOrFail();

            if($request->hasFile('thumbnail')){
                
            // Hapus Gambar Lama
            if($profileVillage->thumbnail && Storage::disk('public')->exists($profileVillage->thumbnail)){
                Storage::disk('public')->delete($profileVillage->thumbnail);
            }

            // Simpan Gambar Baru
            $file = $request->file('thumbnail');
            $fileName = $file->getClientOriginalName();

            $data['thumbnail'] = $file->storeAs('profile-village', $fileName, 'public');
            }else{
                unset($data['thumbnail']);
            }
           


            $profileVillage->update($data);

            return ResponseHelper::jsonResponse(true, 'Profile desa berhasil diperbarui', new ProfileVillageResource($profileVillage), 200);
            } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
