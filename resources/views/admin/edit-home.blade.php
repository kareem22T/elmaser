@extends('admin.layouts.admin-layout')

@section('title', 'اضافة قسم')

@section('categories_add_active', 'active')

@section('content')
<h1 class="mb-5 page-title text-center">
    محتوى الصفحة الرئيسية
</h1>
<div id="edit_home">

    <div class="w-100 mb-3">
        <label for="categories" class="d-block mb-2">رئيس التحرير</label>
        <input type="text" name="search" id="search" class="form-control w-100" placeholder="رئيس التحرير" v-model="editor_master">
    </div>
    <div class="w-100 mb-3">
        <label for="categories" class="d-block mb-2">رئيس مجلس الادارة</label>
        <input type="text" name="search" id="search" class="form-control w-100" placeholder="رئيس مجلس الادارة" v-model="manager_name">
    </div>
    {{-- <div class="w-100 mb-3">
        <textarea name="news" id="news" cols="30" rows="5" placeholder="شريط الاخبار" class="form-control" v-model="news_bar"></textarea>
    </div> --}}
    <div class="mb-3 w-100">
        <label for="categories" class="d-block mb-2">اقسام الصفحة الرئيسية</label>
        <div class="w-100 d-flex gap-2 mb-3" style="position: relative">
            <select v-if="categories_data" v-model="catInput" id="categories" @change="getCategoryText" @keydown.enter="addTag" placeholder="اقسام الصفحة الرئيسية ..." class="form-control">
                <option v-for="(category, index) in categories_data" :key="index" :value="category.id" v-if="categories_data.length > 0">
                    @{{category.main_name}}
                </option>
            </select>
            <button class="btn btn-secondary w-25 button-secondary" @click="addTag">اضافة قسم</button>
            <div class="suggestions card p-2 w-100" style="position: absolute; top: calc(100% + 10px);
            lef: 0; max-height: 132px; overflow: auto;" v-if="search_categories && search_categories.length > 0">
                <div class="p-1 btn btn-light mb-1" style="text-align: left;padding: .3rem 1rem !important" v-for="tag in search_categories" :key="tag.id"  @click="this.catInput = tag.name; addTag(); this.search_categories = []" > @{{tag.name}} </div>
            </div>
        </div>
        <ul class="d-flex gap-2 flex-wrap-wrap">
            <li v-for="(tag, index) in prevCategories" :key="index" class="btn btn-light">
                @{{ tag }}
                <button @click="removeTag(index)" class="ti ti-x" style="background: transparent; border: none; cursor: pointer;"></button>
            </li>
        </ul>
    </div>
    <div class="mb-3 w-100">
        <label for="categories" class="d-block mb-2">المقالات الرئيسية</label>
        <div class="w-100 d-flex gap-2 mb-3" style="position: relative">
            <input type="text" name="search" id="search" class="form-control w-100" placeholder="بحث بعنوان المقالة" v-model="search" @input="getSearch(this.search)">
            <button class="btn btn-secondary w-25 button-secondary" @click="addTag">اضافة المقالة</button>
            <div class="suggestions card p-2 w-100" style="position: absolute; top: calc(100% + 10px);
            lef: 0; max-height: 132px; overflow: auto;" v-if="articles_search && articles_search.length > 0 && search">
                <div class="p-1 btn btn-light mb-1" style="text-align: left;padding: .3rem 1rem !important" v-for="tag in articles_search" :key="tag.id"  @click="addArticle(tag.id, tag.title)" > @{{tag.title}} </div>
            </div>
        </div>
        <ul class="d-flex gap-2 flex-wrap-wrap">
            <li v-for="(tag, index) in prevArticles" :key="index" class="btn btn-light">
                @{{ tag }}
                <button @click="removeArticle(index)" class="ti ti-x" style="background: transparent; border: none; cursor: pointer;"></button>
            </li>
        </ul>
    </div>

    <button class="button btn btn-primary w-25" @click="saveHomeContent(news_bar, categories)">حفظ</button>
    <br><br>
    <br><br>
</div>
@endsection

@section('styles')
<style>
    .swiper-button-next, .swiper-button-prev {
        width: fit-content !important;
        height: fit-content !important;
        padding: 4px !important;
        display: flex !important;
        bottom: 0 !important;
        top: auto;
        z-index: 9999;
    }
    .swiper-pagination {
        bottom: 0
    }
    .swiper-button-next::after, .swiper-button-prev::after {
        content: ""
    }
</style>
@endsection

@section('scripts')
<!-- Swiper JS -->

<!-- Initialize Swiper -->
<script>
const { createApp, ref } = Vue;

