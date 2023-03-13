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
   $xid = Request('xid') ? (int) Request('xid') : 0;

   $owner_id = Request('owner_id');
   $state_id = Request('state_id');
   $type_id = Request('type_id');

   $VehicleDAO = new VehicleDAO();
   $VehicleDAO->mount();

   $owner_type_list = $VehicleDAO->owner_type_list;
   $dispose_list = $VehicleDAO->dispose_list;
   $totalByStatus = $VehicleDAO->totalVehicleByStatus('all');
    if($xmode == 'catelog'){
        $vehicles = $VehicleDAO->vehicles;
    }

    $totaldraf = 0;
    $totalverification = 0;
    $totalapproval = 0;

@endphp
@if(!empty($totalByStatus))
@foreach ($totalByStatus as $v_status)
    @php
        switch ($v_status->code) {
            case '01':
            $totaldraf = $v_status->total;
                break;
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
        background-color: #f2f4f0;
        padding-bottom:0px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height: 210px;
        /* height:172px; */
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
    .no-plet:hover {
        color:orange;
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
        /* min-height: 80px;
        height:135px; */
    }
    .no-plet {
        font-family: avenir-bold;
        font-size:24px;
        line-height: 60px;
        text-transform: uppercase;
        color:#000000;
    }
    .lokasi {
        font-family: mark;
        font-size:14px;
        /* line-height:18px; */
    }
    .subject {
        font-family: avenir-bold;
        font-size:12px;
        text-transform: uppercase;
        color:#404040;
        margin-top:5px;
    }
    .kategori {
        background-color:#404040;
        font-family: avenir-bold;
        color:#ffffff;
        font-size:14px;
        padding-left:5px;
        margin-bottom:6px;
    }
    .text-uppercase {
        line-height:16px !important;
        margin-top:10px;
    }
    .details {
        font-family: mark;
        font-size:16px;
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
        height:125px;
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
        height: 132px;
        overflow: auto;
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
    #span-siap-siaga {
        font-family: mark;
        font-size:14px;
        color: #000000;
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
            height:340px;
            padding-left: 10px;
            padding-right: 10px;
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
        .input-group .dropdown {
            margin-top:0px;
        }
        .sect-top-dummy {
            height: 310px;
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

    .branch-label {
        font-size: 14px;
        color: #f1f4ef;
        background-color: #335762;
        border-radius: 7px;
        padding-left: 5px;
        padding-right: 5px;
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
    <div class="mytitle">Rekod Kenderaan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Senarai</li>
        </ol>
    </nav>
    <input type="hidden" name="filter-opt" id="filter-opt" value="">
    @if (Auth::user()->detail->register_purpose == 'is_jkr')
    <div class="dropdown inline" style="display: inline;">
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-folder"></i>
            @switch($status)
                @case('draf')
                    Draf
                @break
                @case('verification')
                    Menunggu Semakan
                    @break
                @case('approval')
                    Menunggu Pengesahan
                    @break
                @default

                @switch($ownership)
                    @case('jkr')
                        Milik JKR
                        @if($owner_type_code == '01')
                            Persekutuan
                        @elseif($owner_type_code == '02')
                            Negeri
                        @endif
                    @break
                    @case('external')
                        Agensi Luar
                    @break
                    @case('public')
                        Awam / Projek
                    @break
                    @case('disposal')
                        Rekod Arkib
                    @break

                @endswitch
            @endswitch
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">Pemilikan</h6></li>
            <li><a class="dropdown-item @if($ownership == 'jkr' && $owner_type_code == '00' &&  $status == null) active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => '', 'xmode' => $xmode, 'ownership' => 'jkr', 'fleet_view' =>  'department', 'limit' => $limit, 'offset' => $offset ])}}')">Milik JKR</a></li>
            <li><a class="dropdown-item @if($ownership == 'jkr' && $owner_type_code == '01' &&  $status == null) active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => '', 'xmode' => $xmode, 'ownership' => 'jkr', 'fleet_view' =>  'department', 'limit' => $limit, 'offset' => $offset, 'owner_type_code' => '01' ])}}')">Milik JKR (Persekutuan)</a></li>
            <li><a class="dropdown-item @if($ownership == 'jkr' && $owner_type_code == '02' && $status == null) active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => '', 'xmode' => $xmode, 'ownership' => 'jkr', 'fleet_view' =>  'department', 'limit' => $limit, 'offset' => $offset, 'owner_type_code' => '02' ])}}')">Milik JKR (Negeri)</a></li>
            <li><a class="dropdown-item @if($ownership == 'public' && $status == null) active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => '', 'xmode' => $xmode, 'ownership' => 'public' , 'fleet_view' =>  'public', 'limit' => $limit, 'offset' => $offset ])}}')">Awam / Projek</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item @if($ownership == 'disposal' && $status == null) active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => '', 'xmode' => $xmode, 'ownership' => 'disposal' , 'fleet_view' =>  'disposal', 'limit' => $limit, 'offset' => $offset ])}}')">Rekod Arkib</a></li>

            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header">Kenderaan Baharu</h6></li>
            <li><a class="dropdown-item @if($status == 'draf') active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => 'draf', 'xmode' => $xmode, 'limit' => $limit, 'offset' => $offset, 'owner_type_code' => $owner_type_code ])}}')" >Draf <span class="badge bg-secondary"><?=$totaldraf?></span></a></li>
            @if ($TaskFlowAccessVehicle->mod_fleet_verify || auth()->user()->isAdmin() || auth()->user()->isPublic())
            <li><a class="dropdown-item @if($status == 'verification') active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => 'verification', 'xmode' => $xmode, 'limit' => $limit, 'offset' => $offset, 'owner_type_code' => $owner_type_code ])}}')" >Menunggu Semakan <span class="badge bg-secondary"><?=$totalverification?></span></a></li>
            @endif
            @if ($TaskFlowAccessVehicle->mod_fleet_approval || auth()->user()->isAdmin() || auth()->user()->isPublic())
            <li><a class="dropdown-item @if($status == 'approval') active @endif" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => 'approval', 'xmode' => $xmode, 'limit' => $limit, 'offset' => $offset, 'owner_type_code' => $owner_type_code ])}}')" >Menunggu Pengesahan <span class="badge bg-secondary"><?=$totalapproval?></span></a></li>
            @endif
        </ul>

    </div>
    @if($fleet_view !== 'disposal')
        <div class="btn-group">
            @if ($AccessVehicle->mod_fleet_c == 1)
            <a class="btn cux-btn bigger spakat-tip" href="{{route('vehicle.register')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah rekod kenderaan"><i class="fal fa-plus"></i> <span style="font-family: avenir;color:black;font-size:14px">Kenderaan</span></a>
            @endif
            <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel('report_vehicle_list')" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel fa-lg" style="margin-top:2px"></i> </a>
            <span class="btn cux-btn bigger dropdown-toggle spakat-tip" type="button" id="mode_listing" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="top" title="Tukar ke Mod {{ $xmode == 'list' ? 'Senarai':'Katalog'}}"><i class="fal {{ $xmode == 'list' ? 'fa-list-ul':'fa-images'}} fa-lg" style="margin-top:2px"></i> {{--@if($xmode == 'list') Senarai @else Katalog @endif--}}
            </span>
            <ul class="dropdown-menu" aria-labelledby="mode_listing">
                <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => $status, 'xmode' => 'list', 'limit' => $limit, 'offset' => $offset, 'ownership' => $ownership, 'fleet_view' =>  $fleet_view, 'owner_id' => $owner_id, 'state_id' => $state_id, 'type_id' => $type_id  ])}}')"><i class="fal fa-list-ul"></i> Mod Senarai</a></li>
                <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['status' => $status, 'xmode' => 'catelog', 'limit' => $limit, 'offset' => $offset, 'ownership' => $ownership, 'fleet_view' =>  $fleet_view, 'owner_id' => $owner_id, 'state_id' => $state_id, 'type_id' => $type_id  ])}}')" selected><i class="fal fa-images"></i> Mod Katalog</a></li>
            </ul>
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

    @else
        {{-- <div class="btn-group">
            <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel()" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel fa-lg" style="margin-top:2px"></i> </a>
        </div> --}}
    @endif

    <div class="row mt-2">
        <div class="col-md-8 pe-4 ps-4 pe-md-3 ps-md-3">
            @if($ownership == 'jkr' && !(in_array($status, ['draf', 'verification', 'approval'])))
                <div class="row">
                    <div class="col-md-6">
                        @if(auth()->user()->detail->hasBranch)
                            <label for="" class="form-label">Cawangan/Jkr Negeri</label>
                            <div class="branch-label mb-2 mb-md-0">{{auth()->user()->detail->hasBranch->name}}</div>
                            @else
                            <select name="owner_id" class="select" id="owner_id">
                                <option value="">[Pilih Cawangan/JKR Negeri]</option>
                                @foreach ($ownerList as $owner)
                                    <option {{$owner_id == $owner['id'] ? 'selected' : ''}} value="{{$owner['id']}}">{{$owner['name']}}&nbsp;({{$owner['total']}})</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <select name="state_id" class="select" id="state_id">
                            <option value="">[Pilih Negeri]</option>
                            @foreach ($stateList as $state)
                                <option {{$state_id == $state->id ? 'selected' : ''}} value="{{$state->id}}">{{$state->name}}&nbsp;({{$state->total}})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="type_id" class="select" id="type_id">
                            <option value="">[Pilih Jenis]</option>
                            @foreach ($typeList as $type)
                                <option {{$type_id == $type->id ? 'selected' : ''}} value="{{$type->id}}">{{$type->name}}&nbsp;({{$type->total}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-4 d-flex justify-content-center justify-content-md-end ms-4 ms-md-0">
            <div class="dropdown inline float-end">
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
                        <input id="fleet_search" onkeyup="onEnterWithSearch(this)" type="text" class="form-control" placeholder="Carian" value='{{$search}}'>
                        <div class="dropdown">
                            <button class="btn filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <input type="hidden" id="schFilterValue" value="{{$xid}}"/>
                                <li><a class="dropdown-item search-filter {{$xid == 0 ? 'active' : ''}}" href="#"  onclick="setSchFilter(this)" xid="0" id="flt-all">Keseluruhan</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 1 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xid="1" id="flt-noplate">No Pendaftaran</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 2 ? 'active' : ''}}" href="#"  onclick="setSchFilter(this)" xid="2" id="flt-nojkr">No JKR</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 3 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xid="3" id="flt-lokasi">Lokasi</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 4 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xid="4" id="flt-milik">Milik</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 5 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xid="5" id="flt-jenis">Jenis</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 6 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xid="6" id="flt-negeri">Negeri</a></li>
                                <li><a class="dropdown-item search-filter {{$xid == 7 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xid="7" id="flt-cawangan">Cawangan</a></li>
                            </ul>
                        </div>
                        <div style="height:40px;max-height:50xp;background-color:#ffffff;-webkit-border-radius: 0px 8px 8px 0px;-moz-border-radius: 0px 8px 8px 0px;border-radius: 0px 8px 8px 0px;">
                            <button type="button" class="input-group-text" id='search-btn'><i class="fal fa-search fa-lg"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<div class="sect-top-dummy"></div>
