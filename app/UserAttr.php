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
	protected function getByUid($out_id = 0, $type = NamePool::NAME_USER_TYPE)
	{
		$out_id = intval($out_id);
		if(empty($out_id)){
			return [];
		}
		$cond = ['out_id' => $out_id, 'type' => $type];
		return $this->where($cond)->first();
	}

	/**
	 * 获取用户昵称
	 * @param int $uid
	 * @return string
	 */
	protected function getNickNameByUid($out_id = 0, $type = NamePool::NAME_USER_TYPE)
	{
		$out_id = intval($out_id);
		if(empty($out_id)){
			return '';
		}
		$cond = ['out_id' => $out_id, 'type' => $type];
		return $this->where($cond)->value('nickname');
	}

	/**
	 * 初始化用户Attr
	 * @param array $data
	 * @return array|bool
	 */
	protected function addAttr($data = [], $type = NamePool::NAME_USER_TYPE)
	{
		if(empty($data)){
			return [];
		}
		$attr = new UserAttr;
		$attr->out_id = $data['out_id'];
		$attr->nickname = $data['nickname'] ?: 'TIKI_USER';
		$attr->type = $type;
		$attr->bio = $data['bio'] ?: '';
		$attr->url = $data['url'] ?: '';
		$attr->company = $data['company'] ?: '';
		$attr->location = $data['location'] ?: '';
		return $attr->save();
	}

	/**
	 * 更新数据
	 * @param array $data
	 * @param int   $out_id
	 * @param int   $type
	 * @return array
	 */
	protected function saveInfo($data = [], $out_id = 0, $type = NamePool::NAME_USER_TYPE)
	{
		if(empty($data) || empty($out_id)){
			return [];
		}
		$cond = ['out_id' => $out_id, 'type' => $type];
		return $this->where($cond)->update($data);
	}
}