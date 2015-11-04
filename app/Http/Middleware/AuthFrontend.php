<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthFrontend {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    private $excepts = [];

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                  $petition = $request->getRequestUri();
                return redirect()->guest('user/auth/login?redirect_to=' . url($petition));
            }
        }

        return $next($request);
    }

}
