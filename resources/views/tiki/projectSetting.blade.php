<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container" style="margin-top: 70px">
    <div class="row m-t-40">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2">
            <h3>x\hello-tiki</h3>
            <div class="form-group">
                <div class="col-xs-12 col-sm-11">
                    <label for="project-description">介绍 (可选)</label>
                    <input type="text" class="form-control" id="project-description">
                </div>
                <div class="col-xs-12 col-sm-1">
                    <button type="submit" class="btn btn-success pull-right" style="margin-top: 25px">保存</button>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12">
                <h4 class="m-t-30">项目协作者</h4>
                <ul class="list-group">
                    <li class="list-group-item">Cras justo odio<a class="btn btn-danger btn-sm pull-right" href="">移除</a></li>
                    <li class="list-group-item">Dapibus ac facilisis in<a class="btn btn-danger btn-sm pull-right" href="">移除</a></li>
                    <li class="list-group-item">Morbi leo risus<a class="btn btn-danger btn-sm pull-right" href="">移除</a></li>
                    <li class="list-group-item">Porta ac consectetur ac<a class="btn btn-danger btn-sm pull-right" href="">移除</a></li>
                    <li class="list-group-item">Vestibulum at eros<a class="btn btn-danger btn-sm pull-right" href="">移除</a></li>
                </ul>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-11">
                    <label for="project-description">添加协作者</label>
                    <input type="text" class="form-control" id="project-description">
                </div>
                <div class="col-xs-12 col-sm-1">
                    <button type="submit" class="btn btn-info pull-right" placeholder="协作者 ID" style="margin-top: 25px">保存</button>
                </div>
            </div>
            <div class="col-xs-12 m-t-20" style="margin-bottom: 100px">
                <h4>移除该项目</h4>
                <div class="alert alert-warning" role="alert">一旦删除该项目，数据将不可恢复。</div>
                <a class="btn btn-danger btn-md pull-right" href="">移除</a>
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
</script>
