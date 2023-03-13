@php
$title = 'Daftar Tempahan Kenderaan';
$subTitle = 'Pendaftaran Tempahan Kenderaan Ke Dalam Sistem SPAKAT';
@endphp

@if (request('booking_id') > 0)
    @php
        $title = 'Maklumat Tempahan Kenderaan';
        $subTitle = 'Maklumat Tempahan Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php

use App\Http\Controllers\Logistic\Booking\LogisticBookingDAO;

$tab = request('tab') ? request('tab') : '';
$LogisticBookingDAO = new LogisticBookingDAO();

$LogisticBookingDAO->read(request('booking_id'));
$detail = $LogisticBookingDAO->detail;
$is_display = $LogisticBookingDAO->is_display;

$TaskFlowAccessLogistic= auth()->user()->vehicleWorkFlow('04', '01');

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

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
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

        @media print {

            @page {
                size: 'A4' portrait; /* auto is default portrait; */
                margin: 5%;
            }

            .content {
                background-color: transparent;
            }

            .col-md-4 {
                width: 30%;
            }

            .col-md-6 {
                width: 50%;
            }

            .col-md-8 {
                width: 70%;
            }

            .noprintMe {
                display: none;
            }

            .imgQR-detail {
                text-align: center;
            }

            #imgQR {
                height: 150px;
                width: 150px;
            }

            .booking-detail {
                width: 100%;
                padding-left: 0px;
            }

            .booking-detail .col-md-4 {
                text-align: center;
                width: 100%;
            }
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

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function downloadFile(filePath, name){
            var link=document.createElement('a');
            link.href = filePath;
            link.download = name+'-'+filePath.lastIndexOf('/') + 1;
            link.click();
        }

        function printDiv(elementId)
        {
            $('#btn-print').hide();
            $('#full-content').hide();
            $('#printSlip').show();
            window.print();
            $('#printSlip').hide();
            $('#full-content').show();
            $('#btn-print').show();
        }

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div id="full-content">
        <div class="mytitle noprintMe">Rekod Tempahan</div>
        <nav aria-label="breadcrumb" class="noprintMe">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                        <i class="fal fa-home"></i></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('logistic.booking.list') }}">Senarai Tempahan</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Slip</li>
            </ol>
        </nav>
        <div class="main-content">
            <div class="quick-navigation noprintMe" data-fixed-after-touch="">
                <div class="wrapper" style="position: relative">
                    <ul id="tabActive">
                        <li class="cub-tab active" onClick="goTab(this, 'slip');" id="tab1">Slip</li>
                    </ul>
                    <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
                    <div class="float-end mt-2">
                        <span class="cux-btn small" id="btn-print" onclick="window.print()">Cetak</span>
                    </div>
                </div>
            </div>
            <section id="slip" class="tab-content">
                <div class="row">
                    <div class="col-md-2 imgQR-detail">
                        <img id="imgQR" src="{{'/'.$qrImgUrl}}" alt="" width="100%">
                    </div>
                    <div class="col-md-10 booking-detail">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <div class="text-uppercase">{{$detail->bookingBy->name}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Jawatan</label>
                                    <div class="text-uppercase">{{$detail->bookingBy->hasOwnRole($detail->bookingBy->id)->designation}}</div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Nama Pemandu</label>
                                    <div class="text-uppercase">{{$detail->hasDriver->name}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">No. Plat Kenderaan</label>
                                    <div class="text-uppercase">{{$detail->hasVehicle->no_pendaftaran}}</div>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Destinasi</label>
                                    <div class="text-uppercase">{{$detail->destination}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Tarikh Masa Pergi</label>
                                    <div class="text-uppercase">{{\Carbon\Carbon::parse($detail->start_datetime)->format('d/m/Y h:m:s A')}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        @foreach ($detail->hasManyAssignedVehicle as $vehicle)
                        <div class="divider-line mt-2"></div>
                        <div class="row">
                            <div class="col-md-8">
                                <fieldset>
                                    <legend>Maklumat Kenderaan</legend>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Pendaftaran</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle->no_pendaftaran}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Hak Milik</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasOwnerType ? $vehicle->hasAssignedVehicle->hasOwnerType->desc_bm : '-' }}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Lokasi Penempatan</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasPlacement() ? $vehicle->hasAssignedVehicle->hasPlacement()->desc : '-' }}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Negeri</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($vehicle->hasAssignedVehicle->hasState->desc) ? $vehicle->hasAssignedVehicle->hasState->desc : '-' }}</div>
                                    </div>

                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Cawangan / Bahagian</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($vehicle->hasAssignedVehicle->cawangan->name) ? $vehicle->hasAssignedVehicle->cawangan->name : '-' }}</div>
                                    </div>
                                    {{-- <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No JKR</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ isset($vehicle->hasAssignedVehicle['no_jkr']) ? $vehicle->hasAssignedVehicle['no_jkr'] : '-' }}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Status</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasVehicleStatus ? $vehicle->hasAssignedVehicle->hasVehicleStatus->desc:''}}</div>
                                    </div> --}}
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Kategori</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle->hasCategory() ? $vehicle->hasAssignedVehicle->hasCategory()->name:''}} > {{$vehicle->hasAssignedVehicle->hasSubCategory()? $vehicle->hasAssignedVehicle->hasSubCategory()->name:''}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Jenis</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{$vehicle->hasAssignedVehicle->hasSubCategoryType() ? $vehicle->hasAssignedVehicle->hasSubCategoryType()->name:''}}</div>
                                    </div>
                                    {{-- <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Loji</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['no_loji']) ? $vehicle->hasAssignedVehicle['no_loji'] : "-"}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Cukai Jalan</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['tarikh_cukai_jalan']) ? $vehicle->hasAssignedVehicle['tarikh_cukai_jalan'] : "-"}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Harga Perolehan</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['harga_perolehan']) ? $vehicle->hasAssignedVehicle['harga_perolehan'] : "-"}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Tarikh Pembelian</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['acqDt']) ? \Carbon\Carbon::parse($vehicle->hasAssignedVehicle['acqDt'])->format('d M Y') : "-"}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pemeriksaan Keselamatan</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{isset($vehicle->hasAssignedVehicle['tarikh_pemeriksaan_keselamatan']) ? $vehicle->hasAssignedVehicle['tarikh_pemeriksaan_keselamatan'] : "-"}}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pegawai Bertanggungjawab</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasAssignedVehicle && $vehicle->hasAssignedVehicle->hasPersonIncharge ? $vehicle->hasAssignedVehicle->hasPersonIncharge->name : '-' }}</div>
                                    </div> --}}
                                    @IF ($vehicle->hasDriver)
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">Pemandu</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->hasDriver ? $vehicle->hasDriver->name : '-' }}</div>
                                    </div>
                                    <div class="row box-info">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-6 rlabel">No Telefon Pemandu</div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-sm-6 col-6 mytext">{{ $vehicle->driver_phone_no ? $vehicle->driver_phone_no : '-' }}</div>
                                    </div>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset>
                                    <legend>Penumpang</legend>
                                    <ul class="ps-0" style="list-style-type:decimal">
                                        @foreach ($vehicle->hasManyPassenger as $passenger)
                                            <li class="mb-2 form-label">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Nama</label>
                                                        <div>{{$passenger->name}}</div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="" class="form-label">Telefon</label>
                                                        <div>{{$passenger->phone_no}}</div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </fieldset>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

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

                parent.stopLoading();
            })

        </script>
    </div>

</body>

</html>
