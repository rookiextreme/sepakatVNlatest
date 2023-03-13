@php
    $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceEvaluation)</textarea> --}}
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
            <th class="text-center" style="width: 90px;">CKM.NT.01</th>
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
                    <td>{{$vehicle->hasFuelType->desc}}</td>
                    <td>{{$vehicle->hasMaintenanceVehicleStatus->desc}}</td>
                    <td class="text-center">
                        @if(in_array($vehicle->hasMaintenanceVehicleStatus->code, ['01','02','06','07']))
                        @php
                            $mjevalcode = "01";
                            if($vehicle->hasCategory && $vehicle->hasCategory->code == "02"){
                                $mjevalcode = "03";
                            }
                        @endphp
                            @if(
                                (in_array($vehicle->hasMaintenanceVehicleStatus->code, ['01']) && auth()->user()->isForemenMaintenance()) ||
                                (in_array($vehicle->hasMaintenanceVehicleStatus->code, ['07']) && auth()->user()->isAssistEngineerMaintenance())
                            )
                                <div class="btn-group">
                                    <span
                                    class="btn cux-btn small"
                                    onclick="generateFormExamination({{$vehicle->id}}, '{{$mjevalcode}}')"> Semak</span>
                                </div>
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
    'targetDivList' =>  '#maintenance_evaluation_vehicle_assessment',
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
        $('#maintenanceEvaluationVehicleDelModal #remove').hide();
        $('#maintenanceEvaluationVehicleDelModal #close').hide();
        $.post("{{route('maintenance.evaluation.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#maintenanceEvaluationVehicleDelModal').modal('hide');
            loadMaintenanceVehicle();
        })
    }

    const generateFormExamination = function(vehicle_id, maintenance_type_code){
        parent.startLoading();
        $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
            maintenance_type_code: maintenance_type_code,
            vehicle_id: vehicle_id,
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
