@php
    $tab = Request('tab') ? Request('tab') : null;
    $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
    $is_myApp = $detail && $detail->created_by == auth()->user()->id ? true: false;
    $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;
    use App\Models\Assessment\AssessmentAccidentVehicle;

    if($detail){
        $queryEvaluation = AssessmentAccidentVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '06');
            })->get();
        $queryApproval = AssessmentAccidentVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
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

    <link href="{{ asset('my-assets/fontawesome-pro/css/light.min.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.js') }}"></script>
    <!--Importing Icons-->

    <script src="{{ asset('my-assets/bootstrap/js/popper.js') }}" type="text/javascript"></script>

    <!--importing bootstrap-->
    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />



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
        #addDamageModal .modal-dialog {
            padding-top:5%;
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
        .unsettle {
            background-color:#a1dbff;
            border-color:red;
            border-width: 2px;
            border-style: solid;
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
        .first-col {
            max-width: 40px;padding-top:0px;padding-left:20px;
        }
        .car-row {

        }
        .car-row:hover {
            background-color: #f4f5f2;
        }
        .icon-white {
            filter: brightness(200%) contrast(198%) saturate(45%) grayscale(99%);
        }
        .radio-highlight {
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
            background-color: #e5e9e1;
            display:table;
            padding-left:15px;
        }
        .tooltip-inner {
            font-family: mark;
            text-align: left;
            font-size:12px;
            line-height:14px;
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
    </style>
    <script type="text/javascript">
        function show(element){
            $(element).show();
        }
        /*function checkFormReadiness() {
            //1. Check first whether form is ready to be submitted
            if(formClearToGo() == true){
                $('.verify').removeClass("dim");
            }else{
                alert("Sila isikan maklumat-maklumat yang diperlukan");
                e.preventDefault();
            }
        }*/
        function formClearToGo() {
            //whether to allow save or not, only if all required fields are filled up
            var proceed = true;
            //1st tab

            $('#frm_application input:required').each(function() {
                if ($(this).val() === ''){
                    proceed = false;
                    $('.verify').addClass('dim');
                }
            });

            if(proceed == true){
                if($('#laporan').length){//if 2nd FORM exists
                    $('#tab2').trigger('click');
                    $('#frm_vehicle input:required').each(function() {

                        //getting the type of field
                        var whattype = this.type || this.tagName.toLowerCase();

                        if ($(this).val() === ''){
                            if($(this).attr('id') == 'vehicle_brand_id'){

                            }
                            proceed = false;
                            $('.verify').addClass('dim');
                            $(this).next().closest('.hasErr').text("Sila isi")
                        }
                    });

                    $('#frm_vehicle .form-select.required').each(function() {
                        if ($(this).find(":selected").text() === ''){
                            proceed == false;
                            console.log("Takde jawapan" + $(this).attr('id'));
                            if($(this) != undefined && $(this) != null){
                                $('.verify').addClass('dim');

                                //var nex = $(this).nextAll().find(':has(.hasErr):first');
                                //nex.text('Sila pilih');
                                //REVISIT

                                $('#' + $(this).attr('id') + '_msg').text('Sila pilih');
                            }
                        }
                    })
                }
            }

            return proceed;
        }
        function addOtherCar() {
            var newRow = "<div class='row car-row'>" +
                    "<div class='col-xl-1 col-lg-1 col-md-1 form-group first-col'><label class='form-label text-dark'>2.</label></div>" +
                    "<div class='col-xl-2 col-lg-2 col-md-3 pt-2'>" +
                    "<div class='form-group'>" +
                    "<input type='text' class='form-control' name='accwit_regno' id='accwit_regno' placeholder='cth. SMC4234' onchange='forceCaps(this);'><div class='hasErr'></div>" +
                    "</div></div>" +

                    "<div class='col-xl-4 col-lg-7 col-md-6 pt-2'>" +
                        "<div class='form-group'>" +
                            "<input type='text' class='form-control' name='vehicle_desc' id='vehicle_desc' placeholder='cth. Motosikal Yamaha 135 LC' onchange='forceCaps(this);'>" +
                            "<div class='hasErr'></div>" +
                        "</div>" +
                    "</div>"+


                    "<div class='col-xl-1 col-lg-1 col-md-1 pt-2 form-group' style='max-width: 40px;padding-top:0px;padding-left:0px'>" +
                    "<button class='btn cux-btn bigger' onclick='clearThisRow()'><i class='fal fa-times'></i></button>" +
                    "</div>" +
                    "</div>";
            $('.car-row').last().after(newRow);
        }

        function submitVerify(data, report_no, report_dt, driver_name, driver_mykad, driver_phone, plate_no, category_main, list_sub_category_main, list_sub_category_main_type, vehicle_brand_id, model_name) {

            data.append('report_no', report_no);
            data.append('report_dt', report_dt);
            data.append('driver_name', driver_name);
            data.append('driver_mykad', driver_mykad);
            data.append('driver_phone', driver_phone);
            data.append('plate_no', plate_no);
            data.append('category_id', category_main);
            data.append('sub_category_id', list_sub_category_main);
            data.append('sub_category_type_id', list_sub_category_main_type);
            data.append('vehicle_brand_id', vehicle_brand_id);
            data.append('model_name', model_name);

                parent.startLoading();
                $.ajax({
                    url: "{{ route('assessment.accident.register.save') }}",
                    type: 'post',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    success: function(response) {
                        window.location = response['url'];
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;

                        $.each(errors, function(key, value) {

                            if(key == 'app_dates'){
                                if($('[name="'+key+'"]').find('.hasErr').length == 0){
                                    console.log(value[0]);
                                    $('[name="'+key+'"]').html('<div class="hasErr">'+value[0]+'</div>');
                                }
                            }
                            else if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                                if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                    $('[name="'+key+'"]').parent().parent().append('<div class="hasErr">'+value[0]+'</div>');
                                }
                            } else {
                                if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                    $('[name="'+key+'"]').parent().append('<div class="hasErr">'+value[0]+'</div>');
                                }
                            }
                        });

                        parent.stopLoading();
                    }
                });
        }
    </script>
