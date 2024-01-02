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
            'password' => bcrypt('ab$')
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
            'name' => 'Milagros Peña',
            'phone' => '3008755514',
            'email' => 'gerencia.general@puracarnes.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('3044228481')
        ]);
        User::create([
            'name' => 'Jair Rada Rada',
            'phone' => '3008755514',
            'email' => 'contabilidad@puracarnes.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('3155352110')
        ]);
        User::create([
            'name' => 'directivo',
            'phone' => '3008755514',
            'email' => 'directivo@puracarnes.com',
            'profile' => 'Admin',
            'status' => 'Active',
            'password' => bcrypt('3016032085')
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
            'profile' => 'Produccion',
            'status' => 'Active',
            'password' => bcrypt('Produccion2023.')
        ]);
        User::create([
            'name' => 'costos',
            'phone' => '3008755514',
            'email' => 'costos@puracarnes.com',
            'profile' => 'Costos',
            'status' => 'Active',
            'password' => bcrypt('costos@puracarnes.com')
        ]);
        User::create([
            'name' => 'Tesoreria',
            'phone' => '3008755514',
            'email' => 'tesoreria@puracarnes.com',
            'profile' => 'Tesoreria',
            'status' => 'Active',
            'password' => bcrypt('tesoreria@puracarnes.com')
        ]);
        User::create([
            'name' => 'comercial',
            'phone' => '3008755514',
            'email' => 'comercial@puracarnes.com',
            'profile' => 'Comercial',
            'status' => 'Active',
            'password' => bcrypt('comercial@puracarnes.com')
        ]);       
        User::create([
            'name' => 'PRINCIPAL',
            'phone' => '3008755514',
            'email' => 'cajaprincipalpcguadalupe@puracarnes.com',
            'profile' => 'Comercial',
            'status' => 'Active',
            'password' => bcrypt('cajaprincipalpcguadalupe@puracarnes.com')
        ]);

        User::create([
            'name' => 'AUXILIAR',
            'phone' => '3008755514',
            'email' => 'cajaauxiliarpcguadalupe@puracarnes.com',
            'profile' => 'Comercial',
            'status' => 'Active',
            'password' => bcrypt('cajaauxiliarpcguadalupe@puracarnes.com')
        ]);


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

        // crear permisos modulo Reportes
        Permission::create(['name' => 'Report_Create']);

        // crear permisos para modulo compras
        Permission::create(['name' => 'Compras']);

        // crear permisos para modulo Inventario
        Permission::create(['name' => 'Inventory']);

        // crear permisos para modulo alistamiento
        Permission::create(['name' => 'Produccion']);

        // crear permisos para modulo traslados
        Permission::create(['name' => 'Traslados']);

        // crear permisos para modulo ventas
        Permission::create(['name' => 'Pos_Create']);

        // crear permisos para modulo Workshop
         Permission::create(['name' => 'Workshop']);



        // crear role Administrador
        $admin     = Role::create(['name' => 'Admin']);

        // crear role Cajero
        $cajero    = Role::create(['name' => 'Cajero']);

        // crear role compras
        $comprador  = Role::create(['name' => 'Comprador']);

        // crear role alistamiento
        $produccion  = Role::create(['name' => 'Produccion']);

        // crear role costos
        $costos  = Role::create(['name' => 'Costos']);

        // crear role Vendedor
        $ventas  = Role::create(['name' => 'Tesoreria']);

        // crear role Comercial
        $comercial  = Role::create(['name' => 'Comercial']);



        // asignar permisos al rol Admin
        $admin->givePermissionTo([
            'Admin_Menu', 'Compras', 'Produccion', 'Traslados', 'Workshop', 'Pos_Create', 'Inventory', 'Cashout_Create', 'Parametros_Create', 'Category_View', 'Category_Create', 'Category_Search', 'Category_Update', 'Category_Destroy', 'Product_View', 'Product_Create', 'Product_Search', 'Product_Update', 'Product_Destroy', 'Report_Create'
        ]);

        // asignar permisos al rol Cajero
        $cajero->givePermissionTo(['Pos_Create', 'Cashout_Create', 'Category_View', 'Category_Search', 'Product_View', 'Product_Search']);

        // asignar permisos al comprador
        $comprador->givePermissionTo(['Compras', 'Inventory', 'Workshop', 'Produccion']);

        // asignar permisos a produccion
        $produccion->givePermissionTo(['Produccion']);

        // asignar permisos a costos
        $costos->givePermissionTo(['Compras', 'Product_View', 'Product_Search', 'Traslados', 'Inventory']);

        // asignar permisos al vendedor
        $ventas->givePermissionTo(['Pos_Create', 'Cashout_Create', 'Category_View', 'Category_Search', 'Product_View', 'Product_Search']);

        // asignar permisos al usuario comercial o cajero, activa menu ventas y caja
        $comercial->givePermissionTo(['Pos_Create']);

        /************************ Asignar role Admin al usuario */
        /* $uAdmin = User::find(1);
        $uAdmin->assignRole('Admin'); */

        User::find(1)->assignRole('Admin');
        User::find(2)->assignRole('Admin');
        User::find(3)->assignRole('Admin');
        User::find(4)->assignRole('Admin');
        User::find(5)->assignRole('Admin');
        User::find(6)->assignRole('Comprador');
        User::find(7)->assignRole('Produccion');
        User::find(8)->assignRole('Costos');
        User::find(9)->assignRole('Tesoreria');
        User::find(10)->assignRole('Comercial');
        User::find(11)->assignRole('Comercial');
        User::find(12)->assignRole('Comercial');
        
    }
}
