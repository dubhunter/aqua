<?php
class AlertCall extends AlertTwilio {

	public static function alert(Trigger $trigger, Event $event) {
		$twilio = self::getTwilioClient();
		//make call
//		$sms = array(
//			'From' => TWILIO_NUMBER,
//			'To' => $trigger->getAlertRecipient(),
//			'Body' => sprintf($trigger->getAlertMsg(), $event->getEventData()),
//		);
//		$response = $twilio->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/SMS/Messages', 'POST', $sms);
//		return $response;
	}
}












