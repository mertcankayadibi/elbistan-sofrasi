@extends('layouts.app')

@section('title', $category['name'])

@push('head')
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::collectionSchema($category['name'], url('/kategori/'.$category['slug']), $products->items()), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::breadcrumbs([['label' => 'Ana sayfa', 'url' => route('home')], ['label' => $category['name'], 'url' => url('/kategori/'.$category['slug'])]]), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')


    <div class="border-b border-kraft/25 bg-white">
        <div class="container-page flex items-center gap-2.5 py-3 text-[13.5px] text-fume/60">
            <a href="{{ route('home') }}" class="font-medium hover:text-bordo hover:underline">Ana sayfa</a>
            <span aria-hidden="true" class="text-fume/35">›</span>
            <span class="font-semibold text-fume">{{ $category['name'] }}</span>
        </div>
    </div>

    <section class="bg-white pb-12 pt-5 md:pb-16 md:pt-6">
        <div class="container-page">
            @include('categories._selected-chips')
            <div class="grid gap-10 lg:grid-cols-[300px_minmax(0,1fr)] xl:grid-cols-[320px_minmax(0,1fr)]">
                <aside class="sticky top-6 hidden self-start bg-krem p-5 lg:block" data-filter-desktop>
                    @include('categories._filters', ['mobileSheet' => false])
                </aside>
                <div>
                    <div class="mt-3 flex flex-col gap-3 border-b border-kraft/25 pb-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3"><h1 class="font-display text-[1.6rem] leading-none text-bordo md:text-[1.8rem]">{{ $category['name'] }}</h1><span class="text-sm font-semibold text-zeytin">{{ $products->total() }} ürün</span></div>
                        <div class="flex items-center gap-3">
                            <button type="button" data-filter-open class="flex h-11 items-center gap-2 border border-kraft/50 px-4 text-sm font-bold text-fume lg:hidden">Filtrele @if($selectedFilterCount > 0)<span class="text-bordo">({{ $selectedFilterCount }})</span>@endif</button>
                            <form action="{{ $filterAction }}" method="get" class="flex items-center gap-3 text-[15px] font-semibold">
                                @foreach (request()->except(['sirala', 'sayfa']) as $key => $value)
                                    @if (is_array($value)) @foreach ($value as $item)<input type="hidden" name="{{ $key }}[]" value="{{ $item }}">@endforeach @else<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endif
                                @endforeach
                                <label for="category-sort">Sırala:</label><select id="category-sort" name="sirala" data-auto-submit class="h-12 border border-kraft/50 bg-white px-3 text-[15px] font-semibold"><option value="onerilen" @selected($filterState['sort'] === 'onerilen')>Önerilen</option><option value="fiyat-artan" @selected($filterState['sort'] === 'fiyat-artan')>Fiyat artan</option><option value="fiyat-azalan" @selected($filterState['sort'] === 'fiyat-azalan')>Fiyat azalan</option><option value="yeni" @selected($filterState['sort'] === 'yeni')>Yeni gelenler</option></select>
                            </form>
                        </div>
                    </div>
                    @if ($products->isEmpty())
                        <div class="border border-kraft/30 bg-krem px-6 py-16 text-center"><h2 class="text-2xl">Bu filtrelerle ürün bulunamadı</h2><p class="mt-3 text-sm text-fume/65">Farklı bir ölçü veya fiyat aralığı deneyin.</p><a href="{{ $filterAction }}" class="btn-primary mt-6">Filtreleri temizle</a></div>
                    @else
                        <div class="mt-7 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4 lg:gap-4 xl:grid-cols-4">@foreach ($products as $product)<x-product-card :product="$product" />@endforeach</div>
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
            <div class="mt-16 border-t border-kraft/30 pt-8"><span class="kilim-divider mb-5 block"></span><h2 class="text-2xl">{{ $category['name'] }} ürünleri</h2><div class="mt-4 max-w-3xl space-y-3 text-sm leading-7 text-fume/70"><p>{{ $category['description'] }} Elbistan Sofrası'nın kilerinden seçilen ürünleri, mevsiminde ve alıştığımız ölçüyle hazırlıyoruz.</p><p>Her paket, Elbistan'dan çıkar ve sofranıza 2-3 iş gününde ulaşır. Ürünlerimizi saklama ve kullanım önerileriyle birlikte gönderiyoruz.</p></div></div>
        </div>
    </section>
    <div class="fixed inset-0 z-50 hidden bg-fume/45" data-filter-backdrop></div>
    <aside class="fixed inset-x-0 bottom-0 z-[60] max-h-[85dvh] translate-y-full overflow-y-auto rounded-t-[14px] bg-krem p-5 transition-transform duration-300 lg:hidden" data-filter-drawer aria-hidden="true">
        <div class="mx-auto mb-4 h-1 w-12 rounded-full bg-kraft/50" aria-hidden="true"></div>
        <div class="mb-4 flex items-center justify-between border-b border-kraft/25 pb-4"><h2 class="font-display text-xl">Filtreler</h2><button type="button" data-filter-close class="flex h-10 w-10 items-center justify-center border border-kraft/40 text-xl" aria-label="Filtreleri kapat">×</button></div>
        @include('categories._filters', ['mobileSheet' => true])
    </aside>
@endsection

@push('scripts')
<script>
(() => {
    const body = document.body;
    const drawer = document.querySelector('[data-filter-drawer]');
    const backdrop = document.querySelector('[data-filter-backdrop]');
    const openButton = document.querySelector('[data-filter-open]');
    const setDrawer = (open) => {
        if (!drawer || !backdrop) return;
        drawer.classList.toggle('translate-y-full', !open); drawer.classList.toggle('translate-y-0', open);
        backdrop.classList.toggle('hidden', !open); drawer.setAttribute('aria-hidden', String(!open)); body.classList.toggle('drawer-open', open);
    };
    openButton?.addEventListener('click', () => setDrawer(true));
    backdrop?.addEventListener('click', () => setDrawer(false));
    document.querySelectorAll('[data-filter-close]').forEach((button) => button.addEventListener('click', () => setDrawer(false)));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') setDrawer(false); });
    document.querySelectorAll('[data-filter-accordion]').forEach((accordion) => {
        const trigger = accordion.querySelector('[data-filter-trigger]'); const panel = accordion.querySelector('[data-filter-panel]'); const chevron = accordion.querySelector('[data-filter-chevron]');
        trigger?.addEventListener('click', () => { const expanded = trigger.getAttribute('aria-expanded') === 'true'; trigger.setAttribute('aria-expanded', String(!expanded)); if (panel) panel.hidden = expanded; chevron?.classList.toggle('rotate-180', !expanded); });
    });
    document.querySelectorAll('[data-auto-submit]').forEach((select) => select.addEventListener('change', () => select.form?.submit()));
})();
</script>
@endpush
