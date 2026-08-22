<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest()->paginate(12);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'category' => 'required|in:tutorials,updates,tips,news',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'read_time' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        
        // Ensure slug is unique if auto-generated
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Blog::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs'), $filename);
            $validated['image'] = '/uploads/blogs/' . $filename;
        }

        if (empty($validated['read_time'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $minutes = max(1, ceil($wordCount / 200));
            $validated['read_time'] = $minutes . ' min read';
        }

        if ($request->boolean('is_featured')) {
            Blog::query()->update(['is_featured' => false]); // Only 1 featured post at a time
        }

        $validated['published_at'] = now();
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post published successfully!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'category' => 'required|in:tutorials,updates,tips,news',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'read_time' => 'nullable|string|max:50',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if (!empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        } else {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Ensure slug is unique
        $originalSlug = $validated['slug'];
        $count = 1;
        while (Blog::where('slug', $validated['slug'])->where('id', '!=', $blog->id)->exists()) {
            $validated['slug'] = $originalSlug . '-' . $count++;
        }

        if ($request->hasFile('image')) {
            if ($blog->image && File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs'), $filename);
            $validated['image'] = '/uploads/blogs/' . $filename;
        }

        if (empty($validated['read_time'])) {
            $wordCount = str_word_count(strip_tags($validated['content']));
            $minutes = max(1, ceil($wordCount / 200));
            $validated['read_time'] = $minutes . ' min read';
        }

        if ($request->boolean('is_featured') && !$blog->is_featured) {
            Blog::where('id', '!=', $blog->id)->update(['is_featured' => false]);
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['is_featured'] = $request->boolean('is_featured', false);

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && File::exists(public_path($blog->image))) {
            File::delete(public_path($blog->image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post deleted successfully!');
    }

    public function toggleActive(Blog $blog)
    {
        $blog->update(['is_active' => !$blog->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $blog->is_active,
            'message' => 'Status updated successfully',
        ]);
    }

    public function toggleFeatured(Blog $blog)
    {
        if (!$blog->is_featured) {
            Blog::where('id', '!=', $blog->id)->update(['is_featured' => false]);
            $blog->update(['is_featured' => true]);
        } else {
            $blog->update(['is_featured' => false]);
        }

        return response()->json([
            'success' => true,
            'is_featured' => $blog->is_featured,
            'message' => 'Featured status updated successfully',
        ]);
    }
}
