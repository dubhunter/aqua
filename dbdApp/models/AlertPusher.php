<?php
class AlertPusher implements TriggerAlert {

	const PUSHER_CREDENTIALS = 'constant/pusher.inc';
	const PUSHER_CHANNEL = 'hyduino';
	const PUSHER_EVENT = 'event';

	/**
	 * @var null|Pusher
	 */
	protected static $pusher_client = null;

	/**
	 * @throws dbdException
	 * @return Pusher
	 */
	protected static function getPusherClient() {
		if (self::$pusher_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('PUSHER_APP_ID') && defined('PUSHER_KEY') && defined('PUSHER_SECRET'))) {
				dbdLoader::load(self::PUSHER_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('PUSHER_APP_ID') && defined('PUSHER_KEY') && defined('PUSHER_SECRET'))) {
					throw new dbdException("Pusher credentials file could not be included. PATH=" . self::PUSHER_CREDENTIALS);
				}
			}
			self::$pusher_client = new Pusher(PUSHER_KEY, PUSHER_SECRET, PUSHER_APP_ID);
		}
		return self::$pusher_client;
	}

	/**
	 * @param Trigger $trigger
	 * @param Event $event
	 */
	public static function alert(Trigger $trigger, Event $event) {
		$pusher = self::getPusherClient();
		$msg = sprintf($trigger->getAlertMsg(), $event->getEventData());
		$pusher->trigger(self::PUSHER_CHANNEL, self::PUSHER_EVENT, array(
			'event' => $event->getEventName(),
			'data' => $event->getEventData(),
			'msg' => $msg,
		));
	}
}