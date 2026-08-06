<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Religion;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ReligionResource;
use App\Http\Requests\Religion\ReligionStoreRequest;
use App\Http\Requests\Religion\ReligionUpdateRequest;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer|min:5|max:100',
        ]);

        $rowPerPage = $request->input('row_per_page');
        $search = $request->input('search');

        $religion = Religion::query()->when($search, function($query) use ($search) {
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data agama berhasil diambil', PaginateResource::make($religion, ReligionResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReligionStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $religion = Religion::create($data);

            return ResponseHelper::jsonResponse(true, 'Data agam berhasil ditambahkan.', new ReligionResource($religion), 201);
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
            $religion = Religion::find($id);

            if(!$religion){
                return ResponseHelper::jsonResponse(false, 'Data agama tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data agama berhasil diambil', new ReligionResource($religion), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReligionUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $religion = Religion::findOrFail($id);

            if(!$religion){
                return ResponseHelper::jsonResponse(false, 'Data agama tidak ditemukan.', null, 404);
            }

            $religion->update($data);

            return ResponseHelper::jsonResponse(true, 'Data agama berhasil diperbarui', new ReligionResource($religion), 200);
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
            $religion = Religion::findOrfail($id);

            $religion->delete();

            return ResponseHelper::jsonResponse(true, 'Data agama berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
