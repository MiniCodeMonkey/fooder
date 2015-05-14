<?php namespace Fooder\Http\Controllers;

use Illuminate\Http\Request;

use Fooder\Uber\Client;

class RideController extends Controller {

	/**
	 * Input:
	 * Route id, drive-thru id, Uber user token
	 *
	 * Output:
	 * success/failure
	 *
	 * Description:
	 * Request ride with Uber
	 * Text Uber driver with drive-thru instructions
	 */
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

	public function getProducts(Request $request) {
	    try {
		    $client = new Client;

		    $profile = $client->userProfile();

		    $products = $client->products(38.898813, -77.039459); // Somewhere in DC - hardcoded for now
		    $productsList = [];
		    foreach ($products['products'] as $product) {
		    	$productsList[$product['product_id']] = $product['display_name'] . ': ' . $product['description'];
		    }
		    
		    return view('home', ['name' => $profile['first_name'], 'products' => $productsList]);

		} catch(Exception $e) {
		    print $e->getMessage();
		}
	}

}
