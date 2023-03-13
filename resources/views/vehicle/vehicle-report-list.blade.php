{{-- @php
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
    $xid = Request('xid') ? Request('xid') : 0;
    $optdesc = 'Semua';
    if($xid == 1){
        $optdesc = 'No Pendaftaran';
    }else if($xid == 2){
        $optdesc = 'No JKR';
    }else if($xid == 3){
        $optdesc = 'Lokasi';
    }else if($xid == 4){
        $optdesc = 'Milik';
    }else if($xid == 5){
        $optdesc = 'Jenis';
    }else if($xid == 6){
        $optdesc = 'Pengeluar';
    }

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
@endif --}}
@php
    $status = Request('status') ? Request('status') : null;
    $ownership = Request('ownership') ?  Request('ownership') : 'jkr';
    $search = Request('search') ?  Request('search') : null;
    $fleet_view = Request('fleet_view') ?  Request('fleet_view') : 'department';
    if($fleet_view == 'department'){
        $title_span = 'Milik JKR';
    }elseif($fleet_view == 'public'){
        $title_span = 'Awam / Projek';
    }else{
        $title_span = 'Lupus';
    }
    $xmode = Request('xmode') ? Request('xmode') : 'list';
    $xid = Request('xid') ? Request('xid') : 0;
    $limit = Request('limit') ? Request('limit') : 5;
    $optdesc = 'Semua';
    if($xid == 1){
        $optdesc = 'No Pendaftaran';
    }else if($xid == 2){
        $optdesc = 'No JKR';
    }else if($xid == 3){
        $optdesc = 'Lokasi';
    }else if($xid == 4){
        $optdesc = 'Milik';
    }else if($xid == 5){
        $optdesc = 'Jenis';
    }else if($xid == 6){
        $optdesc = 'Pengeluar';
    }else if($xid == 7){
        $optdesc = 'Negeri';
    }else if($xid == 8){
        $optdesc = 'Cawangan';
    }
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
{{-- <link href="{{ asset('my-assets/css/datareport.css') }}" rel="stylesheet" type="text/css"> --}}
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
    .content {
        /* padding-left:0px !important; */
        /* padding-right:0px !important; */
    }
    .main-content {
        padding-top:20px;
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
        width:auto;
        text-align: center;
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
        padding-left:10px;
        padding-right:10px;
    }
    .filter-btn span {
        font-family: helvetica;
        color:#000000;
        font-size:14px;
        line-height: 0px;
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
    #fleet_search {
        width:140px;
    }
    .form-check-label {
        line-height: 12px;
        margin-top:5px;
    }
    .pagin {
        margin-left:25px;
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
            padding-left:0px;
            padding-right:20px;
        }
        .box-right {
            width:65%;
        }
        .sect-top {
            height:180px;
            padding-left:23px;
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

        .sect-top-dummy {
            height:160px;
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
<script type="text/javascript">
    var hideableCol = 25;
    function putUpColumnName() {
        var myColSet = readCookie('cMyColSet');
        if(myColSet == null){
            myColSet = "111111111000000000000000";
            setCookie('cMyColSet', myColSet);
        }

        //23 is total column that can be hide/show
        for (let i = 0; i < hideableCol; i++) {
            var colName = $('#head' + i).text();
            $('#labelName' + i).text(colName);
            if(myColSet.charAt(i) == '1'){
                $('.col' + i).show();
                $('#checkFor' + i).prop( "checked", true);
            }else{
                $('.col' + i).hide();
                $('#checkFor' + i).prop( "checked", false);
            }
        }
    }
    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }
    function setCookie(variable, value, expires_seconds) {
        var d = new Date();
        d = new Date(d.getTime() + 1000 * expires_seconds);
        document.cookie = variable + '=' + value + '; expires=' + d.toGMTString() + ';';
    }
    function updateColumnSettings() {
        var newStatement = "";
        for (let i = 0; i < hideableCol; i++) {
            if($('#checkFor' + i).is(":checked")){
                newStatement = newStatement + "1";
            }else{
                newStatement = newStatement + "0";
            }
        }
        setCookie('cMyColSet', newStatement);
    }
    function setSchFilter(obj) {
        var objid = $(obj).attr('id');
        if(objid == 'flt-all') {
            $('#sch-opt').text('Bebas');
        }else if(objid == 'flt-noplate') {
            $('#sch-opt').text('No Pendaftaran');
        }else if(objid == 'flt-nojkr') {
            $('#sch-opt').text('No JKR');
        }else if(objid == 'flt-lokasi') {
            $('#sch-opt').text('Lokasi');
        }else if(objid == 'flt-milik') {
            $('#sch-opt').text('Milik');
        }else if(objid == 'flt-jenis') {
            $('#sch-opt').text('Jenis');
        }else if(objid == 'flt-pengeluar') {
            $('#sch-opt').text('Pengeluar');
        }else if(objid == 'flt-negeri') {
            $('#sch-opt').text('Negeri');
        }else if(objid == 'flt-cawangan') {
            $('#sch-opt').text('Cawangan');
        }

        $('.search-filter').removeClass('active');
        $('#' + objid).addClass('active');

        $('#filter-opt').val(objid);
        var xid = $(obj).attr('xid');
        $('#schFilterValue').val(xid);
        $('#fleet_search').attr('placeholder', $(obj).html());
    }
</script>
</head>
<body class="content">
    <div class="sect-top">
        <div class="mytitle">Laporan Senaraian Kenderaan <span>{{$title_span}}</span></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('vehicle.report')}}');">Laporan &amp; Statistik</a></li>
            <li class="breadcrumb-item active" aria-current="page" id="daerah">Senarai Kenderaan {{$title_span}}</li>
            </ol>
        </nav>
    <input type="hidden" name="filter-opt" id="filter-opt" value="">
    @if (Auth::user()->detail->register_purpose == 'is_jkr')
    <div class="dropdown inline" style="display: inline;">
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-folder"></i>

            @switch($status)
                @case('verification')
                    Menunggu Semakan
                    @break
                @case('approval')
                    Menunggu Pengesahan
                    @break
                @default

                @switch($ownership)
                    @case('jkr')
                        Milik JKR Persekutuan
                    @break
                    @case('state')
                        Milik JKR Negeri
                    @break
                    @case('external')
                        Agensi Luar
                    @break
                    @case('public')
                        Awam
                    @break
                    @case('disposal')
                        Rekod Arkib
                    @break

                @endswitch
            @endswitch
        </span>
        <ul class="dropdown-menu no-print" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">Pemilikan</h6></li>

            <li><a class="dropdown-item {{Request('ownership') == 'jkr' ? 'active' : ''}}" onclick="parent.openPgInFrame('{{ route('report.vehicle-list', ['ownership' => 'jkr', 'fleet_view' => 'department', 'limit' => Request('limit')])}}')">Milik JKR Persekutuan</a></li>
            <li><a class="dropdown-item {{Request('ownership') == 'state' ? 'active' : ''}}" onclick="parent.openPgInFrame('{{ route('report.vehicle-list', ['ownership' => 'state', 'fleet_view' => 'department', 'limit' => Request('limit')])}}')">Milik JKR Negeri</a></li>
            <li><a class="dropdown-item {{Request('ownership') == 'public' ? 'active' : ''}}" onclick="parent.openPgInFrame('{{ route('report.vehicle-list', ['ownership' => 'public', 'fleet_view' => 'public', 'limit' => Request('limit')])}}')">Awam / Projek</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item {{Request('ownership') == 'disposal' ? 'active' : ''}}" onclick="parent.openPgInFrame('{{ route('report.vehicle-list', ['ownership' => 'disposal', 'fleet_view' => 'disposal', 'limit' => Request('limit')])}}')">Rekod Arkib</a></li>
        </ul>
    </div>

        <div class="btn-group">
            <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel()" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel"></i> &nbsp;Muat Turun Data</a>
            <a class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fal fa-cog"></i>&nbsp;Paparan
            </a>
            <a class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</a>
        </div>

    <div class="dropdown inline float-end" style="margin-right:30px;">
        <div style="display:inline-block;width:70px;padding-right:5px;">
            <div style="position: absolute;left:-50px;line-height:40px;">Papar</div>
            <select class="form-control form-select" id="total_list_per_page" name="total_list_per_page">
                <option value="5" {{$limit==5 ? "selected" : ""}}>5</option>
                <option value="10" {{$limit==10 ? "selected" : ""}}>10</option>
                <option value="25" {{$limit==25 ? "selected" : ""}}>25</option>
                <option value="50" {{$limit==50 ? "selected" : ""}}>50</option>
                <option value="100" {{$limit==100 ? "selected" : ""}}>100</option>
            </select>
        </div>
        <div style="display: inline-block;width:auto;">
            <div class="input-group">
                <input id='fleet_search' type="text" class="form-control" placeholder="Carian" value='{{$search}}'>
                <div class="dropdown">
                    <button class="btn filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><span id="sch-opt">{{$optdesc}}</span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item search-filter{{$xid == 0 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="0" id="flt-all">Bebas</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 1 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="1" id="flt-noplate">No Pendaftaran</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 2 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="2" id="flt-nojkr">No JKR</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 3 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="3" id="flt-lokasi">Lokasi</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 4 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="4" id="flt-milik">Milik</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 5 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="5" id="flt-jenis">Jenis</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 6 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="6" id="flt-pengeluar">Pengeluar</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 7 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="7" id="flt-negeri">Negeri</a></li>
                        <li><a class="dropdown-item search-filter{{$xid == 8 ? ' active' : ''}}" href="#" onclick="setSchFilter(this)" xid="8" id="flt-cawangan">Cawangan</a></li>
                    </ul>
                </div>
                <div style="height:40px;max-height:50xp;background-color:#ffffff;-webkit-border-radius: 0px 8px 8px 0px;-moz-border-radius: 0px 8px 8px 0px;border-radius: 0px 8px 8px 0px;">
                    <span class="input-group-text" id='search-btn'><i class="fal fa-search fa-lg"></i></span>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="schFilterValue" value="{{$xid}}"/>
    @endif
