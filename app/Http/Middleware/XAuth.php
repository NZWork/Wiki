<?php
/**
 * Created by PhpStorm.
 * User: LiuWenJie
 * Date: 2017/4/11
 * Time: 下午9:39
 */

namespace App\Http\Middleware;

use App\Http\Commons\Response;
use Closure;
use App\Def;
use Input;

class XAuth
{
	/**
	 * 内部接口身份验证
	 * @param         $request
	 * @param Closure $next
	 * @return \Illuminate\Http\JsonResponse|mixed
	 */
	public function handle($request, Closure $next)
	{
		$auth = Input::get('xauth');
		if($auth === Def::TIKI_API_XAUTH){
			return $next($request);
		}
		return Response::json(400,[],'请求来源不明');
	}
}