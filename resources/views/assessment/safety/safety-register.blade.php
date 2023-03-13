@php
    use Illuminate\Http\Request;

    $tab = Request('tab') ? Request('tab') : null;
    $TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
    $is_myApp = $detail && $detail->created_by == auth()->user()->id ? true: false;
    $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;
    use App\Models\Assessment\AssessmentSafetyVehicle;

    if($detail){
        $queryEvaluation = AssessmentSafetyVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '06');
            })->get();
        $queryApproval = AssessmentSafetyVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '03');
            })->get();

        $totalEvaluation = count($queryEvaluation);
        $totalApproval = count($queryApproval);
    }
    $id = Request('id');
    $status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';

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
            font-size:30px;
            letter-spacing:-1px;
            line-height:28px;
            color:#000000;
            margin-top:20px;
        }
        .announce div {
            margin-top:15px;
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
        }
        html {
            scroll-behavior: smooth !important;
        }
        ul.checklist li {
            list-style-type: none;
            font-family: mark-bold;
            font-size:16px;
            line-height:30px;
            margin-left:-30px;
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
            left:-20px;
            width:70px;
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

        .display-logo-footer {
            display: none;
            margin: 20px;
        }

        @media print {
            @page {
                margin: 0;
                size: 'A4' portrait; /* auto is default portrait; */
            }

            .hideWhenPrintByModal {
                display: none;
            }

            .display-logo-footer {
                display: block;
                position: fixed;
                bottom: 0;
                right: 0;
            }

            body {
                background-color: white;
            }

            .modal-backdrop {
                background-color: transparent;
            }

        }
    </style>
</head>
<body class="content">
    <div class="mytitle ">Penilaian <span>Keselamatan & Prestasi</span></div>
    <nav aria-label="breadcrumb" class="">
        <ol class="breadcrumb">
            @if($roleAccessCode == '04')
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.public.dashboard')}}');">
                <i class="fal fa-home"></i></a>
            </li>
            @else
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('assessment.overview') }}')">Penilaian</a></li>
            @endif
            <li class="breadcrumb-item">
                <a href="{{ route('assessment.safety.list', ['status_code' => $status_code]) }}">Rekod Penilaian</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
        </ol>
    </nav>
    @if($roleAccessCode == '01' || $roleAccessCode == '03')
    <div class="process-stage ">
        <div class="stageline">&nbsp</div>
        <div class="stagecover">&nbsp</div>
        @php
            $stage = 0;
            if (!$detail || $detail && in_array($detail->hasStatus->code, ['01'])) {
                $stage = 65;
            } else if ($detail && in_array($detail->hasStatus->code, ['02'])) {
                $stage = 150;
            } else if ($detail && in_array($detail->hasStatus->code, ['03','04'])) {
                $stage = 320;
            } else if ($detail && in_array($detail->hasStatus->code, ['05'])) {
                $stage = 405;
            } else if ($detail && in_array($detail->hasStatus->code, ['08'])) {
                $stage = 490;
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
            <div class="stagename">Pemohon</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']) ? 'done': ''}}">2</div>
            <div class="stagename">Penolong Jurutera</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['03','04','05','08']) ? 'done': ''}}">3</div>
            <div class="stagename">Pembantu Kemahiran</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['04','05','08']) ? 'done': ''}}">4</div>
            <div class="stagename">Penolong Jurutera</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['05','08']) ? 'done': ''}}">5</div>
            <div class="stagename">Jurutera</div>
        </div>
        <div class="stage">
            <div class="num {{$detail && in_array($detail->hasStatus->code, ['08']) ? 'done': ''}}">6</div>
            <div class="stagename">Selesai</div>
        </div>
    </div>
    @endif
    <div class="main-content ">
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
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isForemenAssessment() || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'assessment');" id="tab4">Penilaian</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isAssistEngineerAssessment()  || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'evaluation');" id="tab6">Semakan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'approval');" id="tab7">Kelulusan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAssistEngineerAssessment() || auth()->user()->isAdmin() || $is_myApp) )
                        <li class="cub-tab"  onClick="goTab(this, 'certificate');" id="tab8">Sijil</li>
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="application" class="tab-content">
            @include('assessment.safety.tab.safety-application')
        </section>
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
        <section id="vehicle" class="tab-content">
            @include('assessment.safety.tab.safety-vehicle')
        </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
            <section id="appointment" class="tab-content">
                @include('assessment.safety.tab.safety-appointment')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isForemenAssessment() || auth()->user()->isAdmin()))
            <section id="assessment" class="tab-content">
                @include('assessment.safety.tab.safety-assessment')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isAssistEngineerAssessment()  || auth()->user()->isAdmin()))
            <section id="evaluation" class="tab-content">
                @include('assessment.safety.tab.safety-evaluation')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAdmin()))
            <section id="approval" class="tab-content">
                @include('assessment.safety.tab.safety-approval')
            </section>
        @endif

        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAssistEngineerAssessment() || auth()->user()->isAdmin() || $is_myApp) )
            <section id="certificate" class="tab-content">
                @include('assessment.safety.tab.safety-certificate')
            </section>
        @endif

        <div class="modal fade modal-asking" id="examinationApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="row" id="frm_examination">
                    @csrf
                    <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
                        <div class="modal-body pt-5">
                            <div class="asking">
                                Hantar permohonan kepada<br/>
                                Pembantu Kemahiran<br/>untuk memulakan proses penilaian?
                            </div>
                            <input type="hidden" name="section" value="examination">
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button class="btn btn-module" type="submit">Ya</button>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="verifyApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true" style="margin-top:10vh">
            <div class="modal-dialog modal-lg">
                <form class="row" id="frm_verify">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-body awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                            <input type="hidden" id="assessment_id" name="assessment_id">
                            <input type="hidden" name="section" value="verify">
                            <div class="announce">Makluman
                                <div>
                                Sila ambil maklum berkenaan dengan dokumen sokongan yang<br/>perlu anda bawa semasa menghantar kenderaan</div></div>
                            <hr>
                            <ul class="checklist">
                                <li><i class="fal fa-check fa-lg"></i> Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                                <li><i class="fal fa-check fa-lg"></i> Surat dari Jabatan</li>
                                <li><i class="fal fa-check fa-lg"></i> Surat Pelepasan Tanggungan (Pemeriksaan Keselamatan dan Prestasi Kenderaan)</li>
                                <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn back-hailait"
                                        target="_blank"
                                        data-fancybox data-type="iframe"
                                        href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Surat Pelepasan Tanggungan', 'report_name' => 'letter_of_release_of_dependent_safety', 'assessment_safety_id' => $detail ? $detail->id : -1])}}"
                                        ><i class="fas fa-file-pdf"></i> Muat Turun Surat
                                </a>
                                </li>
                            </ul>
                            <!--<div class="col-md-8">
                                Untuk borang per
                                <i class="fa fa-file-pdf fa-2x bg-danger"></i>&nbsp;
                                <a href="#" class="link-info" style="text-decoration: none;">Surat Pelepasan Tanggungan Kenderaan Baharu <em>(Sila Download Di sini)</em></a>
                            </div>-->
                            <div class="col-xl-10 col-lg-10 col-md-10 col-12">
                                <div class="form-check" style="height: unset;">
                                    <input class="form-check-input" type="checkbox" value="" id="aggrement" required  oninvalid="this.setCustomValidity('Sila tandakan kotak ini jika anda mahu meneruskan')"
                                    oninput="this.setCustomValidity('')">
                                    <label class="form-check-label cursor-pointer" style="line-height: 24px;" for="aggrement">
                                        Saya dengan ini mengisyitiharkan segala maklumat yang diberikan adalah benar dan tidak bercanggah dengan mana-mana peraturan. Permohonan ini akan terbatal sekiranya saya gagal hadir pada tarikh temujanji yang ditetapkan.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-start">
                            <button class="btn btn-module" type="submit">Hantar Permohonan</button>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="vehicleChecklistFailedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vehicleChecklistFailedModalLabel" aria-hidden="true" style="margin-top:10vh">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div id="checklist_failed"></div>
            </div>
            <div class="modal-footer justify-content-center ">
                <div class="btn-group">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" onclick="closePrint()"><i class="fa fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-link" onclick="window.print()">Cetak</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="editVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Kenderaan
                    {{-- <div>kenderaan</div> --}}
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>

            </div>
            <form id="frmEditVehicle" action="">
            @csrf
            <div class="modal-body" style="width:97%">
                <input type="hidden" name="assessment_type_id" id="assessment_type_id" xassessmentTypeId>
                <input type="hidden" name="vehicle_id" id="vehicle_id" xvehicleId>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No. Pendaftaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="plate_no" id="plate_no" xpendaftaran onchange="this.value = this.value.toUpperCase()" maxlength="12">
                            <div class="hasErr"></div>
                            <span id="no_pendaftaran2"></span>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Chasis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="chasis_no" id="chasis_no" xcasis_no placeholder="52WVC10338" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="engine_no" id="engine_no" xenjin_no placeholder="4D56-EL0995" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Buatan <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="vehicle_brand_id" id="brand" onchange="getVehicleModel(this.value)" xbrand>
                                <option value="">Sila Pilih</option>
                                @foreach ($brand_list as $brand )
                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Model <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="model_name" id="model_name" placeholder="SAGA" xmodelname onchange="this.value = this.value.toUpperCase()" maxlength="250">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Odometer (km) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="odometer" id="odometer" xodometer onchange="this.value = this.value.toUpperCase()" maxlength="30">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" id="category" class="form-control form-select" onchange="editVehicleGetSubCategory(this.value)" xkategori>
                                <option value="">Sila Pilih</option>
                                @foreach ($category_list as $category)
                                    <option value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                                @endforeach
                            </select>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" >
                            <label for="" class="form-label text-dark">Sub Kategori <span class="text-danger">*</span></label>
                            <select name="sub_category_id" id="list_sub_category" class="form-control form-select" onchange="editVehicleGetSubCategoryType(this.value)" >
                                <option value="">Sila Pilih</option>
                            </select>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Jenis <span class="text-danger">*</span></label>
                            <select name="sub_category_type_id" id="list_sub_category_type" class="form-control form-select" >
                                <option value="">Sila Pilih</option>
                            </select>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9" >
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Sebab <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason_changed" id="reason_changed" cols="20" rows="4"></textarea>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer flex justify-content-start">
                <button type="submit" class="btn btn-module float-start">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-times"></i> Tutup</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="display-logo-footer">
    <img src="{{asset('my-assets/img/spakat-small-min.png')}}" alt="">
