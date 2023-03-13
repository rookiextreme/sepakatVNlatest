@php
   $AccessSummon = auth()->user()->vehicle('01', '02');
   $TaskFlowAccessSummon = auth()->user()->vehicleWorkFlow('01', '02');
   $status = Request('status') ? Request('status') : null;
   $branch_id = Request('branch_id') ? Request('branch_id') : null;
   $limit = Request('limit') ? Request('limit') : 5;
   $search = Request('search') ? Request('search') : null;
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
    <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/spakat.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
    <script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

    <style type="text/css">
        .sect-top {
            position: fixed;
            left:0px;
            width:100%;
            z-index:4;
            padding-left:28px;
            padding-right:28px;
            background-color: #f2f4f0;
            padding-bottom:20px;
            border-bottom-color:#e7e7e7;
            border-bottom-style: solid;
            border-bottom-width:1px;
            margin-left:0px;
            margin-right:0px;
        }
        .sect-top-dummy {
            height:190px;
        }
        body {
            background-color: #f4f5f2;
        }
        .record-indicator {
            font-family: avenir;
            font-size:14px;
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

        .fancybox__content {
            height: 100vh !important;
        }

        .branch-label {
            font-size: 14px;
            color: #f1f4ef;
            background-color: #335762;
            border-radius: 7px;
            padding-left: 5px;
            padding-right: 5px;
        }

    </style>
    <script>
        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="sect-top">
        <div class="mytitle">Rekod Saman</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
                <!--
                //PAPAR BILA CLICKED FROM REKOD KENDERAAN
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.list-alternate')}}');">Senarai Kenderaan</a></li>-->
                <li class="breadcrumb-item active" aria-current="page">Senarai</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md col-12">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-12">
                        <div class="btn-group">
                            <div class="dropdown inline" style="display: inline;">
                                <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fal fa-folder"></i>
                                    @switch($status)
                                    @case('in_progress')
                                        Tertunggak
                                        @break
                                    @case('payment_done')
                                        Dilunaskan
                                        @break
                                    @case('is_chg_ownership')
                                        Dipindah Milik
                                        @break
                                    @default
                                        Keseluruhan
                                    @endswitch
                                </span>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><h6 class="dropdown-header">Rekod</h6></li>
                                    <li><a class="dropdown-item {{$status == 'all' ? 'active': ''}}" onclick="parent.openPgInFrame('{{route('vehicle.saman.rekod', ['status' => 'all'])}}')">Keseluruhan</a></li>
                                    <li><a class="dropdown-item {{$status == 'in_progress' ? 'active': ''}}" onclick="parent.openPgInFrame('{{route('vehicle.saman.rekod', ['status' => 'in_progress'])}}')">Tertunggak</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Selesai</h6></li>
                                    <li><a class="dropdown-item {{$status == 'all_done' ? 'active': ''}}" onclick="parent.openPgInFrame('{{route('vehicle.saman.rekod', ['status' => 'all_done'])}}')">Keseluruhan</a></li>
                                    <li><a class="dropdown-item {{$status == 'payment_done' ? 'active': ''}}" onclick="parent.openPgInFrame('{{route('vehicle.saman.rekod', ['status' => 'payment_done'])}}')">Dilunaskan</a></li>
                                    <li><a class="dropdown-item {{$status == 'is_chg_ownership' ? 'active': ''}}" onclick="parent.openPgInFrame('{{route('vehicle.saman.rekod', ['status' => 'is_chg_ownership'])}}')">Dipindah Milik</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group">
                            @if ($AccessSummon->mod_fleet_c == 1)
                                <a onclick="getSummonVehicle()" aria-readonly="" data-bs-toggle="modal"
                                data-bs-target="#VehicleSearchModal" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Saman</a>
                            @endif
                            @if ($AccessSummon->mod_fleet_d == 1)
                                <button data-bs-toggle="modal" data-bs-target="#summonDelModal" id="delete_all" disabled class="btn cux-btn bigger" type="button"><i class="fal fa-trash-alt"></i> Hapus</button>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-12 custom mt-2 mt-md-0">
                        @if(auth()->user()->detail->hasBranch)
                            <label for="" class="form-label">Cawangan/Jkr Negeri</label>
                            <div class="branch-label mb-2 mb-md-0">{{auth()->user()->detail->hasBranch->name}}</div>
                            @else
                            <select name="branch_id" class="form-control" id="branch_id">
                                <option value="">[Sila Pilih Cawangan]</option>
                                @foreach ($branch_list as $index => $branch)
                                    <option value="{{$branch->id}}" {{$branch_id == $branch->id ? 'selected' : ''}}>{{$branch->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-4 mt-2 mt-md-0">
                
            </div> --}}
            <div class="col-md col-lg-4 col-12 mt-2 mt-md-0">
                <div class="float-end pe-0">
                    {{-- <span class="btn cux-btn bigger" onclick="downloadExcel()"><i class="fal fa-file-excel text-success"></i>&nbsp;Muat Turun</span> --}}
                    {{ $summon_list->links('pagination.option.default', [ 'limit' => $limit , 'search' => $search, 'placeholder' => 'Carian Plat Nombor']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="sect-top-dummy"></div>
    <div class="main-content">
        <div class="table-responsive">
            <table class="table-custom no-footer stripe">
                <thead>
                    @if ($AccessSummon->mod_fleet_d == 1)
                        <th class="col-del">
                            <input class="form-check-input cursor-pointer" type="checkbox" name="chkall" value="" id="chkall">
                        </th>
                    @endif
                    <th style="width:46px"></th>
                    <th>No Kenderaan</th>
                    <th>Pengeluar Saman</th>
                    <th>Jenis Saman</th>
                    <th>No. Notis</th>
                    <th>Hak Milik</th>
                    <th>Cawangan</th>
                    {{-- <th>Kategori > Sub Kategori</th> --}}
                    <th class="text-center">Status</th>
                </thead>
                <tbody id="sortable">
                    @foreach ($summon_list as $summon)
                        @php

                            $fleet_view =  $summon->pendaftaran->hak_milik == 'project' ? 'public' : 'department';
                            $categoryName = '';
                            $subCategoryName = '';

                            if ($summon->pendaftaran->hasCategory()) {
                                if ($summon->pendaftaran->hasCategory()) {
                                    $categoryName = $summon->pendaftaran->hasCategory()->name;
                                }

                                if ($summon->pendaftaran->hasSubCategory()) {
                                    $subCategoryName = $summon->pendaftaran->hasSubCategory()->name;
                                }
                            }

                        @endphp
                        <tr>
                            @if ($AccessSummon->mod_fleet_d == 1)
                                <td class="text-center">
                                    @if(in_array($summon->statusSaman->code, ['01']) || auth()->user()->isAdmin())
                                        <input class="form-check-input" type="checkbox" name="chkdel" value="{{ $summon->id }}" id="chkdel">
                                    @endif
                                </td>
                            @endif
                            <td class="p-1 text-center">
                                @if ($AccessSummon->mod_fleet_u == 1)
                                    @if(in_array($summon->statusSaman->code, ['01']))
                                        <span class="btn cux-btn" onclick="openPgInFrame('{{ route('vehicle.saman.daftar', [ 'id' => $summon->id, 'vehicle_id' => $summon->pendaftaran->id ]) }}')"><i class="fa fa-pencil-alt"></i></span>
                                    @endif
                                    @if(in_array($summon->statusSaman->code, ['02','03','05']))
                                        <div class="btn-group dropend">
                                            <button class="btn cux-btn" onclick="openPgInFrame('{{ route('vehicle.saman.daftar', [ 'id' => $summon->id, 'vehicle_id' => $summon->pendaftaran->id, 'is_display' => 1, 'tab' => 1 ]) }}')"><i class="fa fa-pencil-alt"></i></button>
                                            <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropright</span></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li style="margin-top:-8px;"><h6 class="header-highlight">{{ $summon->pendaftaran->no_pendaftaran }}</h6></li>
                                                <li class="f1st-menu dropdown-item" onclick="openNewTab(1, {{$summon->id}})">
                                                    <i class="fal fa-typewriter"></i> Cetak Surat
                                                </li>
                                                {{-- <li class="dropdown-item"><i class="fal fa-undo"></i> Batal Saman</li> --}}
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                            </td>
                            <td><a class="text-uppercase"
                                href="{{ route('vehicle.saman.daftar', ['id' => $summon->id, 'vehicle_id' =>  $summon->pendaftaran->id ]) }}">{{ $summon->pendaftaran->no_pendaftaran }}</a>
                        </td>
                            <td class="text-uppercase">{{ $summon->maklumatSaman ? $summon->maklumatSaman->hasSummonAgency->desc : '' }}</td>
                            <td class="text-uppercase">{{ $summon->maklumatSaman ? $summon->maklumatSaman->hasSummonType->desc : '' }}</td>
                            <td class="text-uppercase">{{ $summon->maklumatSaman ? $summon->maklumatSaman->summon_notice_no : '' }}</td>
                            {{-- <td class="text-uppercase">{{ $categoryName . ' > ' . $subCategoryName }}</td> --}}
                            <td class="text-uppercase">{{ $summon->pendaftaran->hasOwnerType ? $summon->pendaftaran->hasOwnerType->desc_bm : 'PERSEKUTUAN' }}</td>
                            <td class="text-uppercase">
                                @switch($summon->pendaftaran->hasOwnerType->code)
                                    @case('01')
                                        {{ $summon->pendaftaran->cawangan ? $summon->pendaftaran->cawangan->name : '-' }}
                                        @break
                                    @case('02')
                                        {{ $summon->pendaftaran->cawangan ? $summon->pendaftaran->cawangan->name : '-' }}
                                        @break
                                    @case('03')
                                        {{ $summon->pendaftaran->hasMoreDetail->hasProject ? $summon->pendaftaran->hasMoreDetail->hasProject->contractor_name : '-'}}
                                        @break
                                        
                                @endswitch
                            </td>
                            <td class="text-center text-uppercase">
                                @if(in_array($summon->statusSaman->code, ['02','05']))
                                <button type="button" class="btn cux-btn small" onclick="openPgInFrame('{{ route('vehicle.saman.daftar', ['id' => $summon->id, 'vehicle_id' =>  $summon->pendaftaran->id, 'tab' => 2 ]) }}')">{{ $summon->statusSaman->name }}</button>
                                @else
                                {{ $summon->statusSaman->name }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    @if(count($summon_list)==0)
                    <tr class="no-record">
                        <td colspan="9" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>


        {{ $summon_list->links('pagination.default', [ 'limit' => $limit , 'search' => $search, 'status' => $status]) }}

        <div class="modal fade" id="VehicleSearchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="VehicleSearchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
              <div class="modal-content">

                <div class="modal-body">
                    <div class="popup-title">Pilih Kenderaan</div>
                    <div class="text-guide">Sila buat carian kenderaan.</div>
                    <hr/>
                  <div class="row">
                      <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
                            <div class="input-group">
                            <input type="text" onkeyup="getSummonVehicle('search', this)" class="form-control" placeholder="cth. JAJ4532">
                            <button type="button" class="input-group-text" id="enter"><i class="fa fa-search"></i></button>
                            </div>
                      </div>
                    <div class="col-12">
                        <div class="table-responsive" id="summonVehicleList">

                        </div>

                        {{-- <div class="float-end" id="pagination" style="display: none">
                            <div class="btn-group">
                                <button class="btn cux-btn prev" onclick="getSummonVehicle('prev')"><i class="far fa-chevron-left"></i></button>
                                <button class="btn cux-btn next" onclick="getSummonVehicle('next')"><i class="far fa-chevron-right"></i></button>
                            </div>
                        </div> --}}
                    </div>
                  </div>
                </div>
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
              </div>
            </div>
        </div>

        <div class="modal fade" id="summonDelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="summonDelModalLabel" aria-hidden="true">
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

    <script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
    <script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>

    <script>

        let vehicleLimit = 5;
        let vehicleOffset = 0;
        var vehicleSearch = null;
        var checkedList = [];

        function getCurrentChecked(){
            checkedList = [];
            $('#chkdel:checked').map(function() {
                checkedList.push(parseInt(this.value));
            });

            return checkedList;
        }

        function remove(){
            $('#summonDelModal #remove').hide();
            $('#summonDelModal #close').hide();
            $.post("{{route('vehicle.saman.delete')}}", {
                checkedList: checkedList,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#summonDelModal .sub-title').text(result.message);
                }
                $('#summonDelModal #reload').show();
            })
        }

        function getSummonVehicle(content, self){

            if(content == 'next'){
                vehicleOffset = vehicleOffset + 1;
                callAjaxSummonVehicle();
            } else if(content == 'prev'){
                if(vehicleOffset > 0){
                    vehicleOffset = vehicleOffset - 1;
                    callAjaxSummonVehicle();
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
                    callAjaxSummonVehicle();
                }
            } else {
                callAjaxSummonVehicle();
            }
        }

        function callAjaxSummonVehicle(){
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
                    $('#summonVehicleList').html(data);
            });


        }

        function selectSummonVehicle(vehicle_id, vehicle_no){
            window.location.href = "{{route('vehicle.saman.daftar')}}?vehicle_id="+vehicle_id;
        }

        function ajaxLoadModalVehicleSummonPage(url){
            parent.startLoading();
            $.get(url, function(data){
                $('#summonVehicleList').html(data);
                parent.stopLoading();
            });
        }

        function downloadExcel(){
            $.ajax({
                url:"{{route('vehicle.saman.export.excel')}}",
                data: {},
                cache:false,
                xhrFields:{
                    responseType: 'blob'
                },
                success: function(result, status, xhr){
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] : 'Senarai Kenderaan.xlsx');

                    // The actual download
                    var blob = new Blob([result], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;

                    document.body.appendChild(link);

                    link.click();
                    document.body.removeChild(link);
                },
                error:function(){

                }
            });
        }

        const fancyView = function(url){
            const fancybox = new Fancybox([
            {
                src: url,
                type: "iframe",
            },
            ]);

            fancybox.on("done", (fancybox, slide) => {
            console.log(`done!`);
            });
        }

        function openNewTab(id, summon_id){

            var issuer = $('#summon_agency_id').val();
            if(id==1){
                var url = '{{route('vehicle.saman.generate.letter')}}?id='+summon_id+'&issuer='+issuer;
                fancyView(url);
            }

        }

        $(document).ready(function() {

            $('#option_per_page').select2({
                width: '100%',
                theme: "classic"
            })

            $('#branch_id').select2({
                width: '100%',
                theme: "classic"
            }).on('change', function(res){
                let url = '{{route('vehicle.saman.rekod')}}';
                let status = '{{$status}}';
                let branch_id = this.value;

                parent.openPgInFrame(url+"?status="+status+"&branch_id="+branch_id);
            })

            $('[name="chkall"]').change(function() {

                $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(checkedList.length > 0){
                    $('#delete_all').prop('disabled', false);
                }

            });

            $('[name="chkdel"]').change(function() {

                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(checkedList.length == $('[name="chkdel"]').length){
                    $('#chkall').prop('checked', true);
                } else {
                    $('#chkall').prop('checked', false);
                }

                if(checkedList.length > 0){
                    $('#delete_all').prop('disabled', false);
                }
            });

        })

    </script>
</body>

</html>
