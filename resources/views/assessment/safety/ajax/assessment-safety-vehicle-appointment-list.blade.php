@php
    $TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentSafety)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th class="col-del">
                <input class="form-check-input" name="chkall" id="chkall" type="checkbox">
            </th>
            <th>Bil</th>
            <!--<th>Milik</th>-->
            <th>No Pendaftaran</th>
            <th class="">Kategori > Sub-Kategori</th>
            <th class="">Jenis</th>
            <th class="" style="width: 50px;">Buatan</th>
            <th class="" style="width: 50px;">Model</th>
            <th class="">Status</th>
            <th class="text-center">Pembantu Kemahiran</th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td class="pb-0">
                        <input class="form-check-input" name="chkdel" type="checkbox" value="{{$vehicle->id}}" id="chkdel">
                    </td>
                    <td class="pb-0"><div style="font-size: 14px">{{$vehicleList->firstItem() + $index}}</div><input type="hidden" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <!--<td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>-->
                    <td>{{$vehicle->plate_no}}</td>
                    <td class="caps">{{$vehicle->hasCategory->name ? $vehicle->hasCategory->name : '-'}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : '-'}}</td>
                    <td class="caps">{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name ? $vehicle->model_name : '-'}}</td>
                    <td class="caps">{{$vehicle->hasAssessmentVehicleStatus ? $vehicle->hasAssessmentVehicleStatus->desc : '-'}}</td>
                    <td class="text-center">
                        @if($hasAssessmentSafetyDetail->hasStatus->code == '02')
                            <select data-vehicle-id="{{$vehicle->id}}" name="foremen_id" class="foremen" id="foremen_id_{{$vehicle}}">
                                <option value="open">TUGASAN TERBUKA</option>
                                <optgroup label="Spesifik :">
                                @foreach ($foremenList as $foremen)
                                <option {{$vehicle->foremen_by == $foremen->id ? 'selected': ''}} value="{{$foremen->id}}">{{mb_strimwidth(strtoupper($foremen->name), 0, 26, "...")}}</option>
                                @endforeach
                            </select>
                        @else
                            {{$vehicle->foremenBy ? $vehicle->foremenBy->name : '-'}}
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
    'targetDivList' =>  '#assessment_safety_vehicle_appointment',
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

    generateFormExamination = function(vehicle_id){
        parent.startLoading();
        $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
            vehicle_id: vehicle_id,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;
        })
    }

    assignToFormen = function(vehicle_id, formen_id){
        $.post("{{route('assessment.safety.vehicle-appointment-assign')}}", {
            vehicle_id: vehicle_id,
            user_id: formen_id,
            assign_to: 'formen',
            '_token': '{{ csrf_token() }}'
        },  function(result){

        })
    }

    $(document).ready(function(){

    $('.foremen').select2({
        'width': "100%",
        'theme': "classic"
    }).on('change', function(e){
        e.preventDefault();

        let vehicle_id = $(this).attr('data-vehicle-id');
        let forment_id = this.value;
        assignToFormen(vehicle_id, forment_id);
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
