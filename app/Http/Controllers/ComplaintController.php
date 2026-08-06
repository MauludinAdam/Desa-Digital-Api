<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ComplaintResource;
use App\Http\Requests\Complaint\ComplaintStoreRequest;
use App\Http\Requests\Complaint\ComplaintUpdateRequest;

class ComplaintController extends Controller
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

        $complaint = Complaint::with([
            'citizen',
            'respondedBy'
        ])->when($search, function($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        if($complaint->isEmpty()){
            return ResponseHelper::jsonResponse(false, 'Data pengaduan belum ada.', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'Data pengaduan berhasil diambil', PaginateResource::make($complaint, ComplaintResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ComplaintStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $complaint = Complaint::create($data);

            return ResponseHelper::jsonResponse(true, 'Data pengaduan berhasil ditambahkan.', new ComplaintResource($complaint), 201);
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
            $complaint = Complaint::find($id);

            if(!$complaint){
                return ResponseHelper::jsonResponse(false, 'Data pengaduan tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data pengaduan berhasil ditampilkan', new ComplaintResource($complaint), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false. $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ComplaintUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $complaint = Complaint::find($id);

            $complaint->update($data);

            return ResponseHelper::jsonResponse(true, 'Data pengaduan berhasil diperbarui', new ComplaintResource($complaint), 200);
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
            $complaint = Complaint::find($id);

            $complaint->delete();

            return ResponseHelper::jsonResponse(true, 'Data pengaduan berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