createApp({
  data() {
    return {
        editor_master: null,
        manager_name: null,
        categories: [],
        articles: [],
        prevCategories: [],
        prevArticles: [],
        category: '',
        catInput: '',
        search: null,
        articles_search: null,
        categories_data: @json(App\Models\Category::all()),
        news_bar: '',
        ad_1: null,
        ad_2: null,
        ad_3: null,
        mobile_ad_1: null,
        mobile_ad_2: null,
        mobile_ad_3: null,
        main_ad: null,
        imagePreview_ad_1: null,
        imagePreview_ad_2: null,
        imagePreview_ad_3: null,
        imagePreview_mobile_ad_1: null,
        imagePreview_mobile_ad_2: null,
        imagePreview_mobile_ad_3: null,
        imagePreview_main_ad: null,
    }
  },
  methods: {
    handleFileChange(prev, ad) {
      const fileInput = event.target;
      const file = fileInput.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          this['imagePreview_ad_' + prev] = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        this['imagePreview_ad_' + prev] = null;
      }

      this['ad_' + ad] = file;
    },
    handleMobileFileChange(prev, ad) {
      const fileInput = event.target;
      const file = fileInput.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          this['imagePreview_mobile_ad_' + prev] = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        this['imagePreview_mobile_ad_' + prev] = null;
      }

      this['mobile_ad_' + ad] = file;
    },
    handlemain_adFileChange() {
      const fileInput = event.target;
      const file = fileInput.files[0];

      if (file) {
        const reader = new FileReader();
        reader.onload = () => {
          this.imagePreview_main_ad = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        this.imagePreview_main_ad= null;
      }

      this.main_ad = file;
    },
    async getSearch(search_words) {
            try {
                const response = await axios.post(`/admin/articles/search?page=${this.page}`, {
                    search_words: search_words,
                },
                );
                if (response.data.status === true) {
                    this.articles_search = response.data.data.data
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
                this.languages_data = false
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
    getCategoryText(event) {
      const selectedIndex = event.target.selectedIndex;
      this.category = event.target.options[selectedIndex].text;
    },
    addTag() {
      if (this.category.trim() !== '' && this.catInput !== '') {
        this.prevCategories.push(this.category.trim());
        this.category = '';
        this.categories.push(this.catInput);
        this.catInput = '';
      }
    },
    addArticle(article, title) {
        this.articles.push(article)
        this.prevArticles.push(title)
        this.search = null
    },
    removeArticle(index) {
      this.articles.splice(index, 1);
      this.prevArticles.splice(index, 1);
    },
    removeTag(index) {
      this.categories.splice(index, 1);
      this.prevCategories.splice(index, 1);
    },
    async getCategories() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/categories/main`, {
                cat: 'cat'
            },
            );
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.categories_data = response.data.data
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
    async getHomeCategoriesAndArtciles() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.get(`{{route('get.homeCategoriesandArticles')}}`);
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.categories = response.data.data.catids
                this.articles = response.data.data.artids
                this.prevCategories = response.data.data.catnames
                this.prevArticles = response.data.data.artnames
                this.news_bar = response.data.data.newsbar ? response.data.data.newsbar.text : null
                this.editor_master = response.data.data.editor_master ? response.data.data.editor_master.name : null
                this.manager_name = response.data.data.editor_master ? (response.data.data.editor_master.manager_name) : null
                if (response.data.data.ads) {
                    this.imagePreview_ad_1 = response.data.data.ads.ad_1 ? '/images/uploads/ads/' + response.data.data.ads.ad_1 : null
                    this.imagePreview_ad_2 = response.data.data.ads.ad_2 ? '/images/uploads/ads/' + response.data.data.ads.ad_2 : null
                    this.imagePreview_ad_3 = response.data.data.ads.ad_3 ? '/images/uploads/ads/' + response.data.data.ads.ad_3 : null
                    this.imagePreview_mobile_ad_1 = response.data.data.ads.mobile_ad_1 ? '/images/uploads/ads/' + response.data.data.ads.mobile_ad_1 : null
                    this.imagePreview_mobile_ad_2 = response.data.data.ads.mobile_ad_2 ?'/images/uploads/ads/' + response.data.data.ads.mobile_ad_2 : null
                    this.imagePreview_mobile_ad_3 = response.data.data.ads.mobile_ad_3 ? '/images/uploads/ads/' + response.data.data.ads.mobile_ad_3 : null
                    this.imagePreview_main_ad = response.data.data.ads.main_ad ? '/images/uploads/ads/' + response.data.data.ads.main_ad : null
                }
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
    async saveHomeContent(news_bar, categories) {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`{{ route('save.home') }}`, {
                editor_master: this.editor_master,
                manager_name: this.manager_name,
                news_bar: news_bar,
                categories: categories,
                articles: this.articles,
                ad_1: this.ad_1,
                ad_2: this.ad_2,
                ad_3: this.ad_3,
                mobile_ad_1: this.mobile_ad_1,
                mobile_ad_2: this.mobile_ad_2,
                mobile_ad_3: this.mobile_ad_3,
                main_ad: this.main_ad,
            },
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            );
            if (response.data.status === true) {
                document.getElementById('errors').innerHTML = ''
                let error = document.createElement('div')
                error.classList = 'success'
                error.innerHTML = response.data.message
                document.getElementById('errors').append(error)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()
                location.reload()
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
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
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
  },
  mounted() {
    $('.loader').fadeOut()
  },
  created() {
    this.getHomeCategoriesAndArtciles()
  },
}).mount('#edit_home')
</script>
<script>
window.onload = function() {
    setTimeout(() => {
        var swiper = new Swiper(".mySwiper", {
                pagination: {
                    el: ".swiper-pagination",
                    type: "fraction",
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
            },
        });
    }, 3000);
}
</script>

@endsection
