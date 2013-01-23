<?php
class PollController extends HYController {

	public function doDefault() {
		if ($power = Power::getNext()) {
			echo 'data: "' . ($power->getStatus() ? 'on' : 'off') . '"';
			$power->setRead(1);
			$power->save();
		}

		$this->noRender();
	}
}
