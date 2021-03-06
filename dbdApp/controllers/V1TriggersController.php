<?php
class V1TriggersController extends V1ApiController {

	public function doGet() {
		$event = $this->getParam("event");
		$limit = $this->genLimit();
		$triggers = Trigger::getAll($event, null, $limit);
		$data = array();
		foreach ($triggers as $t) {
			$data[] = array(
				'id' => $t->getID(),
				'event_name' => $t->getEventName(),
				'trigger_name' => $t->getTriggerName(),
				'trigger_type' => $t->getTriggerType(),
				'trigger_value' => $t->getTriggerValue(),
				'alert_type' => $t->getAlertType(),
				'alert_msg' => $t->getAlertMsg(),
				'alert_recipient' => $t->getAlertRecipient(),
				'enabled' => $t->isEnabled(),
				'last_alert_date' => $t->getLastAlertDate() == '0000-00-00 00:00:00' ? null : dbdDB::datez($t->getLastAlertDate()),
				'max_alert_interval' => $t->getMaxAlertInterval(),
				'date_created' => dbdDB::datez($t->getDateCreated()),
				'date_updated' => dbdDB::datez($t->getDateUpdated()),
			);
		}

		$total = Trigger::getCount($event);

		$this->dataList(array('triggers' => $data), $total, '/v1/times');
	}

	public function doPost() {
		$trigger = new Trigger();
		$trigger->setEventName($this->getParam('event_name'));
		$trigger->setTriggerName($this->getParam('trigger_name'));
		$trigger->setTriggerType($this->getParam('trigger_type'));
		$trigger->setTriggerValue($this->getParam('trigger_value'));
		$trigger->setAlertType($this->getParam('alert_type'));
		$trigger->setAlertMsg($this->getParam('alert_msg'));
		$trigger->setAlertRecipient($this->getParam('alert_recipient'));
		$trigger->setEnabled($this->getParam('enabled'));
		$trigger->setLastAlertDate('0000-00-00 00:00:00');
		$trigger->setMaxAlertInterval($this->getParam('max_alert_interval'));
		$trigger->save();
		$this->data(array(
			'id' => $trigger->getID(),
			'event_name' => $trigger->getEventName(),
			'trigger_name' => $trigger->getTriggerName(),
			'trigger_type' => $trigger->getTriggerType(),
			'trigger_value' => $trigger->getTriggerValue(),
			'alert_type' => $trigger->getAlertType(),
			'alert_msg' => $trigger->getAlertMsg(),
			'alert_recipient' => $trigger->getAlertRecipient(),
			'enabled' => $trigger->isEnabled(),
			'last_alert_date' => $trigger->getLastAlertDate() == '0000-00-00 00:00:00' ? null : dbdDB::datez($trigger->getLastAlertDate()),
			'max_alert_interval' => $trigger->getMaxAlertInterval(),
			'date_created' => dbdDB::datez($trigger->getDateCreated()),
			'date_updated' => dbdDB::datez($trigger->getDateUpdated()),
		));
	}
}
