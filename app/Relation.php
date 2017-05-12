<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/4/9
 * Time: 下午4:03
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
	const DIR_TYPE_USER = 1;
	const DIR_TYPE_FILE = 1;
	const DIR_TYPE_FOLDER = 2;
	const DIR_TYPE_REPO = 3;
	const DIR_TYPE_ORG = 4;

	//protected $table = '';

	/**
	 * 根据Id获取目录
	 * @param int $id
	 * @return array
	 */
	protected function getById($id = 0)
	{
		$id = intval($id);
		if(empty($id)){
			return [];
		}
		$cond = ['id' => $id];
		return $this->where($cond)->first();
	}

	/**
	 * 获取markdown文件信息
	 * @param int $pid
	 * @param int $id
	 * @return array
	 */
	protected function getToken($out_id = 0, $id = 0, $type = self::DIR_TYPE_FILE)
	{
		if(empty($out_id) || empty($id)){
			return [];
		}
		$cond = [
			'id'     => $id,
			'out_id' => $out_id,
			'type'   => $type
		];
		return $this->where($cond)->first();
	}

	/**
	 * 落盘 校验
	 * @param int    $pid
	 * @param string $token
	 * @return bool
	 */
	protected function checkSetStroage($out_id = 0, $token = '', $type = self::DIR_TYPE_REPO)
	{
		$cond = [
			'out_id' => $out_id,
			'token'  => $token,
			'type'   => $type
		];
		return (bool)$this->where($cond)->first();
	}

	/**
	 * 获取项目下所有markdown文件
	 * @param int $project_id
	 * @return array
	 */
	protected function getByProject($out_id = 0, $type = self::DIR_TYPE_REPO)
	{
		$out_id = intval($out_id);
		if(!$out_id){
			return [];
		}
		$cond = [
			'out_id' => $out_id,
			'type'   => $type
		];
		return $this->where($cond)->where('token', '!=', '')->get();
	}

	/**
	 * 添加记录
	 * @param     $data
	 * @param int $type
	 * @return array
	 */
	protected function addDir($data, $type = self::DIR_TYPE_REPO)
	{
		if(empty($data)){
			return [];
		}
		$data['type'] = $type;
		return $this->insertGetId($data);
	}

	/**
	 * 获取id
	 * @param int $out_id
	 * @param int $type
	 * @return mixed
	 */
	protected function getId($out_id = 0, $type = self::DIR_TYPE_ORG)
	{
		$cond = [
			'out_id' => $out_id,
			'type'   => $type
		];
		return $this->where($cond)->first();
	}

	/**
	 * 获取目录名称
	 * @param int $id
	 * @return array
	 */
	protected function getName($id = 0)
	{
		$id = intval($id);
		if(empty($id)){
			return [];
		}
		$cond = ['id' => $id];
		return $this->where($cond)->value('name');
	}

	/**
	 * 获取孩子们
	 * @param int $parent
	 * @return array
	 */
	protected function getChild($parent = 0)
	{
		if(!$parent){
			return [];
		}
		$cond = ['parent' => $parent];
		return $this->where($cond)->get();
	}

	protected function getByCond($cond = [])
	{
		if(empty($cond)){
			return [];
		}
		return $this->where($cond)->get();
	}
}