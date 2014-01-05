<?php
class V1SmsController extends APController {

	public function doPost() {
		dbdLog($this->getParams());
		$body = trim(strtolower($this->getParam('Body')));

		if (in_array($body, array('level', 'liquid'))) {
			$this->setTemplate('twiml/water-level.tpl');
			$this->view->assign('level', Reservoir::getLevel());
			$this->view->assign('runtime', round(Reservoir::getRuntime()));
			$this->view->assign('rundays', floor(Reservoir::getRundays()));
		} else {
			$this->setTemplate('twiml/empty.tpl');
			$power = new Power();
			$power->setStatus(in_array($body, array('water', 'on', '1')) ? 1 : 0);
			$power->save();
		}
	}
}
