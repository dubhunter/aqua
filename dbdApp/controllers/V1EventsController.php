<?php
class V1EventsController extends V1ApiController {

	public function doGet() {
		$event = $this->getParam('event');
		$limit = $this->genLimit();
		$date_from = $this->getParam('date_from');
		$date_to = $this->getParam('date_to');
		if ($date_from || $date_to) {
			$limit = null;
		}
		$events = Event::getAll($event, $date_from, $date_to, $limit);
		$data = array();
		foreach ($events as $e) {
			$data[] = array(
				'id' => $e->getID(),
				'event' => $e->getEventName(),
				'data' => $e->getEventData(),
				'date' => dbdDB::datez($e->getEventDate()),
			);
		}

		$total = Event::getCount($event);

		$this->dataList(array('events' => $data), $total, '/v1/events');
	}

	public function doPost() {
		dbdLog($this->getParams());
		$event = Event::create($this->getParam('event'), $this->getParam('data'));
		$this->data(array(
			'id' => $event->getID(),
			'event' => $event->getEventName(),
			'data' => $event->getEventData(),
			'date' => dbdDB::datez($event->getEventDate()),
		));
	}
}
