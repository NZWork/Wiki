<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div class="container">
    <div class="row m-t-40">
        <div class="col-xs-12">
            <h3>{{ $data['org'] }} / {{ $data['name'] }}
                <div class="pull-right">
                    <a class="btn btn-sm btn-default" href="#" role="button"><i class="fa fa-star" aria-hidden="true"></i> Start 23,123</a>
                </div>
            </h3>
            <p class="text-muted">{{ $data['updated_at'] }}</p>
            <div class="jumbotron">
                <p><a class="btn btn-success btn-md w-lg pull-right" href="/{{ $data['org'] }}/{{ $data['name'] }}">立即阅读</a></p>
                <h1>{{ $data['name'] }}</h1>
                <p>{{ $data['description'] }}</p>
            </div>
        </div>
    </div>
</div>
<!-- end container -->

<!-- header -->
@include('public.footer')
<!-- //header -->
