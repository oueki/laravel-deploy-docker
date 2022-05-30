<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use Illuminate\Support\Str;

class PostExample
{

    public function __construct(
        public string $title,
        public string $body,
        public string $except = '',
        public bool $published = false,
    ) {
        if (empty($title)) {
            throw new \InvalidArgumentException(
                'Title should not be empty');
        }
//        $this->stringHelper = new StringHelper();
    }

    public function publish(): void
    {
        if (empty($this->body)) {
            throw new BusinessException(
                'Cant publish post with empty body');
        }

        $this->published = true;
    }

    public function fillExcept($limit): void
    {
        $this->except = StringHelper::cut($this->body, $limit);
//        $this->except = Str::limit($this->body, $limit);

    }
}
