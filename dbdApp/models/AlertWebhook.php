<?php
class AlertWebhook implements TriggerAlert {

	/**
	 * @param Trigger $trigger
	 * @param Event $event
	 */
	public static function alert(Trigger $trigger, Event $event) {
		$msg = sprintf($trigger->getAlertMsg(), $event->getEventData());
		Purl::post($trigger->getAlertRecipient(), array('data' => array(
			'event' => $event->getEventName(),
			'data' => $event->getEventData(),
			'msg' => $msg,
		)));
	}
}