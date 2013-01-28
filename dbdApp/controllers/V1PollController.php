<?php
class V1PollController extends V1ApiController {

	public function doGet() {
		$this->noRenderJson();

		if ($power = Power::getNext()) {
			echo 'data: "' . ($power->getStatus() ? 'on' : 'off') . '"' . PHP_EOL . PHP_EOL;
			$power->setRead(1);
			$power->save();
		}

	}
}
