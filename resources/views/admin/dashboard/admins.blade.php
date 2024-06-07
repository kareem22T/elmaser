@extends('admin.layouts.admin-layout')

@section('title', 'Admins')
@section('admins_active', 'active')

@section('content')
<div class="admins_wrapper" id="admins_wrapper">
    <div class="switchs">
        <button :class="showWriter ? 'active' : ''" @click="showMasters = false;showWriter = true; showPublisher = false; ShowModerators = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-pencil" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M10 18l5 -5a1.414 1.414 0 0 0 -2 -2l-5 5v2h2z" />
              </svg>
            الكاتبون
        </button>
        <button :class="showPublisher ? 'active' : ''" @click="showMasters = false;showWriter = false; showPublisher = true; ShowModerators = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-news" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" />
                <path d="M8 8l4 0" />
                <path d="M8 12l4 0" />
                <path d="M8 16l4 0" />
              </svg>
            الناشرين
        </button>
    </div>
    <div class="card w-100 mt-4" id="word_prev"  v-if="showWriter">
        <div class="card-header d-flex justify-content-between gap-3">
            <h1>الكاتبون</h1>
            <button class="btn btn-primary w-fit d-flex gap-2 align-items-center" @click="admin_title = 'Writer';showAddAdmin = true">اضافة كاتب <i class="ti ti-plus"></i></button>
        </div>
        <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">اسم المستخدم</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">التحكم</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="Writers && Writers.length > 0" v-for="admin in Writers" :key="admin.id">
                    <td>@{{admin.username}}</td>
                    <td>
                        <div class="btns d-flex flex-center gap-2">
                            <button class="btn btn-danger" @click="this.delete(admin.id, admin.username)"><i class='ti ti-trash'></i></button>
                        </div>
                    </td>
                </tr>
                <tr v-if="!Writers || Writers.length == 0" style="font-size: 20px; font-weight: 700; text-align: center">
                    <td colspan="5"><h2>لا يوجد كاتبون!</h2></td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1">
            <div v-for="page_num in last_page" :key="page_num" >
                <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num == page ? 'active' : ''">@{{ page_num }}</label>
                <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="search == '' ? getarticles() : getSearch(this.search)">
            </div>
        </div>
        <h4 class="text-center">
            @{{ articles_data && articles_data.length == 0 ? 'There is no any Article' : '' }}
        </h4>
        <h4 class="text-center">
            @{{ articles_data === false ? 'Server error try again later' : '' }}
        </h4>
        </div>
    </div>

    <div class="card w-100 mt-4" id="word_prev"  v-if="showPublisher">
        <div class="card-header d-flex justify-content-between gap-3">
            <h1>الناشرين</h1>
            <button class="btn btn-primary w-fit d-flex gap-2 align-items-center" @click="admin_title = 'Publisher';showAddAdmin = true">اضافة ناشر <i class="ti ti-plus"></i></button>
        </div>
        <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
            <thead class="text-dark fs-4">
                <tr>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">اسم المستخدم</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">التحكم</h6>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="Publishers && Publishers.length > 0" v-for="admin in Publishers" :key="admin.id">
                    <td>@{{admin.username}}</td>
                    <td>
                        <div class="btns d-flex flex-center gap-2">
                            <button class="btn btn-danger" @click="this.delete(admin.id, admin.username)"><i class='ti ti-trash'></i></button>
                        </div>
                    </td>
                </tr>
                <tr v-if="!Publishers || Publishers.length == 0" style="font-size: 20px; font-weight: 700; text-align: center">
                    <td colspan="5"><h2>لا يوجد ناشرين!</h2></td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1">
            <div v-for="page_num in last_page" :key="page_num" >
                <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num == page ? 'active' : ''">@{{ page_num }}</label>
                <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="search == '' ? getarticles() : getSearch(this.search)">
            </div>
        </div>
        <h4 class="text-center">
            @{{ articles_data && articles_data.length == 0 ? 'There is no any Article' : '' }}
        </h4>
        <h4 class="text-center">
            @{{ articles_data === false ? 'Server error try again later' : '' }}
        </h4>
        </div>
    </div>


    <div class="hide-content" @click="showAddAdmin = false" v-if="showAddAdmin | showEditAdmin"></div>
    <div class="pop-up show_request_details_wrapper card p-3 gap-3" v-if="showAddAdmin">
        <h1 class="text-center">Add @{{ admin_title }}</h1>
        <br>
        <div class="form-group">
            <input type="text" name="username" id="username" class="form-control" v-model="username" placeholder="اسم المستخدم">
        </div>
        <br>
        <div class="form-group">
            <input type="text" name="password" id="password" class="form-control" v-model="password" placeholder="كلمة المروم">
        </div>
        <br>
        <div class="btns d-flex gap-2 flex-center justify-content-center">
            <button class="btn btn-secondary" @click="showAddAdmin = false;admin_data = null">الغاء</button>
            <button class="btn btn-success" @click="add()">اضاقة</button>
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
        masters: null,
        Writers: null,
        Publishers: null,
        moderators: null,
        showMasters: true,
        showWriter: false,
        showPublisher: true,
        ShowModerators: false,
        showAddAdmin: false,
        admin_title: null,
        username: null,
        email: null,
        phone: null,
        password: null,
        to_edit_username: null,
        to_edit_email: null,
        to_edit_phone: null,
        to_edit_password: null,
        to_edit_id: null,
        to_edit_password_confirmation: null,
        showEditAdmin: false,
        admin_data: null
    }
  },
  methods: {
    getEditValues(admin) {
        this.to_edit_username = admin.username;
        this.to_edit_email = admin.email;
        this.to_edit_phone = admin.phone;
        this.to_edit_role = admin.role;
        this.to_edit_id = admin.id;
    },
    async getAdmins() {
      $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.get(`{{ route('get.admins') }}`,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            );
            if (response.data.status === true) {
                document.getElementById('errors').innerHTML = ''
                $('.loader').fadeOut()
                this.Writers = response.data.data.Writers
                this.Publishers = response.data.data.Publisher
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
    async add() {
      $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`{{ route('admin.add') }}`, {
                username: this.username,
                password: this.password,
                role: this.admin_title,
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
                    window.location.reload()
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
    async edit() {
      $('.loader').fadeIn().css('display', 'flex')
        try {
            const response = await axios.post(`{{ route('admin.update') }}`, {
                admin_id: this.to_edit_id,
                username: this.to_edit_username,
                password: this.to_edit_password,
                password_confirmation: this.to_edit_password_confirmation,
                role: this.to_edit_role,
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
                    window.location.reload()
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
    async delete(id, name) {
        if (confirm("Are you sure you want to delete " + name + " account")) {
        $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`{{ route('admin.delete') }}`, {
                    admin_id: id,
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
                        window.location.reload()
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
        }
    },
  },
  created() {
    this.getAdmins()
    $('.loader').fadeOut()
  },
  mounted() {
  },
}).mount('#admins_wrapper')
</script>
@endsection
