<?php
class V1TimersInstanceController extends V1ApiController {

	public function doGet() {
		$timer = new Timer($this->getParam('id'));
		$this->data(array(
			'id' => $timer->getID(),
			'start' => $timer->getTimeStart(),
			'stop' => $timer->getTimeStop(),
			'running' => $timer->isRunning(),
			'date_created' => $timer->getDateCreated(),
			'date_updated' => $timer->getDateUpdated(),
		));
	}

	public function doPost() {
		dbdLog($this->getParams());
		$timer = new Timer($this->getParam('id'));
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
