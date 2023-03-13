@php
    use App\Models\Assessment\AssessmentDisposalVehicle;
    use App\Models\Assessment\AssessmentVehicleImage;
    use App\Models\Assessment\AssessmentFormCheckLvl1;
    use App\Models\Vehicle\Brand;
    use App\Models\RefCategory;
    $tab = Request('tab') ? Request('tab') : null;
    $vehicle_id = Request('vehicle_id');
    $AssessmentDisposalVehicle = AssessmentDisposalVehicle::find($vehicle_id);
    $OwnImage = AssessmentVehicleImage::where('vehicle_id', $AssessmentDisposalVehicle->id)
                                        ->whereHas('hasAssessmentType', function($q){
                                            $q->where('code', '06');
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
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
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
        .response-toast {
            left:calc(100vw-300px) !important;
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
            border-color:#d3cece;
            border-width:1px;
            border-style:solid;
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
            color: #463779 !important;
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
            text-transform: uppercase;
            color: #463779 !important;
            height:70px;
            padding-right:20px;
            text-align: right;
            border-right-width: 1px;
            border-right-color:#e7eae4;
            border-right-style: solid;
            vertical-align: middle;
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
        #kaedah .active {
            background-color:#463779;
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
        .sub-header-ind {
            font-family:avenir-bold;font-size:12px;line-height:12px;
        }
        .striploin {
            background-color:#eae7e7;
        }
        .bac_wf {
            /*penilaian pelupusan*/
            background-color: #f2eeee !important;
        }
        .slidecontainer {
            width: 100%; /* Width of the outside container */
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            padding-left:-1px;
        }
        .slidecontainer span {
            float:right;
            text-align: right;
        }

        /* The slider itself */
        .slider {
        -webkit-appearance: none;  /* Override default CSS styles */
            appearance: none;
            width: 100%; /* Full-width */
            height: 25px; /* Specified height */

            background-color:#ffffff;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            /*-webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);*/

            box-shadow: -1px 0px 7px 0px rgba(0,0,0,0.13) inset;
            -webkit-box-shadow: -1px 0px 7px 0px rgba(0,0,0,0.13) inset;
            -moz-box-shadow: -1px 0px 7px 0px rgba(0,0,0,0.13) inset;
            border-color:#dcdcd8;
            border-width:2px;
            border-style:solid;

            outline: none; /* Remove outline */
            opacity: 0.7; /* Set transparency (for mouse-over effects on hover) */
            -webkit-transition: .2s; /* 0.2 seconds transition on hover */
            transition: opacity .2s;
        }

        /* Mouse-over effects */
        .slider:hover {
            opacity: 1; /* Fully shown on mouse-over */
        }

        /* The slider handle (use -webkit- (Chrome, Opera, Safari, Edge) and -moz- (Firefox) to override default look) */
        .slider::-webkit-slider-thumb {
            -webkit-appearance: none; /* Override default look */
            appearance: none;
            width: 21px; /* Set a specific slider handle width */
            height: 21px; /* Slider handle height */
            background: #463779; /* Green background */
            cursor: pointer; /* Cursor on hover */

            border-radius: 6px 6px 6px 6px;
            -moz-border-radius: 6px 6px 6px 6px;
            -webkit-border-radius: 6px 6px 6px 6px;
        }

        .slider::-moz-range-thumb {
            width: 25px; /* Set a specific slider handle width */
            height: 25px; /* Slider handle height */
            background: #04AA6D; /* Green background */
            cursor: pointer; /* Cursor on hover */
        }
        .input-group-text {
            height: 42px !important;
            line-height:28px;
            background-color:#ffffff;
            border-radius: 0px 8px 8px 0px;
            -moz-border-radius: 0px 8px 8px 0px;
            -webkit-border-radius: 0px 8px 8px 0px;
            font-family: avenir;
            font-size: 12px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            border-color:#dcdcd8;
            border-width:2px;
            border-style:solid;
            cursor: pointer;
        }
        .slider {
            border-radius: 8px 8px 8px 8px;
            -moz-border-radius: 8px 8px 8px 8px;
            -webkit-border-radius: 8px 8px 8px 8px;
        }
        #harga-asal {
            font-size:20px;
            line-height: 40px;
            margin-bottom:0px;
        }
        #tahun-asal {
            font-size:30px;
            line-height: 40px;
            margin-bottom:0px;
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
        /*.txt-data {
            font-family: helvetica;
            font-size:16px;
            line-height: 16px;
            text-transform: uppercase;
            margin-bottom:15px;
        }*/
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
            .the-section {
                line-height: 20px;
                height: 40px;
                border-right-style: none;
                padding-left:20px;
            }
            ul.asstabrow {
                margin-left:0px;
            }
            .assessment-tab {
                top:70px;
                height:50px;
                width:100%;
                padding-left:0px;
                padding-right:0px;
            }
            .top-fix {
                height:140px;
                padding-left:10px;
                padding-right:10px;
            }
            .sect-top-dummy {
                height:140px;
            }
            .table-responsive {
                overflow:scroll-x;
                padding:20px;
            }
            .table-responsive .table-custom {
                width:800px;
                margin-right:20px;
            }
        }

    </style>
    <script type="text/javascript">
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
        function summarizeThisForm() {
            //count the status of form
            var user_level = $('#user_level').val();
            var mileage_distance = $('#mileage_distance').val();
            var donecheck = $('.mustcheck:input:checkbox:checked').length;
            var rows= $('.core-answer').length;
            var pembawah = rows + 1;

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

            if(user_level == 'TA'){
                pembawah = pembawah + 4;
            }

            var mustcheck = $('.mustcheck:input:radio:checked').length;
            if(mileage_distance != ''){
                mustcheck = mustcheck + 1;
            }

            if(user_level == 'TA'){
                if(parseInt($('#delivery_service').val()) > 0){
                    mustcheck = mustcheck + 1;
                }
                if(parseInt($('#post_durability').val()) > 0){
                    mustcheck = mustcheck + 1;
                }
                if(parseInt($('#post_current_value').val()) > 0){
                    mustcheck = mustcheck + 1;
                }
                if(parseInt($('#current_value').val()) > 0){
                    mustcheck = mustcheck + 1;
                }
            }

            var pctg = parseInt((parseFloat(mustcheck) / parseFloat(pembawah))*100);
            $('.progress-bar').attr('style','width: ' + pctg + '%');
            $('#special-progress').text(pctg + '%');

            @if(auth()->user()->isForemenAssessment())
            @else
                if(pctg < 100){
                    $('.send-button').prop('disabled', true);
                }else if(pctg == 100){
                    $('.send-button').prop('disabled', false);
                }
            @endif
        }
        function countCurrentValSchedule() {
            //count current value according to schedule
            var thisVal = $('#depre-schedule').text();
            thisVal = thisVal.replace('%','');
            var oriprice = $('#ori_price').val();
            oriprice = oriprice.replace(/,/g, ''),

            sugg = (parseFloat(thisVal) / 100) * parseFloat(oriprice);

            sugg = sugg.replace(/[^\d.]/g, '');
            $('#current_value').val(sugg);
            $('#current_value2').html(sugg);
            //alert(oriprice);
        }
        function calculateDepreciationValue(){
            //get value from jadual susutnilai
            var selectedAge = $('#selected_age').val();
            var selectedBrand = $('#selected_model').val();
            var url = '{{route('settings.calculateDepreciationValue')}}';

            $.ajax({
                url: url,
                data: {selectedAge: selectedAge, selectedBrand: selectedBrand},
                cache: false,
                //contentType: false,
                //processData: false,
                dataType:'json',
                method: 'GET',
                success: function(data){
                    $('#result_class').val(data.classname);

                    $('#result_percentage').val(data.percentage);
                    $('#suggestion').text(data.percentage + "% (" + data.classname + ")");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(xhr.status);
                    var err = eval("(" + xhr.responseText + ")");
                    //alert(err.Message);
                }
            });

            summarizeThisForm();
        }
        function sumValAfter() {
            //sum nilai selepas
            var current_value = $('#current_value').val();
            current_value = current_value.replace(/[^\d.]+/g,'');

            var maincost = $('#current_maintenance_cost').val();
            maincost = maincost.replace(/[^\d.]+/g,'');

            var postval = 0.0;
            if(parseInt(maincost) > 0){
                postval = (parseFloat(maincost) / 2) + parseFloat(current_value);
            }else{
                postval = parseFloat(current_value);
            }
            $('#post_current_value').val(convertCurrency(postval));
        }
        function simulateDepreciation() {
            //simulate depreciation vs original price
            var oriprice = $('#ori_price').val();
            oriprice = oriprice.replace(/[^\d.]+/g,'');

            var manupct = $('#manual_depreciation').val();
            manupct = manupct.replace(/[^\d.]+/g,'');

            var curprice = (parseFloat(manupct) / 100) * parseFloat(oriprice);
            curprice = curprice.toFixed(2);
            $('#current_value').val(convertCurrency(curprice));
            $('#current_value2').html(convertCurrency(curprice));

            sumValAfter();
        }
        function initCurrValue() {
            calculateDepreciationValue();
            //check who uses the form
            var user_level = $('#user_level').val();
            if(user_level == 'TA'){
                //check value of Current Value;
                var curVal = $('#current_value').val();
                if(parseInt(curVal) == '0'){
                    //calculate
                    //get result_percentage
                    var resPct = $('#result_percentage').val();
                    var oriprice = $('#ori_price').val().replace(/,/g, '');

                    var currValue = (parseFloat(resPct)/100)*parseFloat(oriprice);
                    currValue = currValue.toFixed(2);
                    $('#current_value').val(convertCurrency(currValue));
                    $('#current_value2').html(convertCurrency(currValue));
                }
            }
        }
        function updateBasedOnSchedule() {
            //update NILAI SEMASA mengikut Jadual Susutnilai
            var curVal = $('#current_value').val();
            curVal = curVal.replace(/[^\d.]+/g,'');

            //calculate
            //get result_percentage
            var resPct = $('#result_percentage').val();
            var oriprice = $('#ori_price').val();
            oriprice = oriprice.replace(/[^\d.]+/g,'');

            var latestValue = (parseFloat(resPct)/100)*parseFloat(oriprice);
            latestValue = latestValue.toFixed(2);
            $('#current_value').val(convertCurrency(latestValue));
            $('#current_value2').html(convertCurrency(latestValue));

            sumValAfter();
        }
        function manualChangeCurValue() {
            //change NILAI SEMASA secara manual
            var curVal = $('#current_value').val();
            curVal = curVal.replace(/[^\d.]+/g,'');

            var curCost = $('#current_maintenance_cost').val();
            curCost = curCost.replace(/[^\d.]+/g,'');

            var postValue = 0.0;
            if(parseFloat(curCost) > 0){
                postValue = parseFloat(curVal) + (parseFloat(curCost)/2);
                $('#post_current_value').val(convertCurrency(postValue));
            }else{
                postValue = parseFloat(curVal);
                $('#post_current_value').val(convertCurrency(postValue));
            }

            $('#current_value').val(convertCurrency(curVal));
            $('#current_value2').html(convertCurrency(curVal));
            changePct();
        }
        function changePct() {
            var curVal = $('#current_value').val();
            curVal = curVal.replace(/[^\d.]+/g,'');

            var oriprice = $('#ori_price').val();
            oriprice = oriprice.replace(/[^\d.]+/g,'');

            var lever = 0.0;
            if(parseInt(oriprice) > 0){
                lever = (parseFloat(curVal) / parseFloat(oriprice)) * 100;
                $('#manual_depreciation').val(Math.ceil(lever));
                $('.slidecontainer #susut').text(Math.ceil(lever));
            }
        }
        function cadangLer() {
            $('#kewpa_remarks').val("Butir-butir pembaikan yang perlu:\n 1. Sistem enjin kenderaan masih berfungsi.\n 2. Sistem transmisi/kotak gear perlu diselenggara sepenuhnya.\n 3. Sistem penyaman udara, sistem brek dan suspensi/gantungan perlu diselenggara sepenuhnya.");
        }

        function cadangLer2() {
            $('#kewpa_remarks2').val("Diakui bahawa aset tersebut telah diperiksa dan perakukan untuk pelupusan atas-atas sebab-sebab berikut :\n 1. Kenderaan tersebut telah berusia 1 tahun dan prestasi kenderaan menurun\n 2. Keupayaan kenderaan tidak lagi ditahap yang optimum.\n");
        }
    </script>
</head>
<body class="content">
<div id="response" class="alert alert-spakat response-toast" role="alert"></div>
<div class="top-fix">
    <div class="mytitle">Penilaian <span>Pelupusan</span></div>

    <div class="show-plet-no">
        <div style="position: absolute;right:200px;width:140px;height:50px;padding-top:7px;background-color:#ffffff;padding-left:5px;padding-right:5px;-webkit-border-radius: 8px;-moz-border-radius: 8px;border-radius: 8px;border-color:#e1e5de;border-style:solid;border-width:1px">
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="my-progress"></div>
            </div>
            <div class="float-end" style="font-family: mark-bold;color:#383631" id="special-progress">0%</div>
        </div>
        {{$AssessmentDisposalVehicle->plate_no}}
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
                <a href="{{ route('assessment.disposal.register', [
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
                <li class="my-tab ass_dis" onclick="scrollTarget('PEMERIKSA', this)">PEMERIKSA</li>
                @if (auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment())
                <li class="my-tab ass_dis" onclick="scrollMaster()">JUSTIFIKASI</li>
                <li class="my-tab ass_dis" onclick="scrollTarget('ASAS', this)">ASAS</li>
                @else
                <li class="my-tab ass_dis" onclick="scrollMaster()">ASAS</li>
                @endif
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
<div class="sect-top-dummy"></div>
@php
    $age = date("Y") - $AssessmentDisposalVehicle->manufacture_year;
    $brand = $AssessmentDisposalVehicle->vehicle_brand_id;
@endphp
<div class="main-content">
    <form id="frm_examination_achievement_vehicle">
        @csrf
        <div class="fixed-submit">
            @if(auth()->user()->isEngineerAssessment())
                <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Selesai</button>
                <button class="btn btn-link" type="submit" xaction="draf" formnovalidate><i class="fa fa-save"></i> Simpan</button>
            @elseif(auth()->user()->isAssistEngineerAssessment())
                <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Hantar</button>
                <button class="btn btn-link" type="submit" xaction="draf" formnovalidate><i class="fa fa-save"></i> Simpan</button>
            @elseif(auth()->user()->isForemenAssessment())
                <button class="btn btn-module" type="button" xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal">Hantar</button>
                <button class="btn btn-link" type="submit" xaction="draf" formnovalidate><i class="fa fa-save"></i> Simpan</button>
            @endif
        </div>
        <div class="row" id="assess-form">
            <input type="hidden" name="check_type" id="check_type" value="Komputer">
            <input type="hidden" name="selected_age" id="selected_age" value="{{$age}}">
            <input type="hidden" name="selected_model" id="selected_model" value="{{$brand}}">
            <input type="hidden" name="ori_price" id="ori_price" value="{{$AssessmentDisposalVehicle->original_price}}">
            <input type="hidden" name="earlier_maintenance_cost" id="earlier_maintenance_cost" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->earlier_maintenance_cost == null ? 0: $AssessmentDisposalVehicle->earlier_maintenance_cost}}" style="max-width: 130px" >
            <input type="hidden" name="user_level" id="user_level" value="{{auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() ? 'TA' : 'Tukang'}}">
            <input type="hidden" name="result_class" id="result_class" value="">
            <input type="hidden" name="result_percentage" id="result_percentage" value="15">
            <input type="hidden" name="odometer" id="odometer" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->odometer ? '' : 0}}" >
            <div class="col-xl-12 col-lg-12 col-md-12 paper mt-4" style="{{auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() ? '' : 'display: none'}}">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 bac_wf p-0">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5 text-end small-section" onclick="calculateDepreciationValue();">Penolong Jurutera</div>
                            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7 wf-details" id="test">{{auth()->user()->isAssistEngineerAssessment() ? auth()->user()->name : ''}}</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5 text-end small-section">Tarikh & Masa</div>
                            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7 wf-details">
                                {{Carbon\Carbon::now()->format('d M Y')}}
                                <small>{{\Carbon\Carbon::parse($AssessmentDisposalVehicle->verify_dt)->format('g:i:s A')}}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12">
                        <div class="the-section">Justifikasi</div>
                    </div>
                    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                        <div class="row" style="{{auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() ? '' : 'display: none'}}">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-12" style="padding-top:14px">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark" style="line-height: 6px">Tahap Penyampaian<br/>Perkhidmatan (%) <span class="text-danger">*</span></label>
                                    {{--<input  type="text" name="delivery_service" id="delivery_service" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->delivery_service == null ? 0: $AssessmentDisposalVehicle->delivery_service}}" style="max-width: 130px" >--}}

                                    <div class="slidecontainer" style="width:80%;">
                                        <input type="range" min="0" max="100" value="{{$AssessmentDisposalVehicle->delivery_service}}" class="slider custom-range" id="delivery_service" name="delivery_service">
                                        <span id="service-level">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-6" style="padding-top:14px">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark" style="line-height: 6px">Anggaran Tahan<br/>Selepas Dibaiki <small>(Tahun)</small><span class="text-danger">*</span></label>

                                    <select class="form-control form-select" id="post_durability" name="post_durability" style="width: 130px" onchange="summarizeThisForm()">
                                        <option></option>
                                        @php
                                            $pilihan = $AssessmentDisposalVehicle->post_durability == null ? "0" : $AssessmentDisposalVehicle->post_durability;
                                            for ($tahan = 0; $tahan <= 5; $tahan++) {
                                                $selected = '';
                                                if($tahan == $AssessmentDisposalVehicle->post_durability){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = '';
                                                }
                                                echo "<option value='{$tahan}' {$selected}>{$tahan} tahun</option>";
                                            }
                                        @endphp

                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6" style="padding-top:14px">
                                <div class="form-group">
                                <label for="" class="form-label text-dark" style="line-height: 6px">Anggaran Kos<br/>Penyelenggaraan Semasa <small>RM</small><span class="text-danger">*</span></label>
                                <input onchange="sumValAfter();" type="text" name="current_maintenance_cost" id="current_maintenance_cost" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->current_maintenance_cost == null ? 0: number_format($AssessmentDisposalVehicle->current_maintenance_cost, 2, '.', ',')}}" style="max-width: 130px" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark" style="line-height: 14px">Harga Perolehan Asal </label>
                                    <div class="txt-data" id="harga-asal"><small>RM</small> {{number_format($AssessmentDisposalVehicle->original_price, 2, '.', ',')}}</div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark" style="line-height: 14px">Rujuk Jadual<br/>Susut Nilai <small>%</small></label></div>
                                    <div class="btn-group">
                                        <button type="button" class="btn cux-btn bigger" style="margin-top:-7px" id="suggestion" onclick="updateBasedOnSchedule()"><i class="far fa-chart-line-down"></i> 0%</button>
                                        <button type="button" class="btn cux-btn bigger" style="margin-top:-7px" id="suggestion"><i class="fas fa-calculator"></i> Kalkulator</button>
                                    </div>
                                    <div class="txt-data"><small style="line-height:30px">(Usia {{$age}})</small></div>

                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                <label for="" class="form-label text-dark" style="line-height: 6px">Anggaran Nilai<br/>Selepas Diperbaiki <small>RM</small><span class="text-danger">*</span></label>
                                <input onchange="sumValAfter();" type="text" name="post_current_value" id="post_current_value" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->post_current_value == null ? 0: number_format($AssessmentDisposalVehicle->post_current_value, 2, '.', ',')}}" style="max-width: 130px">
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row pb-4">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                <label for="" class="form-label text-dark">Simulasi Susut Nilai <small>%</small></label></div>
                                {{--<input  type="text" name="delivery_service" id="delivery_service" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->delivery_service == null ? 0: $AssessmentDisposalVehicle->delivery_service}}" style="max-width: 130px" >--}}

                                <div class="slidecontainer" style="width:80%">
                                    <input type="range" min="0" max="100" value="{{$AssessmentDisposalVehicle->manual_depreciation ? $AssessmentDisposalVehicle->manual_depreciation : 0}}" class="slider custom-range" id="manual_depreciation" name="manual_depreciation" onchange="simulateDepreciation();">
                                    <span id="susut">0</span>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label currency" style="line-height: 6px">Nilai Semasa<br/><small>RM</small> <span class="text-danger">*</span></label>
                                    <div class="txt-data" id="harga-nilai-semasa"><p style="font-size: 40px;" id="current_value2"></p></div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label currency" style="line-height: 6px">Nilai Semasa<br/><small>RM</small> <span class="text-danger">*</span></label>
                                    {{--<input onchange="forceCurrency(this)" type="text" name="current_value" id="current_value" class="form-control text-end" autocomplete="off" value="" style="max-width: 130px" >--}}
                                    <input type="text" class="form-control text-end" name="current_value" id="current_value" placeholder="0.00" aria-describedby="basic-addon2" value="{{$AssessmentDisposalVehicle->current_value == null ? 0: number_format($AssessmentDisposalVehicle->current_value, 2, '.', ',')}}" onchange="manualChangeCurValue()" style="max-width: 130px">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark" style="line-height: 14px">Tahun Dibuat</label>
                                    <div class="txt-data" id="tahun-asal">{{$AssessmentDisposalVehicle->manufacture_year}} <small>{{$age}} tahun</small></div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row pb-4">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label currency" style="line-height: 6px">No. Siri Pendaftaran Aset</label>
                                    <input type="text" class="form-control" name="aset_regno" id="aset_regno" value="{{$AssessmentDisposalVehicle->aset_regno == null ? '-': $AssessmentDisposalVehicle->aset_regno}}" style="max-width: 150px" onchange="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-6">
                                <div class="form-group">
                                    <label for="" class="form-label currency" style="line-height: 6px">No. Kodifikasi Nasional</label>
                                    <input type="text" class="form-control" name="nc_no" id="nc_no" value="{{$AssessmentDisposalVehicle->nc_no == null ? '-': $AssessmentDisposalVehicle->nc_no}}" style="max-width: 150px" onchange="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 paper mt-4">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 bac_wf p-0">
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5 text-end small-section">Pembantu Kemahiran</div>
                            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7 wf-details">{{$AssessmentDisposalVehicle->foremenBy ? $AssessmentDisposalVehicle->foremenBy->name : '-'}}</div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 col-md-3 col-sm-3 col-5 text-end small-section">Tarikh & Masa</div>
                            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-7 wf-details">
                                {{\Carbon\Carbon::parse($AssessmentDisposalVehicle->foremen_dt)->format('d M Y')}}
                                <small>{{\Carbon\Carbon::parse($AssessmentDisposalVehicle->foremen_dt)->format('g:i:s A')}}</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="ASAS">
                        <div class="the-section">Asas</div>
                    </div>
                    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" style="padding-top:10px">
                                @if($AssessmentDisposalVehicle->hasCategory->code == "02")
                                    <div class="col-xl-10 col-lg-10 col-md-3 col-sm-3 col-12" style="padding-top:6px">
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark" style="line-height: 6px">Tempoh Penggunaan<small>jam</small><span class="text-danger">*</span></label>
                                        <input type="number" name="hours_used" id="hours_used" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->hours_used == null ? 0: $AssessmentDisposalVehicle->hours_used}}" style="max-width: 120px" >
                                        </div>
                                    </div>
                                @else
                                    <div class="col-xl-10 col-lg-10 col-md-3 col-sm-3 col-12" style="padding-top:6px">
                                        <div class="form-group">
                                            <label for="" class="form-label text-dark" style="line-height: 6px">Jumlah Jarak<br/>Perjalanan <small>km</small><span class="text-danger">*</span></label>
                                            <input type="number" name="mileage_distance" id="mileage_distance" class="form-control text-end" autocomplete="off" value="{{$AssessmentDisposalVehicle->mileage_distance == null ? 0: $AssessmentDisposalVehicle->mileage_distance}}" style="max-width: 120px" onchange="summarizeThisForm()">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-3 col-sm-3 col-12 leftline" style="padding-top:8px">
                                <div >
                                    <div class="form-group" id="own_image">
                                        @if($OwnImage->count() < 5)
                                            <label for="" class="form-label  text-dark">Imej Kenderaan <span class="text-danger">*</span></label>
                                            {{-- <button type="button" class="btn cux-btn bigger" style="margin-top:2px"><i class="fas fa-image"></i> Muat Naik Gambar</button> --}}
                                            <div class="col-md-9"><label for="veh_img_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik</label></div>
                                            <input onchange="uploadFile(this)" data-id="{{$vehicle_id}}" data-lvl="veh_img_doc" class="form-control d-none" accept="image/*" type="file" id="veh_img_doc" />
                                        @endif
                                    </div>
                                </div>
                                <hr/>
                                {{-- @php
                                    $path = '';
                                    $docName = '';
                                    if($AssessmentDisposalVehicle->hasVehicleImgDoc){
                                        $path = $AssessmentDisposalVehicle->hasVehicleImgDoc->doc_path;
                                        $docName = $AssessmentDisposalVehicle->hasVehicleImgDoc->doc_name;
                                    }
                                @endphp
                                <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer mb-4" style="{{$AssessmentDisposalVehicle->hasVehicleImgDoc ? '' :'display:none'}}"> --}}
                                    <span id="reload_perdiv">
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
                                        <div style="position:relative; width:150px;" >
                                            <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentDisposalVehicle->id}}, 'veh_img_doc', {{$vehicleImage->id}})"><i class="fa fa-times icon-white"></i></div>
                                            <img id="preview_vehicle" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$OwnImage ? 'block' :'none'}}">
                                        </div>
                                    @endforeach
                                @endif
                                    </span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="switch">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="engine_no" id="engine_no" value="{{$AssessmentDisposalVehicle->engine_no}}" placeholder="4D56-EL0995" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="switch">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">No Casis <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="chasis_no" id="chasis_no" value="{{$AssessmentDisposalVehicle->chasis_no}}" placeholder="52WVC10338" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="switch">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">Kategori </label>
                                        <select name="category_id" id="category" class="form-control form-select" onchange="getSubCategory(this.value)" >
                                            <option value="">Sila Pilih</option>
                                            @foreach ($category_list as $category)
                                                <option value="{{$category->id}}" {{$category->id == $AssessmentDisposalVehicle->category_id ? 'selected' : ''}}>{{strtoupper($category->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="switch">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">Sub Kategori </label>
                                        <select name="sub_category_id" id="list_sub_category" class="form-control form-select" onchange="getSubCategoryType(this.value)" >
                                            <option value="">Sila Pilih</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="switch">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">Jenis </label>
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
                                        <label for="" class="form-label text-dark">Buatan</label>
                                        <select class="form-control form-select" name="vehicle_brand_id" id="brand" onchange="getVehicleModel(this.value)">
                                            <option value="">Sila Pilih</option>
                                            @foreach ($brand_list as $brand )
                                                <option value="{{$brand->id}}" {{$brand->id == $AssessmentDisposalVehicle->vehicle_brand_id ? 'selected' : ''}}>{{$brand->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                <div class="switch">
                                    <div class="form-group">
                                        <label for="" class="form-label text-dark">Model</label>
                                        <input type="text" class="form-control" name="model_name" id="model_name" value="{{$AssessmentDisposalVehicle->model_name}}" placeholder="SAGA" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
                <div class="row" id="{{str_replace(' ', '', $AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname)}}">
                    <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12">
                        <div class="the-section">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</div>
                    </div>
                    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                        <div class="table-responsive">
                            <table class="table-custom no-footer stripe">
                                <thead>
                                    <th class="text-center pt-2">Baik (%)
                                        <hr style="margin-top:6px;margin-bottom:6px"/>
                                        <div class="row">
                                            <div class="col-4 sub-header-ind">75</div>
                                            <div class="col-4 sub-header-ind">50</div>
                                            <div class="col-4 sub-header-ind">25</div>
                                        </div>
                                    </th>
                                    <th class="text-center align-middle pt-2" style="width: 70px;">Rosak Teruk</th>
                                    <th class="text-center align-middle pt-2">Catatan</th>
                                    <th class="text-center" colspan="4">Tindakan
                                        <hr style="margin-top:6px;margin-bottom:6px"/>
                                        <div class="row">
                                            <div class="col-4 sub-header-ind">Baiki</div>
                                            <div class="col-4 sub-header-ind">B/Pulih</div>
                                            <div class="col-4 sub-header-ind">Ganti</div>
                                        </div>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-0">
                                            <div class="row p-0 core-answer">
                                                <div class="col-4">
                                                    <div class="form-switch">
                                                        <input type="radio" {{$AssessmentFormCheckLvl1->hasDisposalPercentage && $AssessmentFormCheckLvl1->hasDisposalPercentage->code == '01' ? 'checked': ''}} class="form-check-input cursor-pointer mt-2 me-2 mustcheck" name="form_check_percentage_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl1->id}}" value="01" required/>
                                                    </div>
                                                </div>
                                                <div class="col-4 pe-2">
                                                    <div class="form-switch">
                                                        <input type="radio" {{$AssessmentFormCheckLvl1->hasDisposalPercentage && $AssessmentFormCheckLvl1->hasDisposalPercentage->code == '02' ? 'checked': ''}} class="form-check-input cursor-pointer mt-2 me-2 mustcheck" name="form_check_percentage_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl1->id}}" value="02" required/>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-switch">
                                                        <input type="radio" {{$AssessmentFormCheckLvl1->hasDisposalPercentage && $AssessmentFormCheckLvl1->hasDisposalPercentage->code == '03' ? 'checked': ''}} class="form-check-input cursor-pointer mt-2 me-2 mustcheck" name="form_check_percentage_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl1->id}}" value="03" required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-0 text-center">
                                            <div class="form-switch" style="margin-top:8px;margin-left:5px">
                                                <input type="radio" {{$AssessmentFormCheckLvl1->hasDisposalPercentage && $AssessmentFormCheckLvl1->hasDisposalPercentage->code == '04' ? 'checked': ''}} class="form-check-input cursor-pointer mt-2 me-2 mustcheck" name="form_check_percentage_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl1->id}}" value="04"/>
                                            </div>
                                        </td>
                                        <td style="padding-top:3px;padding-left:4px;padding-right:4px;padding-bottom:0px;">
                                            <textarea name="form_note_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl1->id}}" rows="1" class="form-control mustcheck" maxlength="200" onchange="summarizeThisForm()">{{$AssessmentFormCheckLvl1->note}}</textarea>

                                        </td>
                                        <td class="text-center">
                                            <div class="form-switch">
                                                <input {{$AssessmentFormCheckLvl1->is_repair == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass" name="form_check_is_repair_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_is_repair_component_id_{{$AssessmentFormCheckLvl1->id}}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-switch">
                                                <input {{$AssessmentFormCheckLvl1->is_repairs ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass" name="form_check_is_repairs_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_is_repairs_component_id_{{$AssessmentFormCheckLvl1->id}}">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="form-switch">
                                                <input {{$AssessmentFormCheckLvl1->is_replacement ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass" name="form_check_is_replacement_lvl1_component_id_{{$AssessmentFormCheckLvl1->id}}" id="form_is_replace_component_id_{{$AssessmentFormCheckLvl1->id}}" >
                                            </div>
                                        </td>
                                        <td>
                                            <div class="hasErr"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="row" >
                    <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12">
                        <div class="the-section">Catatan KEW.PA-19</div>
                    </div>
                    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                        <button type="button" class="btn cux-btn" onclick="cadangLer()">Cadangkan Komen</button>
                        <textarea name="kewpa_remarks" id="kewpa_remarks" style="height: 250px;" cols="30" rows="10" class="form-control" onchange="summarizeThisForm()">{{str_replace("<br>", "", $AssessmentDisposalVehicle->kewpa_remarks)}}</textarea>
                    </div>
                </div>


                <div class="row" >
                    <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12">
                        <div class="the-section">Catatan KEW.PA-19 (2)</div>
                    </div>
                    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12">
                        <button type="button" class="btn cux-btn" onclick="cadangLer2()">Cadangkan Komen</button>
                        <textarea name="kewpa_remarks2" id="kewpa_remarks2" style="height: 250px;" cols="30" rows="10" class="form-control" onchange="summarizeThisForm()">{{str_replace("<br>", "", $AssessmentDisposalVehicle->kewpa_remarks2)}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div style="height:400px"></div>
</div>
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
                <input type="hidden" name="section" value="examination">
            </div>
            <div class="modal-footer justify-content-start">
                <button class="btn btn-module" xaction="approve">Ya</button>
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

        submitExaminationAchievementVehicleDisposal = function(formData, save_as){

            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('save_as', save_as);
            parent.startLoading();
            $.ajax({
                url: "{{ route('assessment.disposal.vehicle-assessment.form.save') }}",
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
                    let errors = response.responseJSON.errors;
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
        function selectHash(self){
            $('.checked').removeClass('checked disabled');

            let hash = window.location.hash;
            $(self).addClass('checked disabled');
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

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('id', $(self).attr('data-id'));
            formData.append('lvl', $(self).data('lvl'));
            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.disposal.vehicle-assessment.form-file.save') }}",
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
            $.post("{{route('assessment.disposal.deleteRelatedDoc')}}", {
                vehicle_id: vehicle_id,
                image_id: image_id,
                section: section,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                    $('#reload_perdiv').load(document.URL + ' #reload_perdiv');
                    $('#own_image').load(document.URL + ' #own_image');
            })
        }

        function openEnlargeModal(self){

            $('#enlargeImageModal img').attr('src', $(self).attr('src'));
            $('#enlargeImageModal').modal('show');
        }

            $(function(){
                $('#edit').editable({
                inlineMode: false
                })
            });

            $(function(){
                $('#edit').editable({
                autosave: false, // Enable autosave option. Enabling autosave helps preventing data loss.
                autosaveInterval: 1000, // Time in milliseconds to define when the autosave should be triggered.
                saveURL: null, // Defines where to post the data when save is triggered. The editor will initialize a POST request to the specified URL passing the editor content in the body parameter of the HTTP request.
                blockTags: ["n", "p", "blockquote", "pre", "h1", "h2", "h3", "h4", "h5", "h6"], // Defines what tags list to format a paragraph and their order.
                borderColor: "#252528", // Customize the appearance of the editor by changing the border color.
                buttons: ["bold", "italic", "underline", "strikeThrough", "fontSize", "color", "sep", "formatBlock", "align", "insertOrderedList", "insertUnorderedList", "outdent", "indent", "sep", "selectAll", "createLink", "insertImage", "undo", "redo", "html"], // Defines the list of buttons that are available in the editor.
                crossDomain: false, // Make AJAX requests using CORS.
                direction: "ltr", // Sets the direction of the text.
                editorClass: "", // Set a custom class for the editor element.
                height: "auto", // Set a custom height for the editor element.
                imageMargin: 20, // Define a custom margin for image. It will be visible on the margin of the image when float left or right is active.
                imageErrorCallback: false,
                imageUploadParam: "file", // Customize the name of the param that has the image file in the upload request.
                imageUploadURL: "http://uploads.im/api", // A custom URL where to save the uploaded image.
                inlineMode: true, // Enable or disable inline mode.
                placeholder: "Type something", // Set a custom placeholder to be used when the editor body is empty.
                shortcuts: true, // Enable shortcuts. The shortcuts are visible when you hover a button in the editor.
                spellcheck: false, // Enables spellcheck.
                typingTimer: 250, // Time in milliseconds to define how long the typing pause may be without the change to be saved in the undo stack.
                width: "auto" // Set a custom width for the editor element.
                })
            });

        $(document).ready(function(){

            initTab();
            let tab = '{{$tab}}';
            //$('#tab'+tab).trigger('click');
            initCurrValue();

             $('select').select2({
                 width: '100%',
                 theme: "classic"
             });

            categoryId = {{$AssessmentDisposalVehicle->category_id ? $AssessmentDisposalVehicle->category_id : -1}};
            subCategoryId = {{$AssessmentDisposalVehicle->sub_category_id ? $AssessmentDisposalVehicle->sub_category_id : -1}};
            subCategoryTypeId = {{$AssessmentDisposalVehicle->sub_category_type_id ? $AssessmentDisposalVehicle->sub_category_type_id : -1}};

            vehicleBrandId = {{$AssessmentDisposalVehicle->vehicle_brand_id ? $AssessmentDisposalVehicle->vehicle_brand_id : -1}};

            if(categoryId != -1){
                getSubCategory(categoryId);
            }

            if(vehicleBrandId != -1){
                getVehicleModel(vehicleBrandId);
            }

            $('#post_durability').select2({
                 width: '130px',
                 theme: "classic",
                 placeholder: "[Sila pilih]"
            });

            $('.mustcheck').change(function() {
                summarizeThisForm();
            });

            var slider = document.getElementById("delivery_service");
            var output = document.getElementById("service-level");
            output.innerHTML = slider.value;
            slider.oninput = function() {
                output.innerHTML = this.value;
                summarizeThisForm();
            }

            var slider2 = document.getElementById("manual_depreciation");
            var output2 = document.getElementById("susut");
            output2.innerHTML = slider2.value;
            slider2.oninput = function() {
                output2.innerHTML = this.value;
                summarizeThisForm();
            }

            /*$('#manual_depreciation').slider({
                slide: function() {
                    alert('A');
                }
            });*/

            /*var slider2 = document.getElementById("manual_depreciation");
            var output = document.getElementById("susut");
            output.innerHTML = slider2.value;
            slider2.oninput = function() {
                output.innerHTML = this.value;
                alert(this.value);
            }*/

            /**/


            //checkIfAllChecked();

            // $('.radio_check').on('click', function(){
            //     var radio = $('input:radio:checked').length;
            //     console.log(radio);
            //     if(radio == 3){
            //         var radio = 0;
            //         $(this).prop('checked', false);
            //     }
            // });

            $('#check_all').on('change', function(){
                $('.check_is_pass').prop('checked', this.checked);
            })

            $('[xaction]').on('click', function(){
                save_as = $(this).attr('xaction');

                if(save_as == 'approve'){
                    let formData = new FormData($('#frm_examination_achievement_vehicle')[0]);
                    submitExaminationAchievementVehicleDisposal(formData, save_as);
                }
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                submitExaminationAchievementVehicleDisposal(formData, save_as);
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
