@php
    $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
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
            <th class="text-center" style="width: 50px;">Semakan</th>
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
                    <td class="text-center">
                        <span
                                class="btn cux-btn small"
                                onclick="generateFormExamination({{$vehicle->id}}, '01')"> Semak</span>
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
    'targetDivList' =>  '#maintenance_evaluation_vehicle_evaluation',
    'params' => $params
])}}

<script type="text/javascript">

    const updateEvaluationVehicleStatus = function(vehicle_id, status_code){
        $.post('{{route('maintenance.evaluation.vehicle.updateStatus')}}', {
            '_token': '{{ csrf_token() }}',
            'vehicle_id': vehicle_id,
            'status_code': status_code
        }, function(response){
            console.log(response);
        })

    }

    const generateFormExamination = function(vehicle_id, maintenance_type_code){
        parent.startLoading();
        $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
            maintenance_type_code: maintenance_type_code,
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
