<!DOCTYPE html>
<html lang="tr">
<head>
    @php
        $seo = array_merge(\App\Support\Seo::defaults(), $seo ?? []);
        $pageTitle = trim((string) ($seo['title'] ?? 'Ana Sayfa'));
        $fullTitle = str_contains($pageTitle, \App\Support\Seo::SITE_NAME)
            ? $pageTitle
            : $pageTitle.' · '.\App\Support\Seo::SITE_NAME;
        $seoRobots = $seo['robots'] ?? 'index,follow';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="robots" content="{{ $seoRobots }}">
    <title>{{ $fullTitle }}</title>
    @if ($seo['canonical'] !== '' && ! str_starts_with($seoRobots, 'noindex'))
        <link rel="canonical" href="{{ $seo['canonical'] }}">
    @endif
    <meta property="og:site_name" content="{{ \App\Support\Seo::SITE_NAME }}">
    <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    @if ($seo['canonical'] !== '' && ! str_starts_with($seoRobots, 'noindex'))
        <meta property="og:url" content="{{ $seo['canonical'] }}">
    @endif
    @if (! empty($seo['image']))
        <meta property="og:image" content="{{ $seo['image'] }}">
    @endif
    <meta property="og:locale" content="tr_TR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    @if (! empty($seo['image']))
        <meta name="twitter:image" content="{{ $seo['image'] }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..700;1,9..144,400..600&family=Manrope:wght@300..800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::organizationSchema(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode(\App\Support\Seo::websiteSchema(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
</head>
<body>
    <x-site.header />
    <main>@yield('content')</main>
    <x-site.footer />
    @stack('scripts')
</body>
</html>
