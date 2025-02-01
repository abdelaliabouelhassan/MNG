<?php

use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\ProfileController;
use App\Spiders\MNGSpider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use RoachPHP\Roach;
use Spatie\LaravelPdf\Facades\Pdf;

Route::get('/test', function () {
    $results = Roach::collectSpider(MNGSpider::class);
    dd($results);
});

Route::post('/generate-horizontal-pdf', [GeneratePdfController::class, 'generateHorizontalPdf']);
Route::post('/generate-vertical-pdf', [GeneratePdfController::class, 'generateVerticalPdf']);
Route::get('/', [GeneratePdfController::class, 'index']);
