@foreach ( $vehicleList as $vehicle )
    @php
        $vehicleType = "";
        if($vehicle->hasSubCategoryType()){
            $vehicleType = $vehicle->hasSubCategoryType()->name;
        }
    @endphp


@endforeach

        <table class="table-custom stripe no-footer">
            <thead>
                <th class="text-start" style="width:200px">No Pendaftaran</th>
                <th style="width:250px">Cawangan</th>
                <th style="width:140px">No Telefon</th>
                <th>Kategori > Sub Kategori > Jenis</th>
            </thead>
            <tbody>
                @foreach ($vehicleList as $vehicle)
                <tr class="cursor-pointer" onclick="selectSummonVehicle({{ $vehicle->id }}, '{{ $vehicle->no_pendaftaran }}')" data-bs-dismiss="modal">
                    <td class="text-start" style="text-align: left">{{$vehicle->no_pendaftaran ?: '-'}}</td>
                    <td style="text-align: left">{{$vehicle->cawangan ? $vehicle->cawangan->name : 'Cawangan Ke'}}</td>
                    <td style="text-align: left">{{$vehicle->user ? $vehicile->user->detail->telbimbit : 'KENDERAAN PENUMPANG'}}</td>
                    <td>-</td>
                </tr>
            @endforeach
            </tbody>
        </table>

{{$vehicleList->links('pagination.ajax-vehicle-summon')}}
