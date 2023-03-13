<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="row">
        <div class="col-12 mt-2">
            @if(Session::has('message'))
                <p class="alert alert-success mt-2">{{ Session::get('message') }}</p>
             @endif
        </div>
        <div class="col-md-6">
            <form wire:submit.prevent="upload">
                <div class="row g-3 mt-4">
                    <div class="col-8">
                        <label for="" class="form-label text-dark">Notis Saman</label>
                        <div class="input-group mb-3">
                            <input type="file" wire:model="dokumen" class="form-control" id="inputGroupFile02" {{$summon !== 'draf' ? 'disabled' : ''}}>
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                    </div>
                    <div class="row g-3 mt-2">
                        @hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')

                        <div class="col-3">
                            <button class="btn btn-primary text-white fw-bold" type="submit">Simpan</button>
                        </div>
                        @endhasanyrole
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            
            @if (!empty($file['file']->dokumenSaman))
                <h4 class="text-dark fw-bold">Dokumen</h4><hr>
                <a href="{{$file['url']}}">{{$file['file']->dokumenSaman->name_dokumen}}</a>
            @endif
        </div>
    </div>
</div>
