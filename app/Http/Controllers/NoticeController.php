<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with('creator')->orderBy('created_at', 'desc')->get();
        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:normal,urgent',
        ]);

        Notice::create([
            'title' => $request->title,
            'message' => $request->message,
            'priority' => $request->priority,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice posted successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notices.index')->with('success', 'Notice deleted.');
    }
}