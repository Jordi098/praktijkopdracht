<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::all();
        return view('home', compact('stories'));
    }

    public function findStory($id)
    {
        $story = Story::find($id);
        return view('story', compact('story'));
    }
}
