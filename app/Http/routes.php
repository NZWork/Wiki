<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('index');
});

Route::get('/test', 'TestController@index');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/login', function () {
		$session = \Illuminate\Support\Facades\Session::get('user');
		if(isset($session->uid) && \App\User::checkMiddleLogin($session->uid, $session->email)){
			return redirect('/center');
		}
		//return view('login');
		return redirect('https://oauth.tiki.im/auth?response_type=code&redirect_uri=https://tiki.im/login/callback&client_id=test&state=1');
	});

	Route::get('/activation', 'UserController@activation');
	Route::get('/login/callback', 'UserController@authCallback');
	Route::post('/set/passwd', 'UserController@setPasswdByToken');
});

/**
 * 登录中间件
 */
Route::group(['middleware' => ['web', 'login']], function () {
	Route::get('/logout', 'UserController@logout');
	Route::get('/center', 'TikiController@index');

	Route::get('/setting', 'UserController@setting');
	Route::post('/nameSetting', 'UserController@nameSetting');
	Route::post('/userSetting', 'UserController@userSetting');

	Route::get('/newOrg', 'TikiController@newOrg');
	Route::post('/createOrg', 'TikiController@createOrg');


	Route::get('/newRepo', 'TikiController@newRepo');
	Route::post('/createRepo', 'TikiController@createRepo');

	Route::get('/project', 'TikiController@project');
	Route::get('/projectSetting', 'TikiController@projectSetting');
	Route::post('/repoSetting', 'TikiController@repoSetting');

    Route::get('/edit/{pid?}/{id?}', 'MarkDownController@getStroageFile');


    Route::get('/{name}', 'TikiController@profile');
    Route::get('/{name}/{project}', 'TikiController@read');
});

/**
 * 内部接口
 */
Route::group(['middleware' => ['web', 'xauth']], function () {
	Route::post('/api/nz/login', 'UserController@login');
	Route::post('/api/nz/user', 'UserController@userInfo');
	Route::post('/api/nz/save', 'MarkDownController@setStroageFile');
	Route::post('/api/nz/generate', 'MarkDownController@generateWiki');
	Route::post('/api/nz/identity', 'MarkDownController@xtokenAuth');
});



//test
Route::get('/test', 'MarkDownController@index');
Route::get('/wiki', 'MarkDownController@getStroageFile');