</div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        function show(element){
            $(element).show();
        }

        function updateFormat(model, self){
            var key = event.keyCode || event.charCode;
            if(model == 'ic_no'){
                let x = $('#ic_no').val();

                if(key == 8){
                    $('#ic_no').val(x);
                } else {
                    if(x.length !== 7 || x.length !== 9){
                        x = x.replace(/[^\w\s]/gi, "");
                    }

                    if(x.length >= 6 && key !== 8){
                        x = x.substring(0, 6) + "-" + x.substring(6, x.length);
                    }

                    if(x.length >= 9 && key !== 8){
                        x = x.substring(0, 9) + "-" + x.substring(9, x.length);
                    }
                    $('#ic_no').val(x);
                }

            }
        }

        function submitVerify(data) {

            $('[name="app_dates"]').html('');

                parent.startLoading();
                $.ajax({
                    url: "{{ route('assessment.safety.register.save') }}",
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

        viewCheckListFailed = function(assessment_type_id, vehicle_id){

            $('body div').addClass('hideWhenPrintByModal');
            $('body nav').addClass('hideWhenPrintByModal');
            $('#vehicleChecklistFailedModal div:not(.modal-footer)').removeClass('hideWhenPrintByModal');

            $.get('{{route('assessment.safety.vehicle.checklist.failed')}}', {
                'assessment_type_id' : assessment_type_id,
                'vehicle_id' : vehicle_id
            }, function(res){
                $('#vehicleChecklistFailedModal #checklist_failed').html(res);
                let modal = $('#vehicleChecklistFailedModal');
                modal.modal('show');
            });

        }

        closePrint = function(){
            setTimeout(() => {
                $('.hideWhenPrintByModal').removeClass('hideWhenPrintByModal');
            }, 500);
        }

        fancyView = function(url){
            fancybox = new Fancybox([
            {
                src: url,
                type: "iframe",
            },
            ]);

            fancybox.on("done", (fancybox, slide) => {
            console.log(`done!`);
            });
        }

        viewCheckList = function(self){
            fancyView($(self).data('url'));
        }

        function editVehicleGetSubCategory(category_id){

            $('#editVehicleModal #list_sub_category').html('<option value="">Sila Pilih</option>');
            $('#editVehicleModal #list_sub_category_type').html('<option value="">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getSubCategory')}}", {
                category_id: category_id
            }, function(result){

                let count = result.length;
                let totalInit = 0;
                let same = false;

                if(count == 0){

                }
                else{

                    result.forEach(element => {
                        $('#editVehicleModal #list_sub_category').append('<option value='+element.id+'>'+element.name+'</option>');
                        if(subCategoryId == element.id){
                            same = true;
                        }
                        totalInit++;
                    });
                }

                if(count == totalInit){
                    if(!same){
                        subCategoryId = null;
                    }
                    $('#editVehicleModal #list_sub_category').val(subCategoryId).trigger("change");
                }

            });
        }

        function editVehicleGetSubCategoryType(sub_category_id){

            $('#editVehicleModal #list_sub_category_type').html('<option value="">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getSubCategoryType')}}", {
                sub_category_id: sub_category_id
            }, function(result){

                let count = result.length;
                let totalInit = 0;
                let same = false;


                if (count == 0){

                }
                else{

                    result.forEach(element => {
                        $('#editVehicleModal #list_sub_category_type').append('<option value='+element.id+'>'+element.name+'</option>');
                        totalInit++;
                        if(subCategoryTypeId == element.id){
                            same = true;
                        }
                    });
                }


                if(count == totalInit){
                    if(!same){
                        subCategoryTypeId = null;
                    }

                    console.log('subCategoryTypeId', subCategoryTypeId);

                    //$('#editVehicleModal #list_sub_category_type').val(data.sub_category_type_id).trigger("change");
                    $('#editVehicleModal #list_sub_category_type').val(subCategoryTypeId).trigger("change");
                }

            });
        }

        editVehicle = function(self){

            let assessment_type_id = $(self).data('assessment-type-id');
            let vehicle_id = $(self).data('vehicle-id');

            parent.startLoading();
            let editVehicleModal = $('#editVehicleModal');
            $.ajax({
            url: '{{Route("assessment.getVehicleDetail")}}',
            type: 'get',
            data: {
                'assessment_type_id' : assessment_type_id,
                'vehicle_id': vehicle_id,
            },
            dataType: 'json',
                success: function(data){

                    categoryId = data.category_id;
                    subCategoryId = data.sub_category_id;
                    subCategoryTypeId = data.sub_category_type_id;
                    $('[xassessmenttypeid]').val(assessment_type_id);
                    $('[xvehicleId]').val(data.id);
                    $('[xpendaftaran]').val(data.plate_no);
                    $('[xenjin_no]').val(data.engine_no);
                    $('[xcasis_no]').val(data.chasis_no);
                    $('[xbrand]').val(data.vehicle_brand_id).trigger("change");
                    $('[xmodelname]').val(data.model_name);

                    $('[xkategori]').val(data.category_id).trigger("change");

                    $('[xodometer]').val(data.odometer);

                    $('[xkjbtn]').val(data.hod_title);

                    $('[xjbtna]').val(data.department_name);

                    editVehicleModal.find('#reason_changed').val(data.reason_changed);

                    parent.stopLoading();
                }
            });

            editVehicleModal.modal('show');

        }

        submitEditVehicle = function(data) {

            $('.hasErr').html('');

            let editVehicleModal = $('#editVehicleModal');

            $.ajax({
                url: "{{ route('assessment.editVehicle.save') }}",
                type: 'post',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    editVehicleModal.modal('hide');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                                $('[name="'+key+'"]').parent().parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            console.log('key', key)
                            if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                                $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });
                }
            });
        }

        $(document).ready(function(){
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');



            $('.appointment_time').select2({
                width: '100%',
                theme: "classic",
                placeholder: "[Pilih Slot]"
            });

            $('.verify').on('click', function(e){
                e.preventDefault();

                var id = $(this).data('id');
                $('#assessment_id').val(id);
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

            $('#frmEditVehicle').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                submitEditVehicle(formData);

            });

        });
    </script>
</body>
</html>
