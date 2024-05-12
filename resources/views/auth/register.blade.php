<x-guest-layout>
    <div class="text-center">
        <h1 class="text-4xl mb-2 mt-2">{{ __("Inscription") }}</h1>
        <p class="">{{ __("Inscrivez-vous et prenons la route ensemble. On se retrouve sur Carter-Cash") }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Adresse e-mail*"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-password :name="'password'" :id="'password'" :placeholder="__('Mot de passe*')"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 w-full">
            <button class="w-full items-center py-2 mb-4 bg-red-600 rounded text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __("S'inscrire") }}
            </button>

            <div class="">
                <span>{{ __("Vous avez déjà un compte ?") }}</span>
                <a class="text-cyan-700 font-bold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Connexion') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
