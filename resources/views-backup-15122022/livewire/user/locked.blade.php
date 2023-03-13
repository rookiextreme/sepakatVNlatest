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
                            <th>Tarikh DiKunci</th>
                            <th>Dikunci Oleh</th>
                            <th>Dikunci Hingga</th>
                            <th class="text-center" width="15%">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td><a href="">{{$user->name}}</a></td>
                                <td><a href="">{{$user->email}}</a></td>
                                <td>
                                    {{$this->dateFormat($user->detail->userAuditLog->created_at, 'd/m/Y')}}
                                </td>
                                <td>
                                    {{$user->detail->userAuditLog->user->name}}
                                </td>
                                <td>
                                    {{$this->dateFormat($user->detail->isLocked->end_dt, 'd/m/Y')}}
                                </td>
                                <td>
                                    <div class="d-grid gap-1">
                                        <button wire:click.prevent="$emit('userLockedMD', {{ $user->id}}, '{{url()->current()}}')" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#giveAccessModal" >Aktifkan</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="float-end">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        @livewire('components.user.modal-locked')
    </div>
</div>