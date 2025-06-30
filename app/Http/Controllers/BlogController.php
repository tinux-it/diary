<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::where('state', 'published')
            ->where('is_visible', true)
            ->orderBy('date', 'desc')
            ->paginate(12);

        return view('welcome', compact('blogPosts'));
    }

    public function showPublic(BlogPost $blogPost)
    {
        // Only allow viewing published and public posts
        if ($blogPost->state !== 'published' || !$blogPost->is_visible) {
            abort(404);
        }

        return view('blog.show-public', compact('blogPost'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'image' => 'nullable|image|max:1024',
            'state' => 'required|in:draft,published,archived',
            'is_visible' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog-images', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['is_visible'] = $request->has('is_visible');
        $validated['date'] = now('Europe/Amsterdam')->toDateTime(); // Automatically set to today

        BlogPost::create($validated);

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol aangemaakt!');
    }

    public function show(BlogPost $blogPost)
    {
        return view('blog.show', compact('blogPost'));
    }

    public function edit(BlogPost $blogPost)
    {
        return view('blog.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'subject' => 'required|min:3|max:255',
            'content' => 'required|min:10',
            'image' => 'nullable|image|max:1024',
            'state' => 'required|in:draft,published,archived',
            'is_visible' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image);
            }
            $validated['image'] = $request->file('image')->store('blog-images', 'public');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $blogPost->update($validated);

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol bijgewerkt!');
    }

    public function destroy(BlogPost $blogPost)
    {
        // Delete image if exists
        if ($blogPost->image) {
            Storage::disk('public')->delete($blogPost->image);
        }

        $blogPost->delete();

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol verwijderd!');
    }

    public function toggleVisibility(BlogPost $blogPost)
    {
        $blogPost->update(['is_visible' => !$blogPost->is_visible]);

        return redirect()->route('dashboard')->with('message', 'Zichtbaarheid van dagboek entry bijgewerkt!');
    }
}
