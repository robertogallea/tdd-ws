<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post(
    '/convert',
    '\App\Http\Controllers\ConversionController'
);
