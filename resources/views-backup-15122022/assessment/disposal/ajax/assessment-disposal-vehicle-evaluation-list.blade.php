@php
    $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentDisposal)</textarea> --}}
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
            <th class="text-center" style="width: 200px;">Semakan</th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td>{{$vehicleList->firstItem() + $index}}</td>
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
                                    onclick="generateFormExaminationEvaluate({{$vehicle->id}}, '06')"> {{$vehicle->app_datetime  ? 'Tukar': 'Semak'}}</button>

                            {{-- <select data-vehicle-id="{{$vehicle->id}}" name="v_status_code" class="ms-2 evaluate_v_status_code" id="evaluate_v_status_code_{{$vehicle->id}}">
                                <option value="">Sila Pilih</option>
                                <option {{$vehicle->hasAssessmentVehicleStatus->code == '04' ? 'selected' : ''}} value="04">Lulus</option>
                                <option {{$vehicle->hasAssessmentVehicleStatus->code == '05' ? 'selected' : ''}} value="05">Gagal</option>
                            </select> --}}
                        </div>
                    </td>
                </tr>
            @endforeach
            @if(count($vehicleList) == 0)
                <tr class="no-record">
                    <td colspan="9" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@php
$params = [
    // 'form_id' => 1
    'assessment_disposal_id' => $assessment_disposal_id
];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_disposal_vehicle_evaluation',
   'params' => $params
])}}

<script type="text/javascript">

    updateEvaluationVehicleStatus = function(vehicle_id, status_code){
        $.post('{{route('assessment.disposal.vehicle.updateStatus')}}', {
            '_token': '{{ csrf_token() }}',
            'vehicle_id': vehicle_id,
            'status_code': status_code
        }, function(response){
            console.log(response);
        })

    }

    generateFormExaminationEvaluate = function(vehicle_id,assessment_type_code ){
        parent.startLoading();
        $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
            assessment_type_code: assessment_type_code,
            vehicle_id: vehicle_id,
            tab: 5,
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

