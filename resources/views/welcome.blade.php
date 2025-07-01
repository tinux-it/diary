<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dagboek - Persoonlijke Gedachten en Herinneringen</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @vite('resources/css/app.css')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    </head>
    <body class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-6 sm:py-12 px-4 sm:px-6 lg:px-8">
        <!-- Login Button -->
        <div class="absolute top-4 right-4">
                    @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center px-3 sm:px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-medium text-sm rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="hidden sm:inline">Mijn Dagboek</span>
                    <span class="sm:hidden">Dagboek</span>
                        </a>
                    @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center px-3 sm:px-4 py-2 bg-white/80 backdrop-blur-sm border border-orange-200 text-orange-700 font-medium text-sm rounded-xl shadow-sm hover:shadow-md hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="hidden sm:inline">Inloggen</span>
                    <span class="sm:hidden">Login</span>
                </a>
            @endauth
        </div>

        <div class="max-w-6xl mx-auto">

            <!-- Header Section -->
            <div class="text-center mb-8 sm:mb-12">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-orange-500 to-orange-600 rounded-full mb-4 sm:mb-6 shadow-lg">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 sm:mb-4">Persoonlijke Gedachten en Herinneringen</h1>
                <div class="max-w-2xl mx-auto">
                    <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                        Een warme plek om je dagelijkse ervaringen, gedachten en herinneringen te delen.
                        Hier vind je openhartige verhalen uit het leven die hoop en kracht geven.
                    </p>
                </div>
            </div>

            <div class="grid gap-6 sm:gap-8">

                <!-- Blog Posts Display -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8 border border-orange-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 sm:mb-8 space-y-3 sm:space-y-0">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Recente Verhalen</h3>
                                <p class="text-sm sm:text-base text-gray-600">Ontdek de laatste gedachten en herinneringen van anderen</p>
                            </div>
                        </div>

                        @if($blogPosts->count() > 0)
                            <div class="space-y-4 sm:space-y-6">
                                @foreach($blogPosts as $blogPost)
                                    <div class="group relative overflow-hidden rounded-xl border-2 transition-all duration-300 hover:shadow-lg border-orange-200 bg-gradient-to-br from-orange-50 to-amber-50 hover:border-orange-300">
                                        <div class="p-4 sm:p-6">
                                            <div class="flex flex-col sm:flex-row sm:items-start space-y-4 sm:space-y-0 sm:space-x-4">
                                                <!-- Featured Image -->
                                                @if($blogPost->image)
                                                    <div class="mb-6 sm:mb-8">
                                                        <img src="data:image/jpeg;base64,{{ $blogPost->image }}"
                                                             alt="{{ $blogPost->subject }}"
                                                             class="w-full h-48 sm:h-64 md:h-80 object-contain rounded-2xl shadow-lg"
                                                             loading="lazy"
                                                             onerror="this.style.display='none'">
                                                    </div>
                                                @endif

                                                <div class="flex-1 min-w-0">
                                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 space-y-2 sm:space-y-0">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h4 class="font-semibold text-gray-900 text-lg sm:text-xl line-clamp-2">
                                                                    {{ $blogPost->subject }}
                                                                </h4>
                                                                <p class="text-xs sm:text-sm text-gray-600">
                                                                    {{ $blogPost->date->format('j M Y') }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center space-x-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                                            <span class="text-xs font-medium text-green-700 uppercase tracking-wider">Openbaar</span>
                                                        </div>
                                                    </div>

                                                    <!-- Content Preview -->
                                                    <div class="bg-white/80 backdrop-blur-sm border border-orange-200 rounded-lg p-3 sm:p-4 transition-all duration-200">
                                                        <div class="text-gray-700 text-xs sm:text-sm line-clamp-3 sm:line-clamp-4 mb-3 sm:mb-4">
                                                            {{ Str::limit(strip_tags($blogPost->content), 300) }}
                                                        </div>

                                                        <a href="{{ route('blog.show.public', $blogPost) }}"
                                                           class="inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-medium py-2 px-4 sm:px-6 rounded-lg shadow-sm hover:shadow-md transform hover:scale-[1.02] transition-all duration-200 text-xs sm:text-sm w-full sm:w-auto">
                                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                            </svg>
                                                            Lees Verhaal
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            @if($blogPosts->hasPages())
                                <div class="mt-6 sm:mt-8">
                                    {{ $blogPosts->links() }}
                                </div>
                        @endif
                        @else
                            <div class="text-center py-8 sm:py-16">
                                <div class="max-w-md mx-auto">
                                    <svg class="mx-auto h-16 w-16 sm:h-24 sm:w-24 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-4 text-base sm:text-lg font-medium text-gray-800">Nog geen openbare berichten</h3>
                                    <p class="mt-2 text-sm sm:text-base text-gray-500">
                                        Er zijn nog geen openbare dagboek berichten beschikbaar.
                                    </p>
                                    @auth
                                        <div class="mt-6">
                                            <a href="{{ route('blog.create') }}"
                                               class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 w-full sm:w-auto">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Schrijf het Eerste Bericht
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-6">
                                            <a href="{{ route('login') }}"
                                               class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 w-full sm:w-auto">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                                Inloggen om te Schrijven
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer Message -->
            <footer>
                <div class="mt-8 sm:mt-12 text-center">
                    <div class="text-gray-500 text-xs mt-4"><a href="https://tomemming.nl">Made with ❤️ by Tom Emming</a></div>
                </div>
            </footer>

        </div>

        <style>
            /* Styles moved to app.css */
        </style>
    </body>
</html>
