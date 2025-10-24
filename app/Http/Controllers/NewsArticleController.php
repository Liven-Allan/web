<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Project;
use App\Models\DescriptionText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsArticleController extends Controller
{
    /**
     * Display a listing of the news articles.
     */
    public function index()
    {
        $news = News::latest('date')->paginate(10);
        
        // Get projects and description for the master layout
        $projects = Project::latest()->take(4)->get();
        $descriptionText = DescriptionText::latest()->first();
        
        return view('frontend.news', compact('news', 'projects', 'descriptionText'));
    }

    /**
     * Show the form for creating a new news article.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news article in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        News::create($validated);

        return redirect()->route('news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Show the form for editing the specified news article.
     */
    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified news article in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            // Store new image
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news article from storage.
     */
    public function destroy(News $news)
    {
        // Delete image if exists
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'News article deleted successfully.');
    }
}