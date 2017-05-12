<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container">
    <div class="row m-t-40">
        <div class="col-xs-12 col-sm-6 col-sm-offset-2">
            <h3>创建新项目</h3>
            <form action="/createRepo" method="post">
                <div class="form-group">
                    <div class="col-xs-3">
                        <label for="product-owner">所有者</label>
                        <select class="selectpicker" data-style="btn-primary" id="product-owner" name="org_id">
                            <option value="0">{{ $header->name }}</option>
                            @foreach ($orgList as $org)
                                <option value="{{ $org['org_id'] }}">{{ $org['org_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-8">
                        <label for="project-name">项目名</label>
                        <input type="text" class="form-control" placeholder="hello-tiki" id="project-name" name="name" value="{{old('name')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">项目站点 (可选)</label>
                        <input type="text" class="form-control" id="project-website" name="website" value="{{old('website')}}">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <label for="project-description">介绍 (可选)</label>
                        <input type="text" class="form-control" id="project-description" name="description" value="{{old('description')}}">
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