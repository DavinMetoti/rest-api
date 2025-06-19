<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Http\Contracts\Api\MonthlyTransactionRepositoryInterface;
use App\Http\Contracts\Api\CustomerRepositoryInterface;
use App\Http\Contracts\Api\SalesOrderRepositoryInterface;

// Repositories
use App\Http\Repositories\Api\MonthlyTransactionRepository;
use App\Http\Repositories\Api\CustomerRepository;
use App\Http\Repositories\Api\SalesOrderRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MonthlyTransactionRepositoryInterface::class, MonthlyTransactionRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(SalesOrderRepositoryInterface::class, SalesOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
