<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    private function peerUsers()
    {
        $me = auth()->user();

        if ($me->role === 'admin') {
            return User::where('role', '!=', 'admin')->get();
        }

        if ($me->role === 'board') {
            return User::where('role', 'board')->where('id', '!=', $me->id)->get();
        }

        return User::where('role', 'employee')->where('id', '!=', $me->id)->get();
    }

    private function adminIds()
    {
        return User::where('role', 'admin')->pluck('id')->all();
    }

    public function index()
    {
        $me = auth()->user();
        $adminIds = $this->adminIds();
        $conversations = collect();

        if ($me->role !== 'admin') {
            $lastMessage = Message::where(function ($q) use ($me, $adminIds) {
                $q->where('sender_id', $me->id)->whereIn('receiver_id', $adminIds);
            })->orWhere(function ($q) use ($me, $adminIds) {
                $q->whereIn('sender_id', $adminIds)->where('receiver_id', $me->id);
            })->orderBy('created_at', 'desc')->first();

            $unread = Message::whereIn('sender_id', $adminIds)
                ->where('receiver_id', $me->id)
                ->where('is_read', false)
                ->where('is_deleted', false)
                ->count();

            $conversations->push([
                'is_admin_thread' => true,
                'user' => null,
                'last_message' => $lastMessage,
                'unread_count' => $unread,
            ]);
        }

        foreach ($this->peerUsers() as $user) {
            if ($me->role === 'admin') {
                $lastMessage = Message::where(function ($q) use ($user, $adminIds) {
                    $q->where('sender_id', $user->id)->whereIn('receiver_id', $adminIds);
                })->orWhere(function ($q) use ($user, $adminIds) {
                    $q->whereIn('sender_id', $adminIds)->where('receiver_id', $user->id);
                })->orderBy('created_at', 'desc')->first();
            } else {
                $lastMessage = Message::where(function ($q) use ($me, $user) {
                    $q->where('sender_id', $me->id)->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($me, $user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', $me->id);
                })->orderBy('created_at', 'desc')->first();
            }

            $unread = Message::where('sender_id', $user->id)
                ->where('receiver_id', $me->id)
                ->where('is_read', false)
                ->where('is_deleted', false)
                ->count();

            $conversations->push([
                'is_admin_thread' => false,
                'user' => $user,
                'last_message' => $lastMessage,
                'unread_count' => $unread,
            ]);
        }

        $conversations = $conversations->sortByDesc(function ($c) {
            return $c['last_message'] ? $c['last_message']->created_at : \Carbon\Carbon::createFromTimestamp(0);
        })->values();

        return view('messages.index', compact('conversations'));
    }

    public function showAdmin()
    {
        $me = auth()->user();
        if ($me->role === 'admin') {
            abort(404);
        }

        $adminIds = $this->adminIds();

        $messages = Message::where(function ($q) use ($me, $adminIds) {
            $q->where('sender_id', $me->id)->whereIn('receiver_id', $adminIds);
        })->orWhere(function ($q) use ($me, $adminIds) {
            $q->whereIn('sender_id', $adminIds)->where('receiver_id', $me->id);
        })->orderBy('created_at', 'asc')->get();

        Message::whereIn('sender_id', $adminIds)
            ->where('receiver_id', $me->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show-admin', compact('messages'));
    }

    public function storeAdmin(Request $request)
    {
        $me = auth()->user();
        if ($me->role === 'admin') {
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:2000']);

        $firstAdmin = User::where('role', 'admin')->first();
        if (!$firstAdmin) {
            return back()->with('error', 'No admin available.');
        }

        Message::create([
            'sender_id' => $me->id,
            'receiver_id' => $firstAdmin->id,
            'body' => $request->body,
            'is_read' => false,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('messages.admin');
    }

    public function pollAdmin()
    {
        $me = auth()->user();
        $adminIds = $this->adminIds();

        $messages = Message::where(function ($q) use ($me, $adminIds) {
            $q->where('sender_id', $me->id)->whereIn('receiver_id', $adminIds);
        })->orWhere(function ($q) use ($me, $adminIds) {
            $q->whereIn('sender_id', $adminIds)->where('receiver_id', $me->id);
        })->orderBy('created_at', 'asc')->get();

        Message::whereIn('sender_id', $adminIds)
            ->where('receiver_id', $me->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(
            $messages->map(function ($m) use ($me) {
                return [
                    'id' => $m->id,
                    'body' => $m->body,
                    'time' => $m->created_at->format('h:i A'),
                    'is_mine' => $m->sender_id === $me->id,
                    'is_read' => (bool) $m->is_read,
                    'is_deleted' => (bool) $m->is_deleted,
                ];
            })
        );
    }

    public function show(User $user)
    {
        $me = auth()->user();
        if (!$this->peerUsers()->contains('id', $user->id)) {
            abort(403);
        }

        if ($me->role === 'admin') {
            $adminIds = $this->adminIds();
            $messages = Message::where(function ($q) use ($user, $adminIds) {
                $q->where('sender_id', $user->id)->whereIn('receiver_id', $adminIds);
            })->orWhere(function ($q) use ($user, $adminIds) {
                $q->whereIn('sender_id', $adminIds)->where('receiver_id', $user->id);
            })->orderBy('created_at', 'asc')->get();
        } else {
            $messages = Message::where(function ($q) use ($me, $user) {
                $q->where('sender_id', $me->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($me, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $me->id);
            })->orderBy('created_at', 'asc')->get();
        }

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $me->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'user'));
    }

    public function store(Request $request, User $user)
    {
        $me = auth()->user();
        if (!$this->peerUsers()->contains('id', $user->id)) {
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:2000']);

        Message::create([
            'sender_id' => $me->id,
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
        $me = auth()->user();
        if (!$this->peerUsers()->contains('id', $user->id)) {
            abort(403);
        }

        if ($me->role === 'admin') {
            $adminIds = $this->adminIds();
            $messages = Message::where(function ($q) use ($user, $adminIds) {
                $q->where('sender_id', $user->id)->whereIn('receiver_id', $adminIds);
            })->orWhere(function ($q) use ($user, $adminIds) {
                $q->whereIn('sender_id', $adminIds)->where('receiver_id', $user->id);
            })->orderBy('created_at', 'asc')->get();
        } else {
            $messages = Message::where(function ($q) use ($me, $user) {
                $q->where('sender_id', $me->id)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($me, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $me->id);
            })->orderBy('created_at', 'asc')->get();
        }

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $me->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(
            $messages->map(function ($m) use ($me) {
                return [
                    'id' => $m->id,
                    'sender_id' => $m->sender_id,
                    'body' => $m->body,
                    'time' => $m->created_at->format('h:i A'),
                    'is_mine' => $m->sender_id === $me->id,
                    'is_read' => (bool) $m->is_read,
                    'is_deleted' => (bool) $m->is_deleted,
                ];
            })
        );
    }
}