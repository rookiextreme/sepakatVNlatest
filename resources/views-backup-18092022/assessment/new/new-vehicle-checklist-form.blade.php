@php
    use App\Models\Assessment\AssessmentNewVehicle;
    use App\Models\Assessment\AssessmentVehicleImage;
    use App\Models\Vehicle\Brand;
    use App\Models\RefCategory;

    $tab = Request('tab') ? Request('tab') : null;
    $vehicle_id = Request('vehicle_id');
    $AssessmentNewVehicle = AssessmentNewVehicle::find($vehicle_id);
    $OwnImage = AssessmentVehicleImage::where('vehicle_id', $AssessmentNewVehicle->id)
                                        ->whereHas('hasAssessmentType', function($q){
                                            $q->where('code', '01');
                                        })->get();
    $brand_list = Brand::all();
    $category_list = RefCategory::where('status', 1)->get();
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
            color:#849d48;
            display: inline;
            padding-right:13px;
            padding-left:10px;
            border-right-width: 1px;
            border-right-style: solid;
            border-right-color:#969690;
        }
        .cux-btn.active {
            background-color:#849d48;
        }
        ul.asstabrow li.my-tab:first-of-type {
            margin-left:-20px;
        }
        ul.asstabrow li.my-tab:hover {
            color:orange;
        }
        .awas {
            background-position:top right;
            background-size:150px 160px;
            background-repeat: no-repeat;
            min-height: 400px;
        }
        .the-section {
            font-family: lato-bold;
            font-size:16px;
            line-height: 18px;
            padding-top:14px;
            color:#849d48;
            height:70px;
            padding-right:20px;
            text-align: right;
            border-right-width: 1px;
            border-right-color:#e7eae4;
            border-right-style: solid;
            vertical-align: middle;
        }
        .w-40 {
            width: 40% !important;
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
        .table-custom {
            margin-top:0px !important;
        }
        .row-section {
            font-family:lato-bold;
            text-align:left;
        }
        .thin-topline {
            border-top-width: 1px;
            border-top-color:#c9d1c1;
            border-top-style: solid;
        }
        .w-imej {
            max-width:60px;
            width:60px;
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
        #assess-form {
            width:100%;
        }
        textarea {
            height:30px !important;
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
            /*Large devices (desktops, less than 1200pon 992px)*/
            /*medium*/
            .the-section {
                text-align:left;
            }
        }

        @media (max-width: 767.98px) {
            /* Small devices (landscape phones, less than 768px)
            /*small*/

        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
            .top-fix {
                top:-10px;
            }
            .assessment-tab {
                width:calc(100% - 50px);
            }
            .the-section {
                line-height: 20px;
                height: 30px;
                border-right-style: none;
                margin-left:20px;
            }
            .assessment-tab {
                top:20px;
                height:50px;
                width:100%;
            }
            .top-fix {
                height:140px;
            }
            .sect-top-dummy {
                height:140px;
            }
            .small-section {
                font-family: lato-bold;
                font-size:12px;
                line-height: 30px;
                text-transform: uppercase;
                color: #463779 !important;
                height:30px;
                padding-right:20px;
                text-align: right;
                vertical-align: middle;
            }
            .wf-details {
                font-family: lato-bold;
                font-size:12px;
                line-height: 30px;
                text-transform: uppercase;
                color: #1e1d1f !important;
                height:30px;
                text-align: left;
                vertical-align: middle;
            }
        }

    </style>
    <script type="text/javascript">
    function summarizeThisForm() {
        //count the status of form
        var user_level = $('#user_level').val();

        var rows= $('.must-answer').length;
        var pembawah = rows;

        var donecheck = $('.mustcheck:input:checkbox:checked').length;

        var mustselect = $('.mustselect').length;

        $(".mustselect option:selected").each(function(){
            if($(this).val() != ''){
                donecheck = donecheck + 1;
            }
        });

        if(parseInt(donecheck) == parseInt(rows)){

        }else{
            //there is unchecked answer
            $(".mustcheck:input:checkbox:not(:checked)").each(function () {
                //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
                var theId = $(this).attr("id");
                var newFld = theId.replace("form_check_component_id_", "form_note_component_id_");
                if($('#' + newFld).val() != ''){
                    donecheck = donecheck + 1;
                }
            });
        }
        var odo_read = $('#odometer').val();
        //for odo
        pembawah = pembawah + 1;
        if(odo_read != ''){
            donecheck = donecheck + 1;
        }

        var price = $('#price').val();
        if(parseFloat(price) > 0.0){
            pembawah = pembawah + 2;
            var receipt_no = $('#receipt_no').val();
            if(receipt_no != ''){
                donecheck = donecheck + 1;
            }

            var receipt_file = $('#receipt_file').val();
            if(receipt_file != ''){
                donecheck = donecheck + 1;
            }
        }

        var check_type = $('#check_type').val();

        if(check_type == 'Komputer'){
            pembawah = pembawah + 1;
            if($('#preview_vtl').length > 0){
                donecheck = donecheck + 1;
            }
        }
        if(user_level == 'TA'){
            //pembawah = pembawah + 4;
            /*if(parseInt($('#delivery_service').val()) > 0){
                donecheck = donecheck + 1;
            }
            if(parseInt($('#post_durability').val()) > 0){
                donecheck = donecheck + 1;
            }
            if(parseInt($('#post_current_value').val()) > 0){
                donecheck = donecheck + 1;
            }
            if(parseInt($('#current_value').val()) > 0){
                donecheck = donecheck + 1;
            }*/
        }
        //alert(donecheck + "/" + pembawah);
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
    <div class="mytitle" onclick="summarizeThisForm()">Penilaian <span>Kenderaan Baharu</span></div>

    <div class="show-plet-no">
        <div style="position: absolute;right:200px;width:140px;height:50px;padding-top:7px;background-color:#ffffff;padding-left:5px;padding-right:5px;-webkit-border-radius: 8px;-moz-border-radius: 8px;border-radius: 8px;border-color:#e1e5de;border-style:solid;border-width:1px">
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="my-progress"></div>
            </div>
            <div class="float-end" style="font-family: mark-bold;color:#383631" id="special-progress">0%</div>
        </div>
        {{$AssessmentNewVehicle->plate_no}}
    </div>

    <input type="hidden" name="user_level" id="user_level" value="{{auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() ? 'TA' : 'Tukang'}}">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                @if(auth()->user()->isForemenAssessment())
                <a href="{{ route('access.operation.dashboard') }}">Dashboard</a>
                @else
                <a href="{{ route('assessment.new.register', [
                    'id' => Request('assessment_id'),
                    'tab' => 4
                ]) }}">Penilaian Kenderaan Baharu</a>
                @endif
            </li>
            <li class="breadcrumb-item active" aria-current="page">Borang Penilaian</li>
        </ol>
    </nav>
    <div class="assessment-tab">
        <div style="width:auto;white-space:nowrap;">
            <ul class="asstabrow">
                <li class="my-tab" onclick="scrollTarget('PEMERIKSA', this)">PEMERIKSA</li>
                <li class="my-tab" onclick="scrollMaster()">UMUM</li>
                {{-- <li class="my-tab" onclick="scrollTarget('row-payment', this)">PEMBAYARAN</li> --}}
                <li class="my-tab" onclick="scrollTarget('KAEDAH', this)">KAEDAH</li>
            @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
            <li class="my-tab" onclick="scrollTarget('{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}', this)">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</li>
            @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="main-content ">
    <form id="frm_examination_achievement_vehicle">
        @csrf
        <div class="fixed-submit">
            @if(auth()->user()->isEngineerAssessment())
                <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Selesai</button>
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
            @elseif(auth()->user()->isAssistEngineerAssessment())
                <button class="btn btn-module send-button" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Sahkan</button>
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
            @elseif(auth()->user()->isForemenAssessment())
                <button class="btn btn-module send-button" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Hantar</button>
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan</button>
            @endif
        </div>
        <input type="hidden" name="check_type" id="check_type" value="Komputer">
        <input type="hidden" name="price" id="price" value="{{$AssessmentNewVehicle->price}}">
        <div class="paper" id="assess-form">
            <div class="row">
                <div class="col-xl-3 col-lg-2 col-md-12 col-12" id="PEMERIKSA">
                    <div class="the-section main">PEMERIKSA</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 bac_wf p-0">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5" style="color: #080807;font-family: lato-bold; font-size:
                                12px; text-transform: uppercase; height: 30px; padding-right:20px;
                                vertical-align:middle;">Pembantu Kemahiran</div>
                                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7"  style="color: #080807;font-family: lato-bold; font-size:
                                12px; text-transform: uppercase; height: 30px; padding-right:20px;
                                vertical-align:middle;">{{$AssessmentNewVehicle->foremenBy ? $AssessmentNewVehicle->foremenBy->name : '-'}}</div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5" style="color: #080807;font-family: lato-bold; font-size:
                                12px; text-transform: uppercase; height: 30px; padding-right:20px;
                                vertical-align:middle;">Tarikh & Masa</div>
                                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7"  style="color: #080807;font-family: lato-bold; font-size:
                                12px; text-transform: uppercase; height: 30px; padding-right:20px;
                                vertical-align:middle;">
                                    {{\Carbon\Carbon::parse($AssessmentNewVehicle->foremen_dt)->format('d M Y')}}
                                    <small  style="color: #080807;font-family: lato-bold; font-size:
                                    12px; text-transform: uppercase; height: 30px; padding-right:20px;
                                    vertical-align:middle;">{{\Carbon\Carbon::parse($AssessmentNewVehicle->foremen_dt)->format('g:i:s A')}}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                    <div class="the-section main">UMUM</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Odometer <span class="text-danger">*</span></label>
                                    <input type="number" name="odometer" id="odometer" class="form-control" value="{{$AssessmentNewVehicle->odometer}}" onchange="summarizeThisForm()" maxlength="7">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-2 col-md-3 col-sm-3 col-12">
                            <div class="form-group" id="own_image">
                                @if($OwnImage->count() < 5)
                                    <label for="" class="form-label text-dark">Imej Kenderaan<span class="text-danger"></span></label>
                                    <div class="col-md-9"><label for="veh_img_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik</label></div>
                                    <input onchange="uploadFileVehicle(this)" data-id="{{$AssessmentNewVehicle->id}}" data-lvl="veh_img_doc" class="form-control d-none" accept="image/*" type="file" id="veh_img_doc" />
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-10 col-md-9 col-sm-9 col-12" id="reload_veh">
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
                                        <div  style="position:relative; width:150px;">
                                            <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentNewVehicle->id}}, 'veh_img_doc', {{$vehicleImage->id}})"><i class="fa fa-times icon-white"></i></div>
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
                                    <input type="text" class="form-control" name="engine_no" id="engine_no" value="{{$AssessmentNewVehicle->engine_no}}" placeholder="4D56-EL0995" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">No Casis <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chasis_no" id="chasis_no" value="{{$AssessmentNewVehicle->chasis_no}}" placeholder="52WVC10338" onchange="this.value = this.value.toUpperCase()" maxlength="30">
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
                                            <option value="{{$category->id}}" {{$category->id == $AssessmentNewVehicle->category_id ? 'selected' : ''}}>{{strtoupper($category->name)}}</option>
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
                                            <option value="{{$brand->id}}" {{$brand->id == $AssessmentNewVehicle->vehicle_brand_id ? 'selected' : ''}}>{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                            <div class="switch">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Model <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="model_name" id="model_name" value="{{$AssessmentNewVehicle->model_name}}" placeholder="SAGA" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            {{-- <div class="row thin-topline" id="row-payment">
                <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                    <div class="the-section">PEMBAYARAN</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Jumlah Bayaran </label>
                                <div class="txt-data ass_gov mt-2"><small>RM</small> {{number_format($AssessmentNewVehicle->price, 2, '.', ',')}}</div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Resit</label>
                                {{-- <input type="text" class="form-control" name="receipt_no" id="receipt_no" value="{{$AssessmentNewVehicle->hasAssessmentDetail->hasBpkNo->code}}" style="max-width:130px" maxlength="10">
                                <div class="txt-data ass_gov mt-2">{{$AssessmentNewVehicle->hasAssessmentDetail->hasBpkNo->code}}</div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5 col-6">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Resit Bayaran <span class="text-danger">{{$AssessmentNewVehicle->receipt_doc > 0 ? "*" : " "}}</span></label>
                                <div class="col-md-9"><label for="receipt_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Gambar</label></div>
                                <input onchange="uploadFileReceipt(this)" data-id="{{$vehicle_id}}" data-lvl="receipt_doc" class="form-control d-none" accept="image/*" type="file" id="receipt_doc" />
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-6" id="reload_receipt">
                            @if ($AssessmentNewVehicle->hasReceiptDoc)
                                @php
                                    $path = '';
                                    $docName = '';
                                    if($AssessmentNewVehicle->hasReceiptDoc){
                                        $path = $AssessmentNewVehicle->hasReceiptDoc->doc_path;
                                        $docName = $AssessmentNewVehicle->hasReceiptDoc->doc_name;
                                    }
                                @endphp
                                <input type="hidden" name="receipt_file" id="receipt_file" value="{{$docName}}">
                                <div  style="position:relative; width:150px; height:60px">
                                    <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentNewVehicle->id}}, 'receipt_doc', {{$AssessmentNewVehicle->receipt_doc}})"><i class="fa fa-times icon-white"></i></div>
                                    <img id="preview_receipt" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentNewVehicle->hasReceiptDoc ? 'block' :'none'}}">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row thin-topline" id="KAEDAH">
                <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                    <div class="the-section">KAEDAH</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                            <div class="form-group">
                            <label for="" class="form-label  text-dark">Kaedah Pemeriksaan <span class="text-danger">*</span></label>
                                <div class="btn-group" id="kaedah">
                                    <label for="evaluation_type" class="btn cux-btn bigger {{$AssessmentNewVehicle->evaluation_type == 'Manual' ? 'active' : ''}}" onClick="checkThis('Manual', this);summarizeThisForm()">Manual</label>
                                    <input type="text" class="form-control d-none" name="evaluation_type" id="evaluation_type" value="Manual">
                                    <label for="evaluation_type" class="btn cux-btn bigger {{$AssessmentNewVehicle->evaluation_type == 'Komputer' || $AssessmentNewVehicle->evaluation_type == null ? 'active' : ''}}" onClick="checkThis('Komputer', this);summarizeThisForm()">Berkomputer</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6" id="row_vtl" style="display: {{$AssessmentNewVehicle->evaluation_type == 'Manual' ? 'none' : 'show'}}">
                            <div class="form-group">
                                {{-- <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger">*</span></label>
                                <button type="button" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Laporan</button> --}}
                                <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger">*</span></label>
                                <div class="col-md-9"><label for="vtl_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Laporan</label></div>
                                <input onchange="uploadFileVTL(this)" data-id="{{$vehicle_id}}" data-lvl="vtl_doc" class="form-control d-none" accept="image/*" type="file" id="vtl_doc" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-2 col-md-3 col-sm-3 col-12" id="reload_vtl" style="display: {{$AssessmentNewVehicle->evaluation_type == 'Manual' ? 'none' : 'show'}}">
                            @if ($AssessmentNewVehicle->hasVtlDoc)
                                @php
                                    $path = '';
                                    $docName = '';
                                    if($AssessmentNewVehicle->hasVtlDoc){
                                        $path = $AssessmentNewVehicle->hasVtlDoc->doc_path;
                                        $docName = $AssessmentNewVehicle->hasVtlDoc->doc_name;
                                    }
                                @endphp
                                <div style="position:relative; width:150px; height:60px" id="vtl_img_for">
                                    <div class="img-del"><i class="fa fa-times icon-white"></i></div>
                                    <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentNewVehicle->id}}, 'vtl_doc', {{$AssessmentNewVehicle->vtl_doc}})"><i class="fa fa-times icon-white"></i></div>
                                    <img id="preview_vtl" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="120px" height="70px" class="cursor-pointer" style="display: {{$AssessmentNewVehicle->hasVtlDoc ? 'block' :'none'}};margin-bottom:10px" >
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row thin-topline">
                <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                    <div class="the-section main"></div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <div class="row thin-underline">
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-8 pt-3">
                            <div class="form-switch form-group">
                                <input type="checkbox" class="form-check-input mt-2" name="check_all" id="check_all">
                                <label class="form-check-label cursor-pointer" for="check_all" style="margin-top:-5px;font-size:14px">&nbsp;&nbsp;Lulus Semua</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
            <div class="row {{$loop->index > 0 ? "thin-topline" : ""}}">
                <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="{{str_replace(' ', '', $AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname)}}">
                    <div class="the-section">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</div>
                </div>
                <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                    <!--start of content-->
                    @if($AssessmentFormCheckLvl1->hasManySelection->count()>0)
                        <div class="row">
                            @foreach ($AssessmentFormCheckLvl1->hasManySelection as $hasSelection)
                                @php
                                    $tableList = DB::table($hasSelection->hasTableSelection->table)->get();
                                @endphp
                                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                    <div class="form-group must-answer">
                                        <label for="" class="form-label">{{$hasSelection->hasTableSelection->desc}}</label>

                                        @switch($hasSelection->hasSelectionType->code)
                                            @case('01')
                                            {{-- dropdown --}}
                                                <select class="form-select mustcheck mustselect" name="form_selection_id_{{$hasSelection->id}}" id="form_selection_id_{{$hasSelection->id}}" onchange="summarizeThisForm()" required>
                                                    <option></option>
                                                    @foreach ($tableList as $item)
                                                        <option {{$hasSelection->selected_id == $item->id ? 'selected': ''}} value="{{$item->id}}">{{$item->desc}}</option>
                                                    @endforeach
                                                </select>
                                                @break
                                            @case('02')
                                            {{-- checkbox --}}
                                            @php
                                                $selected_ids = explode(',', $hasSelection->selected_ids);
                                            @endphp

                                                @foreach ($tableList as $item)
                                                    <div class="form-check-inline">
                                                        <input
                                                        @if(in_array($item->id, $selected_ids))
                                                        checked="true"
                                                        @endif
                                                        type="checkbox" class="form-check-input mt-2" name="form_selection_id_{{$hasSelection->id}}[]" id="form_selection_id_{{$hasSelection->id}}_id_{{$item->id}}" value="{{$item->id}}">
                                                        <label for="form_selection_id_{{$hasSelection->id}}_id_{{$item->id}}" class="form-check-label cursor-pointer">{{$item->desc}}</label>
                                                    </div>
                                                @endforeach

                                                @break
                                            @case('03')
                                            {{-- radio --}}

                                                @break
                                            @default

                                            <select class="form-select mustcheck mustselect" name="form_selection_id_{{$hasSelection->id}}" id="form_selection_id_{{$hasSelection->id}}" onchange="summarizeThisForm()" required>
                                                <option></option>
                                                @foreach ($tableList as $item)
                                                    <option {{$hasSelection->selected_id == $item->id ? 'selected': ''}} value="{{$item->id}}">{{$item->desc}}</option>
                                                @endforeach
                                            </select>

                                        @endswitch
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif

                    @foreach ($AssessmentFormCheckLvl1->hasFormComponentCheckListLvl2 as $AssessmentFormCheckLvl2)
                        <div class="form-group mb-0" style="line-height:10px;"><label>{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</label></div>
                        <div class="col-10">
                        <table class="table-custom stripe no-footer">
                            <thead>
                                <th style="width: 50px;">Lulus</th>
                                <th class="w-40">Penilaian</th>
                                <th class="w-auto">Catatan</th>
                                <th class="text-center w-imej">Imej</th>
                            </thead>
                            <tbody class="no-footer">
                                @if($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3->count() == 0)
                                <tr class="must-answer">
                                    <td>
                                        <div class="form-switch">
                                            <input {{$AssessmentFormCheckLvl2->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mustcheck" name="form_check_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl2->id}}" onchange="summarizeThisForm()">
                                        </div>
                                    </td>
                                    <td>{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                    <td>
                                        <textarea style="resize: none;" name="form_note_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl2->id}}" rows="2" class="form-control"  onchange="summarizeThisForm()">{{$AssessmentFormCheckLvl2->note}}</textarea>
                                    </td>
                                    <div class="hasErr"></div>
                                    <td class="text-center">
                                        <label for="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" class="btn cux-btn bigger"><i class="fas fa-image"></i></label>
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
                                            <div style="position:relative; display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}; width:150px; height:60px" >
                                                <div class="img-del"><i class="fa fa-times icon-white"></i></div>
                                                <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl2->doc_id}}, 'lvl2', {{$AssessmentFormCheckLvl2->id}})"><i class="fa fa-times icon-white"></i></div>
                                                <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @else
                                @foreach ($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3 as $AssessmentFormCheckLvl3)
                                <tr class="must-answer">
                                    <td>
                                        <div class="form-switch">
                                            <input {{$AssessmentFormCheckLvl3->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mustcheck" name="form_check_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl3->id}}" onchange="summarizeThisForm()">
                                        </div>
                                    </td>
                                    <td>{{$AssessmentFormCheckLvl3->hasComponentLvl3->component}}</td>
                                    <td>
                                        <textarea style="resize: none;" name="form_note_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl3->id}}" rows="2" class="form-control"  onchange="summarizeThisForm()">{{$AssessmentFormCheckLvl3->note}}</textarea>
                                    </td>
                                    <div class="hasErr"></div>
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
                                            <div style="position:relative; display: {{$AssessmentFormCheckLvl3->hasDoc? 'block':'none'}}; width:150px; height:60px" id="reload_img_lvl3">
                                                <div class="img-del"><i class="fa fa-times icon-white"></i></div>
                                                <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl3->doc_id}}, 'lvl3', {{$AssessmentFormCheckLvl3->id}})"><i class="fa fa-times icon-white"></i></div>
                                                <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl3->hasDoc? 'block':'none'}}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        </div>
                    @endforeach
                   <!--end of content-->
                </div>
            </div>
            @endforeach
            <div style="height:100px"></div>
        </div>
    </form>
