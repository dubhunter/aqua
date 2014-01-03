<?php
class V1PowerController extends V1ApiController {

	public function doGet() {
		$event = Event::getLast(Event::EVENT_NAME_POWER);
		$this->data('status', $event ? $event->getEventData() : 'off');
	}

	public function doPost() {
		dbdLog($this->getParams());
		if ($this->getParam('status') == 'on') {
			$power = Power::on();
		} else {
			$power = Power::off();
		}
		$this->data(array(
			'id' => $power->getID(),
			'status' => $power->getStatus(),
			'read' => $power->getRead(),
			'date_created' => dbdDB::datez($power->getDateCreated()),
			'date_updated' => dbdDB::datez($power->getDateUpdated()),
		));
	}
}
