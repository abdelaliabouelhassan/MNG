<?php

use App\Http\Controllers\GeneratePdfController;
use Illuminate\Support\Facades\Route;


Route::post('/generate-horizontal-pdf', [GeneratePdfController::class, 'generateHorizontalPdf']);
Route::post('/generate-vertical-pdf', [GeneratePdfController::class, 'generateVerticalPdf']);
Route::post('/getData', [GeneratePdfController::class, 'getData']);
Route::get('/', [GeneratePdfController::class, 'index']);
