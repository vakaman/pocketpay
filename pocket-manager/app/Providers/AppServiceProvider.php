<?php

namespace App\Providers;

use App\Domain\Repository\PersonRepositoryInterface;
use App\Domain\Repository\PersonServiceInterface;
use App\Domain\Repository\TransactionRepositoryInterface;
use App\Domain\Repository\WalletRepositoryInterface;
use App\Infrastructure\Repository\PersonRepository;
use App\Infrastructure\Repository\TransactionRepository;
use App\Infrastructure\Repository\WalletRepository;
use App\Infrastructure\Service\NotifyerService;
use App\Infrastructure\Service\PersonService;
use App\Service\Interfaces\NotifyerServiceInterface;
use App\Service\Interfaces\TransactionServiceInterface;
use App\Service\Interfaces\WalletServiceInterface;
use App\Service\TransactionService;
use App\Service\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(PersonServiceInterface::class, PersonService::class);

        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);

        $this->app->bind(WalletServiceInterface::class, WalletService::class);
        $this->app->bind(WalletRepositoryInterface::class, WalletRepository::class);

        $this->app->bind(NotifyerServiceInterface::class, NotifyerService::class);
    }
}
