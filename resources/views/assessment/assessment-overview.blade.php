@php
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentGovLoan;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentSafety;
use App\Models\Assessment\AssessmentAccident;
    $totalPenilaianBaru = 0;
    $totalPenilaianKeselamatan = 0;
    $totalPenilaianNilaiSemasa = 0;
    $totalPenilaianKemalangan = 0;
    $totalPenilaianPinjaman = 0;
    $totalPenilaianPelupusan = 0;
    $roleCode = auth()->user()->detail->refRole->code;

    $workshopId = auth()->user()->detail->workshop_id ? auth()->user()->detail->workshop_id : -1;
    $roleCode = auth()->user()->detail->refRole->code;

    $AccessAssessmentNew = auth()->user()->vehicle('02', '01');
    $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');

    $AccessAssessmentSafety = auth()->user()->vehicle('02', '02');
    $TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '02');

    $AccessAssessmentCurrValue = auth()->user()->vehicle('02', '03');
    $TaskFlowAccessAssessmentCurrValue = auth()->user()->vehicleWorkFlow('02', '03');

    $AccessAssessmentAccident = auth()->user()->vehicle('02', '04');
    $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '04');

    $AccessAssessmentDisposal = auth()->user()->vehicle('02', '05');
    $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '05');

    $AccessAssessmentGovloan = auth()->user()->vehicle('02', '06');
    $TaskFlowAccessAssessmentGovloan = auth()->user()->vehicleWorkFlow('02', '06');

    $appStatus = '3,4,5,6';
    $assessment_mapRoleIdTo_AppStatusId = [
        '01' => '3,4,5,6',
        '02' => '-1',
        '03' => '3,4,5,6',
        '04' => '3,4,5,6',
        '07' => '4',
        '05' => '-1',
        '14' => '3,4,5,6',
        '15' => '3,4,5,6',

    ];

    if(
        in_array($roleCode, array('01','02','03','04','07','13','14','15')) ||
        $AccessAssessmentNew->mod_fleet_r ||
        $AccessAssessmentAccident->mod_fleet_r ||
        $AccessAssessmentSafety->mod_fleet_r ||
        $AccessAssessmentCurrValue->mod_fleet_r ||
        $AccessAssessmentGovloan->mod_fleet_r ||
        $AccessAssessmentDisposal->mod_fleet_r
    ){

    Log::info("-----------------");
    Log::info("roleCode : ".$roleCode);
    Log::info("workshopId : ".$workshopId);
    if(isset($assessment_mapRoleIdTo_AppStatusId[$roleCode])){
        Log::info("mapRoleIdTo_StatusId : ".$assessment_mapRoleIdTo_AppStatusId[$roleCode]);
        $appStatus = $assessment_mapRoleIdTo_AppStatusId[$roleCode];
    }
    
    Log::info("-----------------\n\n\n\n\n");

    $queryByWorkshop = 'an.workshop_id = '.$workshopId;
    $queryByAppStatus = '';

    if($roleCode == '01'){
        $queryByWorkshop = '';
        $queryByAppStatus = 'WHERE an.app_status_id NOT IN (1,2,7,9) OR (an.app_status_id IN (2) AND an.created_by = '.auth()->user()->id.')';
    } else {
        $queryByWorkshop = ' WHERE an.workshop_id ='.$workshopId;
        $queryByAppStatus = 'AND an.app_status_id IN ('.$appStatus.') OR (an.app_status_id IN (2) AND an.created_by = '.auth()->user()->id.')';
    }

    if($roleCode == '05'){
        $queryByAppStatus = 'AND an.created_by = '.auth()->user()->id;
    }

    $totalPenilaianBaru = DB::select(DB::raw('
        SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_new an
        '.$queryByWorkshop.'
        '.$queryByAppStatus.'
        '))[0]->total;

    $totalPenilaianKeselamatan =  $query = DB::select(DB::raw('
        SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_safety an
        '.$queryByWorkshop.'
        '.$queryByAppStatus.'
        '))[0]->total;

    $totalPenilaianNilaiSemasa =  $query = DB::select(DB::raw('
        SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_currvalue an
        '.$queryByWorkshop.'
        '.$queryByAppStatus.'
        '))[0]->total;

    $totalPenilaianKemalangan =  $query = DB::select(DB::raw('
        SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_accident an
        '.$queryByWorkshop.'
        '.$queryByAppStatus.'
        '))[0]->total;

    $totalPenilaianPinjaman =  $query = DB::select(DB::raw('
        SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_gov_loan an
        '.$queryByWorkshop.'
        '.$queryByAppStatus.'
        '))[0]->total;

    $totalPenilaianPelupusan =  $query = DB::select(DB::raw('
        SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_disposal an
        '.$queryByWorkshop.'
        '.$queryByAppStatus.'
        '))[0]->total;
    }

    if($roleCode == '07'){
        Log::info('ada log');
        Log::info($queryByWorkshop);
        Log::info($queryByAppStatus);
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
    .assess-new {
        background-image: url('my-assets/img/assess-new.png');
        background-repeat: no-repeat;
        background-position: right bottom;
    }
    .assess-loan {
        background-image: url('my-assets/img/assess-loan.png');
        background-repeat: no-repeat;
        background-position: right bottom;
        background-size: auto 100px;
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
        height:295px;
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
    .txt-big .section, .txt-analysis .section {
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
        /* cursor: pointer; */
        text-align: right;
        line-height: 10px;
    }
    /* .txt-calendar:hover {
        background: rgba(255,255,255,0.8);
    } */
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
        height:135px;
        padding-top:20px;
        padding-left:15px;
        padding-right:15px;
        width:140px;
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
            margin-top:80px;
            height:443px;
            width:100%;
            max-width:290px;
            padding-left:12px;
            padding-right:10px;
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
                <div class="sch-point">
                    <div class="spectitle">Penilaian</div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 p-0 line-r assess-new" style="background-image: url({{asset('my-assets/img/assess-new.png')}});">
                            <div class="txt-big">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('assessment.new.list')}}')">
                                <div class="section">Kenderaan<br/>Baharu</div>
                                <div class="count">{{$totalPenilaianBaru}}</div>
                                <div class="terms">penilaian</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 p-0 line-r">
                            <div class="txt-big">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('assessment.currvalue.list')}}')">
                                <div class="section">Nilai<br/>Semasa</div>
                                <div class="count">{{$totalPenilaianNilaiSemasa}}</div>
                                <div class="terms">penilaian</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 p-0 assess-stats" style="background-image: url({{asset('my-assets/img/assess-statistics.png')}});">
                            <div class="txt-big">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('assessment.safety.list')}}')">
                                <div class="section">Keselamatan<br/>& Prestasi</div>
                                <div class="count">{{$totalPenilaianKeselamatan}}</div>
                                <div class="terms">penilaian</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 p-0 line-r line-t">
                            <div class="txt-big">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('assessment.accident.list')}}')">
                                <div class="section">Disebabkan<br/>Kemalangan</div>
                                <div class="count">{{$totalPenilaianKemalangan}}</div>
                                <div class="terms">penilaian</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 p-0 line-r line-t assess-loan" style="background-image: url({{asset('my-assets/img/assess-loan.png')}});">
                            <div class="txt-big">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('assessment.gov_loan.list')}}')">
                                <div class="section">Pinjaman<br/>Kerajaan</div>
                                <div class="count">{{$totalPenilaianPinjaman}}</div>
                                <div class="terms">penilaian</div>
                            </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-6 p-0 line-t">
                            <div class="txt-big">
                            <a style="text-decoration:none;" href="javascript:openPgInFrame('{{route('assessment.disposal.list')}}')">
                                <div class="section">Tujuan<br/>Pelupusan</div>
                                <div class="count">{{$totalPenilaianPelupusan}}</div>
                                <div class="terms">penilaian</div>
                            </a>
                            </div>
                        </div>
                    </div>
                    <div class="shadow-point"></div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-4 col-12">
                <div class="sml-point float-end">
                    <div class="pointer"><i class="fal fa-chevron-right fa-lg"></i></div>
                    <div class="shadow-point"></div>
                    <div class="row">
                        {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6 p-0 assess-calendar"  style="background-image: url({{asset('my-assets/img/assess-calendar.png')}});">
                            <div class="txt-calendar" onclick="openPgInFrame('{{ route('assessment.calendar') }}')">
                            <div class="txt-calendar">
                                <span class="txt-blc" style="border-radius: 4px 4px 0px 4px;-moz-border-radius: 4px 4px 0px 4px;-webkit-border-radius: 4px 4px 0px 4px;">Jadual</span>
                                <span class="txt-blc" style="border-radius: 4px 0px 4px 4px;-moz-border-radius: 4px 0px 4px 4px;-webkit-border-radius: 4px 0px 4px 4px;">Temujanji</span>
                            </div>
                        </div> --}}
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-6 p-0">
                            <div class="txt-analysis" onclick="openPgInFrame('{{ route('assessment.report') }}')">
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
