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

            <div class="text-sm text-gray-600 text-center mt-4 mb-4">
                <h1 class="text-2xl mb-4 font-bold">{{ __("	Réinitialiser le mot de passe") }}</h1>

                {{ __('Saisissez nouveau mot de passe.') }}
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-password :name="'password'" :id="'password'" :placeholder="__('Mot de passe*')"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-password :name="'password_confirmation'" :id="'password_confirmation'" :placeholder="__('Confirmer le mot de passe*')"/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                    <div class="items-center justify-end mt-6">
                        <button class="w-full items-center py-2 mb-4 bg-red-600 rounded text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __("Réinitialiser le mot de passe") }}
                        </button>

                        <p class="text-center">
                            <a class="text-cyan-700 font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="/">
                                {{ __('Retour à Carter Cash') }}
                            </a>
                        </p>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>
