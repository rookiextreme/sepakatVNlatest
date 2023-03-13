@php
    $tab = Request('tab') ? Request('tab') : null;
    $TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('03', '02');
    $is_myApp = $detail && $detail->created_by == auth()->user()->id ? true: false;
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
    {{-- import animate tooltip --}}
    <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <link href="{{asset('my-assets/plugins/datatables/datatables.css')}}" rel="stylesheet" type="text/css">

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
    <script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

    <style type="text/css">

        .fancybox__content{
            height: 100vh !important;
        }
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
        /*Change text in autofill textbox*/
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            transition: background-color 5000s ease-in-out 0s;
        }

        /*.input-group-text {
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
        }*/

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
        .announce {
            font-family: helve-bold;
            font-size:40px;
            letter-spacing:-1px;
            line-height:38px;
            color:#000000;
            margin-top:20px;
        }
        .announce div {
            margin-top:5px;
            font-size:20px;
            letter-spacing:-1px;
            line-height:24px;
            color:#3e7090;
        }
        .modal-body {
            /* margin-right:-20px; */
        }
        .awas {
            background-position:top right;
            background-size:150px 160px;
            background-repeat: no-repeat;
            min-height: 400px;
        }
        html {
            scroll-behavior: smooth !important;
        }
        ul.checklist li {
            list-style-type: none;
            font-family: mark-bold;
            font-size:16px;
            line-height:30px;
            margin-left:-10px;
        }
        .back-hailait {
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#f0f9ff+0,cbebff+47,a1dbff+100;Blue+3D+%2313 */
            background: #f0f9ff; /* Old browsers */
            background: -moz-linear-gradient(top,  #f0f9ff 0%, #cbebff 47%, #a1dbff 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top,  #f0f9ff 0%,#cbebff 47%,#a1dbff 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom,  #f0f9ff 0%,#cbebff 47%,#a1dbff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f0f9ff', endColorstr='#a1dbff',GradientType=0 ); /* IE6-9 */
            -webkit-box-shadow: 0px 0px 10px -5px rgba(62,112,144,0.43) !important;
            -moz-box-shadow: 0px 0px 10px -5px rgba(62,112,144,0.43) !important;
            box-shadow: 0px 0px 10px -5px rgba(62,112,144,0.43) !important;
            border-width: 2px;
            border-color:#52819f;
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
        .process-stage {
            position: relative;
            width:100%;
            height:80px;
        }

        .stageline {
            position: absolute;
            top:20px;
            left:-31px;
            right:-101px;
            width:calc(100% + 62px);
            background-color:#DDE0DA;
            height:20px;
            z-index:0;
            border-radius: 12px 12px 0px 0px;
            -moz-border-radius: 12px 12px 0px 0px;
            -webkit-border-radius: 12px 12px 0px 0px;
        }
        .stagecover {
            position: absolute;
            top:26px;
            left:-31px;
            right:-101px;
            width:calc(100% + 62px);
            background-color:#f4f5f2;
            height:15px;
            z-index:0;
            border-radius: 12px 12px 0px 0px;
            -moz-border-radius: 12px 12px 0px 0px;
            -webkit-border-radius: 12px 12px 0px 0px;
        }
        .stagestatus {
            position: absolute;
            top:20px;
            left:-31px;
            right:-101px;
            width:calc(30px + 150px);
            background-color:#3C5C69;
            height:20px;
            z-index:0;
            border-radius: 12px 0px 0px 0px;
            -moz-border-radius: 12px 0px 0px 0px;
            -webkit-border-radius: 12px 0px 0px 0px;
        }
        .stagestatus .cover {
            position: absolute;
            top:6px;
            background-color:#f4f5f2;
            border-radius: 12px 0px 0px 0px;
            -moz-border-radius: 12px 0px 0px 0px;
            -webkit-border-radius: 12px 0px 0px 0px;
            width:100%;
        }
        .stage {
            position: relative;
            display: inline-block;
            text-align: center;
            margin-left:50px;
            padding-top:8px;
        }
        .stage .stagename {
            position: absolute;
            top:43px;
            left:-25px;
            width:80px;
            text-align: center;
            font-family: avenir;
            font-size:10px;
            line-height:10px;
        }
        .stage .num {
            position: relative;
            z-index:1;
            margin-left:auto;
            margin-right:auto;
            background-color:#DDE0DA;
            border-radius: 30px;
            font-size:14px;
            font-family: lato-bold;
            text-align: center;
            width:30px;
            height:30px;
            line-height: 30px;
        }
        .stage .num.done {
            background-color:#3C5C69;
            color:#ffffff;
        }

        /* vehicle process */

        .vehicle-process-stage {
            position: relative;
            white-space: nowrap;
            overflow: auto;
            width:100%;
            height:110px;
        }

        .vehicle-stageline {
            position: absolute;
            top:20px;
            left:-31px;
            right:-101px;
            width:calc(100% + 62px);
            background-color:#DDE0DA;
            height:20px;
            z-index:0;
            border-radius: 12px 12px 0px 0px;
            -moz-border-radius: 12px 12px 0px 0px;
            -webkit-border-radius: 12px 12px 0px 0px;
        }
        .vehicle-stagecover {
            position: absolute;
            top: 20px;
            left: 0px;
            right: -101px;
            width: calc(100%);
            background-color: #f4f5f2;
            height: 7px;
            z-index: 0;
            border-radius: 12px 12px 0px 0px;
            -moz-border-radius: 12px 12px 0px 0px;
            -webkit-border-radius: 12px 12px 0px 0px;
        }
        .vehicle-stagestatus {
            position: absolute;
            top:20px;
            left:0px;
            right:-101px;
            width:0px;
            background-color:#3C5C69;
            height:20px;
            z-index:0;
            border-radius: 12px 0px 0px 0px;
            -moz-border-radius: 12px 0px 0px 0px;
            -webkit-border-radius: 12px 0px 0px 0px;
        }
        .vehicle-stagestatus .cover {
            position: absolute;
            top:6px;
            background-color:#ffffff;
            border-radius: 12px 0px 0px 0px;
            -moz-border-radius: 12px 0px 0px 0px;
            -webkit-border-radius: 12px 0px 0px 0px;
            width:100%;
        }
        .vehicle-stage {
            position: relative;
            display: inline-block;
            text-align: center;
            margin-left:50px;
            padding-top:8px;
        }
        .vehicle-stage .stagename {
            position: absolute;
            top:43px;
            left:-25px;
            width:80px;
            text-align: center;
            font-family: avenir;
            font-size:10px;
            line-height:10px;
            white-space: break-spaces;
        }
        .vehicle-stage .num {
            position: relative;
            z-index:1;
            margin-left:auto;
            margin-right:auto;
            background-color:#DDE0DA;
            border-radius: 30px;
            font-size:14px;
            font-family: lato-bold;
            text-align: center;
            width:30px;
            height:30px;
            line-height: 30px;
        }
        .vehicle-stage .num.done {
            background-color:#3C5C69;
            color:#ffffff;
        }

        /* end vehicle process */

        .cux-btn:hover {
            border-bottom-width: 2px;
        }

        .fancybox__container {
            z-index: 1060;
        }
    </style>
</head>
<body class="content">
    <div class="mytitle">Servis Dan Pembaikan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('maintenance.overview') }}')">Servis Dan Pembaikan</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('maintenance.job.list') }}">Rekod Servis Dan Pembaikan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
        </ol>
    </nav>
    <div class="process-stage">
        <div class="stageline">&nbsp</div>
        <div class="stagecover">&nbsp</div>
        @php
            $stage = 0;
            if (!$detail || $detail && in_array($detail->hasStatus->code, ['01'])) {
                $stage = 65;
            } else if ($detail && in_array($detail->hasStatus->code, ['02'])) {
                $stage = 150;
            } else if ($detail && in_array($detail->hasStatus->code, ['03','04'])) {
                $stage = 235;
            } else if ($detail && in_array($detail->hasStatus->code, ['03','04','08'])) {
                $stage = 320;
            }
        @endphp
        <!--
            85px per stage

            e.g
            Stage 1 : +65px;
            Stage 2 : +150px;
            Stage 3 : +235px;
            Stage 4 : +320px;
            Stage 5 : +405px;

            stagestatus = blue line status
        -->
        <div class="stagestatus" style="width:calc(30px + {{$stage}}px);">
            <div class="cover">&nbsp</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']) ? 'done': ''}}">1</div>
            <div class="stagename">Permohonan</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']) ? 'done': ''}}">2</div>
            <div class="stagename">Temujanji</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['03','04','05','08']) ? 'done': ''}}">3</div>
            <div class="stagename">Penilaian</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['08']) ? 'done': ''}}">4</div>
            <div class="stagename">Selesai</div>
        </div>
        {{-- <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['08']) ? 'done': ''}}">5</div>
            <div class="stagename">Sijil</div>
        </div> --}}
    </div>
    <div class="main-content">
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                        <li class="cub-tab active" onClick="goTab(this, 'application');" id="tab1">Permohonan</li>
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
                        <li class="cub-tab"  onClick="goTab(this, 'vehicle');" id="tab2">Kenderaan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
                        <li class="cub-tab"  onClick="goTab(this, 'appointment');" id="tab3">Temujanji</li>
                    @endif
                    @if ($detail && $detail &&
                        (
                            (in_array($detail->hasStatus->code, ['03','04','05','08']) && ($TaskFlowAccessMaintenanceJob->mod_fleet_verify || $TaskFlowAccessMaintenanceJob->mod_fleet_approval)) ||
                            (in_array($detail->hasStatus->code, ['08']) && auth()->user()->isPublic())
                        )
                    )
                        <li class="cub-tab"  onClick="goTab(this, 'assessment');" id="tab4">Penilaian</li>
                    @endif
                    {{-- @if ($detail && $detail && in_array($detail->hasStatus->code, ['04','05','08']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                        <li class="cub-tab"  onClick="goTab(this, 'job');" id="tab5">Semakan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['05','08']) && (auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()))
                        <li class="cub-tab"  onClick="goTab(this, 'approval');" id="tab6">Kelulusan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['08']))
                        <li class="cub-tab"  onClick="goTab(this, 'certificate');" id="tab7">Sijil</li>
                    @endif --}}
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="application" class="tab-content">
            @include('maintenance.job.tab.job-application')
        </section>
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
        <section id="vehicle" class="tab-content">
            @include('maintenance.job.tab.job-vehicle')
        </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
            <section id="appointment" class="tab-content">
                @include('maintenance.job.tab.job-appointment')
            </section>
        @endif
        @if ($detail && $detail &&
                (
                    (in_array($detail->hasStatus->code, ['03','04','05','08']) && ($TaskFlowAccessMaintenanceJob->mod_fleet_verify || $TaskFlowAccessMaintenanceJob->mod_fleet_approval)) ||
                    (in_array($detail->hasStatus->code, ['08']) && auth()->user()->isPublic())
                )
            )
            <section id="assessment" class="tab-content">
                @include('maintenance.job.tab.job-assessment')
            </section>
        @endif
        {{-- @if ($detail && $detail && in_array($detail->hasStatus->code, ['04','05','08']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
            <section id="job" class="tab-content">
                @include('maintenance.job.tab.job-evaluation')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['05','08']) && (auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()))
            <section id="approval" class="tab-content">
                @include('maintenance.job.tab.job-approval')
            </section>
        @endif

        @if ($detail && $detail && in_array($detail->hasStatus->code, ['08']))
            <section id="certificate" class="tab-content">
                @include('maintenance.job.tab.job-certificate')
            </section>
        @endif --}}

        <div class="modal fade" id="examinationApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form class="row" id="frm_examination">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                                <input type="hidden" name="section" value="examination">

                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 text-center">
                                Adakah anda ingin menghantar maklumat ini untuk proses pemeriksaan?
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button class="btn btn-module" type="submit">Ya</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="verifyApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true" style="margin-top:10vh">
            <div class="modal-dialog modal-lg">
                <form class="row" id="frm_verify">
                    @csrf
                    <div class="modal-content tanda">
                        <div class="modal-body awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                            <input type="hidden" name="section" value="verify">
                            <div class="announce">Makluman<div> Sila ambil maklum berkenaan dengan dokumen sokongan yang<br/>perlu anda bawa semasa menghantar kenderaan</div></div>
                            <hr>
                            <ul class="checklist">
                                <li><i class="fal fa-check fa-lg"></i> Borang Kew.Pa-10</li>
                                <li><i class="fal fa-check fa-lg"></i> Surat Permohonan Penyenggaraan</li>
                                <li class="mt-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <i class="fal fa-check fa-lg"></i> Surat Serahan Kenderaan
                                        </div>
                                        <div class="col-md-6">
                                            <span class="ms-2 btn cux-btn back-hailait" data-url="{{asset('/borang/borang_serahan_kenderaan_module_penyenggaraan.pdf')}}" data-download="" onclick="fancyView(this)"><i class="fal fa-file-pdf"></i> Muat Turun Surat</span>
                                        </div>
                                    </div>

                                </li>
                            </ul>

                            <div class="col-xl-10 col-lg-10 col-md-10 col-12">
                                <div class="form-check" style="height: unset;">
                                    <input class="form-check-input" type="checkbox" value="" id="aggrement" required  oninvalid="this.setCustomValidity('Sila tandakan kotak ini jika anda mahu meneruskan')"
                                    oninput="this.setCustomValidity('')">
                                    <label class="form-check-label cursor-pointer" style="line-height: 24px;" for="aggrement">
                                        Saya dengan ini mengisyitiharkan segala maklumat yang diberikan adalah benar dan tidak bercanggah dengan mana-mana peraturan. Permohonan
                                        ini akan terbatal sekiranya tiada maklumbalas dalam temujanji seperti yang dimaklumkan (emel/surat/panggilan telefon) dalam 30 tempoh hari bekerja.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button class="btn btn-module" type="submit">Hantar Permohonan</button>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal <i class="fal fa-undo"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vWorkflowModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vWorkflowModalLabel" aria-hidden="true" style="margin-top:10vh">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="vehicle-process-stage" id="vehicle-process-stage-scroller" style="
                        border-radius: 30px;
                        ">
                        <div class="vehicle-stagecover"></div>

                        <div class="vehicle-stagestatus">
                            <div class="cover">&nbsp;</div>
                        </div>
                        <div class="vehicle-stage">
                            <div class="num done">1</div>
                            <div class="stagename">Permohonan</div>
                        </div>
                        <div class="vehicle-stage">
                            <div class="num {{$detail && $detail->hasAssistantEngineerBy ? 'done': ''}}">2</div>
                            <div class="stagename">Set Penolong Jurutera</div>
                        </div>
                        <div class="vehicle-stage">
                            <div class="num {{$detail && $detail->appointment_dt ? 'done': ''}}">3</div>
                            <div class="stagename">Set Temujanji <span class="assign d-block" style="font-size: 10px;">{{$detail && $detail->hasAssistantEngineerBy ? ' ('.$detail->hasAssistantEngineerBy->name.')': ''}}</span></div>
                        </div>
                        <div class="vehicle-stage foremen-internal">
                            <div class="num">4</div>
                            <div class="stagename">Membuat Pemeriksaan <span class="assign d-block" style="font-size: 10px;"></span></div>
                        </div>
                        <div class="vehicle-stage">
                            <div class="num">5</div>
                            <div class="stagename">Menyemak Pemeriksaan <span class="assign d-block" style="font-size: 10px;">{{$detail && $detail->hasAssistantEngineerBy ? ' ('.$detail->hasAssistantEngineerBy->name.')': ''}}</span></div>
                        </div>

                        <div class="vehicle-stage">
                            <div class="num">6</div>
                            <div class="stagename">Mengesahkan Pemeriksaan</div>
                        </div>


                        {{-- Start Jika ada kajian pasaran --}}
                        <div style="display: none;" id="has_research_market">
                            <div class="vehicle-stage" id="stage-7">
                                <div class="num">7</div>
                                <div class="stagename">Sediakan Kajian Pasaran <span class="assign d-block" style="font-size: 10px;">{{$detail && $detail->hasAssistantEngineerBy ? ' ('.$detail->hasAssistantEngineerBy->name.')': ''}}</span></div>
                            </div>
                            <div class="vehicle-stage" id="stage-8">
                                <div class="num">8</div>
                                <div class="stagename">Semakan Kajian Pasaran {{$detail && $detail->hasAssistantEngineerBy ? ' ('.$detail->hasAssistantEngineerBy->name.')': ''}}</div>
                            </div>
                            <div class="vehicle-stage" id="stage-9">
                                <div class="num">9</div>
                                <div class="stagename">Sahkan Kajian Pasaran</div>
                            </div>
                            <div class="vehicle-stage" id="stage-10">
                                <div class="num">10</div>
                                <div class="stagename">Sediakan Jadual Harga {{$detail && $detail->hasAssistantEngineerBy ? ' ('.$detail->hasAssistantEngineerBy->name.')': ''}}</div>
                            </div>
                            <div class="vehicle-stage" id="stage-11">
                                <div class="num">11</div>
                                <div class="stagename">Semakan Jadual Harga (Jurutera)</div>
                            </div>
                            <div class="vehicle-stage" id="stage-12">
                                <div class="num">12</div>
                                <div class="stagename">Pengesahan Jadual Harga (Jurutera Kanan)</div>
                            </div>

                                <div style="display: none;" id="has_maintain_internal">

                                    <div class="vehicle-stage" id="stage-13">
                                        <div class="num">13</div>
                                        <div class="stagename">Senggara <br/>(Servis Dalaman)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-14">
                                        <div class="num">14</div>
                                        <div class="stagename">Semakan Senggara <br/>(Servis Dalaman) {{$detail && $detail->hasAssistantEngineerBy ? ' ('.$detail->hasAssistantEngineerBy->name.')': ''}}</div>
                                    </div>

                                </div>

                                <div style="display: none;" id="has_maintain_external">
                                    <div class="vehicle-stage" id="stage-15">
                                        <div class="num">15</div>
                                        <div class="stagename">Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-16">
                                        <div class="num">16</div>
                                        <div class="stagename">Semakan Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-17">
                                        <div class="num">17</div>
                                        <div class="stagename">Selesai</div>
                                    </div>
                                </div>

                                <div style="display: none;" id="has_maintain_external_only">
                                    <div class="vehicle-stage" id="stage-13">
                                        <div class="num">13</div>
                                        <div class="stagename">Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-14">
                                        <div class="num">14</div>
                                        <div class="stagename">Semakan Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-15">
                                        <div class="num">15</div>
                                        <div class="stagename">Selesai</div>
                                    </div>
                                </div>
                        </div>
                        {{-- End Jika ada kajian pasaran  --}}

                        {{-- Start Jika tiada kajian pasaran --}}
                        <div style="display: none;" id="has_not_research_market">

                                <div style="display: none;" id="has_maintain_internal">
                                    <div class="vehicle-stage" id="stage-7">
                                        <div class="num">7</div>
                                        <div class="stagename">Senggara <br/>(Servis Dalaman)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-8">
                                        <div class="num">8</div>
                                        <div class="stagename">Semakan Senggara <br/>(Servis Dalaman)</div>
                                    </div>
                                </div>

                                <div style="display: none;" id="has_maintain_external">
                                    <div class="vehicle-stage" id="stage-10">
                                        <div class="num">10</div>
                                        <div class="stagename">Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-11">
                                        <div class="num">11</div>
                                        <div class="stagename">Semakan Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-12">
                                        <div class="num">12</div>
                                        <div class="stagename">Selesai</div>
                                    </div>
                                </div>

                                <div style="display: none;" id="has_maintain_external_only">
                                    <div class="vehicle-stage" id="stage-7">
                                        <div class="num">7</div>
                                        <div class="stagename">Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-8">
                                        <div class="num">8</div>
                                        <div class="stagename">Semakan Pemantauan <br/>(Secara Luaran)</div>
                                    </div>
                                    <div class="vehicle-stage" id="stage-9">
                                        <div class="num">9</div>
                                        <div class="stagename">Selesai</div>
                                    </div>
                                </div>

                                <div style="display: none;" id="has_not_maintain_external">
                                    <div class="vehicle-stage" id="stage-9">
                                        <div class="num">9</div>
                                        <div class="stagename">Selesai</div>
                                    </div>
                                </div>
                        </div>
                        {{-- End Jika ada kajian pasaran  --}}

                    </div>

                    <div class="d-flex justify-content-center">
                        <div style="font-size: 30px;font-family: 'lato-bold';border: 3px solid #3c5b69;padding-left: 5px;padding-right: 5px;color: #3d5a68;" id="currentStage"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
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

        function fileUrl(fileName, format){
            if(format == 'pdf'){
                window.open('/borang/'+fileName);
            } else {
                window.location.assign('/borang/'+fileName);
            }
        }

        const fancyView = function(self){
            let url = $(self).data('url');
            let is_download = $(self).data('download');

            if(is_download){
                window.location.replace(url);
            } else {
                const fancybox = new Fancybox([
                {
                    src: url,
                    type: "pdf",
                },
                ]);

                fancybox.on("done", (fancybox, slide) => {
                console.log(`done!`);
                });
            }
        }

        function submitVerify(data) {

            $('[name="app_dates"]').html('');

                parent.startLoading();
                $.ajax({
                    url: "{{ route('maintenance.job.register.save') }}",
                    type: 'post',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    success: function(response) {
                        console.log(response);
                        window.location = response['url'];
                    },
                    error: function(response) {
                        console.log(response);
                        var errors = response.responseJSON.errors;

                        $.each(errors, function(key, value) {

                            if(key == 'app_dates'){
                                if($('[name="'+key+'"]').find('.hasErr').length == 0){
                                    console.log(value[0]);
                                    $('[name="'+key+'"]').html('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                                }
                            }
                            else if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                                if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                    $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                                }
                            } else {
                                if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                    $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                                }
                            }
                        });

                        parent.stopLoading();
                    }
                });
        }

        currentWorkflowVehicle = function(self){
            let vVehicle = $(self).parent().parent().data('vehicle');
            let foremen = $(self).parent().parent().data('vehicle-foremen');
            let vStatus = $(self).parent().parent().data('status');
            let vForm = $(self).parent().parent().data('vehicle-form');
            let vFormStatus = $(self).parent().parent().data('vehicle-form-status');
            let vFormInternal = $(self).parent().parent().data('vehicle-form-maintenance-internal');
            let vFormExternal = $(self).parent().parent().data('vehicle-form-maintenance-external');
            let process = 80;

            $('.vehicle-stage:gt(2) .num.done').removeClass('done');
            $('#has_research_market').hide();
            $('#has_not_research_market').hide();
            $('#has_maintain_internal').hide();
            $('#has_maintain_external').hide();
            $('#has_maintain_external_only').hide();

            @if (
                (env('APP_ENV') !== 'production') || 
                session()->get('session_switch_admin_id')
                )
                console.log(vVehicle);
                console.log(foremen);
                console.log(vStatus);
                console.log(vForm);
                console.log(vFormStatus);
                console.log(vFormInternal);
                console.log(vFormExternal);
            @endif

            let forementStage = $('.foremen-internal .stagename .assign');
            if(foremen){
                forementStage.text('('+foremen.name+')');
            }

            if(vStatus.code == '01'){
                process = process * 2;
                @if ($detail && $detail->hasAssistantEngineerBy)
                    process += 80;
                @endif

                @if ($detail && $detail->appointment_dt)
                    process += 80;
                @endif

                let currentStage = $('#currentStage');
                let stageNow = $('.vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();

                currentStage.text(stageNow);

            } else if(vStatus.code == '06' || vStatus.code == '08'){
                process = process * 4;

                if(vFormStatus.code == '03'){
                    process += 80;
                    $('.vehicle-stage:nth(3) .num').addClass('done');
                }

                if(vForm){

                    if(vForm.is_research_market == 1){

                        $('.vehicle-stage:nth(3) .num').addClass('done');
                        $('.vehicle-stage:nth(4) .num').addClass('done');
                        $('.vehicle-stage:nth(5) .num').addClass('done');

                        $('#has_research_market').css('display', 'inline-flex');

                        if(vFormStatus.code == '04'){
                            process += 80;
                            if(vForm.rsm_prepared_by){
                                $('.vehicle-stage:nth(6) .num').addClass('done');
                            }
                        }

                        if(vFormStatus.code == '05'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            process += 320;
                        }

                        if(vFormStatus.code == '06'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            process += 400;
                            if(vForm.rsm_prepared_by){
                                $('.vehicle-stage:nth(7) .num').addClass('done');
                            }
                        }

                        if(vFormStatus.code == '08'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            process += 480;
                        }

                        if(vFormStatus.code == '09'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            process += 560;
                        }

                        if(vFormStatus.code == '10'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            $('.vehicle-stage:nth(10) .num').addClass('done');
                            process += 640;
                        }

                        if(vFormStatus.code == '11'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            $('.vehicle-stage:nth(10) .num').addClass('done');
                            $('.vehicle-stage:nth(11) .num').addClass('done');
                            process += 720;

                            console.log('vFormInternal.code => ', vFormInternal.code);

                            if(vFormInternal.code == '01'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                            if(vFormInternal.code == '02'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                                $('.vehicle-stage:nth(12) .num').addClass('done');
                                process += 80;
                            }

                            if(vFormInternal.code == '07'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                            if(vFormInternal.code == '03'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                                $('.vehicle-stage:nth(12) .num').addClass('done');
                                $('.vehicle-stage:nth(13) .num').addClass('done');
                                process += 80;
                            }

                            if(vFormExternal && !vFormInternal){
                                $('#has_maintain_external_only').css('display', 'inline-flex');

                                if(vFormExternal.code == '05'){
                                    process += 80;
                                    console.log('here laa');
                                    $('#has_maintain_external_only .vehicle-stage:nth(0) .num').addClass('done');
                                }

                            } else if(vFormInternal.code == '03' && vFormExternal){
                                $('#has_maintain_external').css('display', 'inline-flex');
                                process += 80;

                                if(vFormExternal.code == '05'){
                                    $('.vehicle-stage:nth(13) .num').addClass('done');
                                    $('.vehicle-stage:nth(14) .num').addClass('done');
                                    process += 80;
                                }

                                if(vFormExternal.code == '06'){
                                    $('.vehicle-stage:nth(13) .num').addClass('done');
                                    $('.vehicle-stage:nth(14) .num').addClass('done');
                                    $('.vehicle-stage:nth(15) .num').addClass('done');
                                    process += 80;
                                }
                            }

                        }

                        if(vFormStatus.code == '12'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            $('.vehicle-stage:nth(10) .num').addClass('done');
                            $('.vehicle-stage:nth(11) .num').addClass('done');
                            $('.vehicle-stage:nth(12) .num').addClass('done');
                            $('.vehicle-stage:nth(13) .num').addClass('done');
                            $('.vehicle-stage:nth(14) .num').addClass('done');
                            $('.vehicle-stage:nth(15) .num').addClass('done');
                            $('.vehicle-stage:nth(16) .num').addClass('done');
                            $('.vehicle-stage:nth(17) .num').addClass('done');
                            process += 720;

                            if(vFormInternal){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                            if(vFormExternal && !vFormInternal){
                                $('#has_maintain_external_only').css('display', 'inline-flex');
                                $('#has_maintain_external_only .vehicle-stage:nth(1) .num').addClass('done');
                                $('#has_maintain_external_only .vehicle-stage:nth(2) .num').addClass('done');
                                $('#has_maintain_external_only .vehicle-stage:nth(3) .num').addClass('done');
                                process += 160;
                            }
                            else if(vFormExternal){
                                $('#has_maintain_external').css('display', 'inline-flex');
                                process += 320;
                            }
                        }

                        let currentStage = $('#currentStage');
                        let stageNow = $('.vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();

                        setTimeout(() => {
                            console.log('vStatus.code => ',vStatus.code);
                            console.log('vFormInternal.code => ',vFormInternal.code);
                            console.log('vFormExternal.code => ',vFormExternal.code);
                            if(vStatus.code == '08'){
                                stageNow = $('#has_research_market:visible > .vehicle-stage .num.done:last ~ .stagename').text();

                                stageNow = $('#has_maintain_external:visible > .vehicle-stage .num.done:last ~ .stagename').text();

                                stageNow = $('#has_maintain_external_only:visible > .vehicle-stage .num.done:last ~ .stagename').text();

                                console.log(stageNow);
                            }

                            else if(vFormInternal.code == '07' && $('#has_maintain_internal:visible').length > 0){
                                $('#has_maintain_internal:visible > .vehicle-stage .num:first ~ .stagename').html('Senggara (Servis Dalaman)'+' ('+foremen.name+')');
                                stageNow = $('#has_maintain_internal:visible > .vehicle-stage .num:first ~ .stagename').text();
                            }

                            else if(vFormExternal.code == '06'){
                                stageNow = $('#has_maintain_external:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                currentStage.text(stageNow);
                            }
                            else if(vFormExternal.code == '03' && vFormInternal){
                                stageNow = $('#has_maintain_external:visible > .vehicle-stage .num.done:last ~ .stagename').text();

                            } 
                            else if((vFormExternal.code == '04' || vFormExternal.code == '08') && $('#has_maintain_external:visible').length > 0){
                                $('#has_maintain_external:visible > .vehicle-stage .num:first ~ .stagename').html('Pemantauan (Secara Luaran)'+' ('+foremen.name+')');
                                stageNow = $('#has_maintain_external:visible > .vehicle-stage .num:first ~ .stagename').text();
                            } 
                            else if(vFormExternal && !vFormInternal){

                                console.log('xda internal');
                                
                                if( $('#has_maintain_external_only:visible > .vehicle-stage .num.done').length == 0){
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage:first .stagename').text();
                                    console.log('1');
                                } else if( $('#has_maintain_external_only:visible > .vehicle-stage .num.done').length > 0 && vStatus.code != '08'){
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();
                                    console.log('2');
                                } else if($('#has_research_market:visible > .vehicle-stage .num.done:last').parent().next().length > 0){
                                    stageNow = $('#has_research_market:visible > .vehicle-stage .num.done:last').parent().next().text();
                                }
                                else {
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                    console.log('3');
                                }
                            }

                            currentStage.text(stageNow);
                        }, 400);

                    } else if(vForm.is_research_market_external == 1){

                        $('.vehicle-stage:nth(3) .num').addClass('done');
                        $('.vehicle-stage:nth(4) .num').addClass('done');
                        $('.vehicle-stage:nth(5) .num').addClass('done');

                        $('#has_research_market').css('display', 'inline-flex');

                        if(vFormStatus.code == '04'){
                            process += 80;
                            if(vForm.rsm_prepared_by){
                                $('.vehicle-stage:nth(6) .num').addClass('done');
                            }
                        }

                        if(vFormStatus.code == '05'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            process += 320;
                        }

                        if(vFormStatus.code == '06'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            process += 400;
                            if(vForm.rsm_prepared_by){
                                $('.vehicle-stage:nth(7) .num').addClass('done');
                            }
                        }

                        if(vFormStatus.code == '08'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            process += 480;
                        }

                        if(vFormStatus.code == '09'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            process += 560;
                        }

                        if(vFormStatus.code == '10'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            $('.vehicle-stage:nth(10) .num').addClass('done');
                            process += 640;
                        }

                        if(vFormStatus.code == '11'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            $('.vehicle-stage:nth(10) .num').addClass('done');
                            $('.vehicle-stage:nth(11) .num').addClass('done');
                            process += 720;

                            console.log('vFormInternal.code => ', vFormInternal.code);

                            if(vFormInternal.code == '01'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                            if(vFormInternal.code == '02'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                                $('.vehicle-stage:nth(12) .num').addClass('done');
                                process += 80;
                            }

                            if(vFormInternal.code == '07'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                            if(vFormInternal.code == '03'){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                                $('.vehicle-stage:nth(12) .num').addClass('done');
                                $('.vehicle-stage:nth(13) .num').addClass('done');
                                process += 80;
                            }

                            if(vFormExternal && !vFormInternal){
                                $('#has_maintain_external_only').css('display', 'inline-flex');

                                if(vFormExternal.code == '05'){
                                    process += 80;
                                    console.log('here laa');
                                    $('#has_maintain_external_only .vehicle-stage:nth(0) .num').addClass('done');
                                }

                            } else if(vFormInternal.code == '03' && vFormExternal){
                                $('#has_maintain_external').css('display', 'inline-flex');
                                process += 80;

                                if(vFormExternal.code == '05'){
                                    $('.vehicle-stage:nth(13) .num').addClass('done');
                                    $('.vehicle-stage:nth(14) .num').addClass('done');
                                    process += 80;
                                }

                                if(vFormExternal.code == '06'){
                                    $('.vehicle-stage:nth(13) .num').addClass('done');
                                    $('.vehicle-stage:nth(14) .num').addClass('done');
                                    $('.vehicle-stage:nth(15) .num').addClass('done');
                                    process += 80;
                                }
                            }

                        }

                        if(vFormStatus.code == '12'){
                            $('.vehicle-stage:nth(6) .num').addClass('done');
                            $('.vehicle-stage:nth(7) .num').addClass('done');
                            $('.vehicle-stage:nth(8) .num').addClass('done');
                            $('.vehicle-stage:nth(9) .num').addClass('done');
                            $('.vehicle-stage:nth(10) .num').addClass('done');
                            $('.vehicle-stage:nth(11) .num').addClass('done');
                            $('.vehicle-stage:nth(12) .num').addClass('done');
                            $('.vehicle-stage:nth(13) .num').addClass('done');
                            $('.vehicle-stage:nth(14) .num').addClass('done');
                            $('.vehicle-stage:nth(15) .num').addClass('done');
                            $('.vehicle-stage:nth(16) .num').addClass('done');
                            $('.vehicle-stage:nth(17) .num').addClass('done');
                            process += 720;

                            if(vFormInternal){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                            if(vFormExternal && !vFormInternal){
                                $('#has_maintain_external_only').css('display', 'inline-flex');
                                $('#has_maintain_external_only .vehicle-stage:nth(1) .num').addClass('done');
                                $('#has_maintain_external_only .vehicle-stage:nth(2) .num').addClass('done');
                                $('#has_maintain_external_only .vehicle-stage:nth(3) .num').addClass('done');
                                process += 160;
                            }
                            else if(vFormExternal){
                                $('#has_maintain_external').css('display', 'inline-flex');
                                process += 320;
                            }
                        }

                        let currentStage = $('#currentStage');
                        let stageNow = $('.vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();

                        setTimeout(() => {
                            console.log('vStatus.code ', vStatus.code);
                            if(vStatus.code == '06' || vStatus.code == '08'){
                                if($('#has_research_market:visible > .vehicle-stage .num.done:last').length > 0){
                                    console.log('masuk sini');
                                    stageNow = $('#has_research_market:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                } 
                                else if($('#has_maintain_internal:visible > .vehicle-stage .num.done:last').length > 0){
                                    stageNow = $('#has_maintain_internal:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                } 
                                else if($('#has_maintain_external:visible > .vehicle-stage .num.done:last').length > 0){
                                    stageNow = $('#has_maintain_external:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                } else {
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                }
                            }

                            else if(vFormExternal.code == '06'){
                                stageNow = $('#has_maintain_external:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                currentStage.text(stageNow);
                            }
                            else if(vFormExternal.code == '03' && vFormInternal){
                                stageNow = $('#has_maintain_external:visible > .vehicle-stage .num.done:last ~ .stagename').text();

                            } else if(vFormExternal && !vFormInternal){
                                if( $('#has_maintain_external_only:visible > .vehicle-stage .num.done').length == 0){
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage:first .stagename').text();
                                } else if( $('#has_maintain_external_only:visible > .vehicle-stage .num.done').length > 0 && vStatus.code != '08'){
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();
                                } else {
                                    stageNow = $('#has_maintain_external_only:visible > .vehicle-stage .num.done:last ~ .stagename').text();
                                }
                            }

                            currentStage.text(stageNow);
                        }, 400);

                    }
                    
                    else if(!vForm.is_research_market && (vFormInternal.code == "01" || vFormInternal.code == "02" || vFormInternal.code == "03" || vFormInternal.code == "07" || vFormExternal) ){

                        $('.vehicle-stage:nth(3) .num').addClass('done');
                        $('.vehicle-stage:nth(4) .num').addClass('done');
                        $('.vehicle-stage:nth(5) .num').addClass('done');

                        $('#has_not_research_market').css('display', 'inline-flex');

                        if(vFormStatus.code == '11'){
                            $('.vehicle-stage:nth(5) .num').addClass('done');
                            process += 240;

                            if(vFormInternal.code == '02'){
                                $('#has_not_research_market .vehicle-stage:nth(0) .num').addClass('done');
                                process += 80;
                            }

                            if(vFormInternal.code == '03'){
                                $('#has_not_research_market .vehicle-stage:nth(0) .num').addClass('done');
                                $('#has_not_research_market .vehicle-stage:nth(1) .num').addClass('done');
                                process += 80;
                            }

                            if(vFormExternal && !vFormInternal){
                                $('#has_not_research_market #has_maintain_external_only').css('display', 'inline-flex');
                            }
                            else if(vFormExternal){
                                $('#has_not_research_market #has_maintain_external').css('display', 'inline-flex');
                                //process += 80;

                                if(vFormExternal.code == '05'){
                                    $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(0) .num').addClass('done');
                                    process += 80;
                                }

                                if(vFormExternal.code == '06'){
                                    $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(0) .num').addClass('done');
                                    $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(1) .num').addClass('done');
                                    $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(2) .num').addClass('done');
                                    process += 80;
                                }
                            } else if(vFormInternal){
                                $('#has_maintain_internal').css('display', 'inline-flex');
                            }

                        }

                        if(vFormStatus.code == '12'){

                            process += 80;

                            if(vFormExternal && !vFormInternal){
                                $('#has_not_research_market #has_maintain_external_only').css('display', 'inline-flex');
                                $('#has_not_research_market #has_maintain_external_only .vehicle-stage:nth(0) .num').addClass('done');
                                $('#has_not_research_market #has_maintain_external_only .vehicle-stage:nth(1) .num').addClass('done');
                                $('#has_not_research_market #has_maintain_external_only .vehicle-stage:nth(2) .num').addClass('done');
                                process += 160;
                            } else if(vFormExternal){
                                $('#has_not_research_market #has_maintain_external').css('display', 'inline-flex');
                                $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(0) .num').addClass('done');
                                $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(1) .num').addClass('done');
                                $('#has_not_research_market #has_maintain_external .vehicle-stage:nth(2) .num').addClass('done');
                                process += 160;
                            }

                            if(!vFormExternal){
                                $('#has_not_research_market #has_not_maintain_external').css('display', 'inline-flex');
                                $('#has_not_research_market #has_not_maintain_external .vehicle-stage:nth(0) .num').addClass('done');
                            }
                        }

                        let currentStage = $('#currentStage');
                        let stageNow = $('#has_not_research_market .vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();

                        if($('#has_not_research_market .vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').length == 0){
                            stageNow = $('#has_not_research_market > .vehicle-stage:first .stagename').text();
                        }

                        if(vFormInternal.code == '01'){
                            if(foremen){
                                stageNow += '('+foremen.name+')';
                            }
                        } else if(vFormInternal.code == '02'){
                            @if ($detail && $detail->hasAssistantEngineerBy)
                                stageNow += "({{$detail->hasAssistantEngineerBy->name}}";
                            @endif
                        } else{
                            if(foremen){
                                stageNow += '('+foremen.name+')';
                            }
                        }

                        if(vFormInternal.code == '03'){
                            process += 160;
                        }

                        if(vFormExternal.code == '06'){
                            process += 160;
                        }

                        setTimeout(() => {
                            console.log(vFormExternal.code);
                            if(vFormExternal.code == '05' && !vFormInternal){
                                stageNow = stageNow = $('#has_not_research_market #has_maintain_external .vehicle-stage .num.done:last').parent().next().find('.stagename').text();
                                if($('#has_not_research_market #has_maintain_external .vehicle-stage .num.done').length == 0){
                                    stageNow = $('#has_not_research_market #has_maintain_external > .vehicle-stage:first .stagename').text();
                                }
                            } else if(vFormExternal.code == '06' && !vFormInternal && vFormStatus.code == '12'){
                                stageNow = $('#has_not_research_market #has_maintain_external .vehicle-stage:last .stagename').text();
                            }
                            else if(vStatus.code == '08'){
                                stageNow = $('.vehicle-stage .num.done:last ~ .stagename').text();
                            }

                            currentStage.text(stageNow);
                        }, 500);

                        console.log('here 2');

                    } else {
                        let currentStage = $('#currentStage');
                        let stageNow = $('.vehicle-stage .num.done:last ~ .stagename').parent().next().find('.stagename').text();

                        currentStage.text(stageNow);
                    }
                }
            }


            $('.vehicle-stagestatus').css({
                width: process+'px'
            });

            let vWorkflow = $('#vWorkflowModal');
            vWorkflow.modal('show');

            setTimeout(() => {
                const vScrollContainer = document.getElementById('vehicle-process-stage-scroller');
                const vScrollWidth = vScrollContainer.scrollWidth;

                $('#vehicle-process-stage-scroller').animate({scrollLeft: vScrollWidth - vScrollContainer.clientWidth });

                if(vFormInternal && vFormInternal.code == '01' && vFormStatus.code == '11'){
                    let currentStage = $('#currentStage');
                    stageNow = $('#has_maintain_internal:visible .stagename:first').text() +' ('+foremen.name+')';
                    currentStage.text(stageNow);
                }

            }, 500);

        }
        $(document).ready(function(){

            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                if(popoverTriggerEl){
                    if($(popoverTriggerEl).data('bs-content')){
                        return new bootstrap.Popover(popoverTriggerEl)
                    }
                }
            })
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic"
            });

            $('.verify').on('click', function(e){
                e.preventDefault();
                let modal = $('#verifyApplicationModal');
                modal.modal('show');

            });
            $('#frm_verify').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                submitVerify(formData);

            });

            $('.examination').on('click', function(e){
                e.preventDefault();
                let modal = $('#examinationApplicationModal');
                modal.modal('show');

            });

            $('#frm_examination').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                submitApplication(formData);

            });

        });
    </script>
</body>
</html>

