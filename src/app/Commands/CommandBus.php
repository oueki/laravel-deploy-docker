<?php

namespace App\Commands;

class CommandBus
{
    public function handle($command)
    {
        $class = get_class($command) . 'Handler';
        $class = str_replace('CommandHandler', 'Handler', $class);

        $handler = app($class);
        $handler($command);
    }
}
