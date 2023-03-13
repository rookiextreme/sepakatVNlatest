<div>
    {{-- Do your work, then step back. --}}
    
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4 mb-4">
    <a href="{{route('vehicle.register')}}" class="btn btn-block btn-dark text-white rounded">Daftar Kenderaan</a>
</div>
            <table class="table table-striped">
                <thead>
                    <tr class="table-dark">
                        <th class="text-white">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        </th>
                        <th class="text-white">HAK MILIK</th>
                        <th class="text-white">NO KENDERAAN</th>
                        <th class="text-white">CAWANGAN</th>
                        <th class="text-white">KATEGORI > SUB-KATEGORI</th>
                        <th class="text-white">STATUS REKOD</th>
                        <th class="text-white">TINDAKAN SEMAKAN</th>

                    </tr>
                </thead>
                <tbody>
                   @foreach ($lists as $list )
                        @if ($list->statusSemakan !== null && $list->statusSemakan->kenderaanStatus->status !== 'draf')
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                </td>
                                <td class="text-dark">{{ucwords($list->hak_milik)}}</td>
                                <td class="text-dark">{{$list->no_pendaftaran}}</td>
                                <td  class="text-dark">{{$list->cawangan->cawangan}}</td>
                                <td class="text-dark">{{$list->maklumat->kategori->name}} > {{$list->maklumat->sub !== null ? $list->maklumat->sub->sub_kategori : ''}} </td>
                                <td class="text-dark">{{ucwords($list->maklumat->status)}}</td>
                                <td>
                                    <div class="d-grid gap-2">
                                        @if ($list->statusSemakan->kenderaanStatus->status !== 'draf')
                                            <button class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#verifiedModal">verified</button>
                                     
                                            <button class="btn btn-danger btn-sm text-white"  data-bs-toggle="modal" data-bs-target="#gagalModal">gagal</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @livewire('components.jurutera.modal-semakan', ['pendaftaran_id' => $list->id])
                        @endif
                        {{-- {{$list->statusSemakan->}} --}}
                       
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
