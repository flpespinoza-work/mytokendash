
<sidebar :class="{ '-translate-x-64': !sidebarOpen }" id="sidebar" class="absolute top-0 left-0 z-40 flex-shrink-0 inline-block w-64 h-screen py-4 overflow-y-scroll transition-transform duration-200 ease-in-out transform bg-white border-r border-gray-light lg:static lg:left-auto lg:top-auto lg:translate-x-0 lg:overflow-y-auto no-scrollbar">
    <div class="flex justify-between px-4 pr-3 mb-10">
        <button class="text-gray-500 outline-none lg:hidden hover:text-gray-400"
        aria-controls="sidebar" aria-expanded="false" @click="sidebarOpen = !sidebarOpen">
            <span class="sr-only">Close sidebar</span>
            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z"></path>
            </svg>
        </button>
        <a class="block active" href="/">
            <x-logo class="h-10"/>
        </a>
    </div>
    <div>
        @foreach($menuSidebar as $menuGroup)
        <div class="p-4 mt-3">
            <h3 class="pl-3 text-xs font-light text-gray-400 uppercase">{{ $menuGroup['name'] }}</h3>
            @if( count($menuGroup['submenu']) )
                @include('components.submenu', ['menuGroup' => $menuGroup['submenu']])
            @endif
        </div>
        @endforeach

        <div class="p-4 mt-3">
            <h3 class="pl-3 text-xs font-light text-gray-400 uppercase">Principal</h3>
            <ul class="mt-3">
                <li class="px-2 py-2 rounded-md mb-0.5 last:mb-0 {{ request()->is('/') ? 'bg-orange-lightest': '' }}">
                    <a class="block text-gray-600 transition duration-150 hover:text-gray-800" href="/">
                        <div class="flex items-center flex-grow">
                            <x-heroicon-s-view-grid class="flex-shrink-0 w-5 h-5 mr-2 text-orange"/>
                            <span class="text-xs font-medium">Dashboard</span>
                        </div>
                    </a>
                </li>
                <li class="px-2 py-2 rounded-md mb-0.5 last:mb-0">
                    <a class="block text-gray-600 transition duration-150 hover:text-gray-800" href="/">
                        <div class="flex items-center flex-grow">
                            <x-heroicon-s-bell class="flex-shrink-0 w-5 h-5 mr-2 text-orange"/>
                            <span class="text-xs font-medium">Notificaciones</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Principal -->
        <div class="p-4 mt-3" x-data="{ route: '{{ request()->path() }}', selected: null }"
            x-init="route = route.substring(0, route.lastIndexOf('/'));
            switch(route)
            {
                case 'reports/users': selected = 1; break;
                case 'reports/coupons': selected = 2; break;
                case 'reports/sells': selected = 3; break;
                default: selected = null; break;
            }
            ">
            <h3 class="pl-3 text-xs font-light text-gray-400 uppercase">Reportes</h3>
            <ul class="mt-3 text-gray-600">
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="#" @click="selected !== 1 ? selected = 1 : selected = null">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-grow">
                                <x-heroicon-s-users class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                                <span class="text-xs font-medium">Usuarios</span>
                            </div>
                            <div class="flex flex-shrink-0 ml-2">
                                <x-heroicon-s-chevron-down x-show="selected != 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                                <x-heroicon-s-chevron-up x-show="selected == 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                            </div>
                        </div>
                    </a>
                    <div class="overflow-hidden transition-all duration-200" :class="{ 'max-h-0' : selected != 1 }" x-ref="container1" x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                        <ul class="pt-3 pl-8 pr-1">
                            <li class="flex items-center mb-2">
                                <a class="block transition duration-150 hover:text-gray-darker false active" href="">
                                    <span class="text-xs font-medium">Nuevos usuarios</span>
                                </a>
                                @if (request()->routeIs('reports.new-users'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                            <li class="flex items-center">
                                <a class="block transition duration-150 hover:text-gray-darker" href="">
                                    <span class="text-xs font-medium">Acumulado</span>
                                </a>
                                @if (request()->routeIs('reports.aggregate-users'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 false">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="#" @click="selected !== 2 ? selected = 2 : selected = null">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-grow">
                                <x-heroicon-s-tag class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                                <span class="text-xs font-medium">Cupones</span>
                            </div>
                            <div class="flex flex-shrink-0 ml-2">
                                <x-heroicon-s-chevron-down x-show="selected != 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                                <x-heroicon-s-chevron-up x-show="selected == 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                            </div>
                        </div>
                    </a>
                    <div class="overflow-hidden transition-all duration-200" :class="{ 'max-h-0' : selected != 2 }" x-ref="container2" x-bind:style="selected == 2 ? 'max-height: ' + $refs.container2.scrollHeight + 'px' : ''">
                        <ul class="pl-8 pr-1 mt-3">
                            <li class="flex items-center mb-2">
                                <a class="block transition duration-150" href="">
                                    <span class="text-xs font-medium">Impresos</span>
                                </a>
                                @if (request()->routeIs('reports.printed-coupons'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                            <li class="flex items-center mb-2">
                                <a class="block transition duration-150" href="">
                                    <span class="text-xs font-medium">Canjeados</span>
                                </a>
                                @if (request()->routeIs('reports.redeemed-coupons'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                            <li class="flex items-center mb-2">
                                <a class="block transition duration-150" href="">
                                    <span class="text-xs font-medium">Último cupón</span>
                                </a>
                                @if (request()->routeIs('reports.last-printed-coupons'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                            <li class="flex items-center mb-2">
                                <a class="block transition duration-150" href="">
                                    <span class="text-xs font-medium">Impresos vs Canjeados</span>
                                </a>
                                @if (request()->routeIs('reports.printed-redeemed-coupons'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                            <li class="flex items-center mb-2">
                                <a class="block transition duration-150" href="">
                                    <span class="text-xs font-medium">Acumulados canjeados e impresos</span>
                                </a>
                                @if (request()->routeIs('reports.agregate-coupons'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 false">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="#" @click="selected !== 3 ? selected = 3 : selected = null">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center flex-grow">
                                <x-heroicon-s-currency-dollar class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                                <span class="text-xs font-medium">Ventas</span>
                            </div>
                            <div class="flex flex-shrink-0 ml-2">
                                <x-heroicon-s-chevron-down x-show="selected != 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                                <x-heroicon-s-chevron-up x-show="selected == 1" class="flex-shrink-0 w-3 h-3 ml-1 fill-current text-gray-darker"/>
                            </div>
                        </div>
                    </a>
                    <div class="overflow-hidden transition-all duration-200" :class="{ 'max-h-0' : selected != 3 }" x-ref="container3" x-bind:style="selected == 3 ? 'max-height: ' + $refs.container3.scrollHeight + 'px' : ''">
                        <ul class="pl-8 pr-1 mt-3">
                            <li class="mb-2"><a class="block transition duration-150" href="/"><span class="text-xs font-medium">Detallado</span></a></li>
                            <li class="mb-2 last:mb-0"><a class="block transition duration-150" href="/"><span class="text-xs font-medium">Acumulado</span></a></li>
                        </ul>
                    </div>
                </li>
                <li class="px-3 py-2 rounded-sm mb-0.5 last:mb-0 false">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="/">
                        <div class="flex items-center flex-grow">
                            <x-heroicon-s-credit-card class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                            <span class="text-xs font-medium">Saldo disponible</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Reportes -->
        <div class="p-4 mt-3">
            <h3 class="pl-3 text-xs font-light text-gray-400 uppercase">Administración</h3>
            <ul class="mt-3 text-gray-600">
                <li class="px-3 py-2 rounded-md mb-0.5 last:mb-0">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="" style="outline: none;">
                        <div class="flex items-center flex-grow">
                            <x-heroicon-s-user-circle class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                            <span class="text-xs font-medium">Usuarios</span>
                            @if(request()->is('users*'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                            @endif
                        </div>
                    </a>
                </li>
                <li class="px-3 py-2 rounded-md mb-0.5 last:mb-0">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="" style="outline: none;">
                        <div class="flex items-center flex-grow">
                            <x-heroicon-s-identification class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                            <span class="text-xs font-medium">Roles y Permisos</span>
                            @if(request()->is('roles*'))
                                <span class="ml-auto block w-1.5 h-1.5 rounded-full bg-orange-light"></span>
                            @endif
                        </div>
                    </a>
                </li>
                <li class="px-3 py-2 rounded-md mb-0.5 last:mb-0">
                    <a class="block transition duration-150 text-gray-dark hover:text-gray-darker" href="/" style="outline: none;">
                        <div class="flex items-center flex-grow">
                            <x-heroicon-s-office-building class="flex-shrink-0 w-5 h-5 mr-3 text-orange"/>
                            <span class="text-xs font-medium">Grupos y establecimientos</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Administracion -->
    </div>
</sidebar>
