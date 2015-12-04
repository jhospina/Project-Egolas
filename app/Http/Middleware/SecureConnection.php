<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use App\System\Library\Complements\Util;

class SecureConnection {

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

        $petition = $request->getRequestUri();
       // if (!Util::isSecureConnection()) {
       //     return redirect(str_replace("http", "https", url($petition)));
       // }

        return $next($request);
    }

}
