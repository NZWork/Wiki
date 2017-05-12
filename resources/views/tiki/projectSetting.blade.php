<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container">
    <div class="row m-t-40">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <h3>{{ $title }}</h3>
            <div class="form-group">
                <div class="col-xs-12 col-sm-11">
                    <label for="project-description">介绍 (可选)</label>
                    <input type="text" class="form-control" id="project-description" name="description" value="{{ $description }}">
                </div>
                <div class="col-xs-12 col-sm-1">
                    <button id="update-des" class="btn btn-success pull-right" style="margin-top: 25px">保存</button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12">
                <h4 class="m-t-30">项目协作者</h4>
                <ul class="list-group">
                    @foreach($users as $u)
                    <li class="list-group-item">{{ $u['name'] }}<button class="btn btn-danger btn-sm pull-right" onclick="remove({{ $u['id'] }})">移除</button></li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-11">
                    <label for="project-description">添加协作者</label>
                    <input type="text" class="form-control" id="project-co">
                </div>
                <div class="col-xs-12 col-sm-1">
                    <button id="add-co" class="btn btn-info pull-right" style="margin-top: 25px">添加</button>
                </div>
            </div>
            <div class="col-xs-12 m-t-20" style="margin-bottom: 100px">
                <h4>移除该项目</h4>
                <div class="alert alert-warning" role="alert">一旦删除该项目，数据将不可恢复。</div>
                <button class="btn btn-danger btn-md pull-right" id="delete-project">移除</button>
            </div>
        </div>
    </div>
</div>
<!-- end container -->

<!-- header -->
@include('public.footer')
<!-- //header -->

<script type="text/javascript">
    $('.selectpicker').selectpicker({
        width: 'auto'
    });

    function remove(id) {
        $.ajax({
            type: "POST",
            url: "/delRepoUser",
            data: {
                'repo_id': {{ $repo_id }},
                'id': id,
            },
            cache: false,
            success: function(data) {
                if (data.code == 200) {
                    swal('删除成功')
                    setTimeout("location.reload()", 500);
                } else {
                    swal.showInputError(data.msg)
                }
            },
            error: function() {
                swal.showInputError('网络异常')
            }
        });
    }

    $('#update-des').on('click', function(){
        $.ajax({
            type: "POST",
            url: "/repoSetting",
            data: {
                'description': $('#project-description').val(),
            },
            cache: false,
            success: function(data) {
                if (data.code == 200) {
                    swal('更新成功')
                } else {
                    swal.showInputError(data.msg)
                }
            },
            error: function() {
                swal.showInputError('网络异常')
            }
        });
    })

    $('#delete-project').on('click', function(){
        $.ajax({
            type: "POST",
            url: "/delRepo",
            data: {
                'id': {{ $repo_id }},
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
    })

    $('#add-co').on('click', function(){
        $.ajax({
            type: "POST",
            url: "/addRepoUser",
            data: {
                'name': $('#project-co').val(),
            },
            cache: false,
            success: function(data) {
                if (data.code == 200) {
                    swal('添加成功')
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
    })
</script>
