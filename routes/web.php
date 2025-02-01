<?php

use App\Http\Controllers\GeneratePdfController;
use App\Http\Controllers\ProfileController;
use App\Spiders\MNGSpider;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use RoachPHP\Roach;
use Spatie\LaravelPdf\Facades\Pdf;
use RoachPHP\Spider\Configuration\Overrides;

Route::get('/test', function () {
    $url = 'https://lims.tagleaf.com/coas/5nAkrgJ7iQh1ef77y4dBMBOx5rUGFiHemNmWC8yeFOXtvQGnQ9';
    $overrides = new Overrides(
        startUrls: [$url]
    );
    $results = Roach::collectSpider(MNGSpider::class, $overrides);
    dd($results);
});

Route::post('/generate-horizontal-pdf', [GeneratePdfController::class, 'generateHorizontalPdf']);
Route::post('/generate-vertical-pdf', [GeneratePdfController::class, 'generateVerticalPdf']);
Route::post('/getData', [GeneratePdfController::class, 'getData']);
Route::get('/', [GeneratePdfController::class, 'index']);
