<?php namespace App\Http\Middleware;

use Closure;

class ConnectedWithUber {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (!\Session::has('token')) {
			return redirect('connect');
		}
		
		return $next($request);
	}

}
