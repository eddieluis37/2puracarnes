<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\BeneficiocerdosController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\TodosController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\BeneficiopollosController;
//use App\Http\Livewire\BeneficioresController;
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
use App\Http\Livewire\ReportsController;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\Select2;
use App\Http\Livewire\ThirdsController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\Desposte\Desposteres\DesposteresController;
use Illuminate\Support\Facades\Route;

/*************** SIN LIVWWIRE **********************/
use App\Http\Controllers\res\desposteresrogercodeController;
use App\Http\Controllers\res\beneficioresrogercodeController;
use App\Http\Controllers\cerdo\despostecerdoController;
use App\Http\Controllers\cerdo\beneficiocerdoController;
use App\Http\Controllers\inventory\inventoryrogercodeController;
use App\Http\Controllers\inventory\diariorogercodeController;
use App\Http\Controllers\inventory\mensualrogercodeController;
use App\Http\Controllers\compensado\resrogercodeController;
use App\Http\Controllers\compensado\compensadorogercodeController;
use App\Http\Controllers\alistamiento\alistamientorogercodeController;
use App\Http\Controllers\aves\beneficioavesrogercodeController;
use App\Http\Controllers\aves\desposteavesrogercodeController;

use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\transfer\TransferController;

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

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', Dash::class);


Route::get('/libros', function () {
    // return view('welcome');
    return view('book');
});

Route::resource('books', BooksController::class);
//Route::resource('beneficiocerdos', BeneficiocerdosController::class);

Route::group(['middleware'=> [('auth')]], function () {

   //Route::get('categories', CategoriesController::class)->middleware('role:Cajero');
   //Route::get('categories', CategoriesController::class)->middleware('role:Admin');


	Route::get('categories', CategoriesController::class)->name('categories');
	Route::get('users', UsersController::class);       
    Route::get('roles', RolesController::class);
    Route::get('permisos', PermisosController::class);
    Route::get('asignar', AsignarController::class);
    Route::get('products', ProductsController::class);
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

    /************ Beneficiores **************/
    //Route::get('get_plantasacrificio_by_id', [BeneficioresController::class, 'get_plantasacrificio_by_id'])->name('get_plantasacrificio_by_id');
    //Route::post('store', [BeneficioresController::class, 'store'])->name('store');
    //Route::get('/edit/{id}', [BeneficioresController::class, 'edit'])->name('edit');

    //Route::get('get_plantasacrificiopollo_by_id', [BeneficiopollosController::class, 'get_plantasacrificiopollo_by_id'])->name('get_plantasacrificiopollo_by_id');


    Route::post('storepollo', [BeneficiopollosController::class, 'storepollo'])->name('storepollo');

    Route::post('storem', [DesposterController::class, 'storem'])->name('storem');



    //Route::post('citywithstatecountry', [CityController::class, 'citywithstatecountry'])->name('citywithstatecountry');
  
    
    Route::get('todos', TodosController::class . '@index')->name('todos'); 

    Route::post('todos', TodosController::class . '@store');

    Route::get('/todos/{id}', [TodosController::class , 'show'])->name('todos-edit');

    Route::patch('/todos/{id}', [TodosController::class , 'update'])->name('todos-update');

    Route::delete('/todos/{id}', [TodosController::class , 'destroy'])->name('todos-destroy');
    
});

//Route::get('/tareas', function () {
  //  return view('todos.index');     })->name('todos');
      




require __DIR__ . '/admin.php';



Route::get('conte', Component1::class);
Route::get('conte2', function () {
    return view('contenedor');
});



//rutas utils
Route::get('select2', Select2::class);


/***************** RUTAS SIN LIVEWIRE ********************************** */
/**DESPOSTE RES */
Route::get('desposteres', [desposteresrogercodeController::class, 'index'])->name('desposteres.index');
Route::get('desposteres/{id}', [desposteresrogercodeController::class, 'create']);
Route::post('/desposteresUpdate', [desposteresrogercodeController::class, 'update']);
Route::post('/downdesposter', [desposteresrogercodeController::class, 'destroy']);

