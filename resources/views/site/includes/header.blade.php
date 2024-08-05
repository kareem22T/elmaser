@php
    $categories = App\Models\Category::latest()->orderby("isAtNavMain", "desc")->get();
    $months = array(
    "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو",
    "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"
    );

    $days = array(
    "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"
    );
@endphp

<header>
    <nav class="top">
        <div class="container">
            <div class="right">
                <span class="date">
                    {{$days[Carbon\Carbon::parse(now())->dayOfWeek] . ', ' . Carbon\Carbon::parse(now())->day . ' ' . $months[Carbon\Carbon::parse(now())->month - 1] . ', ' . Carbon\Carbon::parse(now())->year}}
                </span>
                <div class="more"><i class="fa-solid fa-ellipsis"></i></div>
                <div class="links">
                    <a href="/about-us"><i class="icon-info"></i> من نحن</a>
                    <a href="/privacy"><ion-icon name="shield-checkmark-outline"></ion-icon> الخصوصية</a>
                    <a href="/contact-us"><ion-icon name="call-outline"></ion-icon> اتصل بنا</a>
                </div>
            </div>
            <div class="left">
                <div class="links">
                    <a href="/about-ads" class="profile">
                        <span>الاعلانات</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-speakerphone" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M18 8a3 3 0 0 1 0 6" />
                            <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                            <path d="M12 8h0l4.524 -3.77a.9 .9 0 0 1 1.476 .692v12.156a.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
                          </svg>
                    </a>
                </div>
                <div class="social">
                    <div class="links">
                        @if(isset($settingsArray["facebook"]) && $settingsArray["facebook"]["value"])
                            <a href="{{$settingsArray["facebook"]["value"]}}" target="_blanck"><img src="{{ asset('assets/imgs/facebook.png') }}"></a>
                        @endif
                        @if(isset($settingsArray["youtube"]) && $settingsArray["youtube"]["value"])
                            <a href="{{$settingsArray["youtube"]["value"]}}" target="_blanck"><img src="{{ asset('assets/imgs/youtube.png') }}"></a>
                        @endif
                        @if(isset($settingsArray["instagram"]) && $settingsArray["instagram"]["value"])
                            <a href="{{$settingsArray["instagram"]["value"]}}" target="_blanck"><img src="{{ asset('assets/imgs/instagram.png') }}"></a>
                        @endif
                        @if(isset($settingsArray["x"]) && $settingsArray["x"]["value"])
                            <a href="{{$settingsArray["x"]["value"]}}" target="_blanck"><img src="{{ asset('assets/imgs/x.png') }}"></a>
                        @endif
                        @if(isset($settingsArray["tiktok"]) && $settingsArray["tiktok"]["value"])
                            <a href="{{$settingsArray["tiktok"]["value"]}}" target="_blanck"><img src="{{ asset('assets/imgs/tiktok.png') }}"></a>
                        @endif
                        @if(isset($settingsArray["snapchat"]) && $settingsArray["snapchat"]["value"])
                            <a href="{{$settingsArray["snapchat"]["value"]}}" target="_blanck"><img src="{{ asset('assets/imgs/snapchat.png') }}"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="head">
        <div class="container">
            <div class="logo_wrapper">
                <a href="/">
                    <img src="{{ asset('/assets/imgs/home-maser-logo.jpg')}}?v={{time()}}" alt="logo" class="logo">
                </a>
                <div class="text">
                    رئيس مجلس الادارة: {{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->manager_name ? App\Models\Editor_master::first()->manager_name : "لم يحدد بعد"}}
                    <br>
                    رئيس التحرير: {{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->name ? App\Models\Editor_master::first()->name : "لم يحدد بعد"}}
                </div>
            </div>
            @if(isset($settingsArray["header_ad"]) && $settingsArray["header_ad"]["value"])
                @if(isset($settingsArray["header_ad_url"]) && $settingsArray["header_ad_url"]["value"])
                    <a href="{{$settingsArray["header_ad_url"]["value"]}}" target="_blank">
                @endif
                <img src="{{$settingsArray["header_ad"]["value"]}}" alt="advertisment" class="head_advertisment">
                @if(isset($settingsArray["header_ad_url"]) && $settingsArray["header_ad_url"]["value"])
                    </a>
                @endif
            @endif
        </div>
    </div>
    <nav class="bottom">
        <div class="container">
            <div class="hide-content"></div>
            <div class="right">
                <div class="more">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="links">
                    <a href="/" class="active">الرئيسية</a>
                    @foreach ($categories as $item)
                        <a href="/category/{{$item->id}}">{{$item->main_name}}</a>
                    @endforeach
                </div>
                <div class="mobil_links" style="overflow: auto">
                    <div class="social" style="margin: 12px;padding: 8px; background: #fff;border-radius: 8px">
                        <div class="links" style="position: relative !important; display: flex; gap: 8px">
                            @if(isset($settingsArray["facebook"]) && $settingsArray["facebook"]["value"])
                                <a href="{{$settingsArray["facebook"]["value"]}}" style="padding: 0 !important;width: max-content !important;" target="_blanck"><img src="{{ asset('assets/imgs/facebook.png') }}" style="width: 30px;border-radius: 4px"></a>
                            @endif
                            @if(isset($settingsArray["youtube"]) && $settingsArray["youtube"]["value"])
                                <a href="{{$settingsArray["youtube"]["value"]}}" style="padding: 0 !important;width: max-content !important;" target="_blanck"><img src="{{ asset('assets/imgs/youtube.png') }}"  style="width: 30px;border-radius: 4px"></a>
                            @endif
                            @if(isset($settingsArray["instagram"]) && $settingsArray["instagram"]["value"])
                                <a href="{{$settingsArray["instagram"]["value"]}}" style="padding: 0 !important;width: max-content !important;" target="_blanck"><img src="{{ asset('assets/imgs/instagram.png') }}"  style="width: 30px;border-radius: 4px"></a>
                            @endif
                            @if(isset($settingsArray["x"]) && $settingsArray["x"]["value"])
                                <a href="{{$settingsArray["x"]["value"]}}" style="padding: 0 !important;width: max-content !important;" target="_blanck"><img src="{{ asset('assets/imgs/x.png') }}"  style="width: 30px;border-radius: 4px"></a>
                            @endif
                            @if(isset($settingsArray["tiktok"]) && $settingsArray["tiktok"]["value"])
                                <a href="{{$settingsArray["tiktok"]["value"]}}" style="padding: 0 !important;width: max-content !important;" target="_blanck"><img src="{{ asset('assets/imgs/tiktok.png') }}"  style="width: 30px;border-radius: 4px"></a>
                            @endif
                            @if(isset($settingsArray["snapchat"]) && $settingsArray["snapchat"]["value"])
                                <a href="{{$settingsArray["snapchat"]["value"]}}" style="padding: 0 !important;width: max-content !important;" target="_blanck"><img src="{{ asset('assets/imgs/snapchat.png') }}"  style="width: 30px;border-radius: 4px"></a>
                            @endif
                        </div>
                    </div>
                    <a href="/" class="active">الرئيسية</a>
                    @foreach ($categories as $item)
                        <a href="/category/{{$item->id}}">{{$item->main_name}}</a>
                    @endforeach
                </div>
            </div>
            <div class="left">
                <a href="" class="more"><i class="fa-solid fa-grip"></i></a>
                <a href=""><i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </nav>
