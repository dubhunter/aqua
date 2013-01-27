<?php
class AlertCall extends AlertTwilio {

	public static function alert(Trigger $trigger, Event $event) {
		$twilio = self::getTwilioClient();
		$body = sprintf($trigger->getAlertMsg(), $event->getEventData());
		$twiml = '<Response><Say voice="woman">' . $body . '</Say></Response>';
		//make call
		$call = array(
			'From' => TWILIO_NUMBER,
			'To' => $trigger->getAlertRecipient(),
			'Url' => 'http://twimlets.com/echo?Twiml=' . urlencode($twiml),
		);
		$response = $twilio->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/Calls', 'POST', $call);
		return $response;
	}
}












