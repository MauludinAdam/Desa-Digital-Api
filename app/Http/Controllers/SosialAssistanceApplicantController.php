<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SosialAssistanceApplicant;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SosialAssistanceApplicantResource;
use App\Http\Requests\SosialAssistanceApplicant\SosialAssistanceApplicantStoreRequest;
use App\Http\Requests\SosialAssistanceApplicant\SosialAssistanceApplicantUpdateRequest;
class SosialAssistanceApplicantController extends Controller
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

        $sosialAssistanceApplicant = SosialAssistanceApplicant::with([
            'sosialAssistance',
            'citizen',
        ])->when($search, function($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        if($sosialAssistanceApplicant->isEmpty()){
            return ResponseHelper::jsonResponse(false, 'Data penerima bantuan kosong.', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'Data penerima bantau berhasil diambil', PaginateResource::make($sosialAssistanceApplicant, SosialAssistanceApplicantResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosialAssistanceApplicantStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceApplicant = SosialAssistanceApplicant::create($data);

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan berhasil ditambahkan.', new SosialAssistanceApplicantResource($sosialAssistanceApplicant), 201);
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
            $sosialAssistanceApplicant = SosialAssistanceApplicant::find($id);

            if(!$sosialAssistanceApplicant){
                return ResponseHelper::jsonResponse(false, 'Data penerima bantuan tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan berhasil ditampilkan', new SosialAssistanceApplicantResource($sosialAssistanceApplicant), 202);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SosialAssistanceApplicantUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $sosialAssistanceApplicant = SosialAssistanceApplicant::find($id);

            $sosialAssistanceApplicant->update($data);

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan berhasil diperbarui', new SosialAssistanceApplicantResource($sosialAssistanceApplicant), 200);
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
            $sosialAssistanceApplicant = SosialAssistanceApplicant::find($id);

            $sosialAssistanceApplicant->delete();

            return ResponseHelper::jsonResponse(true, 'Data penerima bantuan berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
