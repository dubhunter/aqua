<?php
class TriggersController extends HYController {

	public function doDefault() {
		$this->noRender();
		foreach (Trigger::getAll() as $trigger) {
			print_r($trigger->getData());
		}
	}
}
