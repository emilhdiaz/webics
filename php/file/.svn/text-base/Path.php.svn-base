<?php
class Path extends Object {
	
	private $dir;
	
	public function __construct( $dir ) {
		parent::__construct();
		$this->dir = new DirectoryIterator($dir ? $dir : '.');
	}
	
	public function listNestedDirectories() {
		$directories = array();
		foreach ($this->dir as $fileinfo) {
    		if ($fileinfo->isDir()) {
    			if( strpos($fileinfo->getFilename(), '.') === 0) continue;
    			$dirname = $fileinfo->getPathname();
        		$directories[] = $dirname;
        		$dir = new self($dirname);
        		$dirs = $dir->listNestedDirectories();
        		$directories = array_merge($directories, $dirs);
    		}
    	}
    	return $directories;
	}
	
	public function getFiles() {
		$files = array();
		foreach ($this->dir as $fileinfo) {
    		if ($fileinfo->isFile()) {
    			if( strpos($fileinfo->getFilename(), '.') === 0) continue;
    			$fileName = $fileinfo->getFilename();
        		$files[] = new String($fileName);
    		}
    	} 
    	return $files;	
	}
}
?>