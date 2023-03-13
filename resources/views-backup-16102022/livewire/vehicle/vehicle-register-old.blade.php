<div>
    <style>

    .delete {
        background: #dd3444;
        padding-right: 9px;
        padding-top: 3px;
        border-radius: 15px;
        height: 30px;
        width: 30px;
        float: right;
        color: white;
        z-index: 1;
        position: relative;
        margin-right: -30px;
    }
    .box-item:hover {
        background-color: antiquewhite;
    }


    </style>
    {{-- Do your work, then step back. --}}
    <ul class="nav nav-tabs mb-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link {{$tab == 'pendaftaran' ? 'active' : ''}}" wire:click="$set('tab', 'pendaftaran')">Maklumat Pendaftaran</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$tab == 'maklumat' ? 'active' : ''}} {{empty($reg['id']) ? 'disabled' : ''}}" wire:click="$set('tab', 'maklumat')">Maklumat Kenderaan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$tab == 'tambahan' ? 'active' : ''}} {{empty($reg['id']) ? 'disabled' : ''}}" wire:click="$set('tab', 'tambahan')">Maklumat Tambahan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{$tab == 'upload' ? 'active' : ''}} {{empty($reg['id']) ? 'disabled' : ''}}" wire:click="$set('tab', 'upload')">Muat Naik</button>
          </li>
      </ul>
      @json($reg)
      <div class="tab-content" id="myTabContent">
          @if ($tab == 'pendaftaran')
            <form wire:submit.prevent="pendaftaran" class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">No Pendaftaran</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">{{$reg['no']}}</div>
                        @else
                        <input type="text" wire:model="reg.no" class="form-control">
                        @endif

                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Hak Milik</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">{{$reg['hak']}}</div>
                        @else
                        <div class="input-group mb-3">
                            <select class="form-select" wire:model="reg.hak" >
                                <option selected>Pilih</option>
                                <option value="persekutuan">Persekutuan</option>
                                <option value="negeri">Negeri</option>
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Negeri Penempatan</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$reg['stateName']}}
                            </div>
                        @else
                        <div class="input-group mb-3">
                            <select class="form-select" wire:model="reg.negeri">
                            <option selected>Choose...</option>
                            @foreach ($negeris as $negeri )
                               <option value="{{$negeri->id}}">{{$negeri->negeri}}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label  text-dark">Cawangan / Bahagian</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$reg['branchName']}}
                            </div>
                        @else
                        <div wire:ignore class="input-group mb-3">
                            <select class="form-select" id="req_cawangan" wire:model="reg.cawangan" >
                                <option selected>Choose...</option>
                                {{-- @if (!empty($reg['negeri']))
                                    @foreach ($cawangan as $caw )
                                        @if ($reg['negeri'] == $caw->state_id)
                                            <option value="{{$caw->id}}">{{$caw->cawangan}}</option>
                                        @endif
                                    @endforeach
                                @endif --}}
                                @foreach ($cawangan as $caw )
                                    <option value="{{$caw->id}}">{{$caw->cawangan}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Lokasi Penempatan</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$reg['locationName']}}
                            </div>
                        @else
                        <div class="input-group mb-3">
                            <select class="form-select" wire:model="reg.lokasi" >
                                <option selected>Choose...</option>
                                {{-- @if (!empty($reg['negeri']))
                                    @foreach ($daerah as $caw )
                                        @if ($reg['negeri'] == $caw->state_id)
                                            <option value="{{$caw->id}}">{{$caw->daerah}}</option>
                                        @endif
                                    @endforeach
                                @endif --}}
                                @foreach ($placement_list as $placement )
                                    <option value="{{$placement->id}}">{{$placement->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">No ID Pemunya</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$reg['noid']}}
                            </div>
                        @else
                        <input type="text" wire:model="reg.noid" class="form-control">
                        @endif
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">No JKR</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{$reg['jkr']}}
                            </div>
                        @else
                        <input type="text" wire:model="reg.jkr" class="form-control">
                        @endif
                    </div>
                    {{-- <div class="col-md-4">
                        <label for="" class="form-label text-dark">No JKR</label>
                        <input type="text" class="form-control">
                    </div> --}}
                    @if (empty($is_display) && ($is_display == 0))
                    <div class="row">
                        <br><br>

                        <div class="col-md-4 mt-5">
                            <button class="btn btn-primary text-white" type="submit">Save</button>
                            {{-- @if ()
                            <button class="btn btn-dark text-white" type="submit">Submit</button>
                            @endif --}}
                            @if (!empty($reg['id']))
                               <button class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">Submit</button>
                            @endif

                        </div>
                    </div>
                    @endif

                </form>
          @elseif($tab == 'maklumat')
                @if (!empty($succes))
                    <div class="alert alert-success">{{$succes}}</div>
                @endif
                <form wire:submit.prevent="kenderaan" class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Kategori</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($maklumat['categoryMame']) ?$maklumat['categoryMame']: ''}}
                            </div>
                        @else
                            <div class="input-group mb-3">
                                <select id="category_id" class="form-select" wire:change="changeCategory">
                                    <option value="">Choose...</option>
                                    @foreach ($categoryList as $category )
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Sub Kategori</label>

                        <div class="input-group mb-3">
                            {{-- todo wired issue --}}
                            <input type="hidden" wire:change="changeSubCategory">
                            <select class="form-select" wire:change="changeSubCategory" wire:model="maklumat.sub_category_id">
                                <option value="">Choose...</option>
                                {{-- @if(!empty($maklumat['category_id']))
                                    @foreach ($subCategoryList as $subCategory)
                                        @if ($subCategory->category_id == $maklumat['category_id'])
                                            <option value="{{$subCategory->id}}">{{$subCategory->name}}</option>
                                        @endif
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label text-dark">Jenis Kategori</label>

                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($maklumat['subCategoryMame']) ? $maklumat['subCategoryMame']: ''}}
                                    </div>
                                @else
                                <div class="input-group mb-3">
                                    <select class="form-select" wire:model="maklumat.sub_category_type_id">
                                        <option value="">Choose...</option>
                                        @if (!empty($maklumat['sub_category_id']))
                                        @foreach ($subCategoryTypeList as $subCategoryType)
                                            @if ($subCategoryType->sub_category_id == $maklumat['sub_category_id'])
                                                <option value="{{$subCategoryType->id}}">{{$subCategoryType->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-md-4"></div> --}}
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Pembuat</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($maklumat['brandName'])?$maklumat['brandName']:''}}
                            </div>
                        @else
                        <div class="input-group mb-3">
                            <select class="form-select" id="maklumat_pembuat" wire:model="maklumat.pembuat">
                            <option value="">Choose...</option>
                            @foreach ($brands as $brand )
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label  text-dark">Model</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($maklumat['modelName'])?$maklumat['modelName']: ''}}
                            </div>
                        @else
                        <select class="form-select" id="maklumat_model" wire:model="maklumat.model">
                            <option value="">Choose...</option>
                            @if (!empty($maklumat['pembuat']))
                                @foreach ($models as $model)
                                    <option value="{{$model->id}}">{{$model->model}}</option>
                                @endforeach
                            @endif
                        </select>

                        @endif
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">No Engine</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($maklumat['engine'])? $maklumat['engine'] : ''}}
                            </div>
                        @else
                        <input type="text" class="form-control" wire:model="maklumat.engine">
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">No Chasis</label>
                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($maklumat['chasis']) ? $maklumat['chasis'] : ''}}
                            </div>
                        @else
                        <input type="text" class="form-control" wire:model="maklumat.chasis">
                        @endif
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Status Kenderaan</label>

                        @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($maklumat['vehicle']) ? $maklumat['vehicle'] : ''}}
                            </div>
                        @else
                        <div class="input-group mb-3">
                            <select class="form-select" wire:model="maklumat.vehicle">
                            <option selected>Choose...</option>
                            <option value="active">Aktif</option>
                            <option value="lupus">Lupus</option>
                            </select>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <div class="row">


                            <div class="col-md-8">
                                <label for="" class="form-label text-dark">Gambar Kenderaan</label><br>

                                @if (!empty($is_display) && ($is_display == 1))
                                <div class="text-capitalize theme-color-text border"  style="height: 200px;width: 400px;overflow-y: hidden;">
                                    @foreach ($documents as $doc)

                                    @if ($doc->doc_type == 'gambarKenderaan')
                                        <div class="" style="height:200px;width: 200px;">
                                            <div class="delete" wire:click="$emit('confirmation', {{$doc->id}})">
                                                <img  src="{{$doc->doc_path}}/{{$doc->doc_name}}" height="150px"/>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                </div>
                                @else
                                @if (count($documents)>0)
                                    <label for="photo"><span class="btn btn-sm btn-primary text-white">Tambah Lagi</span></label>
                                    <input type="file" id="photo" hidden class="form-control" wire:model="photo">
                                @else
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" wire:model="photo">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                @endif
                                <div class="overflow-scroll" style="height: 130px;padding: 5px;">
                                    <div class="text-capitalize theme-color-text border row flex-row flex-nowrap">
                                        @foreach ($documents as $doc)

                                        @if ($doc->doc_type == 'gambarKenderaan')
                                        <div class="col-6 ms-2 me-2 cursor-pointer box-item">
                                            {{-- deleteDocument($documentType, $docPath, $docName, $docId){ --}}
                                            <span data-bs-toggle="modal" data-bs-target="#confirmationDeleteModal" class="btn btn-sm btn-danger delete" wire:click.prevent="$emit('deleteDocumentMD', 'vehicle', '{{$doc->doc_path}}', '{{$doc->doc_name}}', {{$doc->id}}, {{$currentId}}, {{$is_display}}, '{{$tab}}', 'Kenderaan Berjaya dihapuskan')">X</span>
                                            {{-- <span class="btn btn-sm btn-danger delete" wire:click="deleteDocument('vehicle', '{{$doc->doc_path}}', '{{$doc->doc_name}}', {{$doc->id}}, '')">X</span> --}}
                                            <img wire:click.prevent="$emit('userEnlargeImageMD', '{{$doc->doc_path}}/{{$doc->doc_name}}')" data-bs-toggle="modal" data-bs-target="#enlargeImageModal" src="{{$doc->doc_path}}/{{$doc->doc_name}}" height="150px" width="100%"/>
                                         </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                            </div>
                            @if ($photo)
                                <div class="col-md-4">
                                    <img src="{{ $photo->temporaryUrl() }}" class="img-fluid img-thumbnail" alt="">
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(!empty($maklumat['vehicle']))
                       @if ($maklumat['vehicle'] == 'lupus')
                            <div class="col-md-4">
                                    <label for="" class="form-label text-dark">Tarikh Belian</label>
                                    <input type="date" class="form-control calender" wire:model="maklumat.tarikhbelian">
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <label for="" class="form-label text-dark">No Resit Rasmi</label>
                                    <input type="text" class="form-control" wire:model="maklumat.noresit">
                                </div>
                                <div class="col-md-4">
                                    <label for="" class="form-label text-dark">Pembeli / Penerima</label>
                                    <input type="text" class="form-control" wire:model="maklumat.penerima">
                                </div>
                                <div class="col-md-4"></div>
                       @endif
                    @endif

                    @if (empty($is_display) && ($is_display == 0))
                        <div class="row">
                            <br><br>

                            <div class="col-md-4 mt-5">
                                <button class="btn btn-primary text-white" type="submit">Save</button>
                                @if (!empty($reg['id']))
                                <button class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">Submit</button>
                                @endif

                            </div>
                        </div>
                    @endif
                </form>

                <script>
                    $('#category_id').select2({
                        width : '100%',
                        theme : 'classic'
                    }).on('change', function (e) {
                        console.log($(this).val());
                        @this.set('maklumat.category_id', $(this).val());
                    });
                    $('#maklumat_pembuat').select2({
                        width : '100%',
                        theme : 'classic'
                    }).on('change', function (e) {
                        console.log($(this).val());
                        @this.set('maklumat.pembuat', $(this).val());
                    });

                    $('#maklumat_model').select2({
                        width : '100%',
                        theme : 'classic'
                    }).on('change', function (e) {
                        console.log($(this).val());
                        @this.set('maklumat.model', $(this).val());
                    });
                </script>
          @elseif($tab == 'tambahan')
          @if (!empty($succes))
                    <div class="alert alert-success">{{$succes}}</div>
                @endif
          <div class="mt-4"></div>
            <form wire:submit.prevent="tambahan" class="mt-2">
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">No ID Pemunya</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($tambahan['idJabatan']) ? $tambahan['idJabatan'] : ""}}
                                    </div>
                                @else
                                <input type="text" class="form-control" wire:model="tambahan.idJabatan">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">No Jkr</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($tambahan['noJkr']) ? $tambahan['noJkr'] : ""}}
                                    </div>
                                @else
                                <input type="text" class="form-control" wire:model="tambahan.noJkr">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">No Loji</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($tambahan['noLoji']) ? $tambahan['noLoji'] : ""}}
                                    </div>
                                @else
                                <input type="text" class="form-control" wire:model="tambahan.noLoji">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-dark">Tarikh Cukai Jalan</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($tambahan['cukaiJalan']) ? $tambahan['cukaiJalan'] : ""}}
                                    </div>
                                @else
                                    <div class="form-group">
                                        <div wire:ignore class="input-group date" id="roadTaxDt"
                                            data-target-input="nearest" data-roadtaxdt="@this">
                                                <input data-target="#roadTaxDt" id="roadTaxDtInput"
                                                type="text" class="form-control datepicker" placeholder=""
                                                autocomplete="off"
                                                data-provide="datepicker" data-date-autoclose="true"
                                                data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                                value="{{isset($tambahan['cukaiJalan'])? $tambahan['cukaiJalan']: null}}"/>

                                                <div class="input-group-text" for="roadTaxDtInput">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                        </div>
                                    </div>
                                @error('tambahan.cukaiJalan') <span class="error text-danger">{{ $message }}</span> @enderror
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Harga Perolehan</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                    <div class="text-capitalize theme-color-text">
                                        {{isset($tambahan['hargaPerolehan']) ? $tambahan['hargaPerolehan'] : ""}}
                                    </div>
                                @else
                                <input type="text" class="form-control" wire:model="tambahan.hargaPerolehan">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Tarikh Pembelian Kenderaan</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                <div class="text-capitalize theme-color-text">
                                    {{isset($tambahan['tarikhPembelian']) ? $tambahan['tarikhPembelian'] : ""}}
                                </div>
                                @else
                                <div wire:ignore class="input-group date" id="tarikhPembelian"
                                    data-target-input="nearest" data-tarikhpembelian="@this">
                                        <input data-target="#tarikhPembelian" id="tarikhPembelianInput"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                        value="{{isset($tambahan['tarikhPembelian'])? $tambahan['tarikhPembelian']: null}}"/>

                                        <div class="input-group-text" for="tarikhPembelianInput">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">No Lo (Pesanan Tempatan)</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                <div class="text-capitalize theme-color-text">
                                    {{isset($tambahan['noLo']) ? $tambahan['noLo'] : ""}}
                                </div>
                                @else
                                <input type="text" class="form-control" wire:model="tambahan.noLo">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Tarikh Pemeriksaan Fizikal</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                <div class="text-capitalize theme-color-text">
                                    {{isset($tambahan['pemeriksaanFizikal']) ? $tambahan['pemeriksaanFizikal'] : ""}}
                                </div>
                                @else
                                <div wire:ignore class="input-group date" id="pemeriksaanFizikal"
                                    data-target-input="nearest" data-pemeriksaanfizikal="@this">
                                        <input data-target="#pemeriksaanFizikal" id="pemeriksaanFizikalInput"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                        value="{{isset($tambahan['pemeriksaanFizikal'])? $tambahan['pemeriksaanFizikal']: null}}"/>

                                        <div class="input-group-text" for="pemeriksaanFizikalInput">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Tarikh Pemeriksaan Keselamatan</label>
                                @if (!empty($is_display) && ($is_display == 1))
                                <div class="text-capitalize theme-color-text">
                                    {{isset($tambahan['pemeriksaanKeselamatan']) ? $tambahan['pemeriksaanKeselamatan'] : ""}}
                                </div>
                                @else
                                <div wire:ignore class="input-group date" id="pemeriksaanKeselamatan"
                                    data-target-input="nearest" data-pemeriksaankeselamatan="@this">
                                        <input data-target="#pemeriksaanKeselamatan" id="pemeriksaanKeselamatanInput"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                        value="{{isset($tambahan['pemeriksaanKeselamatan'])? $tambahan['pemeriksaanKeselamatan']: null}}"/>

                                        <div class="input-group-text" for="pemeriksaanKeselamatanInput">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 border-start">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Tarikh Kemaskini</label>
                            @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($tambahan['kemaskini']) ? $tambahan['kemaskini'] : ""}}
                            </div>
                            @else
                            <div wire:ignore class="input-group date" id="kemaskini"
                                data-target-input="nearest" data-kemaskini="@this">
                                    <input data-target="#kemaskini" id="kemaskiniInput"
                                    type="text" class="form-control datepicker" placeholder=""
                                    autocomplete="off"
                                    data-provide="datepicker" data-date-autoclose="true"
                                    data-date-format="yyyy-mm-dd" data-date-today-highlight="true"
                                    value="{{isset($tambahan['kemaskini'])? $tambahan['kemaskini']: null}}"/>

                                    <div class="input-group-text" for="kemaskiniInput">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Kemaskini Oleh</label>
                            @if (!empty($is_display) && ($is_display == 1))
                            <div class="text-capitalize theme-color-text">
                                {{isset($tambahan['kemaskiniOleh']) ? $tambahan['kemaskiniOleh'] : ""}}
                            </div>
                            @else
                            <input type="text" class="form-control" wire:model="tambahan.kemaskiniOleh" value="">
                            @endif
                        </div>
                    </div>
                </div>
                @if (empty($is_display) && ($is_display == 0))
                <div class="row">
                    <br><br>

                    <div class="col-md-4 mt-5">
                        <button class="btn btn-primary text-white" type="submit">Save</button>
                        @if (!empty($reg['id']))
                            <button class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">Submit</button>
                        @endif
                    </div>
                </div>
                @endif
            </form>
            <script>
                $("#roadTaxDt").on('change.datepicker', function(e){
                    let date = $(this).data('roadtaxdt');
                    eval(date).set('tambahan.cukaiJalan', $('#roadTaxDtInput').val());
                });

                $("#tarikhPembelian").on('change.datepicker', function(e){
                    let date = $(this).data('tarikhpembelian');
                    eval(date).set('tambahan.tarikhPembelian', $('#tarikhPembelianInput').val());
                });

                $("#pemeriksaanFizikal").on('change.datepicker', function(e){
                    let date = $(this).data('pemeriksaanfizikal');
                    eval(date).set('tambahan.pemeriksaanFizikal', $('#pemeriksaanFizikalInput').val());
                });

                $("#pemeriksaanKeselamatan").on('change.datepicker', function(e){
                    let date = $(this).data('pemeriksaankeselamatan');
                    eval(date).set('tambahan.pemeriksaanKeselamatan', $('#pemeriksaanKeselamatanInput').val());
                });

                $("#kemaskini").on('change.datepicker', function(e){
                    let date = $(this).data('kemaskini');
                    eval(date).set('tambahan.kemaskini', $('#kemaskiniInput').val());
                });
            </script>
          @elseif($tab == 'upload')
                @if (!empty($succes))
                    <div class="alert alert-success">{{$succes}}</div>
                @endif
            <form wire:submit.prevent="dokumen" class="row g-3 mt-2">
                @if (!empty($maklumat['vehicle']))
                    @if ($maklumat['vehicle'] == 'lupus')

                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">KEW.PA 13 (Perakuan Pelupusan)</label>
                            <div class="input-group mb-3">
                                <input type="file" wire:model="fails.kewpa13" class="form-control" >
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">KEW.PA 23 (Sijil Pelupusan)</label>
                            <div class="input-group mb-3">
                                <input type="file" wire:model="fails.kewpa23"  class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">Surat Pemohonan</label>
                            <div class="input-group mb-3">
                                <input type="file" wire:model="fails.suratpemohonan"  class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">Resit/ Bil Jualan</label>
                            <div class="input-group mb-3">
                                <input type="file" wire:model="fails.resitjualan" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                    @else
                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">Geran Kenderaan</label>
                            <div class="input-group mb-3">
                                <input type="file" wire:model="fails.geran" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label text-dark">KEW.PA 3 / KEW.312</label>
                            <div class="input-group mb-3">
                                <input type="file" wire:model="fails.kewpa3" class="form-control" id="inputGroupFile02">
                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                            </div>
                        </div>
                    @endif
                @endif

                @if (empty($is_display) && ($is_display == 0))
                <div class="row">
                    <br><br>

                    <div class="col-md-4 mt-5">
                        <button class="btn btn-primary text-white" type="submit">Save</button>
                        @if (!empty($reg['id']))
                            <button class="btn btn-dark text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">Submit</button>
                        @endif
                        {{-- <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Launch static backdrop modal
                        </button>

                        <!-- Modal --> --}}
                    </div>
                </div>
                @endif
            </div>
            </form>
          @endif
          @if (!empty($reg['id']))
            @livewire('dashboard.kenderaan.komponen.submit-modal', ['regid' => $reg['id']])
            {{-- components.user.modal-approval --}}
            {{-- components.enlarge.image.modal-enlarge-image --}}
            @livewire('components.enlarge.image.modal-enlarge-image')
            @livewire('components.confirmation.confirmation-delete-document', ['doc_id' => $this->doc_id])
          @endif

      </div>

        <script>
            jQuery(document).ready(function() {
                initTab();
                $('#req_cawangan').select2({
                    width : '100%',
                    theme : 'classic'
                }).on('change', function (e) {
                    console.log($(this).val());
                    @this.set('reg.cawangan', $(this).val());
                });
            })
        </script>

</div>
