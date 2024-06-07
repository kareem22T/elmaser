<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>المصير|  @yield('title')</title>
  @yield('styles')
  <link rel="stylesheet" href="{{ asset('/dashboard/css/styles.min.css') }}?v={{ time() }}" />
  <link rel="stylesheet" href="{{ asset('/dashboard/css/styles.css') }}?v={{ time() }}" />
  <link rel="stylesheet" href="{{ asset('/libs/css/swiperadmin.css') }}?v={{ time() }}" />
  <style>
    .pop-up {
      margin: auto;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      max-width: 500px;
      z-index: 99999999;
    }
    .hide-content {
      width: 100vw;
      height: 100vh;
      background-color: #0000004d;
      position: fixed;
      top: 0;
      left: 0;
      z-index: calc(99999993 - 1);
    }
    #errors {
      position: fixed;
      top: 1.25rem;
      right: 1.25rem;
      display: flex;
      flex-direction: column;
      max-width: calc(100% - 1.25rem * 2);
      gap: 1rem;
      z-index: 99999999999999999999;

    }
    #errors >* {
      width: 100%;
      color: #fff;
      font-size: 1.1rem;
      padding: 1rem;
      border-radius: 1rem;
      box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    #errors .error {
      background: #e41749;
    }
    #errors .success {
      background: #12c99b;
    }
    .loader {
      width: 100vw;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      justify-content: center;
      align-items: center;
      z-index: 9999999999999999999999999999999999 !important;
      background: #fafafa !important;
      backdrop-filter: blur(1px);
      display: flex
    }
    .custom-loader {
      --d:22px;
      width: 4px;
      height: 4px;
      border-radius: 50%;
      color: rgba(255, 0, 0, 1);
      box-shadow:
        calc(1*var(--d))      calc(0*var(--d))     0 0,
        calc(0.707*var(--d))  calc(0.707*var(--d)) 0 1px,
        calc(0*var(--d))      calc(1*var(--d))     0 2px,
        calc(-0.707*var(--d)) calc(0.707*var(--d)) 0 3px,
        calc(-1*var(--d))     calc(0*var(--d))     0 4px,
        calc(-0.707*var(--d)) calc(-0.707*var(--d))0 5px,
        calc(0*var(--d))      calc(-1*var(--d))    0 6px;
      animation: s7 1s infinite steps(8);
    }

    @keyframes s7 {
      100% {transform: rotate(1turn)}
    }

    .show {
      display: block !important;
    }
  </style>
</head>

<body>
  <div id="errors"></div>
  <div class="loader">
    <div class="custom-loader"></div>
  </div>
  <!--  Header End -->
  @if(Auth::guard("admin")->user()->role !== "Writer")
  <header>
    <div class="logo">
      <a href="{{ route('admin.dashboard') }}" >
        <img src="{{ asset('/dashboard/images/logo.png') }}" alt="">
      </a>
    </div>
    <a href="{{ route('article.add') }}" class="@yield('add_article_active_btn')">
      <i class="ti ti-text-plus"></i>
    </a>
    @if(Auth::guard("admin")->user()->role === "Master")
      <a href="{{ route('categories.prev') }}" class="@yield('categories_prev')">
        <i class="ti ti-category"></i>
      </a>
      <a href="{{ route('home.edit') }}" class="@yield('categories_add_active')">
        <i class="ti ti-home"></i>
      </a>
      <a href="/admin/admins" class="@yield('admins_active')">
        <i class="ti ti-shield"></i>
      </a>
      <a href="/admin/settings" class="@yield('settings_active')">
        <i class="ti ti-settings"></i>
      </a>
    @endif
  </header>
  @endif
  <div class="container mt-4">
    @yield('content')
  </div>
  <script src="{{ asset('/dashboard/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('/dashboard/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('/dashboard/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('/dashboard/js/app.min.js') }}"></script>
  <script src="{{ asset('/dashboard/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="{{ asset('/libs/vue.js') }}"></script>
  <script src="{{ asset('/libs/jquery.js') }}"></script>
  <script src="{{ asset('/libs/axios.js') }}"></script>
  <script src="{{ asset('/libs/swiperadmin.js') }}"></script>

  @yield('scripts')
</body>

</html>
