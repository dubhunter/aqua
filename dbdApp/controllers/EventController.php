<?php
class EventController extends HYController {

	public function doDefault() {
		dbdLog($this->getParams());
		$event = new Event();
		$event->setEventName($this->getParam('event'));
		$event->setEventData($this->getParam('data'));
		$event->setEventDate(dbdDB::date());
		$event->save();

		$this->noRender();
	}
}
