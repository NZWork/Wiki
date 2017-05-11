<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container" style="margin-top: 70px">
    <div class="row m-t-40">
        <div class="col-xs-8 col-xs-offset-2">
            <h4>ID 设置</h4>
            <div class="col-xs-9">
                <form action="/nameSetting" method="post">
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{$form_data['email']}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="name">UserName</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$form_data['name']}}">
                    </div>
                    <button type="submit" class="btn btn-sm w-md btn-success pull-right">更新</button>
                </form>
            </div>
            <div class="col-xs-3">
                <label> 头像 </label>
                <div style="height: 200px; width: 200px; max-width: 100%">
                    <img src="https://pbs.twimg.com/profile_images/831518614561837058/ytvJfYOx_400x400.jpg"
                         class="img-rounded img-responsive">
                    <form enctype="multipart/form-data">
                        <input type="file" name="avatar" id="real-file-upload" style="display:none">
                        <button type="button" onclick="$('#real-file-upload').click()"
                                class="center-block m-t-10 btn btn-sm w-md btn-default">上传新头像
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-8 col-xs-offset-2">
            <h4>用户资料</h4>
            <div class="col-xs-9">
                <form action="/userSetting" method="post">
                    <div class="form-group">
                        <label for="nickname">NickName</label>
                        <input type="text" class="form-control" id="nickname" name="nickname"
                               value="{{$form_data['nickname']}}">
                    </div>
                    <div class="form-group">
                        <label for="url">Url</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{$form_data['url']}}">
                    </div>
                    <div class="form-group">
                        <label for="bio">简介</label>
                        <textarea class="form-control" rows="3" id="bio" name="bio">{{$form_data['bio']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="url">所在公司</label>
                        <input type="text" class="form-control" id="company" name="company"
                               value="{{$form_data['company']}}">
                    </div>
                    <div class="form-group">
                        <label for="location">所在地</label>
                        <input type="text" class="form-control" id="location" name="location"
                               value="{{$form_data['location']}}">
                    </div>
                    <button type="submit" class="btn btn-sm w-md btn-success pull-right">更新</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end container -->

<!-- header -->
@include('public.footer')
<!-- //header -->
