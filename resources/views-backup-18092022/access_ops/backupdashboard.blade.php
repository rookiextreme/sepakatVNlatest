@php

$totalNotYetApprovedUser = DB::table('users.details')
                        ->join('ref_status AS a', 'a.id', '=', 'ref_status_id')
                        ->where('a.code','03')->count();
$totalRegisteredUser = DB::table('users.details')
                        ->join('ref_status AS a', 'a.id', '=', 'ref_status_id')
                        ->where('a.code','06')->count();

@endphp

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
    body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
        background-attachment: fixed;
    }
    .container {
        margin-top:80px;
        max-width:1000px;
        width:80%;
        margin-left:auto;
        margin-right:auto;
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
        width: 300px;
        font-family: helvetica-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
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
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .container {
            margin-top:10px;
            width:90%;
        }
        .sch-point {
            height:90px;
            width:100%;
            margin-bottom:20px;
            margin-top:50px;
        }
        .sch-point .txt {
            display: inline-block;
            width:100%;
            color:#252525;
            padding:5px;
            height:90px;
        }
        .box-nom {
            padding:0px;
            padding-top:0px;
            text-align: center;
            padding-left:0px;
            height:90px;
        }
        .box-nom .line-t {
            border-left-style: solid;
            border-left-color:#e3e3eb;
            border-left-width:1px;
            border-top-style: none;
        }
        .round-point {
            width:100%;
            background-color:#ffffff;
        }
        .lori {
            background-size: 50%;
        }
        .pointer {
            display: none;
        }
        .section {
            font-family:avenir;
            font-size:14px;
            line-height: 16px;
        }
        .count {
            font-size:40px;
            font-family:avenir-bold;
            color:#212121;
            margin-top:8px;
            line-height: 43px;
            margin-bottom:0px;
            filter:none;
        }
        .txt .txt-box {
            height:78px;
        }
        .txt-box:hover {
            background: rgba(207,208,205,0.8);
        }
        .round-point .my-badge {
            top:-12px;
            right:-12px;
        }
        .txt-big {
            width:95%;
        }
        .crc {
            -webkit-border-radius: 15px;
            -webkit-border-bottom-left-radius: 0;
            -moz-border-radius: 15px;
            -moz-border-radius-bottomleft: 0;
            border-radius: 15px;
            border-bottom-left-radius: 0;
            height: 90px;
            width:100%;
            background-position: center right;
        }
        .sch-point .row {
            margin-left:0px;
            margin-right:0px;
        }
        .sch-point .row .box-nom .txt .section {
            display: none;
        }
        .round-point .shadow-point {
            position: absolute;
            margin-left:auto;
            margin-right:auto;
            top:280px;
            width: 100%;
            height: 20px;
            background-color: rgba(106,106,106,0.2);
            border-radius: 100px / 50px;
            cursor: pointer;
            /* Add the blur effect */
            filter: blur(8px);
            -webkit-filter: blur(8px);
        }
        .shadow-point-1 {
            display: none;
        }
        .module-info {
            font-size:16px;
            line-height: 16px;
        }
        .module {
            font-size:26px;
            line-height: 26px;
        }
        .separatozonal {
            display: none;
        }
        .spectitle {
            position:relative;
            top:0px;
            left:0px;
            width: 100%;
            margin-bottom:20px;
        }
        .info-box {
            margin-bottom:10px;
        }
        .grid {
            height:115px;
        }
	}

    #btn-print-container {
        position: absolute;
        top: -60px;
        right: -415px;
        width: 100%;
    }

    @media print {

        .separatozonal {
            display: none;
        }
        .content {
            padding: 0 !important;
            margin: 0 !important;
            transform: scale(.95);
            transform-origin: top left;
            background: transparent !important;
            background-color: transparent !important;
            box-shadow:
        }

        .container {
            margin-top: 50px;
        }

        .info-box {
            box-shadow: none;
        }

        .shadow-point-1 {
            display: none;
        }

        html, body {
            height: 99%;
        }
    }
