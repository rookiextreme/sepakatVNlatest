@php
    use App\Models\Assessment\AssessmentSafetyVehicle;
    use App\Models\Assessment\AssessmentFormCheckLvl1;
    use App\Models\Assessment\AssessmentVehicleImage;
    use App\Models\Vehicle\Brand;
    use App\Models\RefCategory;
    $tab = Request('tab') ? Request('tab') : null;
    $vehicle_id = Request('vehicle_id');
    $vehicleDetails = AssessmentSafetyVehicle::find($vehicle_id);
    $brand_list = Brand::where('status', 1)->orderBy('name')->get();
    $category_list = RefCategory::where('status', 1)->get();
    $OwnImage = AssessmentVehicleImage::where('vehicle_id', $vehicleDetails->id)
                                        ->whereHas('hasAssessmentType', function($q){
                                            $q->where('code', '02');
                                        })->get();
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
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }
        .top-fix {
            position:fixed;
            z-index:100;
            height:170px;
            width:100%;
            left:0px;
            padding-left:30px;
            background-color:#f2f4f0;
            box-shadow: 1px 5px 21px 5px rgba(0,0,0,0.12);
            -webkit-box-shadow: 1px 5px 21px 5px rgba(0,0,0,0.12);
            -moz-box-shadow: 1px 5px 21px 5px rgba(0,0,0,0.12);
            border-bottom-style: solid;
            border-bottom-width: 1px;
            border-bottom-color:#d8ddd3;
        }
        .sect-top-dummy {
            height:170px;
        }
        .paper {
            background-color:#ffffff;
        }
        .assessment-tab {
            position:relative;
            width:100%;
            overflow:scroll;
            height:40px;
            margin-bottom: 5px;
        }
        ul.asstabrow {
            margin-left:-20px;
        }
        ul.asstabrow li.my-tab {
            font-family: lato;
            font-size:14px;
            cursor: pointer;
            color:#4c203b;
            display: inline;
            padding-right:13px;
            padding-left:10px;
            border-right-width: 1px;
            border-right-style: solid;
            border-right-color:#969690;
        }
        ul.asstabrow li.my-tab:first-of-type {
            margin-left:-20px;
        }
        ul.asstabrow li.my-tab:hover {
            color:orange;
        }
        .the-module {
            font-family: lato-bold;
            font-size:16px;
            text-align: left;
            line-height:30px;
            height:30px;
            padding-left:-10px;
            background-color:#f4f5f2;
            color:#000000;
        }
        .the-section {
            font-family: lato-bold;
            font-size:16px;
            line-height: 18px;
            text-transform: uppercase;
            padding-top:14px;
            color:#4c203b;
            height:70px;
            padding-right:20px;
            text-align: right;
            border-right-width: 1px;
            border-right-color:#e7eae4;
            border-right-style: solid;
            vertical-align: middle;
        }
        .the-section.main {
            font-size:20px;
            line-height: 18px;
        }
        .fixed-submit {
            position: fixed;bottom:0px;left:0px;width:100%;height:65px;background-color:#dde3d7;padding-left:30px;padding-top:13px;z-index:100;
            border-top-width: 1px;
            border-top-color:#c9d1c1;
            border-top-style: solid;
        }
        .thin-topline {
            border-top-width: 1px;
            border-top-color:#c9d1c1;
            border-top-style: solid;
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
        .item.selected, .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        html {
            scroll-behavior: smooth !important;
        }

        #preview_img {
            margin-left: auto;
            margin-right: auto;
        }

        .select2-hidden-accessible {
            height: 0px !important;
        }
        .img-del {
            position: absolute;
            right:8px;
            top:-8px;width:30px;height:30px;background-color:red;border-radius:17px;text-align:center;padding-top:4px;
            cursor:pointer;
        }
        .img-del:hover {
            background-color:orange;
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
    <script type="text/javascript">
        function summarizeThisForm() {
            //count the status of form
            var user_level = $('#user_level').val();

            var rows= $('.must-answer').length;
            var pembawah = rows;

            var donecheck = 0;

            var mustselect = $('.mustselect').length;

            $(".mustcheck:input:checkbox").each(function () {
                donecheck = donecheck + 1;
            });

            // if(parseInt(donecheck) == parseInt(rows)){

            // }else{
            //     //there is unchecked answer
            //     $(".mustcheck:input:checkbox:not(:checked)").each(function () {
            //         //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
            //         var theId = $(this).attr("id");
            //         var newFld = theId.replace("form_check_component_id_", "form_note_component_id_");
            //         if($('#' + newFld).val() != ''){
            //             donecheck = donecheck + 1;
            //         }
            //     });
            // }
            var odo_read = $('#odometer').val();

            //for odo
            pembawah = pembawah + 1;
            if(odo_read != ''){

                donecheck = donecheck + 1;

            }

            var check_type = $('#check_type').val();
            if(check_type == 'Komputer'){
                pembawah = pembawah + 1;
                if($('#preview_img').length > 0){
                    donecheck = donecheck + 1;
                }
            }


            // if(user_level == 'TA'){
            //     pembawah = pembawah + 4;
            //     if(parseInt($('#delivery_service').val()) > 0){
            //         donecheck = donecheck + 1;
            //     }
            //     if(parseInt($('#post_durability').val()) > 0){
            //         donecheck = donecheck + 1;
            //     }
            //     if(parseInt($('#post_current_value').val()) > 0){
            //         donecheck = donecheck + 1;
            //     }
            //     if(parseInt($('#current_value').val()) > 0){
            //         donecheck = donecheck + 1;
            //     }
            // }

            var pctg = parseInt((parseFloat(donecheck) / parseFloat(pembawah))*100);
            $('.progress-bar').attr('style','width: ' + pctg + '%');
            $('#special-progress').text(pctg + '%');

            if(pctg < 100){
                $('.send-button').prop('disabled', true);
            }else if(pctg == 100){
                $('.send-button').prop('disabled', false);
            }
        }
        function scrollTarget(targ, obj) {
            var newTarg = targ.replace(/ /g,'');
            var oldTop = $("#" + newTarg).offset().top;
            var diff = $('.top-fix').css('height');
            var newTop = (parseInt(oldTop) - parseInt(diff));
            $('html, body').scrollTop(newTop);
        }
        function scrollMaster() {
            var diff = $('.top-fix').css('height');
            $('html, body').scrollTop(parseInt(diff)-parseInt(diff));
        }
        </script>
</head>
<body class="content">
<div id="response" class="alert alert-spakat response-toast" role="alert"></div>
<div class="top-fix">
    <div class="mytitle" onclick="summarizeThisForm()">Penilaian <span>Keselamatan & Prestasi</span></div>
    <div class="show-plet-no">
        <div style="position: absolute;right:200px;width:140px;height:50px;padding-top:7px;background-color:#ffffff;padding-left:5px;padding-right:5px;-webkit-border-radius: 8px;-moz-border-radius: 8px;border-radius: 8px;border-color:#e1e5de;border-style:solid;border-width:1px">
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="my-progress"></div>
            </div>
            <div class="float-end" style="font-family: mark-bold;color:#383631" id="special-progress">0%</div>
        </div>
        {{$vehicleDetails->plate_no}}
    </div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                @if(auth()->user()->isForemenAssessment())
                <a href="{{ route('access.operation.dashboard') }}">Dashboard</a>
                @else
                <a href="{{ route('assessment.safety.register', [
                    'id' => Request('assessment_id'),
                    'tab' => 4
                ]) }}">Penilaian</a>
                @endif
            </li>
            <li class="breadcrumb-item active" aria-current="page">Borang Penilaian</li>
        </ol>
    </nav>
    <div class="assessment-tab">
        <div style="width:auto;white-space:nowrap;">
            <ul class="asstabrow">
                <li class="my-tab" onclick="scrollMaster()">SEMUA</li>
                <li class="my-tab" onclick="scrollTarget('PEMERIKSA', this)">PEMERIKSA</li>
                <li class="my-tab" onclick="scrollTarget('asas',this)">ASAS</li>
                <li class="my-tab" onclick="scrollTarget('VTL',this)">KAEDAH PEMERIKSAAN / VTL</li>
            @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
                @if($AssessmentFormCheckLvl1->hasComponentLvl1->has_upload == true)
                    <li class="my-tab" onclick="scrollTarget('{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}', this)">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</li>
                @endif
            @endforeach
            @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
                @if($AssessmentFormCheckLvl1->hasComponentLvl1->has_upload == false)
                    <li class="my-tab" onclick="scrollTarget('{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}', this)">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</li>
                @endif
            @endforeach
            </ul>
        </div>
    </div>
