<?php namespace Fooder\Services\Place;

use Fooder\Services\Location;

class Place implements \JsonSerializable {
	private static $radarSearchUrl = 'https://maps.googleapis.com/maps/api/place/radarsearch/json';
	private static $detailsUrl = 'https://maps.googleapis.com/maps/api/place/details/json';
	private $data;
	private $score = null;
	private $details = null;

	public function __construct($data) {
		$this->data = $data;
	}

	public static function find($keyword, $location, $radius = 50000) {
		$radarSearchUrl = self::$radarSearchUrl;
		$response = \Cache::remember('place_' . sha1($keyword . (string)$location . $radius), 60*24, function () use ($keyword, $location, $radius, $radarSearchUrl) {
			$parameters = [
				'keyword' => $keyword,
				'location' => (string)$location,
				'radius' => $radius,
				'key' => config('google.api_key')
			];

			$client = new \GuzzleHttp\Client();
			$response = $client->get($radarSearchUrl, ['query' => $parameters]);
			return json_decode($response->getBody());
		});

		$places = [];
		foreach ($response->results as $place) {
			$places[$place->id] = new Place($place);
		}

		return $places;
	}

	public function getLocation() {
		return Location::fromArray($this->data->geometry->location);
	}

	public function setScore($score) {
		$this->score = $score;
	}

	public function getScore() {
		return $this->score;
	}

	public function details($placeid) {
		if ($this->details === null) {
			$detailsUrl = self::$detailsUrl;
			$response = \Cache::remember('place_details_' . sha1($placeid), 60*24, function () use ($placeid, $detailsUrl) {
				$parameters = [
					'placeid' => $placeid,
					'key' => config('google.api_key')
				];

				$client = new \GuzzleHttp\Client();
				$response = $client->get($detailsUrl, ['query' => $parameters]);
				return json_decode($response->getBody());
			});

			$this->details = $response->result;
		}

		return $this->details;
	}

	public function jsonSerialize() {
		return [
			'score' => $this->getScore(),
			'place' => $this->details($this->data->place_id)
		];
	}

}