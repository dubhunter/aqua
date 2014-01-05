<?php
class V1ReservoirController extends V1ApiController {
	public function doGet() {
		$this->data(array(
			'level' => Reservoir::getLevel(),
			'runtime' => Reservoir::getRuntime(),
			'rundays' => Reservoir::getRundays(),
		));
	}
}
