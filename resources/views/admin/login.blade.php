<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Russo+One&display=swap");

        svg {
            font-family: "Russo One", sans-serif;
            width: 100%; height: 100%;
        }
        svg text {
            animation: stroke 6s infinite alternate;
            stroke-width: 1px;
            stroke: rgba(255, 0, 0, 1);
            font-size: 50px;
        }
        @keyframes stroke {
            0%   {
                fill: rgba(72,138,204,0); stroke: rgba(255, 0, 0, 1);
                stroke-dashoffset: 25%; stroke-dasharray: 0 50%; stroke-width: 2;
            }
            70%  {fill: rgba(72,138,204,0); stroke: rgba(255, 0, 0, 1); }
            80%  {fill: rgba(72,138,204,0); stroke: rgba(255, 0, 0, 1); stroke-width: 3; }
            100% {
                fill: rgba(255, 0, 0, 1); stroke: rgba(54,95,160,0);
                stroke-dashoffset: -25%; stroke-dasharray: 50% 0; stroke-width: 0;
            }
        }

        .wrapper {
            background-color: #00000031;
            backdrop-filter: blur(2px);
            width: 100%;
            height: 100%;
        }

        .loader {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            display: none
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

    </style>
    <link rel="stylesheet" href="{{ asset('/dashboard/css/login.css') }}?v={{ time() }}">
</head>    

<body>
    <!--  Body Wrapper -->
    <div id="errors"></div>
    <div class="loader">
        <div class="wrapper">
            <svg>
                <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                    تسجيل ...
                </text>
            </svg>
        </div>
    </div>

    <div id="login">
        <img src="{{ asset('/dashboard/images/logo.png') }}" alt="">
        <form @submit.prevent>
            <input type="text" id="username" aria-describedby="emailHelp" placeholder="المستخدم" v-model="username">
            <input type="password" id="password" placeholder="كلمة السر" v-model="password">
            <button type="submit" @click="login(this.username, this.password)">تسجيل دخول</button>
        </form>
    </div>
    <script src="{{ asset('/libs/vue.js') }}"></script>
    <script src="{{ asset('/libs/jquery.js') }}"></script>
    <script src="{{ asset('/libs/axios.js') }}"></script>
    <script src="{{ asset('/dashboard/js/login.js') }}?v={{ time() }}"></script>

</body>

</html>