<?php

class Trigger extends dbdModel {

	const TABLE_NAME = 'triggers';
	const TABLE_KEY = 'trigger_id';
	const TABLE_FIELD_TRIGGER_NAME = 'trigger_name';
	const TABLE_FIELD_EVENT_NAME = 'event_name';
	const TABLE_FIELD_ENABLED = 'enabled';
	const TABLE_FIELD_LAST_ALERT_DATE = 'last_alert_date';
	const TABLE_FIELD_DATE_CREATED = 'date_created';
	const TABLE_FIELD_DATE_UPDATED = 'date_updated';

	const TRIGGER_TYPE_EVENT = 0;
	const TRIGGER_TYPE_DATA_EQ_VALUE = 1;
	const TRIGGER_TYPE_DATA_NEQ_VALUE = 2;
	const TRIGGER_TYPE_DATA_GT_VALUE = 3;
	const TRIGGER_TYPE_DATA_LT_VALUE = 4;

	const ALERT_TYPE_SMS = 1;
	const ALERT_TYPE_CALL = 2;
	const ALERT_TYPE_TWITTER = 3;
	const ALERT_TYPE_WEBHOOK = 4;
	const ALERT_TYPE_NOTIFYR = 5;
	const ALERT_TYPE_PUSHER = 6;
	const ALERT_TYPE_EMAIL = 7;
	const ALERT_TYPE_SPLUNK = 8;

	/**
	 * @param null $event_name
	 * @param null $enabled
	 * @param null $limit
	 * @param bool $ids_only
	 * @return array Trigger[]
	 */
	public static function getAll($event_name = null, $enabled = null, $limit = null, $ids_only = false) {
		$keys = array();
		if ($event_name !== null) {
			$keys[self::TABLE_FIELD_EVENT_NAME] = $event_name;
		}
		if ($enabled !== null) {
			$keys[self::TABLE_FIELD_ENABLED] = $enabled ? 1 : 0;
		}
		return parent::getAll($keys, "`" . self::TABLE_FIELD_LAST_ALERT_DATE . " DESC`,`" . self::TABLE_FIELD_TRIGGER_NAME . "`", $limit, $ids_only);
	}

	public static function getCount($event_name = null) {
		$keys = array();
		if ($event_name !== null) {
			$keys[self::TABLE_FIELD_EVENT_NAME] = $event_name;
		}
		return parent::getCount($keys);
	}

	public function save($fields = array()) {
//		HYException::hold();
//		HYException::ensure(($this->hasEventName() && !isset($fields[self::TABLE_FIELD_NAME])) || !empty($fields[self::TABLE_FIELD_NAME]), HYException::EVENT_NAME);
//		HYException::release();

		if ($this->id == 0) {
			$this->setEnabled(1);
			$this->setDateCreated(dbdDB::date());
		}
		$this->setDateUpdated(dbdDB::date());

		parent::save($fields);
	}

	protected function alert(Event $event) {
		if (time() - strtotime($this->getLastAlertDate()) < $this->getMaxAlertInterval()) {
			return;
		}

		switch ($this->getAlertType()) {
			case self::ALERT_TYPE_SMS:
				AlertSms::alert($this, $event);
				break;
			case self::ALERT_TYPE_CALL:
				AlertCall::alert($this, $event);
				break;
			case self::ALERT_TYPE_TWITTER:
				AlertTwitter::alert($this, $event);
				break;
			case self::ALERT_TYPE_WEBHOOK:
				AlertWebhook::alert($this, $event);
				break;
			case self::ALERT_TYPE_NOTIFYR:
				AlertNotifyr::alert($this, $event);
				break;
			case self::ALERT_TYPE_PUSHER:
				AlertPusher::alert($this, $event);
				break;
			case self::ALERT_TYPE_EMAIL:
				AlertEmail::alert($this, $event);
				break;
			case self::ALERT_TYPE_SPLUNK:
				AlertSplunk::alert($this, $event);
				break;
		}

		$this->setLastAlertDate(dbdDB::date());
		$this->save();
	}

	public static function processEvent(Event $event) {
		/** @var $trigger Trigger */
		foreach (self::getAll($event->getEventName(), true) as $trigger) {
			switch ($trigger->getTriggerType()) {
				case self::TRIGGER_TYPE_EVENT:
					$trigger->alert($event);
					break;
				case self::TRIGGER_TYPE_DATA_EQ_VALUE:
					if ($event->getEventData() == $trigger->getTriggerValue()) {
						$trigger->alert($event);
					}
					break;
				case self::TRIGGER_TYPE_DATA_NEQ_VALUE:
					if ($event->getEventData() != $trigger->getTriggerValue()) {
						$trigger->alert($event);
					}
					break;
				case self::TRIGGER_TYPE_DATA_GT_VALUE:
					if ($event->getEventData() > $trigger->getTriggerValue()) {
						$trigger->alert($event);
					}
					break;
				case self::TRIGGER_TYPE_DATA_LT_VALUE:
					if ($event->getEventData() < $trigger->getTriggerValue()) {
						$trigger->alert($event);
					}
					break;
			}
		}
	}
}