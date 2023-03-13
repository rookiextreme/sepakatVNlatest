@php
$AccessMaintenanceJob = auth()->user()->vehicle('02', '01');
$TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('02', '01');

$search = Request('search') ? Request('search') : null;
$tab = Request('tab') ? Request('tab') : null;
$vehicle_id = Request('vehicle_id') ? Request('vehicle_id') : null;

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

    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
    <script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

    <style type="text/css">
        body {
        background-color:#ffffff;
    }
    .container {
        margin-top:80px;
        max-width:1000px;
        width:100%;
        margin-left:auto;
        margin-right:auto;
        background-color:#ffffff;
    }
    .shadow-box {
        margin-top:2%;
        width:55%;
        margin-left:auto;
        margin-right:auto;
    }
    .round-point {
        position: relative;

        width:100%;
        height:200px;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);*/
        /*background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
        margin-left:auto;
        margin-right:auto;

        border-radius: 15px 15px 15px 15px;
        -moz-border-radius: 15px 15px 15px 15px;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-style: solid;
        border-color:#c8c8cc;
        border-width:1px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);

        background-color: #ffffff;

        /*background-image:url(my-assets/img/lori.png);
        background-repeat: no-repeat;
        background-position: left bottom;
        background-size: 55%;*/
    }
    .plain-point {
        position: relative;
        background-color:transparent;
        margin-left:auto;
        margin-right:auto;
        padding:10px;
    }
    .sch-point {
        position: relative;
        width:100%;
        margin-left:auto;
        margin-right:auto;
        padding:0px;
        height:auto;
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
    }
    .spectitle {
        position:absolute;
        top:-50px;
        left:10px;
        font-family: helvetica-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
        margin-left:-10px
    }
    .spectitle span {
        font-family: avenir;
        font-size:20px;
        letter-spacing: 0px;
    }
    .pointer {
        position:absolute;
        right:-70px;
        width:40px;
        top:120px;
    }
    .round-point .shadow-point {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        top:330px;
        width: 280px;
        height: 20px;
        background-color: rgba(106,106,106,0.2);
        border-radius: 100px / 50px;
        cursor: pointer;
         /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);
    }

    .round-point .my-badge {
        position: absolute;
        top:-18px;
        right:-18px;
        background-color: #e9b600;
        -webkit-border-radius: 255px;
        -moz-border-radius: 255px;
        border-radius: 255px;
        height:30px;
        width: 30px;
        text-align: center;
        font-family: mark-bold;
        font-size: 16px;
        line-height: 28px;
        padding-right:0px;
        color:#ffffff;
    }
    .section {
        text-align: left;
        color:#2d2d2d;
        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
    }
    .section-bd {
        text-align: left;
        color:#2d2d2d;
        font-family:avenir-bold;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:11px;
        line-height: 20px;
    }
    .txt {
        width:100%;
        color:#252525;
        padding:5px;
        height:100px;
    }
    .txt .txt-box {
        padding:10px;
        cursor: pointer;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }
    .txt .txt-box:hover {
        background: #cfd0cd;
    }
    .txt-big {
        color:#252525;
        padding:5px;
        margin:5px;
        height:135px;
        padding-top:20px;
        width:128px;
        padding-left:15px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        cursor: pointer;
    }
    .txt-big:hover {
        background: rgba(207,208,205,0.8);
    }
    .sch-point .row {
        margin-left:-13px;
        margin-right:-13px;
    }
    .line-r {
        border-right-style: solid;
        border-right-color:#e3e3eb;
        border-right-width:1px;
    }
    .line-t {
        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
    }
    .line-b {
        border-bottom-style: solid;
        border-bottom-color:#e3e3eb;
        border-bottom-width:1px;
    }
    .count {
        font-size:30px;
        font-family:helve-bold;
        line-height: 30px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
        letter-spacing: 0px;
    }
    .terms {
        font-size:14px;
        line-height: 12px;
        font-family:avenir;
        color:#212121;
        margin-top:4px;
    }
    .crc {
        width:100%;
        height:90px;
        cursor: pointer;
        vertical-align: middle;
        text-align: center;
        -webkit-border-top-left-radius: 14px;
        -webkit-border-top-right-radius: 14px;
        -moz-border-radius-topleft: 14px;
        -moz-border-radius-topright: 14px;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        overflow: hidden;
        background-position: cover;
        background-repeat: no-repeat;
    }
    .lcal-2 {
        width:30px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:200px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }
    a.list {
        font-family: lato;
        cursor:pointer;
        color:#000000;
        text-decoration: none;
    }
    a.list:hover {
        color:darkseagreen;
    }
    .tabung {
        position: relative;
        margin-top:14px;
        margin-left:0px;
        width:90px;
        height:116px;
    }
    .tabung img {
        position:absolute;
        bottom:0px;
        z-index:2;
        width:54px;
    }
    .tabung-isi {
        position:absolute;
        left:5px;
        background: rgb(9,72,121);
        background: linear-gradient(90deg, rgba(9,72,121,1) 0%, rgba(106,220,251,1) 51%, rgba(9,72,121,1) 100%);
        width: 43px;
        height:30px;
        bottom:1px;
        z-index:1;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color:rgba(255,255,255,0.4);
        border-radius: 3px 3px 8px 8px;
        -moz-border-radius: 3px 3px 8px 8px;
        -webkit-border-radius: 3px 3px 8px 8px;
    }
    .tabung-isi.fund1 {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ff512f+0,f09819+50,ff512f+100 */
        background: #ff512f; /* Old browsers */
        background: -moz-linear-gradient(left,  #ff512f 0%, #f09819 50%, #ff512f 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  #ff512f 0%,#f09819 50%,#ff512f 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  #ff512f 0%,#f09819 50%,#ff512f 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff512f', endColorstr='#ff512f',GradientType=1 ); /* IE6-9 */
    }
    .tabung-isi.fund2 {
        background: #1f4037;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #99f2c8, #1f4037);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #99f2c8, #1f4037); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    .tabung-isi.fund3 {
        background: #c31432;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #240b36, #c31432);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #240b36, #c31432); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    .tabung-isi.fund4 {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ffd89b+0,caaa79+50,ffd89b+100 */
background: #ffd89b; /* Old browsers */
background: -moz-linear-gradient(left,  #ffd89b 0%, #caaa79 50%, #ffd89b 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(left,  #ffd89b 0%,#caaa79 50%,#ffd89b 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to right,  #ffd89b 0%,#caaa79 50%,#ffd89b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffd89b', endColorstr='#ffd89b',GradientType=1 ); /* IE6-9 */


    }
    .senggat-besar {
        position:absolute;
        width:2px;
        z-index: 3;
        height:50px;
        background-color: #464646;
        border-radius: 12px 12px 12px 12px;
        -moz-border-radius: 12px 12px 12px 12px;
        -webkit-border-radius: 12px 12px 12px 12px;
    }
    .senggat-besar.left {
        left:10px;
    }
    .senggat-besar.right {
        right:10px;
    }
    .senggat-tengah {
        border-left-color:#939393;
        border-left-width: 1px;
        border-left-style: dotted;
        height:50px;
    }
    .senggat-suku {
        position: absolute;
        top:0px;
        background-color:#939393;
        width:1px;
        height:15px;
        z-index:5;
    }
    .marker {
        position:absolute;
        left:20%;
        z-index: 4;
        top:-30px;
    }
    .progress {
        position:absolute;
        left:0px;
        top:0px;
        height:30px;
        background-color:#e9b600;
        z-index: 2;
    }
    .grid {
        position:relative;
        left:0px;
        width:100%;
        top:40px;
        height:90px;
        z-index: 3;
        padding-left:0px;
        padding-right: 0px;
    }
    .grid .grid-year {
        position: absolute;
        top:-25px;
        left:10px;
        font-family: helvetica-bold;
        color:#000000;
        font-size: 14px;
    }
    .grid .grid-mth {
        position: absolute;
        top:32px;
        font-family: helvetica-bold;
        color:#000000;
        font-size: 12px;
        width:60px;
        padding-left:20px;
        padding-right:20px;
    }
    .count-big {
        font-size:40px;
        font-family:helve-bold;
        line-height: 40px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
    }
    .count-high-ceiling {
        font-size:30px;
        font-family:helve-bold;
        line-height: 100px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
    }
    .shape-decline {
        position: absolute;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 20px solid red;
        border-right: 70px solid transparent;
    }
    .shape-incline {
        position: absolute;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 20px solid green;
        border-left: 70px solid transparent;
    }
    .count span {
        font-size:20px;
        font-family:helve-bold;
        line-height: 20px;
        color:#212121;
    }
    .separatozonal {
        height:4px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background-color:#e1e3df;
        width:100%;
        margin-bottom:20px;
        margin-top:0px;
        margin-left:0px;
        margin-right:0px;
    }
    .separatozonal-dark {
        height:4px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background-color:#b9bcb8;
        width:100%;
        margin-bottom:20px;
        margin-top:0px;
        margin-left:0px;
        margin-right:0px;
    }
    .shadow-point-1 {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        left:0px;
        bottom:-60px;
        width: 100%;
        height: 20px;
        background-color: rgba(106,106,106,0.2);
        border-radius: 100px / 50px;
        cursor: pointer;
         /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);
    }
    .table {
        border:none;
    }
    .table tbody tr td {
        padding:0px;
        line-height: 12px;
        font-family:mark;
        font-size:13px;
    }
    .table tbody tr {
        border-bottom-style: dotted;
        border-bottom-width: 1px;
        border-bottom-color: #b9bcb8;
    }
    .table tbody tr:last-of-type {
        border-bottom-style:none;
        border-bottom-width: 0px;
    }
    .table tbody tr td:first-of-type {
        padding-left:0px !important;
    }
    .table tbody tr td:last-of-type {
        padding-right:0px !important;
        text-align: right;
        font-family:mark-bold;
    }
    .info-box {
        position: relative;

        width:100%;
        height:auto;
        margin-left:auto;
        margin-right:auto;
        margin-bottom:20px;
        border-radius: 15px 15px 15px 15px;
        -moz-border-radius: 15px 15px 15px 15px;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-style: solid;
        border-color:#c8c8cc;
        border-width:1px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);

        background-color: #ffffff;
        padding:20px;
    }
    .module {
        font-family: helvetica-bold;
        font-size:18px;
        letter-spacing: -1px;
        line-height: 20px;
        color:#272727;
    }
    .module-info {
        font-family: avenir;
        font-size:14px;
        letter-spacing: 0px;
        line-height: 14px;
    }
    #tren_woksyop {
        height: 200px;
    }
    .shade-floor {
        position: relative;
        background: rgb(203,203,203);
        background: linear-gradient(0deg, rgba(203,203,203,1) 0%, rgba(227,231,225,1) 10%, rgba(255,255,255,1) 100%);
        border-radius: 0px 0px 15px 15px;
        -moz-border-radius: 0px 0px 15px 15px;
        -webkit-border-radius: 0px 0px 15px 15px;
    }
    .count-xs {
        font-size:22px;
        font-family:helve-bold;
        line-height: 22px;
        color:#212121;
        margin-top:5px;
        margin-bottom:0px;
        letter-spacing: 0px;
    }
    .pct-woksyop {
        position: relative;
        margin-top:5px;
        margin-bottom:10px;
    }
    .txt-nilai {
        color: #40b293;
    }
    .txt-senggara {
        color: #ea5e27;
        text-align: right;
    }
    .pct-penilaian {
        position:absolute;
        top:0px;
        left:0px;
        background-color: #40b293;
        height:5px;
        border-radius: 15px 0px 0px 15px;
        -moz-border-radius: 15px 0px 0px 15px;
        -webkit-border-radius: 15px 0px 0px 15px;
        padding:0px;
        margin-right:0px;
    }
    .pct-penyenggaraan {
        position:absolute;
        top:0px;
        right:0px;
        background-color: #ea5e27;
        height:5px;
        border-radius: 0px 15px 15px 0px;
        -moz-border-radius: 0px 15px 15px 0px;
        -webkit-border-radius:  0px 15px 15px 0px;
        padding:0px;
        margin-left:0px;
    }
    .jadual-woksyop {
        margin-top:23px;
        padding-left:10px;
        padding-right:10px;
    }
    .jadual-woksyop .row {
        margin-top:3px;
    }
    .jadual-woksyop div {
        height:28px;
        line-height: 28px;
    }
    .dys {
        padding-left:4px;
        text-align: center;
        font-size:14px;
        font-family:mark-bold;
    }
    .total {
        font-size:14px;
        font-family:helve-bold;
        width:40px;
        text-align: center;
    }
    .total-alone {
        font-size:14px;
        font-family:helve-bold;
        padding-left:0px;
        padding-right:0px;
        width:40px;
        text-align: center;
    }
    .jadual-woksyop .row .bar-head {
        position:relative;
        width: auto;
        min-width:50%;
    }
    .jadual-woksyop .row .bar {
        position:relative;
        background-image: url('my-assets/img/center-grid.jpg'));
        background-repeat: repeat-y;
        background-position: center center;
        width: auto;
        min-width:50%;
    }
    .small-pct-penilaian {
        position:absolute;
        top:11px;
        left:0px;
        background-color: #40b293;
        max-height:5px;
        border-radius: 4px 0px 0px 4px;
        -moz-border-radius: 4px 0px 0px 4px;
        -webkit-border-radius: 4px 0px 0px 4px;
        padding:0px;
        margin-right:0px;
    }
    .small-pct-penyenggaraan {
        position:absolute;
        top:11px;
        right:0px;
        background-color: #ea5e27;
        max-height:5px;
        border-radius: 0px 4px 4px 0px;
        -moz-border-radius: 0px 4px 4px 0px;
        -webkit-border-radius:  0px 4px 4px 0px;
        padding:0px;
        margin-left:0px;
    }

    .jadual-woksyop .row .bar .hor-split {
        position:absolute;
        top:-2px;
        left:18%;
        width:198px;
        height:2px;
        background-image: url(my-assets/img/hor-split.png);
        background-repeat: no-repeat;
        background-position: top center;
    }
    .day-box {
        background-color: #efefef;
        border-radius: 8px 3px 3px 8px;
        -moz-border-radius: 8px 3px 3px 8px;
        -webkit-border-radius: 8px 3px 3px 8px;
        height:100%;
        font-size:14px;
        font-family:mark-bold;
        color:#4f4f4f;
        text-align: center;
    }
    .grand-total {
        position: absolute;
        right:10px;
        top:-100px;
        text-align: center;
        background: rgb(203,203,203);
background: linear-gradient(0deg, rgba(203,203,203,1) 0%, rgba(227,231,225,1) 100%);
        height:50px;
        width:50px;
        width:auto;
        line-height:50px;
        font-family: helvetica-bold;
        font-size:22px;
        color:#4f4f4f;
        border-color: #b0b0b1;
        border-style: solid;
        border-width: 1px;
        border-radius: 25px 25px 25px 25px;
        -moz-border-radius: 25px 25px 25px 25px;
        -webkit-border-radius:  25px 25px 25px 25px;
    }
    .shade-reverse {
        background: rgb(203,203,203);
        background: linear-gradient(180deg, rgba(203,203,203,1) 0%, rgba(227,231,225,1) 10%, rgba(255,255,255,1) 100%);
        border-radius: 15px 15px 0px 0px;
        -moz-border-radius: 15px 15px 0px 0px;
        -webkit-border-radius: 15px 15px 0px 0px;
    }
    .arrow-nilai {
        position:absolute;
        left:-1px;
        top:4px;
        height:18px;
        width:11px;
        z-index: 4;
        padding:0px;
        vertical-align: top;
        background-image: url(my-assets/img/arrow-nilai.svg);
        background-repeat: no-repeat;
        background-image: cover;
        background-position-x: left;
    }
    .arrow-senggara {
        position:absolute;
        right:-1px;
        top:4px;
        height:18px;
        width:11px;
        z-index: 4;
        padding:0px;
        vertical-align: top;
        background-image: url(my-assets/img/arrow-senggara.svg);
        background-repeat: no-repeat;
        background-image: cover;
        background-position-x: right;
    }
    .arrow-senggara.none, .arrow-nilai.none {
        display: none;
    }
    .box-nilai {
        display: inline-block;
        width: 40px;
        background-color: #40b293;
        text-align:center;
        height:45px;
        vertical-align: text-top;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        line-height: 45px;
    }
    .box-senggara {
        display: inline-block;
        width: 40px;
        background-color: #ea5e27;
        text-align:center;
        height:45px;
        vertical-align: text-top;
        border-radius: 5px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        line-height: 45px;
    }
    .box-tren-woksyop {
        position: absolute;
        bottom:-17px;
        left:-8px;
        width:200px;
        height:280px;
        background-image: url(my-assets/img/tools.png);
        background-repeat: no-repeat;
        background-size: 100px;
        background-position: left bottom;
    }
    .tren-woksyop {
        position:absolute;
        right:18px;
        bottom:8px;
        width:72px;
        text-align: right;
    }
    .signage-back {
        position:absolute;
        bottom:-20px;
        left:14%;
        right:auto;
        height:140px;
        width:135px;
        background-image: url(../../../public/my-assets/img/siap-siaga-min.png);
        background-repeat: no-repeat;
        background-position: center bottom;
        background-size: 100px 136px;
        font-family: helve-bold;
        color:#000000;
        font-size:40px;
        text-align: center;
        padding-top:15px;
    }
    .dark-cloud {
        background-repeat: no-repeat;
        background-position: center bottom;
        background-size: 100% auto;
    }
    .signage-back .sedia {
        font-family: mark-bold;
        text-align: center;
        text-transform:uppercase;
        color:#000000;
        font-size:12px;
        width:100%;
        margin-top:-12px;
    }
    .top-shelf {
        position: relative;
        height:108px;
        border-width: 0px;
        border-style: none;
        border-radius: 4px 10px 10px 3px;
        -moz-border-radius:  4px 10px 10px 3px;
        -webkit-border-radius: 4px 10px 10px 3px;
        background-color:#ffad00;
        padding-left:150px;
    }
    .curve {
        position: absolute;
        top:0px;
        left:0px;
        height:100px;
        background-size: 155px 100px;
        background-repeat: none;
        width:155px;
        font-family: helve-bold;
        color:#846d45;
        font-size: 22px;
        line-height: 20px;
        padding-top:10px;
    }
    .top-shelf .active-box {
        display: inline-block;
        margin-left: 2px;
        margin-right: 2px;
        background-color:transparent;

        width:160px;
        text-align: center;
        cursor: pointer;
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius:  10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        margin-right:10px;
        margin-top:5px;
        border-color:#ffffff;
        border-style: solid;
        border-width: 1px;
        padding:4px;
    }

    .top-shelf .active-box-selected {
        background-color: #345864;
    }

    .top-shelf .active-box .inside{
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#45484d+0,000000+100;Black+3D+%231 */
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#ffffff+0,f1f1f1+50,e1e1e1+51,f6f6f6+100;White+Gloss+%231 */
        background: rgb(255,255,255); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(255,255,255,1) 0%, rgba(241,241,241,1) 50%, rgba(225,225,225,1) 51%, rgba(246,246,246,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(255,255,255,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(255,255,255,1) 0%,rgba(241,241,241,1) 50%,rgba(225,225,225,1) 51%,rgba(246,246,246,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0 ); /* IE6-9 */
        width:100%;
        height:100%;
        text-align: center;
        font-family: helve-bold;
        font-size:22px;
        line-height: 60px;
        cursor: pointer;
        color:#000000;
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius: 6px 6px 6px 6px;
    }
    .top-shelf .active-box .inside:hover {
        background: rgb(255,255,255);

        width:100%;
        height:100%;
        text-align: center;
        font-family: helve-bold;
        font-size:22px;
        line-height: 60px;
        cursor: pointer;
        color:#000000;
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius: 6px 6px 6px 6px;
    }

    .top-shelf .active-box-selected {
    }
    .shelf {
        position: relative;
        height:120px;
        overflow-x: scroll;
        width:100%;
        border-bottom-width: 1px;
        border-bottom-color:#e3dfdf;
        border-bottom-style: solid;
    }
    .jobtype {
        position: absolute;
        top:5px;
        left:0px;
        width:300px;
        font-family: avenir;
        font-size:14px;
    }
    .jobtype span {
        font-family: mark-bold;
        color:#CD5C37;
        font-size:16px;
    }
    .my-date {
        font-family:helve-bold;
        font-size:16px;
        line-height: 30px;
    }
    .job-box {
        float:left;
        height:70px;
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#45484d+0,000000+100;Black+3D+%231 */
        background: rgb(69,72,77); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(69,72,77,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=0 ); /* IE6-9 */
        width:140px;
        text-align: center;
        font-family: helve-bold;
        font-size:22px;
        line-height: 70px;
        cursor: pointer;
        color:#ffffff;
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius:  10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        margin-right:10px;
        margin-top:35px;
    }
    .job-box:hover {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#000000+0,45484d+100 */
        background: rgb(0,0,0); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(0,0,0,1) 0%, rgba(69,72,77,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  rgba(0,0,0,1) 0%,rgba(69,72,77,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  rgba(0,0,0,1) 0%,rgba(69,72,77,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#45484d',GradientType=0 ); /* IE6-9 */
    }

    .fixed-submit {
        position: fixed;bottom:0px;left:0px;width:100%;height:65px;background-color:#dde3d7;padding-left:30px;padding-top:13px;z-index:100;
        border-top-width: 1px;
        border-top-color:#c9d1c1;
        border-top-style: solid;
    }

    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
        .container {
            width: 90%;
        }
	}
	@media (max-width: 1199.98px) {
		/*Large devices (desktops, less than 1200px)*/
		/*Large*/
        .container {
            width: 95%;
        }
	}
	@media (max-width: 991.98px) {
		/* Medium devices (tablets, less than 992px)*/
		/*medium*/
        .container {
            width: 98%;
        }
	}
	@media (max-width: 767.98px) {
		/* Small devices (landscape phones, less than 768px)
		/*small*/
        .container {
            width: 100%;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .container {
            width: 100%;
        }
        .spectitle {
            margin-left:20px
        }
        .my-date {
            margin-left:20px;
        }
        .top-shelf {
            width:100%;
            border-radius: 0px;
            -moz-border-radius:  0px;
            -webkit-border-radius: 0px;
            padding-left:30px;
        }
        .job-box {
            margin-top:13px;
        }
        .jobtype {
            position:sticky;
            left:0px;
        }
        .shelf {
            padding-left:30px;
        }
        .curve {
            padding-left:30px;
            font-size: 16px;
            line-height: 18px;
        }
        .top-shelf {
            padding-left:150px;
        }
	}

    @media print {
        @page {
            size: 'A4' portrait; /* auto is default portrait; */
        }

        .col-md-6 {
            width: 50%;
        }

        .no-printme  {
            display: none;
        }
        .printme  {
            display: block;
        }
        .printme th, .printme td {
            padding-left: 10px;
        }
        .body,.content {
            background: transparent;
        }
        .box-info {
            border: none;
            height: 30px;
        }

        .rlabel, .mytext {
            line-height: unset;
        }

        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
        }
    }
    </style>
    <script>
        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="">
        <div class="mytitle">Penyenggaraan</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
                <li class="breadcrumb-item"><a
                        href="javascript:parent.openPgInFrame('{{ route('maintenance.job.register', ['id' => $hasMaintenanceDetail->id, 'tab' => 2 ]) }}')">Kenderaan Di Selenggara</a></li>
                <li class="breadcrumb-item active" aria-current="page"> {{$hasVehicle->plate_no}}</li>
            </ol>
        </nav>
    </div>
    <div class="main-content" style="padding-right:0px">

        @if($detail && $vehicle_id)
            @php
                //$detail = $detail->where('id',$vehicle_id)->first();
            @endphp
            <div class="col-md-12">
                <div class="quick-navigation mt-2" data-fixed-after-touch="">
                    <div class="wrapper" style="position: relative">
                        <ul id="tabActive">
                            <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Rekod Kenderaan</li>
                            @php
                                $dontActive = 0;
                                $rolling = auth()->user()->roles;


                                if(!empty($rolling)){
                                    foreach($rolling as $r){

                                        if(in_array(auth()->user()->getRoleDesc($r->name)->code, [05,17,16])){
                                            $dontActive++;
                                        }
                                    }
                                }
                            @endphp

                            @if($dontActive == 0)
                                <li class="cub-tab" onClick="goTab(this, 'info');" id="tab2">Senarai Borang</li>
                            @endif
                        </ul>
                        <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
                    </div>
                </div>
                <section id="detail" class="tab-content">
                    @include('maintenance.job.done.tab.job-done-detail')
                </section>
                <section id="info" class="tab-content">
                    @include('maintenance.job.done.tab.job-done-info')
                </section>
            </div>
            @elseif($detail && $detail->count() == 0 && $search)
            Tiada Rekod
        @endif

        <div class="divider-line" style="padding-top:100px"></div>

    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        function searching(value){
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode ==  13 || !value){
                window.location.href = "{{route('maintenance.job.vehicle.monitoring.done.form')}}?search="+value;
            }
        }

        $(document).ready(function(){
            $('.cub-tab:first-child').addClass('active');
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic"
            });
        });

    </script>

</body>

</html>
