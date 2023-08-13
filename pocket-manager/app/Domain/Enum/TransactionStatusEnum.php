<?php

namespace App\Domain\Enum;

enum TransactionStatusEnum: int
{
    case PENDINIG = 1;
    case PROCESSING = 2;
    case FINISHED = 3;
}
