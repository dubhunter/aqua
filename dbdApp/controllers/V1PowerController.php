<?php
class V1PowerController extends V1ApiController {

	public function doGet() {
		$event = Event::getLast('power');
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
			'date_created' => $power->getDateCreated(),
			'date_updated' => $power->getDateUpdated(),
		));
	}
}