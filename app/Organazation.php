<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organazation extends Model
{
	//protected $table = '';

	/**
	 * 根据id获取组织信息
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

	/**
	 * 增加组织
	 * @param array $data
	 * @return array|bool
	 */
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

	/**
	 * 获取组织名
	 * @param int $id
	 * @return array
	 */
	protected function getNameById($id = 0)
	{
		$id = intval($id);
		if(empty($id)){
			return [];
		}
		$cond = ['id' => $id];
		return $this->where($cond)->value('name');
	}

	public static function getDetailByUnique($key, $value)
	{
		if(empty($key) or empty($value) or $key != 'id' and $key != 'name'){
			return Object();
		}

		$org = Organazation::where([$key => $value])->first();
		$attr = UserAttr::where([
			'out_id' => $org['id'],
			'type'   => 2,
		])->first();

		$attrKeys = array('nickname', 'bio', 'url', 'company', 'location', 'avatar', 'type');
		foreach($attrKeys as $key){
			$org[$key] = $attr[$key];
		}
		return $org;
	}

}