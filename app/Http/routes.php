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
		if($session && \App\User::checkMiddleLogin($session->uid, $session->email)){
			return redirect('/center');
		}
		//return view('login');
		return redirect('https://oauth.tiki.im/auth?response_type=code&redirect_uri=https://tiki.im/login/callback&client_id=test&state=1');
	});

	Route::get('/activation', 'UserController@activation');
	Route::get('/login/callback', 'UserController@authCallback');
	Route::post('/set/passwd', 'UserController@setPasswdByToken');
});


Route::group(['middleware' => ['web', 'login']], function () {
	Route::get('/logout', 'UserController@logout');
	Route::get('/center', 'TikiController@index');

	Route::get('/setting', 'UserController@setting');

	Route::get('/edit/{pid?}/{id?}', 'MarkDownController@getStroageFile');


});

Route::group(['middleware' => ['web', 'xauth']], function () {
	Route::post('/api/nz/login', 'UserController@login');
	Route::post('/api/nz/user', 'UserController@userInfo');
	Route::post('/api/nz/save', 'MarkDownController@setStroageFile');
	Route::post('/api/nz/generate', 'MarkDownController@generateWiki');
	Route::post('/api/nz/identity', 'MarkDownController@xtokenAuth');
});





//test


Route::get('/test', 'MarkDownController@index');

Route::get('/org', function (){
	return view('tiki.newOrg');
});
Route::get('/repo', function (){
	return view('tiki.newRepo');
});
Route::get('/profile', function (){
	return view('tiki.profile');
});
Route::get('/project', function (){
	return view('tiki.project');
});
Route::get('/projectSetting', function (){
	return view('tiki.projectSetting');
});
Route::get('/wiki', 'MarkDownController@getStroageFile');




