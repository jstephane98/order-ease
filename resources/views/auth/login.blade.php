<x-guest-layout>
    <div class="text-center mb-5">
        <h1 class="text-4xl mb-2 mt-2">{{ __("Connexion") }}</h1>
        <p class="">{{ __("Connectez-vous et prenons la route ensemble. On se retrouve sur Carter-Cash") }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="Adresse e-mail*"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-password :name="'password'" :id="'password'" :placeholder="__('Mot de passe*')"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <p class="mt-4 mb-4 text-cyan-700 font-bold text-left">
            <a href="{{ route("password.request") }}">{{ __("J'ai oublié mon mot de passe") }}</a>
        </p>

        <div class="mt-4 w-full">
            <button class="w-full items-center py-2 mb-4 bg-red-600 rounded text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __("Se connecter") }}
            </button>

            <div class="">
                <span>{{ __("Vous n'avez pas de compte ?") }}</span>
                <a class="text-cyan-700 font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                    {{ __('Inscription') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
