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

$is_display = $VehicleRegisterDAO->is_display;

$detail = $VehicleRegisterDAO->detail;

$owner_type_list = $VehicleRegisterDAO->owner_type_list;
$states = $VehicleRegisterDAO->states;
$cawangan = $VehicleRegisterDAO->cawangan;
$placement_list = $VehicleRegisterDAO->placement_list;

$categoryList = $VehicleRegisterDAO->categoryList;
$brands = $VehicleRegisterDAO->brands;
$models = $VehicleRegisterDAO->models;

$TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');

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
        .rlabel {
            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:14px;
            line-height: 36px;
            text-align: left;
        }
        .revent {
            font-family:mark;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:darkslategray;
            font-size:14px;
            line-height: 36px;
            text-align: left;
        }

        .mytext {
            font-family: mark;
            font-size:16px;
            line-height: 34px;
            text-align: left;
            color:darkslategray;
            text-transform: uppercase;
        }
        .box-info {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            height:36px;
        }
        .box-info:hover {
            background-color:#ebede6;
        }
        .box-underline {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            height:36px;
        }
        #vehicle_info {
            max-width: 800px;
        }
        .polaroid {
            background-color:#ffffff;
            padding:0px;
            width:240px;
            text-align: center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            border-style: solid;
            border-color:#c8c8cc;
            border-width:1px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            transition: all .2s ease-in-out;
            margin-bottom:20px;
            padding-top:0px;
        }
        .preview-image {
            width:100%;
        }
        .polaroid .plet-no {
            font-family: mark-bold;
            font-size:16px;
            color:#272624;
            text-align: left;
            margin-left:8px;
            line-height: 25px;
            margin-top:-5px;
            margin-bottom:5px;
        }
        .box-left {
            margin-left:auto;
            margin-right:auto;
            margin-top:3px;
            width:100%;
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            padding:10px;
        }
        .modal-header {
            font-family: lato-bold;
            color:#303030;
            letter-spacing: -1px;
            font-size: 18px;
            line-height: 18px;
        }
        .plate-highlight {
            font-family: avenir-bold;
            font-size:14px;
            color:#595959;
            text-transform: uppercase;
        }
        .bulat {
            float:left;
            border-radius:20px;
            border-width: 2px;
            border-color:grey;
            border-style:solid;
            width:25px;
            height:25px;
            background-color:#ffffff;
            margin-top:5px;
        }
        .peristiwa {
            float:left;
            width:auto;

            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:14px;
            line-height: 36px;
            text-align: left;
            padding-left:10px;
        }
        .gap-row {
            height:30px;
        }
        .gap-line {
            width:2px;
            height:28px;
            background-color:grey;
            margin-left:12px;
        }
        .modalDialog {
    position: fixed;
    font-family: Arial, Helvetica, sans-serif;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.8);
    z-index: 99999;
    opacity:0;
    -webkit-transition: opacity 400ms ease-in;
    -moz-transition: opacity 400ms ease-in;
    transition: opacity 400ms ease-in;
    pointer-events: none;
}
.modalDialog:target {
    opacity:1;
    pointer-events: auto;
}
.modalDialog > div {
    width: 400px;
    position: relative;
    margin: 10% auto;
    padding: 5px 20px 13px 20px;
    border-radius: 10px;
    background: #fff;
    background: -moz-linear-gradient(#fff, #999);
    background: -webkit-linear-gradient(#fff, #999);
    background: -o-linear-gradient(#fff, #999);
}
.close {
    background: #606061;
    color: #FFFFFF;
    line-height: 25px;
    position: absolute;
    right: -12px;
    text-align: center;
    top: -10px;
    width: 24px;
    text-decoration: none;
    font-weight: bold;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    border-radius: 12px;
    -moz-box-shadow: 1px 1px 3px #000;
    -webkit-box-shadow: 1px 1px 3px #000;
    box-shadow: 1px 1px 3px #000;
}
.close:hover {
    background: #00d9ff;
}
.getAssignment{
  cursor:pointer;
}

        @media print {
            @page {
                size: 'A4' portrait; /* auto is default portrait; */
            }

            .no-printme  {
                display: none;
            }
            .printme  {
                display: block;
            }
            .body,.content {
                background: transparent;
            }
            .box-info {
                border: none;
                height: 30px;
            }

            .rlabel, .mytext {
                line-height: unset;
            }

            * {
                -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
                color-adjust: exact !important;                 /*Firefox*/
            }
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
    <span class="no-printme">
        <div class="mytitle">Maklumat Kenderaan <span>{{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '-' }}</span></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
                @if(Request('src') != '')
                    @if(Request('src') == 'disaster')
                    <li class="breadcrumb-item"><a href="{{ route('logistic.disasterready.vehicle.list') }}">Kenderaan Siap Siaga</a></li>
                    @elseif(Request('src') == 'report')
                    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.report')}}');">Laporan &amp; Statistik</a></li>
                    @elseif(Request('src') == 'map')
                    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.report')}}');">Laporan &amp; Statistik</a></li>
                    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('report.report_map_peninsular')}}?negeri={{Request('state')}}');">Taburan Kenderaan Mengikut Negeri</a></li>
                    @endif
                @else
                <li class="breadcrumb-item"><a href="{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 5]) }}">Senarai</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '-' }}</li>
            </ol>
        </nav>
    </span>

    <div class="main-content">
        {{-- @if($detail)
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
        @endif --}}
        {{-- <section id="detail" class="tab-content"> --}}
            @include('vehicle.onepagedetail.detail')
        {{-- </section> --}}
        {{-- <section id="info" class="tab-content"> --}}
            {{-- @if($detail) --}}
                {{--@include('vehicle.onepagedetail.info')--}}
            {{-- @endif --}}
        {{-- </section> --}}
        {{--@if($currentFleetTable == 'department') --}}
            {{-- <section id="addon" class="tab-content"> --}}
                {{-- @if($detail) --}}
                    {{-- @include('vehicle.onepagedetail.addon') --}}
                {{-- @endif --}}
            {{-- </section> --}}
        {{--@endif--}}

        <div class="modal fade" id="submitVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitVerificationModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    Anda pasti untuk menghantar ? tekan butang hantar untuk teruskan
                </div>
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" id="close_action_modal" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-secondary" id="back_to_list" onclick="backToList()" style="display: none;" data-bs-dismiss="modal">Tutup</button>
                    <span type="button" class="btn btn-module" xaction="verification" id="hantarBtn">Hantar</button>
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
                    <div class="modal-footer float-start">
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
                    <div class="modal-footer float-start">
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
                theme: "classic"
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
