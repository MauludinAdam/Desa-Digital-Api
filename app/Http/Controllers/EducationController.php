<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;
use App\Helpers\ResponseHelper;
use App\Http\Resources\EducationResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\Education\EducationStoreRequest;
use App\Http\Requests\Education\EducationUpdateRequest;

class EducationController extends Controller
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

        $education = Education::query()->when($search, function($query) use ($search) {
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data pendidikan berhasil diambil', PaginateResource::make($education, EducationResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EducationStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $education = Education::create($data);

            return ResponseHelper::jsonResponse(true, 'Data pendidikan berhasil ditambahkan', new EducationResource($education), 201);
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
            $education = Education::find($id);

            if(!$education){
                return ResponseHelper::jsonResponse(false, 'Data pendidikan tidak ditemukan.', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data pendidikan berhasil diambil', new EducationResource($education), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EducationUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $education = Education::findOrFail($id);

            $education->update($data);

            return ResponseHelper::jsonResponse(true, 'Data pendidikan berhasil diperbarui', new EducationResource($education), 200);
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
            $education = Education::findOrFail($id);

            $education->delete();

            return ResponseHelper::jsonResponse(true, 'Data pendidikan berhasil dihapus.', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
