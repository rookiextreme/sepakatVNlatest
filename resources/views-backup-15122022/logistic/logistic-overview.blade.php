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
    body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
    }
    .container {
        margin-top:20%;
        width:550px;
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

        width:280px;
        height:295px;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);*/
        /*background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
        margin-left:auto;
        margin-right:auto;
        padding-left:10px;
        padding-right:12px;

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
    .sch-point {
        position: relative;
        height:240px;
        width:100%;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
        margin-left:auto;
        margin-right:auto;
        padding:20px;

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
        left:0px;
        width: 100%;
        font-family: lato-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
    }
    .pointer-left {
        position:absolute;
        left:10px;
        width:20px;
        top:110px;
    }
    .pointer-right {
        position:absolute;
        right:10px;
        width:20px;
        top:110px;
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
    .sch-point .shadow-point-1 {
        position: absolute;
        left:0px;
        margin-left:auto;
        margin-right:auto;
        top:270px;
        width: 100%;
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

        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
    }
    .txt {
        width:100%;
        color:#252525;
        padding:5px;
        height:100px;
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
    .count {
        font-size:16px;
        font-family:avenir;
        line-height: 20px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
    }
    .terms {
        font-size:14px;
        font-family:avenir;
        line-height: 16px;
        color:#212121;
        margin-top:10px;
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
    .volvo-last {
        display: none;
    }
    .driver-back {
        width:100%;
        background-image: url(../../../public/my-assets/img/driver-min.png);
        background-repeat: no-repeat;
        background-position: center bottom;
        background-size: 100% auto;
    }
    .signage-back {
        position:absolute;
        bottom:0px;
        left:14%;
        right:auto;
        height:140px;
        width:135px;
        background-image: url(../../../public/my-assets/img/siap-siaga-min.png);
        background-repeat: no-repeat;
        background-position: center bottom;
        background-size: 100px 136px;
        text-align: center;
        padding-top:22px;
    }
    .signage-back span {
        font-family: helve-bold;
        color:#000000;
        font-size:34px;
        cursor:pointer
    }
    .signage-back span:hover {
        color:red;
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
    .dark-cloud {
        background-repeat: no-repeat;
        background-position: center bottom;
        background-size: 100% auto;
    }
    .txt-box {
        cursor:pointer;
        text-align: center;
        padding:10px;
        line-height:20px;
        width:100%;
        cursor: pointer;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }
    .txt-box:hover {
        background: #d4dee5;
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
            margin-top:10px;
            width:100%;
        }
        .sch-point {
            height:90px;
            width:100%;
            margin-bottom:20px;
            margin-top:50px;
        }
        .volvo-last {
            display: block;
            padding:0px;
            height: 88px;px;
            overflow: hidden;
        }
        .volvo-first {
            display: none;
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
	}
</style>
<script>
    function showCondition(){
        $('#syaratTempahan').modal('show');
    }

    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
<div class="main-content">
    <div class="container">
        <div class="row" style="position: relative;">
            <div class="spectitle">Logistik</div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                <div class="sch-point driver-back" style="background-image: url({{asset('my-assets/img/driver-min.png')}});">
                    <div class="section">Tempahan<br/>Kenderaan</div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-6 line-r" onClick="javascript:showCondition();">
                            <div class="txt-box">
                                <i class="fal fa-plus fa-sm" style="filter: brightness(1) invert(1);font-size:30px;font-family:avenir"></i>
                                <div class="terms">Mohon</div>
                            </div>
                        </div>
                        <div class="col-6" onClick="openPgInFrame('{{ route('logistic.booking.list') }}')">
                            <div class="txt-box">
                                <i class="fal fa-list fa-sm" style="filter: brightness(1) invert(1);font-size:30px;"></i>
                                <div class="terms">Senarai</div>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-point-1"></div>

                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-12" style="position: relative">
                <div class="pointer-left"><i class="fal fa-chevron-left fa-lg"></i></div>
                <div class="pointer-right"><i class="fal fa-chevron-right fa-lg"></i></div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                <div class="sch-point" style="background-image: url({{asset('my-assets/img/dark-cloud.png')}});">
                    <div class="section">Siap Siaga<br/>Bencana</div>
                    <div class="signage-back" style="background-image: url({{asset('my-assets/img/siap-siaga-min.png')}});"><span onClick="openPgInFrame('{{ route('logistic.disasterready.vehicle.list', ['fleet_view' => 'department']) }}')">{{$general_record_count_view->total_vehicle_disaster_ready ? $general_record_count_view->total_vehicle_disaster_ready : 0 }}</span>
                        <div class="sedia">Sedia</div>
                    </div>
                    <div class="shadow-point-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="syaratTempahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="syaratTempahanLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <h3 class="text-center" style="color: black">PERMOHONAN MENGGUNAKAN KENDERAAN JABATAN</h3>
            <hr>
                <h5 class="text-align:left" style="color: black">SYARAT-SYARAT <span>:</span></h5>
                    <ol>
                        <li>Permohonan mesti diserahkan kepada Pegawai Kenderaan <span style="color: black"> selewat-lewatnya 3 hari  sebelum </span> tarikh  penggunaan bagi perjalanan  keluar daerah dan
                            <span style="color: black"> 1 hari sebelum </span> penggunaan bagi perjalanan / urusan tempatan. </li>
                        <li>Borang ini hendaklah diisi dengan <span style="color: black"> LENGKAP dan JELAS </span>. Semua perjalanan adalah atas urusan rasmi kerajaan sahaja.</li>
                        <li>Pemohon <span style="color: black"> PERLU melampirkan surat / memo arahan tugas / jemputan mesyuarat / kursus / aktiviti </span> daripada pihak berkaitan.</li>
                        <li>Borang permohonan yang tidak lengkap tidak akan diproses dan kelulusan tertakluk kepada keutamaan tugas dan kekosongan kenderaan.</li>
                    </ol>
        </div>
        <div class="modal-footer">
            <button type="button" class="cux-btn bigger" onclick="openPgInFrame('{{route('logistic.booking.register')}}')">Setuju</button>
            <button type="button" class="btn btn-secondary btn-danger" data-bs-dismiss="modal">Batal</button>
        </div>
    </div>
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style='border-radius: 10px; margin-top: 50%; border: 2px solid #6c757d96; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>

        <div class="modal-body">
            <form action="{{route('vehicle.list-alternate')}}">
                <input autocomplete="off" style='width: 100%;  text-align: center;  border: none; font-family: avenir; padding:10px; outline: none;' placeholder='search keyword' name="searchParam" value="">
            </form>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        initTab();
        $('#searchParam').removeAttr('autocomplete');
    })
</script>
</body>
</html>
