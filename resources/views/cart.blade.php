<x-app-layout>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <ol class="flex items-center text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
                <li class="flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        <i class='bx bx-circle text-white bg-blue-600 rounded-full mr-1.5'></i>
                        Panier
                    </span>
                </li>
                <li class="flex md:w-full items-center @if($step == 'livraison' || $step == 'confirmation') text-blue-600 @endif after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        @if($step == 'livraison' || $step == 'confirmation')
                            <i class='bx bx-circle text-white bg-blue-600 rounded-full mr-1.5'></i>
                        @else
                            <span class="me-2">2</span>
                        @endif
                        Livraison
                    </span>
                </li>
                <li class="flex items-center  @if($step == 'confirmation') text-blue-600 @endif">
                    @if($step == 'confirmation')
                        <i class='bx bx-circle text-white bg-blue-600 rounded-full mr-1.5'></i>
                    @else
                        <span class="me-2">3</span>
                    @endif
                    Confirmation
                </li>
            </ol>

            <div class="flex">
                <div class="w-[70%] mr-7">
                    <h1 class="text-left font-bold text-blue-950 text-3xl">
                        @if(is_null($step))
                            Panier
                        @elseif($step === "livraison")
                            Livraison
                        @else
                            Confirmation
                        @endif
                    </h1>
                    @forelse($paniers as $panier)
                        <div class="bg-white p-4 rounded shadow-m mb-4 flex justify-between">
                            <div class="flex">
                                <img src="data:image/jpeg;base64,{{ base64_encode($panier->article->ART_IMAGE) }}" alt="" class="w-[120px] h-[120px]">

                                <div class="flex flex-col ml-3 mr-3">
                                    <span class="font-bold text-blue-950 text-sm">{{ $panier->article->ART_LIB }}</span>
                                    <span class="text-xs font-bold">{{ $panier->article->ART_CODE }}</span>
                                    @if(is_null($step))
                                        <span class="mt-10 text-green-500 font-bold text-xs"><i class='bx bx-check text-white bg-green-400 rounded-full'></i> Disponible - en magasin</span>
                                    @else
                                        <div class="p-2 m-2 border bg-blue-50 border-blue-200 rounded-sm flex items-center">
                                            <i class='bx bx-circle bg-blue-500 text-white rounded-full'></i>
                                            <div class="flex flex-col ml-3">
                                                <span class="text-blue-800 font-bold">Retrait en Magasin</span>
                                                <span class="items-center text-green-500 font-bold text-xs"><i class='bx bx-check text-white bg-green-400 rounded-full'></i> Disponible</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if(is_null($step))
                                <div class="flex">
                                    <div class="flex flex-col text-center">
                                        <span class="text-xl font-bold text-red-600 mb-4"
                                              data-unit-price="{{ $panier->article->ART_P_EURO }}"
                                              data-art-code="{{ $panier->article->ART_CODE }}"
                                        >
                                            {{ number_format($panier->article->ART_P_EURO * $panier->QUANTITY, decimals: 2, thousands_separator: ' ') }}€
                                        </span>

                                        <label>
                                            <select class="rounded art-panier-quantity">
                                                @foreach(range(1, 10) as $value)
                                                    <option value="{{ $value }}" @if($value == $panier->QUANTITY) selected @endif>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>

                                    <button class="ml-6 delete-art-panier" data-art-code="{{ $panier->article->ART_CODE }}">
                                        <i class='bx bx-x text-white bg-red-400 rounded-full'></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="flex flex-col bg-white p-10 justify-center mb-5 items-center align-middle">
                            <img src="{{ asset('assets/cashy-empty-cart.png') }}" alt="">
                            <p class="font-bold text-xl">Votre panier est vide.</p>
                        </div>
                    @endforelse

                    <div>
                        <a href="{{ route('home') }}" class="font-bold items-center flex hover:no-underline text-blue-800">
                            <i class='bx bx-chevron-left'></i>
                            <span class="underline">Continuer mes achats</span>
                        </a>
                    </div>
                </div>

                <div class="w-[30%] rounded ml-3">
                    <h1 class="text-left font-bold text-blue-950 text-3xl">Récapitulatif</h1>

                    <div class="bg-white p-4 rounded">
                        <h2 class="font-bold text-left text-lg text-blue-950">Total de votre panier</h2>
                        <p class="font-bold text-right text-lg text-blue-950 total-panier">{{ number_format($totalPanier, decimals: 2, thousands_separator: ' ') }}€</p>

                        <hr class="mb-0">

                        <p class="flex justify-between mt-0 text-sm font-bold">
                            <span class="nbr-article">{{ $quantity }} article(s)</span>
                            <span class="total-panier">{{ number_format($totalPanier, decimals: 2, thousands_separator: ' ') }}€</span>
                        </p>
                        <p class="mb-0 text-xm font-bold">Frais de mise à disposition</p>
                        <hr class="mt-0">
                        <div class="text-center">
                            @if($quantity)
                                <a href="{{ route('panier', $step == null ? 'livraison' : 'confirmation') }}" id="btn-" class="text-white bg-red-600 p-2 rounded-md font-bold hover:bg-red-700 btn-cart mt-5 w-full hover:no-underline hover:text-white">
                                    Valider @if(is_null($step)) mon panier @elseif($step == 'livraison') ma livraison @else @endif
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white mt-4 p-4 rounded text-center">
                        <h3 class="items-center justify-center flex text-xl"><i class='bx bx-credit-card'></i> Paiement sécurisé</h3>
                        <hr>
                        <div class="flex justify-center">
                            <img class="w-[30px] mr-1" src="{{ asset('assets/payments-card/cb.svg') }}" alt="">
                            <img class="w-[30px] mr-1" src="{{ asset('assets/payments-card/maestro.svg') }}" alt="">
                            <img class="w-[30px] mr-1" src="{{ asset('assets/payments-card/mastercard.svg') }}" alt="">
                            <img class="w-[30px]" src="{{ asset('assets/payments-card/visa.svg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('js')
        <script>
            async function sendRequest(url = "", data = {}) {
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

            let artPanierQuantity = document.querySelectorAll('.art-panier-quantity');

            artPanierQuantity.forEach((qte) => {
                qte.addEventListener('change', (e) => {
                    let spanPrice = e.target.parentElement.parentElement.querySelector('span');
                    let unitPrice = spanPrice.getAttribute('data-unit-price');
                    let quantityTarget = e.target.value;
                    let code = spanPrice.getAttribute('data-art-code');
                    let nbrArticle = document.querySelector('.nbr-article');
                    let totalPanier = document.querySelectorAll(".total-panier");

                    sendRequest('/api/add-cart', {
                        "ART_CODE": code,
                        "USR_NAME": "{{ Auth::user()?->USR_NAME }}",
                        "QUANTITY": quantityTarget,
                        "INCREMENT": 0
                    })
                        .then((data) => {
                        console.log(data);
                        nbrArticle.innerText = `${data.quantity} articles`
                        totalPanier.forEach((el) => {
                            el.innerText = `${data.totalPanier}€`
                        })
                    });

                    spanPrice.innerText = `${unitPrice * quantityTarget}€`
                })
            })

            let deleteArtPanier = document.querySelectorAll('.delete-art-panier');

            deleteArtPanier.forEach((el) => {
                let codeArt = el.getAttribute('data-art-code')

                el.addEventListener('click', (e) => {
                    let cardPanier = el.parentNode.parentNode;
                    sendRequest('/api/cart/remove-art', {
                        'ART_CODE': codeArt,
                        'USR_NAME': "{{ Auth::user()->USR_NAME }}"
                    })
                    .then((data) => {
                        let nbrArticle = document.querySelector('.nbr-article');
                        let totalPanier = document.querySelectorAll(".total-panier");

                        nbrArticle.innerText = `${data.quantity} articles`
                        totalPanier.forEach((el) => {
                            el.innerText = `${data.totalPanier}€`
                        })
                    })

                    cardPanier.remove();
                })
            })

        </script>
    @endsection

</x-app-layout>
