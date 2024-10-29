<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterChartController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[MasterCategoryController::class,'index']);
Route::get('master/category',[MasterCategoryController::class,'index'])->name('master_category.index');
Route::get('master/category/create',[MasterCategoryController::class,'create'])->name('master_category.create');
Route::post('master/category/create',[MasterCategoryController::class,'store'])->name('master_category.store');
Route::get('master/category/edit/{id}',[MasterCategoryController::class,'edit'])->name('master_category.edit');
Route::put('master/category/edit/{id}', [MasterCategoryController::class, 'update'])->name('master_category.update');
Route::delete('master/category/delete/{id}', [MasterCategoryController::class, 'destroy'])->name('master_category.destroy');
Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard.index');
Route::resource('master/chart', MasterChartController::class);