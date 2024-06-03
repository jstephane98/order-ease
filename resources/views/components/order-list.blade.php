@props(['orders', 'commercial'])

<table class="items-center w-full bg-transparent border-collapse">
    <thead class="text-center">
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">#</th>
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
        ID
    </th>
    @if(! $commercial)
        <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">
            Utilisateur
        </th>
    @endif
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Nombre d'article
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Prix
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Status
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Partenaire
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Date de création
    </th>
    <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">
        Actions
    </th>
    </thead>
    <tbody class="divide-y divide-gray-100 text-center">
    @foreach($orders->items() as $order)
        <tr class="text-gray-500">
            <th class="border-t-0 px-4 align-middle text-sm font-normal whitespace-nowrap p-4 text-left">
                <input type="checkbox" class="rounded">
            </th>
            <td class="text-center border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">
                {{ $order->id }}
            </td>
            @if(! $commercial)
                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                    <a href="mailto:{{ $order->user->email }}" class="hover:no-underline">{{ $order->user->email }}</a>
                </td>
            @endif
            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                {{ $order->NBR_ART }}
            </td>
            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                {{ $order->price }}€
            </td>
            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                {{ $order->status }}
            </td>
            <td class="border-t-0 px-4 align-middle flex flex-col whitespace-nowrap p-4">
                <span>{{ $order->tier->PCF_RS }}</span>
                <span class="italic text-xs font-bold">#{{ $order->tier->PCF_CODE }}</span>
            </td>
            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                {{ $order->created_at->diffForHumans() }}
            </td>
            <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                <div class="flex">
                    <button class="p-2 rounded bg-blue-500 text-white show-detail" id="btn-{{ $order->id }}"
                            data-order-id="{{ $order->id }}">
                        Details
                    </button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $orders->links() }}

@section($commercial ? "js" : "admin:js")
    <script>
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
                                        <div class="text-left flex items-center">
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
    </script>
@endsection