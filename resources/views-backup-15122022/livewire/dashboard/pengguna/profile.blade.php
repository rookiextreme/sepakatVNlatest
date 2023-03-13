<div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" class="text-dark" href="#">MAKLUMAT PENGGUNA</a>
                </li>
            </ul>
            <form wire:submit.prevent="save" class="row mt-3">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="ttl_196">Nama Penuh <em>*</em></label> 
                            <input
                                wire:model="name"
                                type="text" class="form-control" name="fullname"
                                id="fullname" required
                                value=""
                                placeholder="">
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="ttl_196">MyKad <em>*</em></label> 
                            <input
                                wire:model="identityNo"
                                type="text" class="form-control" name="identityNo"
                                id="icno" required
                                value=""
                                placeholder="">
                                @error('identityNo') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="ttl_196">Emel <em>*</em></label> 
                            <input
                                wire:model="email"
                                type="email" class="form-control" name="email"
                                id="email" required
                                value=""
                                placeholder="">
                                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="ttl_196">Tel Bimbit<em>*</em></label> 
                            <input
                                wire:model="phone"
                                type="text" class="form-control" name="mobile"
                                id="mobile" required
                                value=""
                                placeholder="">
                                @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="ttl_196">Tel Pejabat</label>
                            <input
                                wire:model="office"
                                type="text" class="form-control" name="fullname"
                                id="fullname" required
                                value=""
                                placeholder="">
                                @error('office') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                        <label class="form-label">Tujuan Mendaftar <em>*</em> <i class="fa fa-info-circle"></i></label>
                        <div class="form-check form-check-inline mr-2">
                            <input class="form-check-input" type="radio" wire:model="gover" name="role" id="role1" value="true">
                            <label class="form-check-label" for="role1">Kegunaan Rasmi</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" wire:model="gover" name="role" id="role2" value="false">
                            <label class="form-check-label" for="role2">Pihak Ketiga</label>
                        </div>
                    </div>
                </div>
                @if ($gover == 'true')
                <div id="sect-govt">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="ttl_196">Jawatan <em>*</em></label> 
                                <input
                                    wire:model="jawatan"
                                    type="text" class="form-control" name="jawatan"
                                    id="jawatan" required
                                    value=""
                                    placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                            <label class="form-label">Kementerian <em>*</em></label>
                            <select class="form-select form-select" id="div1" wire:model="kem" name="kem" data-placeholder="[Sila pilih]">
                                <option value="">Pilih</option>
                                @foreach ($ministryLists as $list )
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                            <label class="form-label">Jabatan <em>*</em></label>
                            <select class="form-select form-select" id="div2" wire:model="jabatan"  name="div2" data-placeholder="[Sila pilih]">
                                <option value="">Pilih</option>
                                @foreach ($jabatans as $list )
                                    <option value="{{$list->id}}">{{$list->jabatan}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="sect-others">
                        <div class="row">
                            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="ttl_196">Namakan Jabatan / Unit</label> 
                                    <input
                                        wire:model="unit"
                                        type="text" class="form-control" name="div00"
                                        id="div00"
                                        value=""
                                        placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                @if ($gover != null)
                <div id="sect-3rdparty">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                            <label class="form-label">Pihak Ketiga <em>*</em> <i class="fa fa-info-circle"></i></label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="jkr" name="isContractor" id="isContractor1" value="true">
                                <label class="form-check-label mr-3" for="isContractor1">Kontraktor</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" wire:model="jkr" name="isContractor" id="isContractor2" value="false">
                                <label class="form-check-label" for="isContractor2">Orang Awam</label>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($jkr == 'true')
                <div id="sect-contractor">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                            <label class="form-label">Nama Syarikat <em>*</em></label>
                            <input wire:model="companyName" type="text" class="form-control" id="companyname" name="companyname" value="" placeholder="cth. Syarikat Maju Jaya Sdn Bhd">
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                            <label class="form-label">No SSM <em>*</em></label>
                                <input wire:model="ssmno" type="text" class="form-control" id="rocno" name="rocno" value="" placeholder="cth. 1111111-X">
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                            <label class="form-label">Nama Projek Terkini <em>*</em></label>
                            <input wire:model="projectName" type="text" class="form-control" id="projectName" name="projectName" value="" placeholder="cth. Pembinaan 3 Blok Sekolah">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                            <label class="form-label">Kementerian <em>*</em></label>
                            <select wire:model="companyKem" class="form-select form-select" id="project_owner" name="project_owner" data-placeholder="[Sila pilih]">
                                <option value="">Pilih</option>
                                @foreach ($ministryLists as $list )
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @endif
                <div class="form-group center form-group center mt-2">
                    <button type="submit" class="btn btn-primary text-white">Simpan</button>
                    <button type="reset" class="btn btn-reset btn-danger text-white">Batal</button>
                </div>
                <p>&nbsp;</p>
            </form>
        </div>
    </div>
</div>
