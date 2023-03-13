@php
    $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
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
            <th class="text-center" style="width: 120px;">Kelulusan</th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $vehicle)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name.'>' : ''}}  {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand->name}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td class="text-center">
                        <select data-vehicle-id="{{$vehicle->id}}" name="v_status_code" class="v_status_code" id="v_status_code_{{$vehicle->id}}">
                            <option value="">Sila Pilih</option>
                            <option {{$vehicle->hasMaintenanceVehicleStatus->code == '04' ? 'selected' : ''}} value="04">Lulus</option>
                            <option {{$vehicle->hasMaintenanceVehicleStatus->code == '05' ? 'selected' : ''}} value="05">Gagal</option>
                        </select>
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
    'targetDivList' =>  '#maintenance_evaluation_vehicle_approval',
    'params' => $params
])}}

<script type="text/javascript">

    const updateMaintenanceVehicleStatus = function(vehicle_id, status_code){
        $.post('{{route('maintenance.evaluation.vehicle.updateStatus')}}', {
            '_token': '{{ csrf_token() }}',
            'vehicle_id': vehicle_id,
            'status_code': status_code
        }, function(response){
            console.log(response);
        })

    }

    $(document).ready(function(){

        $('.v_status_code').select2({
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
