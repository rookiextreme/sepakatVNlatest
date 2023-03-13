@php
    $TaskFlowAccessLogistic = auth()->user()->vehicleWorkFlow('04', '02');
@endphp

<table id="fleet-ls" class="table-custom no-footer stripe hover">
    <thead>
        <th class="col-del">
            <input class="form-check-input" onchange="checkAll(this)" name="chkall" id="chkall" type="checkbox">
        </th>
        <th>No Pendaftaran</th>
        <th class="">Kategori</th>
        <th class="">SubKategori</th>
        <th class="">Jenis</th>
        {{-- <th class="" style="width: 50px;">Maksima</th> --}}
        <th class="" style="width: 50px;">Perlukan Pemandu?</th>
        @if($TaskFlowAccessLogistic->mod_fleet_approval)
        <th class="text-center" style="width: 50px;">
            Kenderaan
        </th>
        @endif
    </thead>
    <tbody>
        @foreach ($vehicleTypeList as $vehicleType)
        <tr class="disasterready_vehicle">
            <td>
                <input class="form-check-input chkdel" onchange="checkDel(this)" name="chkdel" id="chkdel" type="checkbox" value="{{$vehicleType->id}}"/>
            </td>
            <td class="{{$vehicleType->hasAssignedVehicle ? 'assigned-vehicle':''}}">{{$vehicleType->hasAssignedVehicle ? $vehicleType->hasAssignedVehicle->no_pendaftaran : '-'}}</td>
            <td>{{$vehicleType->hasVehicleType->hasSubCategory->hasCategory->name}}</td>
            <td>{{$vehicleType->hasVehicleType->hasSubCategory->name}}</td>
            <td>{{$vehicleType->hasVehicleType->name}}</td>
            {{-- <td>{{$vehicleType->totalUnitByVehicleType()}}</td> --}}
            <td class="text-center">
                <div class="form-switch" style="margin-right:30px">
                    {{-- <input class="form-check-input m-0" type="checkbox" {{$vehicleType->is_need_driver ? 'checked' :  (!$vehicleType->hasAssignedVehicle ? '' : ($vehicleType->hasAssignedVehicle && $vehicleType->hasAssignedVehicle->hasMainDriver ? '': 'checked') )}} onchange="isNeedDriver({{$vehicleType->id}}, this)"> --}}
                    <input class="form-check-input m-0" type="checkbox" {{$vehicleType->is_need_driver ? 'checked' : ''}} onchange="isNeedDriver({{$vehicleType->id}}, this)">
                </div>
            </td>
            @if($TaskFlowAccessLogistic->mod_fleet_approval)
            <td class="text-center">
                <span data-driver-phoneno="{{$vehicleType->driver_phone_no}}" 
                    data-assigned-vehicle="{{$vehicleType->hasAssignedVehicle ? $vehicleType->hasAssignedVehicle : ''}}" 
                    data-assigned-driver="{{$vehicleType->hasDriver}}" 
                    class="cux-btn bigger" data-bs-toggle="modal" data-bs-target="#assignVehicleModal" 
                    onclick="selectVehicleTypeDetail({{$vehicleType->id}}, {{$vehicleType->hasVehicleType->id}}, {{$vehicleType->hasPlacement ? $vehicleType->hasPlacement->ref_state_id : ''}}, {{$vehicleType->hasPlacement ? $vehicleType->hasPlacement->id : ''}}, this)">{{$vehicleType->hasAssignedVehicle ? 'Tukar': 'Pilih'}}</span>
            </td>
            @endif
        </tr>
        @endforeach
        @if (count($vehicleTypeList) == 0)
        @php
            $totalCols = 6;
            if($TaskFlowAccessLogistic->mod_fleet_approval){
                $totalCols++;
            }
        @endphp
            <tr class="no-record">
                <td colspan="{{$totalCols}}" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod</td>
            </tr>
        @endif
    </tbody>
</table>

<div class="col-12">
    {{$vehicleTypeList->links('logistic.tab.booking-vehicle-type')}}
</div>

<script>
    isNeedDriver = function(id, self){

        let is_need_driver = $(self).prop('checked');

        if(is_need_driver){
            $('#is-need-driver-container-'+id).show();
        } else {
            $('#is-need-driver-container-'+id).hide();
        }

        $.post("{{route('logistic.disasterready.vehicle.need.driver')}}", {
            id: id,
            is_need_driver: is_need_driver,
            '_token': "{{ csrf_token() }}"
        }, function(){
        });
    }
    
</script>
