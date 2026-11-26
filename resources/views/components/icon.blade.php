@props(['name', 'size' => 20, 'class' => ''])

<svg {{ $attributes->merge(['class' => $class, 'width' => $size, 'height' => $size, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'aria-hidden' => 'true']) }} xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
    @switch($name)
        @case('search') <circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/> @break
        @case('user') <circle cx="12" cy="8" r="3.5"/><path d="M5 21a7 7 0 0 1 14 0"/> @break
        @case('heart') <path d="M20.8 8.7c0 5.2-8.8 10.2-8.8 10.2S3.2 13.9 3.2 8.7A4.6 4.6 0 0 1 12 6.4a4.6 4.6 0 0 1 8.8 2.3Z"/> @break
        @case('cart') <path d="M3 4h2l2.1 10.2a2 2 0 0 0 2 1.6h7.5a2 2 0 0 0 1.9-1.4L20 8H6"/><circle cx="9" cy="20" r="1"/><circle cx="17" cy="20" r="1"/> @break
        @case('menu') <path d="M4 7h16M4 12h16M4 17h16"/> @break
        @case('close') <path d="m6 6 12 12M18 6 6 18"/> @break
        @case('truck') <path d="M3 6h11v10H3zM14 10h4l3 3v3h-7z"/><circle cx="7" cy="19" r="1.5"/><circle cx="18" cy="19" r="1.5"/> @break
        @case('leaf') <path d="M20 4C11 4 5 8 5 15c0 2.8 2 5 5 5 7 0 10-7 10-16Z"/><path d="M4 20c3-5 7-8 13-11"/> @break
        @case('sun') <circle cx="12" cy="12" r="3.5"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/> @break
        @case('shield') <path d="M12 3 20 6v5c0 5.2-3.4 8.4-8 10-4.6-1.6-8-4.8-8-10V6l8-3Z"/><path d="m8.5 12 2.3 2.3 4.8-5"/> @break
        @case('star') <path d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"/> @break
        @case('arrow-right') <path d="M4 12h15M13 6l6 6-6 6"/> @break
        @case('plus') <path d="M12 5v14M5 12h14"/> @break
        @case('minus') <path d="M5 12h14"/> @break
        @case('check') <path d="m5 12 4 4L19 6"/> @break
        @case('hand') <path d="M7 11V6a1.5 1.5 0 0 1 3 0v4M10 10V4.5a1.5 1.5 0 0 1 3 0V10M13 10V6a1.5 1.5 0 0 1 3 0v5M16 11V8.5a1.5 1.5 0 0 1 3 0V14c0 4-2.7 7-6.5 7h-1C8 21 5 17.8 5 14v-2a1.5 1.5 0 0 1 3 0"/> @break
        @case('instagram') <rect x="4" y="4" width="16" height="16" rx="4"/><circle cx="12" cy="12" r="3.5"/><circle cx="17.5" cy="6.5" r=".7" fill="currentColor" stroke="none"/> @break
        @case('whatsapp') <path d="M20 11.5a8 8 0 0 1-11.8 7L4 20l1.5-4A8 8 0 1 1 20 11.5Z"/><path d="M9 8.5c.3-.5.7-.5 1-.1l.9 1c.2.3.2.6 0 .9l-.5.6c.6 1.1 1.5 2 2.7 2.5l.5-.6c.2-.3.6-.4.9-.2l1.1.7c.4.3.4.7.1 1.1-.4.6-1 1-1.7 1-2.9-.3-5.9-3.1-6.2-5.9 0-.4.3-.8 1.2-1Z"/> @break
        @case('youtube') <path d="M20.5 7.3a2.2 2.2 0 0 0-1.5-1.5C17.7 5.5 12 5.5 12 5.5s-5.7 0-7 .3a2.2 2.2 0 0 0-1.5 1.5C3.2 8.5 3.2 12 3.2 12s0 3.5.3 4.7A2.2 2.2 0 0 0 5 18.2c1.3.3 7 .3 7 .3s5.7 0 7-.3a2.2 2.2 0 0 0 1.5-1.5c.3-1.2.3-4.7.3-4.7s0-3.5-.3-4.7Z"/><path d="m10 9 5 3-5 3V9Z"/> @break
        @default <circle cx="12" cy="12" r="8"/>
    @endswitch
</svg>
