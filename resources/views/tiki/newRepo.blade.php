<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container" style="margin-top: 70px">
    <div class="row m-t-40">
        <div class="col-xs-12 col-sm-6 col-sm-offset-2">
            <h3>创建新项目</h3>
            <form>
                <div class="form-group">
                    <div class="col-xs-3">
                        <label for="product-owner">所有者</label>
                        <select class="selectpicker" data-style="btn-primary" id="product-owner">
                            <option value="">x</option>
                            <option value="">GayHub</option>
                        </select>
                    </div>
                    <div class="col-xs-8">
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

<!-- header -->
@include('public.footer')
<!-- //header -->

<script type="text/javascript">
    $('.selectpicker').selectpicker({
        width: 'auto'
    });

</script>
