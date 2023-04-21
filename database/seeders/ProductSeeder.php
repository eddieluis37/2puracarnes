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
        $product = new Product(["code" => "PC001", "barcode" => "123456789", "name" => "PACHA", "stock" => "10", "category_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "10000", "price" => "12000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC002", "barcode" => "123456790", "name" => "CENTRO DE PIERNA", "stock" => "20", "category_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "10500", "price" => "12500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC003", "barcode" => "123456791", "name" => "SIRLOIN DE RES", "stock" => "30", "category_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "11000", "price" => "13000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC004", "barcode" => "123456792", "name" => "BOTA", "stock" => "40", "category_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "11500", "price" => "13500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC005", "barcode" => "123456793", "name" => "CAMPANA", "stock" => "50", "category_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "12000", "price" => "14000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC006", "barcode" => "123456794", "name" => "MUCHACHO", "stock" => "60", "category_id" => "1", "meatcut_id" => "1", "unitofmeasure_id" => "1", "cost" => "12500", "price" => "14500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC007", "barcode" => "123456795", "name" => "CADERA SIN PUNTA", "stock" => "70", "category_id" => "1", "meatcut_id" => "2", "unitofmeasure_id" => "1", "cost" => "13000", "price" => "15000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC008", "barcode" => "123456796", "name" => "CADERA CON PUNTA", "stock" => "80", "category_id" => "1", "meatcut_id" => "2", "unitofmeasure_id" => "1", "cost" => "13500", "price" => "15500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC009", "barcode" => "123456797", "name" => "PUNTA DE ANCA", "stock" => "90", "category_id" => "1", "meatcut_id" => "2", "unitofmeasure_id" => "1", "cost" => "14000", "price" => "16000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC010", "barcode" => "123456798", "name" => "BOLA", "stock" => "20", "category_id" => "1", "meatcut_id" => "3", "unitofmeasure_id" => "1", "cost" => "14500", "price" => "16500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC011", "barcode" => "123456799", "name" => "CHATA", "stock" => "30", "category_id" => "1", "meatcut_id" => "4", "unitofmeasure_id" => "1", "cost" => "15000", "price" => "17000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC012", "barcode" => "123456800", "name" => "CHURRASCO", "stock" => "40", "category_id" => "1", "meatcut_id" => "4", "unitofmeasure_id" => "1", "cost" => "15500", "price" => "17500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC013", "barcode" => "123456801", "name" => "LOMO ENTERO", "stock" => "50", "category_id" => "1", "meatcut_id" => "5", "unitofmeasure_id" => "1", "cost" => "16000", "price" => "18000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC014", "barcode" => "123456802", "name" => "LOMO FINO LIMPIO", "stock" => "60", "category_id" => "1", "meatcut_id" => "5", "unitofmeasure_id" => "1", "cost" => "16500", "price" => "18500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC015", "barcode" => "123456803", "name" => "BRAZO COMPLETO", "stock" => "70", "category_id" => "1", "meatcut_id" => "6", "unitofmeasure_id" => "1", "cost" => "17000", "price" => "19000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC016", "barcode" => "123456804", "name" => "BOLA DE BRAZO", "stock" => "80", "category_id" => "1", "meatcut_id" => "6", "unitofmeasure_id" => "1", "cost" => "17500", "price" => "19500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC017", "barcode" => "123456805", "name" => "ASAR ESPECIAL", "stock" => "90", "category_id" => "1", "meatcut_id" => "6", "unitofmeasure_id" => "1", "cost" => "18000", "price" => "20000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC018", "barcode" => "123456806", "name" => "DESCARGUE COMPLETO", "stock" => "20", "category_id" => "1", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "18500", "price" => "20500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC019", "barcode" => "123456807", "name" => "FINA TAJADA", "stock" => "30", "category_id" => "1", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "19000", "price" => "21000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC020", "barcode" => "123456808", "name" => "MILANESA", "stock" => "40", "category_id" => "1", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "19500", "price" => "21500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC021", "barcode" => "123456809", "name" => "LOMO BARCINO", "stock" => "50", "category_id" => "1", "meatcut_id" => "7", "unitofmeasure_id" => "1", "cost" => "20000", "price" => "22000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC022", "barcode" => "123456810", "name" => "PECHO CON TAPA", "stock" => "60", "category_id" => "1", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "20500", "price" => "22500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC023", "barcode" => "123456811", "name" => "PECHO SIN TAPA", "stock" => "70", "category_id" => "1", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "21000", "price" => "23000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC024", "barcode" => "123456812", "name" => "PECHO SIN TAPA SIN BOTON", "stock" => "80", "category_id" => "1", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "21500", "price" => "23500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC025", "barcode" => "123456813", "name" => "TAPA ", "stock" => "90", "category_id" => "1", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "22000", "price" => "24000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC026", "barcode" => "123456814", "name" => "BOTON", "stock" => "40", "category_id" => "1", "meatcut_id" => "8", "unitofmeasure_id" => "1", "cost" => "22500", "price" => "24500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC027", "barcode" => "123456815", "name" => "MURILLO PIERNA", "stock" => "50", "category_id" => "1", "meatcut_id" => "9", "unitofmeasure_id" => "1", "cost" => "23000", "price" => "25000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC028", "barcode" => "123456816", "name" => "MURILLO ", "stock" => "60", "category_id" => "1", "meatcut_id" => "9", "unitofmeasure_id" => "1", "cost" => "23500", "price" => "25500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC029", "barcode" => "123456817", "name" => "COGOTE", "stock" => "70", "category_id" => "1", "meatcut_id" => "10", "unitofmeasure_id" => "1", "cost" => "24000", "price" => "26000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC030", "barcode" => "123456818", "name" => "GOULASH", "stock" => "80", "category_id" => "1", "meatcut_id" => "10", "unitofmeasure_id" => "1", "cost" => "24500", "price" => "26500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC031", "barcode" => "123456819", "name" => "MOLIDA ESPECIAL", "stock" => "90", "category_id" => "1", "meatcut_id" => "10", "unitofmeasure_id" => "1", "cost" => "25000", "price" => "27000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC032", "barcode" => "123456820", "name" => "COSTILLA DELANTERA", "stock" => "20", "category_id" => "1", "meatcut_id" => "11", "unitofmeasure_id" => "1", "cost" => "25500", "price" => "27500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC033", "barcode" => "123456821", "name" => "ASADO DE TIRA", "stock" => "30", "category_id" => "1", "meatcut_id" => "11", "unitofmeasure_id" => "1", "cost" => "26000", "price" => "28000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC034", "barcode" => "123456822", "name" => "COSTILLA SUPER ESPECIAL", "stock" => "40", "category_id" => "1", "meatcut_id" => "11", "unitofmeasure_id" => "1", "cost" => "26500", "price" => "28500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC101", "barcode" => "123456823", "name" => "COSTILLA COMPLETA", "stock" => "50", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "27000", "price" => "29000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC102", "barcode" => "123456824", "name" => "COSTILLA CANASTO", "stock" => "60", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "27500", "price" => "29500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC103", "barcode" => "123456825", "name" => "COSTILLA ESPECIAL", "stock" => "40", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "28000", "price" => "30000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC104", "barcode" => "123456826", "name" => "COSTILLA CORRIENTE", "stock" => "50", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "28500", "price" => "30500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC105", "barcode" => "123456827", "name" => "FALDA", "stock" => "60", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "29000", "price" => "31000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC106", "barcode" => "123456828", "name" => "SOBREBARRIGA GRUESA", "stock" => "70", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "29500", "price" => "31500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC107", "barcode" => "123456829", "name" => "SOBREBARRIGA DELGADA", "stock" => "80", "category_id" => "1", "meatcut_id" => "12", "unitofmeasure_id" => "1", "cost" => "30000", "price" => "32000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC108", "barcode" => "123456830", "name" => "COLA DE RES ENTERA", "stock" => "90", "category_id" => "1", "meatcut_id" => "13", "unitofmeasure_id" => "1", "cost" => "30500", "price" => "32500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC109", "barcode" => "123456831", "name" => "NUDOS DE COLA", "stock" => "20", "category_id" => "1", "meatcut_id" => "13", "unitofmeasure_id" => "1", "cost" => "31000", "price" => "33000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC110", "barcode" => "123456832", "name" => "HUESO DE PALETA", "stock" => "30", "category_id" => "1", "meatcut_id" => "14", "unitofmeasure_id" => "1", "cost" => "31500", "price" => "33500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC111", "barcode" => "123456833", "name" => "TOMAHAWK-TBONE", "stock" => "40", "category_id" => "1", "meatcut_id" => "15", "unitofmeasure_id" => "1", "cost" => "32000", "price" => "34000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC112", "barcode" => "123456834", "name" => "HUESO ESPECIAL", "stock" => "50", "category_id" => "1", "meatcut_id" => "16", "unitofmeasure_id" => "1", "cost" => "32500", "price" => "34500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC113", "barcode" => "123456835", "name" => "HUESO AGUJA", "stock" => "60", "category_id" => "1", "meatcut_id" => "17", "unitofmeasure_id" => "1", "cost" => "33000", "price" => "35000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC114", "barcode" => "123456836", "name" => "HUESO CARNUDO", "stock" => "70", "category_id" => "1", "meatcut_id" => "18", "unitofmeasure_id" => "1", "cost" => "33500", "price" => "35500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC115", "barcode" => "123456837", "name" => "HUESO DE PECHO", "stock" => "80", "category_id" => "1", "meatcut_id" => "19", "unitofmeasure_id" => "1", "cost" => "34000", "price" => "36000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC116", "barcode" => "123456838", "name" => "VIRILIS", "stock" => "90", "category_id" => "1", "meatcut_id" => "20", "unitofmeasure_id" => "1", "cost" => "34500", "price" => "36500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC117", "barcode" => "123456839", "name" => "CREADILLAS", "stock" => "20", "category_id" => "1", "meatcut_id" => "21", "unitofmeasure_id" => "1", "cost" => "35000", "price" => "37000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC118", "barcode" => "123456840", "name" => "SEBO PECHO", "stock" => "30", "category_id" => "1", "meatcut_id" => "22", "unitofmeasure_id" => "1", "cost" => "35500", "price" => "37500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC119", "barcode" => "123456841", "name" => "SEBO ", "stock" => "40", "category_id" => "1", "meatcut_id" => "23", "unitofmeasure_id" => "1", "cost" => "36000", "price" => "38000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC120", "barcode" => "123456842", "name" => "HUESO POROSO", "stock" => "50", "category_id" => "1", "meatcut_id" => "24", "unitofmeasure_id" => "1", "cost" => "36500", "price" => "38500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC150", "barcode" => "123456843", "name" => "MOTA", "stock" => "70", "category_id" => "1", "meatcut_id" => "25", "unitofmeasure_id" => "1", "cost" => "37000", "price" => "39000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC201", "barcode" => "123456844", "name" => "MOLIDA CORRIENTE", "stock" => "80", "category_id" => "1", "meatcut_id" => "25", "unitofmeasure_id" => "1", "cost" => "37500", "price" => "39500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC202", "barcode" => "123456845", "name" => "CHOCOZUELA", "stock" => "90", "category_id" => "1", "meatcut_id" => "26", "unitofmeasure_id" => "1", "cost" => "38000", "price" => "40000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC203", "barcode" => "123456846", "name" => "RILA", "stock" => "20", "category_id" => "1", "meatcut_id" => "27", "unitofmeasure_id" => "1", "cost" => "38500", "price" => "40500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC204", "barcode" => "123456847", "name" => "UBRE", "stock" => "30", "category_id" => "1", "meatcut_id" => "28", "unitofmeasure_id" => "1", "cost" => "39000", "price" => "41000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();

        // CERDO

        $product = new Product(["code" => "PC205", "barcode" => "123456848", "name" => "ESPINAZO DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "31", "unitofmeasure_id" => "1", "cost" => "10000", "price" => "12000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC206", "barcode" => "123456849", "name" => "SOLOMITO DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "32", "unitofmeasure_id" => "1", "cost" => "10500", "price" => "12500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC207", "barcode" => "123456850", "name" => "CHULETA DE LOMO", "stock" => "10", "category_id" => "2", "meatcut_id" => "32", "unitofmeasure_id" => "1", "cost" => "11000", "price" => "13000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC208", "barcode" => "123456851", "name" => "COSTILLA DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "32", "unitofmeasure_id" => "1", "cost" => "11500", "price" => "13500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC209", "barcode" => "123456852", "name" => "COSTILLA SPARRY", "stock" => "10", "category_id" => "2", "meatcut_id" => "32", "unitofmeasure_id" => "1", "cost" => "12000", "price" => "14000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC210", "barcode" => "123456853", "name" => "COSTILLA BABY BACK DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "32", "unitofmeasure_id" => "1", "cost" => "12500", "price" => "14500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC211", "barcode" => "123456854", "name" => "COSTILOMO COMPLETO", "stock" => "10", "category_id" => "2", "meatcut_id" => "32", "unitofmeasure_id" => "1", "cost" => "13000", "price" => "15000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC212", "barcode" => "123456855", "name" => "CABEZA DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "33", "unitofmeasure_id" => "1", "cost" => "13500", "price" => "15500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC213", "barcode" => "123456856", "name" => "TOCINO BARRIGA", "stock" => "10", "category_id" => "2", "meatcut_id" => "34", "unitofmeasure_id" => "1", "cost" => "14000", "price" => "16000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC214", "barcode" => "123456857", "name" => "TOCINO PAPADA", "stock" => "10", "category_id" => "2", "meatcut_id" => "35", "unitofmeasure_id" => "1", "cost" => "14500", "price" => "16500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC215", "barcode" => "123456858", "name" => "PEZUÑA DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "36", "unitofmeasure_id" => "1", "cost" => "15000", "price" => "17000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC216", "barcode" => "123456859", "name" => "TOCINO CORRIENTE", "stock" => "10", "category_id" => "2", "meatcut_id" => "37", "unitofmeasure_id" => "1", "cost" => "15500", "price" => "17500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC217", "barcode" => "123456860", "name" => "EMPELLA - DESPALME", "stock" => "10", "category_id" => "2", "meatcut_id" => "38", "unitofmeasure_id" => "1", "cost" => "16000", "price" => "18000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC218", "barcode" => "123456861", "name" => "SIRLOIN DE CERDO ", "stock" => "10", "category_id" => "2", "meatcut_id" => "39", "unitofmeasure_id" => "1", "cost" => "16500", "price" => "18500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC219", "barcode" => "123456862", "name" => "PULPA DE PIERNA CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "39", "unitofmeasure_id" => "1", "cost" => "17000", "price" => "19000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC220", "barcode" => "123456863", "name" => "CHULETA DE PIERNA", "stock" => "10", "category_id" => "2", "meatcut_id" => "39", "unitofmeasure_id" => "1", "cost" => "17500", "price" => "19500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC221", "barcode" => "123456864", "name" => "PULPA DE BRAZO CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "40", "unitofmeasure_id" => "1", "cost" => "18000", "price" => "20000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC222", "barcode" => "123456865", "name" => "CHULETA DE BRAZO", "stock" => "10", "category_id" => "2", "meatcut_id" => "40", "unitofmeasure_id" => "1", "cost" => "18500", "price" => "20500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC223", "barcode" => "123456866", "name" => "MILANESA DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "40", "unitofmeasure_id" => "1", "cost" => "19000", "price" => "21000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC224", "barcode" => "123456867", "name" => "GOULASH DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "40", "unitofmeasure_id" => "1", "cost" => "19500", "price" => "21500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC225", "barcode" => "123456868", "name" => "HUESO POROSO DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "41", "unitofmeasure_id" => "1", "cost" => "20000", "price" => "22000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC226", "barcode" => "123456869", "name" => "BONDIOLA", "stock" => "10", "category_id" => "2", "meatcut_id" => "42", "unitofmeasure_id" => "1", "cost" => "20500", "price" => "22500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC227", "barcode" => "123456870", "name" => "PANCETA", "stock" => "10", "category_id" => "2", "meatcut_id" => "43", "unitofmeasure_id" => "1", "cost" => "21000", "price" => "23000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC228", "barcode" => "123456871", "name" => "MATAMBRE", "stock" => "10", "category_id" => "2", "meatcut_id" => "43", "unitofmeasure_id" => "1", "cost" => "21500", "price" => "23500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC229", "barcode" => "123456872", "name" => "OSSOBUCO + CODO", "stock" => "10", "category_id" => "2", "meatcut_id" => "44", "unitofmeasure_id" => "1", "cost" => "22000", "price" => "24000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC230", "barcode" => "123456873", "name" => "LOMO DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "45", "unitofmeasure_id" => "1", "cost" => "22500", "price" => "24500", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();
        $product = new Product(["code" => "PC231", "barcode" => "123456874", "name" => "MOTA DE CERDO", "stock" => "10", "category_id" => "2", "meatcut_id" => "46", "unitofmeasure_id" => "1", "cost" => "23000", "price" => "25000", "iva" => "0", "alerts" => "10", "image" => "noimage.png"]);
        $product->save();



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
