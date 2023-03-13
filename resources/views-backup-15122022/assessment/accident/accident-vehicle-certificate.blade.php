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
    <link rel="stylesheet"
        href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}">
    </script>

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
            z-index: 1060;
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
            height: 50vh;
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
            cursor: pointer;
        }

        .item.selected,
        .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        html {
            scroll-behavior: smooth !important;
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
    <div class="mytitle">Penilaian Kemalangan</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                        <i class="fal fa-home"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('assessment.accident.register', [
                        'id' => Request('assessment_id'),
                        'tab' => 6
                    ]) }}">Penilaian Kemalangan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Maklumat Sijil</li>
            </ol>
        </nav>
        <div class="main-content bg-white pt-3 pb-3">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <div class="col-"></div>
                        <span class="text-center text-darker align-middle text-uppercase">jkr malaysia</span>
                        <span class="text-center text-darker align-middle text-uppercase">sijil pemeriksaan dan
                            pengujian kenderaan</span>
                        <span class="text-left text-darker text-uppercase">
                            <div>No. Dokumen : CKM.KM.02</div>
                            <div>No. Keluaran</div>
                            <div>No. Pindaan</div>
                            <div>Tarikh</div>
                            <div>Muka Surat</div>
                        </span>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">no pesanan kerajaan tuan</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">no kontrak</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Fail Tuan</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Tarikh</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Kepada</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Adalah Diperakui Bahawa</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Kenderaan</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">: {{$detail->hasCategory->name}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Jenis</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">: {{$detail->hasSubCategoryType ? $detail->hasSubCategoryType->name : $detail->hasSubCategory->name}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">No Pendaftaran</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">: {{$detail->plate_no}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">No. Enjin</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">: {{$detail->engine_no}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">No. Casis</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">: {{$detail->chasis_no}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Tarikh Diperiksa & Diuji</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">: {{\Carbon\Carbon::parse($detail->updated_at)->format('d/m/Y g:i A')}}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <span class="text-darker align-middle text-uppercase form-label">Hitungan</span>
                        </div>
                        <div class="col-md-9">
                            <span class="text-left text-darker align-middle text-uppercase">:</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-3">
                <div class="col-md-9">
                    <div class="d-flex justify-content-between">
                        <p class="text-justify text-darker">
                            beserta alat - alat kelengkapannya telah diperiksa dan diuji di <b class="text-dark">{{$detail->hasAssessmentDetail->hasWorkShop->desc}}/JKR CKM</b>
                            <b class="text-dark">Negeri {{$detail->hasAssessmentDetail->hasState}}</b> dan didapati menepati spesifikasi kontrak. Sebarang aduan dan kecacatan selepas
                            penyerahannya
                            hendaklah dirujuk kepada pihak pembekal selagi dalam tempoh jaminan.
                        </p>
                    </div>
                </div>
            </div>
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
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>
        function show(element){
            $(element).show();
        }


    </script>


</body>

</html>
