<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Blog::active();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $featuredBlog = Blog::active()->featured()->latest('published_at')->first();
        
        // If no featured blog explicitly set, fallback to the latest active blog
        if (!$featuredBlog && !$request->filled('category')) {
            $featuredBlog = Blog::active()->latest('published_at')->first();
        }

        // Get regular blogs (excluding the featured one if it exists)
        if ($featuredBlog) {
            $query->where('id', '!=', $featuredBlog->id);
        }

        $blogs = $query->latest('published_at')->paginate(9);

        return view('blog.index', compact('blogs', 'featuredBlog'));
    }

    public function show(string $slug): View
    {
        $blog = Blog::active()->where('slug', $slug)->firstOrFail();
        
        // Increment view count
        $blog->increment('views');

        $relatedBlogs = Blog::active()
            ->where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedBlogs'));
    }
}
