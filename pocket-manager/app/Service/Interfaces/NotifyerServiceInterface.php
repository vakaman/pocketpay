<?php

namespace App\Service\Interfaces;

use App\Domain\Entity\Financial\Transaction;
use App\Infrastructure\Http\Entity\Notification\Package;

/**
 * @see \App\Infrastructure\Service\NotifyerService
 */
interface NotifyerServiceInterface
{
    public function send(Package $package): bool;

    public function pushPackage(Package $package): bool;

    public function notificationPackage(Transaction $transaction): Package;
}
