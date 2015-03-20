<?php namespace Fooder\Services;

class Location implements \JsonSerializable {
	/**
	 * Earth radius in miles
	 * @var integer
	 */
	private $earthRadius = 3959;

	private $lat;
	private $lng;

	public function __construct($lat, $lng) {
		$this->lat = $lat;
		$this->lng = $lng;
	}

	/**
	 * Creates a new Location object from an associative or indexed array
	 * @param  array $arr
	 * @return Location
	 */
	public static function fromArray($arr) {
		$arr = (array)$arr;

		if (is_array($arr)) {
			if (isset($arr['lat']) && isset($arr['lng'])) {
				return new Location($arr['lat'], $arr['lng']);
			} elseif (count($arr) >= 2) {
				$arr = array_values($arr);
				return new Location($arr[0], $arr[1]);
			}
		}

		return [];
	}

	public function getLatitude() {
		return $this->lat;
	}

	public function getLongitude() {
		return $this->lng;
	}

	/**
	 * Calculates haversine distance between this and another location
	 * @param Location $location
	 * @return double Distance in miles
	 */
	public function distanceTo($location) {
		$deltaLatitude = deg2rad($location->getLatitude() - $this->getLatitude());
		$deltaLongitude = deg2rad($location->getLongitude() - $this->getLongitude());

		$a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) + cos(deg2rad($this->getLatitude())) * cos(deg2rad($location->getLatitude())) * sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));

		return $this->earthRadius * $c;
	}

	/**
	 * Converts to comma-separated lat/lon string
	 * @return string
	 */
	public function __toString() {
		return $this->lat . ',' . $this->lng;
	}

	public function jsonSerialize() {
		return [$this->lat, $this->lng];
	}

}