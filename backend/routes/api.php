<?php

use App\Http\Controllers\PricingController;
use Illuminate\Support\Facades\Route;

Route::get('/pricing-config', [PricingController::class, 'config']);
Route::post('/pricing-calculate', [PricingController::class, 'calculate']);
