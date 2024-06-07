@php
    $categories = App\Models\Category::latest()->take(9)->get();
    $months = array(
    "يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو",
    "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"
    );

    $days = array(
    "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"
    );
@endphp


<footer>
    <div class="container">
        <div class="logo_wrapper">
            <a href="/">
                <img src="{{ asset('/assets/imgs/home-maser-logo.jpg')}}" style="width: 130px" alt="logo" class="logo">
            </a>
            <div class="text">
                رئيس مجلس الادارة: {{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->manager_name ? App\Models\Editor_master::first()->manager_name : "لم يحدد بعد"}}
                <br>
                رئيس التحرير: {{ App\Models\Editor_master::first() && App\Models\Editor_master::first()->name ? App\Models\Editor_master::first()->name : "لم يحدد بعد"}}
            </div>
        </div>
        <div class="links">
            @foreach ($categories as $item)
                <a href="/category/{{$item->id}}"><i class="fa-solid fa-caret-left"></i> {{$item->main_name}}</a>
            @endforeach
        </div>
    </div>
</footer>
