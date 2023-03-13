<div>
    {{-- Do your work, then step back. --}}
    <div class="row">
        <div class="col-md-4 mb-4">
            <form action="">
                <div class="form-group">
                    <input type="text" class="form-control" value="Search Keyword">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{$hoii}}
            <table class="table table-striped">
                <thead>
                    <tr class="table-secondary">
                        <th>Nama</th>
                        <th>Kakitangan Kerajaan</th>
                        <th>Kakitangn JKR</th>
                        <th>Jawatan</th>
                        <th>Cawangan</th>
                        <th>Akses Level</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @if (empty($user->status) && $user->detail)
                            <tr>
                                <td><a href="{{route('spakat.pengguna.profile', ['id' => $user->id])}}">{{$user->name}}</a></td>
                                <td>{{$user->detail->gov_staff ? 'Ya' : 'Tidak'}}</td>
                                <td>{{$user->detail->jkr_staff ? 'Ya' : 'Tidak'}}</td>
                                <td>{{$user->detail->jkrStaff == null ? 'Tiada' : $user->detail->jkrStaff->jawatan->jawatan}}</td>
                                <td>{{$user->detail->jkrStaff == null ? 'Tiada' : $user->detail->jkrStaff->cawangan->cawangan}}</td>
                                <td>
                                    <select wire:model="role.{{$user->id}}" id="" class="form-select">
                                        <option value="">Pilih satu</option>
                                        @foreach ($roles as $rol)
                                            <option value="{{$rol->name}}">{{$rol->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-primary  text-white" wire:click="action({{$user->id}}, 'pass')">Pass</button>
                                    <button class="btn btn-danger  text-white" wire:click="action({{$user->id}}, 'tolak')">Tolak</button>

                                </td>
                            </tr>
                        @endif
                        
                    @endforeach  
                </tbody>
            </table>
        </div>
    </div>
</div>
