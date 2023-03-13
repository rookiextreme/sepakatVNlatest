@php
    use App\Http\Controllers\Vehicle\VehicleDAO;

   $AccessVehicle = auth()->user()->vehicle('01', '01');
   $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');
   $totalByStatus = "";

   $xmode = Request('xmode') ? Request('xmode') : 'list';
   $fleet_view = Request('fleet_view') ?  Request('fleet_view') : 'department';
   $ownership = Request('ownership') ?  Request('ownership') : 'jkr';
   $locations = Request('locations.placement.name') ?  Request('locations.placement.name') : 'Persekutuan';

   $status = Request('status') ? Request('status') : null;
   $search = Request('search') ?  Request('search') : null;

   $VehicleDAO = new VehicleDAO();
   $VehicleDAO->mount();

   $owner_type_list = $VehicleDAO->owner_type_list;
   $dispose_list = $VehicleDAO->dispose_list;
   $totalByStatus = $VehicleDAO->totalVehicleByStatus($fleet_view);
    if($xmode == 'catelog'){
        $vehicles = $VehicleDAO->vehicles;
    }

    $totalverification = 0;
    $totalapproval = 0;

@endphp
@if(!empty($totalByStatus))
@foreach ($totalByStatus as $v_status)
    @php
        switch ($v_status->code) {
            case '02':
            $totalverification = $v_status->total;
                break;
            case '03':
            $totalapproval = $v_status->total;
                break;
        }
    @endphp
@endforeach
@endif
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<script src="{{ asset('my-assets/bootstrap/js/popper.js') }}" type="text/javascript"></script>

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>


