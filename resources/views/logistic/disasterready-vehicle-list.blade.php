@php
//    $AccessVehicle = auth()->user()->vehicle('04', '02');
//    $TaskFlowAccessDisasterReady = auth()->user()->vehicleWorkFlow('04', '02');

//    use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyVehicleDAO;
//    $DisasterReadyVehicleDAO = new DisasterReadyVehicleDAO();
//    $DisasterReadyVehicleDAO->mount();
//    $disasterready_vehicle_list = $DisasterReadyVehicleDAO->disasterready_vehicle_list;
//    $fleet_view = 'department';
$filterOpt = Request('filterOpt') ? Request('filterOpt') : 'flt-all';
$search = Request('search') ? Request('search') : null;
$page = Request('page') ? Request('page') : 1;
$limit = Request('limit') ? Request('limit') : 10;
$offset = ($page - 1)*$limit;
@endphp
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

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<link href="{{asset('my-assets/plugins/datatables/datatables.css')}}" rel="stylesheet" type="text/css">

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">

    .sect-top {
        position: fixed;
        left:0px;
        width:100%;
        z-index:4;
        padding-left:28px;
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
    .cursor-pointer {
        cursor: pointer;
    }
    table.dataTable tbody tr td.combine {
        padding-top: 4px;
        width:30px;
        text-align: center;
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

    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }

    .main-content table thead tr th {
        text-transform: uppercase;
    }
    td.dt-center { text-align: center; }
    .dropdown-item {
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
        border-radius: 4px 4px 6px 6px;
        -moz-border-radius: 4px 4px 6px 6px;
        -webkit-border-radius:  4px 4px 6px 6px;
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
    .details {
        font-family: mark;
        font-size:14px;
        line-height:14px;
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
    .table-custom thead th.special {
        background-color:#ffffff;
    }
    .table-custom tbody tr td.special {
        background-color:#ffffff;
    }
    .table-custom tfoot th.special {
        background-color:#ffffff;
    }

    .form-control.search {
        -webkit-border-radius: 8px 0px 0px 8px;
        -moz-border-radius: 8px 0px 0px 8px;
        border-radius: 8px 0px 0px 8px;
        height: 42px !important;
        margin-top:0px;
        border-color:#dcdcd8;
    }

    .input-group-text {
        border-width: 1px;
        margin-left: 0px !important;
    }

    .filter-btn {
        border-radius: 0;
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
        border-bottom-width:1px;
        border-bottom-style:solid;
        border-top-color:#dcdcd8;
        border-top-width:1px;
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
    @media print {
        nav * {
            display: none !important;
        }
        .sect-top {
            display: none !important;
        }
        .sect-top-dummy {
            display: none !important;
        }
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
<div class="mytitle">Senarai Kenderaan <span>Siap Siaga Bencana</span></div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Logistik</a></li>
      <li class="breadcrumb-item active" aria-current="page">Rekod Kenderaan Siap Siaga Bencana</li>
    </ol>
</nav>
<input type="hidden" name="filter-opt" id="filter-opt" value="{{$filterOpt}}">
<div class="main-content">
    <div class="btn-group">
        <a class="btn cux-btn bigger spakat-tip" href="{{route('report.report.disaster_ready.export.excel', [ 'view' => 'logistic_vehicle_disaster_ready_by_state', 'filterOpt' => $filterOpt, 'search' => $search])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel"></i> &nbsp;Muat Turun Data</a>
        <a class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</a>
    </div>
    <div class="dropdown inline float-end">
        <div class="input-group">
            @php
                $mapPlaceholder = [
                    'flt-all' => 'Semua',
                    'flt-plateno' => 'No Pendaftaran',
                    'flt-negeri' => 'Negeri',
                    'flt-jenis' => 'Jenis'
                ]
            @endphp
            <input type="search" id="searching" onkeyup="searching(this.value)" class="form-control search" placeholder="{{$mapPlaceholder[$filterOpt]}}" value="{{$search}}">
            <div class="dropdown">
                <button class="btn filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <input type="hidden" id="schFilterValue" value="0"/>
                    <li><a class="dropdown-item search-filter {{$filterOpt=='flt-all' ? 'active':''}}" onclick="setSchFilter(this)" xid="0" id="flt-all">Semua</a></li>
                    <li><a class="dropdown-item search-filter {{$filterOpt=='flt-plateno' ? 'active':''}}" onclick="setSchFilter(this)" xid="3" id="flt-plateno">No Pedaftaran</a></li>
                    <li><a class="dropdown-item search-filter {{$filterOpt=='flt-negeri' ? 'active':''}}" onclick="setSchFilter(this)" xid="1" id="flt-negeri">Negeri</a></li>
                    <li><a class="dropdown-item search-filter {{$filterOpt=='flt-jenis' ? 'active':''}}" onclick="setSchFilter(this)" xid="2" id="flt-jenis">Jenis</a></li>
                </ul>
            </div>
            <button onclick="searching(this.value, 'click')" class="input-group-text"><i class="fa fa-search"></i></button>
          </div><!--<i class="fas fa-search" style="line-height:20px"></i>-->
    </div>
    <br><br>
    <div class="row">
        <div class="table-responsive pt-0">
            <table id="fleet-ls" class="table-custom mt-0 no-footer stripe" style="height:{{count($disasterready_vehicle_list) == 1 ? '200px;' : ''}}100%;">
                <thead>
                    <tr>
                        @if(Auth::user()->isAdmin() || Auth::user()->isVehicleOfficer())
                        <th></th>
                        @endif
                        <th>Bil</th>
                        <th>CKMN</th>
                        <th style="width:70px;text-align:left">No. Pendaftaran</th>
                        <th>Hak Milik</th>
                        <th>Jenis</th>
                        <th>Pembuat</th>
                        <th>Model</th>
                        {{-- <th>Kategori</th>
                        <th>Sub-Kategori</th>
                        <th>Jenis</th>
                        <th class="lcal-3">Milik</th>
                        <th>Lokasi</th>
                        <th>Negeri</th>
                        <th class="lcal-2">Usia</th>
                        <th class="lcal-4">Pengeluar</th>
                        <th class="lcal-4">Model</th> --}}
                    </tr>
                </thead>
                <tbody id="sortable">
                    @foreach ($disasterready_vehicle_list as $index => $disasterready_vehicle)
                        <tr>
                            @if(Auth::user()->isAdmin() || Auth::user()->isVehicleOfficer())
                            <td class="p-1" style="padding-top:4px">
                                <div class='btn-group'>
                                    <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" ><!--<span class="visually-hidden">Toggle Dropright</span>--></button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="z-index: 1000">
                                        <li style="margin-top:-8px;"><h6 class="header-highlight">{{$disasterready_vehicle->no_pendaftaran}}</h6></li>
                                        <li class="dropdown-item" data-platNumber="{{$disasterready_vehicle->no_pendaftaran}}" onclick="promptTo{{($disasterready_vehicle->disaster_ready ? 'Un':'')}}DeclarePrepareForDisaster({{$disasterready_vehicle->id}}, this)" ><i class="fal fa-shield{{($disasterready_vehicle->disaster_ready ? '-cross':'')}}" ></i>
                                            <span id="span-siap-siaga">{{($disasterready_vehicle->disaster_ready ? ' Batal Isytihar Siap Siaga':' Isytihar Siap Siaga')}}</span>
                                        </li>
    
                                    </ul>
                                </div>
                            </td>
                            @endif
                            <td>{{($index + 1) + $offset}}</td>
                            <td>{{$disasterready_vehicle->hasState ? $disasterready_vehicle->hasState->desc : '-'}}</td>
                            <td style="padding-left:10px;text-align: left !important;">
                                <a onclick="parent.openPgInFrame('{{route('vehicle.onepagedetail', ['id' => $disasterready_vehicle->id, 'src' => 'disaster', 'fleet_view' => 'department', 'view_as' => 'full_detail'])}}')">{{$disasterready_vehicle->no_pendaftaran}}</a>
                            </td>
                            <td>{{$disasterready_vehicle->hasOwnerType->desc_bm}}</td>
                            <td>{{$disasterready_vehicle->hasSubCategoryType() ?
                                    $disasterready_vehicle->hasSubCategoryType()->hasSubCategory->hasCategory->name 
                                    .' / '.
                                    $disasterready_vehicle->hasSubCategoryType()->hasSubCategory->name 
                                    .' / '.
                                    $disasterready_vehicle->hasSubCategoryType()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasBrand() ? $disasterready_vehicle->hasBrand()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasVehicleModel() ? $disasterready_vehicle->hasVehicleModel()->name : '-'}}</td>
                            {{-- <td class="text-uppercase">{{$disasterready_vehicle->hasCategory()->name}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasSubCategory() ? $disasterready_vehicle->hasSubCategory()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasSubCategoryType() ?$disasterready_vehicle->hasSubCategoryType()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasOwnerType->desc_bm}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasPlacement() ? $disasterready_vehicle->hasPlacement()->desc : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasPlacement() ? $disasterready_vehicle->hasPlacement()->hasState->desc : '-'}}</td>
                            <td class="text-uppercase text-center">{{$disasterready_vehicle->manufacture_year ? (\Carbon\Carbon::now()->format('Y') - $disasterready_vehicle->manufacture_year): '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasBrand() ? $disasterready_vehicle->hasBrand()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasVehicleModel() ? $disasterready_vehicle->hasVehicleModel()->name : '-'}}</td> --}}

                        </tr>
                    @endforeach
                    @if (count($disasterready_vehicle_list) == 0)
                    <tr class="no-record">
                        <td colspan="10" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
                <div class="txt-memo">
                    Membatalkan <span id="target-siap-siaga">WPL2172</span> dari<br/>kenderaan siap siaga bencana?
                    <br/><br/>
                    <div class="confirm">Pastikan no pendaftaran adalah betul.</div>
                </div>
            </div>
            <div class="modal-footer float-start">
                <span class="btn btn-module" xaction="close" onclick="parent.openPgInFrame('{{route('logistic.disasterready.vehicle.list')}}')" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="undeclare_ready_disaster" >Ya</span>
                <span class="btn btn-reset" xaction="no" data-bs-dismiss="modal">Batal</span>
            </div>
        </div>
    </div>
</div>

{{$disasterready_vehicle_list->links('pagination.default', [ 'limit' => $limit])}}
<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var ids = [];
    var selfDataTable;
    let fleet_view = 'department';

    function searching(value, trigger){
        let filterOpt = $('#filter-opt').val();
        let keycode = (event.keyCode ? event.keyCode : event.which);
        let searching = $('#searching').val();
        if((searching && trigger == 'click')){
            window.location.href = "{{route('logistic.disasterready.vehicle.list')}}?search="+searching+"&filterOpt="+filterOpt;
        } else {
            if(keycode ==  13 || !value){
                window.location.href = "{{route('logistic.disasterready.vehicle.list')}}?search="+value+"&filterOpt="+filterOpt;
            }
        }
    }

    function setSchFilter(obj) {
        var objid = $(obj).attr('id');
        $('.search-filter').removeClass('active');
        $('#' + objid).addClass('active');

        $('#filter-opt').val(objid);
        var xid = $(obj).attr('xid');
        $('#schFilterValue').val(xid);
        $('#searching').attr('placeholder',$(obj).html());
    }

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

    function promptToUnDeclarePrepareForDisaster(vehicle_id, self){
        let triggerMD = $('#UnDeclarePrepareForDisasterModal');
        let platNumber = $(self).attr('data-platNumber');
        triggerMD.find('#vehicle_id').val(vehicle_id);
        triggerMD.find('#target-siap-siaga').text(platNumber);
        triggerMD.modal('show');
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

    jQuery(document).ready(function() {

        $('select').select2({
			width: '60px',
			theme: "classic",
			minimumResultsForSearch: -1
        });

        $('#chkall').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));

            var rows = $('[name="chkdel"]:checked').map(function () {
            return this.value;
            } );

            if(rows.length > 0){
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

            hide('[xaction="delete"]');
            hide('[xaction="no"]');

            $('[name="chkdel"]:checked').map(function () {
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.disasterready.delete')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#deleteDisasterReadyModal .modal-body').text('Maklumat kenderaan berjaya dihapuskan');
                show('[xaction="close"]');
                //$('#deleteDisasterReadyModal').modal('hide');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('[xaction="verify"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="verify"]');
            hide('[xaction="no"]');

           $('[name="chkdel"]:checked').map(function () {
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.disasterready.approval')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#verifyDisasterReadyModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
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
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.disasterready.approve')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#approvalDisasterReadyModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('[xaction="undeclare_ready_disaster"]').on('click', function(e){
            e.preventDefault();
            let vehicle_id = $('#UnDeclarePrepareForDisasterModal #vehicle_id').val();
            submitToUnDeclareForDisasterReady(vehicle_id);
        });

    });
</script>
</body>
</html>


