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
            'name' => 'Jair Rada Rada',
            'phone' => '3008755514',
            'email' => 'gerencia.comercial@puracarnes.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('3016032085')
        ]);
        User::create([
            'name' => 'directivo',
            'phone' => '3008755514',
            'email' => 'directivo@puracarnes.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('directivo@puracarnes.com')
        ]);
        User::create([
            'name' => 'compras',
            'phone' => '3008755514',
            'email' => 'compras@puracarnes.com',
            'profile' => 'Comprador',
            'status' => 'Active',
            'password' => bcrypt('compras@puracarnes.com')
        ]);
        User::create([
            'name' => 'produccion',
            'phone' => '3008755514',
            'email' => 'produccion@puracarnes.com',
            'profile' => 'produccion',
            'status' => 'Active',
            'password' => bcrypt('produccion@puracarnes.com')
        ]);

        /* User::create([
            'name' => 'produccion',
            'phone' => '301873219',
            'email' => 'produccion@puracarnes.com',
            'profile' => 'Alistamiento',
            'status' => 'Active',
            'password' => bcrypt('produccion@puracarnes.com')
        ]); */

        /**********************************************************************/
        /*** Al agregar nuevos roles  se debe agregar el rol en la migracion tabla User
         *   $table->enum('profile',['Admin','Cajero','Vendedor','Comprador'])->default('Admin'); */

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

        // crear permisos para usuario comprador
        Permission::create(['name' => 'Compras_All']);
        Permission::create(['name' => 'Inventory']);

        // crear permisos para usuario produccion
        Permission::create(['name' => 'Produccion']);
     


        // crear role Administrador
        $admin     = Role::create(['name' => 'Admin']);

        // crear role Cajero
        $cajero    = Role::create(['name' => 'Cajero']);

        // crear role Vendedor
        $vendedor  = Role::create(['name' => 'Vendedor']);

        // crear role compras
        $comprador  = Role::create(['name' => 'Comprador']);

         // crear role alistamiento
         $produccion  = Role::create(['name' => 'Produccion']);

        // asignar permisos al rol Admin
        $admin->givePermissionTo([
            'Admin_Menu', 'Compras_All', 'Produccion', 'Inventory', 'Cashout_Create', 'Parametros_Create', 'Category_View', 'Category_Create', 'Category_Search', 'Category_Update', 'Category_Destroy', 'Product_View', 'Product_Create', 'Product_Search', 'Product_Update', 'Product_Destroy', 'Pos_Create', 'Report_Create'
        ]);

        // asignar permisos al rol Cajero
        $cajero->givePermissionTo(['Cashout_Create', 'Category_View', 'Category_Search', 'Product_View', 'Product_Search', 'Pos_Create']);

        // asignar permisos al vendedor
        $vendedor->givePermissionTo(['Cashout_Create', 'Category_View', 'Category_Search', 'Product_View', 'Product_Search']);

        // asignar permisos al comprador
        $comprador->givePermissionTo(['Compras_All', 'Inventory']);

        // asignar permisos a produccion
        $produccion->givePermissionTo(['Produccion']);

        // asignar role Admin al usuario Eddie Rada
        $uAdmin = User::find(1);
        $uAdmin->assignRole('Admin');

        // asignar role Admin al usuario directivo
        $uAdmin = User::find(2);
        $uAdmin->assignRole('Admin');

        // asignar role Cajero al usuario Andrea Cabana
        $uCajero = User::find(2);
        $uCajero->assignRole('Cajero');

        // asignar role Vendedor al usuario Jair Rada
        $uVendedor = User::find(3);
        $uVendedor->assignRole('Vendedor');

        // asignar role Compras al usuario compras
        $uComprador = User::find(4);
        $uComprador->assignRole('Comprador');
        
        $uProduccion = User::find(4);
        $uProduccion->assignRole('Produccion');
    }
}
