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
                <a href="#" class="btn btn-sm btn-default">新建</a>
                <a href="#" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a onclick="newDirOrFile(true)">文档</a></li>
                    <li><a onclick="newDirOrFile(false)">目录</a></li>
                </ul>
            </div>
            @endif
            <div class="pull-right">
                @if(count($path) > 2)
                <a href="#" class="btn btn-sm btn-default">生成 Wiki</a>
                @endif
                @if(count($path) > 1)
                @if(count($path) == 2)
                <!-- 组织 -->
                <a href="/orgSetting" class="btn btn-sm btn-default">设置</a>
                <!-- 项目 -->
                @elseif(count($path) > 2)
                <a href="/projectSetting" class="btn btn-sm btn-default">设置</a>
                @endif
                @endif
            </div>
        </div>
    </div>
    <div class="row m-t-30">
        @foreach($dir as $file)
        @if($file['type'] == 1)
        <!-- 文档 -->
        <div class="file-list">
            <div class="delete">
                <svg class="icon pull-right" aria-hidden="true" onclick="deleteFile('{{ $file['id'] }}')">
                    <use xlink:href="#icon-shanchudelete31"></use>
                </svg>
            </div>
            <a target="_blank" href="/edit/{{ $file['out_id'] }}/{{ $file['id'] }}">
                <svg class="icon" aria-hidden="true" style="width: 48px; height: 48px;">
                  <use xlink:href="#icon-wenjian"></use>
                </svg>
                <p class="text-center">{{ $file['name'] }}</p>
            </a>
        </div>
        @elseif($file['type'] == 2)
        <div class="file-list">
            <div class="delete">
                <svg class="icon pull-right" aria-hidden="true" onclick="deleteFile('{{ $file['id'] }}')">
                    <use xlink:href="#icon-shanchudelete31"></use>
                </svg>
            </div>
            <a target="_blank" href="/open?dir_id={{ $file['id'] }}">
                <svg class="icon" aria-hidden="true" style="width: 48px; height: 48px;">
                  <use xlink:href="#icon-wenjianjia"></use>
                </svg>
                <p class="text-center">{{ $file['name'] }}</p>
            </a>
        </div>
        @else
        <a class="file-list" href="/open?dir_id={{ $file['id'] }}">
            <svg class="icon" aria-hidden="true" style="width: 48px; height: 48px;">
                @if($file['type'] == 3)
                <use xlink:href="#icon-project"></use>
                @elseif($file['type'] == 4)
                <use xlink:href="#icon-zuzhi_hover"></use>
                @endif
            </svg>
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
                            setTimeout("location.reload()", 500);
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

    function deleteFile(id) {
        swal({
          title: "确认删除",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "删除",
          cancelButtonText: "取消",
          closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: "POST",
                url: "/deleteFile",
                data: {
                    'id': id,
                },
                cache: false,
                success: function(data) {
                    if (data.code == 200) {
                        swal('删除成功')
                        setTimeout("location.reload()", 500);
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
