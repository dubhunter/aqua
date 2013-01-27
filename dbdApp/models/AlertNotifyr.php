<?php
class AlertNotifyr implements TriggerAlert {

	const NOTIFYR_CREDENTIALS = 'constant/notifyr.inc';
	const NOTIFYR_CHANNEL = 'hyduino';

	/**
	 * @var null|NotifyrClient
	 */
	protected static $notifyr_client = null;

	/**
	 * @throws dbdException
	 * @return NotifyrClient
	 */
	protected static function getNotifyrClient() {
		if (self::$notifyr_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('NOTIFYR_KEY') && defined('NOTIFYR_SECRET'))) {
				dbdLoader::load(self::NOTIFYR_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('NOTIFYR_KEY') && defined('NOTIFYR_SECRET'))) {
					throw new dbdException("Notifyr credentials file could not be included. PATH=" . self::NOTIFYR_CREDENTIALS);
				}
			}
			self::$notifyr_client = new NotifyrClient(NOTIFYR_KEY, NOTIFYR_SECRET);
		}
		return self::$notifyr_client;
	}

	/**
	 * @param Trigger $trigger
	 * @param Event $event
	 */
	public static function alert(Trigger $trigger, Event $event) {
		$notifyr = self::getNotifyrClient();
		$msg = sprintf($trigger->getAlertMsg(), $event->getEventData());
		$notifyr->publish(self::NOTIFYR_CHANNEL, array(
			'event' => $event->getEventName(),
			'data' => $event->getEventData(),
			'msg' => $msg,
		));
	}
}