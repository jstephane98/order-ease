<x-app-layout>
    {{--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>--}}

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="filter mb-5 bg-blue-100 border border-blue-500 rounded p-5">
                <h2 class="text-xl font-bold flex items-center">
                    <i class='bx bx-slider'></i>
                    <span>Recherche avancée</span>
                </h2>
                <form id="filter" method="POST" action="{{ route('home') }}">
                    @csrf

                    <div class="flex items-center justify-around">
                        <div class="flex flex-col mr-5 justify-between">
                            <div class="flex flex-col mb-3">
                                <label for="family">Famille</label>
                                <select name="FAR_CODE" id="family" class="rounded">
                                    <option value="">--- Selectionner une Famille ---</option>
                                    @foreach($filtersData['FART_CODE'] as $key => $filterData)
                                        <option value="{{ $key }}" @selected($famille === $key)>{{ $filterData }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <label for="s-family">Sous-Famille</label>
                                <select name="SFA_CODE" id="s-family" class="rounded">
                                    <option value="">--- Selectionner une sous famille ---</option>
                                    @foreach($filtersData['SFA_CODE'] as $key => $filterData)
                                        <option value="{{ $key }}" @selected($s_famille == $key)>{{ $filterData }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between">
                            <div class="flex flex-col mb-3">
                                <label for="t-service">Type de service</label>
                                <select name="ART_CODE" id="t-service" class="rounded">
                                    <option value="">--- Selectionner un type de service ---</option>
                                    @foreach($filtersData['ART_TYPE'] as $key => $filterData)
                                        <option value="{{ $key }}" @selected($type_art == $key)>{{ $filterData }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex flex-col">
                                <label for="category">Catégories</label>
                                <select name="ART_CAT" id="category" class="rounded">
                                    <option value="">--- Selectionner une catégorie ---</option>
                                    @foreach($filtersData['ART_CATEG'] as $key => $filterData)
                                        <option value="{{ $key }}" @selected($cat_art == $key)>{{ $filterData }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-10">
                        <button id="reset-filter" class="bg-red-500 flex items-center mr-10 p-2 font-bold rounded text-white hover:no-underline hover:text-white hover:bg-red-600" type="reset">
                            <i class='bx bx-x text-xl'></i>
                            <span>Annuler le filtre</span>
                        </button>
                        <button class="bg-green-500 p-2 rounded text-white font-bold hover:bg-green-600" type="submit">
                            Appliquer le filtre
                        </button>
                    </div>
                </form>
            </div>

            @foreach($articles as $article)
                <div class="flex justify-between grid-cols-2 bg-white overflow-hidden shadow-sm hover:shadow-xl sm:rounded-sm transition ease-in-out duration-150 mb-4 p-4">
                    <div class="flex m-3">
                        <img src="data:image/jpeg;base64,{{ base64_encode($article->ART_IMAGE) }}" alt="" class="w-[10rem] mr-5">
                        <div class="flex flex-col ">
                            <a class="hover:no-underline" href="{{ route('show-article', $article->ART_CODE) }}">
                                <span class="font-bold text-blue-950">{{ $article->ART_LIB }}</span>
                            </a>
                            <span class="text-sm text-gray-500">CODE: {{ $article->ART_CODE }}</span>
                        </div>
                    </div>

                    <div class="">
                        <div class="p-2 font-bold text-red-600 bg-amber-200 text-[32px] text-center rounded-xl">
                            {{ $article->ART_P_EURO }}€
                        </div>
                        <p class="flex-col mt-4 mb-4">
                        <span class="text-green-500 font-bold text-sm">
                            <i class='bx bx-check text-white bg-green-400 rounded-full'></i>
                            <span>Sur commande - en retrait magasin</span>
                        </span>
                        </p>
                        <button data-article-image="data:image/jpeg;base64,{{ base64_encode($article->ART_IMAGE) }}"
                                data-article-lebele="{{ $article->ART_LIB }}"
                                data-article-amount="{{ $article->ART_P_EURO }}€"
                                id="btn-cart-{{ $article->ART_CODE }}"
                                data-article-code="{{ $article->ART_CODE }}"
                                class="text-white w-full bg-red-600 p-2 rounded-md font-bold hover:bg-red-700 btn-cart">
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-center items-center mt-10">
                <button @disabled(is_null($articles->previousPageUrl())) id="preview-button"
                        class="@if(is_null($articles->previousPageUrl())) bg-red-50 text-red-200 hover:text-red-200 @else bg-red-200 text-red-600 hover:text-red-600 @endif mr-2 rounded"
                >
                    <i class='bx bx-chevron-left text-4xl'></i>
                </button>
                <select name="" id="selected-page" class="rounded ">
                    @foreach(range(1, $articles->lastPage()) as $page)
                        <option value="{{ $page }}" @if($page === $articles->currentPage()) selected @endif>{{ $page }} sur {{ $articles->lastPage() }}</option>
                    @endforeach
                </select>
                <button @disabled(is_null($articles->nextPageUrl())) id="next-button"
                        class="@if(is_null($articles->nextPageUrl())) bg-red-50 text-red-200 hover:text-red-200 @else bg-red-200 text-red-600 hover:text-red-600 @endif ml-2 rounded">
                    <i class='bx bx-chevron-right text-4xl'></i>
                </button>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            const addBtnCart = document.querySelectorAll('.btn-cart');

            addBtnCart.forEach((el, index) => {
                const img = el.getAttribute('data-article-image');
                const libele = el.getAttribute('data-article-lebele');
                const amount = el.getAttribute('data-article-amount');
                const id = el.getAttribute('id')
                const code = el.getAttribute('data-article-code')

                UIkit.util.on('#' + id, 'click', (e) => {
                    e.preventDefault();
                    e.target.blur();

                    @guest
                        // Open Modal
                        UIkit.modal.dialog(`
                            <div class="pt-3">
                                <h1 class="text-center text-2xl font-bold"><i class='bx bx-x text-white bg-red-400 rounded-full'></i> Ajout au panier </h1>
                                <hr>
                                <div class="flex justify-between p-2 items-center">
                                    <img src="` + img + `" alt="" class="w-[80px] h-[80px] text-center">
                                    <span class="font-bold">` + libele + `</span>
                                    <span class="text-red-600 font-bold">` + amount + `</span>
                                </div>
                                <div class="text-center pb-3">Connecter vous pour continuer <a href="{{ route('login') }}" class="font-bold">Se connecter</a></div>
                            </div>
                        `);
                    @else
                        // Send data to cart
                        sendRequest('/api/add-cart', {
                            "ART_CODE": code,
                            "user_id": "{{ Auth::user()->id }}",
                            "QUANTITY": 1,
                            "INCREMENT": 1
                        }, "POST").then((data) => {
                            console.log(data);
                        });

                        // Open Modal
                        UIkit.modal.dialog(`
                            <div class="pt-3">
                                <h1 class="text-center text-2xl font-bold"><i class='bx bx-check text-white bg-green-400 rounded-full'></i> Ajouté au panier</h1>
                                <hr>
                                <div class="flex justify-between p-2 items-center">
                                    <img src="` + img + `" alt="" class="w-[80px] h-[80px] text-center">
                                    <span class="font-bold">` + libele + `</span>
                                    <span class="text-red-600 font-bold">` + amount + `</span>
                                </div>
                                <div class="text-center pb-3"><a href="{{ route('panier') }}"" class="rounded text-white font-semibold bg-red-500 hover:bg-red-600 p-2 hover:text-white">Voir le panier</a></div>
                            </div>
                        `);
                    @endguest
                });
            });

            async function sendRequest(url = "", data = {}, method = "") {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data),
                });
                return response.json();
            }

            // Get Data for filter
            family = document.getElementById("family")
            s_family = document.getElementById("s-family")
            t_service = document.getElementById("t-service")
            category = document.getElementById("category")
            form_filter = document.getElementById("filter")
            nextPage = document.getElementById("next-button")
            previewPage = document.getElementById("preview-button")

            // Change page selected
            const selectedPage = document.getElementById("selected-page")
            selectedPage.addEventListener('change', (e) => {
                submitFilterFormForPagination(e.target.value)
            })

            if ("{{ $articles->nextPageUrl() }}") {
                nextPage.addEventListener('click', (e) => {
                    console.log({{ $current_page + 1 }})
                    submitFilterFormForPagination({{ $current_page + 1 }})
                })
            }

            if ("{{ $articles->previousPageUrl() }}") {
                previewPage.addEventListener('click', (e) => {
                    submitFilterFormForPagination({{ $current_page - 1 }})
                })
            }

            // Reset filter
            let resetFilter = document.getElementById("reset-filter")
            resetFilter.addEventListener('click', (e) => {
                window.location = "{{ route('home') }}"
            })

            function submitFilterFormForPagination(page) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'page';
                input.value = page;
                form_filter.appendChild(input);
                form_filter.submit();
            }

        </script>
    @endsection
</x-app-layout>
