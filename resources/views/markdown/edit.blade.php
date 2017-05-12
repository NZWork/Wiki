<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div>
    <input disabled class="form-control" value="{{ $title }}">
    <div id="main">
        <textarea  style="display:none;" id="content"></textarea>
    </div>
</div>
<!-- end container -->

<!-- header -->
@include('public.footer')
<!-- //header -->

<script src="/editormd/editormd.min.js"></script>
<script src="https://cdn.bootcss.com/diff_match_patch/20121119/diff_match_patch.js"></script>
<script src="/js/ot.js"></script>
<script src="/js/util.js"></script>
<script src="/js/edit.js"></script>
<script type="text/javascript">
    initEditor('{{$xtoken}}', '{{$pubkey}}')
</script>
