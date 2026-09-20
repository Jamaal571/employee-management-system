<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $conversations = User::where('id', '!=', $userId)->get()->map(function ($user) use ($userId) {
            $lastMessage = Message::where(function ($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })->orderBy('created_at', 'desc')->first();

            $unreadCount = Message::where('sender_id', $user->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->where('is_deleted', false)
                ->count();

            return [
                'user' => $user,
                'last_message' => $lastMessage,
                'unread_count' => $unreadCount,
            ];
        })->sortByDesc(function ($conv) {
            return $conv['last_message'] ? $conv['last_message']->created_at : \Carbon\Carbon::createFromTimestamp(0);
        })->values();

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $userId = auth()->id();

        $messages = Message::where(function ($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($userId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'body' => $request->body,
            'is_read' => false,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('messages.show', $user);
    }

    public function destroy(Message $message)
    {
        if ($message->sender_id !== auth()->id()) {
            abort(403);
        }

        $message->update(['is_deleted' => true]);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back();
    }

    public function poll(User $user)
    {
        $userId = auth()->id();

        $messages = Message::where(function ($q) use ($userId, $user) {
            $q->where('sender_id', $userId)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($userId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(
            $messages->map(function ($m) {
                return [
                    'id' => $m->id,
                    'sender_id' => $m->sender_id,
                    'body' => $m->body,
                    'time' => $m->created_at->format('h:i A'),
                    'is_mine' => $m->sender_id === auth()->id(),
                    'is_read' => (bool) $m->is_read,
                    'is_deleted' => (bool) $m->is_deleted,
                ];
            })
        );
    }
}