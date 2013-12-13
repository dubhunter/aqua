<?php
class APController extends dbdController {

	protected function init() {
		$this->view->left_delimiter = '<%';
		$this->view->right_delimiter = '%>';

		$this->view->addCss('aqua.css');
		$this->view->addJs('aqua.js');

		$this->view->config_load("errorMsgs.conf");
		HYException::setMsgArray($this->view->get_config_vars());
		$this->view->clear_config();
	}

	public function doDefault() {
		$this->setTemplate('aqua.tpl');
	}

	public function __doAction() {
		$this->doDefault();
	}
}
