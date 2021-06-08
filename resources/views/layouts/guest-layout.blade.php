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

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="m-0 font-sans text-base antialiased leading-none bg-white text-gray-dark">
    <noscript>{{ __('You need to enable JavaScript to run this app.') }}</noscript>
    <div class="flex min-h-screen">
        <x-top-navigation/>

        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <header class="sticky top-0 z-30 bg-white border-b border-gray-light lg:hidden">
                <div class="px-4 sm:px-6 lg:px8">
                    <div class="flex items-center justify-between h-16 -mb-px">
                        <div class="flex items-center">
                            <button class="text-gray-darker lg:hidden" aria-controls="sidebar" aria-expanded="false">
                                <span class="sr-only">Open sidebar</span>
                                <x-icons.menu class="w-6 h-6"/>
                            </button>
                            <a class="block ml-2 lg:hidden active" href="/">
                                <x-logo class="h-9"/>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <main class="h-screen text-gray-darker">
                <div class="w-full">
                    {{ $slot}}
                </div>
            </main>
        </div>

    </div>

</body>
</html>
