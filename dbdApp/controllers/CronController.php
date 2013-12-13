<?php
class CronController extends APController {

	const FIVE_MIN = 300;

	public function doDefault() {
		echo 'USAGE: dbdcli -c cron -a [timers|heartbeat]' . PHP_EOL;
	}

	public function doTimers() {
		foreach (Timer::toStart() as $timer) {
			echo "Turning on!" . PHP_EOL;
			Power::on();
			$timer->setRunning(1);
			$timer->save();
		}
		foreach (Timer::toStop() as $timer) {
			echo "Turning off!" . PHP_EOL;
			Power::off();
			$timer->setRunning(0);
			$timer->save();
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
