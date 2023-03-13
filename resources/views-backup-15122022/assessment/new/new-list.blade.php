@php
session()->put('new_current_detail_id', null);
$AccessAssessment = auth()->user()->vehicle('02', '01');
$TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentNewVehicle;

$status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';
$search = Request('search') ? Request('search') : null;
$schema = "assessment";
$AssessmentStatus = DB::table($schema.'.assessment_new AS a')
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
    }

    else{
        $AssessmentStatus->where('created_by', Auth::user()->id);
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

    $queryEvaluation = AssessmentNew::whereHas('hasVehicleMany', function($q){
            $q->whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '04');
            });
        })->get();
    $queryApproval = AssessmentNew::whereHas('hasVehicleMany', function($q){
            $q->whereHas('hasAssessmentVehicleStatus', function($q){
                $q->where('code', '05');
            });
        })->get();

    // $queryApproval = AssessmentNew::whereHas('hasAssessmentVehicleStatus', function($q){
    //         $q->where('code', '03');
    //     })->get();

    // $totalVehicleEvaluation = count($queryEvaluation);
    // $totalVehicleApproval = count($queryApproval);

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
            $totalVerification = $queryEvaluation->count();
            $totalProcess += $status->total;
            break;
        case '05':
            $totalApproval = $queryApproval->count();
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

