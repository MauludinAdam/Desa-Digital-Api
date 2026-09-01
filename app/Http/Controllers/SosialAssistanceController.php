<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SosialAssistance;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SosialAssistanceResource;
use App\Http\Requests\SosialAssistance\SosialAssistanceStoreRequest;
use App\Http\Requests\SosialAssistance\SosialAssistanceUpdateRequest;
class SosialAssistanceController extends Controller
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

        $sosialAssistance = SosialAssistance::with([
            'category',
        ])->when($search, function($query) use ($search) {
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);


        return ResponseHelper::jsonResponse(true, 'Data sosial assisten berhasil diambil', PaginateResource::make($sosialAssistance, SosialAssistanceResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosialAssistanceStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $sosialAssistance = SosialAssistance::create($data);

            return ResponseHelper::jsonResponse(true, 'Data bantuan sosial berhasil ditambahkan', new SosialAssistanceResource($sosialAssistance), 201);
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
            $sosialAssistance = SosialAssistance::find($id);

            if(!$sosialAssistance){
                return ResponseHelper::jsonResponse(false, 'Data bantuan sosial tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data bantuan sosial berhasil diambil', new SosialAssistanceResource($sosialAssistance), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SosialAssistanceUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $sosialAssistance = SosialAssistance::findOrFail($id);

            if(!$sosialAssistance){
                return ResponseHelper::jsonResponse(false, 'Data bantuan sosial tidak ditemukan', null, 404);
            }

            $sosialAssistance->update($data);

            return ResponseHelper::jsonResponse(true, 'Data bantuan sosial berhasil diperbarui', new SosialAssistanceResource($sosialAssistance), 200);
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
            $sosialAssistance = SosialAssistance::find($id);

            $sosialAssistance->delete();

            return ResponseHelper::jsonResponse(true, 'Data bantuan sosial berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
