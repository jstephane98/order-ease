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
                <h1 class="text-2xl mb-4 font-bold">{{ __("Mot de passe oublié ?") }}</h1>

                {{ __('Saisissez votre adresse e-mail et nous vous enverrons des instructions pour réinitialiser votre mot de passe.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Adresse e-mail*"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="items-center justify-end mt-6">
                    <button class="w-full items-center py-2 mb-4 bg-red-600 rounded text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __("Continuer") }}
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
