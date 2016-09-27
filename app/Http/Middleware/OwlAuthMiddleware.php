<?php namespace App\Http\Middleware;

use Closure;
use AdminAuth;
use Redirect;

class OwlAuthMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!AdminAuth::user()) {
            //App::abort(404);
            return Redirect::to('/');
        }
        return $next($request);
    }

}
