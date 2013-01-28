<?php
class V1SmsController extends HYController {

	protected function init() {
		$this->setTemplate('twiml/empty.tpl');
	}

	public function doPost() {
		dbdLog($this->getParams());
		$body = strtolower($this->getParam('Body'));

		$power = new Power();
		$power->setStatus(in_array($body, array('water', 'on', '1')) ? 1 : 0);
		$power->save();
	}
}
