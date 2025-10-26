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
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        // pending = created by users but not published yet and not deleted
        $pending = Story::with('category')->where('published', false)->latest()->get();

        // trashed = soft-deleted stories
        $trashed = Story::onlyTrashed()->with('category')->latest('deleted_at')->get();

        // Gather user names without relying on a Story->user relationship
        $userIds = $pending->pluck('user_id')->merge($trashed->pluck('user_id'))->unique()->filter()->values()->all();
        $users = User::whereIn('id', $userIds)->pluck('name', 'id')->toArray();

        // attach a safe user_name attribute used by the view
        $pending->each(function ($s) use ($users) {
            $s->user_name = $users[$s->user_id] ?? 'Onbekend';
        });
        $trashed->each(function ($s) use ($users) {
            $s->user_name = $users[$s->user_id] ?? 'Onbekend';
        });

        return view('admin.index', compact('pending', 'trashed'));
    }

    // approve (publish) a story
    public function approve(Story $story)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $story->published = true;
        $story->save();

        return redirect()->route('admin.index')->with('success', 'Verhaal goedgekeurd.');
    }

    // reject = delete (soft-delete) or remove
    public function reject(Story $story)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $story->delete();

        return redirect()->route('admin.index')->with('success', 'Verhaal afgewezen en verwijderd.');
    }

    // restore a soft-deleted story (by id)
    public function restore($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $story = Story::onlyTrashed()->findOrFail($id);
        $story->restore();

        return redirect()->route('admin.index')->with('success', 'Verhaal hersteld.');
    }

    // permanently delete a soft-deleted story
    public function forceDelete($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $story = Story::onlyTrashed()->findOrFail($id);
        $story->forceDelete();

        return redirect()->route('admin.index')->with('success', 'Verhaal permanent verwijderd.');
    }
}
