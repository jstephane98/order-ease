@props(['orders', 'commercial'])

<table class="items-center w-full bg-transparent border-collapse">
    <thead class="text-center">
    <th class="px-4 bg-gray-50 text-gray-700  py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">#</th>
    <th class="px-4 bg-gray-50 text-gray-700  py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
        ID
    </th>
    @if(! $commercial)
        <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap">
            Utilisateur
        </th>
    @endif
    <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Nombre d'article
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Prix
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Status
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Partenaire
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Date de création
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 text-center py-3 text-xs font-semibold  uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Actions
    </th>
    </thead>
    <tbody class="divide-y divide-gray-100 text-center">
    @foreach($orders->items() as $order)
        <tr class="text-gray-500">
            <th class="border-t-0 px-4  text-sm font-normal whitespace-nowrap p-4 ">
                <input type="checkbox" class="rounded">
            </th>
            <td class="text-center border-t-0 px-4  text-xs font-medium text-gray-900 whitespace-nowrap p-4">
                {{ $order->id }}
            </td>
            @if(! $commercial)
                <td class="border-t-0 px-4  text-xs whitespace-nowrap p-4">
                    <a href="mailto:{{ $order->user->email }}" class="hover:no-underline">{{ $order->user->email }}</a>
                    <br>
                    <span class="text-gray-500 mt-2">{{ $order->user->type }}</span>
                </td>
            @endif
            <td class="border-t-0 px-4  text-xs whitespace-nowrap p-4">
                {{ $order->NBR_ART }}
            </td>
            <td class="border-t-0 px-4  text-xs whitespace-nowrap p-4">
                {{ $order->price }}€
            </td>
            <td class="border-t-0 px-4  text-xs whitespace-nowrap p-4">
                <span class="p-1 rounded font-bold {{ $order->status == App\Models\Order::STATUS['CREATED'] ? 'bg-blue-100 text-blue-500' : ($order->status == App\Models\Order::STATUS['INPROGRESS'] ? 'bg-orange-100 text-orange-500' : ($order->status == App\Models\Order::STATUS['CANCELED'] ? 'bg-red-100 text-red-500' : ($order->status == App\Models\Order::STATUS['UPDATED'] ? 'bg-fuchsia-100 text-fuchsia-500' : ($order->status === App\Models\Order::STATUS['CART'] ? 'bg-gray-100 text-gray-500' : 'bg-green-100 text-green-500')))) }}">{{ $order->status }}</span>
            </td>
            <td class="border-t-0 px-4  flex flex-col whitespace-nowrap p-4">
                <span>{{ $order->tier->PCF_RS }}</span>
                <span class="italic text-xs font-bold">#{{ $order->tier->PCF_CODE }}</span>
            </td>
            <td class="border-t-0 px-4  text-xs whitespace-nowrap p-4">
                {{ $order->created_at->diffForHumans() }}
            </td>
            <td class="border-t-0 px-4  text-xs whitespace-nowrap p-4">
                <div class="flex">
                    <button class="p-2 rounded bg-blue-500 border text-white font-bold hover:border hover:text-blue-500 hover:bg-white hover:border-blue-500 transition ease-in show-detail" id="btn-show-{{ $order->id }}"
                            data-order-id="{{ $order->id }}">
                        Details
                    </button>

                    @if(Auth::user()->type == 'ADMIN' && $order->status == App\Models\Order::STATUS['INPROGRESS'])
                        <button class="p-2 ml-5 rounded text-green-500 border border-green-500 font-bold hover:text-white hover:bg-green-500 transition ease-in valid-order" id="btn-validate-{{ $order->id }}"
                                data-order-id="{{ $order->id }}">
                            Valider
                        </button>
                    @endif

                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="mt-10">
    {{ $orders->links() }}
</div>

@section($commercial ? "js" : "admin:js")
    <script>

        // See detail for order
        let btnDetail = document.querySelectorAll(".show-detail");

        btnDetail.forEach((btn) => {
            const id = btn.getAttribute('id');
            const panier = btn.getAttribute('data-order-panier');

            UIkit.util.on('#' + id, 'click', async (e) => {
                e.preventDefault();
                e.target.blur();

                let orderId = btn.getAttribute('data-order-id');

                const response = await fetch('/orders/' + orderId, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                });

                response.json().then(data => {
                    let articles = "";

                    data.panier.forEach((panier) => {
                        articles += `<div class="flex justify-between p-2 items-center">
                                        <div class=" flex items-center">
                                            <img src="` + panier.article.ART_IMAGE + `" alt="" class="w-[50px] h-[50px] text-center">
                                            <span class="font-bold ml-3">` + panier.article.ART_LIB + ` (x` + panier.QUANTITY +`)</span>
                                        </div>
                                        <span class="text-green-600 font-bold">` + panier.article.ART_P_EURO * panier.QUANTITY + `€</span>

                               </div> <hr class="mt-0 mb-0">`
                    })

                    // Open Modal
                    UIkit.modal.dialog(`
                        <div class="pt-5">
                            <h1 class="text-center text-2xl font-bold"><i class='bx bx-check text-white bg-green-400 rounded-full'></i> Liste des articles</h1>
                            <hr>
                               <div class="p-5">`+ articles +`</div>

                        </div>
                    `);
                })
            });
        })

        // Validate order
        let btnValidate = document.querySelectorAll(".valid-order");

        btnValidate.forEach((btn) => {
            const id = btn.getAttribute('id');
            const orderId = btn.getAttribute('data-order-id');

            UIkit.util.on('#' + id, 'click', async (e) => {
                e.preventDefault();
                e.target.blur();

                UIkit.modal.dialog(`
                    <div class="p-5 text-center">
                        <p class="flex justify-center text-xl text-green-600 p-5 text-center items-center">
                            <i class='bx bx-package text-2xl'></i>
                            <span>Voulez-vous valider cette commande ?</span>
                        </p>
                        <div class="uk-text-center flex justify-center">
                            <button class="p-2 text-red-700 bg-red-200 uk-modal-close rounded mr-5" type="button">Annuler</button>
                            <form action="{{ route('valid-order') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="`+ orderId +`">
                                <button type="submit" class="py-2 px-5 text-green-700 bg-green-200 rounded">Valider</button>
                            </form>
                        </div>
                    </div>
                `);
            });
        })
    </script>
@endsection
