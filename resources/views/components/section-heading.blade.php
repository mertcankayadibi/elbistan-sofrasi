@props(['eyebrow', 'title', 'link' => null, 'linkLabel' => null])
<div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
    <div>
        <p class="eyebrow mb-3">{{ $eyebrow }}</p>
        <h2>{{ $title }}</h2>
    </div>
    @if ($link && $linkLabel)
        <a class="text-link shrink-0" href="{{ $link }}">{{ $linkLabel }} <x-icon-arrow-right :size="16" /></a>
    @endif
</div>
