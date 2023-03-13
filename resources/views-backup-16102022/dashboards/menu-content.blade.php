

@php

    $totalPenilaianBaru = 0;
    $totalPenilaianKeselamatan = 0;
    $totalPenilaianNilaiSemasa = 0;
    $totalPenilaianKemalangan = 0;
    $totalPenilaianPinjaman = 0;
    $totalPenilaianPelupusan = 0;


    $totalSenggaraanPemeriksaan = 0;
    $totalSenggaraanServis = 0;

    $totalLogisticBooking = 0;
    $disasterPreparation = 0;

    $workshopId = auth()->user()->detail->workshop_id ? auth()->user()->detail->workshop_id : -1;
    $branchId = auth()->user()->detail->branch_id ? auth()->user()->detail->branch_id : -1;
    $roleCode = auth()->user()->detail->refRole->code;

    Log::info('$roleCode => '.$roleCode);

    $AccessVehicle = auth()->user()->vehicle('01', '01');
    $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');

    $AccessVehicleSummon = auth()->user()->vehicle('01', '02');
    $TaskFlowAccessSummon = auth()->user()->vehicleWorkFlow('01', '02');

    $AccessAssessmentNew = auth()->user()->vehicle('02', '01');
    $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');

    $AccessAssessmentSafety = auth()->user()->vehicle('02', '02');
    $TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '02');

    $AccessAssessmentCurrValue = auth()->user()->vehicle('02', '03');
    $TaskFlowAccessAssessmentCurrValue = auth()->user()->vehicleWorkFlow('02', '03');

    $AccessAssessmentAccident = auth()->user()->vehicle('02', '04');
    $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '04');

    $AccessAssessmentDisposal = auth()->user()->vehicle('02', '05');
    $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '05');

    $AccessAssessmentGovloan = auth()->user()->vehicle('02', '06');
    $TaskFlowAccessAssessmentGovloan = auth()->user()->vehicleWorkFlow('02', '06');

    $AccessWarrant = auth()->user()->vehicle('03', '01');
    $TaskFlowAccessWarant = auth()->user()->vehicleWorkFlow('03', '01');

    $AccessMaintenance = auth()->user()->vehicle('03', '02');
    $TaskFlowAccessMaintenance = auth()->user()->vehicleWorkFlow('03', '02');

    $AccessVehicleReport = auth()->user()->vehicle('01', '03');
    $AccessAssessmentReport = auth()->user()->vehicle('02', '07');
    $AccessMaintenanceReport = auth()->user()->vehicle('03', '03');

    $AccessLogisticBooking = auth()->user()->vehicleWorkFlow('04', '01');
    $AccessLogisticBookingDisaster = auth()->user()->vehicleWorkFlow('04', '02');

    $AccessLogisticReport = auth()->user()->vehicle('04', '03');

    $allowDisasterReady = auth()->user()->generalSetting('02');
    $xmode = Request('xmode') ? Request('xmode') : 'list';

    // $assessment_mapRoleIdTo_AppStatusId = [
    //     '01' => '1,2,3,4,5',
    //     '02' => '-1',
    //     '03' => '6',
    //     '04' => '3,5',
    //     '07' => '4',
    //     '05' => '-1',
    //     '14' => '6',
    //     '15' => '3,5',

    // ];

    $appStatus = '3,4,5,6';
    $assessment_mapRoleIdTo_AppStatusId = [
        '01' => '3,4,5,6',
        '02' => '-1',
        '03' => '3,4,5,6',
        '04' => '3,4,5,6',
        '07' => '4',
        '05' => '-1',
        '14' => '3,4,5,6',
        '15' => '3,4,5,6',

    ];

    // if(isset($assessment_mapRoleIdTo_AppStatusId[$roleCode])){
    //Assessment Alert
    if(
        in_array($roleCode, array('01','02','03','04','07','13','14','15')) ||
        $AccessAssessmentNew->mod_fleet_r ||
        $AccessAssessmentAccident->mod_fleet_r ||
        $AccessAssessmentSafety->mod_fleet_r ||
        $AccessAssessmentCurrValue->mod_fleet_r ||
        $AccessAssessmentGovloan->mod_fleet_r ||
        $AccessAssessmentDisposal->mod_fleet_r

    ){

        Log::info("-----------------");
        Log::info("roleCode : ".$roleCode);
        Log::info("workshopId : ".$workshopId);
        if(isset($assessment_mapRoleIdTo_AppStatusId[$roleCode])){
            Log::info("mapRoleIdTo_StatusId : ".$assessment_mapRoleIdTo_AppStatusId[$roleCode]);
            $appStatus = $assessment_mapRoleIdTo_AppStatusId[$roleCode];
        }

        Log::info("-----------------\n\n\n\n\n");

        $queryByWorkshop = 'an.workshop_id = '.$workshopId;
        Log::info('$roleCode => '.$roleCode);

        if($roleCode == '01'){
            $queryByWorkshop = '';
            $queryByAppStatus = 'WHERE an.app_status_id NOT IN (1,2,7,9)';
        }
        else if($roleCode == '03'){
            $queryByWorkshop = ' WHERE an.workshop_id ='.$workshopId;
            $queryByAppStatus = 'AND an.app_status_id IN ('.$appStatus.')';
        } else {
            $queryByWorkshop = '';
            $queryByAppStatus = ' WHERE an.created_by = '.auth()->user()->id;
        }

        $queryByAppStatus = $queryByAppStatus.' OR (an.created_by = '.auth()->user()->id.' AND an.app_status_id IN (2) )';

        $totalPenilaianBaru = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_new an
            '.$queryByWorkshop.'
            '.$queryByAppStatus.'
            '))[0]->total;

        $totalPenilaianKeselamatan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_safety an
            '.$queryByWorkshop.'
            '.$queryByAppStatus.'
            '))[0]->total;

        $totalPenilaianNilaiSemasa =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_currvalue an
            '.$queryByWorkshop.'
            '.$queryByAppStatus.'
            '))[0]->total;

        $totalPenilaianKemalangan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_accident an
            '.$queryByWorkshop.'
            '.$queryByAppStatus.'
            '))[0]->total;

        $totalPenilaianPinjaman =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_gov_loan an
            '.$queryByWorkshop.'
            '.$queryByAppStatus.'
            '))[0]->total;

        $totalPenilaianPelupusan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM assessment.assessment_disposal an
            '.$queryByWorkshop.'
            '.$queryByAppStatus.'
            '))[0]->total;

            Log::info('queryByAppStatus');
            Log::info($queryByAppStatus);
            Log::info($totalPenilaianKeselamatan);
    }

    //Maintenance Alert
    if(
        in_array($roleCode, array('01','02','03','04','05','08','09','10','11','12')) ||
        $AccessWarrant->mod_fleet_r ||
        $AccessMaintenance->mod_fleet_r
    ){

        $mAppStatus = '3,4,5,10,12';
        $maintenance_mapRoleIdTo_AppStatusId = [
            '01' => '3,4,5,10,12',
            '02' => '-1',
            '03' => '3,4,5,10,12',
            '04' => '3,4',
            '05' => '3,4',
            '08' => '4',
            '09' => '4,5,10,12',
            '10' => '4,5,10,12',
            '11' => '3,4,5,10,12',
            '12' => '3,4,5,10,12'
        ];

        //if(isset($maintenance_mapRoleIdTo_AppStatusId[$roleCode])){

        Log::info("\n\n\n\n\n-----------------");
        Log::info("roleCode : ".$roleCode);
        Log::info("workshopId : ".$workshopId);
        if(isset($maintenance_mapRoleIdTo_AppStatusId[$roleCode])){
            Log::info("mapRoleIdTo_StatusId : ".$maintenance_mapRoleIdTo_AppStatusId[$roleCode]);
            $mAppStatus = $maintenance_mapRoleIdTo_AppStatusId[$roleCode];
        }

        Log::info("-----------------\n\n\n\n\n");

        $queryWorkshop = '';
        $querySeniorEngineer = '';
        $queryAssignEngginer = '';
        $queryAssistantEngginer = '';
        $queryPublic = '';

        if(auth()->user()->isAdmin()){
            $queryWorkshop = '';
        }
        else if($workshopId){
            $queryWorkshop = ' AND an.workshop_id = '.$workshopId;
        }

        if(in_array($roleCode, array('01'))){

        }
        elseif(in_array($roleCode, array('10'))){
            $queryAssignEngginer = '';
            $querySeniorEngineer = ' OR EXISTS (
                    SELECT
                        1
                    FROM
                        maintenance.job_vehicle jv
                    JOIN maintenance.job_vehicle_examination_form jve ON jve.vehicle_id = jv.id
                    JOIN maintenance.job_vehicle_status jvs ON jvs.id = jve.job_vehicle_status_id
                    WHERE
                        jv.maintenance_job_id = an.id and jvs.code = \'10\'
                    )';
        }
        elseif(in_array($roleCode, array('11'))){
            $queryAssignEngginer = ' AND (an.assign_engineer_by = '.auth()->user()->id.' or an.assign_engineer_by is null)';
        }
        elseif(in_array($roleCode, array('04','12'))){
            $queryAssistantEngginer = ' AND an.assistant_engineer_by = '.auth()->user()->id;
        }
        else {
            $queryWorkshop = '';
            $queryPublic = ' AND an.created_by = '.auth()->user()->id;
        }

        $myApp = ' OR (an.app_status_id IN (2) AND an.created_by = '.auth()->user()->id.')';

        $totalSenggaraanPemeriksaan =  $query = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM maintenance.evaluation an
            WHERE an.app_status_id IN ('.$mAppStatus.')
            '.$queryWorkshop.$querySeniorEngineer.$queryAssignEngginer.$queryAssistantEngginer.$queryPublic.$myApp.'
            '))[0]->total;

        $totalSenggaraanServis = DB::select(DB::raw('
            SELECT COALESCE(count(an.id),0) AS total FROM maintenance.job an
            WHERE an.app_status_id IN ('.$mAppStatus.')
            '.$queryWorkshop.$querySeniorEngineer.$queryAssignEngginer.$queryAssistantEngginer.$queryPublic.$myApp.'
            '))[0]->total;

        Log::info($mAppStatus);
        Log::info($queryWorkshop.$queryAssignEngginer.$queryAssistantEngginer.$queryPublic.$myApp);

        

        $totalLogisticBooking = Auth::user()->totalLogisticBooking(Request());

        $disasterPreparation = Auth::user()->totalLogisticBookingDisaster(Request());

    }

@endphp
{{-- @json($sql) --}}
<style>
    .local-separator {
        position: absolute;
        right:0px;
        top:-4px;
        background-color:rgba(255,255,255,0.3);
        width:140px;
        height:1px;
    }
</style>
<ul>
    @if (in_array($roleAccessCode, array('01','03', '04', '02')) && ( Auth::user()->detail->register_purpose == 'is_jkr' ) && !auth()->user()->isDriver()  )
    <li id="pengrekodlist" style="clear:both"><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;<a href="#" name = "pengrekod" class="pengrekod" id='pengrekod'
            onclick="toggleSubMenuSpecial(this,'{{ route('vehicle.overview') }}');">PENGURUSAN REKOD</a>
        <ul class="subside">
            <!--<li><a href="javascript:openFromMenu('{{ route('vehicle.overview') }}')">Sepintas Lalu</a></li>-->
            {{-- @if ($AccessVehicle->mod_fleet_r == 1) --}}
                <li>
                    @if ($totalVehicle > 0)
                    <span class="badge bg-spakat">{{ $totalVehicle }}</span>
                    @endif
                    {{-- <a id="rekodkenderaan" href="javascript:openFromMenu('{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 5, 'ownership' => 'jkr', 'fleet_view' =>  'department']) }}')">Rekod Kenderaan</a> --}}
                    {{-- <a id="rekodkenderaan" href="javascript:openFromMenu('{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 10, 'ownership' => 'jkr', 'fleet_view' =>  'department']) }}')">Rekod Kenderaan</a> --}}
                    <a id="rekodkenderaan" href="javascript:openFromMenu('{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 10, 'ownership' => 'jkr', 'fleet_view' =>  'department']) }}')">Rekod Kenderaan</a>
                </li>
                {{-- <li>
                    <a id="rekodkenderaan" href="javascript:openFromMenu('{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 10, 'ownership' => 'jkr', 'fleet_view' =>  'department']) }}')">Rekod Kenderaan</a>
                </li> --}}
            {{-- @endif --}}
            {{-- @if ($AccessVehicleSummon->mod_fleet_r == 1) --}}
                @if (in_array($roleAccessCode, array('01','03')))
                <li><a href="javascript:openFromMenu('{{ route('vehicle.saman.rekod', ['limit' => 5]) }}')">Rekod Saman</a></li>
                @endif
                @if (in_array($roleAccessCode, array('04')))
                <li><a href="javascript:openFromMenu('{{ route('vehicle.saman.rekodbayar') }}')">Bayaran Saman</a></li>
                @endif
            {{-- @endif --}}
            @if (in_array($roleAccessCode, array('01','03')))
            {{-- <li><a href="javascript:openFromMenu('{{ route('vehicle.archive') }}')">Arkib</a></li> --}}
            {{-- <li><a href="javascript:openFromMenu('{{route('vehicle.list', ['status' => '', 'xmode' => $xmode, 'ownership' => 'disposal' , 'fleet_view' =>  'disposal'])}}')">Arkib</a></li> --}}
            <li><a id="rekodkenderaan" href="javascript:openFromMenu('{{ route('vehicle.list-alternate', ['offset' => 0, 'limit' => 10, 'ownership' => 'disposal', 'fleet_view' =>  'disposal']) }}')">Rekod Arkib</a></li>
                @if($AccessVehicleReport->mod_fleet_r)
                    <li><a href="javascript:openFromMenu('{{ route('vehicle.report') }}')">Laporan &amp; Statistik</a></li>
                @endif
            @endif
            @if (in_array($roleAccessCode, array('02')))
                @if($AccessVehicleReport->mod_fleet_r)
                    <li><a href="javascript:openFromMenu('{{ route('vehicle.report') }}')">Laporan &amp; Statistik</a></li>
                @endif
            @endif
        </ul>
    </li>
    @endif
    @if (in_array($roleAccessCode, array('01','03','04','02')))
    @if(
        $AccessAssessmentNew->mod_fleet_r ||
        $AccessAssessmentSafety->mod_fleet_r||
        $AccessAssessmentCurrValue->mod_fleet_r ||
        $AccessAssessmentAccident->mod_fleet_r ||
        $AccessAssessmentDisposal->mod_fleet_r ||
        $AccessAssessmentGovloan->mod_fleet_r
    )
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;
        @if (in_array($roleAccessCode, array('01','02', '03')))
            <a href="#" onclick="toggleSubMenuSpecial(this,'{{ route('assessment.overview')}}')">PENILAIAN</a>
        @else
            <a href="#" onclick="toggleSubMenu(this)">PENILAIAN</a>
        @endif
        <ul class="subside">
            @if (in_array($roleAccessCode, array('01','03','04')))
                <li><span class="badge bg-spakat" {{$totalPenilaianBaru==0 ? "style=display:none" : ''}}>{{$totalPenilaianBaru}}</span> <a href="javascript:openFromMenu('{{ route('assessment.new.list') }}')">Kenderaan Baharu</a></li>
                {{-- @if (!(Auth()->user()->isPublic())) --}}
                <li><span class="badge bg-spakat" {{$totalPenilaianKeselamatan==0 ? "style=display:none" : ""}}>{{$totalPenilaianKeselamatan}}</span><a href="javascript:openFromMenu('{{ route('assessment.safety.list') }}')">Keselamatan &amp; Prestasi</a></li>
                {{-- @endif --}}
                <li><span class="badge bg-spakat" {{$totalPenilaianNilaiSemasa==0 ? "style=display:none" : ""}}>{{$totalPenilaianNilaiSemasa}}</span><a href="javascript:openFromMenu('{{ route('assessment.currvalue.list') }}')">Harga Semasa</a></li>
                <li><span class="badge bg-spakat" {{$totalPenilaianKemalangan==0 ? "style=display:none" : ""}}>{{$totalPenilaianKemalangan}}</span><a href="javascript:openFromMenu('{{ route('assessment.accident.list') }}')">Kemalangan</a></li>
                {{-- @if (!(Auth()->user()->isPublic())) --}}
                <li><span class="badge bg-spakat" {{$totalPenilaianPinjaman==0 ? "style=display:none" : ""}}>{{$totalPenilaianPinjaman}}</span><a href="javascript:openFromMenu('{{ route('assessment.gov_loan.list') }}')">Pinjaman Kerajaan</a></li>
                <li><span class="badge bg-spakat" {{$totalPenilaianPelupusan==0 ? "style=display:none" : ""}}>{{$totalPenilaianPelupusan}}</span><a href="javascript:openFromMenu('{{ route('assessment.disposal.list') }}')">Pelupusan</a></li>
                {{-- @endif --}}
                
                @if (in_array($roleAccessCode, array('01', '03')))
                <li style="position: relative;margin-top:5px;padding-top:5px">
                    <div class="local-separator"></div>
                    {{-- <a href="javascript:openFromMenu('{{ route('assessment.calendar') }}')">Jadual Temujanji</a></li> --}}
                <li><a href="javascript:openFromMenu('{{ route('assessment.depreciation') }}')">Kalkulator Susut Nilai</a></li>
                    @if($AccessAssessmentReport->mod_fleet_r)
                        <li><a href="javascript:openFromMenu('{{ route('assessment.report') }}')">Laporan &amp; Statistik</a></li>
                    @endif
                @endif
                @elseif (in_array($roleAccessCode, array('02')))
                    @if($AccessAssessmentReport->mod_fleet_r)
                        <li><a href="javascript:openFromMenu('{{ route('assessment.report') }}')">Laporan &amp; Statistik</a></li>
                    @endif
            @endif
        </ul>
    </li>
    @endif
    @if(
        $AccessWarrant->mod_fleet_r ||
        $AccessMaintenance->mod_fleet_r
    )
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" />&nbsp;
        @if (in_array($roleAccessCode, array('01','02', '03')))
            <a href="#" onclick="toggleSubMenuSpecial(this,'{{ route('maintenance.overview')}}')">PENYENGGARAAN</a>
        @else
            <a href="#" onclick="toggleSubMenu(this)">PENYENGGARAAN</a>
        @endif
        <ul class="subside">
            @if (in_array($roleAccessCode, array('02')))
                    @if($AccessMaintenanceReport->mod_fleet_r)
                        <li><a href="javascript:openFromMenu('{{ route('maintenance.report') }}')">Laporan &amp; Statistik</a></li>
                    @endif
                @else
                    @if($AccessWarrant->mod_fleet_r)
                        @php
                            $is_preview = 1;
                            if($AccessWarrant->mod_fleet_u){
                                $is_preview = 0;
                            }
                        @endphp
                        <li><a href="javascript:openFromMenu('{{ route('maintenance.warrant.table', ['is_preview' => $is_preview]) }}')">Agihan Waran</a></li>
                    @endif
                    <li><span class="badge bg-spakat" {{$totalSenggaraanPemeriksaan==0 ? "style=display:none" : ''}}>{{$totalSenggaraanPemeriksaan}}</span> <a href="javascript:openFromMenu('{{ route('maintenance.evaluation.list', [ 'status_code' => 'all_inprogress']) }}')">Pemeriksaan</a></li>
                    <li><span class="badge bg-spakat" {{$totalSenggaraanServis==0 ? "style=display:none" : ""}}>{{$totalSenggaraanServis}}</span> <a href="javascript:openFromMenu('{{ route('maintenance.job.list', ['status_code' => 'all_inprogress']) }}')">Servis & Pembaikan</a></li>

                    @if( Auth::user()->isAdmin() || Auth::user()->detail->register_purpose == 'is_jkr')

                    <!--<li>{{--<span class="badge bg-spakat">0</span>--}} <a href="javascript:openFromMenu('{{ route('maintenance.job.list') }}')">Templat Surat</a></li>-->
                    @endif
                    {{-- @if( Auth::user()->detail->register_purpose !== 'is_jkr')
                    <li><a href="javascript:openFromMenu('{{ route('maintenance.job.nonjkr.register') }}')">Permohonan Baharu {{Auth::user()->isAdmin() ? 'Non JKR' : ''}}</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('assessment.calendar') }}')">Jadual Temujanji {{Auth::user()->isAdmin() ? 'Non JKR' : ''}}</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('vehicle.list-alternate', ['fleet_view' => 'public']) }}')">Rekod Kenderaan {{Auth::user()->isAdmin() ? 'Non JKR' : ''}}</a></li>
                    {{-- <li><a href="javascript:openFromMenu('{{ route('maintenance.job.nonjkr.list') }}')">Pemeriksaan {{Auth::user()->isAdmin() ? 'Non JKR' : ''}}</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('maintenance.job.nonjkr.list') }}')">Penyenggaraan {{Auth::user()->isAdmin() ? 'Non JKR' : ''}}</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('maintenance.job.nonjkr.list') }}')">Pemantauan {{Auth::user()->isAdmin() ? 'Non JKR' : ''}}</a></li>
                    @endif --}}
                    @if (in_array($roleAccessCode, array('01','03')))
                    <li style="position: relative;margin-top:5px;padding-top:5px">
                        <div class="local-separator"></div>
                        {{-- <a href="javascript:openFromMenu('{{ route('maintenance.calendar') }}')">Jadual Temujanji</a></li> --}}
                        @if($AccessMaintenanceReport->mod_fleet_r)
                            <li><a href="javascript:openFromMenu('{{ route('maintenance.report') }}')">Laporan &amp; Statistik</a></li>
                        @endif
                    @endif
            @endif
        </ul>
    </li>
    @endif
    @endif
    @if (in_array($roleAccessCode, array('01','03','04','02'))  && ( Auth::user()->detail->register_purpose == 'is_jkr' ) || ( Auth::user()->detail->register_purpose == 'is_public_jkr' ))
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" />&nbsp;<a href="#"
            onClick="toggleSubMenuSpecial(this,'{{ route('logistic.overview') }}');">LOGISTIK</a>
        <ul class="subside">
            @if (in_array($roleAccessCode, array('01','03','04','02')) || ( Auth::user()->detail->register_purpose == 'is_jkr' || Auth::user()->detail->register_purpose == 'is_public_jkr' ))
                @if(!auth()->user()->isPublic() || (( Auth::user()->detail->register_purpose == 'is_jkr' || Auth::user()->detail->register_purpose == 'is_public_jkr' ) && auth()->user()->isPublic()) )
             <li><span class="badge bg-spakat" {{$totalLogisticBooking==0 ? "style=display:none" : ''}}>{{$totalLogisticBooking}}</span><a href="javascript:openFromMenu('{{ route('logistic.booking.list', ['status_code' => 'all_inprogress' ]) }}')">Tempahan Kenderaan</a></li>
                @endif
                @if($allowDisasterReady->hasActiveSettingSub())
                    <li><span class="badge bg-spakat" {{$disasterPreparation==0 ? "style=display:none" : ''}}>{{$disasterPreparation}}</span><a href="javascript:openFromMenu('{{ route('logistic.disasterready.list') }}')">Siap Siaga Bencana</a></li>
                @endif
            @endif
            @if (Auth::user()->isAdmin() || Auth::user()->isVehicleOfficer())
                <!--<li><a href="javascript:openFromMenu('{{ route('logistic.disasterready.vehicle.list', ['fleet_view' => 'department']) }}')"><i class="fa fa-caret-right" style="filter: brightness(200%) contrast(198%) saturate(45%) grayscale(99%);"></i> Kenderaan</a></li>-->
                <li style="position: relative;margin-top:5px;padding-top:5px">
                    <div class="local-separator"></div>
                <a href="javascript:openFromMenu('{{ route('logistic.disasterready.vehicle.list', ['fleet_view' => 'department', 'limit' => 10]) }}')">Kenderaan Siap Siaga</a></li>
                <li>
                <a href="javascript:openFromMenu('{{ route('logistic.booking.vehicle.grant.list', [ 'limit' => 10]) }}')">Kenderaan Konsesi</a></li>
            @endif
            @if($AccessLogisticReport->mod_fleet_r)
                <li><a href="javascript:openFromMenu('{{ route('logistic.report') }}')">Laporan &amp; Statistik</a></li>
            @endif
            @if(auth()->user()->isDriver() || auth()->user()->isEngineer() || auth()->user()->isAdmin())
            <li><a href="javascript:openFromMenu('{{ route('logistic.driver-task-vehicle') }}')">
                @if(auth()->user()->isEngineer() || auth()->user()->isAdmin())
                    Rekod Tugasan Pemandu
                    @else
                    Tugasan
                @endif

            </a></li>
            @else
            @endif
        </ul>
    </li>
    @endif
    @if (in_array($roleAccessCode, array('01')))
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;<a href="#"
            onClick="toggleSubMenuSpecial(this, '{{route('access.roles.overview')}}');">AKSES</a>
        <ul class="subside" style="display:
        @if (Route::currentRouteName()=='access.user.overview' ||
            Route::currentRouteName()=='access.user.approval' || Route::currentRouteName()=='access.user.registered' ||
            Route::currentRouteName()=='access.user.revoked' || Route::currentRouteName()=='access.user.locked' ) block @endif">
            <!--<li><a href="javascript:openFromMenu('{{route('access.roles.overview')}}')">Sepintas Lalu</a></li>-->
            <li><span class="badge bg-spakat">{{$totalNotYetApprovedUser}}</span> <a class="@if (Route::currentRouteName()=='access.user.approval' ) active @endif"
                    href="javascript:openFromMenu('{{ route('access.user.approval') }}')">Menunggu Kelulusan</a></li>
            {{-- <li><a class="@if (Route::currentRouteName() == 'access.user.registered')active @endif" href="javascript:openFromMenu('{{route('access.user.registered')}})">Pengguna Berdaftar</a></li> --}}
            <li><a href="javascript:openFromMenu('{{ route('access.user.registered') }}')">Pengguna Berdaftar</a></li>
            <li><a
                    href="javascript:openFromMenu('{{ route('access.roles.list', ['offset' => 0, 'limit' => 5]) }}')">Peranan</a>
            </li>
            <li><a href="javascript:openFromMenu('{{ route('access.audit_list') }}')">Jejak Pengguna</a></li>
        </ul>
    </li>
    @elseif(auth()->user()->isCoordinator())
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;<a href="#" onClick="toggleSubMenuSpecial(this, '{{route('access.roles.overview')}}');">AKSES</a>
        <ul class="subside">
            <li><a href="javascript:openFromMenu('{{ route('access.user.registered') }}')">Pengguna Berdaftar</a></li>
        </ul>
    </li>
    @endif
    @if (in_array($roleAccessCode, array('01')))
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;<a href="#"
            onClick="toggleSubMenu(this);">TETAPAN</a>
        <ul class="subside">
            <li><a href="javascript:openFromMenu('{{ route('settings.general') }}')">Opsyen Am</a></li>
            {{-- <li><a href="javascript:openPgInFrame('{{ route('assessment.depreciation') }}')">Jadual Susut Nilai</a></li> --}}
            <li><a href="javascript:openFromMenu('{{ route('settings.depreciation') }}')">Jadual Susut Nilai</a></li>
            <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;<a href="#"
                onClick="toggleSubMenu(this);">Senarai Rujukan</a>
                <ul class="subside">
                    <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-branchowner') }}')">Cawangan/Bahagian</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-agency') }}')">Kementerian</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-category') }}')">Kategori Kenderaan</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-refevent') }}')">Kategori Peristiwa</a></li>
                    {{-- <li><a href="javascript:openPgInFrame('{{ route('report.report_custom') }}')">Laporan Boleh Ubah</a></li> --}}
                    <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-brand') }}')">Pengeluar Kenderaan</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-component') }}')">Komponen Kenderaan</a></li>
                    <li><a href="javascript:openFromMenu('{{ route('reference.placement-location') }}')">Lokasi Penempatan</a></li>
                    {{-- <li><a href="javascript:openFromMenu('{{ route('reference.engine-type') }}')">Jenis Enjin</a></li> --}}
                    {{-- <li><a href="javascript:openFromMenu('{{ route('reference.fuel-type') }}')">Jenis Bahan Api</a></li> --}}
                    {{-- <li><a href="javascript:openFromMenu('{{ route('reference.cooling-system') }}')">Sisem Penyejukan</a></li> --}}
                    {{-- <li><a href="javascript:openFromMenu('{{ route('reference.transmission-type') }}')">Jenis Transmission</a></li> --}}
                    {{-- <li><a href="javascript:openFromMenu('{{ route('reference.suspension-type') }}')">Jenis Suspension</a></li> --}}
                    <li><a href="javascript:openFromMenu('{{ route('reference.component.checklist', ['module' => 'assessment', 'assement_type_code' => '01']) }}')">Senarai Semak</a></li>
                </ul>
            </li>
            <li><a href="javascript:openFromMenu('{{ route('settings.announce') }}')">Pengumuman</a></li>
            {{-- <li><a href="javascript:openPgInFrame('{{ route('reference.agency') }}')">Struktur Agensi</a></li> --}}
            {{-- <li><a href="#')">Templat Surat</a></li> --}}
        </ul>
    </li>
    @endif
   {{--  @if (in_array($roleAccessCode, array('01')))
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;<a href="#"
            onClick="toggleSubMenu(this);">DAFTAR RUJUKAN</a>
        <ul class="subside">
            <li><a href="javascript:openFromMenu('{{ route('reference.agency') }}')">Struktur Agensi</a></li>
            <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-branchowner') }}')">Cawangan/Bahagian</a></li>
            <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-category') }}')">Kategori Kenderaan</a></li>
            <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-brand') }}')">Pengeluar Kenderaan</a></li>
            <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-component') }}')">Komponen Kenderaan</a></li>
            <li><a href="javascript:openFromMenu('{{ route('reference.vehicle-refevent') }}')">Peristiwa</a></li>
            <li><a href="javascript:openFromMenu('{{ route('underconstruction') }}')">Cawangan Woksyop</a></li>
        </ul>
    </li>
    @endif--}}
    <li class="pt-3 pb-3">
        <div class="smallgap"></div>
    </li>
    <li class="mini"><a href="javascript:openFromMenu('{{ route('settings.user-profile') }}')">PROFAIL PERIBADI</a></li>
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;
        <a href="#" onClick="toggleSubMenu(this);">Rujukan</a>
        <ul class="subside">
            <li><a href="{{route('download.user.manual.vehicle')}}">Manual Pengguna Modul Rekod Kenderaan</a></li>
            <li><a href="{{route('download.user.manual.assessment')}}">Manual Pengguna Modul Penilaian</a></li>
            <li><a href="{{route('download.user.manual.maintenance')}}">Manual Pengguna Modul Penyenggaraan</a></li>
            <li><a href="{{route('download.user.manual.logistic')}}">Manual Pengguna Modul Logistik</a></li>
        </ul>
    </li>
    <li><img src="{{ asset('my-assets/img/chevron.svg') }}" class="chevron" /> &nbsp;
        <a href="#" onClick="toggleSubMenu(this);">Muat Turun</a>
        <ul class="subside">
            <li>
                <a href="{{route('download.apk.latest')}}">Aplikasi Mobile (Android)</a>
            </li>
        </ul>
    </li>
    <!--<li class="mini"><a href="javascript:openFromMenu('{{ route('underconstruction') }}')">MEJA BANTUAN</a></li>-->
    <form method="POST" action="{{ route('logout') }}" id="logoutApp">
    @csrf
    <li class="mini"><a href="#" onclick="logout();">LOG KELUAR</a></li>
    </form>
</ul>

