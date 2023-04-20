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
        /*Product::create([
            'meatcut_id'=> 1,
            'category_id' => 4,
            'name' => 'ESPECIAL STICK',
            'code' => 'PC0040',
            'cost' => 21000,
            'price' => 23000,
            'iva' => 19,
            'barcode' => '77070065557',
            'stock' => 1000,
            'alerts' => 10,
            'image' => '.png'
        ]);
        Product::create([
            'meatcut_id'=> 1,
            'category_id' => 5,
            'name' => 'PULGAREJO',
            'code' => 'PC0313',
            'cost' => 21000,
            'price' => 23000,
            'iva' => 19,
            'barcode' => '71010065987',
            'stock' => 1000,
            'alerts' => 10,
            'image' => '.png'
        ]);
        Product::create([
            'meatcut_id'=> 1,
            'category_id' => 6,
            'name' => 'CHORIZO SANTAROSANO 800 GR X 10',
            'code' => 'PC401',
            'cost' => 21000,
            'price' => 23000,
            'iva' => 19,
            'barcode' => '75010065987',
            'stock' => 1000,
            'alerts' => 10,
            'image' => '.png'
        ]);*/
        Product::create([
            'meatcut_id'=> 1,
        	'category_id' => 1,
        	'name' => 'LOMO FINO',
            'code' => 'PC001',
        	'cost' => 21000,
        	'price' => 23000,
            'iva' => 0,
        	'barcode' => '75010065987',
        	'stock' => 1000,
        	'alerts' => 10,
        	'image' => '.png'
        ]);
         Product::create([
            'meatcut_id'=> 1,
        	'category_id' => 1,
        	'name' => 'PUNTA DE ANCA',
            'code' => 'PC002',
        	'cost' => 21000,
        	'price' => 23000,
            'iva' => 0,
        	'barcode' => '7609872014',
        	'stock' => 1000,
        	'alerts' => 10,
        	'image' => 'CADERAS.png'
        ]);
          Product::create([
            'meatcut_id'=> 1,
        	'category_id' => 1,
        	'name' => 'CHATA',
            'code' => 'PC003',
        	'cost' => 19000,
        	'price' => 22600,
            'iva' => 19,
        	'barcode' => '7709876541',
        	'stock' => 1000,
        	'alerts' => 10,
        	'image' => 'PIERNA.png'
        ]);
           Product::create([
            'meatcut_id'=> 1,
        	'category_id' => 1,
        	'name' => 'CHURRASCO',
            'code' => 'PC004',
        	'cost' => 22000,
        	'price' => 29000,
        	'barcode' => '790654812',
        	'stock' => 1000,
        	'alerts' => 10,
        	'image' => 'CHATAS.png'
        ]);
            Product::create([
            'meatcut_id'=> 1,
            'category_id' => 1,
            'name' => 'ASAR ESPECIAL',
            'code' => 'PC005',
            'cost' => 32000,
            'price' => 42000,
            'barcode' => '790654813',
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'CHATAS.png'
        ]);
            Product::create([
            'meatcut_id'=> 1,
            'category_id' => 1,
            'name' => 'CENTRO DE PIERNA',
            'code' => 'PC006',
            'cost' => 12000,
            'price' => 19800,
            'barcode' => '790654814',
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'CHATAS.png'
        ]);
             Product::create([
            'meatcut_id'=> 1,
            'category_id' => 1,
            'name' => 'BOLA DE PIERNA',
            'code' => 'PC007',
            'cost' => 14000,
            'price' => 19800,
            'barcode' => '790654815',
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'CHATAS.png'
        ]);
            Product::create([
            'meatcut_id'=> 1,
            'category_id' => 1,
            'name' => 'CADERA',
            'code' => 'PC008',
            'cost' => 14000,
            'price' => 19800,
            'barcode' => '790654816',
            'stock' => 1000,
            'alerts' => 10,
            'image' => 'CHATAS.png'
        ]);
            Product::create([
            'meatcut_id'=> 1,
            'category_id' => 1,
            'name' => 'BOTA CON MUCHACHO',
            'code' => 'PC009',
            'cost' => 13000,
            'price' => 17700,
            'barcode' => '790654817',
            'stock' => 1000,
            'alerts' => 10,
            'image' => '.png'
        ]);

    }
}
