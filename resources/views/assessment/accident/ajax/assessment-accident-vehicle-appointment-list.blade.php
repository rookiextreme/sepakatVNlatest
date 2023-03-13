@php
    $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentAccident)</textarea> --}}

<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th>Bil</th>
            <th>Milik</th>
            <th>No Pendaftaran</th>
            <th class="">Kategori > Sub-Kategori</th>
            <th class="">Jenis</th>
            {{-- <th class="" style="width: 50px;">Buatan</th>
            <th class="" style="width: 50px;">Model</th> --}}
            <th class="">No Repot</th>
            <th class="text-center">Senarai Kenderaan Terlibat</th>
            <th class="text-center">Pembantu Kemahiran</th>
        </thead>
        <tbody>

            @foreach ($vehicleList as $index => $vehicle)
                <tr>
                    <td>{{$vehicleList->firstItem() + $index}}</td>

                    <td>{{$vehicle->is_gover ? 'KERAJAAN' : 'AWAM'}}</td>
                    <td>{{$vehicle->plate_no}}</td>
                    <td>{{$vehicle->hasCategory->name}} > {{$vehicle->hasSubCategory? $vehicle->hasSubCategory->name : ''}}</td>
                    <td>{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : ''}}</td>
                    <td>{{$vehicle->hasAssessmentVehicleStatus->desc}}</td>
                    <td class="text-center">
                        <button type="button" class="btn cux-btn" onclick="listStruckVehicle({{$vehicle->id}})">
                            <i class="fas fa-pen"></i>
                        </button>
                    </td>
                    {{-- <td>{{$vehicle->hasVehicleBrand->name}}</td> --}}
                    {{-- <td>{{$vehicle->model_name}}</td> --}}
                    <td class="text-center">
                        @if($hasAssessmentAccidentDetail->hasStatus->code == '02')
                            <select data-vehicle-id="{{$vehicle->id}}" name="foremen_id" class="foremen" id="foremen_id_{{$vehicle}}">
                                <option value="open">TUGASAN TERBUKA</option>
                               <optgroup label="Spesifik :">
                                @foreach ($foremenList as $foremen)
                                <option {{$vehicle->foremen_by == $foremen->id ? 'selected': ''}} value="{{$foremen->id}}">{{mb_strimwidth(strtoupper($foremen->name), 0, 26, "...")}}</option>
                                @endforeach
                            </select>
                        @else
                            {{$vehicle->foremenBy->name}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- {{$vehicleList->links('pagination.default')}} --}}
@php
$params = [
    // 'form_id' => 1
    'assessment_accident_id' => $assessment_accident_id
];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_accident_vehicle_appointment',
   'params' => $params
])}}

<div class="modal fade" id="viewAssessmentStruckVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="viewAssessmentStruckVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Berlanggar Dengan
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="table-responsive col-md-9 d-flex justify-content-between">
                        <table id="fleet-ls" class="table-custom stripe no-footer">
                            <thead>
                                <tr>
                                    <th class="text-center">No. Pendaftaran</th>
                                    <th class="text-center">Maklumat Kenderaan</th>
                                </tr>
                            </thead>
                            <tbody id="listStruck">
                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <div class="table-responsive col-md-9 d-flex align-bottom">
                            <table id="fleet-ls" class="table-custom stripe no-footer">
                                <thead>
                                    <tr>
                                        <th class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="align-bottom"><span id="totalStruck"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer float-start">
                <div class="row">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
      </div>
    </div>
</div>

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
        $('#assessmentAccidentVehicleDelModal #remove').hide();
        $('#assessmentAccidentVehicleDelModal #close').hide();
        $.post("{{route('assessment.accident.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#assessmentAccidentVehicleDelModal').modal('hide');
            loadAssessmentVehicle();
        })
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
        $.post("{{route('assessment.accident.vehicle-appointment-assign')}}", {
            vehicle_id: vehicle_id,
            user_id: formen_id,
            assign_to: 'formen',
            '_token': '{{ csrf_token() }}'
        },  function(result){

        })
    }

    listStruckVehicle = function(vehicle_id){
        parent.startLoading();

        let viewAssessmentStruckVehicleModal = $('#viewAssessmentStruckVehicleModal');
        $.ajax({
        url: '{{Route("assessment.accident.vehicle.getStruckVehicleForm")}}',
        type: 'get',
        data: {
            "vehicleId": vehicle_id
        },
        dataType: 'json',
        success: function(data) {
            console.log(data.struckList.length);
                    $('#totalStruck').html(data.struckList.length);
                    $('#listStruck').empty();
                        if (data.struckList.length>0){
                            jQuery.each(data.struckList, function(index, value){
                                $('#listStruck').append('<tr><td class="text-center">'+data.struckList[index].accwit_regno+'</td><td class="text-center">'+data.struckList[index].vehicle_desc+'</td>'
                                +'</tr>');
                            });
                        }
                        else {

                            $('#listStruck').append('<tr><td colspan="3" class="text-center pt-5">Tiada Rekod</td></tr>');

                        }

                    parent.stopLoading();
                }
        });
        viewAssessmentStruckVehicleModal.modal('show');
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
