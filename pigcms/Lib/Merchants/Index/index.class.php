<?php
bpBase::loadAppClass('base', '', 0);
class index_controller extends base_controller {
	public function index() {
    	include $this->showTpl();
    }
	public function price() {
    	include $this->showTpl();
    }
}

?>