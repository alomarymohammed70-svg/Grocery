<?php

namespace App\Exports;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Sale::whereBetween('sale_date', [$this->startDate, $this->endDate])
            ->with('customer')
            ->withCount('items')
            ->get();
    }

    public function headings(): array
    {
        return [
            'رقم الفاتورة',
            'التاريخ',
            'العميل',
            'نوع البيع',
            'عدد الأصناف',
            'المبلغ الإجمالي',
            'المبلغ المدفوع',
            'المبلغ المتبقي'
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->invoice_number,
            $sale->sale_date,
            $sale->customer->name ?? 'غير محدد',
            $sale->sale_type == 'cash' ? 'نقداً' : 'آجل',
            $sale->items_count,
            number_format($sale->total_amount, 2),
            number_format($sale->paid_amount, 2),
            number_format($sale->total_amount - $sale->paid_amount, 2)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:H' => ['alignment' => ['horizontal' => 'right']],
        ];
    }
}