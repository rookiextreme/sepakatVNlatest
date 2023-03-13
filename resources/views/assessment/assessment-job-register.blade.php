@php
$title = 'Daftar Kenderaan';
$subTitle = 'Pendaftaran Kenderaan Ke Dalam Sistem SPAKAT';
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

if(Request('id') > 0){
    $title = 'Maklumat Kenderaan';
    $subTitle = 'Maklumat Kenderaan Sistem SPAKAT';
}

use App\Http\Controllers\Maintenance\MaintenanceJobDAO;

$MaintenanceJobDAO = new MaintenanceJobDAO();
$MaintenanceJobDAO->mount(Request());
$vehicleDetail = $MaintenanceJobDAO->vehicleDetail;
$detail = $MaintenanceJobDAO->detail;
$is_display = $MaintenanceJobDAO->is_display;
$maintenance_type_list = $MaintenanceJobDAO->maintenance_type_list;
$warran_type_list = $MaintenanceJobDAO->warran_type_list;
$osol_type_list = $MaintenanceJobDAO->osol_type_list;

$fleet_view = request('fleet_view') ? request('fleet_view') : 'department';

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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .table {
            width: 100%;
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
            border: transparent;
            background: #dbdcd8;
        }

        .bootstrap-datetimepicker-widget.dropdown-menu {
            display: block;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Start Vehicle Detail Style */

        .polaroid {
            background-color:#ffffff;
            padding:5px;
            max-width:200px;
            height:165px;
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
        }
        .polaroid .plet-no {
            font-family: mark-bold;
            font-size:16px;
            color:#272624;
            text-align: left;
            margin-left:5px;
            line-height: 35px;
        }
        .plate-highlight {
            font-family: avenir-bold;
            font-size:14px;
            color:#595959;
            text-transform: uppercase;
        }
        .box-left {
            margin-left:auto;
            margin-right:auto;
            margin-top:3px;
            max-width:180px;
            height:120px;
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
        }
        .box-right {
            float:left;
            width:80%;
            padding-top:5px;
            margin-left:20px;
        }

        .box-info .rlabel {
            float:left;
            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:12px;
            line-height: 30px;
            text-align: left;
            width:auto;
        }
        .box-info .mytext {
            float:right;
            font-family: mark;
            font-size:12px;
            width:auto;
            line-height: 30px;
            text-align: right;
        }
        .box-info {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            height:30px;
        }
        /* End Vehicle Detail */

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

            .polaroid {
                margin-left: 15px;
            }

            .box-info{
                padding-left:15px;
                padding-right:15px;
            }

        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
        }

    </style>
    <script>

        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var currentTab = 1;

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

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Penilaian</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">Penilaian</a></li>
            {{-- <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('maintenance.job.list') }}')">Penyengaraan</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
        </ol>
    </nav>
    <div class="main-content">
        @php
            $publicPath = "";
            if($vehicleDetail && $vehicleDetail->hashVehicleImagePrimary() && $vehicleDetail->hashVehicleImagePrimary()->doc_path_thumbnail){
                $publicPath = '/'.$vehicleDetail->hashVehicleImagePrimary()->doc_path_thumbnail.'/'.$vehicleDetail->hashVehicleImagePrimary()->doc_name;
            }
        @endphp

        <div class="row mb-2" id="vehicle_info">
            <div class="col-xl-2 col-lg-2 col-md-4 line-r">
                <div class="polaroid">
                    <div class="box-left" style="background-image: url({{$publicPath ?: asset('my-assets/fleet-img/no-image-min.png')}});">&nbsp;</div>
                    <div class="show-plet-no">{{$vehicleDetail->no_pendaftaran}}</div>
                </div>

            </div>
            <div class="col-xl-10 col-lg-10 col-md-8">
                <div class="row">
                    <div class="col-md-4">
                        <div class="box-info">
                            <div class="rlabel">No Pendaftaran</div>
                            <div class="mytext">{{$vehicleDetail->no_pendaftaran ?:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Tahun Dibeli</div>
                            <div class="mytext">{{$vehicleDetail->purchase_dt ?:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Tahun Dibuat</div>
                            <div class="mytext">{{$vehicleDetail->manufacture_year ?:'-'}}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="box-info">
                            <div class="rlabel">Kategori</div>
                            <div class="mytext text-uppercase">{{$vehicleDetail->hasCategory()->name}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Sub Kategori</div>
                            <div class="mytext text-uppercase">{{$vehicleDetail->hasSubCategory()->name}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Jenis</div>
                            <div class="mytext text-uppercase">{{$vehicleDetail->hasSubCategoryType()->name}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">No Enjin</div>
                            <div class="mytext">{{$vehicleDetail->no_engine ?: '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">No Chasis</div>
                            <div class="mytext">{{$vehicleDetail->no_chasis ?: '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Pembuat</div>
                            <div class="mytext">{{$vehicleDetail->hasBrand ?: '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Model</div>
                            <div class="mytext">{{$vehicleDetail->hasModel ?: '-'}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Penyenggaraan</li>
                    <li class="cub-tab" onClick="goTab(this, 'exam');" id="tab2">Pemeriksaan</li>
                    <li class="cub-tab" onClick="goTab(this, 'testing');" id="tab3">Pengujian</li>
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>

        <section id="detail" class="tab-content">
            @include('maintenance.tab.maintenance-job-detail')
        </section>

        <section id="exam" class="tab-content">
            @include('maintenance.tab.maintenance-job-exam')
        </section>

        <section id="testing" class="tab-content">
            @include('maintenance.tab.maintenance-job-testing')
        </section>

    <div class="modal fade" id="submitForAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitForAppointmentModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
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
                <span type="button" class="btn btn-module" xaction="appointment" >Hantar</button>
            </div>
        </div>
        </div>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">

        var paramTab = {{Request('tab')? Request('tab') : 1}};

        function backToList(){
            window.location = "{{route('maintenance.job.list')}}";
        }

        function getVehicle(content, self){

            if(content == 'next'){
                vehicleOffset = vehicleOffset + 1;
                callAjaxVehicle();
            } else if(content == 'prev'){
                if(vehicleOffset > 0){
                    vehicleOffset = vehicleOffset - 1;
                    callAjaxVehicle();
                }
            }
            else if(content == 'search'){
                console.log(content, self.value);
                if(self.value != ''){
                    $('#enter').show();
                } else {
                    $('#enter').hide();
                }
                vehicleSearch = self.value;
                if(event.key === 'Enter' || self.value == '') {
                    if(vehicleSearch.length > 0){
                        vehicleOffset = 0;
                    }
                    callAjaxVehicle();
                }
            } else {
                callAjaxVehicle();
            }
        }

        function callAjaxVehicle(){
            $.get("{{route('vehicle.saman.ajax.getVehicle')}}", {
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch
                }, function(data){
                    if(data.length > 0){
                        $('#pagination').show();
                    } else {
                        $('#pagination').hide();
                    }
                    $('#vehicleList').html(data);
            });

            $.get("{{route('vehicle.saman.ajax.getVehicle.total')}}", {
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch
                }, function(vehicle){
                    var totalCurrentPage = (vehicleOffset ? ((vehicleOffset+1)*vehicleLimit): vehicleLimit+1 );
                    if(vehicle.total  < totalCurrentPage){
                        totalCurrentPage = vehicle.total;
                    }

                    var totalFrom = vehicleLimit*vehicleOffset+1;
                    $('#vehicleTotal').text('Rekod '+ (vehicleOffset == 0 ? 1 : (vehicle.total > vehicleLimit ? (totalFrom) : vehicle.total) ) + ' - ' + ( totalCurrentPage ) + ' Daripada ' + vehicle.total);
                    if(vehicle.total == 0){
                        $('#vehicleTotal').text('Tiada Rekod');
                    }

                    $('#pagination .next').prop('disabled', false);
                    $('#pagination .prev').prop('disabled', false);

                    if(vehicleOffset == 0){
                        $('#pagination .prev').prop('disabled', true);
                    }

                    if(totalFrom == totalCurrentPage || vehicleOffset > 0 && (totalCurrentPage == vehicle.total)){
                        $('#pagination .next').prop('disabled', true);
                    }

                    if(totalCurrentPage <= vehicleLimit){
                        $('#pagination .next').prop('disabled', true);
                        $('#pagination .prev').prop('disabled', true);
                    }

            });
        }

        function selectVehicle(vehicle_id, vehicle_no){
            let targetVehicleInput = $('#vehicle_id');
            let targetVehicleDisplay = $('#vehicle_display');
            targetVehicleInput.val(vehicle_id);
            targetVehicleDisplay.val(vehicle_no);
            $('#VehicleSearchModal').modal('hide');
        }


        $(document).ready(function() {
            initTab();

            var hash = window.location.hash;

            switch (paramTab) {
                case 2:
                $('#tab2').click();
                    break;
                case 3:
                $('#tab3').click();
                    break;

                default:
                    break;
            }
            $('select').select2({
                width: '100%',
                theme: "classic"
            });

            $('[xaction="appointment"]').on('click', function(e){
                e.preventDefault();

                $('#submitForAppointmentModal .modal-body').text('Sila tunggu...');
                hide('#close_action_modal');
                hide('[xaction="appointment"]');

                $.post("{{route('maintenance.job.submitForAppointment')}}", {
                    '_token': '{{ csrf_token() }}'
                }, function(result){
                    if(result==1){
                        var message = 'Maklumat berjaya dihantar';
                        $('#submitForAppointmentModal .modal-body').text(message);
                        show('#back_to_list');
                    }
                });

            });

        });

    </script>
</body>

</html>
