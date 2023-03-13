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
        /* max-width: 1030px; */
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

    .col-mth.header-depreciation{
        background-color: lightgoldenrodyellow;
        border-right: 1px solid lightgrey;
        text-align: right;
        padding-right: 8px;

    }

    .header-depreciation.left{

        text-align: left;
        padding-left: 8px;
        font-size: 14px;

    }

    tr{
        border-bottom: 1px solid lightgrey !important;
    }

    .percentage-value{

        text-align: right !important;
    }

    .form-select.smaller{


        font-size: 12px !important;
        padding: 2px !important;
        padding-left: 6px !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

</style>
<script type="text/javascript">

</script>
</head>
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


<body class="content">
<div class="sect-top">
    <div class="mytitle">Laporan <span> Perbelanjaan Peruntukan MHPV</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('maintenance.report')}}')">Laporan & Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan Perbelanjaan Peruntukan Bulanan</li>
        </ol>
    </nav>



    <div class="dropdown inline" style="display: inline;">
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-calendar"></i>
            {{$selectedYear}}
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">TAHUN</h6></li>
            @foreach ($listYear as $yearItem)
            <li><a class="dropdown-item year" data-year="{{$yearItem}}" onclick="getWarrantByYear(this)" xvalue={{$yearItem}} {{ $selectedYear == $yearItem ? 'style=background-color:lightgrey': ''}}>{{$yearItem}}</a></li>
            @endforeach
        </ul>
    </div>

    <div class="d-inline">
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-calendar"></i>
            &nbsp;&nbsp;{{$selectedMonth}}&nbsp;&nbsp;
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">BULAN</h6></li>
            <li><a class="dropdown-item month"  xvalue="1" {{ $selectedMonth == 1 ? 'style=background-color:lightgrey': ''}}>Januari</a></li>
            <li><a class="dropdown-item month"  xvalue="2" {{ $selectedMonth == 2 ? 'style=background-color:lightgrey': ''}}>Februari</a></li>
            <li><a class="dropdown-item month"  xvalue="3" {{ $selectedMonth == 3 ? 'style=background-color:lightgrey': ''}}>Mac</a></li>
            <li><a class="dropdown-item month"  xvalue="4" {{ $selectedMonth == 4 ? 'style=background-color:lightgrey': ''}}>April</a></li>
            <li><a class="dropdown-item month"  xvalue="5" {{ $selectedMonth == 5 ? 'style=background-color:lightgrey': ''}}>Mei</a></li>
            <li><a class="dropdown-item month"  xvalue="6" {{ $selectedMonth == 6 ? 'style=background-color:lightgrey': ''}}>Jun</a></li>
            <li><a class="dropdown-item month"  xvalue="7" {{ $selectedMonth == 7 ? 'style=background-color:lightgrey': ''}}>Julai</a></li>
            <li><a class="dropdown-item month"  xvalue="8" {{ $selectedMonth == 8 ? 'style=background-color:lightgrey': ''}}>Ogos</a></li>
            <li><a class="dropdown-item month"  xvalue="9" {{ $selectedMonth == 9 ? 'style=background-color:lightgrey': ''}}>September</a></li>
            <li><a class="dropdown-item month"  xvalue="10" {{ $selectedMonth == 10 ? 'style=background-color:lightgrey': ''}}>Oktober</a></li>
            <li><a class="dropdown-item month"  xvalue="11" {{ $selectedMonth == 11 ? 'style=background-color:lightgrey': ''}}>November</a></li>
            <li><a class="dropdown-item month"  xvalue="12" {{ $selectedMonth == 12 ? 'style=background-color:lightgrey': ''}}>Disember</a></li>
        </ul>
        <span class="btn cux-btn bigger" onClick="window.print()"> <i class="fal fa-print"></i> Cetak</span>
    </div>
