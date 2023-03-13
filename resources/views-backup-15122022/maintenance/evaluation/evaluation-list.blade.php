@php
session()->put('mevaluation_current_detail_id', null);
$AccessMaintenanceEvaluation = auth()->user()->vehicle('03', '02');
$TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('03', '02');

use App\Models\Maintenance\MaintenanceEvaluation;

$status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';
$filterOpt = Request('filterOpt') ? Request('filterOpt') : 'flt-all';
$search = Request('search') ? Request('search') : null;
$schema = "maintenance";
$EvaluationStatus = DB::table($schema.'.evaluation AS a')
    ->select(DB::raw("COUNT(*) as total"), 'b.code','b.desc')
    ->join($schema.'.application_status AS b', 'b.id', 'a.app_status_id')
    ->groupBy('b.code','b.desc');

    if(auth()->user()->isAdmin()){
        Log::info('saya admin');
    } elseif(auth()->user()->isAssistEngineerMaintenance()){
        $EvaluationStatus->where('a.assistant_engineer_by', auth()->user()->id);
    } elseif(in_array(auth()->user()->roleAccess()->code, ['03'])){
        $EvaluationStatus->where(
            [
                'a.workshop_id' => auth()->user()->detail->workshop_id
            ]
        );
    }else{
        $EvaluationStatus->where('a.created_by', auth()->user()->id);
    }

    $EvaluationStatus->whereNotIn('b.code', ['00', '07']);

    if(auth()->user()->isSeniorEngineerMaintenance()){
        $EvaluationStatus->whereIn('b.code', ['03']);
    }elseif(auth()->user()->isForemenMaintenance()){
        $EvaluationStatus->whereIn('b.code', ['03']);
    }

    if($AccessMaintenanceEvaluation->fleet_has_limit){
        $EvaluationStatus->where(
            [
                'a.workshop_id' => auth()->user()->detail->workshop_id
            ]
        );
    }

    $EvaluationStatus->orWhereRaw('(b.code in (\'01\', \'02\', \'03\', \'11\') and a.created_by = '.auth()->user()->id.' )');

$totalDraft = DB::table($schema.'.evaluation AS a')
    ->join($schema.'.application_status AS b', 'b.id', 'a.app_status_id')
    ->where([
        'b.code' => '01',
        'a.created_by' => auth()->user()->id
    ])
    ->count();

$totalProcess = $totalDraft;

$totalAppointment = 0;
$totalAssessment = 0;
$totalVerification = 0;
$totalApproval = 0;
$totalGenerateLetter = 0;
$totalCompleted = 0;
$totalRejected = 0;

