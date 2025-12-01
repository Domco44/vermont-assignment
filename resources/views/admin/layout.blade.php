<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Admin', ['app' => 'Vermont']) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

<header class="bg-white shadow p-4">
    <div class="container mx-auto flex justify-between items-center">

        <!-- LEFT: Logo / links -->
        <div class="flex items-center space-x-4">
            <h1 class="text-2xl font-bold">
                <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
            </h1>

            <x-language-switcher/>

            @can('admin')
                <a href="{{ route('admin.products.index') }}" class="text-blue-600 hover:underline">
                    {{ __('Products') }}
                </a>
            @endcan
        </div>

        <!-- RIGHT: user/admin menu -->
        <nav class="flex items-center space-x-4">
            @auth
                <span>{{ __('Admin welcome') }}, {{ auth()->user()->name }}</span>

                <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline">
                    {{ __('Shop') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">
                        {{ __('Log out') }}
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    {{ __('Login') }}
                </a>
            @endguest
        </nav>
    </div>
</header>

<main class="container mx-auto flex-1 py-6">
    @yield('content')
</main>

<footer class="bg-white shadow p-4 mt-6 text-center">
    &copy; {{ date('Y') }} {{ __('Admin title', ['app' => 'Vermont']) }}
</footer>

</body>
</html>
