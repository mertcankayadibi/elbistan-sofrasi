@if (! empty($filterChips))
    <div class="mb-5 flex flex-wrap items-center gap-2" aria-label="Seçili filtreler">
        @foreach ($filterChips as $chip)
            <a href="{{ $chip['url'] }}" class="inline-flex items-center gap-1 rounded-sm border border-bordo/35 bg-bordo/5 px-2.5 py-1.5 text-xs font-semibold text-bordo hover:bg-bordo hover:text-white" aria-label="{{ $chip['label'] }} filtresini kaldır">{{ $chip['label'] }} <span aria-hidden="true">×</span></a>
        @endforeach
    </div>
@endif
