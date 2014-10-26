<?php
class V1PollAckController extends V1ApiController {
	public function doPost() {
		if ($power = Power::getNext()) {
			$power->setRead(1);
			$power->save();
		}
	}
}
