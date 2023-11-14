<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Centro_costo_product;

class StockFisicoImportClass implements ToModel
{
    public function model(array $row)
    {
        return new Centro_costo_product([
       
            'column1' => $row[0],
            'column2' => $row[1],
          
        ]);
    }
}
