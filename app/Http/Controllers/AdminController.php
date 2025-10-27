<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // show pending stories
    public function index()
    {
        $pending = Story::with('category')->where('published', false)->latest()->get();

        $trashed = Story::onlyTrashed()->with('category')->latest('deleted_at')->get();

        $userIds = $pending->pluck('user_id')->merge($trashed->pluck('user_id'))->unique()->filter()->values()->all();
        $users = User::whereIn('id', $userIds)->pluck('name', 'id')->toArray();

        $pending->each(function ($s) use ($users) {
            $s->user_name = $users[$s->user_id] ?? 'Onbekend';
        });
        $trashed->each(function ($s) use ($users) {
            $s->user_name = $users[$s->user_id] ?? 'Onbekend';
        });

        return view('admin.index', compact('pending', 'trashed'));
    }

    // approve a story
    public function approve(Story $story)
    {
        $story->published = true;
        $story->save();

        return redirect()->route('admin.index')->with('success', 'Verhaal goedgekeurd.');
    }

    // reject (delete) a story
    public function reject(Story $story)
    {
        $story->delete();

        return redirect()->route('admin.index')->with('success', 'Verhaal afgewezen en verwijderd.');
    }

    // restore a soft-deleted story (by id)
    public function restore($id)
    {
        $story = Story::onlyTrashed()->findOrFail($id);
        $story->restore();

        return redirect()->route('admin.index')->with('success', 'Verhaal hersteld.');
    }

    // permanently delete a soft-deleted story
    public function forceDelete($id)
    {
        $story = Story::onlyTrashed()->findOrFail($id);
        $story->forceDelete();

        return redirect()->route('admin.index')->with('success', 'Verhaal permanent verwijderd.');
    }
}
