<x-app-layout>
    {{--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>--}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6">

            <div class="filter mb-5 bg-blue-100 border border-blue-500 rounded p-3">
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

            <div class="grid grid-cols-2 gap-4">
                @foreach($articles as $article)
                    @include('components.article-card', ['article' => $article, 'sameFamily' => false])
                @endforeach
            </div>

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
