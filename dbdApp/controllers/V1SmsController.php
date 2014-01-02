<?php
class V1SmsController extends APController {

	protected function init() {
		$this->setTemplate('twiml/empty.tpl');
	}

	public function doPost() {
		dbdLog($this->getParams());
		$body = strtolower($this->getParam('Body'));

		if (in_array($body, array('level', 'liquid'))) {
			$this->setTemplate('twiml/water-level.tpl');
			$level = Event::getLast('liquid');
			$this->view->assign('level', $level->getData());
		} else {
			$this->setTemplate('twiml/empty.tpl');
			$power = new Power();
			$power->setStatus(in_array($body, array('water', 'on', '1')) ? 1 : 0);
			$power->save();
		}
	}
}
