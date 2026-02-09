<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;

Route::post('/organizations', [OrganizationController::class, 'store']);
Route::get('/organizations/{name}/relations', [OrganizationController::class, 'relations']);
