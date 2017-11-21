<?php

namespace YawningCat\CodeGeneration;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Iterator\PathFilterIterator;
use Psy\CodeCleaner\NamespaceAwarePass;
use Composer\Autoload\ClassLoader;
use function Composer\Autoload\includeFile;

class CodeGenerationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	$this->loadViewsFrom(__DIR__.'/pattern', 'YawiningCatCG/pattern');
    	$this->mergeConfigFrom(__DIR__.'/YawiningCatCG.php', 'YawiningCatCG');
    	$this->publishes([
    		__DIR__.'/YawiningCatCG.php' => config_path('YawiningCatCG.php'),
    		__DIR__.'/pattern' => base_path('resources/views/vendor/YawiningCatCG/pattern'),
    		__DIR__.'/data' => base_path('resources/views/vendor/YawiningCatCG/data'),
    	]);
    	$this->commands([
    		Commands\CGCommand::class
    	]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
