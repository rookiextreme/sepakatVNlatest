@php
$title = 'Daftar Tempahan Kenderaan';
$subTitle = 'Pendaftaran Tempahan Kenderaan Ke Dalam Sistem SPAKAT';

$id = request('id') ? request('id') : (session()->get('booking_current_detail_id') ? session()->get('booking_current_detail_id') : 0);
@endphp

@if ($id > 0)
    @php
        $title = 'Maklumat Tempahan Kenderaan';
        $subTitle = 'Maklumat Tempahan Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php

use App\Http\Controllers\Logistic\Booking\LogisticBookingDAO;
use App\Models\RefOwner;
use App\Models\RefState;

$tab = request('tab') ? request('tab') : '';
$LogisticBookingDAO = new LogisticBookingDAO();

$LogisticBookingDAO->read($id);
$detail = $LogisticBookingDAO->detail;
$applicant = $LogisticBookingDAO->applicant;
$is_display = $LogisticBookingDAO->is_display;
$stay_status_list = $LogisticBookingDAO->stay_status_list;
$department_list = RefOwner::whereHas('hasOwnerType', function($q){
    $q->where('display_for', 'user_register');
})->get();
$state_list = RefState::all();

//Booking -> journey
$doc_path = $detail && $detail->hasWorkInsLetter ? $detail->hasWorkInsLetter->doc_path : '';
$doc_name = $detail && $detail->hasWorkInsLetter ? $detail->hasWorkInsLetter->doc_name : '';
$pathUrl = $detail && $detail->hasWorkInsLetter ? '/storage/'.$doc_path.$doc_name : '';

$TaskFlowAccessLogistic= auth()->user()->vehicleWorkFlow('04', '01');

