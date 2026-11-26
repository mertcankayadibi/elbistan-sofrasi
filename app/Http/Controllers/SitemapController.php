<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\Http\Response;

final class SitemapController extends Controller
{
    public function index(): Response
    {
        $lastmod = now()->toDateString();
        $urls = [
            ['loc' => url('/'), 'lastmod' => $lastmod, 'changefreq' => 'weekly', 'priority' => '1.0'],
            ['loc' => url('/urunler'), 'lastmod' => $lastmod, 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => url('/hakkimizda'), 'lastmod' => $lastmod, 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/tarifler'), 'lastmod' => $lastmod, 'changefreq' => 'weekly', 'priority' => '0.7'],
        ];

        foreach (Catalog::categories() as $category) {
            $urls[] = [
                'loc' => url('/kategori/'.$category['slug']),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        foreach (Catalog::all() as $product) {
            $urls[] = [
                'loc' => url('/urun/'.$product['slug']),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
