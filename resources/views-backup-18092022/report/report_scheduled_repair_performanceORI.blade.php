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
        border:1px solid #cdcdcd;
        text-align: right;
        padding-right:5px;
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

</script>
</head>



<body class="content">
<div class="sect-top">
    <div class="mytitle">Pemeriksaan & Penyenggaraan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('maintenance.report')}}')">Laporan & Statistik</a></li>
        <li class="breadcrumb-item active" aria-current="page">Prestasi Pembaikan</li>
        </ol>
    </nav>


    <div class="dropdown inline" style="display: inline;">
        <div class="btn-group">
            <div class="btn-group" role="group">
                <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>

            </div>

        </div>

    </div>
</div>
<br/>
<div class="sect-top-dummy"></div>
<div class="main-content">


    <section id="perincian" class="tab-content">
        <div class="detailing" style='max-width: fit-content;'>
            {{-- <div class="small-title mb-4">Prestasi Pembaikan</div> --}}
            <table style='border:2px solid grey;'>
                <thead style='border-bottom:2px solid grey'>
                    {{-- <td class="end"></td> --}}
                    <td class='small-title' style='border-left:2px solid white;border-top:2px solid white'>Prestasi Pembaikan</td>
                    {{-- <td class="row-item" style=';border-right:2px solid grey;font-family:mark-bold;text-align:right;vertical-align:bottom;padding-right:5px' rowspan='2'>KOMPONEN</td> --}}
                    <td class="col-mth JAN" style='text-align:center;border:2px solid grey' colspan='13'>Bilangan Mengikut Bulan</td>

                    {{-- <td class="end"></td> --}}
                </thead>
                <thead style='border-bottom:2px solid grey'>
                    {{-- <td class="end"></td> --}}
                    <td class="row-item" style=';border-right:2px solid grey;font-family:mark-bold;text-align:right;vertical-align:bottom;padding-right:5px' rowspan='2'>KOMPONEN</td>

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
                    <td class="col-mth DIS" style='border-left:2px solid grey'>Total</td>
                    {{-- <td class="end"></td> --}}
                </thead>


                @php

                    $component = ["Overhaul","Engine","Suspension & Handling", "Brake", "Transmission", "Electronics","A/C", "Tyre", "Hydraulics","Body", "Others"];

                @endphp
                <tbody>
                    @foreach ($component as $item)
                    <tr>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px'>{{$item}}</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link ">0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    @endforeach
                    <tr style='border:2px solid grey'>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;font-family:mark-bold;border-right:2px solid grey;padding-right:5px'>Jumlah Pembaikan</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link " style='font-family:mark-bold'>0</td>
                        @endfor
                        <td class="col-focus link " style='font-family:mark-bold;border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    <tr style='height:20px;'>
                    </tr>


                    <tr style='border-top:2px solid grey'>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px'>Jumlah Pembaikan secara Dalaman</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link " style='background-color:yellow'>0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey;background-color:yellow'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    <tr>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px;'>Jumlah Pembaikan di Luar</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link ">0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    <tr style='border-bottom:2px solid grey'>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px;font-family:mark-bold'>Peratus Pembaikan secara Dalaman</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link ">0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>

                    <tr style='height:20px;'>
                    </tr>

                    <tr style='border-top:2px solid grey'>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px'>Jumlah Penyenggaraan</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link " style='background-color:yellow'>0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey;background-color:yellow'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    <tr>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px;'>Jumlah Penyenggaraan secara Dalaman</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link ">0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    <tr>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px;'>Jumlah Penyenggaraan di Luar</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link ">0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>
                    <tr style='border-bottom:2px solid grey'>
                        {{-- <td class="end thin-underline"></td> --}}
                        <td class="row-item thin-underline" style='text-align:right;border-right:2px solid grey;padding-right:5px;font-family:mark-bold'>Peratus Pembaikan secara Dalaman</td>

                        @for ($i = 0; $i<12; $i++)

                        <td class="col-focus link ">0</td>
                        @endfor
                        <td class="col-focus link "  style='border-left:2px solid grey'>0</td>

                        {{-- <td class="end"></td> --}}
                    </tr>


                </tbody>
            </table>
        </div>

    </section>
</div>
<script type="text/javascript">
    $(document).ready(function() {


    });


</script>
<script type="text/javascript">





</script>
<script type="text/javascript">

</script>
</body>
