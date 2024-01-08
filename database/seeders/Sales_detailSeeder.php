<?php

namespace Database\Seeders;

use App\Models\SaleDetail;
use Illuminate\Database\Seeder;

class Sales_detailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SaleDetail::create([
            'sale_id' => 1,
            'product_id' => 1,
            'quantity' => 3,
            'price' => 7000,
            'porc_desc' => 5,
            'descuento' => 3,
            'descuento_cliente' => 3000,
            'porc_iva' => 18,
            'iva' => 1000,
            'otro_impuesto' => 0,
            'total_bruto' => 50000,            
            'total' => 100000,
            'status' => true
        ]);
    }
}
