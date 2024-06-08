<x-app-admin>
    <div id="main-content" class="h-full w-full relative overflow-y-auto lg:ml-64">
        <main>
            <div class="pt-6 px-4">
                <div class="w-full mb-5">
                    <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                        <h3 class="text-xl text-center leading-none font-bold text-gray-900 mb-10">Liste de commandes</h3>
                        <div class="block w-full overflow-x-auto">
                            @if(session('success'))
                                <p class="text-center text-green-500 font-bold flex items-center">
                                    <i class="bx bx-check text-xl"></i>
                                    <span>{{ session("success") }}</span>
                                </p>
                            @endif

                            <x-order-list :orders="$orders" :commercial="false"/>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-admin>
