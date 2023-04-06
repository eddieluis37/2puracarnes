<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'ESPECIAL STICK',
            'code' => 'PC0040',
            'cost' => 21000,
            'price' => 23000,
            'iva' => 19,
            'barcode' => '77070065557',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 4,
            'image' => '.png'
        ]);
        Product::create([
            'name' => 'PULGAREJO',
            'code' => 'PC0313',
            'cost' => 21000,
            'price' => 23000,
            'iva' => 19,
            'barcode' => '71010065987',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 5,
            'image' => '.png'
        ]);
        Product::create([
            'name' => 'CHORIZO SANTAROSANO 800 GR X 10',
            'code' => 'PC401',
            'cost' => 21000,
            'price' => 23000,
            'iva' => 19,
            'barcode' => '75010065987',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 6,
            'image' => '.png'
        ]);
        Product::create([
        	'name' => 'LOMO FINO',
            'code' => 'PC001',
        	'cost' => 21000,
        	'price' => 23000,
            'iva' => 0,
        	'barcode' => '75010065987',
        	'stock' => 1000,
        	'alerts' => 10,
        	'category_id' => 1,
        	'image' => '.png'
        ]);
         Product::create([
        	'name' => 'PUNTA DE ANCA',
            'code' => 'PC002',
        	'cost' => 21000,
        	'price' => 23000,
            'iva' => 0,
        	'barcode' => '7609872014',
        	'stock' => 1000,
        	'alerts' => 10,
        	'category_id' => 1,
        	'image' => 'CADERAS.png'
        ]);
          Product::create([
        	'name' => 'CHATA',
            'code' => 'PC003',
        	'cost' => 19000,
        	'price' => 22600,
            'iva' => 19,
        	'barcode' => '7709876541',
        	'stock' => 1000,
        	'alerts' => 10,
        	'category_id' => 1,
        	'image' => 'PIERNA.png'
        ]);
           Product::create([
        	'name' => 'CHURRASCO',
            'code' => 'PC004',
        	'cost' => 22000,
        	'price' => 29000,
        	'barcode' => '790654812',
        	'stock' => 1000,
        	'alerts' => 10,
        	'category_id' => 1,
        	'image' => 'CHATAS.png'
        ]);
            Product::create([
            'name' => 'ASAR ESPECIAL',
            'code' => 'PC005',
            'cost' => 32000,
            'price' => 42000,
            'barcode' => '790654813',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'CHATAS.png'
        ]);
            Product::create([
            'name' => 'CENTRO DE PIERNA',
            'code' => 'PC006',
            'cost' => 12000,
            'price' => 19800,
            'barcode' => '790654814',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'CHATAS.png'
        ]);
             Product::create([
            'name' => 'BOLA DE PIERNA',
            'code' => 'PC007',
            'cost' => 14000,
            'price' => 19800,
            'barcode' => '790654815',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'CHATAS.png'
        ]);
              Product::create([
            'name' => 'CADERA',
            'code' => 'PC008',
            'cost' => 14000,
            'price' => 19800,
            'barcode' => '790654816',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => 'CHATAS.png'
        ]);
              Product::create([
            'name' => 'BOTA CON MUCHACHO',
            'code' => 'PC009',
            'cost' => 13000,
            'price' => 17700,
            'barcode' => '790654817',
            'stock' => 1000,
            'alerts' => 10,
            'category_id' => 1,
            'image' => '.png'
        ]);

    }
}
