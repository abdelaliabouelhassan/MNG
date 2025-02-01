<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class GeneratePdfController extends Controller
{
    //

    public function generateHorizontalPdf(Request $request)
    {
        return Pdf::view('horizontalPdf', compact('request'))
            ->landscape()
            ->margins(0, 0, 0, 0)
            ->paperSize(80.4, 200, 'mm')
            ->name('invoice-2023-04-10.pdf')
            ->download();
    }
    public function generateVerticalPdf(Request $request)
    {
        return Pdf::view('verticalPdf', compact('request'))
            ->landscape()
            ->margins(0, 0, 0, 0)
            ->paperSize(76.9, 200, 'mm')
            ->name('invoice-2023-04-10.pdf')
            ->download();
    }
}
