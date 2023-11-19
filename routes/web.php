<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\TodosController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\BeneficiopollosController;
use App\Http\Livewire\CashoutController;
use App\Http\Livewire\CategoriesController;
use App\Http\Livewire\CoinsController;
use App\Http\Livewire\Component1;
use App\Http\Livewire\Dash;
use App\Http\Livewire\DesposterController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\PosController;
use App\Http\Livewire\PrecioAgreementsController;
use App\Http\Livewire\ProductsController;
use App\Http\Livewire\MeatcutsController;
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\Select2;
use App\Http\Livewire\ThirdsController;
use App\Http\Livewire\UsersController;
use Illuminate\Support\Facades\Route;

/*************** SIN LIVWWIRE **********************/

use App\Http\Controllers\res\desposteresController;
use App\Http\Controllers\res\beneficioresController;
use App\Http\Controllers\cerdo\despostecerdoController;
use App\Http\Controllers\cerdo\beneficiocerdoController;

use App\Http\Controllers\FormapagoController;
use App\Http\Controllers\ParametrocontableController;
use App\Http\Controllers\sale\saleController;

use App\Http\Controllers\compensado\compensadoController;
use App\Http\Controllers\alistamiento\alistamientoController;
use App\Http\Controllers\aves\beneficioavesController;
use App\Http\Controllers\aves\desposteavesController;
use App\Http\Controllers\inventory\CargarVentasController;
use App\Http\Controllers\inventory\CentroCostoProductController;
use App\Http\Controllers\CentroCostoProdController;
use App\Http\Controllers\AsignarPreciosProdController;
use App\Http\Controllers\faster\fasterController;
use App\Http\Controllers\transfer\TransferController;
use App\Http\Controllers\workshop\workshopController;

use App\Http\Controllers\costo\costoController;
use App\Http\Controllers\DragDropController;
use App\Http\Controllers\inventory\inventoryController;
use App\Http\Controllers\inventory\diaryController;
use App\Http\Controllers\inventory\mensualController;
use App\Http\Controllers\listaprecio\listaPrecioController;

use App\Http\Controllers\ReportController;

use App\Http\Controllers\ImportStockFisicoController;


/************************************************* */

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});

//Route::get('/post/{post}', 'HomeController@post')->name('post');
Route::get('/post/{post}', [HomeController::class, 'post'])->name('post');

//Route::get('/admin/posts', 'Admin\PostsController@index')->name('admin.posts.index');
Route::get('/admin/posts', [App\Http\Controllers\Admin\PostsController::class, 'index'])->name('admin.posts.index');

//Route::post('/admin/posts/store', 'Admin\PostsController@store')->name('admin.posts.store');
Route::post('/admin/posts/store', [App\Http\Controllers\Admin\PostsController::class, 'store'])->name('admin.posts.store');


//Route::post('/admin/posts/{postId}/update', 'Admin\PostsController@update')->name('admin.posts.update');
Route::post('/admin/posts{postId}/update', [App\Http\Controllers\Admin\PostsController::class, 'update'])->name('admin.posts.update');

//Route::delete('/admin/posts/{postId}/delete', 'Admin\PostsController@delete')->name('admin.posts.delete');
Route::delete('/admin/posts{postId}/delete', [App\Http\Controllers\Admin\PostsController::class, 'delete'])->name('admin.posts.delete');

Route::get('/', function () {
    return view('auth.login');
});

Route::get('prueba', function () {
    return view('livewire.beneficiores.prueba');
});

//Auth::routes();

Auth::routes(['register' => false]); // deshabilitamos el registro de nuevos users

Route::get('/home', Dash::class);


Route::get('/libros', function () {
    // return view('welcome');
    return view('book');
});

Route::resource('books', BooksController::class);
//Route::resource('beneficiocerdos', BeneficiocerdosController::class);

