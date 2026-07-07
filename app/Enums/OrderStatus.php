<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 0;
    case PAID = 1;
    case CANCELLED = 2;
    
}
