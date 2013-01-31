<?php
class V1EventsInstanceController extends V1ApiController {

	public function doGet() {
		$event = new Event($this->getParam('id'));
		$this->data(array(
			'id' => $event->getID(),
			'event' => $event->getEventName(),
			'data' => $event->getEventData(),
			'date' => dbdDB::datez($event->getEventDate()),
		));
	}
}
