<?php
class HYException extends dbdHoldableException {

	const BAD_REQUEST = 400;
	const UNAUTHORIZED = 401;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;
	const METHOD_NOT_ALLOWED = 405;

	const EVENT_NAME = 1001;
	const EVENT_DATA = 1002;

	const POWER_STATUS = 1101;

	const TIME_START = 1201;
	const TIME_STOP = 1202;

	private static $msgs = array();

	public function __construct($code = 0) {
		parent::__construct(self::g($code), $code);
	}

	public static function setMsgArray($msgs) {
		self::$msgs = is_array($msgs) ? $msgs : array();
	}

	public static function g($code) {
		$key = "error" . $code;
		return array_key_exists($key, self::$msgs) ? self::$msgs[$key] : get_class() . ": Message for code " . $code . " could not be found.";
	}

	public static function ensure($expr, $code) {
		if (!$expr)
			self::intercept(new self($code));
	}
}
