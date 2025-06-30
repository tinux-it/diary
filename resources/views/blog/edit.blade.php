<x-layouts.app :title="__('Dagboek bericht Bewerken')">
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                            Bewerk je bericht
                        </h1>
                        <p class="text-lg text-gray-600">
                            Update je gedachten en herinneringen
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl font-medium text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Terug naar Dagboek
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

            <!-- Form -->
            <form action="{{ route('blog.update', $blogPost) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Main Content Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden">
                    <div class="px-6 py-8 sm:px-8">
                        <div class="space-y-8">
                            <!-- Subject -->
                            <div class="space-y-2">
                                <label for="subject" class="block text-sm font-semibold text-gray-800">
                                    Titel van bericht
                                </label>
                                <input type="text"
                                       name="subject"
                                       id="subject"
                                       value="{{ old('subject', $blogPost->subject) }}"
                                       class="block w-full px-4 py-3 border border-gray-200 rounded-xl shadow-sm placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 text-gray-800"
                                       placeholder="Hoe wil je het bericht van vandaag noemen?"
                                       required>
                                @error('subject')
                                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Content with Quill -->
                            <div class="space-y-2">
                                <label for="content" class="block text-sm font-semibold text-gray-800">
                                    Je Gedachten
                                </label>
                                <div class="relative">
                                    <div id="quill-editor"
                                         class="quill-editor bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
                                         style="height: 400px; min-height: 400px;">
                                        {!! old('content', $blogPost->content) !!}
                                    </div>
                                    <textarea name="content" id="content" class="hidden">{{ old('content', $blogPost->content) }}</textarea>
                                </div>
                                @error('content')
                                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-800">
                                    Voeg een Foto Toe (Optioneel)
                                </label>
                                @if($blogPost->image)
                                    <div class="mb-4 p-4 bg-orange-50 rounded-xl border border-orange-200">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ Storage::url($blogPost->image) }}" alt="Current image" class="h-20 w-20 object-cover rounded-lg shadow-sm">
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">Huidige foto</p>
                                                <p class="text-xs text-gray-500">Upload een nieuwe foto om deze te vervangen</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-orange-200 rounded-2xl bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                    <div class="space-y-4 text-center">
                                        <div class="flex justify-center">
                                            <svg class="mx-auto h-12 w-12 text-orange-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-lg font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 transition-colors duration-200 px-4 py-2 border border-orange-200">
                                                <span>Kies een foto</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                            <p class="pl-3 self-center">of sleep en zet neer</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF tot 1MB</p>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Settings Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden">
                    <div class="px-6 py-6 sm:px-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Instellingen</h3>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-1">
                            <!-- State -->
                            <div class="space-y-2">
                                <label for="state" class="block text-sm font-semibold text-gray-800">
                                    Status
                                </label>
                                <select name="state"
                                        id="state"
                                        class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-gray-800 shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                                    <option value="draft" {{ old('state', $blogPost->state) == 'draft' ? 'selected' : '' }}>Concept</option>
                                    <option value="published" {{ old('state', $blogPost->state) == 'published' ? 'selected' : '' }}>Gepubliceerd</option>
                                    <option value="archived" {{ old('state', $blogPost->state) == 'archived' ? 'selected' : '' }}>Gearchiveerd</option>
                                </select>
                                @error('state')
                                    <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Visibility Toggle -->
                        <div class="mt-6 pt-6 border-t border-orange-100">
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <label for="is_visible" class="text-sm font-semibold text-gray-800">
                                        Maak dit bericht openbaar
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        Sta anderen toe om dit bericht op de website te zien.
                                    </p>
                                </div>
                                <div class="relative">
                                    <input type="checkbox"
                                           name="is_visible"
                                           id="is_visible"
                                           class="sr-only"
                                           {{ old('is_visible', $blogPost->is_visible) ? 'checked' : '' }}>
                                    <label for="is_visible"
                                           class="relative inline-flex h-6 w-11 items-center rounded-full bg-gray-200 transition-colors duration-200 cursor-pointer hover:bg-gray-300">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition duration-200 ease-in-out translate-x-1"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-xl font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                        Annuleren
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 border border-transparent rounded-xl font-semibold text-sm text-white shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Bericht Bijwerken
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Custom Quill styling for light mode */
        .ql-toolbar {
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            border-color: rgb(229 231 235);
            background-color: rgb(255 255 255);
            border-bottom: 1px solid rgb(229 231 235);
        }

        .ql-container {
            border-bottom-left-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
            border-color: rgb(229 231 235);
            font-size: 16px;
            background-color: rgb(255 255 255);
        }

        .ql-editor {
            min-height: 350px;
            padding: 1rem;
            color: rgb(31 41 55);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
        }

        .ql-editor p {
            margin-bottom: 1rem;
        }

        .ql-editor h1, .ql-editor h2, .ql-editor h3 {
            color: rgb(31 41 55);
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .ql-editor h1 {
            font-size: 1.5rem;
        }

        .ql-editor h2 {
            font-size: 1.25rem;
        }

        .ql-editor h3 {
            font-size: 1.125rem;
        }

        .ql-editor ul, .ql-editor ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .ql-editor li {
            margin-bottom: 0.25rem;
        }

        .ql-editor blockquote {
            border-left: 4px solid rgb(251 146 60);
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: rgb(75 85 99);
        }

        .ql-editor a {
            color: rgb(251 146 60);
            text-decoration: underline;
        }

        .ql-editor a:hover {
            color: rgb(249 115 22);
        }
    </style>
</x-layouts.app>
