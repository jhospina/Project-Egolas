<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;

class Authenticate {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    private $excepts = [
        "/manager/auth/login",
        "/manager/auth/logout",
        "/user/auth/login",
        "/user/auth/logout",
        "/user/auth/recovery",
        "/user/auth/recovery?request=send-mail&form=token",
        "/user/auth/recovery/reset/password",
        "/user/auth/recovery/reset/password/post"
    ];

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
                if (strpos($petition, "/user/") !== false && !in_array($petition, $this->excepts))
                    return redirect()->guest('user/auth/login');

                if (strpos($petition, "/manager/") !== false && !in_array($petition, $this->excepts))
                    return redirect()->guest('manager/auth/login');
            }
        }

        return $next($request);
    }

}
