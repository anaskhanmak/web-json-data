@extends('components.layouts.web.master')

@section('main-content')
    {{-- Hero Banner --}}
    <section
        class="bg-no-repeat bg-center bg-cover min-h-[calc(100dvh-clamp(102px,11vw,103px))] overflow-hidden lg:py-4 z-10 flex flex-col lg:flex-row items-center justify-center relative xl:pb-0 lg:bg-cover lg:bg-center bg-black bg-[linear-gradient(153deg,#1a6996_0%,#000000_71%)] lg:bg-[url('https://trademarkace.com/assets/images/banners/hero-banner.webp')] bg-no-repeat bg-center bg-cover">
        <img fetchpriority="high" decoding="async" loading="eager"
            src="https://trademarkace.com/assets/images/banners/hero-boys.webp" alt="hero image" width="1187" height="745"
            class="hidden xl:block w-[52vw] h-auto mx-auto absolute bottom-0 z-0 2 xl:right-0 object-contain">
        <div class="cus-container">
            <div class="row">
                <div class="lg:w-6/12 2xl:w-6/12">
                    <span class="font-montserrat text-white text-sm xl:text-xl 4xl:text-4xl">Register <span
                            class="text-secondary font-bold">and</span> Protect</span>
                    <h1 class="text-white text-3xl md:text-3xl lg:text-5xl 4xl:text-[65px] font-montserrat font-bold mb-0">
                        Your Business Identity With
                        <span class="text-secondary">Trademark Ace</span><br>

                    </h1>
                    <p
                        class="my-4 min-h-[72px] max-w-[750px] leading-relaxed text-white font-sans 4xl:text-xl xl:text-lg text-sm font-light capitalize">
                        Secure your brand identity with expert trademark registration, monitoring, and legal support from
                        Trademark Ace.</p>
                    <div class="flex gap-0 md:gap-7 4xl:gap-20 w-full flex-wrap">
                        <ul class="min-h-[68px]">
                            <li class="flex items-center gap-3 text-white font-hind 4xl:text-xl text-sm font-medium mb-2">
                                <img src="https://trademarkace.com/assets/images/icons/check.svg" alt="check icon"
                                    width="20" height="20"> Free trademark availability search
                            </li>
                            <li class="flex items-center gap-3 text-white font-hind 4xl:text-xl text-sm font-medium mb-2">
                                <img src="https://trademarkace.com/assets/images/icons/check.svg" alt="check icon"
                                    width="20" height="20"> Fast and accurate application filing
                            </li>
                        </ul>
                        <ul>
                            <li class="flex items-center gap-3 text-white font-hind 4xl:text-xl text-sm font-medium mb-2">
                                <img src="https://trademarkace.com/assets/images/icons/check.svg" alt="check icon"
                                    width="20" height="20"> Expert handling of office actions
                            </li>
                            <li class="flex items-center gap-3 text-white font-hind 4xl:text-xl text-sm font-medium mb-2">
                                <img src="https://trademarkace.com/assets/images/icons/check.svg" alt="check icon"
                                    width="20" height="20"> Complete brand protection solutions
                            </li>
                        </ul>
                    </div>
                    <div class="flex gap-3 mt-4 flex-wrap">
                        <a href="#" class="btn btn-primary w-full lg:w-auto">Start My Trademark
                            Registration</a>
                        <button type="button" onclick="openChatWidget()"
                            class="btn btn-outline-white w-full lg:w-auto">Live Chat</button>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
