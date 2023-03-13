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
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/no-data-to-display.js')}}"></script>

<style type="text/css">
    /*body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
        padding:20px;
    }*/
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px;
        max-width: 1200px;
        margin: 1em auto;
        margin-left:0px;
    }
    #container {
        height: 500px;
    }
    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }


    .display {
        width:100%;
        padding-left:10px;
        padding-right:10px;
        padding-top:35px;
    }
    body {
        background-color: #f4f5f2;
    }
    .subtitle {
        font-family: mark;
        font-size:16px;
        line-height: 15px;
        color:#2c5c6a;
    }
    .rpt-box {
        position: relative;
        padding-top:18vh;
    }
    .sch-point {
        position: relative;
        height:30vh;
        width:100%;
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
        padding-left:10px;
        padding-right:10px;
        vertical-align: baseline;
    }
    ul.menu li:first-of-type {
        font-family: avenir-bold;
        text-transform: uppercase;
        font-size: 14px;
        line-height: 16px;
        padding-top:5px;
        padding-bottom:5px;
        margin-top:10px;
        list-style-type: none;
        margin-left:-30px;
        color:#303030;

    }
    ul.menu li {
        line-height: 10px;
        list-style-type: none;
        margin-left:-30px;
        border-bottom-style: solid;
        border-bottom-color:rgba(0,0,0,0.04);
        border-bottom-width:1px;
        padding-top:5px;
        padding-bottom:5px;
    }
    ul.menu li a {
        font-family: mark;
        font-size: 14px;
        line-height:16px;
        color:#303030;
        text-decoration: none;
    }
    ul.menu li a:hover {
        color:#ffa124;
    }
    .rpt-link {
        height:32px;
        /*border-bottom-style: solid;
        border-bottom-color:rgba(0,0,0,0.13);
        border-bottom-width:1px;*/
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        cursor: pointer;
    }
    .rpt-link.boss {
        font-family: mark-bold;
    }
    .rpt-link-end {
        height:32px;
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        cursor: pointer;
    }
    .rpt-link:hover,  .rpt-link-end:hover {
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        color:#ffa124;
    }
    .ico-rpt {
        height:50px;
        margin-left:0px;
        margin-bottom:25px;
        margin-top:25px;
    }
    .rpt-title {
        position: absolute;
        left:75px;
        top: 35px;
        font-family: mark-bold;
        font-size:18px;
        color:#51574b;
    }
    .table {
        width:100%;
        margin-left:0px;
    }
    .table tbody tr {
        height:30px;
        background-color: transparent;
    }
    .table tbody tr td {
        font-family: mark;
        font-size:14px;
        line-height:30px;
        background-color: transparent;
    }
    .content-row {
        padding-left:20px;padding-right:20px;
    }
    .hailait {
        background-color:#eaede7
    }
    .hailait.end {
        border-radius: 0px 0px 10px 10px;
        -moz-border-radius: 0px 0px 10px 10px;
        -webkit-border-radius: 0px 0px 10px 10px;
        padding-bottom:20px;
    }
    .hailait.stt {
        border-radius: 10px 10px 0px 0px;
        -moz-border-radius: 10px 10px 0px 0px;
        -webkit-border-radius: 10px 10px 0px 0px;
    }
    .subsection {
        font-family: avenir;
        letter-spacing: 4px;
        text-transform: uppercase;
        font-size:10px;
        line-height: 32px;
        padding-left:20px;
        color:#3c3c3c;
        height: 34px;
        background-color: #ffffff;
        border-radius: 25px 25px 25px 25px;
        -moz-border-radius: 25px 25px 25px 25px;
        -webkit-border-radius: 25px 25px 25px 25px;
        border-color:#e2e2e1;
        border-width: 1px;
        border-style:solid;
        width:100%;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
    }
    .btn-spec {
        float: right;
        width:30px;
        height:30px;
        text-align: center;
        cursor: pointer;
        padding-top:3px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
    }
    .btn-spec:hover {
        background-color:#2c5c6a;
    }
    .sub-icon {
        position: relative;
        display:none;
        width:100%;
    }
    .group-head {
        border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        background-color:#e1e4db;
        width:auto;
        display: inline-block;
        padding-left:10px;
    }
    .group-head .form-check-input {
        margin-top:7px;
    }
    .group-head .form-check-label {
        font-family: avenir;
        font-size:14px;
        padding-right:14px;
        border-right-style: solid;
        border-right-width: 1px;
        border-right-color: #f4f5f2;
    }
    .group-head .btn-group {
        margin-top:-2px;
        margin-left:-10px;
        margin-right:2px;
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
        .main-icon {
            display:none;
        }
        .sub-icon {
            display:block;
            border-bottom-width: 1px;
            border-bottom-color: #c8c0b8;
            border-bottom-style: solid;
            padding-bottom:5px;
        }
        ul.menu li:first-of-type {
            line-height: 12px;
            height:40px;
            padding-top:10px;
        }
        ul.menu li {
            line-height: 12px;
            height:40px;
            padding-top:10px;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .subsection {
            margin-top:20px;
            width:90%;
            margin-right:5%;
            margin-left:5%;
            border-radius: 10px 10px 10px 10px;
            -moz-border-radius: 10px 10px 10px 10px;
            -webkit-border-radius: 10px 10px 10px 10px;
        }
        .ico-rpt {
            margin-left:auto;
            margin-bottom:auto;
        }
        .content-row {
            padding-left:30px;padding-right:30px;
        }
        .header .hailait {
            background:none;
        }
        .header .col-3 {
            height:90px;
            text-align: center;
        }
        .spectitle {
            margin-left:20px;
        }
        ul.menu li:first-of-type {
            line-height: 12px;
            height:30px;
            padding-top:5px;
        }
        ul.menu li {
            line-height: 12px;
            height:30px;
            padding-top:5px;
        }
	}
</style>
</head>
@php
    $currentYear = \Carbon\Carbon::now()->format('Y');
    $selectedYear = $year;
    $years = range($currentYear, $currentYear-5);
@endphp
<body class="content">
<div class="sect-top">
    <div class="mytitle">Analisa Tren <span>Penyenggaraan</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('maintenance.overview')}}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a
                    href="javascript:openPgInFrame('{{ route('maintenance.overview') }}')">Pemeriksaan & Penyenggaraan</a></li>
            <li class="breadcrumb-item"><a
                href="javascript:openPgInFrame('{{ route('maintenance.report') }}')">Laporan &amp; Statistik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tren Penyenggaraan</li>
        </ol>
    </nav>
    <div class="dropdown inline" style="display: inline;">
        <div class="group-head">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="servis" id="servis" value="1" checked>
                <label class="form-check-label cursor-pointer" for="servis">Servis</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="pembaikan" id="pembaikan" value="1" checked>
                <label class="form-check-label cursor-pointer" for="pembaikan">Pembaikan</label>
            </div>
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                {{$selectedYear}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($years as $year)
                        <li><a class="dropdown-item year" data-year="{{$year}}" onclick="changeYear(this)">{{$year}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="dropdown inline float-end">
            <span class="btn cux-btn bigger"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        </div>
    </div>
</div>
<div class="sect-top-dummy"></div>
<br/>
<div class="main-content">
    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'carta');" id="tab1">Carta</li>
                <li class="cub-tab" onClick="goTab(this, 'perincian');" id="tab2">Perincian</li>
            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>
    <section id="carta" class="tab-content">
        <div class="detailing">
            <div class="small-title">Servis</div>
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
            <hr/>
            <div class="small-title">Pembaikan</div>
            <figure class="highcharts-figure">
                <div id="container2" style="height: 700px;"></div>
            </figure>
        </div>
        <p>&nbsp;</p>
    </section>
    <section id="perincian" class="tab-content">
        <div class="detailing">
            <div class="small-title">Servis</div>
            <table class="table-custom">
                <thead>
                    <td class="end"></td>
                    <td class="row-item"></td>
                    <td class="col-mth JAN">Jan</td>
                    <td class="col-mth FEB">Feb</td>
                    <td class="col-mth MAC">Mac</td>
                    <td class="col-mth APR">Apr</td>
                    <td class="col-mth MEY">Mei</td>
                    <td class="col-mth JUN">Jun</td>
                    <td class="col-mth JUL">Jul</td>
                    <td class="col-mth AUG">Ogo</td>
                    <td class="col-mth SEP">Sep</td>
                    <td class="col-mth OCT">Okt</td>
                    <td class="col-mth NOV">Nov</td>
                    <td class="col-mth DIS">Dis</td>
                    <td class="end"></td>
                </thead>
                <tbody>

                    @foreach ($maintenance_service_report_view as $index_service => $service)
                        <tr>
                            <td class="end thin-underline"></td>
                            <td class="row-item thin-underline">{{$service->component}} </td>
                            <td class="col-focus">{{$service->month_1}}</td>
                            <td class="col-focus">{{$service->month_2}}</td>
                            <td class="col-focus">{{$service->month_3}}</td>
                            <td class="col-focus">{{$service->month_4}}</td>
                            <td class="col-focus">{{$service->month_5}}</td>
                            <td class="col-focus">{{$service->month_6}}</td>
                            <td class="col-focus">{{$service->month_7}}</td>
                            <td class="col-focus">{{$service->month_8}}</td>
                            <td class="col-focus">{{$service->month_9}}</td>
                            <td class="col-focus">{{$service->month_10}}</td>
                            <td class="col-focus">{{$service->month_11}}</td>
                            <td class="col-focus">{{$service->month_12}}</td>
                        </tr>
                    @endforeach
                    
                    {{-- <tr>
                        <td class="end"></td>
                        <td class="row-item">% Pertumbuhan</td>
                        <td class="col-info">+100%</td>
                        <td class="col-info">+100%</td>
                        <td class="col-info">-70%</td>
                        <td class="col-info">+33%</td>
                        <td class="col-info">+75%</td>
                        <td class="col-info">-25%</td>
                        <td class="col-info">+300%</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="end"></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>

        <div class="detailing">
            <div class="small-title">Pembaikan</div>
            <table class="table-custom">
                <thead>
                    <td class="end"></td>
                    <td class="row-item"></td>
                    <td class="col-mth JAN">Jan</td>
                    <td class="col-mth FEB">Feb</td>
                    <td class="col-mth MAC">Mac</td>
                    <td class="col-mth APR">Apr</td>
                    <td class="col-mth MEY">Mei</td>
                    <td class="col-mth JUN">Jun</td>
                    <td class="col-mth JUL">Jul</td>
                    <td class="col-mth AUG">Ogo</td>
                    <td class="col-mth SEP">Sep</td>
                    <td class="col-mth OCT">Okt</td>
                    <td class="col-mth NOV">Nov</td>
                    <td class="col-mth DIS">Dis</td>
                    <td class="end"></td>
                </thead>
                <tbody>
        
                    @foreach ($maintenance_repair_report_view as $index_repair => $repair)
                        <tr>
                            <td class="end thin-underline"></td>
                            <td class="row-item thin-underline">{{$repair->component}} </td>
                            <td class="col-focus">{{$repair->month_1}}</td>
                            <td class="col-focus">{{$repair->month_2}}</td>
                            <td class="col-focus">{{$repair->month_3}}</td>
                            <td class="col-focus">{{$repair->month_4}}</td>
                            <td class="col-focus">{{$repair->month_5}}</td>
                            <td class="col-focus">{{$repair->month_6}}</td>
                            <td class="col-focus">{{$repair->month_7}}</td>
                            <td class="col-focus">{{$repair->month_8}}</td>
                            <td class="col-focus">{{$repair->month_9}}</td>
                            <td class="col-focus">{{$repair->month_10}}</td>
                            <td class="col-focus">{{$repair->month_11}}</td>
                            <td class="col-focus">{{$repair->month_12}}</td>
                        </tr>
                    @endforeach
                    
                    {{-- <tr>
                        <td class="end"></td>
                        <td class="row-item">% Pertumbuhan</td>
                        <td class="col-info">+100%</td>
                        <td class="col-info">+100%</td>
                        <td class="col-info">-70%</td>
                        <td class="col-info">+33%</td>
                        <td class="col-info">+75%</td>
                        <td class="col-info">-25%</td>
                        <td class="col-info">+300%</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="col-info">-</td>
                        <td class="end"></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>

    </section>
</div>
<script type="text/javascript">
var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];

// [{
//         name: 'Enjin',
//         data: [15, 26, 47, 39, 30, 13, 32, 0, 0, 0, 0, 0]
//     }, {
//         name: 'Suspension',
//         data: [0, 2, 1, 2, 5, 4, 3, 0, 0, 0, 0, 0]
//     }, {
//         name: 'Brek',
//         data: [1, 1, 2, 2, 17, 2, 12, 0, 0, 0, 0, 0]
//     }, {
//         name: 'Transmisi',
//         data: [0, 1, 3, 3, 4, 2, 7, 0, 0, 0, 0, 0]
//     }, {
//         name: 'AC',
//         data: [1, 3, 6, 6, 19, 5, 20, 0, 0, 0, 0, 0]
//     }, {
//         name: 'Tayar',
//         data: [0, 0, 2, 7, 6, 0, 0, 0, 0, 0, 0, 0]
//     }, {
//         name: 'Lain-lain',
//         data: [0, 1, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0]
//     }]

let seriesRepair = [];

let dataRepair = [0,0,0,0,0,0,0,0,0,0,0,0];

@foreach ($maintenance_repair_report_view as $repair)

    dataRepair = [0,0,0,0,0,0,0,0,0,0,0,0];

    for (let index = 1; index < 12; index++) {
        dataRepair[index-1] =+ @json($repair)['month_'+index];

        if(index == 11){

            const compName = obj => obj.name === '{{$repair->component}}';

            if(!seriesRepair.some(compName)){
                seriesRepair.push({
                    name: '{{$repair->component}}',
                    data: dataRepair
                });
            } else {
                const findOne = seriesRepair.find((e) => e.name == '{{$repair->component}}');
                findOne.data = dataRepair;
            }
        }
    }
    
@endforeach

// ---------

let seriesService = [];
let dataService = [0,0,0,0,0,0,0,0,0,0,0,0];

@foreach ($maintenance_service_report_view as $service)

    dataService = [0,0,0,0,0,0,0,0,0,0,0,0];

    for (let index = 1; index < 12; index++) {
        dataService[index-1] =+ @json($service)['month_'+index];

        if(index == 11){

            const compName = obj => obj.name === '{{$service->component}}';

            if(!seriesService.some(compName)){
                seriesService.push({
                    name: '{{$service->component}}',
                    data: dataService
                });
            } else {
                const findOne = seriesService.find((e) => e.name == '{{$service->component}}');
                findOne.data = dataService;
            }
        }
    }
    
@endforeach

Highcharts.chart('container', {
    lang: {
        noData: "Tiada Rekod"
    },
    noData: {
        style: {
            fontWeight: 'bold',
            fontSize: '15px'
        }
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Servis'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis']
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Servis'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    credits: {
      enabled: false
    },
    series: seriesService
});
var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];

Highcharts.chart('container2', {
    lang: {
        noData: "Tiada Rekod"
    },
    noData: {
        style: {
            fontWeight: 'bold',
            fontSize: '15px'
        }
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Pembaikan'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis']
    },
    yAxis: {
        min: 0,
        title: {
            text: ''
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true
            }
        }
    },
    credits: {
      enabled: false
    },
    series: seriesRepair
});
</script>
<script>

    changeYear = function(self){
        let year = $(self).data('year');
        let url = "{{route('report.maintenance-trends')}}";
        parent.openPgInFrame(url+"?year="+year);
    }

    jQuery(document).ready(function() {
        initTab();

        $('#servis').on('change', function(){
            let is_checked = this.checked;
            if(is_checked){
                $('#container').show();
            } else {
                $('#container').hide();
            }
        })

        $('#pembaikan').on('change', function(){
            let is_checked = this.checked;
            if(is_checked){
                $('#container2').show();
            } else {
                $('#container2').hide();
            }
        });

    })
</script>
</body>
</html>

