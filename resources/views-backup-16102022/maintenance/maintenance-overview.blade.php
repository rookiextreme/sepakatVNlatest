@php
use App\Models\Maintenance\MaintenanceEvaluation;
use App\Models\Maintenance\MaintenanceJob;

$filter = 'created_by = '.auth()->user()->id;
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

$schema = 'maintenance';

$queryMaintenanceEvaluation = DB::table($schema.'.evaluation AS a')
    ->select(DB::raw("COUNT(*) as total"), 'b.code','b.desc')
    ->join($schema.'.application_status AS b', 'b.id', 'a.app_status_id');

$queryMaintenanceJob = DB::table($schema.'.job AS a')
    ->select(DB::raw("COUNT(*) as total"), 'b.code','b.desc')
    ->join($schema.'.application_status AS b', 'b.id', 'a.app_status_id');

if(auth()->user()->isAdmin()){
} elseif(auth()->user()->isEngineerMaintenance()){
    $queryMaintenanceEvaluation->whereRaw('a.workshop_id = '.auth()->user()->detail->workshop_id.' and (a.assign_engineer_by = '.auth()->user()->id.' or a.assign_engineer_by is null)');
} elseif(auth()->user()->isAssistEngineerMaintenance()){
    Log::info('saya isAssistEngineerMaintenance');
    Log::info('saya workshop '.auth()->user()->detail->workshop_id);
    Log::info('auth()->user()->id '.auth()->user()->id);
    $queryMaintenanceEvaluation->where(
        [
            'a.assistant_engineer_by' => auth()->user()->id,
            'a.workshop_id' => auth()->user()->detail->workshop_id
        ]
    );

} elseif(in_array(auth()->user()->roleAccess()->code, ['03'])){
    $queryMaintenanceEvaluation->where(
        [
            'a.workshop_id' => auth()->user()->detail->workshop_id
        ]
    );
} elseif(auth()->user()->isPublic()){
    $queryMaintenanceEvaluation->where('a.created_by', auth()->user()->id);
}

$queryMaintenanceEvaluation->whereNotIn('b.code', ['00', '01', '07', '08']);

if(auth()->user()->isSeniorEngineerMaintenance()){
    $queryMaintenanceEvaluation->whereIn('b.code', ['03']);
} elseif(auth()->user()->isForemenMaintenance()){
    $queryMaintenanceEvaluation->whereIn('b.code', ['03']);
}

$queryMaintenanceEvaluation->orWhereRaw('(b.code in (\'01\') and a.created_by = '.auth()->user()->id.' )');


// stop eval

// start job
if(auth()->user()->isAdmin()){
}
elseif(auth()->user()->isEngineerMaintenance()){
    $queryMaintenanceJob->whereRaw('a.workshop_id = '.auth()->user()->detail->workshop_id.' and (a.assign_engineer_by = '.auth()->user()->id.' or a.assign_engineer_by is null)');
} elseif(auth()->user()->isAssistEngineerMaintenance()){
    Log::info('saya isAssistEngineerMaintenance');
    Log::info('saya workshop '.auth()->user()->detail->workshop_id);
    Log::info('auth()->user()->id '.auth()->user()->id);
    $queryMaintenanceJob->where(
        [
            'a.assistant_engineer_by' => auth()->user()->id,
            'a.workshop_id' => auth()->user()->detail->workshop_id
        ]
    );

} elseif(in_array(auth()->user()->roleAccess()->code, ['03'])){
    $queryMaintenanceJob->where(
        [
            'a.workshop_id' => auth()->user()->detail->workshop_id
        ]
    );
} else {
    $queryMaintenanceJob->where('a.created_by', auth()->user()->id);
}

$queryMaintenanceJob->whereNotIn('b.code', ['00', '01', '07', '08']);

if(auth()->user()->isSeniorEngineerMaintenance()){
    $queryMaintenanceJob->whereIn('b.code', ['03']);
} elseif(auth()->user()->isForemenMaintenance()){
    $queryMaintenanceJob->whereIn('b.code', ['03']);
}

