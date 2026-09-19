<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\BumdesSales;
use App\Models\BumdesProduct;
use App\Http\Resources\BumdesSalesResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\BumdesSales\BumdesSalesStoreRequest;
use App\Http\Requests\BumdesSales\BumdesSalesUpdateRequest;
use Illuminate\Support\Facades\DB;
use App\Models\BumdesSalesItem;
use App\Exports\BumdesSalesExport;
use Maatwebsite\Excel\Facades\Excel;

class BumdesSalesController extends Controller
{
    private function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        
        $lastSale = BumdesSales::whereDate('created_at', now()->toDateString())
        ->orderBy('created_at','desc')
        ->first();

        if($lastSale){
            $lastNumber = (int) substr($lastSale->invoice_number, -4);
            $number = $lastNumber + 1;
        }else{
            $number = 1;
        }

        return 'INV-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function generateInvoice()
    {
        $invoiceNumber = $this->generateInvoiceNumber();

        return ResponseHelper::jsonResponse(true, 'Nomor Invoice berhasil dibuat', ['invoice_number' => $invoiceNumber], 200);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'row_per_page'  => 'nullable|integer',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
        ]);

        $rowPerPage = $request->input('row_per_page');
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $bumdesSales = BumdesSales::when($search, function($query) use ($search){
            $query->search($search);
        })
        ->when($startDate && $endDate, function($query) use ($startDate, $endDate){
            $query->whereBetween('sale_date', [$startDate, $endDate]);
        })
        ->orderBy('created_at','desc')->paginate($rowPerPage);

        return ResponseHelper::jsonResponse(true, 'Data sales bumdes berhasil diambil', PaginateResource::make($bumdesSales, BumdesSalesResource::class), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BumdesSalesStoreRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Generate invoice daro backend
            $data['invoice_number'] = $this->generateInvoiceNumber();

            // Simpan transaksi utama
            $bumdesSales = BumdesSales::create([
                'invoice_number'    => $data['invoice_number'],
                'sale_date'         => $data['sale_date'],
                'customer_name'     => $data['customer_name'],
                'total_amount'      => $data['total_amount'],
                'payment_method'    => $data['payment_method'],
                'status'            => $data['status']
            ]);

            // Simpan detai transaksi
            foreach($data['items'] as $item){

            // Ambil product dan kunci row selama transaksi berlangsun
            $product = BumdesProduct::where('id', $item['bumdes_product_id'])
            ->lockForUpdate()
            ->first();

            // cek product
            if(!$product){
                throw new \Exception('product tidak ditemukan.');
            }

            // cek stok
            if($product->stock < $item['quantity']){
                throw new \Exception(
                    "Stock product {$product->name} tidak mencukupi.".
                    "Stock tersedia: {$product->stock}."
                );
            }

                BumdesSalesItem::create([
                    'bumdes_sales_id' => $bumdesSales->id,
                    'bumdes_product_id' => $item['bumdes_product_id'],
                    'quantity'          => $item['quantity'],
                    'price'             => $item['price'],
                    'subtotal'          => $item['subtotal'],
                ]);

                // Kurangi Stock
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            $bumdesSales->load('bumdesSalesItem.bumdesProduct');

            return ResponseHelper::jsonResponse(true, 'Data penjualan bumdes berhasil ditambahkan', new BumdesSalesResource($bumdesSales), 201);
        } catch (\Throwable $e) {
            DB::rollback();

            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $bumdesSales = BumdesSales::with([
                'bumdesSalesItem.bumdesProduct'
            ])->find($id);

            if(!$bumdesSales){
                return ResponseHelper::jsonResponse(false, 'Data penjualan tidak ditemukan!', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data penjualan berhasil diambil', new BumdesSalesResource($bumdesSales), 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BumdesSalesUpdateRequest $request, string $id)
    {
        try {
            $data = $request->validated();

            $bumdesSales = BumdesSales::find($id);

            if(!$bumdesSales){
                return ResponseHelper::jsonResponse(fales, 'Data penjualana tidak ditemukan', null, 404);
            }

            $bumdesSales->update($data);

            return ResponseHelper::jsonResponse(true, 'Data penjualan berhasil diperbaruin', new BumdesSalesResource($bumdesSales), 200);
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
            $bumdesSales = BumdesSales::find($id);

            if(!$bumdesSales){
                return ResponseHelper::jsonResponse(false, 'Data penjualan tidak ditemukan', null, 404);
            }

            $bumdesSales->delete();

            return ResponseHelper::jsonResponse(true, 'Data penjualan berhasil dihapus', null, 200);
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            return Excel::download(
            new BumdesSalesExport,
            'Laporan Transaksi BUMDes.xlsx'
        );
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
