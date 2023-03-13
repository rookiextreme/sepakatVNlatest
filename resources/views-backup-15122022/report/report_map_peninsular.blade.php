@php
use App\Http\Controllers\Report\ReportMapPeninsularDAO;
use App\Models\Fleet\FleetTotalRecordByState;

$ReportMapPeninsularDAO = new ReportMapPeninsularDAO();
$ReportMapPeninsularDAO->mount();
$total_record_by_state = $ReportMapPeninsularDAO->total_record_by_state;

@endphp
{{--  @json($total_record_by_state)  --}}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>Aodo</title>
{{--JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian--}}
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
        z-index:5;
        transition: all 0.4s ease-in;
    }
    .map-right {
        position: absolute;
        top:20px;
        right:40px;
        height:500px;
        widht:800px;
        z-index:5;
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
    .countdrilless {
        font-size:24px;
        font-family:helve-bold;
        line-height: 24px;
        color:#212121;
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
        right:110px;
        top:220px;
    }
    #info-kelantan {
        right:140px;
        top:110px;
    }
    #info-terengganu {
        z-index: 7;
        right:70px;
        top:135px;
        font-size:10px;
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
    #info-putrajaya {
        left:75px;
        top:350px;
        width:100px;
        line-height:10px;
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
    .point-perlis {
        position: absolute;
        width:70px;
        height:1px;
        background-color: #264b6c;
        top:15px;
        left:55px;
        z-index:4;
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

    .point-putrajaya {
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

    .point-melaka {
        position: absolute;
        width:1px;
        height:40px;
        background-color:#264b6c;
        top:349px;
        left:206px;
        z-index:4;
    }



    .point {
        /*dont delete*/
    }
    .infoonly {
        position: absolute;
        z-index: 3;
        transition: all .1s ease-in-out;
        font-family: mark;
        font-size:12px;
        text-align: center;
        color:#2c5c6a;
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
        color: #1f272a;
        /* background: #4242423b;
        border-radius: 5px;
        padding: 3px; */
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

    /*MAP WILAYAH*/
    .map-state-wilayah {
        position: absolute;
        top:150px;
        left:10px;
        width:100%;
        height:500px;
        overflow-y:hidden;
    }
    .map-state-wilayah .map {
        width:500px;
        height:500px;
        margin-left:-webkit-calc((100% - 500px)/2);
        margin-left:-moz-calc((100% - 500px)/2);
        margin-left:calc((100% - 500px)/2);
    }
    .map-state-wilayah .map img {
        width:440px;
        margin-top:0px;
    }

    .back-hias {
        position: absolute;
        z-index:1;
        left:10%;
        top:100px;
        width:80%;
        height:300px;
        /* background-color:#b5d6d7; */
    }
    .drill-further {
        position: absolute;
        right:-420px;
        top:0px;
        height:100%;
        width:400px;
        background-color:#ffffff;
        border-left-color:#f1f1f1;
        border-left-width: 1px;
        border-left-style: solid;
        z-index:50;
        box-shadow: -7px 0px 35px -7px rgba(0,0,0,0.27);
        -webkit-box-shadow: -7px 0px 35px -7px rgba(0,0,0,0.27);
        -moz-box-shadow: -7px 0px 35px -7px rgba(0,0,0,0.27);
        padding:15px;
    }
    .sub-win-title {
		font-family: lato-bold;
        color:#303030;
		letter-spacing: -1px;
		font-size: 20px;
		line-height: 18px;
		margin-bottom:10px;
		margin-top:10px;
	}
    .sub-win-title span {
        letter-spacing: 0px;
    }
    .list-viewer {
        width:100%;
        height:85%;
        overflow:scroll;
    }
    .btn-closer {
        position: absolute;
        right:10px;
        top:18px;
        width:35px;
        cursor: pointer;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        text-align: center;
        padding-left:10px;
        padding-right:10px;
    }
    .btn-closer:hover {
        background-color:#d2d0da;
    }
    .thin-topline {
        border-top-width: 1px;
        border-top-color:#c9d1c1;
        border-top-style: solid;
    }
    .btnBoxRight {
        position: absolute;right:25px;top:80px;
    }
    .title-report {
        display:none;
    }
    body > .print-frame > .footer {
        display:none;
        width:100%;
    }
    .img-peninsular, .img-borneo {
        height:450px;
    }
    .back-hias .split {
        display:none;
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
        .map-right {
            top:40px;
        }
        .back-hias {
            height:500px;
        }
        .back-hias .split {
            display:block;
            width:100%;
            text-align: center;
        }
        .back-hias .split img {
            height:500px;
        }
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
        .map-left {
            left:22%;
            top:30px;
            padding-top:0px;
            width:370px;
            z-index: 4;
            height:440px;
            transition: all .2s ease-in-out;
        }
        .map-right {
            left:100vw;
            padding-top:50px;
            margin-top:0px;
            top:0px;
            width:100%;
            z-index:4;
            height:500px;
            text-align: center;
            transition: all .2s ease-in-out;
        }
        .img-peninsular {
            height:450px;
        }
        .img-borneo {
            height:300px;
        }
        .mobile-btn-right {
            display: inline;
            top:230px;
            right:3%;
        }
        .mobile-btn-left {
            display:none;
            left:3%;
            top:230px;
        }
        .back-hias {
            height:300px;
        }
        .back-hias .split {
            display:none;
        }
        #info-sabah {
            right:210px;
            top:105px;
        }
        #info-labuan {
            right:270px;
            top:85px;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/

        .mobile-btn-right {
            display: inline;
        }
        .map-left {
            left:10%;
            width:100%;
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
        /*.map-state-kualalumpur .map .info-daerah-master {
            top:0px;
            left:20px;
            width:90px;
            height:102px;
        }*/
	}

    @media print {
        @page {size: A4 landscape}

        html,body {
            height:100%;
            background-color:#ffffff;
        }
        body > .print-frame {
            height: 100%;
            display: block;
            position: relative;
        }
        body > .print-frame > .footer {
            position: absolute;
            bottom: 0px;
            left: 0px;
            display:block;
            width:100%;
        }
        .title-report {
            display:block;
            font-family: lato-bold;
            font-size:26px;
            margin-bottom: 10%;
        }
        .sect-top {
            display: none;
        }
        .sect-top-dummy {
            display: none;
        }
        .state-shutter {
            display:none !important;
        }
        .info-daerah {
            line-height:8px !important;
        }
        .footer img.spakat {
            height:30px;
        }
        .footer .todt {
            float:right;width:auto;display:table;line-height:40px;vertical-align:text-bottom;
            font-family: lato;
            font-size:10px;
        }
        .info-daerah.lge br { font-size: 70%;}
        .info-daerah.xs br { font-size: 14%; }

        .map-state-terengganu, .map-state-perlis {
            zoom: 150%;
            margin-top:-5%;
        }
        .map-state-johor, .map-state-pahang, .map-state-kelantan, .map-state-perak, .map-state-kedah, .map-state-selangor, .map-state-kl, .map-state-melaka, .map-state-n9, .map-state-penang, .map-state-sabah {
            zoom: 150%;
            margin-top:-6%;
        }
    }

    .print-frame {
        background-color: #b8dce5;
    }

    .position-map-custom {
        left: 500px;
        text-align: left;
        width: 250px;
        padding: 10px;
    }

    .position-map-custom .placement_name {
        margin-left: 40px;
        margin-top: -20px;
        position: absolute;
        text-align: left;
    }

    .placement_name {
        font-family: mark;
        font-size: 12px;
        line-height: 12px;
        text-align: center;
        color: #2c5c6a;
    }
</style>
<script>
    $(document).ready(function() {
        //goState('terengganu');
    });
</script>
<script type="text/javascript">
    function openDrawer() {
        //check if drawer is closed
        $('.drill-further').animate({
            right: "0"
        }, 500, function() {
            // Animation complete.
        });
    }
    function closeDrawer() {
        //check if drawer is closed
        $('.drill-further').animate({
            right: "-420"
        }, 500, function() {
            // Animation complete.
        });
    }
    function breadGroup(opt){
        if(opt == 'negara'){
            $('#negeri').show();
            $('#negeriback').hide();
            $('#daerah').hide();
        }else if(opt == 'negeri'){
            $('#negeri').hide();
            $('#negeriback').show();
            $('#daerah').show();
        }
    }
    function backToCountry() {
        breadGroup('negara');
        $('#show-opt').val('');
        letGoState();
        closeDrawer();
    }
    function printMe() {
        if($('#show-opt').val() == ''){
            $(document).attr("title", "Taburan Kenderaan JKR di Setiap Negeri");
        }else {
            $(document).attr("title", "Taburan Kenderaan JKR di Negeri " + $('#show-opt').val());
        }
        window.print();
    }
</script>
</head>
<body>
@php
    $negeri = Request('negeri');
@endphp
{{Request('all')}}
<div class="sect-top">
    <div class="mytitle">Taburan Kenderaan <span>Mengikut Lokasi Kenderaan</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('vehicle.report')}}');">Laporan &amp; Statistik</a></li>
        <li class="breadcrumb-item active" aria-current="page" id="negeri">Seluruh Negara</li>
        <li class="breadcrumb-item active" aria-current="page" id="negeriback"><a href="#" onclick="backToCountry()">Seluruh Malaysia</a></li>
        <li class="breadcrumb-item active" aria-current="page" id="daerah">Mengikut Negeri</li>
        </ol>
    </nav>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><h6 class="dropdown-header">Mengikut</h6></li>
        <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.report_compositions')}}'">Negeri</a></li>
        <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.report_compositions')}}'">Daerah</a></li>
    </ul>
    <div class="btnBoxRight">
        <button type="button" class="btn cux-btn" onClick="printMe();"><i class="fal fa-print"></i>&nbsp;Cetak</button>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="print-frame"><!--print outside-->
    <div class="title-report">Taburan Kenderaan <span>Seluruh Negara</span></div>
    <input type="hidden" name="show-opt" id="show-opt" value="{{$negeri}}">
    <div class="state-shutter" onClick="backToCountry()"><i class="fas fa-arrow-circle-left fa-2x"></i></div>
    <div class="map-state map-state-johor">
        <div class="map" id="map-state-johor-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($johor as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-johor">{{$totalInMap}}</div>Johor</div>
            <img src="{{asset('my-assets/img/map-3d-johor.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-pahang">
        <div class="map" id="map-state-pahang-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($pahang as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-pahang">{{$totalInMap}}</div>Pahang</div>
            <img src="{{asset('my-assets/img/map-3d-pahang.svg')}}" alt="" width="100%"/>
        </div>
    </div>

    <div class="map-state map-state-melaka">
        <div class="map" id="map-state-melaka-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($melaka as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-melaka">{{$totalInMap}}</div>Melaka</div>
            <img src="{{asset('my-assets/img/map-3d-melaka.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-n9">
        <div class="map" id="map-state-n9-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($n9 as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left: -100px;top: 0;" ><div class="count giant" id="master-n9">{{$totalInMap}}</div>Negeri Sembilan</div>
            <img src="{{asset('my-assets/img/map-3d-n9.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-kl">
        <div class="map" id="map-state-kl-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($kl as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="right:0px;top:0px;" ><div class="count giant" id="master-kl">{{$totalInMap}}</div>Kuala Lumpur</div>
            <img src="{{asset('my-assets/img/map-3d-kualalumpur.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-selangor">
        <div class="map" id="map-state-selangor-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($selangor as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-selangor">{{$totalInMap}}</div>Selangor</div>
            <img src="{{asset('my-assets/img/map-3d-selangor.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-perak">
        <div class="map" id="map-state-perak-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($perak as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left: -80px;top: 200px;" ><div class="count giant" id="master-perak">{{$totalInMap}}</div>Perak</div>
            <img src="{{asset('my-assets/img/map-3d-perak.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-kedah">
        <div class="map" id="map-state-kedah-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($kedah as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-kedah">{{$totalInMap}}</div>Kedah</div>
            <img src="{{asset('my-assets/img/map-3d-kedah.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-wilayah">
        <div class="map" id="map-state-wilayah-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($wilayah as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-wilayah">{{$totalInMap}}</div>Wilayah</div>
            <img src="{{asset('my-assets/img/map-3d-wilayah.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-penang">
        <div class="map" id="map-state-penang-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($penang as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:0px;top:0px;" ><div class="count giant" id="master-penang">{{$totalInMap}}</div>Pulau Penang</div>
            <img src="{{asset('my-assets/img/map-3d-penang.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-perlis">
        <div class="map" id="map-state-perlis-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($perlis as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-perlis">{{$totalInMap}}</div>Perlis</div>
            <img src="{{asset('my-assets/img/map-3d-perlis.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-kelantan">
        <div class="map" id="map-state-kelantan-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($kelantan as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-kelantan">{{$totalInMap}}</div>Kelantan</div>
            <img src="{{asset('my-assets/img/map-3d-kelantan.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-terengganu">
        <div class="map" id="map-state-terengganu-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($terengganu as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-terengganu">{{$totalInMap}}</div>Terengganu</div>
            <img src="{{asset('my-assets/img/map-3d-terengganu.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-sarawak">
        <div class="map" id="map-state-sarawak-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($sarawak as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-sarawak">{{$totalInMap}}</div>Sarawak</div>
            <img src="{{asset('my-assets/img/map-3d-sarawak.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-sabah">
        <div class="map" id="map-state-sabah-map">
            @php
                $totalInMap = 0;
            @endphp
            @foreach ($sabah as $index_map_placement => $map_placement)
                @php
                    $total = $map_placement->hasTotal();
                @endphp
                <div class="info-daerah lge @if(!$map_placement->desc_bm) position-map-custom @endif" style="
                @if($map_placement->map_position_left)
                left:{{$map_placement->map_position_left}};
                @endif
                @if($map_placement->map_position_right)
                right:{{$map_placement->map_position_right}};
                @endif
                @if($map_placement->map_position_top)
                top:{{$map_placement->map_position_top}};
                @endif"><div class="count" data-state_id="{{$map_placement->hasMap->state_id}}" data-id="{{$map_placement->placement_id}}" data-branch="@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif" id="placement-{{$map_placement->placement_id}}">{{$total}}</div><span class="placement_name">@if($map_placement->desc_bm)
                    {!!$map_placement->desc_bm!!}
                    @else
                    {{$map_placement->hasPlacement->desc}}
                @endif</span></div>
                @php
                    $totalInMap = $totalInMap + $total;
                @endphp
            @endforeach
            <div class="info-daerah-master" style="left:0px;top:0px;" ><div class="count giant" id="master-sabah">{{$totalInMap}}</div>Sabah</div>
            <img src="{{asset('my-assets/img/map-3d-sabah.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="whole-map">
        <div class="mobile-btn-right"><i class="fas fa-arrow-circle-right fa-2x" onclick="moveMap('right')"></i></div>
        <div class="mobile-btn-left" onclick="moveMap('left')"><i class="fas fa-arrow-circle-left fa-2x"></i></div>
        <div class="back-hias">
            <div class="split"><img src="{{asset('my-assets/img/split-min.png')}}" alt=""/></div>
        </div>
        <div class="map-left">
            @php
                $statesRefs = [
                    '01' => [
                        'spot' =>'johor',
                        'desc' => 'Johor',
                        'view' => true,
                    ],
                    '02' => [
                        'spot' =>'kedah',
                        'desc' => 'Kedah',
                        'view' => true,
                    ],
                    '03' => [
                        'spot' =>'kelantan',
                        'desc' => 'Kelantan',
                        'view' => true,
                    ],
                    '04' => [
                        'spot' =>'melaka',
                        'desc' => 'Melaka',
                        'view' => true,
                    ],
                    '05' => [
                        'spot' =>'n9',
                        'desc' => '',
                        'view' => true,
                    ],
                    '06' => [
                        'spot' =>'pahang',
                        'desc' => '',
                        'view' => true,
                    ],
                    '07' => [
                        'spot' =>'perak',
                        'desc' => '',
                        'view' => true,
                    ],
                    '08' => [
                        'spot' =>'perlis',
                        'desc' => '',
                        'view' => true,
                    ],
                    '09' => [
                        'spot' =>'penang',
                        'desc' => '',
                        'view' => true,
                    ],
                    '12' => [
                        'spot' =>'selangor',
                        'desc' => '',
                        'view' => true,
                    ],
                    '13' => [
                        'spot' =>'terengganu',
                        'desc' => '',
                        'view' => true,
                    ],
                    '14' => [
                        'spot' =>'kl',
                        'desc' => '',
                        'view' => true,
                    ],
                    '16' => [
                        'spot' =>'putrajaya',
                        'desc' => '',
                        'view' => true,
                    ]
                ];
            @endphp
            @foreach ($total_record_by_state as $state)
                @if(isset($statesRefs[$state->code]) && $statesRefs[$state->code]['view'])
                    @if(!in_array($state->code, ['16']))
                    <div id="info-{{$statesRefs[$state->code]['spot']}}" class="info" onClick="goState('{{$statesRefs[$state->code]['spot']}}','{{$state->code}}')"><div class="count">{{$state->total()}}</div>{{$state->state_name}}</div>
                    @else
                    <div id="info-{{$statesRefs[$state->code]['spot']}}" class="infoonly"><div class="countdrilless">{{$state->total()}}</div>{{$state->state_name}}</div>
                    @endif
                @endif
            @endforeach
            <div class="point-kl point"></div>
            <div class="point-perlis point"></div>
            <div class="point-putrajaya point"></div>
            <div class="point-melaka point"></div>
            <img src="{{asset('my-assets/img/peninsular-min.png')}}" alt="" height="450px" usemap="#Map" class="img-peninsular"/>
            <!--<img src="../../../public/my-assets/img/peninsular.png" alt="" width="450px" usemap="#Map" class="img-peninsular"/>-->
            <map name="Map">
              <area id="spot-johor" shape="poly" coords="299,390,298,412,299,426,290,428,285,443,290,465,298,469,313,471,343,494,353,497,371,527,386,511,415,518,438,525,451,525,425,465,398,412,387,406,387,427,369,420,334,419,305,398" href="javascript:goState('johor')">
              <area id="spot-pahang" shape="poly" coords="185,223,192,245,201,257,202,283,217,293,224,308,220,323,235,334,250,335,272,346,294,365,316,379,331,397,358,398,371,402,372,389,356,373,360,315,348,295,355,278,328,263,309,270,306,258,323,233,309,232,309,214,291,208,281,210,258,220,243,209,237,209,231,221,223,220,217,216,208,227,186,224" href="javascript:goState('pahang')">
              <area id="spot-melaka" shape="poly" coords="230,424,247,420,262,420,277,426,273,451,248,444,231,426" href="javascript:alert('Melaka');goState('melaka')">
              <area id="spot-n9" shape="poly" coords="215,401,218,414,226,415,244,408,259,407,276,411,285,413,293,378,277,368,267,357,245,347,235,349,225,374,217,377,216,400" href="javascript:goState('n9')">
              <area id="spot-putrajaya" shape="poly" coords="193,369,190,377,195,382,201,370,195,369">
              <area id="spot-kl" shape="poly" coords="194,342,190,349,191,361,200,363,208,347,196,342" href="javascript:goState('kualalumpur')">
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
                $statesRefs = [
                    '10' => [
                        'spot' =>'sabah',
                        'desc' => '',
                        'view' => true,
                    ],
                    '11' => [
                        'spot' =>'sarawak',
                        'desc' => '',
                        'view' => false,
                    ],
                    '15' => [
                        'spot' =>'labuan',
                        'desc' => '',
                        'view' => true,
                    ]
                ];
            @endphp
            @foreach ($total_record_by_state as $state)
                @if(isset($statesRefs[$state->code]) && $statesRefs[$state->code]['view'])
                    @if(!in_array($state->code, ['15']))
                    <div id="info-{{$statesRefs[$state->code]['spot']}}" class="info" onClick="goState('{{$statesRefs[$state->code]['spot']}}','{{$state->code}}')"><div class="count">{{$state->total()}}</div>{{$state->state_name}}</div>
                    @else
                    <div id="info-{{$statesRefs[$state->code]['spot']}}" class="infoonly"><div class="countdrilless">{{$state->total()}}</div>{{$state->state_name}}</div>
                    @endif
                @endif
            @endforeach
            <img src="{{asset('my-assets/img/borneo-min.png')}}" alt="" height="450px" usemap="#MapBorneo" class="img-borneo"/>
            <!--<img src="../../../public/my-assets/img/borneo.png" alt="" width="450px" usemap="#MapBorneo" class="img-borneo"/>-->
            <map name="MapBorneo">
              <area id="spot-labuan" shape="poly" coords="259,73,253,85,266,83,259,74">
              <area id="spot-sabah" shape="poly" coords="261,97,277,88,269,77,277,67,301,53,302,39,330,4,355,5,355,17,376,23,371,48,390,43,396,56,408,57,420,64,437,76,446,73,447,85,416,98,399,94,421,123,401,122,386,128,372,120,372,129,365,132,353,124,288,126,280,113,283,97" href="javascript:goState('sabah')">
              <area id="spot-sarawak"shape="poly" coords="7,237,51,285,79,275,93,279,121,273,129,256,159,250,166,259,192,267,210,254,235,255,260,208,259,189,274,183,283,131,272,115,273,102,245,106,234,138,209,116,164,181,93,196,74,257,9,239" href="#">
            </map>
      </div>
    </div>
    <div class="footer"><img src="{{asset('my-assets/img/spakat-small-min.png')}}" class="spakat">
        <div class="todt">Dicetak pada {{$date = date('d/m/Y H:i A')}}</div>
    </div>
</div><!--end of print outsider for state-->
<div class="drill-further">
    <div class="sub-win-title">Senarai Kenderaan</div>
    <div id="choice" style="margin-top:-7px"></div>
    <div class="btn-closer" onclick="closeDrawer()"><i class="fal fa-times fa-lg"></i></div>
        <a href="{{ route('report.vehicle-list')}}?ownership=jkr&fleet_view=department&limit=10"><button class="btn cux-btn mt-2 mb-2">Senarai Penuh</button></a>
    <hr/>
    <div class="list-viewer" id="district-list">
        <div id="vehicle_by_district">

        </div>
    </div>
</div>
<script>

    function initializeStateValue(){

        let state_code, state_name, state_total = 0;

        @foreach ($total_record_by_state as $item)
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
            @if ($item->code == '03')
                $('.map-state-kelantan .count.giant').text(state_total);
            @endif
            @if ($item->code == '04')
                $('.map-state-melaka .count.giant').text(state_total);
            @endif
            @if ($item->code == '05')
                $('.map-state-nsembilan .count.giant').text(state_total);
            @endif
            @if ($item->code == '06')
                $('.map-state-pahang .count.giant').text(state_total);
            @endif
            @if ($item->code == '07')
                $('.map-state-perak .count.giant').text(state_total);
            @endif
            @if ($item->code == '08')
                $('.map-state-perlis .count.giant').text(state_total);
            @endif
            @if ($item->code == '09')
                $('.map-state-penang .count.giant').text(state_total);
            @endif
            @if ($item->code == '10')
                $('.map-state-sabah .count.giant').text(state_total);
            @endif
            @if ($item->code == '11')
                $('.map-state-sarawak .count.giant').text(state_total);
            @endif
            @if ($item->code == '12')
                $('.map-state-selangor .count.giant').text(state_total);
            @endif
            @if ($item->code == '13')
                $('.map-state-terengganu .count.giant').text(state_total);
            @endif
            @if ($item->code == '14')
                $('.map-state-kl .count.giant').text(state_total);
            @endif
            @if ($item->code == '15')
                $('.map-state-labuan .count.giant').text(state_total);
            @endif
            @if ($item->code == '16')
                $('.map-state-putrajaya .count.giant').text(state_total);
            @endif

        @endforeach
    }
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
        $('#show-opt').val(state);
        $('.title-report span').text('Negeri');
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
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    var totalFleet = data[i].total_fleet;
                    var districtName = data[i].description;
                    var order = data[i].order;
                    var placement_id = data[i].placement_id;

                    $(".map-state-"+state.toLowerCase()+" .info-daerah[xorder='"+order+"'] .count").html(totalFleet);
                    $("#p_id").val(placement_id);
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
            state = "Wilayah Persekutuan";
        }else if(state == 'kualalumpur'){
            state = "WP Kuala Lumpur";
        }else if(state == 'penang'){
            state = "Pulau Pinang";
        }
        $('#negeri').text(toTitleCase(state));
        //var shrinkMap = $('.img-peninsular, .img-borneo').addClass('shrink').fadeOut();
         //var shrinkMap = $('.map-lef').fadeOut('fast');
         //var moveLeft = $('.map-left').addClass('move-to-left');
        /*$('.state-shutter').fadeIn('fast');
        shrinkMap.after(function(){

        });*/
    }
    function letGoState(state) {
        $('.img-peninsular, .img-borneo').fadeIn().removeClass('shrink');
        $('.map-state-' + state).fadeOut('fast');
        $('#daerah').hide();
        $('#negeri').text('Seluruh Negara');
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
        $('#negeri').text('Seluruh Negara');
        $('.info, .point').show('fast');
        $('.state-shutter').fadeOut('fast');
        $('.back-hias').animate({'width': '80%', 'left': '10%'}, 'fast');

    }
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

    const loadVehicleByDistrict = function(opt, state_id) {
        console.log('opt display', opt);
        var negeri = $('#show-opt').val();
        $.get("{{ route('report.vehicle-by-district-list')}}?opt="+opt+"&negeri="+negeri+"&state_id="+state_id, function(result){
                $('#vehicle_by_district').html(result);
            });
    }

    const initMapPosition = function(targe_map){
        //.map-state-kelantan
        let map_position = [];
        const map = $(targe_map+' .map');
        $('.map .info-daerah').each(function(){

            $('.count').html(null);
            
            const left = $(this).css('left');
            const right = $(this).css('right');
            const top = $(this).css('top');
            const placement_id = $(this).children().attr('code');
            const placement_desc = $(this).text();
            let obj = {};
            obj['map_position_left'] = left;
            obj['map_position_right'] = right;
            obj['map_position_top'] = top;
            obj['placement_id'] = placement_id;
            obj['desc_bm'] = placement_desc;
            map_position.push(obj);
        });

        setTimeout(() => {
            console.log('map_position ', map_position);
            $.post('{{route('report.update_map_position')}}', {
                '_token': '{{ csrf_token() }}',
                'map_position': map_position,
            }, function(res){

            });
        }, 500);
        
    }

    $(document).ready(function(){
        // initializeStateValue();
        $(window).resize(function() {
            var wh = $(window).height();
            //$('#negeri').text($(window).width());
            if (wh < 760) {
                $('.sect-top, .sect-top-dummy').slideUp();
            } else {
                $('.sect-top, .sect-top-dummy').slideDown();
            }
        });

        var showOpt = $('#show-opt').val();
        if(showOpt != ''){
            breadGroup('negeri');
            if(showOpt == 'johor'){
                goState(showOpt, '01');
            }else if(showOpt == 'kedah'){
                goState(showOpt, '02');
            }else if(showOpt == 'kelantan'){
                goState(showOpt, '03');
            }else if(showOpt == 'melaka'){
                goState(showOpt, '04');
            }else if(showOpt == 'n9'){
                goState(showOpt, '05');
            }else if(showOpt == 'pahang'){
                goState(showOpt, '06');
            }else if(showOpt == 'perak'){
                goState(showOpt, '07');
            }else if(showOpt == 'perlis'){
                goState(showOpt, '08');
            }else if(showOpt == 'penang'){
                goState(showOpt, '09');
            }else if(showOpt == 'sabah'){
                goState(showOpt, '10');
            }else if(showOpt == 'sarawak'){
                goState(showOpt, '11');
            }else if(showOpt == 'selangor'){
                goState(showOpt, '12');
            }else if(showOpt == 'terengganu'){
                goState(showOpt, '13');
            }else if(showOpt == 'kl'){
                goState(showOpt, '14');
            }else if(showOpt == 'putrajaya'){
                goState(showOpt, '16');
            }else if(showOpt == 'labuan'){
                goState(showOpt, '15');
            }else if(showOpt == 'wilayah'){
                goState(showOpt, '17');
            }
        }else{
            breadGroup('negara');
        }

        $('.info-daerah').click(function() {
            var opt = $(this).children().data('id');
            var state_id = $(this).children().data('state_id');
            $('#choice').html($(this).children().data('branch'));
            openDrawer();
            loadVehicleByDistrict(opt, state_id);

            // $('#district-list').load('?opt=' + opt);
            // window.location.href = "{{route('report.report_map_peninsular')}}?opt="+opt;
        });

        // $("#map-state-johor-map").click(function() {
        //     var $clicker = $(this);
        //     var pos = $clicker.position();
        //     alert(pos.top + ' => '+pos.left + ' => '+pos.right);
        // });
        $(window).resize(function() {
            //$('.mytitle').text($(window).width());
        });

        const johor = document.getElementById('map-state-johor-map');

        johor.onclick = function(e) { 
            const left = e.pageX - e.currentTarget.offsetLeft - 25; 
            const top = e.pageY - e.currentTarget.offsetTop - 188; 
            console.log('left => ',left);
            console.log('top => ',top);
        }
    })
</script>
</body>
</html>

