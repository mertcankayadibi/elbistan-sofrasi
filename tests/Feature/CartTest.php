<?php

use App\Support\Cart;
use App\Support\Catalog;

it('adds products to the session cart and aggregates repeated additions', function () {
    $this->postJson('/sepet/ekle', ['slug' => 'elbistan-tarhana-1-kg', 'qty' => 2])
        ->assertOk()
        ->assertJson(['count' => 2, 'subtotal' => 438]);

    $this->postJson('/sepet/ekle', ['slug' => 'elbistan-tarhana-1-kg', 'qty' => 3])
        ->assertOk()
        ->assertJson(['count' => 5, 'subtotal' => 1095]);

    expect(session('cart'))->toBe(['elbistan-tarhana-1-kg' => 5]);
});

it('caps quantities at twenty and removes an item when updated to zero', function () {
    $this->postJson('/sepet/ekle', ['slug' => 'tarhana-500-g', 'qty' => 20])->assertOk();
    $this->postJson('/sepet/ekle', ['slug' => 'tarhana-500-g', 'qty' => 20])
        ->assertJson(['count' => 20, 'subtotal' => 2380]);

    $this->patchJson('/sepet/guncelle', ['slug' => 'tarhana-500-g', 'qty' => 0])
        ->assertOk()
        ->assertJson(['count' => 0, 'subtotal' => 0, 'removed' => true, 'line_total' => 0]);

    expect(session('cart'))->toBe([]);
});

it('removes and clears cart items', function () {
    $this->withSession(['cart' => [
        'tarhana-500-g' => 1,
        'urfa-isot-250-g' => 2,
    ]]);

    $this->deleteJson('/sepet/cikar', ['slug' => 'tarhana-500-g'])
        ->assertOk()
        ->assertJson(['count' => 2, 'removed' => true]);

    $this->postJson('/sepet/temizle')
        ->assertOk()
        ->assertJson(['count' => 0, 'subtotal' => 0]);

    expect(session('cart'))->toBe([]);
});

it('calculates paid and free shipping at the five hundred lira threshold', function () {
    $this->withSession(['cart' => ['elbistan-tarhana-1-kg' => 1]])
        ->get('/sepet')
        ->assertOk()
        ->assertSee('79,00 ₺')
        ->assertSee('298,00 ₺');

    $this->withSession(['cart' => ['elbistan-tarhana-1-kg' => 3]])
        ->get('/sepet')
        ->assertOk()
        ->assertSee('Ücretsiz')
        ->assertSee('657,00 ₺');

    expect(Cart::freeShippingThreshold())->toBe(500);
});

it('rejects an unknown product slug', function () {
    $this->postJson('/sepet/ekle', ['slug' => 'olmayan-urun', 'qty' => 1])
        ->assertStatus(422)
        ->assertJson(['message' => 'Ürün bulunamadı.']);
});

it('renders an empty cart without demo items', function () {
    $this->get('/sepet')
        ->assertOk()
        ->assertSee('Sepetiniz boş')
        ->assertDontSee('Elbistan Usulü Tarhana');
});

it('exposes the session quantity in both header counters', function () {
    $this->withSession(['cart' => ['tarhana-500-g' => 3]])
        ->get('/sepet')
        ->assertSee('data-cart-count>3</span>', false);
});

it('uses catalog prices when calculating cart lines', function () {
    $this->withSession(['cart' => ['tarhana-500-g' => 2]]);

    expect(Cart::items()[0]['line_total'])->toBe(Catalog::find('tarhana-500-g')['price'] * 2);
});
