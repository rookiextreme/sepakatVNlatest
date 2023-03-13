@php
$title = 'Daftar Kenderaan';
$subTitle = 'Pendaftaran Kenderaan Ke Dalam Sistem SPAKAT';
@endphp

@if (request('id') > 0)
    @php
        $title = 'Maklumat Kenderaan';
        $subTitle = 'Maklumat Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php
use App\Http\Controllers\Vehicle\VehicleHistoryDAO;

$VehicleHistoryDAO = new VehicleHistoryDAO();
$VehicleHistoryDAO->mount(request());

$is_display = $VehicleHistoryDAO->is_display;

$detail = $VehicleHistoryDAO->detail;
$maklumat = $VehicleHistoryDAO->detail ? $VehicleHistoryDAO->detail->maklumat : null;
$tambahan = $VehicleHistoryDAO->detail ? $VehicleHistoryDAO->detail->maklumatTambahan : null;

$vehicle_history_list = $VehicleHistoryDAO->vehicle_history_list;
$negeris = $VehicleHistoryDAO->negeris;
$cawangan = $VehicleHistoryDAO->cawangan;
$placement_list = $VehicleHistoryDAO->placement_list;

$categoryList = $VehicleHistoryDAO->categoryList;
$brands = $VehicleHistoryDAO->brands;
$models = $VehicleHistoryDAO->models;

$TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');

$fleet_view = Request('fleet_view') ? Request('fleet_view') : 'department';
$currentYear = \Carbon\Carbon::now()->format('Y');
$prevYear = $currentYear - 1;
$nextYear = $currentYear + 1;
$selectedYear = $currentYear;
$years = range($currentYear, $currentYear-5);
if(Request('selectedYear')){
    $prevYear = Request('selectedYear') - 1;
    $nextYear = Request('selectedYear') + 1;
    $selectedYear = Request('selectedYear');
}

