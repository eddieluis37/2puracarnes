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
        $product = new Product(["code"=> "PC001", "barcode" => "123456689", "name" => "PACHA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "10000", "price" => "12000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC002", "barcode" => "123456690", "name" => "CENTRO DE PIERNA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "10500", "price" => "12500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC003", "barcode" => "123456691", "name" => "SIRLOIN DE RES", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "11000", "price" => "13000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC004", "barcode" => "123456692", "name" => "BOTA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "11500", "price" => "13500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC005", "barcode" => "123456693", "name" => "CAMPANA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "12000", "price" => "14000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC006", "barcode" => "123456694", "name" => "MUCHACHO", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "12500", "price" => "14500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC007", "barcode" => "123456695", "name" => "CADERA SIN PUNTA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "2", "unitofmeasure_id" => "1", "cost" => "13000", "price" => "15000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC008", "barcode" => "123456696", "name" => "CADERA CON PUNTA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "2", "unitofmeasure_id" => "1", "cost" => "13500", "price" => "15500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC009", "barcode" => "123456697", "name" => "PUNTA DE ANCA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "2", "unitofmeasure_id" => "1", "cost" => "14000", "price" => "16000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC010", "barcode" => "123456698", "name" => "BOLA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "3", "unitofmeasure_id" => "1", "cost" => "14500", "price" => "16500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC011", "barcode" => "123456699", "name" => "CHATA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "4", "unitofmeasure_id" => "1", "cost" => "15000", "price" => "17000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC012", "barcode" => "123456700", "name" => "CHURRASCO", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "4", "unitofmeasure_id" => "1", "cost" => "15500", "price" => "17500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC013", "barcode" => "123456701", "name" => "LOMO ENTERO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "5", "unitofmeasure_id" => "1", "cost" => "16000", "price" => "18000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC014", "barcode" => "123456702", "name" => "LOMO FINO LIMPIO", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "5", "unitofmeasure_id" => "1", "cost" => "16500", "price" => "18500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC015", "barcode" => "123456703", "name" => "BRAZO COMPLETO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "6", "unitofmeasure_id" => "1", "cost" => "17000", "price" => "19000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC016", "barcode" => "123456704", "name" => "BOLA DE BRAZO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "6", "unitofmeasure_id" => "1", "cost" => "17500", "price" => "19500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC017", "barcode" => "123456705", "name" => "ASAR ESPECIAL", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "6", "unitofmeasure_id" => "1", "cost" => "18000", "price" => "20000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC018", "barcode" => "123456706", "name" => "DESCARGUE COMPLETO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "18500", "price" => "20500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC019", "barcode" => "123456707", "name" => "FINA TAJADA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "19000", "price" => "21000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC020", "barcode" => "123456708", "name" => "MILANESA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "19500", "price" => "21500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC021", "barcode" => "123456709", "name" => "LOMO BARCINO", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "20000", "price" => "22000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC022", "barcode" => "123456710", "name" => "CARNE PARA SUDAR", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "12000", "price" => "14000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC023", "barcode" => "123456711", "name" => "CARNE BLANDA PARA ASAR", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "12000", "price" => "14000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC024", "barcode" => "123456712", "name" => "PECHO CON TAPA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "20500", "price" => "22500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC025", "barcode" => "123456713", "name" => "PECHO SIN TAPA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "21000", "price" => "23000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC026", "barcode" => "123456714", "name" => "PECHO SIN TAPA SIN BOTON", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "21500", "price" => "23500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC027", "barcode" => "123456715", "name" => "TAPA ", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "22000", "price" => "24000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC028", "barcode" => "123456716", "name" => "BOTON", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "22500", "price" => "24500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC029", "barcode" => "123456717", "name" => "MURILLO PIERNA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "9", "unitofmeasure_id" => "1", "cost" => "23000", "price" => "25000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC030", "barcode" => "123456718", "name" => "MURILLO ", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "9", "unitofmeasure_id" => "1", "cost" => "23500", "price" => "25500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC031", "barcode" => "123456719", "name" => "COGOTE", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "10", "unitofmeasure_id" => "1", "cost" => "24000", "price" => "26000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC032", "barcode" => "123456720", "name" => "GOULASH", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "10", "unitofmeasure_id" => "1", "cost" => "24500", "price" => "26500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC033", "barcode" => "123456721", "name" => "MOLIDA ESPECIAL", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "10", "unitofmeasure_id" => "1", "cost" => "25000", "price" => "27000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC034", "barcode" => "123456722", "name" => "COSTILLA DELANTERA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "11", "unitofmeasure_id" => "1", "cost" => "25500", "price" => "27500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC035", "barcode" => "123456723", "name" => "ASADO DE TIRA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "11", "unitofmeasure_id" => "1", "cost" => "26000", "price" => "28000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC036", "barcode" => "123456724", "name" => "COSTILLA SUPER ESPECIAL", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "11", "unitofmeasure_id" => "1", "cost" => "26500", "price" => "28500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC037", "barcode" => "123456725", "name" => "COSTILLA COMPLETA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "27000", "price" => "29000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC038", "barcode" => "123456726", "name" => "COSTILLA CANASTO", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "27500", "price" => "29500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC039", "barcode" => "123456727", "name" => "COSTILLA ESPECIAL", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "28000", "price" => "30000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC040", "barcode" => "123456728", "name" => "COSTILLA CORRIENTE", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "28500", "price" => "30500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC041", "barcode" => "123456729", "name" => "FALDA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "29000", "price" => "31000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC042", "barcode" => "123456730", "name" => "SOBREBARRIGA GRUESA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "29500", "price" => "31500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC043", "barcode" => "123456731", "name" => "SOBREBARRIGA DELGADA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "30000", "price" => "32000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC044", "barcode" => "123456732", "name" => "COLA DE RES ENTERA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "13", "unitofmeasure_id" => "1", "cost" => "30500", "price" => "32500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC045", "barcode" => "123456733", "name" => "NUDOS DE COLA", "stock" => "10", "category_id" => "1", "level_product_id" => "2", "meatcut_id" => "13", "unitofmeasure_id" => "1", "cost" => "31000", "price" => "33000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC046", "barcode" => "123456734", "name" => "HUESO DE PALETA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "14", "unitofmeasure_id" => "1", "cost" => "31500", "price" => "33500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC047", "barcode" => "123456735", "name" => "TOMAHAWK-TBONE", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "15", "unitofmeasure_id" => "1", "cost" => "32000", "price" => "34000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC048", "barcode" => "123456736", "name" => "HUESO ESPECIAL", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "16", "unitofmeasure_id" => "1", "cost" => "32500", "price" => "34500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC049", "barcode" => "123456737", "name" => "HUESO AGUJA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "17", "unitofmeasure_id" => "1", "cost" => "33000", "price" => "35000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC050", "barcode" => "123456738", "name" => "HUESO CARNUDO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "18", "unitofmeasure_id" => "1", "cost" => "33500", "price" => "35500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC051", "barcode" => "123456739", "name" => "HUESO DE PECHO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "19", "unitofmeasure_id" => "1", "cost" => "34000", "price" => "36000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC052", "barcode" => "123456740", "name" => "VIRILIS", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "20", "unitofmeasure_id" => "1", "cost" => "34500", "price" => "36500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC053", "barcode" => "123456741", "name" => "CREADILLAS", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "21", "unitofmeasure_id" => "1", "cost" => "35000", "price" => "37000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC054", "barcode" => "123456742", "name" => "SEBO PECHO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "22", "unitofmeasure_id" => "1", "cost" => "35500", "price" => "37500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC055", "barcode" => "123456743", "name" => "SEBO ", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "23", "unitofmeasure_id" => "1", "cost" => "36000", "price" => "38000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC056", "barcode" => "123456744", "name" => "HUESO POROSO", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "24", "unitofmeasure_id" => "1", "cost" => "36500", "price" => "38500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC057", "barcode" => "123456745", "name" => "MOTA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "25", "unitofmeasure_id" => "1", "cost" => "37000", "price" => "39000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC058", "barcode" => "123456746", "name" => "MOLIDA CORRIENTE", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "25", "unitofmeasure_id" => "1", "cost" => "37500", "price" => "39500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC059", "barcode" => "123456747", "name" => "CHOCOZUELA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "26", "unitofmeasure_id" => "1", "cost" => "38000", "price" => "40000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC060", "barcode" => "123456748", "name" => "RILA", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "27", "unitofmeasure_id" => "1", "cost" => "38500", "price" => "40500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
$product = new Product(["code"=> "PC061", "barcode" => "123456749", "name" => "UBRE", "stock" => "10", "category_id" => "1", "level_product_id" => "1", "meatcut_id" => "28", "unitofmeasure_id" => "1", "cost" => "39000", "price" => "41000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();

/*
        // AVES - POLLO

        $product = new Product(["code"=> "PC301", "barcode" => "123456875", "name" => "PECHUGA", "stock" => "10", "category_id" => "3", "meatcut_id" => "51", "unitofmeasure_id" => "1", "cost" => "10000", "price" => "12000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC302", "barcode" => "123456876", "name" => "PIERNA PERNIL, CON RABADILLA", "stock" => "10", "category_id" => "3", "meatcut_id" => "52", "unitofmeasure_id" => "1", "cost" => "10500", "price" => "12500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC303", "barcode" => "123456877", "name" => "PIERNA PERNIL , SIN RABADILLA", "stock" => "10", "category_id" => "3", "meatcut_id" => "52", "unitofmeasure_id" => "1", "cost" => "11000", "price" => "13000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC304", "barcode" => "123456878", "name" => "COLOMBINAS", "stock" => "10", "category_id" => "3", "meatcut_id" => "52", "unitofmeasure_id" => "1", "cost" => "11500", "price" => "13500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC305", "barcode" => "123456879", "name" => "MUSLITOS", "stock" => "10", "category_id" => "3", "meatcut_id" => "52", "unitofmeasure_id" => "1", "cost" => "12000", "price" => "14000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC306", "barcode" => "123456880", "name" => "MIXTO", "stock" => "10", "category_id" => "3", "meatcut_id" => "52", "unitofmeasure_id" => "1", "cost" => "12500", "price" => "14500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC307", "barcode" => "123456881", "name" => "ALAS, CON COSTILLAR", "stock" => "10", "category_id" => "3", "meatcut_id" => "53", "unitofmeasure_id" => "1", "cost" => "13000", "price" => "15000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC308", "barcode" => "123456882", "name" => "ALAS, SIN COSTILLAR", "stock" => "10", "category_id" => "3", "meatcut_id" => "53", "unitofmeasure_id" => "1", "cost" => "13500", "price" => "15500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC309", "barcode" => "123456883", "name" => "COSTILLARES", "stock" => "10", "category_id" => "3", "meatcut_id" => "53", "unitofmeasure_id" => "1", "cost" => "14000", "price" => "16000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC310", "barcode" => "123456884", "name" => "COSTILLARES", "stock" => "10", "category_id" => "3", "meatcut_id" => "53", "unitofmeasure_id" => "1", "cost" => "14500", "price" => "16500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC311", "barcode" => "123456885", "name" => "GRASA", "stock" => "10", "category_id" => "3", "meatcut_id" => "54", "unitofmeasure_id" => "1", "cost" => "15000", "price" => "17000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC312", "barcode" => "123456886", "name" => "POLLO ENTERO", "stock" => "10", "category_id" => "3", "meatcut_id" => "55", "unitofmeasure_id" => "1", "cost" => "15500", "price" => "17500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC313", "barcode" => "123456887", "name" => "MENUDENCIAS", "stock" => "10", "category_id" => "3", "meatcut_id" => "56", "unitofmeasure_id" => "1", "cost" => "16000", "price" => "18000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC314", "barcode" => "123456888", "name" => "MOLLEJAS", "stock" => "10", "category_id" => "3", "meatcut_id" => "56", "unitofmeasure_id" => "1", "cost" => "16500", "price" => "18500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();
        $product = new Product(["code"=> "PC315", "barcode" => "123456889", "name" => "CORAZONES", "stock" => "10", "category_id" => "3", "meatcut_id" => "56", "unitofmeasure_id" => "1", "cost" => "17000", "price" => "19000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]); $product->save();


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
        /*  Product::create([
            'meatcut_id'=> 1,
        	'category_id' => 1,
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
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
            'unitofmeasure_id' => 1,
            'name' => 'BOTA CON MUCHACHO',
            'code' => 'PC009',
            'cost' => 13000,
            'price' => 17700,
            'barcode' => '790654817',
            'stock' => 1000,
            'alerts' => 10,
            'image' => '.png'
        ]); */
    }
}
