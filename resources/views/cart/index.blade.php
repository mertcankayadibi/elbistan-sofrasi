@extends('layouts.app')

@section('title', 'Sepetiniz')

@section('content')
    @php
        $hasItems = count($items) > 0;
        $progress = $threshold > 0 ? min(100, (int) round(($subtotal / $threshold) * 100)) : 100;
        $remaining = max(0, $threshold - $subtotal);
    @endphp

    <section class="bg-krem py-12 md:py-16">
        <div class="container-page">
            <p class="eyebrow mb-4">KİLERİNİZ</p>
            <div class="flex flex-wrap items-end justify-between gap-4">
                <h1>Sepetiniz</h1>
                <div class="flex items-center gap-4 text-sm text-fume/60">
                    <span data-cart-item-count>{{ $cartCount }} ürün</span>
                    <button type="button" data-cart-clear class="{{ $hasItems ? '' : 'hidden' }} text-xs font-bold text-bordo underline">Sepeti temizle</button>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-12 md:py-16" data-cart-page>
        <div class="container-page grid gap-10 lg:grid-cols-[minmax(0,1fr)_360px]">
            <div>
                <div class="divide-y divide-kraft/25 border-y border-kraft/25 {{ $hasItems ? '' : 'hidden' }}" data-cart-lines>
                    @foreach ($items as $item)
                        @php($product = $item['product'])
                        <article class="flex gap-4 py-5" data-cart-line data-cart-slug="{{ $product['slug'] }}" data-price="{{ $product['price'] }}">
                            <a href="{{ route('product.show', $product['slug']) }}">
                                <img src="{{ asset('images/'.$product['image']) }}" alt="{{ $product['name'] }}" width="900" height="900" class="h-[88px] w-[88px] shrink-0 object-cover">
                            </a>
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('product.show', $product['slug']) }}" class="font-display text-lg font-semibold hover:text-bordo">{{ $product['name'] }}</a>
                                <p class="mt-1 text-xs text-fume/55">{{ $product['weight'] }}</p>
                                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex h-9 items-center border border-kraft/40" data-stepper>
                                        <button type="button" data-step="-1" class="flex h-full w-8 items-center justify-center hover:text-bordo" aria-label="Adedi azalt"><x-icon-minus :size="13" /></button>
                                        <input type="number" min="1" max="20" value="{{ $item['quantity'] }}" data-cart-quantity aria-label="{{ $product['name'] }} adet" class="h-full w-10 border-x border-kraft/25 bg-transparent text-center text-xs">
                                        <button type="button" data-step="1" class="flex h-full w-8 items-center justify-center hover:text-bordo" aria-label="Adedi artır"><x-icon-plus :size="13" /></button>
                                    </div>
                                    <button type="button" data-cart-remove class="text-xs text-fume/55 underline hover:text-bordo">Kaldır</button>
                                </div>
                            </div>
                            <strong data-line-total class="shrink-0 font-display text-lg font-semibold">{{ \App\Support\Catalog::formatPrice($item['line_total']) }}</strong>
                        </article>
                    @endforeach
                </div>

                <div class="mt-7 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                    <a href="{{ route('home') }}#urunler" class="text-link">← Alışverişe devam et</a>
                    <form class="flex gap-2" data-coupon-form>
                        <label class="sr-only" for="coupon">Kupon kodu</label>
                        <input id="coupon" type="text" placeholder="Kupon kodu" class="h-11 border border-kraft/40 px-3 text-sm">
                        <button type="submit" class="btn-outline h-11">Uygula</button>
                    </form>
                </div>

                <div class="{{ $hasItems ? 'hidden' : '' }} mt-12 border border-kraft/30 bg-krem p-8 text-center" data-empty-cart>
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-kraft/50 text-bordo"><x-icon-cart :size="25" /></div>
                    <h2 class="mt-5 text-2xl">Sepetiniz boş</h2>
                    <p class="mt-3 text-sm text-fume/65">Kilerden bir ürün seçerek sofrayı kurabilirsiniz.</p>
                    <a href="{{ route('home') }}#urunler" class="btn-primary mt-6">Ürünlere bak</a>
                </div>
            </div>

            <aside class="{{ $hasItems ? '' : 'hidden' }} h-fit border border-kraft/25 bg-krem p-6 lg:sticky lg:top-28" data-cart-summary data-threshold="{{ $threshold }}">
                <h2 class="text-2xl">Sipariş özeti</h2>
                <div class="mt-7 space-y-4 border-b border-kraft/25 pb-5 text-sm">
                    <div class="flex justify-between"><span class="text-fume/65">Ara toplam</span><strong data-cart-subtotal>{{ \App\Support\Catalog::formatPrice($subtotal) }}</strong></div>
                    <div class="flex justify-between"><span class="text-fume/65">Kargo</span><strong data-cart-shipping class="{{ $shipping === 0 ? 'text-zeytin' : '' }}">{{ $shipping === 0 ? 'Ücretsiz' : \App\Support\Catalog::formatPrice($shipping) }}</strong></div>
                </div>
                <div class="flex items-center justify-between py-5"><span class="font-semibold">Toplam</span><strong class="font-display text-2xl" data-cart-total>{{ \App\Support\Catalog::formatPrice($total) }}</strong></div>
                <button type="button" class="btn-primary w-full">Ödemeye geç <x-icon-arrow-right :size="16" /></button>
                <div class="mt-6">
                    <div class="mb-2 flex justify-between text-xs text-fume/65"><span data-shipping-message>{{ $remaining > 0 ? \App\Support\Catalog::formatPrice($remaining).' kaldı' : 'Ücretsiz kargo hakkı kazandınız' }}</span><span>{{ $threshold }} ₺</span></div>
                    <div class="h-2 overflow-hidden rounded-full bg-kraft/20"><div data-shipping-progress class="h-full rounded-full bg-zeytin transition-all" style="width: {{ $progress }}%"></div></div>
                    <p class="mt-2 text-xs text-zeytin">500 ₺ üzeri kargo ücretsiz</p>
                </div>
                <p class="mt-5 flex items-center gap-2 text-xs text-zeytin"><x-icon-shield :size="17" /> Güvenli ödeme · 256-bit SSL</p>
                <div class="mt-5 flex flex-wrap gap-2 text-[10px] text-fume/55"><span class="border border-kraft/35 px-2 py-1">VISA</span><span class="border border-kraft/35 px-2 py-1">Mastercard</span><span class="border border-kraft/35 px-2 py-1">TROY</span><span class="border border-kraft/35 px-2 py-1">iyzico</span></div>
            </aside>
        </div>
    </section>
@endsection
