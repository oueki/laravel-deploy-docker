<?php

namespace App\Services\Sms;
use Illuminate\Support\Facades\Log;


class SmsLog implements Sms
{

    public function send($number, $text): void
    {
        Log::info('number: ' . $number . ' ' . 'text ' . $text);
    }
}
