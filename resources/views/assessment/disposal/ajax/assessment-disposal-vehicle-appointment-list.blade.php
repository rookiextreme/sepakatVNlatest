@php
    // $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
    $totalPrice = 0.00;
    foreach ($vehicleList as $vehicle){
        $totalPrice += $vehicle->price;
    }
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentDisposal)</textarea> --}}
<div class="form-group mb-0 pb-0">
    <label for="" class="form-label mb-0">PENUGASAN KHAS  <em class="text-danger"></em></label>
</div>
<div class="table-responsive mt-0 pb-0">
    <table id="fleet-ls" class="table-custom no-footer mt-0 stripe">
        <thead>
            <th class="col-del">
                <input class="form-check-input" name="chkall" id="chkall" type="checkbox">
            </th>
            <th>Bil</th>
            <th>No Pendaftaran</th>
            <th>Kategori > Sub-Kategori > Jenis</th>
            <th>Jenis</th>
            <th>Buatan</th>
            <th >Model</th>
            <th class="lcal-assign">Pembantu Kemahiran</th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td class="pb-0">
                        <input class="form-check-input" name="chkdel" type="checkbox" value="{{$vehicle->id}}" id="chkdel">
                    </td>
                    <td class="pb-0"><div style="font-size: 14px">{{$vehicleList->firstItem() + $index}}</div><input type="hidden" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td class="caps"><small>{{$vehicle->hasCategory ? $vehicle->hasCategory->name : '-'}} > </small>{{$vehicle->hasSubCategory ? $vehicle->hasSubCategory->name : '-'}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td>{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td>{{$vehicle->model_name}}</td>
                    <td style="padding-left:5px;padding-top:3px;padding-bottom:0px;padding-right:5px;">
                        @if($hasAssessmentDisposalDetail->hasStatus->code == '02')
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
            @if(count($vehicleList) == 0)
                <tr class="no-record">
                    <td colspan="8" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
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
   'targetDivList' =>  '#assessment_disposal_vehicle_appointment',
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
        $.post("{{route('assessment.disposal.vehicle-appointment-assign')}}", {
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
