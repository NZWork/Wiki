<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/1/12
 * Time: 下午7:45
 */

namespace App\Http\Controllers;

use App\NamePool;
use App\Organazation;
use App\UserAttr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TikiController extends Controller
{
	public function index()
	{
		$user = Session::get('user');
		$data = [
			'header' => Session::get('user'),
		];
		return view('tiki.index')->with($data);
	}

	/**
	 * 新建组织
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function newOrg()
	{
		$data = [
			'header' => Session::get('user'),
		];
		return view('tiki.newOrg')->with($data);
	}

	public function createOrg()
	{
		$name = Input::get('name');
		$user = Session::get('user');
		$res = NamePool::getByName($name);
		if(empty($res)){
			NamePool::saveName($user->uid, $name, NamePool::NAME_ORG_TYPE);
			$res = Organazation::addOrg(['name' => $name, 'create_uid' => $user->uid]);
			if($res->id){
				$data = [
					'out_id'   => $res->id,
					'nickname' => Input::get('nickname'),
					'bio'      => Input::get('bio'),
					'url'      => Input::get('url'),
					'company'  => Input::get('company'),
					'location' => Input::get('location'),
				];
				UserAttr::addAttr($data, NamePool::NAME_ORG_TYPE);
				return redirect('/center');
			}
		}
		return back()->withInput()->withErrors(['组织名已被使用']);
	}
}