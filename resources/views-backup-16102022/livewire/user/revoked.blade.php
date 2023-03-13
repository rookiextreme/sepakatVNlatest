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
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr class="table-secondary">
                            <th>Nama</th>
                            <th>Emel</th>
                            <th width="15%" class="text-center">Kakitangan Kerajaan ?</th>
                            <th>Tarikh Dibuang</th>
                            <th>Dibuang Oleh</th>
                            <th class="text-center" width="15%">Sebab DiBuang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if ($user->status)
                            <tr>
                                <td><a href="">{{$user->name}}</a></td>
                                <td><a href="">{{$user->email}}</a></td>
                                <td class="text-center">{{$user->detail->gov_staff ? 'Ya' : 'Tidak'}}</td>
                                <td>
                                    {{$this->dateFormat($user->detail->userAuditLog->created_at, 'd/m/Y')}}
                                </td>
                                <td>
                                    {{$user->detail->userAuditLog->user->name}}
                                </td>
                                <td class="text-center">
                                    {{$user->detail->userAuditLog->comment}}
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <div class="float-end">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>