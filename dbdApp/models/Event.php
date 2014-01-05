<?php
class Event extends dbdModel {

	const TABLE_NAME = 'events';
	const TABLE_KEY = 'event_id';
	const TABLE_FIELD_NAME = 'event_name';
	const TABLE_FIELD_DATA = 'event_data';
	const TABLE_FIELD_DATE = 'event_date';

	const EVENT_NAME_POWER = 'power';
	const EVENT_NAME_LIQUID = 'liquid';
	const EVENT_NAME_LIGHT = 'light';
	//the event name when we don't hear anything from the aquapi
	const EVENT_NAME_CRICKETS = 'crickets';
	//the event name when we try to turn on with no water
	const EVENT_NAME_DESERT = 'desert';

	/**
	 * @param null $name
	 * @param null $date_from
	 * @param null $date_to
	 * @param null $limit
	 * @param bool $ids_only
	 * @return array Event[]
	 */
	public static function getAll($name = null, $date_from = null, $date_to = null, $limit = null, $ids_only = false) {
		$keys = array();
		if ($name !== null) {
			$keys[self::TABLE_FIELD_NAME] = $name;
		}
		if ($date_from !== null && $date_to !== null) {
			$keys[self::TABLE_FIELD_DATE] = array(
				dbdDB::date($date_from),
				dbdDB::date($date_to),
				dbdDB::COMP_TYPE => dbdDB::COMP_BETWEEN,
			);
		} else {
			if ($date_from !== null) {
				$keys[self::TABLE_FIELD_DATE] = array(
					dbdDB::date($date_from),
					dbdDB::COMP_TYPE => dbdDB::COMP_GTEQ,
				);
			}
			if ($date_to !== null) {
				$keys[self::TABLE_FIELD_DATE] = array(
					dbdDB::date($date_to),
					dbdDB::COMP_TYPE => dbdDB::COMP_LT,
				);
			}
		}
		return parent::getAll($keys, "`" . self::TABLE_FIELD_DATE . "` DESC", $limit, $ids_only);
	}

	/**
	 * @param null $name
	 * @return integer
	 */
	public static function getCount($name = null) {
		$keys = array();
		if ($name !== null) {
			$keys[self::TABLE_FIELD_NAME] = $name;
		}
		return parent::getCount($keys);
	}

	/**
	 * @param null $name
	 * @return Event|null
	 */
	public static function getLast($name = null) {
		$keys = array();
		$keys[self::TABLE_FIELD_NAME] = $name !== null ? $name : array(self::EVENT_NAME_CRICKETS, dbdDB::COMP_TYPE => dbdDB::COMP_NEQ);;
		$last = parent::getAll($keys, "`" . self::TABLE_FIELD_DATE . "` DESC", 1);
		return count($last) ? $last[0] : null;
	}

	public static function create($name, $data) {
		$event = new self();
		$event->save(array(
			'event_name' => $name,
			'event_data' => $data,
		));
		return $event;
	}

	/**
	 * @param array $fields
	 */
	public function save($fields = array()) {
		HYException::hold();
		HYException::ensure(($this->hasEventName() && !isset($fields[self::TABLE_FIELD_NAME])) || !empty($fields[self::TABLE_FIELD_NAME]), HYException::EVENT_NAME);
		HYException::ensure(($this->hasEventData() && !isset($fields[self::TABLE_FIELD_DATA])) || isset($fields[self::TABLE_FIELD_DATA]), HYException::EVENT_DATA);
		HYException::release();

		if ($this->id == 0) {
			$this->setEventDate(dbdDB::date());
		}
		parent::save($fields);

		Trigger::processEvent($this);
	}
}
