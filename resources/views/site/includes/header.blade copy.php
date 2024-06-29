@php
    $categories = App\Models\Category::all();
@endphp

<header id="header_wrapper">
    <div class="container">
        <div>
            <button @click="showSearchPopUp = true"><i class="fa fa-search"></i></button>
            <p>
                <span>رئيس التحرير</span><br>
                <span>{{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->name ? App\Models\Editor_master::first()->name : "لم يحدد بعد"}}</span><br>
                <span >مدير تحرير</span><br style="margin-top: 8px">
                <span>{{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->manager_name ? App\Models\Editor_master::first()->manager_name : "لم يحدد بعد"}}</span><br>
            </p>
        </div>
        <div>
            <a href="{{ route('site.home') }}"><img src="{{ asset('/dashboard/images/logo.png') }}" alt="logo"></a>
        </div>
        <div>
            <div class="social_wrapper">
                <span>رئيس مجلس الإدارة </span> <br>
                <span>حسام البحيري</span><br>
                <br>
                    <div class="social">
                        <a href="https://www.facebook.com/elgomhuriaeljadida" target="_blank">
                            <img src="{{ asset("/site/imgs/facebook.png") }}" width="30" alt="">
                    </a>
                    <a href="https://twitter.com/i/flow/login?redirect_after_login=%2FEEljadida32528" target="_blank">
                        <img src="{{ asset("/site/imgs/x.png") }}" width="30" alt="">
                    </a>
                    <a href="https://www.tiktok.com/@elgomhuriaeljadid?_t=8jlj7ZTUQzO&_r=1" target="_blank">
                        <img src="{{ asset("/site/imgs/tiktok.png") }}" width="30" alt="">
                    </a>
                    <a href="https://www.instagram.com/elgomhuriaeljadida/" target="_blank">
                        <img src="{{ asset("/site/imgs/insta.png") }}" width="30" alt="">
                    </a>
                    <a href="https://www.youtube.com/channel/UCGzsSgidw7s3i9pdxjScPQA" target="_blank">
                        <img src="{{ asset("/site/imgs/youtube.png") }}" width="30" alt="">
                    </a>
                </div>
            </div>
            <div class="more">
                <button class="show_left_nav"><i class="fa fa-bars"></i></button>
                <div class="links animate__animated">
                    @foreach ($categories as $category)
                    <a href="/category/{{$category?->id}}">{!! $category?->icon !!} {{ $category?->main_name }} </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="hide-content"></div>
    <div class="hide-content" v-if="showSearchPopUp" :style="showSearchPopUp ? 'display: block' : ''"></div>
    <div class="pop-up search-pop-up" dir="rtl" v-if="showSearchPopUp" style="top: calc(clamp(3.125rem, calc(1.7314rem + 5.9459vw), 6.5625rem) + 20px) !important;border-radius: 0;">
        <div class="input-search">
            <input type="text" name="search" id="search" placeholder="ابحث عن مقالات" v-model="search" @keyup="getSugesstions()" @keyup.enter="goToSearch" @focus="showSuggesstion = true" @blur="showSuggesstion = false">
            <i class="fa fa-search" style="cursor: pointer" @click="goToSearch"></i>
            <div class="suggestions suggestions2" v-if="results && results.length">
                <a :href="`/article/${item.id}`" v-for="item in results.slice(0, 5)" :key="item.id" @click="showSearchPopUp = false">@{{ item.title }}</router-link>
                <a :href="`/search?s=${this.search}`" style="text-align: center !important; font-weight: 600 !important">عرض الكل</a>
            </div>
        </div>
        <button @click="showSearchPopUp = false; this.search = ''">الغاء</button>
    </div>
</header>
<div class="mobile-social">
    <a href="https://www.facebook.com/elgomhuriaeljadida" target="_blank">
        <img src="{{ asset("/site/imgs/facebook.png") }}" width="30" alt="">
    </a>
    <a href="https://twitter.com/i/flow/login?redirect_after_login=%2FEEljadida32528" target="_blank">
        <img src="{{ asset("/site/imgs/x.png") }}" width="30" alt="">
    </a>
    <a href="https://www.tiktok.com/@elgomhuriaeljadid?_t=8jlj7ZTUQzO&_r=1" target="_blank">
        <img src="{{ asset("/site/imgs/tiktok.png") }}" width="30" alt="">
    </a>
    <a href="https://www.instagram.com/elgomhuriaeljadida/" target="_blank">
        <img src="{{ asset("/site/imgs/insta.png") }}" width="30" alt="">
    </a>
    <a href="https://www.youtube.com/channel/UCGzsSgidw7s3i9pdxjScPQA" target="_blank">
        <img src="{{ asset("/site/imgs/youtube.png") }}" width="30" alt="">
    </a>
</div>

<p class="mobile-paragraph">
    <span>رئيس مجلس الإدارة: حسام البحيري</span>
    <span>رئيس التحرير: {{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->name ? App\Models\Editor_master::first()->name : "لم يحدد بعد"}}</span>
    <span>مدير تحرير: {{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->manager_name ? App\Models\Editor_master::first()->manager_name : "لم يحدد بعد"}}</span><br>
</p>


