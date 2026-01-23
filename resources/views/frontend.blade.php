<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Basmago | Premium Umrah &amp; Hajj Packages</title>
    <meta name="description" content="Premium Umrah &amp; Hajj packages with trusted service, comfortable hotels near Haram, guided experiences, and 24/7 support. Book your sacred journey with confidence." />
    <link rel="canonical" href="{{ url()->current() }}" />

    <meta property="og:type" content="website" />
    <meta property="og:title" content="Basmago | Premium Umrah &amp; Hajj Packages" />
    <meta property="og:description" content="Premium Umrah &amp; Hajj packages with trusted service, comfortable hotels near Haram, guided experiences, and 24/7 support. Book your sacred journey with confidence." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Basmago" />
    <meta property="og:image" content="{{ asset('images/logo.jpeg') }}" />
    <meta property="og:image:alt" content="Basmago" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Basmago | Premium Umrah &amp; Hajj Packages" />
    <meta name="twitter:description" content="Premium Umrah &amp; Hajj packages with trusted service, comfortable hotels near Haram, guided experiences, and 24/7 support. Book your sacred journey with confidence." />
    <meta name="twitter:image" content="{{ asset('images/logo.jpeg') }}" />

    <link rel="icon" href="{{ asset('images/logo.jpeg') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpeg') }}" />

    @php
        $orgSchema = [
            '@' . 'context' => 'https://schema.org',
            '@' . 'type' => 'Organization',
            'name' => 'Basmago',
            'url' => url('/'),
            'logo' => asset('images/logo.jpeg'),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/frontend/main.jsx'])
</head>
<body class="antialiased">
    <div id="app"></div>
</body>
</html>
