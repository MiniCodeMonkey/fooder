<?php namespace Fooder\Http\Controllers;

use Fooder\Http\Requests;
use Fooder\Http\Controllers\Controller;

use Illuminate\Http\Request;

class RouteController extends Controller {
	/**
	 * Input:
 	 * Origin, Destination
 	 * 
 	 * Output:
 	 * Route
 	 * Drive-thru's
 	 * 
 	 * Description:
 	 * Calculate route using Google Maps Directions API
 	 * Find drive-thru candidates using a couple of calls to the Yelp API
 	 * Rank drive-thru's on how close they are to the route
 	 * Give the user of drive-thru choices
	 */
	public function getIndex() {
		
	}

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
	public function postIndex() {

	}

}
