<?php


namespace App\Http\Controllers;

use App\Http\Commons\Curl;
use App\Http\Commons\Response;
use App\Http\Commons\XToken;
use App\Organazation;
use App\Project;
use App\Relation;
use App\RepoMap;
use Illuminate\Support\Facades\Session;
use Input;
use App\Def;
use RedisDB;
use Controller;

class MarkDownController extends Controller
{
	public function index()
	{
	}

	/**
	 * 打开markdown编辑器
	 * @return $this
	 */
	public function getStroageFile($id = 0, $project_id = 0)
	{
		/*$id = Input::get('id');
		$project_id = Input::get('pid');*/
		$user = Session::get('user');
		$token = Relation::getToken($project_id, $id, Relation::DIR_TYPE_FILE)['token'];
		$check = RepoMap::checkAuth(isset($user->uid) ? $user->uid : 0, $project_id);
		if((empty($id) || empty($project_id) || empty($token)) || empty($check)){
			return view('errors.mdzz');
		}
		if(!RedisDB::exists(Def::REDIS_MARKDOWN_KEY . $project_id . "_$token")){
			$md = file_get_contents(Def::MARKDOWN_ROOT_PATH . "/$project_id/" . Def::MARKDOWN_TYPE_ORIGIN_PATH . "/$token");
			RedisDB::set(Def::REDIS_MARKDOWN_KEY . $project_id . "_$token", $md);
		}
		$title = Relation::getById($id);
		$xtoken = XToken::encrypt([
			'token'      => $token,
			'project_id' => $project_id,
			'uid'        => $user->uid,
			'time'       => time()
		]);
		return view('markdown.edit')->with([
			'header' => $user,
			'title'  => $title['name'],
			'xtoken' => $xtoken['token'],
			'pubkey' => $xtoken['pubkey']
		]);
	}

	/**
	 * xtoken解析
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function xtokenAuth()
	{
		$xtoken = Input::get('xtoken');
		$pubkey = Input::get('pubkey');
		$info = XToken::decrypt($xtoken, $pubkey);
		if(isset($info->time) && time() - $info->time <= Def::XTOKEN_LIFECYCLE){
			return Response::json(2204, $info, 'Xtoken 身份信息');
		}
		return Response::json(2404, [], 'XToken 无效或过期');
	}

	/**
	 * markdown文件无人操作 落盘接口
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function setStroageFile()
	{
		$project_id = Input::get('pid');
		$token = Input::get('token');
		if(empty($project_id) || empty($token)){
			return Response::json(2401, [], '参数错误');
		}
		$res = $this->_redisOp($project_id, $token);
		if($res !== FALSE){
			RedisDB::del(Def::REDIS_MARKDOWN_KEY . $project_id . "_$token");
			return Response::json(2201, [], '落盘成功');
		}
		return Response::json(2402, [], '落盘异常');
	}

	/**
	 * markdown 转换 HTML
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function generateWiki()
	{
		$project_id = Input::get('pid');
		$mds = Relation::getByProject($project_id);
		foreach($mds as $md){
			if(RedisDB::exists(Def::REDIS_MARKDOWN_KEY . $project_id . "_" . $md['token'])){
				$this->_redisOp($project_id, $md['token']);
			}
		}
		$data = [
			'repo' => $project_id,
			'auth' => Def::GENERATE_AUTH_KEY,
		];
		$result = json_decode(Curl::post(Def::GENERATE_WIKI_URL, $data));
		if(isset($result->stat) && $result->stat){
			return Response::json(2203, [], '生成请求已提交处理');
		}
		return Response::json(2403, $result, "生成请求提交异常");
	}

	public function read($org, $repo)
	{
		$orgInfo = Organazation::getByName($org);
		if(!isset($orgInfo)){
			return view('errors.mdzz');
		}
		$repoInfo = Project::getRepo(['org_id' => $orgInfo['id'], 'name' => $repo]);
		if(!isset($repoInfo)){
			return view('errors.mdzz');
		}
		$rela = Relation::getByCond(['out_id' => $repoInfo['id'], 'type' => Relation::DIR_TYPE_REPO]);
		$list = [];
		if(isset($rela[0])){
			$list = $this->_getChild($rela[0]['id']);
		}
		$data = [
			'repo'  => $repo,
			'org'   => $org,
			'title' => $repo,
			'menu'  => $list,
		];
		return view('markdown.read');
	}

	/**
	 * @param $parent
	 * @return mixed
	 */
	private function _getChild($parent)
	{
		$info = Relation::getByCond(['parent' => $parent]);
		$list = [];
		foreach($info as $item){
			if($item['type'] == Relation::DIR_TYPE_FOLDER){
				$list[] = $this->_getChild($item['id']);
			} else{
				$list[] = [
					'id'    => $item['id'],
					'name'  => $item['name'],
					'token' => $item['token']
				];
			}
		}
		return $list;
	}

	/**
	 * Redis 数据落盘
	 * @param $project_id
	 * @param $token
	 * @return int
	 */
	private function _redisOp($project_id, $token)
	{
		if(!Relation::checkSetStroage($project_id, $token, Relation::DIR_TYPE_FILE) || !RedisDB::exists(Def::REDIS_MARKDOWN_KEY . $project_id . "_$token")){
			return FALSE;
		}
		$data = RedisDB::get(Def::REDIS_MARKDOWN_KEY . $project_id . "_$token");
		$path = Def::MARKDOWN_ROOT_PATH . "/$project_id/";
		if(!is_readable($path)){
			is_file($path) or mkdir($path, 0777);
			is_file($path) or mkdir($path . Def::MARKDOWN_TYPE_ORIGIN_PATH . "/", 0777);
		}
		$md = fopen($path . Def::MARKDOWN_TYPE_ORIGIN_PATH . "/" . $token, "w+");
		$res = fwrite($md, $data);
		fclose($md);
		return $res;
	}
}