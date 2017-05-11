<!-- header -->
@include('public.header')
<!-- //header -->


<!-- container -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 m-b-10">
            <h4>x/马越大爷</h4>
        </div>
        <div class="col-xs-12 col-sm-6">
            <a href="#" class="btn btn-sm btn-default">上一层</a>
        </div>
        <div class="col-xs-12 col-sm-3 col-sm-offset-3">
            <div class="btn-group">
                <a href="#" class="btn btn-sm btn-info">新建</a>
                <a href="#" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a onclick="newDirOrFile(true)">文档</a></li>
                    <li><a onclick="newDirOrFile(false)">目录</a></li>
                </ul>
            </div>
            <div class="pull-right">
                <a href="#" class="btn btn-sm btn-default">生成 Wiki</a>
                <a href="#" class="btn btn-sm btn-default">设置</a>
            </div>
        </div>
    </div>
    <div class="row m-t-30">
        <a class="file-list" href="/edit/1/1">
            <img src="https://pbs.twimg.com/profile_images/831518614561837058/ytvJfYOx_400x400.jpg" width="64px">
            <p class="text-center"> 马越GayHub.avi </p>
        </a>
        <a class="file-list" href="#">
            <img src="images/file.png" width="64px">
            <p class="text-center">test-file</p>
        </a>
    </div>
</div>
<!-- end container -->

<!-- footer -->
@include('public.footer')
<!-- //footer -->

<script type="text/javascript">
    function newDirOrFile(isFile) {
        swal({
                title: '新建' + (isFile?'文档':'目录'),
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "命名",
                confirmButtonText: "创建",
                cancelButtonText: "取消"
            },
            function(inputValue){
                if (inputValue === false) return false;

                if (inputValue === "") {
                    swal.showInputError("You need to write something!");
                    return false
                }

                swal("Nice!", "You wrote: " + inputValue, "success");
            });
    }
</script>
