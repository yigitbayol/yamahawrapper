<?php

namespace Yigitbayol\Yamahawrapper;

use Illuminate\Support\ServiceProvider;
use Yigitbayol\Yamahawrapper\Providers\ConfigServiceProvider;

class YamahaWrapperServiceProvider extends ServiceProvider
{
    function boot()
    {

    }

    function register()
    {
        $this->app->register(ConfigServiceProvider::class);
    }
}
