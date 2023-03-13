@php
    $tab = Request('tab') ? Request('tab') : null;
    $form_id = $detail->id;
    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;
    $isResearchMarket = $detail->is_research_market;
    $hasFormRepairInternal = null;
    $hasFormRepairExternal = null;
    $showInternalForm = false;
    $showExternalForm = false;
    $showInternalTestingForm = false;
    $showExternalTestingForm = false;

    if($detail->hasJVEForm){
        $MJobVehicleStatus = $detail->hasJVEForm->hasMaintenanceJobVehicleStatus;
        if($repair_method_id){
            $hasRepairMethod = $detail->hasRepairMethod;
            $hasFormRepairInternal = $detail->hasJVEForm->hasFormRepairInternal->first();
            $hasFormRepairExternal = $detail->hasJVEForm->hasFormRepairExternal->first();

            if($hasRepairMethod->code == '01'){
                $MJobVehicleStatus = $hasFormRepairInternal->hasMaintenanceJobVehicleStatus;
                if ($isResearchMarket == 2) {
                    $showInternalForm = false;
                    $showInternalTestingForm = true;
                }
                else {
                    $showInternalForm = true;
                    $showInternalTestingForm = false;
                }
            } 
            if($hasRepairMethod->code == '02'){
                $MJobVehicleStatus = $hasFormRepairExternal->hasMaintenanceJobVehicleStatus;
                if ($isResearchMarket == 2) {
                    $showExternalForm = false;
                    $showExternalTestingForm = true;
                }
                else {
                    $showExternalForm = true;
                    $showExternalTestingForm = false;
                }
            }
        }
    } else {
        if(!$isResearchMarket == 2){
            if($detail->hasInternalRepairStatus && in_array($detail->hasInternalRepairStatus->code, ['01','02','03','07'])){
                $showInternalForm = true;
            
            } 
            if((!$detail->hasInternalRepairStatus || $detail->hasInternalRepairStatus->code == '03') && $detail->hasExternalRepairStatus && in_array($detail->hasExternalRepairStatus->code, ['04','05', '06','08'])){
                $showExternalForm = true;
            }
        }
        if($isResearchMarket == 2){
            if($detail->hasInternalRepairStatus && in_array($detail->hasInternalRepairStatus->code, ['01','02','03','07'])){
            $showInternalTestingForm = true;
           
            } 
            if((!$detail->hasInternalRepairStatus || $detail->hasInternalRepairStatus->code == '03') && $detail->hasExternalRepairStatus && in_array($detail->hasExternalRepairStatus->code, ['04','05', '06','08'])){
                $showExternalTestingForm = true;
            }
        }    
        
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

        .fixed-submit {
            position: fixed;bottom:0px;left:0px;width:100%;height:65px;background-color:#dde3d7;padding-left:30px;padding-top:13px;z-index:100;
            border-top-width: 1px;
            border-top-color:#c9d1c1;
            border-top-style: solid;
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
            margin-left: 2px !important;
            border: transparent;
            background: #dbdcd8;
        }

        .sub-component {
            list-style-type: upper-roman;
        }

        .sub-component li {
            color: #1f1f1f;
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
    <div class="mytitle">Servis Dan Pembaikan Kenderaan</div>
    <div id="response" style="position: fixed;z-index: 2;" class="alert alert-spakat response-toast" role="alert"></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('access.operation.dashboard', ['dashboard_type' => 'maintenance']) }}">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                @if(auth()->user()->isForemenMaintenance())
                <a href="{{ route('access.operation.dashboard', ['dashboard_type' => 'maintenance']) }}">Dashboard</a>
                @else
                <a href="{{ route('maintenance.job.register', [
                    'id' => Request('maintenance_id'),
                    'tab' => 4
                ]) }}">Servis Dan Pembaikan Kenderaan</a>
                @endif
            </li>
            <li class="breadcrumb-item">Servis Dan Pembaikan Kenderaan</li>
            <li class="breadcrumb-item active" aria-current="page">{{$detail->hasVehicle->plate_no}}</li>
        </ol>
    </nav>
    @if(env('APP_ENV') == 'local')
        <textarea class="form-control" name="" id="" style="resize: none; height: 100px;">
            @json($detail)
            {{-- @json($repair_method_list->where('code','02')) --}}
            @if ($detail->hasRepairMethod())
                @json($detail->hasRepairMethod()->where('code', '02')->first())
            @endif
        </textarea>
    @endif
    @php
        $is_pemkem = false;

        if(auth()->user()->isForemenMaintenance()){
            $is_pemkem = true;
        }
    @endphp
    <div class="main-content">
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active"  onClick="goTab(this, 'inspect_vehicle');" id="tab1">Pemeriksaan</li>
                    
                    @if(!$is_pemkem)
                        <li class="cub-tab" style="display: {{in_array($MJobVehicleStatus->code, ['04','05','06','08','09','10','11','12']) && $detail->hasJVEForm && $detail->is_research_market == 1 ? '': 'none'}};" onClick="goTab(this, 'research_market');" id="tab2">Kajian Pasaran</li>
                        <li class="cub-tab" style="display:  {{in_array($MJobVehicleStatus->code, ['08','09','10','11','12']) && $detail->hasJVEForm && $detail->is_research_market == 1 ? '': 'none'}};" onClick="goTab(this, 'procurement');" id="tab3">Perolehan</li>
                    @endif
                    @if($showInternalForm || $showExternalForm)
                        <li class="cub-tab" style="display: {{in_array($MJobVehicleStatus->code, ['07','11','12']) && !$showInternalTestingForm && $showInternalForm ? '' : 'none'}};" onClick="goTab(this, 'maintenance');" id="tab4">Senggara (Secara Dalaman)</li>
                        <li class="cub-tab" style="display: {{in_array($MJobVehicleStatus->code, ['11','12']) && !$showExternalTestingForm && $showExternalForm ? '' : 'none'}};" onClick="goTab(this, 'monitoring');" id="tab5">Pemantauan (Secara Luaran)</li>
                    @elseif ($showInternalTestingForm || $showExternalTestingForm)
                        <li class="cub-tab" style="display: {{in_array($MJobVehicleStatus->code, ['11','12']) && $showInternalTestingForm && $isResearchMarket == 2 ? '' : 'none'}};" onClick="goTab(this, 'testing');" id="tab6">Pengujian (Secara Dalaman)</li>
                        <li class="cub-tab" style="display: {{in_array($MJobVehicleStatus->code, ['11','12']) && $showExternalTestingForm && $isResearchMarket == 2 ? '' : 'none'}};" onClick="goTab(this, 'external_testing');" id="tab7">Pengujian (Secara Luaran)</li>
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="inspect_vehicle" class="tab-content">
            @include('maintenance.job.examination.tab.inspect')
        </section>

        @if(!$is_pemkem)
            <section style="display: {{in_array($MJobVehicleStatus->code, ['04','05','06','08','09','10','11','12']) && $detail->is_research_market == 1? '': 'none'}};" id="research_market" class="tab-content">
                @include('maintenance.job.examination.tab.research-market')
            </section>
            <section style="display: {{in_array($MJobVehicleStatus->code, ['08','09','10','11','12']) && $detail->is_research_market == 1 ? '': 'none'}};" id="procurement" class="tab-content">
                @include('maintenance.job.examination.tab.procurement')
            </section>
        @endif

        <section style="display: {{in_array($MJobVehicleStatus->code, ['07','11','12']) && !$showInternalTestingForm && $showInternalForm ? '' : 'none'}};" id="maintenance" class="tab-content">
             @include('maintenance.job.examination.tab.maintenance')
        </section>
        <section style="display: {{in_array($MJobVehicleStatus->code, ['11','12']) && !$showExternalTestingForm  && $showExternalForm ? '' : 'none'}};" id="monitoring" class="tab-content">
             @include('maintenance.job.examination.tab.monitoring') 
        </section>


        <section style="display: {{in_array($MJobVehicleStatus->code, ['11','12']) && $showInternalTestingForm && $isResearchMarket == 2 ? '' : 'none'}};" id="testing" class="tab-content">
            @include('maintenance.job.examination.tab.testing') 
       </section>
       <section style="display: {{in_array($MJobVehicleStatus->code, ['11','12']) && $showExternalTestingForm && $isResearchMarket == 2 ? '' : 'none'}};" id="external_testing" class="tab-content">
        @include('maintenance.job.examination.tab.external-testing') 
   </section>
    </div>

    <div class="divider-line" style="padding-top: 100px;"></div>

    @include('components.modal-enlarge-image')

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        let save_as = "";

        function show(element){
            $(element).show();
        }


        function selectHash(self){
            $('.selected').removeClass('selected disabled');

            let hash = window.location.hash;
            $(self).addClass('selected disabled');
        }

        const checkIfAllChecked = function(){
            let totalCheckBox = $('.check_is_pass').length;
            let totalChecked = $('.check_is_pass:checked').length;
            console.log(totalCheckBox, totalChecked);
            if(totalCheckBox == totalChecked){
                $('#check_all_1').prop('checked', true);
            }
        }

        const goTabResearchMarket = function(){
            $('#frm_vehicle_inspect').submit();
            $('#tab2').trigger('click');
        }

        const submitExaminationForm = function(data){

            $('form').find('[type="submit"]').prop('disabled', true)

            let repair_method = $.map($('.repair_method:checked'), function(n, i){
                    return n.value;
                }).join(',');

                if(repair_method.length > 0){
                    data.append('repair_method', repair_method);
                }

                $('.hasErr').html('');

            $.ajax({
                url: '{{ route('maintenance.job.vehicle.maintenance.form.save') }}',
                type: 'post',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000, function(){
                        $('form').find('[type="submit"]').prop('disabled', false);
                    });

                    if(data.get('save_as') != 'draf'){
                        @if(auth()->user()->isForemenMaintenance())
                        window.location.href = "{{ route('access.operation.dashboard')}}";
                        @else
                        window.location.href = "{{ route('maintenance.job.register')}}?id={{Request('maintenance_id')}}&tab=4";
                        @endif
                    }
                },
                error: function(response) {
                    console.log(response);
                    var errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        $('#hasErr_'+key).html(value[0]);
                    });
                }
            });
        }

        reinitizeTabBaseOnStatus = function(){
            @if (in_array($MJobVehicleStatus->code, ['04','05','06']))
                $('#tab2').trigger('click');
                @elseif (in_array($MJobVehicleStatus->code, ['08','09','10']))
                $('#tab3').trigger('click');
            @endif
        }

        const checkAtleaseOneRepairMethod = function(form){
            form.find('.repair_method_err').html('');
            console.log('status => {{$MJobVehicleStatus->code}}');
            @if( 
                in_array($MJobVehicleStatus->code, ['03']) && auth()->user()->isAssistEngineerMaintenance()
                )
                let checkAtleaseOneRepairMethod = $('.repair_method:checked').length;
                if(checkAtleaseOneRepairMethod == 0){
                    form.find('.repair_method_err').html('<span class="text-danger">Sila Pilih Salah satu kaedah pembaikan</span>')
                    return false;
                } else {
                    return true;
                }
            @elseif(in_array($MJobVehicleStatus->code, ['01','02']) && auth()->user()->isForemenMaintenance())
                return true;
            @endif
        }

        const prompInspectVerification = function(){
            let form = $('#frm_vehicle_inspect');
            silentSave();
            if(checkAtleaseOneRepairMethod(form)){
                $('#prompInspectVerificationModal').modal('show');
            }
        }

        silentSave = function(self){

            let save_as = $(self).data('save-as');

            switch (save_as) {
                case 'inspect':
                    $('#frm_vehicle_inspect').submit();
                    break;
                case 'market':
                    $('#frm_vehicle_research_market').submit();
                    break;
                case 'procurement':
                    $('#frm_vehicle_procurement').submit();
                    break;
                case 'maintenance':
                    $('#frm_vehicle_maintenance').submit();
                    break;
                case 'monitoring':
                    $('#frm_vehicle_monitoring').submit();
                    break;
                case 'testing':
                    $('#frm_vehicle_testing').submit();
                break;
                case 'external_testing':
                    $('#frm_vehicle_external_testing').submit();
                break;
                default:
                    $('#frm_vehicle_inspect').submit();
                    break;
            }

        }

        $(document).ready(function(){

            reinitizeTabBaseOnStatus();

            $('#ref_info_id').select2({
                width: '100%',
                theme: 'classic',
                placeholder: 'Sila Pilih',
                dropdownParent: $('#addFormMonitoringInfoModal')
            });

            $('#frm_vehicle_inspect').on('submit', function(e){
                e.preventDefault();
                console.log('trigger save frm_vehicle_inspect');

                let form = $(this);
                if(checkAtleaseOneRepairMethod(form)){
                    let formData = new FormData(this);
                    formData.append('save_as','draf');
                    submitExaminationForm(formData, form);
                }
            });

            $('#frm_vehicle_research_market').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);

                formData.append('save_as','draf');
                formData.append('repair_method_id','{{$repair_method_id}}');

                submitExaminationForm(formData);
            });

            $('#frm_vehicle_procurement').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                let selectedSplComp = $('[name="pro_budget_price_supl_id"]:checked');
                let selectedSplCompPrice = selectedSplComp.next();

                formData.append('save_as','draf');
                formData.append('repair_method_id','{{$repair_method_id}}');
                formData.append('pro_budget_price', selectedSplCompPrice.val());

                submitExaminationForm(formData);
            });

            $('#frm_vehicle_maintenance').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('save_as','draf');
                formData.append('repair_method_id','{{$repair_method_id}}');

                let inspect_type = $.map($('.inspect_type:checked'), function(n, i){
                    return n.value;
                }).join(',');

                if(inspect_type.length > 0){
                    formData.append('inspect_type', inspect_type);
                }

                submitExaminationForm(formData);
            });

            $('#frm_vehicle_monitoring').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('save_as', 'draf');
                formData.append('repair_method_id','{{$repair_method_id}}');

                submitExaminationForm(formData);
            });

            $('#frm_vehicle_testing').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('save_as', 'draf');
                formData.append('repair_method_id', '{{$repair_method_id}}');
                
                submitExaminationForm(formData);
            })

            $('#frm_vehicle_external_testing').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('save_as', 'draf');
                formData.append('repair_method_id', '{{$repair_method_id}}');
                
                submitExaminationForm(formData);
            })

            $('[xaction="inspect"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_inspect');
                let formData = new FormData(form[0]);
                let save_as = $(this).attr('stage');
                formData.append('save_as', save_as);
                
                submitExaminationForm(formData);

                console.log('save_as', save_as);

                if(save_as !== 'inspect_verification'){
                    @if(in_array($MJobVehicleStatus->code, ['02']) && auth()->user()->isForemenMaintenance())
                        let checkAtleaseOneRepairMethod = $('.repair_method:checked').length;
                        if(checkAtleaseOneRepairMethod == 0){
                            form.find('.repair_method_err').html('<span class="text-danger">Sila Pilih Salah satu kaedah pembaikan</span>')
                            return false;
                        }
                    @endif
                }

                form.find('.repair_method_err').html('');

                switch (save_as) {
                    case 'inspect_research_market':
                    window.location.href = "{{ route('maintenance.job.register')}}?id={{Request('maintenance_id')}}&tab=4";
                        break;

                    case 'inspect_not_research_market':
                    window.location.href = "{{ route('maintenance.job.register')}}?id={{Request('maintenance_id')}}&tab=4";
                        break;

                    default:
                        window.location.href = "{{route('access.operation.dashboard')}}";
                        break;
                }

            });

            $('[xaction="procurement"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_procurement')[0];
                let formData = new FormData(form);
                let save_as = $(this).attr('stage');
                let selectedSplComp = $('[name="pro_budget_price_supl_id"]:checked');
                let selectedSplCompPrice = selectedSplComp.next();

                formData.append('save_as', save_as);
                formData.append('repair_method_id','{{$repair_method_id}}');
                formData.append('pro_budget_price', selectedSplCompPrice.val());

                submitExaminationForm(formData);
                window.location.href = "{{ route('maintenance.job.register')}}?id={{Request('maintenance_id')}}&tab=4";
            });

            $('[xaction="research_market"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_research_market')[0];
                let formData = new FormData(form);
                let save_as = $(this).attr('stage');
                formData.append('save_as', save_as);
                formData.append('repair_method_id','{{$repair_method_id}}');
                submitExaminationForm(formData);

                if(save_as){
                    window.location.href = "{{ route('maintenance.job.register')}}?id={{Request('maintenance_id')}}&tab=4";
                }
            });

            $('[xaction="maintenance"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_maintenance')[0];
                let formData = new FormData(form);
                let save_as = $(this).attr('stage');
                formData.append('save_as', save_as);
                formData.append('repair_method_id','{{$repair_method_id}}');

                let inspect_type = $.map($('.inspect_type:checked'), function(n, i){
                    return n.value;
                }).join(',');

                if(inspect_type.length > 0){
                    formData.append('inspect_type', inspect_type);
                }

                submitExaminationForm(formData);
            });

            $('[xaction="monitoring"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_monitoring')[0];
                let formData = new FormData(form);
                let save_as = $(this).attr('stage');
                formData.append('save_as', save_as);
                formData.append('repair_method_id','{{$repair_method_id}}');
                submitExaminationForm(formData);
            });

            $('[xaction="testing"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_testing')[0];
                let formData = new FormData(form);
                let save_as = $(this).attr('stage');
                formData.append('save_as', save_as);
                formData.append('repair_method_id','{{$repair_method_id}}');
                submitExaminationForm(formData);
            });

            $('[xaction="external_testing"]').on('click', function(e){
                e.preventDefault();
                let form = $('#frm_vehicle_external_testing')[0];
                let formData = new FormData(form);
                let save_as = $(this).attr('stage');
                formData.append('save_as', save_as);
                formData.append('repair_method_id','{{$repair_method_id}}');
                submitExaminationForm(formData);
            });

            


        })

    </script>


</body>

</html>
