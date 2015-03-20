<?php namespace Fooder\Services\Directions;

use Fooder\Services\Line;

class Step {
	private $data;

	public function __construct($data) {
		$this->data = $data;
	}

	public function getLine() {
		$points = \Polyline::Decode($this->data->polyline->points);

		return new Line(\Polyline::Pair($points));
	}

}