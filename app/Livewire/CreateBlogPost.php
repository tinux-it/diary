<?php

namespace App\Livewire;

use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBlogPost extends Component
{
    use WithFileUploads;

    public string $subject = '';
    public string $content = '';
    public $image;
    public string $date;
    public string $state = 'draft';
    public bool $is_visible = true;

    protected $rules = [
        'subject' => 'required|min:3|max:255',
        'content' => 'required|min:10',
        'image' => 'nullable|image|max:1024', // 1MB max
        'date' => 'required|date',
        'state' => 'required|in:draft,published,archived',
        'is_visible' => 'boolean',
    ];

    public function mount(): void
    {
        $this->date = now()->format('Y-m-d');
    }

    public function render(): View
    {
        return view('livewire.create-blog-post');
    }

    public function save(): void
    {
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
    }

    public function resetForm(): void
    {
        $this->reset();
        $this->date = now()->format('Y-m-d');
    }
}
