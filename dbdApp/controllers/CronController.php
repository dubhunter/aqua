<?php
class CronController extends HYController {

	public function doDefault() {
		foreach (Times::toStart() as $times) {
			echo "Turning on!";
			Power::on();
			$times->setRunning(1);
			$times->save();
		}
		foreach (Times::toStop() as $times) {
			echo "Turning off!";
			Power::off();
			$times->setRunning(0);
			$times->save();
		}
	}
}
