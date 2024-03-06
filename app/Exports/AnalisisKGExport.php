<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class analisisKGExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'CAT',
            'BASICO',
            'PRODUCTO',
            'INI',
            'CL',
            'TF',
            'CP',
            'TI',
            'TS',
            'VE',
            'NC',
            'ND',
            'TVE',
            'SI',
            'INF',
            'DIS',
            'MER',
            'PMER'
        ];
    }
}