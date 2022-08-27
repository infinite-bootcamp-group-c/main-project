<?php

namespace App\Entity\Enums;

enum OrderTransactionStatus: int {
    case FAILED = 0;
    case SUCCESS = 1;
    case WAITING = 2;
}