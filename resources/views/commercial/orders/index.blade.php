<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 bg-white p-5 rounded shadow shadow-2xl">
            <x-order-list :orders="$orders" :commercial="true"/>
        </div>
    </div>
</x-app-layout>
