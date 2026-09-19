<?php

namespace App\Exports;

use App\Models\BumdesSales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\WorkSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BumdesSalesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return BumdesSales::orderBy('sale_date','desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No.Invoice',
            'Tanggal',
            'Nama Customer',
            'Total',
            'Metode Pembayaran',
            'Status',
        ];
    }

    public function map($sale): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $sale->invoice_number,
            $sale->sale_date,
            $sale->customer_name ?? '-',
            $sale->total_amount,
            $sale->payment_method,
            $sale->status,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style Header
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb'   => 'FFFF00',
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'  => Alignment::VERTICAL_CENTER,
            ],
            'borders'   => [
                'allBorders' => [
                    'borderStyle'   => Border::BORDER_THIN,
                ],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event){
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow();

                // Border Seluruh table
                $sheet->getStyle("A1:G1{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Rata Tengan Kolom tertentu
                $sheet->getStyle("A2:A{$highestRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("B2:B{$highestRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("C2:C{$highestRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("G2:G{$highestRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("F2:F{$highestRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("E2:E{$highestRow}")
                ->getNumberFormat()
                ->setFormatCode('"Rp." #,##0');

                // Tinggi Header
                $sheet->freezePane('A2');
            }
        ];
    }
}
