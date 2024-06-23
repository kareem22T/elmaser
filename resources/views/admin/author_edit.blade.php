@extends('admin.layouts.admin-layout')

@section('name', 'تعديل بيانات الناشر')

@section('authors_add_active', 'active')

@if($Author)
@section('content')
<h3 class="mb-5">
    تعديل بيانات الناشر
</h3>
<style>
    .toolbar button {
        font-size: 22px;
        font-weight: bold
    }
</style>
<div class="card" id="add_article">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
    <div class="card-body" >
        <div>
            <div class="w-100 mb-4 gap-2" style="display: grid; grid-template-columns: 1fr 1fr;">
                <div class="w-100">
                    <div>
                        <label for="name" class="form-label">اسم الناشر *</label>
                        <input type="text" class="form-control" id="name" v-model="name">
                    </div>
                </div>
                <div class="w-100">
                    <div>
                        <label for="description" class="form-label">وصف الناشر *</label>
                        <input type="text" class="form-control" id="description" v-model="description">
                    </div>
                </div>
            </div>
            <div class="mb-3 w-100">
                <div class="w-25">
                    <!-- Swiper -->
                    <div class="w-100 mb-3 pb-5">
                        <button type="submit" class="btn btn-primary w-50 form-control" style="height: fit-content" @click="this.getContentArticle().then(() => {this.update()})"><i class="ti ti-edit"></i> تحديث</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="hide-content" v-if="showImages || showSliderPopUp || showCodePopUp || showAlbumPopUp"></div>

    <div class="pop-up show-images-pop-up card" v-if="showImages" style="min-width: 90vw;height: 90vh;padding: 20px;display: flex;flex-direction: column;justify-content: space-between;gap: 1rem;">
        <input type="text" name="search" id="search" class="form-control w-25 mb-2" placeholder="بحث ..." v-model="search" @input="getSearchImages(this.search)">
        <div class="imgs p-2 gap-3" v-if="images && images.length" style="display: flex;grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));flex-wrap: wrap;height: 100%;overflow: auto;">
            <div class="img" @click="this.choosed_img = '{{ asset("/dashboard/images/uploads") }}/' + img.path; this.choosedImgId = img.id" v-for="(img, index) in images" :key="img.id" style="width: 260px;height: 230px;overflow: hidden;padding: 10px;border-radius: 1rem;box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                <img :src="'{{ asset("/dashboard/images/uploads") }}/' + img.path" id="preview" alt="img logo" style="width: 100%;height: 100%;object-fit: contain;">
            </div>
        </div>
        <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1">
            <div v-for="page_num in last_page" :key="page_num" >
                <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num == page ? 'active' : ''">@{{ page_num }}</label>
                <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="!search ? getImages() : getSearchImages(this.search)">
            </div>
        </div>
        <h1 v-if="images && !images.length && !search">There is not any image yet! (upload now)</h1>
        <div class="foot" style="display: flex;width: 100%;justify-content: space-between;gap: 1rem;">
            <button class="btn btn-primary" @click="this.showUploadPopUp = true">Upload Image</button>
            <div class="hide-content" v-if="showUploadPopUp"></div>
            <div class="pop-up card p-3" v-if="showUploadPopUp">
                <label for="image" class="mb-2">Choose Image File</label>
                <input type="file" name="image" id="image" class="form-control mb-4" @change="imageChanges">
                <div class="d-flex gap-2 w-100 justify-content-center">
                    <button class="btn btn-light"  @click="this.showUploadPopUp = false">Cancel</button>
                    <button class="btn btn-secondary" @click="uploadImage(image)">
                        Add Image
                    </button>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-light"  @click="this.showImages = false; this.search = null;this.forSlider = false">Cancel</button>
                <button class="btn btn-success"  @click="insertImgToArticle();this.forSlider = false">Choose</button>
            </div>
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
</div>
@endsection

@section('scripts')
<script>
const { createApp, ref } = Vue;

createApp({
  data() {
    return {
      thumbnail: null,
      name: '{{$Author->name}}',
      description: '{{$Author->description}}',
      content: '',
      images: null,
      showImages: false,
      showUploadPopUp: false,
      image: null,
      choosed_img: null,
      current_article_id: null,
      search_tags: null,
      preview_img: '{{$Author->profile_path}}',
      search: null,
      page: 1,
      total: 0,
      last_page: 0,
      forSlider: false,
      slider_imgs: [],
      showSliderPopUp: false,
      code: '',
      showCodePopUp: false,
      album_imgs: [],
      brief: '{{$Author->brief}}',
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
        this.showImages = false
    },
    async update() {
      $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`{{ route('author.update') }}`, {
                id:'{{$Author->id}}',
                name: this.name,
                description: this.description,
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
                window.location.href = '{{ route("authors.prev") }}'
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
    },    execCommand(command) {
        document.execCommand(command, false, null);
    },
    insertHTML(html, element, key) {
        document.getElementById(element).focus();
        document.execCommand('insertHTML', false, html);
        document.execCommand('insertHTML', false, "<br>");
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
    insertAlbumContent(element) {
        if (this.album_imgs.length > 2) {
            // Get the target element where you want to insert the content
            var targetElement = document.getElementById(element);

            // Get the content from the 'slider' element
            var sliderContent = document.getElementById('album').innerHTML;
            document.getElementById(element).focus();
            document.execCommand('insertHTML', false, sliderContent);
            this.showAlbumPopUp = false;
            this.album_imgs = []
            this.setValuesToNull()
        } else {
            $("#errors").fadeIn("slow");
            document.getElementById("errors").innerHTML = "";
            let error = document.createElement("div");
            error.classList = "error";
            error.innerHTML =
                "يجب ان يحتوي الالبوم علي تلاثة صور ع الاقل";
            document.getElementById("errors").append(error);
            setTimeout(() => {
                $("#errors").fadeOut("slow");
            }, 2000);
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
    chooseImage(imagePath) {
        this.choosed_img = '/dashboard/images/uploads/' + imagePath;
    },
    setValuesToNull () {
        this.chooseImage = null
        this.current_article_id = null
        this.showImages = null
        this.forAlbum = false
        this.forSlider = false
    },
    insertImgToArticle () {
        if (this.current_article_id) {
            if (this.choosed_img) {
                this.insertHTML('<img src="' + this.choosed_img + '" />', this.current_article_id)
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
    async getContentArticle() {
        console.log(this.languages_data);
        if (document.getElementById('article-content') && document.getElementById('article-content').innerHTML != '')
            this.content = document.getElementById('article-content').innerHTML;
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
}).mount('#add_article')
</script>
@endsection
@endif
