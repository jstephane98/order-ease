<aside id="sidebar" class="fixed z-20 h-full top-0 left-0 pt-16 flex lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75" aria-label="Sidebar">
    <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 bg-white divide-y space-y-1">
                <ul class="space-y-2 pb-2">
                    @if(Auth::user()->type === "ADMIN")
                        <li>
                            <a href="{{ route('admin:user.index') }}" class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group hover:no-underline">
                                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3 flex-1 whitespace-nowrap">Utilisateurs</span>
                            </a>
                        </li>
                    @endif
                    <li>
                        <a href="{{ route("admin:order.index") }}" class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group hover:no-underline">
                            <i class='bx bx-package text-2xl text-gray-500 group-hover:text-gray-900'></i>
                            <span class="ml-3">Commandes</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
