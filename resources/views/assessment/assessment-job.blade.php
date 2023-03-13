@php
   $AccessMaintenance = auth()->user()->vehicle('03', '02');
   $TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('03', '02');
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

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .cursor-pointer {
            cursor: pointer;
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

        #enter {
            display: none;height: 39px;
            margin-left: 2px;
            border: 2px solid #e5e5e5;
            border-left: none;
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
        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Penyenggaran</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Penyenggaran</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekod Penyenggaran</li>
        </ol>
    </nav>
    <div class="main-content">
        <form class="form-submit" id="the_form">
            <div class="btn-group">
                @if ($AccessMaintenance->mod_fleet_c == 1)
                    <a onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                    data-bs-target="#VehicleSearchModal" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Penyenggaran</a>
                @endif
                @if ($AccessMaintenance->mod_fleet_d == 1)
                    <button data-bs-toggle="modal" data-bs-target="#maintenanceJobDelModal" id="delete_all" disabled class="btn cux-btn bigger" type="button"><i class="fal fa-trash-alt"></i> </button>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <th><input name="chkall" id="chkall" type="checkbox"></th>
                        <th></th>
                        <th class="text-center">No Pendaftaran</th>
                        <th class="text-center">Tarikh Masuk Bengkel</th>
                        <th class="text-center">Tarikh Dijangka Siap</th>
                        {{-- <th class="text-center">Tarikh Siap</th> --}}
                        <th class="text-center">Jumlah Anggaran</th>
                        {{-- <th class="text-center">Jumlah Kos</th> --}}
                        <th class="text-center">Status</th>
                    </thead>
                    <tbody id="sortable">
                        @foreach ($maintenance_job_list as $maintenance_job)
                        <tr>
                            <td>
                                <input name="chkdel" id="chkdel" type="checkbox" value="{{$maintenance_job->id}}">
                            </td>
                            <td>
                                <div class="btn-group dropend">
                                    <button type="button" class="btn cux-btn" onClick="javascript:openPgInFrame('{{ route('assessment.job.register',  ['id' => $maintenance_job->id, 'vehicle_id' => $maintenance_job->hasVehicle()->id ]) }}')"><i class="fa fa-pencil-alt"></i></button>
                                </div>
                            </td>
                            <td>{{$maintenance_job->hasVehicle()->no_pendaftaran}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center">{{$maintenance_job->hasAppStatus->desc}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th class="text-center">No Pendaftaran</th>
                        <th class="text-center">Tarikh Masuk Bengkel</th>
                        <th class="text-center">Tarikh Dijangka Siap</th>
                        {{-- <th class="text-center">Tarikh Siap</th> --}}
                        <th class="text-center">Jumlah Anggaran</th>
                        {{-- <th class="text-center">Jumlah Kos</th> --}}
                        <th class="text-center">Status</th>
                    </tfoot>
                </table>
            </div>
            {{ $maintenance_job_list->links('pagination.default') }}
        </form>

        <div class="modal fade" id="VehicleSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">

                <div class="modal-body">
                  <h3 class="text-dark">Pilih Kenderaan</h3>
                  <p class="text-muted">Pilih Kenderaan daripada rekod Kenderaan yang berdaftar.</p><hr>
                  <div class="row">
                    <div class="col-12 input-group">
                        <input type="text" onkeyup="getVehicle('search', this)" class="form-control" placeholder="Carian Kenderaan">
                        <span class="input-group-text" id="enter">Enter</span>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th>No Pendaftaran</th>
                                    <th>Cawangan</th>
                                    <th>Hak Milik</th>
                                    <th>No Telefon</th>
                                    <th style="width: 300px;">Kategori Kenderaan</th>
                                </thead>
                                <tbody id="vehicleList">
                                </tbody>
                            </table>
                        </div>
                        <div class="float-start">
                            <div id="vehicleTotal"></div>
                        </div>
                        <div class="float-end" id="pagination" style="display: none">
                            <div class="btn-group">
                                <button class="btn btn-secondary cursor-pointer prev" onclick="getVehicle('prev')">Sebelum</button>
                                <button class="btn btn-secondary cursor-pointer next" onclick="getVehicle('next')">Selepas</button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="maintenanceJobDelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="maintenanceJobDelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah anda ingin menghapuskan maklumat ini ?
                    </p>
                </div>
                <div class="modal-footer float-start">
                  <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                  <button type="button" style="display: none" id="reload" class="btn btn-secondary" onclick="window.location.reload()">Tutup</button>
                  <button type="button" id="remove" class="btn btn-danger text-white" onclick="remove()">Ya</button>
                </div>
              </div>
            </div>
        </div>

    </div>

    <script>

        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var ids = [];

        function getCurrentChecked(){
            ids = [];
            $('#chkdel:checked').map(function() {
                ids.push(parseInt(this.value));
            });

            return ids;
        }

        function remove(){
            $('#maintenanceJobDelModal #remove').hide();
            $('#maintenanceJobDelModal #close').hide();
            $.post("{{route('assessment.job.delete')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#maintenanceJobDelModal .sub-title').text(result.message);
                }
                $('#maintenanceJobDelModal #reload').show();
            })
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
            $.get("{{route('assessment.job.ajax.getVehicle')}}", {
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

            $.get("{{route('assessment.job.ajax.getVehicle.total')}}", {
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
                        $('#vehicleTotal').html('<label>Tiada Rekod</label><label class="ms-2 cux-btn small" onclick="parent.openPgInFrame(\'{{route('vehicle.register')}}\')"><i class="fa fa-plus"> </i> &nbsp;Tambah Kenderaan</label>');
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
            window.location.href = "{{route('assessment.job.register')}}?vehicle_id="+vehicle_id;
        }

        $(document).ready(function() {

            $('[name="chkall"]').change(function() {

                $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(ids.length > 0){
                    $('#delete_all').prop('disabled', false);
                }

            });

            $('[name="chkdel"]').change(function() {

                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(ids.length == $('[name="chkdel"]').length){
                    $('#chkall').prop('checked', true);
                } else {
                    $('#chkall').prop('checked', false);
                }

                if(ids.length > 0){
                    $('#delete_all').prop('disabled', false);
                }
            });

        })

    </script>
</body>

</html>
