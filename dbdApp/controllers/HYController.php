<?php
class HYController extends dbdController {

	protected function init() {
		$this->view->left_delimiter = '<%';
		$this->view->right_delimiter = '%>';

		$this->view->addCss('hyduino.css');
		$this->view->addJs('hyduino.js');

		$this->view->config_load("errorMsgs.conf");
		HYException::setMsgArray($this->view->get_config_vars());
		$this->view->clear_config();
	}

	public function doDefault() {
		$this->setTemplate('hyduino.tpl');
	}

	public function __doAction() {
		$this->doDefault();
	}
}
