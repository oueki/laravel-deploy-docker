<?php

namespace App\Listeners;

use App\Events\BookUpdatePrice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPriceChangeNotify
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BookUpdatePrice  $event
     * @return void
     */
    public function handle(BookUpdatePrice $event)
    {
        $book_id = $event->book_id;
        Log::info('Book price change ' . $book_id);
    }


}
