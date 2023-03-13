@php
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Saman\MaklumatKenderaanSaman;

$filter = 'created_by = '.auth()->user()->id;
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

$queryVehicle = FleetDepartment::whereHas('hasVehicleStatus', function($q){
    $q->whereIn('code', ['01','02','03']);
})->whereHas('vAppStatus', function($q){
    $q->whereIn('code', ['06']);
});
$querySummon = MaklumatKenderaanSaman::whereHas('hasStatus', function($q2){
        $q2->whereIn('code', ['02']);
});

if (in_array($roleAccessCode, array('01'))){

}

if (in_array($roleAccessCode, array('02'))){
}

if (in_array($roleAccessCode, array('03'))){
}

if (in_array($roleAccessCode, array('04'))){
    $queryVehicle->whereHas('createdBy', function($q){
        $q->where('id', auth()->user()->id);
    });

    $querySummon->whereHas('pendaftaran', function($q){
        $q->where('user_id', auth()->user()->id);
    });
}

if(auth()->user()->detail->hasBranch){

    $queryVehicle->where('cawangan_id', auth()->user()->detail->hasBranch->id);

    $querySummon->whereHas('pendaftaran', function($q){
        $q->where('cawangan_id', auth()->user()->detail->hasBranch->id);
    });
}


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
    .lori {
        background-image:url({{asset('my-assets/img/lori.png')}});
        background-repeat: no-repeat;
        background-position: left bottom;
        background-size: 55%;
    }
    .sch-point {
        position: relative;
        height:293px;
        width:140px;
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
    .sch-point .shadow-point-1 {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        top:330px;
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
    .count {
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
        line-height: 20px;
        color:#212121;
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
        <div class="row" style="position: relative;">
            <div class="spectitle">Pengurusan Rekod</div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="sch-point">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-4 pr-0 volvo-first">
                            <div class="crc" style="background-image: url({{asset('my-assets/img/fleet.jpg')}});background-size: cover;"></div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-4 box-nom">
                            <div class="txt">
                                <div class="txt-box" data-bs-toggle="modal" data-bs-target="#searchModal">
                                    <div class="section">Carian Kenderaan</div>
                                    <div class="count"><i class="fal fa-search fa-sm" style="filter: brightness(1) invert(1);"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-4 box-nom">
                            <div class="txt line-t">
                                <div class="txt-box">
                                    <a href="javascript:openPgInFrame('{{route('vehicle.register')}}')" style="text-decoration:none;">
                                    <div class="section">Tambah<Br/>Rekod</div>
                                    <div class="count"><i class="fal fa-plus fa-sm" style="filter: brightness(1) invert(1);"></i></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-4 pr-0 volvo-last">
                            <div class="crc" style="background-image: url({{asset('my-assets/img/fleet.jpg')}});background-size: cover;"></div>
                        </div>
                    </div>
                    <div class="shadow-point-1"></div>
                    <div class="pointer"><i class="fal fa-chevron-right fa-lg"></i></div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-12">
                <div class="round-point lori">
                    <div class="row" style="padding:0px;">
                        <div class="col-6 line-r p-0">
                            <div class="txt-big">
                                <a href="javascript:openPgInFrame('{{route('vehicle.list-alternate',[ 'offset' => 0 , 'limit'=> 5 ])}}')" style="text-decoration:none;">
                                <div class="section">Rekod<br/>Kenderaan</div>
                                <div class="count">{{$queryVehicle->count()}}</div>
                                <div class="terms">kenderaan</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 p-0">
                            <div class="txt-big">
                                <a href="javascript:openPgInFrame('{{route('vehicle.saman.rekod', ['status' => 'in_progress'])}}')" style="text-decoration:none;">
                                    <div class="section">Saman<br/>Tertunggak</div>
                                    <div class="count">{{$querySummon->count()}}</div>
                                    <div class="terms">saman</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-6 line-t"></div>
                        <div class="col-6 p-0 line-t">
                            <div class="txt-big">
                                <a href="javascript:openPgInFrame('{{ route('vehicle.report') }}')" style="text-decoration:none;">
                                    <div class="section" style="margin-top:10px">Laporan &amp;<br/>Analisa</div>
                                    <i class="fal fa-chart-line fa-2x mt-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-point"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style='border-radius: 10px; margin-top: 50%; border: 2px solid #6c757d96; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>

        <div class="modal-body">
            <form action="{{route('vehicle.list-alternate')}}">
                <input autocomplete="off" style='width: 100%;  text-align: center;  border: none; font-family: avenir; padding:10px; outline: none;' placeholder='search keyword' name="search" value="">
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
