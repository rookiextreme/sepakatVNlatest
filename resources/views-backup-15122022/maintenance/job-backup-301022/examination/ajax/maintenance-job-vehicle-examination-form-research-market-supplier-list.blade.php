@php
    $TaskFlowAccessMaintenanceJobAccess = auth()->user()->vehicleWorkFlow('02', '02');
    $hasAction = false;

    if($can_edit || $can_delete){
        $hasAction = true;
    }
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceJobAccess)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table table-bordered">
        <thead>
            <th style="width: 50px;">Bil</th>
            @if($hasAction)
                <th style="width: 90px;"></th>
            @endif
            <th>Nama Syarikat</th>
        </thead>
        <tbody>

            @if($supplierList->count() == 0)
            <tr class="no-record">
                <td colspan="3" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
            </tr>
            @endif

            @foreach ($supplierList as $index => $supplier)
                <tr class="supplier-item">
                    <td>{{$supplierList->firstItem() + $index}}</td>
                    @if($hasAction)
                        <td>
                            <div data-supplier="{{$supplier}}" class="btn-group">
                                @if($can_edit)
                                    <span onclick="editSupplier(this)" class="btn cux-btn small"> <i class="fal fa-pen-nib"></i></span>
                                @endif
                                @if($can_delete)
                                    <span onclick="delSupplier({{$supplier->id}})" class="btn cux-btn small"> <i class="fal fa-trash-alt"></i></span>
                                @endif
                            </div>
                        </td>
                    @endif
                    <td class="text-uppercase">
                        {{$supplier->company_name}}
                    </td>
                </tr>
            @endforeach

        </tbody>
        {{-- <tfoot>
            <th style="width: 50px;">Bil</th>
             <th style="width: 90px;"></th>
            <th>Nama Syarikat</th>
        </tfoot> --}}
    </table>
</div>
{{$supplierList->links('pagination.ajax-maintenance-job-form-supplier', ['form_id' => $form_id, 'jve_form_repair_id' => $jve_form_repair_id])}}

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
        $('#maintenanceJobVehicleDelModal #remove').hide();
        $('#maintenanceJobVehicleDelModal #close').hide();
        $.post("{{route('maintenance.job.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#maintenanceJobVehicleDelModal').modal('hide');
            loadMaintenanceVehicle();
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
