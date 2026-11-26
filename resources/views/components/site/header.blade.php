@php
    $categories = \App\Support\Catalog::categories();
    $cartCount = \App\Support\Cart::count();
@endphp

<div class="announcement-bar bg-bordo" data-announcement>
    <div class="container-page flex min-h-11 items-center justify-center py-2 text-center">
        <p class="announcement-bar__text">500 ₺ ve üzeri alışverişlerde ücretsiz kargo</p>
    </div>
</div>

<header class="site-header relative z-40 border-b border-kraft/20 bg-white transition-shadow" data-site-header>
    <div class="container-page flex min-h-[92px] items-center gap-5 py-3">
        <a href="{{ route('home') }}" class="site-logo flex shrink-0 items-center" aria-label="Elbistan Sofrası ana sayfa">
            <img src="{{ asset('images/logo.png') }}" alt="Elbistan Sofrası" width="406" height="320" class="h-[68px] w-auto lg:h-[78px]">
        </a>

        <form action="{{ route('products.index') }}" method="get" class="header-search hidden h-10 min-w-0 flex-1 items-center border border-kraft/50 lg:flex">
            <x-icon-search :size="18" class="ml-3 shrink-0 text-fume/60" />
            <label class="sr-only" for="header-search">Ürün ara</label>
            <input id="header-search" type="search" name="q" placeholder="Ürün, kategori veya marka ara…" class="min-w-0 flex-1 bg-transparent px-3 text-xs placeholder:text-fume/50">
            <button type="submit" class="flex h-full w-12 items-center justify-center bg-zeytin text-white transition hover:bg-bordo" aria-label="Ara"><x-icon-search :size="19" /></button>
        </form>

        <div class="ml-auto hidden items-center gap-5 lg:flex">
            <a href="{{ route('home') }}#hesabim" class="header-action"><x-icon-user :size="20" /><span>Hesabım</span></a>
            <a href="{{ route('home') }}#favoriler" class="header-action"><x-icon-heart :size="20" /><span>Favorilerim</span></a>
            <a href="{{ route('cart.index') }}" class="header-action relative"><x-icon-cart :size="21" /><span>Sepetim</span><span class="cart-count {{ $cartCount === 0 ? 'hidden' : '' }}" data-cart-count>{{ $cartCount }}</span></a>
        </div>
        <div class="ml-auto flex items-center gap-2 lg:hidden">
            <a href="{{ route('products.index') }}" class="flex h-10 w-10 items-center justify-center border border-kraft/40 text-fume" aria-label="Ürün ara"><x-icon-search :size="19" /></a>
            <button type="button" data-drawer-open class="flex h-10 w-10 shrink-0 items-center justify-center border border-kraft/40" aria-label="Menüyü aç"><x-icon-menu :size="22" /></button>
        </div>
    </div>

    <nav class="hidden border-t border-kraft/15 lg:block" aria-label="Ana menü">
        <div class="container-page nav-scroll flex h-12 items-center gap-3 overflow-x-auto whitespace-nowrap lg:h-[54px] lg:justify-between xl:gap-4">
            <a href="{{ route('home') }}" class="nav-link">Ana Sayfa</a>
            @foreach ($categories as $category)
                <a href="{{ route('category.show', $category['slug']) }}" class="nav-link">{{ $category['name'] }}</a>
            @endforeach
            <a href="{{ route('products.index') }}" class="nav-link">Tüm Ürünler</a>
            <a href="{{ route('recipes.index') }}" class="nav-link">Tarifler</a>
            <a href="{{ route('page.story') }}" class="nav-link">Hikâyemiz</a>
        </div>
    </nav>
</header>

<div class="fixed inset-0 z-50 hidden bg-fume/45" data-drawer-backdrop></div>
<aside class="mobile-drawer fixed right-0 top-0 z-[60] flex h-dvh w-[min(90vw,380px)] translate-x-full flex-col overflow-y-auto bg-krem p-6 transition-transform duration-300" data-mobile-drawer aria-hidden="true">
    <div class="flex items-center justify-between border-b border-kraft/25 pb-5">
        <a href="{{ route('home') }}" aria-label="Elbistan Sofrası ana sayfa"><img src="{{ asset('images/logo.png') }}" alt="Elbistan Sofrası" width="406" height="320" class="h-14 w-auto"></a>
        <button type="button" data-drawer-close class="flex h-9 w-9 items-center justify-center border border-kraft/40" aria-label="Menüyü kapat"><x-icon-close :size="19" /></button>
    </div>
    <form action="{{ route('products.index') }}" method="get" class="mt-5 flex h-10 items-center border border-kraft/45 bg-white">
        <x-icon-search :size="17" class="ml-3 text-zeytin" />
        <input type="search" name="q" placeholder="Ürün ara…" class="min-w-0 flex-1 bg-transparent px-3 text-xs">
    </form>
    <nav class="mt-5 flex flex-col" aria-label="Mobil menü">
        <a href="{{ route('home') }}" class="mobile-nav-link text-bordo">Ana Sayfa</a>
        @foreach ($categories as $category)
            <a href="{{ route('category.show', $category['slug']) }}" class="mobile-nav-link">{{ $category['name'] }}</a>
        @endforeach
        <a href="{{ route('products.index') }}" class="mobile-nav-link">Tüm Ürünler</a>
        <a href="{{ route('recipes.index') }}" class="mobile-nav-link">Tarifler</a>
        <a href="{{ route('page.story') }}" class="mobile-nav-link">Hikâyemiz</a>
    </nav>
    <div class="mt-auto space-y-4 border-t border-kraft/25 pt-5 text-sm">
        <a href="{{ route('home') }}#hesabim" class="flex items-center gap-3"><x-icon-user :size="19" class="text-zeytin" /> Hesabım</a>
        <a href="{{ route('home') }}#favoriler" class="flex items-center gap-3"><x-icon-heart :size="19" class="text-zeytin" /> Favorilerim</a>
        <a href="{{ route('cart.index') }}" class="flex items-center gap-3"><x-icon-cart :size="19" class="text-zeytin" /> Sepetim <span class="cart-count cart-count-inline {{ $cartCount === 0 ? 'hidden' : '' }}" data-cart-count>{{ $cartCount }}</span></a>
    </div>
</aside>