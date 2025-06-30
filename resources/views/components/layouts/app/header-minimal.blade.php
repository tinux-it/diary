store
@props([
    'title' => 'My Title',
    'metaDescription' => 'Default description about your site or app here.',
    'metaKeywords' => 'reservations, horeca, beauty, time management',
    'metaRobots' => 'index, follow',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')

    <title>{{ $metaTitle ?? $title }}</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="{{ $metaTitle ?? $title }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('images/logo.svg') }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $metaTitle ?? $title }}" />
    <meta name="twitter:description" content="{{ $metaDescription }}" />
    <meta name="twitter:image" content="{{ asset('images/logo.svg') }}" />

    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
{{ $slot }}
@stack('scripts')
@fluxScripts
</body>
</html>
