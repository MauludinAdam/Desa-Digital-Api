<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Letter;
use App\Models\LetterType;
use App\Http\Requests\Letter\LetterStoreRequest;
use App\Http\Requests\Letter\LetterUpdateRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\LetterResource;


class LetterController extends Controller
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

        $letter = Letter::with([
            'citizen',
            'letterType',
        ])->when($search, function ($query) use ($search) {
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data surat berhasil diambil', PaginateResource::make($letter, LetterResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LetterStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $exists = Letter::where('citizen_id', $data['citizen_id'])
            ->where('letter_type_id', $data['letter_type_id'])
            ->where('status', 'pending')
            ->exists();

            if($exists){
                return ResponseHelper::jsonResponse(false, 'Penduduk tersebut sudah memiliki surat dengan jenis yang sama.', null, 422);
            }

            $letterType = LetterType::findOrFail($data['letter_type_id']);

            $year = now()->year;

            $lastLetter = Letter::where('letter_type_id', $data['letter_type_id'])
            ->whereYear('created_at', $year)
            ->latest('created_at')
            ->first();

            $number = $lastLetter ? ((int) explode('/', $lastLetter->letter_number)[1]) + 1 : 1;

            $months = [
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                7 => 'VII',
                8 => 'VIII',
                9 => 'IX',
                10 => 'X',
                11 => 'XI',
                12 => 'XII',
            ];

            $month = $months[now()->month];
            
            $data['letter_number'] = sprintf(
                '%s/%03d/%s/%s',
                $letterType->code,
                $number,
                $month,
                $year
            );

            $letter = Letter::create($data);

            return ResponseHelper::jsonResponse(true, 'Data surat berhasi ditambahkan.', new LetterResource($letter), 201);
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
            $letter = Letter::with([
                'citizen',
                'letterType',
            ])->find($id);

            if(!$letter){
                return ResponseHelper::jsonResponse(false, 'Data surat tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data surat berhasil diambil', new LetterResource($letter), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LetterUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        try {
            $letter = Letter::findOrFail($id);

            $exists = Letter::where('citizen_id', $data['citizen_id'])
            ->where('letter_type_id', $data['letter_type_id'])
            ->where('status','pending')
            ->where('id', '!=', $id)
            ->exists();

            if($exists){
                return ResponseHelper::jsonResponse(false, 'Penduduk tersebut sudah memiliki pengajuan surat dengan jenis yang sama.', null, 422);
            }

            $letter->update($data);

            // dd($letter->fresh()->toArray())

            return ResponseHelper::jsonResponse(true, 'Data surat berhasil diperbarui', new LetterResource($letter), 200);
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
            $letter = Letter::find($id);

            if(!$letter){
                return ResponseHelper::jsonResponse(false, 'Data surat tidai ditemukan', null, 404);
            }

            $letter->delete();

            return ResponseHelper::jsonResponse(true, 'Data surat berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessaget(), null, 500);
        }
    }

    public function approved(string $id)
    {
       try {
         $letter = Letter::findOrFail($id);

        $letter->update([
            'status'    => 'approved',
            'approved_by'   => auth()->id(),
            'approved_at'   => now(),
        ]);

        return ResponseHelper::jsonResponse(true, 'Surat berhasil di setujuin', null, 200);
       } catch (\Throwable $e) {
        return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
       }
    }

    public function rejected(Request $request, $id)
    {
        try {
            $letter = Letter::findOrFail($id);

            $letter->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'approved_by'   => auth()->id(),
                'approved_at'   => now(),
            ]);

            return ResponseHelper::jsonResponse(true, 'Sura berhasil ditolak', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
