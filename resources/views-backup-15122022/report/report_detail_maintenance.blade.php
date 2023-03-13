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
        border-bottom-color:black;
        border-bottom-width:1px;
        border-bottom-style: solid;
        height:40px;
        padding:5px;
        font-size: 12px !important;
        vertical-align: middle !important;

    }

    thead td.col-mth {
        font-family: mark;
        color:#1b1b1b;
        font-size:14px;
        border-bottom-width:3px;
        vertical-align: bottom;
        border:1px solid black;
        text-align: center;
        padding-right:5px;
    }
    .col-focus {
        min-width: 70px;
        vertical-align: middle;
        text-align: center;
        padding-right:5px;
        border-right-color: black;
        border-right-width:1px;
        border-right-style: solid;
        border-bottom:1px solid rgba(0, 0, 0, 0.1);
        font-size:12px;
        font-family: mark;
        padding:5px;
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
        font-size:12px;
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

    .purple{

        background-color: purple;
        color:white !important;

    }

    .red{

    background-color: red;
    color:white !important;

    }

    .blue-green{

        background-color:#558CA8;
        color:white !important;
    }

    @media print {
        @page {
            size: 'A4' portrait; /* auto is default portrait; */

        }

        .pagebreak { page-break-before: always; }

        .no-printme  {
            display: none;
        }
        .printme  {
            display: block;
        }
        .body,.content {
            background: transparent;
        }
        .box-info {
            border: none;
            height: 30px;
        }

        .rlabel, .mytext {
            line-height: unset;
        }

        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
        }

    }
