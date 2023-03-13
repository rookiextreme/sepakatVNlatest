<div class="table-responsive">
    <table class="table-custom stripe no-footer">
        <thead>
            <th style="text-align: left">No Pendaftaran</th>
            <th>Negeri</th>
            <th>Daerah</th>
            <th>Jenis</th>
            <th style="width: 50px;" class="text-center">Kenderaan Konsesi</th>
        </thead>
        <tbody>
            @foreach ($vehicleList as $vehicle)
            <tr class="cursor-pointer" data-fleet-table="{{$vehicle->is_grant ? 'grant' : 'department'}}" data-hasdriver="{{$vehicle->main_driver_id ? true: false}}" data-vehicle-id="{{$vehicle->id}}" data-vehicle-plate-no="{{$vehicle->no_pendaftaran}}" onclick="selectVehicle(this)" data-bs-dismiss="modal">
                <td style="text-align: left"><a>{{$vehicle->no_pendaftaran}}</a></td>
                <td>{{$vehicle->state_name ?: '-'}}</td>
                <td>{{$vehicle->placement_name ?: '-'}}</td>
                <td>{{$vehicle->sub_category_type_name ?: '-'}}</td>
                <td class="text-center">
                @if($vehicle->is_grant)
                    <span class="text-success">Ya</span>
                    @else
                    Tidak
                @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{$vehicleList->links('pagination.ajax-vehicle')}}
