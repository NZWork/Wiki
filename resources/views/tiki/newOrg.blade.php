<!-- header -->
@include('public.header')
<!-- //header -->


<!-- container -->
<div class="container" style="margin-top: 70px">
    <div class="row m-t-40">
        <div class="col-xs-12 col-sm-6 col-sm-offset-2">
            <h3>创建新组织</h3>
            <form action="/createOrg" method="post">
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-name">组织名</label>
                        <input type="text" class="form-control" placeholder="Hello-Tiki" id="org-name" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">介绍 (可选)</label>
                        <input type="text" class="form-control" placeholder="组织介绍" id="org-bio" name="bio">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">组织主页</label>
                        <input type="text" class="form-control" placeholder="组织介绍" id="org-url" name="url">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">所属公司</label>
                        <input type="text" class="form-control" placeholder="组织介绍" id="org-company" name="company">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">所属地区</label>
                        <input type="text" class="form-control" placeholder="组织介绍" id="org-location" name="location">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm m-t-30 pull-right">创建组织</button>
            </form>
        </div>
    </div>
</div>
<!-- end container -->


<!-- footer -->
@include('public.footer')
<!-- //footer -->