<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgMap extends Model
{
	protected $table = 'org_user_maps';

	/**
	 * 获取用户组织表
	 * @param int $uid
	 * @return array
	 */
	protected function getOrgList($uid = 0)
	{
		$uid = intval($uid);
		if(empty($uid)){
			return [];
		}
		$cond = ['uid' => $uid];
		return $this->where($cond)->orderBy('id', 'desc')->get();
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
	 * 权限验证
	 * @param $uid
	 * @param $org_id
	 * @return array
	 */
	protected function checkAuth($uid, $org_id)
	{
		$uid = intval($uid);
		$org_id = intval($org_id);
		if(empty($uid) || empty($org_id)){
			return [];
		}
		$cond = [
			'uid'     => $uid,
			'org_id' => $org_id
		];
		return $this->where($cond)->first();
	}


}