</div>
@php
    $counter = 0;
@endphp
<div class="sect-top-dummy"></div>
<div class="main-content">
    <form id="frm_examination_achievement_vehicle">
    @csrf
    <div class="fixed-submit">
        @if(auth()->user()->isEngineerAssessment())
            <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Selesai</button>
            <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
        @elseif(auth()->user()->isAssistEngineerAssessment())
            <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Sahkan</button>
            <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
        @elseif(auth()->user()->isForemenAssessment())
            <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Hantar</button>
            <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
        @endif
    </div>
    <div class="row paper" id="assess-form">
        <input type="hidden" name="check_type" id="check_type" value="Komputer">
        <input type="hidden" name="user_level" id="user_level" value="{{auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() ? 'TA' : 'Tukang'}}">
        <input type="text" class="form-control d-none" name="evaluation_type" id="evaluation_type" value="Komputer">
        <div class="col-xl-12 col-lg-12 col-md-12" style="max-width:1300px">
            <div class="row thin-topline">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="the-module">PEMERIKSA</div>
                </div>
            </div>
            <div class="row thin-topline">
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="PEMERIKSA">
                    <div class="the-section">PEMERIKSA</div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5" style="color: #080807;font-family: lato-bold; font-size:
                        12px; text-transform: uppercase; height: 30px; padding-right:20px; padding-top: 10px;
                        vertical-align:middle;">Pembantu Kemahiran</div>
                        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7"  style="color: #080807;font-family: lato-bold; font-size:
                        12px; text-transform: uppercase; height: 30px; padding-right:20px; padding-top: 10px;
                        vertical-align:middle;">{{$vehicleDetails->foremenBy ? $vehicleDetails->foremenBy->name : '-'}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5" style="color: #080807;font-family: lato-bold; font-size:
                        12px; text-transform: uppercase; height: 30px; padding-right:20px; padding-top: 10px;
                        vertical-align:middle;">Tarikh & Masa</div>
                        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7"  style="color: #080807;font-family: lato-bold; font-size:
                        12px; text-transform: uppercase; height: 30px; padding-right:20px; padding-top: 10px;
                        vertical-align:middle;">
                            {{\Carbon\Carbon::parse($vehicleDetails->foremen_dt)->format('d M Y')}}
                            <small  style="color: #080807;font-family: lato-bold; font-size:
                            12px; text-transform: uppercase; height: 30px; padding-right:20px;
                            vertical-align:middle;">{{\Carbon\Carbon::parse($vehicleDetails->foremen_dt)->format('g:i:s A')}}</small>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row thin-topline">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="the-module">Senarai Semak Pemeriksaan Keselamatan dan Prestasi Kenderaan (Pengujian)</div>
                </div>
            </div>
            <div class="row thin-topline">
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="asas">
                    <div class="the-section">Asas</div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                    <div class="form-group">
                        <label for="" class="form-label text-dark">Bacaan Odometer <span class="text-danger">*</span></label>
                        <input type="number" class="form-control text-end" name="odometer" id="odometer" value="{{$vehicleDetails->odometer}}" placeholder="" onchange="this.value = this.value.toUpperCase()" onchange="summarizeThisForm()" style="max-width: 140px">
                    </div>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12">
                    <div class="the-section"></div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-12">
                    <div class="row" id="reload_veh">
                        <div class="col-xl-3 col-lg-2 col-md-3 col-sm-3 col-12">
                            <div class="form-group" id="own_image">
                                @if($OwnImage->count() < 5)
                                    <label for="" class="form-label text-dark">Imej Kenderaan<span class="text-danger"></span></label>
                                    <div class="col-md-9"><label for="veh_img_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik</label></div>
                                    <input onchange="uploadFile(this)" data-id="{{$vehicleDetails->id}}" data-lvl="veh_img_doc" class="form-control d-none" accept="image/*" type="file" id="veh_img_doc" />
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-10 col-md-9 col-sm-9 col-12">
                            <!--imej di sini-->
                                @if (count($OwnImage) > 0)
                                    @foreach ( $OwnImage as $vehicleImage)
                                        @php
                                            $path = '';
                                            $docName = '';
                                            if($vehicleImage){
                                                $path = $vehicleImage->doc_path;
                                                $docName = $vehicleImage->doc_name;
                                            }
                                        @endphp
                                        <div style="position:relative; width:150px;">
                                            <div class="img-del" onclick="deleteFile({{$vehicleDetails->id}}, 'veh_img_doc', {{$vehicleImage->id}})"><i class="fa fa-times icon-white"></i></div>
                                            <img id="preview_vehicle" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$OwnImage ? 'block' :'none'}}">
                                        </div>
                                    @endforeach
                                @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="engine_no" id="engine_no" value="{{$vehicleDetails->engine_no}}" placeholder="4D56-EL0995" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">No Casis <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chasis_no" id="chasis_no" value="{{$vehicleDetails->chasis_no}}" placeholder="52WVC10338" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Kategori <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category" class="form-control form-select" onchange="getSubCategory(this.value)" >
                                        <option value="">Sila Pilih</option>
                                        @foreach ($category_list as $category)
                                            <option value="{{$category->id}}" {{$category->id == $vehicleDetails->category_id ? 'selected' : ''}}>{{strtoupper($category->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Sub Kategori <span class="text-danger">*</span></label>
                                    <select name="sub_category_id" id="list_sub_category" class="form-control form-select" onchange="getSubCategoryType(this.value)" >
                                        <option value="">Sila Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Jenis <span class="text-danger">*</span></label>
                                    <select name="sub_category_type_id" id="list_sub_category_type" class="form-control form-select" >
                                        <option value="">Sila Pilih</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Buatan <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="vehicle_brand_id" id="brand" onchange="getVehicleModel(this.value)">
                                        <option value="">Sila Pilih</option>
                                        @foreach ($brand_list as $brand )
                                            <option value="{{$brand->id}}" {{$brand->id == $vehicleDetails->vehicle_brand_id ? 'selected' : ''}}>{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Model <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="model_name" id="model_name" value="{{$vehicleDetails->model_name}}" placeholder="SAGA" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row thin-topline">
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="VTL">
                    <div class="the-section">Kaedah Pemeriksaan</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="btn-group" id="kaedah">
                        {{-- <button type="button" class="btn cux-btn bigger active" onClick="checkThis('Komputer', this)">Berkomputer</button>
                        <button type="button" class="btn cux-btn bigger" onClick="checkThis('Manual', this)">Manual</button> --}}
                        <label for="evaluation_type" class="btn cux-btn bigger {{$vehicleDetails->evaluation_type == 'Manual' ? 'active' : ''}}" onClick="checkThis('Manual', this)">Manual</label>
                        <input type="text" class="form-control d-none" name="evaluation_type" id="evaluation_type" value="Manual">
                        <label for="evaluation_type" class="btn cux-btn bigger {{$vehicleDetails->evaluation_type == 'Komputer' || $vehicleDetails->evaluation_type == null ? 'active' : ''}}" onClick="checkThis('Komputer', this)">Berkomputer</label>

                    </div>
                </div>
            </div>
            <div class="row thin-topline" id="row_vtl" style="display: {{$vehicleDetails->evaluation_type == 'Manual' ? 'none' : 'show'}}">
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="VTL">
                    <div class="the-section">VTL</div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-12 pt-2">
                    <div class="form-group">
                        <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger">*</span></label>
                        <label type="button" for="vtl_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik</label>
                        <input onchange="uploadFile(this)" data-id="{{$vehicle_id}}" data-lvl="vtl_doc" class="form-control d-none" accept="image/*" type="file" id="vtl_doc" />
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-4 col-sm-4 col-12 pt-2 pb-2">
                    @php
                        $path = '';
                        $docName = '';
                        if($vehicleDetails->hasVtlDoc){
                            $path = $vehicleDetails->hasVtlDoc->doc_path;
                            $docName = $vehicleDetails->hasVtlDoc->doc_name;
                        }
                    @endphp
                    <div id="reload_vtl">
                        <div  style="position:relative; width:150px; display: {{$vehicleDetails->hasVtlDoc ? 'block':'none'}};">
                            <div class="img-del" onclick="deleteFile({{$vehicleDetails->vtl_doc}}, 'vtl_doc', {{$vehicleDetails->id}})"><i class="fa fa-times icon-white"></i></div>
                            <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" {{$vehicleDetails->hasVtlDoc ? "" :"style='display:none'"}}>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 thin-topline">
                <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                    <div class="the-section main">SEMUA KRITERIA</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="form-switch">
                        <input type="checkbox" class="form-check-input mt-2 me-2" name="check_all" id="check_all">
                        <label class="form-check-label cursor-pointer" for="check_all">Lulus Semua</label>
                    </div>
                </div>
            </div>
            <div class="row thin-topline">
                @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
                    @if($AssessmentFormCheckLvl1->hasComponentLvl1->has_upload == true)
                        <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="{{str_replace(' ', '', $AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname)}}">
                            <div class="the-section">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</div>
                        </div>
                        <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                            <div class="table-responsive">
                                <table class="table-custom stripe no-footer">
                                    <thead>
                                        <th style="width: 50px;">Lulus</th>
                                        <th class="w-50">Pengujian</th>
                                        <th class="w-auto">Catatan</th>
                                        <th class="w-auto">Imej</th>
                                    </thead>
                                    <tbody class="no-footer">
                                        @foreach ($AssessmentFormCheckLvl1->hasFormComponentCheckListLvl2 as $AssessmentFormCheckLvl2)
                                            <tr class="must-answer">
                                                <td>
                                                    <div class="form-switch">
                                                        {{--@php
                                                            $counter = $counter+1;
                                                            echo $counter;
                                                        @endphp--}}
                                                        <input {{$AssessmentFormCheckLvl2->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mt-2 me-2 mustcheck" name="form_check_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl2->id}}">
                                                    </div>
                                                    <td>{{ ucwords($AssessmentFormCheckLvl2->hasComponentLvl2->component) }}</td>
                                                    <td>
                                                        <textarea style="resize: none;" name="form_note_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl2->id}}" rows="2" class="form-control">{{$AssessmentFormCheckLvl2->note}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <label for="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" class="btn cux-btn bigger form-label"><i class="fas fa-image"></i></label>
                                                        {{-- <input onchange="uploadFile(this)" class="form-control d-none" accept="image/*" name="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" /> --}}
                                                        <input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl2->id}}" data-lvl="2" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" />
                                                        @php
                                                            $path = '';
                                                            $docName = '';
                                                            if($AssessmentFormCheckLvl2->hasDoc){
                                                                $path = $AssessmentFormCheckLvl2->hasDoc->doc_path;
                                                                $docName = $AssessmentFormCheckLvl2->hasDoc->doc_name;
                                                            }
                                                        @endphp
                                                        <div id="reload_img_lvl2_{{$AssessmentFormCheckLvl2->id}}">
                                                            <div  style="position:relative; width:150px; display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}};">
                                                                <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl2->doc_id}}, 'lvl2', {{$AssessmentFormCheckLvl2->id}})"><i class="fa fa-times icon-white"></i></div>
                                                                <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    @endforeach

                @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
                    @if($AssessmentFormCheckLvl1->hasComponentLvl1->has_upload == false)
                        <div class="row thin-topline">
                            <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="{{str_replace(' ', '', $AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname)}}">
                                <div class="the-section">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</div>
                            </div>
                            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                                @if($AssessmentFormCheckLvl1->hasManySelection->count()>0)
                                <div class="row">
                                    @foreach ($AssessmentFormCheckLvl1->hasManySelection as $hasSelection)
                                        @php
                                            $tableList = DB::table($hasSelection->hasTableSelection->table)->get();
                                        @endphp
                                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">{{$hasSelection->hasTableSelection->desc}}</label>
                                                <select class="form-select" name="form_selection_id_{{$hasSelection->id}}" id="form_selection_id_{{$hasSelection->id}}">
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($tableList as $item)
                                                        <option {{$hasSelection->selected_id == $item->id ? 'selected': ''}} value="{{$item->id}}">{{$item->desc}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                                <div class="table-responsive">
                                    {{-- @foreach ($AssessmentFormCheckLvl1->hasFormComponentCheckListLvl2 as $AssessmentFormCheckLvl2) --}}
                                    {{-- <div class="form-group mb-0 p-0" style="line-height:10px;"><label style="margin-bottom:0px;line-height:10px;">{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</label></div> --}}
                                    <table class="table-custom stripe no-footer">
                                        <thead>
                                            <th style="width: 50px;">Lulus</th>
                                            <th class="w-50">Penilaian</th>
                                            <th class="w-auto">Catatan</th>
                                            <th class="text-center w-imej">Imej</th>
                                        </thead>
                                        <tbody class="no-footer">
                                            @foreach ($AssessmentFormCheckLvl1->hasFormComponentCheckListLvl2 as $AssessmentFormCheckLvl2)
                                                @if($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3->count() == 0 )
                                                <!--<tr class="">
                                                    <td colspan="4" class="row-section"></td>
                                                </tr>-->
                                                    <tr class="must-answer">
                                                        <td>
                                                        {{--@php
                                                            $counter = $counter+1;
                                                            echo $counter;
                                                        @endphp--}}
                                                            <div class="form-switch">
                                                                <input {{$AssessmentFormCheckLvl2->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mt-2 me-2 mustcheck" name="form_check_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl2->id}}">
                                                            </div>
                                                        </td>
                                                        <td>{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                                        <td>
                                                            <textarea style="resize: none;" name="form_note_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl2->id}}" rows="2" class="form-control">{{$AssessmentFormCheckLvl2->note}}</textarea>
                                                        </td>
                                                        <td class="text-center">
                                                            <label for="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" class="btn cux-btn bigger form-label"><i class="fas fa-image"></i></label>
                                                            {{-- <input onchange="uploadFile(this)" class="form-control d-none" accept="image/*" name="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" /> --}}
                                                            <input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl2->id}}" data-lvl="2" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" />
                                                            @php
                                                                $path = '';
                                                                $docName = '';
                                                                if($AssessmentFormCheckLvl2->hasDoc){
                                                                    $path = $AssessmentFormCheckLvl2->hasDoc->doc_path;
                                                                    $docName = $AssessmentFormCheckLvl2->hasDoc->doc_name;
                                                                }
                                                            @endphp
                                                            <div id="reload_img_lvl2_{{$AssessmentFormCheckLvl2->id}}">
                                                                <div  style="position:relative; width:150px; display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}};">
                                                                    <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl2->doc_id}}, 'lvl2', {{$AssessmentFormCheckLvl2->id}})"><i class="fa fa-times icon-white"></i></div>
                                                                    <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @else

                                                <!--<tr class="">
                                                    <td colspan="4" class="form-label">{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                                </tr>-->
                                                    @foreach ($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3 as $AssessmentFormCheckLvl3)
                                                        <tr>
                                                            <td>
                                                                <div class="form-switch">
                                                                    <input {{$AssessmentFormCheckLvl3->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mt-2 me-2" name="form_check_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl3->id}}">
                                                                </div>
                                                            </td>
                                                            <td>{{$AssessmentFormCheckLvl3->hasComponentLvl3->component}}</td>
                                                            <td>
                                                                <textarea style="resize: none;" name="form_note_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl3->id}}" rows="2" class="form-control">{{$AssessmentFormCheckLvl3->note}}</textarea>
                                                            </td>
                                                            <td class="text-center" style="text-align: center; vertical-align: middle;">
                                                                <label for="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" class="btn cux-btn bigger"><i class="fas fa-image"></i></label>
                                                                {{-- <input onchange="uploadFile(this)" class="form-control d-none" accept="image/*" name="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" type="file" id="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" /> --}}
                                                                <input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl3->id}}" data-lvl="3" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" />
                                                                @php
                                                                    $path = '';
                                                                    $docName = '';
                                                                    if($AssessmentFormCheckLvl3->hasDoc){
                                                                        $path = $AssessmentFormCheckLvl3->hasDoc->doc_path;
                                                                        $docName = $AssessmentFormCheckLvl3->hasDoc->doc_name;
                                                                    }
                                                                @endphp
                                                                <div id="reload_img_lvl3_{{$AssessmentFormCheckLvl3->id}}">
                                                                    <div  style="position:relative; width:150px; display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}};">
                                                                        <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl3->doc_id}}, 'lvl3', {{$AssessmentFormCheckLvl3->id}})"><i class="fa fa-times icon-white"></i></div>
                                                                        <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl3->hasDoc ? 'block' :'none'}}">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>
    </div>
