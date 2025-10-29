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

        $query = Story::with('user')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('text', 'like', "%{$search}%");
            });
        }

        if (!empty($activeCategory)) {
            $query->where('category_id', $activeCategory);
        }

        $query->where('published', true);

        $stories = $query->get();
        $categories = Category::all();

        return view('home', compact('stories', 'search', 'categories', 'activeCategory'));
    }

    public function show(Story $story)
    {
        return view('story', compact('story'));
    }

    public function myStories()
    {
        $stories = Story::where('user_id', Auth::id())->latest()->get();
        return view('myStories', compact('stories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('create', compact('categories'));
    }

    public function edit(Story $story)
    {
        if ($story->user_id !== Auth::id()) {
            return redirect()->route('story.index');
        }
        $categories = Category::all();
        return view('edit', compact('story', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'text' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp'
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        $story = new Story();
        $story->name = $validated['title'];
        $story->text = $validated['text'];
        $story->category_id = $validated['category_id'];
        $story->user_id = Auth::id();
        $story->published = false;
        $story->file_path = $path;
        $story->save();

        return redirect()->route('story.index')->with('success', 'Verhaal opgeslagen en in afwachting van goedkeuring.');
    }

    public function update(Request $request, Story $story)
    {
        if (Auth::id() !== $story->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:100',
            'text' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp',
        ]);


        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');;
            $story->file_path = $path;
        }

        $story->name = $validated['title'];
        $story->text = $validated['text'];
        $story->category_id = $validated['category_id'];
        $story->user_id = Auth::id();
        $story->published = true;
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
