<?php

namespace App\Http\Controllers;

use App\Support\Catalog;
use App\Support\CatalogFilter;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CategoryController extends Controller
{
    public function show(string $slug, Request $request): Response
    {
        $category = collect(Catalog::categories())->firstWhere('slug', $slug);

        abort_if($category === null, 404);

        $query = $request->query();
        $source = Catalog::byCategory($slug);
        $products = CatalogFilter::paginate($source, $query, $request->url());
        $seo = Seo::category($category);
        $seo['robots'] = ($query['q'] ?? '') !== '' ? 'noindex,follow' : $seo['robots'];

        return response()->view('categories.show', [
            'category' => $category,
            'products' => $products,
            'filterOptions' => CatalogFilter::options(Catalog::all(), Catalog::categories()),
            'filterState' => CatalogFilter::state($query),
            'filterChips' => CatalogFilter::chips($query, $request->url()),
            'selectedFilterCount' => count(CatalogFilter::chips($query, $request->url())),
            'filterAction' => $request->url(),
            'isCategoryPage' => true,
            'seo' => $seo,
        ]);
    }
}
