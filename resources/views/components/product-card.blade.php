@props(['product'])
@php
    $discount = $product['old_price'] ? round((1 - $product['price'] / $product['old_price']) * 100) : null;
    $rating = (float) $product['rating'];
    $fullStars = (int) floor($rating);
    $hasHalf = ($rating - $fullStars) >= 0.4;
    $emptyStars = max(0, 5 - $fullStars - ($hasHalf ? 1 : 0));
@endphp
<article class="product-card group flex min-w-0 flex-col" data-product-card data-groups="{{ implode(',', $product['groups']) }}">
    <div class="product-card__media relative aspect-[4/3] overflow-hidden">
        <a href="{{ route('product.show', $product['slug']) }}" class="block h-full w-full" aria-label="{{ $product['name'] }} ürününü incele">
            <img src="{{ asset('images/' . $product['image']) }}" alt="{{ $product['name'] }}" width="900" height="900" loading="lazy" class="h-full w-full object-cover">
        </a>
        @if ($product['badge'])
            <span class="absolute left-2.5 top-2.5 bg-bordo px-2 py-0.5 text-[10px] font-bold uppercase tracking-[.08em] text-white">{{ $product['badge'] }}</span>
        @endif
        <button type="button" data-favorite-toggle aria-label="{{ $product['name'] }} ürününü favorilere ekle" aria-pressed="false" class="favorite-toggle absolute right-2 top-2 flex h-9 w-9 items-center justify-center rounded-full bg-white/88 text-fume/70 shadow-[0_2px_10px_-4px_rgba(41,37,34,.5)] backdrop-blur-sm transition hover:text-bordo"><x-icon-heart :size="19" /></button>
    </div>

    <div class="flex flex-1 flex-col px-3.5 pb-3.5 pt-2.5">
        <a href="{{ route('product.show', $product['slug']) }}" title="{{ $product['name'] }}" class="product-card__name">{{ $product['name'] }}</a>
        <p class="product-card__variant">{{ $product['weight'] }}</p>

        <div class="product-card__rating">
            <span class="product-card__stars">
                @for ($i = 0; $i < $fullStars; $i++)
                    <x-icon-star :size="13" class="fill-current" />
                @endfor
                @if ($hasHalf)
                    <span class="product-card__half"><x-icon-star :size="13" class="fill-current" /></span>
                @endif
                @for ($i = 0; $i < $emptyStars; $i++)
                    <x-icon-star :size="13" class="product-card__star-empty" />
                @endfor
            </span>
            <span class="product-card__count">({{ $product['reviews'] }})</span>
            <span class="sr-only">{{ $product['rating'] }} / 5 puan, {{ $product['reviews'] }} değerlendirme</span>
        </div>

        <div class="product-card__price">
            <span>{{ \App\Support\Catalog::formatPrice($product['price']) }}</span>
            @if ($discount)
                <span class="product-card__off">%{{ $discount }}</span>
            @endif
        </div>

        <button type="button" data-add-to-cart class="product-card__action" data-product-slug="{{ $product['slug'] }}"><x-icon-cart :size="16" /><span data-cart-label>Sepete Ekle</span></button>
    </div>
</article>
