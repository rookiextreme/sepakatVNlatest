<div>
    <div class="float-end">
        <a class="btn cux-btn bigger mb-1" href="{{route('vehicle.register')}}"><i class="fa fa-plus"></i> Tambah Kenderaan</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="table-dark">
                <th class="text-white h6"></th>
                <th class="text-white h6 text-uppercase">
                    @hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')
                        Tindakan Semakan
                    @else
                        Status Pendaftaran
                    @endhasanyrole
                </th>
                <th class="text-white h6">HAK MILIK</th>
                <th class="text-white h6">NO KENDERAAN</th>
                <th class="text-white h6">CAWANGAN</th>
                <th class="text-white h6">KATEGORI > SUB-KATEGORI</th>
                <th class="text-white h6">STATUS KENDERAAN</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicleList as $vehicle)
                <tr>
                    <td></td>
                    <td class="text-primary">
                       @hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')  
                        @if ($vehicle->statusSemakan && $vehicle->statusSemakan->kenderaanStatus->status !== 'draf')
                            <button class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#verifiedModal">verified</button>
                        
                            <button class="btn btn-danger btn-sm text-white"  data-bs-toggle="modal" data-bs-target="#gagalModal">gagal</button>
                        @endif
                        @else
                        {{!empty($vehicle->statusSemakan) ? ucwords(str_replace('_',' ', $vehicle->statusSemakan->kenderaanStatus->status)) : '' }}
                        @endhasanyrole
                    </td>
                    <td>{{ucwords($vehicle->hak_milik)}}</td>
                    <td><a class="helve-bold cursor-pointer" href="{{route('vehicle.register', ['id' => $vehicle->id, 'is_display' => true])}}">{{$vehicle->no_pendaftaran}}</a></td>
                    <td>{{isset($vehicle->cawangan) ? $vehicle->cawangan->cawangan : ''}}</td>
                    <td>{{!empty($vehicle->maklumat->kategori) ? $vehicle->maklumat->kategori->name : '' }} > {{!empty($vehicle->maklumat->subKategori) ? $vehicle->maklumat->subKategori->sub_kategori : '' }} </td>
                    <td>{{!empty($vehicle->maklumat->status) ? ucwords( $vehicle->maklumat->status) : '' }}</td>
                </tr>
            @endforeach
        
        </tbody>
    </table>
    <div class="float-end">
        {{ $vehicleList->links() }}
    </div>
    @livewireScripts
</div>
