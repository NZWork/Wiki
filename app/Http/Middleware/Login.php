<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Session;

class Login
{
	/**
	 * 中间件 登入校验
	 * @param         $request
	 * @param Closure $next
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function handle($request, Closure $next)
	{
		$session = Session::get('user');
		if(isset($session->uid) && isset($session->email)){
			$res = User::checkMiddleLogin($session->uid, $session->email);
			if($res){
				return $next($request);
			}
		}
		return redirect('/login');
	}
}
