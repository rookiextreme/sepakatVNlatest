@php
    $TaskFlowAccessLogistic = auth()->user()->vehicleWorkFlow('04', '01');
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="10">@json($TaskFlowAccessLogistic)</textarea> --}}

<div class="table-responsive">
    <table id="fleet-ls" class="table-custom no-footer stripe">
        <thead>
            <th class="col-del">
                <input class="form-check-input" onchange="checkAll(this)" name="chkall" id="chkall" type="checkbox">
            </th>
            {{-- <th></th> --}}
            @if($TaskFlowAccessLogistic->mod_fleet_approval)
                <th>No Pendaftaran</th>
            @endif
            <th class="">Kategori > Sub-kategori</th>
            <th class="">Jenis Kenderaan</th>
            <th style="width: 60px;text-align:center">Perlukan Pemandu?</th>
            <th style="width: 60px;text-align:right">Senarai Penumpang</th>
            <th style="width: 165px;text-align:center"></th>
            @if($TaskFlowAccessLogistic->mod_fleet_approval)
                <th class="text-center" style="width: 50px;">
                    Kenderaan
                </th>
            @endif
            {{-- <th style="width: 165px;text-align:center">Lokasi</th> --}}
        </thead>
        <tbody>
            @foreach ($vehicleTypeList as $vehicleType)
            <tr class="booking_vehicle">
                <td>
                    <input class="form-check-input chkdel" onchange="checkDel(this)" name="chkdel" id="chkdel" type="checkbox" value="{{$vehicleType->id}}"/>
                </td>
                {{-- <td>
                    <div class="btn-group">
                        <div class="btn-group dropend">
                            <button type="button" onclick="editBookingVehicle()" class="btn cux-btn small" data-bs-toggle="modal" data-bs-target="#addVehicleTypeModal"><i class="fa fa-pencil-alt"></i></button>
                        </div>
                    </div>
                </td> --}}
                @if($TaskFlowAccessLogistic->mod_fleet_approval)
                    <td class="{{$vehicleType->hasAssignedVehicle ? 'assigned-vehicle':''}}">{{$vehicleType->hasAssignedVehicle ? $vehicleType->hasAssignedVehicle->no_pendaftaran : '-'}}</td>
                @endif
                <td>
                    @if($vehicleType->hasAssignedVehicle)
                        @switch($vehicleType->fleet_table)
                            @case('grant')
                                    @if($vehicleType->hasAssignedVehicle->hasCategory())
                                    {{$vehicleType->hasAssignedVehicle->hasCategory()->name}}
                                    @endif
                                    @if($vehicleType->hasAssignedVehicle->hasSubCategory())
                                    > <small>{{$vehicleType->hasAssignedVehicle->hasSubCategory()->name}}</small>
                                    @endif
                                @break
                            @case('department')
                                {{$vehicleType->hasAssignedVehicle->hasCategory()->name}}
                                >
                                <small>{{$vehicleType->hasAssignedVehicle->hasSubCategory()->name}}</small>
                                @break
                            @default
                                
                        @endswitch
                    @else
                    @if($vehicleType->hasVehicleType)
                        {{$vehicleType->hasVehicleType->hasSubCategory->hasCategory->name}} > <small>{{$vehicleType->hasVehicleType->hasSubCategory->name}}</small>
                        @else
                        {{$vehicleType->hasSubCategory->hasCategory->name}} > <small>{{$vehicleType->hasSubCategory->name}}</small>
                    @endif
                    @endif
                    
                </td>
                <td>
                    @if($vehicleType->hasAssignedVehicle)
                        @switch($vehicleType->fleet_table)
                            @case('grant')
                                    @if($vehicleType->hasAssignedVehicle->hasSubCategoryType())
                                        {{$vehicleType->hasAssignedVehicle->hasSubCategoryType()->name}}
                                    @endif
                                @break
                            @case('department')
                                {{$vehicleType->hasAssignedVehicle->hasSubCategoryType()->name}}
                                @break
                            @default
                                
                        @endswitch
                    @else
                    @if($vehicleType->hasVehicleType)
                        {{$vehicleType->hasVehicleType->name}}
                        @else
                        {{$vehicleType->hasSubCategory->hasCategory->name}}
                    @endif
                    
                    @endif
                </td>
                <td class="text-center">
                    <div class="form-switch" style="margin-right:30px">
                        {{-- <input class="form-check-input m-0" type="checkbox" {{$vehicleType->is_need_driver ? 'checked' :  (!$vehicleType->hasAssignedVehicle ? '' : ($vehicleType->hasAssignedVehicle && $vehicleType->hasAssignedVehicle->hasMainDriver ? '': 'checked') )}} onchange="isNeedDriver({{$vehicleType->id}}, this)"> --}}
                        <input class="form-check-input m-0" type="checkbox" {{$vehicleType->is_need_driver ? 'checked' : ''}} onchange="isNeedDriver({{$vehicleType->id}}, this)">
                    </div>
                </td>
                <td class="text-end" style="text-align: right">{{count($vehicleType->hasManyPassenger)}}/{{$vehicleType->total_passenger}}</td>
                <td class="text-start">
                    <div class="btn-group">
                        <button type="button" class="cux-btn" onclick="getVehicleByTypeWithPassenger('booking_vehicle_id', {{$vehicleType->id}})" data-bs-toggle="modal" data-bs-target="#vehiclePassengerListModal">Senarai</button>
                        <button type="button" data-id="{{$vehicleType->id}}" data-file="{{$vehicleType->hasPassengerDoc}}" class="cux-btn" onclick="selectVehicleByTypeWithPassenger(this)" data-bs-toggle="modal" data-bs-target="#uploadVehiclePassengerListModal">{{$vehicleType->hasPassengerDoc ? 'Tukar Fail' : 'Muat Naik'}}</button>
                    </div>
                </td>
                @if($TaskFlowAccessLogistic->mod_fleet_approval)
                    <td class="text-center">
                        <span data-fleet-table="{{$vehicleType->fleet_table}}" data-driver-phoneno="{{$vehicleType->driver_phone_no}}" data-assigned-vehicle="{{$vehicleType->hasAssignedVehicle ? $vehicleType->hasAssignedVehicle : ''}}" data-assigned-driver="{{$vehicleType->hasDriver}}" class="cux-btn bigger" data-bs-toggle="modal" data-bs-target="#assignVehicleModal" 
                            data-sub-category-id="{{$vehicleType->hasSubCategory ? $vehicleType->hasSubCategory->id : -1}}"
                            onclick="selectVehicleTypeDetail({{$vehicleType->id}}, {{$vehicleType->hasVehicleType ? $vehicleType->hasVehicleType->id : -1}}, {{$vehicleType->hasPlacement->ref_state_id}}, {{$vehicleType->hasPlacement->id}}, this)">{{$vehicleType->hasAssignedVehicle ? 'Tukar': 'Pilih'}}</span>
                    </td>
                @endif
                {{-- <td>{{$vehicleType->hasPlacement->desc}} -  {{$vehicleType->hasBooking->id}} - {{$vehicleType->createdBy->id}} - {{$vehicleType->hasPlacement->hasState->desc}}</td> --}}
            </tr>
            @endforeach
            @if (count($vehicleTypeList) == 0)
                <tr class="no-record">
                    <td colspan="8" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod</td>
                </tr>
            @endif
            {{-- <tr>
                <td>
                    <input name="chkdel" id="chkdel" type="checkbox" value=""/>
                </td>
                <td></td>
                <td>Kenderaan Penumpang</td>
                <td>Kereta</td>
                <td>Pacuan 4 Roda (4X4)</td>
                <td class="text-center"> </td>
                <td class="text-center">
                    <input name="chkdel" id="chkdel" type="checkbox" value=""/>
                </td>
                <td class="text-center"> 2/3 <span class="cux-btn small" data-bs-toggle="modal" data-bs-target="#vehiclePassengerListModal">Senarai</span></td>
                <td class="text-center">
                    <span class="cux-btn bigger" data-bs-toggle="modal"
                    data-bs-target="#assignVehicleModal">Pilih</span>
                </td>
            </tr> --}}
        </tbody>
    </table>
</div>
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

        $.post("{{route('logistic.booking.vehicle.need.driver')}}", {
            id: id,
            is_need_driver: is_need_driver,
            '_token': "{{ csrf_token() }}"
        }, function(){
        });
    }


</script>