foreach ($EvaluationStatus->get() as $status) {
    switch ($status->code) {
        case '02':
            $totalAppointment = $status->total;
            $totalProcess += $status->total;
            break;
        case '03':
            $totalAssessment = $status->total;
            $totalProcess += $status->total;
            break;
        case '04':
            $totalVerification = $status->total;
            $totalProcess += $status->total;
            break;
        case '05':
            $totalApproval = $status->total;
            $totalProcess += $status->total;
            break;
        case '08':
            $totalCompleted = $status->total;
            break;
        case '06':
            $totalRejected = $status->total;
            break;
        case '11':
            $totalGenerateLetter = $status->total;
            $totalProcess += $status->total;
            break;
        default:
            # code...
            break;
    }
}

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

    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }
        .sect-top {
            position: fixed;
            left: 0px;
            width: 100%;
            z-index: 4;
            padding-left: 28px;
            background-color: #f2f4f0;
            padding-bottom: 10px;
            border-bottom-color: #e7e7e7;
            border-bottom-style: solid;
            border-bottom-width: 1px;
            margin-left: 0px;
            margin-right: 0px;
        }

        .sect-top-dummy {
            height: 190px;
        }
        .form-control.search {
            -webkit-border-radius: 8px 0px 0px 8px;
            -moz-border-radius: 8px 0px 0px 8px;
            border-radius: 8px 0px 0px 8px;
            height: 42px !important;
            width:160px;
            margin-top:0px;
            border-color:#dcdcd8;
            margin-top:-5px;
        }
        .form-control.search .input-group-text {
                height: 30px;
                line-height:4px;
                background-color:#ffffff;
                border-radius: 0px 8px 8px 0px;
                -moz-border-radius: 0px 8px 8px 0px;
                -webkit-border-radius: 0px 8px 8px 0px;
                font-family: avenir;
                font-size: 20px;
                padding:0px;
                padding-left:10px;
                padding-right:10px;
                -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
                -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
                box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
                border-color:#dcdcd8;
                border-width:1px;
                border-style:solid;
                cursor: pointer;
        }
        .form-control.search .input-group-text:hover {
            background-color:#eae1e1;
        }
        .dropdown-menu {
            min-width: 200px;
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
        .dropdown-item .badge {
            line-height: 15px;
            margin-top:-3px;
        }
        #enter {
            display: none;
            height: 39px;
            margin-left: 2px;
            border: 2px solid #e5e5e5;
            border-left: none;
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
    <div class="sect-top">
        <div class="mytitle">Pemeriksaan Kerosakan</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i
                            class="fal fa-home"></i></a></li>
                <li class="breadcrumb-item"><a
                        href="javascript:openPgInFrame('{{ route('maintenance.overview') }}')">Pemeriksaan Kerosakan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekod Pemeriksaan</li>
            </ol>
        </nav>
        <input type="hidden" name="filter-opt" id="filter-opt" value="{{$filterOpt}}">
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
                    Temujanji
                    @break
                @case('03')
                    Pemeriksaan
                    @break
                @case('04')
                    Semakan
                    @break
                @case('11')
                    Janaan Perihal Kerosakan
                    @break
                @case('06')
                    Batal
                    @break
                @case('08')
                    Selesai
                    @break
                @endswitch
            </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><h6 class="dropdown-header">Permohonan</h6></li>
                <li><a class="dropdown-item {{$status_code == 'all_inprogress' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  'all_inprogress'])}}')">Dalam Proses 
                    @if($totalProcess> 0)
                    <span class="badge bg-secondary">{{$totalProcess}}</span>
                    @endif
                </a></li>
                <li><hr class="dropdown-divider"></li>
                @if(!auth()->user()->isPublic())
                <li><h6 class="dropdown-header">Peringkat</h6></li>
                @if($totalDraft>0)
                    <li><a class="dropdown-item {{$status_code == '01' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '01'])}}')">Draf 
                        <span class="badge bg-secondary">{{$totalDraft}}</span>
                    </a></li>
                @endif
                <li><a class="dropdown-item {{$status_code == '02' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '02'])}}')">Temujanji 
                    @if($totalAppointment>0)
                    <span class="badge bg-secondary">{{$totalAppointment}}</span>
                    @endif
                </a></li>
                <li><a class="dropdown-item {{$status_code == '03' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '03'])}}')">Pemeriksaan 
                    @if($totalAssessment>0)
                    <span class="badge bg-secondary">{{$totalAssessment}}</span>
                    @endif
                </a></li>
                <li><a class="dropdown-item {{$status_code == '04' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '04'])}}')">Semakan 
                    @if($totalVerification>0)
                    <span class="badge bg-secondary">{{$totalVerification}}</span>
                    @endif
                </a></li>
                <li><a class="dropdown-item {{$status_code == '11' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '11'])}}')">Janaan Perihal Kerosakan 
                    @if($totalGenerateLetter>0)
                    <span class="badge bg-secondary">{{$totalGenerateLetter}}</span>
                    @endif
                </a></li>
                <li><hr class="dropdown-divider"></li>
                @endif
                
                <li><h6 class="dropdown-header">Arkib</h6></li>
                <li><a class="dropdown-item {{$status_code == '08' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '08'])}}')">Selesai 
                    @if($totalCompleted>0)
                    <span class="badge bg-secondary">{{$totalCompleted}}</span>
                    @endif
                </a></li>
                <li><a class="dropdown-item {{$status_code == '06' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('maintenance.evaluation.list', ['status_code' =>  '06'])}}')">Batal 
                    @if($totalRejected>0)
                    <span class="badge bg-secondary">{{$totalRejected}}</span>
                    @endif
                </a></li>
            </ul>
        </div>
        <div class="btn-group">
            @if ($AccessMaintenanceEvaluation->mod_fleet_c == 1)
            {{-- <a onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
            data-bs-target="#VehicleSearchModal" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Penilaian</a> --}}

            <a onclick="openPgInFrame('{{route('maintenance.evaluation.register')}}')" aria-readonly=""
                class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Permohonan</a>
            @endif
            @if ($AccessMaintenanceEvaluation->mod_fleet_d == 1)
            <button data-bs-toggle="modal" data-bs-target="#maintenanceEvaluationDelModal" disabled
                class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-trash-alt"></i> Hapus</button>
            <button data-bs-toggle="modal" data-bs-target="#assessmentAccidentCancelModal" disabled
                class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-eraser"></i> Batal</button>
            @endif
        </div>
        <div class="dropdown inline float-end">
            <div class="input-group">
                @php
                    $mapPlaceholder = [
                        'flt-all' => 'Semua',
                        'flt-refno' => 'No Rujukan',
                        'flt-applicant' => 'Pemohon',
                        'flt-telno' => 'No Telefon'
                    ]
                @endphp
                <input type="search" id="searching" onkeyup="searching(this.value)" class="form-control search" placeholder="{{$mapPlaceholder[$filterOpt]}}" value="{{$search}}">
                <div class="dropdown">
                    <button class="btn filter-btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <input type="hidden" id="schFilterValue" value="0"/>
                        <li><a class="dropdown-item search-filter {{$filterOpt=='flt-all' ? 'active':''}}" onclick="setSchFilter(this)" xid="0" id="flt-all">Semua</a></li>
                        <li><a class="dropdown-item search-filter {{$filterOpt=='flt-refno' ? 'active':''}}" onclick="setSchFilter(this)" xid="3" id="flt-refno">No Rujukan</a></li>
                        <li><a class="dropdown-item search-filter {{$filterOpt=='flt-applicant' ? 'active':''}}" onclick="setSchFilter(this)" xid="1" id="flt-applicant">Pemohon</a></li>
                        <li><a class="dropdown-item search-filter {{$filterOpt=='flt-telno' ? 'active':''}}" onclick="setSchFilter(this)" xid="2" id="flt-telno">No Telefon</a></li>
                    </ul>
                </div>
                <button onclick="searching(this.value, 'click')" class="input-group-text"><i class="fa fa-search"></i></button>
              </div><!--<i class="fas fa-search" style="line-height:20px"></i>-->
        </div>
    </div>
    <div class="sect-top-dummy"></div>
    <div class="main-content" style="padding-right:0px">
        <div class="table-responsive">
            <table class="table-custom stripe no-footer">
                <thead>
                    @if ($AccessMaintenanceEvaluation->mod_fleet_d == 1)
                    <th><input class="form-check-input" name="chkall" id="chkall" type="checkbox"></th>
                    @endif
                    @if ($AccessMaintenanceEvaluation->mod_fleet_u == 1)
                    <th class="lcal-2"></th>
                    @endif
                    <th>No Rujukan</th>
                    <th>No. Pendaftaran</th>
                    <th>Pemohon</th>
                    <th>Tel</th>
                    
                    {{-- <th>Tarikh Siap</th> --}}
                    <th>Agensi</th>
                    {{-- <th>Jumlah Kos</th> --}}
                    {{-- <th>Jumlah Kenderaan</th> --}}
                    <th>Status</th>
                    <th>Tarikh  & Masa<br/>Permohonan</th>
                </thead>
                <tbody id="sortable">
                        @php
                            $tab = 1;
                        @endphp
                        @if (count($maintenance_evaluation_list) > 0)
                            @foreach ( $maintenance_evaluation_list as $maintenance)
                            @php
                                switch ($maintenance->hasStatus->code) {
                                    case '01':
                                        $tab = 1;
                                        break;
                                    case '02':
                                        // if($TaskFlowAccessMaintenanceEvaluation->mod_fleet_appointment){
                                        //     $tab = 3;
                                        // }
                                        if($maintenance->hasAssistantEngineerBy){
                                            $tab = 3;
                                        } else {
                                            $tab = 1;
                                        }
                                        break;
                                    case '03':
                                        // if($TaskFlowAccessMaintenanceEvaluation->mod_fleet_verify){
                                        //     $tab = 4;
                                        // }
                                        $tab = 4;
                                        break;
                                    case '04':
                                        $tab = 5;
                                        break;
                                    case '09':
                                    case '11':
                                        $tab = 6;
                                        break;

                                    default:
                                        $tab = 1;
                                        break;
                                }
                            @endphp
                            <tr>
                                @if ($AccessMaintenanceEvaluation->mod_fleet_d == 1)
                                <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$maintenance->id}}"></td>
                                @endif
                                @if ($AccessMaintenanceEvaluation->mod_fleet_u == 1)
                                <td>
                                    <div class="btn-group dropend">
                                        <button type="button" class="btn cux-btn" onClick="openPgInFrame('{{route('maintenance.evaluation.register', [ 'id' =>  $maintenance->id, 'tab' => $tab ])}}')"><i class="fa fa-pencil-alt"></i></button>
                                    </div>
                                </td>
                                @endif
                                <td><a href="{{route('maintenance.evaluation.register', [ 'id' =>  $maintenance->id, 'tab' => $tab ])}}">{{$maintenance->ref_number}}</a></td>
                                <td><a href="{{route('maintenance.evaluation.register', [ 'id' =>  $maintenance->id, 'tab' => $tab ])}}">{{$maintenance->hasVehicle() && $maintenance->hasVehicle()->first() ? $maintenance->hasVehicle()->first()->plate_no : ''}}</a></td>
                                <td><a href="{{route('maintenance.evaluation.register', [ 'id' =>  $maintenance->id, 'tab' => $tab ])}}">{{$maintenance->applicant_name}}</a></td>
                                <td>{{$maintenance->phone_no}}</td>
                                {{-- <td>{{$maintenance->email}}</td> --}}
                                {{-- <td>{{$maintenance->hasAgency->desc}}</td> --}}
                                <td>{{$maintenance->department_name}}</td>
                                {{-- <td>{{$maintenance->hasVehicle->count()}}</td> --}}
                                <td>
                                    @switch($maintenance->hasStatus->code)
                                        @case('02')
                                            @if(!$maintenance->hasAssistantEngineerBy && ($TaskFlowAccessMaintenanceEvaluation->mod_fleet_appointment))
                                                Tetapkan Penolong Jurutera
                                                @else
                                                    @if(!$maintenance->appointment_dt && ($TaskFlowAccessMaintenanceEvaluation->mod_fleet_appointment))
                                                        Tetapkan Temujanji
                                                    @else
                                                    {{$maintenance->hasStatus->desc}}
                                                    @endif
                                            @endif
                                            @break
                                        @case('11')
                                            @if(($TaskFlowAccessMaintenanceEvaluation->mod_fleet_approval))
                                                Menunggu Kelulusan Janaan Perihal Kerosakan
                                                @else
                                                {{$maintenance->hasStatus->desc}}
                                            @endif
                                            @break
                                            
                                            @break
                                        @default
                                        {{$maintenance->hasStatus->desc}}
                                            
                                    @endswitch
                                </td>
                                <td>{{\Carbon\Carbon::parse($maintenance->created_at)->format('d F Y')}}<br/><small>{{\Carbon\Carbon::parse($maintenance->created_at)->format('g:i A')}}</small></td>

                            </tr>
                            @endforeach
                        @else
                            <tr class="no-record">
                                <td colspan="10" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                            </tr>
                        @endif
                </tbody>
            </table>
            {{$maintenance_evaluation_list->links('pagination.default')}}
        </div>

        {{-- @extends('maintenance.evaluation.accident-test')

        @section('name')
        @endsection --}}
    </div>
    <div class="modal fade" id="maintenanceEvaluationDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationDelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah anda ingin menghapuskan maklumat ini ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" style="display: none" id="reload" class="btn btn-secondary"
                        onclick="window.location.reload()">Tutup</button>
                    <button type="button" id="remove" class="btn btn-danger text-white"
                        onclick="remove()">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assessmentAccidentCancelModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentAccidentCancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah anda ingin batalkan maklumat ini ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close_cancel" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" style="display: none" id="reload_cancel" class="btn btn-secondary"
                        onclick="window.location.reload()">Tutup</button>
                    <button type="button" id="cancel" class="btn btn-danger text-white"
                        onclick="cancel()">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var ids = [];

        function searching(value, trigger){
        let filterOpt = $('#filter-opt').val();
        let keycode = (event.keyCode ? event.keyCode : event.which);
        let searching = $('#searching').val();
        let statusCode = '{{$status_code}}';
        if((searching && trigger == 'click')){
            window.location.href = "{{route('maintenance.evaluation.list')}}?search="+searching+"&filterOpt="+filterOpt+"&status_code="+statusCode;
        } else {
            if(keycode ==  13 || !value){
                window.location.href = "{{route('maintenance.evaluation.list')}}?search="+value+"&filterOpt="+filterOpt+"&status_code="+statusCode;
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

        function getCurrentChecked(){
            ids = [];
            $('#chkdel:checked').map(function() {
                ids.push(parseInt(this.value));
            });

            return ids;
        }

        function remove(){
            $('#maintenanceEvaluationDelModal #remove').hide();
            $('#maintenanceEvaluationDelModal #close').hide();
            $.post("{{route('maintenance.evaluation.delete')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#maintenanceEvaluationDelModal .sub-title').text(result.message);
                }
                $('#maintenanceEvaluationDelModal #reload').show();
            })
        }

        function cancel(){
            $('#assessmentAccidentCancelModal #cancel').hide();
            $('#assessmentAccidentCancelModal #close_cancel').hide();
            $.post("{{route('maintenance.evaluation.cancel')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#assessmentAccidentCancelModal .sub-title').text(result.message);
                }
                $('#assessmentAccidentCancelModal #reload_cancel').show();
            })
        }

        $(document).ready(function() {

            $('[name="chkall"]').change(function() {

                $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
                $('.delete_all').prop('disabled', true);

                getCurrentChecked();
                if(ids.length > 0){
                    $('.delete_all').prop('disabled', false);
                }

            });

            $('[name="chkdel"]').change(function() {

                $('.delete_all').prop('disabled', true);

                getCurrentChecked();
                if(ids.length == $('[name="chkdel"]').length){
                    $('#chkall').prop('checked', true);
                } else {
                    $('#chkall').prop('checked', false);
                }

                if(ids.length > 0){
                    $('.delete_all').prop('disabled', false);
                }
            });

        })

    </script>
</body>

</html>
