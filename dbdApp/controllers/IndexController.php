<?php
class IndexController extends HYController {

	public function doDefault() {
		$this->view->assign("title", "Welcome to " . dbdMVC::getAppName() . "!");
		$this->view->assign("powerOn", $this->isPowerOn());
	}

	public function doPower() {
		dbdLog($this->getParams());
		$power = new Power();
		$power->setStatus($this->getParam('status') == 'on' ? 1 : 0);
		$power->save();
		$this->forward();
	}
}