</div>
<div class="sect-top-dummy"></div>
{{-- <div class="title-report">Laporan Senaraian Kenderaan <span>Milik JKR</span></div> --}}
<div class="main-content">
    @if($xmode == 'list')
        <div xmode="list">
        <div class="table-responsive">
                <table class="table-custom no-footer stripe" style="width:auto">
                    <thead>
                        <tr>
                            <th class="lcal-2" class="col-del">Bil.</th>
                            <th class="lcal-5 col0" id="head0">Hak Milik</th>
                            <th class="lcal-5 col2" id="head2">Cawangan</th>
                            <th class="lcal-3" style="width:70px;text-align:left">No. Pendaftaran</th>
                            @if ($fleet_view == 'public')
                                <th class="lcal-3 col0" id="head0">No.Kontrak</th>
                                <th class="lcal-3 col1" id="head1">Nama Projek</th>
                                <th class="lcal-3 col2" id="head2">Head of Project Team (HOPT)</th>
                                <th class="lcal-3 col3" id="head3">Nama Syarikat Kontraktor</th>
                            @elseif($fleet_view == 'disposal')
                                <th class="lcal-5 col0" id="head0">Kaedah Pelupusan</th>
                                <th class="lcal-5 col1" id="head1">No. Resit Rasmi</th>
                                <th class="lcal-5 col2" id="head2">Pembeli</th>
                                <th class="lcal-5 col3" id="head3">Tarikh Lupus</th>
                            @else
                                <th class="lcal-4 col1" id="head1">Negeri</th>
                                <th class="lcal-5 col3" id="head3">Lokasi Penempatan</th>
                            @endif
                            <th class="lcal-3 col4" id="head4">Kategori</th>
                            <th class="lcal-5 col5" id="head5">Sub Kategori</th>
                            <th class="lcal-5 col6" id="head6">Jenis</th>
                            <th class="lcal-3 col7" id="head7">Pembuat</th>
                            <th class="lcal-3 col8" id="head8">Model</th>
                            <th class="lcal-3 col9" id="head9">No.Casis</th>
                            <th class="lcal-3 col10" id="head10">No.Enjin</th>
                            <th class="lcal-3 col11" id="head11">No.ID Pemunya</th>
                            <th class="lcal-3 col12" id="head12">Status</th>
                            <th class="lcal-3 col13" id="head13">No.Loji</th>
                            <th class="lcal-3 col14" id="head14">No.JKR</th>
                            <th class="lcal-3 col15" id="head15">Harga Perolehan</th>
                            <th class="lcal-4 col16" id="head16">Tarikh Perolehan</th>
                            <th class="lcal-3 col17" id="head17">Tarikh Pembelian</th>
                            <th class="lcal-3 col18" id="head18">Tarikh Pemeriksaan Keselamatan</th>
                            <th class="lcal-4 col19" id="head19">Tarikh Cukai Jalan</th>
                            <th class="lcal-3 col20" id="head20">Tahun Dibuat</th>
                            <th class="lcal-3 col21" id="head21">Pegawai Bertangunggjawab</th>
                            <th class="lcal-3 col22" id="head22">Pegawai Kemaskini</th>
                            <th class="lcal-3 col23" id="head23">Tarikh Kemaskini</th>
                            <th class="t-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($department) > 0)
                            @foreach ($department as $fleet)
                            <tr>
                                <td class="text-uppercase" style="padding-top:2px;text-align:right">{{$loop->index+1}}.</td>
                                <td class="text-uppercase col0">{{$fleet["HAK MILIK"]}}</td>
                                <td class="text-uppercase col2">{{$fleet["CAWANGAN"]}}</td>
                                <td class="text-start text-uppercase" style="padding-left:10px;text-align: left !important;">{{$fleet["NO.PENDAFTARAN"]}}</td>
                                @if ($fleet_view == 'public')
                                    <td class="text-uppercase col0">{{$fleet["NO.KONTRAK"]}}</td>
                                    <td class="text-uppercase col1">{{$fleet["NAMA PROJEK"]}}</td>
                                    <td class="text-uppercase col2">{{$fleet["HOPT"]}}</td>
                                    <td class="text-uppercase col3">{{$fleet["NAMA SYARIKAT KONTRAKTOR"]}}</td>
                                @elseif($fleet_view == 'disposal')
                                    <td class="text-uppercase col0">{{$fleet["KAEDAH PELUPUSAN"]}}</td>
                                    <td class="text-uppercase col1">{{$fleet["NO.RESIT RASMI"]}}</td>
                                    <td class="text-uppercase col2">{{$fleet["PEMBELI"]}}</td>
                                    <td class="text-uppercase col3">{{!empty($fleet["TARIKH LUPUS"]) ? \Carbon\Carbon::parse($fleet["TARIKH LUPUS"])->format('d M Y') : ''}}</td>
                                @else
                                    <td class="text-uppercase col1">{{$fleet["NEGERI"]}}</td>
                                    <td class="text-uppercase col3">{{$fleet["LOKASI PENEMPATAN"]}}</td>
                                @endif


                                <td class="text-uppercase col4">{{$fleet["KATEGORI"]}}</td>
                                <td class="text-uppercase col5">{{$fleet["SUB KATEGORI"]}}</td>
                                <td class="text-uppercase col6">{{$fleet["JENIS"]}}</td>
                                <td class="text-uppercase col7">{{$fleet["PEMBUAT"]}}</td>
                                <td class="text-uppercase col8">{{$fleet["MODEL"]}}</td>
                                <td class="text-uppercase col9">{{$fleet["NO.CASIS"]}}</td>
                                <td class="text-uppercase col10">{{$fleet["NO.ENJIN"]}}</td>
                                <td class="text-uppercase col11">{{$fleet["NO.ID PEMUNYA"]}}</td>
                                <td class="text-uppercase col12">{{$fleet["STATUS"]}}</td>
                                <td class="text-uppercase col13">{{$fleet["NO.LOJI"]}}</td>
                                <td class="text-uppercase col14">{{$fleet["NO.JKR"]}}</td>
                                <td class="text-uppercase col15">{{$fleet["HARGA PEROLEHAN"]}}</td>
                                <td class="text-uppercase col16">{{!empty($fleet["TARIKH PEROLEHAN"]) ? \Carbon\Carbon::parse($fleet["TARIKH PEROLEHAN"])->format('d M Y') : ''}}</td>
                                <td class="text-uppercase col17">{{!empty($fleet["TARIKH PEMBELIAN"]) ? \Carbon\Carbon::parse($fleet["TARIKH PEMBELIAN"])->format('d M Y') : ''}}</td>
                                <td class="text-uppercase col18">{{!empty($fleet["TARIKH PEMERIKSAAN KESELAMATAN"]) ? \Carbon\Carbon::parse($fleet["TARIKH PEMERIKSAAN"])->format('d M Y') : ''}}</td>
                                <td class="text-uppercase col19">{{!empty($fleet["TARIKH CUKAI JALAN"]) ? \Carbon\Carbon::parse($fleet["TARIKH CUKAI JALAN"])->format('d M Y') : ''}}</td>

                                <td class="text-uppercase col20">{{$fleet["TAHUN DIBUAT"]}}</td>
                                <td class="text-uppercase col21">{{$fleet["PEGAWAI BERTANGGUNGJAWAB"]}}</td>
                                <td class="text-uppercase col22">{{$fleet["PEGAWAI KEMASKINI"]}}</td>
                                <td class="text-uppercase col23">{{!empty($fleet["TARIKH KEMASKINI"]) ? \Carbon\Carbon::parse($fleet["TARIKH KEMASKINI"])->format('d M Y') : ''}}</td>
                                <td class="t-end"></td>
                            </tr>
                        @endforeach
                        @else
                        <tr class="no-record">
                            <td colspan="11" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <br/>
            <div class="paging">{{$department->withQueryString()->links('pagination.default')}}</div>
            <p>&nbsp;</p>
        </div>
    @endif
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><div class="popup-title">Paparan Kolum</div></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ps-5 pe-5">
            <div class="row">
                @for ($x = 0; $x <=23; $x++)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 form-check">
                        <input class="form-check-input colAdjust" type="checkbox" value="1" id="checkFor{{$x}}" checked>
                        <label class="form-check-label" for="checkFor{{$x}}" id="labelName{{$x}}"></label>
                    </div>
                @endfor
            </div>
        </div>
        <div class="modal-footer justify-content-start">
            <button type="button" class="btn btn-module" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
