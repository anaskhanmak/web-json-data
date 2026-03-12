<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ $title ?? 'Trademark' }}</title>
<meta name="description" content="{{ $description ?? '' }}">
<meta name="keywords" content="{{ $keywords ?? '' }}">
<link rel="icon" type="images/webp" href="{{ asset('assets/images/logo/fav.webp') }}">

{{-- Preload Hero Banner Image --}}
<link rel="preload" as="image" href="{{ asset('assets/images/banners/hero-banner.webp') }}" fetchpriority="high"
    imagesizes="100vw">
<link rel="preload" as="image" href="{{ asset('assets/images/banners/hero-boys.webp') }}" fetchpriority="high" imagesizes="50vw">




{{-- Fonts CDN --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link rel="preload" as="style"
    href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Montserrat:wght@100..900&display=swap"
    onload="this.onload=null;this.rel='stylesheet'">

<noscript>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Hind:wght@300;400;500;600;700&family=Montserrat:wght@100..900&display=swap">
</noscript>


{{-- Swiper Slider CDN --}}
<link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" as="style"
    onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
</noscript>

{{-- intelinput CDN --}}
<link rel="preload" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.min.css"
    as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@25.3.1/build/css/intlTelInput.min.css">
</noscript>


@vite('resources/css/app.css')
