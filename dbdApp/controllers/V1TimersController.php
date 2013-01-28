<?php
class V1TimersController extends V1ApiController {

	public function doGet() {
		$page = $this->getParam('page') ?: 0;
		$pagesize = $this->getParam('pagesize') ?: self::DEFAULT_PAGE_SIZE;
		$timers = Timer::getAll(null, null, null, null, ($page * $pagesize) . ',' . $pagesize);
		$data = array();
		foreach ($timers as $t) {
			$data[] = array(
				'id' => $t->getID(),
				'start' => $t->getTimeStart(),
				'stop' => $t->getTimeStop(),
				'running' => $t->isRunning(),
				'date_created' => $t->getDateCreated(),
				'date_updated' => $t->getDateUpdated(),
			);
		}

		$total = Timer::getCount();

		$this->dataList(array('timers' => $data), $total, '/v1/timers');
	}

	public function doPost() {
		dbdLog($this->getParams());
		$timer = new Timer();
		$timer->setTimeStart($this->getParam('time_start'));
		$timer->setTimeStop($this->getParam('time_stop'));
		$timer->save();
		$this->data(array(
			'id' => $timer->getID(),
			'start' => $timer->getTimeStart(),
			'stop' => $timer->getTimeStop(),
			'running' => $timer->isRunning(),
			'date_created' => $timer->getDateCreated(),
			'date_updated' => $timer->getDateUpdated(),
		));
	}
}
