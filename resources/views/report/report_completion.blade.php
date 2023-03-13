<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/datatables/datatables.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<!--<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">-->

<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/highcharts-3d.js')}}"></script>
<!--<script src="{{asset('my-assets/plugins/highcharts/code/modules/stock.js')}}"></script>-->
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>

{{--  lodash plugin  --}}
<script src="{{asset('my-assets/plugins/lodash/core.js')}}"></script>

<style type="text/css">
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
        margin-left:0px;
    }
    #container {
        height: 400px;
        width:100%;
    }
    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
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
    .dropdown-item {
        font-family: mark;
        font-size:14px;
    }
    .dropdown-item i.fa {
        min-width:40px !important;
        text-align:left;
    }
    .dropdown-header {
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:12px;
        color:#6d7466;
    }
    .header-highlight {
        background-color:#49575c;
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:16px;
        color:#ffffff;
        height: 30px;
        line-height: 30px;
        padding-left:16px;
        border-radius: 4px 4px 6px 6px;
        -moz-border-radius: 4px 4px 6px 6px;
        -webkit-border-radius:  4px 4px 6px 6px;
    }
    .dropdown-menu {
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
    }
    .detailing {
        background-color:#ffffff;
        padding:20px;
        width:100%;
        max-width: 1030px;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
    }
    thead td {
        border-bottom-color:#999999;
        border-bottom-width:1px;
        border-bottom-style: solid;
        height:40px;
    }
    thead td.col-mth {
        font-family: mark-bold;
        color:#1b1b1b;
        font-size:14px;
        border-bottom-width:3px;
        vertical-align: bottom;
        text-align: right;
        width:100px;
        padding-right:5px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
    }
    thead td.col-pct {
        font-family: mark-bold;
        color:#1b1b1b;
        font-size:14px;
        border-bottom-width:3px;
        vertical-align: bottom;
        text-align: right;
        width:150px;
        padding-right:5px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
    }
    .col-focus {
        min-width: 70px;
        vertical-align: text-top;
        text-align: right;
        padding-right:5px;
        height:30px;
        font-size:15px;
        line-height:26px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
    }
    .col-focus.link {
        font-family: mark-bold;
        font-size:16px;

        text-decoration: none;
        color:#454545;
        cursor:pointer;
        line-height:26px;
        transition: all 0.2s ease-in;
    }
    .col-focus.link:hover {
        font-size:16px;
        background-color:orange;
        line-height:26px;
        color:#ffffff;
    }
    .col-info {
        font-family: mark;
        font-size:14px;
        color:#454545;
        line-height:16px;
        text-align: right;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
        padding-right:5px;
    }
    .row-item {
        font-family: mark;
        font-size:14px;
        line-height: 14px;
        min-width:160px;
        color:#2c2c2c;
        padding-top:5px;
        padding-left:7px;
        padding-bottom:5px;
        background-color:#eeeded;
    }
    .thick-underline {
        border-bottom-color:#999999;
        border-bottom-width:3px;
        border-bottom-style: solid;
    }
    .total {
        font-family: mark-bold;
        border-top-color:#999999;
        border-top-width:3px;
        border-top-style: solid;
        font-size:14px;
        line-height: 14px;
        height:40px;
    }
    .total.link {
        padding-top:5px;
        font-family: mark-bold;
        font-size:16px;

        text-decoration: none;
        color:#454545;
    }
    .end {
        width:15px;
    }
    .col-tren {
        padding-right:10px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
        text-align: right;
    }
    .shape-decline {
        float: right;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 15px solid red;
        border-right: 40px solid transparent;
    }
    .shape-incline {
        float: right;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 15px solid green;
        border-left: 40px solid transparent;
    }
    .shape-constant {
        float: right;
        bottom:0px;
        width: 40px;
        height: 15px;
        background-color: #40b293;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
    });

    var stateArray = [];
    var lunasArray = [];
    var samanArray = [];

    @foreach($data_all as $item)

            stateArray.push('{{$item->name}}');
            samanArray.push({{$item->total}});
            lunasArray.push({{$data_paid[$loop->index]->total}});

    @endforeach

    @php

        $monthDesc = [
            '0' => 'Sepanjang Tahun',
            '1' => 'Januari',
            '2' => 'Febuari',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Julai',
            '8' => 'Ogos',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember'

        ]

    @endphp


</script>
</head>

