<?php namespace Fooder\Http\Controllers;

use Fooder\Uber\Client;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('connected');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
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
