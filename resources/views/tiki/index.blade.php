<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <ol class="breadcrumb" style="background-color: transparent">
               @foreach($path as $p)
               <li><a href="/open?dir_id={{ $p['dir_id'] }}">{{ $p['name'] }}</a></li>
               @endforeach
            </ol>
        </div>
        <div class="col-xs-12 col-sm-3 col-sm-offset-3">
            @if(count($path)  > 2)
            <div class="btn-group">
                <a href="#" class="btn btn-sm btn-info">新建</a>
                <a href="#" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a onclick="newDirOrFile(true)">文档</a></li>
                    <li><a onclick="newDirOrFile(false)">目录</a></li>
                </ul>
            </div>
            @endif
            <div class="pull-right">
                <a href="#" class="btn btn-sm btn-default">生成 Wiki</a>
                <a href="#" class="btn btn-sm btn-default">设置</a>
            </div>
        </div>
    </div>
    <div class="row m-t-30">
        @foreach($dir as $file)
        @if($file['type'] == 1)
        <!-- 文档 -->
        <a class="file-list" href="/edit/{{ $file['id'] }}/{{ $file['out_id'] }}" data-type="{{ $file['type'] }}">
            <img src="https://pbs.twimg.com/profile_images/831518614561837058/ytvJfYOx_400x400.jpg" width="64px">
            <p class="text-center">{{ $file['name'] }}</p>
        </a>
        @else
        <a class="file-list" href="/open?dir_id={{ $file['id'] }}" data-type="{{ $file['type'] }}">
            <img src="https://pbs.twimg.com/profile_images/831518614561837058/ytvJfYOx_400x400.jpg" width="64px">
            <p class="text-center">{{ $file['name'] }}</p>
        </a>
        @endif
        @endforeach
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
                    swal.showInputError("命名不可为空");
                    return false
                }

                $.ajax({
                    type: "POST",
                    url: "/newFile",
                    data: {
                        name: inputValue,
                        type: isFile ? 1 : 2
                    },
                    cache: false,
                    success: function(data) {
                        if (data.code == 200) {
                            swal('创建成功')
                            setTimeout("location.reload()", 1000);
                        } else {
                            // 提示删除失败
                            swal.showInputError(data.msg)
                        }
                    },
                    error: function() {
                        swal.showInputError('网络异常')
                    }
                });
            });
    }
</script>
