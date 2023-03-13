<div>
    <div class="row">
        
        <div class="col-md-12 mt-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th class="fw-bold">JENIS SAMAN</th>
                        <th class="fw-bold">NO KENDERAAN</th>
                        <th class="fw-bold">NO NOTIS SAMAN</th>
                        <th class="fw-bold">KATEGORI > SUB KATEGORI</th>
                        <th class="fw-bold">PEMILIK</th>
                        <th class="fw-bold">TINDAKAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summons as $summon)
                        <tr>
                            <td></td>
                            <td>{{$summon->maklumatSaman ? $summon->maklumatSaman->jenis_saman : ''}}</td>
                            <td><a href="{{route('saman.daftar.save', ['id' => $summon->id])}}">{{$summon->pendaftaran->no_pendaftaran}}</a></td>
                            <td>{{$summon->maklumatSaman ? $summon->maklumatSaman->no_notis_saman : ''}}</td>
                            <td>{{$summon->pendaftaran->maklumat->kategori->name .' > '. $summon->pendaftaran->maklumat->sub->sub_kategori }}</td>
                            <td>{{$summon->user->name}}</td>
                            <td>
                                
                                @if ($summon->statusSaman->status_saman  == 'unpaid')
                                     <a href="{{route('saman.pengguna.bayaran', ['id' => $summon->id])}}" class="btn btn-primary">Bayar Saman</a>
                                @elseif ($summon->statusSaman->status_saman  == 'waiting')
                                     <span class="text-success">Menunggu Pengesahan</span>
                                @elseif ($summon->statusSaman->status_saman  == 'paid')
                                    <span class="text-success">Bayaran Diterima</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
