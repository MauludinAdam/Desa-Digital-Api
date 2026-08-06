<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Occupation;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\OccupationResource;
use App\Http\Requests\Occupation\OccupationStoreRequest;
use App\Http\Requests\Occupation\OccupationUpdateRequest;
use App\Helpers\ResponseHelper;

class OccupationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'      => 'nullable|integer|min:5|max:100',
        ]);

        $rowPerPage = $request->input('row_per_page');
        $search = $request->input('search');

        $occupation = Occupation::query()->when($search, function ($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data pekerjaan berhasil diambil', PaginateResource::make($occupation, OccupationResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OccupationStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $occupation = Occupation::create($data);

            return ResponseHelper::jsonResponse(true, 'Data Pekerjaan berhasil ditambahkan.', new OccupationResource($occupation), 201);
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
            $occupation = Occupation::find($id);

            if(!$occupation){
                return ResponseHelper::jsonResponse(false, 'Data pekerjaan tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data pekerjaan berhasil diambil', new OccupationResource($occupation), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OccupationUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $occupation = Occupation::findOrFail($id);

            $occupation->update($data);

            return ResponseHelper::jsonResponse(true, 'Data pekerjaan berhasil diperbarui', new OccupationResource($occupation), 200);
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
            $occupation = Occupation::find($id);

            $occupation->delete();

            return ResponseHelper::jsonResponse(true, 'Data pekerjaan berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
