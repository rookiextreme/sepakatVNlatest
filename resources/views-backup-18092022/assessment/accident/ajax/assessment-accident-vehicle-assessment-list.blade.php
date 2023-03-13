@php
    // $TaskFlowAccessAssessmentAccident = auth()->user()->damageWorkFlow('02', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessAssessmentAccident)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th class="col-del">Bil</th>
            <th class="col-del"><input class="form-check-input" name="chkall" id="chkall" type="checkbox"></th>
            <th></th>
            <th>Kerosakan</th>
            <th>Nota</th>
            <th class="lcal-4">Baiki</th>
            <th class="lcal-4">Ganti</th>
            <th class="lcal-4">Imej</th>
            @if(auth()->user()->isForemenAssessment())
            @else
                <th class="text-center">Kiraan</th>
            @endif
        </thead>
        <tbody>
        @if(count($damageList)>0)
            @foreach ($damageList as $index => $damage)
                <tr>
                    <td>{{$damageList->firstItem() + $index}} </td>
                    <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$damage->id}}"></td>
                    <td class="lcal-btn" onclick="editDamageFormAsessment({{$damage->id}})"><i class="fa fa-pencil-alt"></i></td>
                    <td>{{$damage->damage}}</td>
                    <td>{{$damage->damage_note}}</td>
                    <td>
                        @if ($damage->is_repair)
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        @if ($damage->is_replace)
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        {{-- @if($damage->hasDamageImage) --}}
                        @php
                            $path = '';
                            $docName = '';
                            if($damage->hasDamageImage){
                                $path = $damage->hasDamageImage->doc_path;
                                $docName = $damage->hasDamageImage->doc_name;
                            }
                        @endphp
                        <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="50px" class="cursor-pointer" >
                        {{-- @else --}}
                        {{-- @endif --}}
                    </td>
            @if(auth()->user()->isForemenAssessment())

            @else
                <td class="text-center">
                    RM {{$damage->price_list}}
                </td>
            @endif
                </tr>
            @endforeach
        @else
                <tr>
                    <td colspan="8" class="text-center">Tiada Rekod Kerosakan Lagi</td>
                </tr>
        @endif
        </tbody>
    </table>
</div>
@php
$params = [
    // 'form_id' => 1
    'assessment_accident_id' => $assessment_accident_id
];
@endphp
{{$damageList->links('pagination.ajax-default', [
   'targetDivList' =>  '#assessment_accident_vehicle_assessment',
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