<style type="text/css">
    .sect-top {
        position: fixed;
        left:0px;
        width:100%;
        z-index:4;
        padding-left:28px;
        background-color: #f2f4f0;
        padding-bottom:6px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height:165px;
    }
    .shadow-top {
        box-shadow: -7px 16px 35px -7px rgba(0,0,0,0.27);
        -webkit-box-shadow: -7px 16px 35px -7px rgba(0,0,0,0.27);
        -moz-box-shadow: -7px 16px 35px -7px rgba(0,0,0,0.27);
        transition: transform 0.3s ease-out;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    table.dataTable tbody tr td.combine {
        padding-top: 4px;
        width:30px;
        text-align: center;
    }
    .modal-header {
        font-family: helvetica-bold;
        font-size:18px;
        color:#303030;
		letter-spacing:0px;
		letter-spacing: -1px;
		font-size: 18px;
		line-height: 18px;
    }
    .awas {
        background-position:top right;
        background-size:150px 160px;
        background-repeat: no-repeat;
        min-height: 400px;
    }
    a {
        font-family: lato;
        color:#718aa6;
        cursor:pointer;
        text-decoration: none;
    }
    a:hover {
        text-decoration: none;
        color:#000000;
    }
    body {
        background-color: #f4f5f2;
    }
    .lcal-2 {
        width:50px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:150px;
    }
    .lcal-5 {
        width:250px;
    }

    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }
    td.dt-center {
        text-align: center;
    }
    .dropdown-item {
        font-family: mark;
        font-size:14px;
    }
    .dropdown-item a {
        font-family: mark;
        font-size:14px;
    }
    .dropdown-item i.fa {
        min-width:40px !important;
        text-align:left;
    }
    .dropdown-header {
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:12px;
        color:#6d7466;
    }
    .header-highlight {
        background-color:#49575c;
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:16px;
        color:#ffffff;
        height: 30px;
        line-height: 30px;
        padding-left:16px;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius:  4px 4px 4px 4px;
    }
    .f1st-menu {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#e7e7e7+0,ffffff+100 */
        margin-top:-5px;
        background: #e7e7e7; /* Old browsers */
        background: -moz-linear-gradient(top,  #e7e7e7 0%, #ffffff 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #e7e7e7 0%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #e7e7e7 0%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e7e7e7', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
    }
    .dropdown-menu {
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
    }
    .catalogue {
        width:100%;
        max-width: 800px;
        padding-left:10px;
        padding-right:10px;
        padding-bottom:30px;
    }
    .catalogue .box-catalogue {
        background-color: #ffffff;
        margin-bottom:10px;
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius:  6px 6px 6px 6px;
        border-color:#d7d7de;
        border-width:2px;
        border-style:solid;
        min-height: 80px;
        height:105px;
    }
    .no-plet {
        font-family: avenir-bold;
        font-size:20px;
        line-height: 45px;
        text-transform: uppercase;
        color:#000000;
    }
    .lokasi {
        font-family: mark;
        font-size:12px;
        line-height:12px;
    }
    .subject {
        font-family: avenir-bold;
        font-size:10px;
        text-transform: uppercase;
        color:#404040;
        margin-top:5px;
    }
    .kategori {
        background-color:#404040;
        font-family: avenir-bold;
        color:#ffffff;
        font-size:12px;
        padding-left:5px;
        margin-bottom:3px;
    }
    .text-uppercase {
        line-height:16px !important;
        margin-top:10px;
    }
    .details {
        font-family: mark;
        font-size:14px;
    }
    .line-t {
        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
    }
    .box-left {
        position: absolute;
        left:10px;
        top:0px;
        margin-left:-8px;
        margin-top:3px;
        width:143px;
        height:95px;
        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        transition: all .2s ease-in-out;
    }
    .box-left:hover {
        transform: scale(1.1);
    }
    .box-right {
        width:80%;
        padding-top:5px;
        margin-left:20px;
    }
    .date .input-group-text {
        height: 39px;
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
    .filter-btn {
        height: 42px !important;
        width:42px;
        text-align: center;
        line-height:28px;
        background-color:#ffffff;
        border-radius: none;
        -moz-border-radius: none;
        -webkit-border-radius: none;
        font-family: avenir;
        font-size: 12px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        border-bottom-color:#dcdcd8;
        border-bottom-width:2px;
        border-bottom-style:solid;
        border-top-color:#dcdcd8;
        border-top-width:2px;
        border-top-style:solid;
        border-left-color:#dcdcd8;
        border-left-width:1px;
        border-left-style:solid;
        border-right-style:none;
        cursor: pointer;
        padding-left:0px;
        padding-right:0px;
        line-height:38px;
    }
    .select2-container--open {
        z-index:1060;
    }
    .txt-memo, .txt-memo span {
        font-family: mark;
        font-size:20px;
        line-height: 20px;
        color:#16829b;
    }
    .txt-memo span {
        font-family: mark-bold;
        text-decoration: underline;
        font-size:20px;
        line-height: 20px;
        color:#16829b;
    }
    .txt-memo .confirm {
        font-family: mark-bold;
        font-size:20px;
        line-height: 20px;
        color:#16829b;
    }
    .modal-body {
        vertical-align: middle;
        padding-left:20px;
        padding-right:20px;
    }
    #prompt-container {
        padding-left:30px;
        padding-right:30px;
    }
    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
        .catalogue {
            width:100%;
            max-width: 1000px;
        }
	}
	@media (max-width: 1199.98px) {
		/*Large devices (desktops, less than 1200px)*/
		/*Large*/

	}
	@media (max-width: 991.98px) {
		/* Medium devices (tablets, less than 992px)*/
		/*medium*/
        .box-right {
            width:75%;
        }
	}
	@media (max-width: 767.98px) {
		/* Small devices (landscape phones, less than 768px)
		/*small*/
        .box-right {
            width:70%;
        }
        .data-extra {
            display: none;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .main-content {
            padding-left:20px;
            padding-right:20px;
        }
        .box-right {
            width:65%;
        }
        .sect-top {
            height:150px;
        }
        .sect-top .dropdown {
            margin-top:30px;
        }
        .sect-top nav {
            margin-top:40px;
        }
        .catalogue .box-catalogue {
            height: 100%;
        }
	}
    .nav-btn{
        font-family: mark-bold !important;
        font-size: 12px !important;
        text-transform: uppercase;
        color:rgba(53, 51, 51, 0.637);

    }
    .nav-text{
        font-family: mark !important;
        font-size: 12px !important;
        color:rgba(53, 51, 51, 0.993);

    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
<script type="text/javascript">
    function setSchFilter(obj) {
        var objid = $(obj).attr('id');
        $('.search-filter').removeClass('active');
        $('#' + objid).addClass('active');

        $('#filter-opt').val(objid);
        var xid = $(obj).attr('xid');
        $('#schFilterValue').val(xid);
        $('#fleet_search').attr('placeholder',$(obj).html());
    }
</script>
</head>
<body class="content">
    <div class="sect-top">
        <div class="mytitle">Laporan Senaraian Kenderaan <span>Milik JKR</span></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('vehicle.report')}}');">Laporan &amp; Statistik</a></li>
            <li class="breadcrumb-item active" aria-current="page" id="daerah">Kenderaan Daerah</li>
            </ol>
        </nav>
    <input type="hidden" name="filter-opt" id="filter-opt" value="">
    @if (Auth::user()->detail->register_purpose == 'is_jkr')
    <div class="dropdown inline" style="display: inline;">
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-ul-list"></i>
            Johor
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">Pemilikan</h6></li>
            <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['status' => '', 'xmode' => $xmode, 'ownership' => 'jkr', 'fleet_view' =>  'department' ])}}')">Milik JKR</a></li>
            <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['status' => '', 'xmode' => $xmode, 'ownership' => 'public' , 'fleet_view' =>  'public'])}}')">Awam / Projek</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['status' => '', 'xmode' => $xmode, 'ownership' => 'disposal' , 'fleet_view' =>  'disposal'])}}')">Rekod Arkib</a></li>
        </ul>

    </div>
    @if($fleet_view !== 'disposal')
        <div class="btn-group">
            @if ($AccessVehicle->mod_fleet_c == 1)
            <a class="btn cux-btn bigger spakat-tip" href="{{route('vehicle.register')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah rekod kenderaan"><i class="fal fa-plus"></i> <span style="font-family: avenir;color:black;font-size:14px">Kenderaan</span></a>
            @endif
            <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel()" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel fa-lg" style="margin-top:2px"></i> &nbsp;Muat Turun Data</a>
            <!--<span class="btn cux-btn bigger dropdown-toggle spakat-tip" type="button" id="mode_listing" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="top" title="Tukar ke Mod {{ $xmode == 'list' ? 'Senarai':'Katalog'}}"><i class="fal fa-list-ul fa-lg" style="margin-top:2px"></i> {{--@if($xmode == 'list') Senarai @else Katalog @endif--}}
            </span>
            <ul class="dropdown-menu" aria-labelledby="mode_listing">
                <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['status' => $status, 'xmode' => 'list', 'ownership' => $ownership, 'fleet_view' =>  $fleet_view ])}}')"><i class="fal fa-list-ul"></i> Mod Senarai</a></li>
                <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.list', ['status' => $status, 'xmode' => 'catelog', 'ownership' => $ownership, 'fleet_view' =>  $fleet_view ])}}')" selected><i class="fal fa-images"></i> Mod Katalog</a></li>
            </ul>-->
        </div>

            @if ($AccessVehicle->mod_fleet_d == 1)
            <button class="btn cux-btn bigger" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#deleteVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
            @endif
            <div class="btn-group">
            @if ($TaskFlowAccessVehicle->mod_fleet_verify)
                @if($status == 'verification')
                    <button class="btn cux-btn bigger" xaction="verify_all" data-bs-toggle="modal" data-bs-target="#verifyVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Semak"><i class="fa fa-check"></i>&nbsp;Semak</button>
                @endif
            @endif

            @if ($TaskFlowAccessVehicle->mod_fleet_approval)
                @if($status == 'approval')
                    <button class="btn cux-btn bigger" xaction="approve_all" data-bs-toggle="modal" data-bs-target="#approvalVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                @endif
            @endif
            </div>
    @endif
    <div class="dropdown inline float-end" style="margin-right:30px;">
        <div style="display: inline-block;width:70px;padding-right:5px;">
            <div style="position: absolute;left:-50px;line-height:40px;">Papar</div>
            <select class="form-select" id='total_list_per_page' name='total_list_per_page'>
                <option value="5" {{$limit==5 ? "selected" : ""}}>5</option>
                <option value="10" {{$limit==10 ? "selected" : ""}}>10</option>
                <option value="25" {{$limit==25 ? "selected" : ""}}>25</option>
                <option value="50" {{$limit==50 ? "selected" : ""}}>50</option>
                <option value="100" {{$limit==100 ? "selected" : ""}}>100</option>
            </select>
        </div>
        <div style="display: inline-block;width:200px;">
            <div class="input-group">
                <input id='fleet_search' type="text" class="form-control" placeholder="Carian" value='{{$search}}'>
                <div class="dropdown">
                    <button class="btn filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <input type="hidden" id="schFilterValue" value="0"/>
                        <li><a class="dropdown-item search-filter active" href="#" onclick="setSchFilter(this)" xid="0" id="flt-jenis">All</a></li>
                        <li><a class="dropdown-item search-filter" href="#" onclick="setSchFilter(this)" xid="1" id="flt-noplate">No Pendaftaran</a></li>
                        <li><a class="dropdown-item search-filter" href="#" onclick="setSchFilter(this)" xid="2" id="flt-nojkr">No JKR</a></li>
                        <li><a class="dropdown-item search-filter" href="#" onclick="setSchFilter(this)" xid="3" id="flt-lokasi">Lokasi</a></li>
                        <li><a class="dropdown-item search-filter" href="#" onclick="setSchFilter(this)" xid="4" id="flt-milik">Milik</a></li>
                        <li><a class="dropdown-item search-filter" href="#" onclick="setSchFilter(this)" xid="5" id="flt-jenis">Jenis</a></li>
                    </ul>
                </div>
                <div style="height:40px;max-height:50xp;background-color:#ffffff;-webkit-border-radius: 0px 8px 8px 0px;-moz-border-radius: 0px 8px 8px 0px;border-radius: 0px 8px 8px 0px;">
                    <span class="input-group-text" id='search-btn'><i class="fal fa-search fa-lg"></i></span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="sect-top-dummy"></div>
