<?php

namespace Udara\LaravelAuth\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $notifications = auth()->check()
            ? auth()->user()->unreadNotifications()->orderBy('created_at', 'desc')->take(3)->get()
            : collect();

        return view('layouts.app', compact('notifications'));
    }
}
