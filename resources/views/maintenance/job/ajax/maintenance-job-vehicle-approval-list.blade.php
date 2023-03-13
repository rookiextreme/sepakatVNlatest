@php
    $TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentAccident)</textarea> --}}
<div class="table-responsive">
    {{-- <table id="fleet-ls" class="table display compact stripe hover compact table-bordered"> --}}
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
            <th class="text-center" style="width: 180px;">Semakan</th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $vehicle)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : ''}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasFuelType->desc}}</td>
                    <td>
                        {{$vehicle->hasMaintenanceVehicleStatus->desc}}
                        <div>
                            @if($vehicle->hasExamform)
                                <label for="" class="form-label pt-1 ps-2">
                                    - {{$vehicle->hasExamform->hasMaintenanceJobVehicleStatus->desc}}
                                </label>

                                    @if($vehicle->hasExamform->hasInternalRepairStatus)
                                        <div>
                                            <label class="ps-4 form-label d-inline">
                                                - {{$vehicle->hasExamform->hasInternalRepairStatus->desc}}
                                            </label>
                                            @if(in_array($vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code, ['11']) && in_array($vehicle->hasExamform->hasInternalRepairStatus->code, ['01','02']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                                                <br/><span class="btn btn-sm btn-secondary ms-4" onclick="generateFormApproval({{$vehicle->id}}, '02', 4)"> Semak</span>
                                            @endif
                                        </div>
                                    @endif
                                    @if($vehicle->hasExamform->hasExternalRepairStatus)
                                        <div class="mt-2">
                                            <label class="ps-4 form-label d-inline">
                                                - {{$vehicle->hasExamform->hasExternalRepairStatus->desc}}
                                            </label>
                                            @if(in_array($vehicle->hasExamform->hasMaintenanceJobVehicleStatus->code, ['11']) && in_array($vehicle->hasExamform->hasExternalRepairStatus->code, ['04','05']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                                            <br/><span class="btn btn-sm btn-secondary ms-4" onclick="generateFormApproval({{$vehicle->id}}, '02', 5)"> Semak</span>
                                            @endif
                                        </div>
                                    @endif
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="input-group flex-nowrap">
                            <span class="btn cux-btn"
                            style="height: 42px;margin-right: -4px;border-top: 2px #dfdfdf solid;border-bottom: 2px #dfdfdf solid;border-left: 2px #dfdfdf solid;line-height: 24px;"
                            onclick="generateFormApproval({{$vehicle->id}}, '02', 1)"> Semak</span>
                            <select data-vehicle-id="{{$vehicle->id}}" name="job_vp_status_code" class="ms-2 job_vp_status_code" id="job_vp_status_code_{{$vehicle->id}}">
                                <option value="">Sila Pilih</option>
                                <option {{$vehicle->hasMaintenanceVehicleStatus->code == '04' ? 'selected' : ''}} value="04">Lulus</option>
                                <option {{$vehicle->hasMaintenanceVehicleStatus->code == '05' ? 'selected' : ''}} value="05">Gagal</option>
                            </select>
                        </div>
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
    'targetDivList' =>  '#maintenance_job_vehicle_list',
    'params' => $params
])}}

<script type="text/javascript">

    const updateMaintenanceVehicleStatus = function(vehicle_id, status_code){
        $.post('{{route('maintenance.job.vehicle.updateStatus')}}', {
            '_token': '{{ csrf_token() }}',
            'vehicle_id': vehicle_id,
            'status_code': status_code
        }, function(response){
            console.log(response);
        })

    }

    const generateFormApproval = function(vehicle_id, maintenance_type_code_selected, tab){
        parent.startLoading();
        $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
            maintenance_type_code: maintenance_type_code_selected,
            vehicle_id: vehicle_id,
            tab: tab,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;

        })
    }

    $(document).ready(function(){

        $('.job_vp_status_code').select2({
            'width': "100%",
            'theme': "classic"
        }).on('change', function(e){
            e.preventDefault();
            let aVehicleId = $(this).attr('data-vehicle-id');
            let code = this.value;
            updateMaintenanceVehicleStatus(aVehicleId, code);
            console.log(this);
        });

    });
</script>
