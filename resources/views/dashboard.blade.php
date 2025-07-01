<x-layouts.app :title="__('Dagboek')">
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                    <div class="space-y-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 tracking-tight">
                            Je Dagboek
                        </h1>
                        <p class="text-base sm:text-lg text-gray-600">
                            Je persoonlijke ruimte voor gedachten en herinneringen
                        </p>
                    </div>
                    <a href="{{ route('blog.create') }}"
                       class="inline-flex items-center justify-center px-4 sm:px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105 w-full sm:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nieuw bericht schrijven
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session()->has('message'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Search and Filters -->
            <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden mb-6 sm:mb-8">
                <div class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                    <form method="GET" action="{{ route('dashboard') }}" class="space-y-4 sm:space-y-6">
                        <div class="grid grid-cols-1 gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <!-- Search -->
                            <div class="space-y-2">
                                <label for="search" class="block text-sm font-semibold text-gray-800">
                                    Zoek Entries
                                </label>
                                <input type="text"
                                       name="search"
                                       id="search"
                                       value="{{ request('search') }}"
                                       class="block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-gray-800"
                                       placeholder="Zoek op titel of inhoud...">
                            </div>

                            <!-- State Filter -->
                            <div class="space-y-2">
                                <label for="state" class="block text-sm font-semibold text-gray-800">
                                    Status
                                </label>
                                <select name="state"
                                        id="state"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200  text-gray-800">
                                    <option value="">Alle Entries</option>
                                    <option value="draft" {{ request('state') == 'draft' ? 'selected' : '' }}>Concept</option>
                                    <option value="published" {{ request('state') == 'published' ? 'selected' : '' }}>Gepubliceerd</option>
                                    <option value="archived" {{ request('state') == 'archived' ? 'selected' : '' }}>Gearchiveerd</option>
                                </select>
                            </div>

                            <!-- Visibility Filter -->
                            <div class="space-y-2">
                                <label for="visibility" class="block text-sm font-semibold text-gray-800">
                                    Zichtbaarheid
                                </label>
                                <select name="visibility"
                                        id="visibility"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200  text-gray-800">
                                    <option value="">Alles</option>
                                    <option value="1" {{ request('visibility') == '1' ? 'selected' : '' }}>Openbaar</option>
                                    <option value="0" {{ request('visibility') == '0' ? 'selected' : '' }}>Privé</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <a href="{{ route('dashboard') }}"
                               class="inline-flex justify-center items-center px-4 sm:px-6 py-3 border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 w-full sm:w-auto">
                                Filters Wissen
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center items-center px-4 sm:px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 w-full sm:w-auto">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Zoeken
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Diary Entries -->
            <div class="space-y-4 sm:space-y-6">
                @forelse($blogPosts as $blogPost)
                    <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                        <div class="p-4 sm:p-6 lg:p-8">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-4 lg:space-y-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between space-y-3 sm:space-y-0 sm:space-x-3 mb-4">
                                        <h2 class="text-lg sm:text-xl font-bold text-gray-800 hover:text-orange-600 transition-colors duration-200">
                                            <a href="{{ route('blog.show', $blogPost) }}">{{ $blogPost->subject }}</a>
                                        </h2>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <!-- Status Badge -->
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($blogPost->state === 'published') bg-green-100 text-green-800
                                                @elseif($blogPost->state === 'draft') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                @if($blogPost->state === 'published') Gepubliceerd
                                                @elseif($blogPost->state === 'draft') Concept
                                                @else Gearchiveerd @endif
                                            </span>

                                            <!-- Visibility Badge -->
                                            @if($blogPost->is_visible)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Openbaar
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                                                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                                                    </svg>
                                                    Privé
                                                </span>
                                            @endif
                                        </div>
                                    </div>

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


                                    <!-- Content Preview -->
                                    <div class="text-gray-600 mb-4 line-clamp-3 text-sm sm:text-base">
                                        {!! Str::limit($blogPost->content, 200) !!}
                                    </div>

                                    <!-- Meta Information -->
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-sm text-gray-500 space-y-2 sm:space-y-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center space-y-1 sm:space-y-0 sm:space-x-4">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $blogPost->date->format('j M Y') }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $blogPost->updated_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center justify-center sm:justify-end space-x-2 lg:ml-6 lg:flex-col lg:space-x-0 lg:space-y-2">
                                    <a href="{{ route('blog.show', $blogPost) }}"
                                       class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 min-w-[44px] min-h-[44px]"
                                       title="Entry lezen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('blog.edit', $blogPost) }}"
                                       class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 min-w-[44px] min-h-[44px]"
                                       title="Entry bewerken">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('blog.toggle-visibility', $blogPost) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 min-w-[44px] min-h-[44px]"
                                                title="{{ $blogPost->is_visible ? 'Privé maken' : 'Openbaar maken' }}">
                                            @if($blogPost->is_visible)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd"></path>
                                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('blog.destroy', $blogPost) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze entry wilt verwijderen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center px-3 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 min-w-[44px] min-h-[44px]"
                                                title="Entry verwijderen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden">
                        <div class="px-4 sm:px-6 lg:px-8 py-8 sm:py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-800">Nog geen dagboek entries</h3>
                            <p class="mt-1 text-sm text-gray-500">Begin vandaag met het schrijven van je eerste dagboek entry.</p>
                            <div class="mt-6">
                                <a href="{{ route('blog.create') }}"
                                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 w-full sm:w-auto">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Je Eerste Entry Schrijven
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($blogPosts->hasPages())
                <div class="mt-6 sm:mt-8">
                    {{ $blogPosts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
