@php
    $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
    // $totalPrice = 0.00;
    // foreach ($vehicleList as $vehicle){
    //     $totalPrice += $vehicle->price;
    // }

@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentNew)</textarea> --}}
<input type="hidden" name="total_vehicle" id="total_vehicle" value="{{count($vehicleList)}}">
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom stripe">
        <thead>
            <th class="col-del">
                <input class="form-check-input" name="chkall" id="chkall" type="checkbox">
            </th>
            <th class="col-del">Bil</th>
            <th>No Pendaftaran</th>
            <th class="lcal-4">Jenis</th>
            <th class="lcal-3">Buatan</th>
            <th class="lcal-3">Model</th>
            <th style="width: 70px">Pembantu Kemahiran</th>
            <th style="text-align:right;width:100px;padding-bottom:7px">Harga<br/><small>RM</small></th>
        </thead>
        <tbody>
            @foreach ($vehicleList as $index => $vehicle)
                <tr style="height:20px">
                    <td class="pb-0">
                        <input class="form-check-input" name="chkdel" type="checkbox" value="{{$vehicle->id}}" id="chkdel">
                    </td>
                    <td class="pb-0"><div style="font-size: 14px">{{$vehicleList->firstItem() + $index}}</div><input type="hidden" name="vehicle_id[{{$loop->index}}]" value="{{$vehicle->id}}"></td>
                    <td class="pb-0">{{$vehicle->plate_no}}</td>
                    <td class="caps pb-0">{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}}</td>
                    <td class="caps pb-0">{{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}}</td>
                    <td class="caps pb-0">{{$vehicle->model_name}}</td>
                    <td class="pb-0" style="padding-top:3px;padding-left:4px;padding-right:4px;padding-bottom:0px;width:270px">
                        @if($hasAssessmentNewDetail->hasStatus->code == '02')
                            <select data-vehicle-id="{{$vehicle->id}}" name="foremen_id" class="foremen" id="foremen_id_{{$vehicle}}">
                               <option value="open">TUGASAN TERBUKA</option>
                               <optgroup label="Spesifik :">
                                @foreach ($foremenList as $foremen)
                                <option {{$vehicle->foremen_by == $foremen->id ? 'selected': ''}} value="{{$foremen->id}}">{{mb_strimwidth(strtoupper($foremen->name), 0, 26, "...")}}</option>
                                @endforeach
                                </optgroup>
                            </select>
                        @else
                            {{$vehicle->foremenBy ? $vehicle->foremenBy->name : '-'}}
                        @endif
                    </td>
                    <td class="pb-0" style="padding-top:3px;padding-left:4px;padding-right:4px;padding-bottom:0px;">
                        <input type="text" class="form-control currency" name="price[{{$loop->index}}]" id="price{{$loop->index}}" value="{{ number_format((float)$vehicle->price, 2, '.', '')}}" data-vehicle-id="{{$vehicle->id}}" onchange="countGrandTotal(); updatePrice(this);">
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th colspan="7" class="text-end pt-3">Jumlah <small>RM</small></th>
            <th style="text-align:right;width:100px"><span id="grandtotal" style="color:#000000">{{ number_format((float)$totalPrice, 2, '.', '')}}</span></th>
        </tfoot>
    </table>
</div>
@php
 $params = [
     // 'form_id' => 1
 ];
@endphp
{{$vehicleList->links('pagination.ajax-default', [
    'targetDivList' =>  '#assessment_new_vehicle_appointment',
    'params' => $params
])}}

<script type="text/javascript">

    // var ids = [];

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }
    function countGrandTotal() {
        var total = 0.0;
        var sum = 0.00;
        $('.currency').each(function(){
            var thisval = $(this).val();
            $(this).val(parseFloat(thisval).toFixed(2));
            sum += +$(this).val();
        });
        $('#grandtotal').text(parseFloat(sum).toFixed(2));
    }

    updatePrice = function(self){
        let crf = "{{ csrf_token() }}";
        let vehicle_id = $(self).data('vehicle-id');
        let price = self.value;
        $.post('{{route('assessment.new.vehicle-appointment-updatePrice')}}', {
            '_token': crf,
            'vehicle_id': vehicle_id,
            'price': price
        });
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
        $.post("{{route('assessment.new.vehicle-appointment-assign')}}", {
            vehicle_id: vehicle_id,
            user_id: formen_id,
            assign_to: 'formen',
            '_token': '{{ csrf_token() }}'
        },  function(result){

        })
    }

    $(document).ready(function(){

        $('.currency').keyup(function(e) {
            /*if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }*/
            if (/[^\d.]/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/[^\d.]/g, '');
            }
        });

        $('.foremen').select2({
            'width': "100%",
            'theme': "classic",
            'placeholder': "[Sila pilih]"
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
