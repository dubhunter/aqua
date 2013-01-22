<?php
class HYErrorController extends HYController {

	public function doDefault() {
		dbdError::doError($this);
	}
}
