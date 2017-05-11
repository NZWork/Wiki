<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 2017/1/4
 * Time: 下午2:41
 */

namespace App\Http\Controllers;

use App\NamePool;
use Mail;
use Validator;
use App\User;
use App\UserAttr;
use App\Http\Commons\Curl;
use App\Http\Commons\Response;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

	public function index()
	{

	}

	/**
	 * Auth 登陆 API
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login()
	{
		$rules = array(
			'email'  => 'required|email|max:255',
			'passwd' => 'required|min:6',
		);
		$validator = validator(Input::get(), $rules);
		if($validator->fails()){
			$messages = $validator->messages()->first();
			return Response::json(400, [], $messages);
		}
		$email = Input::get('email');
		$passwd = Input::get('passwd');
		$user = User::getUserByEmail($email);
		if($user){   //登入验证
			if($user->status === 1){
				if(Hash::check($passwd, $user->passwd)){
					return Response::json(1200, ['id' => $user->id], '登入成功');
				}
				return Response::json(1400, [], '登陆失败');
			}
			return Response::json(1202, ['id' => $user->id], '账户未激活或已被冻结');
		}
		//注册
		$res = User::createUser($email, $passwd);
		if(!$res){
			return Response::json(1401, [], '注册失败');
		}
		UserAttr::addAttr(['out_id' => $res->id, 'nickname' => $res->name]);
		$str = "欢迎使用Tiki,请打开以下链接激活账号\n激活地址：http://tiki.im/activation?id=" .
			$res->id . "&token=" . $res->token;
		$res = Mail::raw($str, function ($message) use ($email) {
			$message->subject('激活');
			$message->to($email);
		});
		return Response::json(1201, [], '注册成功');
	}

	/**
	 * Auth 获取用户信息 API
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function userInfo()
	{
		$uid = Input::get('uid');
		$user = User::getUserById($uid);
		if(empty($user)){
			return Response::json(1403, [], '用户信息获取失败');
		}
		$nickname = UserAttr::getNickNameByUid($uid);
		return Response::json(1203, [
			'uid'        => $user['id'],
			'avatar'     => '',
			'nickname'   => $nickname,
			'email'      => $user['email'],
			'name'       => $user['name'],
			'status'     => $user['status'],
			'created_at' => $user['created_at'],
		], '用户信息');
	}

	/**
	 * 登入回调函数  用户验证
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function authCallback()
	{
		$code = Input::get('code');
		$uid = Input::get('uid');
		if(empty($code) || empty($uid)){
			//return Response::json(1404, [], '请求信息不全');
			return view('login')->with('msg', '请求信息不全');
		}
		//auth -> token获取
		$token_url = 'https://oauth.tiki.im/token?code=' . $code .
			'&client_id=test&grant_type=authorization_code&client_secret=12jh3gas623g&redirect_uri=https://tiki.im/login/callback';
		$token_info = json_decode(Curl::get($token_url));
		if(empty($token_info->access_token)){
			//return Response::json(1405, [], 'Auth token获取失败');
			return view('login')->with('msg', 'Auth token获取失败');
		}
		//token -> 用户信息获取
		$user_url = 'https://oauth.tiki.im/info?code=' . $token_info->access_token . '&uid=' . $uid;
		$user_info = json_decode(Curl::get($user_url));
		if(empty($user_info->uid)){
			//return Response::json(1406, [], 'Auth 用户信息获取失败');
			return view('login')->with('msg', 'Auth 用户信息获取失败');
		}
		Session::put('user', $user_info);
		if(Input::get('state') == 2){
			return redirect('https://pan.tiki.im');
		}
		return redirect('/center');
	}

	/**
	 * 账号激活
	 * @return $this
	 */
	public function activation()
	{
		$id = Input::get('id');
		$token = Input::get('token');
		$user = User::getUserById($id);
		if($user && $user->token == $token){
			return view('user.activation')->with([
				'title' => '激活账号',
				'msg'   => '请设置密码',
				'id'    => $id,
				'token' => $token
			]);
		}
		return view('errors.show')->with([
			'title' => '激活账号',
			'msg'   => '无效链接',
		]);
	}

	/**
	 * 设置密码
	 * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function setPasswdByToken()
	{
		$rules = array(
			'passwd' => 'required|min:6|confirmed',
		);
		$validator = validator(Input::get(), $rules);
		if($validator->fails()){
			$msg = $validator->messages()->first();
			return back()->with(['error_msg' => $msg]);
		}
		$id = Input::get('id');
		$token = Input::get('token');
		$passwd = Input::get('passwd');
		$user = User::getUserById($id);
		if($user && $token == $user->token){
			$data = [
				'status' => 1,
				'passwd' => Hash::make($passwd),
				'token'  => '',
			];
			User::updateInfo($data, ['id' => $id]);
			return redirect('login');
		}
		return view('errors.show')->with([
			'title' => '激活账号',
			'msg'   => '无效链接',
		]);
	}

	/**
	 * 设置页
	 * @return $this
	 */
	public function setting()
	{
		$user = Session::get('user');
		$info = UserAttr::getByUid($user->uid);
		$data = [
			'header'    => $user,
			'form_data' => [
				'name'     => $user->name,
				'email'    => $user->email,
				'nickname' => $info['nickname'],
				'url'      => $info['url'],
				'bio'      => $info['bio'],
				'company'  => $info['company'],
				'location' => $info['location']
			]
		];
		return view('user.setting')->with($data);
	}

	/**
	 * 用户名设置
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function NameSetting()
	{
		$user = Session::get('user');
		$name = Input::get('name');
		if($user->name !== $name){
			$res = NamePool::getByName($name);
			if(empty($res)){
				User::updateInfo(['name' => "'$name'"], ['id' => $user->uid]);
				NamePool::saveName($user->uid, $name);
				$user->name = $name;
				Session::put('user', $user);
				return redirect()->action('UserController@setting');
			}
		}
		return back()->withInput();
	}

	/**
	 * 用户信息更新
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function userSetting()
	{
		$user = Session::get('user');
		$data = [
			'nickname' => Input::get('nickname'),
			'url'      => Input::get('url'),
			'bio'      => Input::get('bio'),
			'company'  => Input::get('company'),
			'location' => Input::get('location')
		];
		UserAttr::saveInfo($data, $user->uid);
		$user->nickname = $data['nickname'];
		Session::put('user', $user);
		return redirect()->action('UserController@setting');
	}

	public function logout()
	{
		Session::flush();
		return redirect('https://tiki.im');
	}

}