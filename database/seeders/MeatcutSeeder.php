<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products\Meatcut;

class MeatcutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meatcut::create([
        	'category_id' => 1,
        	'name' => 'Pacha',
        	'description' => '',
        	'status' => true
        ]);
    }
}
