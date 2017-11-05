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
