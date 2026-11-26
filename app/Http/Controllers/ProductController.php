<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use App\Support\CatalogFilter;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $query = $request->query();
        $products = CatalogFilter::paginate(Catalog::all(), $query, $request->url());
        $seo = Seo::listing();
        $seo['robots'] = ($query['q'] ?? '') !== '' ? 'noindex,follow' : $seo['robots'];

        return response()->view('products.index', [
            'categories' => Catalog::categories(),
            'products' => $products,
            'filterOptions' => CatalogFilter::options(Catalog::all(), Catalog::categories()),
            'filterState' => CatalogFilter::state($query),
            'filterChips' => CatalogFilter::chips($query, $request->url()),
            'selectedFilterCount' => count(CatalogFilter::chips($query, $request->url())),
            'filterAction' => $request->url(),
            'isCategoryPage' => false,
            'seo' => $seo,
        ]);
    }

    public function show(string $slug): Response
    {
        $product = Catalog::find($slug);

        abort_if($product === null, 404);

        return response()->view('products.show', [
            'product' => $product,
            'related' => Catalog::related($slug),
            'seo' => Seo::product($product),
        ]);
    }
}
