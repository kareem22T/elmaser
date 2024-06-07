@extends('site.layouts.main')

@section('title', ' اتصل بنا')

@section('content')
<style>
    .settings_wrapper .about::after {
        width: 80px;
        height: 80px;
        content: '';
        position: absolute;
        border-top: 3px solid;
        top: 0;
        right: 0;
        border-right: 3px solid;
        border-color: #e45c3f;
        border-radius: 0 10px 0 0
    }
    .settings_wrapper .about::before {
        width: 80px;
        height: 80px;
        content: '';
        position: absolute;
        border-left: 3px solid;
        bottom: 0;
        left: 0;
        border-bottom: 3px solid;
        border-color: #e45c3f;
        border-radius: 0 0 0 10px
    }
    @media (max-width: 575.98px) {
        .about {
            grid-template-columns: 1fr !important;
            padding: 15px !important
        }
        .about p {
            font-size: 14px !important
        }
    }
    .settings_wrapper .social a {
        color: white;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        flex-direction: column-reverse;
        justify-content: center;
        align-items: center;
        border: 1px solid white;
        padding: 10px;
        width: 100%;
        border-radius: 5px;
        transition: all .3s ease-in
    }
    .settings_wrapper .social a:hover {
        background: white;
        color: #e45c3f
    }
    .social a:hover svg {
        stroke: #e45c3f
    }
    .social a.anghami:hover svg {
        fill: #e45c3f
    }
    .social a svg {
        stroke: #fff;
        width: 30px;
        height: 30px;
        transition: all .3s ease-in
    }
    .social a.anghami svg {
        fill: #fff;
        width: 27px;
        height: 27px;
        transition: all .3s ease-in
    }
