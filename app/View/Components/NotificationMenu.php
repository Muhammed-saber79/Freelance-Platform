<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class NotificationMenu extends Component
{
    public $notifications;
    public $new = 0;
    /**
     * Create a new component instance.
     */
    public function __construct(public $count = 10)
    {
        $user = Auth::guard('web')->user();
        $this->notifications = $user->notifications()->take($this->count)->get();
        
        $this->new = $user->unreadNotifications->count();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification-menu');
    }
}
