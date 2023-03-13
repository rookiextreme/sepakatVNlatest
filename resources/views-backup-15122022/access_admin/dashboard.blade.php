@php

$totalNotYetApprovedUser = DB::table('users.details')
                        ->join('ref_status AS a', 'a.id', '=', 'ref_status_id')
                        ->where('a.code','03')->count();
$totalRegisteredUser = DB::table('users.details')
                        ->join('ref_status AS a', 'a.id', '=', 'ref_status_id')
                        ->where('a.code','06')->count();

@endphp


@php

    $totalPenilaianBaru = 0;
    $totalPenilaianKeselamatan = 0;
    $totalPenilaianNilaiSemasa = 0;
    $totalPenilaianKemalangan = 0;
    $totalPenilaianPinjaman = 0;
    $totalPenilaianPelupusan = 0;

    $totalSenggaraanPemeriksaan = 0;
    $totalSenggaraanServis = 0;

    $workshopId = auth()->user()->detail->workshop_id;
    $roleCode = auth()->user()->detail->refRole->code;

    $assessment_mapRoleIdTo_AppStatusId = [
        '01' => '1,2,3,4,5',
        '02' => '-1',
        '03' => '6',
        '04' => '3,5',
        '07' => '4'
    ];

    // if(isset($assessment_mapRoleIdTo_AppStatusId[$roleCode])){
    if(in_array($roleCode, array('01','02','03','04','07'))){

        Log::info("-----------------");
        Log::info("roleCode : ".$roleCode);
        Log::info("workshopId : ".$workshopId);
        Log::info("mapRoleIdTo_StatusId : ".$assessment_mapRoleIdTo_AppStatusId[$roleCode]);
        Log::info("-----------------\n\n\n\n\n");

        $totalPenilaianBaru = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_new an
            WHERE an.workshop_id = ?
            AND an.app_status_id IN ('.$assessment_mapRoleIdTo_AppStatusId[$roleCode].')
            '),[$workshopId])[0]->total;


        Log::info("totalPenilaianBaru : ".$totalPenilaianBaru);

        $totalPenilaianKeselamatan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_safety an
            WHERE an.workshop_id = ?
            AND an.app_status_id IN ('.$assessment_mapRoleIdTo_AppStatusId[$roleCode].')
            '),[$workshopId])[0]->total;

        $totalPenilaianNilaiSemasa =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_currvalue an
            WHERE an.workshop_id = ?
            AND an.app_status_id IN ('.$assessment_mapRoleIdTo_AppStatusId[$roleCode].')
            '),[$workshopId])[0]->total;

        $totalPenilaianKemalangan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_accident an
            WHERE an.workshop_id = ?
            AND an.app_status_id IN ('.$assessment_mapRoleIdTo_AppStatusId[$roleCode].')
            '),[$workshopId])[0]->total;

        $totalPenilaianPinjaman =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_gov_loan an
            WHERE an.workshop_id = ?
            AND an.app_status_id IN ('.$assessment_mapRoleIdTo_AppStatusId[$roleCode].')
            '),[$workshopId])[0]->total;

        $totalPenilaianPelupusan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_disposal an
            WHERE an.workshop_id = ?
            AND an.app_status_id IN ('.$assessment_mapRoleIdTo_AppStatusId[$roleCode].')
            '),[$workshopId])[0]->total;
    }

    if(in_array($roleCode, array('01','02','03','04','08','09'))){

        $maintenance_mapRoleIdTo_AppStatusId = [
            '01' => '2,3,4,5',
            '02' => '-1',
            '03' => '2,3,4,5',
            '04' => '2,3,4',
            '08' => '4',
            '09' => '5'
        ];

        //if(isset($maintenance_mapRoleIdTo_AppStatusId[$roleCode])){

        Log::info("\n\n\n\n\n-----------------");
        Log::info("roleCode : ".$roleCode);
        Log::info("workshopId : ".$workshopId);
        Log::info("mapRoleIdTo_StatusId : ".$maintenance_mapRoleIdTo_AppStatusId[$roleCode]);
        Log::info("-----------------\n\n\n\n\n");

        $queryWorkshop = '';

        if($workshopId){
            $queryWorkshop = ' AND an.workshop_id = '.$workshopId;
        }

        $totalSenggaraanPemeriksaan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM maintenance.evaluation an
            WHERE an.app_status_id IN ('.$maintenance_mapRoleIdTo_AppStatusId[$roleCode].')
            '.$queryWorkshop.'
            '))[0]->total;

        $totalSenggaraanServis = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM maintenance.job an
            WHERE an.app_status_id IN ('.$maintenance_mapRoleIdTo_AppStatusId[$roleCode].')
            '.$queryWorkshop.'
            '))[0]->total;

    }

    $totalJohor = 0;
    $totalKedah = 0;
    $totalKelantan = 0;
    $totalMelaka = 0;
    $totalNegeriSembilan = 0;
    $totalPahang = 0;
    $totalPerak = 0;
    $totalPerlis = 0;
    $totalPulauPinang = 0;
    $totalSabah = 0;
    $totalSelangor = 0;
    $totalTerengganu = 0;
    $totalKualaLumpur = 0;
    $totalLabuan = 0;
    $totalPutrajaya = 0;

    use App\Models\Fleet\FleetTotalRecordByState;

    $stateListCount = FleetTotalRecordByState::all();
    foreach ($stateListCount as $state) {
        switch ($state->code) {
            case '01':
            $totalJohor = $state->total();
            break;
            case '02':
            $totalKedah = $state->total();
            break;
            case '03':
            $totalKelantan = $state->total();
            break;
            case '04':
            $totalMelaka = $state->total();
            break;
            case '05':
            $totalNegeriSembilan = $state->total();
            break;
            case '06':
            $totalPahang = $state->total();
            break;
            case '07':
            $totalPerak = $state->total();
            break;
            case '08':
            $totalPerlis = $state->total();
            break;
            case '09':
            $totalPulauPinang = $state->total();
            break;
            case '10':
            $totalSabah = $state->total();
            break;
            // case '11':
            // $totalSelangor = $state->total();
            // break;
            case '12':
            $totalSelangor = $state->total();
            break;
            case '13':
            $totalTerengganu = $state->total();
            break;
            case '14':
            $totalKualaLumpur = $state->total();
            break;
            case '15':
            $totalLabuan = $state->total();
            break;
            case '16':
            $totalPutrajaya = $state->total();
            break;
        }
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
    .container-fluid {
        margin-top:30px;
        max-width:1200px;
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

        font-family: lato-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:10px;
        color:#212121;
    }
    .spectitle span {
        font-family: lato;
        font-size:18px;
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
    .ind-baharu {
        display: inline-block;
        width:47%;
        min-height:60px;
        text-align: right;
    }
    .ind-baharu .title {
        font-size:14px;
        line-height: 14px;
        color:#252525;
    }
    .txt-big {
        color:#252525;
        padding-top:20px;
        margin-bottom:0px;
        width:50%;
        display: inline-block;
        cursor: pointer;
    }
    .txt-big:hover, .txt-big:hover .count-big {
        color:orange;
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
        margin-top:1px;
        margin-bottom:0px;
        letter-spacing: 0px;
    }
    .count:hover {
        color:orange;
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
        width:100px;
        height:116px;
    }
    .tabung img {
        position:absolute;
        bottom:0px;
        z-index:2;
        width:74px;
    }
    .tabung-isi {
        position:absolute;
        left:6px;
        background: rgb(9,72,121);
        background: linear-gradient(90deg, rgba(9,72,121,1) 0%, rgba(106,220,251,1) 51%, rgba(9,72,121,1) 100%);
        width: 61px;
        height:30px;
        bottom:2px;
        z-index:1;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color:rgba(255,255,255,0.4);
        border-radius: 3px 3px 12px 12px;
        -moz-border-radius: 3px 3px 12px 12px;
        -webkit-border-radius: 3px 3px 12px 12px;
    }
    .tabung-kkr {
        position:absolute;
        left:6px;
        background: #ff512f; /* Old browsers */
        background: -moz-linear-gradient(left,  #ff512f 0%, #f09819 50%, #ff512f 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  #ff512f 0%,#f09819 50%,#ff512f 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  #ff512f 0%,#f09819 50%,#ff512f 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff512f', endColorstr='#ff512f',GradientType=1 ); /* IE6-9 */
        width: 61px;
        height:30px;
        bottom:2px;
        z-index:1;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color:rgba(255,255,255,0.4);
        border-radius: 3px 3px 12px 12px;
        -moz-border-radius: 3px 3px 12px 12px;
        -webkit-border-radius: 3px 3px 12px 12px;
    }
    .tabung-fund2 {
        position:absolute;
        left:6px;
        background: #ffd89b; /* Old browsers */
        background: -moz-linear-gradient(left,  #ffd89b 0%, #caaa79 50%, #ffd89b 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  #ffd89b 0%,#caaa79 50%,#ffd89b 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  #ffd89b 0%,#caaa79 50%,#ffd89b 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffd89b', endColorstr='#ffd89b',GradientType=1 ); /* IE6-9 */
        width: 61px;
        height:30px;
        bottom:2px;
        z-index:1;
        border-top-width: 1px;
        border-top-style: solid;
        border-top-color:rgba(255,255,255,0.4);
        border-radius: 3px 3px 12px 12px;
        -moz-border-radius: 3px 3px 12px 12px;
        -webkit-border-radius: 3px 3px 12px 12px;
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
        margin-top:2px;
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
    .shape-constant {
        position: absolute;
        bottom:0px;
        width: 70px;
        height: 20px;
        background-color: #40b293;
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
        font-family: helvetica-bold, arial, sans-serif;
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
        border-radius: 0px 0px 10px 10px;
        -moz-border-radius: 0px 0px 10px 10px;
        -webkit-border-radius: 0px 0px 10px 10px;
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
    /*.jadual-woksyop {
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
    }*/
    /*.total-alone {
        font-size:14px;
        font-family:helve-bold;
        padding-left:0px;
        padding-right:0px;
        width:40px;
        text-align: center;
    }*/
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
        bottom:0px;
        left:0px;
        width:100%;
        height:100%;
        padding-top:38px;
        right:auto;
        background-image: url(../../../public/my-assets/img/siap-siaga-min.png);
        background-repeat: no-repeat;
        background-position: center bottom;
        background-size: 100px 136px;
        font-family: helve-bold;
        color:#000000;
        font-size:30px;
        text-align: center;
    }
    .signage-back:hover {
        color:#305a45;
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
    .sect-siaga {
        position: absolute;
        width:100%;
        height:200px;
        left:0px;
        bottom:0px;
        padding-top:20px;
    }
    .sect-siaga .section {
        padding-left:20px;
    }
    .bg-selesai {
        background-color:#8aa050;
    }
    .close {
        background:transparent;
        border:none;
        margin-top:-7px;
        margin-right:-7px;
        cursor: pointer;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .close:hover {
        background-color:#ffffff;
    }
    .alert-spakat {
        background-color:#232220;
        color:#ffffff;
    }
    .alert-spakat a {
        font-family: mark-bold;
        cursor:pointer;
        text-decoration: none;
        color:#ffad00;
    }
    .alert-spakat a:hover {
        color:#8aa050;
    }

    a:link { text-decoration: none; }
    a:visited { text-decoration: none; }
    a:hover { text-decoration: none; }
    a:active { text-decoration: none; }
    #notify {
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
    .own-legend {
        padding-top:10px;
        width:100%;
        height:100%;
        padding-right:0px;
    }
    .lejen {
        position: relative;
        height:52px;
        font-size:12px;
        letter-spacing: 0px;
        font-family: mark;
        line-height: 14px;
        color:#212121;
        padding-top:10px;
        vertical-align: middle;
        text-align: right;
    }
    .chart-legend {
        font-size:12px;
        font-family: mark;
    }
    .sword {
        position: absolute;
        height:1px;
        width:400px;
        z-index: 5;
        bottom:0px;
        left:0px;
        background-color:#e6e6e6;
    }
    .penilaian-legend {
        text-align: right;
        padding-bottom:10px;
        margin-left:-20px;
        margin-right:-20px;
        padding-right:20px;
    }
    .stat-month {
        display: inline-block;
        margin-left:0px;
        text-align: left;
    }
    .legend-saman {
        position: relative;
        width:100%;
        height:50px;
        margin-top:-40px;
    }
    .legend-saman .stat-saman-tunggak {
        position: absolute;
        top:0px;
        left:35px;
        width:60px;
    }
    .legend-saman .stat-saman-tunggak .legend-top {
        font-family: mark;
        color: #2c473e;
        font-size:12px;
    }
    .legend-saman .stat-saman-selesai {
        position: absolute;
        top:0px;
        width:100%;
        border-left-color:#e5e3de;
        border-left-width: 1px;
        border-left-style: solid;
    }
    .legend-saman .stat-saman-selesai .legend-top {
        text-align: right;
        font-family: mark;
        color: #2c473e;
        font-size:10px;
        line-height:10px;
    }
    .stat-saman-tunggak {
        display: inline-block;
        font-family:mark;
        text-align: left;
        font-size:12px;
        width:80px;
    }
    .stat-saman-selesai {
        display: inline-block;
        font-family:mark;
        text-align: right;
        font-size:10px;
        width:50px;
    }
    .stat-penilaian {
        display: inline-block;
        font-family:mark;
        text-align: right;
        font-size:10px;
        width:80px;
    }
    .stat-penilaian .legend-top {
        text-align: right;
        font-family: mark;
        font-size:12px;
    }
    #box-logistics {
        min-height: 355px;
    }
    .state-box {
        border-left-style: solid;
        border-left-color:#e3e3eb;
        border-left-width:1px;
        padding-left:10px;
    }
    .state-box .state:hover {
        color: orange;
    }
    .slick-slide {
        width: 110px;
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

    #saman-belum-selesai {
        padding-right: 10px;
    }

    #saman-sudah-selesai {
        padding-right: 25px;
    }

    @media (max-width: 325px) and (min-width: 0px) {
        #saman-belum-selesai {
            padding-right: 15px;
        }
        #saman-sudah-selesai {
            padding-right: 30px;
        }
	}

    @media (max-width: 380px) and (min-width: 325px) {
        #saman-belum-selesai {
            padding-right: 25px;
        }
        #saman-sudah-selesai {
            padding-right: 35px;
        }
	}

    @media (max-width: 430px) and (min-width: 380px) {
        #saman-belum-selesai {
            padding-right: 34px;
        }
        #saman-sudah-selesai {
            padding-right: 43px;
        }
	}

    @media (max-width: 773px) and (min-width: 430px) {
        #saman-belum-selesai {
            padding-right: 3px;
        }
        #saman-sudah-selesai {
            padding-right: 20px;
        }
	}
