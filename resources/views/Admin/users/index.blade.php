<x-app-admin>
    <div id="main-content" class="h-full w-full relative overflow-y-auto lg:ml-64">
        <main>
            <div class="pt-6 px-4">
                <div class="w-full mb-5">
                    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                        <h3 class="text-xl text-left leading-none font-bold text-gray-900 mb-10">Liste des utilisateurs</h3>
                        <div class="block w-full overflow-x-auto">
                            <div class="text-right mb-5">
                                <a href="#modal-sections" uk-toggle class="p-2 rounded text-green-700 bg-green-200 hover:no-underline hover:text-green-700">Créer un utilisateur</a>
                            </div>
                            <table class="items-center w-full bg-transparent border-collapse">
                                <thead class="text-center">
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">#</th>
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
                                        ID
                                    </th>
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
                                        Utilisateur
                                    </th>
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                                        Type
                                    </th>
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                                        Date de création
                                    </th>
                                    <th class="hidden px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                                        Actions
                                    </th>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-left font-bold">
                                    @foreach($users->items() as $user)
                                        <tr class="text-gray-500">
                                            <th class="border-t-0 px-4 align-middle text-sm font-normal whitespace-nowrap p-4 text-left">
                                                <input type="checkbox" class="rounded">
                                            </th>
                                            <td class="text-center border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">
                                                {{ $user->id }}
                                            </td>
                                            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                <a href="mailto:{{ $user->email }}" class="hover:no-underline">{{ $user->email }}</a>
                                            </td>
                                            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                {{ $user->type }}
                                            </td>
                                            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                {{ $user->created_at->diffForHumans() }}
                                            </td>
                                            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4 hidden">
                                                <div class="">
                                                    <a href="update-user-modal-{{ $user->id }}" class="py-2 px-1 bg-blue-50 border border-blue-700 rounded text-blue-700 mr-5 hover:bg-blue-700 hover:text-blue-50 hover:border transition ease-in hover:no-underline">
                                                        Modifier
                                                    </a>
                                                    <a href="{{ $user->id }}" class="py-2 px-1 bg-red-600 border border-red-50 rounded text-red-50 mr-5 hover:bg-red-50 hover:text-red-600 hover:border hover:border-red-700 transition ease-in hover:no-underline">
                                                        Supprimer
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

{{--    Modal for create Users --}}
    <div id="modal-sections" class="rounded" uk-modal>
        <div class="uk-modal-dialog ">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Créer un utilisateur</h2>
            </div>
            <div class="uk-modal-body">
                <form method="POST" action="{{ route('store:user') }}">
                    @csrf

                    <!-- Type account -->
                    <div class="mt-4">
                        <label for="type-account">Type de compte <span class="text-red-600">*</span></label>
                        <select name="type" id="type-account" class="w-full rounded p-3 mt-2 border-gray-400">
                            @foreach(\App\Models\User::TYPE_ACCOUNT as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Liste des tiers -->
                    <div class="mt-4" id="tiers">

                    </div>

                    <!-- Nom -->
                    <div class="mt-4">
                        <label for="name">Nom</label>
                        <x-text-input id="name" class="block mt-1 w-full border" type="name" name="name" :value="old('name')" required autocomplete="name" placeholder="Nom de l'utilisateur"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email">E-mail <span class="text-red-600">*</span></label>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Adresse e-mail*"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password_password">Mot de passe <span class="text-red-600">*</span></label>
                        <x-input-password :name="'password'" :id="'password'" :placeholder="__('Mot de passe*')"/>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="uk-modal-footer uk-text-center">
                        <button class="p-2 text-red-700 bg-red-200 uk-modal-close rounded " type="button">Annuler</button>
                        <button type="submit" class="py-2 px-5 text-green-700 bg-green-200 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--   notification --}}
    @section("admin:js")
        <script>
            @if(session('success'))
                UIkit.modal.dialog(`<p class="text-xl text-green-600 p-5 text-center item-center"> <i class='bx bx-check text-2xl'></i> {{ session('success') }}</p>`);
            @endif

            @if(session('error'))
                UIkit.modal.dialog(`<p class="text-xl text-red-600 p-5 font-bold text-center item-center"> <i class='bx bx-x text-2xl'></i> {{ session('error') }}</p>`);
            @endif

            // select tiers
            let accountType = document.getElementById("type-account");
            let selectTiers = document.getElementById("select-tiers");
            let divTiers = document.getElementById("tiers");

            accountType.addEventListener("change", (e) => {
                if (e.target.value === "PARTENAIRE") {
                    let options = ''

                    @foreach($tiers as $tier)
                       options += '<option value="{{ $tier->PCF_CODE }}">{{ $tier->PCF_RS }}</option>'
                    @endforeach

                    divTiers.innerHTML = `
                        <label for="select-tiers">Selectionner les tiers <span class="text-red-600">*</span></label>
                        <select multiple name="tiers[]" id="select-tiers" class="w-full rounded p-3 mt-2 border-gray-400">
                            ${options}
                        </select>
                    `
                }
                else {
                    divTiers.innerText = '';
                }
            })
        </script>
    @endsection
</x-app-admin>