<div class="main-content">
    @php
        $url = route('vehicle.list-alternate', [
            'offset' => ($offset-$limit),
            'ownership' => Request('ownership'),
            'fleet_view' => $fleet_view,
            'owner_id' => $owner_id,
            'state_id' => $state_id,
            'type_id' => $type_id,
            'owner_type_code' => $owner_type_code,
            'limit' => $limit,
            'offset' => $offset,
            'xmode' => $xmode,
        ]);
    @endphp
    @if($xmode == 'list')
        <div xmode="list">
           <div class="table-responsive">
            <table class="table-custom no-footer stripe" style="{{count($listFleets) == 1 ? 'height: calc(100vh / 2);' : ''}}">
                <thead>
                    <tr>
                        <th>Bil</th>
                        @if(auth()->user()->isAdmin() ||
                        $TaskFlowAccessVehicle->mod_fleet_verify ||
                        $TaskFlowAccessVehicle->mod_fleet_approval ||
                        $TaskFlowAccessVehicle->mod_fleet_can_edit_after_approve
                        )
                            @if(auth()->user()->isAdmin() ||
                            $TaskFlowAccessVehicle->mod_fleet_verify && in_array($fleet->vapp_status_id, [2,3]) ||
                            $TaskFlowAccessVehicle->mod_fleet_approval && in_array($fleet->vapp_status_id, [4]))
                                <th class="col-del"><input type="checkbox" value="" name="chkall" id="chkall" class="form-check-input"></th>
                            @endif
                        <th class="col-del"></th>
                        @endif
                        <th style="width:70px;text-align:left">No. Pendaftaran</th>
                        <th class="lcal-5">Kategori</th>
                        <th class="lcal-3">Milik</th>
                            @if ($fleet_view == 'public')
                                <th>Nama Projek</th>
                                <th class="lcal-3">Ketua Pasukan Projek (HOPT)</th>
                            @elseif ($fleet_view == 'disposal')
                                <th>Kaedah Lupus</th>
                                <th class="lcal-3">Penerima</th>
                                <th class="lcal-3">Tarikh Lupus</th>
                            @else
                                <th>Lokasi</th>
                                <th class="lcal-3">Usia</th>
                            @endif
                        <th class="lcal-4">Pengeluar</th>
                        <th class="lcal-4">Model</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listFleets as $index => $fleet)
                    @php
                        $fleet_view = isset($fleet->fleet_view) ? $fleet->fleet_view: $fleet_view;
                    @endphp
                    <tr>
                        <td class="row-item table-item">
                            {{$offset + ($index +1)}}
                        </td>
                        @if(auth()->user()->isAdmin() ||
                                $TaskFlowAccessVehicle->mod_fleet_verify ||
                                $TaskFlowAccessVehicle->mod_fleet_approval ||
                                $TaskFlowAccessVehicle->mod_fleet_can_edit_after_approve
                            )

                            @if(auth()->user()->isAdmin() ||
                                $TaskFlowAccessVehicle->mod_fleet_verify && in_array($fleet->vapp_status_id, [2,3]) ||
                                $TaskFlowAccessVehicle->mod_fleet_approval && in_array($fleet->vapp_status_id, [4]))
                                    <td>
                                        <input value="{{$fleet->id}}" name="chkdel" id="chkdel" class="form-check-input" type="checkbox" xvalue='{{$fleet->id}}'>
                                    </td>
                            @endif
                        <td class="p-1" style="padding-top:4px">
                            <div class='btn-group'>
                                @if(auth()->user()->isAdmin() ||
                                $TaskFlowAccessVehicle->mod_fleet_verify && in_array($fleet->vapp_status_id, [2,3]) ||
                                $TaskFlowAccessVehicle->mod_fleet_approval && in_array($fleet->vapp_status_id, [4]) ||
                                $TaskFlowAccessVehicle->mod_fleet_can_edit_after_approve ||
                                $TaskFlowAccessVehicle->mod_fleet_can_dispose_federal ||
                                $TaskFlowAccessVehicle->mod_fleet_can_dispose_state
                                )

                                @php
                                    $param  = array_merge(Request()->query(), ['id' => $fleet->id, 'fleet_view' => $fleet_view, 'search' => $search]);
                                @endphp
                                <button class='btn cux-btn' onclick="parent.openPgInFrame('{{route('vehicle.register', $param)}}')"><i class="fa fa-pencil-alt"></i> </button>
                                @endif
                                @if(auth()->user()->isAdmin())
                                <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" onclick="countRecordInProcess('{{$fleet->no_pendaftaran}}',{{$fleet->id}})"><!--<span class="visually-hidden">Toggle Dropright</span>--></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="z-index: 1000">
                                    <li style="margin-top:-8px;"><h6 class="header-highlight">{{$fleet->no_pendaftaran}}</h6></li>
                                    <li class="dropdown-item f1st-menu" onclick="openPgInFrame('{{route('vehicle.history')}}?id={{$fleet->id}}&fleet_view={{$fleet_view}}')">Rekod Peristiwa <span class="badge bg-secondary" id='totalEvents{{$fleet->id}}'>0</span></li>
                                    <li class="dropdown-item" onclick="openPgInFrame('{{route('vehicle.saman.rekod')}}?vehicle_id={{$fleet->id}}&fleet_view={{$fleet_view}}')">Rekod Saman <span class="badge bg-secondary" id='totalSummons{{$fleet->id}}'>0</span></li>
                                    <li class="dropdown-item">Rekod Penilaian <span class="badge bg-secondary" id='totalAssessments{{$fleet->id}}'>0</span></li>
                                    <li class="dropdown-item">Rekod Senggaraan <span class="badge bg-secondary" id='totalMaintenance{{$fleet->id}}'>0</span></li>
                                    <li><hr class="dropdown-divider"></li>
                                    @if($fleet->vehicle_status_code == '01')
                                        @if($fleet_view == 'department')
                                            <li class="dropdown-item" ><i class="fal fa-shield{{($fleet->disaster_ready ? '-cross':'')}}" ></i>
                                                <span id="span-siap-siaga" data-platNumber="{{$fleet->no_pendaftaran}}" onclick="promptTo{{($fleet->disaster_ready ? 'Un':'')}}DeclarePrepareForDisaster({{$fleet->id}}, this)">{{($fleet->disaster_ready ? ' Batal Isytihar Siap Siaga':' Isytihar Siap Siaga')}}</span>
                                            </li>
                                        @endif
                                    @endif
                                    @if($fleet_view == 'department')
                                        <li class="dropdown-item" id="dispose_{{$fleet->id}}" onclick="promptTo{{$fleet_view == 'disposal' ? 'Un' : ''}}Dispose({{$fleet->id}})"><i class="fal fa-{{$fleet_view == 'disposal' ? 'undo' : 'recycle'}}"></i> {{$fleet_view == 'disposal' ? 'Kembalikan' : 'Lupuskan'}}</li>
                                    @endif
                                    <li class="dropdown-item" id="change_ownership_{{$fleet->id}}" onclick="promptChangeOwnership({{$fleet->id}}, '{{$fleet_view}}')"><i class="fal fa-exchange"></i> Tukar Milik</li>
                                    <li class="dropdown-item" id="delete_{{$fleet->id}}" onclick="deleteThisItem({{$fleet->id}})" data-bs-toggle="modal" data-bs-target="#deleteVehicleModal"><i class="fal fa-trash-alt"></i> Padam</li>

                                </ul>
                                @elseif(
                                $TaskFlowAccessVehicle->mod_fleet_can_dispose_federal && ($fleet->ownership_code == '01') ||
                                $TaskFlowAccessVehicle->mod_fleet_can_dispose_state && ($fleet->ownership_code == '02')
                                )
                                <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" onclick="countRecordInProcess('{{$fleet->no_pendaftaran}}',{{$fleet->id}})"></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="z-index: 1000">
                                    <li style="margin-top:-8px;"><h6 class="header-highlight">{{$fleet->no_pendaftaran}}</h6></li>
                                    <li class="dropdown-item" id="dispose_{{$fleet->id}}" onclick="promptTo{{$fleet_view == 'disposal' ? 'Un' : ''}}Dispose({{$fleet->id}})"><i class="fal fa-{{$fleet_view == 'disposal' ? 'undo' : 'recycle'}}"></i> {{$fleet_view == 'disposal' ? 'Kembalikan' : 'Lupuskan'}}</li>

                                    @if(Auth::user()->isVehicleOfficer())
                                        @if($fleet->vehicle_status_code == '01')
                                            @if($fleet_view == 'department')
                                                <li class="dropdown-item" ><i class="fal fa-shield{{($fleet->disaster_ready ? '-cross':'')}}" ></i>
                                                    <span id="span-siap-siaga" data-platNumber="{{$fleet->no_pendaftaran}}" onclick="promptTo{{($fleet->disaster_ready ? 'Un':'')}}DeclarePrepareForDisaster({{$fleet->id}}, this)">{{($fleet->disaster_ready ? ' Batal Isytihar Siap Siaga':' Isytihar Siap Siaga')}}</span>
                                                </li>
                                            @endif
                                        @endif
                                    @endif

                                </ul>
                                @endif
                            </div>
                        </td>
                        @endif
                        <td class="text-start" style="padding-left:10px;text-align: left !important;"><a onclick="parent.openPgInFrame('{{route('vehicle.onepagedetail', ['id' => $fleet->id, 'fleet_view' => $fleet_view,  'view_as' => 'full_detail'])}}')">{{$fleet->no_pendaftaran}}</a></td>
                        <td class="text-uppercase">{{$fleet->category_name}}</td>
                        <td class="text-uppercase">{{$fleet->ownership}}</td>
                            @if ($fleet_view == 'public')
                                <td class="text-uppercase">{{$fleet->project_name}}</td>
                                <td class="text-uppercase">{{$fleet->hopt}}</td>
                            @elseif ($fleet_view == 'disposal')
                                <td class="text-uppercase">{{$fleet->disposal_name}}</td>
                                <td class="text-uppercase">{{$fleet->recipient}}</td>
                                <td class="text-uppercase">{{$fleet->dispose_dt ? Carbon\Carbon::parse($fleet->dispose_dt)->format('d M Y') : '-'}}</td>
                            @else
                                <td class="text-uppercase">{{$fleet->placement_name}}</td>
                                <td class="text-uppercase">{{$fleet->age}}</td>
                            @endif
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
            </table>
           </div>
        </div>
        @if($total_fleet > 0)
            <div class='row' style='margin-top:10px;margin-bottom:10px;'>
                @php
                    $totalPage = round($total_fleet / $limit);

                    if(($totalPage * $limit) >= $total_fleet){
                        $totalPage = $totalPage - 1;
                    }
                @endphp
                <div class='col-md-6'>
                    <div class='btn-group'>
                        <button class="btn cux-btn text-decoration-none cursor-pointer" @if($page == 0) disabled @endif onclick="openPgInFrame('{{$url}}&page=0')"><i class="fas fa-fast-backward"></i></button>
                        <button class="btn cux-btn text-white text-decoration-none cursor-pointer" @if($page == 0) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$page > 0 ? $page - 1: 0}}')"><i class="fas fa-step-backward"></i></button>
                        <button class="btn cux-btn text-white text-white text-decoration-none cursor-pointer" @if($page == $totalPage) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$page + 1}}')" ><i class="fas fa-step-forward"></i></button>
                        <button class="btn cux-btn text-white text-decoration-none cursor-pointer" @if($page == $totalPage) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$totalPage}}')"><i class="fas fa-fast-forward"></i></button>
                    </div>
                    {{$offset + 1}} - {{$offset + $index + 1}} of {{$total_fleet}}
                </div>
            </div>
        @endif
    @elseif($xmode == 'catelog')
        <div xmode="catelog" class="catalogue">
            <div class="row">
                {{--<div class="d-flex justify-content-end pe-0">
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="search" id="searching" onkeyup="searching(this)" class="form-control spec-sch mt-0" placeholder="Cari Kenderaan" value="{{$search}}">
                            <span for="searching" xaction="search" class="input-group-text cux-btn" id="basic-addon2" style="height:38px;"><i class="fal fa-search fa-lg"></i></span>
                        </div>
                    </div>
                </div> --}}
                <br>
            </div>
            @foreach ($listFleets as $index => $vehicle)
            {{-- @json($vehicle) --}}
                @php
                    $publicPath = "";
                    if($vehicle->thumb_url){
                        $publicPath = '/'.$vehicle->thumb_url.'/'.$vehicle->doc_name;
                    }
                @endphp
                <div class="row box-catalogue">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="position: relative">
                        <div class="row">
                            <div class="col" style="position:relative;max-width:143px;width:143px;">
                                @if(empty($publicPath))
                                    <div class="box-left" style="background-image: url('{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}');">&nbsp;</div>
                                @else
                                    <div class="box-left" data-bs-toggle="modal"  data-bs-target="#vehicleImagesModal" onclick="loadVehicleImages({{$vehicle->id}})" style="background-image: url('{{!empty($publicPath) ? $publicPath : asset('my-assets/fleet-img/no-image-min.png') }}');">&nbsp;</div>
                                @endif
                            </div>
                            <div class="col box-right">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">
                                        <a onclick="parent.openPgInFrame('{{route('vehicle.onepagedetail', ['id' => $vehicle->id, 'fleet_view' => $fleet_view,  'view_as' => 'full_detail'])}}')" class="no-plet">{{$vehicle->no_pendaftaran}}</a>
                                    </div>
                                    {{-- <div class="col-1">
                                        <div class="btn-group dropend">
                                            <button type="button" class="btn cux-btn" onClick="javascript:openPgInFrame('{{ route('vehicle.register',  ['id' => $vehicle->id, 'fleet_view' => $fleet_view ]) }}')"><i class="fa fa-pencil-alt"></i></button>
                                            <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"><span class="visually-hidden">Toggle Dropright</span></button>
                                                <span class="visually-hidden">Toggle Dropright</span></button>
                                                <ul class="dropdown-menu">
                                                    <li style="margin-top:-8px;"><h6 class="header-highlight">{{$vehicle->no_pendaftaran}}</h6></li>
                                                    <li class="f1st-menu"><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.history', ['id' => $vehicle->id, 'fleet_view' => $fleet_view ])}}')">Rekod Peristiwa <span class="badge bg-secondary"></span></a></li>
                                                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.saman.rekod', [ 'vehicle_id' => $vehicle->id])}}')">Rekod Saman <span class="badge bg-secondary"></span></a></li>
                                                    <li><a class="dropdown-item" href="#">Rekod Penilaian <span class="badge bg-secondary">0</span></a></li>
                                                    <li><a class="dropdown-item" href="#">Rekod Senggaraan <span class="badge bg-secondary">0</span></a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    @if($fleet_view == 'department')
                                                        <li>
                                                            @if($vehicle->disaster_ready)
                                                            <a class="dropdown-item" data-platNumber="{{$vehicle->no_pendaftaran}}" onclick="promptToUnDeclarePrepareForDisaster({{$vehicle->id}}, this)"><i class="fal fa-shield-cross" style="width:20px"></i> Batal Istihar Siap Siaga</a>
                                                            @else
                                                            <a class="dropdown-item" data-platNumber="{{$vehicle->no_pendaftaran}}" onclick="promptToDeclarePrepareForDisaster({{$vehicle->id}}, this)"><i class="fal fa-shield" style="width:20px"></i> Istihar Siap Siaga Bencana</a>
                                                            @endif
                                                        </li>
                                                    @endif
                                                    <li><a class="dropdown-item" onclick="promptTo{{$fleet_view == 'disposal' ? 'Un' : ''}}Dispose('{{$vehicle->id}}')" ><i class="fal fa-{{$fleet_view == 'disposal' ? 'undo' : 'recycle'}}" style="width:20px"></i> {{$fleet_view == 'disposal' ? 'Kembalikan' : 'Lupuskan'}}</a></li>
                                                @if( Auth::user()->isAdmin())
                                                    <li><a class="dropdown-item" onclick="promptChangeOwnership('{{$vehicle->id}}','{{$fleet_view}}}')"><i class="fal fa-exchange" style="width:20px"></i> Tukar Milik</a></li>
                                                    @if ($AccessVehicle->mod_fleet_u == 1)
                                                        <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('vehicle.register.detail', [ 'id' => $vehicle->id, 'fleet_view' => $fleet_view ])}}')"><i class="fa fa-pencil-alt" style="width:20px"></i> Ubah</a></li>
                                                    @endif
                                                @endif
                                                    @if($fleet_view !== 'disposal')
                                                    <li><a class="dropdown-item" data-bs-toggle="modal" onclick="deleteThisItem({{$vehicle->id}})"  data-bs-target="#deleteVehicleModal"><i class="fal fa-trash-alt" style="width:20px"></i> Padam</a></li>
                                                    @endif
                                                </ul>
                                        </div>
                                    </div> --}}
                                    <div class="col-1 pt-2">
                                        <div class='btn-group'>
                                            <button class='btn cux-btn bigger' onclick="parent.openPgInFrame('{{route('vehicle.register')}}/{{$vehicle->id}}?fleet_view={{$fleet_view}}')"><i class="fa fa-pencil-alt"></i></button>
                                            <button type="button" class="btn cux-btn bigger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" onclick="countRecordInProcess('{{$vehicle->no_pendaftaran}}',{{$vehicle->id}})"><!--<span class="visually-hidden">Toggle Dropright</span>--></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="z-index: 1000">
                                                <li style="margin-top:-8px;"><h6 class="header-highlight">{{$vehicle->no_pendaftaran}}</h6></li>
                                                <li class="dropdown-item f1st-menu" onclick="openPgInFrame('{{route('vehicle.history')}}?id={{$vehicle->id}}&fleet_view={{$fleet_view}}')">Rekod Peristiwa <span class="badge bg-secondary" id='totalEvents{{$vehicle->id}}'>0</span></li>
                                                <li class="dropdown-item" onclick="openPgInFrame('{{route('vehicle.saman.rekod')}}?vehicle_id={{$vehicle->id}}&fleet_view={{$fleet_view}}')">Rekod Saman <span class="badge bg-secondary" id='totalSummons{{$vehicle->id}}'>0</span></li>
                                                <li class="dropdown-item">Rekod Penilaian <span class="badge bg-secondary" id='totalAssessments{{$vehicle->id}}'>0</span></li>
                                                <li class="dropdown-item">Rekod Senggaraan <span class="badge bg-secondary" id='totalMaintenance{{$vehicle->id}}'>0</span></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li class="dropdown-item" ><i class="fal fa-shield{{($vehicle->disaster_ready ? '-cross':'')}}" ></i>
                                                    <span id="span-siap-siaga" data-platNumber="{{$vehicle->no_pendaftaran}}" onclick="promptTo{{($vehicle->disaster_ready ? 'Un':'')}}DeclarePrepareForDisaster({{$vehicle->id}}, this)">{{($vehicle->disaster_ready ? ' Batal Isytihar Siap Siaga':' Isytihar Siap Siaga')}}</span>
                                                </li>
                                                <li class="dropdown-item" id="dispose_{{$vehicle->id}}" onclick="promptTo{{$fleet_view == 'disposal' ? 'un' : ''}}Dispose({{$vehicle->id}})"><i class="fal fa-{{$fleet_view == 'disposal' ? 'undo' : 'recycle'}}"></i> {{$fleet_view == 'disposal' ? 'Kembalikan' : 'Lupuskan'}}</li>
                                                <li class="dropdown-item" id="change_ownership_{{$vehicle->id}}" onclick="promptChangeOwnership({{$vehicle->id}}, '{{$fleet_view}}')"><i class="fal fa-exchange"></i> Tukar Milik</li>
                                                <li class="dropdown-item" id="delete_{{$vehicle->id}}" onclick="deleteThisItem({{$vehicle->id}})" data-bs-toggle="modal" data-bs-target="#deleteVehicleModal"><i class="fal fa-trash-alt"></i> Padam</li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-3">
                                        <div class="subject">Milik</div>
                                        {{-- <div class="details">{{!empty($vehicle->acqDt) ? \carbon\Carbon::parse($vehicle->acqDt)->format('Y') : '-'}}</div> --}}
                                        <div class="details">{{$vehicle->ownership}}</div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-3">
                                        <div class="subject">Usia</div>
                                        {{-- <div class="details">{{\Carbon\Carbon::parse($vehicle->acqDt)->diff(\Carbon\Carbon::now())->format('%y tahun');}}</div> --}}
                                        <div class="details">{{$vehicle->age}} tahun</div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-0 col-6 data-extra">
                                        <div class="subject">Model</div>
                                        {{-- <div class="details">{{$vehicle->engine_no}}</div> --}}
                                        <div class="details">{{$vehicle->model_name}}</div>
                                    </div>
                                </div>
                                <div class="row line-t">
                                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 col-6">
                                        <div class="kategori">{{$vehicle->category_name}}</div>
                                        <div class="lokasi">{{$vehicle->placement_name}}</div>
                                    </div>
                                    <div class="col-1">
                                        <div class="subject"></div>
                                        <div class="details"></div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 pt-1">
                                        <div class="subject">Pengeluar</div>
                                        <div class="details">{{$vehicle->brand_name}}</div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 pt-1">
                                        <div class="subject">No Enjin</div>
                                        <div class="details">{{$vehicle->no_engine}}</div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-0 col-6 data-extra pt-1">
                                        <div class="subject">No Casis</div>
                                        <div class="details">{{$vehicle->no_chasis}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($total_fleet > 0)
                <div class='row' style='margin-top:10px;margin-bottom:10px;'>
                    @php
                        $totalPage = round($total_fleet / $limit);
                    @endphp
                    <div class='col-md-6'>
                        <div class='btn-group'>
                            <button class="btn cux-btn text-decoration-none cursor-pointer" @if($page == 0) disabled @endif onclick="openPgInFrame('{{$url}}&page=0')"><i class="fas fa-fast-backward"></i></button>
                            <button class="btn cux-btn text-white text-decoration-none cursor-pointer" @if($page == 0) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$page > 0 ? $page - 1: 0}}')"><i class="fas fa-step-backward"></i></button>
                            <button class="btn cux-btn text-white text-white text-decoration-none cursor-pointer" @if($page == $totalPage) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$page + 1}}')" ><i class="fas fa-step-forward"></i></button>
                            <button class="btn cux-btn text-white text-decoration-none cursor-pointer" @if($page == $totalPage) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$totalPage}}')"><i class="fas fa-fast-forward"></i></button>
                        </div>
                        {{$offset + 1}} - {{$offset + $index + 1}} of {{$total_fleet}}
                    </div>
                </div>
            @endif
        </div>
    @else
    @endif
