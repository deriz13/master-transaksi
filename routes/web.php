<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterCategoryController;
use App\Http\Controllers\MasterChartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard.index');
Route::get('/',[MasterCategoryController::class,'index']);

Route::get('master/category',[MasterCategoryController::class,'index'])->name('master_category.index');
Route::get('master/category/create',[MasterCategoryController::class,'create'])->name('master_category.create');
Route::post('master/category/create',[MasterCategoryController::class,'store'])->name('master_category.store');
Route::get('master/category/edit/{id}',[MasterCategoryController::class,'edit'])->name('master_category.edit');
Route::put('master/category/edit/{id}', [MasterCategoryController::class, 'update'])->name('master_category.update');
Route::delete('master/category/delete/{id}', [MasterCategoryController::class, 'destroy'])->name('master_category.destroy');

Route::get('master/chart',[MasterChartController::class,'index'])->name('master_chart.index');
Route::get('master/chart/create',[MasterChartController::class,'create'])->name('master_chart.create');
Route::post('master/chart/create',[MasterChartController::class,'store'])->name('master_chart.store');
Route::get('master/chart/edit/{id}',[MasterChartController::class,'edit'])->name('master_chart.edit');
Route::put('master/chart/edit/{id}', [MasterChartController::class, 'update'])->name('master_chart.update');
Route::delete('master/chart/delete/{id}', [MasterChartController::class, 'destroy'])->name('master_chart.destroy');

Route::get('transaction',[TransactionController::class,'index'])->name('transaction.index');
Route::get('transaction/create',[TransactionController::class,'create'])->name('transaction.create');
Route::post('transaction/create',[TransactionController::class,'store'])->name('transaction.store');
Route::get('transaction/edit/{id}',[TransactionController::class,'edit'])->name('transaction.edit');
Route::put('transaction/edit/{id}', [TransactionController::class, 'update'])->name('transaction.update');
Route::delete('transaction/delete/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');

Route::get('report',[ReportController::class,'index'])->name('report.index');


