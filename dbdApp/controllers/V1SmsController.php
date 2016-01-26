<?php
class V1SmsController extends APController {

	public function doPost() {
		$body = trim(strtolower($this->getParam('Body')));

		switch ($body) {
			case 'level':
			case 'liquid':
				$this->setTemplate('twiml/water-level.tpl');
				$this->view->assign('level', Reservoir::getLevel());
				$this->view->assign('runtime', round(Reservoir::getRuntime()));
				$this->view->assign('rundays', floor(Reservoir::getRundays()));
				break;
			case 'temp':
				$this->setTemplate('twiml/temp.tpl');
				$event = Event::getLast(Event::EVENT_NAME_TEMP);
				$this->view->assign('temp', (float)$event->getEventData());
				break;
			default:
				$this->setTemplate('twiml/empty.tpl');
				$power = new Power();
				$power->setStatus(in_array($body, array('water', 'on', '1')) ? 1 : 0);
				$power->save();
				break;
		}
	}
}
