<?php
namespace App\Dto;

use App\ValueObjects\Money;

class BookDto
{
    public function __construct(
        public readonly string $isbn,
        public readonly string $title,
        public readonly Money $price,
        public readonly int $page,
        public readonly int $year,
        public readonly string $excerpt = '',
    ) {
    }
}
