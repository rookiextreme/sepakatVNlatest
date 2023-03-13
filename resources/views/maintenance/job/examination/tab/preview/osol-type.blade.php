@php
    $tab = Request('tab') ? Request('tab') : 1;
    $osol_type_code = Request('osol_type_code') ? Request('osol_type_code') : null;
    $selectedYear = Request('selectedYear') ? Request('selectedYear') : date('Y');
    
@endphp
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
        text-align: center;
        font-family: mark-bold;

        color:black;
        font-size: 11px;
        padding : 5px;
        padding-left: 8px;
        padding-right: 8px;

    }

    .header-depreciation.left{

        text-align: left;
        padding-left: 8px;

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

    .table-item{
        font-family: mark;
        font-size: 11px;
        background-color: white;
        border:1px solid lightgray;
        text-align: center;
        padding:10px;


    }

    .table-item.main{
        font-family: mark-bold;
        font-size: 11px;
        text-align: left;
        background-color: lightgray;
    }

    .footer-table{

        background-color:#3f464b;
        padding-top: 10px;
        padding-bottom: 10px;
        color:white;
    }

    .footer-table.main{
        text-align: left;
        font-family: 'mark-bold';
        background-color:#3f464b;
    }
    .small-title{

        font-size: 14px !important;
    }
</style>
</head>
<body class="content">

    <div class="mt-2 pt-2"></div>
    
    <div class="dropdown inline" style="display: inline;">
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-calendar"></i>
            {{$selectedYear}}
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">Tahun</h6></li>
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
            <li><h6 class="dropdown-header">tahun</h6></li>
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
            <li><a class="dropdown-item month"  xvalue="11" {{ $selectedMonth == 12 ? 'style=background-color:lightgrey': ''}}>Desember</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            @switch($osol_type_code)
                @case('01')
                    @include('maintenance.warrant.tab.mhpv-osol-26000', [
                        'is_preview' => $is_preview
                    ])
                    @break
                @case('02')
                    @include('maintenance.warrant.tab.mhpv-osol-28000', [
                         'is_preview' => $is_preview
                    ])
                    @break
                @default
                    
            @endswitch
        </div>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>


    <script>

        const getWarrantByYear = function(self){

            parent.startLoading();

            let year = $(self).data('year');
            let url = '{{route('maintenance.job.vehicle.getVehicleForm.research.market.OsolType')}}';

            window.location.href = url+"?osol_type_code={{$osol_type_code}}&selectedYear="+year;
            
        }

        $(document).ready(function(){
            parent.stopLoading();

            $('.dropdown-item.month').click(function(e){
                var clickedItem = $(this).attr('xvalue');
                location.replace('{{ route('maintenance.job.vehicle.getVehicleForm.research.market.OsolType') }}'+'?osol_type_code={{$osol_type_code}}&selectedYear={{$selectedYear}}&selectedMonth='+clickedItem);
            });

        });
    </script>

</body>

</html>
