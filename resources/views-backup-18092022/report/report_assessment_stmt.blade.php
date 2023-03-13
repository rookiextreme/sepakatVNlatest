@php
    $type = $assessment_type;
    switch ($type) {
        case 'new':
            $type = "Kenderaan Baharu";
            break;
        case 'accident':
            $type = "Kemalangan";
            break;
        case 'currvalue':
            $type = "Harga Semasa";
            break;
        case 'disposal':
            $type = "Pelupusan";
            break;
        case 'gov':
            $type = "Pinjaman Kerajaan";
            break;
        case 'safety':
            $type = "Keselamatan & Prestasi";
            break;

        default:
            break;
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
    <script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

    <style type="text/css">

        .fancybox__content{
            height: 100vh !important;
        }
        body {
            background-color: #f4f5f2;
        }
        .modal .modal-dialog .modal-content {
            background-color: #f4f5f2;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
        }
        .rlabel {
            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:14px;
            line-height: 36px;
            text-align: left;
        }
        .mytext {
            font-family: mark;
            font-size:16px;
            line-height: 34px;
            text-align: left;
            color:darkslategray;
            text-transform: uppercase;
        }
        .box-info {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            line-height:36px;
        }
        .box-info:hover {
            background-color:#ebede6;
        }
        .box-underline {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            height:36px;
        }
        #vehicle_info {
            max-width: 800px;
        }
        .polaroid {
            background-color:#ffffff;
            padding:5px;
            max-width:200px;
            height:165px;
            text-align: center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            border-style: solid;
            border-color:#c8c8cc;
            border-width:1px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            transition: all .2s ease-in-out;
        }
        .polaroid .plet-no {
            font-family: mark-bold;
            font-size:16px;
            color:#272624;
            text-align: left;
            margin-left:5px;
            line-height: 35px;
        }
        .box-left {
            margin-left:auto;
            margin-right:auto;
            margin-top:3px;
            max-width:60%;
            height:90%;
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
        }
        .plate-highlight {
            font-family: avenir-bold;
            font-size:14px;
            color:#595959;
            text-transform: uppercase;
        }
        .lcal-2 {
        width: 40px;
        text-align: center;
        padding-right:0px;
        padding-left:10px;
        padding-top:0px;
    }
    .lcal-2 .form-check-input {
        margin-left:4px;
        margin-top:2px;
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
    .edit-btn {
        padding-left:4px;
        padding-right:4px;
        padding-top:5px;
        padding-bottom:5px;
        text-align: center;
        border-color:#dcdcd8;
        font-family: mark;
        font-size: 12px;
        width:30px;
        border-color:#dcdcd8;
        border-width:2px;
        border-style:solid;
        margin-top:0px;
        cursor: pointer;
        margin:0px;
    }
    .edit-btn:hover {
        background-color:orange;
    }
    .lcal-btn {
        padding:0px;
        text-align:center;
        cursor: pointer;
        width:40px;
        padding-left:7px;
    }
    .lcal-btn:hover {
        text-align:center;
        background-color:#dce0d9;
        border-radius: 8px 8px 8px 8px;
        -moz-border-radius: 8px 8px 8px 8px;
        -webkit-border-radius: 8px 8px 8px 8px;
    }

    .fieldset {
        border-top-color: rgb(226, 228, 224);
        border-top-width: 1px;
        border-top-style: solid;
        top: 10px;
        position: relative;
        padding-bottom: 10px;
    }

        #printHeader, #printLastFooter {
            display: none;
        }

        @media print {

            @page {
                size: auto;
                size: A4;
                margin: 30px;
            }

            html, body {
                background-color: transparent;
                width: 210mm;
                height: 297mm;
            }

            #printHeader {
                display: flex;
            }

            #printLastFooter:last-child {
                display: flex;
                position: fixed;
                bottom: 0px;
                left: 0px;
                width: 100%;
                background: transparent;
                height: 100vh;
            }

            footer {
                position: fixed;
                bottom: 0;
            }

            .table-responsive {
                overflow-x: unset;
            }

            .box-info {
                border: none;
                line-height: unset;
            }

            .fieldset {
                border-top-color: transparent;
                border-top-width: 1px;
                border-top-style: solid;
                top: 10px;
                position: relative;
                padding-bottom: 0px;
            }

            .fieldset.appl{
                padding-bottom: 15px;
            }

            .fieldset.vehicle {
                top: -1px;
            }

            .no-printme  {
                display: none;
            }
            .printme  {
                display: block;
            }
            .box-info {
                width:100%;
                border-bottom-style: solid;
                border-bottom-color:#e3e3eb;
                border-bottom-width:1px;
                padding-left:0px;
                padding-right:0px;
                padding-top: 3px;
                padding-bottom: 3px;
            }

            .rlabel, .mytext {
                line-height: unset;
            }

            .printable {
                display: none;
            }

            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
                color-adjust: exact !important;                 /*Firefox*/
            }

            .table-report th, .table-report td {
                border: 1px solid #797a78;
                padding-left: 5px;
                padding-right: 5px;

            }

            .table-report th {
                color: black;
                background-color: #c8ccc5;
            }

            .table-report td {
                color: black;
            }

            tfoot, tr.repeat-footer, td.repeat-footer {
                border: 1px solid transparent;
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

    <script>

    function hide(element){
        $(element).hide();
    }

    function show(element){
        $(element).show();
    }

    function block(element){
        $(element).prop('disabled', true);
    }

    function release(element){
        $(element).prop('disabled', false);
    }

    function alphanumeric()
    {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        return regex;
    }

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <span class="no-printme">
        <div class="mytitle">Laporan Penilaian</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if(auth()->user()->isAdmin())
                    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.report')}}');"><i class="fal fa-home"></i></a></li>
                    <li class="breadcrumb-item " aria-current="page"><a href="javascript:openPgInFrame('{{route('report.report_appl_by_mth')}}');">Laporan {{$month}}, {{$year}}</a></li>
                    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('report.report_appl_by_wsp', [ 'workshop_id' =>  Request('workshop_id'), 'assessment_type' => $assessment_type])}}');">Laporan Woksyop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Maklumat Permohonan</li>
                @else
                    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.public.dashboard')}}');">
                        <i class="fal fa-home"></i></a>
                    </li>
                    @if($assessment_type == 'new')
                        <li class="breadcrumb-item">
                            <a href="{{ route('assessment.new.list') }}">Rekod Penilaian</a>
                        </li>
                    @elseif($assessment_type == 'safety')
                        <li class="breadcrumb-item">
                            <a href="{{ route('assessment.safety.list') }}">Rekod Penilaian</a>
                        </li>
                    @elseif($assessment_type == 'currvalue')
                        <li class="breadcrumb-item">
                            <a href="{{ route('assessment.currvalue.list') }}">Rekod Penilaian</a>
                        </li>
                    @elseif($assessment_type == 'accident')
                        <li class="breadcrumb-item">
                            <a href="{{ route('assessment.accident.list') }}">Rekod Penilaian</a>
                        </li>
                    @elseif($assessment_type == 'gov')
                        <li class="breadcrumb-item">
                            <a href="{{ route('assessment.gov_loan.list') }}">Rekod Penilaian</a>
                        </li>
                    @elseif($assessment_type == 'disposal')
                        <li class="breadcrumb-item">
                            <a href="{{ route('assessment.disposal.list') }}">Rekod Penilaian</a>
                        </li>
                    @else
                    @endif

                    <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
                @endif
            </ol>
        </nav>
    </span>
    <div class="main-content">
        <form class="row" id="frm_detail">

            <div class="messages"></div>
            <div id="printHeader">
                <table style="width: 100%;">
                    <tr>
                        <td align="top" style="width: 100px;">
                            <img src="{{asset('my-assets/img/logo-min.png')}}" width="100%" alt="">
                        </td>
                        <td class="text-uppercase text-black-50">
                            <label for="" class="ps-3 form-label">Jabatan Kerja Raya Malaysia</label>
                        </td>
                    </tr>
                    <tr>
                        <td align="top" colspan="2" class="text-uppercase text-black-50 pt-3">
                            <label for="" class="form-label">Cetakan Borang Permohonan</label>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="printMe" class="printme" style="width:1200px">
                    <div class="row mb-2" id="vehicle_photo">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 line-r">
                            {{-- <div class="polaroid">
                                <div class="box-left" style="background-image: url({{asset('my-assets/img/icon-user2.png')}});">&nbsp;</div>
                                <div><p style="color:black; font-size:10px;" >{{$data->applicant_name}}</p></div>
                            </div> --}}
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-4 no-printme">
                            <div class="float-end">
                                <div class="btn-group">
                                    {{-- <span class="btn cux-btn small" onClick="javascript:openPgInFrame('{{ route('new.register',  ['id' => $detail->id, 'fleet_view' => $fleet_view ]) }}')"> <i class="fal fa-edit"></i> Kemaskini</span> --}}
                                    <span class="btn cux-btn small" onClick="window.print()"> <i class="fal fa-print"></i> Cetak</span>
                                </div>
                            </div>
                        </div>
                            <div class="fieldset appl">
                                <legend>Maklumat Permohonan</legend>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No. Rujukan</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->ref_number}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Jenis Penilaian</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$type}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Permohonan</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{\Carbon\Carbon::parse($data->created_at)->translatedFormat("d F Y")}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Nama Pemohon</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->applicant_name}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Telefon</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->phone_no}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Emel</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6"><p style="font-family:Arial;margin-bottom: 0px;">{{$data->email}}</p></div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Kad Pengenalan</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->ic_no}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Kementerian</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->hasAgency ? $data->hasAgency->desc : '-'}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Jabatan / Agensi</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->department_name}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Alamat</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->address}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Poskod</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->postcode}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Negeri</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->hasState ? $data->hasState->desc : '-'}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Woksyop Pilihan</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->hasWorkshop->desc}}</div>
                                </div>
                                <div class="row box-info">
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Temu Janji</div>
                                    <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$data->appointment_dt ? \Carbon\Carbon::parse($data->appointment_dt)->translatedFormat("d F Y") : ' '}}</div>
                                </div>
                            </div>
                            <div class="fieldset vehicle">

                                <legend>Maklumat Kenderaan</legend>
                                <div class="table-responsive">
                                    @if($data->hasVehicle && $data->hasVehicle->count() == 0)
                                    @else
                                        <table class="table-report stripe" style="width:100%;z-index:9999;">
                                            <thead>
                                                <th style="vertical-align:top;">Bil</th>
                                                <th style="vertical-align:top;" class="special">No Pendaftaran</th>
                                                {{-- <th style="vertical-align:top;">Pembelian</th>
                                                <th style="vertical-align:top;">Milik</th>
                                                <th style="vertical-align:top;">Kategori <i class="fal fa-chevron-right"></i> Sub-Kategori</th> --}}
                                                <th style="vertical-align:top;">Jenis</th>
                                                <th style="vertical-align:top;">Buatan</th>
                                                <th style="vertical-align:top;">Model</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->hasVehicleMany as $vehicle)
                                                    <tr>
                                                        <td style="vertical-align:top;">{{$loop->index+1}}</td>
                                                        <td style="vertical-align:top;" class="caps special">{{$vehicle->plate_no}}</td>
                                                        {{-- <td style="vertical-align:top;" class="caps">{{ Carbon\Carbon::parse($vehicle->purchase_dt)->translatedFormat("d F Y")}}</td>
                                                        <td style="vertical-align:top;" class="caps">{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                                                        <td style="vertical-align:top;" class="caps">{{$vehicle->hasCategory->name}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td> --}}
                                                        <td style="vertical-align:top;">{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                                                        <td style="vertical-align:top;">{{$vehicle->hasVehicleBrand->name}}</td>
                                                        <td style="vertical-align:top;">{{$vehicle->model_name}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            {{-- <tfoot>
                                                <tr class="repeat-footer">
                                                    <td class="repeat-footer" colspan="8"><div style="height: 50px; background-color: white;"></div></td>
                                                </tr>
                                            </tfoot> --}}
                                        </table>
                                    @endif
                                </div>
                            </div>
                            <div class="fieldset">
                                <legend>Makluman</legend>
                                @if($assessment_type == 'new')
                                    <ul class="checklist">
                                        <li>Delivery Note</li>
                                        <li>Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                                        <li>Surat dari Jabatan</li>
                                        <li>Salinan Cukai Jalan</li>
                                        <li>Salinan Pesanan Kerajaan (LO)</li>
                                        <li>Salinan Lukisan-lukisan Teknikal (yang berkenaan)</li>
                                        <li>Surat Pelepasan Tanggungan Kenderaan Baharu
                                            &nbsp;&nbsp;
                                            <a target="_blank" class="printable" data-fancybox data-type="iframe"
                                            href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Surat Pelepasan Tanggungan Kenderaan Baharu', 'report_name' => 'letter_of_guarantee', 'assessment_new_id' => ($data->id)])}}">
                                            <span class="btn cux-btn back-hailait"><i class="fal fa-file-pdf"></i> Muat Turun Surat</span></a>
                                        </li>
                                    </ul>
                                @elseif($assessment_type == 'safety')
                                    <ul class="checklist">
                                        <li> Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                                        <li> Surat dari Jabatan</li>
                                        <li> Surat Pelepasan Tanggungan (Pemeriksaan Keselamatan dan Prestasi Kenderaan)
                                            <a class="printable"
                                                target="_blank"
                                                data-fancybox data-type="iframe"
                                                href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Surat Pelepasan Tanggungan', 'report_name' => 'letter_of_release_of_dependent_safety', 'assessment_safety_id' => $data->id])}}"
                                                ><span class="btn cux-btn back-hailait"><i class="fal fa-file-pdf"></i> Muat Turun Surat</span>
                                            </a>
                                        </li>
                                    </ul>
                                @elseif($assessment_type == 'currvalue')
                                    <ul class="checklist">
                                        <li> Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                                        <li> Surat dari Jabatan</li>
                                        {{--  <li> Salinan Kad Pengenalan Pemohon</li>
                                        <li> Surat Wakil Kuasa (Jika Berkenaan)</li>  --}}
                                    </ul>
                                @elseif($assessment_type == 'accident')
                                    <ul class="checklist">
                                        <li> Borang Laporan Kerosakan - Borang Am 362B<Br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Bahagian 1 lengkap diisi dalam 4 salinan)</li>
                                        <li> Repot Polis</li>
                                    </ul>
                                @elseif($assessment_type == 'gov')
                                    <ul class="checklist">
                                        <li> Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                                        <li> Surat dari Jabatan</li>
                                        <li> Salinan Kad Pengenalan Pemohon</li>
                                        <li> Surat Wakil Kuasa (Jika Berkenaan)</li>
                                    </ul>
                                @elseif($assessment_type == 'disposal')
                                    <ul class="checklist">
                                        <li> JPJ K2 atau Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                                        <li> Surat dari Jabatan</li>
                                        <li> Borang Kew.PA-3</li>
                                        <li> Borang Kew.PA-15</li>
                                        <li> Surat Pelepasan Tanggungan
                                            {{-- &nbsp;&nbsp;<a
                                            class="printable"
                                            target="_blank"
                                            style="height: unset;"
                                            data-fancybox data-type="iframe"
                                            href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Surat Pelepasan Tanggungan', 'report_name' => 'letter_of_release_of_dependent', 'assessment_disposal_id' => $data->id])}}"
                                            ><span class="btn cux-btn back-hailait"><i class="fal fa-file-pdf"></i> Muat Turun Surat</span>
                                            </a> --}}
                                        </li>
                                    </ul>
                                @else
                                @endif
                            </div>
                            <hr soft/>
                    </div>
            </div>
        </form>

    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">
    </script>
</body>

{{-- <div id="printLastFooter" style="z-index: -1">
    <table>
        <tr>
            <td colspan="" style="bottom: 0px; right: 30px; position: absolute; color: black;">
                asas
            </td>
        </tr>
    </table>
</div> --}}

</html>
