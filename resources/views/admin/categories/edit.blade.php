@extends('admin.layouts.admin-layout')

@section('title', 'تعديل القسم')
@section('categories_prev', 'active')

@section('content')
<h3 class="mb-5 page-title">
    تعديل قسم
</h3>
<div class="card" id="edit_cat">
    <div class="card-body">
        @if($category)
        <div>
            <div class="w-100 mb-3">
                <input type="text" class="form-control w-50" id="symbol" v-model="main_name" >
                <input type="hidden" name="category_id" id="category_id" value="{{ $category?->id }}">
            </div>
            <!-- Swiper -->
            <div class="gap-2 w-100 mb-3 pb-3" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="swiper-slide w-100">
                    <div>
                        <input type="color" class="form-control" id="cat_name" v-model="color" placeholder="اسم القسم *">
                    </div>
                </div>
            </div>
            <div class="w-100 mb-4 d-flex gap-4">
                <textarea name="description" id="description" cols="30" rows="10" class="form-control w-75" placeholder="وصف القسم" v-model="description"></textarea>
            </div>
            <div  class="d-flex justify-content-between gap-4 align-items-end flex-wrap-wrap">
                <button type="submit" class="btn btn-primary w-50 form-control button mb-4" style="height: fit-content" @click="save(main_name, description, color)">Save</button>
            </div>
        </div>
        @else
        @php
            return redirect('/admin/categories/preview');
        @endphp
        @endif
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('/public/libs/swiper.css') }}">
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
<script src="{{ asset('/public/libs/swiper.js') }}"></script>

<!-- Initialize Swiper -->
<script>
window.onload = function() {
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
};
</script>

<script>
const { createApp, ref } = Vue;

createApp({
  data() {
    return {
      main_name: null,
      color: null,
      main_cat_id: null,
      description: null,
      languages_data: null,
      categories_data: null,
      category_data: null,
      category_names: null,
      category_translations: {},
      show_main_categories: false,
      category_id: undefined,
      thumbnail_path: null,
      thumbnail: null,
      images: null,
      showImages: false,
      showUploadPopUp: false,
      image: null,
      choosed_img: null,
      preview_img: null,
      page: 1,
      total: 0,
      last_page: 0,
    }
  },
  methods: {
    async save(main_name, description, color) {
      $('.loader').fadeIn().css('display', 'flex')
      try {
        const response = await axios.post(`/admin/categories/edit`, {
          main_name: main_name,
          description: description,
          category_id: this.category_data.id,
          color: color
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
            window.location.href = '/admin/categories'
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
    async getCategory() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/category`, {
                category_id: this.category_id
            },
            );
            if (response.data.status === true) {
                $('.loader').fadeOut()
                this.category_data = response.data.data
                this.main_name = this.category_data.main_name
                this.description = this.category_data.description
                this.color = this.category_data.color
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
  },
  mounted() {
    this.category_id = document.getElementById('category_id').value ? document.getElementById('category_id').value : undefined;
    this.getCategory()
    $(document).on('click', '.imgs .img', function () {
        $(this).css('border', '1px solid #13DEB9')
        $(this).siblings().css('border', 'none')
    })

  },
}).mount('#edit_cat')
</script>
@endsection
