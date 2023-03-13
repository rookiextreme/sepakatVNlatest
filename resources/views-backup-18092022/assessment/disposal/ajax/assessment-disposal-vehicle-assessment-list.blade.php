@php
    $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentDisposal)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th>Bil</th>
            <th>No Pendaftaran</th>
            <th class="">Kategori > Sub-Kategori</th>
            <th class="">Jenis</th>
            <th class="" style="width: 50px;">Buatan</th>
            <th class="" style="width: 50px;">Model</th>
            <th class="">Status</th>
            <th class="text-center" style="width: 90px;">CKM.KB.01</th>
        </thead>
        <tbody>
            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td>{{$vehicleList->firstItem() + $index}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : '-'}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : '-'}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasAssessmentVehicleStatus ? $vehicle->hasAssessmentVehicleStatus->desc : '-'}}</td>
                    <td class="text-center">
                        {{-- @if(in_array($vehicle->hasAssessmentVehicleStatus->code, ['01','02'])) --}}
                            <div class="btn-group">
                                <span
                                    class="btn cux-btn small"
                                    onclick="generateFormExamination({{$vehicle->id}}, '06')"> {{$vehicle->app_datetime ? 'Tukar': 'Semak'}}</span>
                            </div>
                        {{-- @endif --}}
                    </td>
                </tr>
            @endforeach
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
   'targetDivList' =>  '#assessment_disposal_vehicle_assessment',
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
        $('#assessmentDisposalVehicleDelModal #remove').hide();
        $('#assessmentDisposalVehicleDelModal #close').hide();
        $.post("{{route('assessment.disposal.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#assessmentDisposalVehicleDelModal').modal('hide');
            loadAssessmentVehicle();
        })
    }

    generateFormExamination = function(vehicle_id, assessment_type_code){
        parent.startLoading();
        $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
            assessment_type_code: assessment_type_code,
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
