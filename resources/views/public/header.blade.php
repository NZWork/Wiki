<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Hello Tiki · Tiki Paper</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css">
    <link href="https://sindresorhus.com/github-markdown-css/github-markdown.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/bootstrap-select/2.0.0-beta1/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/editormd/css/editormd.min.css"/>

    <link rel="stylesheet" href="/css/app.css">
</head>

<body>

<!-- navbar -->
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a href="../" class="navbar-brand">Tiki</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download"><i class="fa fa-plus"
                                                                                                aria-hidden="true"></i>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="download">
                        <li><a href="/newOrg">新建组织</a></li>
                        <li><a href="/newRepo">新建项目</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">
                        <img src="https://pbs.twimg.com/profile_images/831518614561837058/ytvJfYOx_400x400.jpg"
                             class="img-rounded" width="20px" height="20px">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="download">
                        @if(isset($header))
                            <li><a href=""><b>{{$header->nickname}}</b></a></li>
                            <li class="divider"></li>
                            <li><a href="/center">个人主页</a></li>
                            <li><a href="/setting">账号设置</a></li>
                            <li><a href="https://pan.tiki.im">网盘</a></li>
                            <li><a href="http://www.baidu.com">帮助</a></li>
                            <li><a href="/logout">退出</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- end navbar -->
<div class="container" style="margin-top:64px">
@if (isset($errors))
    @foreach ($errors as $error)
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>错误！</strong> {{ $error }}
    </div>
    @endforeach
@endif
</div>
