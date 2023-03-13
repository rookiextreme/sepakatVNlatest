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
    $yearList = [];
    $monthList = [];

    $yearRange = range(date('Y') - 10, date('Y'));

    foreach ($yearRange as $key) {
        array_push($yearList,$key);
    }

    for ($i=1; $i <= 12; $i++) { 
        array_push($monthList,str_pad($i, 2, '0', STR_PAD_LEFT));
    }

@endphp

<body class="content">
<div class="sect-top">
    <div class="mytitle">Penilaian <span>Senarai Pemeriksaan (Keseluruhan)</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.admin.dashboard') }}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('assessment.report')}}');">Laporan &amp; Analisis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Senarai Pemeriksaan (Keseluruhan)</li>
        </ol>
    </nav>

</div>
<div class="sect-top-dummy"></div>
<div class="main-content">

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <label for="" class="form-label">Penilaian</label>
                    <select name="assessment_type" class="select" id="assessment_type">
                        <option value="">[Semua]</option>
                        @foreach ($assessmentTypeList as $assessmentType)
                            <option value="{{$assessmentType->code}}" {{$assessment_selected_code == $assessmentType->code ? 'selected': ''}}>{{$assessmentType->desc}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Tahun</label>
                    <select name="year" class="select" id="year">
                        <option value="">[Semua]</option>
                        @foreach (array_reverse($yearList) as $year)
                            <option value="{{$year}}" {{$year_selected == $year ? 'selected': ''}}>Tahun {{$year}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="" class="form-label">Bulan</label>
                    <select name="month" class="select" id="month">
                        <option value="">[Semua]</option>
                        @foreach (array_reverse($monthList) as $index => $month)
                            <option value="{{$month}}" {{$month_selected == $month ? 'selected': ''}}>Bulan {{(int)$month}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="" class="form-label">Muat Turun</label>
                    <div class="btn-group">
                        <a class="btn cux-btn bigger" href="{{route('report.report.assessment.export.excel', ['view' => 'report_assessment_examination', 'is_report' => true, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected])}}"> <i class="fa fa-file-export"></i> Excel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table-custom stripe no-footer" style="width: 100%">
            <thead>
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-left">JKR Woksyop</th>
                    <th class="text-left">Jenis Penilaian</th>
                    <th class="text-left">Jenis Kenderaan</th>
                    <th class="text-left">Model</th>
                    <th class="text-left">No. Pendaftaran</th>
                    <th class="text-left">Kementerian</th>
                    <th class="text-left">Agensi Lain</th>
                    <th class="text-left">Pemohon</th>
                    <th class="text-center">Tarikh Mohon</th>
                    <th class="text-center">Tarikh Periksa</th>
                    <th class="text-center">Kaedah Penilaian</th>
                    <th class="text-center">Status Penilaian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $key)
                    <tr>
                        <td>{{($index + 1) + $offset}}</td>
                        <td>{{$key->workshop_name}}</td>
                        <td>{{$key->assessment_name}}</td>
                        <td>{{$key->v_type_name}}</td>
                        <td>{{$key->model_name}}</td>
                        <td>{{$key->plate_no}}</td>
                        <td>{{$key->ministry_name}}</td>
                        <td>{{$key->department_name}}</td>
                        <td>{{$key->applicant_name}}</td>
                        <td class="text-center">{{\Carbon\Carbon::parse($key->created_at)->format('d/m/Y')}}</td>
                        <td class="text-center">{{$key->foremen_dt ? \Carbon\Carbon::parse($key->foremen_dt)->format('d/m/Y') : '-'}}</td>
                        <td class="text-center">{{$key->assessment_method}}</td>
                        <td class="text-center">{{$key->app_status}}</td>
                    </tr>
                @endforeach
                @if(count($list) == 0)
                    <tr class="no-record">
                        <td colspan="13" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                    </tr>
                @endif
                {{-- <tr>
                    <td colspan="13">
                        <div class="float-start ps-2">
                            <div class='btn-group'>
                                <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => 0, 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{$offset == 0 ? "disabled":""}} >Pertama</button>
                                <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => ($offset-$limit), 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{$offset == 0 ? "disabled":""}} >Sebelum</button>
                                <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => ($offset+$limit), 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{$offset+$limit > $total ? "disabled":""}}>Selepas</button>
                                <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => (round($total/$limit) - 1) * $limit, 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{ ($offset + $limit) > $total ? "disabled":""}} >Akhir</button>
                            </div>
                            <span class='nav-text'>Dari {{($offset+1)}} Hingga {{$total<($offset+$limit) ? $total : ($offset+$limit) }} daripada {{$total}}</span>
                        </div>
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
    @if($total > 0)
            <div style='margin-top:0px;margin-bottom:10px'>
                <div class="float-start">
                    <span class='nav-text'>Dari {{($offset+1)}} Hingga {{$total<($offset+$limit) ? $total : ($offset+$limit) }} daripada {{$total}}</span>
                </div>
                <div class="float-end">
                    <div class='btn-group'>
                        <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => 0, 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{$offset == 0 ? "disabled":""}} >Pertama</button>
                        <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => ($offset-$limit), 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{$offset == 0 ? "disabled":""}} >Sebelum</button>
                        <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => ($offset+$limit), 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{$offset+$limit > $total ? "disabled":""}}>Selepas</button>
                        <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('assessment.report.overall', ['offset' => ((int)($total/$limit)) * $limit, 'limit' => $limit, 'assessment_type_code' => $assessment_selected_code, 'year' => $year_selected, 'month' => $month_selected ])}}')" {{ ($offset + $limit) > $total ? "disabled":""}} >Akhir</button>
                    </div>
                </div>
            </div>
        @endif
    <div class="footer-divider"></div>

</div>

<script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        initTab();
        let url = "{{route('assessment.report.overall')}}";

        $('#assessment_type').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            let assessment_type = this.value;
            let year = $('#year').val();
            let month = $('#month').val();
            parent.openPgInFrame(url+"?year="+year+"&month="+month+"&assessment_type_code="+assessment_type);
        });

        $('#year').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            let assessment_type = $('#assessment_type').val();
            let year = this.value;
            let month = $('#month').val();
            parent.openPgInFrame(url+"?year="+year+"&month="+month+"&assessment_type_code="+assessment_type);
        });
        $('#month').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            let assessment_type = $('#assessment_type').val();
            let year = $('#year').val();
            let month = this.value;
            parent.openPgInFrame(url+"?year="+year+"&month="+month+"&assessment_type_code="+assessment_type);
        });
    });

</script>
</body>
