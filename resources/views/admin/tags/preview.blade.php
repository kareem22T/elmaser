@extends('admin.layouts.admin-layout')

@section('title', 'Tags')

@section('Tags_preview_active', 'active')

@section('content')
<h3 class="mb-5">
    Tags
</h3>
<div class="card w-100" id="Tag_prev">
    <div class="card-header d-flex justify-content-between gap-3">
        <input type="text" name="search" id="search" class="form-control w-25" placeholder="Search" v-model="search" @input="getSearch(this.search)">
        <a href="/admin/tags/add" class="btn btn-primary w-fit d-flex gap-2 align-items-center">
            <i class="ti ti-plus"></i> Add Tag
        </a>
    </div>
    <div class="card-body p-4">
    <div class="table-responsive" v-if="Tags_data && Tags_data.data.length > 0">
        <table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4">
            <tr>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">Id</h6>
                    {{-- <a href="" class="ml-2 sort text-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-sort" width="1rem" height="1rem" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 9l4 -4l4 4m-4 -4v14"></path>
                            <path d="M21 15l-4 4l-4 -4m4 4v-14"></path>
                        </svg>
                    </a> --}}
                </th>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">Tag name</h6>
                </th>
                <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0 d-inline-flex align-items-center">Controls</h6>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(Tag, index) in Tags_data.data" :key="index">
                <td class="border-bottom-0"><h6 class="fw-semibold mb-0">@{{Tag.id}}</h6></td>
                <td class="border-bottom-0">
                    <p class="mb-0 fw-normal">@{{Tag.name}}</p>
                </td>
                <td class="border-bottom-0">
                    <div class="d-flex gap-2">
                        <button class="btn btn-secondary p-2 edit_Tag_btn" @click="this.edit_pop_up = true; getValues(Tag.id, Tag.name)"><h4 class="ti ti-edit text-light m-0 fw-semibold"></h4></button>
                        <button class="btn btn-danger p-2" @click="this.delete_pop_up = true; getValues(Tag.id, Tag.name)"><h4 class="ti ti-trash text-light m-0 fw-semibold"></h4></button>
                    </div>
                </td>
            </tr>
        </tbody>
        </table>
    </div>
    <div class="pagination w-100 d-flex gap-2 justify-content-center mt-3" v-if="last_page > 1">
        <div v-for="page_num in last_page" :key="page_num" >
            <label :for="`page_num_${page_num}`" class="btn btn-primary" :class="page_num == page ? 'active' : ''">@{{ page_num }}</label>
            <input type="radio" class="d-none" name="page_num" :id="`page_num_${page_num}`" v-model="page" :value="page_num" @change="search == '' ? getTags() : getSearch(this.search)">
        </div>
    </div>

    <h4 class="text-center">
        @{{ Tags_data && Tags_data.data.length == 0 ? 'There is no any added Tag' : '' }}
    </h4>
    <h4 class="text-center">
        @{{ Tags_data === false ? 'Server error try again later' : '' }}
    </h4>
    </div>
    <div class="hide-content" v-if="edit_pop_up"></div>
    <div class="pop-up edit_pop_up card w-50" style="margin: auto; display: none;"  :class="{ 'show': edit_pop_up }" v-if="edit_pop_up">
        <div class="card-body">
            <form @submit.prevent>
                <div class="form-group w-100">
                    <label for="name" class="mb-2">
                        Tag Name
                    </label>
                    <input type="text" name="name" id="name" class="form-control mb-2" :value="tag_name" v-model="tag_name">
                </div>
                <div class="btns d-flex w-100 justify-content-between gap-3">
                    <button class="btn btn-light w-100" @click="edit_pop_up = false; getValus(null, null, null)">Cancel</button>
                    <button class="btn btn-secondary w-100" @click="update(tag_id, tag_name)">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="hide-content" v-if="delete_pop_up"></div>
    <div class="pop-up delete_pop_up card w-50" style="margin: auto; display: none;"  :class="{ 'show': delete_pop_up }" v-if="delete_pop_up">
        <div class="card-body">
            <form @submit.prevent>
                <h5 class="mb-3 text-center">Are you sure you want to delete "@{{ tag_name }}"" Tag?</h5>
                <div class="btns d-flex w-100 justify-content-between gap-3">
                    <button class="btn btn-light w-100" @click="delete_pop_up = false; getValus(null, null, null)">Cancel</button>
                    <button class="btn btn-danger w-100" @click="deleteTag(tag_id)">delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const { createApp, ref } = Vue

createApp({
    data() {
        return {
            tag_id: null,
            tag_name: null,
            edit_pop_up: false,
            delete_pop_up: false,
            Tags_data: null,
            search: null,
            page: 1,
            total: 0,
            last_page: 0,
        }
    },
    methods: {
        async update(tag_id, tag_name) {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`/admin/tags/edit`, {
                    tag_id: tag_id,
                    tag_name: tag_name,
                },
                );
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
        async deleteTag(tag_id) {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`/admin/tags/delete`, {
                    tag_id: tag_id,
                },
                );
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
        async getTags() {
            $('.loader').fadeIn().css('display', 'flex')
            try {
                const response = await axios.post(`/admin/tags?page=${this.page}`, {
                },
                );
                if (response.data.status === true) {
                    $('.loader').fadeOut()
                    this.Tags_data = response.data.data
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
                this.Tags_data = false
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
        async getSearch(search_words) {
            try {
                const response = await axios.post(`/admin/tags/search?page=${this.page}`, {
                    search_words: search_words,
                },
                );
                if (response.data.status === true) {
                    this.Tags_data = response.data.data
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
                this.Tags_data = false
                setTimeout(() => {
                    $('#errors').fadeOut('slow')
                }, 3500);

                console.error(error);
            }
        },
        getValues(tag_id, tag_name) {
            this.tag_id = tag_id
            this.tag_name = tag_name
        }
    },
    created() {
        this.getTags()
        $('.loader').fadeOut()
    },
}).mount('#Tag_prev')
</script>
@endsection