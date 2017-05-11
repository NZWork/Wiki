<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [

	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [

	];

	/**
	 * 根据email获取用户信息
	 * @param $email
	 * @return array
	 */
	protected function getUserByEmail($email)
	{
		if(empty($email)){
			return [];
		}
		return User::where(['email' => $email])->first();
	}

	/**
	 * 根据id获取用户信息
	 * @param $id
	 * @return array
	 */
	protected function getUserById($id)
	{
		if(empty($id)){
			return [];
		}
		return User::where(['id' => $id])->first();
	}

	/**
	 * 账号校验
	 * @param $id
	 * @param $email
	 * @return bool
	 */
	protected function checkMiddleLogin($id, $email)
	{
		if(empty($id) || empty($email)){
			return FALSE;
		}
		$user = User::where(['id' => $id])->first();
		if($user->email === $email){
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * 用户注册
	 * @param $email
	 * @param $passwd
	 * @return array|bool
	 */
	protected function createUser($email, $passwd)
	{
		if(empty($email) || empty($passwd)){
			return FALSE;
		}
		$user = new User;
		$user->email = $email;
		$user->name = 'Tiki_' . rand(10000, 99999);
		$user->passwd = Hash::make($passwd);
		$user->status = -1;
		$user->token = self::tokenGen(32);
		if($user->save()){
			return $this->getUserByEmail($email);
		}
		return FALSE;
	}

	/**
	 * 更新用户数据
	 * @param array $data
	 * @param array $cond
	 * @return bool
	 */
	protected function updateInfo($data, $cond)
	{
		if(empty($data) || empty($cond)){
			return FALSE;
		}
		return User::where($cond)->update($data);
	}

	// 生成随机码
	private static function tokenGen($length = 128)
	{    // 默认128位
		$seed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$code = '';
		for($i = 0; $i < $length; $i++){
			$code .= $seed[mt_rand(0, 61)];
		}
		return $code;
	}
}