</style>
<script type="text/javascript">
    var eachMonthTotal = [];
    var differences = [];

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
<div class="sect-top no-printme">
    <div class="mytitle">Pemeriksaan & Penyenggaraan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('maintenance.report')}}')">Laporan & Statistik</a></li>
        <li class="breadcrumb-item active" aria-current="page">Perincian Kerja Mengikut Kategori</li>
        </ol>
    </nav>
    <div class="dropdown inline" style="display: inline;">
        <div class="btn-group" role="group">
            <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                {{$selectedYear}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @foreach ($listYear as $yearItem)
                <li><a class="dropdown-item year" data-year="{{$yearItem}}" onclick="getWarrantByYear(this)" xvalue={{$yearItem}} {{ $selectedYear == $yearItem ? 'style=background-color:lightgrey': ''}}>{{$yearItem}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="btn-group" role="group">
            <a class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                &nbsp;&nbsp;{{$selectedMonth}}&nbsp;&nbsp;
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><h6 class="dropdown-header">BULAN</h6></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="1" {{ $selectedMonth == 1 ? 'style=background-color:lightgrey': ''}}>Januari</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="2" {{ $selectedMonth == 2 ? 'style=background-color:lightgrey': ''}}>Februari</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="3" {{ $selectedMonth == 3 ? 'style=background-color:lightgrey': ''}}>Mac</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="4" {{ $selectedMonth == 4 ? 'style=background-color:lightgrey': ''}}>April</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="5" {{ $selectedMonth == 5 ? 'style=background-color:lightgrey': ''}}>Mei</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="6" {{ $selectedMonth == 6 ? 'style=background-color:lightgrey': ''}}>Jun</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="7" {{ $selectedMonth == 7 ? 'style=background-color:lightgrey': ''}}>Julai</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="8" {{ $selectedMonth == 8 ? 'style=background-color:lightgrey': ''}}>Ogos</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="9" {{ $selectedMonth == 9 ? 'style=background-color:lightgrey': ''}}>September</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="10" {{ $selectedMonth == 10 ? 'style=background-color:lightgrey': ''}}>Oktober</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="11" {{ $selectedMonth == 11 ? 'style=background-color:lightgrey': ''}}>November</a></li>
                <li><a class="dropdown-item month" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate')}}')" xvalue="12" {{ $selectedMonth == 12 ? 'style=background-color:lightgrey': ''}}>Disember</a></li>
            </ul>
        </div>

        <div class="dropdown inline" style="display: inline;">
            <span class="btn cux-btn bigger dropdown-toggle dd-workshop" xvalue="{{$selectedWorkshopId}}" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                {{$selectedWorkshop}}
            </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><h6 class="dropdown-header"></h6></li>
                @foreach ($listWorkshop as $item)
                <li><a class="dropdown-item workshop"  valueId="{{$item->id}}" xvalue={{$item->desc}} {{ $selectedWorkshop == $item->desc ? 'style=background-color:lightgrey': ''}} onclick='change'>{{$item->desc}}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="dropdown inline" style="display: inline;">
            <span class="btn cux-btn bigger dropdown-toggle text-uppercase" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                {{$repair_method_desc}}
            </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><h6 class="dropdown-header">Jenis Perkhidmatan</h6></li>
                <li><a class="dropdown-item text-uppercase {{!$repair_method ? 'active' : ''}}" 
                    href={{route('report.report_detail_maintenance', ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth, 'repair_method' => null])}}
                    >Semua</a></li>
                <li><a class="dropdown-item text-uppercase {{$repair_method == 1 ? 'active' : ''}}" 
                    href={{route('report.report_detail_maintenance', ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth, 'repair_method' => 1])}}
                    >Perkhidmatan & Bekalan</a></li>
                <li><a class="dropdown-item text-uppercase {{$repair_method == 2 ? 'active' : ''}}"
                    href={{route('report.report_detail_maintenance', ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth, 'repair_method' => 2])}}
                    >Perkhidmatan</a></li>
                <li><a class="dropdown-item text-uppercase {{$repair_method == 3 ? 'active' : ''}}"
                    href={{route('report.report_detail_maintenance', ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth, 'repair_method' => 3])}}
                    >Bekalan</a></li>
            </ul>
        </div>

        <div class="dropdown inline" style="display: inline;">
            <span class="btn cux-btn bigger dropdown-toggle text-uppercase" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                {{$selectedCustomer}}
            </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><h6 class="dropdown-header">Pelanggan</h6></li>
                <li><a class="dropdown-item text-uppercase {{!$customer_id ? 'active' : ''}}"
                    href={{route('report.report_detail_maintenance', ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth, 'repair_method' => $repair_method, 'customer_id' => null])}}
                    >Semua</a>
                </li>
                @foreach ($listCustomer as $customer)
                <li><a class="dropdown-item text-uppercase {{$customer_id == $customer->customer_id ? 'active' : ''}}"
                    href={{route('report.report_detail_maintenance', ['selectedYear' => $selectedYear, 'selectedMonth' => $selectedMonth, 'repair_method' => $repair_method, 'customer_id' => $customer->customer_id])}}
                    >{{$customer->desc}}</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="btn-group">
            <div class="btn-group" role="group">
                <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
            </div>
        </div>

        <div class="d-inline">
            <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel()" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel fa-lg" style="margin-top:2px"></i> </a>
        </div>

    </div>
