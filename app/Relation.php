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
    //protected $table = '';

    /**
     * 获取markdown文件信息
     * @param int $pid
     * @param int $id
     * @return array
     */
    protected function get($pid = 0, $id = 0)
    {
        if(empty($pid) || empty($id)){
            return [];
        }
        $cond = [
            'id' => $id,
            'project_id' => $pid,
        ];
        return $this->where($cond)->first();
    }

    /**
     * 落盘 校验
     * @param int $pid
     * @param string $token
     * @return bool
     */
    protected function checkSetStroage($pid = 0 , $token = '')
    {
        $cond = [
            'project_id' => $pid,
            'token' => $token,
        ];
        return (bool)$this->where($cond)->first();
    }

    /**
     * 获取项目下所有markdown文件
     * @param int $project_id
     * @return array
     */
    protected function getByProject($project_id = 0)
    {
        $project_id = intval($project_id);
        if(!$project_id){
            return [];
        }
        $cond = [
            'project_id' => $project_id,
        ];
        return $this->where($cond)->where('token','!=','')->get();
    }
}