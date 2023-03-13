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
    }
    .col-focus {
        min-width: 70px;
        vertical-align: text-top;
        text-align: right;
        padding-right:5px;
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
        line-height:16px;
        transition: all 0.2s ease-in;
    }
    .col-focus.link:hover {
        font-size:20px;
        background-color:orange;
        line-height:16px;
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
        min-width:130px;
        color:#2c2c2c;
        padding-top:5px;
        padding-left:7px;
        padding-bottom:5px;
        background-color:#eeeded;
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
    var eachMonthTotal = [];
    var differences = [];
    @foreach ($data as $item)
        //alert('$item->month_name : '+'{{$item->month}}');

        //$('.col-focus.{{$item->month}}').html('{{$item->total}}');
        eachMonthTotal.push([{{$item->total}}]);
        //alert('{{$loop->index}}');

    @endforeach

    @foreach ($differences as $percentageDifference)
        //alert('$item->month_name : '+'{{$item->month}}');
        var hasData = {{$percentageDifference}};
        //$('.col-focus.{{$item->month}}').html('{{$item->total}}');
        if(hasData>-1){
            differences.push([hasData]);
        }
        //alert('{{$loop->index}}');

    @endforeach


   // alert(differences);
</script>
</head>

@php
    $trendDesc = [
        'jabatan' => 'Kenderaan Jabatan',
        'projek' => 'Kenderaan Projek',
        '' => 'Invalid',
        'lupus' => 'Kenderaan Lupus'

    ]
@endphp


<body class="content">
<div class="sect-top">
    <div class="mytitle">Laporan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('vehicle.report')}}')">Laporan & Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tren Pendaftaran Baharu ({{$trendDesc[$trendOn]}})</li>
        </ol>
    </nav>


    <div class="dropdown inline" style="display: inline;">
        <div class="btn-group">
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">

                    {{$trendDesc[$trendOn]}}

                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><h6 class="dropdown-header">Tren Pendaftaran Baharu</h6></li>
                    <li><a class="dropdown-item type" {{ $trendOn == 'jabatan' ? 'style=background-color:lightgrey': ''}} xname='jabatan'> Kenderaan Jabatan</a></li>
                    <li><a class="dropdown-item type" {{ $trendOn == 'projek' ? 'style=background-color:lightgrey': ''}} xname='projek'> Kenderaan Projek</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Tren Pelupusan</h6></li>
                    <li><a class="dropdown-item type" {{ $trendOn == 'lupus' ? 'style=background-color:lightgrey': ''}} xname='lupus'> Kenderaan Lupus</a></li>
                </ul>
            </div>
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{$currentYear}}
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item year" {{ $currentYear == '2021' ? 'style=background-color:lightgrey !important': ''}} xname='2021'> 2021</a></li>
                    <li><a class="dropdown-item year" {{ $currentYear == '2020' ? 'style=background-color:lightgrey !important': ''}} xname='2020'> 2020</a></li>
                    <li><a class="dropdown-item year" {{ $currentYear == '2019' ? 'style=background-color:lightgrey !important': ''}} xname='2019'> 2019</a></li>
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
            <div class="small-title">Analisa Tren</div>
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </section>
    <section id="perincian" class="tab-content">
        <div class="detailing">
            <div class="small-title mb-4">Analisa Tren</div>
            <table>
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
                    <tr>
                        <td class="end thin-underline"></td>
                        <td class="row-item thin-underline">Bilangan {{$trendDesc[$trendOn]}}</td>

                        @foreach ($data as $item)

                        <td class="col-focus link ">{{$item->total}}</td>
                        @endforeach
                        {{-- <td class="col-focus link ">0</td>
                        <td class="col-focus link ">0</td>
                        <td class="col-focus link ">0</td>
                        <td class="col-focus link ">0</td>
                        <td class="col-focus link ">0</td>
                        <td class="col-focus link ">0</td>
                        <td class="col-focus link ">0</td>
                        <td class="col-focus ">0</td>
                        <td class="col-focus ">0</td>
                        <td class="col-focus ">0</td>
                        <td class="col-focus ">0</td>
                        <td class="col-focus ">0</td> --}}
                        <td class="end"></td>
                    </tr>
                    <tr>
                        <td class="end thin-underline"></td>
                        <td class="row-item thin-underline">Tren</td>
                        @foreach ($differences as $percentageDifference)
                        {{-- <td class="col-info">{{$percentageDifference<0 ? "":"+"}}{{$percentageDifference}}%</td> --}}
                            @if($percentageDifference>-1)
                                <td class="col-tren thin-underline"><div class="shape-{{$percentageDifference==0 ? "": ($percentageDifference<0 ? "decline":"incline")}}"></div></td>
                            @endif
                        @endforeach
                        {{-- <td class="col-tren thin-underline"><div class="shape-incline"></div></td>
                        <td class="col-tren thin-underline"><div class="shape-incline"></div></td>
                        <td class="col-tren thin-underline"><div class="shape-decline"></div></td>
                        <td class="col-tren thin-underline"><div class="shape-incline"></div></td>
                        <td class="col-tren thin-underline"><div class="shape-incline"></div></td>
                        <td class="col-tren thin-underline"><div class="shape-incline"></div></td>
                        <td class="col-tren thin-underline"><div class="shape-incline"></div></td>
                        <td class="col-tren thin-underline"></td>
                        <td class="col-tren thin-underline"></td>
                        <td class="col-tren thin-underline"></td>
                        <td class="col-tren thin-underline"></td>
                        <td class="col-tren thin-underline"></td> --}}
                        <td class="end thin-underline"></td>
                    </tr>
                    <tr>
                        <td class="end"></td>
                        <td class="row-item">% Pertumbuhan</td>
                        @foreach ($differences as $percentageDifference)
                            @if($percentageDifference>-1)
                                <td class="col-info">{{$percentageDifference<0 ? "":"+"}}{{$percentageDifference}}%</td>
                            @endif
                        @endforeach
                        {{-- <td class="col-info">+100%</td>
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
                        <td class="col-info">-</td> --}}
                        <td class="end"></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        initTab();
        //alert('{{$trendOn}}');
        $('.dropdown-item.type').click(function(e){
            var clickedItem = $(this).attr('xname');
            //alert(clickedItem);
            location.replace('report_trend_analysis?current_year={{$currentYear}}&trend_on='+clickedItem);
	  	});

          $('.dropdown-item.year').click(function(e){
            var clickedItem = $(this).attr('xname');
            //alert(clickedItem);
            location.replace('report_trend_analysis?trend_on={{$trendOn}}&current_year='+clickedItem);


	  	});
    });