</style>
<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<!--<div class="info-box">
    <div class="module mb-0">
        <div class="module-info ml-2">Pengurusan</div>
        Waran
    </div>
    <div class="row shade-floor p-0" style="height:130px;">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6" style="position: relative;">
            <div class="tabung">
                <img src="{{asset('my-assets/img/tabung-thin.png')}}">
                <div class="tabung-isi fund1" style="height:51%"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6" style="position: relative;">
            <div class="tabung">
                <img src="{{asset('my-assets/img/tabung-thin.png')}}">
                <div class="tabung-isi fund2" style="height:36%"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6" style="position: relative;">
            <div class="tabung fund3">
                <img src="{{asset('my-assets/img/tabung-thin.png')}}">
                <div class="tabung-isi fund3" style="height:61%"></div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6" style="position: relative;">
            <div class="tabung fund4">
                <img src="{{asset('my-assets/img/tabung-thin.png')}}">
                <div class="tabung-isi fund4" style="height:90%"></div>
            </div>
        </div>
    </div>
    <div class="row" style="height:130px;">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="pt-3">
                <div class="section">B37 KKR</div>
                <div class="count">35%</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="pt-3">
                <div class="section">Agensi Luar</div>
                <div class="count">35%</div>

            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="pt-3">
                <div class="section">MHPV</div>
                <div class="count">35%</div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
            <div class="pt-3">
                <div class="section">JPM</div>
                <div class="count">35%</div>
            </div>
        </div>
    </div>
