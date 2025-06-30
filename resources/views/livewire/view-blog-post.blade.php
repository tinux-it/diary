<?php

use App\Models\BlogPost;

use function Livewire\Volt\{state, mount};

state(['post' => null]);

mount(function ($postId) {
    $this->post = BlogPost::findOrFail($postId);
});

?>

<div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full dark:bg-gray-800">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                {{ $post->subject }}
                            </h3>
                            <button wire:click="$dispatch('closeModal')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        @if($post->image)
                            <div class="mb-4">
                                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->subject }}" class="w-full h-64 object-cover rounded-lg">
                            </div>
                        @endif
                        
                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <span>{{ $post->date->format('M d, Y') }}</span>
                            <span>•</span>
                            <span class="capitalize">{{ $post->state }}</span>
                            @if($post->is_visible)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Visible
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Hidden
                                </span>
                            @endif
                        </div>
                        
                        <div class="prose max-w-none dark:prose-invert">
                            <div class="text-gray-700 dark:text-gray-300">
                                {!! $post->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button wire:click="$dispatch('closeModal')" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div> 