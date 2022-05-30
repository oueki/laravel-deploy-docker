<?php

namespace App\Services\Sms;

interface Sms
{
    public function send($number, $text): void;
}
