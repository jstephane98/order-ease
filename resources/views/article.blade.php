<x-app-layout>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h1 class="font-bold text-blue-800 text-3xl">{{ $article->ART_LIB }}</h1>

            <div class="flex">
                <div class="flex">
                    <div class="cursor-pointer">
                        <div class="p-3 rounded border-[1px] border-gray-400">
                            <img class="w-[100px] h-[100px]" src="{{ $article->ART_IMAGE }}" alt="">
                        </div>
                    </div>

                    <div class="">
                        <div class="p-10 border-[1px] border-gray-400 rounded ml-4">
                            <img class="" src="{{ $article->ART_IMAGE }}" alt="">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col ml-10">
                    <div class="">
                        <div class="text-2xl font-bold bg-yellow-200 mb-4 p-3 text-center text-red-600 rounded-s">{{ $article->ART_P_EURO }}€</div>
                        <div class="">
                            <label>
                                <select class="rounded art-panier-quantity" id="select-quantity">
                                    @foreach(range(1, 10) as $value)
                                        <option value="{{ $value }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <button id="add-cart" class="text-white bg-red-600 p-2 rounded-md font-bold hover:bg-red-700 btn-cart ml-3">
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col mt-4">
                        <span class="text-green-500 font-bold text-sm flex items-center">
                            <i class='bx bx-check text-white bg-green-400 rounded-full mr-1'></i>
                            <span>Sur commande - en retrait magasin</span>
                        </span>
                        <span class="text-xm">Retrait sous 1h dans votre</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('js')
        <script>
            const img = "data:image/jpeg;base64,{{ base64_encode($article->ART_IMAGE) }}";
            const libele = "{{ $article->ART_LIB }}";
            const amount = "{{ $article->ART_P_EURO }}";
            const id = "add-cart"
            const code = "{{ $article->ART_CODE }}"
            const selected = document.getElementById('select-quantity')

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
                        "user_id": "{{ Auth::user()->id }}",
                        "QUANTITY": selected.value,
                        "INCREMENT": 0
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
