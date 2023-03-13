@php

    $hasRepairMethod = $detail->repair_method;

    $hasFormRepairInternal = null;
    $hasWaranTypeInternal = null;
    $hasQuotationInternal = null;

    $hasFormRepairExternal = null;
    $hasWaranTypeExternal = null;
    $hasQuotationExternal = null;

    $hasExternalRepair = $detail->hasExternalRepair;

    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;

    if($repair_method_id){
        $hasRepairMethod = $detail->hasJVEForm->repair_method;

        $hasFormRepairInternal = $detail->hasJVEForm->hasFormRepairInternal->first();
        if($hasFormRepairInternal){
            $hasWaranTypeInternal = $hasFormRepairInternal->hasWaranType;
        }
        $hasQuotationInternal = $detail->hasQuotationInternal->first();
        $hasWaranTypeInternal = $hasQuotationInternal && $hasQuotationInternal->hasWaranType ? $hasQuotationInternal->hasWaranType : '';

        $hasFormRepairExternal = $detail->hasJVEForm->hasFormRepairExternal->first();
        
        if($hasFormRepairExternal){
            $hasWaranTypeExternal = $hasFormRepairExternal->hasWaranType;
            $MJobVehicleStatus = $hasFormRepairExternal->hasMaintenanceJobVehicleStatus;
        }
        
        $hasQuotationExternal = $detail->hasQuotationExternal->first();
        $hasWaranTypeExternal = $hasQuotationExternal && $hasQuotationExternal->hasWaranType ? $hasQuotationExternal->hasWaranType : '';

        $hasExternalRepair = $detail->hasJVEForm->hasExternalRepair;

    } else {
        if($detail->hasInternalQuot){
            $hasQuotationInternal = $detail->hasInternalQuot;
            $hasWaranTypeInternal = $hasQuotationInternal && $hasQuotationInternal->hasWarantType ? $hasQuotationInternal->hasWarantType :'';
        }
        if($detail->hasExternalQuot){
            $hasQuotationExternal = $detail->hasExternalQuot;
            $hasWaranTypeExternal = $hasQuotationExternal && $hasQuotationExternal->hasWarantType ? $hasQuotationExternal->hasWarantType : '';
        }
        
    }