</div>



{{-- <div class="modal fade" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah semakan telah selesai dan ingin meneruskan proses ini?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="approve" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade modal-asking" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-body pt-5">
                <div class="asking">
                    @if(auth()->user()->isEngineerAssessment())
                        Selesaikan penilaian untuk kenderaan ini?<br/>
                        <small style="line-height:14px;margin-top:5px">Dengan selesainya penilaian ini,<br/>sijil boleh dikeluarkan untuk kenderaan ini.</small>
                    @elseif(auth()->user()->isForemenAssessment())
                        Hantar permohonan kepada<br/>
                        Penolong Jurutera?
                    @else
                        Hantar permohonan kepada<br/>
                        Jurutera?
                    @endif
                </div>
                {{-- <input type="hidden" name="section" value="examination"> --}}
            </div>
            <div class="modal-footer justify-content-start">
                <button class="btn btn-module" xaction="approve">Teruskan</button>
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
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

        submitExaminationAchievementVehicleNew = function(formData, save_as){

            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('save_as', save_as);

            parent.startLoading();
            $.ajax({
                url: "{{ route('assessment.new.vehicle-assessment.form.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    if(save_as == 'approve'){
                        window.location.href = response.url;
                    }
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    parent.stopLoading();
                },
                error: function(response) {
                    parent.stopLoading();
                    console.log(response);
                    var errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
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
            var id = $(self).attr('data-id');
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).data('lvl'));
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.new.vehicle-assessment.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_perdiv').load(document.URL + ' #reload_perdiv');
                    $('#reload_img_lvl2_'+id+'').load(document.URL + ' #reload_img_lvl2_'+id+'');
                    $('#reload_img_lvl3_'+id+'').load(document.URL + ' #reload_img_lvl3_'+id+'');
                    $('#own_image').load(document.URL + ' #own_image');
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
                url: "{{ route('assessment.new.vehicle-assessment.form-file.delete') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {

                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_img_lvl2_'+id+'').load(document.URL + ' #reload_img_lvl2_'+id+'');
                    $('#reload_img_lvl3_'+id+'').load(document.URL + ' #reload_img_lvl3_'+id+'');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        uploadFileReceipt = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('.form-label').text('Tukar Fail')
                $(self).parent().find('#preview_receipt').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).attr('data-lvl'));
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.new.vehicle-assessment.saveDocument.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_receipt').load(document.URL + ' #reload_receipt');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        uploadFileVTL = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('.form-label').text('Tukar Fail')
                $(self).parent().find('#preview_vtl').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).attr('data-lvl'));
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.new.vehicle-assessment.saveDocument.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_vtl').load(document.URL + ' #reload_vtl');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        uploadFileVehicle = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('.form-label').text('Tukar Fail')
                $(self).parent().find('#preview_vehicle').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).attr('data-lvl'));
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.new.vehicle-assessment.saveDocument.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_veh').load(document.URL + ' #reload_veh');
                    $('#own_image').load(document.URL + ' #own_image');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        deleteRelatedDoc = function(vehicle_id, section, image_id){
            $.post("{{route('assessment.new.deleteRelatedDoc')}}", {
                vehicle_id: vehicle_id,
                image_id: image_id,
                section: section,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(section=='veh_img_doc'){
                    $('#reload_veh').load(document.URL + ' #reload_veh');
                    $('#own_image').load(document.URL + ' #own_image');
                }else if(section=='receipt_doc'){
                    $('#reload_receipt').load(document.URL + ' #reload_receipt');
                }else{
                    $('#reload_vtl').load(document.URL + ' #reload_vtl');
                }
            })
        }

        function checkThis(details, obj) {
            $('#kaedah .btn').removeClass('active');
            $('#check_type').val(details);
            $(obj).addClass('active');
            if(details == 'Komputer'){
                $('#row_vtl').fadeIn();
                $('#reload_vtl').fadeIn();
                $('#vtl_img_for').fadeIn();
            }else{
                $('#row_vtl').fadeOut();
                $('#reload_vtl').fadeOut();
                $('#reload_vtl').fadeOut();
            }
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
                 theme: "classic",
                 placeholder: "Sila pilih"
             });

            categoryId = {{$AssessmentNewVehicle->category_id ? $AssessmentNewVehicle->category_id : -1}};
            subCategoryId = {{$AssessmentNewVehicle->sub_category_id ? $AssessmentNewVehicle->sub_category_id : -1}};
            subCategoryTypeId = {{$AssessmentNewVehicle->sub_category_type_id ? $AssessmentNewVehicle->sub_category_type_id : -1}};

            vehicleBrandId = {{$AssessmentNewVehicle->vehicle_brand_id ? $AssessmentNewVehicle->vehicle_brand_id : -1}};

            if(categoryId != -1){
                getSubCategory(categoryId);
            }

            if(vehicleBrandId != -1){
                getVehicleModel(vehicleBrandId);
            }

            checkIfAllChecked();

            summarizeThisForm();

            if(parseFloat($('#price').val()) == 0.0){
                $('#row-payment').hide();
            }

            $('#check_all').on('change', function(){
                $('.check_is_pass').prop('checked', this.checked);
                summarizeThisForm();
            })

            $('[xaction]').on('click', function(){
                save_as = $(this).attr('xaction');

                if(save_as == 'approve'){
                    let formData = new FormData($('#frm_examination_achievement_vehicle')[0]);
                    submitExaminationAchievementVehicleNew(formData, save_as);
                }
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                submitExaminationAchievementVehicleNew(formData, save_as);
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
