<?php
class Sms extends HYController {

//	const NOTIFYR_CHANNEL = 'sms';

	protected function init() {
		$this->setTemplate('twiml/empty.tpl');
	}

	public function doDefault() {
		dbdLog($this->getParams());
		$body = strtolower($this->getParam('Body'));

		$power = new Power();
		$power->setStatus(in_array($body, array('water', 'on', '1')) ? 1 : 0);
		$power->save();

//		$this->getNotifyrClient()->publish(self::NOTIFYR_CHANNEL, $this->getParam('Body'));
	}
}
