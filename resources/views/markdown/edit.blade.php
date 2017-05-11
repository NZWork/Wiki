<!-- header -->
@include('public.header')
<!-- //header -->

<!-- container -->
<div style="margin-top:64px">
    <input class="form-control" value="Tiki Cookbook th">
    <div id="main">
        <textarea  style="display:none;" id="content"></textarea>
    </div>
</div>
<!-- end container -->

<!-- header -->
@include('public.footer')
<!-- //header -->

<script src="editormd/editormd.min.js"></script>
<script src="js/ot.js"></script>
<script src="js/util.js"></script>
<script src="js/edit.js"></script>

<script type="text/javascript">
    var testEditor;
    $(function() {
        testEditor = editormd("main", {
            width   : "100%",
            height  : 640,
            syncScrolling : "single",
            path    : "editormd/lib/"
        });
    });
    $(document).ready(function(){
        connect('{{$xtoken}}', '{{$pubkey}}')
    })
</script>
