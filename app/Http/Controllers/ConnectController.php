<?php namespace Fooder\Http\Controllers;

use Fooder\Http\Requests;
use Fooder\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Pest;
use Uber\API\OAuth;

class ConnectController extends Controller {

	private $oauth;

	public function __construct() {
		$options = [
	        'clientId'     => config('uber.client_id'),
	        'clientSecret' => config('uber.secret'),
	        'redirectUri'  => url('connect/return')
	    ];
	    $this->oauth = new OAuth($options);
	    $this->oauth->setScopes(['profile', 'request']);
	}

	public function getIndex() {
		return view('connect.connect', ['url' => $this->oauth->getAuthorizationUrl()]);
	}

	public function getReturn(Request $request) {
		try {
		    $token = $this->oauth->getAccessToken('authorization_code', [
	            'code' => $request->input('code')
	        ]);
	        session(['token' => $token]);

	        return redirect('/');
		} catch(\Exception $e) {
		    return view('connect.connect', [
		    	'url' => $this->oauth->getAuthorizationUrl(),
		    	'error' => $e->getMessage()
		    ]);
		}
	}

}
