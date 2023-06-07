<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Eddie Rada',
            'phone' => '3324769453',
            'email' => 'admin@puracarnes.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('7201880130')
        ]);
        User::create([
            'name' => 'Yaniela Gutierrez',
            'phone' => '301873219',
            'email' => 'nacional@puracarnes.com',
            'profile' => 'Cajero',
            'status' => 'Active',
            'password' => bcrypt('7201880130')
        ]);
         User::create([
            'name' => 'Jair Rada Rada',
            'phone' => '3008755514',
            //'email' => 'vendedor1@puracarnes.com',
            'email' => 'realbenditouno@gmail.com',
            'profile' => 'Vendedor',
            'status' => 'Active',
            'password' => bcrypt('realbenditouno12345')
        ]);

        // crear role Administrador
        $admin     = Role::create(['name' => 'Admin']);

        // crear role Cajero
        $cajero    = Role::create(['name' => 'Cajero']);

         // crear role Vendedor
        $vendedor  = Role::create(['name' => 'Vendedor']);

         // crear permisos componente Admin
        Permission::create(['name' => 'Admin_Menu']);

        // crear permisos componente Cashout
        Permission::create(['name' => 'Cashout_Create']);      


        // crear permisos componente categories
        Permission::create(['name' => 'Category_View']);  
        Permission::create(['name' => 'Category_Create']);
        Permission::create(['name' => 'Category_Search']);
        Permission::create(['name' => 'Category_Update']);
        Permission::create(['name' => 'Category_Destroy']);

         // crear permisos componente parametros
        Permission::create(['name' => 'Parametros_Create']);

         // crear permisos componente Productos
        Permission::create(['name' => 'Product_View']);
        Permission::create(['name' => 'Product_Create']);
        Permission::create(['name' => 'Product_Search']);
        Permission::create(['name' => 'Product_Update']);
        Permission::create(['name' => 'Product_Destroy']);

         // crear permisos componente Ventas

        Permission::create(['name' => 'Pos_Create']);

        // crear permisos componente Reportes

        Permission::create(['name' => 'Report_Create']);
       

        // asignar permisos al rol Admin
        $admin->givePermissionTo(['Admin_Menu', 'Cashout_Create', 'Parametros_Create', 'Category_View', 'Category_Create', 'Category_Search', 'Category_Update', 'Category_Destroy', 'Product_View', 'Product_Create', 'Product_Search', 'Product_Update', 'Product_Destroy', 'Pos_Create', 'Report_Create'
        ]);

        // asignar permisos al rol Cajero
        $cajero->givePermissionTo(['Cashout_Create', 'Category_View', 'Category_Search', 'Product_View', 'Product_Search', 'Pos_Create']);

        // asignar permisos al vendedor
        $vendedor->givePermissionTo(['Cashout_Create','Category_View', 'Category_Search', 'Product_View', 'Product_Search']);



        // asignar role Admin al usuario Eddie Rada
        $uAdmin = User::find(1);
        $uAdmin->assignRole('Admin');

        // asignar role Cajero al usuario Andrea Cabana
        $uCajero = User::find(2);
        $uCajero->assignRole('Cajero');

         // asignar role Vendedor al usuario Jair Rada
        $uVendedor = User::find(3);
        $uVendedor->assignRole('Vendedor');       

          
    }
}
