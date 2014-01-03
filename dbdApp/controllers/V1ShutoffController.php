<?php
class V1ShutoffController extends V1ApiController {
	public function doPost() {
		dbdLog($this->getParams());
		$status = Event::getLast(Event::EVENT_NAME_POWER);
		if ($status->getEventData() == 'on') {
			$power = Power::off();
			$this->data(array(
				'id' => $power->getID(),
				'status' => $power->getStatus(),
				'read' => $power->getRead(),
				'date_created' => dbdDB::datez($power->getDateCreated()),
				'date_updated' => dbdDB::datez($power->getDateUpdated()),
			));
		}
	}
}
