@php
    $tab = Request('tab') ? Request('tab') : 1;
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

<link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">

<script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

{{--  lodash plugin  --}}
<script src="{{asset('my-assets/plugins/lodash/core.js')}}"></script>

<style type="text/css">
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px;
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
        height: 40px;
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

    button.edit-add-item-adjustment {
        padding-top: 0px;
        padding-bottom: 0px;
        font-size: 12px;
    }

    @media print {
        @page {
            size: landscape; /* auto is default portrait; */
            margin: 10px;
        }

        #container-osol-260-state, #container-osol-280-state, #container-osol-mhpv-state, #container-kkr-state, #container-agency-state, #container-unjuran-main {
            width: 15%;
        }

        #container-osol-260, #container-osol-280, #container-osol-mhpv, #container-kkr, #container-agency, #container-unjuran {
            width: 85%;
        }

        .row-item.table-item.main {
            font-size: 10px;
        }

        .row-item.table-item {
            min-width: 20px;
        }

        .header-depreciation {
            height: 50px;
        }

        .col-mth.header-depreciation {
            font-size: 8px;
        }

        .label_state {
            height: 100px !important;
        }

        .label_unjuran {
            height: 40px !important;
        }

        .edit-add-item-mhpv:nth-child(1) {
            height: 30px;
        }

        .edit-add-item-mhpv:nth-child(2) {
            display: none;
        }

        .edit-add-item-adjustment {
            display: none;
        }

        .edit-add-item-projection {
            display: none;
        }

        .table-item {
            padding: 3px;
            height: 40px;
        }

        .btn-scoller {
            display: none !important;
        }

        .pagebreak { page-break-before: always; }

        .no-printme  {
            display: none !important;
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
<div id="response" class="alert alert-spakat response-toast" role="alert"></div>
<div class="sect-top no-printme">
    <div class="mytitle">Penyenggaraan <span>Agihan Waran</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.admin.dashboard') }}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Agihan Waran</a></li>
            {{-- <li class="breadcrumb-item active" aria-current="page">Jadual Susut Nilai</li> --}}
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
        <span class="btn cux-btn bigger" onClick="printMe()"> <i class="fal fa-print"></i> Cetak</span>
    </div>
    <div class="d-inline">
        <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel()" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel fa-lg" style="margin-top:2px"></i> </a>
    </div>
</div>
<br/>
<div class="sect-top-dummy"></div>
<div class="main-content">
    <div class="quick-navigation no-printme" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab" onClick="goTab(this, 'mhpv');" id="tab1">MHPV</li>
                <li class="cub-tab" onClick="goTab(this, 'kkr');" id="tab2">KKR</li>
                <li class="cub-tab" onClick="goTab(this, 'agensiluar');" id="tab3">AGENSI LUAR</li>
                <li class="cub-tab" onClick="goTab(this, 'unjuran');" id="tab4">UNJURAN</li>
                <li class="cub-tab" onClick="goTab(this, 'penyata');" id="tab5">PENYATA PERBELANJAAN</li>
            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>


    <section id="mhpv" class="tab-content">
        @include('maintenance.warrant.tab.mhpv')
    </section>

    <section id="kkr" class="tab-content">
        @include('maintenance.warrant.tab.kkr')
    </section>

    <section id="agensiluar" class="tab-content">
        @include('maintenance.warrant.tab.agency-luar')
    </section>

    <section id="unjuran" class="tab-content">
        @include('maintenance.warrant.tab.unjuran-osol')
    </section>

    <section id="penyata" class="tab-content">
        @include('maintenance.warrant.tab.penyata-perbelanjaan')
    </section>

</div>

{{-- VIEW Kemaskini Maklumat Peruntukan START--}}

<div class="modal fade" id="divUpdateInfoWarrant" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Kemaskini Maklumat Peruntukan
        </div>
        <div class="modal-body">
            <form id='divUpdateInfoWarrantForm'>
                <input type='hidden' id='warrant-id' name='' value=''/>
                <input type='hidden' id='warrant-total-allocation' name='' value=''/>
                <input type='hidden' id='warrant-workshop-id' name='' value=''/>
                <input type='hidden' id='text-carry-addition' name='' value=''/>
                <input type='hidden' id='text-carry-deduct' name='' value=''/>
                <input type='hidden' id='warrant-type-id' name='' value=''/>
                <input type='hidden' id='osol-type-id' name='' value=''/>
                <div class='row'>
                    <div class='col-sm-6 col-12'>
                        <div class="form-group">
                            <label id="label-state" for="" class="form-label text-dark" ></label>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark" >PERUNTUKAN (RM) </label>
                            <input type='hidden' id='default-text-allocation' value=''/>
                            <input onkeyup="changeValue('allocation',this.value)" type="text" class="form-control numbers-only" id='text-allocation' style='text-align:right' value='0'>

                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">TAMBAHAN (RM) </label>
                            <input type='hidden' id='default-text-addition' value=''/>
                            <input onkeyup="changeValue('addition',this.value)" type="text" class="form-control numbers-only" id='text-addition' style='text-align:right' value='0'>

                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">TARIK BALIK (RM) </label>
                            <input type='hidden' id='default-text-deduct' value=''/>
                            <input onkeyup="changeValue('deduct',this.value)" type="text" class="form-control numbers-only" id='text-deduct' style='text-align:right' value='0'>

                        </div>
                        <div class="form-group" id='respondMsg'>
                            <label for="" class="form-label "></label>
                        </div>
                    </div>
                    <div class='col-sm-6 col-12'>
                        <div class="form-group">
                            <label for="" class="form-label text-dark" ></label>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark" >(+) PERUNTUKAN (RM) </label>
                            <input onkeyup="addValue('allocation',this.value)" type="text" class="form-control numbers-only" id='text-add-allocation' style='text-align:right' value=''>
                        </div>

                        <div class="form-group">
                            <label for="" class="form-label text-dark">(+) TAMBAHAN (RM) </label>
                            <input onkeyup="addValue('addition',this.value)" type="text" class="form-control numbers-only" id='text-add-addition' style='text-align:right' value=''>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">(+) TARIK BALIK (RM) </label>
                            <input onkeyup="addValue('deduct',this.value)" type="text" class="form-control numbers-only" id='text-add-deduct' style='text-align:right' value=''>

                        </div>
                        <div class="form-group" id='respondMsg'>
                            <label for="" class="form-label "></label>
                        </div>
                    </div>
                </div>



            </form>


        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal" style='font-family:mark !important'>Tidak</span>
            <span class="btn btn-danger" style='font-family:mark !important' onclick='updateInfoWarrant()' >Ya</span>
        </div>
    </div>
    </div>
</div>
{{-- VIEW Kemaskini Maklumat Peruntukan END --}}

{{-- VIEW Kemaskini Maklumat UNJURAN START--}}

<div class="modal fade" id="divUpdateInfoProjection" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Kemaskini Unjuran Perbelanjaan
        </div>
        <div class="modal-body">
            <form id='divUpdateInfoProjectionForm'>
                <input type='hidden' id='projection-value' name='' value=''/>
                <div class='row'>
                    <div class='col-sm-6 col-12'>
                        <div class="form-group">
                            <label id='label-month' for="" class="form-label text-dark" ></label>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark" >PERATUS %</label>
                            <input onkeyup="this.value = this.value" type="text" class="form-control" id='text-percent' value=''>
                        </div>
                        <div class="form-group" id='respondMsg'>
                            <label for="" class="form-label "></label>
                        </div>
                    </div>
                </div>


            </form>


        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal" style='font-family:mark !important'>Tidak</span>
            <span class="btn btn-danger" style='font-family:mark !important' onclick='updateInfoProjection()' >Ya</span>
        </div>
    </div>
    </div>
</div>
{{-- VIEW Kemaskini Maklumat UNJURAN END --}}


{{-- VIEW PELARASAN START--}}

<div class="modal fade" id="divUpdateExpenseAdjusment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            PERBELANJAAN LAIN
        </div>
        <div class="modal-body">
            <form id='divUpdateExpenseAdjusmentForm'>
                <input type='hidden' id='adjust-warrant-id' name='' value=''/>
                <input type='hidden' id='adjust-warrant-workshop-id' name='' value=''/>
                <input type='hidden' id='adjust-warrant-type-id' name='' value=''/>
                <input type='hidden' id='adjust-osol-type-id' name='' value=''/>
                <div class='row'>
                    <div class='col-sm-6 col-12'>
                        <div class="form-group">
                            <label id="label-state" for="" class="form-label text-dark" ></label>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">JUMLAH Bulan Sebelum (RM) </label>
                            <div class="text-info" id="adjust-text-prev-month">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">JUMLAH Bulan {{$selectedMonth}} Ini(RM) </label>
                            <input onkeyup="this.value = this.value" type="text" class="form-control" id='adjust-text-amount' value=''>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">JUMLAH Termasuk Bulan Sebelum (RM) </label>
                            <div class="text-info" id="adjust-text-amount-carryon">
                                
                            </div>
                        </div>
                        <div class="form-group" id="payment_note_container">
                            <label for="" class="form-label text-dark">CATATAN</label>
                            <input onkeyup="this.value = this.value" type="text" class="form-control" id='adjust-text-note' value=''>

                        </div>
                            <div class="form-group" id="payment_dt_container">
                            <label for="" class="form-label text-dark">TARIKH PEMBAYARAN</label>
                            <div class="input-group date form_datetime" id="date1Container" data-date="" data-date-format="dd M yyyy">
                                <input class="form-control appointment_date" size="16" id="input_date_1" type="text"
                                value="" placeholder="Tarikh" onkeypress="return false;" readonly="readonly" required>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <label class="input-group-addon input-group-text">
                                    <i class="fal fa-calendar-alt"></i>
                                </label>
                            </div>
                        </div>
                            <input type="hidden" name="appointment_date_1" id="appointment_date_1" value="" />
                        <div class="form-group" id='respondMsg'>
                            <label for="" class="form-label "></label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal" style='font-family:mark !important'>Tidak</span>
            <span class="btn btn-danger" style='font-family:mark !important' onclick='addAdjustment()' >Ya</span>
        </div>
    </div>
    </div>
</div>
{{-- VIEW PELARASAN END --}}



<script type="text/javascript">

    let tab = '{{$tab}}';
    let adjust_mode = null;
    let adjust_for = null;
    let selected_curr_val = 0.00;
    let selected_curr_val_prev_month = 0.00;

    printMe = function(){
        $('.edit-add-item-adjustment').prev().attr('colspan',2);
        $('.edit-add-item-projection').prev().attr('colspan',2);
        window.print();
        setTimeout(() => {
            $('.edit-add-item-adjustment').prev().attr('colspan',0);
            $('.edit-add-item-projection').prev().attr('colspan',0);
        }, 200);
    }

    goHashKey = function(key){
        if(key){
            let target = {
                '26000' : '#osol260-parent',
                '28000' : '#osol280-parent'
            }
            $('html, body').animate({
                scrollTop: $(target[key]).offset().top - 250
            }, 300);
        }
    }


    $(document).ready(function() {

        let mphvHasKey = "{{Request('mphv') ? Request('mphv') : ''}}";

        initTab();

        goHashKey(mphvHasKey);


        var goToTabStr = '{{$goToTab}}';
        //alert(goToTabStr);

        if(!mphvHasKey){
            if(goToTabStr != null && goToTabStr !='' ){
                var goToTab = parseInt(goToTabStr);
                if(goToTab>0){
                    $('#tab'+goToTab).click();
                }
            }

            let strf = window.location.hash;
            if(strf.split('#')[1]){
                window.location.hash = '';
                tab = strf.split('tab=')[1];
            }

            $('#tab'+tab).trigger('click');
        }

        $('.edit-add-item-mhpv').click(function(e) {

            e.preventDefault();
            $('#respondMsg').hide();
            let id = $(this).parent().data('id');
            let divType = $(this).parent().data('div-type');
            let targetModal = $('#divUpdateInfoWarrant');

            if (divType == "osol26") {
                var jObjList = @json($osol26);
            }else if (divType == "osol28")  {
                var jObjList = @json($osol28);
            }else if (divType == "osolKKR") {
                var jObjList = @json($osolKKR);
            }else if (divType == "osolExternal") {
                var jObjList = @json($osolExternal);
            }
            var objList =  jObjList.find(x => x.id === id);

            targetModal.find('#warrant-id').val(objList.id);
            targetModal.find('#warrant-workshop-id').val(objList.workshop_id);
            targetModal.find('#warrant-type-id').val(objList.waran_type_id);
            targetModal.find('#osol-type-id').val(objList.osol_type_id);
            targetModal.find('#label-state').text(objList.state);
            targetModal.find('#text-allocation').val(objList.allocation == null ? "0" : objList.allocation);
            targetModal.find('#text-addition').val(objList.addition == null ? "0" : objList.addition);
            targetModal.find('#text-deduct').val(objList.deduct == null ? "0" : objList.deduct);
            targetModal.find('#default-text-allocation').val(objList.allocation == null ? "0" : objList.allocation);
            targetModal.find('#default-text-addition').val(objList.addition == null ? "0" : objList.addition);
            targetModal.find('#default-text-deduct').val(objList.deduct == null ? "0" : objList.deduct);
            targetModal.find('#text-carry-addition').val(objList.addition == null ? "" : objList.carry_addition);
            targetModal.find('#text-carry-deduct').val(objList.deduct == null ? "" : objList.carry_deduct);
            targetModal.find('#text-expense').val(objList.expense == null ? "" : objList.expense);
            targetModal.find('#text-advance').val(objList.advance == null ? "" : objList.advance);
            targetModal.find('#warrant-total-allocation').val(objList.total_allocation == null ? "" : objList.total_allocation);
            targetModal.find('#textarea-note').text(objList.note_expense == null ? "" : objList.note_expense);
            targetModal.modal('show');

        });

        $('.dropdown-item.month').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            location.replace('{{ route('maintenance.warrant.table') }}'+'?selectedYear={{$selectedYear}}&selectedMonth='+clickedItem);
	  	});

        $('.dropdown-item.year').click(function(e){
            var clickedItem = $(this).attr('xvalue');
            location.replace('{{ route('maintenance.warrant.table') }}'+'?selectedYear='+clickedItem);

	  	});

        $('.dropdown-item.workshop').click(function(e){

            var clickedVal = $(this).text();
            $('.dd-workshop').text(clickedVal);

            id = $(this).attr('valueId');
            var test = $('.dd-workshop').attr('xvalue',id);
            $('#warrant_selection').show();

	  	});

        $('.dropdown-item.waran').click(function(e){
            var clickedVal = $(this).text();
            $('.dd-waran').text(clickedVal);
            id = $(this).attr('valueId');

            if (id == 1) {
                $('#osol_selection').show();
                $('#btn_search').hide();
            }else {
                $('#osol_selection').hide();
                $('#btn_search').show();
            }
            var test = $('.dd-waran').attr('xvalue',id);
	  	});

          $('.dropdown-item.osol').click(function(e){

            var clickedVal = $(this).text();
            $('.dd-osol').text(clickedVal);
            id = $(this).attr('valueId');
            var test = $('.dd-osol').attr('xvalue',id);
             $('#btn_search').show();
	  	});

          $('.edit-add-item-projection').click(function(e) {
            e.preventDefault();
            $('#respondMsg').hide();
            let value = $(this).data('id');
            let targetModal = $('#divUpdateInfoProjection');

            var jObjList = @json($osolProjectionSet);
            var objList =  jObjList.find(x => x.value === value);

            targetModal.find('#projection-value').val(objList.value);
            targetModal.find('#label-month').text(objList.month_desc);
            targetModal.find('#text-percent').val(objList.percent);
            targetModal.modal('show');

        });


        $('.edit-add-item-adjustment').click(function(e) {
            e.preventDefault();
            $('#respondMsg').hide();
            let id = $(this).parent().parent().parent().data('id');
            let wd_id = $(this).parent().parent().data('id');
            let adjust = $(this).parent().parent().data('adjust');
            let mode = $(this).data('mode');
            let divType = $(this).parent().parent().parent().data('div-type');
            let targetModal = $('#divUpdateExpenseAdjusment');

            console.log('wd_id ', wd_id);
            console.log('adjust ', adjust);
            console.log('mode ', mode);

            let amount = 0.00;
            let curr_val = 0.00;
            let expense = 0.00;
            let advance = 0.00;

            expense = $(this).parent().parent().data('expense') ? $(this).parent().parent().data('expense') : 0.00;
            advance = $(this).parent().parent().data('advance') ? $(this).parent().parent().data('advance') : 0.00;

            $('#payment_note_container').hide();
            $('#payment_dt_container').hide();

            adjust_mode = mode;
            adjust_for = adjust;

            if(mode == 'add'){

                if(adjust == 'expense'){
                    targetModal.find('.modal-header').html('Tambah Pembelanjaan Lain');
                    amount = expense.toFixed(2);
                } else {
                    targetModal.find('.modal-header').html('Tambah Tanggungan');
                    amount = advance.toFixed(2);
                }

                $('#adjust-text-amount').val('0.00');

                $('#payment_note_container').show();
                $('#payment_dt_container').show();

            }else if(mode == 'update'){

                if(adjust == 'expense'){
                    targetModal.find('.modal-header').html('Kemaskini Pembelanjaan Lain');
                    amount = expense.toFixed(2);
                } else {
                    targetModal.find('.modal-header').html('Kemaskini Tanggungan');
                    amount = advance.toFixed(2);
                }

                $('#adjust-text-amount').val(amount);

            }

            if($(this).parent().parent().data('curr_val')){
                curr_val = $(this).parent().parent().data('curr_val');
            }

            selected_curr_val = curr_val;
            console.log('curr_val', curr_val);

            selected_curr_val_prev_month = selected_curr_val - amount;

            $('#adjust-text-prev-month').html(selected_curr_val_prev_month.toFixed(2));
            
            $('#adjust-text-amount-carryon').html(curr_val.toFixed(2));

                if (divType == "osol26") {
                    var jObjList = @json($osol26);
                }else if (divType == "osol28")  {
                    var jObjList = @json($osol28);
                }else if (divType == "osolKKR") {
                    var jObjList = @json($osolKKR);
                }else if (divType == "osolExternal") {
                    var jObjList = @json($osolExternal);
                }
                var objList =  jObjList.find(x => x.id === id);
            // alert(objList.id);
                targetModal.find('#adjust-warrant-id').val(objList.id);
                targetModal.find('#label-state').text(objList.state);
                targetModal.find('#adjust-warrant-workshop-id').val(objList.workshop_id);
                targetModal.find('#adjust-warrant-type-id').val(objList.waran_type_id);
                targetModal.find('#adjust-osol-type-id').val(objList.osol_type_id);

                targetModal.modal('show');

            });

        $('#adjust-text-amount').on('change', function(){
            let value = this.value;
            let afterAdd = 0.00; 

            if(adjust_mode == 'add'){
                afterAdd = selected_curr_val + parseFloat(value);
            } else {
                afterAdd = selected_curr_val_prev_month + parseFloat(value);
            }
            
            $('#adjust-text-amount-carryon').html(afterAdd.toFixed(2));
        });

        $(".numbers-only").keypress(function (e) {
            var keyCode = e.keyCode || e.which;


            //Regex for Valid Characters i.e. Alphabets and Numbers.
            //var regex = '/^[A-Za-z0-9_-.$#!&*@%]+$/';
            var regex = /^[0-9.]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));

            return isValid;
        });

        var today = new Date();
        var startDate = new Date(today.getFullYear(), today.getMonth(), 1);
        var endDate = new Date(today.getFullYear(), today.getMonth(), 31);

        let app_dt_1_container = $('#date1Container').datepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: startDate,
                endDate: endDate
            }
        );

        var listState = {{count($listStatement)}};
        var osolId = {{$selectedOsolId}};
        var waranId = {{$selectedWaranId}};

        if (waranId == 0) {
                $('#warrant_selection').hide();
                $('#osol_selection').hide();
                $('#btn_search').hide();
            }else {
                if (osolId == 0) {
                    $('#osol_selection').hide();
                }else {
                    $('#osol_selection').show();
                    $('#btn_search').show();
                }
                $('#btn_search').show();
                $('#warrant_selection').show();
        }
    });

    function updateInfoWarrant(){

        var allocation = $('#text-allocation').val();
        var addition = $('#text-addition').val();
        var deduct = $('#text-deduct').val();
        var carryAddition = $('#text-carry-addition').val();
        var carryDeduct = $('#text-carry-deduct').val();
        var expense = $('#text-expense').val();
        var noteExpense = $('#textarea-note').val();
        var advance = $('#text-advance').val();
        var id = $('#warrant-id').val();
        var workshopId = $('#warrant-workshop-id').val();
        var warrantTypeId = $('#warrant-type-id').val();
        var osolTypeId = $('#osol-type-id').val();
        var totalAllocation = $('#warrant-total-allocation').val();

        $.get('{{route('maintenance.warrant.update-warrant')}}',{'allocation': allocation,'addition':addition,'deduct':deduct,'id':id,'totalAllocation':totalAllocation,'expense':expense,'advance':advance, 'note_expense': noteExpense, 'year':{{$selectedYear}}  ,'month': {{$selectedMonth}} , 'workshop_id' : workshopId ,'carry_addition':carryAddition , 'carry_deduct':carryDeduct,'waran_type_id': warrantTypeId ,'osol_type_id':osolTypeId}, function(res){

            location.reload();

        });
    }

    function updateInfoProjection(){

        var value = $('#projection-value').val();
        var percent = $('#text-percent').val();

        $.get('{{route('maintenance.warrant.update-projection')}}',{'value': value,'percent':percent}, function(res){
            location.reload();
        });
    }

    function getWarrantByYear(self){

        let year = $(self).data('year');
        $.get('{{route('maintenance.warrant.get-warrant')}}',{'year': year}, function(res){
            window.location.href = "{{route('maintenance.warrant.table')}}?selectedYear="+year;
        });

    }

    function getStatement(self){

        var workshopId = parseInt($('.dd-workshop').attr('xvalue'));
        var waranId = parseInt($('.dd-waran').attr('xvalue'));
        var osolId = parseInt($('.dd-osol').attr('xvalue'));

        var jWorkshop = @json($listWorkshop);
        var objWorkshop =  jWorkshop.find(x => x.id === workshopId);

        var jWaran = @json($listWaranType);
        var objWaran =  jWaran.find(x => x.id === waranId);


        var passOsol = "";
        var passOsolId = 0;

        if (osolId != 0) {
            var jOsol = @json($listOsolType);
            var objOsol =  jOsol.find(x => x.id === osolId);

            passOsol = objOsol.value;
            passOsolId = osolId;
        }

        location.replace('{{ route('maintenance.warrant.table') }}'+'?selectedYear={{$selectedYear}}&selectedMonth={{$selectedMonth}}&selectedWorkshop='+objWorkshop.desc+'&selectedWorkshopId='+workshopId+'&selectedWaran='+objWaran.desc+'&selectedWaranId='+waranId+'&selectedOsol='+passOsol+'&selectedOsolId='+passOsolId+'&tab=5');

    }

    function addAdjustment(){

        var id = $('#adjust-warrant-id').val();
        var workshopId = $('#adjust-warrant-workshop-id').val();
        var warrantTypeId = $('#adjust-warrant-type-id').val();
        var osolTypeId = $('#adjust-osol-type-id').val();
        var amount = $('#adjust-text-amount').val();
        var note = $('#adjust-text-note').val();
        var expenseDt = $('#input_date_1').val();

        //alert('id->'+id+'workshopId->'+workshopId+' amount->'+amount +'note->'+note+'expenseDt->'+expenseDt);
        $.post('{{route('maintenance.warrant.add-warrant-adjustment')}}',
            {
                '_token': '{{csrf_token()}}',
                'id':id,
                'year':{{$selectedYear}}  ,
                'month': {{$selectedMonth}} , 
                'workshop_id' : workshopId ,
                'waran_type_id':warrantTypeId ,
                'osol_type_id':osolTypeId , 
                'amount':amount ,
                'note':note,
                'expense_dt':expenseDt,
                'adjust': adjust_for,
                'adjust_mode': adjust_mode
            }, function(res){

            location.reload();

        });
    }

    function addValue(type, value){

        if(value!=''){
            $('#text-'+type).val(parseFloat($('#default-text-'+type).val())+parseFloat(value));
        }else{
            $('#text-'+type).val($('#default-text-'+type).val());
        }

    }

    function changeValue(type, value){

        if(value!=''){
            $('#text-add-'+type).val('');
        }else{

        }
    }

    function downloadExcel(){

       var activeTab = $('#tabActive').find('.active').text();
        $.ajax({
            url:"{{route('maintenance.warrant.export.excel')}}",
            data: {
                'selectedMonth': {{$selectedMonth}},
                'selectedYear': {{$selectedYear}},
                'selectedWorkshop': "{{$selectedWorkshop}}",
                'selectedWaran': "{{$selectedWaran}}",
                'selectedWorkshopId': {{$selectedWorkshopId}},
                'selectedWaranId': {{$selectedWaranId}},
                'selectedOsol': "{{$selectedOsol}}",
                'selectedOsolId': {{$selectedOsolId}},
                'activeTab' : activeTab
            },
            cache:false,
            xhrFields:{
                responseType: 'blob'
            },
            success: function(result, status, xhr){
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);

                var filename = (matches != null && matches[1] ? matches[1] : 'Senarai '+activeTab+'.xlsx');

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



    var percentageList = [];
    var monthList = [];
    var osol26List = [];
    var osol28List = [];

    @foreach ($osolProjectionSet as $item)
    percentageList.push({{$item->percent}});
    monthList.push('{{$item->month}}');
    @endforeach

    @foreach ($osol26Projectionpercent as $item)
    osol26List.push({{$item}});
    @endforeach


    @foreach ($osol28Projectionpercent as $item)
    osol28List.push({{$item}});
    @endforeach

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
        xAxis: {
            categories: monthList,
            crosshair: true,
            title: {
                text: 'Bulan',
                style: {
                    color: '#5e7485'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: '{value}%',
                style: {
                    color: '#5e7485'
                }
            },
            title: {
                text: '% peratus',
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
            //y: 0,
            verticalAlign: 'top',
            //x: 110,
            floating: true,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || // theme
                'rgba(255,255,255,0.25)'
        },
        series: [{
                name: 'Unjuran ditetapkan',
                data:  percentageList,
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: 'Osol 26000',
                data: osol26List,
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: 'Osol 28000',
                data: osol28List,
                tooltip: {
                    valueSuffix: '%'
                }
            }
        ]
    });

</script>
</body>

