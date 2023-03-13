@php
    use App\Models\RefEngineFuelType;
    use App\Models\Assessment\AssessmentDisposalPercentage;
    use App\Models\Assessment\AssessmentFormCheckLvl1;
    use App\Models\Assessment\AssessmentCurrvalueVehicle;
    use App\Models\Vehicle\Brand;
    use App\Models\RefCategory;

    $tab = Request('tab') ? Request('tab') : null;
    $fuel_list = RefEngineFuelType::all();
    $percentage_rate = AssessmentDisposalPercentage::whereNotIn('value', ['100'])->orderBy('value')->get();
    $check_lvl_id =  Request('check_lvl_id');
    $vehicle_id = Request('vehicle_id');
    $vehicleDetails = AssessmentCurrvalueVehicle::find($vehicle_id);
    $AssessmentCheckListDetail = AssessmentFormCheckLvl1::find($check_lvl_id);
    $brand_list = Brand::where('status', 1)->orderBy('name')->get();
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
            color:#79482a;
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
            color:#79482a;
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
            padding-left:10px;
        }
        .form-switch label {
            font-family: mark;
            font-size:12px;
            color:#454545;
            margin-top:8px;
            text-transform: uppercase;
            cursor:pointer
        }
        .sub-label {
            font-family: mark;
            font-size:10px;
            color:#454545;
            text-transform: uppercase;
            cursor:pointer;
            margin-bottom:5px;
        }
        .floater-spec-right {
            width:auto;
            position: absolute;
            right:10px;
            height:50px;
        }
        .floater-spec-left {
            width:auto;
            position: absolute;
            left:10px;
            height:50px;
        }
        .cux-btn.active {
            background-color:#79482a;
            color:#ffffff;
        }
        .tyre-box {
            position: absolute;
            width:100%;
            left:0px;
            text-align:right;
            background-color:#ededed;
            padding:10px;
            padding-right:10px;
            -webkit-border-radius: 12px;
            -moz-border-radius: 12px;
            border-radius: 12px;
        }
        .tyre-box-right {
            position: absolute;
            width:100%;
            left:0px;
            text-align:left;
            background-color:#ededed;
            padding:10px;
            -webkit-border-radius: 12px;
            -moz-border-radius: 12px;
            border-radius: 12px;
        }
        .tyre-box.top, .tyre-box-right.top {
            top:0px;
        }
        .tyre-box.bot, .tyre-box-right.bot {
            bottom:0px;
        }
        .span.active {
            background:#79482a;
        }
        #total_seat span.active {
            background:#79482a;
        }
        #transmission span.active {
            background:#79482a;
        }
        #wheel_type span.active {
            background:#79482a;
        }
        #tyre_front_left_percentage span.active {
            background:#79482a;
        }
        #tyre_back_left_percentage span.active {
            background:#79482a;
        }
        #tyre_front_right_percentage span.active {
            background:#79482a;
        }
        #tyre_back_right_percentage span.active {
            background:#79482a;
        }
        .plet-no {
            position: absolute;
            right:30px;
            top:30px;
            background-color:#161616;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            border-radius: 6px;
            padding-left:20px;
            padding-right:20px;
            text-align: center;
            color:#ffffff;
            font-family: helve-bold;
            font-size:20px;
            line-height:50px;
            height:50px;
            display: table;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
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
                border-top-width: 1px;
                border-top-color:#79482a;
                border-top-style: solid;
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
        }

    </style>
    <script type="text/javascript">
    function summarizeThisForm() {
        //count the status of form
        var user_level = $('#user_level').val();

        var rows= $('.must-answer').length;
        var pembawah = rows;

        var donecheck = $('.mustcheck:input:checkbox:checked').length;

        //check price
        var price = $('#total_price').val();
        if(parseFloat(price) > 0.00){
            //check receipt no
            var receipt = $('#receipt_no').val();
            if(receipt.trim() != ''){
                donecheck = donecheck + 1;
            }

            //check attachment
            if($('#preview_img').length > 0){
                alert("ada image:");
                donecheck = donecheck + 1;
            }
        }



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
                    alert("Tangkap");
                }
            });
        }
        var odo_read = $('#odo_read').val();

        //for odo
        pembawah = pembawah + 1;

        if(odo_read != ''){
            donecheck = donecheck + 1;
        }

        var check_type = $('#check_type').val();

        if(check_type == 'Komputer'){
            pembawah = pembawah + 1;
            if($('#preview_img').length > 0){
                alert("ada image:");
                donecheck = donecheck + 1;
            }
            alert("donecheck(KOMPUTER):" + donecheck);
        }

        if(user_level == 'TA'){
            pembawah = pembawah + 4;
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
        alert(donecheck + "/" + pembawah);
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
<div class="top-fix">
    <div class="mytitle" onclick="summarizeThisForm()">Penilaian <span>Harga Semasa</span></div>
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
                ]) }}">Penilaian Pinjaman Kerajaan </a>
                @endif
            </li>
            <li class="breadcrumb-item active" aria-current="page">Borang Penilaian</li>
        </ol>
    </nav>
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <div class="show-plet-no">
        <div style="position: absolute;right:140px;width:140px;height:50px;padding-top:7px;background-color:#ffffff;padding-left:5px;padding-right:5px;-webkit-border-radius: 8px;-moz-border-radius: 8px;border-radius: 8px;border-color:#e1e5de;border-style:solid;border-width:1px">
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="my-progress"></div>
            </div>
            <div class="float-end" style="font-family: mark-bold;color:#383631" id="special-progress">0%</div>
        </div>
        {{$vehicleDetails->plate_no}}
    </div>
    <div class="assessment-tab">
        <div style="width:auto;white-space:nowrap;">
            <ul class="asstabrow">
                <li class="my-tab" onclick="scrollTarget('KAEDAH_PENILAIAN', this)">KAEDAH PENILAIAN</li>
                @if(auth()->user()->isForemenAssessment())
                @else
                    <li class="my-tab" onclick="scrollTarget('SYOR', this)">SYOR</li>

                @endif
                @if($vehicleDetails->vehicle_price == 0)
                @else
                    <li class="my-tab" onclick="scrollTarget('PEMBAYARAN', this)">PEMBAYARAN</li>
                @endif
                <li class="my-tab" onclick="scrollTarget('MAKLUMAT KENDERAAN', this)">MAKLUMAT KENDERAAN</li>
                <li class="my-tab" onclick="scrollTarget('KAEDAH_PEMERIKSAAN', this)">KAEDAH PEMERIKSAAN</li>
            {{-- @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
            <li class="my-tab" onclick="scrollTarget('{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}', this)">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</li>
            @endforeach --}}
                <li class="my-tab" onclick="scrollTarget('KEADAAN', this)">KEADAAN</li>
                <li class="my-tab" onclick="scrollTarget('SISTEM', this)">SISTEM</li>
                <li class="my-tab" onclick="scrollTarget('TAYAR', this)">TAYAR</li>
            </ul>
        </div>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="main-content">
    <form id="frm_examination_achievement_vehicle">
        @csrf
        <input type="hidden" value="61" name="depreciate_rate" id="depreciate_rate">
        <input type="hidden" value="{{$check_lvl_id}}" name="check_lvl_id">
        <input type="hidden" name="price" id="price" value="{{$vehicleDetails->vehicle_price}}">

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
        <!--<div class="row">
            <div class="col-md-3">
                <div class="col-md-12">
                    <h3>Semua Kriteria</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-12">

                </div>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="col-md-12">
                    <div class="btn-group float-end">
                        @if(auth()->user()->isForemenAssessment())
                        <button type="submit" xaction="draf" class="btn cux-btn small">Simpan</button>
                        @endif
                        <span xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal" class="btn cux-btn small">Selesai</span>
                    </div>
                </div>
            </div>
        </div>-->
        <input type="hidden" name="check_type" id="check_type" value="{{$vehicleDetails->evaluation_type == null ? 'Komputer' : $vehicleDetails->evaluation_type}}">
        <input type="hidden" name="check_type2" id="check_type2" value="{{$vehicleDetails->evaluation_currvalue_type == null ? 'Harga Semasa' : $vehicleDetails->evaluation_type}}">
        <input type="hidden" name="total_price" id="total_price" value="{{$AssessmentCheckListDetail->total_price}}">

        <div class="row paper" id="assess-form">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="max-width:1300px">
                <div class="row thin-topline" id="KAEDAH_PENILAIAN">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">KAEDAH PENILAIAN</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="row pb-2">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                <label for="" class="form-label  text-dark">Kaedah Penilaian <span class="text-danger">*</span></label>
                                    <div class="btn-group" id="penilaian">
                                        <button type="button" class="btn cux-btn bigger {{$vehicleDetails->evaluation_currvalue_type == 'Harga Semasa' || $vehicleDetails->evaluation_currvalue_type == null ? 'active' : ''}}" onClick="checkType('Harga Semasa', this)">Harga Semasa</button>
                                        <button type="button" class="btn cux-btn bigger {{$vehicleDetails->evaluation_currvalue_type == 'Sisa Besi' ? 'active' : ''}}" onClick="checkType('Sisa Besi', this)">Sisa Besi</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row thin-topline mt-4" id="SYOR" style="{{auth()->user()->isForemenAssessment() && $vehicleDetails->evaluation_currvalue_type == 'Sisa Besi' ? 'display: none':'';}}">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">SYOR</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Harga Asal Kenderaan <span class="text-danger">*</span></label>
                                    <input type="text" onchange="forceCurrency(this)" class="form-control text-end" name="original_price" id="original_price" value="{{number_format($vehicleDetails->original_price, 2, '.', ',')}}" placeholder="">
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Harga Beli <span class="text-danger">*</span></label>
                                    <input type="text" onchange="forceCurrency(this);tempohBerekonomi()" class="form-control text-end" placeholder="" name="current_price" id="current_price" value="{{number_format($vehicleDetails->current_price, 2, '.', ',')}}" placeholder="" >
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Harga Pasaran <span class="text-danger"></span></label>
                                    <input type="text" onchange="forceCurrency(this);tempohBerekonomi()" class="form-control text-end" name="market_price" id="market_price" value="{{number_format($vehicleDetails->market_price, 2, '.', ',')}}" placeholder="" >
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Anggaran Pembaikan <span class="text-danger">*</span></label>
                                    <input type="text" onchange="forceCurrency(this)" class="form-control text-end" placeholder="" name="estimate_repair" value="{{number_format($vehicleDetails->estimate_repair, 2, '.', ',')}}" id="estimate_repair" placeholder="" >
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Harga Anggaran <span class="text-danger">*</span></label>
                                    <input type="text" onchange="forceCurrency(this)" class="form-control text-end" placeholder="" name="estimate_price" value="{{number_format($vehicleDetails->estimate_price, 2, '.', ',')}}" id="estimate_price" placeholder="" >
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                            {{-- <div class="col-xl-3 col-lg-3 col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Tempoh Berekonomi (tahun) <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" name="durabilty" id="durabilty" placeholder="" value="{{$vehicleDetails->durabilty}}" >
                                    <div class="hasErr"></div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row thin-topline mt-4" id="eva_type2" style="{{auth()->user()->isForemenAssessment() && $vehicleDetails->evaluation_currvalue_type == 'Harga Semasa' ? 'display: none':'';}}">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">SISA BESI</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Harga Besi (RM) <span class="text-danger">*</span></label>
                                    <input type="text" onchange="forceCurrency(this)" class="form-control text-end" name="metal_price" id="metal_price" value="{{number_format($vehicleDetails->metal_price, 2, '.', ',')}}" placeholder="">
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-2">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Berat Besi (kg) <span class="text-danger">*</span></label>
                                    <input type="text" onchange="forceCurrency(this);tempohBerekonomi()" class="form-control text-end" placeholder="" name="metal_weight" id="metal_weight" value="{{number_format($vehicleDetails->metal_weight, 2, '.', ',')}}" placeholder="" >
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="row thin-topline" id="PEMBAYARAN">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">PEMBAYARAN</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                            <label for="" class="form-label  text-dark">Resit Bayaran <span class="text-danger">{{$AssessmentCheckListDetail->total_price > 0 ? "*" : " "}}</span></label>
                                            <div class="col-md-9"><label for="receipt_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Gambar</label></div>
                                            <input onchange="uploadFileReceipt(this)" data-id="{{$vehicle_id}}" data-lvl="receipt_doc" class="form-control d-none" accept="image/*" type="file" id="receipt_doc" />
                                            </div>
                                            @php
                                                $path = '';
                                                $docName = '';
                                                if($AssessmentCheckListDetail->hasReceiptDoc){
                                                    $path = $AssessmentCheckListDetail->hasReceiptDoc->doc_path;
                                                    $docName = $AssessmentCheckListDetail->hasReceiptDoc->doc_name;
                                                }
                                            @endphp
                                            <div id="reload_receipt">
                                                <img id="preview_receipt" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentCheckListDetail->hasReceiptDoc ? 'block' :'none'}}">
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-2 col-md-3 col-sm-3 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">No Resit <span class="text-danger"></span></label>
                                    <input type="text" class="form-control" onchange="forceCaps(this)" name="receipt_no" id="receipt_no" value="{{$AssessmentCheckListDetail->receipt_no}}" style="max-width:130px" maxlength="10">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-2 col-md-2 col-sm-2 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Jumlah <span class="text-danger"></span></label>
                                    <div class="txt-data ass_val mt-2"><small>RM</small> {{$vehicleDetails->vehicle_price}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row thin-topline" id="IMEJ">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">IMEJ</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-2 pb-3">
                        <div class="row">
                            <div class="row mb-3">
                                <div class="form-group">
                                    <div class="col-md-6" id="vehicle_doc_div">
                                        <div class="form-group">
                                        <label for="" class="form-label  text-dark">Gambar Kenderaan <span class="text-danger">*</span></label>
                                        <div class="col-md-9"><label for="vehicle_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Gambar</label></div>
                                        <input onchange="uploadFileVehicle(this)" data-id="{{$vehicle_id}}" data-lvl="vehicle_doc" class="form-control d-none" accept="image/*" type="file" id="vehicle_doc" />
                                        </div>
                                        @php
                                            $path = '';
                                            $docName = '';
                                            if($AssessmentCheckListDetail->hasVehicleImgDoc){
                                                $path = $AssessmentCheckListDetail->hasVehicleImgDoc->doc_path;
                                                $docName = $AssessmentCheckListDetail->hasVehicleImgDoc->doc_name;
                                            }
                                        @endphp
                                        <div id="reload_veh">
                                            <img id="preview_veh" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentCheckListDetail->hasVehicleImgDoc ? 'block' :'none'}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-xl-9 col-lg-8 col-md-8 col-sm-8 col-12">
                                <!--show attachment here-->
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row thin-topline" id="MAKLUMATKENDERAAN">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">MAKLUMAT KENDERAAN</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Bacaan Odometer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control text-end" name="odo_read" id="odo_read" value="{{$AssessmentCheckListDetail->odo_read}}" placeholder="" onchange="this.value = this.value.toUpperCase()" style="max-width: 140px">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Transmisi <span class="text-danger">*</span></label>
                                    <div class="btn-group" id="transmission" xname="transmission" style="margin-top:1px">
                                        <span data-trans="Manual" id="transmisi_manual" class="btn cux-btn bigger {{$AssessmentCheckListDetail->transmission == "Manual" ? 'active' : ''}}">Manual</span>
                                        <span data-trans="Automatik" class="btn cux-btn bigger {{$AssessmentCheckListDetail->transmission == "Automatik" ? 'active' : ''}}" id="transmisi_auto">Automatik</span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Bahan Bakar <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-control form-select" id="fuel_type_id" name="fuel_type_id">
                                            <option selected value="">Sila Pilih</option>
                                            @foreach ( $fuel_list as $fuel)
                                                <option {{$AssessmentCheckListDetail->fuel_type_id == $fuel->id ? 'selected'  : ''}} value="{{$fuel->id}}">{{$fuel->desc}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Pacuan <span class="text-danger">*</span></label>
                                    <div class="btn-group" id="wheel_type">
                                        <span data-drive="4X4" class="btn cux-btn bigger {{$AssessmentCheckListDetail->wheel_type == "4X4" ? 'active' : ''}}">4X4</span>
                                        <span data-drive="4X2" class="btn cux-btn bigger {{$AssessmentCheckListDetail->wheel_type == "4X2" ? 'active' : ''}}">4X2</span>
                                        <span data-drive="6X2" class="btn cux-btn bigger {{$AssessmentCheckListDetail->wheel_type == "6X2" ? 'active' : ''}}">6X2</span>
                                        <span data-drive="6X4" class="btn cux-btn bigger {{$AssessmentCheckListDetail->wheel_type == "6X4" ? 'active' : ''}}">6X4</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Muatan Tempat Duduk <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="total_seat" style="width: 50px" value="{{$AssessmentCheckListDetail->total_seat == null ? 4 : $AssessmentCheckListDetail->total_seat}}">
                                    {{-- <div class="btn-group" id="total_seat" >
                                        <span data-total="2" class="btn cux-btn bigger {{$AssessmentCheckListDetail->total_seat == "1" ? 'active' : ''}}">2</span>
                                        <span data-total="4" class="btn cux-btn bigger" {{$AssessmentCheckListDetail->total_seat == "4" ? 'active' : ''}}">4</span>
                                        <span data-total="5" class="btn cux-btn bigger" {{$AssessmentCheckListDetail->total_seat == "5" ? 'active' : ''}}">5</span>
                                        <span data-total="6" class="btn cux-btn bigger" {{$AssessmentCheckListDetail->total_seat == "6" ? 'active' : ''}}">6</span>
                                        <span data-total="7" class="btn cux-btn bigger" {{$AssessmentCheckListDetail->total_seat == "7" ? 'active' : ''}}">7</span>
                                        <span data-total="8" class="btn cux-btn bigger" {{$AssessmentCheckListDetail->total_seat == "8" ? 'active' : ''}}">8</span>
                                    </div> --}}
                                    {{-- <div>{{$AssessmentCheckListDetail->total_seat}}</div> --}}
                                </div>
                            </div>
                        </div>
                            <div class="modal-body">
                                <input type="hidden" name="assessment_vehicle_id" id="assessment_vehicle_id">
                                <fieldset>
                                    <legend>Maklumat Dalam Geran / VOC</legend>
                                <div class="row">
                                    <!--<p><i class="fas fa-info-circle"></i> Sila pastikan maklumat di bawah sama dengan Sijil Pemilikan Kenderaan (geran / VOC) :</p>-->
                                    <div class="col-xl-2 col-lg-3 col-md-3" style="position: relative">
                                        {{-- <div class="load-box"><img src="{{asset('my-assets/img/data-loader.gif')}}"></div> --}}
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark">No. Pendaftaran <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="cth: VBA112" onchange="this.value = this.value.toUpperCase()" value="{{$vehicleDetails->plate_no}}">
                                            <div class="hasErr"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark">No Chasis <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="chasis_no" id="chasis_no" placeholder="cth: RP8M82222KV010380" onchange="this.value = this.value.toUpperCase()" value="{{$vehicleDetails->chasis_no}}">
                                            <div class="hasErr"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="engine_no" id="engine_no" placeholder="cth: W828M5052900" onchange="this.value = this.value.toUpperCase()" value="{{$vehicleDetails->engine_no}}">
                                            <div class="hasErr"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark">Buatan <span class="text-danger">*</span></label>
                                            <select class="form-control form-select" name="vehicle_brand_id" id="brand" onchange="getVehicleModel(this.value)">
                                                <option value="">Sila Pilih</option>
                                                @foreach ($brand_list as $brand )
                                                    <option {{$vehicleDetails->vehicle_brand_id == $brand->id ? 'selected' : ''}} value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="hasErr"></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark">Model <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="model_name" id="model_name" placeholder="cth: X70, C200" onchange="this.value = this.value.toUpperCase()" value="{{$vehicleDetails->model_name}}">
                                            <div class="hasErr"></div>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Pengkelasan</legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">Kategori <span class="text-danger">*</span></label>
                                                <select name="category_id" id="category" class="form-control form-select" onchange="getSubCategory(this.value)" >
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($category_list as $category)
                                                        <option {{$vehicleDetails->category_id == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-4">
                                            <div class="form-group" id="display_list_sub_category" style="display:none;">
                                                <label for="" class="form-label text-dark">Sub Kategori <span class="text-danger">*</span></label>
                                                <select name="sub_category_id" id="list_sub_category" class="form-control form-select" onchange="getSubCategoryType(this.value)" >
                                                    <option value="">Sila Pilih</option>
                                                </select>
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-4" xfunction="sub_category_type_id" id="display_list_sub_category_type" style="display:none;">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">Jenis <span class="text-danger">*</span></label>
                                                <select name="sub_category_type_id" id="list_sub_category_type" class="form-control form-select" >
                                                    <option value="">Sila Pilih</option>
                                                </select>
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>Maklumat Pembelian</legend>
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-3 col-md-3" style="position: relative">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">Harga Beli <small>RM</small> <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-end" name="market_price" id="market_price" placeholder="" onchange="forceCurrency(this)" value="{{number_format($vehicleDetails->market_price, 2, '.', ',')}}">
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3" style="position: relative">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">Harga Asal <small>RM</small> <i class="fa fa-info-circle spakat-tip" data-bs-toggle="tooltip" data-bs-placement="top" title="Harga asal untuk kenderaan baharu"></i> <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control text-end" name="original_price" id="original_price" placeholder="" onchange="forceCurrency(this)" value="{{number_format($vehicleDetails->original_price, 2, '.', ',')}}">
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="" class="form-label">Tahun Dibuat <span class="text-danger">*</span> </label>

                                                <div class="input-group date" id="manufactureYear" data-date="" data-date-format="yyyy" data-link-field="manufacture_year">
                                                    <input class="form-control" size="16" id="manufactureYearInput" type="text" value="{{$vehicleDetails->manufacture_year}}" placeholder="XXXX" readonly>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    <label class="input-group-text" for="manufactureYearInput">
                                                        <i class="fal fa-calendar-alt"></i>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="manufacture_year" id="manufacture_year" value="" />
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="" class="form-label">Tarikh Didaftarkan <span class="text-danger">*</span> </label>

                                                <div class="input-group date" id="registrationVehicleDt" data-date="" data-date-format="dd/mm/yyyy">
                                                    <input class="form-control" size="16" id="registrationVehicleDtInput" type="text" value="{{$vehicleDetails->registration_vehicle_dt}}" placeholder="DD/MM/YYYY" readonly>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                    <label class="input-group-text" for="registrationVehicleDtInput">
                                                        <i class="fal fa-calendar-alt"></i>
                                                    </label>
                                                </div>
                                                <input type="hidden" name="registration_vehicle_dt" id="registration_vehicle_dt" value="" />
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <legend>Wakil Kuasa <i class="fa fa-info-circle spakat-tip" data-bs-toggle="tooltip" data-bs-placement="top" title="Individu yang bertanggungjawab menguruskan atau mengelola kenderaan yang hendak dibeli kelak"></i></legend>
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-3 col-md-3">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="applicant_name" id="applicant_name" maxlength="40" placeholder="cth: ISMAIL BIN IBRAHIM" onchange="this.value = this.value.toUpperCase()" value="{{$vehicleDetails->applicant_name}}">
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">My Kad <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" placeholder="XXXXXX-XX-XXXX" name="applicant_ic_no" maxlength="14" id="applicant_ic_no" placeholder="" onkeyup="updateFormat('applicant_ic_no', this)" value="{{$vehicleDetails->applicant_ic_no}}">
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4">
                                            <div class="form-group">
                                                <label for="" class="form-label text-dark">Syarikat <span class="text-danger"></span></label>
                                                <input type="text" class="form-control" name="applicant_company" id="applicant_company" placeholder="cth: PUNCAK JAYA SDN BHD" onchange="this.value = this.value.toUpperCase()" value="{{$vehicleDetails->applicant_company}}">
                                                <div class="hasErr"></div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                    </div>
                </div>

                <div class="row thin-topline" id="KAEDAH_PEMERIKSAAN">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">KAEDAH PEMERIKSAAN</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="row pb-2">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                <label for="" class="form-label  text-dark">Kaedah Pemeriksaan <span class="text-danger">*</span></label>
                                    <div class="btn-group" id="kaedah">
                                        <button type="button" class="btn cux-btn bigger {{$AssessmentCheckListDetail->evaluation_type == 'Manual' ? 'active' : ''}}" onClick="checkThis('Manual', this)">Manual</button>
                                        <button type="button" class="btn cux-btn bigger {{$AssessmentCheckListDetail->evaluation_type == 'Komputer' || $AssessmentCheckListDetail->evaluation_type == null ? 'active' : ''}}" onClick="checkThis('Komputer', this)">Komputer</button>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="vtl_doc_div" style="display: {{$AssessmentCheckListDetail->evaluation_type == 'Manual' ? 'none' : 'block'}}">
                                <div class="form-group">
                                <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger">*</span></label>
                                <div class="col-md-9"><label for="vtl_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Gambar</label></div>
                                <input onchange="uploadFileVTL(this)" data-id="{{$vehicle_id}}" data-lvl="vtl_doc" class="form-control d-none" accept="image/*" type="file" id="vtl_doc" />
                                </div>
                                @php
                                    $path = '';
                                    $docName = '';
                                    if($AssessmentCheckListDetail->hasVtlDoc){
                                        $path = $AssessmentCheckListDetail->hasVtlDoc->doc_path;
                                        $docName = $AssessmentCheckListDetail->hasVtlDoc->doc_name;
                                    }
                                @endphp
                                <div id="reload_vtl">
                                    <img id="preview_vtl" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentCheckListDetail->hasVtlDoc ? 'block' :'none'}}">
                                </div>
                            </div>
                            {{-- <div class="col-xl-4 col-lg-4 col-md-3 col-sm-3 col-6" id="row_vtl">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger"></span></label>
                                        <label class="btn cux-btn bigger mb-3" for="vtl_report"><i class="fas fa-image"></i> {{$AssessmentCheckListDetail->vtl_report ? 'Tukar Fail' : 'VTL'}} </label>
                                            <input type="file" onchange="changeVTL(this)" accept="pdf,image/*" class="form-control d-none" name="vtl_report" id="vtl_report" >

                                            <div id="preview-file-vtl" class="form-group mb-2" style="display: {{$AssessmentCheckListDetail->vtl_report ? 'block' : 'none'}};height: 200px;overflow: auto;">
                                            @php
                                                $pathUrl= '';
                                                if($AssessmentCheckListDetail->vtl_report){
                                                    $pathUrl =  '/storage/app/public/currvalue/vtl_report/'.$AssessmentCheckListDetail->vtl_report ? '' : null;
                                                }
                                            @endphp
                                                <embed src="{{$pathUrl}}" onclick="openEnlargeModal(this)" id="preview-file-vtl-embed" width="100%" type="">
                                            </div>
                                        </div>
                                    {{-- <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger">*</span></label>
                                    <button type="button" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Laporan</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row thin-topline" id="KEADAAN">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">KEADAAN</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-2">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Bahagian Bawah</label>
                                    <textarea name="bottom_part_cond" class="form-control" id="bottom_part_cond" rows="3">{{$AssessmentCheckListDetail->bottom_part_cond}}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Bahagian Dalam</label>
                                    <textarea name="inner_part_cond" class="form-control" id="inner_part_cond" rows="3">{{$AssessmentCheckListDetail->inner_part_cond}}</textarea>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Bahagian Luar</label>
                                    <textarea name="outer_part_cond" class="form-control" id="outer_part_cond" rows="3">{{$AssessmentCheckListDetail->outer_part_cond}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row thin-topline" id="SISTEM">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">SISTEM</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-3">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-xm-1 col-1">
                                <div class="form-group"><label for="" class="form-label text-dark">Sistem Enjin</label></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2 must-answer" name="engine_system_check" id="engine_system_check" {{$AssessmentCheckListDetail->engine_system_check == true ? 'checked' : ''}}>
                                    <label for="engine_system_check"> Berkeadaan Baik</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-10">
                                <div class="form-group">
                                    <textarea name="engine_system" class="form-control" id="engine_system" rows="2">{{$AssessmentCheckListDetail->engine_system}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-xm-1 col-1">
                                <div class="form-group"><label for="" class="form-label text-dark">Sistem Transmisi</label></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2 must-answer" name="trans_system_check" id="trans_system_check" {{$AssessmentCheckListDetail->trans_system_check == true ? 'checked' : ''}}>
                                    <label for="trans_system_check"> Berkeadaan Baik</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <textarea name="trans_system" class="form-control" id="trans_system" rows="2">{{$AssessmentCheckListDetail->trans_system}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-xm-1 col-1">
                                <div class="form-group"><label for="" class="form-label text-dark">Sistem Gantungan</label></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2 must-answer" name="susp_system_check" id="susp_system_check" {{$AssessmentCheckListDetail->susp_system_check == true ? 'checked' : ''}}>
                                    <label for="susp_system_check"> Berkeadaan Baik</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <textarea name="susp_system" class="form-control" id="susp_system" rows="2">{{$AssessmentCheckListDetail->susp_system}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-xm-1 col-1">
                                <div class="form-group"><label for="" class="form-label text-dark">Sistem Brek</label></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2 must-answer" name="brek_system_check" id="brek_system_check" {{$AssessmentCheckListDetail->brek_system_check == true ? 'checked' : ''}}>
                                    <label for="brek_system_check"> Berkeadaan Baik</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <textarea name="brek_system" class="form-control" id="brek_system" rows="2">{{$AssessmentCheckListDetail->brek_system}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-xm-1 col-1">
                                <div class="form-group"><label for="" class="form-label text-dark">Sistem Pendawaian</label></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2 must-answer" name="wiring_system_check" id="wiring_system_check" {{$AssessmentCheckListDetail->wiring_system_check == true ? 'checked' : ''}}>
                                    <label for="wiring_system_check"> Berkeadaan Baik</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <textarea name="wiring_system" class="form-control" id="wiring_system" rows="2">{{$AssessmentCheckListDetail->wiring_system}}</textarea>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-xm-1 col-1">
                                <div class="form-group"><label for="" class="form-label text-dark">Sistem Penyaman Udara</label></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2 must-answer" name="aircond_system_check" id="aircond_system_check" {{$AssessmentCheckListDetail->aircond_system_check == true ? 'checked' : ''}}>
                                    <label for="aircond_system_check"> Berkeadaan Baik</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
                                <div class="form-group">
                                    <textarea name="aircond_system" class="form-control" id="aircond_system" rows="2">{{$AssessmentCheckListDetail->aircond_system}}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row thin-topline" id="TAYAR">
                    <div class="col-xl-3 col-lg-3 col-md-12 col-12">
                        <div class="the-section main">TAYAR</div>
                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div class="row mt-3">
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4" style="position: relative;text-align:right;height:350px">
                                <div class="tyre-box top">
                                    <div class="sub-label">Kiri <span class="text-danger">*</span></div>
                                    <div class="floater-spec-right">
                                        <div class="input-group" id="tyre_front_left_percentage">
                                            {{-- @foreach ( $percentage_rate as $percentage)
                                                <span data-tyre_front_left="{{$percentage->desc}}" class="btn cux-btn bigger {{$percentage->desc == $AssessmentCheckListDetail->tyre_front_left_percentage ? 'active' : ''}}">{{$percentage->desc}}</span>
                                            @endforeach --}}
                                                <span data-tyre_front_left="25" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_front_left_percentage == 25 ? 'active' : ''}}">25%</span>
                                                <span data-tyre_front_left="50" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_front_left_percentage == 50 ? 'active' : ''}}">50%</span>
                                                <span data-tyre_front_left="75" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_front_left_percentage == 75 ? 'active' : ''}}">75%</span>
                                        </div>

                                    </div>
                                    <div style="height:50px"></div>
                                    <div class="sub-label">Dibuat</div>
                                    <input type="text" class="form-control text-center" maxlength="4" name="tyre_year_fl" id="tyre_year_fl" value="{{$AssessmentCheckListDetail->tyre_year_fl}}" placeholder="1121" onchange="this.value = this.value.toUpperCase()" style="width:60px;float:right">

                                </div>
                                <div class="tyre-box bot" style="bottom:0px;">
                                    <div class="sub-label">Kiri <span class="text-danger">*</span></div>
                                    <div class="floater-spec-right">
                                        <div class="input-group" id="tyre_back_left_percentage">
                                            {{-- @foreach ( $percentage_rate as $percentage)
                                                <span data-tyre_back_left="{{$percentage->desc}}" class="btn cux-btn bigger {{$percentage->desc == $AssessmentCheckListDetail->tyre_back_left_percentage ? 'active' : ''}}">{{$percentage->desc}}</span>
                                            @endforeach --}}
                                                <span data-tyre_back_left="25" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_back_left_percentage == 25 ? 'active' : ''}}">25%</span>
                                                <span data-tyre_back_left="50" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_back_left_percentage == 50 ? 'active' : ''}}">50%</span>
                                                <span data-tyre_back_left="75" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_back_left_percentage == 75 ? 'active' : ''}}">75%</span>
                                        </div>

                                    </div>
                                    <div style="height:50px"></div>
                                    <div class="sub-label">Dibuat</div>
                                    <input type="text" class="form-control text-center" maxlength="4" name="tyre_year_rl" id="tyre_year_rl" value="{{$AssessmentCheckListDetail->tyre_year_rl}}" placeholder="1121" onchange="this.value = this.value.toUpperCase()" style="width:60px;float:right">

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4 text-center">
                                <label for="" class="form-label text-dark">Hadapan</label>
                                <img src="{{asset('my-assets/img/chassis.svg')}}" style="height:270px">
                                <label for="" class="form-label text-dark">Belakang</label>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-4" style="position: relative;text-align:right;height:350px">
                                <div class="tyre-box-right top">
                                    <div class="sub-label">Kanan <span class="text-danger">*</span></div>
                                    <div class="floater-spec-left">
                                        <div class="input-group" id="tyre_front_right_percentage">
                                            {{-- @foreach ( $percentage_rate as $percentage)
                                                <span data-tyre_front_right="{{$percentage->desc}}" class="btn cux-btn bigger {{$percentage->desc == $AssessmentCheckListDetail->tyre_front_right_percentage ? 'active' : ''}}">{{$percentage->desc}}</span>
                                            @endforeach --}}
                                                <span data-tyre_front_right="25" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_front_right_percentage == 25 ? 'active' : ''}}">25%</span>
                                                <span data-tyre_front_right="50" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_front_right_percentage == 50 ? 'active' : ''}}">50%</span>
                                                <span data-tyre_front_right="75" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_front_right_percentage == 75 ? 'active' : ''}}">75%</span>
                                        </div>

                                    </div>
                                    <div style="height:50px"></div>
                                    <div class="sub-label">Dibuat</div>
                                    <input type="text" class="form-control text-center" maxlength="4" name="tyre_year_fr" id="tyre_year_fr" value="{{$AssessmentCheckListDetail->tyre_year_fr}}" placeholder="1121" onchange="this.value = this.value.toUpperCase()" style="width:60px;">

                                </div>
                                <div class="tyre-box-right bot" style="bottom:0px;">
                                    <div class="sub-label">Kanan <span class="text-danger">*</span></div>
                                    <div class="floater-spec-left">
                                        <div class="input-group" id="tyre_back_right_percentage">
                                            {{-- @foreach ( $percentage_rate as $percentage)
                                                <span data-tyre_back_right="{{$percentage->desc}}" class="btn cux-btn bigger {{$percentage->desc == $AssessmentCheckListDetail->tyre_back_right_percentage ? 'active' : ''}}">{{$percentage->desc}}</span>
                                            @endforeach --}}
                                                <span data-tyre_back_right="25" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_back_right_percentage == 25 ? 'active' : ''}}">25%</span>
                                                <span data-tyre_back_right="50" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_back_right_percentage == 50 ? 'active' : ''}}">50%</span>
                                                <span data-tyre_back_right="75" class="btn cux-btn bigger {{$AssessmentCheckListDetail->tyre_back_right_percentage == 75 ? 'active' : ''}}">75%</span>
                                        </div>

                                    </div>
                                    <div style="height:50px"></div>
                                    <div class="sub-label">Dibuat</div>
                                    <input type="text" class="form-control text-center" maxlength="4" name="tyre_year_rr" id="tyre_year_rr" value="{{$AssessmentCheckListDetail->tyre_year_rr}}" placeholder="1121" onchange="this.value = this.value.toUpperCase()" style="width:60px;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div style="height:300px"></div>
        </div>
    </form>
