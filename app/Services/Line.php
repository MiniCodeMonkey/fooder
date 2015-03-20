<?php namespace Fooder\Services;

class Line {
	private $points = [];

	public function __construct($data) {
		foreach ($data as $point) {
			if (!$point instanceof Location) {
				$this->points[] = Location::fromArray($point);
			} else {
				$this->points[] = $point;
			}
		}
	}

	public function getPoints() {
		return $this->points;
	}

}