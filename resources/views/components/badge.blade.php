@props(['label', 'tone' => 'bordo'])
<span {{ $attributes->class(['inline-flex items-center rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-[.12em]', 'bg-bordo text-white' => $tone === 'bordo', 'bg-kraft/30 text-fume' => $tone === 'kraft', 'bg-zeytin/10 text-zeytin' => $tone === 'zeytin']) }}>{{ $label }}</span>
