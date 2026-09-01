<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LetterAttachment;
use App\Helpers\ResponseHelper;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\LetterAttachmentResource;
use App\Http\Requests\LetterAttachment\LetterAttachmentStoreRequest;
use App\Http\Requests\LetterAttachment\LetterAttachmentUpdateRequest;

class LetterAttachmentController extends Controller
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
        $search  = $request->input('search');

        $letterAttachment = LetterAttachment::with([
            'letter',
        ])->when($search, function($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data lampiran surat berhasil diambil', PaginateResource::make($letterAttachment, LetterAttachmentResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LetterAttachmentStoreRequest $request)
    {
        $data = $request->validated();

        try {

            $file = $request->file('file');

            $fileName = $file->getClientOriginalName();
            $data['file'] = $file->storeAs('letter-attachmans', $fileName, 'public');

            $letterAttachment = LetterAttachment::create($data);

            return ResponseHelper::jsonResponse(true, 'Data lampiran surat berhasil ditambahkan.', new LetterAttachmentResource($letterAttachment), 201);
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
            $letterAttachment = LetterAttachment::findOrFail($id);

            if(!$letterAttachment){
                return ResponseHelper::jsonResponse(false, 'Data lampiran surat tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data lampiran surat berhasil diambil', new LetterAttachmentResource($letterAttachment), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LetterAttachmentUpdateRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $letterAttachment = LetterAttachment::find($id);

            $letterAttachment->update($data);

            return ResponseHelper::jsonResponse(true, 'Data lampiran surat berhasil diperbarui', new LetterAttachmentResource($letterAttachment), 200);
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
            $letterAttachment = LetterAttachment::find($id);

            if(!$letterAttachment){
                return ResponseHelper::jsonResponse(false, 'Data lampiran surat tidak ditemukan', null, 404);
            }

            $letterAttachment->delete();

            return ResponseHelper::jsonResponse(true, 'Data lampiran penduduk berhasil dihapus.', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
