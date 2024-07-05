@extends('admin.layouts.admin-layout')

@section('title', 'اضافة مقالة')

@section('add_article_active_btn', 'active')

@section('content')
<div id="add_cat">
    <div  v-if="categories_data && categories_data.length > 0">
    <h1 class="mb-5 page-title text-center">
        اضافة خبر
    </h1>
    <style>
        .toolbar button {
            font-size: 22px;
            font-weight: bold
        }
    </style>
        <div>
            <div class="w-100 mb-3">
                <input type="text" name="title" id="title" class="form-control" placeholder="عنوان الخبر" v-model="title">
            </div>
            <div class="w-100 mb-3">
                <input type="text" name="sub_title" id="sub_title" class="form-control" placeholder="عنوان ثاناوي (اختياري)" v-model="sub_title">
            </div>
            <div class="w-100 mb-3">
                <input type="text" name="intro" id="intro" class="form-control" placeholder="نبذة مختصرة او مقدمة تعرض ع من الخارج" v-model="intro">
            </div>
            <div class="d-flex gap-2 mb-3 align-items-end">
                <div class="w-50" v-if="categories_data">
                    <label for="symbol" class="form-label">القسم *</label>
                    <select name="cat_type" id="cat_type" class="form-control" v-model="cat_id">
                        <option v-for="(category, index) in categories_data" :key="index" :value="category.id" v-if="categories_data.length > 0">
                            @{{category.main_name}}
                        </option>
                    </select>
                </div>
                <div class="w-50">
                    @php
                        $authors = App\Models\Author::all();
                    @endphp
                    <label for="symbol" class="form-label">الناشر *</label>
                    <select name="cat_type" id="cat_type" class="form-control" v-model="author_id">
                        @foreach ($authors as $author)

                            <option value="{{$author?->id}}">
                                {{$author?->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- Swiper -->
            <div class="w-100 mb-4 pb-3">
                <div class="w-100 p-3">
                    <div>
                        <label for="lang_name" class="form-label">محتوى الخبر*</label>
                        <div class="card input">
                            <div class="pt-3">
                                <div class="toolbar d-flex gap-2 justify-content-center" style="flex-wrap: wrap">
                                    <button @click="execCommand('bold')" class="btn btn-light"><b>B</b></button>
                                    <button @click="execCommand('italic')" class="btn btn-light"><i>I</i></button>
                                    <button @click="execCommand('underline')" class="btn btn-light"><u>U</u></button>
                                    <button @click="execCommand('insertOrderedList')" class="btn btn-light"><i class="ti ti-list-numbers"></i></button>
                                    <button @click="execCommand('insertUnorderedList')" class="btn btn-light"><i class="ti ti-list"></i></button>
                                    <button @click="execCommand('justifyLeft')" class="btn btn-light"><i class="ti ti-align-left"></i></button>
                                    <button @click="execCommand('justifyCenter')" class="btn btn-light"><i class="ti ti-align-center"></i></button>
                                    <button @click="execCommand('justifyRight')" class="btn btn-light"><i class="ti ti-align-right"></i></button>
                                    <button @click="insertHTML('<h2>عنوان</h2>', 'article-content')" class="btn btn-light"><i class="ti ti-h-2"></i></button>
                                    <button @click="insertHTML('<h3>عنوان</h3>', 'article-content')" class="btn btn-light"><i class="ti ti-h-3"></i></button>
                                    <button @click="insertHTML('<h4>عنوان</h4>', 'article-content')" class="btn btn-light"><i class="ti ti-h-4"></i></button>
                                    <button @click="insertHTML('<h5>عنوان</h5>', 'article-content')" class="btn btn-light"><i class="ti ti-h-5"></i></button>
                                    <button @click="insertHTML('<h6>عنوان</h6>', 'article-content')" class="btn btn-light"><i class="ti ti-h-6"></i></button>
                                    <button @click="insertHTML('<p>نص</p>', 'article-content')" class="btn btn-light">P</button>
                                    <button class="btn btn-light" @click="this.showImages = true; this.current_article_id = 'article-content'"><i class="ti ti-photo-plus"></i></button>
                                    <button class="btn btn-light" @click="this.showCodePopUp = true"><i class="ti ti-code"></i></button>

                                    <!-- Add color input -->
                                    <input type="color" @input="changeColor($event)" style="--bs-btn-color: #000;background: #F6F9FC !important;--bs-btn-border-color: #F6F9FC;--bs-btn-hover-color: #000;--bs-btn-hover-bg: #d1d4d6;--bs-btn-hover-border-color: #c5c7ca;--bs-btn-focus-shadow-rgb: 209,212,214;--bs-btn-active-color: #000;--bs-btn-active-bg: #c5c7ca;--bs-btn-active-border-color: #b9bbbd;--bs-btn-active-shadow: inset 0 3px 5px rgba(0,0,0,0.125);--bs-btn-disabled-color: #000;--bs-btn-disabled-bg: #F6F9FC;--bs-btn-disabled-border-color: #F6F9FC;border: none !important;height: 50px;border-radius: 8px !important;" class="btn btn-light" />
                                </div>
                            </div>
                            <div class="card-body">
                                <div contenteditable="true" :id="'article-content'" class="form-control" style="min-height: 300px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hide-content" v-if="showImages || showSliderPopUp || showCodePopUp"></div>
            <div class="pop-up show-images-pop-up card" v-if="showImages" style="z-index: 2147483647; min-width: 90vw; height: 90vh; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; gap: 1rem;">
                <input type="text" name="search" id="search" class="form-control w-25 mb-2" placeholder="بحث" v-model="search" @input="getSearchImages(this.search)">
                <div class="imgs p-2 gap-3" v-if="images && images.length" style="display: flex;grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));flex-wrap: wrap;height: 100%;overflow: auto;">
                    <div class="img" @click="this.choosed_img = '/images/uploads/' + img.path; this.choosed_img_title = img.title" v-for="(img, index) in images" :key="img.id" style="width: 260px;height: 230px;overflow: hidden;padding: 10px;border-radius: 1rem;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;position: relative">
                        <img :src="'/images/uploads/' + img.path" id="preview" alt="img logo" style="width: 100%;height: 100%;object-fit: contain;">
                        <button class="btn btn-primary" @click="img_for_seo = img; img_for_seo_title = img.title;img_for_seo_alt = img.alt;this.showSettingsPopUp = true" style="position: absolute;bottom: 5px;left: 50%;transform: translateX(-50%);">
                            Set Title
                        </button>
                    </div>
                </div>
                <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1" style="flex-wrap: wrap; max-width: 100%">
                    <button class="btn btn-primary" :disabled="page === 1" @click="goToFirstPage">الاولي</button>

                    <div v-for="page_num in visiblePages" :key="page_num">
                      <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num === page ? 'active' : ''">@{{ page_num }}</label>
                      <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="pageChanged">
                    </div>

                    <button class="btn btn-primary" :disabled="page === last_page" @click="goToLastPage">الاخيرة</button>
                </div>
                <h1 v-if="images && !images.length && !search">لا توجد صور</h1>
                <div class="hide-content" v-if="showSettingsPopUp"></div>
                <div class="pop-up card p-3" v-if="showSettingsPopUp">
                    <h2 class="mb-3 text-center">Set Image Title</h2>
                    <div class="img">
                        <img :src="`/images/uploads/${img_for_seo.path}`" alt="" style="margin: auto;width: 100%;object-fit: contain;object-fit: cover;max-width: 340px;margin-bottom: 10px;border-radius: 10px;">
                    </div>
                    <div class="form-group mb-2">
                        <label for="title" class="w-100" dir="ltr">Image Title</label>
                        <input type="text" name="title" id="title" class="form-control" v-model="img_for_seo_title">
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-2">
                        <button class="btn btn-light"  @click="this.showSettingsPopUp = false">Cancel</button>
                        <button class="btn btn-secondary" @click="setTitle()">
                            Set Title
                        </button>
                    </div>
                </div>
                <div class="foot" style="display: flex;width: 100%;justify-content: space-between;gap: 1rem;">
                    <button class="btn btn-primary" @click="this.showUploadPopUp = true">تحميل صورة</button>
                    <div class="hide-content" v-if="showUploadPopUp"></div>
                    <div class="pop-up card p-3" v-if="showUploadPopUp">
                        <label for="image" class="mb-2">اختر ملف صورة</label>
                        <input type="file" name="image" id="image" class="form-control mb-4" @change="imageChanges">
                        <div class="d-flex gap-2 w-100 justify-content-center">
                            <button class="btn btn-light"  @click="this.showUploadPopUp = false">الغاء</button>
                            <button class="btn btn-secondary" @click="uploadImage(image)">
                                اضافة صورة
                            </button>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light"  @click="this.showImages = false; this.search = null; getSearch()">الغاء</button>
                        <button class="btn btn-success"  @click="insertImgToArticle()">اختار</button>
                    </div>
                </div>
            </div>
            <div class="pop-up show-slider-pop-up card" v-if="showSliderPopUp" style="padding: 1rem;width: 730px;display: flex;flex-direction: column;justify-content: center;align-items: center;max-width: 90vw;gap: 20px;">
                <h2>Choose imgs for the slider</h2>
                <div style="width: 100%;
                            overflow: auto;
                            height: 210px;
                            display: flex;
                            gap: 1rem;">
                    <img :src="img" v-for="(img, index) in slider_imgs" id="preview" alt="img logo" style="width: 200px;
                    height: 200px;
                    object-fit: cover;">
                </div>
                <div id="slider" style="width: 100%; display: none">
                        <swiper-container class="mySwiper" slides-per-view="3" space-between="15" navigation="true" v-if="slider_imgs && slider_imgs.length" style="width: 100%;padding: 1rem;">
                            <swiper-slide  v-for="(img, index) in slider_imgs" :key="index">
                                <img :src="img" id="preview" alt="img logo" style="width: 100%;
                                height: 200px;
                                object-fit: cover;">
                        </swiper-slide>
                    </swiper-container>
                    <br>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light"  @click="this.showSliderPopUp = false">Cancel</button>
                    <button class="btn btn-primary" @click="this.showImages = true; this.forSlider = true;">Choose</button>
                    <button class="btn btn-secondary" @click="insertSliderContent('article-content')">insert</button>
                </div>
            </div>
            <div class="pop-up show-code-pop-up card" v-if="showCodePopUp" style="padding: 1rem;width: 730px;display: flex;flex-direction: column;justify-content: center;align-items: center;max-width: 90vw;gap: 20px;">
                <div class="form-group w-100 text-center">
                    <label for="code"><h1>Enter Your Html code</h1></label>
                    <textarea dir="ltr" name="code" id="code" rows="10" class="form-control" v-model="code" style="width: 100%;resize: none"></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-light"  @click="this.showCodePopUp = false">Cancel</button>
                    <button class="btn btn-secondary" @click="insertHTML(this.code, 'article-content');this.showCodePopUp = false">insert</button>
                </div>
            </div>

            <div class="mb-3 w-100">
                <div class="w-100 d-flex gap-2 mb-3" style="position: relative">
                    <input v-model="tagInput" @keydown.enter="addTag" placeholder="اضافة الكلمات المفتاحية ..." class="form-control" @input="getTagSearch(tagInput)">
                    <button class="btn btn-secondary w-25 button-secondary" @click="addTag">اضافة كلمة</button>
                    <div class="suggestions card p-2 w-100" style="position: absolute; top: calc(100% + 10px);
                    lef: 0; max-height: 132px; overflow: auto;" v-if="search_tags && search_tags.length > 0">
                        <div class="p-1 btn btn-light mb-1" style="text-align: left;padding: .3rem 1rem !important" v-for="tag in search_tags" :key="tag.id"  @click="this.tagInput = tag.name; addTag(); this.search_tags = []" > @{{tag.name}} </div>
                    </div>
                </div>
                <ul class="d-flex gap-2 flex-wrap-wrap">
                    <li v-for="(tag, index) in tags" :key="index" class="btn btn-light">
                        @{{ tag }}
                        <button @click="removeTag(index)" class="ti ti-x" style="background: transparent; border: none; cursor: pointer;"></button>
                    </li>
                </ul>
            </div>
            <div class="w-50 mb-5" style="margin-left: auto;margin-right: auto">
                <div @click="this.showImages = true; this.current_article_id = null" class="w-100 h-100 p-3 d-flex justify-content-center align-items-center form-control input" style="height: 170px; max-height: 300px;overflow: hidden">
                    <img :src="preview_img ? preview_img : '/dashboard/images/add_image.svg'" id="preview" alt="img logo" style="width: 100%;object-fit: contain; height: 100%;max-width: 250px">
                </div>
            </div>

            <div style="display: flex;gap: 16px;justify-content: center;margin-bottom: 24px;">
                <label for="isMain">اضافة الخبر للرئيسية</label>
                <input type="checkbox" name="isMain" id="isMain" v-model="isMain">
            </div>

            <div style="display: flex;gap: 16px;justify-content: center;margin-bottom: 24px;">
                <label for="isMain">اضافة الخبر لشريط الاخبار</label>
                <input type="checkbox" name="isInNewsBar" id="isInNewsBar" v-model="isInNewsBar">
            </div>

            <div class="mb-5 w-100 d-flex gap-3 justify-content-center">
                @if(Auth::guard('admin')->user()->role !== "Writer")
                    <button type="submit" class="btn btn-primary w-25 form-control button input" style="height: fit-content" @click="getContent().then(() => { add(title, content, preview_img, cat_id, author_name, tags)})"><i class="ti ti-plus"></i> نشر الخبر</button>
                @endif
                <button type="submit" class="btn btn-primary w-25 form-control button-gray input" style="height: fit-content" @click="getContent().then(() => { add(title, content, preview_img, cat_id, author_name, tags, true)})"><i class="ti ti-plus"></i> اضافة كمسودة</button>
            </div>
        </div>
    </div>
    <h1 v-if="!categories_data || categories_data == 0" class="text-center">يرجى اضافة اقسام اولا!</h1>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('/libs/swiper.css') }}">
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
<script src="{{ asset('/libs/swiper.js') }}"></script>
@endsection

