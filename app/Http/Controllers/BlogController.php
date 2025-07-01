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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog-images', 'minio');
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

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($blogPost->image) {
                Storage::disk('minio')->delete($blogPost->image);
            }
            $validated['image'] = $request->file('image')->store('blog-images', 'minio');
        }

        $validated['is_visible'] = $request->has('is_visible');

        $blogPost->update($validated);

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol bijgewerkt!');
    }

    public function destroy(BlogPost $blogPost)
    {
        // Delete image if exists
        if ($blogPost->image) {
            Storage::disk('minio')->delete($blogPost->image);
        }

        $blogPost->delete();

        return redirect()->route('dashboard')->with('message', 'Dagboek entry succesvol verwijderd!');
    }

    public function toggleVisibility(BlogPost $blogPost)
    {
        $blogPost->update(['is_visible' => ! $blogPost->is_visible]);

        return redirect()->route('dashboard')->with('message', 'Zichtbaarheid van dagboek entry bijgewerkt!');
    }

    /**
     * Generate a pre-signed URL for an image
     */
    public static function getImageUrl($imagePath)
    {
        if (! $imagePath) {
            return null;
        }

        try {
            // Try to get a pre-signed URL (expires in 1 hour)
            return Storage::disk('minio')->temporaryUrl($imagePath, now()->addHour());
        } catch (\Exception $e) {
            // Fallback to regular URL if pre-signed fails
            return Storage::disk('minio')->url($imagePath);
        }
    }
}
