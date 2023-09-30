<?php

namespace App\Events;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $_message)
    {
        $this->message = $_message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('messages.' . $this->message->receiver_id),
        ];
    }

    public function broadcastAs ()
    {
        return 'message.created';
    }

    public function broadcastWith ()
    {
        return [
            'message' => $this->message,
            'user' => auth()->user()->name,
            'user_image' => auth()->user()->profile_photo_url,
            'time' => Carbon::now()->diffForHumans()
        ];
    }
}
