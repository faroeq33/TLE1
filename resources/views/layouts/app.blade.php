<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- needed for toggles in navigations to work --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.x.x/dist/alpine.min.js" defer></script>


    <!-- Scripts -->
    @yield('head')
    @vite(['resources/css/app.css'])
</head>

<body class="">
    <div id="app">
        <header><img src="{{ asset('img/header-museum.png') }}" alt="" class="object-cover w-full h-48">
        </header>
        @include('nav')

        <main class="pt-4">

            <body class="h-screen">
                @yield('content')
            </body>
        </main>
    </div>
</body>
@yield('scripts')

</html>
