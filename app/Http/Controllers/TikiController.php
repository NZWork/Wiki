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
use App\OrgMap;
use App\Project;
use App\RepoMap;
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

	/**
	 * 创建组织
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function createOrg()
	{
		$name = Input::get('name');
		$user = Session::get('user');
		$res = NamePool::getByName($name);
		if(empty($res)){
			NamePool::saveName($user->uid, $name, NamePool::NAME_ORG_TYPE);
			//添加组织表
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
				//更新拓展表
				UserAttr::addAttr($data, NamePool::NAME_ORG_TYPE);
				//维护组织用户关系表
				OrgMap::addMap(['org_id' => $res->id, 'uid' => $user->uid]);
				return redirect('/center');
			}
		}
		return back()->withInput()->withErrors(['组织名已被使用']);
	}

	/**
	 * 新建项目
	 * @return $this
	 */
	public function newRepo()
	{
		$user = Session::get('user');
		$list = OrgMap::getOrgList($user->uid);
		$orgList = [];
		foreach($list as $org){
			$orgList[] = [
				'org_id'   => $org['org_id'],
				'org_name' => Organazation::getNameById($org['org_id'])
			];
		}
		$data = [
			'orgList' => $orgList,
			'header'  => $user
		];
		return view('tiki.newRepo')->with($data);
	}

	public function createRepo()
	{
		$org_id = intval(Input::get('org_id'));
		$name = Input::get('name');
		$user = Session::get('user');
		$cond = $org_id ? ['org_id' => $org_id] : ['org_id' => $org_id, 'create_uid' => $user->uid];
		$res = Project::getRepo($cond);
		if(empty($res)){
			//创建项目记录
			$data = [
				'name'        => $name,
				'create_uid'      => $user->uid,
				'org_id'      => $org_id,
				'description' => Input::get('description'),
				'website'     => Input::get('website'),
			];
			$repo_id = Project::addRepo($data);
			//维护项目用户关系表
			RepoMap::addMap(['repo_id' => $repo_id, 'uid' => $user->uid]);
			return redirect('/center');
		}
		return back()->withInput()->withErrors(['组织（或个人）下项目名已被使用']);
	}
}