</div>
<br/>
<div class="sect-top-dummy"></div>
<div class="main-content">
    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'osol26000');" id="tab0">OSOL 26000</li>
                <li class="cub-tab" onClick="goTab(this, 'osol28000');" id="tab1">OSOL 28000</li>
                <li class="cub-tab" onClick="goTab(this, 'ranking');" id="tab2">Ranking Perbelanjaan</li>
                <li class="cub-tab" onClick="goTab(this, 'keseluruhan');" id="tab3">Keseluruhan</li>

            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>


    <section id="osol26000" class="tab-content">
        <div class="detailing">
            <div class="small-title">OSOL 26000</div>
            <table>
                <thead>
                    <td class="col-mth header-depreciation">Rank</td>
                    <td class="col-mth header-depreciation">Negeri</td>
                    <td class="col-mth header-depreciation">Jumlah Peruntukan (RM)</td>
                    <td class="col-mth header-depreciation">Perbelanjaan (RM)</td>
                    <td class="col-mth header-depreciation">Baki (RM)</td>
                    <td class="col-mth header-depreciation">% Kewangan</td>
                </thead>
                <tbody>

                    @if(count($osol26)> 0)
                    
                    @foreach ($osol26 as $osolItem)
                    <tr>
                        <td class="row-item" style="text-transform:uppercase">{{$loop->index+1}}.</td>
                        <td class="row-item" style="text-transform:uppercase">{{$osolItem->state}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->total_allocation,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->carry_total_expense,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->balance,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{$osolItem->percent_financial}}%</td>
                    </tr>
                    @endforeach
                    @else 
                    <tr>
                        <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
                    </tr>
                    @endif
                </tbody>

                <tfoot>
                    @foreach ($osolSum26 as $osolItem)
                    <td class="row-item" colspan="2" style="text-transform:uppercase">TOTAL</td>
                    <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_total_allocation,2)}}</td>
                    <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->carry_total_expense,2)}}</td>
                    <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_balance,2)}}</td>
                    <td class="row-item" style="text-transform:uppercase">{{$osolItem->sum_percent_financial}}%</td>
                    @endforeach
                </tfoot>
                    
            </table>

            <figure class="highcharts-figure">
                <div id="container_26000"></div>
            </figure>
        </div>
    </section>

    <section id="osol28000" class="tab-content">
        <div class="detailing">
            <div class="small-title">OSOL 28000</div>
            <table>
                <thead>
                    <td class="col-mth header-depreciation">Rank</td>
                    <td class="col-mth header-depreciation">Negeri</td>
                    <td class="col-mth header-depreciation">Jumlah Peruntukan (RM)</td>
                    <td class="col-mth header-depreciation">Perbelanjaan (RM)</td>
                    <td class="col-mth header-depreciation">Baki (RM)</td>
                    <td class="col-mth header-depreciation">% Kewangan</td>
                </thead>
                <tbody>

                    @if(count($osol28)> 0)
                    
                    @foreach ($osol28 as $osolItem)
                    <tr>
                        <td class="row-item" style="text-transform:uppercase">{{$loop->index+1}}.</td>
                        <td class="row-item" style="text-transform:uppercase">{{$osolItem->state}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->total_allocation,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->carry_total_expense,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->balance,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{$osolItem->percent_financial}}%</td>
                    </tr>
                    @endforeach
                    @else 
                    <tr>
                        <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
                    </tr>
                    @endif
                </tbody>

                <tfoot>
                    @foreach ($osolSum28 as $osolItem)
                    <td class="row-item" colspan="2" style="text-transform:uppercase">TOTAL</td>
                    <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_total_allocation,2)}}</td>
                    <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->carry_total_expense,2)}}</td>
                    <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_balance,2)}}</td>
                    <td class="row-item" style="text-transform:uppercase">{{$osolItem->sum_percent_financial}}%</td>
                    @endforeach
                </tfoot>
            </table>

            <figure class="highcharts-figure">
                <div id="container_28000"></div>
            </figure>
        </div>
    </section>

    <section id="ranking" class="tab-content">
        <div class="detailing">
            <div class="small-title">Ranking Perbelanjaan</div>
            <table>
                <thead>
                    <td class="col-mth header-depreciation left">Rank</td>
                    <td class="col-mth header-depreciation left">OSOL 26000</td>
                    <td class="col-mth header-depreciation left">% OSOL 26000</td>
                    <td class="col-mth header-depreciation left">OSOL 28000</td>
                    <td class="col-mth header-depreciation left">% OSOL 28000</td>
                </thead>
                <tbody>
                    @foreach ($osol26 as $item)
                    <tr>
                        <td class="row-item" style="text-transform:uppercase">{{$loop->index+1}}.</td>
                        <td class="row-item" style="text-transform:uppercase">{{$item->state}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{$item->percent_financial}}%</td>
                        <td class="row-item" style="text-transform:uppercase">{{$osol28[$loop->index]->state}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{$osol28[$loop->index]->percent_financial}}%</td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
            <figure class="highcharts-figure">
                <div id="container_ranking_26000" style='margin-top:25px'></div>
                <div id="container_ranking_28000" style='margin-top:25px'></div>
            </figure>
        </div>
    </section>

    <section id="keseluruhan" class="tab-content">
        <div class="detailing">
            <div class="small-title">Keseluruhan</div>
            <table>
                <thead>
                    {{-- <td class="end"></td> --}}
                    <td class="col-mth header-depreciation left">Negeri</td>
                    <td class="col-mth header-depreciation left">Jumlah</td>
                    <td class="col-mth header-depreciation left">Perbelanjaan</td>
                    <td class="col-mth header-depreciation left">Baki</td>
                    <td class="col-mth header-depreciation left">% Perbelanjaan</td>
                    <td class="col-mth header-depreciation left">Target</td>
                    {{-- <td class="end"></td> --}}
                </thead>
                <tbody>

                    @if(count($osolTotal)> 0)
                    @foreach ($osolTotal['list_total'] as $osolItem)
                    <tr>
                        <td class="row-item" style="text-transform:uppercase">OSOL {{$osolItem->osol_value}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_total_allocation,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->carry_sum_total_expense,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_balance,2)}}</td>
                        <td class="row-item" style="text-transform:uppercase">{{number_format($osolItem->sum_percent_financial,2)}}%</td>
                        <td class="row-item" style="text-transform:uppercase">{{$mhpvTargetPercent}}%</td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <figure class="highcharts-figure">
                <div id="container_keseluruhan" style='margin-top:25px'></div>
            </figure>
        </div>
    </section>

