<?php
class HYController extends dbdController {

	const TWILIO_CREDENTIALS = 'constant/twilio.inc';
	const NOTIFYR_CREDENTIALS = 'constant/notifyr.inc';

	/**
	 * @var null|TwilioRestClient
	 */
	protected $twilio_client = null;

	/**
	 * @var null|NotifyrClient
	 */
	protected $notifyr_client = null;

	protected function init() {
		$this->view->addCss('hyduino.css');
		$this->view->addJs('hyduino.js');
	}

	/**
	 * @throws dbdException
	 * @return TwilioRestClient
	 */
	protected function getTwilioClient() {
		if ($this->twilio_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('TWILIO_ACCOUNT_SID') && defined('TWILIO_AUTH_TOKEN'))) {
				dbdLoader::load(self::TWILIO_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('TWILIO_ACCOUNT_SID') && defined('TWILIO_AUTH_TOKEN'))) {
					throw new dbdException("Twilio credentials file could not be included. PATH=" . self::TWILIO_CREDENTIALS);
				}
			}
			$this->twilio_client = new TwilioRestClient(TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN);
		}
		return $this->twilio_client;
	}

	/**
	 * @throws dbdException
	 * @return NotifyrClient
	 */
	protected function getNotifyrClient() {
		if ($this->notifyr_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('NOTIFYR_KEY') && defined('NOTIFYR_SMS_PERMIT'))) {
				dbdLoader::load(self::NOTIFYR_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('NOTIFYR_KEY') && defined('NOTIFYR_SMS_PERMIT'))) {
					throw new dbdException("Notifyr credentials file could not be included. PATH=" . self::NOTIFYR_CREDENTIALS);
				}
			}
			$this->notifyr_client = new NotifyrClient(NOTIFYR_KEY, NOTIFYR_SMS_PERMIT);
		}
		return $this->notifyr_client;
	}

	protected function sendSms($to, $body) {
		$TRC = $this->getTwilioClient();
		$sms = array(
			'From' => TWILIO_NUMBER,
			'To' => $to,
			'Body' => $body
		);
		$response = $TRC->request('/' . TWILIO_VERSION . '/Accounts/' . TWILIO_ACCOUNT_SID . '/SMS/Messages', 'POST', $sms);
//		if ($response->IsError)
//			dbdLog("Error starting sending SMS: " . $response->ErrorMessage);
//		else
//			dbdLog("SMS Sent: " . $response->ResponseXml->SMSMessage->Sid);
		return $response;
	}
}
