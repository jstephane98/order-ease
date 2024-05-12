<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-200">

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white overflow-hidden shadow-xl">
                <div class="sm:justify-center flex items-center">
                    <a href="/">
                        <x-application-logo class="w-48" />
                    </a>
                </div>

                {{ $slot }}

                {{-- Social Link --}}
                <div class="mt-6 w-full flex flex-row uppercase border-0 after:flex-grow after:flex-shrink after:basis-[auto] after:h-[12px] after:m-0 after:border-b-[1px] after:ml-1.5 before:flex-grow before:flex-shrink before:basis-[auto] before:h-[12px] before:m-0 before:border-b-[1px] before:mr-1.5">
                    <span>ou</span>
                </div>

                <div class="mt-4 mb-4">
                    <a href="{{ route('social-authenticated', 'google') }}" class="w-full flex border border-gray-600 rounded-sm text-left pl-8 pt-3 pb-3 hover:bg-gray-200">
                        <i class='bx bxl-google bx-sm mr-2'></i>
                        <span>Continuer avec Google</span>
                    </a>
                    <a href="{{ route('social-authenticated', 'facebook') }}" class="w-full flex border border-gray-600 rounded-sm text-left pl-8 pt-3 pb-3 mt-2.5 hover:bg-gray-200">
                        <i class='bx bxl-facebook-circle bx-sm mr-2' ></i>
                        <span>Continuer avec Facebook</span>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
