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

	/**
	 * 新建项目
	 * @param array $data
	 * @return array
	 */
	protected function addRepo($data = [])
	{
		if(empty($data)){
			return [];
		}
		return $this->insertGetId($data);
	}

	/**
	 * 更新数据
	 * @param array $data
	 * @param int   $id
	 * @return array
	 */
	protected function updateRepo($data = [], $id = 0)
	{
		$id = intval($id);
		if(empty($id) || empty($data)){
			return [];
		}
		$cond = ['id' => $id];
		return $this->where($cond)->update($data);
	}

	/**
	 * 获取项目
	 * @param $id
	 * @return array
	 */
	protected function getById($id)
	{
		$id = intval($id);
		if(empty($id)){
			return [];
		}
		$cond = ['id' => $id];
		return $this->where($cond)->first();
	}

}