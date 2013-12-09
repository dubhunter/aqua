<?php
class V1PollController extends V1ApiController {

	public function doGet() {

		if ($power = Power::getNext()) {
			$this->data(array(
				'power' => ($power->getStatus() ? 'on' : 'off'),
			));
			$power->setRead(1);
			$power->save();
		}

	}
}