@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <link rel="shortcut icon" href="{{ asset('my-assets/favicon/favicon.png') }}">

    <!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">

    <!--importing bootstrap-->
    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('my-assets/fontawesome-pro/css/light.min.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.js') }}"></script>
    <!--Importing Icons-->

    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


    <style type="text/css">
        .memory-lane {
            position: relative;
            margin-top:62px;
            margin-left:-30px;
            margin-right:-10px;
            height:80vh;

            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#f2f4f0+0,ffffff+100 */
            background: #f2f4f0; /* Old browsers */
            background: -moz-linear-gradient(top,  #f2f4f0 0%, #ffffff 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top,  #f2f4f0 0%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom,  #f2f4f0 0%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f4f0', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */

            border-radius: 0px 0px 10px 10px;
            -moz-border-radius: 0px 0px 10px 10px;
            -webkit-border-radius: 0px 0px 10px 10px;
            overflow-x:scroll;
            transition: all .2s ease-in-out;
        }
        .dropdown-item {
            font-family: mark;
            font-size:14px;
        }
        .dropdown-item i.fa {
            min-width:40px !important;
            text-align:left;
        }
        .dropdown-header {
            font-family: mark-bold;
            text-transform: uppercase;
            font-size:12px;
            color:#6d7466;
        }

        .info-drawer {
            position: absolute;
            top:-120px;
            width:95%;
            height:280px;
            z-index:2;

            padding:10px;
            border-bottom-width: 3px;
            border-bottom-color:#d4dacf;
            border-bottom-style: solid;
            transition: all .1s ease-in-out;
        }
        .year-timeline {
            margin-top:35vh;max-height:14px;width:80%;margin-left:auto;margin-right:auto;position: relative;
        }
        .sect-top {
            position: fixed;
            left:0px;
            width:100%;
            z-index:4;
            padding-left:28px;
            background-color: #f2f4f0;
            padding-bottom:10px;
            border-bottom-color:#e7e7e7;
            border-bottom-style: solid;
            border-bottom-width:1px;
            margin-left:0px;
            margin-right:0px;
        }
        .sect-top-dummy {
            height:100px;
        }
        .polaroid {
            background-color:#ffffff;
            padding:5px;
            max-width:200px;
            height:165px;
            text-align: center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            border-style: solid;
            border-color:#c8c8cc;
            border-width:1px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            transition: all .2s ease-in-out;
        }
        .polaroid .plet-no {
            font-family: mark-bold;
            font-size:16px;
            text-align: left;
            margin-left:5px;
            line-height: 35px;
            color:#272624;
        }

        .polaroid-status {
            background-color:#ffffff;
            padding:5px;
            max-width:200px;
            height:50px;
            text-align: center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            border-style: solid;
            border-color:#c8c8cc;
            border-width:1px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            transition: all .2s ease-in-out;
        }
        .polaroid-status .status-text {
            font-family: mark-bold;
            font-size:16px;
            text-align: center;
            margin-left:5px;
            line-height: 35px;
            color:#6a9a52;
        }
        .plate-highlight {
            font-family: avenir-bold;
            font-size:14px;
            color:#595959;
            text-transform: uppercase;
        }
        .box-left {
            margin-left:auto;
            margin-right:auto;
            margin-top:3px;
            max-width:180px;
            height:120px;
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
        }
        .box-right {
            float:left;
            width:80%;
            padding-top:5px;
            margin-left:20px;
        }
        .zyear {
            position:absolute;
            top:-30px;
            left:0px;
            width: 300px;
            font-family: helvetica-bold;
            font-size:16px;
            letter-spacing: 0px;
            z-index: 4;
        }
        .back-shadow {
            position: absolute;
            left:0px;
            width:80%;
            z-index:1;
            width:100%;
            height:20px;
        }
        .zmonth {
            position:relative;
            height:15px;
            border-left-style: solid;
            border-left-width:1px;
            border-left-color:#ffffff;
        }
        .hovmonth {
            position:absolute;
            left:0px;
            top:0px;
            z-index:5;
            width:100%;
            height:15px;
            cursor: pointer;
            transition: all .2s ease-in-out;
        }
        .hovmonth:hover {
            transform: scale(1.2);
        }
        .xmth {
            position: absolute;
            top:25px;
            left:2px;
            font-family: mark;
            font-size:12px;
        }
        .prev-year {
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ffffff+0,3c4d85+100 */
            background: #ffffff; /* Old browsers */
            background: -moz-linear-gradient(left,  #ffffff 0%, #b3b3ad 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(left,  #ffffff 0%,#b3b3ad 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to right,  #ffffff 0%,#b3b3ad 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#b3b3ad',GradientType=1 ); /* IE6-9 */

            width:80px;
            position: absolute;
            height:15px;
            left:-83px;
            top:0px;
        }
        .prev-year .nyear {
            position:absolute;
            top:-20px;
            right:5px;
            font-family: helvetica-bold;
            font-size:12px;
            letter-spacing: 0px;
            border-right-width: 1px;
            border-right-color:darkgray;
            border-riight-style:solid;
            cursor:pointer;
        }
        .next-year {
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#b3b3ad+0,ffffff+100 */
            background: #b3b3ad; /* Old browsers */
            background: -moz-linear-gradient(left,  #b3b3ad 0%, #ffffff 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(left,  #b3b3ad 0%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to right,  #b3b3ad 0%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b3b3ad', endColorstr='#ffffff',GradientType=1 ); /* IE6-9 */

            width:80px;
            position: absolute;
            height:15px;
            right:-83px;
            top:0px;
        }
        .next-year .nyear {
            position:absolute;
            top:-20px;
            left:1px;
            font-family: helvetica-bold;
            font-size:12px;
            letter-spacing: 0px;
            cursor:pointer;
        }
        .prev-year .nyear:hover, .next-year .nyear:hover {
            color:#64cbc2;
        }
        .point {
            position: absolute;
            background: #484848;
            border-radius: 25px 25px 25px 25px;
            -moz-border-radius: 25px 25px 25px 25px;
            -webkit-border-radius: 25px 25px 25px 25px;
            width:10px;
            height:10px;
        }
        .point .line {
            position: absolute;
            width:1px;
            background: #484848;
            height:0px;
            left:4px;
        }
        .point.s1 {
            top:3px;
            left:10%;
        }
        .point.s2 {
            top:3px;
            left:42%;
        }
        .point.s3 {
            top:3px;
            left:75%;
        }
        .point .line.l1 {
            height:160px;
            transition-delay: 1s;
            -webkit-transition: height 1s ease-in-out;
            -moz-transition: height 1s ease-in-out;
            -o-transition: height 1s ease-in-out;
            transition: height 1s ease-in-out;
            bottom:4px;
        }
        .point .line.l2 {
            height:47px;
            transition-delay: 1s;
            -webkit-transition: height 1s ease-in-out;
            -moz-transition: height 1s ease-in-out;
            -o-transition: height 1s ease-in-out;
            transition: height 1s ease-in-out;
            bottom:4px;
        }
        .point .line.l3 {
            height:160px;
            transition-delay: 1s;
            -webkit-transition: height 1s ease-in-out;
            -moz-transition: height 1s ease-in-out;
            -o-transition: height 1s ease-in-out;
            transition: height 1s ease-in-out;
            top:4px;
        }
        .point .line.l4 {
            height:50px;
            top:4px;
        }
        .info {
            position: absolute;
            /*height:96px;*/
            height:auto;
            max-height:96px;
            width:145px;
            left:-12px;
            padding:0px;
            color:#484848;
            overflow:hidden;
            z-index: 2;
        }

        .point .line .info {
            display: none;
        }

        .point .line.l1 .info {
            bottom:160px;
            vertical-align: bottom;
        }
        .point .line.l2 .info {
            bottom:50px;
            vertical-align: bottom;
        }
        .point .line.l3 .info {
            top:160px;
        }
        .point .line.l4 .info {
            top:50px;
        }
        /*.point .line.l21 .info {
            top:160px;
            vertical-align: top;
        }*/

        /*.point .down.line2 .info {
            top:50px;
            vertical-align: top;
        }*/


        .info ul.calendar {
            width:173px;
            margin-bottom:0px;
            margin-top:0px;
        }
        .info ul.calendar li {
            list-style-type: none;
            text-align: left;
            font-family: mark;
            font-size:12px;
            line-height:20px;
            width:100%;
            padding-left:0px;
            margin-top:3px;
            margin-left:-30px;
            background-color: rgba(255, 255, 255, 0.9);
            cursor:pointer;
        }
        .info ul.calendar li:hover {
            background-color:#484848;
            color:#ffffff;
            border-radius: 5px 5px 5px 5px;
            -moz-border-radius: 5px 5px 5px 5px;
            -webkit-border-radius: 5px 5px 5px 5px;
        }
        .info ul.calendar li div {
            background: #484848;
            border-radius: 25px 25px 25px 25px;
            -moz-border-radius: 25px 25px 25px 25px;
            -webkit-border-radius: 25px 25px 25px 25px;
            height:20px;
            width:20px;
            text-align: center;
            color:#ffffff;
            font-size:12px;
            font-family: avenir;
            line-height: 20px;
            display: inline-block;
        }
        .spec-sch {
            margin-top:0px;
            border-radius: 10px 0px 0px 10px;
            -moz-border-radius: 10px 0px 0px 10px;
            -webkit-border-radius: 10px 0px 0px 10px;
            border-color:#d6d8d4;
            border-width:2px;
            height:38px;
            font-size:14px;
        }
        /*.info .i1 {
            top:-95px;
            left:-11px;
        }
        .info .i2 {
            top:-13px;
        }
        .info .i3{
            bottom:-100px;
            left:-11px;
        }
        .info .i4{
            bottom:-100px;
            left:-11px;
        }
        .point.s1 .up, .point.s1 .down {
            height:160px;
        }
        .point.s2 .up, .point.s2 .down {
            height:130px;
        }
        .point.s3 .up, .point.s3 .down {
            height:160px;
        }*/
        .mth1 {
            background-color:#36997a;
        }
        .mth2 {
            background-color:#9e577d;
        }
        .mth3 {
            background-color:#c0c02f;
        }
        .mth4 {
            background-color:#621d46;
        }
        .mth5 {
            background-color:#74618a;
        }
        .mth6 {
            background-color:#446392;
        }
        .mth7 {
            background-color:#6a9a52;
        }
        .mth8 {
            background-color:#cfcfce;
        }
        .mth9 {
            background-color:#697a37;
        }
        .mth10 {
            background-color:#4aa494;
        }
        .mth11 {
            background-color:#884b73;
        }
        .mth12 {
            background-color:#5f74b8;
        }
        .push-down {
            transform: translateY(300px);
        }
        .line-r {
            border-right-style: solid;
            border-right-color:#e3e3eb;
            border-right-width:1px;
        }
        .box-info .rlabel {
            float:left;
            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:12px;
            line-height: 30px;
            text-align: left;
            width:auto;
        }
        .box-info .mytext {
            float:right;
            font-family: mark;
            font-size:12px;
            width:auto;
            line-height: 30px;
            text-align: right;
        }
        .box-info {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            height:30px;
        }

        .date .input-group-text {
            height: 39px;
            margin-left: 2px !important;
            border: transparent;
            background: #dbdcd8;
        }
        /*
        GUIDE TO PROGRAMMERS

        There are 4 lines: line1, line2, line3, line4. Put in these rotation
        Put classname in rotation of "line l1", "line l2", "line l3", "line l4"

        There are 3 sectors: s1, s2, s3
            s1: Date fall between 1 until 9th of that month
            s2: Date fall between 10 until 19th of that month
            s3: Date fall between 20 until end of the month
        */
        @media (max-width: 1399.98px) {
            /*X-Large devices (large desktops, less than 1400px)*/
            /*X-Large*/
        }

        @media (max-width: 1199.98px) {
            /*Large devices (desktops, less than 1200px)*/
            /*Large*/
        }

        @media (max-width: 991.98px) {
            /* Medium devices (tablets, less than 992px)*/
            /*medium*/
        }

        @media (max-width: 767.98px) {
            /* Small devices (landscape phones, less than 768px)
  /*small*/
        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
            .year-timeline {
                display:none;
            }
        }

    </style>
    <script type="text/javascript">
    function openInfo() {
        if($('.info-drawer').hasClass('push-down')){
            $('.info-drawer').removeClass('push-down');
            $('.memory-lane').removeClass('push-down');
        }else{
            $('.info-drawer').addClass('push-down');
            $('.memory-lane').addClass('push-down');
        }
    }
    function closeInfo() {
        $('.info-drawer').removeClass('push-down');
        $('.memory-lane').removeClass('push-down');
    }
    function hide(element){
        $(element).hide();
    }

    function show(element){
        $(element).show();
    }

    function block(element){
        $(element).prop('disabled', true);
    }

    function release(element){
        $(element).prop('disabled', false);
    }

    $(document).ready(function() {
        $('.point.s1 .line').addClass('l1');
        $('.point.s2 .line').addClass('l2');
        $('.point.s3 .line').addClass('l3');
        setTimeout(function(){
            $('.point .line .info').fadeIn();
        }, 1000)
    });

    </script>
</head>
<body class="content">
<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>
<div class="sect-top">
    {{-- <textarea name="" class="form-control" id="" cols="30" rows="10">
       @foreach ($detail->hasManyHistory() as $history)

        {{$history->hasEvent()}}

       @endforeach
    </textarea> --}}
    <div class="mytitle">Rekod Peristiwa</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a
                    href="{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 5]) }}">Senarai Kenderaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Rekod Peristiwa {{$detail->no_pendaftaran}}
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-xl-9 col-lg-9 col-md-10 col-sm-10 col-6">
            <button class="btn cux-btn bigger plate-highlight" onClick="openInfo()"><i class="fas fa-info-circle"></i> {{$detail->no_pendaftaran}}</button>
            {{-- VehicleEventHistoryModal --}}
            <button class="btn cux-btn bigger" onclick="prompAddVehicleEventHistory()" ><i class="fal fa-plus"></i> Peristiwa</button>
            <div class="dropdown inline" style="display: inline;">
                <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">{{$selectedYear}}</span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($years as $year)
                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.history', [ 'id' => Request('id'), 'fleet_view' => $fleet_view, 'selectedYear' => $year ])}}')">{{$year}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2 col-6" style="padding-right:35px">
            <div class="input-group">
                <input type="search" class="form-control spec-sch" placeholder="Cari Kenderaan">
                <span class="input-group-text cux-btn" id="basic-addon2" style="height:38px;"><i class="fal fa-search fa-lg"></i></span>
            </div>
        </div>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="info-drawer">
    <div style="position: absolute;bottom:-16px;left:0px;"><a href="javascript:closeInfo()" class="btn cux-btn float-end mt-3"><i class="fal fa-chevron-up"></i></a></div>
    <div class="row" id="frm_info">

        @php
            $publicPath = "";
            if($detail && $detail->hashVehicleImagePrimary() && $detail->hashVehicleImagePrimary()->doc_path_thumbnail){
                $publicPath = '/'.$detail->hashVehicleImagePrimary()->doc_path_thumbnail.'/'.$detail->hashVehicleImagePrimary()->doc_name;
            }
        @endphp

        <div class="col-xl-2 col-lg-2 col-md-4 line-r">
            <div class="polaroid">
                <div class="box-left" style="background-image: url({{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }});">&nbsp;</div>
                <div class="plet-no">{{$detail->no_pendaftaran}}</div>
            </div>
                    <hr>
            <div class="polaroid-status">
                <div class="status-text">
                        {{$detail->hasVehicleStatus ? $detail->hasVehicleStatus->desc : '-'}}
                </div>
            </div>
        </div>
        {{-- {{$detail}} --}}
        <div class="col-xl-10 col-lg-10 col-md-8">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                    <div class="box-info">
                        <div class="rlabel">No Pendaftaran</div>
                        <div class="mytext">{{$detail->no_pendaftaran?:'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Model</div>
                        <div class="mytext">{{$detail->hasVehicleModel() ? $detail->hasVehicleModel()->name:'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Buatan</div>
                        <div class="mytext">{{$detail->hasBrand() ? $detail->hasBrand()->name:'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Kategori</div>
                        <div class="mytext">{{$detail->hasCategory() ? $detail->hasCategory()->name:'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Sub-Kategori</div>
                        <div class="mytext">{{$detail->hasSubCategory() ? $detail->hasSubCategory()->name:'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Jenis</div>
                        <div class="mytext">{{$detail->hasSubCategoryType() ? $detail->hasSubCategoryType()->name:'-'}}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                    <div class="box-info">
                        <div class="rlabel">No. Enjin</div>
                        <div class="mytext">{{$detail->no_engine ? $detail->no_engine : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">No. Casis</div>
                        <div class="mytext">{{$detail->no_chasis ? $detail->no_chasis : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">No. ID Pemunya</div>
                        <div class="mytext">{{$detail->no_id_pemunya ? $detail->no_id_pemunya : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">No. JKR</div>
                        <div class="mytext">{{$detail->no_jkr ? $detail->no_jkr : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">No. Loji</div>
                        <div class="mytext">{{$detail->no_loji ? $detail->no_loji : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">No. Pesanan Kerajaan</div>
                        <div class="mytext">{{$detail->no_lo ? $detail->no_lo : '-'}}</div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                    <div class="box-info">
                        <div class="rlabel">Tahun Dibeli</div>
                        <div class="mytext">{{$detail->acqDt? \Carbon\Carbon::parse($detail->acqDt)->format('d M Y'):'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Tahun Dibuat</div>
                        <div class="mytext">{{$detail->manufacture_year ? : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Usia</div>
                        <div class="mytext">{{$detail->manufacture_year ? Carbon\Carbon::now()->format('Y') - $detail->manufacture_year : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Tarikh Perolehan</div>
                        <div class="mytext">{{$detail->acqDt? \Carbon\Carbon::parse($detail->acqDt)->format('d M Y'):'-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Harga Perolehan</div>
                        <div class="mytext">RM {{$detail->harga_perolehan ? number_format($detail->harga_perolehan, 2, '.', ',') : '0.00'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Siap Siaga</div>
                        <div class="mytext">{{$detail->disaster_ready == true ? "Tempahan Siap Siaga" : '-'}}</div>
                    </div>
                </div>

                <div class="col-12"></div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="box-info">
                        <div class="rlabel">Hak Milik</div>
                        <div class="mytext">{{$detail->hasOwnerType ? $detail->hasOwnerType->desc_bm : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Cawangan</div>
                        <div class="mytext">{{$detail->cawangan ? $detail->cawangan->name: '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Pegawai Bertanggungjawab</div>
                        <div class="mytext">{{$detail->hasPersonIncharge ? $detail->hasPersonIncharge->name: '-'}}</div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="box-info">
                        <div class="rlabel">Negeri</div>
                        <div class="mytext">{{$detail->hasState ? $detail->hasState->desc : '-'}}</div>
                    </div>
                    <div class="box-info">
                        <div class="rlabel">Lokasi Penempatan</div>
                        <div class="mytext">{{$detail->hasPlacement() ? $detail->hasPlacement()->desc : '-'}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="memory-lane" style="padding-top: 50px;">
    <div class="row year-timeline">
        <div class="back-shadow"><img src="{{asset('my-assets/img/shadow-timeline.png')}}" width="100%"/></div>

        @include('vehicle.vehicle-history-month.01')
        @include('vehicle.vehicle-history-month.02')
        @include('vehicle.vehicle-history-month.03')
        @include('vehicle.vehicle-history-month.04')
        @include('vehicle.vehicle-history-month.05')
        @include('vehicle.vehicle-history-month.06')
        @include('vehicle.vehicle-history-month.07')
        @include('vehicle.vehicle-history-month.08')
        @include('vehicle.vehicle-history-month.09')
        @include('vehicle.vehicle-history-month.10')
        @include('vehicle.vehicle-history-month.11')
        @include('vehicle.vehicle-history-month.12')
    </div>
</div>

<div class="modal fade" id="VehicleEventHistoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleEventHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmVehicleEventHistoryModal" method="POST">
                @csrf
                <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
                <div class="modal-body" id="prompt-container">

                    <div id="response" style="display: none" class="text-center">
                        <br/>
                        <div ><span class="text text-success" >Maklumat Berjaya Disimpan! </span></div>
                    </div>

                    <div class="form-group">
                        Adakah anda ingin menambah rekod peristiwa maklumat ini ?
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <select class="form-select" name="vehicle_event_id" id="vehicle_event_id">
                                <option selected value="">Sila Pilih</option>
                                @foreach ($vehicle_history_list as $vehicle_history)
                                    <option value="{{$vehicle_history->id}}">{{$vehicle_history->desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Tarikh Peristiwa</label>
                        <div class="input-group date" id="vehicle_event_dt">
                            <input name="vehicle_event_dt" id="vehicleEventDtInput"
                            type="text" class="form-control datepicker" placeholder=""
                            autocomplete="off"
                            data-provide="datepicker" data-date-autoclose="true"
                            data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                            value="{{Carbon\Carbon::now()->format('d/m/Y')}}"/>

                            <div class="input-group-text" for="vehicleEventDtInput">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('vehicle.history', [ 'id' => $detail->id , 'fleet_view' => $fleet_view ])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                    <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                    <button class="btn btn-danger" type="submit" xaction="add_event_history" >Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="showNextActiviesModal" tabindex="-1" aria-labelledby="showNextActiviesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-body">

        </div>
    </div>
    </div>
</div>

<script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

<script type="text/javascript">

    function showNextActivity(month, s, l){
        let event_ids = eval('nextActiviy_'+month+'_'+s+'_'+l+'_id');
        $.get("{{route('vehicle.history.next-activity')}}", {
            event_ids: event_ids,
            'fleet_view': "{{$fleet_view}}"
        }).done(function(result){
            $('#showNextActiviesModal .modal-body').html(result);
            $('#showNextActiviesModal').modal('show');
            console.log(result);

        }).fail(function(result){

        });
    }

    function prompAddVehicleEventHistory(){
        let triggerMD = $('#VehicleEventHistoryModal');
        triggerMD.modal('show');
    }

    function submitToAddVehicleEventHistory(formData){
        // hide('[xaction="add_event_history"]');

        console.log(formData);

        $.ajax({
            url: "{{route('vehicle.addEventHistory')}}",
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            data: formData,
            success: function(response) {

                let targetModal = $('#frmVehicleEventHistoryModal');
                targetModal[0].reset();
                targetModal.hide();
                window.location.reload();
                // show('[xaction="close"]');
                // hide('[xaction="no"]');
                // targetModal[0].reset();
                // targetModal.find('#response #msg').text(response.message);
                // targetModal.find('#response').show();
                // targetModal.find('#form').hide();
            },
            error: function(response) {

                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if(key == 'vehicle_event_dt'){
                        if($('#vehicle_event_dt').parent().find('.text-danger').length == 0){
                        $('#vehicle_event_dt').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                    }
                    } else {
                        if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                        $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                    }
                    }
                });

                show('[xaction="add_event_history"]');

            }
        });
    }

    function backToList(){
        window.location = "{{route('vehicle.list-alternate')}}";
    }

    $(document).ready(function() {

        let vehicle_event_dt_container = $('#vehicleEventDtInput').datepicker();

        vehicle_event_dt_container.datepicker('setEndDate', new Date());

        $('[xaction="verification"]').on('click', function(e){
            e.preventDefault();

            hide('#close_modal');
            hide('[xaction="verification"]');

            $.post("{{route('vehicle.verification')}}", {
                '_token': '{{ csrf_token() }}'
            }, function(result){
                if(result==1){
                    var message = 'Maklumat berjaya dihantar';
                    $('#submitVerificationModal .modal-body').text(message);
                    show('#back_to_list');
                }
            });

        });

        $('[xaction="verify"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="verify"]');
            hide('[xaction="no"]');

            var vehicle_ids = [];

            @if($detail)
                vehicle_ids.push({{$detail->id}});
            @endif

            $.post('{{route('vehicle.approval')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#verifyVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                backToList();
            })
        });

        $('[xaction="approve"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="approve"]');
            hide('[xaction="no"]');

            var vehicle_ids = [];

            @if($detail)
                vehicle_ids.push({{$detail->id}});
            @endif

            $.post('{{route('vehicle.approve')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#approvalVehicleModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                backToList();
            })
        });

        $('#frmVehicleEventHistoryModal').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            submitToAddVehicleEventHistory(formData);
        });

    })

</script>
</body>

</html>
