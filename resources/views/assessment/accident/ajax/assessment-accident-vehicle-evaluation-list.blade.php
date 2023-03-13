@php
    // $TaskFlowAccessAssessmentAccident = auth()->user()->damageWorkFlow('02', '01');

@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentAccident)</textarea> --}}
@if($hasAssessmentAccidentDetail->hasStatus->code == '08' ||  $hasAssessmentAccidentDetail->hasStatus->code == '05')
    <div class="table-responsive">
        <table id="fleet-ls" class="table-custom stripe">
            <thead>
                <th>Bil</th>
                <th>Kerosakan</th>
                <th>Nota</th>
                <th>Gambar</th>
                <th style="width:150px;text-align:right">Baiki</th>
                <th style="width:150px;text-align:right">Ganti</th>
                <th style="width:150px;text-align:right">Kos Upah Baiki (RM)</th>
                <th style="width:150px;text-align:right">Harga Alat Ganti (RM)</th>
                <th style="width:150px;text-align:right">Harga Kerosakan (RM)</th>
            </thead>
            <tbody>
            @if(count($damageList)>0)
                @foreach ($damageList as $index => $damage)
                    @php
                        $path = '';
                        $docName = '';
                        if($damage->hasDamageImage){
                            $path = $damage->hasDamageImage->doc_path;
                            $docName = $damage->hasDamageImage->doc_name;
                        }
                    @endphp
                    <tr>
                        <input type="hidden" name="damage_id[{{$loop->index}}]" value="{{$damage->id}}">
                        <td>{{$damageList->firstItem() + $index}}</td>
                        <td>{{$damage->damage}}</td>
                        <td>{{$damage->damage_note}}</td>
                        <td><img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="50px" class="cursor-pointer" style="display: {{$damage->hasDamageImage ? 'block' :'none'}}"></td>
                        <td style="width:150px;text-align:right">
                            @if ($damage->is_repair)
                                <i class="fas fa-check"></i>
                            @endif
                        </td>
                        <td style="width:150px;text-align:right">
                            @if ($damage->is_replace)
                                <i class="fas fa-check"></i>
                            @endif
                        </td>
                        <td style="text-align:right">
                            {{number_format((float)$damage->wages_cost, 2, '.', ',')}}
                        </td>
                        <td style="text-align:right">
                            {{number_format((float)$damage->spare_part_price, 2, '.', ',')}}
                        </td>
                        <td style="width:150px;text-align:right">{{number_format((float)$damage->price_list, 2, '.', ',')}}</td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="9" class="text-center">Tiada Rekod Kerosakan Lagi</td>
                    </tr>
            @endif
            </tbody>
            <tfoot>
                <th colspan="8" class="text-end">Anggaran (+/-)</th>
                <th class="text-right form-group" style="text-align: right">
                    {{number_format((float)$vehicleList->estimate_price, 2, '.', ',')}}
                </th>
            </tfoot>
            <tfoot>
                <th colspan="8" class="text-end">Jumlah</th>
                <th class="text-right" id="total-price" style="text-align: right">{{number_format((float)$totalPriceList, 2, '.', ',')}}</th>
            </tfoot>
            <tfoot>
                <th colspan="8" class="text-end">Jumlah Keseluruhan</th>
                <th class="text-right" style="text-align: right">{{number_format((float)$vehicleList->total, 2, '.', ',')}}</th>
            </tfoot>
        </table>
    </div>
