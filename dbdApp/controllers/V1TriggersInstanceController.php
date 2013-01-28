<?php
class V1TriggersInstanceController extends V1ApiController {

	public function doGet() {
		$trigger = new Trigger($this->getParam('id'));
		$this->data(array(
			'id' => $trigger->getID(),
			'event_name' => $trigger->getEventName(),
			'trigger_name' => $trigger->getTriggerName(),
			'trigger_type' => $trigger->getTriggerType(),
			'trigger_value' => $trigger->getTriggerValue(),
			'alert_type' => $trigger->getAlertType(),
			'alert_msg' => $trigger->getAlertMsg(),
			'alert_recipient' => $trigger->getAlertRecipient(),
			'enabled' => $trigger->getEnabled(),
			'last_alert_date' => $trigger->getLastAlertDate(),
			'max_alert_interval' => $trigger->getMaxAlertInterval(),
			'date_created' => $trigger->getDateCreated(),
			'date_updated' => $trigger->getDateUpdated(),
		));
	}

	public function doPost() {
		dbdLog($this->getParams());
		$trigger = new Trigger($this->getParam('id'));
		$trigger->setEventName($this->getParam('event_name'));
		$trigger->setTriggerName($this->getParam('trigger_name'));
		$trigger->setTriggerType($this->getParam('trigger_type'));
		$trigger->setTriggerValue($this->getParam('trigger_value'));
		$trigger->setAlertType($this->getParam('alert_type'));
		$trigger->setAlertMsg($this->getParam('alert_msg'));
		$trigger->setAlertRecipient($this->getParam('alert_recipient'));
		$trigger->setEnabled($this->getParam('enabled'));
		$trigger->setLastAlertDate($this->getParam('last_alert_date'));
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
			'enabled' => $trigger->getEnabled(),
			'last_alert_date' => $trigger->getLastAlertDate(),
			'max_alert_interval' => $trigger->getMaxAlertInterval(),
			'date_created' => $trigger->getDateCreated(),
			'date_updated' => $trigger->getDateUpdated(),
		));
	}
}