</script>
<script type="text/javascript">


    //eachMonthTotal = [0,0,0,0,0,0,0,0,3633,0,0,0];
  //  alert(eachMonthTotal);

	var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];
	Highcharts.chart('container', {
        chart: {
            zoomType: 'xy',
            marginTop: 30
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun',
                'Jul', 'Ogo', 'Sep', 'Okt', 'Nov', 'Dis'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            title: {
                text: 'Peningkatan / Penurunan',
                style: {
                    color: '#988992'
                }
            },
            labels: {
                format: '{value} %',
                style: {
                    color: '988992'
                }
            },
            plotLines: [{
            color: 'black', // Color value
            value: 0, // Value of where the line will appear
            width: 2 // Width of the line
            }],
            opposite: true
        },{ // Secondary yAxis
            labels: {
                format: '{value} buah',
                style: {
                    color: '#5e7485'
                }
            },
            title: {
                text: 'Jumlah',
                style: {
                    color: '#5e7485'
                }
            }
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            y: 30,
            verticalAlign: 'top',
            x: 110,
            floating: true,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || // theme
                'rgba(255,255,255,0.25)'
        },
        series: [{
            name: 'Jumlah',
            type: 'column',
            yAxis: 1,
            color: '#1E434E',
            //data: [5, 10, 3, 4, 7, 3, 12, 0, 0, 0, 0, 1],
            data : eachMonthTotal,
            tooltip: {
                valueSuffix: ' buah'
            }

        },{
            name: 'Tren',
            type: 'spline',
            data: differences,
            tooltip: {
                valueSuffix: '%'
            }
        }]
    });
        //alert(eachMonthTotal.length);






</script>
<script type="text/javascript">

</script>
</body>
