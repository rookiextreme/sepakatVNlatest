@php
    session()->put('booking_current_detail_id', null);
    // access module logistic -> Tempahan Kenderaan
   $AccessVehicle = auth()->user()->vehicle('04', '01');

   // access for verify / approval
   $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('04', '01');

   \Log::info($TaskFlowAccessVehicle);

   use App\Http\Controllers\Logistic\Booking\LogisticBookingDAO;

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
    .modal-header {
        font-family: avenir;
        text-transform: uppercase;
        letter-spacing:4px;
        color:black;
        font-size:10px;
    }
    .announce {
        font-family: helve-bold;
        font-size:30px;
        letter-spacing:-1px;
        line-height:28px;
        color:#000000;
        margin-top:10px;
        margin-bottom:10px;
    }
    ul.notice li {
        font-family:avenir;
        color:#383631;
        font-size:18px;
        margin-bottom:10px;
    }
    ul.notice li span {
        font-family:avenir-bold;
        color:#191816;
        font-size:18px;
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

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
<div class="sect-top">
    <div class="mytitle">Tempahan Kenderaan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Logistik</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tempahan Kenderaan</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="dropdown inline" style="display: inline;">
                <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fal fa-folder"></i>
                    @switch($status_code)
                    @case('all_inprogress')
                        Dalam Proses
                        @break
                    @case('01')
                        Draf
                        @break
                    @case('02')
                        Semakan
                        @break
                    @case('03')
                        Kelulusan
                        @break
                    @case('06')
                        Selesai
                        @break
                    @default
                        Dalam Proses
                    @break
                    @endswitch
                </span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><h6 class="dropdown-header">Permohonan</h6></li>
                    <li><a class="dropdown-item {{$status_code == 'all_inprogress' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('logistic.booking.list', ['status_code' =>  'all_inprogress'])}}')">Dalam Proses
                        @if($totalProcess>0)
                        <span class="badge bg-secondary">{{$totalProcess}}</span>
                        @endif
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Peringkat</h6></li>
                    @if($totalDraft > 0)
                        <li><a class="dropdown-item {{$status_code == '01' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('logistic.booking.list', ['status_code' =>  '01'])}}')">Draf
                            <span class="badge bg-secondary">{{$totalDraft}}</span>
                        </a></li>
                    @endif
                    <li>
                        <a class="dropdown-item {{$status_code == '02' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('logistic.booking.list', ['status_code' =>  '02'])}}')">Semakan
                        @if($totalVerification > 0)
                            <span class="badge bg-secondary">{{$totalVerification}}</span>
                        @endif
                    </a></li>
                    <li>
                        <a class="dropdown-item {{$status_code == '03' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('logistic.booking.list', ['status_code' =>  '03'])}}')">Kelulusan
                        @if($totalApproval > 0)
                            <span class="badge bg-secondary">{{$totalApproval}}</span>
                        @endif
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Arkib</h6></li>
                    <li><a class="dropdown-item {{$status_code == '06' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('logistic.booking.list', ['status_code' =>  '06'])}}')">Selesai
                        @if($totalCompleted>0)
                        <span class="badge bg-secondary">{{$totalCompleted}}</span>
                        @endif
                    </a></li>
                </ul>
            </div>
            <div class="btn-group">
                @if ($AccessVehicle->mod_fleet_c == 1)
                <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#syaratTempahan"><i class="fal fa-plus"></i> Tempahan</a>
                @endif
                @if ($AccessVehicle->mod_fleet_d == 1)
                <button class="btn cux-btn bigger" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#deleteLogisticBookingModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
                @endif
                @if ($TaskFlowAccessVehicle->mod_fleet_verify)
                <button class="btn cux-btn bigger" xaction="verify_all" data-bs-toggle="modal" data-bs-target="#verifyVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Semak"><i class="fa fa-check"></i>&nbsp;Semak</button>
                @endif

                @if ($TaskFlowAccessVehicle->mod_fleet_approval)
                <button class="btn cux-btn bigger" xaction="approve_all" data-bs-toggle="modal" data-bs-target="#approvalVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                @endif
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="dropdown inline float-end">
                <div class="input-group">
                    {{-- <div style="height:40px;max-height:50xp;background-color:#ffffff;-webkit-border-radius: 0px 8px 8px 0px;-moz-border-radius: 0px 8px 8px 0px;border-radius: 0px 8px 8px 0px;">
                        <button type="button" class="input-group-text" id='search-btn'><i class="fal fa-search fa-lg"></i></button>
                    </div> --}}
                {{-- </div>
                <div class="input-group"> --}}
                    @if($search)
                        <label for="" class="btn cux-btn form-control mb-0 mt-0 active" id="clear_search" style="height: 42px;padding-top: 12px;color: #dcdcd8;">X</label>
                    @endif
                    <input class="form-control search" size="16" type="search" onfocus="(this.type='date')" onfocusout="(this.type='text')" style="width: 30%;"
                        placeholder="Tarikh Tempahan" id="searching" value="{{$search_date}}">
                    <label class="input-group-addon input-group-text">
                        <i class="fal fa-calendar-alt"></i>
                    </label>
                    <input id="searching2" onkeyup="onEnterWithSearch(this)" type="text" class="form-control" placeholder="Carian" value='' style="width: 40%;" value="{{$search}}">
                    <div class="dropdown">
                        <button class="btn filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <input type="hidden" id="schFilterValue" value=""/>
                            <li><a class="dropdown-item search-filter {{$searchid == 0 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xsearchid="0" id="default">--</a></li>
                            <li><a class="dropdown-item search-filter {{$searchid == 1 ? 'active' : ''}}" href="#" onclick="setSchFilter(this)" xsearchid="1" id="department">Cawangan</a></li>
                        </ul>
                    </div>
                    <button onclick="searching(this.value, 'click')" class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="main-content">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th><input name="chkall" id="chkall" class="form-check-input" type="checkbox"></th>
            <th class="col-del"></th>
            <th>Pemohon</th>
            <th>Destinasi</th>
            <th>Tarikh Tempahan</th>
            <th>Tarikh & Masa Pergi</th>
            <th>Tarikh & Masa Balik</th>
            <th>Status Tempahan</th>
            <th>Slip Kelulusan</th>
        </thead>
        <tbody id="sortable">
            @foreach ($booking_list as $booking)
                <tr>
                    <td class="col-del">
                        <input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$booking->id}}">
                    </td>
                    <td class="col-edit">
                        {{--<div class="dropdown">
                            <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" id="catelog_dropdown_menu" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden">Toggle Dropright</span></button>
                                <ul class="dropdown-menu">
                                    <li style="margin-top:-8px;"><h6 class="header-highlight">{{$booking->id}}</h6></li>
                                    <li><a class="dropdown-item" onclick="parent.openPgInFrame('{{route('logistic.booking.detail', [ 'id' => $booking->id])}}')"><i class="fa fa-pencil-alt" style="width:20px"></i>
                                        @if($booking->created_by == Auth::user()->id)
                                            @if($TaskFlowAccessVehicle->mod_fleet_approval)
                                                Lulus
                                                @else
                                                Kemaskini
                                            @endif
                                        @else
                                            @if($TaskFlowAccessVehicle->mod_fleet_approval)
                                                Lulus
                                                @else
                                                Kemaskini
                                            @endif
                                        @endif
                                    </a></li>
                                    <li><a class="dropdown-item" ><i class="fal fa-ban" style="width:20px"></i> Tolak</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fal fa-trash-alt" style="width:20px"></i> Hapus</a></li>
                                </ul>
                        </div>--}}
                        <button type="button" class="btn" onClick="openPgInFrame('{{route('logistic.booking.detail', [ 'id' => $booking->id])}}')" data-bs-toggle="tooltip" data-bs-placement="top" ><i class="fa fa-pencil-alt"></i></button>
                    </td>
                    <td>{{$booking->booking_person_name}}<br/><small>{{$booking->hasApplicant ? $booking->hasApplicant->hasDepartment->name : ''}}</small></td>
                    <td>{{$booking->destination}}</td>
                    <td>{{\Carbon\Carbon::parse($booking->created_at)->format('d M Y')}}</td>
                    <td>{{\Carbon\Carbon::parse($booking->start_datetime)->format('d M Y')}}<br/><small>{{\Carbon\Carbon::parse($booking->start_datetime)->format('h:m:s A')}}</small></td>
                    <td>{{\Carbon\Carbon::parse($booking->end_datetime)->format('d M Y')}}<br/><small>{{\Carbon\Carbon::parse($booking->end_datetime)->format('h:m:s A')}}</small></td>
                    <td>
                        <span onClick="openPgInFrame('{{route('logistic.booking.detail', [ 'id' => $booking->id])}}')" class="cursor-pointer spakat-tip"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-html="true"
                            title="Catanan : <br/> {{$booking->note}}"><i class="fas fa-info-circle"></i>
                        </span>
                        {{$booking->hasBookingStatus->name}}

                        </td>
                    <td>
                        @if($booking->hasBookingStatus->code == '06')
                        <a href="{{route('logistic.booking.slip', [ 'booking_id' => $booking->id ])}}">Lihat Slip</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            @if (count($booking_list) == 0)
                <tr class="no-record">
                    <td colspan="10" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                </tr>
            @endif
        </tbody>
    </table>
{{ $booking_list->links('pagination.default') }}

