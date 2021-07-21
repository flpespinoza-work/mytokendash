<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrintedCouponsExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $coupons;

    public function __construct($coupons)
    {
        $this->coupons = $coupons;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->coupons;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Cupones impresos',
            'Monto'
        ];
    }
}
