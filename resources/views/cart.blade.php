<x-app-layout>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <ol class="flex items-center text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">

                <li class="flex md:w-full items-center text-blue-600 sm:after:content-['']
                            after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1
                            after:hidden sm:after:inline-block after:mx-6
                            xl:after:mx-10
                            @if($step) dark:after:border-blue-700 @else dark:after:border-gray-700 @endif"
                >

                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        <i class='bx bx-cart-alt text-xl mr-1.5' ></i>
                        Panier
                    </span>
                </li>

                <li class="flex md:w-full items-center @if($step === 'livraison' || $step === 'confirmation' || $step === 'completed') text-blue-600 @else text-gray-600 @endif sm:after:content-['']
                            after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1
                            after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10
                            @if($step === 'confirmation' || $step === 'completed') dark:after:border-blue-700 @else dark:after:border-gray-700 @endif"
                >
                    <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                        <i class='bx bx-package text-xl rounded-full mr-1.5'></i>
                        Livraison
                    </span>
                </li>

                <li class="flex md:w-full items-center @if($step === 'confirmation' || $step === 'completed') text-blue-600 @else text-gray-600 @endif
                            sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1
                            after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10
                            @if($step === 'completed') dark:after:border-blue-700 @else dark:after:border-gray-700 @endif"
                >
                    <i class='bx bx-loader-alt text-xl @if($step === 'confirmation' || $step === 'completed') animate-spin @endif rounded-full mr-1.5'></i>
                    Confirmation
                </li>

                <li class="flex items-center @if($step === 'completed') text-blue-600 @else text-gray-600 @endif">
                    <i class='bx bx-check text-xl rounded-full mr-1.5'></i>
                    Effectué
                </li>
            </ol>

            @switch($step)
                @case("completed")
                    <div class="flex flex-col bg-white p-10 justify-center mb-5 items-center align-middle">
                        <div class="text-5xl">
                            <i class='bx bx-package text-green-500'></i>
                        </div>
                        <p class="font-bold text-xl">Votre commande a été pris en compte.</p>

                        <div>
                            <a href="{{ route('home') }}" class="font-bold items-center flex hover:no-underline text-red-800 p-3 bg-red-200 rounded hover:text-red-800">
                                Continuer mes achats
                            </a>
                        </div>
                    </div>
                    @break

                @default
                    <div class="flex">
                        <div class="w-[70%] mr-7 ">
                                <h1 class="text-left font-bold text-blue-950 text-3xl">
                                    @if(is_null($step))
                                        Panier
                                    @elseif($step === "livraison")
                                        Livraison
                                    @elseif($step === 'confirmation')
                                        Confirmation
                                    @else

                                    @endif
                                </h1>

                                @if(is_null($step))
                                    @forelse($paniers as $panier)
                                        <div class="bg-white p-4 rounded shadow-m mb-4 flex justify-between">
                                            <div class="flex">
                                                <img src="{{ $panier->article->ART_IMAGE }}" alt="" class="w-[120px] h-[120px]">

                                                <div class="flex flex-col ml-3 mr-3">
                                                    <span class="font-bold text-blue-950 text-sm">{{ $panier->article->ART_LIB }}</span>
                                                    <span class="text-xs font-bold">{{ $panier->article->ART_CODE }}</span>
                                                    <span class="mt-10 text-green-500 font-bold text-xs">
                                                        <i class='bx bx-check text-white bg-green-400 rounded-full'></i>
                                                        Disponible - en magasin
                                                    </span>
                                                </div>
                                            </div>

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
                                        </div>
                                    @empty
                                        <div class="flex flex-col bg-white  p-10 justify-center mb-5 items-center align-middle">
                                            <img src="{{ asset('assets/cashy-empty-cart.png') }}" alt="">
                                            <p class="font-bold text-xl">Votre panier est vide.</p>
                                        </div>
                                    @endforelse
                                @elseif($step === "livraison")
                                    <div class="bg-white p-4 rounded shadow-m">
                                        <h2 class="text-left text-2xl">Choisir le partenaire Tier </h2>

                                        <select name="" id="partner" class="rounded">
                                            @foreach($tiers as $partner)
                                                <option value="{{ $partner->PCF_CODE }}" @selected($tier ? $partner->PCF_CODE === $tier->PCF_CODE : "")>
                                                    {{ $partner->PCF_RS }} ({{ $partner->PAY_CODE }} - {{ $partner->PCF_VILLE }})
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="text-center mt-10 mb-5">
                                            <a href="{{ route('panier', ['update' => 1]) }}" class="p-2 bg-yellow-50 text-yellow-700 border border-yellow-700 rounded
                                                hover:no-underline hover:bg-yellow-600 hover:text-yellow-50 transition duration-150 ease-in-out">
                                                Modifier le panier
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-white rounded flex">
                                        <div class="w-[65%] mr-2 p-2">
                                            @foreach($paniers as $panier)
                                                <div class="flex items-center mt-5">
                                                    <img src="{{ $panier->article->ART_IMAGE }}" alt="" class="w-[120px] h-[120px]">

                                                    <div class="flex flex-col ml-3 mr-3 p-2 rounded bg-blue-50 border-blue-400 border">
                                                        <span class="font-bold text-blue-950 text-sm">{{ $panier->article->ART_LIB }}</span>
                                                        <span class="text-xs font-bold">{{ $panier->article->ART_CODE }}</span>
                                                        <span class="text-xs font-bold">Quantité: {{ $panier->QUANTITY }}</span>
                                                        <span class="text-green-500 font-bold text-xs">
                                                            <i class='bx bx-check text-white bg-green-400 rounded-full'></i>
                                                            Disponible - en magasin
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="p-2 items-center mt-5">
                                            <h4 class="text-xl text-center uppercase font-bold mb-4 items-center">
                                                <i class='bx bx-store text-2xl'></i>
                                                <span>Magasin choisit</span>
                                            </h4>

                                            <div class="flex flex-col bg-green-50 border-green-400 border p-4 text-gray-900">
                                                <span class="font-bold text-xl">
                                                    {{ $tier->PCF_RS }}
                                                </span>
                                                <span class="text-sm">
                                                    {{ $tier->C01 }}
                                                </span>
                                                <span>
                                                    {{ $tier->pays->PAY_NOM }}
                                                </span>
                                                <span>{{ $tier->PCF_VILLE }}</span>
                                                <span>{{ $tier->PCF_RUE }}</span>

                                                <a href="{{ route("panier", ["step" => "livraison"]) }}"
                                                   class="mt-5 p-2 bg-yellow-100 border border-yellow-900 text-sm rounded text-yellow-700 font-bold
                                                          hover:no-underline hover:bg-yellow-700 hover:text-yellow-50 hover:border-opacity-0 transition ease-in">
                                                    Modifier le magasin choisit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

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
                                        @if($step === "confirmation")
                                            <a href="{{ route('order.cancel') }}" class="p-2 rounded text-white bg-red-600 ml-2 font-bold hover:no-underline hover:text-white">Annuler la commande</a>
                                        @endif

                                        <a href="{{ route('panier', $step === null ? 'livraison' : ($step === 'livraison' ? 'confirmation' : 'completed')) }}" id="btn-action"
                                           class="text-white bg-green-600 p-2 rounded-md font-bold hover:bg-green-700 btn-cart
                                                mt-5 w-full hover:no-underline hover:text-white"
                                        >
                                            @if(is_null($step))Valider mon panier @elseif($step == 'livraison')Valider ma livraison @else Confirmer @endif
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-white mt-4 p-4 rounded text-center hidden">
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
                    <div>
                        <a href="{{ route('home') }}" class="font-bold items-center flex hover:no-underline text-blue-800">
                            <i class='bx bx-chevron-left'></i>
                            <span class="underline">Continuer mes achats</span>
                        </a>
                    </div>
            @endswitch
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
                        "user_id": "{{ Auth::user()?->id }}",
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
                        'user_id': "{{ Auth::user()->id }}"
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

            // Choisir la partenaire
            @if($step === "livraison")
                let btnCart = document.getElementById('btn-action');
                let chosePartner = document.getElementById('partner');

                btnCart.href += "?partner=" + chosePartner.value

                chosePartner.addEventListener('change', (e) => {
                    const regex = new RegExp('=' + '.*$');

                    btnCart.href = btnCart.href.replace(regex, "=" + chosePartner.value)
                })

            @endif
        </script>
    @endsection

</x-app-layout>
