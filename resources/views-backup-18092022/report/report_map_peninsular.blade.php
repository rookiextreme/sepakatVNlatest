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
    <div class="state-shutter" onClick="backToCountry()()"><i class="fas fa-arrow-circle-left fa-2x"></i></div>
    <div class="map-state map-state-johor">
        <div class="map">
            <div class="info-daerah-master" style="left:25px;top:345px;" ><div class="count giant" id="master-johor">320</div>Johor</div>
            <div class="info-daerah lge" style="left:275px;top:386px;text-align:right;" xorder='1'><div class="count lg" id="data-johorhead" code="2" branch="Ibu Pejabat JKR Johor">0</div>Ibu Pejabat<br/>JKR Johor</div>
            <div class="info-daerah lge" style="left:350px;top:386px;text-align:left" xorder='11'><div class="count lg" id="data-johorbharu" code="8" branch="JKR Johor Bahru">25</div>JKR Johor<br/>Bahru</div>
            <div class="info-daerah xs" style="left:260px;top:290px;" xorder='2'><div class="count sm" id="data-kulai" code="12" branch="JKR Kulai">0</div>JKR Kulai</div>
            <div class="info-daerah lge" style="left:80px;top:80px;" xorder='3'><div class="count" id="data-segamat" code="4" branch="JKR Segamat">0</div>JKR Segamat</div>
            <div class="info-daerah xs" style="left:41px;top:140px;" xorder='4'><div class="count sm" id="data-tangkak" code="3" branch="JKR Tangkak">0</div>JKR<Br/>Tangkak</div>
            <div class="info-daerah xs" style="left:50px;top:202px;" xorder='5'><div class="count sm" id="data-muar" code="7" branch="JKR Muar">0</div>JKR Muar</div>
            <div class="info-daerah lge" style="left:120px;top:210px;" xorder='6'><div class="count" id="data-batupahat" code="10" branch="JKR Batu Pahat">0</div>JKR Batu<br/>Pahat</div>
            <div class="info-daerah lge" style="left:210px;top:210px;" xorder='7'><div class="count" id="data-kluang" code="9" branch="JKR Kluang">0</div>JKR Kluang</div>
            <div class="info-daerah lge" style="left:310px;top:170px;" xorder='8'><div class="count" id="data-mersing" code="6" branch="JKR Mersing">0</div>JKR Mersing</div>
            <div class="info-daerah lge" style="left:310px;top:240px;" xorder='9'><div class="count" id="data-kotatinggi" code="11" branch="JKR Kota Tinggi">0</div>JKR Kota Tinggi</div>
            <div class="info-daerah lge" style="left:170px;top:360px;" xorder='10'><div class="count" id="data-pontian" code="5" branch="JKR Pontian">0</div>JKR Pontian</div>
            <img src="{{asset('my-assets/img/map-3d-johor.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-pahang">
        <div class="map">
            <div class="info-daerah-master" style="left:25px;top:370px;"><div class="count giant" id="master-pahang">570</div>Pahang</div>
            <div class="info-daerah lge" style="left:300px;top:160px;" xorder='1'><div class="count lg" id="data-pahanghead" code="109" branch="Ibu Pejabat JKR Pahang">0</div>Ibu Pejabat<br/>JKR Pahang</div>
            <div class="info-daerah lge" style="left:94px;top:170px;" xorder='2'><div class="count" id="data-raub" code="120" branch="JKR Daerah Raub">0</div>JKR Raub</div>
            <div class="info-daerah lge" style="left:335px;top:235px;" xorder='3'><div class="count" id="data-pekan" code="116" branch="JKR Daerah Pekan">0</div>JKR<br/>Pekan</div>
            <div class="info-daerah lge" style="left:320px;top:335px;" xorder='4'><div class="count" id="data-rompin" code="118" branch="JKR Daerah Rompin">0</div>JKR<br/>Rompin</div>
            <div class="info-daerah lge" style="left:220px;top:100px;" xorder='5'><div class="count" id="data-jerantut" code="112" branch="JKR Daerah Jelebu">0</div>JKR Jerantut</div>
            <div class="info-daerah xs" style="left:256px;top:215px;" xorder='6'><div class="count sm" id="data-maran" code="114" branch="JKR Daerah Maran">0</div>JKR<br/>Maran</div>
            <div class="info-daerah lge" style="left:100px;top:85px;" xorder='7'><div class="count" id="data-kualalipis" code="113" branch="JKR Daerah Kuala Lipis">0</div>JKR Kuala<br/>Lipis</div>
            <div class="info-daerah xs" style="left:20px;top:5px;" xorder='8'><div class="count sm" id="data-cameronhighlands" code="111" branch="JKR Daerah Cameron Highlands">0</div>JKR Cameron<br/>Highlands</div>
            <div class="info-daerah lge" style="left:215px;top:280px;" xorder='9'><div class="count" id="data-bera" code="115" branch="JKR Daerah Bera">0</div>JKR Bera</div>
            <div class="info-daerah xs" style="left:120px;top:245px;" xorder='10'><div class="count sm" id="data-bentong" code="110" branch="JKR Daerah Bentong">0</div>JKR<br/>Bentong</div>
            <div class="info-daerah xs" style="left:170px;top:210px;" xorder='11'><div class="count" id="data-temerloh" code="117" branch="JKR Daerah Temerloh">0</div>JKR<br/>Temerloh</div>
            <img src="{{asset('my-assets/img/map-3d-pahang.svg')}}" alt="" width="100%"/>
        </div>
    </div>

    <div class="map-state map-state-melaka">
        <div class="map">
            <div class="info-daerah-master" style="right:25px;top:0px;"><div class="count giant" id="master-melaka">234</div>Melaka</div>
            <div class="info-daerah lge" style="left:180px;top:330px"  xorder='1' ><div class="count" id="data-melakahead">0</div code="75" branch="Ibu Pejabat JKR Melaka">Ibu Pejabat<br/>JKR Melaka</div>
            <div class="info-daerah lge" style="right:110px;top:200px" xorder='2' ><div class="count" id="data-jasin" code="77" branch="JKR Daerah Jasin">0</div>JKR Jasin</div>
            {{-- <div class="info-daerah lge" style="left:205px;top:45px"><div class="count" id="data-alorgajah">43</div>JKR Melaka Tengah</div> --}}
            <div class="info-daerah lge" style="left:200px;top:140px" xorder='3' ><div class="count" id="data-alorgajah" code="76" branch="JKR Daerah Alor Gajah">0</div>JKR Alor Gajah</div>

            <div class="info-daerah lge" style="left:120px;top:280px" xorder='4' ><div class="count" id="data-melakatengah" code="78" branch="JKR Daerah Melaka Tengah">0</div>JKR Melaka<br/>Tengah</div>
            <img src="{{asset('my-assets/img/map-3d-melaka.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-n9">
        <div class="map">
            <div class="info-daerah-master" style="right:0px;top:0px;"><div class="count giant" id="master-nsembilan">270</div>Negeri Sembilan</div>
            <div class="info-daerah lge" style="left:40px;top:220px" xorder='1'><div class="count" id="data-n9head" code="91" branch="Ibu Pejabat JKR Negeri Sembilan">0</div>Ibu Pejabat<br/>JKR Negeri Sembilan</div>
            <div class="info-daerah lge" style="left:180px;top:110px" xorder='2'><div class="count" id="data-jelebu" code="92" branch="JKR Daerah Jelebu">0</div>JKR Jelebu</div>
            <div class="info-daerah lge" style="right:80px;top:190px" xorder='3'><div class="count" id="data-jempol" code="93" branch="JKR Daerah Jempol">0</div>JKR Jempol</div>
            <div class="info-daerah lge" style="left:200px;top:240px" xorder='4'><div class="count" id="data-kualapilah" code="94" branch="JKR Daerah Kuala Pilah">0</div>JKR Kuala Pilah</div>
            <div class="info-daerah lge" style="right:90px;top:330px" xorder='5'><div class="count" id="data-tampin" code="98" branch="JKR Daerah Tampin">0</div>JKR Tampin</div>
            <div class="info-daerah xs" style="left:160px;top:330px" xorder='6'><div class="count sm" id="data-rembau" code="96" branch="JKR Daerah Rembau">0</div>JKR Rembau</div>
            <div class="info-daerah xs" style="left:55px;top:365px" xorder='7'><div class="count" id="data-portdickson" code="95" branch="JKR Daerah Port Dickson">0</div>JKR Port Dickson</div>
            <img src="{{asset('my-assets/img/map-3d-n9.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-kl">
        <div class="map">
            <div class="info-daerah-master" style="right:0px;top:0px;"><div class="count giant" id="master-wilayahpersekutuan">188</div>Kuala Lumpur</div>
            <div class="info-daerah lge" style="right:200px;top:220px" xorder='1'><div class="count" id="data-ibupejabatjkr" code="291" branch="Ibu Pejabat JKR Malaysia">0</div>Ibu Pejabat<br/>JKR Malaysia</div>
            <div class="info-daerah lge" style="right:60px;top:373px" xorder='2'><div class="count" id="data-kualalumpur" code="290" branch="JKR Woksyop Persekutuan">0</div>JKR Woksyop<br/>Persekutuan</div>
            <div class="info-daerah lge" style="left:10px;top:180px" xorder='3'><div class="count" id="data-wilayahpersekutuan">0</div>JKR Wilayah<br/>Persekutuan</div>
            <img src="{{asset('my-assets/img/map-3d-kualalumpur.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-selangor">
        <div class="map">
            <div class="info-daerah-master" style="left:10px;bottom:0px;"><div class="count giant" id="master-selangor">356</div>Selangor</div>
            <div class="info-daerah lge" style="left:70px;top:260px" xorder='1'><div class="count" id="data-selangorhead" code="251" branch="Ibu Pejabat JKR Selangor">0</div>Ibu Pejabat<br/>JKR Selangor</div>
            <div class="info-daerah xs" style="left:5px;top:50px" xorder='2'><div class="count" id="data-sabakbernam" code="254" branch="JKR Daerah Sabak Bernam">0</div>JKR Sabak<br/>Bernam</div>
            <div class="info-daerah lge" style="right:130px;top:390px" xorder='3'><div class="count" id="data-sepang" code="258" branch="JKR Daerah Sepang">0</div>JKR Sepang</div>
            <div class="info-daerah xs" style="right:200px;top:340px" xorder='4'><div class="count" id="data-kualalangat" code="252" branch="JKR Daerah Kuala Langat">0</div>JKR Kuala<br/>Langat</div>
            <div class="info-daerah lge" style="right:120px;top:80px" xorder='5'><div class="count" id="data-huluselangor" code="256" branch="JKR Daerah Hulu Selangor">0</div>JKR Hulu Selangor</div>
            <div class="info-daerah lge" style="right:20px;top:160px" xorder='6'><div class="count" id="data-petaling" code="253" branch="JKR Daerah Petaling">0</div>JKR Petaling</div>
            <div class="info-daerah lge" style="left:125px;top:55px" xorder='7'><div class="count" id="data-kualaselangor" code="260" branch="JKR Daerah Kuala Selangor">0</div>JKR Kuala<br/>Selangor</div>
            <div class="info-daerah xs" style="right:67px;top:270px" xorder='8'><div class="count" id="data-hululangat" code="255" branch="JKR Daerah Hulu Langat">0</div>JKR Hulu<br/>Langat</div>
            <div class="info-daerah xs" style="right:105px;top:190px" xorder='9'><div class="count sm" id="data-gombak" code="257" branch="JKR Daerah Gombak">0</div>JKR<br/>Gombak</div>
            <div class="info-daerah lge" style="left:140px;top:360px" xorder='10'><div class="count" id="data-klang" code="259" branch="JKR Daerah Klang">0</div>JKR Klang</div>
            <div class="point-petaling">&nbsp;</div>
            <div class="point-shahalam">&nbsp;</div>
            <img src="{{asset('my-assets/img/map-3d-selangor.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-perak">
        <div class="map">
            <div class="info-daerah-master" style="left:75px;top:0px;"><div class="count giant" id="master-perak">356</div>Perak</div>
            <div class="info-daerah lge" style="right:95px;top:270px" xorder='1'><div class="count" id="data-perakhead" code="135" branch="Ibu Pejabat JKR Perak">0</div>Ibu Pejabat<br/>JKR Perak</div>
            <div class="info-daerah xs" style="right:185px;top:280px" xorder='2'><div class="count sm" id="data-kinta" code="137" branch="JKR Daerah Kinta">0</div>JKR Kinta</div>
            <div class="info-daerah lge" style="right:125px;top:70px" xorder='3'><div class="count" id="data-huluperak" code="139" branch="JKR Daerah Hulu Perak">0</div>JKR Hulu Perak</div>
            <div class="info-daerah lge" style="left:60px;top:360px" xorder='4'><div class="count" id="data-manjung" code="136" branch="JKR Daerah Manjung">0</div>JKR<br/>Manjung</div>
            <div class="info-daerah xs" style="left:205px;top:260px" xorder='5'><div class="count sm" id="data-kualakangsar" code="140" branch="JKR Daerah Kuala Kangsar">0</div>JKR Kuala<br/>Kangsar</div>
            <div class="info-daerah lge" style="left:50px;top:230px" xorder='6'><div class="count" id="data-larutmatangselama" code="144" branch="JKR Daerah Larut, Matang dan Selama">0</div>JKR Larut,<br/>Matang &<br/>Selama</div>
            <div class="info-daerah xs" style="left:140px;top:418px" xorder='7'><div class="count sm" id="data-bagandatuk" code="141" branch="JKR Daerah Bagan Datuk">0</div>JKR Bagan Datuk</div>
            <div class="info-daerah xs" style="right:130px;top:448px" xorder='8'><div class="count sm" id="data-muallim" code="142" branch="JKR Daerah Muallim">0</div>JKR<br/>Muallim</div>
            <div class="info-daerah xs" style="right:160px;top:340px" xorder='9'><div class="count" id="data-batangpadang" code="143" branch="JKR Daerah Batang Padang">0</div>JKR<br/>Batang Padang</div>
            <div class="info-daerah xs" style="left:235px;top:430px" xorder='10'><div class="count sm" id="data-hilirperak" code="145" branch="JKR Daerah Hilir Perak">0</div>JKR<br/>Hilir Perak</div>
            <div class="info-daerah lge" style="left:220px;top:536px" xorder='11'><div class="count" id="data-kampar" code="147" branch="JKR Daerah Kampar">0</div>JKR<br/>Kampar</div>
            <div class="info-daerah xs" style="left:90px;top:110px" xorder='12'><div class="count sm" id="data-kerian" code="138" branch="JKR Daerah Kerian">0</div>JKR<br/>Kerian</div>
            <img src="{{asset('my-assets/img/map-3d-perak.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-kedah">
        <div class="map">
            <div class="info-daerah-master" style="left:35px;bottom:20px;"><div class="count giant" id="master-kedah">356</div>Kedah</div>
            <div class="info-daerah lge" style="left:10px;top:86px" xorder='1'><div class="count" id="data-langkawi" code="33" branch="JKR Langkawi">0</div>JKR Langkawi</div>
            <div class="info-daerah lge" style="right:120px;top:290px" xorder='2'><div class="count" id="data-baling" code="28" branch="JKR Baling">0</div>JKR Baling</div>
            <div class="info-daerah lge" style="right:150px;top:370px" xorder='3'><div class="count" id="data-bandarbaharu" code="29" branch="JKR Bandar Baharu / Kulim">0</div>JKR Bandar<br/>Baharu / Kulim</div>
            <div class="info-daerah lge" style="left:180px;top:42px" xorder='4'><div class="count" id="data-kubangpasu" code="32" branch="JKR Kubang Pasu">0</div>JKR Kubang<br/>Pasu</div>
            <div class="info-daerah lge" style="left:185px;top:135px" xorder='5'><div class="count" id="data-kotasetar" code="30" branch="JKR Kota Setar">0</div>JKR Kota<br/>Setar</div>
            <div class="info-daerah lge" style="left:240px;top:260px" xorder='6'><div class="count" id="data-kualamuda" code="31" branch="JKR Kuala Muda">0</div>JKR Kuala<br/>Muda</div>
            <div class="info-daerah lge" style="right:140px;top:60px" xorder='7'><div class="count" id="data-padangterap" code="34" branch="JKR Padang terap">0</div>JKR Padang<br/>Terap</div>
            <div class="info-daerah lge" style="right:200px;top:164px" xorder='8'><div class="count" id="data-pendang" code="35" branch="JKR Pendang">0</div>JKR<br/>Pendang</div>
            <div class="info-daerah lge" style="right:130px;top:210px" xorder='9'><div class="count" id="data-sik" code="37" branch="JKR Sik">0</div>JKR Sik</div>
            <div class="info-daerah lge" style="left:205px;top:219px" xorder='10'><div class="count" id="data-yan" code="38" branch="JKR Yan">0</div>JKR<br/>Yan</div>
            <img src="{{asset('my-assets/img/map-3d-kedah.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-wilayah">
        <div class="info-daerah-master" style="right:100px;top:160px;"><div class="count giant" id="master-wilayahpersekutuan">221</div>Wilayah<br/>Persekutuan</div>
        <div class="info-daerah lge" style="right:436px;top:94px" xorder='1'><div class="count" id="data-kualalumpur">0</div>JKR WP KL</div>
        <div class="info-daerah lge" style="right:280px;top:260px;text-align:left" xorder='2'><div class="count" id="data-putrajaya">0</div>JKR WP<br/>Putrajaya</div>
        <div class="info-daerah lge" style="right:145px;top:35px;text-align:right" xorder='3'><div class="count" id="data-labuan">0</div>JKR WP<br/>Labuan</div>
        <img src="{{asset('my-assets/img/map-3d-wilayah.svg')}}" alt="" width="100%"/>
    </div>
    <div class="map-state map-state-penang">
        <div class="map">
            <div class="info-daerah-master" style="left:100px;bottom:20px;"><div class="count giant" id="master-penang">209</div>Pulau Pinang</div>
            <div class="info-daerah lge" style="left:120px;top:170px;" xorder='1'><div class="count" id="data-baratdaya" code="167" branch="JKR Daerah Barat Daya">0</div>JKR Barat<br/>Daya</div>
            <div class="info-daerah lge" style="left:173px;top:110px;" xorder='2'><div class="count" id="data-timurlaut" code="171" branch="JKR Daerah Timur Laut">0</div>JKR Timur<br/>Laut</div>
            <div class="info-daerah lge" style="right:130px;top:50px;" xorder='3'><div class="count" id="data-seberangperaiutara" code="170" branch="JKR Seberang Perai Utara">0</div>JKR Seberang<br/>Perai Utara</div>
            <div class="info-daerah lge" style="right:120px;top:150px;" xorder='4'><div class="count" id="data-seberangperaitengah" code="169" branch="JKR Seberang Perai Tengah">0</div>JKR Seberang<br/>Perai Tengah</div>
            <div class="info-daerah lge" style="right:116px;top:260px;" xorder='5'><div class="count" id="data-seberangperaiutara" code="168" branch="JKR Seberang Perai Selatan">0</div>JKR Seberang<br/>Perai Selatan</div>
            <div class="info-daerah xs" style="left:195px;top:40px;" xorder='6'><div class="count sm" id="data-penanghq" code="166" branch="Ibu Pejabat JKR Pulau Pinang">0</div>Ibu Pejabat JKR<br/>Pulau Pinang</div>
            <img src="{{asset('my-assets/img/map-3d-penang.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-perlis">
        <div class="map">
            <div class="info-daerah-master" style="right:35px;bottom:20px;"><div class="count giant" id="master-kedah">70</div>Perlis</div>
            <div class="info-daerah lge" style="left:110px;top:210px" xorder='1'><div class="count" id="data-perlis" code="160" branch="Ibu Pejabat JKR Perlis">0</div>Ibu Pejabat<br/>JKR Perlis</div>
            <img src="{{asset('my-assets/img/map-3d-perlis.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-kelantan">
        <div class="map">
            <div class="info-daerah-master" style="left:0px;top:0px;"><div class="count giant" id="master-kelantan">374</div>Kelantan</div>
            <div class="info-daerah lge" style="right:120px;top:0px" xorder='1'><div class="count" id="data-ibukelantan" code="49" branch="Ibu Pejabat JKR Kelantan">0</div>Ibu Pejabat<br/>JKR Kelantan</div>
            <div class="info-daerah lge" style="left:170px;top:55px" xorder='2'><div class="count" id="data-tumpat" code="57" branch="JKR Jajahan Tumpat">0</div>JKR Jajahan<br/>Tumpat</div>
            <div class="info-daerah xs" style="right:216px;top:0px;text-align:right" xorder='3'><div class="count sm" id="data-feripengkalankubor" code="62" branch="JKR Feri Pengkalan Kubor">0</div>JKR Feri<br/>Pengkalan Kubor</div>
            <div class="info-daerah lge" style="right:170px;top:360px" xorder='4'><div class="count" id="data-guamusang" code="59" branch="JKR Jajahan Gua Musang">0</div>JKR Jajahan Gua Musang</div>
            <div class="info-daerah xs" style="right:100px;top:130px" xorder='5'><div class="count sm" id="data-pasirputeh" code="50" branch="JKR Jajahan Pasir Puteh">0</div>JKR Jajahan<br/>Pasir Puteh</div>
            <div class="info-daerah lge" style="right:50px;top:200px" xorder='6'><div class="count" id="data-machang" code="51" branch="JKR Jajahan Machang">0</div>JKR Jajahan<br/>Machang</div>
            <div class="info-daerah xs" style="left:250px;top:95px" xorder='7'><div class="count sm" id="data-pasirmas" code="52" branch="JKR Jajahan Pasir Mas">0</div>JKR Jajahan<br/>Pasir Mas</div>
            <div class="info-daerah lge" style="right:35px;top:124px" xorder='8'><div class="count" id="data-bachok" code="53" branch="JKR Jajahan Bachok">0</div>JKR<br/>Jajahan<br/>Bachok</div>
            <div class="info-daerah lge" style="right:5px;top:40px;text-align:left" xorder='9'><div class="count" id="data-kuaripusatbukitbuloh" code="60" branch="JKR Kuari Pusat Bukit Buloh">0</div>JKR Kuari<br/>Pusat Bukit<br/>Buloh</div>
            <div class="info-daerah lge" style="right:160px;top:240px" xorder='10'><div class="count" id="data-kualakrai" code="55" branch="JKR Jajahan Kuala Krai">0</div>JKR Jajahan<br/>Kuala Krai</div>
            <div class="info-daerah lge" style="left:185px;top:200px" xorder='11'><div class="count" id="data-jeli" code="56" branch="JKR Jajahan Jeli">0</div>JKR<br/>Jajahan<br/>Jeli</div>
            <div class="info-daerah lge" style="left:140px;top:120px" xorder='12'><div class="count" id="data-tanahmerah" code="58" branch="JKR Jajahan Tanah Merah">0</div>JKR Jajahan<br/>Tanah Merah</div>
            <div class="info-daerah lge" style="right:45px;top:270px" xorder='13'><div class="count" id="data-kesedar" code="61" branch="JKR KESEDAR">0</div>JKR <br/>KESEDAR</div>
            <img src="{{asset('my-assets/img/map-3d-kelantan.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-terengganu">
        <div class="map">
            <div class="info-daerah-master" style="right:40px;top:50px;"><div class="count giant" id="master-terengganu">372</div>Terengganu</div>
            <div class="info-daerah lge" style="right:180px;top:130px" xorder='1'><div class="count" id="data-terengganuhq" code="271" branch="Ibu Pejabat JKR Terengganu">0</div>Ibu Pejabat<br/>JKR Terengganu</div>
            <div class="info-daerah lge" style="left:235px;top:300px;" xorder='2'><div class="count" id="data-dungun" code="272" branch="JKR Daerah Dungun">0</div>JKR Dungun</div>
            <div class="info-daerah lge" style="left:90px;top:70px;" xorder='3'><div class="count" id="data-besut" code="273" branch="JKR Daerah Besut">0</div>JKR<br/>Besut</div>
            <div class="info-daerah lge" style="left:165px;top:110px;" xorder='4'><div class="count" id="data-setiu" code="275" branch="JKR Daerah Setiu">0</div>JKR<br/>Setiu</div>
            <div class="info-daerah xs" style="right:190px;top:220px;" xorder='5'><div class="count" id="data-marang" code="274" branch="JKR Daerah Marang">0</div>JKR<br/>Marang</div>
            <div class="info-daerah lge" style="left:130px;top:220px;" xorder='6'><div class="count" id="data-huluterengganu" code="278" branch="JKR Daerah Hulu Terengganu">0</div>JKR Hulu Terengganu</div>
            <div class="info-daerah lge" style="left:235px;top:400px;" xorder='7'><div class="count" id="data-kemaman" code="276" branch="JKR Daerah Kemaman">0</div>JKR Kemaman</div>
            <img src="{{asset('my-assets/img/map-3d-terengganu.svg')}}" alt="" width="100%"/>
        </div>
    </div>
    <div class="map-state map-state-sarawak">
        <div class="state-shutter" onClick="letGoState('sarawak')"><i class="fas fa-arrow-circle-left fa-2x"></i></div>
        <img src="{{asset('my-assets/img/map-3d-sarawak.svg')}}" alt="" width="100%"/>
    </div>
    <div class="map-state map-state-sabah">
        <div class="map">
            <div class="info-daerah-master" style="right:20px;top:20px;"><div class="count giant" id="master-sabah">2</div>Sabah</div>
            <div class="info-daerah lge" style="left:50px;top:110px" xorder='1'><div class="count" id="data-sabahhead">0</div>Ibu Pejabat<br/>JKR Sabah</div>
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
                    @if($state->code != 16)
                    <div id="info-{{$statesRefs[$state->code]['spot']}}" class="info" onClick="goState('{{$statesRefs[$state->code]['spot']}}','{{$state->code}}')"><div class="count">{{$state->total_by_state}}</div>{{$state->state_name}}</div>
                    @else
                    <div id="info-{{$statesRefs[$state->code]['spot']}}" class="infoonly"><div class="countdrilless">{{$state->total_by_state}}</div>{{$state->state_name}}</div>
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
                <div id="info-{{$statesRefs[$state->code]['spot']}}" class="info" onClick="goState('{{$statesRefs[$state->code]['spot']}}','{{$state->code}}')"><div class="count">{{$state->total_by_state}}</div>{{$state->state_name}}</div>
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

    const loadVehicleByDistrict = function(opt) {
        console.log('opt display', opt);
        var negeri = $('#show-opt').val();
        $.get("{{ route('report.vehicle-by-district-list')}}?opt="+opt+"&negeri="+negeri, function(result){
                $('#vehicle_by_district').html(result);
            });
    }

    $(document).ready(function(){
        initializeStateValue();
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
            }
        }else{
            breadGroup('negara');
        }

        $('.info-daerah').click(function() {
            var opt = $(this).children().attr('id');
            var cd = $(this).children().attr('code');
            $('#choice').text($(this).children().attr('branch'));
            opt = opt.replace("data-", "");
            openDrawer();
            loadVehicleByDistrict(cd);

            // $('#district-list').load('?opt=' + opt);
            // window.location.href = "{{route('report.report_map_peninsular')}}?opt="+opt;
        });
        $(window).resize(function() {
            //$('.mytitle').text($(window).width());
        });
    })
</script>
</body>
</html>
