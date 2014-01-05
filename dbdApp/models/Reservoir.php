<?php

class Reservoir {

	const SAMPLE_DAYS = 3;
	const ACCEPTABLE_VARIANCE = 1;

	protected static $event = null;
	protected static $rpm = null;

	protected static function getRunPerMinute() {
		if (self::$rpm === null) {
			$pairs = array();
			$pair = array();

			$runs = Power::getAllForDays(self::SAMPLE_DAYS);

			foreach ($runs as $run) {
				if ($run->getStatus() == '1' && count($pair) == 0) {
					$pair[] = $run->getDateUpdated();
				} else if (count($pair)) {
					$pair[] = $run->getDateUpdated();
					$pairs[] = $pair;
					$pair = array();
				}
			}

			$rates = array();

			foreach ($pairs as $pair) {
				$events = Event::getAll(Event::EVENT_NAME_LIQUID, $pair[0], $pair[1]);

				$events = array_reverse($events);

				if (count($events) == 0) {
					continue;
				}

				$start = $events[0]->getEventData();
				$end = $events[0]->getEventData();
				$valid = true;

				foreach ($events as $event) {
					if ($event->getEventData() - $start > self::ACCEPTABLE_VARIANCE) {
						$valid = false;
					}
					if ($event->getEventData() < $end) {
						$end = $event->getEventData();
					}
				}

				if ($valid) {
					$seconds = strtotime($pair[1]) - strtotime($pair[0]);
					$rates[] = ($start - $end) / $seconds * 60;
				}
			}
			self::$rpm = array_sum($rates) / count($rates);
		}

		return self::$rpm;
	}

	protected static function timeToMinutes($time) {
		$parts = explode(':', $time);
		return $parts[1] + ($parts[0] * 60);
	}

	public static function getLevel() {
		if (self::$event === null) {
			self::$event = Event::getLast(Event::EVENT_NAME_LIQUID);
		}
		return (float)self::$event->getEventData();
	}

	public static function getRuntime() {
		return round(self::getLevel() / self::getRunPerMinute(), 2);
	}

	public static function getRundays() {
		$timers = Timer::getAll(null, null, true);

		$minutes = 0;

		foreach ($timers as $timer) {
			$minutes += self::timeToMinutes($timer->getTimeStop()) - self::timeToMinutes($timer->getTimeStart());
		}

		return round(self::getRuntime() / $minutes, 2);
	}

}