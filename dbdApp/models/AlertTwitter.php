<?php
class AlertTwitter implements TriggerAlert {

	const TWITTER_CREDENTIALS = 'constant/twitter.inc';

	/**
	 * @var null|Twitter
	 */
	protected static $twitter_client = null;

	/**
	 * @throws dbdException
	 * @return Twitter
	 */
	protected static function getTwitterClient() {
		if (self::$twitter_client === null) {
			// if we don't have the creds, try to load them
			if (!(defined('TWITTER_CONSUMER_KEY') && defined('TWITTER_CONSUMER_SECRET') && defined('TWITTER_ACCESS_TOKEN') && defined('TWITTER_ACCESS_TOKEN_SECRET'))) {
				dbdLoader::load(self::TWITTER_CREDENTIALS);
				// if we still don't have 'em, throw
				if (!(defined('TWITTER_CONSUMER_KEY') && defined('TWITTER_CONSUMER_SECRET') && defined('TWITTER_ACCESS_TOKEN') && defined('TWITTER_ACCESS_TOKEN_SECRET'))) {
					throw new dbdException("Twilio credentials file could not be included. PATH=" . self::TWITTER_CREDENTIALS);
				}
			}
			static::$twitter_client = new Twitter(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, TWITTER_ACCESS_TOKEN, TWITTER_ACCESS_TOKEN_SECRET);
		}
		return static::$twitter_client;
	}

	/**
	 * @param Trigger $trigger
	 * @param Event $event
	 */
	public static function alert(Trigger $trigger, Event $event) {
		$twitter = self::getTwitterClient();
		$status = sprintf($trigger->getAlertMsg(), $event->getEventData());
		if ($trigger->getAlertRecipient()) {
			$status = '.' . $trigger->getAlertRecipient() . ' ' . $status;
		}
		$twitter->post('statuses/update', array('status' => $status));
	}
}