<?php namespace Fooder\Services\Directions;

use Fooder\Services\Location;

class Directions {
	private static $baseUrl = 'https://maps.googleapis.com/maps/api/directions/json';
	private $data;

	public function __construct($data) {
		$this->data = $data;
	}

	public static function getDirections($origin, $destination) {
		$baseUrl = self::$baseUrl;
		$response = \Cache::remember('directions_' . sha1($origin . $destination), 60*24, function () use ($origin, $destination, $baseUrl) {
			$parameters = [
				'origin' => $origin,
				'destination' => $destination,
				'key' => config('google.api_key'),
				'opennow' => true
			];

			$client = new \GuzzleHttp\Client();
			$response = $client->get($baseUrl, ['query' => $parameters]);
			return json_decode($response->getBody());
		});

		return new Directions($response);
	}

	public function getPrimaryLeg() {
		return $this->data->routes[0]->legs[0];
	}

	public function getStartLocation() {
		return Location::fromArray($this->getPrimaryLeg()->start_location);
	}

	public function getEndLocation() {
		return Location::fromArray($this->getPrimaryLeg()->end_location);
	}

	public function getSteps() {
		$steps = [];
		foreach ($this->getPrimaryLeg()->steps as $step) {
			$steps[] = new Step($step);
		}

		return $steps;
	}

}