<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Inertia\Inertia;

class GeneratePdfController extends Controller
{
    //


    public function index()
    {
        $logos = Logo::all();
        return Inertia::render('Welcome', [
            'title' => 'title',
            'logos' => $logos
        ]);
    }

    public function generateHorizontalPdf(Request $request)
    {
        if ($request->logo) {
            $logo = Logo::findOrFail($request->logo);
        } else {
            $logo = Logo::first();
        }
        return Pdf::view('horizontalPdf', compact('request', 'logo'))
            ->landscape()
            ->margins(0, 0, 0, 0)
            ->paperSize(80.4, 200, 'mm')
            ->name('invoice-2023-04-10.pdf')
            ->download();
    }
    public function generateVerticalPdf(Request $request)
    {
        if ($request->logo) {
            $logo = Logo::findOrFail($request->logo);
        } else {
            $logo = Logo::first();
        }
        return Pdf::view('verticalPdf', compact('request', 'logo'))
            ->landscape()
            ->margins(0, 0, 0, 0)
            ->paperSize(76.9, 200, 'mm')
            ->name('invoice-2023-04-10.pdf')
            ->download();
    }
}
