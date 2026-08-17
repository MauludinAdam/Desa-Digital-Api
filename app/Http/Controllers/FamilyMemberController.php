<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Requests\FamilyMember\FamilyMemberStoreRequest;
use App\Http\Requests\FamilyMember\FamilyMemberUpdateRequest;

class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'      => 'nullable|integer|min:5|max:100',
        ]);

        $perPage  = $request->input('row_per_page');
        $search  = $request->input('search');

        $familyMember = FamilyMember::with([
            'citizen',
            'familyCard',
        ])->orderBy('created_at','desc')->paginate($perPage);

        return ResponseHelper::jsonResponse(true, 'Data Anggota keluarga berhasil diambil', PaginateResource::make($familyMember, FamilyMemberResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyMemberStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $familyMember = FamilyMember::create($data);

            return ResponseHelper::jsonResponse(true, 'Data anggota keluarga berhasil ditambahkan!', new FamilyMemberResource($familyMember), 201);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $familyMember = FamilyMember::with(['familyCard','citizen'])->find($id);

            if(!$familyMember){
                return ResponseHelper::jsonResponse(false, 'Data anggota keluarga tidak ditemukan!', null, 404);
                }
                return ResponseHelper::jsonResponse(true, 'Data anggota keluarga berhasil diambil', new FamilyMemberResource($familyMember), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyMemberUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $familyMember = FamilyMember::find($id);

            $familyMember->update($data);

            return ResponseHelper::jsonResponse(true, 'Data anggota keluarga berhasil diperbarui', new FamilyMemberResource($familyMember), 200);
        } catch (\Throwable $e) {
            return responseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $familyMember = FamilyMember::find($id);

            if(!$familyMember){
                return ResponseHelper::jsonResponse(false, 'Data anggota keluarga tidak ditemukan!', null, 404);
            }

            $familyMember->delete();

            return ResponseHelper::jsonResponse(true, 'Data anggota keluarga berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
