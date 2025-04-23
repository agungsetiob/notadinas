<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{asset ('/img/logo.png')}}" type="image/x-icon" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 bg-gray-200">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
            <header class="border bg-white shadow fixed bottom-0 w-full sm:sticky sm:top-0 sm:h-auto h-12 z-50">
                <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center">
                    <nav class="flex overflow-x-auto whitespace-nowrap scrollbar-hide w-full gap-6 sm:justify-center">
                        @php
                            $role = Auth::user()->role;
                            $currentRoute = Route::currentRouteName(); // Deteksi halaman aktif
                            $menuItems = [
                                'admin' => [
                                    ['Dashboard', 'dashboard', 'fas fa-home'],
                                    ['Users', 'users.index', 'fas fa-user'],
                                    ['SKPD', 'skpds.index', 'fas fa-sitemap'],
                                    ['Nota Dinas', 'nota-dinas.index', 'fas fa-file-lines'],
                                    ['Approval', 'approval-histories.index', 'fas fa-clock-rotate-left']
                                ],
                                'skpd' => [
                                    ['Dashboard', 'dashboard', 'fas fa-home'],
                                    ['Nota Dinas', 'nota-dinas.index', 'fas fa-file-lines'],
                                    ['Approval', 'approval-histories.index', 'fas fa-clock-rotate-left']
                                ],
                                'asisten' => [
                                    ['Dashboard', 'dashboard', 'fas fa-home'],
                                    ['Nota Dinas', 'nota-dinas.index', 'fas fa-file-lines'],
                                    ['Approval', 'approval-histories.index', 'fas fa-clock-rotate-left']
                                ],
                                'sekda' => [
                                    ['Dashboard', 'dashboard', 'fas fa-home'],
                                    ['Nota Dinas', 'nota-dinas.index', 'fas fa-file-lines'],
                                    ['Approval', 'approval-histories.index', 'fas fa-clock-rotate-left']
                                ],
                                'bupati' => [
                                    ['Dashboard', 'dashboard', 'fas fa-home'],
                                    ['Nota Dinas', 'nota-dinas.index', 'fas fa-file-lines'],
                                    ['Approval', 'approval-histories.index', 'fas fa-clock-rotate-left']
                                ]
                            ];
                        @endphp

                        @foreach ($menuItems[$role] as $menu)
                            <a href="{{ route($menu[1]) }}" 
                                class="flex flex-col items-center text-sm sm:text-base 
                                {{ $currentRoute == $menu[1] ? 'border-b-2 border-green-500' : '' }}">
                                
                                <i class="{{ $menu[2] }} text-lg sm:text-xl 
                                {{ $currentRoute == $menu[1] ? 'text-green-500' : 'text-dark-600' }}"></i>
                                
                                <span class="mt-2 font-medium text-gray-600 hover:text-blue-700">
                                    {{ $menu[0] }}
                                </span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </header>
            @endisset
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <x-footer/>
        @stack('scripts')
    </body>
</html>