<div class="main-content">
    @if($xmode == 'list')
        <div class='row' style='margin-top:10px;margin-bottom:10px;display:none'>
            <div class='col-3'>
                <div class='btn-group'>
                    <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['offset' => ($offset-$limit), 'fleet_view' => $fleet_view ])}}')" {{$offset == 0 ? "disabled":""}} ><i class="fa fa-arrow-left"></i></button>
                    <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['offset' => ($offset+$limit), 'fleet_view' => $fleet_view ])}}')" {{$offset+$limit > $total_fleet ? "disabled":""}}><i class="fa fa-arrow-right"></i></button>
                </div>
                <span class='nav-text'>&nbsp;&nbsp;&nbsp;{{($offset+1)}} - {{($offset)+$limit}} of {{$total_fleet}}</span>
            </div>
        </div>
        <div xmode="list">
           <div class="table-responsive mt-3">
            <table class="table-custom no-footer stripe">
                <thead>
                    <tr>
                        <th class="col-del"></th>
                        <th style="width:70px;text-align:left">No. Pendaftaran</th>
                        <th class="lcal-5">Kategori</th>
                        <th class="lcal-3">Milik</th>
                        <th>Lokasi</th>
                        <th class="lcal-3">Usia</th>
                        <th class="lcal-4">Pengeluar</th>
                        <th class="lcal-4">Model</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listFleets as $fleet)
                    <tr>
                        <td style="padding-top:2px;text-align:right">{{$loop->index+1}}.</td>
                        <td class="text-start" style="padding-left:10px;text-align: left !important;"><a onclick="parent.openPgInFrame('{{route('vehicle.onepagedetail', ['id' => $fleet->id, 'fleet_view' => $fleet_view,  'view_as' => 'full_detail'])}}')">{{$fleet->no_pendaftaran}}</a></td>
                        <td class="text-uppercase">{{$fleet->category_name}}</td>
                        <td class="text-uppercase">{{$fleet->ownership}}</td>
                        <td class="text-uppercase">{{$fleet->placement_name}}</td>
                        <td class="text-uppercase">{{$fleet->age}}</td>
                        <td class="text-uppercase">{{$fleet->brand_name}}</td>
                        <td class="text-uppercase">{{$fleet->model_name}}</td>
                    </tr>
                @endforeach
                @if($total_fleet == 0)
                <tr class="no-record">
                    <td colspan="9" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                </tr>
                @endif
                </tbody>
                {{-- <tfoot>
                    <tr>
                        <th class="del"></th>
                        <th class="edit">&nbsp;</th>
                        <th class="lcal-3"><span>Pendaftaran</span></th>
                        <th class="lcal-3"><span>Kategori</span></th>
                        <th class="lcal-3"><span>{{$fleet_view == 'disposal' ? 'Kaedah': 'Milik'}}</span></th>
                        <th><span>{{$fleet_view == 'disposal' ? 'Penerima': ($fleet_view == 'public' ? 'Nama Projek' : 'Lokasi')}}</span></th>
                        <th class="lcal-2"><span>{{$fleet_view == 'public' ? 'Ketua Pasukan Projek (HPT)': 'Usia'}}</span></th>
                        <th class="lcal-3"><span>Pengeluar</span></th>
                        <th class="lcal-3"><span>Model</span></th>
                    </tr>
                </tfoot> --}}
            </table>
           </div>
        </div>

        @if($total_fleet > 0)
            <div style='margin-top:10px;margin-bottom:40px'>
                <div class='btn-group'>
                    <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['offset' => ($offset-$limit), 'fleet_view' => $fleet_view, 'search' => $searchParam ])}}')" {{$offset == 0 ? "disabled":""}} ><i class="fa fa-arrow-left"></i></button>
                    <button class='btn cux-btn nav-btn' onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['offset' => ($offset+$limit), 'fleet_view' => $fleet_view, 'search' => $searchParam ])}}')" {{$offset+$limit > $total_fleet ? "disabled":""}}><i class="fa fa-arrow-right"></i></button>
                </div>
                <span class='nav-text'>&nbsp;&nbsp;&nbsp;{{($offset+1)}} - {{$total_fleet<($offset+$limit) ? $total_fleet : ($offset+$limit) }} of {{$total_fleet}}</span>
            </div>
        @endif
    @endif
