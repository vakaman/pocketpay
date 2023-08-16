<?php

namespace App\Jobs;

use App\Infrastructure\Http\Entity\Notification\Package;
use App\Infrastructure\Service\NotifyerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;

    public $maxExceptions = 5;

    public $timeout = 60;

    public function __construct(
        private Package $package,
    ) {
    }

    public function handle(NotifyerService $notifyerService): void
    {
        $notifyerService->pushPackage($this->package);
    }
}
