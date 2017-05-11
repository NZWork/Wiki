<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organazation extends Model
{
	//protected $table = '';

	/**
	 * 根据名称获取组织
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

	protected function addOrg($data = [])
	{
		if(empty($data)){
			return [];
		}
		$org = new Organazation;
		$org->name = $data['name'];
		$org->create_uid = $data['create_uid'];
		if($org->save()){
			return $this->getByName($data['name']);
		}
		return FALSE;
	}

}