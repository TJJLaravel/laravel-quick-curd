<?php

namespace YawningCat\CodeGeneration\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Debug\Tests\Fixtures\ToStringThrower;
class CGCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "YC:cg
    {pattern : choose setted pattern} 
    {--from= : choose parameter from (table,class)} 
    {--table= : choose tablename} 
    {--data= : choose class fullpath} 
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
    	$fs= new Filesystem();
    	$options = $this->options();
    	$arguments = $this->arguments();
    	$data = [];
    	// 获取模式路径
    	//$patternNamespace = config('YawiningCatCG.pattern');
    	if ($fs->exists(base_path('resources/views/vendor/YawiningCatCG/pattern'))) {
    		$patternPath = base_path('resources/views/vendor/YawiningCatCG/pattern').'/'.$arguments['pattern'];
    	} else {
    		$patternPath = base_path('vendor/yawning-cat/code-generation/src/pattern').'/'.$arguments['pattern'];
    	}
    	if (!$fs->exists($patternPath)) {
    		exit('"'.$patternPath.'" directery not exists!');
    	}
    	// 从数据模型获取数据
    	if ($fs->exists(base_path('resources/views/vendor/YawiningCatCG/data'))) {
    		$dataPath = 'resources/views/vendor/YawiningCatCG/data/';
    	} else {
    		$dataPath = 'vendor/yawning-cat/code-generation/src/data/';
    	}
    	if ($fs->exists(base_path($dataPath.$options['data'].'.php'))) {
    		$data = include base_path($dataPath.$options['data'].'.php');
    	}else{
    		exit($options['data'].'.php not exists!');
    	}
    	// 获取在册命名空间
    	$namespaces=include base_path('vendor\composer\autoload_psr4.php');
    	// 获取生成路径根级路径
    	$data['namespacePath'] = $namespaces[$data['namespace']][0];
    	// 获取文件信息
    	$files = $fs->allFiles($patternPath);
    	//$patternFiles = [];
    	foreach ($files as $f) {
    		foreach ($data['files'] as $k=>$v) {
    			if (basename($f->getRelativePathname()) === $k.".blade.php") {
    				$data['files'][$k]['tp_name'] = $f->getRelativePathname();
    				$data['files'][$k]['tp_path'] = $f->getRelativePath();
    				$data['files'][$k]['path'] = $data['namespacePath'].'\\'.str_replace(basename($f->getRelativePathname()),$v['name'].'.'.$v['ext'],$f->getRelativePathname()); // 生成文件路径
    				$data['files'][$k]['namespace'] = $data['namespace'].$f->getRelativePath(); //生成文件命名空间
    			}
    		}
    	}
    	// 获取准备生成的文件内容
    	$data['php'] = '<?php';
    	$filesContent = [];
    	foreach ($data['files'] as $f) {
    		$filesContent[] = array(
    			'path'=>$f['path'],
    			'content'=>view('YawiningCatCG/pattern::'.$arguments['pattern'].'.'.str_replace('\\','.',str_replace('.blade.php','',$f['tp_name'])),$data)
    		);
    	}
    	// 生成文件
    	foreach ($filesContent as $f) {
    		$fs->put($f['path'],$f['content']);
    	}
    }
}
