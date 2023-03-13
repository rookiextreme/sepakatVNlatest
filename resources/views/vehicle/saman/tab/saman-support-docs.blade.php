<style>
    .delete-btn {
        background: #181817;
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
        $publicPath = '/'.$supportDoc->doc_path_thumbnail.'/'.$supportDoc->doc_name;
        $pathUrl = '/storage/'.$supportDoc->doc_path.'/'.$supportDoc->doc_name;
        // vehicle/dokumen/public/1/GkGrr8to2.png
    @endphp
        <div class="col-md-6 col-sm-12 col-12 thin-underline hasSupportDoc">
            @if($is_display == 0)
                <div class="cursor-pointer delete-btn" onclick="prompDeleteSupportDoc({{$supportDoc->id}})"><i class="fa fa-times" style="filter: invert(0%) sepia(98%) saturate(10%) hue-rotate(200deg) brightness(95%) contrast(103%);"></i></div>
            @endif
            @if($supportDoc->doc_format == 'pdf')
            <button type="button" class="btn cux-btn small btn-file" data-url="{{$pathUrl}}" data-download="" onclick="fancyView('{{$pathUrl}}')"><i class="fas fa-file-pdf"></i> Lihat Dokumen {{$loop->index+1}}</button>
            @else
            <div onclick="openEnlargeModal('{{$pathUrl}}')" data-bs-toggle="modal" data-bs-target="#enlargeImageModal" style="
                cursor: pointer;
                height: 120px;
                margin-top:10px;
                background: url('{{$publicPath}}');
                background-size: contain;
                background-repeat: no-repeat;
            " class="float:start"></div>
            @endif
            @if($is_display == 0)
            <div>{{$supportDoc->doc_desc}}</div>
            {{-- <div class="form-check cursor-pointer">
                <input {{$supportDoc->is_primary ? 'checked' : ''}} class="form-check-input cursor-pointer" type="radio" name="v_primary_image" value="{{$supportDoc->id}}" id="v_primary_image-{{$supportDoc->id}}">
                <label class="form-check-label cursor-pointer" for="v_primary_image-{{$supportDoc->id}}">
                Primary
                </label>
            </div> --}}
            @endif
        </div>
    @endforeach
</div>

<div class="modal fade" id="delSummonSuppDocModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delSummonSuppDocModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <span type="button" class="close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                    <i class="fal fa-times"></i>
                </span>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin menghapuskan maklumat ini ?
                </div>
            </div>
            <div class="modal-footer float-start">
                <span class="btn btn-module" onclick="deleteSupportDoc()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    @if($is_display == 0)
        function prompDeleteSupportDoc(id){
            selectedSuppDocId = id;
            $('#delSummonSuppDocModal').modal('show');
        }

        function deleteSupportDoc(){
            var formData = new FormData();
                formData +="&_token={{ csrf_token() }}&id="+selectedSuppDocId;
            $.post("{{route('vehicle.saman.delete.supportDoc')}}",formData, function(result){
                getSupportDocs();
                selectedSuppDocId = null;
                $('#delSummonSuppDocModal').modal('hide');
            });
        }
    @endif

    function openEnlargeModal(img_url){
        $('#enlargeImageModal img').attr('src', img_url);
    }

</script>
