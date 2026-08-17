<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\FamilyCard;
use App\Http\Requests\FamilyCard\FamilyCardStoreRequest;
use App\Http\Requests\FamilyCard\FamilyCardUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\FamilyCardResource;

class FamilyCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'      => 'nullable|integer|min:5|max:100',
        ]);

        $rowPerPage = $request->input('row_per_page', 10);

        $search = $request->input('search');

        // query berdirir sendiri tanpa relasi
        // $familyCara = FamilyCard::query()->when($search, function($query) use ($search){ $query->search($search)
        // });

        // query dengan relasi
        $familyCard = FamilyCard::with([
            'headOfFamily',
            'familyMembers.citizen'
        ])->when($search, function ($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data kartu keluarga berhasil diambil', PaginateResource::make($familyCard, FamilyCardResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyCardStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $familyCard = FamilyCard::create($data);

            return ResponseHelper::jsonResponse(true, 'Data nomor kartu keluarga berhasil ditambahkan', new FamilyCardResource($familyCard), 201);
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
            $familyCard = FamilyCard::with([
                'headOfFamily',
                'familyMembers.citizen'
                ])->findOrFail($id);

            if(!$familyCard){
                return ResponseHelper::jsonResponse(false, 'Data nomor kartu keluarga tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data nomor kartu keluarga berhasil diambil',  new FamilyCardResource($familyCard), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FamilyCardUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $familyCard = FamilyCard::findOrFail($id);

            $familyCard->update($data);

            return ResponseHelper::jsonResponse(true, 'Data nomor kartu keluarga berhasil diupdate', new FamilyCardResource($familyCard), 200);
        } catch (\ModelNotFoundException $e) {
            return ResponseHelper::jsonResponse(false, 'Data nomor kartu keluarga tidak ditemukan', null, 404);
        } catch (\Throwable $e){
            return Responsehelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $familyCard = FamilyCard::find($id);

            if(!$familyCard){
                return ResponseHelper::jsonResponse(false, 'Data nomor kartu keluarga tidak ditemukan', null, 404);
            }

            $familyCard->delete();


            return ResponseHelper::jsonResponse(true, 'Data nomor kartu kerluarga berhasil dihapus.', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
