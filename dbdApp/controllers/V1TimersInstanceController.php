<?php
class V1TimersInstanceController extends V1ApiController {

	public function doGet() {
		$timer = new Timer($this->getParam('id'));
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

	public function doPost() {
		$timer = new Timer($this->getParam('id'));
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
			'minutes_until_start' => $timer->getMinutesUntilStart(),
			'date_created' => dbdDB::datez($timer->getDateCreated()),
			'date_updated' => dbdDB::datez($timer->getDateUpdated()),
		));
	}

	public function doDelete() {
		$timer = new Timer($this->getParam('id'));
		$timer->delete();
		$this->noRenderJson();
	}
}
