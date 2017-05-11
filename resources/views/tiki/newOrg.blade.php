<!-- header -->
@include('public.header')
<!-- //header -->


<!-- container -->
<div class="container" style="margin-top: 70px">
    <div class="row m-t-40">
        <div class="col-xs-12 col-sm-6 col-sm-offset-2">
            <h3>创建新组织</h3>
            <form>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-name">项目名</label>
                        <input type="text" class="form-control" placeholder="hello-tiki" id="project-name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">介绍 (可选)</label>
                        <input type="text" class="form-control input-sm" id="project-description">
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-sm m-t-30 pull-right">创建新项目</button>
            </form>
        </div>
    </div>
</div>
<!-- end container -->


<!-- footer -->
@include('public.footer')
<!-- //footer -->