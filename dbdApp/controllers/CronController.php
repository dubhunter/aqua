<?php
class CronController extends HYController {

	const FIVE_MIN = 300;

	public function doDefault() {
		echo 'USAGE: dbdcli -c cron -a [timers|heartbeat]' . PHP_EOL;
	}

	public function doTimers() {
		foreach (Times::toStart() as $times) {
			echo "Turning on!" . PHP_EOL;
			Power::on();
			$times->setRunning(1);
			$times->save();
		}
		foreach (Times::toStop() as $times) {
			echo "Turning off!" . PHP_EOL;
			Power::off();
			$times->setRunning(0);
			$times->save();
		}
	}

	public function doHeartbeat() {
		$last = Event::getLast();
		$time = strtotime($last->getEventDate());
		$diff = time() - $time;
		if ($diff > self::FIVE_MIN) {
			echo "All I hear is crickets..." . PHP_EOL;
			$minutes = floor($diff / self::FIVE_MIN) * 5;
			Event::create(Event::EVENT_NAME_CRICKETS, $minutes);
		}
	}
}
