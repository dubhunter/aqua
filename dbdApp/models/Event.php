<?php
class Event extends dbdModel {

	const TABLE_NAME = 'events';
	const TABLE_KEY = 'event_id';
	const TABLE_FIELD_NAME = 'event_name';
	const TABLE_FIELD_DATA = 'event_data';
	const TABLE_FIELD_DATE = 'event_date';

	/**
	 * @param null $name
	 * @param null $limit
	 * @param bool $ids_only
	 * @return array Event[]
	 */
	public static function getAll($name = null, $limit = null, $ids_only = false) {
		$keys = array();
		if ($name !== null) {
			$keys[self::TABLE_FIELD_NAME] = $name;
		}
		return parent::getAll($keys, "`" . self::TABLE_FIELD_DATE . "`", $limit, $ids_only);
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
	 * @param array $fields
	 */
	public function save($fields = array()) {
		HYException::hold();
		HYException::ensure(($this->hasEventName() && !isset($fields[self::TABLE_FIELD_NAME])) || !empty($fields[self::TABLE_FIELD_NAME]), HYException::EVENT_NAME);
		HYException::ensure(($this->hasEventData() && !isset($fields[self::TABLE_FIELD_DATA])) || !empty($fields[self::TABLE_FIELD_DATA]), HYException::EVENT_DATA);
		HYException::release();

		if ($this->id == 0) {
			$this->setEventDate(dbdDB::date());
		}
		parent::save($fields);
	}
}