@else
    <div class="table-responsive">
        <table id="fleet-ls" class="table-custom stripe">
            <thead>
                <th class="col-del"><input class="form-check-input" name="chkall" id="chkall" type="checkbox"></th>
                <th>Bil</th>
                <th></th>
                <th>Kerosakan</th>
                <th>Nota</th>
                <th>Foto</th>
                <th style="width:150px;text-align:right">Baiki</th>
                <th style="width:150px;text-align:right">Ganti</th>
                <th style="width:150px;text-align:right">Kos Upah Baiki (RM)</th>
                <th style="width:150px;text-align:right">Harga Alat Ganti (RM)</th>
                <th style="width:150px;text-align:right">Harga Kerosakan (RM)</th>
            </thead>
            <tbody>
            @if(count($damageList)>0)
                @foreach ($damageList as $index => $damage)
                    @php
                        $path = '';
                        $docName = '';
                        if($damage->hasDamageImage){
                            $path = $damage->hasDamageImage->doc_path;
                            $docName = $damage->hasDamageImage->doc_name;
                        }
                    @endphp
                    <tr>
                        <input type="hidden" name="damage_id[{{$loop->index}}]" value="{{$damage->id}}">
                        <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$damage->id}}"></td>
                        <td>{{$damageList->firstItem() + $index}}</td>
                        <td class="lcal-btn" onclick="editDamageFormEvaluation({{$damage->id}})"><i class="fa fa-pencil-alt"></i></td>
                        <td>{{$damage->damage}}</td>
                        <td>{{$damage->damage_note}}</td>
                        <td><img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="50px" class="cursor-pointer" style="display: {{$damage->hasDamageImage ? 'block' :'none'}}"></td>
                        <td style="width:150px;text-align:right">
                            @if ($damage->is_repair)
                                <i class="fas fa-check"></i>
                            @endif
                        </td>
                        <td style="width:150px;text-align:right">
                            @if ($damage->is_replace)
                                <i class="fas fa-check"></i>
                            @endif
                        </td>
                        <td style="text-align:right">
                            <input type="text" onchange="forceCurrency(this)"  class="text-end" onchange="calculate()" name="wages_cost[{{$loop->index}}]" id="wages_cost" value="{{number_format((float)$damage->wages_cost, 2, '.', ',')}}">
                        </td>
                        <td style="text-align:right">
                            <input type="text" onchange="forceCurrency(this)"  class="text-end" name="spare_part_price[{{$loop->index}}]" id="spare_part_price" value="{{number_format((float)$damage->spare_part_price, 2, '.', ',')}}">
                        </td>
                        <td style="width:150px;text-align:right">{{number_format((float)$damage->price_list, 2, '.', ',')}}</td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="10" class="text-center">Tiada Rekod Kerosakan Lagi</td>
                    </tr>
            @endif
            </tbody>
            <tfoot>
                <th colspan="10" class="text-end">Anggaran (+/-)</th>
                <th class="text-right form-group">
                    <input type="text" onchange="forceCurrency(this);updateDamageEstimatePrice(this);"  class="text-end" name="estimate_price" id="estimate_price" value="{{ number_format((float)$vehicleList->estimate_price, 2, '.', ',')}}">
                </th>
            </tfoot>
            <tfoot>
                <th colspan="10" class="text-end">Jumlah</th>
                <th class="text-right" id="total-price">{{number_format((float)$totalPriceList, 2, '.', ',')}}</th>
            </tfoot>
            <tfoot>
                <th colspan="10" class="text-end">Jumlah Keseluruhan</th>
                <th class="text-right">
                    <label for="" class="form-label">
                    {{ number_format((float)$vehicleList->total, 2, '.', ',')}}
                    </label>
                </th>
            </tfoot>
        </table>
    </div>
@endif
@php
$params = [
    // 'form_id' => 1
    'assessment_accident_id' => $assessment_accident_id
];
@endphp
{{$damageList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_accident_vehicle_evaluation',
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

    function calculateUpahCat() {
        var totalPrice = $('#total-price').text();
        var paint_rate = $('#paint_rate').val();
        var paint_fee = parseFloat(totalPrice) * (parseFloat(paint_rate) / 100);
        $('#paint_fee').val(paint_fee);
    }

    function remove(){
        $('#assessmentAccidentdamageDelModal #remove').hide();
        $('#assessmentAccidentdamageDelModal #close').hide();
        $.post("{{route('assessment.accident.vehicle.damage.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#assessmentAccidentdamageDelModal').modal('hide');
            loadAssessmentdamage();
        })
    }

    function openEnlargeModal(self){

            $('#enlargeImageModal img').attr('src', $(self).attr('src'));
            $('#enlargeImageModal').modal('show');


    };

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
