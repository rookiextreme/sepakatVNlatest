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
    @foreach ($vehicleImages as $vehicleImage)
    @php
        $publicPath = '/'.$vehicleImage->thumb_url.'/'.$vehicleImage->doc_name;
        $RealImagePath = '/storage/'.$vehicleImage->doc_path.'/'.$vehicleImage->doc_name;
        // vehicle/dokumen/public/1/GkGrr8to2.png
    @endphp
        <div class="col-12 thin-underline">
            @if($is_display == 0)
                <div class="cursor-pointer delete-btn" onclick="deleteImage({{$vehicleImage->id}})"><i class="fa fa-times" style="filter: invert(0%) sepia(98%) saturate(10%) hue-rotate(200deg) brightness(95%) contrast(103%);"></i></div>
            @endif
            <div onclick="openEnlargeModal('{{$RealImagePath}}')" data-bs-toggle="modal" data-bs-target="#enlargeImageModal" style="
                cursor: pointer;
                height: 120px;
                width: 180px;
                margin-top:10px;
                background: url('{{$publicPath}}');
                background-size: contain;
                background-repeat: no-repeat;
            " class="float:start"></div>
            @if($is_display == 0)
            <div>{{$vehicleImage->doc_desc}}</div>
            <div class="form-check cursor-pointer">
                <input {{$vehicleImage->is_primary ? 'checked' : ''}} class="form-check-input cursor-pointer" type="radio" name="v_primary_image" value="{{$vehicleImage->id}}" id="v_primary_image-{{$vehicleImage->id}}">
                <label class="form-check-label cursor-pointer" for="v_primary_image-{{$vehicleImage->id}}">
                Paparan Utama
                </label>
            </div>
            @endif
        </div>
    @endforeach
</div>

<script type="text/javascript">

    @if($is_display == 0)
        function deleteImage(id){
            var formData = new FormData();
                formData +="&_token={{ csrf_token() }}&id="+id;
            $.post("{{route('vehicle.delete.image')}}",formData, function(result){
                getVehicleImages();
            });
        }
    @endif

    function openEnlargeModal(img_url){
        $('#enlargeImageModal img').attr('src', img_url);
    }

</script>

@include('components.modal-enlarge-image')
