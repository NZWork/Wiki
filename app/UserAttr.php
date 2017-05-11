<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAttr extends Model
{
	protected $table = 'users_attributes';

	/**
	 * @param int $uid
	 * @return array
	 */
	protected function getByUid($uid = 0)
	{
		$uid = intval($uid);
		if(empty($uid)){
			return [];
		}
		$cond = ['uid' => $uid];
		return $this->where($cond)->first();
	}

	/**
	 * 获取用户昵称
	 * @param int $uid
	 * @return string
	 */
	protected function getNickNameByUid($uid = 0)
	{
		$uid = intval($uid);
		if(empty($uid)){
			return '';
		}
		$cond = ['uid' => $uid];
		return $this->where($cond)->value('nickname');
	}

	/**
	 * 初始化用户Attr
	 * @param array $data
	 * @return array|bool
	 */
	protected function add($data = [])
	{
		if(empty($data)){
			return [];
		}
		$attr = new UserAttr;
		$attr->uid = $data['uid'];
		$attr->nickname = $data['nickname'] ?: 'TIKI_USER';
		return $attr->save();
	}

	/**
	 * 更新数据
	 * @param array $data
	 * @param int   $uid
	 * @return array
	 */
	protected function saveInfo($data = [], $uid = 0)
	{
		if(empty($data) || empty($uid)){
			return [];
		}
		$cond = ['uid' => $uid];
		return $this->where($cond)->update($data);
	}
}