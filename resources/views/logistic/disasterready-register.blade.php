@php
$title = 'Daftar Tempahan Kenderaan';
$subTitle = 'Pendaftaran Tempahan Kenderaan Ke Dalam Sistem SPAKAT';

$id = request('id') ? request('id') : (session()->get('disasterready_current_detail_id') ? session()->get('disasterready_current_detail_id') : 0);
@endphp

@if ($id > 0)
    @php
        $title = 'Maklumat Tempahan Kenderaan';
        $subTitle = 'Maklumat Tempahan Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php

use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
use App\Models\RefOwner;
use App\Models\RefAgency;
use App\Models\RefState;

$tab = request('tab') ? request('tab') : '';
$DisasterReadyDAO = new DisasterReadyDAO();

$DisasterReadyDAO->read($id);
$detail = $DisasterReadyDAO->detail;
$is_display = $DisasterReadyDAO->is_display;

$TaskFlowAccessLogistic= auth()->user()->vehicleWorkFlow('04', '01');
$department_list = RefOwner::all();
$agency_list = RefAgency::all();
$state_list = RefState::all();
$stay_status_list = $DisasterReadyDAO->stay_status_list;

$doc_path = $detail && $detail->hasWorkInsLetter ? $detail->hasWorkInsLetter->doc_path : '';
$doc_name = $detail && $detail->hasWorkInsLetter ? $detail->hasWorkInsLetter->doc_name : '';
$pathUrl = $detail && $detail->hasWorkInsLetter ? '/storage/'.$doc_path.$doc_name : '';

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

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">

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
    <div class="mytitle">Siap Siaga Bencana <span>Tempahan</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('logistic.disasterready.list') }}">Senarai Tempahan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Maklumat</li>
        </ol>
    </nav>
    <div class="main-content">
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Permohonan</li>
                    {{-- @if(in_array(auth()->user()->roles()->first()->name, $allowUpdateVehicle)) --}}
                    @if($detail)
                    <li class="cub-tab"  onClick="goTab(this, 'info');" id="tab2">Perjalanan</li>
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>
        <section id="detail" class="tab-content">
            @include('logistic.tab.disasterready-detail')
        </section>
        {{-- @if(in_array(auth()->user()->roles()->first()->name, $allowUpdateVehicle)) --}}
        @if($detail)
        <section id="info" class="tab-content">
                @include('logistic.tab.disasterready-course')
        </section>
        @endif

        <div class="modal fade" id="addVehicleTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addVehicleTypeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                  <div class="modal-header">
                    <div class="small-title">Jenis Kenderaan
                        <div>Pilih kriteria kenderaan yang diperlukan</div>
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
                                    <input type="text" readonly disabled id="vehicle_type_display" class="form-control cursor-pointer">
                                    <span class="input-group-text"><i class="fa fa-car"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-3">
                                <label for="total_unit_need" class="form-label">Jumlah Unit</label>
                                <input type="text" class="form-control" name="total_unit_need">
                                <div class="hasErr text-danger" id="total_unit_need"></div>
                            </div>
                            {{-- <div class="col-md-6">
                                <label for="">Bilangan Penumpang</label>
                                <input type="text" class="form-control" name="total_passenger">
                            </div> --}}
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
            <div class="modal-dialog modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                    <div class="small-title">Pilih Kenderaan
                        <div>Pilih kenderaan yang dikehendaki</div>
                    </div>
                <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="frmAssignVehicle" action="">
                    <input type="hidden" id="vehicle_type_id" name="vehicle_type_id" value="">
                    <input type="hidden" id="section" name="section" value="assign_vehicle">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-12">
                                <label for="" class="form-label text-dark">Pilih Kenderaan</label>
                                <input type="hidden" id="vehicle_id" name="vehicle_id" readonly class="form-control cursor-pointer"
                                    value="@if (!empty($detail['vehicle_id'])) {{ $detail['vehicle_id'] }} @endif">
                                <div class="input-group" onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                                    data-bs-target="#VehicleSearchModal">

                                    @if($is_display)
                                        {{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}
                                    @else
                                    <input type="text" readonly disabled id="vehicle_display" class="form-control cursor-pointer">
                                    <span class="input-group-text"><i class="fa fa-car"></i></span>
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

                    </div>
                    <div class="modal-footer justify-content-start">
                        <button type="submit" class="btn btn-module">Simpan</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>

                    </div>
                </form>
              </div>
            </div>
        </div>

        <div class="modal fade" id="VehicleSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="small-title">Pilih Kenderaan
                            <div>Pilih kenderaan siap siaga yang diperlukan</div>
                        </div>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                        <label for="" class="form-label">Negeri</label>
                        <select class="form-select" id="vehicle_state_id" onchange="getPlacement('vehicle', this.value);getVehicle('state_id', this);">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($state_list as $state)
                                <option  value="{{ $state->id }}">{{ $state->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                        <label for="" class="form-label">Lokasi Penempatan</label>
                        <select class="form-select" id="vehicle_placement_list" onchange="getVehicle('placement_id', this);" >
                            <option selected value="">Sila Pilih</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                        <label for="" class="form-label">Jenis Kenderaan</label>
                        <select class="form-select" id="vehicle_type_list">
                            <option selected value="">Sila Pilih</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                        <label for="" class="form-label">Carian</label>
                        <input type="text" onkeyup="getVehicle('search', this)" class="form-control" placeholder="cth: JAJ5672">
                        <span class="input-group-text" id="enter" style="display: none">Enter</span>
                    </div>
                    <div class="col-12" id="vehicleList">

                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal"><i class="fal fa-arrow-left"></i> Kembali</button>
                  </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="VehicleByTypeSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleByTypeSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="small-title">Pilih Kenderaan
                            <div>Pilih kenderaan yang dikehendaki</div>
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
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
                        <label for="" class="form-label">Lokasi Penempatan</label>
                        <select class="form-select" id="vehicle_type_placement_list" onchange="getVehicleByType('placement_id', this);" >
                            <option selected value="">Sila Pilih</option>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                        <label for="" class="form-label">Carian</label>
                        <input type="text" onkeyup="getVehicleByType('search', this)" class="form-control" placeholder="cth: JAJ5672">
                        <span class="input-group-text" id="enter" style="display: none">Enter</span>
                    </div>
                    <div class="col-12" id="vehicleByTypeList">

                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal"><i class="fal fa-arrow-left"></i> Kembali</button>
                  </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="VehicleByTypeUnitSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleByTypeUnitSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">

                <div class="modal-body">
                  <h3 class="text-dark">Senarai Kenderaan</h3>
                  <div class="row">
                    <div class="col-12 input-group">
                        <input type="text" id="searching" onkeyup="getVehicleByTypeUnit('search',this)" class="form-control" placeholder="Carian Kenderaan">
                        <span class="input-group-text" id="enter" style="display: none">Enter</span>
                    </div>
                    <div class="col-12" id="vehicleByTypeUnitList">

                    </div>
                  </div>
                </div>
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#VehicleByTypeSearchModal" data-bs-dismiss="modal" data-bs-dismiss="#VehicleByTypeUnitSearchModal">Tutup</button>
                  </div>
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
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" id="close_action_modal" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-secondary" id="back_to_list" onclick="backToList()" style="display: none;" data-bs-dismiss="modal">Tutup</button>
                    <span type="button" class="btn btn-module" xaction="verify" >Hantar</button>
                </div>
            </div>
            </div>
        </div>

        @if ($TaskFlowAccessLogistic->mod_fleet_approval)
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
                            <div class="hasErr text-danger" id="disasterready_note"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <span class="btn btn-danger" xaction="reject" >Ya</span>
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
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
                        Adakah anda ingin mengesahkan maklumat ini?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <span class="btn btn-danger" xaction="approve" >Ya</span>
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
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

        let selectedAssignVehicleStateId = null;
        let selectedAssignVehiclePlacementId = null;

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
            } else {
                callAjaxVehicle();
            }
        }

        function getVehicleByType(content, self){

            if(content == 'state_id'){
                selectedStateId = self.value;
            }

            if(content == 'placement_id'){
                selectedPlacementId = self.value;
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

        function callAjaxVehicleByTypeUnit(self){

            let selectedVehicleTypeId = $(self).attr('data-vehicle-type-id');
            let stateId = $(self).attr('data-state-id');
            let placementId = $(self).attr('data-placement-id');

            let searchByVType = '{{Request('vehicle_type_id') ? 'true' : 'false'}}';
            console.log('searchByVType', searchByVType);

            $.get("{{route('logistic.disasterready.vehicle-type-unit.list')}}", {
                    state_id: stateId,
                    placement_id: placementId,
                    vehicle_type_id: selectedVehicleTypeId,
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch,
                }, function(data){
                    $('#vehicleByTypeUnitList').html(data);
            });
        }

        function callAjaxVehicle(){
            $.get("{{route('logistic.disasterready.ajax.getVehicle')}}", {
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
            $.get("{{route('logistic.disasterready.ajax.getVehicleType')}}", {
                    state_id: selectedStateId,
                    placement_id: selectedPlacementId,
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

        function ajaxLoadVehiclePage(url){
            parent.startLoading();
            $.get(url, {
                state_id: selectedStateId,
                placement_id: selectedPlacementId
            }, function(data){
                $('#vehicleList').html(data);
                parent.stopLoading();
            });
        }

        function ajaxLoadModalVehicleTypePage(url){
            parent.startLoading();
            $.get(url, {
                state_id: selectedStateId,
                placement_id: selectedPlacementId
            }, function(data){
                $('#vehicleByTypeList').html(data);
                parent.stopLoading();
            });
        }

        function selectVehicle(self){
            let vehicleId = $(self).attr('data-vehicle-id');
            let vehiclePlateNo = $(self).attr('data-vehicle-plate-no');
            // let hasDriver = $(self).data('hasdriver');
            // if(!hasDriver){
            //     $('#is-need-drive-container').show();
            // } else {
            //     $('#is-need-drive-container').hide();
            // }

            $('#vehicle_id').val(vehicleId);
            $('#vehicle_display').val(vehiclePlateNo);

            $('#VehicleSearchModal').modal('hide');
        }

        function selectVehicleByType(self){

            let placementId = $(self).attr('data-vehicle-placement-id');
            let typeId = $(self).attr('data-vehicle-type-id');
            let typeName = $(self).attr('data-vehicle-type-name');

            $('#placement_id').val(placementId);
            $('#vehicle_type_id').val(typeId);
            $('#vehicle_type_display').val(typeName);

            $('#VehicleByTypeSearchModal').modal('hide');
        }

        function submitAddVehicleType(data){

            $('.hasErr').html('');

            $.ajax({
                url: "{{ route('logistic.disasterready.vehicle.save') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#addVehicleTypeModal').modal('hide');
                    loadDisasterreadyVehicle();
                },
                error: function(response) {

                    var errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            if($('[name="'+key+'"]').find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });
                }
            });

        }

        function assignVehicle(data){
            $.ajax({
                url: "{{ route('logistic.disasterready.vehicle.assign') }}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    $('#assignVehicleModal').modal('hide');
                    loadDisasterreadyVehicle();
                },
                error: function(response) {
                    console.log(response);
                }
            });
        }

        function backToList(){
            window.location = "{{route('logistic.disasterready.list')}}";
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

            $('[xaction="verify"]').on('click', function(e){
                e.preventDefault();

                $('#verifyBookingModal .modal-body').text('Sila tunggu...');
                hide('[xaction="verify"]');
                hide('#close_action_modal');

                var ids = [];

                @if($detail)
                    ids.push({{$detail->id}});
                @endif

                $.post('{{route('logistic.disasterready.approval')}}', {
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

                $.post('{{route('logistic.disasterready.reject')}}', {
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
                        $('.hasErr#disasterready_'+key).html(value[0]);
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

                $.post('{{route('logistic.disasterready.approve')}}', {
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

            parent.stopLoading();

            $('#assignVehicleModal #state_id').select2({
                width: '100%',
                theme: "classic"
            });

            $('#assignVehicleModal #placement_list').select2({
                width: '100%',
                theme: "classic"
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
        })

    </script>
</body>

</html>
