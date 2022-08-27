<?php

namespace App\Entity\Enums;

enum TokenType: int
{
    case OPEN = 0;
    case WAITING = 1;
    case PAID = 2;
    case SENT = 3;
    case RECEIVED = 4;
}