</div>
<br/>
<div class="sect-top-dummy"></div>
<div class="main-content">


    <section id="perincian" class="tab-content">
        <div class="detailing" style='max-width: fit-content;overflow-x:scroll'>
            <div class="col-md-12">
                <div class="btn-group d-none d-md-inline-flex btn-scoller">
                    <button type="button" class="btn cux-btn small" onclick="scrollToLeft('perincian-scroller')"><i class="fa fa-arrow-left"></i></button>
                    <button type="button" class="btn cux-btn small" onclick="scrollToRight('perincian-scroller')"><i class="fa fa-arrow-right"></i></button>
                </div>
            </div>

            {{-- <div class="small-title mb-4">Prestasi Penyenggaraan Berkala</div> --}}
            <div class="overflow-auto" id="perincian-scroller">
                <table class="" style="width: 100%">
                <thead style='border-bottom:2px solid black'>
                    <td class='small-title' style='border-left:2px solid white;border-top:2px solid white' colspan='12'>{{$selectedWorkshop}}  BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</td>
                </thead>
                <thead style='border-bottom:2px solid black'>

                    <td class="col-mth purple">Bil.</td>
                    <td class="col-mth purple" style='min-width:200px !important;'>Nama Syarikat</td>
                    <td class="col-mth purple">Perkhidmatan / Bekalan</td>
                    <td class="col-mth purple" style='min-width:100px !important;'>Kenderaan</td>
                    <td class="col-mth purple" style='min-width:100px !important;'>Jenis Kenderaan</td>
                    <td class="col-mth purple" style='min-width:200px !important;'>Pelanggan</td>
                    <td class="col-mth purple" style='min-width:300px !important;'>Perihal Kerja</td>
                    <td class="col-mth purple">Bulan</td>
                    <td class="col-mth purple">Amaun (RM)</td>
                    <td class="col-mth purple">PJM</td>
                    <td class="col-mth purple">Servis / Pembaikan</td>
                    <td class="col-mth purple" style='border-right:2px solid black;'>Peruntukan</td>
                </thead>
                <tbody>

                    @if(count($listReport)> 0)
                        @foreach ($listReport as $item)
                        <tr>
                            <td class="col-focus ">{{$loop->index+1}}</td>
                            <td class="col-focus ">{{$item->company_name}}</td>
                            <td class="col-focus ">{{$item->company_servis}}</td>
                            <td class="col-focus ">{{$item->plate_no}}</td>
                            <td class="col-focus ">{{$item->vehicle_type}}</td>
                            <td class="col-focus ">{{$item->customer}}</td>
                            <td class="col-focus ">{{$item->work_detail}}</td>
                            <td class="col-focus ">{{$item->month}}</td>
                            <td class="col-focus ">{{$item->amount}}</td>
                            <td class="col-focus ">{{$item->pjm_name}}</td>
                            <td class="col-focus ">{{$item->maintenance_type}}</td>
                            <td class="col-focus ">{{$item->warrant_type}}</td>
                        </tr>

                        @endforeach
                    @else
                    <tr>
                        <td class="col-focus " colspan='12'>Tiada Maklumat</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            </div>
        </div>

    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('.dropdown-item.year').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            location.replace('{{ route('report.report_detail_maintenance') }}'+'?selectedYear='+clickedItem);

	  	});

        $('.dropdown-item.month').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            location.replace('{{ route('report.report_detail_maintenance') }}'+'?selectedYear={{$selectedYear}}&selectedMonth='+clickedItem);
	  	});

        $('.dropdown-item.workshop').click(function(e){
            id = $(this).attr('valueId');
            var test = $('.dd-workshop').attr('xvalue',id);
            location.replace('{{ route('report.report_detail_maintenance') }}'+'?selectedYear={{$selectedYear}}&selectedMonth={{$selectedMonth}}&selectedWorkshopId='+id);

        });


    });


    function downloadExcel(){

    var title = "{{$selectedWorkshop}}  BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}";
    $.ajax({
        url:"{{route('report.report_detail_maintenance_export.excel')}}",
        data: {
            'selectedMonth': {{$selectedMonth}},
            'selectedYear': {{$selectedYear}},
            'selectedWorkshop': "{{$selectedWorkshop}}",
            'selectedWorkshopId': {{$selectedWorkshopId}}
        },
        cache:false,
        xhrFields:{
            responseType: 'blob'
        },
        success: function(result, status, xhr){
            var disposition = xhr.getResponseHeader('content-disposition');
            var matches = /"([^"]*)"/.exec(disposition);

            var filename = (matches != null && matches[1] ? matches[1] : ''+title+'.xlsx');

            // The actual download
            var blob = new Blob([result], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = filename;

            document.body.appendChild(link);

            link.click();
            document.body.removeChild(link);
        },
        error:function(){

        }
    });
    }


</script>
<script type="text/javascript">
</script>
<script type="text/javascript">

</script>
</body>

