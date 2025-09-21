<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SupplierRepositoryInterface;
use App\Repositories\SupplierRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
