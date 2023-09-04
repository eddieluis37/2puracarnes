<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
        	'name' => 'RES',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'CERDO',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'AVES',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'VISCERAS',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'PRODUCTOS PGC',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'CARNICOS',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
        	'name' => 'VISCERAS',
        	'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'EMBUTIDOS',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'PESCADERIA',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
        Category::create([
            'name' => 'OTRAS PROTEINAS',
            'image' => 'https://dummyimage.com/200x150/5c5756/fff'
        ]);
    }
}
