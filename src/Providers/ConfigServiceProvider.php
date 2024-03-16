<?php

namespace Yigitbayol\Yamahawrapper\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Console\Events\CommandFinished;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/yamaha.php' => config_path('yamaha.php')
        ], 'yamaha-config');

        $this->publishes([
            __DIR__ . '/../Migrations' => database_path('migrations')
        ], 'yamaha-migrations');

        $this->publishes([
            __DIR__ . '/../Models' => app_path('Models')
        ], 'yamaha-models');
    }
}
