<?php
class Power extends dbdModel {

	const TABLE_NAME = 'power';
	const TABLE_KEY = 'power_id';
	const TABLE_FIELD_STATUS = 'status';
	const TABLE_FIELD_READ = 'read';
	const TABLE_FIELD_DATE_CREATED = 'date_created';
	const TABLE_FIELD_DATE_UPDATED = 'date_updated';

	/**
	 * @param null $read
	 * @param null $limit
	 * @param bool $ids_only
	 * @return array Power[]
	 */
	public static function getAll($read = null, $limit = null, $ids_only = false) {
		$keys = array();
		if ($read !== null) {
			$keys[self::TABLE_FIELD_READ] = $read ? 1 : 0;
		}
		return parent::getAll($keys, "`" . self::TABLE_FIELD_DATE_CREATED . "`", $limit, $ids_only);
	}

	/**
	 * @param null $read
	 * @return integer
	 */
	public static function getCount($read = null) {
		$keys = array();
		if ($read !== null) {
			$keys[self::TABLE_FIELD_READ] = $read ? 1 : 0;
		}
		return parent::getCount($keys);
	}

	/**
	 * @return null|Power
	 */
	public static function getNext() {
		$next = self::getAll(false, 1);
		return count($next) ? $next[0] : null;
 	}

	/**
	 * @param array $fields
	 */
	public function save($fields = array()) {
		if ($this->id == 0) {
			$this->setRead(0);
			$this->setDateCreated(dbdDB::date());
		}
		$this->setDateUpdated(dbdDB::date());
		parent::save($fields);
	}

	public function setStatus($status) {
		$this->status = $status;
	}

	public function setRead($read) {
		$this->read = $read;
	}

	public function getStatus() {
		return $this->status;
	}

	public function getRead() {
		return $this->read;
	}

	public function getDateCreated() {
		return $this->date_created;
	}

	public function getDateUpdated() {
		return $this->date_updated;
	}
}
