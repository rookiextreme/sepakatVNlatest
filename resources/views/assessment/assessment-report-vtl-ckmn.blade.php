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
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">

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

    .footer-divider {
        height: 120px;
    }

    .cux-btn.bigger {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .thead-overflow {
        position: fixed;
        top: 162px;
        width: calc(100vw - 65px);
        display: inline-table;
        background-color: white;
    }

    @media (max-width: 575.98px) {
        .sect-top-dummy {
            height: 100px;
        }
    }

</style>
<script type="text/javascript">

</script>
</head>

@php

    $grandTotal = 0;

@endphp

<body class="content">
<div class="sect-top">
    <div class="mytitle">Penilaian <span>PEMERIKSAAN KESELAMATAN & PRESTASI KENDERAAN JKR (PERSEKUTUAN DAN NEGERI) TAHUN {{\Carbon\Carbon::now()->format('Y')}}</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.admin.dashboard') }}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('assessment.report')}}');">Laporan &amp; Analisis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ringkasan Bulanan Mengikut CKMN (Tahun Semasa)</li>
        </ol>
    </nav>

</div>
<div class="sect-top-dummy"></div>
<div class="main-content">

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="row">
                {{-- <div class="col-md-3">
                    <label for="" class="form-label">Tahun</label>
                    <select name="year" class="select" id="year">
                        @for ($i = 1; $i < 10; $i++)
                            <option value="{{$i}}" {{$year_back_limit == $i ? 'selected': ''}}> {{$i}} Tahun Kebelakang</option>
                        @endfor
                    </select>
                </div> --}}
                <div class="col-md-2">
                    <label for="" class="form-label">Muat Turun</label>
                    <div class="btn-group">
                        <a class="btn cux-btn bigger" href="{{route('report.report.assessment.export.excel', ['view' => 'report_vtl_ckmn', 'is_report' => true, 'year' => $year_selected, 'year_back_limit' => $year_back_limit])}}"> <i class="fa fa-file-export"></i> Excel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $overall_percentage_assessment_compeleted = 0.0;
        $overall_total_fleet = 0.0;
        $overall_total_assessment = 0.0;
    @endphp
    <div class="table-responsive">
        <table class="table table-bordered table-custom no-footer" style="width: 100%;">
            <thead>
                <tr>
                    <th style="vertical-align: middle; text-align: center;">Bil</th>
                    <th style="vertical-align: middle; text-align: center;">CAWANGAN KEJURUTERAAN MEKANIKAL</th>
                    <th style="vertical-align: middle; text-align: right;">JUMLAH KENDERAAN PERSEKUTUAN & NEGERI</th>
                    <th style="vertical-align: middle; text-align: right;">JUMLAH PENILAIAN SELESAI</th>
                    <th style="vertical-align: middle; text-align: right;">PERATUS SELESAI (%)</th>
                </tr>
            </thead>
            <tbody>
                @if (count($list) > 0)
                    @foreach ($list as $index => $branch)
                        @php
                            $percentage_assessment_compeleted = 0.0;
                            if(isset($branch['total_assessment'])){
                                if($branch['total_assessment'] && $branch['total_assessment'] != 0 && $branch['total_fleet'] != 0){
                                    $overall_total_fleet += $branch['total_fleet'];
                                    $overall_total_assessment += $branch['total_assessment'];
                                    $percentage_assessment_compeleted = ($branch['total_assessment'] / $branch['total_fleet']) * 100;
                                }
                            }

                            $overall_percentage_assessment_compeleted += $percentage_assessment_compeleted;
                        @endphp
                        <tr>
                            <td style="border=2;">{{$index + 1}}</td>
                            <td style="border=2;">{{$branch['name']}}</td>
                            <td class="text-end" style="border=2;">{{isset($branch['total_fleet']) ? $branch['total_fleet'] : 0}}</td>
                            <td class="text-end" style="border=2;">{{isset($branch['total_assessment']) ? $branch['total_assessment'] : 0}}</td>
                            <td class="text-end" style="border=2;">{{$percentage_assessment_compeleted}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="border=2;">Jumlah</td>
                        <td class="text-end" style="border=2;">{{$overall_total_fleet}}</td>
                        <td class="text-end" style="border=2;">{{$overall_total_assessment}}</td>
                        <td class="text-end" style="border=2;">{{$overall_percentage_assessment_compeleted}}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="4">Tiada Rekod</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="footer-divider"></div>

</div>

<script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        initTab();
        let url = "{{route('assessment.report.vtl_ckmn')}}";

        $('#year').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            let year_back_limit = this.value;
            parent.openPgInFrame(url+"?year_back_limit="+year_back_limit);
        });
    });

</script>
</body>
