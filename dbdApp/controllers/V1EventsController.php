<?php
class V1EventsController extends V1ApiController {

	public function doGet() {
		$event = $this->getParam("event");
		$page = $this->getParam('page') ?: 0;
		$pagesize = $this->getParam('pagesize') ?: self::DEFAULT_PAGE_SIZE;
		$events = Event::getAll($event, ($page * $pagesize) . ',' . $pagesize);
		$data = array();
		foreach ($events as $e) {
			$data[] = array(
				'id' => $e->getID(),
				'event' => $e->getEventName(),
				'data' => $e->getEventData(),
				'date' => $e->getEventDate(),
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
			'date' => $event->getEventDate(),
		));
	}
}
