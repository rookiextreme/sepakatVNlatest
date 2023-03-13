@php
    $tab = Request('tab') ? Request('tab') : null;
@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <link rel="shortcut icon" href="{{ asset('my-assets/favicon/favicon.png') }}">

    <!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">

    <!--importing bootstrap-->
    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('my-assets/fontawesome-pro/css/light.min.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.js') }}"></script>
    <!--Importing Icons-->

    <link href="{{ asset('my-assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet" />
    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .lcal-2 {
            width: 50px;
        }

        .lcal-3 {
            width: 100px;
        }

        .lcal-4 {
            width: 150px;
        }

        .cux-box {
            min-width: 400px;
            min-height: 300px;
            width: 60%;
            height: 50%;
        }

        .input-group-text {
            height: 39px;
            margin-left: 2px !important;
            margin-right: 3px;
            border: transparent;
            background: #dbdcd8;
        }

        .input-group.date .input-group-text {
            height: 39px;
            margin-left: 4px !important;
            border: transparent;
            background: #dbdcd8;
        }

        .select2-container--open {
            z-index:1060;
        }

        .inline-label {
            display: contents;
        }

        .scrollable-horizontal {
            width: 100%;
            height: 10vh;
            overflow-x: scroll;
            white-space: nowrap;
            border-left: 3px solid #969690;
            border-right: 3px solid #969690;
        }

        .scrollable-vertical {
            height: 400px;
            overflow-y: scroll;
            white-space: nowrap;
            scroll-behavior: smooth;
        }

        .item {
            padding: 5px;
            display: inline-block;
            border-radius: 15px;
            border: 1px solid #969690;
            color: #969690;
            text-decoration: none;
        }
        .item.selected, .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        body.modal-open {
            height: 100vh;
            overflow-y: hidden;
        }

        .table-custom-local {
            border-spacing: 0;
            border-collapse: separate !important;
            border-color:#d7d7de;
            border-width: 2px;
        }
        .table-custom-local thead th:first-of-type {
            border-color:#d7d7de;
            border-left-width: 0px;
            border-top-width: 0px;
            border-bottom-width: 2px;
            border-right-width: 0px;
            text-align: center;
        }

        .table-custom-local thead th {
            border-color:#d7d7de;
            border-left-width: 0px;
            border-right-width: 0px;

            border-top-width: 0px;
            border-bottom-width: 2px;
            text-align: center;
            font-family:avenir-bold !important;
            font-size: 12px !important;
            color:#393728 !important;
            text-align: left;
            line-height: 12px;
            font-weight:200;
            text-transform: uppercase;
            vertical-align: bottom;
        }
        .table-custom-local thead th:last-of-type {
            border-radius: 0px 8px 0px 0px;
            -moz-border-radius: 0px 8px 0px 0px;
            -webkit-border-radius: 0px 8px 0px 0px;
            border-color:#d7d7de;
            border-left-width: 0px;
            border-bottom-width: 2px;
            border-right-width: 0px;
        }
        .table-custom-local thead th.special {
            background-color:#ffffff;
            border-radius: 8px 8px 0px 0px;
            -moz-border-radius: 8px 8px 0px 0px;
            -webkit-border-radius: 8px 8px 0px 0px;
        }
        .table-custom-local tbody tr {
            border-top-style: none;
            border-top-color: none;
            border-top-width: 0px;
        }
        .table-custom-local tbody tr td {
            border-right-color:#d7d7de;
            border-right-width: 0px;
            border-right-style: solid;
            border-left-color:#d7d7de;
            border-left-width: 0px;
            border-left-style: solid;
            border-top-style: none !important;
            border-top-color: none !important;
            font-family: mark;
            font-size:14px;
            height:18px;
            vertical-align: top !important;
            line-height:16px;
            border-bottom-style: none;
            border-bottom-color: #d7d7de;
            border-bottom-width: 1px;
        }
        .table-custom-local tbody tr td.special {
            background-color:#ffffff;
        }
        .table-custom-local tbody tr td:last-of-type {
            border-right-style: none;
            border-right-color:#d7d7de;
            border-right-width: 0px;
        }
        .table-custom-local tbody tr td a {
            font-family: mark-bold;
            text-decoration: none;
            font-size:14px;
            height:18px;
            color:#393728;
            vertical-align: top !important;
            line-height:16px;
            cursor: pointer;
        }
        .table-custom-local tbody tr td a:hover {
            color:orange;
        }
        .table-custom-local tfoot td {
            height:10px;
            line-height:10px;
            border-left-width: 0px;
            border-right-width: 0px;
            background-color:transparent !important;
        }
        .table-custom-local tfoot td.special {
            background-color:#ffffff !important;
            border-radius: 0px 0px 8px 8px;
            -moz-border-radius: 0px 0px 8px 8px;
            -webkit-border-radius: 0px 0px 8px 8px;
        }

        
        @media print {
            @page {
                size: 'A4' portrait; /* auto is default portrait; */
            }

            .col-md-6 {
                width: 50%;
            }

            .no-printme  {
                display: none;
            }
            .printme  {
                display: block;
            }
            .printme th, .printme td {
                padding-left: 10px;
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
        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
        }

    </style>
</head>
<body class="content">
    <span class="btn cux-btn small" data-bs-toggle="modal" data-bs-target="#mockupForm01">Mockup Borang Kenderaan Baharu</span>
    <span class="btn cux-btn small" data-bs-toggle="modal" data-bs-target="#mockupForm02">Mockup Borang Pemeriksaan</span>
    <span class="btn cux-btn small" data-bs-toggle="modal" data-bs-target="#mockupForm03">Mockup Borang Pemeriksaan & Pengujian</span>
    <span class="btn cux-btn small" data-bs-toggle="modal" data-bs-target="#mockupForm04">Mockup SOP/Senarai Semakan</span>

        <div class="modal fade" id="mockupForm01" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="frm_examination_achievement_vehicle">
                    @csrf
                        <div class="modal-body">
                            <div class="scrollable-horizontal">
                                @foreach ($Ref01ComponentChecklistLvl1 as $RefComponentLvl1)
                                    <a href="#item_{{$loop->index+1}}" class="item">{{$RefComponentLvl1->component_shortname}}</a>
                                @endforeach
                            </div>
                            <div class="row scrollable-vertical">
                                @foreach ($Ref01ComponentChecklistLvl1 as $RefComponentLvl1)
                                    <div id="item_{{$loop->index+1}}">
                                        <div class="col-md-12">
                                            <label for="" class="form-label"> {{$loop->index+1}}. {{$RefComponentLvl1->component}}</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="form-label">Jenis</label>
                                                    <div class="col-md-12">
                                                        <select class="form-select" name="type_{{$loop->index+1}}" id="type_{{$loop->index+1}}">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="form-label">BahanApi</label>
                                                    <div class="col-md-12">
                                                        <select class="form-select" name="fuel_{{$loop->index+1}}" id="cold_{{$loop->index+1}}">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="form-label">Penyejukan</label>
                                                    <div class="col-md-12">
                                                        <select class="form-select" name="cold_{{$loop->index+1}}" id="cold_{{$loop->index+1}}">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @foreach ($RefComponentLvl1->hasManyComponentChecklistLvl2 as $RefComponentLvl2)
                                                <div class="col-md-12">
                                                    <button onclick="$('#collapsed-chevron', this).toggleClass('fa-rotate-180')" class="btn cux-btn bigger text-left mb-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample_{{$loop->index+1}}" aria-expanded="false" aria-controls="collapseExample_{{$loop->index+1}}">
                                                        {{$RefComponentLvl2->component}} <i class="fa fa-chevron-circle-up" id="collapsed-chevron"></i> <span class="badge bg-spakat">{{count($RefComponentLvl2->hasManyComponentChecklistLvl3)}}</span>
                                                    </button>
                                                    <div class="collapse" id="collapseExample_{{$loop->index+1}}">
                                                        <div class="table-responsive">
                                                            <table class="table display compact stripe hover compact table-bordered" style="width: 100%">
                                                                <thead>
                                                                    <th class="text-center" style="width: 50px;"></th>
                                                                    <th></th>
                                                                    <th class="text-center" style="width: 50px;">Lulus</th>
                                                                    <th class="text-center" style="width: 50px;">Gagal</th>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($RefComponentLvl2->hasManyComponentChecklistLvl3 as $RefComponentLvl3)
                                                                        <tr>
                                                                            <td class="text-center">{{$loop->index+1}}</td>
                                                                            <td>{{$RefComponentLvl3->component}}</td>
                                                                            <td class="text-center">
                                                                                <input class="form-check-input cursor-pointer" type="radio" name="mode_1_1" id="mode_1_1" value="1">
                                                                            </td>
                                                                            <td class="text-center">
                                                                                <input class="form-check-input cursor-pointer" type="radio" name="mode_1_1" id="mode_1_1" value="0">
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Catatan</label>
                                                                <textarea class="form-control"  style="resize: none;" name="" id="" cols="30" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    </div>

                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" id="remove" class="btn cux-btn bigger">Simpan</button>
                            <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="mockupForm03" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="frm_examination_achievement_vehicle">
                    @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <div class="small-title">
                                </div>
                                <span>
                                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </span>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-9">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-center text-darker align-middle text-uppercase" >jkr malaysia</span>
                                                <span class="text-center text-darker align-middle text-uppercase" >sijil pemeriksaan dan pengujian kenderaan</span>
                                                <span class="text-left text-darker text-uppercase" >
                                                    <div >No. Dokumen : CKM.KM.02</div>
                                                    <div >No. Keluaran</div>
                                                    <div >No. Pindaan</div>
                                                    <div >Tarikh</div>
                                                    <div >Muka Surat</div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br><br>
                                <div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">no pesanan kerajaan tuan</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">no kontrak</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">fail. kami</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">fail. tuan</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">tarikh</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <br>
                                <div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-left text-darker align-middle text-uppercase">kepada</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-left text-darker align-middle text-uppercase">Adalah diperakui bahawa kenderaan</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">Jenis</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">no. pendaftaran</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">no. enjin</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">no. casis</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">tarikh diperiksa & diuji</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">hitungan</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase">:</span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="d-flex justify-content-between">
                                                    <span class="text-center text-darker align-middle text-uppercase"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br><br>

                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between">
                                                <p class="text-justify text-darker">
                                                    beserta alat - alat kelengkapannya telah diperiksa dan diuji di JKR WORKSYOP PERSEKUTUAN/JKR CKM NEGERI
                                                    _____________ dan didapati menepati spesifikasi kontrak. Sebarang aduan dan kecacatan selepas penyerahannya
                                                    hendaklah dirujuk kepada pihak pembekal selagi dalam tempoh jaminan.
                                                </p>
                                        </div>
                                    </div>
                                </div>
                                <br><br><br>
                                <div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md-9">
                                            <div class="d-flex justify-content-between">
                                                <h3 class="text-dark">
                                                    Ketua Jurutera Mekanikal
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--
                                <div>

                                    <table class="w-75">
                                        <tbody>
                                            <th class="text-left">
                                                <h3 class="text-dark">
                                                    Ketua Jurutera Mekanikal
                                                </h3>
                                            </th>
                                        </tbody>
                                    </table>

                                </div>--}}
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" id="remove" class="btn cux-btn bigger">Simpan</button>
                            <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        {{-- <div class="modal fade" id="mockupForm02" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form id="frm_examination_achievement_vehicle">
                    @csrf
                        <div class="modal-body">
                            <div class="scrollable-horizontal">
                                @foreach ($RefComponentChecklistLvl1 as $RefComponentLvl1)
                                    <a href="#item_{{$loop->index+1}}" class="item">{{$RefComponentLvl1->component_shortname}}</a>
                                @endforeach
                            </div>
                            <div class="row scrollable-vertical">
                                @foreach ($RefComponentChecklistLvl1 as $RefComponentLvl1)
                                <div id="item_{{$loop->index+1}}">
                                    <div class="col-md-12">
                                        <label for="" class="form-label"> {{$loop->index+1}} {{$RefComponentLvl1->component}}</label>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table display compact stripe hover compact table-bordered" style="width: 100%">
                                            <thead>
                                                <th></th>
                                                <th></th>
                                                <th class="text-center" style="width: 50px;">Lulus</th>
                                                <th class="text-center" style="width: 50px;">Gagal</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($RefComponentLvl1->hasManyComponentChecklistLvl2 as $RefComponentLvl2)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{$RefComponentLvl2->component}}</td>
                                                        <td class="text-center">
                                                            <input class="form-check-input cursor-pointer" type="radio" name="mode_1_1" id="mode_1_1" value="1">
                                                        </td>
                                                        <td class="text-center">
                                                            <input class="form-check-input cursor-pointer" type="radio" name="mode_1_1" id="mode_1_1" value="0">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="" class="form-label">Catatan</label>
                                            <textarea class="form-control"  style="resize: none;" name="" id="" cols="30" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" id="remove" class="btn cux-btn bigger">Simpan</button>
                            <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="mockupForm04" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="small-title">
                        </div>
                        <span>
                            <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </span>
                    </div>
                    <div class="modal-body">
                        <span class="btn cux-btn small" onclick="window.print()">Cetak</span>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>1212</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    for ($i=0; $i < 200; $i++) { 
                                        @endphp

                                        <tr>
                                            <td> sdasdsad {{$i}}</td>
                                        </tr>

                                        @php

                                    }
                                @endphp
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>1212</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>  
                    <div class="modal-footer justify-content-between">
                        <button type="submit" id="remove" class="btn cux-btn bigger">Simpan</button>
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        function show(element){
            $(element).show();
        }

        function selectHash(self){

            $('.selected').removeClass('selected disabled');

            let hash = window.location.hash;
            $(self).addClass('selected disabled');
        }

        const submitExaminationAchievementVehicle = function(formData){

        }

        let currentOffset = 0;

        $(document).ready(function(){
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic"
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                submitExaminationAchievementVehicle(formData);
            });

            // $(document).on('click', 'a[href^="#"]', function (event) {
            //     event.preventDefault();

            // });

            $('.item').on('click', function(e){

                let hasDisable = $(this).hasClass('disabled');
                let hash = this.hash;

                currentOffset = $(hash).offset().top;
                console.log('currentOffset ', currentOffset);

                if(!hasDisable){
                    if (hash !== "") {
                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    // console.log($(hash).offset().top);
                    // $('.scrollable-vertical').animate({
                    //     scrollTop: $(hash).offset().top
                    // }, 500, function(){

                    //     // Add hash (#) to URL when done scrolling (default click behavior)
                    //     // window.location.hash = hash;
                    // });

                    $('.modal').scrollTop( 0 );

                    selectHash(this);

                    }
                }

                setTimeout(() => {
                    $('.modal').scrollTop( 0 );
                    let modal = $(".modal");
                    body.stop().animate({scrollTop:0}, 500, 'swing', function() {
                    // alert("Finished animating");
                    });
                }, 300);
            });

        });

    </script>


</body>

</html>
