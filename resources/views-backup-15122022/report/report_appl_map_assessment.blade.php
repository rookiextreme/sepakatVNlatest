@php
use App\Models\RefWorkshop;

$woksyop_list = RefWorkshop::all();

@endphp
{{--  @json($woksyop_list)  --}}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<script src="{{ asset('my-assets/bootstrap/js/popper.js') }}" type="text/javascript"></script>

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>
<style type="text/css">
    /*body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
        padding:20px;
    }*/
    body {
        background-color: #f4f5f2;
    }
    .spectitle {
        margin-top:24px;
        font-family: helvetica-bold;
        font-size:24px;
        letter-spacing: -1px;
        color:#313131;
        transition: all .1s ease-in-out;
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
    .dropdown-menu {
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
    }
    .sect-top-dummy {
        height:140px;
    }
    .state-map {
        transition: all .1s ease-in-out;
    }

    .whole-map {
        position:relative;
        width:100%;
        height:500px;
    }
    .map-left {
        position:absolute;
        top:20px;
        left:40px;
        height:500px;
        width:auto;
        text-align:center;
        z-index:2;
        transition: all 0.4s ease-in;
    }
    .map-right {
        position: absolute;
        top:20px;
        right:40px;
        height:500px;
        widht:800px;
        z-index:2;
        transition: all 0.4s ease-in;
    }
    .move-to-left {
        transform: translateX(-450px);
        transition-timing-function: ease-out;
    }
    .move-to-right {
        transform: translateX(750px);
        transition-timing-function: ease-out;
    }
    .shrink {
        transform: scale(0.8);
        transform-origin: top left;
    }
    .kepit {
        transform: scale(0.7);
    }
    .grow {
        transform: scale(1.2);
    }
    .dropdown-item {
        font-family: mark;
        font-size:14px;
    }
    .dropdown-item a {
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
    .woksyop {
        font-family:mark;
        font-size:12px;
        line-height: 12px;
        color:#34898e;
    }
    .count {
        font-size:24px;
        font-family:helve-bold;
        line-height: 24px;
        color:#212121;
    }
    .count.giant {
        font-size:36px;
        font-family:helve-thin;
        line-height: 36px;
        color:#212121;
    }
    .count.sm {
        font-size:18px;
        line-height: 22px;
    }
    .count.xs {
        font-size:16px;
        line-height: 16px;
    }
    .count:hover {
        color:#34898e;
    }
    .state {
        font-size:14px;
        font-family:mark;
        line-height: 16px;
        color:#34898e;
    }
    .state.sm {
        font-size:12px;
        line-height: 12px;
    }
    .state.xs {
        font-size:10px;
        line-height: 10px;
    }

    /*negeri*/
    #info-johor {
        right:50px;
        top:355px;
    }
    #info-pahang {
        right:120px;
        top:220px;
    }
    #info-kelantan {
        right:140px;
        top:86px;
    }
    #info-terengganu {
        z-index: 7;
        right:70px;
        top:135px;
        font-size:10px;
    }
    .point-penang {
        position: absolute;
        width:50px;
        top:160px;
        left:50px;
        z-index: 4;
    }
    #info-penang {
        left:0px;
        top:120px;
        font-size:10px;
    }
    #info-penang .count {
        font-size:18px;
        line-height: 20px;
    }
    #info-perak {
        left:90px;
        top:140px;
    }
    #info-kedah {
        left:66px;
        top:50px;
    }
    #info-perlis {
        left:128px;
        top:0px;
    }
    .point-perlis {
        position: absolute;
        width:70px;
        height:1px;
        background-color: #264b6c;
        top:15px;
        left:55px;
        z-index:4;
    }
    #info-labuan {
        right:245px;
        top:50px;
        width:100px;
        line-height:10px;
    }
    #info-kl {
        left:10px;
        top:270px;
        width:100px;
        line-height:10px;
    }
    .point-kl {
        position: absolute;
        width:75px;
        height:1px;
        background-color: #264b6c;
        top:284px;
        left:85px;
        z-index:4;
    }
    #info-selangor {
        left:128px;
        top:245px;
        font-size:9px;
        text-align: center;
        line-height:10px;
    }
    #info-selangor .count {
        font-size:18px;
        line-height: 20px;
    }
    #info-n9 {
        left:165px;
        top:300px;
        font-size:9px;
    }
    #info-n9 .count {
        font-size:18px;
        line-height: 20px;
    }
    .point-persekutuan {
        position: absolute;
        width:30px;
        height:41px;
        border-left-style: solid;
        border-left-width:1px;
        border-left-color:#264b6c;
        border-top-style: solid;
        border-top-width:1px;
        border-top-color:#264b6c;
        top:303px;
        left:128px;
        z-index:4;
    }
    #info-persekutuan {
        left:75px;
        top:350px;
        width:100px;
        line-height:10px;
    }
    .point-melaka {
        position: absolute;
        width:1px;
        height:40px;
        background-color:#264b6c;
        top:349px;
        left:206px;
        z-index:4;
    }
    #info-melaka {
        left:186px;
        top:390px;
    }
    #info-sabah {
        right:140px;
        top:95px;
    }
    #info-sarawak {
        left:250px;
        top:370px;
    }


    .point {
        /*dont delete*/
    }
    .info {
        position: absolute;
        z-index: 3;
        cursor: pointer;
        transition: all .1s ease-in-out;
        font-family: mark;
        font-size:12px;
        text-align: center;
        color:#2c5c6a;
    }
    .info-daerah {
        position: absolute;
        z-index: 28;
        cursor: pointer;
        transition: all .1s ease-in-out;
        font-family: mark;
        font-size:12px;
        line-height: 12px;
        text-align: center;
        color:#2c5c6a;
    }
    .info-daerah.xs {
        font-size:10px;
        line-height: 10px;
    }
    .info-daerah-master {
        position: absolute;
        z-index: 28;
        transition: all .1s ease-in-out;
        font-family: mark-bold;
        font-size:20px;
        line-height:22px;
        text-align: center;
        color:#249eba;
        border-color: #2c5c6a;
        border-width: 1px;
        border-style: solid;
        padding:10px;
    }


    .point-shahalam {
        position: absolute;
        width:140px;
        height:1px;
        background-color: #264b6c;
        top:276px;
        left:140px;
        z-index:4;
    }
    .point-petaling {
        position: absolute;
        border-left-style: solid;
        border-left-width:1px;
        border-left-color:#264b6c;
        border-top-style: solid;
        border-top-width:1px;
        border-top-color:#264b6c;
        width:80px;
        height:105px;
        top:172px;
        right:95px;
        z-index:4;
    }



    .mobile-btn-right {
        display:none;
        position: absolute;
        z-index: 10;
        right:5%;
        top:150px;
    }
    .mobile-btn-left {
        display:none;
        position: absolute;
        left:5%;
        top:150px;
        z-index: 10;
    }
    .move-left {
        transform: translateX(-100vw);
    }
    .state-shutter {
        display: none;
        position: fixed;
        left:200px;
        top:45vh;
        z-index:14;
        cursor: pointer;
    }
    .scale-up {
        transform: scale(1.1);
        transform-origin: top center;
        transition: all .4s ease-in-out;
    }
    .map-state {
        display: none;
        margin-top:20px;
        width:100%;
        height:50vh;
        padding-top:0px;
        overflow-y:hidden;
        text-align: center;
        z-index:10;
    }
    .map-state .map {
        position: fixed;
        /*margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);*/
        text-align: center;
        height:100%;
        width:500px;
    }
    .map-state .map img {
        margin-top:10px;
        filter: drop-shadow(-1px 8px 5px rgba(44,92,106, 0.3));
        -webkit-filter: drop-shadow(-1px 8px 5px rgba(44,92,106, 0.3));
        -moz-filter: drop-shadow(-1px 8px 5px rgba(44,92,106, 0.3));
    }
    /*MAP JOHOR*/
    .map-state-johor {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:450px;
        overflow-y:hidden;
    }
    .map-state-johor .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-johor .map img {
        width:450px;
        margin-right:20px;
        margin-top:20px;
    }

    /*MAP PAHANG*/
    .map-state-pahang {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:480px;
        overflow-y:hidden;
    }
    .map-state-pahang .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-pahang .map img {
        width:450px;
        margin-top:20px;
    }

    /*MAP MELAKA*/
    .map-state-melaka {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:480px;
        overflow-y:hidden;
    }
    .map-state-melaka .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-melaka .map img {
        width:450px;
        margin-top:85px;
    }

    /*MAP N9*/
    .map-state-n9 {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:480px;
        overflow-y:hidden;
    }
    .map-state-n9 .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-n9 .map img {
        width:470px;
        margin-top:35px;
    }

    /*MAP KUALA LUMPUR*/
    .map-state-kl {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:480px;
        overflow-y:hidden;
    }
    .map-state-kl .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-kl .map img {
        width:340px;
        margin-top:0px;
    }

    /*MAP SELANGOR*/
    .map-state-selangor {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:480px;
        overflow-y:hidden;
    }
    .map-state-selangor .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-selangor .map img {
        width:450px;
        margin-top:0px;
    }

    /*MAP PERAK*/
    .map-state-perak {
        position: absolute;
        top:140px;
        left:10px;
        width:100%;
        height:530px;
        overflow-y:hidden;
    }
    .map-state-perak .map {
        width:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-perak .map img {
        width:320px;
        margin-top:0px;
    }

    /*MAP KEDAH*/
    .map-state-kedah {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:500px;
        overflow-y:hidden;
    }
    .map-state-kedah .map {
        width:500px;
        height:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-kedah .map img {
        width:440px;
        margin-top:0px;
    }

    /*MAP PENANG*/
    .map-state-penang {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:400px;
        overflow-y:hidden;
    }
    .map-state-penang .map {
        width:500px;
        height:400px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-penang .map img {
        width:300px;
        margin-top:30px;
    }

    /*MAP PERLIS*/
    .map-state-perlis {
        position: absolute;
        top:120px;
        left:10px;
        width:100%;
        height:450px;
        overflow-y:hidden;
    }
    .map-state-perlis .map {
        width:400px;
        height:450px;
        margin-left:-webkit-calc((100% - 400px)/2);
        margin-left:-moz-calc((100% - 400px)/2);
        margin-left:calc((100% - 400px)/2);
    }
    .map-state-perlis .map img {
        width:250px;
        margin-top:25px;
    }

    /*MAP KELANTAN*/
    .map-state-kelantan {
        position: absolute;
        top:140px;
        left:10px;
        width:100%;
        height:520px;
        overflow-y:hidden;
    }
    .map-state-kelantan .map {
        width:500px;
        height:540px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-kelantan .map img {
        width:350px;
        margin-top:30px;
    }

    /*MAP TERENGGANU*/
    .map-state-terengganu {
        position: absolute;
        top:120px;
        left:10px;
        width:100%;
        height:520px;
        overflow-y:hidden;
    }
    .map-state-terengganu .map {
        width:500px;
        height:520px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-terengganu .map img {
        width:340px;
        margin-top:0px;
    }

    /*MAP SABAH*/
    .map-state-sabah {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:520px;
        overflow-y:hidden;
    }
    .map-state-sabah .map {
        width:500px;
        height:520px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-sabah .map img {
        width:460px;
        margin-top:30px;
    }
    .back-hias {
        position: absolute;
        z-index:1;
        left:10%;
        top:100px;
        width:80%;
        height:300px;
        background-color:#b5d6d7;
    }
    @media (max-height: 400px) {
        .spectitle {
            margin-top:16px;
            font-family: helvetica-bold;
            font-size:16px;
            letter-spacing: -1px;
            color:#313131;
        }
    }
    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
	}
    @media (max-width: 1200px) {
        /*special*/

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
        .whole-map {
            margin-top:-50px;
            height:440px;
        }
        .mobile-btn-right {
            display: inline;
        }
        .map-left {
            left:0px;
            top:0px;
            padding-top:0px;
            width:100%;
            z-index: 4;
            height:440px;
            transition: all .2s ease-in-out;
        }
        .map-left img {
            width:300px;
        }
        .map-right {
            left:100vw;
            padding-top:80px;
            margin-top:0px;
            top:0px;
            width:100%;
            z-index:4;
            height:440px;
            text-align: center;
            transition: all .2s ease-in-out;
        }
        .map-right img {
            width:400px;
        }
        /*.map-state-kualaLumpur .map .info-daerah-master {
            top:0px;
            left:20px;
            width:90px;
            height:102px;
        }*/
	}
</style>
<script>
    $(document).ready(function() {
        //goState('terengganu');
    });
</script>
</head>
<body>
<div class="sect-top">
    <div class="spectitle">Taburan Penilaian</div>
    <nav aria-label="breadcrumb" class="float-start" style="width:40%">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('assessment.report')}}');">Laporan &amp; Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page" id="negeri">Taburan Kenderaan mengikut Woksyop</li>
        </ol>
    </nav>
    <div class="inline float-end" style="margin-top:15px;margin-right:30px;">
        <button type="button" class="btn cux-btn bigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Oktober 2021
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="max-width: 50px !important">
            <li class="text-end"><a class="dropdown-item">Oktober 2021</a></li>
            <li class="text-end"><a class="dropdown-item">November 2021</a></li>
            <li class="text-end"><a class="dropdown-item">Disember 2021</a></li>
            <li class="text-end"><a class="dropdown-item">January 2022</a></li>
        </ul>
        <div class="dropdown inline float-end">
            <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        </div>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="state-shutter" onClick="letGoState()"><i class="fas fa-arrow-circle-left fa-2x"></i></div>

<div class="whole-map">
    <div class="mobile-btn-right"><i class="fas fa-arrow-circle-right fa-2x" onclick="moveMap('right')"></i></div>
    <div class="mobile-btn-left" onclick="moveMap('left')"><i class="fas fa-arrow-circle-left fa-2x"></i></div>
    <div class="back-hias"></div>
    <div class="map-left">
        @php
            $woksyopRefs = [
                '01' => [
                    'spot' =>'persekutuan',
                    'desc' => '',
                    'view' => true,
                ],
                '02' => [
                    'spot' =>'johor',
                    'desc' => '',
                    'view' => true,
                ],
                '03' => [
                    'spot' =>'kedah',
                    'desc' => '',
                    'view' => true,
                ],
                '04' => [
                    'spot' =>'kelantan',
                    'desc' => '',
                    'view' => true,
                ],
                '05' => [
                    'spot' =>'melaka',
                    'desc' => '',
                    'view' => true,
                ],
                '06' => [
                    'spot' =>'n9',
                    'desc' => '',
                    'view' => true,
                ],
                '07' => [
                    'spot' =>'pahang',
                    'desc' => '',
                    'view' => true,
                ],
                '08' => [
                    'spot' =>'penang',
                    'desc' => '',
                    'view' => true,
                ],
                '09' => [
                    'spot' =>'perak',
                    'desc' => '',
                    'view' => true,
                ],
                '10' => [
                    'spot' =>'perlis',
                    'desc' => '',
                    'view' => true,
                ],
                '11' => [
                    'spot' =>'selangor',
                    'desc' => '',
                    'view' => true,
                ],
                '12' => [
                    'spot' =>'terengganu',
                    'desc' => '',
                    'view' => true,
                ],
            ];
        @endphp
        @foreach ($woksyop_list as $state)
            @php
            $ckm_label;
            if($state->desc === "JKR CKM" ){
                echo "yes";
            }
            //  remove space  /\s+/
                $string = "JKR";
                $totalP_Peninsular = count($state->hasNew) + count($state->hasAccident) + count($state->hasDisposal) + count($state->hasCurrvalue)
                    + count($state->hasGovLoan) + count($state->hasSafety);
                    $new_name = str_replace($string, "",$state->desc);

                if($state->desc == 'JKR CKM NEGERI PERLIS'){
                    $ckm_label = 'CKM<br/>Perlis';
                }else if($state->desc == 'JKR CKM NEGERI KEDAH'){
                    $ckm_label = 'CKM<br/>Kedah';
                }else if($state->desc == 'JKR CKM NEGERI PULAU PINANG'){
                    $ckm_label = 'CKM<br/>Penang';
                }else if($state->desc == 'JKR CKM NEGERI KELANTAN'){
                    $ckm_label = 'CKM<br/>Kelantan';
                }else if($state->desc == 'JKR CKM NEGERI JOHOR'){
                    $ckm_label = 'CKM<br/>Johor';
                }else if($state->desc == 'JKR CKM NEGERI MELAKA'){
                    $ckm_label = 'CKM<br/>Melaka';
                }else if($state->desc == 'JKR CKM NEGERI PAHANG'){
                    $ckm_label = 'CKM<br/>Pahang';
                }else if($state->desc == 'JKR CKM NEGERI SELANGOR'){
                    $ckm_label = 'CKM<br/>Selangor';
                }else if($state->desc == 'JKR CKM NEGERI N.SEMBILAN'){
                    $ckm_label = 'CKM<br/>N.Sembilan';
                }else if($state->desc == 'JKR CKM NEGERI TERENGGANU'){
                    $ckm_label = 'CKM<br/>T\'ganu';
                }else if($state->desc == 'JKR CKM NEGERI PERAK'){
                    $ckm_label = 'CKM<br/>Perak';
                }else if($state->desc == 'JKR WOKSYOP PERSEKUTUAN'){
                    $ckm_label = 'WSP';
                }
            @endphp
            @if(isset($woksyopRefs[$state->code]) && $woksyopRefs[$state->code]['view'])
            <div id="info-{{$woksyopRefs[$state->code]['spot']}}" class="info" onClick="alert('Jumlah Penilaian {{$totalP_Peninsular}} untuk {{$state->desc}}');"><div class="count">{{$totalP_Peninsular}}</div><div class="woksyop">{{ print $ckm_label}}</div></div>
            @endif
        @endforeach
        {{-- <div class="point-kl point"></div>--}}
        <div class="point-perlis point"></div>
        <div class="point-persekutuan point"></div>
        <div class="point-penang point"></div>
        {{--<div class="point-melaka point"></div> --}}
        <img src="{{asset('my-assets/img/peninsular-min.png')}}" alt="" height="450px" style="z-index:2" usemap="#Map" class="img-peninsular"/>
		<!--<img src="../../../public/my-assets/img/peninsular.png" alt="" width="450px" usemap="#Map" class="img-peninsular"/>-->
        <map name="Map">
          <area id="spot-johor" shape="poly" coords="299,390,298,412,299,426,290,428,285,443,290,465,298,469,313,471,343,494,353,497,371,527,386,511,415,518,438,525,451,525,425,465,398,412,387,406,387,427,369,420,334,419,305,398" href="javascript:goState('johor')">
          <area id="spot-pahang" shape="poly" coords="185,223,192,245,201,257,202,283,217,293,224,308,220,323,235,334,250,335,272,346,294,365,316,379,331,397,358,398,371,402,372,389,356,373,360,315,348,295,355,278,328,263,309,270,306,258,323,233,309,232,309,214,291,208,281,210,258,220,243,209,237,209,231,221,223,220,217,216,208,227,186,224" href="javascript:goState('pahang')">
          <area id="spot-melaka" shape="poly" coords="230,424,247,420,262,420,277,426,273,451,248,444,231,426" href="javascript:alert('Melaka');goState('melaka')">
          <area id="spot-n9" shape="poly" coords="215,401,218,414,226,415,244,408,259,407,276,411,285,413,293,378,277,368,267,357,245,347,235,349,225,374,217,377,216,400" href="javascript:goState('n9')">
          <area id="spot-persekutuan" shape="poly" coords="193,369,190,377,195,382,201,370,195,369">
          <area id="spot-kl" shape="poly" coords="194,342,190,349,191,361,200,363,208,347,196,342" href="javascript:goState('kualaLumpur')">
          <area id="spot-perak" shape="poly" coords="73,160,89,183,94,209,92,243,102,251,112,256,105,265,117,278,160,293,167,289,182,295,193,291,186,248,169,214,186,139,196,136,203,127,199,119,201,101,192,86,161,94,159,118,139,96,133,126,127,138,116,142,108,159,85,158" href="javascript:goState('perak')">
          <area id="spot-penang" shape="poly" coords="76,119,71,124,55,121,55,141,66,141,74,129,76,151,88,151,90,123,85,115,76,117" href="javascript:goState('penang')">
          <area id="spot-kedah" shape="poly" coords="33,45,64,58,72,107,89,107,95,116,94,146,99,147,106,136,121,129,141,76,152,56,117,29,88,23,65,51,35,41,29,23,1,23,11,58" href="javascript:goState('kedah')">
          <area id="spot-perlis" shape="poly" coords="60,5,58,25,51,32,57,44,63,42,79,23,75,9,71,4,63,6" href="javascript:goState('perlis')">
          <area id="spot-kelantan" shape="poly" coords="208,101,206,119,210,130,201,143,191,144,180,205,197,205,208,196,221,202,233,189,251,200,280,191,274,174,264,139,264,107,276,93,262,66,251,56,240,55,237,74,224,93,208,101" href="javascript:goState('kelantan')">
          <area id="spot-terengganu" shape="poly" coords="291,101,281,112,281,143,295,192,316,201,319,216,332,221,334,229,319,248,320,252,334,248,359,263,370,235,370,192,341,140,330,124,318,123,292,102" href="javascript:goState('terengganu')">
          <area id="spot-selangor" shape="poly" coords="124,294,137,298,152,304,165,309,173,301,183,309,197,301,208,307,210,320,207,334,218,341,210,341,195,334,187,347,187,358,191,364,184,378,197,385,206,367,214,350,227,343,218,366,209,375,205,398,186,400,166,381,151,367,163,351,155,328,138,309,123,295" href="javascript:goState('selangor')">
          <area shape="poly" coords="68,49" href="#">
          <area shape="poly" coords="22,397" href="#">
        </map>
    </div>
	<div class="map-right">
        @php
            $woksyopRefs = [
                '13' => [
                    'spot' =>'labuan',
                    'desc' => '',
                    'view' => true,
                ]
            ];
        @endphp
        @foreach ($woksyop_list as $state)
            @php
                $string = "JKR";
                $totalP_East = count($state->hasNew) + count($state->hasAccident) + count($state->hasDisposal) + count($state->hasCurrvalue)
                    + count($state->hasGovLoan) + count($state->hasSafety);
                    $new_name = str_replace($string, "",$state->desc);
                if($state->desc == 'JKR CKM WP LABUAN'){
                    $ckm_label = 'WSL';
                }
            @endphp
            @if(isset($woksyopRefs[$state->code]) && $woksyopRefs[$state->code]['view'])
            <div id="info-{{$woksyopRefs[$state->code]['spot']}}" class="info" onClick="alert('Jumlah Penilaian {{$totalP_East}} untuk {{$state->desc}}');"><div class="count">{{$totalP_East}}</div><div class="woksyop">{{ print $ckm_label}}</div></div>
            @endif
        @endforeach
        <img src="{{asset('my-assets/img/borneo-min.png')}}" alt="" height="450px" usemap="#MapBorneo" class="img-borneo" style="z-index:2"/>
	    <!--<img src="../../../public/my-assets/img/borneo.png" alt="" width="450px" usemap="#MapBorneo" class="img-borneo"/>-->
        <map name="MapBorneo">
          <area id="spot-labuan" shape="poly" coords="259,73,253,85,266,83,259,74">
          <area id="spot-sabah" shape="poly" coords="261,97,277,88,269,77,277,67,301,53,302,39,330,4,355,5,355,17,376,23,371,48,390,43,396,56,408,57,420,64,437,76,446,73,447,85,416,98,399,94,421,123,401,122,386,128,372,120,372,129,365,132,353,124,288,126,280,113,283,97" href="javascript:goState('sabah')">
          <area id="spot-sarawak"shape="poly" coords="7,237,51,285,79,275,93,279,121,273,129,256,159,250,166,259,192,267,210,254,235,255,260,208,259,189,274,183,283,131,272,115,273,102,245,106,234,138,209,116,164,181,93,196,74,257,9,239" href="#">
        </map>
  </div>
</div>
<script>

    function initializeStateValue(){

        let state_code, state_name, state_total = 0;

        @foreach ($woksyop_list as $item)
            state_code = "{{$item->code}}";
            state_name = "{{$item->state_name}}";
            state_total = {{$item->total_by_state}};

            //alert("state_code : "+state_code+" - state_name : "+state_name+" - state_total : "+state_total  );

            @if ($item->code == '01')
                $('.map-state-johor .count.giant').text(state_total);
            @endif
            @if ($item->code == '02')
                $('.map-state-kedah .count.giant').text(state_total);
            @endif
        @endforeach
    }

    jQuery(document).ready(function() {
        initializeStateValue();
        $(window).resize(function() {
            var wh = $(window).height();
            $('#negeri').text($(window).width());
            if (wh < 650) {
                $('.sect-top, .sect-top-dummy').slideUp();
            } else {
                $('.sect-top, .sect-top-dummy').slideDown();
            }
        });
    })
</script>
<script>
    function moveMap(which){
        if(which == 'right') {
            $('.map-left').addClass('move-left');
            $('.map-right').addClass('move-left');
            $('.mobile-btn-right').fadeOut();
            $('.mobile-btn-left').fadeIn();
        }else{
            $('.map-left').removeClass('move-left');
            $('.map-right').removeClass('move-left');
            $('.mobile-btn-left').fadeOut();
            $('.mobile-btn-right').fadeIn();
        }
    }
    function goState(state, state_code) {
        $('.map-left').addClass('move-to-left');
        var moveLeft = $('.map-right').addClass('move-to-right');
        moveLeft.after(function(){
            showState(state);
            $('.back-hias').animate({'width': '50%', 'left': '25%'},'fast')
        })

        //alert(state+' - '+state_code);
        var url = '{{route('report.report_district_details')}}';


        $.ajax({

             url: url,
             data: {stateCode: state_code},
            cache: false,
            //contentType: false,
            //processData: false,
            dataType:'json',
            method: 'GET',
            success: function(data){

                //alert(data.length);
                for (let i = 0; i < data.length; i++) {
                    var totalFleet = data[i].total_fleet;
                    var districtName = data[i].description;
                    var order = data[i].order;

                    $(".map-state-"+state.toLowerCase()+" .info-daerah[xorder='"+order+"'] .count").html(totalFleet);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(xhr.status);
                var err = eval("(" + xhr.responseText + ")");
                //alert(err.Message);
            }
        });

    }


    function showState(state) {
        $('.map-state-' + state).fadeIn('fast').addClass('scale-up');
        $('.info, .point').hide();
        $('#daerah').show();
        $('.state-shutter').fadeIn('fast');
        if(state == 'n9'){
            state = "Negeri Sembilan";
        }else if(state == 'wilayah'){
            state = "WSP";
        }else if(state == 'kualaLumpur'){
            state = "WSP";
        }else if(state == 'penang'){
            state = "Pulau Pinang";
        }
        $('#negeri').text(toTitleCase(state));
    }
    /*function letGoState(state) {
        $('.img-peninsular, .img-borneo').fadeIn().removeClass('shrink');
        $('.map-state-' + state).fadeOut('fast');
        $('#daerah').hide();
        $('#negeri').text('Taburan Kenderaan mengikut Negeri');
        $('.info, .point').show('fast');
        $('.state-shutter').fadeOut('fast');
    }
    function letGoState() {
        //$('.img-peninsular, .img-borneo').fadeIn().removeClass('shrink');
        $('.map-left').removeClass('move-to-left');
        $('.map-right').removeClass('move-to-right');
        $('.map-state').removeClass('scale-up');
        $('.map-state').fadeOut('fast');
        $('#daerah').hide();
        $('#negeri').text('Taburan Kenderaan mengikut Negeri');
        $('.info, .point').show('fast');
        $('.state-shutter').fadeOut('fast');
        $('.back-hias').animate({'width': '80%', 'left': '10%'}, 'fast');

    }*/
    function toTitleCase(str) {
        return str.replace(
            /\w\S*/g,
            function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        );
    }
    function bringUp(idName) {
        $('#float-' + idName).css("z-index", "4");
    }
    function bringDown(idName) {
        $('#float-' + idName).css("z-index", "1");
    }
    function growMap(idName) {
        $('#info-' + idName).addClass('grow');
    }
    function shrinkMap(idName) {
        $('#info-' + idName).removeClass('grow');

    }
</script>
</body>
</html>
