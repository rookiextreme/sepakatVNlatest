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
    }
    .container {
        margin-top:15%;
        width:55%;
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

        width:140px;
        height:210px;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);*/
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);
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
    }
    .round-point:hover {
        transform: scale(1.1);
    }
    .pointer {
        position:absolute;
        right:-90px;
        width:40px;
    }
    .spectitle {
        font-family: helvetica-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
    }
    .round-point .shadow-point {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        top:240px;
        width: 140px;
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
    .round-point .txt {
        position: absolute;
        top:90px;
        width:100%;

        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
        color:#252525;
        padding-top:12px;
        padding-left:12px;
    }
    .round-point .txt .section, .special .txt .section {
        text-align: left;

        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
    }
    .round-point .txt .count {
        font-size:30px;
        font-family:helve-bold;
        line-height: 30px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
    }
    .round-point .txt .terms {
        font-size:14px;
        font-family:avenir;
        line-height: 14px;
        color:#212121;
    }
    .round-point .crc {
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
        .container {
            margin-top:4%;
            width:100%;
            padding-left:20px;
            padding-right:20px;
        }
        .round-point {
            width:100%;
        }
        .round-point .pointer {
            display: none;
        }
        .round-point .txt .section {
            font-family:avenir;
            font-size:14px;
            line-height: 16px;
        }
        .round-point .txt .count {
            font-size:40px;
            font-family:avenir-bold;
            line-height: 30px;
            color:#212121;
            margin-top:10px;
            margin-bottom:0px;
        }
        .round-point .my-badge {
            top:-12px;
            right:-12px;
        }
        .special {
            height:110px;
            margin-top:20px;
        }
        .special .crc {
            -webkit-border-radius: 15px;
            -webkit-border-top-right-radius: 0;
            -moz-border-radius: 15px;
            -moz-border-radius-topright: 0;
            border-radius: 15px;
            border-top-right-radius: 0;
            height: 108px;
            width:34%;

            border-right-style: solid;
            border-right-color:#c2c2c2;
            border-right-width:1px;

            background-position: center center;
        }
        .special .txt {
            position: absolute;
            top:0px;
            left:35%;
            width:50%;

            border-top-style: none;
            color:#252525;
            padding-top:12px;
            padding-left:12px;
        }
        .special .shadow-point {
            top:140px;
            width:100%;
            background-color: rgba(106,106,106,0.2);
            border-radius: 100px / 50px;
        }
        .round-point:hover {
            transform: none;
            border-style: solid;
            border-color:#a9a9ae;
            border-width:1px;
        }
	}
</style>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="spectitle">Pengurusan Akses</div>
            <div class="col-xl-4 col-sm-5 col-6" style="position: relative;">
            <a href="javascript:openPgInFrame('{{route('user.approval')}}')">
                <div class="round-point tanda">
                    <div class="crc" style="background-image: url({{asset('my-assets/img/waiting.jpg')}});background-size: cover;"></div>
                    <div class="txt">
                        <div class="section">Menunggu Kelulusan</div>
                        <div class="count">{{$totalNotYetApprovedUser}}</div>
                        <div class="terms">permohonan</div>
                    </div>
                    <div class="my-badge">!</div>
                    <div class="shadow-point"></div>
                    <div class="pointer"><i class="fal fa-chevron-right fa-lg"></i></div>
                </div>
            </a>
            </div>
            <div class="col-xl-4 col-sm-7 col-6">
            <a href="javascript:openPgInFrame('{{route('user.registered')}}')">
                <div class="round-point">
                    <div class="crc" style="background-image: url({{asset('my-assets/img/access-pass.jpg')}});background-size: cover;"></div>
                    <div class="txt">
                        <div class="section">Pengguna Berdaftar</div>
                        <div class="count">{{$totalRegisteredUser}}</div>
                        <div class="terms">pengguna</div>
                    </div>
                    <div class="shadow-point"></div>
                    <div class="pointer"><i class="fal fa-chevron-right fa-lg"></i></div>
                </div>
            </a>
            </div>
            <div class="col-xl-4 col-sm-12 col-12">
                <div class="round-point special">
                <a href="javascript:openPgInFrame('{{route('underconstruction')}}')">
                    <div class="crc" style="background-image: url({{asset('my-assets/img/audit-trail.jpg')}});background-size: cover;"></div>
                    <div class="txt">
                        <div class="section">Jejak<br/>Pengguna</div>
                        <div class="count"><i class="fal fa-search fa-sm" style="filter: brightness(1) invert(1);"></i></div>
                    </div>
                    <div class="shadow-point"></div>
                </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
    })
</script>
</body>
</html>
