@php
    $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
    $status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';

@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentNew)</textarea> --}}
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
            <th class="text-center" style="width: 120px;">Semakan</th>
            {{-- <th class="text-center" style="width: 120px;">Kelulusan</th> --}}
        </thead>
        <tbody>

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td>{{$vehicleList->firstItem() + $index}}<input type="hidden" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <td>{{$vehicle->is_gover ? 'Kerajaan' : 'Awam'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : '-'}} > {{$vehicle->hasSubCategory ? $vehicle->hasSubCategory->name : '-'}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td>{{$vehicle->hasAssessmentVehicleStatus ? $vehicle->hasAssessmentVehicleStatus->desc : '-'}}</td>
                    <td>
                        <button style="height: 30px;"
                                    type="button"
                                    class="btn cux-btn small"
                                    {{$vehicle->hasAssessmentVehicleStatus->code == "05" ? '' : 'disabled'}}
                                    onclick="generateFormExamination({{$vehicle->id}}, '01','{{$status_code}}')"> {{$vehicle->app_datetime  ? 'Tukar': 'Semak'}}</button>
                    </td>
                    {{-- <td class="text-center">
                        @if($vehicle->hasAssessmentVehicleStatus->code == "05")
                        <select data-vehicle-id="{{$vehicle->id}}" name="v_status_code" class="v_status_code" id="v_status_code_{{$vehicle->id}}">
                            <option {{$vehicle->approval == 0 ? 'selected' : ''}} value="0">Sila Pilih</option>
                            <option {{$vehicle->approval == 1 ? 'selected' : ''}} value="1">Lulus</option>
                            <option {{$vehicle->approval == 2 ? 'selected' : ''}} value="0">Gagal</option>
                        </select>
                        @else
                        @endif
                    </td> --}}
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
    'targetDivList' =>  '#assessment_new_vehicle_approval',
    'params' => $params
])}}

<script type="text/javascript">

    updateAssessmentVehicleStatusNew = function(vehicle_id, status_code){
        $.post('{{route('assessment.new.vehicle.updateStatus')}}', {
            '_token': '{{ csrf_token() }}',
            'vehicle_id': vehicle_id,
            'status_code': status_code
        }, function(response){
            // console.log(response);
            // window.location.reload();
        })

    }

    generateFormExamination = function(vehicle_id, assessment_type_code_selected, status_code){
        if(vehicle_id){
            selected_vehicle_id = vehicle_id;
        }
        if(assessment_type_code_selected){
            assessment_type_code = assessment_type_code_selected;
        }
        parent.startLoading();
        $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
            assessment_type_code: assessment_type_code,
            vehicle_id: selected_vehicle_id,
            status_code: status_code,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            window.location.href = result.url;
        })
    }


    $(document).ready(function(){

        $('.v_status_code').select2({
            'width': "100%",
            'theme': "classic",
            'placeholder' : "[Sila Pilih]"
        // }).on('change', function(e){
        //     e.preventDefault();
        //     let aVehicleId = $(this).attr('data-vehicle-id');
        //     let code = this.value;
        //     updateAssessmentVehicleStatusNew(aVehicleId, code);
        //     console.log(this);
        });

    });
</script>
