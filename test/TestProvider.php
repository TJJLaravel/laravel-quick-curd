<?php

namespace YawningCat\CodeGeneration\Test;

use Illuminate\Support\ServiceProvider;

class TestProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      echo 123;
    }
    static function test() {
    	echo 123;
    }
}
