<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CitizenDocument;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\CitizenDocumentResource;
use App\Http\Requests\CitizenDocument\CitizenDocumentStoreRequest;
use App\Http\Requests\CitizenDocument\CitizenDocumentUpdateRequest;
use App\Helpers\ResponseHelper;

class CitizenDocumentController extends Controller
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

        // query berdiri sendiri tanpa relasi
        // $citizenDocument = CitizenDocument::query()->when($search, function($query) use ($search){
        //     $query->search($search);
        // })->orderBy('created_at','desc')->paginate($rowPerPage);

        // query dengan relasi
        $citizenDocument = CitizenDocument::with([
            'citizen',
        ])->when($search, function ($query) use ($search) {
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data dokumen penduduk berhasil diambil', PaginateResource::make($citizenDocument, CitizenDocumentResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CitizenDocumentStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $citizenDocument = CitizenDocument::create($data);

            return ResponseHelper::jsonResponse(true, 'Dokumen penduduk berhasil ditambahkan.', new CitizenDocumentResource($citizenDocument), 201);
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
            $citizenDocument = CitizenDocument::with([
                'citizen'
            ])->find($id);

            if(!$citizenDocument){
                return ResponseHelper::jsonResponse(false, 'Data dokumen penduduk tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data dokumen penduduk berhasil diambil.', new CitizenDocumentResource($citizenDocument), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CitizenDocumentUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $citizenDocument = CitizenDocument::findOrFail($id);

            $citizenDocument->update($data);

            return Responsehelper::jsonResponse(true, 'Data dokumen penduduk berhasil diupdate!', new CitizenDocumentResource($citizenDocument), 200);
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
            $citizenDocument = CitizenDocument::find($id);

            if(!$citizenDocument){
                return ResponseHelper::jsonResponse(false, 'Data dokumen penduduk tidak ditemukan.', null, 404);
            }

            $citizenDocument->delete();

            return ResponseHelper::jsonResponse(true, 'Data penduduk dokumen berhasil dihapus', null, 200);
         } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
         }
    }
}
