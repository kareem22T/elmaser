@extends('admin.layouts.admin-layout')

@section('title', 'اضافة قسم')

@section('categories_prev', 'active')

@section('content')
<h3 class="mb-5 page-title">
    اضافة قسم
</h3>
<div id="add_cat">
    <div>
        <div>
            <div class="gap-2 w-100 mb-3 pb-3" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="swiper-slide w-100">
                    <div>
                        <input type="text" class="form-control" id="cat_name" v-model="name" placeholder="اسم القسم *">
                    </div>
                </div>
            </div>
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
                <div class="w-50" v-if="show_main_categories">
                    <label for="symbol" class="form-label">اختار قسم رئيسي *</label>
                    <select name="cat_type" id="cat_type" class="form-control" v-model="main_cat_id">
                        <option v-for="(category, index) in categories_data" :key="index" :value="category.id" v-if="categories_data.length > 0">
                            @{{category.main_name}}
                        </option>
                        <option v-if="!categories_data.length" value="">
                            There is no any Main Category Added
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-50 form-control button mb-4" style="height: fit-content" @click="add(name, description)"><i class="ti ti-plus"></i> اضافة القسم</button>
            </div>
        </div>
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
<script src="{{ asset('/public/libs/swiper.js') }}"></script>
@endsection

@section('scripts')
<!-- Swiper JS -->

<!-- Initialize Swiper -->
<script>
const { createApp, ref } = Vue;

createApp({
  data() {
    return {
        name: null,
        color: null,
      cat_type: null,
      main_cat_id: null,
      description: null,
      categories_data: null,
      category_translations: {},
      show_main_categories: false,
      thumbnail: null,
      images: null,
      showImages: false,
      showUploadPopUp: false,
      image: null,
      choosed_img: null,
      preview_img: null,
      search: null,
      page: 1,
      total: 0,
      last_page: 0,
    }
  },
  methods: {
    async add(main_name, description) {
      $('.loader').fadeIn().css('display', 'flex')
      try {
        const response = await axios.post(`/admin/categories/add`, {
          name: main_name,
          color: this.color,
          description: description,
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
    async getCategories() {
        $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`/admin/categories/main`, {
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
    chooseCatType(cat_type) {
        if (cat_type == 1) {
            this.getCategories().then(()=> {
                this.show_main_categories = true
            })
        } else {
            this.show_main_categories = false
        }
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
    previewThumbnail () {
        this.preview_img = this.choosed_img
        this.showImages = false
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
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
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
            setTimeout(() => {
                $('#errors').fadeOut('slow')
            }, 3500);

            console.error(error);
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
