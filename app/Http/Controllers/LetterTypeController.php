<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterType;
use App\Http\Requests\LetterType\LetterTypeStoreRequest;
use App\Http\Requests\LetterType\LetterTypeUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\LetterTypeResource;
use App\Helpers\ResponseHelper;


class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer|min:5|max:100',
        ]);

        $rowPerPage = $request->input('row_per_page', 10);
        $search     = $request->input('search');

        $letterType = LetterType::query()->when($search, function($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data jensi surat berhasil diambil', PaginateResource::make($letterType, LetterTypeResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LetterTypeStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $letterType = LetterType::create($data);

            return ResponseHelper::jsonResponse(true, 'Data jenis surat berhasil ditambahkan.', new LetterTypeResource($letterType), 201);
        } catch (\Throwable $e) {
            return ResopnseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $letterType = LetterType::find($id);

            if(!$letterType){
                return ResponseHelper::jsonResponse(false, 'Data jenis surat tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data jensi surat berhasil diambil', new LetterTypeResource($letterType), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LetterTypeUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $letterType = LetterType::findOrFail($id);

            $letterType->update($data);

            return ResponseHelper::jsonResponse(true, 'Data jenis surat berhasil diperbarui', new LetterTypeResource($letterType), 200);
        } catch (\Throwable $te) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $letterType = LetterType::find($id);

            if(!$letterType){
                return ResponseHelper::jsonResponse(false, 'Data jenis surat tidak ditemukan', null, 404);
            }

            $letterType->delete();

            return ResponseHelper::jsonResponse(true, 'Data jenis surat berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