/**DESPOSTE CERDO */
Route::get('despostecerdo', [despostecerdoController::class, 'index'])->name('despostecerdo.index');
Route::get('despostecerdo/{id}', [despostecerdoController::class, 'create']);
Route::post('/despostecerdoUpdate', [despostecerdoController::class, 'update']);
Route::post('/downdespostec', [despostecerdoController::class, 'destroy']);
/*****************************INVENTORY****************************************** */
Route::get('inventory/consolidado', [inventoryrogercodeController::class, 'index'])->name('inventory.consolidado');
Route::get('inventory/diario', [diariorogercodeController::class, 'index'])->name('inventory.diario');
Route::get('inventory/mensual', [mensualrogercodeController::class, 'index'])->name('inventory.mensual');

Route::get('compensado', [compensadorogercodeController::class,'index'])->name('compensado.index');
Route::get('compensado/create/{id}', [compensadorogercodeController::class,'create'])->name('compensado.create');
Route::get('showlistcompensado', [compensadorogercodeController::class,'show'])->name('compensado.showlist');
Route::post('getproductos', [compensadorogercodeController::class,'getproducts'])->name('compensado.getproductos');
Route::post('compensadosave', [compensadorogercodeController::class,'store'])->name('compensado.save');
Route::post('compensadosavedetail', [compensadorogercodeController::class,'savedetail'])->name('compensado.savedetail');
Route::post('compensadodown', [compensadorogercodeController::class,'destroy'])->name('compensado.down');
Route::post('compensadogetById', [compensadorogercodeController::class,'edit'])->name('compensado.ById');
Route::post('compensadoById', [compensadorogercodeController::class,'editCompensado'])->name('compensado.editCompensado');
Route::post('/downmaincompensado', [compensadorogercodeController::class, 'destroyCompensado'])->name('compensado.downCompensado');
/**BENEFICIO RES */
Route::get('beneficiores', [beneficioresrogercodeController::class,'index'])->name('beneficiores.index');
Route::get('showbeneficiores', [beneficioresrogercodeController::class,'show'])->name('beneficiores.showlist');
Route::get('get_plantasacrificio_by_id', [beneficioresrogercodeController::class, 'get_plantasacrificio_by_id'])->name('get_plantasacrificio_by_id');
Route::post('savebeneficiores', [beneficioresrogercodeController::class, 'store'])->name('beneficiores.save');
Route::get('/edit/{id}', [beneficioresrogercodeController::class, 'edit'])->name('beneficiores.edit');
Route::get('downbeneficiores/{id}', [beneficioresrogercodeController::class, 'destroy'])->name('beneficiores.destroy');

/**BENEFICIO CERDO */
Route::get('beneficiocerdo', [beneficiocerdoController::class,'index'])->name('beneficiocerdo.index');
Route::get('showbeneficiocerdo', [beneficiocerdoController::class,'show'])->name('beneficiocerdo.showlist');
Route::get('get_plantasacrificiocerdo_by_id', [beneficiocerdoController::class, 'get_plantasacrificiocerdo_by_id'])->name('get_plantasacrificiocerdo_by_id');
Route::post('savebeneficiocerdo', [beneficiocerdoController::class, 'store'])->name('beneficiocerdo.save');
Route::get('/beneficiocerdoedit/{id}', [beneficiocerdoController::class, 'edit'])->name('beneficiocerdo.edit');
Route::get('downbeneficiocerdo/{id}', [beneficiocerdoController::class, 'destroy'])->name('beneficiocerdo.destroy');

