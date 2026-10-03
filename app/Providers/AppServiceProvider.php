<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Message;
use App\Models\LeaveRequest;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            if (auth()->check()) {
                $unreadCount = Message::where('receiver_id', auth()->id())
                    ->where('is_read', false)
                    ->where('is_deleted', false)
                    ->count();
                $view->with('unreadMessageCount', $unreadCount);

                if (auth()->user()->role === 'admin') {
                    $pendingLeaveCount = LeaveRequest::where('status', 'pending')->count();
                    $view->with('pendingLeaveCount', $pendingLeaveCount);
                }
            }
        });
    }
}