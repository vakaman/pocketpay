<?php

namespace App\Providers;

use App\Domain\Repository\PeopleRepositoryInterface;
use App\Infrastructure\Repository\PeopleRepository;
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
    }
}
