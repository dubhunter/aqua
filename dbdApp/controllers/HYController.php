<?php
class HYController extends dbdController {

	protected function init() {
		$this->view->addCss('hyduino.css');
		$this->view->addJs('hyduino.js');
	}

	protected function isPowerOn() {
		$event = Event::getLast('power');
		return $event ? $event->getEventData() == 'on' : false;
	}
}
