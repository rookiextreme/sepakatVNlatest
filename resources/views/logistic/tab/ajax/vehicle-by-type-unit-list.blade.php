<style>
    .catalogue {
        width:100%;
        max-width: 800px;
        padding-left:10px;
        padding-right:10px;
        padding-bottom:30px;
    }
    .catalogue .box-catalogue {
        background-color: #ffffff;
        margin-bottom:10px;
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius:  6px 6px 6px 6px;
        border-color:#d7d7de;
        border-width:2px;
        border-style:solid;
        min-height: 80px;
        height:105px;
    }
    .no-plet {
        font-family: avenir-bold;
        font-size:20px;
        line-height: 45px;
        text-transform: uppercase;
        color:#000000;
    }
    .lokasi {
        font-family: mark;
        font-size:12px;
        line-height:12px;
    }
    .subject {
        font-family: avenir-bold;
        font-size:10px;
        text-transform: uppercase;
        color:#404040;
        margin-top:5px;
    }
    .kategori {
        background-color:#404040;
        font-family: avenir-bold;
        color:#ffffff;
        font-size:12px;
        padding-left:5px;
        margin-bottom:3px;
    }
    .text-uppercase {
        line-height:16px !important;
        margin-top:10px;
    }
    .details {
        font-family: mark;
        font-size:14px;
    }
    .line-t {
        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
    }
    .box-left {
        position: absolute;
        left:10px;
        top:0px;
        margin-left:-8px;
        margin-top:3px;
        width:143px;
        height:95px;
        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        transition: all .2s ease-in-out;
    }
    .box-left:hover {
        transform: scale(1.1);
    }
    .box-right {
        width:80%;
        padding-top:5px;
        margin-left:20px;
    }
</style>
@foreach ( $vehicleList as $vehicle)

@php
    $publicPath = "";
    if($vehicle->thumb_url){
        $publicPath = '/'.$vehicle->thumb_url.'/'.$vehicle->doc_name;
    }
@endphp
<div class="row box-catalogue">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="position: relative">
        <div class="row">
            <div class="col" style="position:relative;max-width:143px;width:143px;">
                <div class="box-left" data-bs-toggle="modal" data-bs-target="#vehicleImagesModal"
                    onclick="loadVehicleImages({{$vehicle->id}})"
                    style="background-image: url('{{!empty($publicPath) ? $publicPath : asset('my-assets/img/no-image-min.png') }}');">
                    &nbsp;</div>
            </div>
            <div class="col box-right">
                <div class="row" style="height:45px">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">
                        <div class="no-plet">{{$vehicle->plat_number}}</div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                        <div class="subject">Tahun</div>
                        <div class="details">
                            {{!empty($vehicle->acqDt) ? \carbon\Carbon::parse($vehicle->acqDt)->format('Y') : '-'}}
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                        <div class="subject">Umur</div>
                        <div class="details">
                            {{\Carbon\Carbon::parse($vehicle->acqDt)->diff(\Carbon\Carbon::now())->format('%y tahun');}}
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-0 col-6 data-extra">
                        <div class="subject">No Enjin</div>
                        <div class="details">{{$vehicle->engine_no}}</div>
                    </div>
                </div>
                <div class="row line-t">
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">
                        <div class="kategori">{{$vehicle->category_name}}</div>
                        <div class="lokasi">{{$vehicle->placement_name}}</div>
                    </div>
                    {{-- <div class="col-1">
                        <div class="subject"></div>
                        <div class="details"></div>
                    </div> --}}
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                        <div class="subject">Pengeluar</div>
                        <div class="details">{{$vehicle->brand_name}}</div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3">
                        <div class="subject">Model</div>
                        <div class="details">{{$vehicle->model_name}}</div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-0 col-6 data-extra">
                        <div class="subject">No Casis</div>
                        <div class="details">{{$vehicle->chasis_no}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade modal-dialog-scrollable" id="vehicleImagesModal" tabindex="-1" aria-labelledby="vehicleImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="position: relative;height:100%;">
            <div class="modal-header">
                <button type="button" class="btn-close float-end" onclick="$('#vehicleImagesModal').modal('hide');" aria-label="Close" style="position:absolute;right:15px;top:15px;z-index:10"></button>
            </div>
            <div class="modal-body" id="vehicle-images" style="height: 400px;"></div>
        </div>
    </div>
</div>

{{$vehicleList->links('pagination.ajax-vehicle-type-unit')}}

<script>
    function loadVehicleImages(vehicle_id){
        $.get("{{route('vehicle.ajax.getModalVehicleImages')}}", {
            'vehicle_id': vehicle_id,
            'fleet_view': 'department'
        }, function(res){
            $('#vehicle-images').html(res);
            $('#vehicleImagesIndicators').carousel({
                interval: 3000,
                cycle: true
            });
        });
    }
</script>
