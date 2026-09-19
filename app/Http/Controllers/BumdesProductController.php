<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BumdesProduct;
use App\Http\Requests\BumdesProduct\BumdesProductStoreRequest;
use App\Http\Requests\BumdesProduct\BumdesProductUpdateRequest;
use App\Helpers\ResponseHelper;
use App\Http\Resources\BumdesProductResource;
use App\Http\Resources\PaginateResource;

class BumdesProductController extends Controller
{
    private function generateBarcodeNumber()
    {
        $date = now()->format('Ymd');

        $lastProduct = BumdesProduct::whereDate('created_at', now()->toDateString())
        ->whereNotNull('barcode')
        ->orderBy('created_at', 'desc')
        ->first();

        if($lastProduct){
            $lastNumber = (int) substr($lastProduct->barcode, -4);
            $number = $lastNumber + 1;
        }else{
            $number = 1;
        }

        return $date . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function generateBarcode()
    {
        $barcode = $this->generateBarcodeNumber();

        return ResponseHelper::jsonResponse(true,'Barcode berhasil ditampilkan', ['barcode' => $barcode], 200);
    }

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

        $bumdesProduct = BumdesProduct::with([
            'bumdesUnit',
        ])->when($search, function ($query) use ($search){
            $query->search($search);
        })->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data product berhasil diambil', PaginateResource::make($bumdesProduct, BumdesProductResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BumdesProductStoreRequest $request)
    {
        try {
            $data = $request->validated();


            $bumdesProduct = BumdesProduct::create($data);

            return ResponseHelper::jsonResponse(true, 'Data produk berhasil ditambahkan', new BumdesProductResource($bumdesProduct), 201);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function findByBarcode($barcode)
    {
        $product = BumdesProduct::where('barcode', $barcode)
            ->where('status','active')
            ->first();

        if(!$product){
            return ResponseHelper::jsonResponse(false, 'Product dengan barcode tersebut tidak ditemukan', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'Product berhasil ditemukan', $product, 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $bumdesProduct = BumdesProduct::find($id);

            if(!$bumdesProduct){
                return ResponseHelper::jsonResponse(false, 'Data product bumdes tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data product bumdes berhasil diambil', new BumdesProductResource($bumdesProduct), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesProductUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $bumdesProduct = BumdesProduct::find($id);

            if(!$bumdesProduct){
                return ResponseHelper::jsonResponse(false, 'Data product bumdes tidak ditemukan', null, 404);
            }

            $bumdesProduct->update($data);

            return ResponseHelper::jsonResponse(true, 'Data produk bumdes berhasil diperbarui', new BumdesProductResource($bumdesProduct), 200);
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
            $bumdesProduct = BumdesProduct::find($id);

            $bumdesProduct->delete();

        return ResponseHelper::jsonResponse(true, 'Data produk bumdes berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
