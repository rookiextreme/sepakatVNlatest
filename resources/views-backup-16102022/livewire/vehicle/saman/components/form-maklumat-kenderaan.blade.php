<div class="row">
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="col-6">
        @if(Session::has('message'))
            <p class="alert alert-success mt-2">{{ Session::get('message') }}</p>
        @endif
        <form wire:submit.prevent="store">
            <div class="row g-3 mt-2">
                <div class="col">
                    <label for="" class="form-label text-dark">Kenderaan</label>
                    <select class="form-select" wire:click.prevent="$emit()" wire:model="informations.vehicle_id"  data-bs-toggle="modal" data-bs-target="#kenderaanSearch" {{$summon !== 'draf' ? 'disabled' : ''}}>
                        @if (!empty($informations['vehicle_id']))
                            <option value="{{$informations['vehicle_id']}}">{{$informations['no_pendaftaran']}}</option>
                        @endif
                    </select>
                </div>
                <div class="col">
                    <label for="" class="form-label text-dark">Pemilik Kenderaan</label>
                    <select class="form-select" wire:click.prevent="$emit()" wire:model="informations.owner_id" data-bs-toggle="modal" data-bs-target="#pemilikSearch" {{$summon !== 'draf' ? 'disabled' : ''}}>
                       @if (!empty($informations['owner_id']))
                           <option value="{{$informations['owner_id']}}">{{$informations['no_identiti']}}</option>
                       @endif
                    </select>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-6 offset-6">
                    <label for="" class="form-label text-dark">Emel Ketua Jabatan Pemilik</label>
                    <input type="text" class="form-control" wire:model="informations.head_email" {{$summon !== 'draf' ? 'disabled' : ''}}>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-6 offset-6">
                    <label for="" class="form-label text-dark">Alamat Pejabat Pemilik</label>
                    <input type="text" class="form-control" wire:model="informations.owner_address" {{$summon !== 'draf' ? 'disabled' : ''}}>
                </div>
            </div>

            <div class="row g-3 mt-2">
                @hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')

                <div class="col-3">
                    <button class="btn btn-primary text-white fw-bold" type="submit" {{$summon !== 'draf' ? 'disabled' : ''}}>Simpan</button>
                </div>
                <div class="col-3">
                    <button class="btn btn-dark fw-bold" type="button" wire:click.prevent="hantar" {{$summon !== 'draf' ? 'disabled' : ''}}>Hantar</button>

                </div>
                @endhasanyrole
            </div>
        </form>

    </div>
   @livewire('vehicle.saman.components.search-modal')
  
</div>
