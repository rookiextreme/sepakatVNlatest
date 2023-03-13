@php
    $TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceJob)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom stripe no-footer">
        <thead>
            <th>Bil</th>
            <th>Milik</th>
            <th>No Pendaftaran</th>
            <th class="">Kategori > Sub-Kategori</th>
            <th class="">Jenis</th>
            <th class="" style="width: 50px;">Buatan</th>
            <th class="" style="width: 50px;">Model</th>
            <th class="" style="width: 50px;">Bahan Bakar</th>
            <th class="">Status</th>
            <th class="text-center"></th>
        </thead>
        <tbody>
            @foreach ($vehicleList as $vehicle)
            @php
                $hasJVEFormDetail = null;
                $isRepairMode = false;
                
                if($vehicle->hasExamform->hasFormRepairInternal && 
                    $vehicle->hasExamform->hasFormRepairInternal->first() && 
                    $vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus &&
                    $vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01' &&
                    $vehicle->hasExamform->hasFormRepairInternal->first()->is_research_market == 2 &&
                    in_array($vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code, ['01', '02', '07'])){
                    $hasJVEFormDetail = $vehicle->hasExamform->hasFormRepairInternal->first();
                    $isRepairMode = true;

                    // echo "1\n";
                    // echo $vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code;
                }
                else if($vehicle->hasExamform->hasFormRepairInternal && 
                    $vehicle->hasExamform->hasFormRepairInternal->first() && 
                    $vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus &&
                    $vehicle->hasExamform->hasFormRepairInternal->first()->is_research_market != 2 &&
                    $vehicle->hasExamform->hasFormRepairInternal->first()->hasRepairMethod->code == '01' &&
                    in_array($vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code, ['01', '02', '07'])){
                    $hasJVEFormDetail = $vehicle->hasExamform->hasFormRepairInternal->first();
                    if($vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code !== '11' || ($vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code == '11' && $vehicle->hasExamform->hasFormRepairInternal->first()->hasInternalRepairStatus->code == '02')){
                        $isRepairMode = true;
                    }
                    // echo "2\n";
                    // echo $vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code;
                    
                }
                else if($vehicle->hasExamform->hasFormRepairExternal && 
                    $vehicle->hasExamform->hasFormRepairExternal->first() && 
                        $vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus &&
                        $vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02' &&
                        $vehicle->hasExamform->hasFormRepairExternal->first()->is_research_market == 2 &&
                        $vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code == '05'){
                    $hasJVEFormDetail = $vehicle->hasExamform->hasFormRepairExternal->first();
                    $isRepairMode = true;

                    // echo "3\n";
                    // echo $vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code;
                }
                else if($vehicle->hasExamform->hasFormRepairExternal &&
                    $vehicle->hasExamform->hasFormRepairExternal->first() && 
                    $vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus && 
                    $vehicle->hasExamform->hasFormRepairExternal->first()->is_research_market != 2 &&
                    $vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus && 
                    $vehicle->hasExamform->hasFormRepairExternal->first()->hasRepairMethod->code == '02' &&
                    in_array($vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code, ['04', '05', '08'])) {
                    $hasJVEFormDetail = $vehicle->hasExamform->hasFormRepairExternal->first();
                    if($vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code !== '11' || ($vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code == '11' && $vehicle->hasExamform->hasFormRepairExternal->first()->hasExternalRepairStatus->code == '05')){
                        $isRepairMode = true;
                    }
                    // echo "4\n";
                    // echo $vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code;

                } else if($vehicle->hasExamform->hasRepairMethod() && $vehicle->hasExamform->hasFormRepairIsMarketResearchStarted->count() !== 0 && $vehicle->hasExamform->hasFormRepairInternal){
                    $hasJVEFormDetail = $vehicle->hasExamform->hasFormRepairInternal->first();
                    $isRepairMode = true;

                    // echo "5\n";
                    // echo $vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code;
                } else {
                    $hasJVEFormDetail = $vehicle->hasExamform;
                    // echo "6\n";
                    // echo $vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code;
                }
            @endphp
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name.' >' : ''}} {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasFuelType->desc}}</td>
                    {{-- sini --}}
                    <td>
                        @if($hasJVEFormDetail && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '12')
                            Servis dan pembaikan telah selesai
                        @else
                            @if($hasJVEFormDetail && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus && in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['11']))
                                Menunggu Pembaikan / Servis
                                @else
                                - {{$vehicle->hasMaintenanceVehicleStatus->desc}}
                            @endif
                        @endif
                        <div>
                            @if($hasJVEFormDetail)
                                <label for="" class="form-label pt-1 ps-2">
                                    @php
                                        $mapMJOBV = [
                                            '05' => [
                                                'p1' => 'SEDIAKAN KAJIAN PASARAN',
                                                'p2' => 'CKM.J.02'
                                            ],
                                            '06' => [
                                                'p1' => 'SEMAKAN KAJIAN PASARAN',
                                                'p2' => 'CKM.J.02'
                                            ],
                                            '08' => [
                                                'p1' => 'SEDIAKAN JADUAL HARGA',
                                                'p2' => ''
                                            ],
                                            '09' => [
                                                'p1' => 'SEMAKAN JADUAL HARGA',
                                                'p2' => ''
                                            ],
                                            '10' => [
                                                'p1' => 'PENGESAHAN JADUAL HARGA',
                                                'p2' => ''
                                            ]
                                        ];
                                    @endphp
                                    @if(isset($mapMJOBV[$hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code]))
                                        - {{$mapMJOBV[$hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code]['p1']}}
                                    @else
                                        @if($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '11' && $hasJVEFormDetail->hasInternalRepairStatus && $hasJVEFormDetail->hasInternalRepairStatus->code == '02')
                                        - {{$hasJVEFormDetail->hasInternalRepairStatus->desc}}
                                        @elseif($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '11' && $hasJVEFormDetail->hasExternalRepairStatus && $hasJVEFormDetail->hasExternalRepairStatus->code == '05')
                                        - {{$hasJVEFormDetail->hasExternalRepairStatus->desc}}
                                        @else
                                        - {{$hasJVEFormDetail->hasMaintenanceJobVehicleStatus->desc}}
                                        @endif
                                    @endif
                                </label>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        @if($hasJVEFormDetail)
                            @if(
                                in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['01','02','07']) && auth()->user()->isForemenMaintenance() ||
                                in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['01','02','03','04','05','08','11']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()) ||
                                in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['06','09']) && (auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()) ||
                                in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['10']) && (auth()->user()->isSeniorEngineer() || auth()->user()->isSeniorEngineerMaintenance())
                                )
                                @if(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['03']))
                                    {{-- @if(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['03']) || $hasJVEFormDetail->hasFormRepairIsMarketResearchStarted->count() == 0) --}}
                                    <label for="" class="form-label">CKM.J.01</label>
                                    <span onclick="generateFormAssessment({{$vehicle->id}}, '02')" class="btn cux-btn small" > Teruskan </span>
                                @elseif(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['04','05','06']))
                                    @if($hasJVEFormDetail->hasJVEForm && $hasJVEFormDetail->hasJVEForm->hasFormRepairWithSort)
                                        <div class="btn-group">
                                            @foreach ($hasJVEFormDetail->hasJVEForm->hasFormRepairWithSort as $hasFormRepair)
                                                {{-- {{$hasFormRepair->hasRepairMethod->code}}
                                                {{$hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code}} --}}
                                                @if(in_array($hasFormRepair->hasRepairMethod->id, explode(',',$hasJVEFormDetail->hasJVEForm->repair_method)))
                                                    @if($hasFormRepair->hasRepairMethod->code == '01' && (( $hasJVEFormDetail->hasInternalRepairStatus && in_array($hasJVEFormDetail->hasInternalRepairStatus->code, ['01', '02']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @elseif((auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()) && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '05' && $hasFormRepair->hasRepairMethod->code == '01' && (( $hasJVEFormDetail->hasInternalRepairStatus && in_array($hasJVEFormDetail->hasInternalRepairStatus->code, ['07']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @elseif((auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()) && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '06' && $hasFormRepair->hasRepairMethod->code == '01' && (( $hasJVEFormDetail->hasInternalRepairStatus && in_array($hasJVEFormDetail->hasInternalRepairStatus->code, ['01', '02', '07']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                     @elseif((auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())  && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '05' && $hasFormRepair->hasRepairMethod->code == '02' && (( $hasJVEFormDetail->hasRepairMethod && !in_array($hasJVEFormDetail->hasRepairMethod->code, ['03']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @elseif((auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()) && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '05' && $hasFormRepair->hasRepairMethod->code == '02' && (( $hasJVEFormDetail->hasExternalRepairStatus && in_array($hasJVEFormDetail->hasExternalRepairStatus->code, ['08']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @elseif((auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()) && $hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code == '06' && $hasFormRepair->hasRepairMethod->code == '02' && (( $hasJVEFormDetail->hasExternalRepairStatus && in_array($hasJVEFormDetail->hasExternalRepairStatus->code, ['08']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @elseif(
                                                    (!$hasJVEFormDetail->hasJVEForm->hasInternalRepairStatus || $hasJVEFormDetail->hasJVEForm->hasInternalRepairStatus->code == '03') && $hasFormRepair->hasRepairMethod->code == '02' && (( $hasJVEFormDetail->hasExternalRepairStatus && in_array($hasJVEFormDetail->hasExternalRepairStatus->code, ['04', '05']))))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                @elseif(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['08','09','10']))
                                    @if($hasJVEFormDetail->hasFormRepairWithSort)
                                        <div class="btn-group">
                                            @foreach ($hasJVEFormDetail->hasFormRepairWithSort as $hasFormRepair)
                                                @if(in_array($hasFormRepair->hasRepairMethod->id, explode(',',$hasJVEFormDetail->repair_method)))
                                                    @if($hasJVEFormDetail->hasExternalRepairStatus && $hasFormRepair->hasRepairMethod->code == '02')
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                        @elseif((!$hasJVEFormDetail->hasInternalRepairStatus && $hasFormRepair->hasRepairMethod->code == '01') || ($hasJVEFormDetail->hasInternalRepairStatus && $hasFormRepair->hasRepairMethod->code == '01'))
                                                        <button type="button" data-repair-method="{{$hasFormRepair->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasFormRepair->hasRepairMethod->desc}}</button>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </div>
                                        @else
                                        <div class="btn-group">
                                            @if(in_array($hasJVEFormDetail->hasRepairMethod->id, explode(',',$hasJVEFormDetail->hasJVEForm->repair_method)))
                                                @if($hasJVEFormDetail->hasExternalRepairStatus && $hasJVEFormDetail->hasRepairMethod->code == '02')
                                                    <button type="button" data-repair-method="{{$hasJVEFormDetail->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasJVEFormDetail->hasRepairMethod->desc}}</button>
                                                    @elseif((!$hasJVEFormDetail->hasInternalRepairStatus && $hasJVEFormDetail->hasRepairMethod->code == '01') || ($hasJVEFormDetail->hasInternalRepairStatus && $hasJVEFormDetail->hasRepairMethod->code == '01'))
                                                    <button type="button" data-repair-method="{{$hasJVEFormDetail->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasJVEFormDetail->hasRepairMethod->desc}}</button>
                                                @endif
                                            @endif
                                        </div>
                                    @endif

                                    @elseif(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['11']) && $isRepairMode)
                                    <div class="btn-group">
                                        @if(in_array($hasJVEFormDetail->hasRepairMethod->id, explode(',',$hasJVEFormDetail->hasJVEForm->repair_method)))
                                            @if($hasJVEFormDetail->hasInternalRepairStatus && $hasJVEFormDetail->hasInternalRepairStatus->code == '02' && $hasJVEFormDetail->hasRepairMethod->code == '01')
                                                <button type="button" data-repair-method="{{$hasJVEFormDetail->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasJVEFormDetail->hasRepairMethod->desc}}</button>
                                            @elseif((!$hasJVEFormDetail->hasInternalRepairStatus && $hasJVEFormDetail->hasExternalRepairStatus && $hasJVEFormDetail->hasExternalRepairStatus->code == '05') || ($hasJVEFormDetail->hasExternalRepairStatus && $hasJVEFormDetail->hasExternalRepairStatus->code == '05' && $hasJVEFormDetail->hasRepairMethod->code == '02'))
                                            <button type="button" data-repair-method="{{$hasJVEFormDetail->hasRepairMethod->id}}" onclick="generateFormAssessment({{$vehicle->id}}, '02', this)" class="btn cux-btn small text-uppercase">{{$hasJVEFormDetail->hasRepairMethod->desc}}</button>
                                            @endif
                                        @endif
                                    </div>
                                    @elseif(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['11']) && $hasJVEFormDetail->hasInternalRepairStatus && $hasJVEFormDetail->hasInternalRepairStatus->code == '02')
                                        <span onclick="generateFormAssessment({{$vehicle->id}}, '02')" class="btn cux-btn small" > Teruskan </span>
                                    @elseif(in_array($hasJVEFormDetail->hasMaintenanceJobVehicleStatus->code, ['11']) && $hasJVEFormDetail->hasExternalRepairStatus && $hasJVEFormDetail->hasExternalRepairStatus->code == '05')
                                        <span onclick="generateFormAssessment({{$vehicle->id}}, '02')" class="btn cux-btn small" > Teruskan </span>
                                @endif
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
@php
    $params = [
        // 'form_id' => 1
    ];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
    'targetDivList' =>  '#maintenance_job_vehicle_assessment',
    'params' => $params
])}}

<script type="text/javascript">

    var ids = [];

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }

    function remove(){
        $('#maintenanceJobVehicleDelModal #remove').hide();
        $('#maintenanceJobVehicleDelModal #close').hide();
        $.post("{{route('maintenance.job.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#maintenanceJobVehicleDelModal').modal('hide');
            loadMaintenanceVehicle();
        })
    }

    generateFormAssessment = function(vehicle_id, maintenance_type_code_selected, self){
        parent.startLoading();

        let tab = $(self).data('tab');
        let repair_method_id = $(self).data('repair-method');
        $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
            maintenance_type_code: maintenance_type_code_selected,
            vehicle_id: vehicle_id,
            repair_method_id: repair_method_id,
            tab: tab,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;

        })
    }

    $(document).ready(function(){

    $('[name="chkall"]').change(function() {

        $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

        $('[name="chkall"]').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

    });
</script>
