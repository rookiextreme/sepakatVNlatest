@php
    use App\Models\Assessment\AssessmentNewVehicle;

    $tab = Request('tab') ? Request('tab') : null;
    $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
    $is_myApp = $detail && $detail->created_by == auth()->user()->id ? true: false;
    $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;
    if($detail){
        $queryEvaluation = AssessmentNewVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '06');
            })->get();
        $queryApproval = AssessmentNewVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '03');
            })->get();

        $totalEvaluation = count($queryEvaluation);
        $totalApproval = count($queryApproval);
    }
    $id = Request('id');
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
    {{--<link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">--}}

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
        .lcal-plet {
            width:130px;
        }
        .lcal-2 {
            width: 70px;
        }
        .lcal-3 {
            width: 100px;
        }

        .lcal-4 {
            width: 150px;
        }
        .paper {
            background-color: #ffffff;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            border-color:#d2d0da;
            border-width: 2px;
            border-style:solid;
            max-width: 1200px;
            padding:10px;
            padding-left:15px;
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
            margin-right:-20px;
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

        @media print {
            nav * {
                display: none !important;
            }

            .sect-top {
                display: none !important;
            }
            .sect-top-dummy {
                display: none !important;
            }
             .mytitle{
                 display:none !important;
             }
             .quick-navigation{
                 display:none !important;
             }

             .btn {
                 display: none !important;
             }
        }
    </style>
</head>
<body class="content">
    <div class="mytitle">Penilaian <span>Kenderaan Baharu</span></div>
    <nav aria-label="breadcrumb">
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
                <a href="{{ route('assessment.new.list') }}">Rekod Penilaian</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
        </ol>
    </nav>
    @if($roleAccessCode == '01' || $roleAccessCode == '03')
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
            } else if ($detail && in_array($detail->hasStatus->code, ['05'])) {
                $stage = 320;
            } else if ($detail && in_array($detail->hasStatus->code, ['08'])) {
                $stage = 405;
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
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isForemenAssessment() || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'assessment');" id="tab5">Penilaian</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isAssistEngineerAssessment()  || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'evaluation');" id="tab6">Semakan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'approval');" id="tab7">Kelulusan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAssistEngineerAssessment() || auth()->user()->isAdmin() || auth()->user()->isPublic()) )
                        <li class="cub-tab"  onClick="goTab(this, 'certificate');" id="tab8">Sijil</li>
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="application" class="tab-content">
            @include('assessment.new.tab.new-application')
        </section>
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
        <section id="vehicle" class="tab-content">
            @include('assessment.new.tab.new-vehicle')
        </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
            <section id="appointment" class="tab-content">
                @include('assessment.new.tab.new-appointment')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isForemenAssessment() || auth()->user()->isAdmin()))
            <section id="assessment" class="tab-content">
                @include('assessment.new.tab.new-assessment')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isAssistEngineerAssessment()  || auth()->user()->isAdmin()))
            <section id="evaluation" class="tab-content">
                @include('assessment.new.tab.new-evaluation')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAdmin()))
            <section id="approval" class="tab-content">
                @include('assessment.new.tab.new-approval')
            </section>
        @endif

        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAssistEngineerAssessment() || auth()->user()->isAdmin() || auth()->user()->isPublic()) )
            <section id="certificate" class="tab-content">
                @include('assessment.new.tab.new-certificate')
            </section>
        @endif

        {{--<div class="modal fade" id="examinationApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
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
                            <button class="btn btn-module" type="submit">Ya22</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>--}}

        <div class="modal fade modal-asking" id="examinationApplicationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="row" id="frm_examination">
                    @csrf
                    <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
                        <div class="modal-body pt-5"> <input type="hidden" name="section" value="examination">
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
                        <div class="announce">Makluman<div> Sila ambil maklum berkenaan dengan dokumen sokongan yang<br/>perlu anda bawa semasa menghantar kenderaan</div></div>
                        <hr>
                        <ul class="checklist">
                            <li><i class="fal fa-check fa-lg"></i> Delivery Note</li>
                            <li><i class="fal fa-check fa-lg"></i> Salinan Sijil Pemilikan Kenderaan (VOC / Geran)</li>
                            <li><i class="fal fa-check fa-lg"></i> Surat dari Jabatan</li>
                            <li><i class="fal fa-check fa-lg"></i> Salinan Cukai Jalan</li>
                            <li><i class="fal fa-check fa-lg"></i> Salinan Pesanan Kerajaan (LO)</li>
                            <li><i class="fal fa-check fa-lg"></i> Salinan Lukisan-lukisan Teknikal (yang berkenaan)</li>
                            <li><i class="fal fa-check fa-lg"></i> Surat Pelepasan Tanggungan Kenderaan Baharu
                                &nbsp;&nbsp;
                                <a target="_blank" class="btn back-hailait" data-fancybox data-type="iframe" href="{{route('jasperReport', ['format' => 'pdf', 'title' => 'Surat Pelepasan Tanggungan Kenderaan Baharu', 'report_name' => 'letter_of_guarantee', 'assessment_new_id' => ($id)])}}"><i class="fas fa-file-pdf"></i> Muat Turun Surat</{{ asset('') }}></a>
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
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal <i class="fa fa-undo"></i></button>
                    </div>
                </div>
            </form>
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

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        function show(element){
            $(element).show();
        }

        function submitVerify(data) {

            $('[name="app_dates"]').html('');

                parent.startLoading();
                $.ajax({
                    url: "{{ route('assessment.new.register.save') }}",
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

            $('select').select2({
                width: '100%',
                theme: "classic",
                placeholder: "[Sila pilih]"
            });

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
