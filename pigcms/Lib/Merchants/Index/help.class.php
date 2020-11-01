<?php
bpBase::loadAppClass('base', '', 0);
class help_controller extends base_controller {
	public function __construct(){
		parent::__construct();
	}
	public function index() {
		$imgpath='.';
		if(!empty($this->ResourceUrl)){
			$imgpath=$this->ResourceUrl;
		}elseif(defined('ABS_UPLOAD_PATH')){
		    $imgpath='.'.ABS_UPLOAD_PATH;
		}
    	include $this->showTpl();
    }

	
}

?>