</div>




<script type="text/javascript">
    $(document).ready(function() {

        //$('#latest_class').select2();
        initTab();
        $('.dropdown-item.month').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            location.replace('{{ route('report.report-mhpv-budget-expenditure-by-month') }}'+'?selectedYear={{$selectedYear}}&selectedMonth='+clickedItem);
	  	});

        $('.dropdown-item.year').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            location.replace('{{ route('report.report-mhpv-budget-expenditure-by-month') }}'+'?selectedYear='+clickedItem);

	  	});
    });



</script>
<script type="text/javascript">


    function getWarrantByYear(self){

        let year = $(self).data('year');
        $.get('{{route('maintenance.warrant.get-warrant')}}',{'year': year}, function(res){
            window.location.href = "{{route('report.report-mhpv-budget-expenditure-by-month')}}?selectedYear="+year;
        });

    }


    var sumAllocation26 = [];
    var sumExpense26 = [];
    var sumBalance26 = [];
    var listState26 = [];
    var percen26 = [];

    @foreach ($osol26 as $item)
    sumAllocation26.push({{$item->total_allocation}});
    sumExpense26.push({{$item->carry_total_expense}});
    sumBalance26.push({{$item->balance}});
    listState26.push('{{$item->state}}');
    percen26.push({{$item->percent_financial}});
    @endforeach

    var sumAllocation28 = [];
    var sumExpense28 = [];
    var sumBalance28 = [];
    var listState28 = [];
    var percen28 = [];

    @foreach ($osol28 as $item)
    sumAllocation28.push({{$item->total_allocation}});
    sumExpense28.push({{$item->carry_total_expense}});
    sumBalance28.push({{$item->balance}});
    listState28.push('{{$item->state}}');
    percen28.push({{$item->percent_financial}});
    @endforeach


    var sumTotalAllocation = [];
    var sumTotalExpense = [];
    var sumTotalBalance = [];

    @if(count($osolTotal)> 0)
    @foreach ($osolTotal['list_total'] as $item)
    sumTotalAllocation.push({{$item->sum_total_allocation}});
    sumTotalExpense.push({{$item->carry_sum_total_expense}});
    sumTotalBalance.push({{$item->sum_balance}});
    @endforeach
    @endif

	var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];
	Highcharts.chart('container_26000', {
        chart: {
            zoomType: 'xy',
            type : 'column',
            marginTop: 30
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: listState26,
            useHTML: true,
            crosshair: true,
            title: {
                text: '',
                style: {
                    color: '#5e7485'

                }
            },
            labels: {
                style: {
                    fontSize: '14px',
                    color: 'black'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: 'RM {value}',
                style: {
                    color: '#5e7485',
                    fontSize: '10px'
                }
            },
            title: {
                text: '',
                style: {
                    color: '#5e7485'
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        series: [{
                name: 'Jumlah Peruntukan',
                data: sumAllocation26,
                tooltip: {
                    valuePrefix: 'RM '
                }
            },
            {
                name: 'Perbelanjaan',
                data: sumExpense26,
                tooltip: {
                    valuePrefix: 'RM '
                }
            },
            {
                name: 'Baki',
                data: sumBalance26,
                tooltip: {
                    valuePrefix: 'RM '
                }
            }

        ]
    });

    Highcharts.chart('container_28000', {
        chart: {
            zoomType: 'xy',
            type : 'column',
            marginTop: 30
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: listState28,
            useHTML: true,
            crosshair: true,
            title: {
                text: '',
                style: {
                    color: '#5e7485'

                }
            },
            labels: {
                style: {
                    fontSize: '14px',
                    color: 'black'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: 'RM {value}',
                style: {
                    color: '#5e7485',
                    fontSize: '12px',
                }
            },
            title: {
                text: '',
                style: {
                    color: '#5e7485'
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        series: [{
                name: 'Jumlah Peruntukan',
                data: sumAllocation28,
                tooltip: {
                    valuePrefix: 'RM'
                }
            },
            {
                name: 'Perbelanjaan',
                data: sumExpense28,
                tooltip: {
                    valuePrefix: 'RM'
                }
            },
            {
                name: 'Baki',
                data: sumBalance28,
                tooltip: {
                    valuePrefix: 'RM'
                }
            }

        ]
    });

    Highcharts.chart('container_ranking_26000', {
        chart: {
            zoomType: 'xy',
            type : 'column',
            marginTop: 30
        },
        title: {
            text: 'Jumlah Perbelanjaan Mengikut Woksyop (26000)',
            margin: 50
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: listState26,
            useHTML: true,
            crosshair: true,
            title: {
                text: '',
                style: {
                    color: '#5e7485'

                }
            },
            labels: {
                style: {
                    fontSize: '14px',
                    color: 'black'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: '{value}%',
                style: {
                    color: '#5e7485',
                    fontSize: '12px',
                }
            },
            title: {
                text: '',
                style: {
                    color: '#5e7485'
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        series: [{
                name: 'Peratusan (%) Perbelanjaan',
                data: percen26,
                tooltip: {
                    valueSuffix: ' %'
                }
            }

        ]
    });

    Highcharts.chart('container_ranking_28000', {
        chart: {
            zoomType: 'xy',
            type : 'column',
            marginTop: 30
        },
        colors: ['green', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
        title: {
            text: 'Jumlah Perbelanjaan Mengikut Woksyop (28000)',
            margin: 50,
            style:{
                fontSize:'18px',
                fontWeight: 'bold'
            }
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: listState28,
            useHTML: true,
            crosshair: true,
            title: {
                text: '',
                style: {
                    color: '#5e7485'

                }
            },
            labels: {
                style: {
                    fontSize: '14px',
                    color: 'black'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: '{value}%',
                style: {
                    color: '#5e7485',
                    fontSize: '12px',
                }
            },
            title: {
                text: '',
                style: {
                    color: '#5e7485'
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        series: [{
                name: 'Peratusan (%) Perbelanjaan',
                data: percen28,
                tooltip: {
                    valueSuffix: ' %'
                },
                style: {
                    color: 'red'
                }
            }

        ]
    });

    Highcharts.chart('container_keseluruhan', {
        chart: {
            zoomType: 'xy',
            type : 'column',
            marginTop: 30
        },
        colors: ['grey', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
        title: {
            text: 'Jumlah Perbelanjaan Keseluruhan',
            margin: 50,
            style:{
                fontSize:'18px',
                fontWeight: 'bold'
            }
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['OSOL 26000','OSOL 28000'],
            useHTML: true,
            crosshair: true,
            title: {
                text: '',
                style: {
                    color: '#5e7485'

                }
            },
            labels: {
                style: {
                    fontSize: '14px',
                    color: 'black'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: 'RM {value}',
                style: {
                    color: '#5e7485',
                    fontSize: '12px',
                }
            },
            title: {
                text: '',
                style: {
                    color: '#5e7485'
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
            shadow: true
        },
        series: [{
                name: 'Jumlah Peruntukan',
                data: sumTotalAllocation,
                tooltip: {
                    valuePrefix: 'RM '
                }
            },
            {
                name: 'Perbelanjaan',
                data: sumTotalExpense,
                tooltip: {
                    valuePrefix: 'RM '
                }
            },
            {
                name: 'Baki',
                data: sumTotalBalance,
                tooltip: {
                    valuePrefix: 'RM '
                }
            }

        ]
    });





</script>
<script type="text/javascript">

</script>
</body>
