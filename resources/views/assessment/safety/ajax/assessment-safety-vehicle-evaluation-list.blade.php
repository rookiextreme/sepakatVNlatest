@php
    $TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentSafety)</textarea> --}}
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
            <th class="" style="width: 50px;">Status</th>
            <th class="text-center">Semakan</th>
            <th></th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td class="pb-0"><div style="font-size: 14px">{{$vehicleList->firstItem() + $index}}</div><input type="hidden" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : '-'}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : '-'}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasAssessmentVehicleStatus ? $vehicle->hasAssessmentVehicleStatus->desc : '-'}}</td>

                    <td class="text-center">
                        {{-- {{$vehicle->hasAssessmentVehicleStatus->code == "04"}} --}}
                        <div class="d-flex justify-content-center">
                                <button style="height: 30px;"
                                    type="button"
                                    class="btn cux-btn small"
                                    {{$vehicle->hasAssessmentVehicleStatus->code == "04" ? '' : 'disabled'}}
                                    onclick="generateFormExaminationEvaluate({{$vehicle->id}}, '02', '{{$status_code}}')"> {{$vehicle->app_datetime  ? 'Tukar': 'Semak'}}</button>

                            {{-- <select data-vehicle-id="{{$vehicle->id}}" name="v_status_code" class="ms-2 evaluate_v_status_code" id="evaluate_v_status_code_{{$vehicle->id}}">
                                <option value="">Sila Pilih</option>
                                <option {{$vehicle->hasAssessmentVehicleStatus->code == '04' ? 'selected' : ''}} value="04">Lulus</option>
                                <option {{$vehicle->hasAssessmentVehicleStatus->code == '05' ? 'selected' : ''}} value="05">Gagal</option>
                            </select> --}}
                        </div>
                    </td>
                    <td class="text-center">
                        @if(in_array($vehicle->hasAssessmentVehicleStatus->code, ['03','04']))
                            <div class="btn-group">
                                @if (auth()->user()->isAssistEngineerAssessment() || auth()->user()->isEngineerAssessment() || auth()->user()->isEngineer() || auth()->user()->isAssistEngineer() || auth()->user()->isAdmin())
                                    <a
                                    style="height: unset;"
                                    class="btn cux-btn small"
                                    title="Kemaskini Kenderaan"
                                    data-assessment-type-id="{{$vehicle->hasAssessmentDetail->hasAssessmentType()->id}}"
                                    data-vehicle-id="{{$vehicle->id}}"
                                    onclick="editVehicle(this)"
                                    >
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                            </div>
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
     'assessment_safety_id' => $assessment_safety_id
 ];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
    'targetDivList' =>  '#assessment_safety_vehicle_evaluation',
    'params' => $params
])}}

<script type="text/javascript">

    updateEvaluationVehicleStatus = function(vehicle_id, status_code){
        $.post('{{route('assessment.safety.vehicle.updateStatus')}}', {
            '_token': '{{ csrf_token() }}',
            'vehicle_id': vehicle_id,
            'status_code': status_code
        }, function(response){
            console.log(response);
        })

    }

    generateFormExaminationEvaluate = function(vehicle_id, assessment_type_code, status_code){
        parent.startLoading();
        $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
            assessment_type_code: assessment_type_code,
            vehicle_id: vehicle_id,
            tab: 5,
            status_code: status_code,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;
        })
    }

    $(document).ready(function(){

        $('.evaluate_v_status_code').select2({
            'width': "100%",
            'theme': "classic"
        }).on('change', function(e){
            e.preventDefault();
            let aVehicleId = $(this).attr('data-vehicle-id');
            let code = this.value;
            updateEvaluationVehicleStatus(aVehicleId, code);
            console.log(this);
        });

    });
</script>
