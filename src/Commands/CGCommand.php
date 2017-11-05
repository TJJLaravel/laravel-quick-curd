<?php

namespace YawningCat\CodeGeneration\Commands;

use Illuminate\Console\Command;

class CGCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "CG:start 
    {pattern : choose setted pattern} 
    {--from= : choose parameter from (table,class)} 
    {--table= : choose tablename} 
    {--class= : choose class fullpath} 
    {--namespace=App\\ }";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Code Generation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$namespaces=include base_path('vendor\composer\autoload_psr4.php');
    	$arguments = $this->arguments();
    	$options = $this->options();
        switch($options['from']) {
        	case 'table': break;
        	case 'class': break;
        }
        
        dd($namespaces[$options['namespace']]);
    }
}
