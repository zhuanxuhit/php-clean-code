<?php

namespace App\Providers;

use CleanPhp\Invoicer\Domain\Repository\CustomerRepositoryInterface;
use CleanPhp\Invoicer\Domain\Repository\OrderRepositoryInterface;
use CleanPhp\Invoicer\Persistence\Eloquent\Repository\CustomerRepository;
use CleanPhp\Invoicer\Persistence\Eloquent\Repository\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CustomerRepositoryInterface::class,
                         function($app){
                             return new CustomerRepository($app['db']);
                         });
        $this->app->bind(OrderRepositoryInterface::class,
            function($app){
                return new OrderRepository($app['db']);
            });
    }
}