<div class="modal fade modal-dialog-scrollable" id="vehicleImagesModal" tabindex="-1" aria-labelledby="vehicleImagesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="position: relative;height:100%;">
            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:15px;top:15px;z-index:10"></button>
            <div class="modal-body" id="vehicle-images" style="height: 400px;"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteVehicleModalLabel" aria-hidden="true" style="margin-top:15vh;background-color:rgba(248, 8, 8, 0.295)">
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
            <div class="modal-footer float-start">
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
            <div class="modal-footer float-start">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
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
                <div class="modal-footer float-start">
                    <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                    <button class="btn btn-module" type="submit" xaction="dispose" >Ya</button>
                    <span class="btn btn-link" xaction="no" data-bs-dismiss="modal">Batal</span>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="undisposeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="undisposeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:15vh;">
        <div class="modal-content">
            <form id="frmUnDisposalModal" method="POST">
                @csrf
                <input type="hidden" name="vehicle_id" id="vehicle_id" value="">
                <div class="modal-head mytitle" style="padding-left:13px;">
                    Kembalikan daripada Pelupusan ?
                </div>
                <div class="modal-body" id="prompt-container">
                    <div id="response" style="display: none" class="text-center">
                        <br/>
                        <div ><span class="text text-success" id="msg"></span></div>
                    </div>
                </div>
                <div class="modal-footer float-start">
                    <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
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
            <div class="modal-footer float-start">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
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
            <div class="modal-footer float-start">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('vehicle.list-alternate', ['ownership' => $ownership, 'fleet_view' =>  $fleet_view])}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
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

    function downloadExcel(view){

        parent.$('#loading div').append('<h3 class="text-white" id="generate_report">&nbsp;Jana Laporan Kenderaan...</h3>');
        parent.startLoading();

        $.ajax({
            url:"{{route('jasperReport')}}",
            data: {
                'title': "Senarai Kenderaan JKR "+moment().format('D.M.YYYY'),
                'report_name': "vehicle_list",
                'report_type': "excel",
                'fleet_view': "{{$fleet_view}}",
                'owner_id': '{{$owner_id}}',
                'state_id': '{{$state_id}}',
                'type_id': '{{$type_id}}',
                'status': '{{$status}}',
                'mode': 'query',
                'xmode': '{{$xmode}}',
                'view': view,
                'search': '{{$search}}',
                'xid': '{{$xid}}',
                'owner_type_code': '{{$owner_type_code}}',
            },
            cache:false,
            xhrFields:{
                responseType: 'blob'
            },
            success: function(result, status, xhr){
                var disposition = xhr.getResponseHeader('content-disposition');
                var matches = /"([^"]*)"/.exec(disposition);
                let fleet_view = null;

                @if ($fleet_view == 'department')
                    fleet_view = 'JKR';
                @elseif ($fleet_view == 'public')
                    fleet_view = 'JKR'
                @else
                    fleet_view = 'JKR'
                @endif

                var filename = (matches != null && matches[1] ? matches[1] : 'Senarai Kenderaan JKR '+moment().format('y-m-d h-m-s')+'.xlsx');
                console.log('filename => ', filename);
                console.log('disposition => ', disposition);
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
                parent.stopLoading();
                parent.$('#generate_report').remove();
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

    function promptToUnDispose(vehicle_id){
        let triggerMD = $('#undisposeModal');
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
                hide('[xaction="dispose"]');
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

    function submitToUnDispose(formData){
        // hide('[xaction="dispose"]');

        $.ajax({
            url: "{{route('vehicle.undispose.save')}}",
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
                hide('[xaction="dispose"]');
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
        console.log("here declare");
        let triggerMD = $('#DeclarePrepareForDisasterModal');
        let platNumber = $(self).attr('data-platNumber');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.find('#target-siap-siaga').text(platNumber);
        triggerMD.modal('show');
    }

    function promptToUnDeclarePrepareForDisaster(vehicle_id, self){
        console.log("here undeclare");
        let triggerMD = $('#UnDeclarePrepareForDisasterModal');
        let platNumber = $(self).attr('data-platNumber');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.find('#target-siap-siaga').text(platNumber);
        triggerMD.modal('show');
    }

    function onEnterWithSearch(self){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        var fleetSearch = self.value;
        if(keycode ==  13 || !fleetSearch){
            var totalListPerPage = $('#total_list_per_page').val();
            var xid = $('#schFilterValue').val();
            var xmode = '{{$xmode}}';
            var ownership = '{{$ownership}}';
            var fleet_view = '{{$fleet_view}}';
            var status = '{{$status}}';
            var owner_id = '{{$owner_id}}';
            var state_id = '{{$state_id}}';
            var type_id = '{{$type_id}}';
            parent.openPgInFrame('{{route('vehicle.list-alternate')}}?xmode='+xmode+'&ownership='+ownership+'&fleet_view='+fleet_view+'&limit='+totalListPerPage+'&search='+fleetSearch+'&xid='+xid+'&status='+status+'&owner_id='+owner_id+'&state_id='+state_id+'&type_id='+type_id);

        }
    }

    $(document).ready(function() {

        let owner_id = $('#owner_id').val();
        let state_id = $('#state_id').val();
        let type_id = $('#type_id').val();
        let xmode = '{{$xmode}}';
        let limit = '{{$limit}}';

        $('#owner_id').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            state_id = '';
            type_id = '';
            let url = '{{route('vehicle.list-alternate')}}?owner_id='+this.value+'&state_id='+state_id+'&type_id='+type_id+'&xmode='+xmode+'&limit='+limit+'&owner_type_code={{$owner_type_code}}';
            parent.openPgInFrame(url);
        });

        $('#state_id').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            type_id = '';
            let url = '{{route('vehicle.list-alternate')}}?owner_id='+owner_id+'&state_id='+this.value+'&type_id='+type_id+'&xmode='+xmode+'&limit='+limit+'&owner_type_code={{$owner_type_code}}';
            parent.openPgInFrame(url);
        });

        $('#type_id').select2({
            width: '100%',
            theme: "classic"
        }).on('change', function(e){
            let url = '{{route('vehicle.list-alternate')}}?owner_id='+owner_id+'&state_id='+state_id+'&type_id='+this.value+'&xmode='+xmode+'&limit='+limit+'&owner_type_code={{$owner_type_code}}';
            parent.openPgInFrame(url);
        });

        $('#total_list_per_page').select2({
            width: '100%',
            theme: "classic"
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

                var arrayFleetId = [];
                $('[name="chkdel"]:checked').each(function() {
                    arrayFleetId.push($(this).attr('xvalue'));
                });

                if(vehicle_ids.length > 0){
                    arrayFleetId = vehicle_ids;
                }

                $.post('{{route('vehicle.delete')}}', {
                    'vehicle_ids': arrayFleetId,
                    'remark': remark,
                    'fleet_view': '{{$fleet_view}}',
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#deleteVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihapuskan');
                    show('[xaction="close"]');
                    //$('#deleteVehicleModal').modal('hide');
                    vehicle_ids = [];
                });

                $('[xaction="close"]').on('click', function(){
                    window.location.reload();
                })
            }
        });

        $('#total_list_per_page').change(function(){
            var totalListPerPage = $(this).val();
            var fleetSearch = $('#fleet_search').val();
            parent.openPgInFrame('{{route('vehicle.list-alternate')}}?limit='+totalListPerPage+'&search='+fleetSearch+'&xmode='+xmode);

        });

        $('#search-btn').click(function(){
            var totalListPerPage = $('#total_list_per_page').val();
            var fleetSearch = $('#fleet_search').val();
            var xid = $('#schFilterValue').val();
            var xmode = '{{$xmode}}';
            var status = '{{$status}}';
            parent.openPgInFrame('{{route('vehicle.list-alternate')}}?xmode='+xmode+'&limit='+totalListPerPage+'&search='+fleetSearch+'&xid='+xid+'&status='+status);

        });

        $('[xaction="verify"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="verify"]');
            hide('[xaction="no"]');

            $('[name="chkdel"]:checked').map(function () {
                vehicle_ids.push(parseInt(this.value));
            } );

            $.post('{{route('vehicle.approval')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#verifyVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('[xaction="approve"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="approve"]');
            hide('[xaction="no"]');

            $('[name="chkdel"]:checked').map(function () {
                vehicle_ids.push(parseInt(this.value));
            } );

            $.post('{{route('vehicle.approve')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#approvalVehicleModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
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

        $('#frmUnDisposalModal').on('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            submitToUnDispose(formData);
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
        $(window).scroll(function() {
            var height = $(window).scrollTop();

            if(height  > 100) {
                // do something
                $('.sect-top').addClass('shadow-top');
            }else{
                $('.sect-top').removeClass('shadow-top');
            }
        });
    })
</script>
</body>
</html>
