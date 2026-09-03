<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\BumdesUnitResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\BumdesUnit\BumdesUnitStoreRequest;
use App\Http\Requests\BumdesUnit\BumdesUnitUpdateRequest;
use App\Models\BumdesUnit;

class BumdesUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'      => 'nullable|integer',
        ]);

        $rowPerPage = $request->input('row_per_page');
        $search = $request->input('search');

        $bumdesUnit = BumdesUnit::with([
            'bumdes',
        ])->when($search, function($query) use ($search){

        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data unit bumdes berhasil diambil', PaginateResource::make($bumdesUnit, BumdesUnitResource::class), 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BumdesUnitStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $bumdesUnit = BumdesUnit::create($data);

            return ResponseHelper::jsonResponse(true, 'Data unit bumdes berhasil ditambahkan', new BumdesUnitResource($bumdesUnit), 201);
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
            $bumdesUnit = BumdesUnit::find($id);

            if(!$bumdesUnit){
                return ResponseHelper::jsonResponse(false, 'Data bidang usaha bumdes tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data bidang usaha bumdes berhasil ditampilkan', new BumdesUnitResource($bumdesUnit), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesUnitUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $bumdesUnit = BumdesUnit::find($id);

            if(!$bumdesUnit){
                return ResponseHelper::jsonResponse(false, 'Data unit usaha bumdes tidak ditemukan', null, 404);
            }

            $bumdesUnit->update($data);

            return ResponseHelper::jsonResponse(true, 'Data unit usaha bumdes berhasil diperbarui', new BumdesUnitResource($bumdesUnit), 200);
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
            $bumdesUnit = BumdesUnit::find($id);

            if(!$bumdesUnit){
                return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 404);
            }

            $bumdesUnit->delete();

            return ResponseHelper::jsonResponse(true, 'Data unit usaha bumdes berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
