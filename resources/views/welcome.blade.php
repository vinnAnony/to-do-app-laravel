<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
<div class="flex flex-col">
    @if(Route::has('login'))
        <div class="absolute top-0 right-0 mt-4 mr-4 space-x-4 sm:mt-6 sm:mr-6 sm:space-x-6">
            @auth
                <a href="{{ url('/home') }}" class="no-underline hover:gray-900  text-teal-800 font-semibold font-heading space-x-12">{{ __('Home') }}</a>
            @else
                <a href="{{ route('login') }}" class="no-underline hover:gray-900  text-teal-800 font-semibold font-heading space-x-12">{{ __('Login') }}</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="no-underline hover:gray-900 text-teal-800 font-semibold font-heading space-x-12">{{ __('Register') }}</a>
                @endif
            @endauth
        </div>
    @endif
    <div class="min-h-screen flex items-center justify-center m-3">
        <div class="flex justify-center align-center h-full">
            <div class="bg-indigo-600 text-white rounded shadow-xl py-5 px-5 w-full lg:w-10/12 xl:w-3/4">
                <div class="flex flex-wrap -mx-3 items-center justify-center align-center">
                    <h3 class="text-2xl">Welcome to Hot Tasks!</h3>
                    <div class="w-1/4 px-3 text-center hidden md:block">
                        <div class="p-5 xl:px-8 md:py-5">

                        </div>
                    </div>
                    <div class="w-full sm:w-1/2 md:w-2/4 px-3 text-center">
                        <div class="p-5 xl:px-8 md:py-5">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
