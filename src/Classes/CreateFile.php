<?php
namespace YawningCat\CodeGeneration\Classes;
use Illuminate\Filesystem\Filesystem;
class CreateFile{
	private $storage;
	public function __construct(){
		$this->storage=new Filesystem();
	}
	public function create ($path,$view,$data=array()) {
		$this->storage->put($path,$view,$data);
	}
}