</form>
</div>

    <div class="modal fade modal-asking" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top:12vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
            <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-body pt-5" id="prompt-container">
                    <div class="asking">
                        @if(auth()->user()->isEngineerAssessment())
                            Selesaikan penilaian untuk kenderaan ini?<br/>
                        @elseif(auth()->user()->isForemenAssessment())
                            Hantar permohonan kepada<br/>
                            Penolong Jurutera?
                        @else
                            Hantar permohonan kepada<br/>
                            Jurutera?
                        @endif
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <span class="btn btn-module" xaction="approve">Hantar</span>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Batal</span>
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-enlarge-image')

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        let save_as = "";

        var categoryId = -1;
        var subCategoryId = -1;
        var subCategoryTypeId = -1;
        var vehicleBrandId = -1;
        var vehicleModelId = -1;

        function show(element){
            $(element).show();
        }

        function getSubCategory(category_id){

            $('#list_sub_category').html('<option value="">Sila Pilih</option>');
            $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getSubCategory')}}", {
                category_id: category_id
            }, function(result){

                let count = result.length;
                let totalInit = 0;
                let same = false;
                let display_list_sub_category = $('#display_list_sub_category');

                if(count == 0){
                    display_list_sub_category.hide();
                }
                else{
                    display_list_sub_category.show();
                    result.forEach(element => {
                        $('#list_sub_category').append('<option value='+element.id+'>'+element.name+'</option>');
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
                    $('#list_sub_category').val(subCategoryId).trigger("change");
                }

            });
        }

        function getSubCategoryType(sub_category_id){

            $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getSubCategoryType')}}", {
                sub_category_id: sub_category_id
            }, function(result){

                let count = result.length;
                let totalInit = 0;
                let same = false;
                let display_list_sub_category_type = $('#display_list_sub_category_type');

                if (count == 0){
                    display_list_sub_category_type.hide();
                }
                else{
                    display_list_sub_category_type.show();
                    result.forEach(element => {
                        $('#list_sub_category_type').append('<option value='+element.id+'>'+element.name+'</option>');
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

                    //$('#list_sub_category_type').val(data.sub_category_type_id).trigger("change");
                    $('#list_sub_category_type').val(subCategoryTypeId).trigger("change");
                }

            });
        }

        function getVehicleModel(brand_id){

            $('#list_vehicle_model').html('<option value="">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getVehicleModel')}}", {
                brand_id: brand_id
            }, function(result){

                let count = result.length;
                let totalInit = 0;
                let same = false;

                result.forEach(element => {
                    $('#list_vehicle_model').append('<option value='+element.id+'>'+element.name+'</option>');
                    totalInit++;
                    if(vehicleModelId == element.id){
                        same = true;
                    }
                });

                if(count == totalInit){
                    if(!same){
                        vehicleModelId = null;
                    }
                    $('#list_vehicle_model').val(vehicleModelId).trigger("change");
                }

            });
        }

        submitExaminationAchievementVehicle = function(formData, save_as){

            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('save_as', save_as);
            parent.startLoading();
            $.ajax({
                url: "{{ route('assessment.safety.vehicle-assessment.form.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {

                    if(save_as == 'approve'){
                        //console.log(routeWhenApproved);
                        window.location.href = response.url;
                    }
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    parent.stopLoading();
                },
                error: function(response) {
                    parent.stopLoading();
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });
                }
            });
        }

        function selectHash(self){
            $('.selected').removeClass('selected disabled');

            let hash = window.location.hash;
            $(self).addClass('selected disabled');
        }
        function checkThis(details, obj) {
            $('#kaedah .btn').removeClass('active');
            $('#check_type').val(details);
            $(obj).addClass('active');
            if(details == 'Komputer'){
                $('#row_vtl').fadeIn();
            }else{
                $('#row_vtl').fadeOut();
            }
        }

        checkIfAllChecked = function(){
            let totalCheckBox = $('.check_is_pass').length;
            let totalChecked = $('.check_is_pass:checked').length;
            console.log(totalCheckBox, totalChecked);
            if(totalCheckBox == totalChecked){
                $('#check_all').prop('checked', true);
            }
        }


        uploadFile = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('.form-label').text('Tukar Fail')
                $(self).parent().find('#preview_img').attr('src', url).show();
            }

            let formData = new FormData();
            let id = $(self).attr('data-id');
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).attr('data-lvl'));
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.safety.vehicle-assessment.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#row_vtl').load(document.URL + ' #row_vtl');
                    $('#reload_veh').load(document.URL + ' #reload_veh');
                    // $('#reload_img_lvl2_'+id+'').load(document.URL + ' #reload_img_lvl2_'+id+'');
                    // $('#reload_img_lvl3_'+id+'').load(document.URL + ' #reload_img_lvl3_'+id+'');
                    // window.location.reload();
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        deleteFile = function(doc_id, lvl, id){
            let formData = new FormData();
            var doc_id = doc_id;
            var lvl = lvl;
            var id = id;
            console.log(doc_id, lvl, id);
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', id);
            formData.append('lvl', $(self).data('lvl'));
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('doc_id', doc_id);
            formData.append('lvl', lvl);

            $.ajax({
                url: "{{ route('assessment.safety.vehicle-assessment.form-file.delete') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_veh').load(document.URL + ' #reload_veh');
                    $('#row_vtl').load(document.URL + ' #row_vtl');
                    // $('#reload_img_lvl2_'+id+'').load(document.URL + ' #reload_img_lvl2_'+id+'');
                    // $('#reload_img_lvl3_'+id+'').load(document.URL + ' #reload_img_lvl3_'+id+'');
                    // window.location.reload();
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        function openEnlargeModal(self){

            $('#enlargeImageModal img').attr('src', $(self).attr('src'));
            $('#enlargeImageModal').modal('show');
        }

        $(document).ready(function(){
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

             $('select').select2({
                 width: '100%',
                 theme: "classic"
             });


            categoryId = {{$vehicleDetails->category_id ? $vehicleDetails->category_id : -1}};
            subCategoryId = {{$vehicleDetails->sub_category_id ? $vehicleDetails->sub_category_id : -1}};
            subCategoryTypeId = {{$vehicleDetails->sub_category_type_id ? $vehicleDetails->sub_category_type_id : -1}};

            vehicleBrandId = {{$vehicleDetails->vehicle_brand_id ? $vehicleDetails->vehicle_brand_id : -1}};

            if(categoryId != -1){
                getSubCategory(categoryId);
            }

            if(vehicleBrandId != -1){
                getVehicleModel(vehicleBrandId);
            }

            //to count the progress of this form
            summarizeThisForm();

            $('#check_all').on('change', function(){
                $('.check_is_pass').prop('checked', this.checked);
                //summarizeThisForm();
            })

            $('[xaction]').on('click', function(){
                save_as = $(this).attr('xaction');

                if(save_as == 'approve'){
                    let formData = new FormData($('#frm_examination_achievement_vehicle')[0]);
                    submitExaminationAchievementVehicle(formData, save_as);
                }
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                submitExaminationAchievementVehicle(formData, save_as);
            });

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

                    selectHash(this);

                    }
                }
            });

        });


    </script>


</body>

</html>
