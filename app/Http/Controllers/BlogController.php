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
        if ($blogPost->state !== 'published' || ! $blogPost->is_visible) {
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
            'image' => 'nullable|image',
            'state' => 'required|in:draft,published,archived',
            'is_visible' => 'nullable|boolean',
        ], [
            'subject.required' => 'De titel van het bericht is verplicht.',
            'subject.min' => 'De titel moet minimaal 3 karakters bevatten.',
            'subject.max' => 'De titel mag maximaal 255 karakters bevatten.',
            'content.required' => 'De inhoud van het bericht is verplicht.',
            'content.min' => 'De inhoud moet minimaal 10 karakters bevatten.',
            'image.image' => 'Het bestand moet een afbeelding zijn.',
            'image.max' => 'De afbeelding mag maximaal 25MB groot zijn.',
            'state.required' => 'De status is verplicht.',
            'state.in' => 'De geselecteerde status is ongeldig.',
        ]);

        if ($request->image) {
            $imageData = base64_encode(file_get_contents($request->file('image')));
            $validated['image'] = $imageData;
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
            'image' => 'nullable|image',
            'state' => 'required|in:draft,published,archived',
            'is_visible' => 'nullable|boolean',
        ]);

        // Handle image - if a new image is uploaded, it will overwrite the existing one
        if ($request->hasFile('image')) {
            $imageData = base64_encode(file_get_contents($request->file('image')));
            $validated['image'] = $imageData;
        }

        $validated['is_visible'] = $request->has('is_visible');

        $blogPost->update($validated);

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol bijgewerkt!');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol verwijderd!');
    }

    public function toggleVisibility(BlogPost $blogPost)
    {
        $blogPost->update(['is_visible' => ! $blogPost->is_visible]);

        return redirect()->route('dashboard')->with('message', 'Zichtbaarheid van dagboek entry bijgewerkt!');
    }
}
