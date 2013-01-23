<?php
class PollController extends HYController {

	public function doDefault() {
		if ($power = Power::getNext()) {
			echo PHP_EOL . PHP_EOL . 'data: "' . ($power->getStatus() ? 'on' : 'off') . '"' . PHP_EOL . PHP_EOL;
			$power->setRead(1);
			$power->save();
		}

		$this->noRender();
	}
}
