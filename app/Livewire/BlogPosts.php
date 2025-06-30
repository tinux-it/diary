<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class BlogPosts extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filter = 'all'; // all, draft, published, archived

    public function render(): View
    {
        $blogPosts = BlogPost::query()
            ->where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where('subject', 'like', '%'.$this->search.'%');
            })
            ->when($this->filter !== 'all', function ($query) {
                $query->where('state', $this->filter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.blog-posts', [
            'blogPosts' => $blogPosts,
        ]);
    }

    public function toggleVisibility(BlogPost $blogPost): void
    {
        $blogPost->update(['is_visible' => ! $blogPost->is_visible]);
    }

    public function deleteBlogPost(BlogPost $blogPost): void
    {
        $blogPost->delete();
        session()->flash('message', 'Blog post deleted successfully.');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }
}
