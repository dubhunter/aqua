<?php
class V1TimersController extends V1ApiController {

	public function doGet() {
		$limit = $this->genLimit();
		$timers = Timer::getAll(null, null, null, null, $limit);
		usort($timers, function ($a, $b) {
			/**
			 * @var $a Timer
			 * @var $b Timer
			 */
			if ($a->getMinutesUntilStart() == $b->getMinutesUntilStart()) {
				return 0;
			}
			return $a->getMinutesUntilStart() < $b->getMinutesUntilStart() ? -1 : 1;
		});
		$data = array();
		/** @var $t Timer */
		foreach ($timers as $t) {
			$data[] = array(
				'id' => $t->getID(),
				'start' => $t->getTimeStart(),
				'stop' => $t->getTimeStop(),
				'enabled' => $t->isEnabled(),
				'running' => $t->isRunning(),
				'minutes_until_start' => $t->getMinutesUntilStart(),
				'date_created' => dbdDB::datez($t->getDateCreated()),
				'date_updated' => dbdDB::datez($t->getDateUpdated()),
			);
		}

		$total = Timer::getCount();

		$this->dataList(array('timers' => $data), $total, '/v1/timers');
	}

	public function doPost() {
		$timer = new Timer();
		$timer->setTimeStart($this->getParam('time_start'));
		$timer->setTimeStop($this->getParam('time_stop'));
		$timer->setEnabled($this->getParam('enabled') ? 1 : 0);
		$timer->save();
		$this->data(array(
			'id' => $timer->getID(),
			'start' => $timer->getTimeStart(),
			'stop' => $timer->getTimeStop(),
			'enabled' => $timer->isEnabled(),
			'running' => $timer->isRunning(),
			'minutes_until_start' => $timer->getMinutesUntilStart(),
			'date_created' => dbdDB::datez($timer->getDateCreated()),
			'date_updated' => dbdDB::datez($timer->getDateUpdated()),
		));
	}
}
