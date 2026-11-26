<?php

use App\Http\Controllers\SitemapController;
use App\Support\Catalog;

it('filters the catalogue by a price range', function () {
    $response = $this->get('/urunler?min=200&max=300');

    $response->assertOk()
        ->assertSee('Dolmalık Kuru Biber (Dizi)')
        ->assertDontSee('Tarhana (250 g)')
        ->assertSee('Filtreler');
});

it('sorts products from low to high and high to low', function () {
    $this->get('/urunler?sirala=fiyat-artan')
        ->assertOk()
        ->assertSeeInOrder(['Tarhana (250 g)', 'Mercimek (500 g)']);

    $this->get('/urunler?sirala=fiyat-azalan')
        ->assertOk()
        ->assertSeeInOrder(['Süzme Bal', 'Köy Tereyağı']);
});

it('searches product names, descriptions and categories', function () {
    $this->get('/urunler?q=tarhana')
        ->assertOk()
        ->assertSee('Elbistan Usulü Tarhana')
        ->assertSee('Tarhana (250 g)')
        ->assertDontSee('Urfa İsot');
});

it('paginates the catalogue and keeps the filter query in links', function () {
    $response = $this->get('/urunler?sayfa=1');

    $response->assertOk()
        ->assertSee('40 ürün')
        ->assertSee('sayfa=2');

    expect(substr_count($response->getContent(), 'data-product-card'))->toBe(12);

    $this->get('/kategori/baharat-isot?agirlik=250&sayfa=2')
        ->assertOk()
        ->assertSee('Baharat &amp; İsot', false);
});

it('renders product seo metadata and product structured data', function () {
    $this->get('/urun/elbistan-tarhana-1-kg')
        ->assertOk()
        ->assertSee('<link rel="canonical"', false)
        ->assertSee('<meta property="og:image"', false)
        ->assertSee('"@type":"Product"', false)
        ->assertSee('"priceCurrency":"TRY"', false);
});

it('publishes robots and sitemap content for the static catalogue', function () {
    expect(file_get_contents(public_path('robots.txt')))
        ->toContain('Sitemap:');

    $sitemap = app(SitemapController::class)->index();

    expect($sitemap->getContent())
        ->toContain('/urun/elbistan-tarhana-1-kg')
        ->toContain('/kategori/baharat-isot')
        ->toContain('<lastmod>');

    expect(Catalog::count())->toBe(40);
});
