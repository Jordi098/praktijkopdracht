<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::all();
        return view('home', compact('stories'));
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
        $story->save();

        return redirect()->route('story.index');
    }
}