<div class="modal fade" id="deleteLogisticBookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLogisticBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            Adakah anda ingin menghapuskan data ini ?
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
<div class="modal fade" id="syaratTempahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="syaratTempahanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                PEMBERITAHUAN
            </div>
            <div class="modal-body p-3 text-start">
                <div class="mytitle">Syarat-syarat Menggunakan Kenderaan Jabatan<div>
                <hr>
                <div class="text-start" style="letter-spacing: 0px;color:#383631">
                <ul class="notice pe-5">
                    <li>Permohonan mesti diserahkan kepada Pegawai Kenderaan <span>selewat-lewatnya 3 hari sebelum</span> tarikh  penggunaan bagi perjalanan keluar daerah dan <span>1 hari sebelum</span> penggunaan bagi perjalanan / urusan tempatan.</li>
                    <li>Borang hendaklah diisi dengan <span>lengkap dan jelas</span>.</li>
                    <li>Tujuan perjalanan adalah atas <span>urusan rasmi Kerajaan sahaja</span>.</li>
                    <li>Pemohon <span>perlu melampirkan surat / memo arahan tugas / jemputan mesyuarat / kursus / aktiviti </span> daripada pihak berkaitan.</li>
                    <!--<li>Borang permohonan yang tidak lengkap tidak akan diproses dan kelulusan tertakluk kepada keutamaan tugas dan kekosongan kenderaan.</li>-->
                </ul>
                <p>&nbsp;</p>
                </div>
            </div>
            <div class="modal-footer justify-content-start">
                <button class="btn btn-module bigger" type="button" onclick="openPgInFrame('{{route('logistic.booking.register')}}')">Setuju</button>
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tidak Setuju</button>
            </div>
        </div>
    </div>
