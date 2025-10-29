<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // display all stories, pending stories, and trashed stories. And handle tab selection.
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');

        $stories = Story::with(['category', 'user'])->latest()->get();
        $pending = Story::with(['category', 'user'])->where('published', false)->latest()->get();
        $trashed = Story::onlyTrashed()->with(['category', 'user'])->latest('deleted_at')->get();

        $stories->each(fn($s) => $s->user_name = $s->user->name ?? 'Onbekend');
        $pending->each(fn($s) => $s->user_name = $s->user->name ?? 'Onbekend');
        $trashed->each(fn($s) => $s->user_name = $s->user->name ?? 'Onbekend');

        return view('admin.index', compact('stories', 'pending', 'trashed', 'tab'));

    }


// approve (activate) a story
    public function approve(Story $story)
    {
        $story->published = true;
        $story->save();

        return redirect()->route('admin.index')->with('success', 'Verhaal goedgekeurd.');
    }

    // deactivate (unpublish) a story
    public function deactivate(Story $story)
    {
        $story->published = false;
        $story->save();

        return redirect()->route('admin.index')->with('success', 'Verhaal gedeactiveerd.');
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

        if ($story->file_path && Storage::disk('public')->exists($story->file_path)) {
            Storage::disk('public')->delete($story->file_path);
        }

        $story->forceDelete();

        return redirect()->route('admin.index')
            ->with('success', 'Verhaal permanent verwijderd.');
    }

}
