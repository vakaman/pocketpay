<?php

namespace App\Providers;

use App\Domain\Repository\PeopleRepositoryInterface;
use App\Domain\Service\PocketManagerServiceInterface;
use App\Infrastructure\Repository\PeopleRepository;
use App\Infrastructure\Service\PocketManagerService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(PeopleRepositoryInterface::class, PeopleRepository::class);
        $this->app->bind(PocketManagerServiceInterface::class, PocketManagerService::class);
    }
}