</div>

</div>

<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="{{asset('my-assets/plugins/moment/js/moment.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var ids = [];
    var selfDataTable;

    function searching(value, trigger){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        let searching = $('#searching').val();
        let searching2 = $('#searching2').val();
        if((searching && trigger == 'click')){
            // var totalListPerPage = $('#total_list_per_page').val();
            var totalListPerPage = '{{$limit}}';
            var searchid = $('#schFilterValue').val();
            var status_code = '{{$status_code}}';
            parent.openPgInFrame('{{route('logistic.booking.list')}}?limit='+totalListPerPage+'&search_date='+searching+'&search='+searching2+'&searchid='+searchid+'&status_code='+status_code);
        } else {
            if(keycode ==  13 || !value){
            // var totalListPerPage = $('#total_list_per_page').val();
            var totalListPerPage = '{{$limit}}';
            var searchid = $('#schFilterValue').val();
            var status_code = '{{$status_code}}';
            // console.log('search '+searching2, ' status '+status_code, ' searchid '+searchid);
            parent.openPgInFrame('{{route('logistic.booking.list')}}?limit='+totalListPerPage+'&search_date='+searching+'&search='+searching2+'&searchid='+searchid+'&status_code='+status_code);
            }
        }
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

    function setSchFilter(obj) {

        var objid = $(obj).attr('id');
        $('.search-filter').removeClass('active');
        $('#' + objid).addClass('active');

        var searchid = $(obj).attr('xsearchid');
        $('#schFilterValue').val(searchid);
        $('#searching2').attr('placeholder',$(obj).html());
    }

    function onEnterWithSearch(self){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        var searching = self.value;
        if(keycode ==  13 || !searching){
            var totalListPerPage = $('#total_list_per_page').val();
            var searchid = $('#schFilterValue').val();
            var status_code = '{{$status_code}}';
            parent.openPgInFrame('{{route('logistic.booking.list')}}?limit='+totalListPerPage+'&search='+searching+'&searchid='+searchid+'&status_code='+status_code);
        }
    }

    jQuery(document).ready(function() {

        $('.spakat-tip').tooltip();

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

        $('[name="chkdel"]').change(function() {

            $(this).prop('checked', $(this).checked);

            let rows= $('[name="chkdel"]').map(function () {
                return this.value;
            } );

            let rowsChecked = $('[name="chkdel"]:checked').map(function () {
                return this.value;
            } );

            if(rows.length == rowsChecked.length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(rowsChecked.length > 0){
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

            $.post('{{route('logistic.booking.delete')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#deleteLogisticBookingModal .modal-body').text('Maklumat kenderaan berjaya dihapuskan');
                show('[xaction="close"]');
                //$('#deleteLogisticBookingModal').modal('hide');
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

            $.post('{{route('logistic.booking.approval')}}', {
                'ids': ids,
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
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.booking.approve')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#approvalVehicleModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('#clear_search').on('click', function(){
            window.location.href = "{{route('logistic.booking.list', ['status_code' => $status_code])}}&search=";
        });
    });
</script>
</body>
</html>


