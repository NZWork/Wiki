<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NamePool extends Model
{
	protected $table = 'name_pool';

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
		$cond = ['name' => "'$name'"];
		return $this->where($cond)->first();
	}

	protected function saveName($out_id = 0, $name = '', $type = 1)
	{
		if(empty($uid) || empty($name)){
			return [];
		}
		$cond = [
			'out_id' => $out_id,
			'name'   => "'$name'",
			'type'   => $type
		];
		$res = $this->where($cond)->first();
		if($res){
			return $this->where(['id' => $res['id']])->update(['name' => $name]);
		}
		$data = [
			'name'   => $name,
			'type'   => $type,
			'out_id' => $out_id
		];
		return $this->where($cond)->insert($data);

	}

}