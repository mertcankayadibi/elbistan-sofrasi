@php
    $filterState = $filterState ?? \App\Support\CatalogFilter::state(request()->query());
    $filterOptions = $filterOptions ?? ['weights' => [], 'badges' => [], 'categories' => []];
    $filterAction = $filterAction ?? request()->url();
    $selectedFilterCount = $selectedFilterCount ?? 0;
    $mobileSheet = $mobileSheet ?? false;
    $isCategoryPage = $isCategoryPage ?? false;
    $queryWithoutPrice = \App\Support\CatalogFilter::without(request()->query(), 'min');
    unset($queryWithoutPrice['max']);
@endphp

<form action="{{ $filterAction }}" method="get" class="flex min-h-full flex-col" data-catalog-filter-form>
    @if ($filterState['q'] !== '')
        <input type="hidden" name="q" value="{{ $filterState['q'] }}">
    @endif

    <div class="flex items-center justify-between gap-3 border-b border-kraft/30 pb-4">
        <h2 class="font-sans text-[15px] font-bold uppercase tracking-[.12em]">FİLTRELER</h2>
        @if ($selectedFilterCount > 0)
            <div class="flex items-center gap-3 text-xs">
                <span class="font-bold text-bordo">{{ $selectedFilterCount }}</span>
                <a href="{{ $filterAction }}" class="font-semibold text-bordo underline underline-offset-2">Temizle</a>
            </div>
        @endif
    </div>

    <div class="divide-y divide-kraft/25">
        <section data-filter-accordion data-open class="py-4">
            <button type="button" data-filter-trigger aria-expanded="true" class="flex h-11 w-full items-center justify-between text-left text-[15px] font-bold">
                <span>Fiyat</span><span data-filter-chevron class="text-lg leading-none transition-transform">⌄</span>
            </button>
            <div data-filter-panel class="pt-3">
                <div class="grid grid-cols-[minmax(0,1fr)_minmax(0,1fr)] gap-2">
                    <label class="relative block"><span class="sr-only">Minimum fiyat</span><input type="number" min="0" name="min" value="{{ $filterState['min'] !== null ? (int) $filterState['min'] : '' }}" placeholder="Min" class="h-12 w-full border border-kraft/50 bg-white px-3 pr-8 text-[15px] focus:border-bordo"><span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-fume/55">₺</span></label>
                    <label class="relative block"><span class="sr-only">Maksimum fiyat</span><input type="number" min="0" name="max" value="{{ $filterState['max'] !== null ? (int) $filterState['max'] : '' }}" placeholder="Max" class="h-12 w-full border border-kraft/50 bg-white px-3 pr-8 text-[15px] focus:border-bordo"><span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-xs text-fume/55">₺</span></label>
                </div>
                <div class="mt-3 flex flex-wrap gap-2" aria-label="Hazır fiyat aralıkları">
                    @foreach ([['label' => '0-100', 'min' => 0, 'max' => 100], ['label' => '100-200', 'min' => 100, 'max' => 200], ['label' => '200-300', 'min' => 200, 'max' => 300], ['label' => '300+', 'min' => 300, 'max' => null]] as $range)
                        @php
                            $rangeQuery = array_merge($queryWithoutPrice, ['min' => $range['min']]);
                            if ($range['max'] !== null) {
                                $rangeQuery['max'] = $range['max'];
                            }
                            $rangeUrl = $filterAction.'?'.http_build_query($rangeQuery);
                            $rangeSelected = (int) ($filterState['min'] ?? -1) === $range['min'] && (($filterState['max'] === null && $range['max'] === null) || ($filterState['max'] !== null && $range['max'] !== null && (float) $filterState['max'] === (float) $range['max']));
                        @endphp
                        <a href="{{ $rangeUrl }}" class="border px-2.5 py-1.5 text-xs font-semibold transition {{ $rangeSelected ? 'border-bordo bg-bordo/5 text-bordo' : 'border-kraft/35 text-fume/70 hover:border-bordo hover:text-bordo' }}">{{ $range['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </section>

        <section data-filter-accordion data-open class="py-4">
            <button type="button" data-filter-trigger aria-expanded="true" class="flex h-11 w-full items-center justify-between text-left text-[15px] font-bold">
                <span>Gramaj</span><span data-filter-chevron class="text-lg leading-none transition-transform">⌄</span>
            </button>
            <div data-filter-panel class="pt-2">
                @foreach ($filterOptions['weights'] as $option)
                    <label class="group flex min-h-10 cursor-pointer items-center justify-between gap-3 text-sm hover:text-bordo">
                        <span class="flex items-center gap-3"><input type="checkbox" name="agirlik[]" value="{{ $option['value'] }}" class="peer sr-only" @checked(in_array($option['value'], $filterState['weights'], true))><span aria-hidden="true" class="flex h-5 w-5 shrink-0 items-center justify-center border border-kraft/70 text-xs text-transparent peer-checked:border-bordo peer-checked:bg-bordo peer-checked:text-white">✓</span><span>{{ $option['label'] }}</span></span><span class="text-xs text-fume/45">{{ $option['count'] }}</span>
                    </label>
                @endforeach
            </div>
        </section>

        <section data-filter-accordion class="py-4">
            <button type="button" data-filter-trigger aria-expanded="false" class="flex h-11 w-full items-center justify-between text-left text-[15px] font-bold">
                <span>Etiket</span><span data-filter-chevron class="text-lg leading-none transition-transform">⌄</span>
            </button>
            <div data-filter-panel hidden class="pt-2">
                @foreach ($filterOptions['badges'] as $option)
                    <label class="group flex min-h-10 cursor-pointer items-center justify-between gap-3 text-sm hover:text-bordo">
                        <span class="flex items-center gap-3"><input type="checkbox" name="etiket[]" value="{{ $option['value'] }}" class="peer sr-only" @checked(in_array($option['value'], $filterState['badges'], true))><span aria-hidden="true" class="flex h-5 w-5 shrink-0 items-center justify-center border border-kraft/70 text-xs text-transparent peer-checked:border-bordo peer-checked:bg-bordo peer-checked:text-white">✓</span><span>{{ $option['label'] }}</span></span><span class="text-xs text-fume/45">{{ $option['count'] }}</span>
                    </label>
                @endforeach
            </div>
        </section>

        <section data-filter-accordion class="py-4">
            <button type="button" data-filter-trigger aria-expanded="false" class="flex h-11 w-full items-center justify-between text-left text-[15px] font-bold">
                <span>Kategori</span><span data-filter-chevron class="text-lg leading-none transition-transform">⌄</span>
            </button>
            <div data-filter-panel hidden class="pt-2">
                @foreach ($filterOptions['categories'] as $option)
                    <label class="group flex min-h-10 cursor-pointer items-center justify-between gap-3 text-sm hover:text-bordo">
                        <span class="flex items-center gap-3"><input type="checkbox" name="kategori[]" value="{{ $option['value'] }}" class="peer sr-only" @checked(in_array($option['value'], $filterState['categories'], true))><span aria-hidden="true" class="flex h-5 w-5 shrink-0 items-center justify-center border border-kraft/70 text-xs text-transparent peer-checked:border-bordo peer-checked:bg-bordo peer-checked:text-white">✓</span><span>{{ $option['label'] }}</span></span><span class="text-xs text-fume/45">{{ $option['count'] }}</span>
                    </label>
                @endforeach
            </div>
        </section>
    </div>

    <div class="sticky bottom-0 mt-auto grid grid-cols-2 gap-2 border-t border-kraft/30 bg-krem pt-4">
        <button type="submit" class="btn-primary h-12 px-3 text-xs">{{ $mobileSheet ? ($products->total().' ürünü göster') : 'Filtrele' }}</button>
        <a href="{{ $filterAction }}" class="btn-outline h-12 px-3 text-xs">Temizle</a>
    </div>
</form>
