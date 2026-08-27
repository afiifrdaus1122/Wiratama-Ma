<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HighlightEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HighlightEventController extends Controller
{
    public function index()
    {
        $events = HighlightEvent::latest()->get();
        return view('admin.highlights.index', compact('events'));
    }

    public function create()
    {
        return view('admin.highlights.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video,news',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm|max:20480',
            'content' => 'nullable|string',
            'action_link' => 'nullable|string',
            'action_text' => 'nullable|string|max:50',
            'expires_at' => 'required|date|after:now',
        ]);

        $data = $request->except('media');

        if ($request->hasFile('media')) {
            $data['media_path'] = $request->file('media')->store('highlights', 'public');
        }

        HighlightEvent::create($data);

        return redirect()->route('admin.highlights.index')->with('success', 'Highlight Event created successfully.');
    }

    public function edit(HighlightEvent $highlight)
    {
        return view('admin.highlights.edit', compact('highlight'));
    }

    public function update(Request $request, HighlightEvent $highlight)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:image,video,news',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm|max:20480',
            'content' => 'nullable|string',
            'action_link' => 'nullable|string',
            'action_text' => 'nullable|string|max:50',
            'expires_at' => 'required|date',
        ]);

        $data = $request->except('media');

        if ($request->hasFile('media')) {
            if ($highlight->media_path) {
                Storage::disk('public')->delete($highlight->media_path);
            }
            $data['media_path'] = $request->file('media')->store('highlights', 'public');
        }

        $highlight->update($data);

        return redirect()->route('admin.highlights.index')->with('success', 'Highlight Event updated successfully.');
    }

    public function destroy(HighlightEvent $highlight)
    {
        if ($highlight->media_path) {
            Storage::disk('public')->delete($highlight->media_path);
        }
        $highlight->delete();

        return redirect()->route('admin.highlights.index')->with('success', 'Highlight Event deleted successfully.');
    }
}
