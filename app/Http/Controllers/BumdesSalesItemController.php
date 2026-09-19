<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\BumdesSalesItemResource;
use App\Http\Resources\PaginateResource;
use App\Models\BumdesSalesItem;
use App\Http\Requests\BumdesSalesItem\BumdesSalesItemStoreRequest;
use App\Http\Requests\BumdesSalesItem\BumdesSalesItemUpdateRequest;

class BumdesSalesItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer',
        ]);

        $rowPerPage = $request->input('row_per_page');

        $search = $request->input('search');

        $bumdesSalesItem = BumdesSalesItem::with([
            'bumdesSales',
            'bumdesProduct',
        ])->when($search, function($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data item penjualan berhasil diambil', PaginateResource::make($bumdesSalesItem, BumdesSalesItemResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BumdesSalesItemStoreRequest $request)
    {
        try {
            $data = $request->validated();

            
            $bumdesSalesItem = BumdesSalesItem::create($data);

            return ResponseHelper::jsonResponse(true, 'Data item penjualan berhasil ditambahkan', new BumdesSalesItemResource($bumdesSalesItem), 200);
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
            $bumdesSalesItem = BumdesSalesItem::find($id);

            if(!$bumdesSalesItem){
                return ResponseHelper::jsonResponse(false, 'Data item penjualan tidak ditemuka', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data item penjualan berhasil diambil', new BumdesSalesItemResource($bumdesSalesItem), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesSalesItemUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $bumdesSalesItem = BumdesSalesItem::find($id);

            if(!$bumdesSalesItem){
                return ResponseHelper::jsonResponse(false, 'Data item penjualan tidak ditemukan!', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data item penjualan berhasil diperebarui', new BumdesSalesItemResource($bumdesSalesItem), 200);
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
            $bumdesSalesItem =  BumdesSalesItem::find($id);

            if(!$bumdesSalesItem){
                return ResponseHelper::jsonResponse(false, 'Data item penjualan tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data item penjualan berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
