<?php

use App\Models\BlogPost;
use Livewire\WithFileUploads;

use function Livewire\Volt\{state, rules, mount};

state([
    'subject' => '',
    'content' => '',
    'image' => null,
    'date' => '',
    'state' => 'draft',
    'is_visible' => true,
]);

rules([
    'subject' => 'required|min:3|max:255',
    'content' => 'required|min:10',
    'image' => 'nullable|image|max:1024', // 1MB max
    'date' => 'required|date',
    'state' => 'required|in:draft,published,archived',
    'is_visible' => 'boolean',
]);

mount(function () {
    $this->date = now()->format('Y-m-d');
});

$save = function () {
    $this->validate();

    $imagePath = null;
    if ($this->image) {
        $imagePath = $this->image->store('blog-images', 'public');
    }

    BlogPost::create([
        'subject' => $this->subject,
        'content' => $this->content,
        'image' => $imagePath,
        'date' => $this->date,
        'state' => $this->state,
        'is_visible' => $this->is_visible,
        'user_id' => auth()->id(),
    ]);

    session()->flash('message', 'Blog post created successfully!');
    $this->reset();
    $this->date = now()->format('Y-m-d');
};

$resetForm = function () {
    $this->reset();
    $this->date = now()->format('Y-m-d');
};

$formatText = function ($command, $value = null) {
    $this->dispatch('format-text', command: $command, value: $value);
};

?>

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Blog Post</h2>
            <p class="text-gray-600 dark:text-gray-400">Write and publish your blog post</p>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative dark:bg-green-900 dark:border-green-700 dark:text-green-300" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Form -->
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <!-- Subject -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                    <input wire:model="subject" type="text" id="subject" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter the subject of your blog post">
                    @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Content with Rich Text Editor -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                    
                    <!-- Rich Text Toolbar -->
                    <div class="border border-gray-300 rounded-t-md bg-gray-50 dark:bg-gray-700 dark:border-gray-600 p-2 flex flex-wrap gap-1">
                        <button type="button" wire:click="formatText('bold')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M12.6 18H6V2h4.5a4.5 4.5 0 014.5 4.5 4.5 4.5 0 01-4.5 4.5H10v7h2.6zM10 8h2.5a2.5 2.5 0 000-5H10v5z"/>
                            </svg>
                        </button>
                        <button type="button" wire:click="formatText('italic')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Italic">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 4v3h2.21l-3.42 8H6v3h8v-3h-2.21l3.42-8H18V4h-8z"/>
                            </svg>
                        </button>
                        <button type="button" wire:click="formatText('underline')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Underline">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16 9A6 6 0 114 9V1a1 1 0 012 0v8a4 4 0 108 0V1a1 1 0 012 0v8z"/>
                            </svg>
                        </button>
                        <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>
                        <button type="button" wire:click="formatText('insertUnorderedList')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Bullet List">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </button>
                        <button type="button" wire:click="formatText('insertOrderedList')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Numbered List">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 mx-1"></div>
                        <button type="button" wire:click="formatText('justifyLeft')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Align Left">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                            </svg>
                        </button>
                        <button type="button" wire:click="formatText('justifyCenter')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Align Center">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm2 4a1 1 0 00-1 1v2a1 1 0 001 1h10a1 1 0 001-1V9a1 1 0 00-1-1H5zm0 6a1 1 0 00-1 1v2a1 1 0 001 1h10a1 1 0 001-1v-2a1 1 0 00-1-1H5z"/>
                            </svg>
                        </button>
                        <button type="button" wire:click="formatText('justifyRight')" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded dark:text-gray-300 dark:hover:bg-gray-600" title="Align Right">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Rich Text Editor -->
                    <div 
                        wire:model="content"
                        x-data="{ 
                            content: @entangle('content'),
                            init() {
                                this.$refs.editor.addEventListener('input', () => {
                                    this.content = this.$refs.editor.innerHTML;
                                });
                                this.$refs.editor.innerHTML = this.content;
                            }
                        }"
                        x-ref="editor"
                        contenteditable="true"
                        class="mt-0 block w-full border border-gray-300 rounded-b-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white min-h-[300px] p-4 overflow-y-auto"
                        style="min-height: 300px;"
                        placeholder="Write your blog post content here..."
                    ></div>
                    @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Featured Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600">
                        <div class="space-y-1 text-center">
                            @if($image)
                                <div class="mb-4">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="mx-auto h-32 w-auto rounded-lg">
                                </div>
                            @else
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 dark:bg-gray-800">
                                    <span>Upload a file</span>
                                    <input wire:model="image" id="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 1MB</p>
                        </div>
                    </div>
                    @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Date and State -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                        <input wire:model="date" type="date" id="date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                        <select wire:model="state" id="state" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                        @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Visibility -->
                <div class="flex items-center">
                    <input wire:model="is_visible" type="checkbox" id="is_visible" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_visible" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        Make this post visible to readers
                    </label>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
            <button type="button" wire:click="resetForm" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                Reset
            </button>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create Post
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('livewire:init', () => {
    Livewire.on('format-text', (event) => {
        const { command, value } = event;
        document.execCommand(command, false, value);
    });
});
</script>
