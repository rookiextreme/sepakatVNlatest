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
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>

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
    .rpt-box {
        position: relative;
        width:100px;
        text-align: left;
    }
    .sch-point {
        position: relative;
        height:30vh;
        width:100%;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
        margin-left:auto;
        margin-right:auto;
        padding:0px;

        border-radius: 15px 15px 15px 15px;
        -moz-border-radius: 15px 15px 15px 15px;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-style: solid;
        border-color:#c8c8cc;
        border-width:1px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        transition: all .2s ease-in-out;

        background-color: #ffffff;
        padding-left:10px;
        padding-right:10px;
        vertical-align: baseline;
    }
    .my-map {
        position: relative;
        text-align: center;
        height:70vh;
    }
    .rpt-link {
        height:32px;
        border-bottom-style: solid;
        border-bottom-color:rgba(0,0,0,0.13);
        border-bottom-width:1px;
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        cursor: pointer;
        text-align: left;
    }
    .rpt-link-end {
        height:32px;
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        text-align: left;
        cursor: pointer;
    }
    .rpt-link:hover,  .rpt-link-end:hover {
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        color:#ffa124;
    }
    .ico-rpt {
        height:70px;
        margin-left:0px;
        margin-bottom:10px
    }
    .rpt-title {
        font-family: helvetica-bold;
        font-size:18px;
        color:#444444;
        margin-bottom:10px;
        line-height: 30px;
    }
    .table {
        width:100%;
        margin-left:0px;
    }
    .table tbody tr {
        height:30px;
        background-color: transparent;
    }
    .table tbody tr td {
        font-family: mark;
        font-size:14px;
        line-height:30px;
        background-color: transparent;
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
    .grow {
        transform: scale(1.2);
    }
    .filter-green{
        filter: invert(48%) sepia(79%) saturate(2476%) hue-rotate(86deg) brightness(118%) contrast(119%);
    }
    .map-box {
        position: relative;left:0px;top:-2px;width:98%;height:70vh;text-align:center;
    }
    .map-point {
        transition: all .2s ease-in-out;
        position: absolute;left:0px;top:5px;width:100%;height:100%;z-index:2;
    }
    .count {
        font-size:24px;
        font-family:helve-bold;
        line-height: 24px;
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
    #info-pahang {
        position: absolute;
        z-index: 3;
        right:170px;
        top:300px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-johor {
        position: absolute;
        z-index: 3;
        right:90px;
        top:495px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-perak {
        position: absolute;
        z-index: 3;
        left:136px;
        top:215px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    .point-penang {
        position: absolute;
        width:50px;
        top:160px;
        left:50px;
        z-index: 4;
    }
    #info-penang {
        position: absolute;
        z-index: 3;
        left:25px;
        top:195px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-kedah {
        position: absolute;
        z-index: 3;
        left:105px;
        top:95px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-selangor {
        position: absolute;
        z-index: 3;
        left:180px;
        top:350px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-terengganu {
        position: absolute;
        z-index: 7;
        right:105px;
        top:191px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-kelantan {
        position: absolute;
        z-index: 3;
        right:210px;
        top:160px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    .point-kl {
        position: absolute;
        width:84px;
        height:1px;
        background-color: #264b6c;
        top:395px;
        left:138px;
        z-index:4;
    }
    #info-kl {
        position: absolute;
        z-index: 3;
        left:70px;
        top:380px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    #info-n9 {
        position: absolute;
        z-index: 3;
        right:190px;
        top:413px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    .point-melaka {
        position: absolute;
        width:80px;
        top:470px;
        left:200px;
        z-index: 4;
    }
    #info-melaka {
        position: absolute;
        z-index: 3;
        left:150px;
        top:470px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    .point-ketengah {
        position: absolute;
        width:70px;
        top:250px;
        right:50px;
        z-index: 4;
    }
    #info-ketengah {
        position: absolute;
        z-index: 3;
        right:10px;
        top:270px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    .point-kesedar {
        position: absolute;
        width:130px;
        top:120px;
        right:80px;
        z-index: 4;
    }
    #info-kesedar {
        position: absolute;
        z-index: 3;
        right:20px;
        top:110px;
        cursor: pointer;
        transition: all .1s ease-in-out;
    }
    .point-perlis {
        position: absolute;
        width:110px;
        top:27px;
        left:84px;
        z-index: 4;
    }
    #info-perlis {
        position: absolute;
        z-index: 3;
        left:190px;
        top:50px;
        transition: all .1s ease-in-out;
        cursor: pointer;
    }
    .dis-states {
        position: absolute;
        top:30vh;
        width:200px;
        top:0px;
        z-index: 10;
    }
    .dis-map {
        position: absolute;
        left:48%;
        top:30vh;
        width:50px;
        z-index: 5;
        transition: all .2s ease-in-out;
    }
    .dis-johor {
        position: absolute;
        left:28%;
        top:30vh;
        width:50px;
        z-index: 5;
        transition: all .2s ease-in-out;
    }
    .dis-kedah {
        position: absolute;
        left:28%;
        top:30vh;
        width:50px;
        z-index: 5;
        transition: all .2s ease-in-out;
    }
    .dis-melaka {
        position: absolute;
        left:28%;
        top:30vh;
        width:50px;
        z-index: 5;
        transition: all .2s ease-in-out;
    }
    .rpt-link {
        height:28px;
        width:100%;
        border-bottom-style: solid;
        border-bottom-color:rgba(0,0,0,0.13);
        border-bottom-width:1px;
        line-height: 28px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:14px;
        color:#313131;
        cursor: pointer;
    }
    .rpt-link-end {
        height:32px;
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        cursor: pointer;
    }
    .grow {
        transform: scale(8);
        transform-origin: center;
    }
    .rpt-link:hover,  .rpt-link-end:hover {
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        color:#ffa124;
    }
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
	}
</style>
<script>
    $(document).ready(function() {

    });
</script>
</head>
<body class="content">
<div class="sect-top">
    <div class="spectitle">Taburan Kenderaan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('vehicle.report')}}');">Laporan &amp; Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('report.report_map_peninsular')}}');">Mengikut Negeri</a></li>
        <li class="breadcrumb-item active" aria-current="page">Mengikut Daerah</li>
        </ol>
    </nav>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><h6 class="dropdown-header">Mengikut</h6></li>
        <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.report_compositions')}}'">Negeri</a></li>
        <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.report_compositions')}}'">Daerah</a></li>
    </ul>
</div>
<div class="sect-top-dummy"></div>

<div class="my-map">
    <div class="dis-states">
        <div class="rpt-link" onclick="showState('johor')">Johor</div>
        <div class="rpt-link" onclick="showState('kedah')">Kedah</div>
        <div class="rpt-link" onclick="showState('kelantan')">Kelantan</div>
        <div class="rpt-link" onclick="showState('melaka')">Melaka</div>
        <div class="rpt-link">Pahang</div>
        <div class="rpt-link">Perak</div>
        <div class="rpt-link">Perlis</div>
        <div class="rpt-link">Pulau Pinang</div>
        <div class="rpt-link">Sabah</div>
        <div class="rpt-link">Sarawak</div>
        <div class="rpt-link">Terengganu</div>
        <div class="rpt-link">WP Kuala Lumpur</div>
        <div class="rpt-link">WP Putrajaya</div>
        <div class="rpt-link">KESEDAR</div>
        <div class="rpt-link-end">KETENGAH</div>
    </div>
    <div class="dis-map" id="dis-johor">
        <img src="{{asset('my-assets/img/map-johor.svg')}}" alt="" width="100%"/>
    </div>
    <div class="dis-map" id="dis-kedah">
        <img src="{{asset('my-assets/img/map-kedah.svg')}}" alt="" width="100%"/>
    </div>
    <div class="dis-map" id="dis-kelantan">
        <img src="{{asset('my-assets/img/map-kelantan.svg')}}" alt="" width="100%"/>
    </div>
    <div class="dis-map" id="dis-melaka">
        <img src="{{asset('my-assets/img/map-melaka.svg')}}" alt="" width="100%"/>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
    })
</script>
<script>
    function showState(state) {
        $('.dis-map').removeClass('grow');
        $('.dis-map').fadeOut('fast');
        $('#dis-' + state).fadeIn('fast');
        $('#dis-' + state).addClass('grow');
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
