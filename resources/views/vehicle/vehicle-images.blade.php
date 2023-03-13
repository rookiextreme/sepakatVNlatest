<!--carousel start-->
<div id="vehicleImagesIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" style="position: relative;height: 90%">
    <div class="carousel-indicators" style="z-index:50;top:-20px">
        @foreach ($vehicleImages as $vehicle_image)
            <button type="button" data-bs-target="#vehicleImagesIndicators" data-bs-slide-to="{{$loop->index}}" class="active" aria-current="true" aria-label="Slide 1" style="position: relative;height:5px;width:20px;border-radius: 10px;"></button>
        @endforeach
        </div>
    <div class="carousel-inner" style="height:100%">

        {{-- @json($getModalVehicleImages) --}}
        @foreach ($vehicleImages as $vehicle_image)
            <div style="position:relative" class="carousel-item {{$loop->index == 0 ? 'active' : ''}}">
                <img src='/storage/{{$vehicle_image->doc_path}}{{$vehicle_image->doc_name}}' style="width: 100%;" alt="...">
                <div style="position: absolute;top:0px;left:0px;z-index:10;height:30px;background-color:#000000;font-size:14px;color:#ffffff;line-height:30px;padding-left:5px;padding-right:5px;-webkit-border-radius: 0px 0px 6px 0px;-moz-border-radius: 0px 0px 6px 0px;border-radius: 0px 0px 6px 0px;">
                    {{$vehicle_image->doc_desc}}
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev tanda" type="button" data-bs-target="#vehicleImagesIndicators" data-bs-slide="prev" style="position:absolute;background-color:#ffae00;left:-20px;top:220px;height:45px;width:40px;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#vehicleImagesIndicators" data-bs-slide="next" style="position:absolute;background-color:#ffae00;right:-20px;top:220px;height:45px;width:40px;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!--carousel end-->