</style>
<link rel="stylesheet" type="text/css" href="{{asset('my-assets/plugins/slick/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('my-assets/plugins/slick/slick-theme.css')}}">
<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
<!--<div class="info-box">
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
    </div>-->
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="spectitle">Dashboard <span>Keseluruhan</span></div>
            </div>


    {{-- $totalPenilaianBaru = 0;
    $totalPenilaianKeselamatan = 0;
    $totalPenilaianNilaiSemasa = 0;
    $totalPenilaianKemalangan = 0;
    $totalPenilaianPinjaman = 0;
    $totalPenilaianPelupusan = 0;


    $totalSenggaraanPemeriksaan = 0;
    $totalSenggaraanServis = 0; --}}
    @php
        $totalPenilaian = $totalPenilaianBaru + $totalPenilaianKeselamatan + $totalPenilaianNilaiSemasa + $totalPenilaianKemalangan + $totalPenilaianPinjaman + $totalPenilaianPelupusan;
        $totalSenggaraan = $totalSenggaraanPemeriksaan + $totalSenggaraanServis;
        $totalUserApproval = DB::table('users.details')
                        ->join('ref_status AS a', 'a.id', '=', 'ref_status_id')
                        ->where('a.code','03')->count();
//        $totalSenggaraan = 2;$totalPenilaian = 1;
    @endphp
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="notify">
                <div class="alert alert-dismissible fade show" role="alert" style='background-color: #49575c;color:#ffffff'>
                    @if ($totalPenilaian > 0 && $totalSenggaraan > 0 && $totalUserApproval > 0)
                        Anda mempunyai {{$totalPenilaian}} penilaian, {{$totalSenggaraan}} penyenggaraan dan {{$totalUserApproval}} kelulusan <a class="text-warning" style="text-decoration: none;" href="javascript:parent.openPgInFrame('{{route('access.user.approval')}}')">pengguna</a> untuk diambil tindakan.
                    @else
                        {{$totalPenilaian > 0 ? "Anda mempunyai ".$totalPenilaian." penilaian untuk diambil tindakan.":""}}
                        {{$totalSenggaraan > 0 ? "Anda mempunyai ".$totalSenggaraan." penyenggaraan untuk diambil tindakan.":""}}
                        @if($totalUserApproval > 0)
                        Anda mempunyai {{$totalUserApproval}} kelulusan <a class="text-warning" style="text-decoration: none;" href="javascript:parent.openPgInFrame('{{route('access.user.approval')}}')">pengguna</a> untuk diambil tindakan.
                        @endif
                    @endif


                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="$(this).alert('close')"><i class="fal fa-times" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12" style="position: relative;">
                <div class="info-box" id="box-record" style="position: relative">
                    <div class="row">
                        <div class="module">
                            <div class="module-info">Pengurusan</div>
                            Rekod
                        </div>
                        <div class="col-7">
                            <div class="txt-big thin-underline">
                                <div class="section">Jumlah</div>
                                <div class="count-big" onclick="openPgInFrame('{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 5, 'ownership' => 'jkr', 'fleet_view' =>  'department']) }}')">{{number_format($general_record_count_view->total_department_active)}}</div>
                                <div class="terms mb-5">kenderaan</div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="ind-baharu">
                                <div class="title">Persekutuan</div>
                                <div class="count cursor-pointer thin-underline pb-3" onClick="openPgInFrame('{{route('vehicle.list-alternate', ['offset' => 0, 'limit' => 5, 'owner_type_code' => '01'])}}')">{{number_format($general_record_count_view->total_vehicle_persekutuan)}}</div>
                                <div class="title mt-3">Negeri</div>
                                <div class="count cursor-pointer" onClick="openPgInFrame('{{route('vehicle.list-alternate', ['offset' => 0, 'limit' => 5, 'owner_type_code' => '02'])}}')">{{number_format($general_record_count_view->total_vehicle_negeri)}}</div>
                            </div>
                        </div>

                        <div class="section mt-4">Komposisi</div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                                <div class="col " id="chrtJobFamily" style="margin-left:auto;margin-right:auto;margin-top:0px;height:200px;padding-top:0px;padding-bottom:0px"></div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-0" style="position: relative;padding-top:0px;">
                            <table class="table mt-0">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td class="data">P</td>
                                        <td class="data">N</td>
                                    </tr>
                                    @foreach ($vehicleByCategoryList as $vehicleByCategory)
                                        <tr>
                                            <td>{{$vehicleByCategory->name}}</td>
                                            <td class="data">{{$vehicleByCategory->totalByFederal($vehicleByCategory->id)}}</td>
                                            <td class="data">{{$vehicleByCategory->totalByState($vehicleByCategory->id)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="info-box ps-1 pe-2">
                    <div class="module" style="margin-left:13px">
                        <div class="module-info ml-2">Status</div>
                        Saman
                        <div class="section mt-2">Jumlah Saman</div>
                        <a href="{{ route('report.report_summons_summary.branch')}}"><div class="form-label count-big">
                            {{$totalSummonUnpaid+$totalSummonPaid+$totalSummonTransfered+$totalSummonDiscounted}}
                        </div></a>
                    </div>
                    <figure class="highcharts-figure p-0" style="height:200px;">
                        <div id="chart-saman" style="height:180px;margin-left: 15px;margin-left: 15px;"></div>
                    </figure>
                    <div class="legend-saman">
                        {{-- <div class="stat-saman-tunggak">
                            <div class="legend-top">Tertunggak</div>
                            <div class="count" style="color:#f4a831">{{$totalSummonUnpaid+$totalSummonDiscounted}}</div>
                        </div> --}}
                        <div class="stat-saman-selesai">
                            {{-- <div style="display:inline-block;width:45%; padding-right: 18px;">
                                <div class="legend-top">Pindah Milik</div>
                                <div class="count-xs" style="color:#6b8665">{{$totalSummonTransfered}}</div>
                            </div> --}}
                            <div id="saman-belum-selesai" style="display:inline-block;width:45%;">
                                <div class="legend-top">Belum Selesai</div>
                                <div class="count-xs" style="color:#6b8665">{{$totalSummonUnpaid+$totalSummonDiscounted}}</div>
                            </div>
                            <div id="saman-sudah-selesai" style="display:inline-block;width:45%;">
                                <div class="legend-top">Selesai</div>
                                <div class="count-xs" style="color:#b0d182">{{$totalSummonPaid+$totalSummonTransfered}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="info-box dark-cloud d-none d-lg-block d-xl-none" style="background-image: url({{asset('my-assets/img/dark-cloud.png')}});">
                    <div class="module">
                        <div class="module-info ml-2">Pengurusan</div>
                        Logistik
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                            <div class="section mt-3">Tempahan Kenderaan</div>
                            <div class="row">
                                <div class="col-3 count">0</div>
                                <div class="col-9" style="position: relative;">
                                    <div class="shape-decline"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                            <div class="section mt-3">
                                Siap Siaga Bencana
                            </div>
                            <div style="position:relative;height:155px;width:100%;vertical-align:bottom">
                                <span class="btn section" onclick="openPgInFrame('{{ route('logistic.disasterready.vehicle.list') }}')">
                                    <div class="signage-back" style="background-image: url({{asset('my-assets/img/siap-siaga-min.png')}});">{{$general_record_count_view->total_vehicle_disaster_ready ? $general_record_count_view->total_vehicle_disaster_ready : 0 }}
                                        <div class="sedia">Sedia</div>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-6 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="info-box ps-4 pe-4">
                            <div class="slider autoplay">
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=johor')">
                                    <div class="state">Johor</div>
                                    <div class="count state">{{$totalJohor}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=kedah')">
                                    <div class="state">Kedah</div>
                                    <div class="count state">{{$totalKedah}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=kelantan')">
                                    <div class="state">Kelantan</div>
                                    <div class="count state">{{$totalKelantan}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=n9')">
                                    <div class="state">N. Sembilan</div>
                                    <div class="count state">{{$totalNegeriSembilan}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=melaka')">
                                    <div class="state">Melaka</div>
                                    <div class="count state">{{$totalMelaka}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=pahang')">
                                    <div class="state">Pahang</div>
                                    <div class="count state">{{$totalPahang}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=perak')">
                                    <div class="state">Perak</div>
                                    <div class="count state">{{$totalPerak}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=penang')">
                                    <div class="state">P.Pinang</div>
                                    <div class="count state">{{$totalPulauPinang}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=perlis')">
                                    <div class="state">Perlis</div>
                                    <div class="count state">{{$totalPerlis}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=terengganu')">
                                    <div class="state">Terengganu</div>
                                    <div class="count state">{{$totalTerengganu}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=sabah')">
                                    <div class="state">Sabah</div>
                                    <div class="count state">{{$totalSabah}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=labuan')">
                                    <div class="state">Labuan</div>
                                    <div class="count state">{{$totalLabuan}}</div>
                                </div>
                                <div class="state-box cursor-pointer" onclick="parent.openPgInFrame('{{ route('report.report_map_peninsular')}}?negeri=kl')">
                                    <div class="state">K. Lumpur</div>
                                    <div class="count state">{{$totalKualaLumpur}}</div>
                                </div>
                            </div>
                            <div class="btn-group position-absolute mt-1">
                                <button type="button" class="prev btn cux-btn small">Sebelum</button>
                                <button type="button" class="next btn cux-btn small">Selepas</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">

                        <div class="info-box dark-cloud" id="box-logistics" style="background-image: url({{asset('my-assets/img/dark-cloud.png')}});position:relative">
                            <div class="module">
                                <div class="module-info ml-2">Pengurusan</div>
                                Logistik
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12">
                                    <div class="section">Tempahan Kenderaan</div>
                                    <div class="row">
                                        <div onclick="openPgInFrame('{{ route('logistic.booking.list', ['status_code' => '06']) }}')" class="col-3 count mt-1 cursor-pointer">{{$general_record_count_view->total_logistic_booking ? $general_record_count_view->total_logistic_booking : 0 }}</div>
                                        <div class="col-9" style="position: relative;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="thin-underline">&nbsp;</div>
                            <div class="sect-siaga">
                                <div class="section">
                                    Siap Siaga Bencana
                                </div>
                                <div style="position: absolute;left:0px;bottom:0px;width:100%;height:155px">
                                    <span class="btn section" onclick="openPgInFrame('{{ route('report.report.disaster_ready.by_state_vtypes') }}')">
                                        <div class="signage-back" style="background-image: url({{asset('my-assets/img/siap-siaga-min.png')}});">{{$general_record_count_view->total_vehicle_disaster_ready ? $general_record_count_view->total_vehicle_disaster_ready : 0 }}
                                            <div class="sedia">Sedia</div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="info-box" id="box-maintenanance-warrants" style="padding-bottom:10px">
                            <div class="module mb-0">
                                <div class="module-info ml-2">Pengurusan</div>
                                Waran
                            </div>
                            @php

                                $warranDetails = DB::select('select a.month, b.code, c.code AS osos_code, sum(COALESCE(a.allocation,0)) AS allocation, sum(COALESCE(a.expense, 0)) As expense from maintenance.warrant_detail a
                                join maintenance.waran_type b on b.id = a.waran_type_id
                                left join maintenance.osol_type c on c.id = a.osol_type_id
                                WHERE a.year = '.date('Y').'
                                GROUP BY a.month, b.code, c.id');

                                $mhpvAllocation = 0;
                                $mhpvExpense = 0;
                                $mhpvPerc = 0;

                                $mhpvAllocation26000 = 0;
                                $mhpvExpense26000 = 0;
                                $mhpvPerc26000 = 0;

                                $mhpvAllocation28000 = 0;
                                $mhpvExpense28000 = 0;
                                $mhpvPerc28000 = 0;

                                $kkrAllocation = 0;
                                $kkrExpense = 0;
                                $kkrPerc = 0;

                                $extAgencyAllocation = 0;
                                $extAgencyExpense = 0;
                                $extAgencyPerc = 0;

                                if($warranDetails){
                                    foreach ($warranDetails as $index => $warranDetail) {
                                        switch ($warranDetail->code) {
                                            case '01':
                                                if($warranDetail->month == 12){
                                                    $mhpvAllocation += $warranDetail->allocation;
                                                    switch ($warranDetail->osos_code) {
                                                        case '01':
                                                            $mhpvAllocation26000 += $warranDetail->allocation;
                                                            break;
                                                        case '02':
                                                            $mhpvAllocation28000 += $warranDetail->allocation;
                                                            break;
                                                    }
                                                }

                                                $mhpvExpense += $warranDetail->expense;
                                                switch ($warranDetail->osos_code) {
                                                    case '01':
                                                        $mhpvExpense26000 += $warranDetail->expense;
                                                        break;
                                                    case '02':
                                                        $mhpvExpense28000 += $warranDetail->expense;
                                                        break;
                                                }
                                                break;
                                            case '02':
                                                if($warranDetail->month == 12){
                                                    $kkrAllocation += $warranDetail->allocation;
                                                }
                                                $kkrExpense += $warranDetail->expense;
                                                break;
                                            case '03':
                                                if($warranDetail->month == 12){
                                                    $extAgencyAllocation += $warranDetail->allocation;
                                                }
                                                $extAgencyExpense += $warranDetail->expense;
                                                break;
                                        }
                                    }
                                }

                                Log::info('dashboard_admin');
                                Log::info($mhpvAllocation);
                                Log::info($mhpvExpense);

                                Log::info($mhpvAllocation26000);
                                Log::info($mhpvExpense26000);

                                Log::info($mhpvAllocation28000);
                                Log::info($mhpvExpense28000);

                                $mhpvPerc = $mhpvExpense < $mhpvAllocation && $mhpvAllocation > 0 ? round(($mhpvExpense/$mhpvAllocation) * 100, 2) : 0;

                                $mhpvPerc26000 = $mhpvExpense26000 < $mhpvAllocation26000 && $mhpvAllocation26000 > 0 ? round(($mhpvExpense26000/$mhpvAllocation26000) * 100, 2) : 0;
                                $mhpvPerc28000 = $mhpvExpense28000 < $mhpvAllocation28000 && $mhpvAllocation28000 > 0 ? round(($mhpvExpense28000/$mhpvAllocation28000) * 100, 2) : 0;

                                $kkrPerc = $kkrExpense < $kkrAllocation && $kkrAllocation > 0 ? round(($kkrExpense/$kkrAllocation) * 100, 2) : 0;
                                $extAgencyPerc = $extAgencyExpense < $extAgencyAllocation && $extAgencyAllocation > 0 ? round(($extAgencyExpense/$extAgencyAllocation) * 100, 2) : 0;

                            @endphp
                            <div class="row shade-floor p-0">
                                <div class="row">
                                    <div class="col-md-6 cursor-pointer" onclick="parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 1, 'mphv' => '26000'])}}')">
                                        <div class="section mt-3">
                                            MHPV 26000
                                        </div>
                                        <div style="position: relative;">
                                            <div class="tabung">
                                                <img src="{{asset('my-assets/img/tabung.png')}}">
                                                <div class="tabung-isi" style="height:{{$mhpvPerc26000}}%"></div>
                                            </div>
                                        </div>
                                        <div style="position: relative;">
                                            <div >
                                                <div class="count">{{$mhpvPerc26000}}<small>%</small></div>
                                                @if($mhpvExpense26000>0)
                                                <div class="terms">telah dibelanjakan</div>
                                                <div class="terms">{{number_format($mhpvExpense26000, 0)}} / {{number_format($mhpvAllocation26000, 0)}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 cursor-pointer" style="padding-bottom:20px" onclick="parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 1, 'mphv' => '28000'])}}')">
                                        <div class="section mt-3">
                                            MHPV 28000
                                        </div>
                                        <div style="position: relative;">
                                            <div class="tabung">
                                                <img src="{{asset('my-assets/img/tabung.png')}}">
                                                <div class="tabung-isi" style="height:{{$mhpvPerc28000}}%"></div>
                                            </div>
                                        </div>
                                        <div style="position: relative;">
                                            <div>
                                                <div class="count">{{$mhpvPerc28000}}<small>%</small></div>
                                                @if($mhpvExpense28000>0)
                                                <div class="terms">telah dibelanjakan</div>
                                                <div class="terms">{{number_format($mhpvExpense28000, 0)}} / {{number_format($mhpvAllocation28000, 0)}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row cursor-pointer" onclick="parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 2])}}')">
                                    <div class="section mt-3">
                                        KKR
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-4" style="position: relative;">
                                        <div class="tabung">
                                            <img src="{{asset('my-assets/img/tabung.png')}}">
                                            <div class="tabung-kkr" style="height:{{$kkrPerc}}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-8" style="position: relative;">
                                        <div style="position: absolute; bottom:20px;left:0px;">
                                            <div class="count">{{$kkrPerc}}<small>%</small></div>
                                            @if($kkrExpense>0)
                                                <div class="terms">telah dibelanjakan</div>
                                                <div class="terms">{{number_format($kkrExpense, 0)}}/{{number_format($kkrAllocation, 0)}}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row cursor-pointer" onclick="parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 3])}}')">
                                    <div class="section mt-3">
                                        Agensi Luar
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-4" style="position: relative;">
                                        <div class="tabung">
                                            <img src="{{asset('my-assets/img/tabung.png')}}">
                                            <div class="tabung-fund2" style="height:{{$extAgencyPerc}}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-6 col-8" style="position: relative;">
                                        <div style="position: absolute; bottom:20px;left:0px;">
                                            <div class="count">{{$extAgencyPerc}}<small>%</small></div>
                                            @if($extAgencyExpense>0)
                                            <div class="terms">telah dibelanjakan</div>
                                            <div class="terms">{{number_format($extAgencyExpense, 0)}}/{{number_format($extAgencyAllocation, 0)}}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="info-box" id="box-user-online" style="padding-bottom:10px">
                            <div class="module mb-0">
                                <div class="module-info ml-2">Jumlah</div>
                                Pengguna Secara Langsung
                                <div class="form-label count-big">
                                    {{$total_online_now}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 col-12">
                        <div class="info-box pb-0" style="position: relative">
                            <div class="section-bd cursor-pointer" style="position: absolute;right:20px;top:20px;" onclick="javascript:openPgInFrame('{{ route('report.report_appl_by_mth')}}');">
                                Sehingga {{Carbon\Carbon::now()->translatedFormat('F Y')}}
                            </div>
                            <div class="module">
                                Penilaian
                                {{-- &amp; Pengangkutan --}}
                            </div>
                            <div class="penilaian-legend thin-underline" style="position: relative;">
                                <div class="stat-penilaian">
                                    <div class="legend-top">Baharu</div>
                                    <div class="count-xs" style="color:#6b8665">{{$resultNew->total_new + $resultAccident->total_new +$resultSafety->total_new +$resultCurrvalue->total_new +$resultLoan->total_new +$resultDisposal->total_new }}</div>
                                </div>
                                {{-- <div class="stat-penilaian">
                                    <div class="legend-top">Batal</div>
                                    <div class="count-xs" style="color:#f4b03d">{{$resultNew->total_cancelled + $resultAccident->total_cancelled +$resultSafety->total_cancelled +$resultCurrvalue->total_cancelled +$resultLoan->total_cancelled +$resultDisposal->total_cancelled }}</div>
                                </div> --}}
                                <div class="stat-penilaian">
                                    <div class="legend-top">Tindakan</div>
                                    <div class="count-xs" style="color:#cc593e">{{$resultNew->total_in_progress + $resultAccident->total_in_progress +$resultSafety->total_in_progress +$resultCurrvalue->total_in_progress +$resultLoan->total_in_progress +$resultDisposal->total_in_progress}}</div>
                                </div>
                                <div class="stat-penilaian">
                                    <div class="legend-top">Selesai</div>
                                    <div class="count-xs" style="color:#4abed7">{{$resultNew->total_completed + $resultAccident->total_completed +$resultSafety->total_completed +$resultCurrvalue->total_completed +$resultLoan->total_completed +$resultDisposal->total_completed}}</div>
                                </div>
                                <div class="stat-penilaian">
                                    <div class="legend-top">JUMLAH</div>
                                    {{-- <div class="count">{{$resultNew->total_all_new + $resultAccident->total_all_accident +$resultSafety->total_all_safety +$resultCurrvalue->total_all_currvalue +$resultLoan->total_all_gov_loan +$resultNew->total_cancelled + $resultAccident->total_cancelled +$resultSafety->total_cancelled +$resultCurrvalue->total_cancelled +$resultLoan->total_cancelled+$resultNew->total_in_progress + $resultAccident->total_in_progress +$resultSafety->total_in_progress +$resultCurrvalue->total_in_progress +$resultLoan->total_in_progress }}</div> --}}
                                    <div class="count">{{$resultNew->total_all_new + $resultAccident->total_all_accident + $resultSafety->total_all_safety + $resultCurrvalue->total_all_currvalue + $resultLoan->total_all_gov_loan + $resultDisposal->total_all_disposal}}</div>
                                </div>
                            </div>
                            <div class="row" id="bar-penilaian">
                                <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2" style="padding-right:0px;">
                                    <div class="own-legend">
                                        <div class="row">
                                            <div class="col-12 lejen">Penilaian<br/>Kenderaan Baharu<div class="sword"></div></div>
                                            <div class="col-12 lejen">Penilaian<br/>Kemalangan<div class="sword"></div></div>
                                            <div class="col-12 lejen">Penilaian Prestasi & Keselamatan<div class="sword"></div></div>
                                            <div class="col-12 lejen">Penilaian Harga Semasa<div class="sword"></div></div>
                                            <div class="col-12 lejen">Penilaian Pinjaman Kerajaan<div class="sword"></div></div>
                                            <div class="col-12 lejen">Penilaian<br/>Pelupusan</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-10 col-sm-10 p-0">
                                    <figure class="highcharts-figure" style="height:395px">
                                        <div id="tren_penilaian" style="height:400px"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="info-box pb-0 box-tren-woksyop" style="position: relative;background-image: url({{asset('my-assets/img/tools.png')}});">
                            <div class="section-bd" style="position: absolute;right:20px;top:20px;">Sehingga {{Carbon\Carbon::now()->translatedFormat('F Y')}}</div>
                            <div class="module">
                                Pemeriksaan &amp; Penyenggaraan
                            </div>
                            <div class="penilaian-legend thin-underline" style="position: relative;">
                                <div class="stat-penilaian">
                                    <div class="legend-top">Baharu</div>
                                    <div class="count-xs" style="color:#6b8665">{{$resultMaintenanceEvaluation->total_new + $resultMaintenanceJob->total_new}}</div>
                                </div>
                                {{-- <div class="stat-penilaian">
                                    <div class="legend-top">Batal</div>
                                    <div class="count-xs" style="color:#f4b03d">{{$resultMaintenanceEvaluation->total_cancelled + $resultMaintenanceJob->total_cancelled}}</div>
                                </div> --}}
                                <div class="stat-penilaian">
                                    <div class="legend-top">Tindakan</div>
                                    <div class="count-xs" style="color:#cc593e">{{$resultMaintenanceEvaluation->total_in_progress + $resultMaintenanceJob->total_in_progress}}</div>
                                </div>
                                <div class="stat-penilaian">
                                    <div class="legend-top">Selesai</div>
                                    <div class="count-xs" style="color:#4abed7">{{$resultMaintenanceEvaluation->total_completed + $resultMaintenanceJob->total_completed}}</div>
                                </div>
                                <div class="stat-penilaian">
                                    <div class="legend-top">JUMLAH</div>
                                    <div class="count">{{
                                    $resultMaintenanceEvaluation->total_new + $resultMaintenanceJob->total_new+
                                    $resultMaintenanceEvaluation->total_completed + $resultMaintenanceJob->total_completed+
                                    $resultMaintenanceEvaluation->total_cancelled + $resultMaintenanceJob->total_cancelled+
                                    $resultMaintenanceEvaluation->total_in_progress + $resultMaintenanceJob->total_in_progress
                                    }}</div>
                                </div>
                            </div>
                            <div class="row" id="bar-penyenggaraan">
                                <div class="col-xl-3 col-lg-3 col-md-2 col-sm-2" style="padding-right:0px;">
                                    <div class="own-legend">
                                        <div class="row">
                                            <div class="col-12 lejen" style="padding-top:17px">Pemeriksaan<div class="sword"></div></div>
                                            <div class="col-12 lejen" style="padding-top:17px">Servis<div class="sword"></div></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9 col-lg-9 col-md-10 col-sm-10 p-0">
                                    <figure class="highcharts-figure" style="height:300px;margin-top:10px">
                                        <div id="tren_penyenggaraan" style="height:300px"></div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];

    let categories =  [];
            // categories = [{
			// 	name: 'Sedan',
			// 	y: 505370,
			// 	z: 92.9
			// }, {
			// 	name: 'France',
			// 	y: 551500,
			// 	z: 118.7
			// }, {
			// 	name: 'Poland',
			// 	y: 312685,
			// 	z: 124.6
			// }, {
			// 	name: 'Czech Republic',
			// 	y: 78867,
			// 	z: 137.5
			// }, {
			// 	name: 'Italy',
			// 	y: 301340,
			// 	z: 201.8
			// }, {
			// 	name: 'Switzerland',
			// 	y: 41277,
			// 	z: 214.5
			// }, {
			// 	name: 'Germany',
			// 	y: 357022,
			// 	z: 235.6
			// }];

    @foreach ($vehicleByCategoryList as $vehicleByCategory)
    categories.push({
        name: '{{$vehicleByCategory->name}}',
        y: {{$vehicleByCategory->total}},
        z: {{$vehicleByCategory->id}}
    });
    @endforeach

function loadCategoyChart(){
    Highcharts.setOptions({
        lang: {
            thousandsSep: ','
        }
    });
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
            pointFormat: '<span style=\"font-family:mark;font-size:14px;\">{point.name}</span><br>' +
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
                },
                series: {
                    animation: false,
                    events:{
                        click: function (event) {
                            parent.openPgInFrame('{{ route("report.report_compositions", ["composition_by" => "vehicle_type" ]) }}&category_id='+event.point.z+"&graph_type=pie");
                        }
                    }
                }
            },
        series: [{
            minPointSize: 10,
            innerSize: '20%',
            zMin: 0,
            name: 'kategori',
            data: categories
        }],
        exporting: {
            enabled: false
        },
        credits: {
            enabled: false
        }
    });

    Highcharts.chart('chart-saman', {
        chart: {
            margin: [-20, 0, 20, 34]
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Belum Selesai','Selesai'],
            labels: {
                enabled: false
            },
            allowDecimals: false
        },
        yAxis: {
            title: '',
            style: {
                fontSize: '10px'
            },
            allowDecimals: false
        },
        // labels: {
        //     items: [{
        //         html: 'Keseluruhan',
        //         style: {
        //             left: '20px',
        //             top: '23px',
        //             fontSize: '12px',
        //             color: ( // theme
        //                 Highcharts.defaultOptions.title.style &&
        //                 Highcharts.defaultOptions.title.style.color
        //             ) || 'black'
        //         }
        //     }]
        // },
        plotOptions: {
            column: {
                colorByPoint: true
            },
            series: {
                animation: false,
                events:{
                    click: function (event) {

                        if(event.point.category == "Selesai"){
                            parent.openPgInFrame('{{ route("vehicle.saman.rekod", ["limit" => '5' ]) }}&status=all_done');
                        }
                        else if(event.point.category == "Belum Selesai"){
                            parent.openPgInFrame('{{ route("vehicle.saman.rekod", ["limit" => '5' ]) }}&status=in_progress');
                        }
                        // [
                        //     parent.openPgInFrame('{{ route("vehicle.saman.rekod", ["limit" => '5' ]) }}&status=payment_done'),
                        //     parent.openPgInFrame('{{ route("vehicle.saman.rekod", ["limit" => '5' ]) }}&status=is_chg_ownership')
                        // ]

                    },
                    // click: function (event){
                    //     parent.openPgInFrame('{{ route("vehicle.saman.rekod", ["limit" => '5' ]) }}&status=is_chg_ownership');
                    // }

                }
            },
        },
        colors: [
            '#6a8e4e',
            '#b0d182'
        ],
        series: [{
            type: 'column',
            name: 'Selesai',
            data: [{{$totalSummonUnpaid+$totalSummonDiscounted}}, {{$totalSummonPaid+$totalSummonTransfered}}],
            // center: [26, 80],
            showInLegend: false
        },
        // {
        //     type: 'pie',
        //     name: 'Status Pelunasan',
        //     data: [{
        //         name: 'Selesai',
        //         y: {{$totalSummonPaid}},
        //         sliced: true,
        //         color: '#62782f'
        //     }, {
        //         name: 'Tertunggak',
        //         y: {{$totalSummonUnpaid+$totalSummonDiscounted}},
        //         color: '#f4a831'
        //     }],
        //     center: [26, 80],
        //     size: 90,
        //     crisp: true,
        //     showInLegend: false,
        //     dataLabels: {
        //         enabled: false
        //     }
        // }
        ],
        exporting: {
            enabled: false
        },
        credits: {
            enabled: false
        }
    });



    Highcharts.chart('tren_penilaian', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        legend: {
            itemStyle: {
                color: '#454545',
                fontSize: '12px',
                font: '10px Trebuchet MS, Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: ['KB', 'KE', 'PR', 'HS', 'PK', 'LP'],
            labels: {
                enabled: false
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                animation: false,
                events:{
                    click: function (event) {
                        let mapStatusCode = {
                            "#6b8665": '02',
                            "#4abed7": '08',
                            "#f4b03d": '06'
                        };

                        let statusCode = mapStatusCode[event.point.color] ? mapStatusCode[event.point.color] : '';
                         switch (event.point.category) {

                             case 'KB':
                                    parent.openPgInFrame('{{ route("assessment.new.list") }}?status_code='+statusCode);
                                 break;
                            case 'KE':
                                    parent.openPgInFrame('{{ route("assessment.accident.list") }}?status_code='+statusCode);
                                break;
                            case 'PR':
                                    parent.openPgInFrame('{{ route("assessment.safety.list") }}?status_code='+statusCode);
                                break;
                            case 'HS':
                                    parent.openPgInFrame('{{ route("assessment.currvalue.list") }}?status_code='+statusCode);
                                break;
                            case 'PK':
                                    parent.openPgInFrame('{{ route("assessment.gov_loan.list") }}?status_code='+statusCode);
                                break;
                            case 'LP':
                                    parent.openPgInFrame('{{ route("assessment.disposal.list") }}?status_code='+statusCode);
                                break;

                             default:
                                 break;
                         }
                    }

                }
            }
        },
        series: [
            {
                name: 'Baharu',
                data: [{{$resultNew->total_new}}, {{$resultAccident->total_new}}, {{$resultSafety->total_new}}, {{$resultCurrvalue->total_new}}, {{$resultLoan->total_new}}, {{$resultDisposal->total_new}}],
                stack: 'Baharu',
                color: '#6b8665'
            }, {
                name: 'Tindakan',
                data: [{{$resultNew->total_in_progress}}, {{$resultAccident->total_in_progress}}, {{$resultSafety->total_cancelled}}, {{$resultCurrvalue->total_in_progress}}, {{$resultLoan->total_in_progress}}, {{$resultDisposal->total_in_progress}}],
                stack: 'Proses',
                color: '#cc593e'
            }, {
                name: 'Selesai',
                data: [{{$resultNew->total_completed}}, {{$resultAccident->total_completed}}, {{$resultSafety->total_completed}}, {{$resultCurrvalue->total_completed}}, {{$resultLoan->total_completed}}, {{$resultDisposal->total_completed}}],
                stack: 'Proses',
                color: '#4abed7'
            },

        ],
        credits: {
            enabled: false
        }
    });

    Highcharts.chart('tren_penyenggaraan', {
        chart: {
            type: 'bar'
        },
        title: {
            text: ''
        },
        legend: {
            itemStyle: {
                color: '#454545',
                fontSize: '12px',
                font: '10px Trebuchet MS, Verdana, sans-serif'
            }
        },
        xAxis: {
            categories: ['PM', 'SV','',''],
            labels: {
                enabled: false // disable labels
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        plotOptions: {
            series: {
                stacking: 'normal',
                animation: false,
                events:{
                    click: function (event) {
                        let mapStatusCode = {
                            "#cc593e": 'all_inprogress',
                            "#6b8665": '02',
                            "#4abed7": '08',
                            "#f4b03d": '06'
                        };

                        let statusCode = mapStatusCode[event.point.color] ? mapStatusCode[event.point.color] : '';
                         switch (event.point.category) {

                             case 'PM':
                                    parent.openPgInFrame('{{route('maintenance.evaluation.list')}}?status_code='+statusCode);
                                 break;
                             case 'SV':
                                    parent.openPgInFrame('{{route('maintenance.job.list')}}?status_code='+statusCode);
                                 break;

                             default:
                                 break;
                         }
                    }

                }
            }
        },
        series: [{
            name: 'Diterima',
            data: [{{$resultMaintenanceEvaluation->total_new}}, {{$resultMaintenanceJob->total_new}},0,0],
            stack: 'Baharu',
            color: '#6b8665'
        }, {
            name: 'Tindakan',
            data: [{{$resultMaintenanceEvaluation->total_in_progress}}, {{$resultMaintenanceJob->total_in_progress}},0,0],
            stack: 'Proses',
            color: '#cc593e'
        }, {
            name: 'Selesai',
            data: [{{$resultMaintenanceEvaluation->total_completed}}, {{$resultMaintenanceJob->total_completed}},0,0],
            stack: 'Proses',
            color: '#4abed7'
        }],
        credits: {
            enabled: false
        }
    });
}

    /*$(document).ready(function(){

    });*/

//doChunk();
</script>
<script src="{{asset('my-assets/plugins/slick/slick.js')}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
      $(".vertical-center-4").slick({
        dots: true,
        vertical: true,
        centerMode: true,
        slidesToShow: 4,
        slidesToScroll: 2
      });
      $(".vertical-center-3").slick({
        dots: true,
        vertical: true,
        centerMode: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      $(".vertical-center-2").slick({
        dots: true,
        vertical: true,
        centerMode: true,
        slidesToShow: 2,
        slidesToScroll: 2
      });
      $(".vertical-center").slick({
        dots: true,
        vertical: true,
        centerMode: true,
      });
      $(".vertical").slick({
        dots: true,
        vertical: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3
      });
      $(".center").slick({
        dots: true,
        infinite: true,
        centerMode: true,
        slidesToShow: 5,
        slidesToScroll: 3
      });
      $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true
      });
      $(".lazy").slick({
        lazyLoad: 'ondemand', // ondemand progressive anticipated
        infinite: true
      });
    });
</script>
<script>
    jQuery(document).ready(function() {
        $('.autoplay').slick({
            variableWidth: true,
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            prevArrow: $('.prev'),
            nextArrow: $('.next')
        });
    })
</script>
<script>
    function printMe(self){
        $('#btn-print-container').hide();
        window.print();
        $('#btn-print-container').show();
    }
    jQuery(document).ready(function() {
        loadCategoyChart();

        @if($totalPenilaian > 0 || $totalSenggaraan > 0)
            $('#notify').slideDown();
        @endif
        //var boxHeight = $('#box-record').css('height');
        //$('#box-logistics').css('height', boxHeight);

        var barWidth = $('#bar-penilaian').css('width');
        $('.sword').css('width', (parseInt(barWidth) - 10) + 'px');

        $(window).resize(function() {
            //var boxHeight = $('#box-record').css('height');
            //$('#box-logistics').css('height', boxHeight);
        });
    })
</script>
</body>
</html>

