<?php namespace Fooder\Http\Controllers;

use Illuminate\Http\Request;

use Fooder\Uber\Client;

class RideController extends Controller {

	public function __construct()
	{
		$this->middleware('connected');
	}

	public function postIndex(Request $request)
	{
		try {
		    $client = new Client;

		    $request = $client->requestRide($request->input('product'), 38.898813, -77.039459, 38.908813, -77.039459);

		    var_dump($request);

		    var_dump($client->setRideStatus($request['request_id'], 'accepted'));
		    var_dump($client->rideDetails($request['request_id']));
		    var_dump($client->setRideStatus($request['request_id'], 'arriving'));
		    var_dump($client->rideDetails($request['request_id']));
		    var_dump($client->setRideStatus($request['request_id'], 'in_progress'));
		    var_dump($client->rideDetails($request['request_id']));

		    var_dump($client->rideMap($request['request_id']));

		} catch(Exception $e) {
		    print $e->getMessage();
		}
	}

}
