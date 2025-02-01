<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use App\Spiders\MNGSpider;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Inertia\Inertia;
use RoachPHP\Roach;
use RoachPHP\Spider\Configuration\Overrides;

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


    public function getData(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->url;
        $overrides = new Overrides(
            startUrls: [$url]
        );
        $results = Roach::collectSpider(MNGSpider::class, $overrides);

        // Debug the transformation
        $data = collect($results)->map(function ($item) {
            return $item->all();
        })->values()->all();

        return response()->json($data);
    }
}
