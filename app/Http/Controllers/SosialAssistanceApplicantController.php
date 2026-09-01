<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SosialAssistanceApplicant;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SosialAssistanceApplicantResource;
use App\Http\Requests\SosialAssistanceApplicant\SosialAssistanceApplicantStoreRequest;
use App\Http\Requests\SosialAssistanceApplicant\SosialAssistanceApplicantUpdateRequest;
use Illuminate\Support\Facades\Storage;
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
            $sosialAssistanceApplicant = SosialAssistanceApplicant::with([
                'citizen',
                'sosialAssistance'
                ])->find($id);

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

    public function approved(string $id)
    {
        try {
            $sosialAssistanceApplicant = SosialAssistanceApplicant::findOrFail($id);
            $sosialAssistanceApplicant->update([
                'status'  => 'approved',
            ]);

            return ResponseHelper::jsonResponse(true, 'Penerima bantuan berhasil disetujuin', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function rejected(Request $request, $id)
    {
        try {
            $sosialAssistanceApplicant = SosialAssistanceApplicant::findOrFail($id);

            $sosialAssistanceApplicant->update([
                'status' => 'rejected',
                'rejection_reason'  => 
                $request->rejection_reason,
                'payout_status' => 'failed'
            ]);

            return ResponseHelper::jsonResponse(true, 'Penerima bantuan berhasil di tolak', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function uploadTransferProof(Request $request, $id)
    {
        $request->validate([
            'transfer_proof'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ],[
            'transfer_proof.required'   => 'Bukit penyaluran harus diisi',
            'transfer_proof.image'      => 'Bukti penyaluran harus berupa gambar',
            'transfer_proof.mimes'      => 'Bukti penyaluran harus berupa jpg png jpeg webp',
            'transfer_proof.max'        => 'Bukti penyaluran maksiman 2MB',
        ]);

        try {
            $recipient = SosialAssistanceApplicant::findOrFail($id);

            // Hapus File lama jika
            if($recipient->transfer_proof){
                Storage::disk('public')->delete($recipient->transfer_proof);
            };

            // Upload file baru
            $filePath = $request->file('transfer_proof')
            ->store('transfer_proofs','public');

            $recipient->update(['transfer_proof' => $filePath]);

            return ResponseHelper::jsonResponse(true, 'Bukti penyaluran dana berhasil disalurkan', new SosialAssistanceApplicantResource($recipient), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

}
