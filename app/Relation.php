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
	const DIR_TYPE_FOLDER = 2;
	const DIR_TYPE_REPO = 3;
	const DIR_TYPE_ORG = 4;
	//protected $table = '';

	/**
	 * 获取markdown文件信息
	 * @param int $pid
	 * @param int $id
	 * @return array
	 */
	protected function get($pid = 0, $id = 0, $type = self::DIR_TYPE_REPO)
	{
		if(empty($pid) || empty($id)){
			return [];
		}
		$cond = [
			'id'     => $id,
			'out_id' => $pid,
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
	protected function checkSetStroage($pid = 0, $token = '', $type = self::DIR_TYPE_REPO)
	{
		$cond = [
			'out_id' => $pid,
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
	protected function getByProject($pid = 0, $type = self::DIR_TYPE_REPO)
	{
		$project_id = intval($pid);
		if(!$project_id){
			return [];
		}
		$cond = [
			'out_id' => $project_id,
			'type'   => $type
		];
		return $this->where($cond)->where('token', '!=', '')->get();
	}

	public function addDir($data, $type)
	{

	}
}