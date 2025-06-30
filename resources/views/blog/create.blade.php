<x-layouts.app :title="__('Dagboek bericht Schrijven')">
    <div class="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                           Schrijf een nieuw berichtje
                        </h1>
                        <p class="text-lg text-gray-600">
                            Deel je gedachten, gevoelens en herinneringen van vandaag
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

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 mb-2">
                                Er zijn fouten opgetreden bij het opslaan van je bericht:
                            </h3>
                            <div class="text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
        @endif

            <!-- Form -->
            <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf

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
                                       value="{{ old('subject') }}"
                                       class="block w-full px-4 py-3 border {{ $errors->has('subject') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-orange-500 focus:border-orange-500' }} rounded-xl shadow-sm placeholder-gray-400 focus:ring-2 transition-all duration-200 text-gray-800"
                                       placeholder="Hoe wil je het bericht van vandaag noemen?"
                                       required>
                                @error('subject')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
            </div>

                            <!-- Content with Quill -->
                            <div class="space-y-2">
                                <label for="content" class="block text-sm font-semibold text-gray-800">
                                    Je Gedachten
                                </label>
                                <div class="relative">
                                    <div id="quill-editor"
                                         class="quill-editor bg-white border {{ $errors->has('content') ? 'border-red-300' : 'border-gray-200' }} rounded-xl shadow-sm overflow-hidden"
                                         style="height: 400px; min-height: 400px;">
                                        {!! old('content') !!}
                                    </div>
                                    <textarea name="content" id="content" class="hidden">{{ old('content') }}</textarea>
                                </div>
                                @error('content')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
            </div>

                            <!-- Image Upload -->
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-800">
                                    Voeg een Foto Toe (Optioneel)
                                    <br>
                                    <small>Deze afbeelding wordt getoond op het overzicht en bovenaan de pagina zelf. Meer foto's kun je in het bericht hierboven toevoegen.</small>
                                </label>
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
                                <div id="image-preview"></div>
                                @error('image')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
            </div>
            </div>

                <!-- Settings Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden">
                    <div class="px-6 py-6 sm:px-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Instellingen</h3>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <!-- State -->
                            <div class="space-y-2">
                                <label for="state" class="block text-sm font-semibold text-gray-800">
                                    Status
                                </label>
                                <select name="state"
                                        id="state"
                                        class="block w-full px-4 py-3 border {{ $errors->has('state') ? 'border-red-300 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:ring-orange-500 focus:border-orange-500' }} rounded-xl text-gray-800 shadow-sm focus:ring-2 transition-all duration-200">
                                    <option value="draft" {{ old('state') == 'draft' ? 'selected' : '' }}>Concept</option>
                                    <option value="published" {{ old('state') == 'published' ? 'selected' : '' }}>Gepubliceerd</option>
                                    <option value="archived" {{ old('state') == 'archived' ? 'selected' : '' }}>Gearchiveerd</option>
                </select>
                                @error('state')
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm font-medium">{{ $message }}</p>
                                    </div>
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
                                           value="1"
                                           class="sr-only"
                                           {{ old('is_visible') ? 'checked' : '' }}>
                                    <label for="is_visible"
                                           class="toggle-switch relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 cursor-pointer {{ old('is_visible') ? 'active' : '' }}">
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition duration-200 ease-in-out {{ old('is_visible') ? 'translate-x-6' : 'translate-x-1' }}"></span>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Bericht Opslaan
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

        /* Make images resizable */
        .ql-editor img {
            resize: both;
            overflow: auto;
            max-width: 100%;
            height: auto;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.2s ease;
        }

        .ql-editor img:hover {
            border-color: rgb(251 146 60);
        }

        .ql-editor img:focus {
            border-color: rgb(249 115 22);
            outline: none;
        }

        /* Custom toggle switch styling */
        .toggle-switch {
            transition: background-color 0.2s ease-in-out;
        }

        .toggle-switch.active {
            background-color: rgb(249 115 22);
        }

        .toggle-switch:not(.active) {
            background-color: rgb(229 231 235);
        }

        .toggle-switch:hover {
            background-color: rgb(251 146 60);
        }

        .toggle-switch:not(.active):hover {
            background-color: rgb(209 213 219);
        }
    </style>

    <script>
        // Handle toggle switch functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleInput = document.getElementById('is_visible');
            const toggleLabel = toggleInput.nextElementSibling;

            // Set initial state
            if (toggleInput.checked) {
                toggleLabel.classList.add('active');
                toggleLabel.querySelector('span').classList.add('translate-x-6');
                toggleLabel.querySelector('span').classList.remove('translate-x-1');
            } else {
                toggleLabel.classList.remove('active');
                toggleLabel.querySelector('span').classList.remove('translate-x-6');
                toggleLabel.querySelector('span').classList.add('translate-x-1');
            }

            // Handle toggle click
            toggleLabel.addEventListener('click', function() {
                toggleInput.checked = !toggleInput.checked;

                if (toggleInput.checked) {
                    toggleLabel.classList.add('active');
                    toggleLabel.querySelector('span').classList.add('translate-x-6');
                    toggleLabel.querySelector('span').classList.remove('translate-x-1');
                } else {
                    toggleLabel.classList.remove('active');
                    toggleLabel.querySelector('span').classList.remove('translate-x-6');
                    toggleLabel.querySelector('span').classList.add('translate-x-1');
                }
            });

            // Handle image upload preview
            const imageInput = document.getElementById('image');
            const imageUploadArea = imageInput.closest('.space-y-2').querySelector('.mt-1');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                const previewContainer = document.getElementById('image-preview');

                if (file) {
                    // Clear previous preview
                    previewContainer.innerHTML = '';

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                <div class="relative mt-4">
                    <img src="${e.target.result}" alt="Preview" class="w-full h-48 object-cover rounded-2xl shadow-lg">
                    <div class="absolute top-2 right-2">
                        <button type="button" onclick="removeImage()" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            `;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // Function to remove selected image
        function removeImage() {
            const imageInput = document.getElementById('image');
            const previewContainer = document.getElementById('image-preview');

            imageInput.value = ''; // optional: resets the input
            previewContainer.innerHTML = ''; // removes the preview
        }
    </script>
</x-layouts.app>
