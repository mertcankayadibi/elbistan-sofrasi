<?php

use App\Support\Catalog;

it('renders every storefront page and rejects missing catalog entries', function () {
    foreach ([
        '/',
        '/urunler',
        '/kategori/tarhana-eriste',
        '/kategori/salcalar',
        '/kategori/baharat-isot',
        '/kategori/kurutmalik',
        '/kategori/bakliyat-tahil',
        '/kategori/tatli-kahvaltilik',
        '/urun/elbistan-tarhana-1-kg',
        '/urun/dolmalik-kuru-patlican',
        '/sepet',
        '/hakkimizda',
        '/tarifler',
    ] as $uri) {
        $this->get($uri)->assertOk();
    }

    $this->get('/urun/olmayan')->assertNotFound();
    $this->get('/kategori/olmayan')->assertNotFound();
});

it('renders the requested page content', function () {
    $this->get('/kategori/salcalar')->assertSee('Bakır kazanda, sabırla.')->assertSee('Ev Yapımı Biber Salçası');
    $this->get('/urun/elbistan-tarhana-1-kg')->assertSee('Ürün bilgisi')->assertSee('Benzer ürünler');
    $this->get('/sepet')->assertSee('Sepetiniz');
    $this->get('/hakkimizda')->assertSee('Elbistan, Kahramanmaraş');
    $this->get('/tarifler')->assertSee('Kuru dolma, annemin ölçüsüyle')->assertSee('Tarhana çorbası: ilk kaşık');
});

it('uses existing catalog image files in rendered storefront markup', function () {
    $html = $this->get('/')->getContent();
    preg_match_all('/\/images\/([a-z0-9-]+\.jpg)/i', $html, $matches);

    expect($matches[1])->not->toBeEmpty();

    foreach (array_unique($matches[1]) as $image) {
        expect(is_file(public_path('images/'.$image)))->toBeTrue("Missing image: {$image}");
    }

    expect(Catalog::count())->toBe(40);
});
