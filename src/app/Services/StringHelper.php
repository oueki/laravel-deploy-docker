<?php

namespace App\Services;

class StringHelper
{
    public static function cut(string $source, int $limit): string
    {
        $len = strlen($source);

        if($len <= $limit) {
            return $source;
        }

        return substr($source, 0, $limit-3) . '...';
    }
}
