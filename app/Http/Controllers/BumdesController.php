<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BumdesResource;
use App\Helpers\ResponseHelper;
use App\Models\Bumdes;
use App\Http\Requests\Bumdes\BumdesStoreRequest;
use App\Http\Requests\Bumdes\BumdesUpdateRequest;
use Illuminate\Support\Facades\Storage;

class BumdesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BumdesStoreRequest $request)
    {
        $data = $request->validated();

        try {

            if($request->hasFile('logo')){

            $file = $request->file('logo');

            $fileName = $file->getClientOriginalName();

            $data['logo'] = $file->storeAs('bumdes', $fileName, 'public');
            }

            $bumdes = Bumdes::create($data);

            return ResponseHelper::jsonResponse(true, 'Data profile bumdes berhasil ditambahkan', new BumdesResource($bumdes), 201);
        } catch (\Throwable $e) {
            
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $profileBumdes = Bumdes::firstOrFail();

        return ResponseHelper::jsonResponse(true, 'Profile bumdes berhasil ditampilkan', new BumdesResource($profileBumdes), 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesUpdateRequest $request)
    {
        
        try {
            $data = $request->validated();
            
            $bumdes = Bumdes::first();

            if(!$bumdes){
                return ResponseHelper::jsonResponse(false, 'Data belum tersedia', null, 404);
            }

            if($request->hasFile('logo')){
                
            // Hapus Logo Lama
            if($bumdes->logo && Storage::disk('public')->exists($bumdes->logo)){
                Storage::disk('public')->delete($bumdes->logo);
            }

            // Simpan Logo Baru
            $file = $request->file('logo');
            $fileName = $file->getClientOriginalName();

            $data['logo'] = $file->storeAs('bumdes', $fileName, 'public');

            }else{
                unset($data['logo']);
            }


            $bumdes->update($data);

            return ResponseHelper::jsonResponse(true, 'Profile bumdes berhasil diperbarui', new BumdesResource($bumdes), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $profileBumdes = Bumdes::find($id);

            if(!$profileBumdes){
                return ResponseHelper::jsonResponse(false, 'Data bumdes tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data bumdes berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
