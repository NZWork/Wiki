<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepoMap extends Model
{
	protected $table = 'repo_user_maps';

	/**
	 * 获取用户项目表
	 * @param int $uid
	 * @return array
	 */
	protected function getRepoList($uid = 0)
	{
		$uid = intval($uid);
		if(empty($uid)){
			return [];
		}
		$cond = ['uid' => $uid];
		return $this->where($cond)->orderBy('id', 'asc')->get();
	}

	/**
	 * 添加关系
	 * @param array $data
	 * @return array
	 */
	protected function addMap($data = [])
	{
		if(empty($data)){
			return [];
		}
		return $this->insert($data);
	}

	/**
	 * 验证项目编辑权限
	 * @param $uid
	 * @param $repo_id
	 * @return array
	 */
	protected function checkAuth($uid, $repo_id)
	{
		$uid = intval($uid);
		$repo_id = intval($repo_id);
		if(empty($uid) || empty($repo_id)){
			return [];
		}
		$cond = [
			'uid'     => $uid,
			'repo_id' => $repo_id
		];
		return $this->where($cond)->first();
	}

}