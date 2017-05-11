<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NamePool extends Model
{
	protected $table = 'name_pool';

	const NAME_USER_TYPE = 1;
	const NAME_ORG_TYPE = 2;

	/**
	 * 获取用户名
	 * @param string $name
	 * @return array
	 */
	protected function getByName($name = '')
	{
		if(empty($name)){
			return [];
		}
		$cond = ['name' => $name];
		return $this->where($cond)->first();
	}

	/**
	 * 更新命名池数据
	 * @param int    $out_id
	 * @param string $name
	 * @param int    $type
	 * @return array
	 */
	protected function saveName($out_id = 0, $name = '', $type = self::NAME_USER_TYPE)
	{
		if(empty($out_id) || empty($name)){
			return [];
		}
		$cond = [
			'out_id' => $out_id,
			'type'   => $type
		];
		$res = $this->where($cond)->first();
		if($res){
			return $this->where(['id' => $res['id']])->update(['name' => "$name"]);
		}
		$data = [
			'name'   => $name,
			'type'   => $type,
			'out_id' => $out_id
		];
		return $this->where($cond)->insert($data);

	}

}