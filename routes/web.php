<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterCategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/', MasterCategoryController::class);
