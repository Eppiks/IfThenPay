<?php namespace Eppiks\IfThenPay;

use Illuminate\Support\ServiceProvider;

class IfThenPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Publishes package config file to applications config folder
        $this->publishes([__DIR__ . '/config/ifthenpay.php' => config_path('ifthenpay.php')], 'config');
        //Publishes package migration files to applications databas/migrations folder
        $this->publishes([__DIR__ . '/database/migrations/' => database_path('migrations')], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Let Laravel Ioc Container know about our Controller
        $this->app->make('Eppiks\IfThenPay\IfThenPayController');
    }
}