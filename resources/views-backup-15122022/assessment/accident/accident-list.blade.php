@php
session()->put('accident_current_detail_id', null);
$AccessAssessment = auth()->user()->vehicle('02', '04');
$TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '04');
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentAccidentVehicle;

$status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';
$search = Request('search') ? Request('search') : null;
$schema = "assessment";
$AssessmentStatus = DB::table($schema.'.assessment_accident AS a')
    ->select(DB::raw("COUNT(*) as total"), 'b.code','b.desc')
    ->leftJoin($schema.'.assessment_application_status AS b', 'b.id', 'a.app_status_id')
    ->groupBy('b.code','b.desc');

    $AssessmentStatus->whereNotIn('code', ['00','01']);

    if(auth()->user()->isAdmin()){
        $AssessmentStatus->whereIn('code', ['02','03','04','05','06','08']);
    }

    elseif (auth()->user()->isEngineer() || auth()->user()->isEngineerAssessment()){
        $AssessmentStatus->where('workshop_id', auth()->user()->detail->workshop_id);
    }

    elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerAssessment()){
        $AssessmentStatus->where('workshop_id', auth()->user()->detail->workshop_id);
    }

    elseif(auth()->user()->isForemenAssessment()){
        $AssessmentStatus->whereIn('code', ['03']);
    } else {
        $AssessmentStatus->where('a.created_by', auth()->user()->id);
        $landingPage = route('access.public.dashboard');
    }

    if($AccessAssessment->fleet_has_limit){
        $AssessmentStatus->where(
            [
                'workshop_id' => auth()->user()->detail->workshop_id
            ]
        );
    }

    $AssessmentStatus->orWhereNotIn('code', ['00','06','08'])->where('created_by', auth()->user()->id);

    $queryEvaluation = AssessmentAccidentVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '06');
        })->get();
    $queryApproval = AssessmentAccidentVehicle::whereHas('hasAssessmentVehicleStatus', function($q){
            $q->where('code', '03');
        })->get();

    $totalVehicleEvaluation = count($queryEvaluation);
    $totalVehicleApproval = count($queryApproval);
$totalStruckVehicle = AssessmentAccident::with('hasVehicle', 'hasVehicle.hasStruckVehicle')->count();
$totalProcess = 0;

$totalDraft = 0;
$totalAppointment = 0;
$totalAssessment = 0;
$totalVerification = 0;
$totalApproval = 0;
$totalCompleted = 0;
$totalRejected = 0;

