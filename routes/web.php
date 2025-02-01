<?php

use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'title' => 'title',
    ]);
});

Route::post('/generate-horizontal-pdf', [GeneratePdfController::class, 'generateHorizontalPdf']);
Route::post('/generate-vertical-pdf', [GeneratePdfController::class, 'generateVerticalPdf']);
