<?php namespace Fooder\Http\Controllers;

use Fooder\Http\Requests;
use Fooder\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Fooder\Uber\Client;

use Fooder\Services\Directions\Directions;
use Fooder\Services\Place\Place;
use Fooder\Services\Location;

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
	public function getIndex(Request $request) {
		$directions = Directions::getDirections($request->get('origin'), $request->get('destination'));

		$candidates = array_merge(
			Place::find('fast food', $directions->getStartLocation()),
			Place::find('fast food', $directions->getEndLocation())
		);

		$stepData = [];
		foreach ($directions->getSteps() as $step) {
			$stepData[] = $step->getLine()->getPoints();
			foreach ($step->getLine()->getPoints() as $point) {
				foreach ($candidates as &$candidate) {
					$distance = $point->distanceTo($candidate->getLocation());
					if ($candidate->getScore() === null || $distance < $candidate->getScore()) {
						$candidate->setScore($distance);
					}
				}
			}
		}

		usort($candidates, function ($a, $b) {
			return ($a->getScore() < $b->getScore()) ? -1 : 1;
		});

		$response = [
			'candidates' => array_slice($candidates, 0, 20),
			'route' => $stepData
		];

		return response()->json($response);
	}

}
