<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	//protected $table = '';

	/**
	 * 过滤筛选
	 * @param array $cond
	 * @return array
	 */
	protected function getRepo($cond = [])
	{
		if(empty($cond)){
			return [];
		}
		return $this->where($cond)->first();
	}

	protected function addRepo($data = [])
	{
		if(empty($data)){
			return [];
		}
		return $this->insertGetId($data);
	}

}