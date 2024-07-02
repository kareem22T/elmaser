@extends('admin.layouts.admin-layout')

@section('title', 'لوحة التحكم')

@section('articles_preview_active', 'active')

@section('content')
<h1 class="mb-5 page-title text-center">
    المقالات
</h1>
@php
    $today = Carbon\Carbon::today();
    $yesterday = Carbon\Carbon::yesterday();
    $all = App\Models\Article::all()->count();
    $todayArticles = App\Models\Article::whereDate('created_at', $today)->get()->count();
    $yesterdayArticles = App\Models\Article::whereDate('created_at', $yesterday)->get()->count();
@endphp
<div class="d-flex" style="gap: 8px">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h1 class="card-text">كل المقالات</h1>
                    <h1>{{ $all }}</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h1 class="card-text">المضافة اليوم</h1>
                    <h1>{{ $todayArticles }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h1 class="card-text"> المضافة امس</h1>
                    <h1>{{ $yesterdayArticles }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card w-100" id="word_prev">
    <div class="card-header d-flex justify-content-between gap-3">
        <input type="text" name="search" id="search" class="form-control w-25" placeholder="بحث ..." v-model="search" @input="getSearch(this.search)" style="font-size: 19px !important;padding: 10px 20px !important;border-radius: 15px !important;">
        <div class="btns d-flex gap-2">

            <a href="/admin/articles/draft" class="btn btn-dark w-fit d-flex gap-2 align-items-center">
              المسودة
            </a>
            <a href="/admin/articles/add" class="btn btn-primary w-fit d-flex gap-2 align-items-center">
                <i class="ti ti-plus"></i>  اضافة خبر
            </a>
        </div>
    </div>
    <div class="card-body p-4">
    <div class="table-responsive" v-if="articles_data && articles_data.length > 0">
        <table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4">
            <tr>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">Id</h6>
                </th>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">العنوان</h6>
                </th>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">القسم</h6>
                </th>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">التحكم</h6>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(article, index) in articles_data" :key="index">
                <td class="border-bottom-0"><h6 class="fw-semibold mb-0">@{{article.id}}</h6></td>
                <td class="border-bottom-0"><h6 class="fw-semibold mb-0">@{{ article.title.length >= 20 ? article.title.slice(0, 20) + '...' : article.title}}</h6></td>
                <td class="border-bottom-0">
                    <p class="mb-0 fw-normal">@{{article.category.main_name}}</p>
                </td>
                <td class="border-bottom-0">
                    <div class="d-flex gap-2">
                        <form :action="`/admin/article/toggleTrend/${article.id}`" action="POST">
                            <button type="submit" v-if="!article.isTrend" class="btn btn-success">اضافة الي التريند</button>
                            <button type="submit" v-if="article.isTrend"  class="btn btn-danger">حذف من التريند</button>
                        </form>
                        <button class="btn btn-primary p-2" @click="makeImp(article.id)"><h4 class="ti ti-alert-circle text-light m-0 fw-semibold"></h4> </button>
                        <a :href="`/admin/articles/edit/${article.id}`" class="btn btn-secondary p-2"><h4 class="ti ti-edit text-light m-0 fw-semibold"></h4></a>
                        <button class="btn btn-danger p-2" @click="this.delete_pop_up = true; getValues(article.id, article.title.length >= 20 ? article.title.slice(0, 20) + '...' : article.title)"><h4 class="ti ti-trash text-light m-0 fw-semibold"></h4></button>
                    </div>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
    <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1" dir="ltr">
        <button class="btn btn-primary" :disabled="page === 1" @click="goToFirstPage">الاولي</button>
        <button class="btn btn-primary" :disabled="page === 1" @click="goToPreviousPage">السابقة</button>

        <div v-for="page_num in visiblePages" :key="page_num">
          <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num === page ? 'active' : ''">@{{ page_num }}</label>
          <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="pageChanged">
        </div>

        <button class="btn btn-primary" :disabled="page === last_page" @click="goToNextPage">التالية</button>
        <button class="btn btn-primary" :disabled="page === last_page" @click="goToLastPage">الاخيرة</button>
    </div>
    <h4 class="text-center">
        @{{ !articles_data || articles_data.length == 0 ? 'لا يوجد اي اخبار' : '' }}
    </h4>
    <h4 class="text-center">
        @{{ articles_data === false ? 'Server error try again later' : '' }}
    </h4>
    </div>
    <div class="hide-content" v-if="delete_pop_up"></div>
    <div class="pop-up delete_pop_up card w-50" style="margin: auto; display: none;"  :class="{ 'show': delete_pop_up }" v-if="delete_pop_up">
        <div class="card-body">
            <form @submit.prevent>
                <h5 class="mb-3 text-center">هل انت متاكد من حذف هذا @{{ article_name }} الخبر؟</h5>
                <div class="btns d-flex w-100 justify-content-between gap-3">
                    <button class="btn btn-light w-100" @click="delete_pop_up = false; getValues(null, null)">Cancel</button>
                    <button class="btn btn-danger w-100" @click="deletearticle(article_id)">delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const { createApp } = Vue

createApp({
    data() {
        return {
            article_id: null,
            article_name: null,
            delete_pop_up: false,
            articles_data: null,
            search: '',
            page: 1,
            total: null,
            last_page: null
        }
    },
    computed: {
        visiblePages() {
            const range = 8;
            let start = Math.max(this.page - Math.floor(range / 2), 1);
            let end = start + range - 1;

            if (end > this.last_page) {
                end = this.last_page;
                start = Math.max(end - range + 1, 1);
            }

            const pages = [];
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }

            return pages;
        }
    },
    methods: {
        async deletearticle(article_id) {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`/admin/articles/delete`, {
                    article_id: article_id,
                });
                if (response.data.status === true) {
                    document.getElementById('errors').innerHTML = ''
                    let error = document.createElement('div')
                    error.classList = 'success'
                    error.innerHTML = response.data.message
                    document.getElementById('errors').append(error)
                    $('#errors').fadeIn('slow')
                    $('.loader').fadeOut()
                    setTimeout(() => {
                        $('#errors').fadeOut('slow')
                        location.reload();
                    }, 2000);
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

                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
        async makeImp(article_id) {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`{{route('article.make.important')}}`, {
                    article_id: article_id
                });
                if (response.data.status === true) {
                    document.getElementById('errors').innerHTML = ''
                    let error = document.createElement('div')
                    error.classList = 'success'
                    error.innerHTML = response.data.message
                    document.getElementById('errors').append(error)
                    $('#errors').fadeIn('slow')
                    this.edit_pop_up = false
                    $('.loader').fadeOut()
                    setTimeout(() => {
                        $('#errors').fadeOut('slow')
                    }, 4000);
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

                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
        async getarticles() {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`/admin/articles?page=${this.page}`);
                if (response.data.status === true) {
                    $('.loader').fadeOut()
                    this.articles_data = response.data.data.data
                    this.total = response.data.data.total
                    this.last_page = response.data.data.last_page
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
                this.articles_data = false
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
        async getSearch(search_words) {
            try {
                const response = await axios.post(`/admin/articles/search?page=${this.page}`, {
                    search_words: search_words,
                });
                if (response.data.status === true) {
                    this.articles_data = response.data.data.data
                    this.total = response.data.data.total
                    this.last_page = response.data.data.last_page
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
                this.articles_data = false
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
        getValues(article_id, article_name) {
            this.article_id = article_id
            this.article_name = article_name
        },
        goToFirstPage() {
            this.page = 1;
            this.fetchArticles();
        },
        goToPreviousPage() {
            if (this.page > 1) {
                this.page -= 1;
                this.fetchArticles();
            }
        },
        goToNextPage() {
            if (this.page < this.last_page) {
                this.page += 1;
                this.fetchArticles();
            }
        },
        goToLastPage() {
            this.page = this.last_page;
            this.fetchArticles();
        },
        pageChanged() {
            this.fetchArticles();
        },
        fetchArticles() {
            this.search === '' ? this.getarticles() : this.getSearch(this.search);
        }
    },
    created() {
        this.getarticles();
        $('.loader').fadeOut();
    }
}).mount('#word_prev')
</script>
@endsection
