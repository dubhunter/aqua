<?php
class V1EventsSummaryController extends V1ApiController {

	public function doGet() {
		$event = $this->getParam('event');
		$limit = $this->genLimit();
		$date_from = $this->getParam('date_from');
		$date_to = $this->getParam('date_to');
		if ($date_from || $date_to) {
			$limit = null;
		}

		$events = Event::getAll($event, $date_from, $date_to, $limit);
		$count = count($events);

		dbdLog($count);

		$downsample = $this->getParam('downsample');
		if (!$downsample) {
			$downsample = 1;
		}
		$step_count = 0;
		$sum = 0;
		$sum_count = 0;
		$start = $count ? strtotime($events[$count - 1]->getEventDate()) : time();

		$data = array();
		for ($i = $count - 1; $i >= 0; $i--) {
			dbdLog($i);
			$value = $events[$i]->getEventData();
			$date = strtotime($events[$i]->getEventDate());
			dbdLog($value);
			dbdLog($date);
			if (!is_numeric($value)) {
				continue;
			}
			$sum += $value;
			$sum_count++;
			if ($date > ($start + ($downsample * $step_count) + $downsample) || $i = 0) {
				$data[] = array(
					'data' => round($sum / $sum_count),
					'date' => dbdDB::datez($start + ($downsample * $step_count)),
				);
				$sum = 0;
				$sum_count = 0;
				$step_count++;
			}
		}

		$total = Event::getCount($event);

		$this->dataList(array('events' => $data), $total, '/v1/events/summary');
	}
}
