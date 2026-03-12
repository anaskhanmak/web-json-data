@extends('components.layouts.web.master')

@section('main-content')
    @php
        $hero = $content['hero'] ?? [];
        $about = $content['about'] ?? [];
        $services = $content['services'] ?? [];
    @endphp

    @if (!empty($hero['enabled']))
        <section
            class="hero-banner flex flex-col lg:flex-row items-center justify-center relative bg-black bg-[linear-gradient(153deg,#1a6996_0%,#000000_71%)] text-white">
            <img fetchpriority="high" decoding="async" loading="eager" src="{{ asset($hero['hero-image'] ?? '') }}"
                alt="hero image" width="1187" height="745"
                class="hidden xl:block w-[52vw] h-auto mx-auto absolute bottom-0 z-0 2 xl:right-0 object-contain">
            <div class="cus-container">
                <div class="row">
                    <div class="lg:w-6/12 2xl:w-6/12">
                        <span
                            class="font-montserrat text-white text-sm xl:text-xl 4xl:text-4xl">{{ $hero['top-title'] ?? 'Welcome' }}</span>
                        <h1
                            class="text-white text-3xl md:text-3xl lg:text-5xl 4xl:text-[65px] font-montserrat font-bold mb-0">
                            {{ $hero['title'] ?? 'Welcome' }}
                        </h1>
                        <p
                            class="my-4 min-h-[72px] max-w-[750px] leading-relaxed text-white font-sans 4xl:text-xl xl:text-lg text-sm font-light">
                            {{ $hero['subtitle'] ?? '' }}
                        </p>
                        @if (!empty($hero['CTA_button_text']))
                            <div class="flex gap-3 mt-4 flex-wrap">
                                <a href="{{ $hero['CTA_button_link'] ?? '#' }}" class="btn btn-primary w-full lg:w-auto">{{ $hero['CTA_button_text'] }}</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- About Section Start --}}
    @if (!empty($about['enabled']))
        <section class="pb-0">
            <div class="cus-container relative z-1">
                <div class="row justify-between">
                    <div class="lg:w-5/12 2xl:w-5/12">
                        <h2 class="section-title font-bold">
                            {{ $about['title'] ?? 'About Us' }}
                        </h2>
                        <p>{{ $about['description'] ?? 'About Us' }}</p>
                    </div>
                    <div class="lg:w-5/12 2xl:w-5/12">
                        <ul class="list-inside pl-3 lg:pl-0">
                            @foreach($about['bullets'] ?? [] as $feature)
                            <li class="list-disc font-semibold text-black mb-2"> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        <div class="flex gap-3 mt-4 flex-wrap">
                            @if (!empty($about['button_text']))
                            <a href="#" class="btn btn-primary">{{ $about['button_text'] }}</a>
                            @endif
                            <button type="button" onclick="openChatWidget()" class="btn btn-outline-black">{{ $about['Chat_button_text'] }}</button>

                        </div>
                    </div>
                </div>
            </div>
            <img loading="lazy" src="{{ asset('assets/images/banners/about-1.webp') }}" alt="peoples" width="1920"
                height="772" class=" object-fit-contain hidden xl:block w-full h-auto mx-auto z-0 xl:-mt-37 4xl:-mt-50">
        </section>
    @endif
    {{-- About Section End --}}

    @if (!empty($services['enabled']))
        <section class="bg-slate-50">
            <div class="container py-16 lg:py-20">
                <h2 class="section-title text-center mb-12">
                    {{ $services['title'] ?? 'Our Services' }}
                </h2>
                @php
                    $serviceItems = $services['items'] ?? [];
                    $serviceItems = is_array($serviceItems) ? $serviceItems : [];
                @endphp
                @if (count($serviceItems) > 0)
                    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl mx-auto">
                        @foreach ($serviceItems as $item)
                            <li
                                class="bg-white rounded-lg shadow-sm p-6 text-center font-medium text-slate-800 border border-slate-200">
                                {{ is_string($item) ? $item : json_encode($item) }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </section>
    @endif
@endsection
