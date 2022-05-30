<?php

namespace App\Enums;

enum OrderStatus: int
{
    case CREATED = 0;
    case COMPLETED = 1;
}
