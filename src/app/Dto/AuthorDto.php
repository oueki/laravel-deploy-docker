<?php

namespace App\Dto;

use App\ValueObjects\Email;
use App\ValueObjects\Name;

class AuthorDto
{
    public function __construct(
        public readonly Name $name,
        public readonly Email $email,
        public readonly string|null $biography,
    ) {
    }
}
