<?php
class APErrorController extends APController {

	public function doDefault() {
		dbdError::doError($this);
	}
}
