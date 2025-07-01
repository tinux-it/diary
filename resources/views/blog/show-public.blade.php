<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $blogPost->subject }} - Dagboek</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @vite('resources/css/app.css')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 min-h-screen">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-orange-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-14 sm:h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl sm:text-2xl font-bold text-gray-800 hover:text-orange-600 transition-colors duration-200">
                            Dagboek
                        </a>
                    </div>
                    <nav class="flex items-center space-x-2 sm:space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                               class="inline-flex items-center px-3 sm:px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-medium text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="hidden sm:inline">Mijn Dagboek</span>
                                <span class="sm:hidden">Dagboek</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-3 sm:px-4 py-2 border border-gray-300 rounded-xl font-medium text-sm text-gray-700 bg-white shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                                <span class="hidden sm:inline">Inloggen</span>
                                <span class="sm:hidden">Login</span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-3 sm:px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-medium text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                                    <span class="hidden sm:inline">Registreren</span>
                                    <span class="sm:hidden">Registreer</span>
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        <!-- Blog Post Content -->
        <div class="min-h-screen py-4 sm:py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                        <div class="space-y-2">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">{{ $blogPost->subject }}</h1>
                            <p class="text-base sm:text-lg text-gray-600">Een openhartig verhaal uit het leven</p>
                        </div>
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 w-full sm:w-auto">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Terug naar Overzicht
                        </a>
                    </div>
                </div>

                <!-- Blog Post Content -->
                <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden">
                    <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                        <!-- Meta Information -->
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 text-sm text-gray-500 mb-6">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $blogPost->date->format('j M Y') }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                Openbaar Bericht
                            </span>
                        </div>

                        @if($blogPost->image)
                            <div class="mb-6 sm:mb-8">
                                <img src="data:image/jpeg;base64,{{ $blogPost->image }}"
                                     alt="{{ $blogPost->subject }}"
                                     class="w-full h-48 sm:h-64 object-contain rounded-2xl shadow-lg">
                            </div>
                        @endif


                        <!-- Content -->
                        <div class="prose max-w-none prose-sm sm:prose-base">
                            <div class="ql-editor">
                                {!! $blogPost->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Message -->
        <footer>
            <div class="mt-8 sm:mt-12 text-center">
                <div class="text-gray-500 text-xs mt-4"><a href="https://tomemming.nl">Made with ❤️ by Tom Emming</a></div>
            </div>
        </footer>
    </body>
</html>
