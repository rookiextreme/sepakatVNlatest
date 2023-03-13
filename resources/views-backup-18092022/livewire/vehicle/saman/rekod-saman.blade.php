<div>
    <div class="row">
        <div class="col-12 mt-2">
            @if(Session::has('submition'))
                <p class="alert alert-primary mt-2">{{ Session::get('submition') }}</p>
            @endif
            <a href="{{route('saman.daftar')}}" class="btn btn-dark">Daftar Saman</a>
        </div>
        <div class="col-md-12 mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            <button class="btn">
                                <img src="{{asset("img/icon-delete.png")}}" height="30px"/>
                            </button>
                        </th>
                        <th class="fw-bold">JENIS SAMAN</th>
                        <th class="fw-bold">NO KENDERAAN</th>
                        <th class="fw-bold">NO NOTIS SAMAN</th>
                        <th class="fw-bold">KATEGORI > SUB KATEGORI</th>
                        <th class="fw-bold">PEMILIK</th>
                        <th class="fw-bold">STATUS SAMAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summons as $summon)
                        <tr>
                            <td>
                                <button class="btn" wire:click.prevent="$emit()" data-bs-toggle="modal" data-bs-target="{{'#deleteModal-'.$summon->id}}">
                                    <img src="{{asset("img/icon-delete.png")}}" height="30px"/>
                                </button>
                            </td>
                            <td>{{$summon->maklumatSaman? $summon->maklumatSaman->jenis_saman : ''}}</td>
                            <td><a href="{{route('saman.daftar.save', ['id' => $summon->id])}}">{{$summon->pendaftaran->no_pendaftaran}}</a></td>
                            <td>{{$summon->maklumatSaman ? $summon->maklumatSaman->no_notis_saman : ''}}</td>
                            <td>{{$summon->pendaftaran->maklumat->kategori->name .' > '.$summon->pendaftaran->maklumat->sub->sub_kategori}}</td>
                            <td>{{$summon->user->name}}</td>
                            <td>
                                @if ($summon->statusSaman->status_saman == 'draf')
                                    <span class="text-secondary">Deraf</span>
                                @elseif ($summon->statusSaman->status_saman  == 'unpaid')
                                     <span class="text-danger">Menunggu Bayaran</span>
                                @elseif ($summon->statusSaman->status_saman  == 'paid')
                                    <span class="text-success">
                                        <a href="">Bayaran Diterima</a>
                                    </span>
                                @elseif ($summon->statusSaman->status_saman  == 'waiting')
                                    <span class="text-primary">
                                        <a href="{{route('saman.pengguna.bayaran', ['id' => $summon->id])}}">Menunggu Semakan</a>
                                    </span>
                                @elseif ($summon->statusSaman->status_saman  == 'delete')
                                    <span class="text-danger">Dibuang</span>
                                @endif
                            </td>
                        </tr>
                        @livewire('dashboard.saman.components.delete-modal', ['saman_id' => $summon->id])
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="col-md-12 float-end mt-4">
            {{ $summons->links() }}
        </div>
    </div>
</div>
