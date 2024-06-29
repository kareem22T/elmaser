@extends('site.layouts.main')

@section('title', 'الرئيسية')

@section('content')
@php
    $important_articles = App\Models\Important_article::all();
@endphp
@php
$more_visited = App\Models\Visit::with(['article' => function ($query) {
    $query->where('isDraft', false);
}])
->orderBy('total_visits', 'desc')
->take(4)
->get();
@endphp

<main class="home">
    <div class="container">
        <div class="col-1">
            @if ($ads)
                <div class="ad_wrapper">
                    <section class="ad main">
                        @if ($ads->main_ad)
                        <img src="{{ '/images/uploads/ads/' . $ads->main_ad }}" alt="">
                        @endif
                    </section>
                </div>
            @endif
                @if($latestArticles && count($latestArticles) > 0)
                <section class="latest">
                    <div class="cat-head">
                        <div class="cat">
                            الاحدث
                        </div>
                        <span></span>
                    </div>
                        @foreach ($latestArticles as $article)
                            <a href="/article/{{$article->id}}" class="card">
                                <p>
                                    {{ $article->title }}
                                </p>
                                <div class="img">
                                    <img src="{{ $article->thumbnail_path }}" alt="">
                                </div>
                            </a>
                        @endforeach
                    @if($more_visited && $more_visited->count() > 3)
                    <div class="cat-head" style="margin-top: 30px;">
                        <div class="cat">
                            الاكثر قراءة
                        </div>
                        <span></span>
                    </div>
                    @foreach ($more_visited as $visit)
                        {{-- Check if the associated article exists --}}
                        @if($visit->article)
                            <a href="/article/{{ $visit->article->id }}" class="card">
                                <p>
                                    {{ $visit->article->title }}
                                </p>
                                <div class="img">
                                    <img src="{{ $visit->article->thumbnail_path }}" alt="">
                                </div>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endif
            </section>
        </div>
        <div class="col-2">
            @php
                $main_articles = App\Models\Home_article::all();
            @endphp
            @if ($main_articles->count() > 0)
            <div class="swiper mainSwiper">
                <div class="swiper-wrapper">
                    @foreach ($main_articles as $item)
                    @php
                        $main_article = App\Models\Article::find($item->article_id);
                    @endphp
                    <a href="/article/{{$main_article->id}}" target="_blanck" class="swiper-slide">
                        <div class="thumbnail">
                            <img src="{{$main_article->thumbnail_path}}" alt="">
                        </div>
                        <div class="text">
                            <h2>{{ $main_article->title }}</h2>
                            <h2 class="sub-title">{{ $main_article->sub_title }}</h2>
                            <p>
                                <span>كتب: {{$main_article->author_name}}</span><br>
                                {{Illuminate\Support\Str::limit($main_article->intro, 195)}}
                            </p>

                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="mainSwiper-swiper-button-next"><i class="fa-solid fa-angle-right"></i></div>
                <div class="mainSwiper-swiper-button-prev"><i class="fa-solid fa-angle-left"></i></div>
                <div class="mainSwiper-swiper-pagination"></div>
            </div>
            @endif
            @if ($ads)
                <div class="ad_wrapper main_ad">
                    <section class="ad">
                        @if ($ads->main_ad)
                        <img src="{{ '/images/uploads/ads/' . $ads->main_ad }}" alt="">
                        @endif
                    </section>
                </div>
            @endif


            <section class="categories">
                @if ($categories_per_home && count($categories_per_home )> 0)
                    @foreach ($categories_per_home as $index => $category)
                        <div class="swiper catSwiper">
                            <div class="swiper-wrapper">
                                @foreach ($category?->articles as $article)
                                    <div class="swiper-slide">
                                        <a href="/article/{{$article->id}}" class="thumbnail">
                                            <img src="{{ $article->thumbnail_path }}" alt="">
                                        </a>
                                        <div class="text">
                                            <div class="cat-head">
                                                <span></span>
                                                <a href="category/{{$category?->id}}"  class="cat">
                                                    {{$category?->main_name}}
                                                </a>
                                            </div>
                                            <a href="/article/{{$article->id}}"  dir="rtl">
                                                {{Illuminate\Support\Str::limit($article->title, 85)}}
                                            </a>
                                        </div>
                                    </div>
                                    @endforeach
                                    <a href="/category/{{$category?->id}}" class="swiper-slide last-slide" style="flex-direction: column;width: 513px; margin-right: 30px;display: flex;justify-content: center;align-items: center;font-size: 25px;font-weight: 700;color: var(--secondary-color); ">
                                        {!! $category?->icon !!}
                                        عرض كل مقالات قسم {{ $category?->main_name}}
                                    </a>
                            </div>
                            <div class="navYpag">
                                <div class="mainSwiper-swiper-button-prev"><i class="fa-solid fa-angle-left"></i></div>
                                <div class="mainSwiper-swiper-pagination"></div>
                                <div class="mainSwiper-swiper-button-next"><i class="fa-solid fa-angle-right"></i></div>
                            </div>
                        </div>
                        @if ($ads && $index == 1)
                            <div class="ad_wrapper" style="margin-bottom: 1rem">
                                <section class="ad">
                                    @if ($ads->mobile_ad_1)
                                    <img src="{{ '/images/uploads/ads/' . $ads->mobile_ad_1 }}?v={{time()}}" alt="">
                                    @endif
                                </section>
                            </div>
                        @endif
                    @endforeach
                @endif
            </section>
            @if ($ads)
                <div class="ad_wrapper">
                    <section class="ad">
                        @if ($ads->mobile_ad_2)
                        <img src="{{ '/images/uploads/ads/' . $ads->mobile_ad_2 }}?v={{time()}}" alt="">
                        @endif
                    </section>
                </div>
            @endif
                @if($latestArticles && count($latestArticles) > 0)
                <section class="latest">
                    <div class="cat-head">
                        <div class="cat">
                            الاحدث
                        </div>
                        <span></span>
                    </div>
                        @foreach ($latestArticles as $article)
                            <a href="/article/{{$article->id}}" class="card">
                                <p>
                                    {{ $article->title }}
                                </p>
                                <div class="img">
                                    <img src="{{ $article->thumbnail_path }}" alt="">
                                </div>
                            </a>
                        @endforeach
                    @if($more_visited && $more_visited->count() > 3)
                    <div class="cat-head" style="margin-top: 30px;">
                        <div class="cat">
                            الاكثر قراءة
                        </div>
                        <span></span>
                    </div>
                    @foreach ($more_visited as $visit)
                        {{-- Check if the associated article exists --}}
                        @if($visit->article)
                            <a href="/article/{{ $visit->article->id }}" class="card">
                                <p>
                                    {{ $visit->article->title }}
                                </p>
                                <div class="img">
                                    <img src="{{ $visit->article->thumbnail_path }}" alt="">
                                </div>
                            </a>
                        @endif
                    @endforeach
                    @endif
                </section>
                @endif

            @if ($ads)
                <div class="ad_wrapper">
                    <section class="ad">
                        @if ($ads->mobile_ad_3)
                        <img src="{{ '/images/uploads/ads/' . $ads->mobile_ad_3 }}?v={{time()}}" alt="">
                        @endif
                    </section>
                </div>
            @endif
        </div>
        @if($ads)
        <div class="col-3">
            <div class="ad_wrapper">
                <section class="ad">
                    @if ($ads->ad_1)
                        <img src="{{ '/images/uploads/ads/' . $ads->ad_1 }}?v={{time()}}" alt="">
                    @endif
                </section>
            </div>
            <div class="ad_wrapper">
                <section class="ad">
                    @if ($ads->ad_2)
                        <img src="{{ '/images/uploads/ads/' . $ads->ad_2 }}?v={{time()}}" alt="">
                    @endif
                </section>
            </div>
            <div class="ad_wrapper">
                <section class="ad">
                    @if ($ads->ad_3)
                        <img src="{{ '/images/uploads/ads/' . $ads->ad_3 }}?v={{time()}}" alt="">
                    @endif
                </section>
            </div>
        </div>
        @endif
    </div>
</main>
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
<script>
    var swiper = new Swiper(".mainSwiper", {
      navigation: {
        nextEl: ".mainSwiper-swiper-button-next",
        prevEl: ".mainSwiper-swiper-button-prev",
      },
      spaceBetween: 30,
      pagination: {
        el: ".mainSwiper-swiper-pagination",
      },
      autoplay: {
        delay: 5000, // in milliseconds
     },
    });
    var swiper = new Swiper(".catSwiper", {
      navigation: {
        nextEl: ".mainSwiper-swiper-button-next",
        prevEl: ".mainSwiper-swiper-button-prev",
      },
      spaceBetween: 30,
      pagination: {
        el: ".mainSwiper-swiper-pagination",
      },
      autoplay: {
        delay: 8000, // in milliseconds
        },
    });
</script>
@endsection
