<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="row">
        <div class="col-md-6">
            <form wire:submit.prevent="store">
                <div class="row mt-4">
                    <div class="col-12 mt-2">
                        @if(Session::has('message'))
                            <p class="alert alert-success mt-2">{{ Session::get('message') }}</p>
                        @endif
                    </div>
                    <div class="col" >
                        <label for="" class="form-label text-dark">Jenis Saman</label>
                        <select name="" id="" class="form-select" wire:model="informations.summon_type" {{$summon !== 'draf' ? 'disabled' : ''}}>
                            <option value="">Pilih</option>
                            <option value="pdrm">PDRM</option>
                            <option value="jpj">JPJ</option>
                            <option value="pbt">PBT</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="" class="form-label text-dark">No Notis Saman</label>
                        <input type="text" class="form-control" wire:model="informations.summon_notice" {{$summon !== 'draf' ? 'disabled' : ''}}>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="" class="form-label text-dark">Cawangan</label>
                        <select name="" id="" class="form-select" wire:model="informations.branch_id" {{$summon !== 'draf' ? 'disabled' : ''}}>
                            <option value="">Pilih</option>

                            @foreach ($branchs as $caw )
                                 <option value="{{$caw->id}}">{{$caw->cawangan}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="" class="form-label text-dark">Tarikh Notis</label>
                        <input type="date" class="form-control" wire:model="informations.notice_date" {{$summon !== 'draf'? 'disabled' : ''}}>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="" class="form-label text-dark">Tarikh Notis</label>
                        <input type="date" class="form-control" wire:model="informations.notice_date" {{$summon !== 'draf' ? 'disabled' : ''}}>
                    </div>
                    <div class="col">
                        <label for="" class="form-label text-dark">Masa Kesalahan</label>
                        <input type="time" class="form-control" wire:model="informations.mistake_date" {{$summon !== 'draf' ? 'disabled' : ''}}>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="" class="form-label text-dark">Lokasi</label>
                        <select name="" id="" class="form-select" wire:model="informations.state_id" {{$summon !== 'draf'? 'disabled' : ''}}>
                            <option value="">Pilih</option>
                            @foreach ($states as $negeri )
                                <option value="{{$negeri->id}}">{{$negeri->negeri}}</option> 
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="" class="form-label text-dark">Daerah Saman</label>
                        <select name="" id="" class="form-select" wire:model="informations.city_id" {{$summon !== 'draf'? 'disabled' : ''}}>
                            <option value="">Pilih</option>

                            @if (!empty($informations['state_id']))
                                    
                                    @foreach ($cities as $caw )
                                        @if ($informations['state_id'] == $caw->state_id)
                                            <option value="{{$caw->id}}">{{$caw->daerah}}</option>
                                        @endif
                                    @endforeach


                                @endif
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col">
                        <label for="" class="form-label text-dark">Kod Daerah</label>
                        <input type="text" class="form-control" wire:model="informations.city_code" {{$summon !== 'draf' ? 'disabled' : ''}}>
                    </div>
                    <div class="col">
                        <label for="" class="form-label text-dark">Tempat Kesalahan</label>
                        <input type="text" class="form-control" wire:model="informations.mistake_location" {{$summon !== 'draf'? 'disabled' : ''}}>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <label for="" class="form-label text-dark">Jumlah Kompoun (RM)</label>
                        <input type="text" class="form-control" wire:model="informations.compaun_total" {{$summon !== 'draf'? 'disabled' : ''}}>
                    </div>
                    
                </div>
                <div class="row g-3 mt-2">
                    @hasanyrole('penolong-jurutera-jkr|jurutera-jkr|pentadbir-sistem-spakat')

                    <div class="col-3">
                        <button class="btn btn-primary text-white fw-bold" type="submit">Simpan</button>
                    </div>

                    @endhasanyrole
                </div>
            </form>
        </div>
    </div>
</div>
