<?php
class Timer extends dbdModel {

	const TABLE_NAME = 'timers';
	const TABLE_KEY = 'timer_id';
	const TABLE_FIELD_START = 'time_start';
	const TABLE_FIELD_STOP = 'time_stop';
	const TABLE_FIELD_ENABLED = 'enabled';
	const TABLE_FIELD_RUNNING = 'running';
	const TABLE_FIELD_DATE_CREATED = 'date_created';
	const TABLE_FIELD_DATE_UPDATED = 'date_updated';

	/**
	 * @param null $time_start
	 * @param null $time_stop
	 * @param null $enabled
	 * @param null $running
	 * @param null $limit
	 * @param bool $ids_only
	 * @internal param null $read
	 * @return array Timer[]
	 */
	public static function getAll($time_start = null, $time_stop = null, $enabled = null, $running = null, $limit = null, $ids_only = false) {
		$keys = array();
		if ($time_start !== null) {
			$keys[self::TABLE_FIELD_START] = array($time_start, dbdDB::COMP_TYPE => dbdDB::COMP_LT);
		}
		if ($time_stop !== null) {
			$keys[self::TABLE_FIELD_STOP] = array($time_start, dbdDB::COMP_TYPE => dbdDB::COMP_GT);
		}
		if ($enabled !== null) {
			$keys[self::TABLE_FIELD_ENABLED] = $enabled ? 1 : 0;
		}
		if ($running !== null) {
			$keys[self::TABLE_FIELD_RUNNING] = $running ? 1 : 0;
		}
		return parent::getAll($keys, "`" . self::TABLE_FIELD_START . "`", $limit, $ids_only);
	}

	/**
	 * @param null $time_start
	 * @param null $time_stop
	 * @param null $enabled
	 * @param null $running
	 * @internal param null $read
	 * @return integer
	 */
	public static function getCount($time_start = null, $time_stop = null, $enabled = null, $running = null) {
		$keys = array();
		if ($time_start !== null) {
			$keys[self::TABLE_FIELD_START] = array($time_start, dbdDB::COMP_TYPE => dbdDB::COMP_LT);
		}
		if ($time_stop !== null) {
			$keys[self::TABLE_FIELD_STOP] = array($time_start, dbdDB::COMP_TYPE => dbdDB::COMP_GT);
		}
		if ($enabled !== null) {
			$keys[self::TABLE_FIELD_ENABLED] = $enabled ? 1 : 0;
		}
		if ($running !== null) {
			$keys[self::TABLE_FIELD_RUNNING] = $running ? 1 : 0;
		}
		return parent::getCount($keys);
	}

	public static function toStart($limit = null, $ids_only = false) {
		$keys = array();
		$keys[self::TABLE_FIELD_START] = array(date('H:i:s'), dbdDB::COMP_TYPE => dbdDB::COMP_LT);
		$keys[self::TABLE_FIELD_STOP] = array(date('H:i:s'), dbdDB::COMP_TYPE => dbdDB::COMP_GT);
		$keys[self::TABLE_FIELD_RUNNING] = 0;
		$keys[self::TABLE_FIELD_ENABLED] = 1;
		return parent::getAll($keys, "`" . self::TABLE_FIELD_START . "`", $limit, $ids_only);
	}

	public static function toStop($limit = null, $ids_only = false) {
		$keys = array();
		$keys[self::TABLE_FIELD_STOP] = array(date('H:i:s'), dbdDB::COMP_TYPE => dbdDB::COMP_LT);
		$keys[self::TABLE_FIELD_RUNNING] = 1;
		$keys[self::TABLE_FIELD_ENABLED] = 1;
		return parent::getAll($keys, "`" . self::TABLE_FIELD_START . "`", $limit, $ids_only);
	}

	/**
	 * @param array $fields
	 */
	public function save($fields = array()) {
		HYException::hold();
		HYException::ensure(($this->hasTimeStart() && !isset($fields[self::TABLE_FIELD_START])) || !empty($fields[self::TABLE_FIELD_START]), HYException::TIME_START);
		HYException::ensure(($this->hasTimeStop() && !isset($fields[self::TABLE_FIELD_STOP])) || !empty($fields[self::TABLE_FIELD_STOP]), HYException::TIME_STOP);
		HYException::release();

		if ($this->id == 0) {
			$this->setRunning(0);
			$this->setDateCreated(dbdDB::date());
		}
		$this->setDateUpdated(dbdDB::date());
		parent::save($fields);
	}

	public function getMinutesUntilStart() {
		list($hours, $minutes) = explode(':', $this->getTimeStart());
		$minutes += $hours * 60;
		$now = (date('H') * 60) + (int)date('i');
		if ($minutes < $now) {
			$minutes += 1440;
		}
		return $minutes - $now;
	}
}