/**ALISTAMIENTO*/
Route::get('alistamiento', [alistamientorogercodeController::class,'index'])->name('alistamiento.index');
Route::post('alistamientosave', [alistamientorogercodeController::class,'store'])->name('alistamiento.save');
Route::get('showalistamiento', [alistamientorogercodeController::class,'show'])->name('alistamiento.showlist');
Route::get('alistamiento/create/{id}', [alistamientorogercodeController::class,'create'])->name('alistamiento.create');
Route::post('getproductos', [alistamientorogercodeController::class,'getproducts'])->name('alistamiento.getproductos');
Route::post('alistamientosavedetail', [alistamientorogercodeController::class,'savedetail'])->name('alistamiento.savedetail');
Route::post('/alistamientoUpdate', [alistamientorogercodeController::class, 'updatedetail'])->name('alistamiento.update');
Route::post('alistamientodown', [alistamientorogercodeController::class,'destroy'])->name('alistamiento.down');
Route::post('alistamientoById', [alistamientorogercodeController::class,'editAlistamiento'])->name('alistamiento.edit');
Route::post('getproductospadre', [alistamientorogercodeController::class,'getProductsCategoryPadre'])->name('alistamiento.getproductospadre');
Route::post('/downmmainalistamiento', [alistamientorogercodeController::class, 'destroyAlistamiento'])->name('alistamiento.downAlistamiento');
Route::post('/downmmainalistamiento', [alistamientorogercodeController::class, 'destroyAlistamiento'])->name('alistamiento.downAlistamiento');
Route::post('alistamientoAddShoping', [alistamientorogercodeController::class,'add_shopping'])->name('alistamiento.addShopping');

/***** BENEFICIO AVES******** */
Route::get('beneficioaves', [beneficioavesrogercodeController::class,'index'])->name('beneficioaves.index');
Route::get('get_plantasacrificiopollo_by_id', [beneficioavesrogercodeController::class, 'get_plantasacrificiopollo_by_id'])->name('get_plantasacrificiopollo_by_id');
Route::post('savebeneficioaves', [beneficioavesrogercodeController::class, 'store'])->name('beneficioaves.save');
Route::get('showbeneficioaves', [beneficioavesrogercodeController::class,'show'])->name('beneficioaves.showlist');
Route::get('/beneficioavesedit/{id}', [beneficioavesrogercodeController::class, 'edit'])->name('beneficioaves.edit');

Route::get('desposteaves/{id}', [desposteavesrogercodeController::class, 'create'])->name('desposteaves.create');
Route::post('/desposteavesUpdate', [desposteavesrogercodeController::class, 'update'])->name('desposteaves.update');
Route::post('/downdesposteave', [desposteavesrogercodeController::class, 'destroy'])->name('desposteaves.destroy');

/***** TRANSFER ******** */
Route::get('transfer', [TransferController::class, 'index'])->name('transfer.index');
Route::post('transfersave', [TransferController::class, 'store'])->name('transfer.store');
Route::get('showtransfer', [TransferController::class,'show'])->name('transfer.showlist');
Route::get('transfer/create/{id}', [TransferController::class,'create'])->name('transfer.create');

Route::post('getproductos', [TransferController::class,'getproducts'])->name('transfer.getproductos');
Route::post('transfersavedetail', [TransferController::class,'savedetail'])->name('transfer.savedetail');
Route::post('/transferUpdate', [TransferController::class, 'updatedetail'])->name('transfer.update');
Route::post('transferdown', [TransferController::class,'destroy'])->name('transfer.down');
Route::post('transferById', [TransferController::class,'editTranfer'])->name('transfer.edit');
Route::post('getproductospadreandhijo', [TransferController::class,'getMeatcutAndProducts'])->name('transfer.getproductospadreandhijo');
Route::post('/downmmaintransfer', [TransferController::class, 'destroyTransfer'])->name('transfer.downAlistamiento');
Route::post('/downmmaintransfer', [TransferController::class, 'destroyTransfer'])->name('transfer.downAlistamiento');
Route::post('transferAddShoping', [TransferController::class,'add_shopping'])->name('transfer.addShopping');
