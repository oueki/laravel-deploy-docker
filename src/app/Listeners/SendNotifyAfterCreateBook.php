<?php

namespace App\Listeners;

use App\Events\BookCreated;
use App\Mail\NewBook;
use App\Models\Book;
use App\Services\Sms\Sms;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotifyAfterCreateBook
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(public Sms $sms, public Mailer $mailer)
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BookCreated  $event
     * @return void
     */
    public function handle(BookCreated $event): void
    {
        $book_id = $event->book_id;

        $this->sms->send('+7999999999', 'New Book Created ' . $book_id);

        $this->mailer->send(new NewBook(Book::find($book_id)));

        Log::info('Book created ' . $book_id);
    }

}
