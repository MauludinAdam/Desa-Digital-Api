<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BumdesSales;
use App\Models\BumdesProduct;
use App\Models\BumdesSalesItem;
use Carbon\Carbon;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;

class DashboardBumdesController extends Controller
{
    public function index()
    {
        try {
            // Statistik Utama
            $totalSales = BumdesSales::sum('total_amount');
            $totalTransksi = BumdesSales::count();
            $totalProduct = BumdesProduct::count();

            $averageTransaction = $totalTransksi > 0 ? $totalSales / $totalTransksi : 0;

            // Stok
            $lowStock = BumdesProduct::where('stock', '>', 0)
                ->where('stock', '<', 10)
                ->count();

            $outOfStock = BumdesProduct::where('stock', 0)
                ->count();

            // Total product yang pernah terjual
            $productsSold = BumdesSalesItem::distinct('bumdes_product_id')
                ->count('bumdes_product_id');

            // Penjualan Minggu ini
            $salesChart = collect(range(6, 0))
                ->map(function ($day){
                    $date = Carbon::today()->subDays($day);
                    $total = BumdesSales::whereDate(
                        'sale_date', $date
                    )->sum('total_amount');

                    return [
                        'date'  => $date->format('Y-m-d'),
                        'label' => $date->translatedFormat('D'),
                        'total' => $total,
                    ];
                });


                // Produck terlaris
                $bestSellingProducts = BumdesSalesItem::select(
                    'bumdes_product_id',
                    DB::raw('SUM(quantity) as total_quantity')
                )
                 ->with('bumdesProduct:id,name')
                 ->groupBy('bumdes_product_id')
                 ->orderByDesc('total_quantity')
                 ->limit(5)
                 ->get()
                 ->map(function ($item) {

                 return [
                    'product_id'    => $item->bumdes_product_id,
                    'product_name'  => $item->bumdesProduct->name ?? '-',
                    'total_quantity'    => (int) $item->total_quantity,
                 ];

                 });

                 
                // Metode Pembayaran
                $paymentMethods = BumdesSales::select(
                    'payment_method',
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('payment_method')
                ->orderByDesc('total')
                ->get()
                ->map(function ($item) {

                    return [
                        'payment_method' => $item->payment_method ?? '-',
                        'total' => (int) $item->total,
                    ];
                });


                // Product Stok Menipis
                $lowStockProduct = BumdesProduct::where('stock', '<', 10)
                ->orderBy('stock', 'asc')
                ->limit(5)
                ->get(['id','name','stock','unit']);

                // Transaksi terbaru
                $latestTransactions = BumdesSales::orderBy(
                    'created_at',
                    'desc'
                )
                ->limit(5)
                ->get(['id','invoice_number','sale_date','customer_name','total_amount','payment_method','status']);

                return ResponseHelper::jsonResponse(true, 'Dashboard bumdes berhasil diambil', [
                    'statistics' => [
                        'total_sales'   => $totalSales,
                        'total_transactions' => $totalTransksi,
                        'total_product'     => $totalProduct,
                        'average_transaction' => round(
                            $averageTransaction, 2
                        ),
                        'products_sold' => $productsSold,
                        'low_stoct' => $lowStock,
                        'out_of_stock'  => $outOfStock,
                    ],

                    'sales_chart'   => $salesChart,
                    'best_selling_products' => $bestSellingProducts,
                    'payment_methods'   => $paymentMethods,
                    'low_stock_product' => $lowStockProduct,
                    'latest_transactions'   => $latestTransactions,
                ], 200
                );
        } catch (\Throwable $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
