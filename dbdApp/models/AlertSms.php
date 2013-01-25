<?php
class AlertSms extends AlertTwilio {

	/**
	 * @param Trigger $trigger
	 * @param Event $event
	 * @return TwilioRestResponse
	 */
	public static function alert(Trigger $trigger, Event $event) {
		$twilio = self::getTwilioClient();
		$sms = array(
			'From' => TWILIO_NUMBER,
			'To' => $trigger->getAlertRecipient(),
			'Body' => sprintf($trigger->getAlertMsg(), $event->getEventData()),
		);
		$response = $twilio->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/SMS/Messages', 'POST', $sms);
		return $response;
	}
}