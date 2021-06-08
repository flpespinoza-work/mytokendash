<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body
    x-data="{ sidebarOpen: false }"
    class="m-0 font-sans text-base antialiased leading-none bg-gray-50 text-gray-dark">
    <noscript>{{ __('You need to enable JavaScript to run this app.') }}</noscript>
    <div class="flex h-screen overflow-hidden">
        <div class="lg:w-64">
            <div x-show="sidebarOpen" :class="{ 'opacity-100' : sidebarOpen }" class="fixed inset-0 z-40 transition-opacity duration-200 bg-black bg-opacity-25 opacity-0 pointer-events-none lg:hidden lg:z-auto" aria-hidden="true"></div>
            <x-navigation/>
        </div>
        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
                <div class="px-4 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 -mb-px">
                        <div class="flex items-center">
                            <button class="text-gray-darker lg:hidden" aria-controls="sidebar" aria-expanded="false" @click="sidebarOpen = !sidebarOpen">
                                <span class="sr-only">Open sidebar</span>
                                <x-heroicon-o-menu class="w-6 h-6"/>
                            </button>
                            <a class="block ml-2 lg:hidden active" href="/">
                                <x-logo class="h-10"/>
                            </a>
                        </div>
                        <div class="relative inline-block ml-auto text-left" x-data="{ profileOpen: false }">
                            <button @click="profileOpen = !profileOpen"
                            @keydown.escape="profileOpen = false"
                            type="button" class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-transparent" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                {{ Auth()->user()->name }}
                                <x-heroicon-s-chevron-down class="w-5 h-5 ml-2 -mr-1"/>
                            </button>
                            <div x-show="profileOpen"  @click.away="profileOpen = false" class="absolute right-0 w-56 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="menu-item-0">Mi perfil</a>
                                <form method="POST" action="{{ route('logout') }}" role="none">
                                    @csrf
                                    <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700" role="menuitem" tabindex="-1" id="menu-item-3">
                                    Cerrar sesión
                                    </button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="h-screen text-gray-darker">
                <div class="max-w-screen-xl mx-auto sm:px-6 lg:px-8">
                    <h3 class="py-5 text-lg font-semibold text-gray-500">{{ $title }}</h3>
                    {{ $slot}}
                </div>
            </main>
        </div>

    </div>

    @livewireScripts
</body>
</html>