if($roleAccessCode == '04'){
    $landingPage = route('access.public.dashboard');
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
    <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
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
        .sect-top-dummy {
            height: 190px;
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
        .lcal-5 {
            width: 200px;
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
        .sect-sch {
            float:right;
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

            .sect-top-dummy {
                height: 160px;
            }
            .btn {
                border-radius: 0%;
            }
            .sect-sch {
                float: none;
            }
        }
    </style>
    <script>
        $(document).ready(function() {});

    </script>
</head>
<body class="content">
    <div class="sect-top">
        <div class="mytitle">Penilaian <span>Kenderaan Baharu</span></div>
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
        <div class="row block-menu">
            <div class="col-xl-6 col-lg-8 col-md-8 col-sm-6 col-12">
                <div class="dropdown inline" style="display: inline">
                    <button class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><h6 class="dropdown-header">Permohonan</h6></li>
                        <li><a class="dropdown-item {{$status_code == 'all_inprogress' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  'all_inprogress'])}}')">Dalam Proses
                            @if($totalProcess > 0)<span class="badge bg-secondary">{{$totalProcess}}</span>@endif
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Peringkat</h6></li>
                        <li><a class="dropdown-item {{$status_code == '01' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '01'])}}')">Draf
                            @if($totalDraft > 0)<span class="badge bg-secondary">{{$totalDraft}}</span>@endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '02' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '02'])}}')">Temujanji
                            @if($totalAppointment > 0)<span class="badge bg-secondary">{{$totalAppointment}}</span>@endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '03' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '03'])}}')">Penilaian
                            @if($totalAssessment > 0)<span class="badge bg-secondary">{{$totalAssessment}}</span>@endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '04' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '04'])}}')">Semakan
                            @if($totalVerification > 0)<span class="badge bg-secondary">{{$totalVerification}}</span>
                            @endif

                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '05' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '05'])}}')">Kelulusan
                            @if($totalApproval > 0)<span class="badge bg-secondary">{{$totalApproval}}</span>
                            @endif
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><h6 class="dropdown-header">Arkib</h6></li>
                        <li><a class="dropdown-item {{$status_code == '08' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '08'])}}')">Selesai
                            @if($totalCompleted > 0)<span class="badge bg-secondary">{{$totalCompleted}}</span>@endif
                        </a></li>
                        <li><a class="dropdown-item {{$status_code == '06' ? 'active':''}}" onclick="parent.openPgInFrame('{{route('assessment.new.list', ['status_code' =>  '06'])}}')">Batal
                            @if ($totalRejected > 0)<span class="badge bg-secondary">{{$totalRejected}}</span>
                            @endif
                        </a></li>
                    </ul>
                </div>
                <div class="btn-group inline">
                    @if ($AccessAssessment->mod_fleet_c == 1)
                    {{-- <a onclick="getVehicle()" aria-readonly="" data-bs-toggle="modal"
                    data-bs-target="#VehicleSearchModal" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Penilaian</a> --}}

                    <button type="button" onclick="openPgInFrame('{{route('assessment.new.register')}}')" aria-readonly=""
                        class="btn cux-btn bigger" value="Edit"><i class="fal fa-plus"></i></button>
                    {{-- <button type="button" onclick="searchList()" aria-readonly=""
                        class="btn cux-btn bigger"><i class="fal fa-search"></i></button> --}}
                    @endif
                    {{-- @if ($AccessAssessment->mod_fleet_d == 1) --}}
                        @if($status_code != '08' || auth()->user()->isAdmin())
                            @if($status_code == '06' || $status_code == '01' || auth()->user()->isAdmin())
                                <button data-bs-toggle="modal" data-bs-target="#assessmentNewDelModal" disabled
                            class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-trash-alt"></i></button>
                            @else
                                <button data-bs-toggle="modal" data-bs-target="#assessmentNewCancelModal" disabled class="btn cux-btn bigger delete_all" type="button"><i class="fal fa-eraser"></i></button>
                            @endif
                        @endif
                    {{-- @endif --}}

                </div>
            </div>
            <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12 mt-2 mt-sm-0" id="box-search">
                <div class="input-group">
                    <input type="search" onkeyup="searching(this.value)" class="form-control search" placeholder="Carian No rujukan/Plat No" value="{{$search}}">
                    <span class="input-group-text" style="border-width:1px;"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="sect-top-dummy"></div>
    <div class="main-content">
        <div class="table-responsive">
            <table class="table-custom no-footer stripe">
                <thead>
                    <th class="col-del"><input class="form-check-input" name="chkall" id="chkall" type="checkbox"></th>
                    <th class="col-del"></th>
                    <th class="lcal-3">No Rujukan</th>
                    <th>Pemohon</th>
                    <th class="lcal-3">Tel</th>
                    {{-- <th>Tarikh Siap</th> --}}
                    <th>Kementerian</th>
                    <th>Agensi</th>
                    {{-- <th>Jumlah Kos</th> --}}
                    <th class="lcal-2 text-end">Bilangan Kenderaan</th>
                    <th class="lcal-3">Status Permohonan</th>
                    <th class="lcal-3">Tarikh Permohonan</th>
                </thead>
                <tbody id="sortable">
                    @php
                        $tab = 1;
                    @endphp
                    @foreach ( $news as $new)
                    @php
                        switch ($new->hasStatus->code) {
                        // switch($new-?){
                            case '01':
                                $tab = 1;
                                break;
                            case '02':
                                // if($TaskFlowAccessAssessmentNew->mod_fleet_appointment){
                                //     $tab = 3;
                                // }
                                $tab = 3;
                                break;
                            case '03':
                                // if($TaskFlowAccessAssessmentNew->mod_fleet_verify){
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
                                $tab = 7;
                                break;

                            default:
                                $tab = 1;
                                break;

                        }
                        if(auth()->user()->isAssistEngineerAssessment()){
                                if($new->hasStatus->code == '02'){
                                    $tab = 3;
                                }else{
                                    $tab = 6;
                                }
                            }else if(auth()->user()->isEngineerAssessment()){
                                if($new->hasStatus->code == '08'){
                                    $tab = 8;
                                }else{
                                    $tab = 7;
                                }
                        }else {
                        }
                    @endphp
                    <tr>
                        <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$new->id}}"></td>
                        <td class="col-edit">
                            <br>
                            <div class="btn-group">
                                    <button class='btn cux-btn' onclick="parent.openPgInFrame('{{route('assessment.new.register', [ 'id' =>  $new->id, 'tab' => $tab ])}}')"><i class="fa fa-pencil-alt"></i></button>
                                    <button class='btn cux-btn' onclick="openPgInFrame('{{route('report.report_assessment_stmt', [ 'id' =>  $new->id, 'workshop_id' => $new->hasWorkshop ? $new->hasWorkshop->id: null, 'ref_number' =>  $new->ref_number, 'assessment_type' => 'new'])}}')"><i class="fa fa-print text-success"></i></button>
                                {{-- <button type="button" class="btn" onClick="openPgInFrame('{{route('assessment.new.register', [ 'id' =>  $new->id, 'tab' => $tab ])}}')"><i class="fa fa-pencil-alt"></i></button>
                                <button type="button" class="btn" onClick="openPgInFrame('{{route('report.report_assessment_stmt', [ 'id' =>  $new->id, 'ref_number' =>  $new->ref_number, 'assessment_type' => 'new'])}}')"><i class="fa fa-print text-success"></i></button> --}}
                            </div>
                        </td>
                        {{-- <td>
                            <div class="btn-group">
                                <button class='btn cux-btn' onclick="parent.openPgInFrame('{{route('assessment.new.register', [ 'id' =>  $new->id, 'tab' => $tab ])}}')"><i class="fa fa-pencil-alt"></i></button>
                                <button type="button" class="btn cux-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="z-index: 1000">
                                    <li style="margin-top:-8px;"><h6 class="header-highlight">{{$new->ref_number}}</h6></li>
                                    <li class="dropdown-item f1st-menu" onclick="openPgInFrame('{{route('report.report_assessment_stmt', [ 'id' =>  $new->id, 'ref_number' =>  $new->ref_number, 'assessment_type' => 'new'])}}')"><i class="fa fa-print text-success"></i> Cetak</li>
                                </ul>
                            </div>
                        </td> --}}
                        <td><a href="{{route('assessment.new.register', [ 'id' =>  $new->id, 'tab' => $tab ])}}">{{$new->ref_number}}</a></td>
                        <td><a href="{{route('assessment.new.register', [ 'id' =>  $new->id, 'tab' => $tab ])}}">{{$new->applicant_name}}</a></td>
                        <td>{{$new->phone_no}}</td>
                        <td class="caps">{{$new->hasAgency ? $new->hasAgency->desc : ''}}</td>
                        <td class="caps">{{$new->department_name}}</td>
                        <td class="caps text-end">{{count($new->hasTotalVeh())}}</td>
                        <td class="caps">{{$new->hasStatus->desc}}</td>
                        <td class="caps">{{\Carbon\Carbon::parse($new->created_at)->format('d M Y')}}<br/><small>{{\Carbon\Carbon::parse($new->created_at)->format('g:i A')}}</small></td>
                    </tr>
                    @endforeach
                    @if (count($news) == 0)
                    <tr class="no-record">
                        <td colspan="10" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="pagination">{{$news->links('pagination.default')}}</div>
    </div>


    <div class="modal fade" id="assessmentNewDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentNewDelModalLabel" aria-hidden="true">
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

    <div class="modal fade" id="assessmentNewCancelModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentNewCancelModalLabel" aria-hidden="true">
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
                window.location.href = "{{route('assessment.new.list', ['status_code' => $status_code ])}}&search="+value;
            }
        }

        function getCurrentChecked(){
            ids = [];
            $('#chkdel:checked').map(function() {
                ids.push(parseInt(this.value));
            });

            return ids;
        }
        function goSearch() {
            $('#box-search').slideDown();
        }
        function remove(){
            $('#assessmentNewDelModal #remove').hide();
            $('#assessmentNewDelModal #close').hide();
            $.post("{{route('assessment.new.delete')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#assessmentNewDelModal .sub-title').text(result.message);
                }
                $('#assessmentNewDelModal #reload').show();
            })
        }

        function cancel(){
            $('#assessmentNewCancelModal #cancel').hide();
            $('#assessmentNewCancelModal #close_cancel').hide();
            $.post("{{route('assessment.new.cancel')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#assessmentNewCancelModal .sub-title').text(result.message);
                }
                $('#assessmentNewCancelModal #reload_cancel').show();
            })
        }

        (function($){
            $.fn.focusTextToEnd = function(){
                this.focus();
                var $thisVal = this.val();
                this.val('').val($thisVal);
                return this;
            }
        }(jQuery));

        function addOtherCar() {
            var newRow = "<div class='row car-row'>" +
                    "<div class='col-xl-1 col-lg-1 col-md-1 form-group first-col'><label class='form-label text-dark'>2.</label></div>" +
                    "<div class='col-xl-2 col-lg-2 col-md-3 pt-2'>" +
                    "<div class='form-group'>" +
                    "<input type='text' class='form-control' name='accwit_regno' id='accwit_regno' placeholder='cth. SMC4234' onchange='forceCaps(this);'><div class='hasErr'></div>" +
                    "</div></div>" +

                    "<div class='col-xl-4 col-lg-7 col-md-6 pt-2'>" +
                        "<div class='form-group'>" +
                            "<input type='text' class='form-control' name='vehicle_desc' id='vehicle_desc' placeholder='cth. Motosikal Yamaha 135 LC' onchange='forceCaps(this);'>" +
                            "<div class='hasErr'></div>" +
                        "</div>" +
                    "</div>"+


                    "<div class='col-xl-1 col-lg-1 col-md-1 pt-2 form-group' style='max-width: 40px;padding-top:0px;padding-left:0px'>" +
                    "<button class='btn cux-btn bigger' onclick='clearThisRow()'><i class='fal fa-times'></i></button>" +
                    "</div>" +
                    "</div>";
            $('.car-row').last().after(newRow);
        }

        $(document).ready(function() {
            //$('#box-search').hide();
            @if ($search)
            let searchTxt = $('[type="search"]');
                searchTxt.focusTextToEnd();
            @endif

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