</div>-->
<body class="content">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-12" style="position: relative;">
                <div class="spectitle">Dashboard <span>Keseluruhan</span></div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="height:340px">
                        <div class="info-box">
                            <div class="module mb-0">
                                <div class="module-info ml-2">Pengurusan</div>
                                Waran
                            </div>
                            <div class="row shade-floor p-0" style="height:130px;">
                                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-4" style="position: relative;">
                                    <div class="tabung">
                                        <img src="{{asset('my-assets/img/tabung.png')}}">
                                        <div class="tabung-isi" style="height:65%"></div>
                                    </div>
                                </div>
                                <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-8" style="position: relative;">
                                    <div style="position: absolute; bottom:20px;left:15px;">
                                        <div class="count">35%</div>
                                        <div class="terms">telah dibelanjakan</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="grid">
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="position: relative;">
                                                <div class="senggat-besar left"></div>
                                                <div class="grid-year">2021</div>
                                                <div class="grid-mth" style="left:0px">Jan</div>
                                            </div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="position: relative;">&nbsp;</div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="position: relative;">&nbsp;</div>
                                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3" style="position: relative;">
                                                <div class="senggat-besar right"></div>
                                                <div class="grid-mth text-end" style="right:0px">Dis</div>
                                            </div>
                                        </div>
                                        <div class="senggat-suku" style="left:25%;"></div>
                                        <div class="senggat-suku" style="left:50%;height:40px"></div>
                                        <div class="senggat-suku" style="left:75%;"></div>
                                        <div class="marker" style="left:46.8%">
                                            <svg width="32px" height="45px" viewBox="38 12 128 180" >
                                                <path style="fill:#FFFFFF;stroke:#000000;stroke-width:4;stroke-miterlimit:10;" d="M158.5,73.8c0-32.3-26.2-58.4-58.4-58.4c-32.3,0-58.4,26.2-58.4,58.4c0,16.6,6.9,31.5,18,42.1c7.2,7.2,16.7,17.2,20.1,22.5c7,10.9,20,47.9,20,47.9s13.3-37,20.4-47.9c3.3-5.1,12.2-14.4,19.3-21.6C151.2,106.1,158.5,90.9,158.5,73.8z"/>
                                                <circle style="fill:#000000;" cx="100.1" cy="74.7" r="44.1"/>
                                                <text x="100" y="90" text-anchor="middle" style="font-size:50px;fill:#FFFFFF;">20</text>
                                                </svg>
                                        </div>
                                        <div class="progress" style="width: 34.4%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="info-box dark-cloud" style="background-image: url({{asset('my-assets/img/dark-cloud.png')}});">
                        <div class="module">
                            <div class="module-info ml-2">Pengurusan</div>
                            Logistik
                        </div>
                        <div class="section mt-3">Tempahan Kenderaan</div>
                        <div class="row">
                            <div class="col-6 count">{{$booking_logistic_percent}}%</div>
                            <div class="col-6" style="position: relative;">
                                <div class="shape-decline"></div>
                            </div>
                        </div>
                        <hr/>
                        <div class="section mt-3">
                            Siap Siaga Bencana
                        </div>
                        <div style="position:relative;height:135px;width:100%">
                            <span class="btn section" onclick="openPgInFrame('{{ route('logistic.disasterready.list') }}')">
                                <div class="signage-back" style="background-image: url({{asset('my-assets/img/siap-siaga-min.png')}});">{{$general_record_count_view->total_vehicle_disaster_ready ? $general_record_count_view->total_vehicle_disaster_ready : 0 }}
                                    <div class="sedia">Sedia</div>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-7 col-12" style="position: relative;">
                <div class="info-box">
                    <div class="row ">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="module mb-0">
                                <div class="module-info ml-2">Pengurusan</div>
                                Rekod
                            </div>
                            <div class="txt-big">
                                <div class="section">Jumlah Aset</div>
                                <div class="count-big">{{number_format($general_record_count_view->total_department_active)}}</div>
                                <div class="terms">kenderaan</div>
                            </div>
                        </div>
                        <hr/>
                        <div class="module mb-0">
                            <div class="module-info ml-2">Komposisi</div>
                            Kenderaan
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <div class="col " id="chrtJobFamily" style="margin-left:auto;margin-right:auto;margin-top:0px;height:200px;padding-top:0px;padding-bottom:0px"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-0 pl-4 pr-4" style="position: relative;padding-top:0px;">
                            <table class="table" style="width:80%;margin-left:auto;margin-right:auto;margin-top:-10px">
                                <tbody>
                                    @foreach ($vehicleByCategoryList as $vehicleByCategory)
                                        <tr>
                                            <td>{{$vehicleByCategory->name}}</td>
                                            <td>{{number_format($vehicleByCategory->total, 0)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="info-box">
                        <div class="row" style="padding:0px;">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 pr-0 line-r" style="position: relative;">
                                {{-- <div id="btn-print-container">
                                    <a class="btn cux-btn" onclick="printMe(this)">Cetak</a>
                                </div> --}}
                                <div class="box-tren-woksyop" style="background-image: url({{asset('my-assets/img/tools.png')}});"></div>
                                <div class="module">
                                    <div class="module-info">Pengurusan</div>
                                    Woksyop
                                </div>
                                <div class="tren-woksyop">
                                    <div class="section text-end pr-4"><i class="fal fa-arrow-up"></i> / <i class="fal fa-arrow-down"></i></div>
                                    <div class="" style="position: relative;height:55px">
                                        <div class="count">
                                            98%
                                            <div class="shape-incline" style="left: 0px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <figure class="highcharts-figure" style="margin-top:10px">
                                    <div id="tren_woksyop"></div>
                                </figure>
                            </div>
                        </div>
                        <hr/>
                        <div class="section mt-3">Jadual Woksyop</div>
                        <div class="section-bd mb-4">21 - 26 Jun 2021</div>

                        <div class="row" style="position: relative;">
                            <div class="grand-total">
                                54
                            </div>
                            <div class="col">
                                <div class="box-nilai">
                                    <i class="fal fa-clipboard fa-lg" style="filter: brightness(0) invert(1)"></i>
                                </div>
                                <div style="display: inline-block;padding-left:8px;vertical-align: text-top;" class="terms">
                                    Penilaian
                                    <div class="count-xs">33.4% <small>32</small></div>
                                </div>
                            </div>
                            <div class="col text-end">
                                <div style="display: inline-block;padding-right:8px;vertical-align: text-top;" class="terms">
                                    Penyenggaraaan
                                    <div class="count-xs"><small>22</small> 66.6%</div>
                                </div>
                                <div class="box-senggara">
                                    <i class="fal fa-car-mechanic fa-lg" style="filter: brightness(0) invert(1)"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pct-woksyop">
                            <div class="pct-penilaian" style="width:33.4%">&nbsp;</div>
                            <div class="pct-penyenggaraan" style="width:66.6%">&nbsp;</div>
                        </div>
                        <div class="jadual-woksyop" style="padding-left:10px;padding-right:10px;">
                            <div class="row line-b">
                                <div class="col-xl-1 col-1"><i class="fal fa-calendar-alt"></i></div>
                                <div class="col total-alone line-r">Jumlah</div>
                                <div class="col total-alone txt-nilai">
                                    <i class="fal fa-clipboard"></i>
                                </div>
                                <div class="col bar-head text-center">
                                    <div class="terms" style="margin-top:-2px">Penggunaan Woksyop</div>
                                </div>
                                <div class="col total-alone txt-senggara">
                                    <i class="fal fa-car-mechanic"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1 col-1 day-box">I</div>
                                <div class="col total-alone line-r">7</div>
                                <div class="col total-alone txt-nilai">5</div>
                                <div class="col bar">
                                    <div class="hor-split" style="background-image: url({{asset('my-assets/img/hor-split.png')}});"></div>
                                    <div class="small-pct-penilaian" style="width:71%">&nbsp;</div>
                                    <div class="small-pct-penyenggaraan" style="width:29%">&nbsp;</div>
                                </div>
                                <div class="col total-alone txt-senggara">2</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1 col-1 day-box">S</div>
                                <div class="col total-alone line-r">12</div>
                                <div class="col total-alone txt-nilai">6</div>
                                <div class="col bar">
                                    <div class="hor-split" style="background-image: url({{asset('my-assets/img/hor-split.png')}});"></div>
                                    <div class="small-pct-penilaian" style="width:50%">&nbsp;</div>
                                    <div class="small-pct-penyenggaraan" style="width:50%">&nbsp;</div>
                                </div>
                                <div class="col total-alone txt-senggara">6</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1 col-1 day-box">R</div>
                                <div class="col total-alone line-r">11</div>
                                <div class="col total-alone txt-nilai">7</div>
                                <div class="col bar">
                                    <div class="hor-split" style="background-image: url({{asset('my-assets/img/hor-split.png')}});"></div>
                                    <div class="small-pct-penilaian" style="width:64%">&nbsp;</div>
                                    <div class="small-pct-penyenggaraan" style="width:36%">&nbsp;</div>
                                </div>
                                <div class="col total-alone txt-senggara">4</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1 col-1 day-box">K</div>
                                <div class="col total-alone line-r">10</div>
                                <div class="col total-alone txt-nilai">4</div>
                                <div class="col bar">
                                    <div class="hor-split" style="background-image: url({{asset('my-assets/img/hor-split.png')}});"></div>
                                    <div class="small-pct-penilaian" style="width:40%">&nbsp;</div>
                                    <div class="small-pct-penyenggaraan" style="width:60%">&nbsp;</div>
                                </div>
                                <div class="col total-alone txt-senggara">6</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1 col-1 day-box">J</div>
                                <div class="col total-alone line-r">8</div>
                                <div class="col total-alone txt-nilai">8</div>
                                <div class="col bar">
                                    <div class="hor-split" style="background-image: url({{asset('my-assets/img/hor-split.png')}});"></div>
                                    <div class="small-pct-penilaian" style="width:100%">&nbsp;</div>
                                    <div class="small-pct-penyenggaraan" style="width:0%">&nbsp;</div>
                                </div>
                                <div class="col total-alone txt-senggara">0</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-1 col-1 day-box">S</div>
                                <div class="col total-alone line-r">6</div>
                                <div class="col total-alone txt-nilai">2</div>
                                <div class="col bar">
                                    <div class="hor-split" style="background-image: url({{asset('my-assets/img/hor-split.png')}});"></div>
                                    <div class="small-pct-penilaian" style="width:33%">&nbsp;</div>
                                    <div class="small-pct-penyenggaraan" style="width:67%">&nbsp;</div>
                                </div>
                                <div class="col total-alone txt-senggara">4</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];
    Highcharts.chart('chrtJobFamily', {
        chart: {
            type: 'variablepie',
            marginBottom: 0
        },
        title: {
            text: ''
        },
        tooltip: {
            headerFormat: '',
            pointFormat: '<span style=\"font-family:mark;font-size:14px;\">{point.name}</span> :<br>' +
                '<span style=\"font-family:mark-bold;font-size:14px;margin-bottom:10px\">{point.y}</span>'
        },
        plotOptions: {
                variablepie: {
                    allowPointSelect: true,
                    colors: pieColors,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
        series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: 'kategori',
            data: [{
                name: 'Sedan',
                y: 505370,
                z: 92.9
            }, {
                name: 'France',
                y: 551500,
                z: 118.7
            }, {
                name: 'Poland',
                y: 312685,
                z: 124.6
            }, {
                name: 'Czech Republic',
                y: 78867,
                z: 137.5
            }, {
                name: 'Italy',
                y: 301340,
                z: 201.8
            }, {
                name: 'Switzerland',
                y: 41277,
                z: 214.5
            }, {
                name: 'Germany',
                y: 357022,
                z: 235.6
            }]
        }],
        exporting: {
            enabled: false
        },
        credits: {
            enabled: false
        }
    });
    Highcharts.chart('tren_woksyop', {
        chart: {
            type: 'column',
            marginBottom: 4,
            marginTop: 10
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: [
                'Mac',
                'Apr',
                'Mei'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Penilaian',
            data: [49, 71, 106],
            showInLegend: false,
            color: '#40b293'

        }, {
            name: 'Penyenggaraan',
            data: [83, 78, 98],
            showInLegend: false,
            color: '#ea5e27'

        }],
        exporting: {
            enabled: true
        },
        credits: {
            enabled: false
        }
    });

//doChunk();
</script>
<script>
    jQuery(document).ready(function() {
    })
</script>
</body>
</html>
