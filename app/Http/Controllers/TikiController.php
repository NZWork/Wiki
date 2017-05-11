<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/1/12
 * Time: 下午7:45
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class TikiController extends Controller
{
	public function index()
	{
		$user = Session::get('user');
		$data = [
			'user' => $user->name
		];
		return view('tiki.index')->with($data);
	}
}