<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        $featured = Catalog::featured();

        return view('home', [
            'categories' => Catalog::categories(),
            'products' => $featured,
            'allProducts' => Catalog::interleaved(),
            'heroProduct' => $featured[1] ?? $featured[0],
            'spices' => Catalog::spices(),
        ]);
    }
}