<div class="modal fade modal-dialog-scrollable" id="vehicleImagesModal" tabindex="-1" aria-labelledby="vehicleImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="position: relative;height:100%;">
            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:15px;top:15px;z-index:10"></button>
            <div class="modal-body" id="vehicle-images" style="height: 400px;"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteVehicleModalLabel" aria-hidden="true" style="margin-top:400px;background-color:red">
    <div class="modal-dialog">
        <div class="modal-content" style="padding-top:10vh">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div>
                    Adakah anda ingin menghapuskan data ini ?
                </div>
                <div class="form-group">
                    <label for="remark">Nyatakan sebab</label>
                    <textarea name="remark" class="form-control" id="remark" cols="30" rows="5"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                <span class="btn btn-danger" xaction="delete" >Ya</span>
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

<div class="modal fade" id="changeOwnerShipModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeOwnerShipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
            <div class="modal-header">
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="form-group">
                    Adakah anda ingin menukar pemilikan untuk maklumat ini ?
                </div>

                <div class="form-group">
                    <div class="input-group mb-3">
                        <select class="form-select" name="ownership" id="ownership">
                            <option selected>Sila Pilih</option>
                            @foreach ($owner_type_list as $owner_type)
                                <option xcode="{{$owner_type->code}}" value="{{$owner_type->id}}">{{$owner_type->desc_bm}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                <span class="btn btn-danger" xaction="change_ownership" >Ya</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="disposeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="disposeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:15vh;">
        <div class="modal-content">
            <form id="frmDisposalModal" method="POST">
                @csrf
                <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
                <div class="modal-head mytitle" style="padding-left:13px;">
                    Pelupusan
                </div>
                <div class="modal-body" id="prompt-container">
                    <div id="response" style="display: none" class="text-center">
                        <br/>
                        <div ><span class="text text-success" id="msg"></span></div>
                    </div>

                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6 col-sm-6 col-12">
                            <label for="" class="form-label">Kaedah Pelupusan</label>
                            <div class="input-group">
                                <!--class="form-select" -->
                                <select name="disposal_id" id="disposal_id">
                                    <option></option>
                                    @foreach ($dispose_list as $dispose)
                                        <option value="{{$dispose->id}}">{{$dispose->desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-6 col-sm-6 col-12">
                            <label for="" class="form-label">Tarikh Lupus</label>
                            <div class="input-group date" id="dispose_dt">
                                <input name="dispose_dt" id="disposeDtInput"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                value="{{isset($detail['dispose_dt']) ? Carbon\Carbon::parse($detail['dispose_dt'])->format('d/m/Y'): null}}"/>

                                <div class="input-group-text" for="disposeDtInput">
                                    <i class="fal fa-calendar fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="" class="form-label">Catatan</label>
                            <div class="input-group">
                                <textarea name="remark" id="remark" class="form-control" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <label for="" class="form-label">Penerima</label>
                            <input type="text" id="recipient" name="recipient" class="form-control" value="">
                        </div>
                    </div>
                    <fieldset>
                        <legend>Muat Naik Dokumen</legend>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <label class="form-label">KEW.PA 23</label>
                                <label class="btn cux-btn bigger mb-3" for="kewpa_23"><i class="fal fa-cloud-upload"></i> Muat Naik</label>
                                <input type="file" onchange="changeDocument(this)" class="form-control d-none" name="kewpa_23" id="kewpa_23">
                                <div id="preview-file-kewpa_23" class="form-group mb-2" style="display: none;height: 100px;
                                    overflow: auto;">
                                    <embed id="preview-file-kewpa_23-embed" width="100%" type="">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <label class="form-label">Surat Pindah Milik</label>
                                <label class="btn cux-btn bigger mb-3" for="transfer_letter"><i class="fal fa-cloud-upload"></i> Muat Naik</label>
                                <input type="file" onchange="changeDocument(this)" class="form-control d-none" name="transfer_letter" id="transfer_letter">
                                <div id="preview-file-transfer_letter" class="form-group mb-2" style="display: none;height: 100px;
                                    overflow: auto;">
                                    <embed id="preview-file-transfer_letter-embed" width="100%" type="">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list')}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                    <button class="btn btn-module" type="submit" xaction="dispose" >Ya</button>
                    <span class="btn btn-link" xaction="no" data-bs-dismiss="modal">Batal</span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="DeclarePrepareForDisasterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="DeclarePrepareForDisasterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                  <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo" style="margin-top:14%">
                    Isytiharkan <span id="target-siap-siaga">WPL2172</span> sebagai<br/>kenderaan siap siaga bencana?
                    <br/><br/>
                    <div class="confirm">Pastikan no pendaftaran adalah betul.</div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="declare_ready_disaster" >Ya</span>
                <span class="btn btn-reset" xaction="no" data-bs-dismiss="modal">Batal</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="UnDeclarePrepareForDisasterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UnDeclarePrepareForDisasterModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
            <div class="modal-header" style="height:70px;">
                Pembatalan
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                  <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo" style="margin-top:14%">
                    Membatalkan <span id="target-siap-siaga">WPL2172</span> dari<br/>kenderaan siap siaga bencana?
                    <br/><br/>
                    <div class="confirm">Pastikan no pendaftaran adalah betul.</div>
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('report.vehicle-district-list', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="undeclare_ready_disaster" >Ya</span>
                <span class="btn btn-reset" xaction="no" data-bs-dismiss="modal">Batal</span>
            </div>
        </div>
    </div>
</div>

</div>


<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    var vehicle_ids = [];
    var selfDataTable;
    var fleet_view = '{{$fleet_view}}';

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

    function goTo(url){
        window.location.href = url;
    }

    function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
            param,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
    }

    function changeDocument(self){
        event.preventDefault();
        let docType = self.id;
        let url = URL.createObjectURL(event.target.files[0]);
            $('#preview-file-'+docType+'-embed').attr('src', url);
            $('#preview-file-'+docType).show();
    }

    function downloadExcel(){
        $.ajax({
            url:"{{route('vehicle.export.excel')}}",
            data: {
                'fleet_view': "{{$fleet_view}}"
            },
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

    function searching(self, trigger){
        let searchText = self.value;
        if(trigger == 'click'){
            searchText = self;
        }
        if(event.key === 'Enter' || self.value == '' || trigger == 'click') {
            var url = window.location.href;
            url = removeParam("search", url);
            parent.openPgInFrame(url + "&search="+searchText);
        }
    }

    function validate(content, message){
        if(!$(content).val()){
            if($(content).parent().find('.text-danger').length == 0){
                $(content).parent().append('<div class="text-danger col-12 fs-6">'+message+'</div>');
            }
            return false;
        } else {
            return true;
        }
    }

    function loadVehicleImages(vehicle_id){
        $.get("{{route('vehicle.ajax.getModalVehicleImages')}}", {
            'vehicle_id': vehicle_id,
            'fleet_view': '{{$fleet_view}}'
        }, function(res){
            $('#vehicle-images').html(res);
            $('#vehicleImagesIndicators').carousel({
                interval: 3000,
                cycle: true
            });
        });
    }

    function deleteThisItem(vehicle_id){
        vehicle_ids = [vehicle_id];
    }

    function promptChangeOwnership(vehicle_id, fleet_view_selected){
        fleet_view = fleet_view_selected;
        let triggerMD = $('#changeOwnerShipModal');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.modal('show');
    }

    function submitToChangeOwnership(vehicle_id, ownership){
        hide('[xaction="change_ownership"]');
        $.post("{{route('vehicle.changeOwnerShip')}}", {
            fleet_view: fleet_view,
            ownership: ownership,
            vehicle_id: vehicle_id,
            '_token':'{{ csrf_token() }}'
        }).done(function(){
            $('#changeOwnerShipModal #prompt-container').text('Pemilikan berjaya ditukar');
            show('[xaction="close"]');
            hide('[xaction="no"]');
        }).fail(function(){
            show('xaction="close"');
        })
    }

    function submitToDeclareForDisasterReady(vehicle_id){
        hide('[xaction="declare_ready_disaster"]');
        $.post("{{route('vehicle.declareForDisasterReady')}}", {
            fleet_view: fleet_view,
            vehicle_id: vehicle_id,
            '_token':'{{ csrf_token() }}'
        }).done(function(){

            $('#DeclarePrepareForDisasterModal #prompt-container').text('Maklumat ini telah diisytihar siap siaga bencana');
            show('[xaction="close"]');
            hide('[xaction="no"]');
        }).fail(function(){
            show('xaction="close"');
        })
    }

    function submitToUnDeclareForDisasterReady(vehicle_id){
        hide('[xaction="undeclare_ready_disaster"]');
        $.post("{{route('vehicle.undeclareForDisasterReady')}}", {
            fleet_view: fleet_view,
            vehicle_id: vehicle_id,
            '_token':'{{ csrf_token() }}'
        }).done(function(){

            $('#UnDeclarePrepareForDisasterModal #prompt-container').text('Maklumat ini telah dibatalkan siap siaga bencana');
            show('[xaction="close"]');
            hide('[xaction="no"]');
        }).fail(function(){
            show('xaction="close"');
        })
    }

    function promptToDispose(vehicle_id){
        let triggerMD = $('#disposeModal');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.modal('show');

        $('#disposal_id').select2({
            width: '100%',
            theme: "classic",
            placeholder: "Sila pilih"
        });
    }

    function submitToDispose(formData){
        // hide('[xaction="dispose"]');

        $.ajax({
            url: "{{route('vehicle.dispose.save')}}",
            type: 'post',
            cache: false,
            contentType: false,
            processData: false,
            async: false,
            data: formData,
            success: function(response) {

                let targetModal = $('#frmDisposalModal');
                // targetModal[0].reset();
                // targetModal.hide();
                // window.location.reload();

                console.log("true");
                show('[xaction="close"]');
                hide('[xaction="no"]');
                targetModal[0].reset();
                targetModal.find('#response #msg').text(response.message);
                targetModal.find('#response').show();
                targetModal.find('#form').hide();
            },
            error: function(response) {
                console.log("false");
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if(key == 'dispose_dt'){
                        if($('#dispose_dt').parent().find('.text-danger').length == 0){
                        $('#dispose_dt').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                    }
                    } else {
                        if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                        $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                    }
                    }
                });

                show('[xaction="dispose"]');

            }
        });
    }

    function promptToDeclarePrepareForDisaster(vehicle_id, self){
        let triggerMD = $('#DeclarePrepareForDisasterModal');
        let platNumber = $(self).attr('data-platNumber');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.find('#target-siap-siaga').text(platNumber);
        triggerMD.modal('show');
    }

    function promptToUnDeclarePrepareForDisaster(vehicle_id, self){
        let triggerMD = $('#UnDeclarePrepareForDisasterModal');
        let platNumber = $(self).attr('data-platNumber');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.find('#target-siap-siaga').text(platNumber);
        triggerMD.modal('show');
    }

    $(document).ready(function() {

        $('select').select2({
            width: '100%',
            theme: "classic",
            placeholder: "[Sila pilih]"
        });

        $(window).scroll(function() {
            var height = $(window).scrollTop();

            if(height  > 100) {
                // do something
                $('.sect-top').addClass('shadow-top');
            }else{
                $('.sect-top').removeClass('shadow-top');
            }
        });

        $('.spakat-tip').tooltip();

        $('#chkall').change(function() {


            //alert('sds');
            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));

            // var rows = $(selfDataTable.$('input[type="checkbox"]:checked').map(function () {
            // return this.value;
            // } ) );
            var arrayFleetId = [];
            $('[name="chkdel"]:checked').each(function() {
                arrayFleetId.push($(this).attr('xvalue'));
            });
            var fleetIdList = arrayFleetId.join(", ");

            //alert(fleetIdList);

            if(arrayFleetId.length > 0){
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', false);
            } else {
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', true);
            }

            console.log(fleetIdList);

        });

        $('[name="chkdel"]').change(function() {

            var arrayFleetId = [];
            $('[name="chkdel"]:checked').each(function() {
                arrayFleetId.push($(this).attr('xvalue'));
            });
            var fleetIdList = arrayFleetId.join(", ");

            //alert(fleetIdList);

            if(arrayFleetId.length > 0){
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', false);
            } else {
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', true);
            }


        });

        $('[xaction="delete_all"]').click(function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
        });

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();

            if(validate('#remark', 'Sila masukkan sebab')){

                let remark = $('#remark').val();

                hide('[xaction="delete"]');
                hide('[xaction="no"]');

                //vehicle_ids = [];

                var arrayFleetId = [];
                $('[name="chkdel"]:checked').each(function() {
                    arrayFleetId.push($(this).attr('xvalue'));
                });
                //alert(arrayFleetId);

                $.post('{{route('vehicle.delete')}}', {
                    'vehicle_ids': arrayFleetId,
                    'remark': remark,
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#deleteVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihapuskan');
                    show('[xaction="close"]');
                    //$('#deleteVehicleModal').modal('hide');
                });

                $('[xaction="close"]').on('click', function(){
                    window.location.reload();
                })
            }
        });

        $('#total_list_per_page').change(function(){
            var totalListPerPage = $(this).val();
            var fleetSearch = $('#fleet_search').val();
            parent.openPgInFrame('{{route('report.vehicle-district-list')}}?limit='+totalListPerPage+'&search='+fleetSearch);

        });

        $('#search-btn').click(function(){
            var totalListPerPage = $('#total_list_per_page').val();
            var fleetSearch = $('#fleet_search').val();
            var xid = $('#schFilterValue').val();
            parent.openPgInFrame('{{route('report.vehicle-district-list')}}?limit='+totalListPerPage+'&search='+fleetSearch+'&xid='+xid);

        });


        $('[xaction="change_ownership"]').on('click', function(e){
            e.preventDefault();
            let vehicle_id = $('#changeOwnerShipModal #vehicle_id').val();
            let ownership = $('#changeOwnerShipModal #ownership').val();
            submitToChangeOwnership(vehicle_id, ownership);
        });

        $('[xaction="declare_ready_disaster"]').on('click', function(e){
            e.preventDefault();
            let vehicle_id = $('#DeclarePrepareForDisasterModal #vehicle_id').val();
            submitToDeclareForDisasterReady(vehicle_id);
        });

        $('[xaction="undeclare_ready_disaster"]').on('click', function(e){
            e.preventDefault();
            let vehicle_id = $('#UnDeclarePrepareForDisasterModal #vehicle_id').val();
            submitToUnDeclareForDisasterReady(vehicle_id);
        });

        $('#frmDisposalModal').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            submitToDispose(formData);
        });

        $('[xaction="search"]').on('click', function(e){
            e.preventDefault();
            console.log('12121');
            let searchElem = $('#searching').val();
            searching(searchElem, 'click');
        })
    });

    function countRecordInProcess(plateNumber, id){


        var url = '{{route('vehicle.list-external-count')}}';

        //alert('plateNumber : '+plateNumber);
        $.ajax({

             url: url,
             data: {plateNumber: plateNumber, fleetId : id},
            cache: false,
            //contentType: false,
            //processData: false,
            dataType:'json',
            method: 'GET',
            success: function(data){

                //alert(data.total_department+' -- '+data.total_summons);
                $('#totalEvents'+id).html(data.total_department);
                $('#totalSummons'+id).html(data.total_summons);
                $('#totalAssessments'+id).html('0');
                $('#totalMaintenance'+id).html('0');

                if(data.total_summons > 0){
                    //jika ada saman hide tukar dispos and tukar ownership
                    // $('#dispose_'+id).hide();
                    // $('#change_ownership_'+id).hide();
                    // $('#delete_'+id).hide();
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(xhr.status);
                var err = eval("(" + xhr.responseText + ")");
                //alert(err.Message);


            }
        });

    }
</script>
<script>
    jQuery(document).ready(function() {
    })
</script>
</body>
</html>
