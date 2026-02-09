<?php

use App\Http\Controllers\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::post('/api/organizations', [OrganizationController::class, 'store']);
//Route::get('/api/organizations/{name}/relations', [OrganizationController::class, 'relations']);
