@extends('site.layouts.main')

@section('title', $search_word ?? "")

@section('content')
@if($articles)

<section class="main">
    @php
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
        ->take(4)
        ->get();
        $latest = App\Models\Article::latest()->where('isDraft', false)
        ->take(4)
        ->get();

    @endphp

    @if(isset($settingsArray["main_right"]) && $settingsArray["main_right"]["value"])
        @if(isset($settingsArray["main_right_url"]) && $settingsArray["main_right_url"]["value"])
            <a href="{{$settingsArray["main_right_url"]["value"]}}" target="_blank" class="ad">
        @endif
            <img src="{{$settingsArray["main_right"]["value"]}}" alt="" class="ad">
        @if(isset($settingsArray["main_right_url"]) && $settingsArray["main_right_url"]["value"])
            </a>
        @endif
    @endif
    <div class="container">
        @if(isset($settingsArray["hero_first_ad"]) && $settingsArray["hero_first_ad"]["value"])
        <div class="top_ad" style="margin-top: 16px">
                @if(isset($settingsArray["hero_first_ad_url"]) && $settingsArray["hero_first_ad_url"]["value"])
                    <a href="{{$settingsArray["hero_first_ad_url"]["value"]}}" target="_blank">
                @endif
                    <img src="{{$settingsArray["hero_first_ad"]["value"]}}" alt="">
                @if(isset($settingsArray["hero_first_ad_url"]) && $settingsArray["hero_first_ad_url"]["value"])
                    </a>
                @endif
            </div>
        @endif

        @if(isset($search_word) && $search_word)
            <div class="container" dir="rtl">
                @if($search_word)
                <h1 >مقالات : {{ $search_word}}</h1>
                <input type="hidden" name="search_words" id="search_words" value="{{ $search_word}}">
                @endif
                @if($author_desc)
                <p>{{$author_desc}}</p>
                @endif
            </div>
            <input type="hidden" name="search_words" id="search_words" value="{{ $search_word}}">
        @endif

        <div class="category_wrapper">
            <div class="articles_wrapper">
                @foreach ($articles as $article)
                <a href="/article/{{$article->id}}" class="article">
                    <img src="{{$article->thumbnail_path}}" alt="">
                    <span>
                        {{ $article->title }}
                    </span>
                    <span class="date">{{ $days[Carbon\Carbon::parse($article->created_at)->dayOfWeek] . ', ' . Carbon\Carbon::parse($article->created_at)->day . ' ' . $months[Carbon\Carbon::parse($article->created_at)->month - 1] . ', ' . Carbon\Carbon::parse($article->created_at)->year}}</span>
                </a>
                @endforeach
            </div>
            <div class="side" style="margin-top: 16px">
                @if($more_visited && $more_visited->count() > 3)
                    <div class="head" style="background: #0168b3; color: #fff; font-size: 26px;font-weight: 700;padding: 8px">
                         الاكثر قراءة
                    </div>
                    <div class="side_articles">
                        @foreach ($more_visited as $visit)
                        @if($visit->article)
                            <a href="/article/{{ $visit->article->id }}" class="article">
                                <img src="{{ $visit->article->thumbnail_path }}" alt="">
                                <div class="text">
                                    <i class="fa-solid fa-angle-left"></i>
                                    {{ $visit->article->title }}
                                </div>
                            </a>

                        @endif
                        @endforeach
                    </div>
                @endif
                @if(isset($settingsArray["square_sm_ad"]) && $settingsArray["square_sm_ad"]["value"])
                    <div class="ad-left-2" style="margin: 16px 0">
                        @if(isset($settingsArray["square_sm_ad_url"]) && $settingsArray["square_sm_ad_url"]["value"])
                            <a href="{{$settingsArray["square_sm_ad_url"]["value"]}}" target="_blank" style="text-decoration: none">
                        @endif
                            <img src="{{$settingsArray["square_sm_ad"]["value"]}}" style="width: 100%; ">
                        @if(isset($settingsArray["square_sm_ad_url"]) && $settingsArray["square_sm_ad_url"]["value"])
                            </a>
                        @endif
                    </div>
                @endif
                @if($latest && $latest->count() > 3)
                    <div class="head" style="background: #0168b3; color: #fff; font-size: 26px;font-weight: 700;padding: 8px">
                        اخر الاخبار
                    </div>
                    <div class="side_articles">
                        @foreach ($latest as $article)
                            <a href="/article/{{ $article->id }}" class="article">
                                <img src="{{ $article->thumbnail_path }}" alt="">
                                <div class="text">
                                    <i class="fa-solid fa-angle-left"></i>
                                    {{ $article->title }}
                                </div>
                            </a>

                        @endforeach
                    </div>
                @endif
            </div>
    </div>

        <div class="pagination_wrapper" style="margin-bottom: 16px !important">
            {!! $articles->links('pagination::bootstrap-4') !!}
        </div>
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
    <br>
    <br>
    <br>
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
@endif
{{-- <section class="more">
    <div class="container">
        <div>
            <span>اقرأ المزيد من جميع الاقسام</span>
            عاجل _ الاخبار  _ سياسة _ رآي _ فن وثقافة
            المرآة _ رياضة _ حوادث _ اقتصاد _ تحقيقات _ منوعات
        </div>
    </div>
</section> --}}
@endsection

@section('scripts')
@endsection
