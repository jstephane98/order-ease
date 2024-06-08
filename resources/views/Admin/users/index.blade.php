<x-app-admin>
    <div id="main-content" class="h-full w-full relative overflow-y-auto lg:ml-64">
        <main>
            <div class="pt-6 px-4">
                <div class="w-full mb-5">
                    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                        <h3 class="text-xl text-left leading-none font-bold text-gray-900 mb-10">Liste des utilisateurs</h3>
                        <div class="block w-full overflow-x-auto p-5" id="div-table">
                            <div class="text-right mb-5">
                                <a id="create-user" class="p-2 rounded text-green-700 bg-green-200 hover:no-underline hover:text-green-700">Créer un utilisateur</a>
                                <a href="#deactivate-user-modal" uk-toggle class="p-2 rounded text-red-700 bg-red-200 hover:no-underline hover:text-red-700 ml-3">
                                    Désactiver
                                </a>
                                <a href="#activate-user-modal" uk-toggle class="p-2 rounded text-blue-700 bg-blue-200 hover:no-underline hover:text-blue-700 ml-3">
                                    Activer
                                </a>
                            </div>
                            <table class="items-center w-full bg-transparent border-collapse">
                                <thead class="text-center">
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
                                        <input type="checkbox" class="rounded" id="user_checked">
                                    </th>
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
                                        Status
                                    </th>
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                                        Date de création
                                    </th>
                                    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
                                        Actions
                                    </th>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-left font-bold">
                                    <form action="{{ route('activate:user') }}" method="POST" id="activate-form">
                                        @csrf
                                        @method('PATCH')

                                        @foreach($users->items() as $user)
                                            <tr class="text-gray-500">
                                                <th class="border-t-0 px-4 align-middle text-sm font-normal whitespace-nowrap p-4 text-left">
                                                    <input type="checkbox" class="rounded user_check" name="users[]" value="{{ $user->id }}">
                                                </th>
                                                <td class="text-center border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">
                                                    {{ $user->id }}
                                                </td>
                                                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                    <a href="mailto:{{ $user->email }}" class="hover:no-underline">{{ $user->email }}</a>
                                                    <br>
                                                    {{ $user->name }}
                                                </td>
                                                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                    {{ $user->type }}
                                                </td>
                                                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                    <span class="p-1 rounded @if($user->active) bg-green-100 text-green-500 @else bg-red-100 text-red-500 @endif">{{ $user->active ? 'Actif' : "Inactif" }}</span>
                                                </td>
                                                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                    {{ $user->created_at->diffForHumans() }}
                                                </td>
                                                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                                    <div class="">
                                                        <a class="update-user py-2 px-1 bg-blue-50 border border-blue-700 rounded text-blue-700 mr-5 hover:bg-blue-700 hover:text-blue-50 hover:border transition ease-in hover:no-underline"
                                                           data-user-type="{{ $user->type }}"
                                                           data-user-name="{{ $user->name }}"
                                                           data-user-id="{{ $user->id }}"
                                                           data-user-tier="{{ $user->tier?->PCF_CODE }}"
                                                           data-user-email="{{ $user->email }}">
                                                            Modifier
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </form>
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
                    <div class="mt-4" id="tiers"></div>

                    <!-- Nom -->
                    <div class="mt-4">
                        <label for="name">Nom</label>
                        <x-text-input id="name" class="block mt-1 w-full border" type="name" name="name" :value="old('name')" autocomplete="name" placeholder="Nom de l'utilisateur"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 error-p" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email">E-mail <span class="text-red-600">*</span></label>
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autocomplete="email" placeholder="Adresse e-mail*"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 error-p" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password_password">Mot de passe <span class="text-red-600">*</span></label>
                        <x-input-password :name="'password'" :id="'password'" :placeholder="__('Mot de passe*')" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2 error-p" />
                    </div>

                    <div class="uk-modal-footer uk-text-center">
                        <button class="p-2 text-red-700 bg-red-200 uk-modal-close rounded " type="button">Annuler</button>
                        <button type="submit" class="py-2 px-5 text-green-700 bg-green-200 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{--    Modal for deactivate Users --}}
    <div id="deactivate-user-modal" class="rounded" uk-modal>
        <div class="uk-modal-dialog p-5">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-body">
                <p class=" text-xl text-red-600 p-5 text-center item-center">
                    <i class='bx bx-x text-2xl'></i>
                    <span class="">Voulez-vous désactiver ces utilisateurs ?</span>
                </p>
            </div>
            <div class="uk-text-center">
                <button class="py-2 px-5 text-red-700 bg-red-200 rounded deactivate-user" data-action="deactivate">Désactiver</button>
            </div>
        </div>
    </div>

    {{--    Modal for activate Users --}}
    <div id="activate-user-modal" class="rounded" uk-modal>
        <div class="uk-modal-dialog p-5">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-body">
                <p class=" text-xl text-green-600 p-5 text-center item-center">
                    <i class='bx bx-check text-2xl'></i>
                    <span class="">Voulez-vous Activer ces utilisateurs ?</span>
                </p>
            </div>
            <div class="uk-text-center">
                <button class="py-2 px-5 text-green-700 bg-green-200 rounded deactivate-user" data-action="active">Activer</button>
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

            @if(! $errors->isEmpty())
                UIkit.modal("#modal-sections").show();
            @endif

            // select tiers
            let accountType = document.getElementById("type-account");
            let selectTiers = document.getElementById("select-tiers");
            let divTiers = document.getElementById("tiers");

            accountType.addEventListener("change", (e) => {
                if (e.target.value === "PARTENAIRE") {
                    selectedTier()
                }
                else {
                    divTiers.innerText = '';
                }
            })

            // Select Tier
            function selectedTier(tier = null) {
                let options = ''

                @foreach($tiers as $tier)
                    tierCode = "{{ $tier->PCF_CODE }}";
                    selected = tierCode === tier ? 'selected' : '' ;
                    options += '<option value="{{ $tier->PCF_CODE }}" ' + selected + '>{{ $tier->PCF_RS }} - #{{ $tier->PCF_CODE }}</option>'
                @endforeach

                    divTiers.innerHTML = `
                        <label for="select-tiers">Selectionner les tiers <span class="text-red-600">*</span></label>
                        <select name="tier" id="select-tiers" class="w-full rounded p-3 mt-2 border-gray-400">
                            ${options}
                        </select>
                    `
            }

            // Check All
            let user_checked = document.getElementById("user_checked");
            user_checked.addEventListener('change', (e) => {
                let checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = e.target.checked
                })
            })

            // Deactivate / Activer un user
            let activatedButton = document.querySelectorAll(".deactivate-user");
            let deactivateUserModal = document.getElementById("deactivate-user-modal");
            let formDeactivateUser = document.getElementById("activate-form");

            activatedButton.forEach((el) => {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    let action = el.getAttribute('data-action')

                    let input_selected = document.querySelectorAll('input[type="checkbox"]:checked')
                    let error_selected = document.getElementById('error-selected')

                    if(input_selected.length){
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'activate';
                        input.value = action === 'active' ? '1' : 0;
                        formDeactivateUser.appendChild(input);
                        formDeactivateUser.submit();
                    }
                    else {
                        UIkit.modal("#deactivate-user-modal").hide();
                        UIkit.modal("#activate-user-modal").hide();

                        if(! error_selected) {
                            let p = document.createElement('p');
                            let div = document.getElementById('div-table')
                            p.setAttribute('class', 'text-red-500 font-bold')
                            p.setAttribute('id', 'error-selected')
                            p.innerText = 'Veillez selectionner au moins un utilisateur !'
                            div.prepend(p);
                        }
                    }
                })
            })

            // Create User Form
            let createdForm = document.getElementById('create-user');
            createdForm.addEventListener('click', e => {
                e.preventDefault();
                UIkit.modal("#modal-sections").show();

                let modal = document.getElementById("modal-sections");
                let header = modal.querySelector("div > .uk-modal-dialog > .uk-modal-header .uk-modal-title")
                let form = modal.querySelector("div > .uk-modal-dialog > .uk-modal-body form")
                let inputMethod = document.getElementById("updated-user-method");
                let inputEmail = form.querySelector("#email");

                header.innerText = "Créer un utilisateur";
                form.action = "{{ route("store:user") }}";
                form.method = "POST"
                inputMethod.remove();
                inputEmail.removeAttribute('disabled');
                divTiers.innerText = ''

                inputEmail.classList.add('bg-white')

                form.reset();
            })

            // Update User Form
            let updateButtons = document.querySelectorAll(".update-user")
            let errorP = document.querySelectorAll('.error-p')

            updateButtons.forEach(el => {
                el.addEventListener("click", e => {
                    errorP.forEach(el => el.remove())
                    divTiers.innerText = '';
                    UIkit.modal("#modal-sections").show();

                    const userType = el.getAttribute('data-user-type');
                    const userName = el.getAttribute('data-user-name');
                    const userEmail = el.getAttribute('data-user-email');
                    const userTier = el.getAttribute('data-user-tier');
                    const userId = el.getAttribute('data-user-id');
                    let modal = document.getElementById("modal-sections");
                    let header = modal.querySelector("div > .uk-modal-dialog > .uk-modal-header .uk-modal-title")
                    let form = modal.querySelector("div > .uk-modal-dialog > .uk-modal-body form")
                    let inputMethod = document.createElement('input');
                    let inputUser = document.createElement('input');
                    let selectType = form.querySelector("select");
                    let inputName = form.querySelector("#name");
                    let inputEmail = form.querySelector("#email");

                    header.innerText = "Modifier un utilisateur";
                    form.action = "{{ route("update:user") }}";
                    inputMethod.type = 'hidden';
                    inputMethod.name = '_method';
                    inputMethod.value = "PUT";
                    inputMethod.setAttribute('id', 'updated-user-method')
                    form.prepend(inputMethod);

                    inputUser.type = 'hidden';
                    inputUser.name = 'id';
                    inputUser.value = userId;
                    form.prepend(inputUser);

                    selectType.value = userType;
                    if(userType === 'PARTENAIRE') {
                        selectedTier(userTier)
                    }

                    inputName.value = userName;
                    inputEmail.setAttribute("disabled", '')
                    inputEmail.classList.add('bg-gray-200')
                    inputEmail.value = userEmail;
                })
            });

        </script>
    @endsection
</x-app-admin>