foreach ($AssessmentStatus->get() as $status) {
    switch ($status->code) {
        case '01':
            $totalDraft = $status->total;
            $totalProcess += $status->total;
            break;
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

    <script src="{{ asset('my-assets/bootstrap/js/popper.js') }}" type="text/javascript"></script>

    <!--importing bootstrap-->
    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('my-assets/fontawesome-pro/css/light.min.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.js') }}"></script>
    <!--Importing Icons-->

    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
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
            padding-right: 28px;
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
        <div class="mytitle">Penilaian <span>Kemalangan</span></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if($roleAccessCode == '04')
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.public.dashboard')}}');">
                    <i class="fal fa-home"></i></a>
                </li>
                @else
                <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('assessment.overview')}}');">
                        <i class="fal fa-home"></i></a>
                </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">Rekod Penilaian</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-6 col-12">
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
                            Penilaian
                            @break
                        @case('04')
                            Semakan
                            @break
                        @case('05')
                            Kelulusan
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
                        <li><a class="dropdown-item {{$status_code == 'all_inprogress' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  'all_inprogress'])}}')">Dalam Proses
                            @if($totalProcess > 0)<span class="badge bg-secondary">{{$totalProcess}}</span>@endif
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Peringkat</h6></li>
                        <li><a class="dropdown-item {{$status_code == '01' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '01'])}}')">Draf
                            @if ($totalDraft> 0)
                            <span class="badge bg-secondary">{{$totalDraft}}</span>
                            @endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '02' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '02'])}}')">Temujanji
                            @if ($totalAppointment> 0)
                            <span class="badge bg-secondary">{{$totalAppointment}}</span>
                            @endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '03' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '03'])}}')">Penilaian
                            @if ($totalAssessment> 0)
                            <span class="badge bg-secondary">{{$totalAssessment}}</span>
                            @endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '04' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '04'])}}')">Semakan
                            @if ($totalVerification> 0)
                            <span class="badge bg-secondary">{{$totalVerification}}</span>
                            @endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '05' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '05'])}}')">Kelulusan
                            @if ($totalApproval> 0)
                            <span class="badge bg-secondary">{{$totalApproval}}</span>
                            @endif
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Arkib</h6></li>
                        <li><a class="dropdown-item {{$status_code == '08' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '08'])}}')">Selesai
                            @if ($totalCompleted> 0)<span class="badge bg-secondary">{{$totalCompleted}}</span>
                            @endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '06' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.accident.list', ['status_code' =>  '06'])}}')">Batal
                            @if ($totalRejected> 0)<span class="badge bg-secondary">{{$totalRejected}}</span>
                            @endif
                        </a></li>
                    </ul>
                </div>
                <div class="btn-group inline">
                    {{-- @if ($AccessAssessment->mod_fleet_c == 1)
                    <a onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                    data-bs-target="#VehicleSearchModal" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Penilaian</a>
        
                    <button type="button" onclick="openPgInFrame('{{route('assessment.new.register')}}')" aria-readonly=""
                        class="btn cux-btn bigger" value="Edit"><i class="fal fa-plus"></i></button>
                    <button type="button" onclick="searchList()" aria-readonly=""
                        class="btn cux-btn bigger"><i class="fal fa-search"></i></button>
                    @endif
                    @if ($AccessAssessment->mod_fleet_d == 1)
                        @if($status_code != '08' || auth()->user()->isAdmin())
                            @if($status_code == '06' || $status_code == '01' || auth()->user()->isAdmin())
                                <button data-bs-toggle="modal" data-bs-target="#assessmentNewDelModal" disabled
                            class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-trash-alt"></i></button>
                            @else
                                <button data-bs-toggle="modal" data-bs-target="#assessmentNewCancelModal" disabled class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-eraser"></i></button>
                            @endif
                        @endif
                    @endif --}}
        
                    @if ($AccessAssessment->mod_fleet_c == 1)
                    {{-- <a onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                    data-bs-target="#VehicleSearchModal" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Penilaian</a> --}}
        
                    <button type="button" onclick="openPgInFrame('{{route('assessment.accident.register')}}')" aria-readonly=""
                        class="btn cux-btn bigger" value="Edit"><i class="fal fa-plus"></i></button>
                    {{-- <button type="button" onclick="searchList()" aria-readonly=""
                        class="btn cux-btn bigger"><i class="fal fa-search"></i></button> --}}
                    @endif
                    {{-- @if ($AccessAssessment->mod_fleet_d == 1) --}}
                        @if($status_code != '08' || auth()->user()->isAdmin())
                            @if($status_code == '06' || $status_code == '01' || auth()->user()->isAdmin())
                                <button data-bs-toggle="modal" data-bs-target="#assessmentAccidentDelModal" disabled
                            class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-trash-alt"></i></button>
                            @else
                                <button data-bs-toggle="modal" data-bs-target="#assessmentAccidentCancelModal" disabled class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-eraser"></i></button>
                            @endif
                        @endif
                    {{-- @endif --}}
                </div>
                {{-- <a href="{{ asset('my-assets/forms/borang_am_362B.pdf')}}" target="blank" class="btn cux-btn bigger"><i class="fal fa-file-download"></i> Borang AM 362B</a> --}}
                <a href="{{asset('my-assets/forms/borang_am_362B.pdf')}}" target="blank" class="btn cux-btn bigger"><i class="fal fa-file-download"></i> Borang AM 362B</a>
            </div>
            <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12 mt-2 mt-sm-0 ">
                <div class="dropdown inline">
                    <div class="input-group">
                        <input type="search" onkeyup="searching(this.value)" class="form-control search" placeholder="Carian No Rujukan / Plat No" value="{{$search}}">
                        <span class="input-group-text" style="margin-top:-5px;border-width:1px;"><i class="fa fa-search"></i></span>
                      </div><!--<i class="fas fa-search" style="line-height:20px"></i>-->
                </div>
            </div>
        </div>
    </div>
    <div class="sect-top-dummy"></div>
    <div class="main-content" style="padding-right:0px">
        <div class="table-responsive">
            <table class="table-custom no-footer stripe">
                <thead>
                    <th class="col-del"><input class="form-check-input" name="chkall" id="chkall" type="checkbox"></th>
                    <th class="col-del"></th>
                    <th class="col-ref">No Rujukan</th>
                    @if($roleAccessCode == '04')
                        <th>Woksyop Pilihan</th>
                        <th>Tarikh & Masa<br/>Temujanji</th>
                        <th>No Laporan Kes</th>

                    @else
                        <th>Pemohon</th>
                        <th>Tel</th>
                        <th>Emel</th>
                        <th>Agensi</th>
                    @endif
                    {{-- <th>Tarikh Siap</th> --}}

                    {{-- <th>Jumlah Berlanggar</th> --}}
                    {{-- <th>Jumlah Kos</th> --}}
                    <th>Status</th>
                    <th>Tarikh  & Masa<br/>Permohonan</th>
                </thead>
                <tbody id="sortable">
                    @php
                        $tab = 1;
                    @endphp
                    @foreach ( $accidents as $accident)
                    @php
                        switch ($accident->hasStatus->code) {
                            case '01':
                                $tab = 1;
                                break;
                            case '02':
                                // if($TaskFlowAccessAssessmentAccident->mod_fleet_appointment){
                                //     $tab = 3;
                                // }
                                $tab = 3;
                                break;
                            case '03':
                                // if($TaskFlowAccessAssessmentAccident->mod_fleet_verify){
                                //     $tab = 4;
                                // }
                                $tab = 4;
                                break;
                            case '04':
                                $tab = 5;
                                break;
                            case '05':
                                $tab = 6;
                                break;
                            case '08':
                                // if(auth()->user()->checkRole('03')){

                                // }else
                                $tab = 6;
                                break;

                            default:
                                $tab = 1;
                                break;
                        }
                            if(auth()->user()->isAssistEngineerAssessment()){
                                if($accident->hasStatus->code == '02'){
                                    $tab = 3;
                                }
                                else if($accident->hasStatus->code == '04'){
                                    $tab = 5;
                                }
                            }else if(auth()->user()->isEngineerAssessment()){
                                if($accident->hasStatus->code == '05'){
                                    $tab = 6;
                                }else if($accident->hasStatus->code == '08'){
                                    $tab = 6;
                                }else{

                                }
                            }else {
                            }
                    @endphp
                    <tr>
                        <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$accident->id}}"></td>
                        <td class="col-edit">
                            {{-- <button type="button" class="btn" onClick="openPgInFrame('{{route('assessment.accident.register', [ 'id' =>  $accident->id, 'tab' => $tab ])}}')" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$accident->hasStatus->code == '02' ? 'Lihat':'Kemaskini'}} maklumat"><i class="fa fa-pencil-alt"></i></button> --}}
                            <br>
                            <div class="btn-group">
                                    <button class='btn cux-btn' onclick="parent.openPgInFrame('{{route('assessment.accident.register', [ 'id' =>  $accident->id, 'tab' => $tab ])}}')"><i class="fa fa-pencil-alt"></i></button>
                                    <button class='btn cux-btn' onclick="openPgInFrame('{{route('report.report_assessment_stmt', [ 'id' =>  $accident->id, 'workshop_id' => $accident->hasWorkshop ? $accident->hasWorkshop->id: null, 'ref_number' =>  $accident->ref_number, 'assessment_type' => 'accident'])}}')"><i class="fa fa-print text-success"></i></button>
                                {{-- <button type="button" class="btn" onClick="openPgInFrame('{{route('assessment.new.register', [ 'id' =>  $new->id, 'tab' => $tab ])}}')"><i class="fa fa-pencil-alt"></i></button>
                                <button type="button" class="btn" onClick="openPgInFrame('{{route('report.report_assessment_stmt', [ 'id' =>  $new->id, 'ref_number' =>  $new->ref_number, 'assessment_type' => 'new'])}}')"><i class="fa fa-print text-success"></i></button> --}}
                            </div>
                        </td>
                        <td class="caps"><a href="{{route('assessment.accident.register', [ 'id' =>  $accident->id, 'tab' => $tab ])}}">{{$accident->ref_number}}</a></td>
                        @if($roleAccessCode == '04')
                            <td class="caps">{{$accident->hasWorkShop ? $accident->hasWorkShop->desc : '-'}}</td>
                            <td class="caps">
                                
                                @if($accident->hasStatus->code == '02')
                                    {{\Carbon\Carbon::parse($accident->appointment_dt1)->format('d M Y')}}
                                    <br/><small>{{\Carbon\Carbon::parse($accident->appointment_dt1)->format('g:i A')}} <span class="badge bg-secondary">Cadangan</span></small>
                                @elseif($accident->appointment_dt)
                                    {{\Carbon\Carbon::parse($accident->appointment_dt)->format('d M Y')}}
                                    <br/><small>{{\Carbon\Carbon::parse($accident->appointment_dt)->format('g:i A')}}</small>
                                @else

                                @endif</td>
                            <td>{{$accident && $accident->report_no ? $accident->report_no : ''}}</td>
                        @else
                            <td><a href="{{route('assessment.accident.register', [ 'id' =>  $accident->id, 'tab' => $tab ])}}">{{$accident->applicant_name}}</a></td>
                            <td class="text-center">{{$accident->phone_no ? $accident->phone_no : '-'}}</td>
                            <td>{{$accident->email}}</td>
                            <td>{{$accident->department_name}}</td>
                        @endif
                        <td class="caps">{{$accident->hasStatus->desc}}</td>
                        <td class="caps">{{\Carbon\Carbon::parse($accident->created_at)->format('d M Y')}}<br/><small>{{\Carbon\Carbon::parse($accident->created_at)->format('g:i A')}}</small></td>
                    </tr>
                    @endforeach
                    @if (count($accidents) == 0)
                    <tr class="no-record">
                        <td colspan="9" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod permohonan</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{$accidents->links('pagination.default')}}
        </div>

        {{-- @extends('assessment.accident.accident-test')

        @section('name')
        @endsection --}}
    </div>
    <div class="modal fade" id="assessmentAccidentDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentAccidentDelModalLabel" aria-hidden="true">
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

        function searching(value){
            let keycode = (event.keyCode ? event.keyCode : event.which);
            if(keycode ==  13 || !value){
                window.location.href = "{{route('assessment.accident.list', ['status_code' => $status_code ])}}&search="+value;
            }
        }

        function getCurrentChecked(){
            ids = [];
            $('#chkdel:checked').map(function() {
                ids.push(parseInt(this.value));
            });

            return ids;
        }

        function remove(){
            $('#assessmentAccidentDelModal #remove').hide();
            $('#assessmentAccidentDelModal #close').hide();
            $.post("{{route('assessment.accident.delete')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#assessmentAccidentDelModal .sub-title').text(result.message);
                }
                $('#assessmentAccidentDelModal #reload').show();
            })
        }

        function cancel(){
            $('#assessmentAccidentCancelModal #cancel').hide();
            $('#assessmentAccidentCancelModal #close_cancel').hide();
            $.post("{{route('assessment.accident.cancel')}}", {
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

            $('.spakat-tip').tooltip();

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
