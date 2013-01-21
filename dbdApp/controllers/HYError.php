<?php
class HYError extends HYController
{
	public function doDefault()
	{
		dbdError::doError($this);
	}
}
