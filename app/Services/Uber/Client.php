<?php namespace Fooder\Services\Uber;

use Uber\API\Client as OriginalClient;
use Pest;

class Client extends OriginalClient {

	private $accessToken;
	
	public function __construct() {
		$adapter = new Pest('https://sandbox-api.uber.com/');

		$this->accessToken = session('token')->accessToken;

	    return parent::__construct($adapter, $this->accessToken, true);
	}

	/**
     * Return an array of HTTP headers
     * @return array
     */
    protected function getHeaders() {
        return [
        	'Accept-Language: en_US',    
			'Content-Type: application/json',
			'Authorization: Bearer ' . $this->accessToken
		];
    }

	public function requestRide($product_id, $start_latitude, $start_longitude, $end_latitude, $end_longitude) {
        $path = '/v1/requests';
        $parameters = array(
            'product_id' => $product_id,
            'start_latitude' => $start_latitude,
            'start_longitude' => $start_longitude,
            'end_latitude' => $end_latitude,
            'end_longitude' => $end_longitude,
        );
        $result = $this->adapter->post($path, json_encode($parameters), $this->getHeaders());
        return json_decode($result, true);
    }

    public function setRideStatus($request_id, $status) {
        $path = '/v1/sandbox/requests/' . $request_id;
        $parameters = array(
            'status' => $status,
        );
        $result = $this->adapter->put($path, json_encode($parameters), $this->getHeaders());
        return json_decode($result, true);
    }

    public function rideDetails($request_id) {
        $path = '/v1/requests/' . $request_id;
        $result = $this->adapter->get($path, [], $this->getHeaders());
        return json_decode($result, true);
    }

    public function rideMap($request_id) {
        $path = '/v1/requests/' . $request_id . '/map';
        $result = $this->adapter->get($path, [], $this->getHeaders());
        return json_decode($result, true);
    }

}