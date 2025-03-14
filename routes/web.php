<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [CrudController::class, "index"])->name("crud.index");

Route::prefix("llantas")->group(function () {
    Route::post("/guardar", [CrudController::class, "store"])->name("llantas.guardar");
    Route::put("/editar/{id}", [CrudController::class, "update"])->name("llantas.editar");
    Route::delete("/eliminar/{id}", [CrudController::class, "destroy"])->name("llantas.eliminar");

    Route::get("/eliminadas", [CrudController::class, "eliminadas"])->name("llantas.eliminadas");
    Route::post("/restaurar/{id}", [CrudController::class, "restaurar"])->name("llantas.restaurar");

    Route::get('/llantas/buscar', [CrudController::class, 'buscar'])->name('llantas.buscar');
});