//role 03 == jurutera
$allowUpdateVehicle = ['03'];

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


    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />

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

        .select2-container--open {
            z-index:1060;
        }

        .alert-spakat {
            position: fixed;
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

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Tempahan Kenderaan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('logistic.booking.list') }}">Senarai Tempahan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Borang Tempahan</li>
        </ol>
    </nav>
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <div class="main-content">
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Permohonan</li>
                    <li class="cub-tab" onClick="goTab(this, 'journey');" id="tab2">Perjalanan</li>
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="detail" class="tab-content">
            @include('logistic.tab.booking-detail')
        </section>
        <section id="journey" class="tab-content">
            @include('logistic.tab.booking-journey')
        </section>

        {{--<div class="modal fade" id="addVehicleTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVehicleTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                    <div class="small-title">Jenis Kenderaan
                        <div>Kriteria kenderaan yang diperlukan</div>
                    </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="frmAddVehicleType" action="">
                    <input type="hidden" id="section" name="section" value="add_vehicle_type">
                    @csrf
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-6">
                                <label for="" class="form-label">Jenis Kenderaan</label>
                                <input type="hidden" id="placement_id" name="placement_id" readonly>
                                <input type="hidden" id="vehicle_type_id" name="vehicle_type_id" readonly class="form-control cursor-pointer"
                                    value="@if (!empty($detail['vehicle_type_id'])) {{ $detail['vehicle_type_id'] }} @endif">
                                <div class="input-group" onclick="getVehicleByType()" aria-readonly="" data-bs-toggle="modal"
                                    data-bs-target="#VehicleByTypeSearchModal">
                                    @if($is_display)
                                        {{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}
                                    @else
                                    <input type="text" readonly disabled id="vehicle_type_display" class="form-control cursor-pointer" >
                                    <span class="input-group-text"><i class="fa fa-car fa-lg"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-3">
                                <label for="total_unit_need" class="form-label">Jumlah Unit</label>
                                <input type="number" class="form-control text-end" name="total_unit_need" style="width:70px;">
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-3">
                                <label for="total_passenger" class="form-label text-dark">Bilangan Penumpang</label>
                                <input type="number" class="form-control text-end" name="total_passenger" style="width:70px;">
                            </div>
                        </div>

                    </div>
                </form>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-module">Simpan</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    </div>
              </div>
            </div>
        </div>--}}
        <div class="modal fade" id="addVehicleTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVehicleTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                    <div class="small-title">Jenis Kenderaan
                        <div>Kriteria kenderaan yang diperlukan</div>
                    </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="frmAddVehicleType" action="">
                    <input type="hidden" id="section" name="section" value="add_vehicle_type">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-6">
                                <label for="" class="form-label">Jenis Kenderaan</label>
                                <input type="hidden" id="placement_id" name="placement_id" readonly>
                                <input type="hidden" id="branch_id" name="branch_id" readonly>
                                <input type="hidden" id="sub_category_id" name="sub_category_id" readonly class="form-control cursor-pointer"
                                    value="@if (!empty($detail['sub_category_id'])) {{ $detail['sub_category_id'] }} @endif">
                                <input type="hidden" id="vehicle_type_id" name="vehicle_type_id" readonly class="form-control cursor-pointer"
                                    value="@if (!empty($detail['vehicle_type_id'])) {{ $detail['vehicle_type_id'] }} @endif">
                                <div class="input-group" onclick="getVehicleByType()" aria-readonly="" data-bs-toggle="modal"
                                    data-bs-target="#VehicleByTypeSearchModal">
                                    @if($is_display)
                                        {{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}
                                    @else
                                    <input type="text" readonly disabled id="vehicle_type_display" class="form-control cursor-pointer" >
                                    <span class="input-group-text"><i class="fa fa-car fa-lg"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-3">
                                <label for="total_unit_need" class="form-label">Jumlah Unit</label>
                                <input type="number" class="form-control text-end" name="total_unit_need" style="width:70px;">
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-3">
                                <label for="total_passenger" class="form-label text-dark">Bilangan Penumpang</label>
                                <input type="number" class="form-control text-end" name="total_passenger" style="width:70px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-module">Simpan</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
              </div>
            </div>
        </div>

        <div class="modal fade" id="assignVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignVehicleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <div class="small-title">Pemilihan Kenderaan
                        <div>Sila pilih kenderaan yang dikehendaki</div>
                    </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="frmAssignVehicle" action="">
                    <input type="hidden" id="vehicle_type_id" name="vehicle_type_id" value="">
                    <input type="hidden" id="section" name="section" value="assign_vehicle">
                    <input type="hidden" id="fleet_table" name="fleet_table" value="@if (!empty($detail['fleet_table'])) {{ $detail['fleet_table'] }} @endif">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Pilih Kenderaan</label>
                                <input type="hidden" id="vehicle_id" name="vehicle_id" readonly class="form-control cursor-pointer"
                                    value="@if (!empty($detail['vehicle_id'])) {{ $detail['vehicle_id'] }} @endif">
                                <div class="input-group" onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                                    data-bs-target="#VehicleSearchModal">

                                    @if($is_display)
                                        {{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}
                                    @else
                                    <input type="text" readonly disabled id="vehicle_display" class="form-control cursor-pointer">
                                    <span class="input-group-text"><i class="fa fa-car fa-w-14"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div id="is-need-drive-container" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="form-label text-dark">Pemandu *</label>
                                        <x-modal-user isDisplay="{{$is_display}}" filterByRole="06" title="Pemandu" subTitle="Sila pilih atau buat carian" fieldName="driver_id" fieldValue="" dataName=""></x-modal-user>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="form-label text-dark">No Telefon Pemandu </label>
                                        <input type="text" name="driver_phone_no" id="driver_phone_no" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-secondary">Simpan</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
        </div>

        <div class="modal fade" id="VehicleSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">

                <div class="modal-body">
                  <h3 class="text-dark">Pilih Kenderaan</h3>
                  {{-- <p class="text-muted">Pilih Kenderaan</p> --}}
                  <hr>
                  <div class="row">
                    {{-- <div class="col-md-4">
                        <label for="" class="form-label">Negeri</label>
                        <select class="form-select" id="vehicle_state_id" onchange="getPlacement('vehicle', this.value);getVehicle('state_id', this);">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($state_list as $state)
                                <option  value="{{ $state->id }}">{{ $state->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label">Lokasi Penempatan</label>
                        <select class="form-select" id="vehicle_placement_list" onchange="getVehicle('placement_id', this);" >
                            <option selected value="">Sila Pilih</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Jenis Kenderaan</label>
                        <select class="form-select" id="vehicle_type_list">
                            <option selected value="">Sila Pilih</option>
                        </select>
                    </div> --}}
                    <div class="col-12">
                        <div class="btn-group">
                            <button data-bs-toggle="modal" data-bs-target="#addVehicleGrantModal" type="button" class="btn cux-btn small"><i class="fa fa-plus"></i> Kenderaan Konsesi</button>
                        </div>
                    </div>
                    <div class="col-12 input-group mt-2">
                        <input type="text" id="booking_v_search" onkeyup="getVehicle('search', this)" class="form-control" placeholder="Carian Kenderaan">
                        <span class="input-group-text" id="enter" style="display: none">Enter</span>
                    </div>
                    <div class="col-12" id="vehicleList">

                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="VehicleByTypeSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleByTypeSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                    <div class="small-title">Jenis Kenderaan
                        <div>Sila pilih jenis kenderaan yang diperlukan</div>
                    </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <label for="" class="form-label">Negeri</label>
                        <select class="form-select" id="state_id" onchange="getPlacement('vehicle_type', this.value);getVehicleByType('state_id', this);">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($state_list as $state)
                                <option  value="{{ $state->id }}">{{ $state->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <label for="" class="form-label">Lokasi Penempatan</label>
                        <select class="form-select" id="vehicle_type_placement_list" onchange="getVehicleByType('placement_id', this);" >
                            <option selected value="">Sila Pilih</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12">
                        <label for="" class="form-label">Cawangan / Bahagian</label>
                        <div class="input-group">
                            <select class="form-select" id="vehicle_type_branch_list" onchange="getVehicleByType('branch_id', this);" >
                                <option selected value="">Sila Pilih</option>
                                @foreach ($branches as $branch)
                                    <option  value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5 col-12">
                        <label for="" class="form-label">Carian</label>
                        <input type="text" onkeyup="getVehicleByType('search', this)" class="form-control" placeholder="cth: JAJ5672">
                        <span class="input-group-text" id="enter" style="display: none">Enter</span>
                    </div>
                    <div class="col-12" id="vehicleByTypeList">

                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-module" data-bs-dismiss="modal"><i class="fal fa-arrow-left icon-white"></i> Kembali</button>

                  </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="VehicleByTypeUnitSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleByTypeUnitSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="small-title">Senarai Kenderaan
                            <div>Anda boleh memilih kenderaan</div>
                        </div>
                        <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
                                <label for="" class="form-label">Carian</label>
                                <div class="input-group">
                                    <input type="text" id="searching" onkeyup="getVehicleByTypeUnit('search',this)" class="form-control" placeholder="Carian Kenderaan">
                                    <div style="height:40px;max-height:50xp;background-color:#ffffff;-webkit-border-radius: 0px 8px 8px 0px;-moz-border-radius: 0px 8px 8px 0px;border-radius: 0px 8px 8px 0px;">
                                        <span class="input-group-text" id='search-btn'><i class="fal fa-search fa-lg"></i></span>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                            <div class="col-12 p-4" id="vehicleByTypeUnitList">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-module" data-bs-toggle="modal" data-bs-target="#VehicleByTypeSearchModal" data-bs-dismiss="modal" data-bs-dismiss="#VehicleByTypeUnitSearchModal"><i class="fal fa-arrow-left icon-white"></i> Kembali</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addVehicleGrantModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVehicleGrantModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="small-title">Tambah Kenderaan Konsesi
                            <div></div>
                        </div>
                        <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        @include('vehicle.tab.grant-detail', 
                        [
                            'currentFleetTable' => 'grant',
                            'states' => \App\Models\RefState::all(),
                            'placement_list' => \App\Models\FleetPlacement::all(),
                            'detail' => null,
                            'fleet_view' => 'grant'
                        ])
                    </div>
                    <div class="modal-footer justify-content-start">
                        {{-- <button type="button" class="btn btn-module" data-bs-toggle="modal" data-bs-target="#VehicleByTypeSearchModal" data-bs-dismiss="modal" data-bs-dismiss="#VehicleByTypeUnitSearchModal"><i class="fal fa-arrow-left icon-white"></i> Kembali</button> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="vehiclePassengerListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="vehiclePassengerListModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">

              <div class="modal-content">
                <div class="modal-header">
                    <div class="small-title">Senarai Penumpang
                        <div>Senarai penumpang yang akan menggunakan kemudahan kenderaan yang dipilih</div>
                    </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="frmPassenger">
                    <input type="hidden" name="booking_vehicle_id" id="booking_vehicle_id">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                          {{-- <div class="col-12 input-group">
                              <input type="text" onkeyup="getVehicleByTypeWithPassenger('search',this)" class="form-control" placeholder="Carian Penumpang">
                              <span class="input-group-text" id="enter" style="display: none">Enter</span>
                          </div> --}}
                          <div class="col-12" id="vehicleByTypeWithPassengerList">

                          </div>
                        </div>

                      </div>
                      <div class="modal-footer justify-content-start">
                        <button class="btn btn-module" type="submit">Simpan</button>
                        {{--<button type="button" class="btn btn-link" onclick="loadBookingVehicle()">--}}
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
              </div>
            </div>
        </div>

        <div class="modal fade" id="uploadVehiclePassengerListModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="uploadVehiclePassengerListModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">

              <div class="modal-content">
                <div class="modal-header">
                    <div class="small-title">Muat Naik Senarai Penumpang
                        {{--  <div>Senarai penumpang yang akan menggunakan kemudahan kenderaan yang dipilih</div>  --}}
                    </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="frmUploadVPassengerDoc">
                    <input type="hidden" name="booking_vehicle_id" id="vuploadbooking_vehicle_id">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group" id="vehicle_passenger_doc_container">
                            <label for="" class="form-label">Muat Naik Senarai Penumpang</label>
                            <input type="file" class="d-none" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf" name="vehicle_passenger_doc" id="vehicle_passenger_doc">
                            <div class="col-md-3 mb-2">
                                <label for="vehicle_passenger_doc" type="button" class="btn cux-btn bigger">
                                    <i class="fa fa-upload"></i> Muat Naik</label>
                            </div>
                            <div id="preview-file" class="form-group" style="display: none;">
                                <iframe src="" id="preview-file-embed" width="100%" height="250px" type=""></iframe>
                            </div>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-start">
                        <button class="btn btn-module" type="submit">Simpan</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
              </div>
            </div>
        </div>

        <div class="modal fade" id="verifyBookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyBookingModalLabel" aria-hidden="true">
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
                    <span type="button" class="btn btn-primary" xaction="verify" >Hantar</button>
                </div>
            </div>
            </div>
        </div>

        @if (auth()->user()->isAdmin() || $TaskFlowAccessLogistic->mod_fleet_approval)
            <div class="modal fade" id="rejectBookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rejectBookingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="form-group fs-5 text-center">
                            Adakah anda ingin menolak tempahan <br/>maklumat ini?
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">
                                Nyatakan Sebab <em class="text-danger">*</em>
                            </label>
                            <textarea style="resize: none;" class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
                            <div class="hasErr text-danger" id="booking_note"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <span class="btn btn-module" xaction="reject" >Ya</span>
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-reset" xaction="no" data-bs-dismiss="modal">Tidak</span>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal fade" id="approvalBookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approvalBookingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        <div class="form-group fs-5 text-center">
                            Adakah anda ingin mengesahkan <br/>maklumat ini?
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <span class="btn btn-module" xaction="approve" >Ya</span>
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-reset" xaction="no" data-bs-dismiss="modal">Tidak</span>
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

        let selectedStateId = null;
        let selectedPlacementId = null;
        let selectedBranchId = null;

        let selectedAssignVehicleTypeId = null;
        let selectedAssignVehicleStateId = null;
        let selectedAssignVehiclePlacementId = null;

        let selectedBookingVehicleId = null;
        let vehicle_passenger_docCurrentPreviewFile = null;

        function getPlacement(content, reg_negeri){

            $('#'+content+'_placement_list').html('<option value="">Sila Pilih</option>');

            $.get("{{route('vehicle.ajax.getPlacement')}}", {
                reg_negeri: reg_negeri
            }, function(result){

                var count = result.length;
                var totalInit = 0;
                var same = false;

                result.forEach(element => {

                    $('#'+content+'_placement_list').append('<option value='+element.id+'>'+element.desc+'</option>');
                        if(divisionId == element.id){
                            same = true;
                        }
                        totalInit++;
                    });

            });
        }

        function checkNeedDriver(vehicleTypeDetailId){
            let is_need_driver_container = $('#is-need-drive-container');
            $.post("{{route('logistic.booking.vehicle.checkIsNeedDriver')}}", {
                id: vehicleTypeDetailId,
                '_token': "{{ csrf_token() }}"
            }, function(result){
                if(result.is_need_driver){
                    is_need_driver_container.show();
                } else {
                    is_need_driver_container.hide();
                }
            });
        }

        function selectVehicleTypeDetail(id, vehicle_type_id, state_id, placement_id, self){
            checkNeedDriver(id);

            selectedAssignVehicleTypeId = null;
            
            if(vehicle_type_id != -1){
                selectedAssignVehicleTypeId = vehicle_type_id;
            }
            
            selectedAssignVehicleStateId = state_id;
            selectedAssignVehiclePlacementId = placement_id;

            let fleetTable = $(self).data('fleet-table');
            let assignedVehicle = $(self).data('assigned-vehicle');
            let assignedDriver = $(self).data('assigned-driver');
            let assignedDriverPhoneNo = $(self).data('driver-phoneno');

            $('#fleet_table').val(fleetTable);
            $('#vehicle_id').val(assignedVehicle.id);
            $('#driver_id').val(assignedDriver.id);
            $('#driver_phone_no').val(assignedDriverPhoneNo);

            $('#user_display_driver_id').val(assignedDriver.name);
            $('#vehicle_display').val(assignedVehicle.no_pendaftaran);
            $('#assignVehicleModal #vehicle_type_id').val(id);
        }

        function getVehicle(content, self){
            if(content == 'state_id'){
                selectedAssignVehicleStateId = self.value;
            }

            if(content == 'placement_id'){
                selectedAssignVehiclePlacementId = self.value;
            }

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
            } else if(content == 'search_manual'){

                $('#booking_v_search').val(self);
                
                if(self != ''){
                    $('#enter').show();
                } else {
                    $('#enter').hide();
                }
                vehicleSearch = self;
                console.log('vehicleSearch ', vehicleSearch);
                if(event.key === 'Enter' || self != '') {
                    if(vehicleSearch.length > 0){
                        vehicleOffset = 0;
                    }
                    callAjaxVehicle();
                }
            } else {
                callAjaxVehicle();
            }
        }

        function getVehicleByType(content, self){

            if(content == 'state_id'){
                selectedStateId = self.value;
                selectedPlacementId = null;
                selectedBranchId = null;
                $('#vehicle_type_branch_list').val(selectedBranchId).trigger('change');
            }

            if(content == 'placement_id'){
                selectedPlacementId = self.value;
            }

            if(content == 'branch_id'){
                selectedBranchId = self.value;
            }

            if(content == 'next'){
                vehicleOffset = vehicleOffset + 1;
                callAjaxVehicleByType();
            } else if(content == 'prev'){
                if(vehicleOffset > 0){
                    vehicleOffset = vehicleOffset - 1;
                    callAjaxVehicleByType();
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
                    callAjaxVehicleByType();
                }
            } else {
                callAjaxVehicleByType();
            }
        }

        function getVehicleByTypeUnit(content, self){

            if(content=='vehicle_type_id'){
                $('#VehicleByTypeUnitSearchModal #searching')
                .attr('data-vehicle-category-id', $(self).data('vehicle-category-id'))
                .attr('data-vehicle-subcategory-id', $(self).data('vehicle-subcategory-id'))
                .attr('data-vehicle-type-id', $(self).data('vehicle-type-id'))
                .attr('data-state-id', $(self).data('state-id'))
                .attr('data-placement-id', $(self).data('placement-id'));
            }

            if(content == 'search'){
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
                    callAjaxVehicleByTypeUnit(self);
                }
            } else {
                callAjaxVehicleByTypeUnit(self);
            }
        }

        function getVehicleByTypeWithPassenger(content, self){

            if(content == 'booking_vehicle_id'){
                $('#booking_vehicle_id').val(self);
                selectedBookingVehicleId = self;
            }
            if(content == 'search'){
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
                    callAjaxVehicleByTypeWithPassenger(self);
                }
            } else {
                callAjaxVehicleByTypeWithPassenger(self);
            }
        }

        function selectVehicleByTypeWithPassenger(self){
            let booking_vehicle_id = $(self).data('id');
            let file = $(self).data('file');

            if(file){
                let filePath = '/'+file.doc_path+'/'+file.doc_name;

                $('#vehicle_passenger_doc_container #preview-file-embed').attr('src', filePath);
                $('#vehicle_passenger_doc_container [for="vehicle_passenger_doc"]').text('Tukar Fail');
                $('#vehicle_passenger_doc_container #preview-file').show();

            } else {
                $('#vehicle_passenger_doc_container #preview-file').hide();
            }

            $('#vuploadbooking_vehicle_id').val(booking_vehicle_id);
        }

        function callAjaxVehicle(){
            console.log('callAjaxVehicle :: vehicleSearch ', vehicleSearch);
            $.get("{{route('logistic.booking.ajax.getVehicle')}}", {
                    sub_category_type_id: selectedAssignVehicleTypeId,
                    state_id: selectedAssignVehicleStateId,
                    placement_id: selectedAssignVehiclePlacementId,
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch,
                }, function(data){
                    if(data.length > 0){
                        $('#pagination').show();
                    } else {
                        $('#pagination').hide();
                    }
                    $('#vehicleList').html(data);
            });
        }

        function callAjaxVehicleByType(){
            $.get("{{route('logistic.booking.ajax.getVehicleType')}}", {
                    state_id: selectedStateId,
                    placement_id: selectedPlacementId,
                    branch_id: selectedBranchId,
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch,
                }, function(data){
                    if(data.length > 0){
                        $('#pagination').show();
                    } else {
                        $('#pagination').hide();
                    }
                    $('#vehicleByTypeList').html(data);
            });
        }

        function callAjaxVehicleByTypeUnit(self){

            let selectedVehicleCategoryId = $(self).attr('data-vehicle-category-id');
            let selectedVehicleSubCategoryId = $(self).attr('data-vehicle-subcategory-id');
            let selectedVehicleTypeId = $(self).attr('data-vehicle-type-id');
            let stateId = $(self).attr('data-state-id');
            let placementId = $(self).attr('data-placement-id');

            let searchByVType = '{{Request('vehicle_type_id') ? 'true' : 'false'}}';
            console.log('searchByVType', searchByVType);

            $.get("{{route('logistic.booking.vehicle-type-unit.list')}}", {
                    state_id: stateId,
                    placement_id: placementId,
                    branch_id: selectedBranchId,
                    category_id: selectedVehicleCategoryId,
                    sub_category_id: selectedVehicleSubCategoryId,
                    vehicle_type_id: selectedVehicleTypeId,
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch,
                }, function(data){
                    $('#vehicleByTypeUnitList').html(data);
            });
        }

        function callAjaxVehicleByTypeWithPassenger(self){

            $.get("{{route('logistic.booking.vehicle-type-with-passenger.list')}}", {
                    booking_vehicle_id: selectedBookingVehicleId,
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch,
                }, function(data){
                    $('#vehicleByTypeWithPassengerList').html(data);
            });
        }

        function ajaxLoadVehiclePage(url){
            parent.startLoading();
            $.get(url, function(data){
                $('#vehicleList').html(data);
                parent.stopLoading();
            });
        }

        function ajaxLoadModalVehicleTypePage(url){
            parent.startLoading();
            $.get(url, {
                state_id: selectedStateId,
                placement_id: selectedPlacementId,
                branch_id: selectedBranchId
            }, function(data){
                $('#vehicleByTypeList').html(data);
                parent.stopLoading();
            });
        }

        function ajaxLoadModalVehicleTypeUnitPage(url){
            parent.startLoading();
            $.get(url, function(data){
                $('#vehicleByTypeUnitList').html(data);
                parent.stopLoading();
            });
        }

        function ajaxLoadModalVehicleTypeWithPassengerPage(url){
            parent.startLoading();
            $.get(url, {
                state_id: selectedStateId,
                placement_id: selectedPlacementId,
                branch_id: selectedBranchId
            }, function(data){
                $('#vehicleByTypeWithPassengerList').html(data);
                parent.stopLoading();
            });
        }

        function selectVehicle(self){
            let fleetTable = $(self).data('fleet-table');
            let vehicleId = $(self).data('vehicle-id');
            let vehiclePlateNo = $(self).data('vehicle-plate-no');
            // let hasDriver = $(self).data('hasdriver');
            // if(!hasDriver){
            //     $('#is-need-drive-container').show();
            // } else {
            //     $('#is-need-drive-container').hide();
            // }

            $('#fleet_table').val(fleetTable);
            $('#vehicle_id').val(vehicleId);
            $('#vehicle_display').val(vehiclePlateNo);

            $('#VehicleSearchModal').modal('hide');
        }

        function selectVehicleByType(self){

            let branchId = $(self).attr('data-vehicle-branch-id');
            let placementId = $(self).attr('data-vehicle-placement-id');
            let subCategoryId = $(self).attr('data-sub-category-id');
            let typeId = $(self).attr('data-vehicle-type-id');
            let typeName = $(self).attr('data-vehicle-type-name');

            $('#branch_id').val(branchId);
            $('#placement_id').val(placementId);
            $('#sub_category_id').val(subCategoryId);
            $('#vehicle_type_id').val(typeId);
            $('#vehicle_type_display').val(typeName);

            $('#VehicleByTypeSearchModal').modal('hide');
        }

        function submitAddVehicleType(data){
            $.ajax({
                url: "{{ route('logistic.booking.vehicle.save') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#addVehicleTypeModal').modal('hide');
                    loadBookingVehicle();
                },
                error: function(response) {
                    console.log(response);
                }
            });

        }

        function assignVehicle(data){
            $.ajax({
                url: "{{ route('logistic.booking.vehicle.assign') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#assignVehicleModal').modal('hide');
                    loadBookingVehicle();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function savePassengerInfo(data){
            $.ajax({
                url: "{{ route('logistic.booking.vehicle.passenger.save') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#vehiclePassengerListModal').modal('hide');
                    loadBookingVehicle();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function uploadVPassengerDoc(data){
            $.ajax({
                url: "{{ route('logistic.booking.vehicle.passenger.upload') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#uploadVehiclePassengerListModal').modal('hide');
                    loadBookingVehicle();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function submitDetailGrant(data) {

            $('.hasErr').remove();

            $.ajax({
                url: "{{ route('vehicle.register.save') }}",
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(response) {
                    getVehicle('search_manual', response.reg_no);
                    $('#frm_detail_grant')[0].reset();
                    $('#addVehicleGrantModal #state_id').select2('val', 0);
                    $('#addVehicleGrantModal #list_lokasi').select2('val', 0);
                    $('#addVehicleGrantModal').modal('hide');
                },
                error: function(response) {

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

        function backToList(){
            window.location = "{{route('logistic.booking.list')}}";
        }

        $(document).ready(function() {
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            let department = $('select#department_id');

            if(department.length == 1){
                $('#department_id').select2({
                    width: '100%',
                    theme: "classic"
                });
            }

            $('#state_id').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#VehicleByTypeSearchModal")
            });

            $('#vehicle_type_placement_list').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#VehicleByTypeSearchModal")
            });

            $('#vehicle_type_branch_list').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#VehicleByTypeSearchModal")
            });

            $('#assignVehicleModal #state_id').select2({
                width: '100%',
                theme: "classic"
            });

            $('#assignVehicleModal #placement_list').select2({
                width: '100%',
                theme: "classic"
            });

            $('[name="chkall"]').change(function() {

                $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
                $('.delete_all').prop('disabled', true);

                getCurrentChecked();
                if(ids.length > 0){
                    $('.delete_all').prop('disabled', false);
                }
            });

            $('#frmAddVehicleType').on('submit', function(e){

                e.preventDefault();
                let formData = new FormData(this);
                submitAddVehicleType(formData);

            });

            $('#frmAssignVehicle').on('submit', function(e){

                e.preventDefault();
                let formData = new FormData(this);
                assignVehicle(formData);

            });

            $('#frmPassenger').on('submit', function(e){

                e.preventDefault();
                let formData = new FormData(this);
                savePassengerInfo(formData);

            });

            $('#frmUploadVPassengerDoc').on('submit', function(e){

                e.preventDefault();
                let formData = new FormData(this);
                uploadVPassengerDoc(formData);

            });

            $('[xaction="verify"]').on('click', function(e){
                e.preventDefault();

                $('#verifyBookingModal .modal-body').text('Sila tunggu...');
                hide('[xaction="verify"]');
                hide('#close_action_modal');

                var ids = [];

                @if($detail)
                    ids.push({{$detail->id}});
                @endif

                $.post('{{route('logistic.booking.approval')}}', {
                    'ids': ids,
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#verifyBookingModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
                    show('#back_to_list');
                });

                $('#back_to_list').on('click', function(){
                    backToList();
                })
            });

            $('[xaction="reject"]').on('click', function(e){
                e.preventDefault();

                hide('[xaction="reject"]');
                hide('[xaction="no"]');

                var ids = [];

                @if($detail)
                    ids.push({{$detail->id}});
                @endif

                $('.hasErr').html('');

                let note = $('#rejectBookingModal #note').val();

                $.post('{{route('logistic.booking.reject')}}', {
                    'ids': ids,
                    '_token':'{{ csrf_token() }}',
                    'note': note
                }).done(function(res){
                    $('#rejectBookingModal .modal-body').text('Maklumat kenderaan berjaya ditolak');

                    hide('[xaction="reject"]');
                    hide('[xaction="no"]');
                    show('[xaction="close"]');
                 })
                .fail(function(xhr, status, error) {
                    show('[xaction="reject"]');
                    show('[xaction="no"]');
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.hasErr#booking_'+key).html(value[0]);
                    });
                });

                $('[xaction="close"]').on('click', function(){
                    backToList();
                })
            });

            $('[xaction="approve"]').on('click', function(e){
                e.preventDefault();

                hide('[xaction="approve"]');
                hide('[xaction="no"]');

                var ids = [];

                @if($detail)
                    ids.push({{$detail->id}});
                @endif

                $.post('{{route('logistic.booking.approve')}}', {
                    'ids': ids,
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#approvalBookingModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                    show('[xaction="close"]');
                });

                $('[xaction="close"]').on('click', function(){
                    backToList();
                })
            });

            $('#vehicle_passenger_doc').on('change', function(e){
                e.preventDefault();

                let url = URL.createObjectURL(e.target.files[0]);
                $('#vehicle_passenger_doc_container #preview-file-embed').attr('src', url);
                $('#vehicle_passenger_doc_container #preview-file').show();
                vehicle_passenger_docCurrentPreviewFile = url;
            });

            $('#frm_detail_grant').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();
                formData += "&_token={{ csrf_token() }}";
                formData += "&fleet_view=grant";
                formData += "&always_create=true";
                submitDetailGrant(formData);

            });

            parent.stopLoading();
        })

    </script>
</body>

</html>
