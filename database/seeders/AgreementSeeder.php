<?php

namespace Database\Seeders;

use App\Models\Agreement;
use Illuminate\Database\Seeder;

class AgreementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agreement::create([
        	'name' => 'CLIENTES REGULARES'
        	
        ]);       
        Agreement::create([
        	'name' => 'SEMANAL'
        
        ]);
        Agreement::create([
            'name' => 'QUINCENAL'
           
        ]);
        Agreement::create([
            'name' => 'MENSUAL'
            
        ]);
        Agreement::create([
            'name' => 'TRIMESTRAL'            
        ]);
         Agreement::create([
        	'name' => 'POLICIA NACIONAL'
        	
        ]);
        Agreement::create([
        	'name' => 'DEFENSA CIVIL'
        	
        ]);
    }
}
