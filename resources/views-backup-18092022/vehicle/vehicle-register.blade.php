@php
$title = 'Daftar Kenderaan';
$subTitle = 'Pendaftaran Kenderaan Ke Dalam Sistem SPAKAT';
@endphp

@if (request('id') > 0)
    @php
        $title = 'Maklumat Kenderaan';
        $subTitle = 'Maklumat Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php
use App\Http\Controllers\Vehicle\VehicleRegister;

$VehicleRegisterDAO = new VehicleRegister();
$VehicleRegisterDAO->mount(request());

$currentFleetTable = $VehicleRegisterDAO->currentFleetTable;
$fleet_view = request('fleet_view') ? request('fleet_view') : 'department';
$tab = request('tab') ? request('tab') : '';
$offset = Request('offset') ?  Request('offset') : 0;
$search = Request('search') ?  Request('search') : null;

$is_display = $VehicleRegisterDAO->is_display;

$detail = $VehicleRegisterDAO->detail;

$owner_type_list = $VehicleRegisterDAO->owner_type_list;
$states = $VehicleRegisterDAO->states;
$cawangan = $VehicleRegisterDAO->cawangan;
$placement_list = $VehicleRegisterDAO->placement_list;

$categoryList = $VehicleRegisterDAO->categoryList;
$brands = $VehicleRegisterDAO->brands;
$models = $VehicleRegisterDAO->models;

$vehicleStatusList = $VehicleRegisterDAO->vehicleStatusList;

$TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');

$params = [
    'offset' => $offset, 
    'limit' => 10,
    'search' => $search
];

if(Session('session_v_list_owner_id') > 0){
    $params['owner_id'] = Session('session_v_list_owner_id');
}

if(Session('session_v_list_state_id') > 0){
    $params['state_id'] = Session('session_v_list_state_id');
}

if(Session('session_v_list_type_id') > 0){
    $params['type_id'] = Session('session_v_list_type_id');
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
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>


    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
    <script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

    <style type="text/css">

        .fancybox__content{
            height: 100vh !important;
        }
        body {
            background-color: #f4f5f2;
        }
        .modal .modal-dialog .modal-content {
            background-color: #f4f5f2;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 8px;
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
        .modal-header {
            font-family: lato-bold;
            font-size:16px;
            color:#303030;
            letter-spacing: -1px;
            line-height: 14px;
        }
        .cux-box {
            min-width: 400px;
            min-height: 300px;
            width: 60%;
            height: 50%;
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

        .hasErr {
            font-size: 14px !important;
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
    <script>

    function hide(element){
        $(element).hide();
    }

    function show(element){
        $(element).show();
    }

    function block(element){
        $(element).prop('disabled', true);
    }

    function release(element){
        $(element).prop('disabled', false);
    }

    function alphanumeric()
    {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        return regex;
    }

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Rekod Kenderaan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle.list-alternate', $params) }}">Senarai</a></li>
            <li class="breadcrumb-item active" aria-current="page">Borang</li>
        </ol>
    </nav>
    <div class="main-content">
        @if($detail)
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Kenderaan</li>
                    @if($detail)
                        <li class="cub-tab" {{$detail ? '': 'disabled'}} onClick="goTab(this, 'info');" id="tab2">Spesifikasi</li>
                        @if($currentFleetTable == 'department')
                            <li class="cub-tab" {{$detail ? '': 'disabled'}} onClick="goTab(this, 'addon');" id="tab3">Perolehan</li>
                        @endif
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        @endif
        <section id="detail" class="tab-content">
            @include('vehicle.tab.detail')
        </section>
        <section id="info" class="tab-content">
            @if($detail)
                @include('vehicle.tab.info')
            @endif
        </section>
        @if($currentFleetTable == 'department')
            <section id="addon" class="tab-content">
                @if($detail)
                    @include('vehicle.tab.addon')
                @endif
            </section>
        @endif

        <div class="modal fade" id="submitVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitVerificationModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    Anda pasti untuk menghantar ? tekan butang hantar untuk teruskan
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close_action_modal" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-secondary" id="back_to_list" onclick="backToList()" style="display: none;" data-bs-dismiss="modal">Tutup</button>
                    <span type="button" class="btn btn-primary" xaction="verification" id="hantarBtn">Hantar</button>
                </div>
            </div>
            </div>
        </div>
        @if ($TaskFlowAccessVehicle->mod_fleet_verify)
            <div class="modal fade" id="verifyVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyVehicleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        Adakah anda sudah menyemak maklumat pendaftaran ini ?
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                        <span class="btn btn-danger" xaction="verify" >Ya</span>
                    </div>
                </div>
                </div>
            </div>
        @endif

        @if ($TaskFlowAccessVehicle->mod_fleet_approval)
            <div class="modal fade" id="approvalVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approvalVehicleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        Adakah anda ingin mengesahkan maklumat ini?
                    </div>
                    <div class="modal-footer">
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                        <span class="btn btn-danger" xaction="approve" >Ya</span>
                    </div>
                </div>
                </div>
            </div>
        @endif

    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">

        function backToList(){
            window.location = "{{route('vehicle.list-alternate')}}";
        }

        $(document).ready(function() {
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic",
                placeholder: "[Sila pilih]"
            });

            parent.stopLoading();

            $('[xaction="verification"]').on('click', function(e){
                e.preventDefault();

                $('#submitVerificationModal .modal-body').text('Sila tunggu...');
                hide('#close_action_modal');
                hide('[xaction="verification"]');

                $.post("{{route('vehicle.verification')}}", {
                    'fleet_view': '{{$fleet_view}}',
                    '_token': '{{ csrf_token() }}'
                }, function(result){
                    if(result==1){
                        var message = 'Maklumat berjaya dihantar';
                        $('#submitVerificationModal .modal-body').text(message);
                        show('#back_to_list');
                    }
                });

            });

            $('[xaction="verify"]').on('click', function(e){
                e.preventDefault();

                $('#verifyVehicleModal .modal-body').text('Sila tunggu...');
                hide('[xaction="verify"]');
                hide('[xaction="no"]');

                var vehicle_ids = [];

                @if($detail)
                    vehicle_ids.push({{$detail->id}});
                @endif

                $.post('{{route('vehicle.approval')}}', {
                    'fleet_view': '{{$fleet_view}}',
                    'vehicle_ids': vehicle_ids,
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#verifyVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
                    show('[xaction="close"]');
                });

                $('[xaction="close"]').on('click', function(){
                    backToList();
                })
            });

            $('[xaction="approve"]').on('click', function(e){
                e.preventDefault();

                hide('[xaction="approve"]');
                hide('[xaction="no"]');

                var vehicle_ids = [];

                @if($detail)
                    vehicle_ids.push({{$detail->id}});
                @endif

                $.post('{{route('vehicle.approve')}}', {
                    'fleet_view': '{{$fleet_view}}',
                    'vehicle_ids': vehicle_ids,
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#approvalVehicleModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                    show('[xaction="close"]');
                });

                $('[xaction="close"]').on('click', function(){
                    backToList();
                })
            });

        })

    </script>
</body>

</html>