@php
    $important_articles = App\Models\Important_article::orderBy("id", "desc")->get();
@endphp

    <div class="news_slider">
        {{-- <div class="container"> --}}
            <div class="bar" style="width: 100vw;padding: 4px 0">
                @if ($important_articles->count() > 0)
                    <div class="ticker-wrap" style="width: 100%;">

                        <div id="ticker" style="font-weight: 500;font-size: 19px;line-height: 36px;text-align: right;color: #000000;white-space: nowrap;">


                            <div id="ticker-box" style="overflow: hidden; min-height: 40px;">
                                <ul style="padding: 0px; margin: 0px; position: relative; list-style-type: none;">

                                    <li style="display: flex; justify-content: center; align-items: center; gap: 12px;font-size: 14px;font-weight: 500;    position: absolute; white-space: nowrap; right: -3543px; color: rgb(0, 0, 0);">
                                        @foreach ($important_articles as $index => $important)
                                            @if($important && $important->article)
                                            <a href="/article/{{$important->article->id}}" style="text-decoration: none; color:rgb(0, 0, 0); display: inline-flex;justify-content: center; align-items: center;gap: 12px;margin-right: 12px">
                                                {{$important->article->title}}
                                                @if ($index + 1 !== $important_articles->count())
                                                <img src="{{ asset("/site/imgs/logo_t.png")}}" alt="" style="width: 18px">
                                                @endif
                                                </a>
                                            @endif
                                        @endforeach
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
            <script>
                function getBrowser() {
                    var ua = navigator.userAgent;
                    if (ua.indexOf("Chrome") > -1 && ua.indexOf("Edg") === -1 && ua.indexOf("OPR") === -1) {
                        return "Chrome";
                    } else if (ua.indexOf("Firefox") > -1) {
                        return "Firefox";
                    } else if (ua.indexOf("Safari") > -1 && ua.indexOf("Chrome") === -1) {
                        return "Safari";
                    } else if (ua.indexOf("Edg") > -1) {
                        return "Edge";
                    } else if (ua.indexOf("OPR") > -1) {
                        return "Opera";
                    } else {
                        return "Other";
                    }
                }

                var isMobile = window.innerWidth <= 767;
                var browser = getBrowser();
                var speed;

                if (browser === "Chrome") {
                    speed = isMobile ? 11 : 10;
                } else if (browser === "Firefox") {
                    speed = isMobile ? 12 : 1;
                } else {
                    speed = isMobile ? 13 : 10; // Default speed for other browsers
                }

                startTicker('ticker-box', {speed: speed, delay: 500});
            </script>

          </div>
    {{-- </div> --}}
    <form method="GET" action="/search" class="search" style="position: fixed;top: 0;left: 0;width: 100%;height: 100vh;background: #0000003b;z-index: 99999999999999;padding: 1rem;box-sizing: border-box;">
        <!-- Added v-model binding and @input event handler for search functionality -->
        <div class="hide-content-2" style="position: fixed;width: 100%;height: 100vh;top: 0;left: 0;background: #0003;z-index: 9999"></div>
        <input type="text" name="s"style="width: 100%;z-index: 999999;position: relative;text-align: right;direction: rtl;padding: 10px;border-radius: 8px;" id="search" placeholder="بحث ..." v-model="search" @input="handleSearch">
        <button type="submit" style="transform: none;top: 28px;left: 28px;z-index: 99999991;position: absolute;" >
            بحث
            <i class="fa fa-search"></i>
        </button>
        <!-- Added suggestion box for search results -->
    </form>
</header>

