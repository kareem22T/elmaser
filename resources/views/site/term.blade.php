@extends('site.layouts.main')

@section('title', 'Term | ')

@section('content')
<div id="term" v-if="term_data && term_data.length > 0">
    @include('site.includes.header')
    <div class="container">
        <aside>
            <div class="top_cat">
                <h1 class="top_title">
                    Top Categories <span class="line"></span>
                </h1>
                <div class="categories">
                    <div class="cat">
                        <img src="{{ asset('/public/site/imgs/top-basketball.jpg') }}">
                        <h3>Basketball</h3>
                    </div>
                    <div class="cat">
                        <img src="{{ asset('/public/site/imgs/top-basketball.jpg') }}">
                        <h3>Basketball</h3>
                    </div>
                    <div class="cat">
                        <img src="{{ asset('/public/site/imgs/top-basketball.jpg') }}">
                        <h3>Basketball</h3>
                    </div>
                    <div class="cat">
                        <img src="{{ asset('/public/site/imgs/top-basketball.jpg') }}">
                        <h3>Basketball</h3>
                    </div>
                    <div class="cat">
                        <img src="{{ asset('/public/site/imgs/top-basketball.jpg') }}">
                        <h3>Basketball</h3>
                    </div>
                </div>
            </div>
            <div class="top_words">
                <h1 class="top_title">
                    Top Words <span class="line"></span>
                </h1>
                <div class="terms">
                    <a  class="term">
                        <h2>Off Side</h2>
                        <h4>Football</h4>
                    </a>
                    <a  class="term">
                        <h2>Off Side</h2>
                        <h4>Football</h4>
                    </a>
                    <a  class="term">
                        <h2>Off Side</h2>
                        <h4>Football</h4>
                    </a>
                    <a  class="term">
                        <h2>Off Side</h2>
                        <h4>Football</h4>
                    </a>
                    <a  class="term">
                        <h2>Off Side</h2>
                        <h4>Football</h4>
                    </a>
                    <a  class="term">
                        <h2>Off Side</h2>
                        <h4>Football</h4>
                    </a>
                </div>
            </div>
        </aside>
        <article>
            <div class="head">
                <h1>@{{ term_data.title }}</h1>
                <div>
                    <span>By <b>Admin</b></span>
                    <span class="date">
                        <i class="fa-regular fa-calendar-days" style="font-size: 18px; margin: 0 7px;"></i> @{{ term_data.created_at }}
                    </span>
                </div>
            </div>
            <div class="thumbnail" v-if="term_data.thumbnail_path">
                <img :src="term_data.thumbnail_path" alt="">
            </div>
            <div class="content" v-html="term_data.content">
            </div>
            <div class="sound" v-html="term_data.sound">
            </div>
        </article>
    </div>
</div>
@endsection

@section('scripts')
<script>
const { createApp, ref } = Vue
createApp({
data() {
    return {
        term_id: `{{ request()->id }}`,
        term_data: null,
        title: '',
        user: null,
        languages_data: null,
        current_lang: "EN"
    }
},
methods: {
    async getTerm(id, lang){
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post( `{{ route('site.getterm') }}`, {
                id: id,
                lang: lang
            },
            );
            $('.loader').fadeOut()
            if (response.data.status === true) {
                document.getElementById('errors').innerHTML = ''
                this.term_data = response.data.data
                this.title = 'afdsf'
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 4000);
            } else {
                document.getElementById('errors').innerHTML = ''
                $.each(response.data.errors, function (key, value) {
                    let error = document.createElement('div')
                    error.classList = 'error'
                    error.innerHTML = value
                    document.getElementById('errors').append(error)
                });
                $('#errors').fadeIn('slow')
                setTimeout(() => {
                    $('input').css('outline', 'none')
                    $('#errors').fadeOut('slow')
                }, 3500);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()

            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    async getLanguages() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`{{ route('languages.get') }}`, {
            },
            );
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.languages_data = response.data.data
            } else {
                $('.loader').fadeOut()
                document.getElementById('errors').innerHTML = ''
                $.each(response.data.errors, function (key, value) {
                    let error = document.createElement('div')
                    error.classList = 'error'
                    error.innerHTML = value
                    document.getElementById('errors').append(error)
                });
                $('#errors').fadeIn('slow')
                setTimeout(() => {
                    $('input').css('outline', 'none')
                    $('#errors').fadeOut('slow')
                }, 5000);
            }

        } catch (error) {
            document.getElementById('errors').innerHTML = ''
            let err = document.createElement('div')
            err.classList = 'error'
            err.innerHTML = 'server error try again later'
            document.getElementById('errors').append(err)
            $('#errors').fadeIn('slow')
            $('.loader').fadeOut()
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    getCookie(cookieName) {
        const name = cookieName + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const cookieArray = decodedCookie.split(';');

        for(let i = 0; i < cookieArray.length; i++) {
            let cookie = cookieArray[i];
            while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1);
            }
            if (cookie.indexOf(name) === 0) {
            return cookie.substring(name.length, cookie.length);
            }
        }
        return "";
    },
    checkCookie(cookieName) {
        var cookies = document.cookie.split(';');
        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            if (cookie.indexOf(`${cookieName}=`) === 0) {
                return true; // Found 'user_token' cookie
            }
        }
        return false; // 'user_token' cookie not found
    },
    async getUser() {
        var hasUserTokenCookie = this.checkCookie('user_token');
        if (hasUserTokenCookie) {
            sessionStorage.setItem('user_token', this.getCookie('user_token'))
        }
        let user_token = sessionStorage.getItem('user_token')
        if (user_token) {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.get(`{{ route('site.get-user') }}`,
                    {
                        headers: {
                            'AUTHORIZATION': `Bearer ${user_token}`
                        }
                    },
                );
                $('.loader').fadeOut()
                if (response.data.status === true) {
                    sessionStorage.setItem('user', JSON.stringify(response.data.data))
                    this.user = response.data.data
                } else {
                    return false;
                }

            } catch (error) {
                console.error(error);
                return false;
            }
        }
    },
    setCookie(name, value, days) {
        var expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + days);

        var expires = "expires=" + expirationDate.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    },
    setLang() {
        this.setCookie('lang', this.current_lang, 30)
        this.getTerm(this.term_id, this.current_lang)
        if (this.current_lang == 'AR') {
            document.body.classList = 'ar'
        } else {
            document.body.classList = ''
        }

    },
    async getLang() {
        var isLang = this.checkCookie('lang');
        if (isLang) {
            sessionStorage.setItem('lang', this.getCookie('lang'))
            this.current_lang = sessionStorage.getItem('lang')
        }
    }
},
created() {
    this.getLang().then(() => {
        this.getTerm(this.term_id, this.current_lang)
        if (this.current_lang == 'AR') {
            document.body.classList = 'ar'
        }
    })
    this.getUser()
    this.getLanguages()
},
}).mount('#term')
</script>
@endSection
