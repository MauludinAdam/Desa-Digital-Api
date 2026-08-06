<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\SosialAssistanceCategory;
use App\Http\Resources\SosialAssistanceCategoryResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\SosialAssistanceCategory\SosialAssistanceCategoryStoreRequest;
use App\Http\Requests\SosialAssistanceCategory\SosialAssistanceCategoryUpdateRequest;

class SosialAssistanceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer|min:5|max:100'
        ]);

        $rowPerPage = $request->input('row_per_page');
        $search = $request->input('search');

        $sosialAssistanceCategory = SosialAssistanceCategory::query($search, function($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        if($sosialAssistanceCategory->isEmpty()){
            return ResponseHelper::jsonResponse(false, 'Data kategori bantuan tidak ditemukan.', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'Data kategori berhasil diambil', PaginateResource::make($sosialAssistanceCategory, SosialAssistanceCategoryResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosialAssistanceCategoryStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceCategory = SosialAssistanceCategory::create($data);

            return ResponseHelper::jsonResponse(true, 'Data kategori bantuan berhasil ditambahkan.', new SosialAssistanceCategoryResource($sosialAssistanceCategory), 201);
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
            $sosialAssistanceCategory = SosialAssistanceCategory::find($id);

            if(!$sosialAssistanceCategory){
                return ResponseHelper::jsonResponse(false, 'Data kategori bantuan tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data kategori bantuan berhasil diambil', new SosialAssistanceCategoryResource($sosialAssistanceCategory), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SosialAssistanceCategoryUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceCategory = SosialAssistanceCategory::findOrFail($id);

            
            $sosialAssistanceCategory->update($data);

            return ResponseHelper::jsonResponse(true, 'Data kategori bantuan berhasil diperbarui', new SosialAssistanceCategoryResource($sosialAssistanceCategory), 200);
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
            $sosialAssistanceCategory = SosialAssistanceCategory::find($id);

            $sosialAssistanceCategory->delete();

            return ResponseHelper::jsonResponse(true, 'Data kategori bantuan berhasil dihapus.', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
