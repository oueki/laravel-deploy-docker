<?php

namespace App\Infrastructure;

use Illuminate\Contracts\Events\Dispatcher;

class LaravelMultiDispatcher implements MultiDispatcher
{

    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function multiDispatch(array $events)
    {
        foreach ($events as $event)
        {
            $this->dispatcher->dispatch($event);
        }
    }
}
