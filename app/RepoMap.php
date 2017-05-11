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

}