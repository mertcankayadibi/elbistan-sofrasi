@extends('layouts.app')

@section('title', 'Ana Sayfa')

@section('content')
    <section class="hero-cover hero-cover--light" aria-label="Elbistan Sofrası">
        <div class="hero-cover__media">
            <img src="{{ asset('images/hero-slider.jpg') }}" alt="Elbistan Sofrası kurutulmuş biber, baharat ve yöresel pul biber paketi" width="1920" height="600" fetchpriority="high">
            <span class="hero-cover__shade" aria-hidden="true"></span>
        </div>
        <div class="container-page hero-cover__body">
            <p class="hero-cover__eyebrow"><span aria-hidden="true"></span>ELBİSTAN'DAN SOFRANIZA</p>
            <h1>Elbistan'dan<br>sofranıza</h1>
            <p class="hero-cover__lead">Anadolu'nun geleneksel lezzetlerini, katkısız ve el emeğiyle sofranıza taşıyoruz.</p>
            <div class="hero-cover__actions">
                <a href="{{ route('products.index') }}" class="btn-primary"><x-icon-cart :size="17" />Alışverişe başla</a>
                <a href="{{ route('category.show', 'baharat-isot') }}" class="btn-outline">Ürünleri keşfet <x-icon-arrow-right :size="16" /></a>
            </div>
        </div>
    </section>

        <section class="category-strip bg-white py-6 md:py-9" id="kategoriler">
        <div class="container-page grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category['slug']) }}" class="category-card group">
                    <img src="{{ asset('images/' . $category['image']) }}" alt="{{ $category['name'] }}" width="900" height="900" loading="lazy">
                    <span class="category-card__shade" aria-hidden="true"></span>
                    <span class="category-card__label">
                        <span class="category-card__name">{{ $category['name'] }}</span>
                        <span class="category-card__meta">{{ $category['count'] }} ürün <span aria-hidden="true">→</span></span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-10 md:py-14" id="cok-satanlar">
        <div class="container-page">
            <p class="mb-3 text-center text-[.78rem] font-bold uppercase tracking-[.22em] text-zeytin">Raflardan</p><div class="section-title-centered section-title--hero"><span class="section-leaf" aria-hidden="true">⌁</span><h2>Çok Satan Ürünler</h2><span class="section-leaf section-leaf--right" aria-hidden="true">⌁</span></div><p class="mt-4 text-center text-[.95rem] text-fume/60">{{ count($allProducts) }} ürün · Elbistan'dan seçilmiş</p>
            <div class="product-grid mt-8">
                @foreach ($allProducts as $product)<x-product-card :product="$product" />@endforeach
            </div>
        </div>
    </section>


            <section class="trust-band border-y border-kraft/20 bg-white py-8 md:py-10"><div class="container-page grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([['icon' => 'shield', 'title' => 'Güvenli Ödeme', 'text' => 'Alışverişleriniz 256 bit SSL ile güvence altında.'], ['icon' => 'box', 'title' => 'Özenli Paketleme', 'text' => 'Ürünler tazeliğini koruyacak şekilde hazırlanır.'], ['icon' => 'truck', 'title' => 'Hızlı Kargo', 'text' => 'Siparişleriniz en kısa sürede adresinize ulaştırılır.'], ['icon' => 'headset', 'title' => 'Müşteri Desteği', 'text' => 'Her konuda yanınızdayız. Bize ulaşabilirsiniz.']] as $trust)<div class="flex items-start gap-4 border-kraft/20 sm:border-r sm:pr-5 last:border-0"><span class="trust-icon" aria-hidden="true">{{ $trust['icon'] === 'truck' ? '♧' : ($trust['icon'] === 'box' ? '□' : ($trust['icon'] === 'headset' ? '◡' : '♧')) }}</span><div><h3 class="font-sans text-sm font-bold">{{ $trust['title'] }}</h3><p class="mt-1 text-xs leading-5 text-fume/65">{{ $trust['text'] }}</p></div></div>@endforeach
    </div></section>

        <section class="bg-white py-14 md:py-20" id="tarifler"><div class="container-page"><div class="flex items-end justify-between gap-5"><div><p class="eyebrow mb-3">SOFRANIN TARİFLERİ</p><h2>Elbistan sofrasından üç tarif.</h2></div><a href="{{ route('recipes.index') }}" class="text-link">Tüm tarifler <x-icon-arrow-right :size="16" /></a></div><div class="mt-9 grid gap-5 md:grid-cols-3">
        @foreach ([['title' => 'Kuru dolma, annemin ölçüsüyle', 'image' => 'r-dolma.jpg', 'time' => '45 dk', 'description' => 'Pirinç, soğan ve nane; iç harcın sırrı.'], ['title' => 'Tarhana çorbası: ilk kaşık', 'image' => 'r-soup.jpg', 'time' => '20 dk', 'description' => 'Un yerine tarhana, üstüne tereyağı.'], ['title' => 'Cevizli kahvaltı sofrası', 'image' => 'r-kahvalti.jpg', 'time' => '15 dk', 'description' => 'Pekmez, ceviz ve taze ekmek.']] as $recipe)<article class="recipe-card group"><div class="relative aspect-[3/2] overflow-hidden"><img src="{{ asset('images/' . $recipe['image']) }}" alt="{{ $recipe['title'] }}" width="900" height="600" loading="lazy" class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]"><span class="absolute left-3 top-3 bg-kraft px-2 py-1 text-[11px] font-bold text-fume">{{ $recipe['time'] }}</span></div><div class="p-5"><h3>{{ $recipe['title'] }}</h3><p class="mt-2 text-sm text-fume/65">{{ $recipe['description'] }}</p><a href="{{ route('recipes.index') }}" class="mt-5 inline-flex items-center gap-2 text-xs font-bold text-bordo">Tarifi oku <x-icon-arrow-right :size="15" /></a></div></article>@endforeach
    </div></div></section>

    <section class="bg-krem py-14 md:py-20" id="notlar"><div class="container-page"><div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between"><div><p class="eyebrow mb-3">SOFRALARDAN NOTLAR</p><h2 class="font-bold">Sofralardan notlar.</h2></div><p class="font-display text-xl text-bordo">4,9 / 5 <span class="font-sans text-sm text-fume/60">· 642 değerlendirme</span></p></div><div class="mt-9 grid gap-4 md:grid-cols-3">
        @foreach ([['text' => 'Tarhanayı kayınvalidemin tarifiyle yaptım, ilk kaşıkta Elbistan\'a gittim. Kokusu bambaşka.', 'name' => 'Zeynep A.', 'city' => 'İstanbul'], ['text' => 'Salça kavanozu açıldığında bütün mutfak kokuyor. On yıllık alışverişim, hiç şaşırtmadı.', 'name' => 'Murat K.', 'city' => 'Ankara'], ['text' => 'Kargo iki günde geldi, kutular özenliydi. Kuru patlıcanlar tek tek seçilmiş gibi.', 'name' => 'Elif D.', 'city' => 'İzmir']] as $review)<article class="review-card"><div class="flex gap-1 text-kraft">★★★★★</div><p class="mt-5 text-sm leading-7">“{{ $review['text'] }}”</p><div class="mt-7 border-t border-kraft/20 pt-4"><p class="text-sm font-bold">{{ $review['name'] }} <span class="font-normal text-fume/55">· {{ $review['city'] }}</span></p><p class="mt-1 text-[11px] text-zeytin">✓ Doğrulanmış alışveriş</p></div></article>@endforeach
    </div></div></section>

    <section class="newsletter-section border-y border-kraft/25 bg-white py-14 md:py-16" id="bulten"><div class="container-page grid items-center gap-8 lg:grid-cols-2"><div><p class="eyebrow mb-3">MEKTUP</p><h2>İlk siparişinize %10.</h2><p class="mt-4 max-w-md text-sm leading-7 text-fume/70">Hasat zamanı, yeni tarifler ve kiler notları. Ayda bir, iki e-posta.</p></div><form class="flex flex-col gap-3 sm:flex-row sm:items-start" data-newsletter-form><div class="flex-1"><label class="sr-only" for="newsletter-email">E-posta adresiniz</label><input id="newsletter-email" type="email" required placeholder="E-posta adresiniz" class="h-12 w-full border border-fume/20 bg-white px-4 text-sm placeholder:text-fume/45"><p class="mt-2 text-[11px] text-fume/55">İstediğin zaman çıkabilirsin.</p></div><button type="submit" class="btn-primary h-12 shrink-0">Kodu gönder</button><p class="hidden basis-full text-sm font-semibold text-zeytin" data-newsletter-success>Teşekkürler, kodu e-postanıza gönderdik.</p></form></div></section>
@endsection