</div>

<!--<div class="modal fade" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
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
</div>-->


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

        function checkThis(details, obj) {
            $('#kaedah .btn').removeClass('active');
            $('#check_type').val(details);
            $(obj).addClass('active');
            if(details == 'Komputer'){
                $('#vtl_doc_div').fadeIn();
            }else{
                $('#vtl_doc_div').fadeOut();
            }
        }

        function checkType(details, obj) {
            $('#penilaian .btn').removeClass('active');
            $('#check_type2').val(details);
            $(obj).addClass('active');
            if(details == 'Harga Semasa'){
                $('#SYOR').fadeIn();
                $('#eva_type2').fadeOut();
            }else{
                $('#SYOR').fadeOut();
                $('#eva_type2').fadeIn();
            }
        }

        function tempohBerekonomi() {
            var tempoh = 0;
            var maxYears = 15;
            var tahunAsal = 2015;
            var tahunSkrg = 2021;
            var diff = parseInt(tahunSkrg) - parseInt(tahunAsal);
            if(parseInt(diff) > 15) {
                tempoh = 0;
            }else{
                if(parseInt(diff) > 8) {
                    tempoh = parseInt(maxYears) - parseInt(diff);
                }else{
                    tempoh = parseInt(maxYears) - parseInt(diff);
                }
            }
            return tempoh;
        }

        function show(element){
            $(element).show();
        }

        submitExaminationAchievementVehicle = function(formData, save_as){

            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('save_as', save_as);
            $('#frm_application .hasErr').html('');

            parent.startLoading();
            $.ajax({
                url: "{{ route('assessment.currvalue.vehicle-assessment.form.save') }}",
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
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    // window.location.reload();
                    parent.stopLoading();
                },
                error: function(response) {
                    console.log(response);
                    var errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox' || $('[xname="'+key+'"]')){
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
            formData.append('check_lvl_id', "{{Request('check_lvl_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.currvalue.vehicle-assessment.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    // console.log(response);
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
            formData.append('check_lvl_id', "{{Request('check_lvl_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.currvalue.vehicle-assessment.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    // console.log(response);
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
                $(self).parent().find('#preview_veh').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).attr('data-lvl'));
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('check_lvl_id', "{{Request('check_lvl_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.currvalue.vehicle-assessment.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    // console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_veh').load(document.URL + ' #reload_veh');

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

        function calculateEco() {
            //calcaulate tempoh berekonomi
        }
        function calculateCurrentEstimate() {
            var oriPrice = $('#original_price').val();
            var depRate = $('#depreciate_rate').val();
            var curPrice = (parseFloat(depRate) / 100.00) * parseFloat(oriPrice);
            $('#current_price').val(curPrice);
        }

        formAppend = function(formData){
            // let total_seat = $('#total_seat span.active').attr('data-total');
            let transmission = $('#transmission span.active').attr('data-trans');
            let wheel_type = $('#wheel_type span.active').attr('data-drive');
            let tyre_front_left = $('#tyre_front_left_percentage span.active').attr('data-tyre_front_left');
            let tyre_back_left = $('#tyre_back_left_percentage span.active').attr('data-tyre_back_left');
            let tyre_front_right = $('#tyre_front_right_percentage span.active').attr('data-tyre_front_right');
            let tyre_back_right = $('#tyre_back_right_percentage span.active').attr('data-tyre_back_right');

            // formData.append('total_seat',total_seat);
            formData.append('transmission', transmission);
            formData.append('wheel_type', wheel_type);
            formData.append('tyre_front_left', tyre_front_left);
            formData.append('tyre_back_left', tyre_back_left);
            formData.append('tyre_front_right', tyre_front_right);
            formData.append('tyre_back_right', tyre_back_right);
        }

        $(document).ready(function(){
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

             $('select').select2({
                 width: '100%',
                 theme: "classic"
             });

            if(parseFloat($('#price').val()) == 0.0){
                $('#PEMBAYARAN').hide();
            }

            calculateCurrentEstimate();

            checkIfAllChecked();

            $('#check_all').on('change', function(){
                $('.check_is_pass').prop('checked', this.checked);
            })

            $('#plate_no').on({
                keydown: function(e) {
                    if (e.which === 32)
                    return false;
                },
                change: function() {
                    this.value = this.value.replace(/\s/g, "");
                }
            });

            $('[xaction]').on('click', function(){
                save_as = $(this).attr('xaction');

                if(save_as == 'approve'){
                    let formData = new FormData($('#frm_examination_achievement_vehicle')[0]);
                    formAppend(formData);
                    submitExaminationAchievementVehicle(formData, save_as);
                }
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){

                e.preventDefault();
                let formData = new FormData(this);
                formAppend(formData);
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

            $('#transmission span').on('click', function(e) {
                e.preventDefault();

                $('#transmission span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

            $('#total_seat span').on('click', function(e) {
                e.preventDefault();

                $('#total_seat span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

            $('#wheel_type span').on('click', function(e) {
                e.preventDefault();

                $('#wheel_type span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

            $('#tyre_front_left_percentage span').on('click', function(e) {
                e.preventDefault();

                $('#tyre_front_left_percentage span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

            $('#tyre_back_left_percentage span').on('click', function(e) {
                e.preventDefault();

                $('#tyre_back_left_percentage span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

            $('#tyre_front_right_percentage span').on('click', function(e) {
                e.preventDefault();

                $('#tyre_front_right_percentage span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

            $('#tyre_back_right_percentage span').on('click', function(e) {
                e.preventDefault();

                $('#tyre_back_right_percentage span').removeClass('active');

                let self = this;
                $(self).addClass('active');
            });

        });

    </script>


</body>

</html>
