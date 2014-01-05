<?php
class V1ReservoirController extends V1ApiController {
	public function doGet() {
		$this->data(array(
			'level' => Reservoir::getLevel(),
			'runrate' => Reservoir::getRunrate(),
			'runtime' => Reservoir::getRuntime(),
			'rundays' => Reservoir::getRundays(),
		));
	}
}
