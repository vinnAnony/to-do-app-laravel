<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hot Tasks') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans" {{ session('message') ? 'data-notification' : '' }} data-notification-type='success' data-notification-message="{{ json_encode(session('message')) }}">
<div id="app">

    <div class="flex flex-wrap place-items-center sticky top-0 z-50">
        <section class="relative mx-auto">
            <!-- navbar -->
            <nav>
                <div class="flex justify-between bg-gray-900 text-white w-screen sm:hidden">
                    <div class="px-5 xl:px-12 py-6 flex w-full items-center">
                        <a class="text-3xl font-bold font-heading" href="{{ url('/') }}">
                            {{ config('app.name', 'Hot Tasks') }}
                        </a>
                        <!-- Nav Links -->
                        <ul class="hidden md:flex px-4 mx-auto font-semibold font-heading space-x-12">
                            @guest
                                <li><a class="hover:text-gray-200" href="{{ route('login') }}">Login</a></li>
                                @if (Route::has('register'))
                                    <li><a class="hover:text-gray-200" href="{{ route('register') }}">Register</a></li>
                                @endif
                            @else
                                <li><a class="hover:text-gray-200" href="{{ route('home') }}">Home</a></li>
                                <li><a class="hover:text-gray-200" href="{{ route('posts') }}">Guzzler</a></li>
                                <li><a class="hover:text-gray-200" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        Logout</a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    {{ csrf_field() }}
                                </form>

                        </ul>

                    </div>
                    <div class="flex mr-6 items-center">
                        <div class="inline-block rounded-full h-10 w-10 border-radius-10">
                            <img class="rounded-full h-10 w-10 border-radius-10" src="{{asset('storage/images/avatars/'.Auth::user()->profile_url )}}">
                        </div>
                    </div>
                    @endguest

                    <a class="self-center mr-12 lg:hidden"id="navbar-burger">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hover:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </a>

                    <div class="hidden flex items-center justify-center py-4" id="mobile-menu">
                        <div class=" sm:flex sm:items-center">
                            <ul class="">
                                <li class="active"><a href="index.html" class="block text-sm px-2 py-4 text-white bg-green-500 font-semibold">Home</a></li>
                                <li><a href="#services" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Services</a></li>
                                <li><a href="#about" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">About</a></li>
                                <li><a href="#contact" class="block text-sm px-2 py-4 hover:bg-green-500 transition duration-300">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </section>
    </div>

    @yield('content')
</div>

<script type="text/javascript">
    function deleteConfirmation() {
        swal({
            title: "Do you want to delete task?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d64c58',
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
        }).then(function (value) {
            if (value) {
                //event.preventDefault();
                document.getElementById('deleteTaskForm').submit();
            }
        });
    }

    (function(){
        const button = document.getElementById('navbar-burger'); // Hamburger Icon
        const menu = document.getElementById('mobile-menu'); // Menu

        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            console.log("wiiii")
        });
    })();

</script>
</body>
</html>