</head>
<body class="content">
    <div class="mytitle" onClick="formClearToGo()">Penilaian <span id="test">Kemalangan</span></div>
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
                <a href="{{ route('assessment.accident.list') }}">Rekod Penilaian</a>
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
                        <li class="cub-tab"  onClick="goTab(this, 'laporan');" id="tab2">Kemalangan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
                        <li class="cub-tab"  onClick="goTab(this, 'appointment');" id="tab3">Temujanji</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isForemenAssessment() || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'assessment');" id="tab4">Penilaian</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isAssistEngineerAssessment()  || auth()->user()->isAdmin()))
                        <li class="cub-tab"  onClick="goTab(this, 'evaluation');" id="tab5">Semakan</li>
                    @endif
                    @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAdmin()) || ($is_myApp && $detail->hasStatus->code == '08') )
                        <li class="cub-tab"  onClick="goTab(this, 'approval');" id="tab6">{{$is_myApp && $detail->hasStatus->code == '08' ? 'Kerosakan' : 'Kelulusan'}}</li>
                    @endif
                    {{-- @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && auth()->user()->checkRole('03'))
                        <li class="cub-tab"  onClick="goTab(this, 'certificate');" id="tab7">Sijil</li>
                    @endif --}}
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="application" class="tab-content">
            @include('assessment.accident.tab.accident-application')
        </section>
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
        <section id="laporan" class="tab-content">
            @include('assessment.accident.tab.accident-vehicle')
        </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
            <section id="appointment" class="tab-content">
                @include('assessment.accident.tab.accident-appointment')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isForemenAssessment() || auth()->user()->isAdmin()))
            <section id="assessment" class="tab-content">
                @include('assessment.accident.tab.accident-assessment')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isAssistEngineerAssessment()  || auth()->user()->isAdmin()))
            <section id="evaluation" class="tab-content">
                @include('assessment.accident.tab.accident-evaluation')
            </section>
        @endif
        @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && (auth()->user()->isEngineerAssessment() || auth()->user()->isAssistEngineerAssessment() || auth()->user()->isAdmin() || auth()->user()->isPublic()) )
            <section id="approval" class="tab-content">
                @include('assessment.accident.tab.accident-approval')
            </section>
        @endif

        {{-- @if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && auth()->user()->checkRole('03'))
            <section id="certificate" class="tab-content">
                @include('assessment.accident.tab.accident-certificate')
            </section>
        @endif --}}

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
                    <div class="modal-content tanda">
                        <div class="modal-body awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                            <input type="hidden" id="assessment_id" name="assessment_id">
                            <input type="hidden" name="section" value="verify">
                            <div class="announce">Makluman<div> Sila ambil maklum berkenaan dengan dokumen sokongan yang<br/>perlu anda bawa semasa menghantar kenderaan</div></div>
                            <hr>
                            <ul class="checklist">
                                <li><i class="fal fa-check fa-lg"></i> Borang Laporan Kerosakan - Borang Am 362B<Br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Bahagian 1 lengkap diisi dalam 4 salinan)</li>
                                <li><i class="fal fa-check fa-lg"></i> Repot Polis</li>
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
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal <i class="fal fa-undo"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

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

        $(document).ready(function(){
            initTab();

            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic",
                placeholder: "[Sila pilih]"
            });
            $('#jabatan-tip').tooltip();

            /*$('#frm_vehicle input').on('keyup', function(e){
                if(formClearToGo() == true){
                    $('.verify').removeClass('dim');
                }else{
                    $('.verify').addClass('dim');
                }
            });*/
            $('.appointment_time').select2({
                width: '100%',
                theme: "classic",
                placeholder: "[Pilih Slot]"
            });

            $('.verify').on('click', function(e){
                //e.preventDefault();

                if(formClearToGo()){
                    var id = $(this).data('id');
                    $('#assessment_id').val(id);
                    let modal = $('#verifyApplicationModal');
                    modal.modal('show');
                }else{
                    e.preventDefault();
                }
            });
            $('#frm_verify').on('submit', function(e) {
                e.preventDefault();
                // let frm_vehicle = new FormData($('#frm_vehicle')[0]);
                var report_no = $('#report_no').val();
                var report_dt = $('#report_dt').val();
                var driver_name = $('#driver_name').val();
                var driver_mykad = $('#driver_mykad').val();
                var driver_phone = $('#driver_phone').val();
                var plate_no = $('#plate_no').val();
                var category_main = $('#category_main').val();
                var list_sub_category_main  = $('#list_sub_category_main').val();
                var list_sub_category_main_type = $('#list_sub_category_main_type').val();
                var vehicle_brand_id = $('#vehicle_brand_id').val();
                var model_name = $('#model_name').val();
                let formData = new FormData(this);
                submitVerify(formData, report_no, report_dt, driver_name, driver_mykad, driver_phone, plate_no, category_main, list_sub_category_main, list_sub_category_main_type, vehicle_brand_id, model_name);

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
