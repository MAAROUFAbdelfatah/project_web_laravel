<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncadrantsController;
use App\Http\Controllers;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('admin/encadrants', App\Http\Controllers\EncadrantsController::class);
Route::resource('admin/coencadrants', App\Http\Controllers\CoencadrantsController::class);
Route::resource('admin/etudiants', App\Http\Controllers\EtudiantsController::class);
Route::resource('admin/equipes', App\Http\Controllers\EquipesController::class);
Route::get('admin/equipes/{id}/members/create', [App\Http\Controllers\EquipesController::class, 'addMember'])->name('equipes.members.create');
Route::delete('admin/equipes/{equipe}/members/{id}', [App\Http\Controllers\EquipesController::class, 'deleteMember'])->name('equipes.members.destroy');
Route::post('admin/equipes/members', [App\Http\Controllers\EquipesController::class, 'storeMember'])->name('equipes.members.store');
Route::resource('admin/busniess_plans', App\Http\Controllers\BusniessPlansController::class);
Route::resource('admin/busniess_plans/{id}/taches',  App\Http\Controllers\TachesController::class);
Route::resource('admin/articles', App\Http\Controllers\ArticlesController::class);
Route::put('admin/busniess_plans/valide/{id}', [App\Http\Controllers\BusniessPlansController::class, 'valide'])->name('busniess_plans.valide');
Route::resource('admin/projects', App\Http\Controllers\ProjectsController::class);
Route::resource('admin/projects/{id}/taches',  App\Http\Controllers\TachesController::class, [
    'names' => [
        'index' => 'projects_taches.index',
        'edit' => 'projects_taches.edit',
        'create' => 'projects_taches.create',
        'store' => 'projects_taches.store',
        'show' => 'projects_taches.show',
        'destroy' => 'projects_taches.destroy',
        'update' => 'projects_taches.update'
    ]]);

Route::get('/', [App\Http\Controllers\GestsController::class, 'index']);