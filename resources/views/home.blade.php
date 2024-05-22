<x-app-layout>
    {{--<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>--}}

    <h1 class="text-center text-5xl font-bold mt-4">Articles disponible</h1>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @foreach($articles as $article)
                <div class="grid justify-between grid-cols-2 bg-white overflow-hidden shadow-sm hover:shadow-xl sm:rounded-sm transition ease-in-out duration-150 mb-4 p-4">
                    <div class="flex m-3">
                        <img src="data:image/jpeg;base64,{{ base64_encode($article->ART_IMAGE) }}" alt="" class="w-[60%] h-[60%] mr-5">
                        <div class="">
                            <p class="font-bold text-blue-950">{{ $article->ART_LIB }}</p>
                            <p class="text-sm text-gray-500">CODE: {{ $article->ART_CODE }}</p>
                        </div>
                    </div>

                    <div class="">
                        <div class="p-2 font-bold text-red-600 bg-amber-200 text-[32px] w-[60%] text-center rounded-xl">
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
                                class="text-white bg-red-600 p-2 rounded-md font-bold hover:bg-red-700 btn-cart">
                            Ajouter au panier
                        </button>
                    </div>
                </div>
            @endforeach

            <div class="">
                {{ $articles->links() }}
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
                        addCart('/api/add-cart', {
                            "ART_CODE": code,
                            "USR_NAME": "{{ Auth::user()->USR_NAME }}",
                            "QUANTITY": 1,
                            "INCREMENT": 1
                        }).then((data) => {
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

            async function addCart(url = "", data = {}) {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data),
                });
                return response.json();
            }
        </script>
    @endsection
</x-app-layout>
