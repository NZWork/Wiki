<!-- header -->
@include('public.header')
<!-- //header -->


<!-- container -->
<div class="container">
  <div class="row m-t-40">
    <div class="col-xs-12">
      <div class="col-xs-3">
        <div style="height: 230px; width: 230px; max-width: 100%">
          <img src="https://pbs.twimg.com/profile_images/831518614561837058/ytvJfYOx_400x400.jpg" class="img-rounded img-responsive">
        </div>
        <h3>{{ $profile->nickname }}</h3>
        <p>{{ $profile->name }}@if($isUser) · 第 {{ $profile->id }} 号成员@endif</p>
        <span class="text-muted">{{ $profile->bio }}</span>
        <hr>
        <p><i class="fa fa-map-marker m-r-10" aria-hidden="true"></i>{{ $profile->location }}</p>
        <p><i class="fa fa-link m-r-5" aria-hidden="true"></i><a href="{{ $profile['url'] }}">{{ $profile->url }}</a></p>
        <hr>
        <h4>Organizations</h4>
        <ul class="list-inline">
          @foreach ($profile->organazations as $org)
          <li style="width: 64px"><a href="{{ $org->name }}"><img src="{{ $org->avatar }}" class="img-rounded img-responsive"></a></li>
          @endforeach
        </ul>
      </div>
      <div class="col-xs-9">
        <h3>Repos</h3>
        <ul class="list-unstyled repo-list">
          @foreach($profile->projects as $p)
          <li>
            <h3><a href="{{ $p->name }}">{{ $p->name }}</a></h3>
            <div>
              <span class="text-muted">Description</span>
              <span class="like pull-right"><i class="fa fa-heart-o" aria-hidden="true"></i> 23,231</span>
              <span class="latest-update text-muted pull-right">Updated 2 days ago</span>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- end container -->


<!-- header -->
@include('public.footer')
<!-- //header -->
