<div class="flex bg-white p-3 rounded shadow-2xl justify-between @if($sameFamily) items-center @endif">
    <div class="@if(! $sameFamily) flex @endif">
        <img src="{{ $article->ART_IMAGE }}" alt="" class="w-[8rem] mr-5">
        <div class="flex flex-col ">
            <a class="hover:no-underline" href="{{ route('show-article', $article->ART_CODE) }}">
                <span class="font-bold text-blue-950">{{ $article->ART_LIB }}</span>
            </a>
            <span class="text-sm text-gray-500">CODE: {{ $article->ART_CODE }}</span>
        </div>
    </div>

    <div class="ml-3">
        <div class="font-bold text-red-600 bg-amber-200 text-[32px] text-center rounded-xl px-2">
            {{ number_format($article->ART_P_EURO, 2, ',', ' ') }}€
        </div>
        <p class="flex-col mt-4 mb-4 text-center">
            <span class="font-bold text-sm">
                @if($article->stock?->STK_REEL)
                    <i class='bx bx-check text-white bg-green-400 rounded-full'></i>
                    <span class="text-green-500">Disponible en stock</span>
                @elseif($article->sameFamilyAvailable)
                    <i class='bx bx-check text-white bg-blue-400 rounded-full'></i>
                    <span class="text-blue-500">Produit similaire disponible en stock</span>
                @else
                    <i class='bx bx-x text-white bg-red-400 rounded-full'></i>
                    <span class="text-red-500">En rupture de stock</span>
                @endif
            </span>
        </p>

        @if($article->stock?->STK_REEL)
            <div class="text-center">
                <button data-article-image="{{ $article->ART_IMAGE }}"
                        data-article-lebele="{{ $article->ART_LIB }}"
                        data-article-amount="{{ $article->ART_P_EURO }}€"
                        id="btn-cart-{{ $article->ART_CODE }}"
                        data-article-code="{{ $article->ART_CODE }}"
                        class="text-white bg-red-600 p-2 rounded-md font-bold hover:bg-red-700 btn-cart">
                    Ajouter au panier
                </button>
            </div>
        @endif
    </div>
</div>

@section('article:card.js')
    <script>
        const addBtnCart = document.querySelectorAll('.btn-cart');

        addBtnCart.forEach((el, index) => {
            const img = el.getAttribute('data-article-image');
            const libele = el.getAttribute('data-article-lebele');
            const amount = el.getAttribute('data-article-amount');
            const articleId = el.getAttribute('id')
            const code = el.getAttribute('data-article-code')

            console.log(articleId)

            UIkit.util.on('#' + articleId, 'click', (e) => {
                e.preventDefault();
                e.target.blur();

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
    </script>
@endsection
