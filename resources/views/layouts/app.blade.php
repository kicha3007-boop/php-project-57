<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token">
    <title>{{ __('layout.app_name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white text-gray-900">
    <header class="border-b border-gray-200 bg-white">
        <nav class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4">
            <div class="flex flex-wrap items-center gap-6">
                <a href="{{ route('home') }}" class="text-xl font-semibold">{{ __('layout.app_name') }}</a>
                <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('layout.tasks') }}</a>
                <a href="{{ route('task_statuses.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('layout.task_statuses') }}</a>
                <a href="{{ route('labels.index') }}" class="text-gray-600 hover:text-gray-900">{{ __('layout.labels') }}</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('logout') }}" data-method="post" rel="nofollow"
                       class="rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">{{ __('layout.logout') }}</a>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">{{ __('layout.login') }}</a>
                    <a href="{{ route('register') }}"
                       class="rounded bg-blue-600 px-4 py-2 font-medium text-white hover:bg-blue-700">{{ __('layout.register') }}</a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
        @include('components.flash')
        {{ $slot }}
    </main>
</body>
</html>