</style>
<div class="container settings_wrapper"  >

    <div class="about" style="padding: 1.5rem;width: 100%;margin: auto;position: relative;display: grid;grid-template-columns: 1fr 1fr;gap: 2rem; margin-top: 2rem; margin-bottom: 5rem">
        <div class="img" style="position: relative;width: 100%;height: 100%;">
            <img src="{{asset('site/imgs/obi-pixel8propix-UEQvUtRs224-unsplash.jpg')}}" alt="" style="width: 100%;height: 100%;object-fit: cover;border-radius: 10px;position: absolute;top: 0;left: 0;">
            <div class="bg" style="width: 100%;height: 100%;top: 0;left: 0;position: absolute;background: #e45c3f;border-radius: 10px;opacity: 0.7;"></div>
            <div class="social" style="position: relative;top: 0;left: 0;width: 100%;height: 100%;display: flex;flex-direction: column;justify-content: center;align-items: center;gap: 10px;padding: 1rem;display: grid;grid-template-columns: 1fr 1fr;">
            @if(isset($settingsArray["email"]) && $settingsArray["email"]["value"])
                <a target="_blank" href="mailto:{{$settingsArray["email"]["value"]}}" style="grid-column: span 2">
                    {{ $settingsArray["email"]["value"] }}
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                        <path d="M3 7l9 6l9 -6" />
                    </svg>
                </a>
            @endif
            @if(isset($settingsArray["phone"]) && $settingsArray["phone"]["value"])
                <a target="_blank" href="tel:{{$settingsArray["phone"]["value"]}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone-call" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        <path d="M15 7a2 2 0 0 1 2 2" />
                        <path d="M15 3a6 6 0 0 1 6 6" />
                      </svg>
                </a>
            @endif
            @if(isset($settingsArray["facebook"]) && $settingsArray["facebook"]["value"])
                    <a target="_blank" href="{{$settingsArray["facebook"]["value"]}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-facebook" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" />
                          </svg>
                    </a>
                @endif
                @if(isset($settingsArray["instagram"]) && $settingsArray["instagram"]["value"])
                <a target="_blank" href="{{$settingsArray["instagram"]["value"]}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-instagram" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" />
                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M16.5 7.5l0 .01" />
                          </svg>
                    </a>
                @endif
                @if(isset($settingsArray["youtube"]) && $settingsArray["youtube"]["value"])
                    <a target="_blank" href="{{$settingsArray["youtube"]["value"]}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-youtube" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M2 8a4 4 0 0 1 4 -4h12a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-12a4 4 0 0 1 -4 -4v-8z" />
                            <path d="M10 9l5 3l-5 3z" />
                          </svg>
                    </a>
                @endif
                @if(isset($settingsArray["tiktok"]) && $settingsArray["tiktok"]["value"])
                    <a target="_blank" href="{{$settingsArray["tiktok"]["value"]}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-tiktok" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M21 7.917v4.034a9.948 9.948 0 0 1 -5 -1.951v4.5a6.5 6.5 0 1 1 -8 -6.326v4.326a2.5 2.5 0 1 0 4 2v-11.5h4.083a6.005 6.005 0 0 0 4.917 4.917z" />
                          </svg>
                    </a>
                @endif
                @if(isset($settingsArray["x"]) && $settingsArray["x"]["value"])
                    <a target="_blank" href="{{$settingsArray["x"]["value"]}}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-x" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="#0d0d0d" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 4l11.733 16h4.267l-11.733 -16z" />
                            <path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" />
                          </svg>
                    </a>
                @endif
            </div>
        </div>
        <div style="display: flex; align-items: center;align-items: center;justify-content: center;width: 100%">
            <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;gap: 0;width: 100%;text-align: right">
                <h3 style="font-weight: 700;">ارسل لنا رسالة</h3>
                <p>ننتظر اقتراحك او استفسارك !</p>
                <div class="form-group" style="margin: 20px 0 16px;width: 100%;display: flex; flex-direction: column; gap: 10px">
                    <input type="text" name="text" id="name" class="form-control" placeholder="الاسم" style="box-sizing: border-box;margin: 0;padding: 9.8px 11px;color: rgba(0, 0, 0, 0.88);font-size: 16px;line-height: 1.15;list-style: none;position: relative;display: inline-block;width: 100%;min-width: 0;background-color: #ffffff;background-image: none;border-width: 1px;border-style: solid;border-color: #d9d9d9;border-radius: 8px;transition: all 0.2s;direction: rtl;">
                    <input type="text" name="text" id="subject" class="form-control" placeholder="العنوان" style="box-sizing: border-box;margin: 0;padding: 9.8px 11px;color: rgba(0, 0, 0, 0.88);font-size: 16px;line-height: 1.15;list-style: none;position: relative;display: inline-block;width: 100%;min-width: 0;background-color: #ffffff;background-image: none;border-width: 1px;border-style: solid;border-color: #d9d9d9;border-radius: 8px;transition: all 0.2s;direction: rtl;">
                    <input type="text" name="email" id="email" class="form-control" placeholder="بريدك الالكتروني" style="box-sizing: border-box;margin: 0;padding: 9.8px 11px;color: rgba(0, 0, 0, 0.88);font-size: 16px;line-height: 1.15;list-style: none;position: relative;display: inline-block;width: 100%;min-width: 0;background-color: #ffffff;background-image: none;border-width: 1px;border-style: solid;border-color: #d9d9d9;border-radius: 8px;transition: all 0.2s;direction: rtl;">
                    <textarea name="msg" id="msg" cols="30"  class="form-control" rows="4" placeholder="الرسالة" style="box-sizing: border-box;margin: 0;padding: 9.8px 11px;color: rgba(0, 0, 0, 0.88);font-size: 16px;line-height: 1.15;list-style: none;position: relative;display: inline-block;width: 100%;min-width: 0;background-color: #ffffff;background-image: none;border-width: 1px;border-style: solid;border-color: #d9d9d9;border-radius: 8px;transition: all 0.2s;direction: rtl;resize: none"></textarea>
                </div>
                <button id="login_with_email" style="outline: none;position: relative;display: inline-block;font-weight: 400;white-space: nowrap;text-align: center;background-image: none;background-color: #e45c3f;border: 1px solid transparent;cursor: pointer;transition: all 0.2s cubic-bezier(0.645, 0.045, 0.355, 1);user-select: none;touch-action: manipulation;line-height: 1.15;color: #fff;padding: 10px 3rem;width: 100%;border-radius: 10px;">ارسال</button>
            </div>
    </div>
</div>
@endsection

