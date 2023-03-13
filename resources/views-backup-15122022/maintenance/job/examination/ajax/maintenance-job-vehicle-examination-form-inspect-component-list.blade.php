@php
    $TaskFlowAccessMaintenanceJobAccess = auth()->user()->vehicleWorkFlow('02', '02');
    $form_id = Request('form_id');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceJobAccess)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table table-bordered">
        <thead>
            <th>Bil</th>
            @if($detail && $detail->hasMaintenanceJobVehicleStatus && in_array($detail->hasMaintenanceJobVehicleStatus->code, ['01','02']))
                <th style="width: 90px;"></th>
            @endif
            <th>Jenis Penyenggaraan</th>
            <th>Sistem</th>
            <th>Catatan Pemeriksaan</th>
        </thead>
        <tbody>

            @if($componentList->count() == 0)
            <tr class="no-record">
                <td colspan="6" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
            </tr>
            @endif

            @foreach ($componentList as $index => $component)
                <tr>
                    <td>{{$componentList->firstItem() + $index}}</td>
                    @if(
                        (in_array($detail->hasMaintenanceJobVehicleStatus->code, ['01','02']) && auth()->user()->isForemenMaintenance()) ||
                        (in_array($detail->hasMaintenanceJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                    )
                        <td>
                            <div data-component="{{$component}}" class="btn-group">
                                <span onclick="editInspectComponent(this)" class="btn cux-btn small"> <i class="fal fa-pen-nib"></i></span>
                                <span onclick="delInspectComponent({{$component->id}})" class="btn cux-btn small"> <i class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                    @endif
                    <td>{{$component->hasMaintenanceJobPurposeType?$component->hasMaintenanceJobPurposeType->desc:''}}</td>
                    <td>{{$component->hasRefComponentLvl1?$component->hasRefComponentLvl1->component:''}}</td>
                    <td>{{$component->note}}</td>
                </tr>
            @endforeach

        </tbody>
        {{-- <tfoot>
            <th>Bil</th>
            <th></th>
            <th>Jenis Penyenggaraan</th>
            <th>Sistem</th>
            <th>Komponen</th>
            <th>Catatan Pemeriksaan</th>
        </tfoot> --}}
    </table>
</div>
{{$componentList->links('pagination.ajax-maintenance-job-form-component', ['form_id' => $form_id])}}

<script type="text/javascript">

    var ids = [];

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
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
