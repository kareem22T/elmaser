@extends('site.layouts.main')

@section('title', 'الرئيسية')

@section('content')

<section class="main">

    @if(isset($settingsArray["main_right"]) && $settingsArray["main_right"]["value"])
        @if(isset($settingsArray["main_right_url"]) && $settingsArray["main_right_url"]["value"])
            <a href="{{$settingsArray["main_right_url"]["value"]}}" target="_blank" class="ad">
        @endif
            <img src="{{$settingsArray["main_right"]["value"]}}" alt="" class="ad">
        @if(isset($settingsArray["main_right_url"]) && $settingsArray["main_right_url"]["value"])
            </a>
        @endif
    @endif
    <div>
        <div class="container">
            @if(isset($settingsArray["hero_first_ad"]) && $settingsArray["hero_first_ad"]["value"])
            <div class="top_ad">
                    @if(isset($settingsArray["hero_first_ad_url"]) && $settingsArray["hero_first_ad_url"]["value"])
                        <a href="{{$settingsArray["hero_first_ad_url"]["value"]}}" target="_blank">
                    @endif
                        <img src="{{$settingsArray["hero_first_ad"]["value"]}}" alt="">
                    @if(isset($settingsArray["hero_first_ad_url"]) && $settingsArray["hero_first_ad_url"]["value"])
                        </a>
                    @endif
                </div>
            @endif
            @php
                $main_articles = App\Models\Home_article::all();
                $trend = App\Models\Article::latest()->where("isTrend", true)->take(15)->get();
            @endphp
            <div class="main_articles">
                @if ($main_articles->count() > 0)
                <div class="swiper mainSlider">
                    <div class="swiper-wrapper">
                        @foreach ($main_articles as $item)
                        @php
                            $main_article = App\Models\Article::find($item->article_id);
                        @endphp
                        <div class="swiper-slide">
                            <a href="/article/{{$main_article->id}}">
                                <img src="{{$main_article->thumbnail_path}}" alt="">
                            </a>
                            <div class="text" style="width: 100%">
                                <div class="head">
                                    <a href="/category/{{$main_article->category->id}}" style="color: #fff; text-decoration: none">
                                        <i class="fa-solid fa-list"></i> {{ $main_article->category->main_name }}
                                    </a>
                                </div>
                                <a href="/article/{{$main_article->id}}" style="width: 100%;display: block;text-decoration: none;">
                                    <p>
                                        <span>{{ $main_article->title }}</span>
                                    </p>
                                </a>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                @endif
                @if(isset($settingsArray["square_ad"]) && $settingsArray["square_ad"]["value"])
                    <div class="side-ad">
                        @if(isset($settingsArray["square_ad_url"]) && $settingsArray["square_ad_url"]["value"])
                            <a href="{{$settingsArray["square_ad_url"]["value"]}}" target="_blank" style="text-decoration: none">
                        @endif
                            <img src="{{$settingsArray["square_ad"]["value"]}}" alt="">
                        @if(isset($settingsArray["square_ad_url"]) && $settingsArray["square_ad_url"]["value"])
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            <div class="digital_coins">
                <div>
                    @if(isset($settingsArray["gold_24"]) && $settingsArray["gold_24"]["value"] && isset($settingsArray["gold_21"]) && $settingsArray["gold_21"]["value"]&& isset($settingsArray["gold_18"]) && $settingsArray["gold_18"]["value"])
                    <div class="prices">
                        <h2><ion-icon name="pricetags-outline"></ion-icon> اسعار اليوم</h2>
                        <div>
                            <h4><img src="./assets/imgs/gold_icon.png" alt=""> الذهب عيار 18: <span>{{$settingsArray["gold_24"]["value"]}} ج</span></h4>
                            <h4><img src="./assets/imgs/gold_icon.png" alt=""> الذهب عيار 21: <span>{{$settingsArray["gold_21"]["value"]}} ج</span></h4>
                            <h4><img src="./assets/imgs/gold_icon.png" alt=""> الذهب عيار 24: <span>{{$settingsArray["gold_18"]["value"]}} ج</span></h4>
                        </div>
                    </div>
                    @endif
                    @if(isset($settingsArray["horizon_sec_ad"]) && $settingsArray["horizon_sec_ad"]["value"])
                        <div class="top_ad">
                            @if(isset($settingsArray["horizon_sec_ad_url"]) && $settingsArray["horizon_sec_ad_url"]["value"])
                                <a href="{{$settingsArray["horizon_sec_ad"]["value"]}}" target="_blank" style="text-decoration: none">
                            @endif
                                <img src="{{$settingsArray["horizon_sec_ad"]["value"]}}" alt="">
                            @if(isset($settingsArray["horizon_sec_ad_url"]) && $settingsArray["horizon_sec_ad_url"]["value"])
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
                @if(isset($settingsArray["square_sm_ad"]) && $settingsArray["square_sm_ad"]["value"])
                    <div class="ad-left-2">
                        @if(isset($settingsArray["square_sm_ad_url"]) && $settingsArray["square_sm_ad_url"]["value"])
                            <a href="{{$settingsArray["square_sm_ad_url"]["value"]}}" target="_blank" style="text-decoration: none">
                        @endif
                            <img src="{{$settingsArray["square_sm_ad"]["value"]}}" alt="">
                        @if(isset($settingsArray["square_sm_ad_url"]) && $settingsArray["square_sm_ad_url"]["value"])
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            @php
            $latest_news = App\Models\Article::latest()->take(15)->get();

            $months = array(
                "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو",
                "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"
                );

            $days = array(
            "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"
            );
            $more_visited = App\Models\Visit::with(['article' => function ($query) {
                $query->where('isDraft', false);
            }])
            ->orderBy('total_visits', 'desc')
            ->take(6)
            ->get();
        @endphp
        @if($trend->count() > 0)
            <div class="trend">
                <h1 class="head-light head"><i class="fa-solid fa-bolt"></i>تريند المصير اليوم <span class="line"></span></h1>
                <div class="swiper trendSlider">
                    <div class="swiper-wrapper">
                        @foreach ($trend as $article)

                        <div class="swiper-slide">
                            <a href="/article/{{$article->id}}" class="img">
                                <img src="{{$articel->thumbnail_path}}" alt="">
                            </a>
                            <div class="text">
                                <a  href="/category/{{$article->category}}">
                                    <h4 class="head-eg">{{ $article->category->main_name }}</h4>
                                </a>
                                <a  href="/article/{{$article->id}}">
                                    <p>{{ $article->title }}</p>
                                </a>
                                <span class="date"><i class="fa-regular fa-calendar-days"></i>
                                    {{ $days[Carbon\Carbon::parse($article->created_at)->dayOfWeek] . ', ' . Carbon\Carbon::parse($article->created_at)->day . ' ' . $months[Carbon\Carbon::parse($article->created_at)->month - 1] . ', ' . Carbon\Carbon::parse($article->created_at)->year}}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            @endif
        </div>
        @if($latest_news->count() > 0)
            <div class="borsa">
                <div class="container">
                    <h1 class="head-dark head"><i class="fa-solid fa-chart-simple"></i>اهم اخبار اليوم <span class="line"></span></h1>
                    <div class="swiper borsaSlider">
                        <div class="swiper-wrapper">
                            @foreach ($latest_news as $item)
                            <a href="article/{{$item->id}}" class="swiper-slide">
                                <div class="img">
                                    <img src="{{$item->thumbnail_path}}" alt="">
                                </div>
                                <div class="text">
                                    <p>{{ $item->title }}</p>
                                    <span class="date">{{ $days[Carbon\Carbon::parse($item->created_at)->dayOfWeek] . ', ' . Carbon\Carbon::parse($item->created_at)->day . ' ' . $months[Carbon\Carbon::parse($item->created_at)->month - 1] . ', ' . Carbon\Carbon::parse($item->created_at)->year}}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        @endif
        <div class="economics">
            <div class="container">
                @if ($categories_per_home && count($categories_per_home )> 0)
                    @foreach (array_slice($categories_per_home, 0, 4) as $index => $category)
                        <div>
                            <h4>{{$category->main_name}} <ion-icon name="ellipsis-horizontal-outline"></ion-icon></h4>
                            @foreach($category->articles as $index => $article)
                                <a href="/article/{{$article->id}}" class="{{ $index === 0 ? 'main-article eg' : '' }}" style="{{'border-color:' . $category->color}}">
                                    <div class="img">
                                        <img src="{{ $article->thumbnail_path }}" alt="">
                                    </div>
                                    <p>{{ $article->title }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="container">
            @if(isset($settingsArray["horizon_third_ad"]) && $settingsArray["horizon_third_ad"]["value"])
                    <div class="top_ad">
                        @if(isset($settingsArray["horizon_third_ad_url"]) && $settingsArray["horizon_third_ad_url"]["value"])
                            <a href="{{$settingsArray["horizon_third_ad"]["value"]}}" target="_blank" style="text-decoration: none">
                        @endif
                            <img src="{{$settingsArray["horizon_third_ad"]["value"]}}" alt="">
                        @if(isset($settingsArray["horizon_third_ad_url"]) && $settingsArray["horizon_third_ad_url"]["value"])
                            </a>
                        @endif
                    </div>
                @endif
        </div>
        @if($more_visited && $more_visited->count() > 3)
            <div class="most-read">
                <div class="container">
                    <h1 class="head-dark head"><i class="fa-solid fa-arrow-trend-up"></i> الاخبار الاكثر قرائة <span class="line"></span></h1>
                    <div class="news">
                        @foreach ($more_visited as $visit)
                        @if($visit->article)
                        <div>
                            <a href="article/{{ $visit->article->id }}" class="img">
                                <img src="{{ $visit->article->thumbnail_path }}" alt="">
                            </a>
                            <div class="text">
                                <a href="category/{{ $visit->article->category->id }}"> {{ $visit->article->category->main_name }} <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                <a href="article/{{ $visit->article->id }}">{{ $visit->article->title }}</a>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @if ($categories_per_home && count($categories_per_home )> 0)
        @foreach (array_slice($categories_per_home, 4) as $index => $category)
            <div class="borsa-2">
                <div class="container">
                    <h1 class="head-dark head"><i class="fa-solid fa-chart-simple"></i>{{$category->main_name}} <span class="line"></span>
                    </h1>
                    <div class="swiper borsaSlider"  dir="rtl">
                        <div class="swiper-wrapper">
                            @foreach($category->articles as $index => $article)
                                <a href="/article/{{$article->id}}" class="swiper-slide" style="text-decoration: none">
                                    <div class="img">
                                        <img src="./assets/imgs/trend.jpg" alt="">
                                    </div>
                                    <div class="text">
                                        <p>{{ $article->title }}</p>
                                        <span class="date">{{ $days[Carbon\Carbon::parse($article->created_at)->dayOfWeek] . ', ' . Carbon\Carbon::parse($article->created_at)->day . ' ' . $months[Carbon\Carbon::parse($article->created_at)->month - 1] . ', ' . Carbon\Carbon::parse($article->created_at)->year}}</span>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    </div>
    @if(isset($settingsArray["main_left"]) && $settingsArray["main_left"]["value"])
        @if(isset($settingsArray["main_left_url"]) && $settingsArray["main_left_url"]["value"])
            <a href="{{$settingsArray["main_left_url"]["value"]}}" target="_blank" class="ad">
        @endif
            <img src="{{$settingsArray["main_left"]["value"]}}" alt="" class="ad">
        @if(isset($settingsArray["main_left_url"]) && $settingsArray["main_left_url"]["value"])
            </a>
        @endif
    @endif
</section>
@endsection
