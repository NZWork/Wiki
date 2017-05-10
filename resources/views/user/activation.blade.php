Title: {{$title}}<br>
Msg: {{ empty($msg) ? '' : $msg }}<br>
@if(Session::has('error_msg'))
    EMsg: {{ Session::get('error_msg') }}<br>
@endif
Id: {{ empty($id) ? '' : $id }}<br>
Token: {{ empty($token) ? '' : $token }}<br>
<form action="/set/passwd" method="post">
    <input name="id" value="{{ empty($id) ? '' : $id }}" type="hidden">
    <input name="token" value="{{ empty($token) ? '' : $token }}" type="hidden">
    Passwd: <input type="password" name="passwd" value="">
    RePasswd: <input type="password" name="passwd_confirmation" value="">
    <button type="submit">设置密码</button>
</form>