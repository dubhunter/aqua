<?php
class V1TimersController extends V1ApiController {

	public function doGet() {
		$limit = $this->genLimit();
		$timers = Timer::getAll(null, null, null, null, $limit);
		$data = array();
		foreach ($timers as $t) {
			$data[] = array(
				'id' => $t->getID(),
				'start' => $t->getTimeStart(),
				'stop' => $t->getTimeStop(),
				'enabled' => $t->isEnabled(),
				'running' => $t->isRunning(),
				'date_created' => dbdDB::datez($t->getDateCreated()),
				'date_updated' => dbdDB::datez($t->getDateUpdated()),
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
		$timer->setEnabled($this->getParam('enabled'));
		$timer->save();
		$this->data(array(
			'id' => $timer->getID(),
			'start' => $timer->getTimeStart(),
			'stop' => $timer->getTimeStop(),
			'enabled' => $timer->isEnabled(),
			'running' => $timer->isRunning(),
			'date_created' => dbdDB::datez($timer->getDateCreated()),
			'date_updated' => dbdDB::datez($timer->getDateUpdated()),
		));
	}
}
