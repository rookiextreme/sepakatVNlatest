<style>
    .delete-btn {
        background: #dd3444;
        padding-left: 8px;
        padding-top: 3px;
        border-radius: 15px;
        height: 25px;
        width: 25px;
        float: left;
        font-size: 14px;
        margin-left: -2px;
        margin-top: -5px;
        color: white;
    }
</style>
<div class="row">
    @foreach ($supportDocs as $supportDoc)
    @php
        $path = '/'.$supportDoc->doc_path.'/'.$supportDoc->doc_name;
    @endphp
        <div class="col-md-2 col-sm-3 col-6 mb-1">
            @if($is_display == 0)
                <div class="cursor-pointer delete-btn" onclick="deleteFile({{$supportDoc->id}})">X</div>
            @endif
            <button onclick="window.location='{{$path}}'" class="btn cux-btn small">
                <i class="fa fa-file-{{$supportDoc->doc_format}}"></i> Muat Turun
            </button>
        </div>
    @endforeach
</div>

<script type="text/javascript">

    @if($is_display == 0)
        function deleteFile(id){
            var formData = new FormData();
                formData +="&_token={{ csrf_token() }}&id="+id;
            $.post("{{route('logistic.delete.file')}}",formData, function(result){
                getSupportDocs();
            });
        }
    @endif

</script>