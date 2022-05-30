<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $book_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $book_id)
    {
        $this->book_id = $book_id;

    }


}