$queryMaintenanceJob->orWhereIn('b.code', ['01'])->where('a.created_by', auth()->user()->id);


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
        overflow-y:hidden;
    }
    .container {
        margin-top:15%;
        max-width:750px;
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
    .pemeriksaan {
        background-image: url('my-assets/img/pemeriksaan-min.png');
        background-repeat: no-repeat;
        background-position: right bottom;
        background-size: auto 115px;
    }
    .penyenggaraan {
        background-image: url('my-assets/img/penyenggaraan-min.png');
        background-repeat: no-repeat;
        background-position: left top;
        background-size: auto 120px;
    }
    .waran {
        background-image: url('my-assets/img/waran-min.png');
        background-repeat: no-repeat;
        background-position: 20px top;
        background-size: auto 110px;
    }
    .assess-stats {
        background-image: url('my-assets/img/assess-statistics.png');
        background-repeat: no-repeat;
        background-position: 68px 70px;
        background-size: 80px auto;
    }
    .assess-market {
        background-image: url('my-assets/img/assess-market.png');
        background-repeat: no-repeat;
        background-position: 1px bottom;
        background-size: auto 145px;
        border-radius: 0px 15px 0px 0px;
        -moz-border-radius: 0px 15px 0px 0px;
        -webkit-border-radius: 0px 15px 0px 0px;
    }
    .assess-calendar {
        background-image: url('my-assets/img/assess-calendar.png');
        background-repeat: no-repeat;
        background-position: left middle;
        background-size: cover;
        border-radius: 15px 15px 0px 0px;
        -moz-border-radius: 15px 15px 0px 0px;
        -webkit-border-radius: 15px 15px 0px 0px;
        width:151px;
        height:110px;
        border-bottom-style: solid;
        border-bottom-width:1px;
        border-bottom-color:#8ad0e2;
    }
    .sml-point {
        position: relative;
        margin-left:0px;
        height:auto;
        width:153px;
        max-width:200px;
        padding-left:12px;
        padding-right:10px;
                /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
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
        transition: all .2s ease-in-out;

        background-color: #ffffff;
    }
    .sch-point {
        position: relative;
        height:138px;
        width:100%;
        max-width:454px;
        padding-left:12px;
        padding-right:10px;
                /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
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
        transition: all .2s ease-in-out;

        background-color: #ffffff;
    }
    .sch-point.work {
        height:150px;
    }
    .sch-point.waran {
        height:125px;
    }
    .spectitle {
        position:absolute;
        top:-50px;
        left:0px;
        width: 300px;
        font-family: lato-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
    }
    .pointer {
        position:absolute;
        left:-45px;
        width:40px;
        top:120px;
    }
    .sml-point .shadow-point, .sch-point .shadow-point {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        left:-5px;
        top:330px;
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
    .txt-big .section, .txt-big-wide .section, .txt-analysis .section {
        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
    }
    .txt-big.pemeriksaan .section {
        margin-top:3px;
        margin-bottom:0px;
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
    .box {
        cursor: pointer;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        padding-bottom:10px;
    }
    .box:hover {
        background: #cfd0cd;
    }
    .txt-calendar {
        color:#ffffff;
        margin:5px;
        height:100px;
        padding-top:55px;
        padding-left:15px;
        padding-right:15px;
        width:140px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        cursor: pointer;
        text-align: right;
        line-height: 10px;
    }
    .txt-calendar:hover {
        background: rgba(255,255,255,0.8);
    }
    .txt-calendar .txt-blc {
        margin-top:50px;
        color:#ffffff;
        background-color: #212121;
        padding-right:3px;
        padding-left:3px;
        display: inline;
        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
        box-decoration-break:clone;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
    }
    .txt-analysis {
        color:#252525;
        margin:5px;
        height:170px;
        margin-top:6px;
        padding-top:20px;
        padding-left:15px;
        padding-right:15px;
        width:140px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        cursor: pointer;
    }
    .txt-analysis:hover {
        background: rgba(207,208,205,0.8);
    }
    .txt-big {
        color:#252525;
        margin:5px;
        height:138px;
        padding-top:20px;
        padding-left:15px;
        padding-right:15px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        cursor: pointer;
    }
    .txt-big.pemeriksaan {
        width:179px;
    }
    .txt-big.penyenggaraan {
        width:252px;
        text-align: right;
        padding-top:24px;
    }
    .txt-big:hover {
        background: rgba(207,208,205,0.8);
    }
    .txt-big.waran {
        margin-left:142px;
        width:305px;
        height:112px;
    }
    .sch-point .row {
        margin-left:-13px;
        margin-right:-13px;
    }
    .line-r {
        border-right-style: solid;
        border-right-color:#c8c8cc;
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
        margin-bottom:5px;
    }
    .count-sm {
        font-size:24px;
        font-family:helve-bold;
        line-height: 24px;
        color:#212121;
        margin-top:15px;
        margin-bottom:0px;
    }
    .terms {
        font-size:16px;
        font-family:avenir;
        line-height: 18px;
        color:#8a8a8a;
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
            margin-top:80px;
            height:443px;
            width:100%;
            max-width:290px;
            padding-left:12px;
            padding-right:10px;
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
        .txt-big {
            color:#252525;
            margin:5px;
            height:135px;
            padding-top:20px;
            padding-left:10px;
            width:100%;
            cursor: pointer;
        }
        .txt-big .section {
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
<body>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-8 col-12">
                <div class="sch-point work">
                    <div class="spectitle">Penyenggaraan</div>
                    <div class="row">
                        <div class="col-xl-5 col-lg-5 col-md-4 col-sm-4 col-4 p-0 line-r pemeriksaan" style="background-image: url({{asset('my-assets/img/pemeriksaan-min.png')}});">
                            <div class="txt-big pemeriksaan">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' => 'all_inprogress'])}}')">
                                <div class="section">Pemeriksaan<br/>Kerosakan</div>
                                <div class="count">{{$queryMaintenanceEvaluation->count()}}</div>
                                <div class="terms">tugasan</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-8 col-sm-8 col-8 p-0 penyenggaraan" style="background-image: url({{asset('my-assets/img/penyenggaraan-min.png')}});">
                            <div class="txt-big penyenggaraan">
                                <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('maintenance.job.list', ['status_code' => 'all_inprogress'])}}')">
                                    <div class="section">Servis &<br/>Pembaikan</div>
                                    <div class="count">{{$queryMaintenanceJob->count()}}</div>
                                    <div class="terms">tugasan</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-point"></div>
                </div>
                <div class="sch-point waran" style="background-image: url({{asset('my-assets/img/waran-min.png')}});">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                            <div class="txt-big waran">
                                <div class="row" onclick="openPgInFrame('{{route('maintenance.warrant.table')}}');">
                                    <div class="section">Pengurusan Waran</div>
                                    <div class="col-6">
                                        <div class="count" style="line-height: 24px">423,300</div>
                                        <div class="terms mt-0">berbaki</div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <div class="count-sm">95%</div>
                                        <div class="terms mt-0">digunakan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <div class="sml-point float-end">
                    <div class="pointer"><i class="fal fa-chevron-right fa-lg"></i></div>
                    <div class="shadow-point"></div>
                    <div class="row">
                        {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6 p-0 assess-calendar"  style="background-image: url({{asset('my-assets/img/assess-calendar.png')}});">
                            <div class="txt-calendar" onclick="openPgInFrame('{{route('assessment.evaluation_record')}}')">
                                <span class="txt-blc" style="border-radius: 4px 4px 0px 4px;-moz-border-radius: 4px 4px 0px 4px;-webkit-border-radius: 4px 4px 0px 4px;">Jadual</span>
                                <span class="txt-blc" style="border-radius: 4px 0px 4px 4px;-moz-border-radius: 4px 0px 4px 4px;-webkit-border-radius: 4px 0px 4px 4px;">Temujanji</span>
                            </div>
                        </div> --}}
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6 p-0" onclick="parent.openPgInFrame('{{route('maintenance.report')}}')">
                            <div class="txt-analysis">
                                <div class="section">Laporan &amp;<br/>Analisa</div>
                                <i class="fal fa-chart-line fa-2x mt-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
