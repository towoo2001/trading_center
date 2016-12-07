<?php
/**
 * Created by PhpStorm.
 * User: t
 * Date: 2016/12/2
 * Time: 11:15
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Logger;

class LoggerServiceProvider extends ServiceProvider{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * 在容器中注册绑定.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('logger', function ($app) {
            return Logger::getInstance();
        });
    }
}