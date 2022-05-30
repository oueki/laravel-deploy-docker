<?php

namespace App\Commands\Book\Create;

class Command
{
    public function __construct(
        public readonly string $isbn,
        public readonly string $title,
    ) {
    }
}
