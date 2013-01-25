<?php
class AlertCall extends AlertTwilio {

	public static function alert(Trigger $trigger, Event $event) {
		$twilio = self::getTwilioClient();
		$body = sprintf($trigger->getAlertMsg(), $event->getEventData());
		$twiml = '<?xml version="1.0" encoding="UTF-8"?><Response><Say voice="woman">' . $body . '</Say></Response>';
		//make call
		$call = array(
			'From' => TWILIO_NUMBER,
			'To' => $trigger->getAlertRecipient(),
			'Url' => 'http://twimlets.com/echo?Twiml=' . urlencode($twiml),
		);
		dbdLog($call);
		$response = $twilio->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/Calls', 'POST', $call);
		dbdLog($response);
		return $response;
	}
}












