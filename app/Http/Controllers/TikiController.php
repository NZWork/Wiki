<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/1/12
 * Time: 下午7:45
 */

namespace App\Http\Controllers;


use App\User;
use App\Http\Commons\XToken;
use App\NamePool;
use App\Organazation;
use App\OrgMap;
use App\Project;
use App\Relation;
use App\RepoMap;
use App\UserAttr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class TikiController extends Controller
{

	/**
	 * 用户主页
	 * @return $this
	 */
	public function profile($name)
	{
		$profileID = $name;

		$user = Session::get('user');
		$profile = json_decode(json_encode($user), TRUE);
		$isUserProfile = TRUE;

		if($user != NULL or $user->name != $profileID){ // is not current login user
			$profile = User::getUserByName($profileID);
			if(count($profile) == 0){ // maybe organazation
				$isUserProfile = FALSE;
				$profile == Organazation::getDetailByUnique('name', $profileID);
			}
		}

		if(count($profile) == 0){ // user not found
			return view('errors.404')->withHeader($user);
		}

		if($isUserProfile){
			$profile->organazations = array();

			$orgIDList = OrgMap::getOrgList($profile->id);
			foreach($orgIDList as $org){
				$profile->organazations[] = Organazation::getDetailByUnique('id', $org->id);
			}

			$profile->projects = Project::getRepo(['create_uid' => $profile->id]);
		} else{
			$profile->projects = Project::getRepo(['org_id' => $profile->id]);
		}

		$data = [
			'header'  => $user,
			'profile' => $profile,
			'isUser'  => $isUserProfile,
		];
		return view('tiki.profile')->with($data);
	}

	/**
	 * center
	 * @return $this
	 */
	public function index()
	{
		$user = Session::get('user');
		$dir_id = Session::get('dir_id');
		$path = Session::get('path');
		if(empty($path)){
			$path = [['dir_id' => 0, 'name' => '仪表盘']];
			Session::put($path);
		}
		$dir = [];
		if(empty($dir_id)){    //根目录为组织
			$list = OrgMap::getOrgList($user->uid);
			foreach($list as $org){
				$rela = Relation::getId($org['org_id'], Relation::DIR_TYPE_ORG);
				if($rela){
					$dir[] = [
						'id'     => $rela['id'],
						'out_id' => $rela['out_id'],
						'name'   => $rela['name'],
						'type'   => $rela['type'],
						'token'  => $rela['token']
					];
				}
			}
		} else{    //根据dir_id获取目录下文件
			$list = Relation::getChild($dir_id);
			foreach($list as $rela){
				if($rela){
					$dir[] = [
						'id'     => $rela['id'],
						'out_id' => $rela['out_id'],
						'name'   => $rela['name'],
						'type'   => $rela['type'],
						'token'  => $rela['token']
					];
				}
			}
		}
		$data = [
			'header' => Session::get('user'),
			'dir'    => $dir,
			'path'   => $path,
		];
		return view('tiki.index')->with($data);
	}

	/**
	 * 打开目录
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function openDir()
	{
		$dir_id = intval(Input::get('dir_id'));
		$user = Session::get('user');
		$rela = Relation::getById($dir_id);
		if($rela['type'] == Relation::DIR_TYPE_ORG){
			$res = OrgMap::checkAuth($user->uid, $rela['out_id']);
		} else{
			$res = RepoMap::checkAuth($user->uid, $rela['out_id']);
		}
		if($rela){
			$path = Session::get('path');
			$path[] = [
				'dir_id' => $dir_id,
				'name'   => Relation::getName($dir_id)
			];
			Session::put('path', $path);
			Session::put('dir_id', $dir_id);
			return redirect('/center');
		}
		return view('errors.404');
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
				//目录关系表
				Relation::addDir([
					'out_id'     => $res->id,
					'create_uid' => $user->uid,
					'name'       => $name,
					'parent'     => 0,
				], Relation::DIR_TYPE_ORG);
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

	/**
	 * 创建项目
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function createRepo()
	{
		$org_id = intval(Input::get('org_id'));
		$name = Input::get('name');
		$user = Session::get('user');
		$cond = ['org_id' => $org_id, 'name' => $name];
		if($org_id == 0){
			$cond['create_uid'] = $user->uid;
		}
		$res = Project::getRepo($cond);
		if(empty($res)){
			$data = [
				'name'        => $name,
				'create_uid'  => $user->uid,
				'org_id'      => $org_id,
				'description' => Input::get('description'),
				'website'     => Input::get('website'),
			];
			//创建项目记录
			$repo_id = Project::addRepo($data);
			//维护项目用户关系表
			RepoMap::addMap(['repo_id' => $repo_id, 'uid' => $user->uid]);
			//目录关系表
			$rela = Relation::getId($org_id, Relation::DIR_TYPE_ORG);
			Relation::addDir([
				'out_id'     => $repo_id,
				'create_uid' => $user->uid,
				'name'       => $name,
				'parent'     => $rela->id,
			], Relation::DIR_TYPE_REPO);
			return redirect('/center');
		}
		return back()->withInput()->withErrors(['组织（或个人）下项目名已被使用']);
	}

	public function newFolder()
	{
		$user = Session::get('user');
		$id = Input::get('id');
		$name = Input::get('name');

	}

	/**
	 * 项目展示
	 * @return $this
	 */
	public function project()
	{
		$user = Session::get('user');
		$repo_id = Input::get('id');
		$data = [
			'header' => $user,
			'data'   => [

			]
		];
		return view('tiki.project')->with($data);
	}

	/**
	 * 项目管理页
	 * @return $this
	 */
	public function projectSetting()
	{
		$user = Session::get('user');
		$data = [
			'header'    => $user,
			'form_data' => [

			]
		];
		return view('tiki.projectSetting')->with($data);
	}

	/**
	 * 项目编辑
	 */
	public function repoSetting()
	{

	}

}
