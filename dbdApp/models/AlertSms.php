<?php
class AlertSms implements TriggerAlert {

	const TWILIO_CREDENTIALS = 'constant/twilio.inc';

	/**
	 * @var null|TwilioRestClient
	 */
	protected static $twilio_client = null;

	/**
	 * @throws dbdException
	 * @return TwilioRestClient
	 */
	protected static function getTwilioClient() {
		if (self::$twilio_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('TWILIO_ACCOUNT_SID') && defined('TWILIO_AUTH_TOKEN'))) {
				dbdLoader::load(self::TWILIO_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('TWILIO_ACCOUNT_SID') && defined('TWILIO_AUTH_TOKEN'))) {
					throw new dbdException("Twilio credentials file could not be included. PATH=" . self::TWILIO_CREDENTIALS);
				}
			}
			static::$twilio_client = new TwilioRestClient(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);
		}
		return static::$twilio_client;
	}

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