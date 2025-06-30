<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::where('user_id', auth()->id());

        // Search functionality
        if ($request->filled('search')) {
            $query->where('subject', 'like', '%'.$request->search.'%');
        }

        // Filter functionality
        if ($request->filled('filter') && $request->filter !== 'all') {
            $query->where('state', $request->filter);
        }

        $blogPosts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard', compact('blogPosts'));
    }
}
