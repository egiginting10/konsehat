<?php

namespace App\Providers;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $unreadChatCount = 0;

            if (Auth::check() && Auth::user()->dokterDetail) {
                $unreadChatCount = ChatMessage::where('receiver_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            }

            $view->with('unreadChatCount', $unreadChatCount);
        });
    }
}