@endphp
<form id="frm_vehicle_inspect">
    @csrf
    <div class="fixed-submit">
        @if(in_array($MJobVehicleStatus->code, ['02']) || 
            auth()->user()->isAdmin() ||
            in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            )
        <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
        @endif
        @if(auth()->user()->isForemenMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['02']))
                <button class="btn btn-module" type="button" onclick="prompInspectVerification()">Hantar Untuk Semakan</button>
            @endif
        @endif
        @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance() || auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['03','04','07']))
                <button class="btn btn-module" onclick="silentSave(this)" id="btn_is_research_market" style="display: {{$detail->is_research_market && $detail->is_research_market == 1 ? '':'none'}};" type="button" data-bs-toggle="modal" data-bs-target="#prompResearchMarketModal">Seterusnya</button>
                <button data-save-as="inspect" onclick="silentSave(this)" class="btn btn-module" id="btn_is_not_research_market" style="display: {{in_array($detail->is_research_market, [0,2]) ? '':'none'}};" type="button" data-bs-toggle="modal" data-bs-target="#prompMaintenanceModal">Seterusnya</button>
            @endif
        @endif
    </div>
    <input type="hidden" name="section" id="section" value="inspect">
    <div class="row">
        <p>
            PEMERIKSAAN KENDERAAN (CKM.J.01)
            <div> <i class="fas fa-info-circle"></i>&nbsp;Sila isikan butiran pemeriksaan bagi kenderaan ini </div>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <legend>Pemeriksa</legend>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Tarikh Pemeriksaan</label>
                            <div class="text-uppercase">{{$detail->inspected_dt ? \Carbon\Carbon::parse($detail->inspected_dt)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y')}}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="form-label">Nama Pemeriksa</label>
                            <div class="text-uppercase">{{$detail->inspectedBy ? $detail->inspectedBy->name : auth()->user()->name}}</div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-12">
            <fieldset>
                <legend>Butiran Pemeriksaan</legend>
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Kategori</label>
                        @if(
                            (in_array($MJobVehicleStatus->code, ['02']) && auth()->user()->isForemenMaintenance()) ||
                            (in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                        )
                        <select name="category_id" id="category"
                            class="form-control form-select"
                            onchange="getSubCategory(this.value)">
                            <option value="">Sila Pilih</option>
                            @foreach ($category_list as $category)
                            <option
                                {{$detail->hasVehicle->hasCategory && $detail->hasVehicle->hasCategory->id == $category->id ? 'selected': ''}}
                                value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        <div class="hasErr"></div>
                        @else
                        {{$detail->hasVehicle->hasCategory ? $detail->hasVehicle->hasCategory->name : '-'}}
                        @endif
                    </div>
                    <div class="col-md-4">
                        <label for="" class="form-label text-dark">Sub-Kategori</label>
                        @if(
                            (in_array($MJobVehicleStatus->code, ['02']) && auth()->user()->isForemenMaintenance()) ||
                            (in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                        )
                        <select name="sub_category_id" id="list_sub_category"
                            class="form-control form-select"
                            onchange="getSubCategoryType(this.value)">
                            <option value="">Sila Pilih</option>
                        </select>
                        <div class="hasErr"></div>
                        @else
                        {{$detail->hasVehicle->hasSubCategory ? $detail->hasVehicle->hasSubCategory->name : '-'}}
                        @endif
                    </div>
                   
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">Jenis</label>
                                @if(
                                    (in_array($MJobVehicleStatus->code, ['02']) && auth()->user()->isForemenMaintenance()) ||
                                    (in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                                )
                                <select name="sub_category_type_id" id="list_sub_category_type"
                                    class="form-control form-select">
                                    <option value="">Sila Pilih</option>
                                </select>
                                @else
                                {{$detail->hasVehicle->hasSubCategoryType ? $detail->hasVehicle->hasSubCategoryType->name : '-'}}
                                @endif
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12" id="other_sub_type_name" style="display: none">
                                <div class="form-group">
                                    <label for="" class="form-label text-dark">Lain-lain Jenis Kenderaan</label>
                                    <input onchange="this.value = this.value.toUpperCase()" type="text" class="form-control" name="other_sub_category_type" id="other_sub_category_type" placeholder="Lain-lain Jenis Kenderaan">
                                    <div class="hasErr"></div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    @if(
                        in_array($MJobVehicleStatus->code, ['02']) ||
                        in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
                        )
                        <div class="col-md-12">
                            <div class="btn-group">
                                <span onclick="addMaintenanceVehicleFormInspectComponent()" class="btn cux-btn small"> <i class="fa fa-plus"></i> Tambah</span>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12" id="maintenance_job_vehicle_component_list"></div>
                </div>
            </fieldset>
        </div>
        
        @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance() || auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance() || auth()->user()->isSeniorEngineerMaintenance())
        <div class="col-md-12 mt-3">
            <fieldset>
                <legend>Butiran Kajian Pasaran</legend>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Cadangan Kaedah Pembaikan</label>
                                @if(
                                    (in_array($MJobVehicleStatus->code, ['02']) && auth()->user()->isForemenMaintenance()) ||
                                    (in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                                    )
                                    @foreach ($repair_method_list as $repair_method)
                                        @if ($repair_method->id != 3)
                                            <input data-code="{{$repair_method->code}}" {{in_array($repair_method->id, explode(',',$hasRepairMethod)) ? 'checked': ''}} class="form-check-input repair_method" type="checkbox" id="repair_method_id_{{$repair_method->id}}" value="{{$repair_method->id}}">
                                            <label class="cursor-pointer" for="repair_method_id_{{$repair_method->id}}">{{$repair_method->desc}}</label>
                                        @endif
                                    @endforeach
                                    <div class="repair_method_err"></div>
                                @else
                                <ul>
                                    @foreach ($repair_method_list as $repair_method)
                                        @if ($repair_method->id != 3)
                                            @if(in_array($repair_method->id, explode(',',$hasRepairMethod)))
                                                <li>{{$repair_method->desc}}</li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6" id="internal" style="{{in_array(1, explode(',', $hasRepairMethod)) ? '' : 'display: none;'}}">
                                        <fieldset>
                                            <legend>Secara Dalaman</legend>
                                            <div class="col-md-12">
                                                <label for="" class="form-label">Kaedah Perolehan</label>
                                                @if(
                                                in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                
                                                    <select name="is_research_market" class="form-select" id="is_research_market">
                                                        <option {{$detail->is_research_market == 0 ? 'selected' : ''}} value="0">Tidak Perlu</option>
                                                        <option {{$detail->is_research_market == 1 ? 'selected' : ''}} value="1">Pembelian Terus</option>
                                                        <option {{$detail->is_research_market == 2 ? 'selected' : ''}} value="2">Sebut Harga</option>
                                                    </select>
                                                    <span onclick="prompQuotation(1)" id="btn_is_quotation" class="btn btn-module" style="display: {{$detail->is_research_market == 2 ? '': 'none'}};">Kemaskini maklumat sebut harga</span>
                                                @else
                                                    @if($hasFormRepairInternal && $hasFormRepairInternal->is_research_market)
                                                        @switch($hasFormRepairInternal->is_research_market)
                                                            @case(0)
                                                            Tidak Perlu
                                                                @break
                                                            @case(1)
                                                            Pembelian Terus
                                                                @break
                                                            @case(2)
                                                            Sebut Harga
                                                                @break
                                                            @default
                                                        @endswitch
                                                        @else
                                                        -
                                                    @endif
                                                @endif
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6" id="external" style="{{in_array(2, explode(',', $hasRepairMethod)) ? '' : 'display: none;'}}">
                                        <fieldset>
                                            <legend>Secara Luaran</legend>
                                            <div class="col-md-12">
                                                <label for="" class="form-label">Justifikasi Pembaikan Luar</label>
                                                @if(
                                                    (in_array($MJobVehicleStatus->code, ['02']) && auth()->user()->isForemenMaintenance()) || 
                                                    (in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                                                )
                                                <select name="external_repair_id" id="external_repair_id">
                                                    <option value="">Sila Pilih</option>
                                                    @foreach ($external_repair_list as $external_repair)
                                                        <option data-code="{{$external_repair->code}}" {{$detail->external_repair_id == $external_repair->id ? 'selected': ''}} value="{{$external_repair->id}}">{{$external_repair->desc}}</option>
                                                    @endforeach
                                                </select>
                                                @else
                
                                                    @if($hasExternalRepair)
                                                    {{$hasExternalRepair->desc}}
                                                    @else
                                                    -
                                                    @endif
                                                @endif
                                                <div class="col-md-12" id="external_repair_container_other" style="display: none;">
                                                    <label for="" class="form-label">Lain-Lain</label>
                                                    <textarea class="form-control" style="resize: none;" name="other_external_note" id="other_external_note" cols="30" rows="5">{{$detail->other_external_note}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="" class="form-label">Kaedah Perolehan</label>
                                                @if(
                                                in_array($MJobVehicleStatus->code, ['03']) && (auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance()))
                                            
                                                    <select name="is_research_market_external" class="form-select" id="is_research_market_external">
                                                        <option {{$detail->is_research_market_external == 0 ? 'selected' : ''}} value="0">Tidak Perlu</option>
                                                        <option {{$detail->is_research_market_external == 1 ? 'selected' : ''}} value="1">Pembelian Terus</option>
                                                        <option {{$detail->is_research_market_external == 2 ? 'selected' : ''}} value="2">Sebut Harga</option>
                                                    </select>
                                                    <span onclick="prompQuotation(2)" id="btn_is_quotation_external" class="btn btn-module" style="display: {{$detail->is_research_market_external == 2 ? '': 'none'}};">Kemaskini maklumat sebut harga</span>
                                                @else
                                                    @if($hasFormRepairExternal && $hasFormRepairExternal->is_research_market)
                                                        @switch($hasFormRepairExternal->is_research_market)
                                                            @case(0)
                                                            Tidak Perlu
                                                                @break
                                                            @case(1)
                                                            Pembelian Terus
                                                                @break
                                                            @case(2)
                                                            Sebut Harga
                                                                @break
                                                            @default
                                                        @endswitch
                                                        @else
                                                        -
                                                    @endif
                                                @endif
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        </div>
        @endif
    </div>
</form>

<div class="modal fade" id="prompInspectVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompInspectVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Hantar untuk semakan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin menghantar untuk semakan?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="inspect" stage="inspect_verification" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addFormInspectComponentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addFormInspectComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Komponen
                    <div>Komponen Kenderaan yang akan dinilai</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddFormInspectComponent" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <span class="ms-2 mt-2" id="response"></span>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="form-label">Jenis Penyenggaraan <em class="text-danger">*</em> </label>
                                @foreach ($purpose_type_list as $purpose_type)
                                    <input class="form-check-input mt-2 ms-2" type="radio" onchange="inspect_getComponentLvl1(this.value)" name="purpose_type_id" id="purpose_type_id_{{$purpose_type->id}}" value="{{$purpose_type->id}}">
                                    <label class="form-check-label cursor-pointer" for="purpose_type_id_{{$purpose_type->id}}">{{$purpose_type->desc}}</label>
                                @endforeach
                                <div class="hasErr text-danger" id="inspect_purpose_type_id"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="inspect_lvl1_id" class="form-label">Pilih Sistem <em class="text-danger">*</em> </label>
                                    <select class="form-control" name="lvl1_id" id="inspect_lvl1_id" onchange="getComponentLvl2(this.value)">
                                        <option value="">Sila Pilih</option>
                                    </select>
                                    <div class="hasErr text-danger" id="inspect_lvl1_id"></div>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Pilih Komponen</label>
                                    <select class="form-control" name="lvl2_id" id="component_lvl2_list">
                                        <option value="">Sila Pilih</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Catatan Pemeriksaan</label>
                                    <textarea onkeyup="forceCapsWithoutTrim(this)" style="resize: none;" class="form-control" name="note" id="note" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="form_component_id" id="form_component_id">
                
            </div>
            <div class="modal-footer justify-content-between">

                <button type="submit" class="btn btn-module float-start">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>
                
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="delFormInspectComponentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delFormInspectComponentModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin menghapuskan maklumat ini ?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" onclick="deleteInspectComponent()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompResearchMarketModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompResearchMarketModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin teruskan ke Proses Pembelian Terus?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="inspect" stage="inspect_research_market" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompMaintenanceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompMaintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Pengesahan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin teruskan untuk Pembaikan & Servis?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="inspect" stage="inspect_not_research_market">Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompUpdateQuotationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompUpdateQuotationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" id="frm_update_quotation">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    Kemaskini Sebut harga
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="prompt-container" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="form-label">Pilihan Waran <em class="text-danger">*</em></label>
                            <select class="custom-select" name="waran_type_id" id="inspect_select_waran_type_id">
                                <option value="">Sila Pilih</option>
                                @foreach ($waran_type_list as $waran_type)
                                    <option data-code="{{$waran_type->code}}" {{$hasWaranTypeInternal && ($hasWaranTypeInternal->id == $waran_type->id) ? 'selected':''}} value="{{$waran_type->id}}">{{$waran_type->desc}}</option>
                                @endforeach
                            </select>
                            <div class="hasErr text-danger" id="inspect_waran_type_id"></div>
                        </div>
                        <div class="col-md-6" id="inspect_osol_type_container" style="{{$hasWaranTypeInternal && $hasWaranTypeInternal->code == '01' ? '' : 'display: none;'}}">
                            <label for="" class="form-label">Jenis Osol <em class="text-danger">*</em></label>
                            <select class="custom-select col-6" name="osol_type_id" id="inspect_select_osol_type_id">
                                <option value="">Sila Pilih</option>
                            </select>
                            <div class="hasErr text-danger" id="inspect_osol_type_id"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">No sebutharga <em class="text-danger">*</em></label>
                            <input name="quotation_no" type="text" class="form-control" value="{{$hasQuotationInternal ? $hasQuotationInternal->quotation_no : ''}}">
                            <div class="hasErr text-danger" id="inspect_quotation_no"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Nama syarikat pembekal <em class="text-danger">*</em></label>
                            <input name="company_name" type="text" class="form-control" value="{{$hasQuotationInternal ? $hasQuotationInternal->company_name : ''}}">
                            <div class="hasErr text-danger" id="inspect_company_name"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Tarikh Sebut Harga <em class="text-danger">*</em></label>
                            <div class="input-group date" id="quotation_dt" data-target-input="nearest">
                                    <input name="quotation_dt" id="quotation_dt_input"
                                    type="text" class="form-control datepicker" placeholder=""
                                    autocomplete="off"
                                    data-provide="datepicker" data-date-autoclose="true"
                                    data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                    value="{{$hasQuotationInternal ? \Carbon\Carbon::parse($hasQuotationInternal->quotation_dt)->format('d/m/Y') : ''}}"/>

                                    <div class="input-group-text" for="quotation_dt_input">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                            </div>
                            <div class="hasErr text-danger" id="inspect_quotation_dt"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Tarikh SST</label>
                            <div class="input-group date" id="sst_dt" data-target-input="nearest">
                                <input name="sst_dt" id="sst_dt_input"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                value="{{$hasQuotationInternal ? \Carbon\Carbon::parse($hasQuotationInternal->sst_dt)->format('d/m/Y') : ''}}"/>
                            
                                <div class="input-group-text" for="sst_dt_input">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="hasErr text-danger" id="inspect_sst_dt"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Jumlah harga (RM) <em class="text-danger">*</em> </label>
                            <input name="total_price" id="total_price_quotation" onchange="forceCurrency(this)" type="text" class="form-control" value="{{$hasQuotationInternal ? $hasQuotationInternal->total_price : ''}}">
                            <div class="hasErr text-danger" id="inspect_total_price"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Tarikh siap</label>
                            <div class="input-group date" id="end_dt" data-target-input="nearest">
                                <input name="end_dt" id="end_dt_input"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                value="{{$hasQuotationInternal ? \Carbon\Carbon::parse($hasQuotationInternal->end_dt)->format('d/m/Y') : ''}}"/>
                            
                                <div class="input-group-text" for="end_dt_input">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="hasErr text-danger" id="inspect_end_dt"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-module" >Ya</button>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="prompUpdateQuotationExternalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompUpdateQuotationExternalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" id="frm_update_quotation_external">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    Kemaskini Sebut harga
                    <button type="button" class="btn" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="prompt-external-container" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="form-label">Pilihan Waran <em class="text-danger">*</em></label>
                            <select class="custom-select" name="waran_type_id" id="inspect_select_waran_type_id_external">
                                <option value="">Sila Pilih</option>
                                @foreach ($waran_type_list as $waran_type)
                                    <option data-code="{{$waran_type->code}}" {{$hasWaranTypeExternal && $hasWaranTypeExternal->id == $waran_type->id ? 'selected':''}} value="{{$waran_type->id}}">{{$waran_type->desc}}</option>
                                @endforeach
                            </select>
                            <div class="hasErr text-danger" id="inspect_waran_type_id"></div>
                        </div>
                        <div class="col-md-6" id="inspect_osol_type_container" style="{{$hasWaranTypeExternal && $hasWaranTypeExternal->code == '01' ? '' : 'display: none;'}}">
                            <label for="" class="form-label">Jenis Osol <em class="text-danger">*</em></label>
                            <select class="custom-select col-6" name="osol_type_id" id="inspect_select_osol_type_id_external">
                                <option value="">Sila Pilih</option>
                            </select>
                            <div class="hasErr text-danger" id="inspect_osol_type_id"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">No sebutharga <em class="text-danger">*</em></label>
                            <input name="quotation_no" type="text" class="form-control" value="{{$hasQuotationExternal ? $hasQuotationExternal->quotation_no : ''}}">
                            <div class="hasErr text-danger" id="inspect_quotation_no"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Nama syarikat pembekal <em class="text-danger">*</em></label>
                            <input name="company_name" type="text" class="form-control" value="{{$hasQuotationExternal ? $hasQuotationExternal->company_name : ''}}">
                            <div class="hasErr text-danger" id="inspect_company_name"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Tarikh Sebut Harga <em class="text-danger">*</em></label>
                            <div class="input-group date" id="quotation_dt" data-target-input="nearest">
                                    <input name="quotation_dt" id="quotation_dt_input"
                                    type="text" class="form-control datepicker" placeholder=""
                                    autocomplete="off"
                                    data-provide="datepicker" data-date-autoclose="true"
                                    data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                    value="{{$hasQuotationExternal ? \Carbon\Carbon::parse($hasQuotationExternal->quotation_dt)->format('d/m/Y') : ''}}"/>
                
                                    <div class="input-group-text" for="quotation_dt_input">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                            </div>
                            <div class="hasErr text-danger" id="inspect_quotation_dt"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Tarikh SST</label>
                            <div class="input-group date" id="sst_dt" data-target-input="nearest">
                                <input name="sst_dt" id="sst_dt_input"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                value="{{$hasQuotationExternal ? \Carbon\Carbon::parse($hasQuotationExternal->sst_dt)->format('d/m/Y') : ''}}"/>
                            
                                <div class="input-group-text" for="sst_dt_input">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="hasErr text-danger" id="inspect_sst_dt"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Jumlah harga (RM) <em class="text-danger">*</em> </label>
                            <input name="total_price" id="total_price_quotation" onchange="forceCurrency(this)" type="text" class="form-control" value="{{$hasQuotationExternal ? $hasQuotationExternal->total_price : ''}}">
                            <div class="hasErr text-danger" id="inspect_total_price"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="form-label">Tarikh siap</label>
                            <div class="input-group date" id="end_dt" data-target-input="nearest">
                                <input name="end_dt" id="end_dt_input"
                                type="text" class="form-control datepicker" placeholder=""
                                autocomplete="off"
                                data-provide="datepicker" data-date-autoclose="true"
                                data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                value="{{$hasQuotationExternal ? \Carbon\Carbon::parse($hasQuotationExternal->end_dt)->format('d/m/Y') : ''}}"/>
                            
                                <div class="input-group-text" for="end_dt_input">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="hasErr text-danger" id="inspect_end_dt"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-module" >Ya</button>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

    let componentId = null;
    let inspectComponentIds = [];
    let compIdLvl1 = null;
    let compIdLvl2 = null;
    
    let subCategoryId = null;
    let subCategoryTypeId = null;

    let osol_type_id = '{{$hasQuotationInternal && $hasQuotationInternal->osol_type_id ? $hasQuotationInternal->osol_type_id : ''}}';
    let osol_type_id_external = '{{$hasQuotationExternal && $hasQuotationExternal->osol_type_id ? $hasQuotationExternal->osol_type_id: ''}}';
    let selected_repair_method_id = null;

    function getSubCategory(category_id){

        $('#list_sub_category').html('<option value="">Sila Pilih</option>');
        $('#list_sub_category_type').html('');
        $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategory')}}", {
            category_id: category_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;
            let display_list_sub_category = $('#display_list_sub_category');

            if(count == 0){
                display_list_sub_category.hide();
            }
            else{
                display_list_sub_category.show();
                result.forEach(element => {
                    $('#list_sub_category').append('<option value='+element.id+'>'+element.name+'</option>');
                    if(subCategoryId == element.id){
                        same = true;
                    }
                    totalInit++;
                });
            }

            if(count == totalInit){
                if(!same){
                    subCategoryId = null;
                }
                $('#list_sub_category').val(subCategoryId).trigger("change");
            }

        });
    }

    function getSubCategoryType(sub_category_id){

        $('#list_sub_category_type').html('');
        $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategoryType')}}", {
            sub_category_id: sub_category_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;
            let display_list_sub_category_type = $('#display_list_sub_category_type');

            if (count == 0){
                display_list_sub_category_type.hide();
            }
            else{
                display_list_sub_category_type.show();
                result.forEach(element => {
                    $('#list_sub_category_type').append('<option value='+element.id+' data-name='+element.name+'>'+element.name+'</option>');
                    totalInit++;
                    if(subCategoryTypeId == element.id){
                        same = true;
                    }
                });
            }


            if(count == totalInit){
                if(!same){
                    subCategoryTypeId = null;
                }

                console.log('subCategoryTypeId', subCategoryTypeId);

                //$('#list_sub_category_type').val(data.sub_category_type_id).trigger("change");
                $('#list_sub_category_type').val(subCategoryTypeId).trigger("change");
            }

        });
    }

    const inspect_getComponentLvl1 = function(pr_type_id){
        
        $('#inspect_lvl1_id').html('<option value="">Sila Pilih</option>');

        $.get('{{route('maintenance.job.vehicle.getComponentLvl1')}}', {
            pr_type_id: pr_type_id,
            compLvl: 1
        }, function(responses){
            responses.forEach(res => {
                $('#inspect_lvl1_id').append('<option '+ (compIdLvl1 == res.id ? "selected" : "") +' value='+res.id+'>'+res.component+'</option>');
            });
        });
    }
    
    const getComponentLvl2 = function(compId){
        
        $('#component_lvl2_list').html('<option value="">Sila Pilih</option>');

        $.get('{{route('maintenance.job.vehicle.getComponentLvl2')}}', {
            compId: compId,
            compLvl: 2
        }, function(responses){
            let isSame = false; 
            responses.forEach(res => {
                if(compIdLvl2 == res.id){
                    isSame = true;
                }
                $('#component_lvl2_list').append('<option value='+res.id+'>'+res.component+'</option>');
            });
            if(!isSame){
                compIdLvl2 = null;
            }
            $('#component_lvl2_list').val(compIdLvl2).trigger("change");
        });
    }

    const addMaintenanceVehicleFormInspectComponent = function(){

        $('#inspect_lvl1_id').html('<option value="">Sila Pilih</option>');
        
        let frmAddFormInspectComponent = $('#addFormInspectComponentModal #frmAddFormInspectComponent');
        frmAddFormInspectComponent[0].reset();
        componentId = null;
        compIdLvl1 = null;
        compIdLvl2 = null;
        $('#inspect_lvl1_id').val('').trigger('change');
        $('#note').val('');
        $('#addFormInspectComponentModal').modal('show');
    }

    const submitVehicleFormComponent = function(data, formElemt){
        let btnSubmit = $(formElemt).find('[type="submit"]');
        btnSubmit.prop('disabled', true);
        $('.hasErr').html('');
        $.ajax({
            url: '{{ route('maintenance.job.vehicle.getVehicleForm.inspect.component.save') }}',
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                btnSubmit.prop('disabled', false);
                loadMaintenanceJobVehicleComponentList();
                $('#lvl1_id').html('<option value="">Sila Pilih</option>');
                $('#addFormInspectComponentModal').modal('hide');
            },
            error: function(response) {
                btnSubmit.prop('disabled', false);
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('.hasErr#inspect_'+key).html(value[0]);
                });
            }
        });
    }

    const editInspectComponent = function(self){
        let data = $(self).parent().data('component');
        componentId = data.id;
        compIdLvl1 = data.ref_component_lvl1_id;
        compIdLvl2 = data.ref_component_lvl2_id;
        inspect_getComponentLvl1(data.maintenance_job_purpose_type_id);
        let frmAddFormInspectComponent = $('#addFormInspectComponentModal #frmAddFormInspectComponent');
        frmAddFormInspectComponent.find('#note').val(data.note);
        frmAddFormInspectComponent.find('#purpose_type_id_'+data.maintenance_job_purpose_type_id).prop('checked', true);
        $('#addFormInspectComponentModal').modal('show');
    }

    const delInspectComponent = function(id){
        inspectComponentIds = [id];
        $('#delFormInspectComponentModal').modal('show');
    }

    const deleteInspectComponent = function(){
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.inspect.component.delete') }}', {
            "_token": "{{ csrf_token() }}",
            'ids': inspectComponentIds
        }, function(res){
            inspectComponentIds = [];
            loadMaintenanceJobVehicleComponentList();
            $('#delFormInspectComponentModal').modal('hide');
        });
    }

    const loadMaintenanceJobVehicleComponentList = function(){
        $.get('{{route('maintenance.job.vehicle.getVehicleForm.inspect.component.list')}}', {
            form_id: '{{$form_id}}',
            repair_method_id: '{{$repair_method_id}}',
        }, function(result){
            $('#maintenance_job_vehicle_component_list').html(result);
        })
    }

    function ajaxLoadMaintenanceJobFormComponentPage(url){
        parent.startLoading();
        $.get(url, function(data){
            $('#maintenance_job_vehicle_component_list').html(data);
            parent.stopLoading();
        });
    }

    const prompQuotation = function(repair_method_id){
        selected_repair_method_id = repair_method_id;

        $('#prompUpdateQuotationModal #prompt-container').hide();
        $('#prompUpdateQuotationExternalModal #prompt-external-container').hide();

        if(selected_repair_method_id == 1){
            $('#prompUpdateQuotationModal #prompt-container').show();
            $('#prompUpdateQuotationExternalModal #prompt-external-container').hide();
            $('#prompUpdateQuotationModal').modal('show');
        }else if(selected_repair_method_id == 2){
            $('#prompUpdateQuotationModal #prompt-container').hide();
            $('#prompUpdateQuotationExternalModal #prompt-external-container').show();
            $('#prompUpdateQuotationExternalModal').modal('show');
        }
    }

    const updateQuotation = function(data, formElemt){

        let btnSubmit = $(formElemt).find('[type="submit"]');
        btnSubmit.prop('disabled', true);
        $('.hasErr').html('');

        $.ajax({
            url: '{{ route('maintenance.job.vehicle.getVehicleForm.inspect.quotation.save') }}',
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                btnSubmit.prop('disabled', false);
                $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                $('#prompUpdateQuotationModal').modal('hide');
                $('#prompUpdateQuotationExternalModal').modal('hide');
            },
            error: function(response) {
                btnSubmit.prop('disabled', false);
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('.hasErr#inspect_'+key).html(value[0]);
                });
            }
        });
    }

    const getInspectOsolType = function(warrantTypeId, container){
        console.log("container", container);
        $.get('{{route('maintenance.job.vehicle.getOsolType')}}', {
            warrantTypeId: warrantTypeId
        }, function(res){
            let osol_type = container.find('[name="osol_type_id"]');
            osol_type.html('<option value="">Sila Pilih</option>');
            res.forEach(element => {
                osol_type.append('<option data-code='+element.code+' value='+element.id+'>'+element.desc+'</option>')
            });
            osol_type.val(osol_type_id).trigger('change');

        })
    }

    const getInspectOsolTypeExternal = function(warrantTypeId, container){
        console.log("container", container);
        $.get('{{route('maintenance.job.vehicle.getOsolType')}}', {
            warrantTypeId: warrantTypeId
        }, function(res){
            let osol_type = container.find('[name="osol_type_id"]');
            osol_type.html('<option value="">Sila Pilih</option>');
            res.forEach(element => {
                osol_type.append('<option data-code='+element.code+' value='+element.id+'>'+element.desc+'</option>')
            });
            osol_type.val(osol_type_id_external).trigger('change');

        })
    }

    $(document).ready(function(){
        initTab();
        let tab = '{{$tab}}';
        $('#tab'+tab).trigger('click');

        $('select').select2({
            width: '100%',
            theme: "classic"
        });

        let quotation_dt_input = $('#quotation_dt_input').datepicker();
        let sst_dt_input = $('#sst_dt_input').datepicker();
        let end_dt_input = $('#end_dt_input').datepicker();
        let list_sub_category_type = $('#list_sub_category_type');
        let other = list_sub_category_type.find('option:selected', this).data('name');
        let other_sub_type_name = $('#other_sub_type_name');

        end_dt_input.datepicker('setStartDate', new Date());

        // $('#list_sub_category_type').on('change', function(e){
        //     let other = $(this).find('option:selected', this).data('name');
        //     if(other == 'LAIN-LAIN'){
        //         $('#other_sub_type_name').show();
        //     }
        //     else{
        //         $('#other_sub_type_name').hide();
        //     }
        // });
        loadMaintenanceJobVehicleComponentList();

        @if ($detail->hasVehicle->hasSubCategory)
            let categoryId = {{$detail->hasVehicle->hasSubCategory->hasCategory->id}};
            subCategoryId = {{$detail->hasVehicle->hasSubCategory->id}};
            getSubCategory(categoryId);
        @endif

        @if ($detail->hasVehicle->hasSubCategoryType)
            subCategoryTypeId = {{$detail->hasVehicle->hasSubCategoryType->id}};
            getSubCategoryType(subCategoryId);
        @endif

        let inspect_osol_type_container = null;

        @if($hasWaranTypeInternal)
            @if($hasWaranTypeInternal->code == '01')
                inspect_osol_type_container = $('#prompUpdateQuotationModal #inspect_osol_type_container');
                getInspectOsolType({{$hasWaranTypeInternal->id}}, inspect_osol_type_container.parent());
                inspect_osol_type_container.show();
            @endif
        @endif

        @if($hasWaranTypeExternal)
            @if($hasWaranTypeExternal->code == '01')
                inspect_osol_type_container = $('#prompUpdateQuotationExternalModal #inspect_osol_type_container');
                getInspectOsolTypeExternal({{$hasWaranTypeExternal->id}}, inspect_osol_type_container.parent());
                inspect_osol_type_container.show();
            @endif
        @endif

        @if ($detail->hasRepairMethod() && $detail->hasRepairMethod()->where('code', '01')->first())
            let inspect_repair_method_container = $('#inspect_repair_method_container');
            inspect_repair_method_container.show();
        @endif

        @if($hasQuotationInternal && $hasQuotationInternal->total_price)
        $('#total_price_quotation').trigger('change');
        @endif
        
        $('#frmAddFormInspectComponent').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            console.log(formData);
            let form_id = '{{$form_id}}';
            if(componentId){
                formData.append('id', componentId);
            }
            formData.append('form_id', form_id);
            submitVehicleFormComponent(formData, this);
        });

        $('#is_research_market').on('change', function(e){
            e.preventDefault();
            
            let is_research_market = this.value;
            console.log('is_research_market => ', is_research_market);
            switch (is_research_market) {
                case '0':
                    $('#btn_is_not_research_market').show();
                    $('#btn_is_research_market').hide();
                    $('#btn_is_quotation').hide();
                    break;
                case '1':
                    $('#btn_is_research_market').show();
                    $('#btn_is_not_research_market').hide();
                    $('#btn_is_quotation').hide();
                    break;
                case '2':
                    $('#btn_is_not_research_market').show();
                    $('#btn_is_research_market').hide();
                    $('#btn_is_quotation').show();
                    break;
            
                default:
                    break;
            }

        });

        $('#is_research_market_external').on('change', function(e){
            e.preventDefault();
            
            let is_research_market_external = this.value;
            console.log('is_research_market_external => ', is_research_market_external);
            switch (is_research_market_external) {
                case '0':
                $('#btn_is_not_research_market_external').show();
                $('#btn_is_research_market_external').hide();
                $('#btn_is_quotation_external').hide();
                break;
                case '1':
                $('#btn_is_research_market_external').show();
                $('#btn_is_not_research_market_external').hide();
                $('#btn_is_quotation_external').hide();
                break;
                case '2':
                $('#btn_is_not_research_market_external').show();
                $('#btn_is_research_market_external').hide();
                $('#btn_is_quotation_external').show();
                break;
            
                default:
                    break;
            }

        });

        $('#frm_update_quotation').on('submit', function(e){
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('repair_method_id', selected_repair_method_id);
            updateQuotation(formData, this);

        });

        $('#frm_update_quotation_external').on('submit', function(e){
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('repair_method_id', selected_repair_method_id);
            updateQuotation(formData, this);

        });

        $('.repair_method').on('change', function(e){

            e.preventDefault();

            let internal = $('#internal');
            let external = $('#external');
            let repair_methods = $.map($('.repair_method:checked'), function(n, i){
                return $(n).data('code');
            });

            internal.hide();
            external.hide();

            repair_methods.forEach(repair_method => {
                if(repair_method.indexOf('01') != -1){
                    internal.show();
                }else if(repair_method.indexOf('02') != -1){
                    external.show();
                }
            });

        });

        $('#external_repair_id').on('change', function(e){
            let id = this.value;
            let external_repair_code = $('option:selected', this).data('code');
            let external_repair_container_other = $('#external_repair_container_other');
            if(external_repair_code == '03'){
                external_repair_container_other.show();
            } else {
                external_repair_container_other.hide();
            }
        });

        $('#inspect_select_waran_type_id, #inspect_select_waran_type_id_external').on('change', function(e){
            let id = this.value;
            let waran_type_code = $('option:selected', this).data('code');
            let inspect_osol_type_container = $(this).parent().parent().find('#inspect_osol_type_container');
            if(waran_type_code == '01'){
                getInspectOsolType(id, $(this).parent().parent());
                inspect_osol_type_container.show();
            } else {
                let url = '{{route('maintenance.job.vehicle.getVehicleForm.research.market.WaranType')}}';

                inspect_osol_type_container.hide();
            }
        });

    });
</script>