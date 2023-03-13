
<div class="table-responsive">
    <table class="table-custom stripe no-footer">
        <thead>
            <th></th>
            <th>Negeri</th>
            <th>Daerah</th>
            <th>Kategori</th>
            <th>Sub-Kategori</th>
            <th>Jenis</th>
            <th>Unit</th>
            {{-- <th>Disaster</th> --}}
        </thead>
        <tbody>
            @foreach ($vehicleList as $vehicle)

            <tr class="cursor-pointer booking_vehicle">
                <td class="text-center" data-vehicle-branch-id="{{$vehicle->branch_id}}" data-vehicle-placement-id="{{$vehicle->placement_id}}" data-sub-category-id="{{$vehicle->sub_category_id}}" data-vehicle-type-id="{{$vehicle->sub_category_type_id}}" data-vehicle-type-name="{{$vehicle->sub_category_type_name ? $vehicle->sub_category_type_name : $vehicle->sub_category_name}}" onclick="selectVehicleByType(this)" data-bs-dismiss="modal">
                    <span class="cux-btn small">Pilih</span>
                </td>
                <td>{{$vehicle->state_name ?: '-'}}</td>
                <td>{{$vehicle->placement_name ?: '-'}}</td>
                <td>{{$vehicle->category_name ?: '-'}}</td>
                <td>{{$vehicle->sub_category_name ?: '-'}}</td>
                <td>{{$vehicle->sub_category_type_name ?: '-'}}</td>

                <td
                    data-vehicle-category-id="{{$vehicle->category_id}}"
                    data-vehicle-subcategory-id="{{$vehicle->sub_category_id}}"
                    data-vehicle-type-id="{{$vehicle->sub_category_type_id}}"
                    data-state-id="{{$vehicle->ref_state_id}}"
                    data-placement-id="{{$vehicle->placement_id}}"
                    class="text-center" data-bs-toggle="modal" data-bs-target="#VehicleByTypeUnitSearchModal" data-bs-dismiss="modal" data-bs-dismiss="#VehicleByTypeSearchModal" onclick="getVehicleByTypeUnit('vehicle_type_id', this)">
                    <span class="cux-btn small">
                        {{-- {{$vehicle->total_type_unit}}
                        {{$vehicle->total_sub_unit}} --}}
                    @if($vehicle->total_type_unit > 0)
                        {{$vehicle->total_type_unit}}
                        @else
                        {{$vehicle->total_sub_unit}}
                    @endif
                    </span>
                </td>
                {{-- <td>{{$vehicle->disaster_ready}}</td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{$vehicleList->links('pagination.ajax-vehicle-type')}}
