@php
    $TaskFlowAccessMaintenanceJobAccess = auth()->user()->vehicleWorkFlow('02', '02');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceJobAccess)</textarea> --}}
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <th style="width: 50px;">Bil </th>
            <th style="width: 50px;"></th>
            <th style="width: 150px;">Tarikh</th>
            <th >Perihal Pemantauan </th>
            <th style="width: 200px;">Catatan</th>
            <th>Imej</th>
        </thead>
        <tbody>
            
            @if($monitoringInfoList->count() == 0)
            <tr class="no-record">
                <td colspan="5" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
            </tr>
            @endif

            @foreach ($monitoringInfoList as $index => $monitorInfo)
                <tr data-ref-info-code="{{$monitorInfo->hasRefInfo && $monitorInfo->hasRefInfo->code ? $monitorInfo->hasRefInfo->code : ''}}">
                    <td class="align-top">{{$monitoringInfoList->firstItem() + $index}}</td>
                    <td class="align-top">
                        <div data-monitorInfo="{{$monitorInfo}}" class="btn-group">
                            <span onclick="editQuotationMonitorInfo(this)" class="btn cux-btn small"> <i class="fal fa-pen-nib"></i></span>
                            <span onclick="delQuotationMonitorInfo({{$monitorInfo->id}})" class="btn cux-btn small"> <i class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td class="text-uppercase align-top">
                        {{$monitorInfo->monitoring_dt ? \Carbon\Carbon::parse($monitorInfo->monitoring_dt)->format('d F Y') : ''}}
                    </td>
                    <td class="align-top">
                        {{$monitorInfo->hasRefInfo && $monitorInfo->hasRefInfo->desc ? $monitorInfo->hasRefInfo->desc : ''}}
                    </td>
                    <td class="align-top">
                        {{$monitorInfo->note}}
                    </td class="align-top">
                    <td class="align-top">
                        <img class="cursor-pointer" onclick="openEnlargeModal(this)" data-url="{{'/'.$monitorInfo->doc_path.'/'.$monitorInfo->doc_name}}" src="{{'/'.$monitorInfo->doc_path_thumbnail.'/'.$monitorInfo->doc_name}}" alt="">
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{-- <tfoot>
            <th style="width: 50px;">Bil </th>
            <th style="width: 90;">Tarikh</th>
            <th style="width: 50px;">Perihal Pemantauan </th>
            <th>Catatan</th>
            <th>Imej</th>
        </tfoot> --}}
    </table>
</div>
{{$monitoringInfoList->links('pagination.ajax-maintenance-job-form-monitor-info', ['form_id' => $form_id])}}

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
