<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $activeCategory = $request->input('category');

        $query = Story::with('category')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('text', 'like', "%{$search}%");
            });
        }

        if (!empty($activeCategory)) {
            $query->where('category_id', $activeCategory);
        }

        if (!auth()->check() || !auth()->user()->is_admin) {
            $query->where('published', true);
        }

        $stories = $query->get();

        $categories = Category::all();

        return view('home', compact('stories', 'search', 'categories', 'activeCategory'));
    }

    public function show(Story $story)
    {
        return view('story', compact('story'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function edit(Story $story)
    {
        $categories = Category::all();
        return view('edit', compact('story', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'text' => 'required'
        ]);
        $story = new Story();
        $story->name = $request->input('title');
        $story->text = $request->input('text');
        $story->category_id = $request->input('category_id');
        $story->user_id = Auth::id();

        $story->published = (auth()->check() && auth()->user()->is_admin) ? true : false;

        $story->save();

        return redirect()->route('story.index');
    }

    public function update(Request $request, Story $story)
    {
        if (Auth::id() !== $story->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:100',
            'text' => 'required',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $story->name = $request->input('title');
        $story->text = $request->input('text');
        $story->category_id = $request->input('category_id');
        $story->save();

        return redirect()->route('story.show', $story)->with('success', 'Story updated.');
    }

    public function destroy(Story $story)
    {
        if (Auth::id() !== $story->user_id) {
            abort(403);
        }

        $story->delete();

        return redirect()->route('story.index')->with('success', 'Story verwijderd.');
    }
}
