@extends('layouts.app')

@section('title', 'Tüm Ürünler')

@push('head')
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::collectionSchema('Tüm Ürünler', url('/urunler'), $products->items()), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::breadcrumbs([['label' => 'Ana sayfa', 'url' => route('home')], ['label' => 'Tüm ürünler', 'url' => url('/urunler')]]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
    <div class="border-b border-kraft/20 bg-white"><div class="container-page flex items-center gap-2 py-4 text-xs text-fume/55"><a href="{{ route('home') }}" class="hover:text-bordo">Ana sayfa</a><span aria-hidden="true">›</span><span class="text-fume">Tüm ürünler</span></div></div>
    <section class="bg-krem py-5 md:py-7"><div class="container-page flex flex-col gap-2 md:flex-row md:items-baseline md:justify-between"><div><p class="eyebrow mb-2">ELBİSTAN SOFRASI</p><h1 class="text-[2rem] md:text-[2.5rem]">Tüm Ürünler</h1><p class="mt-2 max-w-xl text-sm leading-6 text-fume/70">Kurutmalık, baharat, salça ve yöresel kiler ürünlerinin tamamını tek rafta keşfedin.</p></div><p class="font-display text-xl text-bordo">{{ $products->total() }} ürün</p></div></section>
    <section class="bg-white py-8 md:py-12">
        <div class="container-page">
            @include('categories._selected-chips')
            <div class="grid items-start gap-8 lg:grid-cols-[300px_minmax(0,1fr)] xl:grid-cols-[320px_minmax(0,1fr)] xl:gap-10">
                <aside class="sticky top-6 hidden self-start bg-krem p-5 lg:block" data-filter-desktop>@include('categories._filters', ['mobileSheet' => false])</aside>
                <div class="min-w-0">
                    <div class="mb-6 flex items-center justify-between gap-4 border-b border-kraft/25 pb-5">
                        <p class="font-display text-xl text-bordo">{{ $products->total() }} ürün</p>
                        <form action="{{ $filterAction }}" method="get" class="flex items-center gap-3 text-[15px] font-semibold">
                            @foreach (request()->except(['sirala', 'sayfa']) as $key => $value)
                                @if (is_array($value)) @foreach ($value as $item)<input type="hidden" name="{{ $key }}[]" value="{{ $item }}">@endforeach @else<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
                            @endforeach
                            <label for="products-sort">Sırala:</label><select id="products-sort" name="sirala" data-auto-submit class="h-12 border border-kraft/50 bg-white px-3 text-[15px] font-semibold"><option value="onerilen" @selected($filterState['sort'] === 'onerilen')>Önerilen</option><option value="fiyat-artan" @selected($filterState['sort'] === 'fiyat-artan')>Fiyat artan</option><option value="fiyat-azalan" @selected($filterState['sort'] === 'fiyat-azalan')>Fiyat azalan</option><option value="yeni" @selected($filterState['sort'] === 'yeni')>Yeni gelenler</option></select>
                        </form>
                    </div>
                    @if ($products->isEmpty())
                        <div class="border border-kraft/30 bg-krem px-6 py-16 text-center"><h2 class="text-2xl">Bu filtrelerle ürün bulunamadı</h2><p class="mt-3 text-sm text-fume/65">Farklı bir ölçü veya fiyat aralığı deneyin.</p><a href="{{ $filterAction }}" class="btn-primary mt-6">Filtreleri temizle</a></div>
                    @else
                        <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4 lg:gap-4 xl:grid-cols-4">@foreach ($products as $product)<x-product-card :product="$product" />@endforeach</div>
                    @endif
                    @if ($products->hasPages())
                        <nav class="mt-10 flex flex-wrap items-center justify-center gap-2" aria-label="Sayfalama">
                            @if ($products->previousPageUrl())<a rel="prev" href="{{ $products->previousPageUrl() }}" class="flex h-11 w-11 items-center justify-center border border-kraft/35 text-lg hover:border-bordo hover:text-bordo" aria-label="Önceki sayfa">‹</a>@endif
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)<a href="{{ $url }}" class="flex h-11 min-w-11 items-center justify-center border px-3 text-sm font-bold {{ $page === $products->currentPage() ? 'border-bordo bg-bordo text-white' : 'border-kraft/35 hover:border-bordo hover:text-bordo' }}" @if($page === $products->currentPage()) aria-current="page" @endif>{{ $page }}</a>@endforeach
                            @if ($products->nextPageUrl())<a rel="next" href="{{ $products->nextPageUrl() }}" class="flex h-11 w-11 items-center justify-center border border-kraft/35 text-lg hover:border-bordo hover:text-bordo" aria-label="Sonraki sayfa">›</a>@endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <div class="fixed inset-0 z-50 hidden bg-fume/45" data-filter-backdrop></div>
    <aside class="fixed inset-x-0 bottom-0 z-[60] max-h-[85dvh] translate-y-full overflow-y-auto rounded-t-[14px] bg-krem p-5 transition-transform duration-300 lg:hidden" data-filter-drawer aria-hidden="true"><div class="mx-auto mb-4 h-1 w-12 rounded-full bg-kraft/50" aria-hidden="true"></div><div class="mb-4 flex items-center justify-between border-b border-kraft/25 pb-4"><h2 class="font-display text-xl">Filtreler</h2><button type="button" data-filter-close class="flex h-10 w-10 items-center justify-center border border-kraft/40 text-xl" aria-label="Filtreleri kapat">×</button></div>@include('categories._filters', ['mobileSheet' => true])</aside>
@endsection

@push('scripts')
<script>
(() => {
    const body = document.body, drawer = document.querySelector('[data-filter-drawer]'), backdrop = document.querySelector('[data-filter-backdrop]');
    const setDrawer = (open) => { if (!drawer || !backdrop) return; drawer.classList.toggle('translate-y-full', !open); drawer.classList.toggle('translate-y-0', open); backdrop.classList.toggle('hidden', !open); drawer.setAttribute('aria-hidden', String(!open)); body.classList.toggle('drawer-open', open); };
    document.querySelectorAll('[data-filter-open]').forEach((button) => button.addEventListener('click', () => setDrawer(true)));
    backdrop?.addEventListener('click', () => setDrawer(false)); document.querySelectorAll('[data-filter-close]').forEach((button) => button.addEventListener('click', () => setDrawer(false)));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') setDrawer(false); });
    document.querySelectorAll('[data-filter-accordion]').forEach((accordion) => { const trigger = accordion.querySelector('[data-filter-trigger]'), panel = accordion.querySelector('[data-filter-panel]'), chevron = accordion.querySelector('[data-filter-chevron]'); trigger?.addEventListener('click', () => { const expanded = trigger.getAttribute('aria-expanded') === 'true'; trigger.setAttribute('aria-expanded', String(!expanded)); if (panel) panel.hidden = expanded; chevron?.classList.toggle('rotate-180', !expanded); }); });
    document.querySelectorAll('[data-auto-submit]').forEach((select) => select.addEventListener('change', () => select.form?.submit()));
})();
</script>
@endpush