@section('scripts')

<script>
const { createApp, ref } = Vue;

createApp({
  data() {
    return {
      img_for_seo: null,
      showSettingsPopUp: false,
      img_for_seo_title: null,
      main_name: null,
      cat_id: null,
      languages_data: null,
      categories_data: @json(App\Models\Category::all()),
      sub_categories_data: null,
      thumbnail: null,
      title: '',
      sub_title: null,
      intro: '',
      content: '',
      author_name: '',
      tagInput: '',
      tags: [],
      images: null,
      showImages: false,
      showUploadPopUp: false,
      image: null,
      choosed_img: null,
      current_article_id: null,
      search_tags: null,
      preview_img: null,
      isMain: false,
      isInNewsBar: false,
      search: null,
      choosed_img_title: "",
      showSliderPopUp: false,
      showCodePopUp: false,
      author_id: null,
      slider_imgs: [],
      code: '',
      forSlider: false,
      page: 1,
      total: 0,
      last_page: 0,
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
    addTag() {
      if (this.tagInput.trim() !== '') {
        this.tags.push(this.tagInput.trim());
        this.tagInput = '';
      }
    },
    removeTag(index) {
      this.tags.splice(index, 1);
    },
    previewThumbnail () {
        this.preview_img = this.choosed_img
        this.thumbnail_title = this.choosed_img_title
        this.showImages = false
    },
    pageChanged() {
      if (!this.search) {
        this.getImages();
      } else {
        this.getSearchImages(this.search);
      }
    },
    goToFirstPage() {
      this.page = 1;
      this.pageChanged();
    },
    goToPreviousPage() {
      if (this.page > 1) {
        this.page -= 1;
        this.pageChanged();
      }
    },
    goToNextPage() {
      if (this.page < this.last_page) {
        this.page += 1;
        this.pageChanged();
      }
    },
    goToLastPage() {
      this.page = this.last_page;
      this.pageChanged();
    },
    async add(title, content, thumbnail, cat_id, author_name, tags, draft = null) {
      $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/articles/add`, {
                title: title,
                content: content,
                thumbnail: thumbnail,
                thumbnail_title: this.thumbnail_title,
                cat_id: cat_id,
                author_name: author_name,
                author_id: this.author_id,
                tags: tags,
                draft: draft ? draft : null,
                intro: this.intro,
                sub_title: this.sub_title,
                isMain: this.isMain,
                isInNewsBar: this.isInNewsBar,
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
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                    window.location.href = '{{ route("admin.dashboard") }}'
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
    async getTagSearch(search_words) {
        try {
            const response = await axios.post(`/admin/tags/search`, {
                search_words: search_words,
            },
            );
            if (response.data.status === true) {
                if (search_words != '')
                    this.search_tags = response.data.data.data
                else
                    this.search_tags = []
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
            this.Tags_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    async getImages() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.get(`/admin/images/get_images?page=${this.page}`
            );
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.images = response.data.data.data
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
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    async getSearchImages(search_words) {
        try {
            const response = await axios.post(`/admin/images/search?page=${this.page}`, {
                search_words: search_words,
            },
            );
            if (response.data.status === true) {
                this.images = response.data.data.data
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
            this.languages_data = false
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
        }
    },
    insertSliderContent(element) {
        if (this.slider_imgs.length > 3) {
            // Get the target element where you want to insert the content
            var targetElement = document.getElementById(element);

            // Get the content from the 'slider' element
            var sliderContent = document.getElementById('slider').innerHTML;
            document.getElementById(element).focus();
            document.execCommand('insertHTML', false, sliderContent);
            this.showSliderPopUp = false;
            this.slider_imgs = []
            this.setValuesToNull()
        } else {
            $("#errors").fadeIn("slow");
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "يجب ان يحتوي الاسلايدر علي اربعة صور ع الاقل";
            document.getElementById("errors").append(error);
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);
        }
    },

    async uploadImage(image) {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/images/upload`, {
                img: image,
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
                this.showUploadPopUp = false;
                this.getImages()
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3000);
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
    async setTitle() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/images/set-title`, {
                img_id: this.img_for_seo.id,
                title: this.img_for_seo_title,
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
                this.showSettingsPopUp = false;
                this.getImages()
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3000);
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
    async getCategories() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/categories/main`, {
                cat: 'cat'
            },
            );
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.categories_data = response.data.data.data
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
    pushCatTranslation(id, name) {
        this.category_translations.push({
            lang_id: id,
            name: name
        })
    },
    prevSubCat() {
        this.getSubCategories().then(() => {
            if (this.sub_categories_data.length) {
                this.show_sub_categories = true
            }
        })
    },
    execCommand(command) {
            document.execCommand(command, false, null);
        },
        insertHTML(html, element, key) {
            document.getElementById(element).focus();
            document.execCommand('insertHTML', false, html);
        },
        changeColor(event) {
            const color = event.target.value;
            document.execCommand('foreColor', false, color);
        },
        setValuesToNull () {
        this.chooseImage = null
        this.current_article_id = null
        this.showImages = null
        this.forAlbum = false
        this.forSlider = false
    },

    photoChanges(event) {
        this.thumbnail = event.target.files[0];
        var file = event.target.files[0];
        var fileType = file.type;
        var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "Invalid file type. Please choose a GIF, JPEG, or PNG image.";
            document.getElementById("errors").append(error);
            $("#errors").fadeIn("slow");
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);

            $(this).val(null);
            $("#preview").attr(
                "src",
                "/dashboard/images/add_image.svg"
            );
            $(".photo_group i").removeClass("fa-edit").addClass("fa-plus");
        } else {
            // display image preview
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#preview").attr("src", e.target.result);
                $(".photo_group  i")
                    .removeClass("fa-plus")
                    .addClass("fa-edit");
                $(".photo_group label >i").fadeOut("fast");
            };
            reader.readAsDataURL(file);
        }
    },
    imageChanges(event) {
        this.image = event.target.files[0];
                // check if file is valid image
        var file = event.target.files[0];
        var fileType = file.type;
        var validImageTypes = ["image/gif", "image/jpeg", "image/jpg", "image/png"];
        if ($.inArray(fileType, validImageTypes) < 0) {
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "Invalid file type. Please choose a GIF, JPEG, or PNG image.";
            document.getElementById("errors").append(error);
            $("#errors").fadeIn("slow");
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);

            $(this).val(null);
        } else {
            // display image preview
            var reader = new FileReader();
            reader.onload = function (e) {
            };
            reader.readAsDataURL(file);
        }

    },
    async getContent () {
        if (document.getElementById('article-content') && document.getElementById('article-content').innerHTML != '')
            this.content = document.getElementById('article-content').innerHTML;
    },
    chooseImage(imagePath) {
        this.choosed_img = imagePath;
    },
    insertImgToArticle () {
        if (this.current_article_id) {
            if (this.choosed_img) {
                this.insertHTML('<div class="embeded_img" style="width: min-content"><img src="' + this.choosed_img + '" /><p style="text-align: center">' + this.choosed_img_title + '</p></div><p></p>', this.current_article_id)
                this.chooseImage = null
                this.current_article_id = null
                this.showImages = null
            }else {
                document.getElementById('errors').innerHTML = ''
                let err = document.createElement('div')
                err.classList = 'error'
                err.innerHTML = 'Please Choose an image or uploade one'
                document.getElementById('errors').append(err)
                $('#errors').fadeIn('slow')
                $('.loader').fadeOut()
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

            }
        } else if (this.forSlider) {
            this.slider_imgs.push(this.choosed_img)
            this.chooseImage = null
            this.current_article_id = null
            this.showImages = null
        } else if (this.forAlbum) {
            this.album_imgs.push(this.choosed_img)
            this.chooseImage = null
            this.current_article_id = null
            this.showImages = null
        }
        else {
            this.previewThumbnail()
        }

    },
  },
  created() {
    this.getImages()
  },
  mounted() {
    $(document).on('click', '.imgs .img', function () {
        $(this).css('border', '1px solid #13DEB9')
        $(this).siblings().css('border', 'none')
    })
  },
}).mount('#add_cat')
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