<body class="content">
<div class="sect-top">
    <div class="mytitle">Laporan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('vehicle.report')}}')">Laporan & Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tren Saman</li>
        </ol>
    </nav>
    <div class="dropdown inline" style="display: inline;">

        <div class="btn-group">
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fal fa-calendar"></i> {{$monthDesc[$month]}}
                </a>
                <ul class="dropdown-menu" >
                    <li><a class="dropdown-item monthly" xvalue = '0' {{ $month == 0 ? 'style=background-color:lightgrey': ''}}> Spanjang Tahun </a></li>
                    <li><a class="dropdown-item monthly" xvalue = '1' {{ $month == 1 ? 'style=background-color:lightgrey': ''}}> Januari</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '2' {{ $month == 2 ? 'style=background-color:lightgrey': ''}}> Februari</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '3' {{ $month == 3 ? 'style=background-color:lightgrey': ''}}> Mac</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '4' {{ $month == 4 ? 'style=background-color:lightgrey': ''}}> April</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '5' {{ $month == 5 ? 'style=background-color:lightgrey': ''}}> Mei</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '6' {{ $month == 6 ? 'style=background-color:lightgrey': ''}}> Jun</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '7' {{ $month == 7 ? 'style=background-color:lightgrey': ''}}> Julai</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '8' {{ $month == 8 ? 'style=background-color:lightgrey': ''}}> Ogos</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '9' {{ $month == 9 ? 'style=background-color:lightgrey': ''}}> September</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '10' {{ $month == 10 ? 'style=background-color:lightgrey': ''}}> Oktober</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '11' {{ $month == 11 ? 'style=background-color:lightgrey': ''}}> November</a></li>
                    <li><a class="dropdown-item monthly" xvalue = '12' {{ $month == 12 ? 'style=background-color:lightgrey': ''}}> Disember</a></li>
                </ul>
            </div>
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{$year}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @php
                        $yearList = [];
                        $yearRange = range(date('Y') - 5, date('Y'));
                        foreach (array_reverse($yearRange) as $key) {
                            array_push($yearList,$key);
                        }
                    @endphp
                    @foreach ($yearList as $key)
                        <li><a class="dropdown-item yearly" xvalue = '{{$key}}' {{ $year == $key ? 'style=background-color:lightgrey': ''}}> {{$key}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="dropdown inline float-end">
            <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        </div>
    </div>
</div>
<br/>
<div class="sect-top-dummy"></div>
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
            <div class="small-title">Saman & Pelunasan</div>
            <figure class="highcharts-figure">
                <div id="container" style="width:100%"></div>
            </figure>
        </div>
    </section>
    <section id="perincian" class="tab-content">
        <div class="detailing">
            <div class="small-title mb-4">Saman & Pelunasan</div>
            <table>
                <thead>
                    <td class="end thick-underline"></td>
                    <td class="row-item thick-underline"></td>
                    <td class="col-mth">Saman</td>
                    <td class="col-mth">Lunas</td>
                    <td class="col-mth">Tunggakan</td>
                    <td class="col-pct">% Tunggakan</td>
                    <td class="end thick-underline"></td>
                </thead>
                <tbody>
                    @foreach ($data_all as $item)

                    {{-- <td class="col-focus link ">{{$item->total}}</td> --}}
                    <tr>
                        <td class="end thin-underline"></td>
                        <td class="row-item thin-underline">{{$item->name}}</td>
                        <td class="col-focus thin-underline link">{{$item->total}}</td>
                        <td class="col-focus thin-underline link">{{$data_paid[$loop->index]->total}}</td>
                        <td class="col-focus thin-underline link">{{$data_unpaid[$loop->index]->total}}</td>
                        <td class="col-focus thin-underline">{{round(($data_unpaid[$loop->index]->total)/($item->total == 0 ? "1" : $item->total)*100)}}%</td>
                        <td class="end thin-underline"></td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
            <p>&nbsp;</p>
        </div>

    </section>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        initTab();

        $('.dropdown-item.yearly').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            //alert(clickedItem);
            location.replace('report_completion?year='+clickedItem+'&month={{$month}}');


	  	});

        $('.dropdown-item.monthly').click(function(e){
        var clickedItem = $(this).attr('xvalue');
        //alert(clickedItem);
        location.replace('report_completion?month='+clickedItem+'&year={{$year}}');


	  	});
    });


</script>
<script type="text/javascript">


	var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];

    //alert(stateArray+' - '+samanArray+' - '+lunasArray);

	Highcharts.chart('container', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 15,
                beta: 15,
                viewDistance: 25,
                depth: 40
            },
            marginLeft: 0
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            //categories: ['Selangor', 'Johor', 'Kedah', 'Kelantan', 'Melaka', 'N. Sembilan', 'Pahang', 'Perak', 'Perlis', 'P. Pinang','WP KL', 'WP Putrajaya', 'WP Labuan', 'Sabah','Sarawak','Terengganu'],
            categories: stateArray,
            labels: {
                skew3d: true,
                style: {
                    fontSize: '16px'
                }
            }
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'Jumlah Saman / Lunas ',
                skew3d: true
            }
        },

        tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
            pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
        },

        plotOptions: {
            column: {
                stacking: 'normal',
                depth: 40
            }
        },

        series: [{
            name: 'Saman',
            //data: [5, 3, 4, 7, 2, 5, 0, 4, 7, 2, 3, 5, 4, 2, 1],
            data : samanArray,
            stack: 'male',
            color: '#FFA500'
        }, {
            name: 'Lunas',
            //data: [3, 4, 4, 2, 5, 5, 3, 4, 7, 2, 1, 3, 2, 1, 0],
            data : lunasArray,
            stack: 'male',
            color: '#1e434e'
        }]
    });
</script>
</body>
