<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vermont</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 text-gray-800">

<header class="bg-white shadow p-4 mb-6">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex ">
            <div class="shrink-0 flex gap-6 items-center">
                <a href="{{ route('shop.index') }}">
                    <x-application-logo class="block h-12 w-auto"/>
                </a>

                <x-language-switcher/>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="flex items-center space-x-4">

            {{-- Admin dashboard --}}
            @can('admin')
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:underline">
                    {{__('Dashboard')}}
                </a>
            @endcan

            {{-- Authenticated user --}}
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:underline">
                        {{__('Log out')}}
                    </button>
                </form>
            @endauth

            {{-- Guest --}}
            @guest
                <a href="{{ route('login') }}" class="text-gray-900 hover:underline">
                    {{__('Login')}}
                </a>
            @endguest

        </nav>
    </div>
</header>

<main class="container mx-auto">
    @yield('content')
</main>

<footer class="bg-white shadow p-4 mt-6 text-center">
    &copy; {{ date('Y') }} Vermont Eshop
</footer>

</body>
</html>
