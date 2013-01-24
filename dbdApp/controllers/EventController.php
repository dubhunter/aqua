<?php
class EventController extends HYController {

	public function doDefault() {
		dbdLog($this->getParams());
		Event::create($this->getParam('event'), $this->getParam('data'));
		$this->noRender();
	}
}
