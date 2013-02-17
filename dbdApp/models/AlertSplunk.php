<?php
class AlertSplunk implements TriggerAlert {

	const SPLUNK_CREDENTIALS = 'constant/splunk.inc';

	/**
	 * @param Trigger $trigger
	 * @param Event $event
	 * @throws dbdException
	 */
	public static function alert(Trigger $trigger, Event $event) {
		// if we don't have the creds, try to load them
		if (!(defined('SPLUNK_PROJECT_ID') && defined('SPLUNK_ACCESS_TOKEN'))) {
			dbdLoader::load(self::SPLUNK_CREDENTIALS);
			// if we still don't have 'em, throw
			if (!(defined('SPLUNK_PROJECT_ID') && defined('SPLUNK_ACCESS_TOKEN'))) {
				throw new dbdException("Splunk credentials file could not be included. PATH=" . self::SPLUNK_CREDENTIALS);
			}
		}

		$msg = sprintf($trigger->getAlertMsg(), $event->getEventData());
		$payload = date('D M d H:i:s e Y', strtotime($event->getEventDate()))
		$payload .= ' event=' . $event->getEventName();
		$payload .= ' data=' . $event->getEventData();
		$payload .= ' msg=' . $msg;
		dbdLog($payload);
		$response = Purl::post('https://api.splunkstorm.com/1/inputs/http?index=' . SPLUNK_PROJECT_ID . '&sourcetype=syslog', array(
			'headers' => array(
				'Authorization' => 'Basic ' . base64_encode('x:' . SPLUNK_ACCESS_TOKEN),
			),
			'data' => $payload,
		));
		dbdLog($response);
	}
}