</div>

{{--<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>--}}

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
{{--<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}
<script>
        $('#total_list_per_page').change(function(){
            var limit = $(this).val();
            var fleetSearch = '{{$search}}';
            var xid = '{{$xid}}';
            var status = '{{$status}}';
            var xmode = '{{$xmode}}';
            var ownership = '{{$ownership}}';
            var fleet_view = '{{$fleet_view}}';
            parent.openPgInFrame('{{route('report.vehicle-list')}}?status='+status+'&xmode='+xmode+'&ownership='+ownership+'&limit='+limit+'&fleet_view='+fleet_view+'&search='+fleetSearch+'&xid='+xid);
        });

        $('#search-btn').click(function(){
            var limit = $('#total_list_per_page').val();
            var fleetSearch = $('#fleet_search').val();
            var xid = $('#schFilterValue').val();
            var status = '{{$status}}';
            var xmode = '{{$xmode}}';
            var ownership = '{{$ownership}}';
            var fleet_view = '{{$fleet_view}}';
            parent.openPgInFrame('{{route('report.vehicle-list')}}?status='+status+'&xmode='+xmode+'&ownership='+ownership+'&limit='+limit+'&fleet_view='+fleet_view+'&search='+fleetSearch+'&xid='+xid);
        });

        function downloadExcel(){
            $.ajax({
                url:"{{route('report.vehicle-export.excel')}}",
                data: {
                    'fleet_view': "{{$fleet_view}}",
                    'ownership': '{{Request('ownership')}}',
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

                    var filename = (matches != null && matches[1] ? matches[1] : 'Laporan Senarai Rekod Kenderaan '+fleet_view+'.xlsx');

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

</script>
<script>
    jQuery(document).ready(function() {
        //update field name
        putUpColumnName();

        $('#total_list_per_page').select2({
            width: '100%',
            theme: "classic",
            placeholder: "[Sila pilih]"
        });

        $('.colAdjust').change(function() {
            var fldId = $(this).attr('id');
            var colNo = fldId.replace('checkFor','')
            if(this.checked) {
                $('.col' + colNo).show();
            }else{
                $('.col' + colNo).hide();
            }
            updateColumnSettings();
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
    })
</script>
</body>
</html>