Route::group(['middleware' => [('auth')]], function () {

    Route::get('categories', CategoriesController::class)->name('categories');
    Route::get('users', UsersController::class);
    Route::get('roles', RolesController::class);
    Route::get('permisos', PermisosController::class);
    Route::get('asignar', AsignarController::class);
    Route::get('products', ProductsController::class);
    Route::get('meatcuts', MeatcutsController::class);
    Route::get('pos', PosController::class);
    Route::get('coins', CoinsController::class);
    Route::get('reports', ReportsController::class);
    Route::get('cashout', CashoutController::class);
    Route::get('dash', Dash::class)->name('dash');
    Route::get('thirds', ThirdsController::class);
    Route::get('precio_agreements', PrecioAgreementsController::class);
    //Route::get('beneficiores', BeneficioresController::class);
    Route::get('beneficiopollos', BeneficiopollosController::class);
    //Route::get('desposteres/{id}', DesposteresController::class);

    /**beneficiores*/
    Route::resource('desposter', DesposterController::class);

    /*desposteres* */
    Route::post('desposteresAdd', [DesposteresController::class, 'store']);
    Route::get('getdesposter/{id}', [DesposteresController::class, 'getdesposter']);
    Route::get('downdesposter/{id}/{beneficioId}', [DesposteresController::class, 'destroy']);

    //reportes PDF
    Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
    Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);


    //reportes EXCEL
    Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reporteExcel']);
    Route::get('report/excel/{user}/{type}', [ExportController::class, 'reporteExcel']);


    Route::post('storepollo', [BeneficiopollosController::class, 'storepollo'])->name('storepollo');

    Route::post('storem', [DesposterController::class, 'storem'])->name('storem');



    //Route::post('citywithstatecountry', [CityController::class, 'citywithstatecountry'])->name('citywithstatecountry');


    Route::get('todos', TodosController::class . '@index')->name('todos');

    Route::post('todos', TodosController::class . '@store');

    Route::get('/todos/{id}', [TodosController::class, 'show'])->name('todos-edit');

    Route::patch('/todos/{id}', [TodosController::class, 'update'])->name('todos-update');

    Route::delete('/todos/{id}', [TodosController::class, 'destroy'])->name('todos-destroy');

    /************************* RUTAS SIN LIVEWIRE ********************************** */
    Route::get('centro_costo_prod', [CentroCostoProdController::class, 'index'])->name('ccpShow');
    Route::get('showCcpSwitch', [CentroCostoProdController::class, 'show'])->name('showCcpSwitch');
    Route::post('/updateCcpSwitch', [CentroCostoProdController::class, 'updateCcpSwitch'])->name('updateCcpSwitch');
   
    /************************* RUTAS ASIGNAR PRECIOS A PRODUCTOS ********************************** */
    Route::get('asignar_precios_prod', [AsignarPreciosProdController::class, 'index'])->name('APPShow');
    Route::get('showAPPSwitch', [AsignarPreciosProdController::class, 'show'])->name('showAPPSwitch');
    Route::post('/updateAPPSwitch', [AsignarPreciosProdController::class, 'updateAPPSwitch'])->name('updateAPPSwitch');

    /*****************************INVENTORY****************************************** */
    Route::get('inventory/diary', [diaryController::class, 'index'])->name('inventory.diary');
    Route::get('inventory/consolidado', [inventoryController::class, 'index'])->name('inventory.consolidado');
    Route::get('showinventory', [diaryController::class, 'show'])->name('inventory.showlist');
    //Route::post('showinventory', [diaryController::class,'show'])->name('inventory.showinvent');
    Route::get('inventory/mensual', [mensualController::class, 'index'])->name('inventory.mensual');

    Route::get('inventory/centro_costo_products', [CentroCostoProductController::class, 'index'])->name('inventory.showccp');
   
    Route::get('showCcpInventory', [CentroCostoProductController::class, 'show'])->name('inventory.show-ccp');
    Route::get('showConsolidadoInventory', [inventoryController::class, 'show'])->name('inventory.showConsol');

    Route::get('totales', [inventoryController::class, 'totales'])->name('inventory.totales');

    Route::post('cargarInventariohist', [inventoryController::class, 'cargarInventariohist'])->name('cargarInventariohist');
    Route::post('/updateCcpInventory', [CentroCostoProductController::class, 'updateCcpInventory'])->name('inventory.updateCcpInventory999');

    Route::get('inventory/showhistorico', [inventoryController::class, 'showhistorico'])->name('inventory.showhistorico');
    Route::get('inventory/consolidado_historico', [inventoryController::class, 'indexhistorico'])->name('inventory.consolidadohistorico');
    Route::get('totaleshist', [inventoryController::class, 'totaleshist'])->name('inventory.totaleshist');
    //Route::post('/updateCcpInventory', 'CentroCostoProductController@updateCcpInventory')->name('updateCcpInventory');

    /*****************************CARGAR-VENTAS*******************************************/
    Route::get('inventory/cargar_ventas', [CargarVentasController::class, 'index'])->name('inventory.showcvc');
    Route::get('showCargarVentasInv', [CargarVentasController::class, 'show'])->name('inventory.showCargarVentas');
    Route::post('/updateCVInv', [CargarVentasController::class, 'updateCVInv'])->name('inventory.updateCVInv');
    

    /*****************************BENEFICIO-RES*******************************************/
    Route::get('beneficiores', [beneficioresController::class, 'index'])->name('beneficiores.index');
    Route::get('showbeneficiores', [beneficioresController::class, 'show'])->name('beneficiores.showlist');
    Route::get('get_plantasacrificio_by_id', [beneficioresController::class, 'get_plantasacrificio_by_id'])->name('get_plantasacrificio_by_id');
    Route::post('savebeneficiores', [beneficioresController::class, 'store'])->name('beneficiores.save');
    Route::get('/edit/{id}', [beneficioresController::class, 'edit'])->name('beneficiores.edit');
    Route::get('downbeneficiores/{id}', [beneficioresController::class, 'destroy'])->name('beneficiores.destroy');



    /*****************************DESPOSTE-RES******************************************/
    Route::get('desposteres', [desposteresController::class, 'index'])->name('desposteres.index');
    Route::get('desposteres/{id}', [desposteresController::class, 'create']);
    Route::post('/desposteresUpdate', [desposteresController::class, 'update']);
    Route::post('/downdesposter', [desposteresController::class, 'destroy']);
    Route::post('cargarInventario', [desposteresController::class, 'cargarInventario'])->name('desposteres.show');

    /*****************************DESPOSTE-CERDO******************************************/
    Route::get('despostecerdo', [despostecerdoController::class, 'index'])->name('despostecerdo.index');
    Route::get('despostecerdo/{id}', [despostecerdoController::class, 'create']);
    Route::post('/despostecerdoUpdate', [despostecerdoController::class, 'update']);
    Route::post('/downdespostec', [despostecerdoController::class, 'destroy']);
    Route::post('cargarInventarioc', [despostecerdoController::class, 'cargarInventariocerdo'])->name('despostecerdo.show');

    /*****************************COMPRAS-COMPENSADOS****************************************** */
    Route::get('compensado', [compensadoController::class, 'index'])->name('compensado.index');
    Route::get('compensado/create/{id}', [compensadoController::class, 'create'])->name('compensado.create');
    Route::get('showlistcompensado', [compensadoController::class, 'show'])->name('compensado.showlist');
    Route::post('getproductos', [compensadoController::class, 'getproducts'])->name('compensado.getproductos');
    Route::post('compensadosave', [compensadoController::class, 'store'])->name('compensado.save');
    Route::post('compensadosavedetail', [compensadoController::class, 'savedetail'])->name('compensado.savedetail');
    Route::post('compensadodown', [compensadoController::class, 'destroy'])->name('compensado.down');
    Route::post('compensadogetById', [compensadoController::class, 'edit'])->name('compensado.ById');
    Route::post('compensadoById', [compensadoController::class, 'editCompensado'])->name('compensado.editCompensado');
    Route::post('/downmaincompensado', [compensadoController::class, 'destroyCompensado'])->name('compensado.downCompensado');
    Route::post('compensadoInvres', [compensadoController::class, 'cargarInventariocr'])->name('compensado.cargarInventariocr');

    /**BENEFICIO CERDO */
    Route::get('beneficiocerdo', [beneficiocerdoController::class, 'index'])->name('beneficiocerdo.index');
    Route::get('showbeneficiocerdo', [beneficiocerdoController::class, 'show'])->name('beneficiocerdo.showlist');
    Route::get('get_plantasacrificiocerdo_by_id', [beneficiocerdoController::class, 'get_plantasacrificiocerdo_by_id'])->name('get_plantasacrificiocerdo_by_id');
    Route::post('savebeneficiocerdo', [beneficiocerdoController::class, 'store'])->name('beneficiocerdo.save');
    Route::get('/beneficiocerdoedit/{id}', [beneficiocerdoController::class, 'edit'])->name('beneficiocerdo.edit');
    Route::get('downbeneficiocerdo/{id}', [beneficiocerdoController::class, 'destroy'])->name('beneficiocerdo.destroy');

    /***** BENEFICIO AVES******** */
    Route::get('beneficioaves', [beneficioavesController::class, 'index'])->name('beneficioaves.index');
    Route::get('get_plantasacrificiopollo_by_id', [beneficioavesController::class, 'get_plantasacrificiopollo_by_id'])->name('get_plantasacrificiopollo_by_id');
    Route::post('savebeneficioaves', [beneficioavesController::class, 'store'])->name('beneficioaves.save');
    Route::get('showbeneficioaves', [beneficioavesController::class, 'show'])->name('beneficioaves.showlist');
    Route::get('/beneficioavesedit/{id}', [beneficioavesController::class, 'edit'])->name('beneficioaves.edit');

    Route::get('desposteaves/{id}', [desposteavesController::class, 'create'])->name('desposteaves.create');
    Route::post('/desposteavesUpdate', [desposteavesController::class, 'update'])->name('desposteaves.update');
    Route::post('/downdesposteave', [desposteavesController::class, 'destroy'])->name('desposteaves.destroy');

    /**ALISTAMIENTO*/
    Route::get('alistamiento', [alistamientoController::class, 'index'])->name('alistamiento.index');
    Route::post('alistamientosave', [alistamientoController::class, 'store'])->name('alistamiento.save');
    Route::get('showalistamiento', [alistamientoController::class, 'show'])->name('alistamiento.showlist');
    Route::get('alistamiento/create/{id}', [alistamientoController::class, 'create'])->name('alistamiento.create');
    Route::post('getproductos', [alistamientoController::class, 'getproducts'])->name('alistamiento.getproductos');
    Route::post('alistamientosavedetail', [alistamientoController::class, 'savedetail'])->name('alistamiento.savedetail');
    Route::post('/alistamientoUpdate', [alistamientoController::class, 'updatedetail'])->name('alistamiento.update');
    Route::post('alistamientodown', [alistamientoController::class, 'destroy'])->name('alistamiento.down');
    Route::post('alistamientoById', [alistamientoController::class, 'editAlistamiento'])->name('alistamiento.edit');
    Route::post('getproductospadre', [alistamientoController::class, 'getProductsCategoryPadre'])->name('alistamiento.getproductospadre');
    Route::post('/downmmainalistamiento', [alistamientoController::class, 'destroyAlistamiento'])->name('alistamiento.downAlistamiento');
    Route::post('/downmmainalistamiento', [alistamientoController::class, 'destroyAlistamiento'])->name('alistamiento.downAlistamiento');
    Route::post('alistamientoAddShoping', [alistamientoController::class, 'add_shopping'])->name('alistamiento.addShopping');

    /** TALLER ***/
    Route::get('workshop', [workshopController::class, 'index'])->name('workshop.index');
    Route::post('workshopsave', [workshopController::class, 'store'])->name('workshop.save');
    Route::get('showworkshop', [workshopController::class, 'show'])->name('workshop.showlist');
    Route::get('workshop/create/{id}', [workshopController::class, 'create'])->name('workshop.create');
    Route::post('getproductos', [workshopController::class, 'getproducts'])->name('workshop.getproductos');
    Route::post('workshopsavedetail', [workshopController::class, 'savedetail'])->name('workshop.savedetail');
    Route::post('/workshopUpdate', [workshopController::class, 'updatedetail'])->name('workshop.update');
    Route::post('workshopdown', [workshopController::class, 'destroy'])->name('workshop.down');
    Route::post('workshopById', [workshopController::class, 'editWorkshop'])->name('workshop.edit');
    Route::post('getproductospadre', [workshopController::class, 'getProductsCategoryPadre'])->name('workshop.getproductospadre');
    Route::post('/downmmainworkshop', [workshopController::class, 'destroyWorkshop'])->name('workshop.downAlistamiento');
    Route::post('workshopAddShoping', [workshopController::class, 'add_shopping'])->name('workshop.addShopping');

    /***** TRANSFER ******** */
    Route::get('transfer', [transferController::class, 'index'])->name('transfer.index');
    Route::post('transfersave', [transferController::class, 'store'])->name('transfer.save');
    Route::get('showtransfer', [transferController::class, 'show'])->name('transfer.showlist');
    Route::get('transfer/create/{id}', [transferController::class, 'create'])->name('transfer.create');
    Route::post('getproductos', [transferController::class, 'getproducts'])->name('transfer.getproductos');
    Route::post('productsbycostcenterdest', [transferController::class, 'ProductsByCostcenterDest'])->name('transfer.productsbycostcenterdest');
    Route::post('getproductsbycostcenterorigin', [transferController::class, 'getProductsByCostcenterOrigin'])->name('transfer.getproductsbycostcenterorigin');

    Route::get('/obtener-valores-producto', [transferController::class, 'obtenerValoresProducto'])->name('transfer.obtener-valores-producto');
    Route::get('/obtener-valores-producto-destino', [transferController::class, 'obtenerValoresProductoDestino'])->name('transfer.obtener-valores-producto-destino');

    Route::post('transfersavedetail', [transferController::class, 'savedetail'])->name('transfer.savedetail');
    Route::post('/transferUpdate', [transferController::class, 'updatedetail'])->name('transfer.update');
    Route::post('transferdown', [transferController::class, 'destroy'])->name('transfer.down');
    Route::post('transferById', [transferController::class, 'editTransfer'])->name('transfer.edit');
    Route::post('productospadre', [transferController::class, 'getProductsCategoryPadre'])->name('transfer.productospadre');
    Route::post('/downmmaintransfer', [transferController::class, 'destroyTransfer'])->name('transfer.downAlistamiento');
    Route::post('transferAddShoping', [transferController::class, 'add_shopping'])->name('transfer.addShopping');

    /***** FASTER ******** */
    Route::get('faster', [fasterController::class, 'index'])->name('faster.index');
    Route::post('fastersave', [fasterController::class, 'store'])->name('faster.save');
    Route::get('showfaster', [fasterController::class, 'show'])->name('faster.showlist');
    Route::get('faster/create/{id}', [fasterController::class, 'create'])->name('faster.create');
    Route::post('getproductos', [fasterController::class, 'getproducts'])->name('faster.getproductos');
    Route::post('fastersavedetail', [fasterController::class, 'savedetail'])->name('faster.savedetail');
    Route::post('/fasterUpdate', [fasterController::class, 'updatedetail'])->name('faster.update');
    Route::post('fasterdown', [fasterController::class, 'destroy'])->name('faster.down');
    Route::post('fasterById', [fasterController::class, 'editFaster'])->name('faster.edit');
    Route::post('getproductospadre', [fasterController::class, 'getProductsCategoryPadre'])->name('faster.getproductospadre');
    Route::post('/downmmainfaster', [fasterController::class, 'destroyFaster'])->name('faster.downAlistamiento');
    Route::post('fasterAddShoping', [fasterController::class, 'add_shopping'])->name('faster.addShopping');

    /**COSTO*/
    Route::get('costo', [costoController::class, 'index'])->name('costo.index');
    Route::get('showcosto', [costoController::class, 'show'])->name('costo.showlist');
    Route::get('costo/create/{id}', [costoController::class, 'create'])->name('costo.create');


    /***** FORMAS DE PAGO ******** */
    Route::get('formapago', [FormapagoController::class, 'index'])->name('formapago.index');
    Route::post('formapagosave', [FormapagoController::class, 'store'])->name('formapago.save');
    Route::get('formapago{formapagoId}/delete', [FormapagoController::class, 'delete'])->name('formapago.delete');
    Route::get('formapago{formapagoId}/edit', [FormapagoController::class, 'edit'])->name('formapago.edit');
    Route::post('formapago/{formapagoId}', [FormapagoController::class, 'update'])->name('formapago.update');


    /***** PARAMETROS CONTABLES*********/
    Route::get('parametrocontable', [ParametrocontableController::class, 'index'])->name('parametrocontable.index');
    Route::post('parametrocontablesave', [ParametrocontableController::class, 'store'])->name('parametrocontable.save');
    Route::get('parametrocontable{parametrocontableId}/delete', [ParametrocontableController::class, 'delete'])->name('parametrocontable.delete');
    Route::get('parametrocontable{parametrocontableId}/edit', [ParametrocontableController::class, 'edit'])->name('parametrocontable.edit');
    Route::post('parametrocontable/{parametrocontableId}', [ParametrocontableController::class, 'update'])->name('parametrocontable.update');

    /*****************************VENTAS******************************************/

   // Route::get('sales', [SaleController::class, 'index'])->name('sale.index');
 //   Route::post('salesave', [SaleController::class, 'store'])->name('sale.save');
    Route::get('sale{saleId}/delete', [SaleController::class, 'delete'])->name('sale.delete');
    Route::get('sale{ventaId}/edit', [SaleController::class, 'edit'])->name('sale.edit');
    Route::post('sale/{ventaId}', [SaleController::class, 'update'])->name('sale.update');
    Route::get('sale/create/{id}', [SaleController::class, 'create'])->name('sale.create');
    Route::post('getproductosv', [SaleController::class, 'getproducts'])->name('sale.getproductos');
    //Route::post('salesavedetail', [SaleController::class, 'savedetail'])->name('sale.savedetail');

    Route::get('sale/registrar_pago/{id}', [SaleController::class, 'create_reg_pago'])->name('sale.registrar_pago');

    Route::get('sales', [saleController::class, 'index'])->name('sale.index');
    Route::get('showlistVentas', [saleController::class, 'show'])->name('sale.showlistVentas');
    Route::post('ventasave', [saleController::class, 'store'])->name('sale.save');
    Route::post('salesavedetail', [saleController::class, 'savedetail'])->name('sale.savedetail');
    Route::post('saleById', [saleController::class, 'editCompensado'])->name('sale.editCompensado');
    Route::post('ventadown', [saleController::class, 'destroy'])->name('sale.down');
    Route::post('/destroyVenta', [saleController::class, 'destroyVenta'])->name('sale.destroyVenta');

    Route::get('/obtener-precios-producto', [saleController::class, 'obtenerPreciosProducto'])->name('sale.obtener-precios-producto');

    /*****************************LISTA_DE_PRECIO******************************************/

    Route::get('lista_de_precio', [listaPrecioController::class, 'index'])->name('lista_de_precio.index');
    Route::get('showListaPrecio', [listaPrecioController::class, 'show'])->name('lista_de_precio.showListaPrecio');

    Route::post('lista_de_preciosave', [listaPrecioController::class, 'store'])->name('lista_de_precio.save');
    Route::get('lista_de_precio/create/{id}', [listaPrecioController::class, 'create'])->name('lista_de_precio.create');
    Route::get('lista_de_precio{lista_de_precioId}/delete', [listaPrecioController::class, 'delete'])->name('lista_de_precio.delete');
    Route::get('lista_de_precio{lista_de_precioId}/edit', [listaPrecioController::class, 'edit'])->name('lista_de_precio.edit');
    Route::post('lista_de_precio/{lista_de_precioId}', [listaPrecioController::class, 'update'])->name('lista_de_precio.update');

    Route::post('/drag-drop', [DragDropController::class, 'handleDragDrop'])->name('drag-drop.handleDragDrop');
    Route::get('/drag', [DragDropController::class, 'showDragView'])->name('drag.showDragView');

   // Route::get('/descargar-reporte', 'App\Http\Controllers\ReportController@downloadExcel');
    Route::get('/descargar-reporte', [ReportController::class, 'downloadExcel'])->name('descargar-reporte');

    Route::get('/import', [ImportStockFisicoController::class, 'import'])->name('import');

});

require __DIR__ . '/admin.php';

Route::get('conte', Component1::class);
Route::get('conte2', function () {
    return view('contenedor');
});

//rutas utils
Route::get('select2', Select2::class);


/* Route::view('/', 'welcome'); */
Route::view('/examples/basic', 'examples.basic');
Route::view('/examples/custom-component', 'examples.custom-component');
Route::view('/examples/as-form-input', 'examples.as-form-input');
Route::view('/examples/livewire', 'examples.livewire');
Route::view('/examples/livewire/drag-drop-multiple-targets', 'examples.livewire-drag-drop-multiple-targets');
Route::view('/examples/customization', 'examples.customization');
Route::view('/examples/drag-drop', 'examples.drag-drop');
Route::view('/examples/drag-drop-nested', 'examples.drag-drop-nested');
Route::view('/examples/disable-drop-sort', 'examples.disable-drop-sort');
