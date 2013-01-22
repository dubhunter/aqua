<?php
class HYException extends dbdHoldableException
{
	const AUTH_REQ = 1001;
	const AUTH_MISMATCH = 1002;
	const USER_NOT_FOUND = 1003;
	const USER_PASS_CONFIRM_MISMATCH = 1003;

	const EVENT_NAME = 1101;
	const EVENT_DATA = 1102;

	const POWER_STATUS = 1201;

	private static $msgs = array();

	public function __construct($code = 0)
	{
		parent::__construct(self::g($code), $code);
	}

	public static function setMsgArray($msgs)
	{
		self::$msgs = is_array($msgs) ? $msgs : array();
	}

	public static function g($code)
	{
		$key = "error".$code;
		return array_key_exists($key, self::$msgs) ? self::$msgs[$key] : get_class().": Message for code ".$code." could not be found.";
	}

	public static function ensure($expr, $code)
	{
		if (!$expr)
			self::intercept(new self($code));
	}
}
