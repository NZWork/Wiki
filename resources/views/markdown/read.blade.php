<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Hello Tiki · Tiki Paper</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css">
    <link href="https://sindresorhus.com/github-markdown-css/github-markdown.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>

<body>

<!-- container -->
<div class="row">
    <div class="col-xs-2 sidebar">
        <a href="">Hello Tiki</a>
        <hr>
        <ul class="nav nav-sidebar">
            <li><a href="#">Introduction</a></li>
            <li>
                <a class="text-muted">注册账号</a>
                <ul class="nav sub-nav">
                    <li><a href="">Tiki 账号</a></li>
                </ul>
            </li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
        </ul>
    </div>
    <div class="col-xs-10 col-xs-offset-2">
        <div class="tiki-wrapper">
            <iframe src="tiki-content-iframe.html" id="tiki-content" width="100%" frameborder="0" onload="hideImg(this)"></iframe>
        </div>
    </div>
</div>
<!-- end container -->



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript">
    var B = document.body,
        H = document.documentElement,
        height
    if (typeof document.height !== 'undefined') {
        height = document.height // For webkit browsers
    } else {
        height = Math.max(B.scrollHeight, B.offsetHeight, H.clientHeight, H.scrollHeight, H.offsetHeight);
    }
    $('#tiki-content').height(height-32);
    document.body.style.overflow = 'hidden';
    function hideImg(i) {
        var imgs = i.contentWindow.document.getElementsByTagName('img');
        for(var i=0;i<imgs.length;i++)imgs[i].style.display='none'
    }
</script>
</body>

</html>