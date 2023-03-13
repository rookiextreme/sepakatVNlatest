<div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <form action="">
                <div class="form-group">
                    <input type="text" class="form-control" value="Search Keyword">
                </div>
            </form>
        </div>
    </div>

    <div class="mt-3">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <div class="row mb-2">
        <div class="col-md-12">
            <div class="float-end">
                <button class="btn btn-primary text-white" wire:click:prevent="addModal()" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                    <tr class="table-secondary">
                        <th>Nama Jabatan</th>
                        <th>Tetapan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jabatans as $Lihatjabatan)
                    <tr>
                        <td><a href="{{route('control.department.detail', ['id' => $Lihatjabatan->id])}}">{{$Lihatjabatan->jabatan}}</a></td>
                        <td width="30px">
                            <button wire:click="modalDeleteConfirm({{ $Lihatjabatan->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger btn-sm text-white">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal :: Add :: Confirmation -->
            <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Maklumat Jabatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-control" wire:model="ministryid" style="width: 100%">
                                        <option>Pilih Kementerian</option>
                                        @foreach ($Ministries as $ministry)
                                            <option value="{{$ministry-> id}}">{{$ministry-> name}}</option>
                                        @endforeach
                                    </select>
                                    @error('ministryid') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama Jabatan</label>
                                    <input type="text" wire:model="departmentName" class="form-control">
                                    @error('departmentName') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-secondary btn-danger text-white close-modal" wire:click.prevent="confirmToAdd()">Ya</a>
                    </div>
                </div>
                </div>
            </div>

            <!-- Modal :: Delete :: Confirmation -->
            <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Adakah anda ingin menghapuskan maklumat ini ?
                    </div>
                    <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-secondary btn-danger text-white close-modal" wire:click.prevent="confirmToDelete()" data-bs-dismiss="modal">Ya</a>
                    </div>
                </div>
                </div>
            </div>

            <div class="float-end">
                {{ $jabatans->links() }}
            </div>

        </div>
    </div>
</div>

<script>
    window.addEventListener('department-added', event => {
        $('#addModal').find('form')[0].reset();
        $("#addModal").modal('hide');                
    });
</script>