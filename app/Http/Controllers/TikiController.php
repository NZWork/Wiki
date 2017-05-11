<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/1/12
 * Time: 下午7:45
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
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

	/**
	 * 新建组织
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function newOrg()
	{
		return view('tiki.index');
	}

	public function createOrg()
	{
		$user = Session::get('user');
		$data = [
			'name'     => Input::get('name'),
			'nickname' => Input::get('nickname'),
			'bio'      => Input::get('bio'),
			'url'      => Input::get('url'),
			'company'  => Input::get('company'),
			'location' => Input::get('location')
		];
		dd($data);
	}
}