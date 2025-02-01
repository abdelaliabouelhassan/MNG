<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class MNGSpider extends BasicSpider
{
    public array $startUrls = [
        'https://lims.tagleaf.com/coas/5nAkrgJ7iQh1ef77y4dBMBOx5rUGFiHemNmWC8yeFOXtvQGnQ9'
    ];

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $batchNo = $response
            ->filter('p:contains("Batch No.")')
            ->first();
        $batchNo = $batchNo->count() ? trim(preg_replace('/Batch No\.?\s*:/', '', $batchNo->text())) : null;

        $UID = $response
            ->filter('p:contains("Metrc UID")')
            ->first();
        $UID = $UID->count() ? trim(preg_replace('/Metrc UID\.?\s*:/', '', $UID->text())) : null;

        $name = $response
            ->filter('p.h5 span.text-semibold')
            ->first();
        $name = $name->count() ? $name->text() : null;

        $distro = $response
            ->filter('p.h5:contains("Client")')
            ->first();
        $distro = $distro->count() ? $distro->text() : null;

        // Extract client name safely
        if ($distro) {
            preg_match('/Client:\s*(.+)/i', $distro, $matches);
            $distro = $matches[1] ?? null;
        }

        $licenseText = $response
            ->filter('p.h6:contains("License")')
            ->first();
        $license = null;
        if ($licenseText->count()) {
            preg_match('/License\s*#:\s*([\w-]+)/i', $licenseText->text(), $matches);
            $license = $matches[1] ?? null;
        }

        $data = [
            'batch' => $batchNo,
            'UID' => $UID,
            'totalTHC' => null,
            'totalCBD' => null,
            'totalCannabinoids' => null,
            'sumOfCannabinoids' => null,
            'name' => $name,
            'distro' => $distro,
            'license' => $license
        ];

        $response->filter('.concentration-display')->each(function ($node) use (&$data) {
            $titleNode = $node->filter('p.h4.text-semibold');
            $title = $titleNode->count() ? $titleNode->text() : '';

            $valueNode = $node->filter('.row p.col-sm-4');
            $value = $valueNode->count() ? trim($valueNode->text()) : null;

            if (str_contains($title, 'Total THC')) {
                $data['totalTHC'] = $value;
            } elseif (str_contains($title, 'Total CBD')) {
                $data['totalCBD'] = $value;
            } elseif (str_contains($title, 'Total Cannabinoids')) {
                $data['totalCannabinoids'] = $value;
            } elseif (str_contains($title, 'Sum of Cannabinoids')) {
                $data['sumOfCannabinoids'] = $value;
            }
        });

        yield $this->item($data);
    }
}
