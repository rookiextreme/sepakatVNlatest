@php
    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;

    $can_add_component = false;
    $can_edit_component = false;
    $can_delete_component = false;

    $can_add_supplier = false;
    $can_edit_supplier = false;
    $can_delete_supplier = false;

    if(
        auth()->user()->isAssistEngineer() || 
        auth()->user()->isAssistEngineerMaintenance() ||
        auth()->user()->isEngineer() || 
        auth()->user()->isEngineerMaintenance()
    ) {
        if(in_array($MJobVehicleStatus->code, ['04','05','06'])){
            $can_add_component = true;
            $can_edit_component = true;
            $can_delete_component = true;

            $can_add_supplier = true;
            $can_edit_supplier = true;
            $can_delete_supplier = true;
        }
    }
@endphp
{{-- @json($MJobVehicleStatus) --}}
<style>
    /* #osol_type_container .select2-container {
        width: 50% !important;
    } */
</style>
<form id="frm_vehicle_research_market">
    @csrf
    <div class="fixed-submit">
        @if(in_array($MJobVehicleStatus->code, ['04','05','06']))
        <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
        @endif

        @if(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
        {{-- Penolong Jurutera --}}
            @if(in_array($MJobVehicleStatus->code, ['05']))
                <button disabled id="btnApproval" class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompResearchMarketApprovalModal">Hantar Untuk Pengesahan</button>
            @endif
        @elseif(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
        {{-- Jurutera --}}
            @if(in_array($MJobVehicleStatus->code, ['06']))
                <button type="button" data-save-as="market" onclick="silentSave(this)" {{$detail && $detail->hasWaranType ? '': 'disabled'}} class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompResearchMarketApproveModal">Sahkan</button>
            @endif
        @endif
    </div>
    <input type="hidden" name="section" id="section" value="research_market">
    <div class="row">
        <p>
            PERINCIAN KAJIAN PASARAN ({{$detail->hasJVEForm ? $detail->hasRepairMethod->desc : null}})
            <div> <i class="fas fa-info-circle"></i>&nbsp;Sila isikan perincian kajian pasaran bagi kenderaan ini  </div>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <legend>Butiran Kajian Pasaran</legend>
                <div class="row">
                    @if($can_add_component)
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="btn-group">
                                    <span onclick="addMaintenanceVehicleResearchMarketFormComponent()" class="btn cux-btn small"> <i class="fa fa-plus"></i> Tambah</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12" id="maintenance_job_vehicle_research_market_component_list"></div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <fieldset>
                <legend>Senarai Pembekal <span class="text-danger">*</span> </legend>
                <div class="row">
                    @if($can_add_supplier)
                        <div class="col-md-12">
                            <div class="btn-group">
                                <span onclick="addMaintenanceVehicleFormSupplier()" class="btn cux-btn small"> <i class="fa fa-plus"></i> Tambah</span>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12" id="maintenance_job_vehicle_research_market_supplier_list"></div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <fieldset>
                        <legend>Disediakan Oleh</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama</label>
                                    <div>{{$detail->RSMPreparedBy ? $detail->RSMPreparedBy->name : (auth()->user()->isAssistEngineerMaintenance() ? auth()->user()->name : '-')}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Tarikh</label>
                                    <div>{{$detail->rsm_prepared_dt ? \Carbon\Carbon::parse($detail->rsm_prepared_dt)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y')}}</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-12">
                    <fieldset>
                        <legend>DiSemak Oleh</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama</label>
                                    <div>{{$detail->RSMVerifiedBy ? $detail->RSMVerifiedBy->name :  (auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance() ? auth()->user()->name : '-')}}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Tarikh</label>
                                    <div>{{$detail->rsm_verified_dt ? \Carbon\Carbon::parse($detail->rsm_verified_dt)->format('d F Y') : (auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance() ? \Carbon\Carbon::now()->format('d F Y') : '-')}}</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-12">
                    <fieldset>
                        <legend>Pilihan Waran <span class="text-danger">*</span></legend>
                        <div class="row">
                            <div class="col-md-8">
                                @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                                    <div class="btn-group col-12">
                                        <select class="custom-select col-8" name="waran_type_id" id="waran_type_id" required>
                                            <option value="">Sila Pilih</option>
                                            @foreach ($waran_type_list as $waran_type)
                                                <option data-code="{{$waran_type->code}}" {{$detail->hasWaranType && $detail->hasWaranType->id == $waran_type->id ? 'selected':''}} value="{{$waran_type->id}}">{{$waran_type->desc}}</option>
                                            @endforeach
                                        </select>
                                        <button
                                            id="btn_waran_type_container"
                                            data-mode="view"
                                            data-url=""
                                            data-download=""
                                            onclick="fancyView(this)"
                                            style="display: none;border-radius: 5px;left: 7px;height: 42px;"
                                            class="btn cux-btn col-4" type="button">Lihat Waran</button>
                                    </div>
                                    @else
                                        {{$detail->hasJVEForm && $detail->hasJVEForm->hasWaranType ?  $detail->hasJVEForm->hasWaranType->desc : ''}}
                                @endif
                            </div>
                            <div class="col-md-8" id="osol_type_container" style="display: none;">
                                @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                                    <div class="btn-group col-12">
                                        <select class="custom-select col-6" name="osol_type_id" id="osol_type_id">
                                            <option value="">Sila Pilih</option>
                                        </select>
                                        <button
                                        id="btn_osol_type_container"
                                        data-url=""
                                        data-download=""
                                        onclick="fancyView(this)"
                                        style="display: none;border-radius: 5px;left: 7px;height: 42px;"
                                        class="btn cux-btn col-6" type="button">Lihat Waran</button>
                                      </div>
                                    @else
                                        {{$detail->hasJVEForm && $detail->hasJVEForm->hasOsolType ?  $detail->hasJVEForm->hasOsolType->desc : ''}}
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>


            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="addFormSupplierModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addFormSupplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Pembekal
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddFormSupplier" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <span class="ms-2 mt-2" id="response"></span>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama Syarikat</label>
                                    <textarea maxlength="100" style="resize: none;" class="form-control" name="company_name" id="company_name" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="form_supplier_id" id="form_supplier_id">

            </div>
            <div class="modal-footer justify-content-between">

                <button type="submit" class="btn btn-module float-start">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>

            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="addFormResearchMarketComponentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addFormResearchMarketComponentModalLabel" aria-hidden="true">
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
            <form id="frmAddFormResearchMarketComponent" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <span class="ms-2 mt-2" id="response"></span>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">

                                <label for="" class="form-label">Perihal Kerja <em class="text-danger">*</em> </label>
                                    <textarea name="detail" id="detail" maxlength="1000" style="resize: none;overflow: auto;" rows="5" class="form-control" placeholder="KERJA-KERJA MEMBUKA, MEROMBAK RAWAT, MENGENALPASTI DAN MEMASANG ALAT GANTI BARU BAGI ENGINE SYSTEM SEHINGGA SEMPURNA"></textarea>
                                <div class="hasErr text-danger" id="rsm_detail"></div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <label for="" class="form-label">Jenis Penyenggaraan <em class="text-danger">*</em> </label>
                                    @foreach ($purpose_type_list as $purpose_type)
                                        <input class="form-check-input mt-2 ms-2" onchange="researchMarket_getComponentLvl1(this.value)"  type="radio" name="purpose_type_id" id="researchMarket_purpose_type_id_{{$purpose_type->id}}" value="{{$purpose_type->id}}">
                                        <label class="form-check-label cursor-pointer" for="researchMarket_purpose_type_id_{{$purpose_type->id}}">{{$purpose_type->desc}}</label>
                                    @endforeach
                                    <div class="hasErr text-danger" id="rsm_purpose_type_id"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Pilih Sistem <em class="text-danger">*</em> </label>
                                    <select class="form-control" name="lvl1_id" id="lvl1_id" onchange="researchMarket_getComponentLvl2(this.value)">
                                        <option value="">Sila Pilih</option>
                                    </select>
                                    <div class="hasErr text-danger" id="rsm_lvl1_id"></div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Harga Seunit (RM)</label>
                                    <input type="text" onkeypress="return isNumber(this)" class="form-control" name="per_price" id="per_price" value="">
                                </div>
                            </div> --}}
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

<div class="modal fade" id="delFormResearchMarketComponentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delFormResearchMarketComponentModalLabel" aria-hidden="true">
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
                <span class="btn btn-module" onclick="deleteResearchMarketComponent()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addFormResearchMarketComponentSubModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addFormResearchMarketComponentSubModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Komponen</div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddFormResearchMarketComponentSub" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <span class="ms-2 mt-2" id="response"></span>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Pilih Komponen LVl 2</label>
                            <select class="form-control" name="lvl2_id" id="researchMarket_component_lvl2_list" onchange="researchMarket_getComponentLvl3(this.value)">
                                <option value="">Sila Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" id="container_complvl3" style="display: none;">
                        <div class="form-group">
                            <label for="" class="form-label">Pilih Komponen LVl 3</label>
                            <select class="form-control" name="lvl3_id" id="researchMarket_component_lvl3_list">
                                <option value="">Sila Pilih</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">

                <button type="submit" class="btn btn-module float-start">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>

            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="delFormResearchMarketComponentSubModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delFormResearchMarketComponentSubModalLabel" aria-hidden="true">
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
                <span class="btn btn-module" onclick="deleteResearchMarketComponentSub()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delFormSupplierModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delFormSupplierModalLabel" aria-hidden="true">
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
                <span class="btn btn-module" onclick="deleteSupplier()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompResearchMarketVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompResearchMarketVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Semakan
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
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="research_market" stage="research_market_verification">Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompResearchMarketApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompResearchMarketApprovalModalLabel" aria-hidden="true">
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
                    Adakah anda ingin menghantar untuk pengesahan?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="research_market" stage="research_market_approval">Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompResearchMarketApproveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompResearchMarketApproveModalLabel" aria-hidden="true">
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
                    Adakah anda ingin mengesahkan maklumat ini?
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="research_market" stage="research_market_approve">Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script>
    let researchMarketComponentId = null;
    let researchMarketComponentIds = [];
    let researchMarketComponentSubIds = [];
    let researchMarketCompIdLvl1 = null;
    let researchMarketCompIdLvl2 = null;
    let researchMarketCompIdLvl3 = null;
    let rsm_osol_type_id = '{{$detail->osol_type_id}}';

    let form_id = null;
    let jve_form_repair_id = null;

    @if ($detail && $detail->hasJVEForm)
        form_id = {{$detail->hasJVEForm->id}};
        jve_form_repair_id = {{$detail->id}};
    @else
        form_id = {{$detail->id}};
    @endif

    let supplierId = null;
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    const fancyView = function(self){
        let url = $(self).data('url');
        let is_download = $(self).data('download');
        console.log('url' , url);

        if(is_download){
            window.location.replace(url);
        } else {
            const fancybox = new Fancybox([
            {
                src: url,
                type: "iframe",
            },
            ]);

            fancybox.on("done", (fancybox, slide) => {
            console.log(`done!`);
            });
        }
    }

    const getOsolType = function(warrantTypeId){
        $.get('{{route('maintenance.job.vehicle.getOsolType')}}', {
            warrantTypeId: warrantTypeId
        }, function(res){
            let osol_type = $('#osol_type_id');
            osol_type.html('<option value="">Sila Pilih</option>');
            res.forEach(element => {
                osol_type.append('<option data-code='+element.code+' value='+element.id+'>'+element.desc+'</option>')
            });

            osol_type.val(rsm_osol_type_id).trigger('change');

        })
    }

    const loadMaintenanceJobVehicleResearchMarketComponentList = function(){
        $.get('{{route('maintenance.job.vehicle.getVehicleForm.research.market.component.list')}}', {
            form_id: form_id,
            jve_form_repair_id: jve_form_repair_id,
            repair_method_id: '{{$repair_method_id}}',
            can_edit: '{{$can_edit_component}}',
            can_delete: '{{$can_delete_component}}',
        }, function(result){
            $('#maintenance_job_vehicle_research_market_component_list').html(result);
        })
    }

    const loadMaintenanceJobVehicleResearchMarketSupplierList = function(){

        $.get('{{route('maintenance.job.vehicle.getVehicleForm.research.market.supplier.list')}}', {
            form_id: form_id,
            jve_form_repair_id: jve_form_repair_id,
            repair_method_id: '{{$repair_method_id}}',
            can_edit: '{{$can_edit_supplier}}',
            can_delete: '{{$can_delete_supplier}}',
        }, function(result){
            $('#maintenance_job_vehicle_research_market_supplier_list').html(result);

            let btnApproval = $('#btnApproval');

            if($('.supplier-item').length < 1){
                btnApproval.prop('disabled', true);

            } else {
                btnApproval.prop('disabled', false);
            }
        })
    }

    const selfRecalculate = function(self, compId){
        let quantity = $('#quantity_component_id_'+compId).val();
        let perPrice = $('#per_unit_component_id_'+compId).val();
        let grandTotal = $('#grandTotal');
        let total = quantity*perPrice;
        $('#input_total_price_component_id_'+compId).val(total);
        $('#total_price_component_id_'+compId).text(numberWithCommas(total.toFixed(2)));

        submitVehicleResearchMarketFormComponentUpdatePrice(self);

        grandTotalPrice = 0;
        $('.input_total_price_component').map(function(i,o,u){
            if($(o).val()){
                grandTotalPrice+=parseFloat($(o).val());
            }
        });

        grandTotalPrice = grandTotalPrice + currentTotal;
        if(currentrmcCurrentpage == 1){
            grandTotalPrice = grandTotalPrice + nextTotal;
        }
        grandTotal.text(numberWithCommas(grandTotalPrice.toFixed(2)));

    }

    const ajaxLoadMaintenanceJobFormResearchMarketComponentPage = function(url){
        parent.startLoading();
        $.get(url, function(data){
            $('#maintenance_job_vehicle_research_market_component_list').html(data);
            parent.stopLoading();
        });
    }

    const ajaxLoadMaintenanceJobFormSupplierPage = function(url){
        parent.startLoading();
        $.get(url, function(data){
            $('#maintenance_job_vehicle_research_market_supplier_list').html(data);
            parent.stopLoading();
        });
    }

    const researchMarket_getComponentLvl1 = function(pr_type_id){

        $('#lvl1_id').html('<option value="">Sila Pilih</option>');

        $.get('{{route('maintenance.job.vehicle.getComponentLvl1')}}', {
            pr_type_id: pr_type_id,
            compLvl: 1
        }, function(responses){
            responses.forEach(res => {
                $('#lvl1_id').append('<option '+ (researchMarketCompIdLvl1 == res.id ? "selected" : "") +' value='+res.id+'>'+res.component+'</option>');
            });
        });
    }

    const researchMarket_getComponentLvl2 = function(compLvl1Id){

        $('#researchMarket_component_lvl2_list').html('<option value="">Sila Pilih</option>');

        $.get('{{route('maintenance.job.vehicle.getComponentLvl2')}}', {
            compId: compLvl1Id,
            compLvl: 2
        }, function(responses){
            let isSame = false;
            responses.forEach(res => {
                if(researchMarketCompIdLvl2 == res.id){
                    isSame = true;
                }
                $('#researchMarket_component_lvl2_list').append('<option value='+res.id+'>'+res.component+'</option>');
            });
            if(!isSame){
                researchMarketCompIdLvl2 = null;
            }
            $('#researchMarket_component_lvl2_list').val(researchMarketCompIdLvl2).trigger("change");
        });
    }

    const researchMarket_getComponentLvl3 = function(compLvl2Id){

        $('#researchMarket_component_lvl3_list').html('<option value="">Sila Pilih</option>');

        $.get('{{route('maintenance.job.vehicle.getComponentLvl3')}}', {
            compId: compLvl2Id,
            compLvl: 3
        }, function(responses){

            if(responses.count > 0){
                $('#container_complvl3').show();
            } else {
                $('#container_complvl3').hide();
            }

            let isSame = false;
            responses.forEach(res => {
                if(researchMarketCompIdLvl3 == res.id){
                    isSame = true;
                }
                $('#researchMarket_component_lvl3_list').append('<option value='+res.id+'>'+res.component+'</option>');
            });
            if(!isSame){
                researchMarketCompIdLvl3 = null;
            }
            $('#researchMarket_component_lvl3_list').val(researchMarketCompIdLvl3).trigger("change");
        });
    }

    const addMaintenanceVehicleResearchMarketFormComponent = function(){
        let frmAddFormResearchMarketComponent = $('#addFormResearchMarketComponentModal #frmAddFormResearchMarketComponent');
        frmAddFormResearchMarketComponent[0].reset();
        researchMarketComponentId = null;
        researchMarketCompIdLvl1 = null;
        researchMarketCompIdLvl2 = null;
        frmAddFormResearchMarketComponent.find('#lvl1_id').html('<option value="">Sila Pilih</option>');
        frmAddFormResearchMarketComponent.find('#detail').val('');
        frmAddFormResearchMarketComponent.find('#quantity').val('');
        frmAddFormResearchMarketComponent.find('#per_price').val('');
        $('#addFormResearchMarketComponentModal').modal('show');
    }

    const addMaintenanceVehicleResearchMarketFormComponentSub = function(compId, compLvl1Id){
        researchMarketComponentId = compId;
        researchMarket_getComponentLvl2(compLvl1Id);
        let frmAddFormResearchMarketComponentSub = $('#addFormResearchMarketComponentSubModal #frmAddFormResearchMarketComponentSub');
        frmAddFormResearchMarketComponentSub[0].reset();
        $('#addFormResearchMarketComponentSubModal').modal('show');
    }

    const submitVehicleResearchMarketFormComponent = function(data){
        $('.hasErr').html('');
        $.ajax({
            url: '{{ route('maintenance.job.vehicle.getVehicleForm.component.save') }}',
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                loadMaintenanceJobVehicleResearchMarketComponentList();
                loadMaintenanceJobVehicleProcurementComponentList();
                $('#lvl1_id').html('<option value="">Sila Pilih</option>');
                $('#addFormResearchMarketComponentModal').modal('hide');
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('.hasErr#rsm_'+key).html(value[0]);
                });
            }
        });
    }

    const submitVehicleResearchMarketFormComponentUpdatePrice = function(self){
        let id = $(self).data('id');
        let price = self.value;
        let _token = "{{ csrf_token() }}";
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.component.price.save') }}', {
            'id': id,
            'price': price,
            '_token': _token
        });
    }

    const submitVehicleResearchMarketFormComponentSub = function(data){
        $.ajax({
            url: '{{ route('maintenance.job.vehicle.getVehicleForm.research.market.component.sub.save') }}',
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                loadMaintenanceJobVehicleResearchMarketComponentList();
                $('#addFormResearchMarketComponentSubModal').modal('hide');
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;
            }
        });
    }

    const editResearchMarketComponent = function(self){
        let data = $(self).parent().data('component');
        researchMarketComponentId = data.id;
        researchMarketCompIdLvl1 = data.ref_component_lvl1_id;
        researchMarketCompIdLvl2 = data.ref_component_lvl2_id;
        let frmAddFormResearchMarketComponent = $('#addFormResearchMarketComponentModal #frmAddFormResearchMarketComponent');
        researchMarket_getComponentLvl1(data.maintenance_job_purpose_type_id);
        frmAddFormResearchMarketComponent.find('#detail').val(data.detail);
        frmAddFormResearchMarketComponent.find('#quantity').val(data.quantity);
        frmAddFormResearchMarketComponent.find('#per_price').val(data.per_price);
        frmAddFormResearchMarketComponent.find('#researchMarket_purpose_type_id_'+data.maintenance_job_purpose_type_id).prop('checked', true);
        $('#addFormResearchMarketComponentModal').modal('show');
    }

    const delResearchMarketComponent = function(id){
        researchMarketComponentIds = [id];
        $('#delFormResearchMarketComponentModal').modal('show');
    }

    const deleteResearchMarketComponent = function(){
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.component.delete') }}', {
            "_token": "{{ csrf_token() }}",
            'ids': researchMarketComponentIds
        }, function(res){
            researchMarketComponentIds = [];
            loadMaintenanceJobVehicleResearchMarketComponentList();
            loadMaintenanceJobVehicleProcurementComponentList();
            $('#delFormResearchMarketComponentModal').modal('hide');
        });
    }

    const delResearchMarketComponentSub = function(id){
        researchMarketComponentSubIds = [id];
        $('#delFormResearchMarketComponentSubModal').modal('show');
    }

    const deleteResearchMarketComponentSub = function(){
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.research.market.component.sub.delete') }}', {
            "_token": "{{ csrf_token() }}",
            'ids': researchMarketComponentSubIds
        }, function(res){
            researchMarketComponentIds = [];
            loadMaintenanceJobVehicleResearchMarketComponentList();
            $('#delFormResearchMarketComponentSubModal').modal('hide');
        });
    }

    const addMaintenanceVehicleFormSupplier = function(){
        let frmAddFormSupplier = $('#addFormSupplierModal #frmAddFormSupplier');
        frmAddFormSupplier[0].reset();
        $('#company_name').val('');
        $('#addFormSupplierModal').modal('show');
    }

    const submitVehicleFormSupplier = function(data){
        $.ajax({
            url: '{{ route('maintenance.job.vehicle.getVehicleForm.research.market.supplier.save') }}',
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                loadMaintenanceJobVehicleResearchMarketSupplierList();
                loadMaintenanceJobVehicleProcurementComponentList();
                $('#addFormSupplierModal').modal('hide');
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;
            }
        });
    }

    const editSupplier = function(self){
        let data = $(self).parent().data('supplier');
        supplierId = data.id;
        let frmAddFormSupplier = $('#addFormSupplierModal #frmAddFormSupplier');
        frmAddFormSupplier.find('#company_name').text(data.company_name);
        $('#addFormSupplierModal').modal('show');
    }

    const delSupplier = function(id){
        supplierIds = [id];
        $('#delFormSupplierModal').modal('show');
    }

    const deleteSupplier = function(){
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.research.market.supplier.delete') }}', {
            "_token": "{{ csrf_token() }}",
            'ids': supplierIds
        }, function(res){
            supplierIds = [];
            loadMaintenanceJobVehicleResearchMarketSupplierList();
            $('#delFormSupplierModal').modal('hide');
        });
    }

    $(document).ready(function(){

        loadMaintenanceJobVehicleResearchMarketComponentList();
        loadMaintenanceJobVehicleResearchMarketSupplierList();

        @if ($detail->hasWaranType)
            @if($detail->hasWaranType->code == '01')
                let osol_type_container = $('#osol_type_container');
                getOsolType({{$detail->hasWaranType->id}});
                osol_type_container.show();
            @endif
        @endif

        $('#frmAddFormResearchMarketComponent').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            console.log(formData);
            let form_id = '{{$form_id}}';
            if(researchMarketComponentId){
                formData.append('id', researchMarketComponentId);
            }
            formData.append('form_id', form_id);
            submitVehicleResearchMarketFormComponent(formData);
        });

        $('#frmAddFormResearchMarketComponentSub').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);

            if(researchMarketComponentId){
                formData.append('form_complvl1_id', researchMarketComponentId);
            }
            submitVehicleResearchMarketFormComponentSub(formData);
        });

        $('#frmAddFormSupplier').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            let form_id = '{{$form_id}}';
            if(supplierId){
                formData.append('id', supplierId);
            }
            formData.append('form_id', form_id);
            @if ($repair_method_id)
            formData.append('repair_method_id', '{{$repair_method_id}}');
            @endif
            submitVehicleFormSupplier(formData);
        });

        $('#purpose_type_id').on('change', function(e){
            let purpose_type_id = this.value;

        });

        $('#waran_type_id').on('change', function(e){
            let id = this.value;
            let waran_type_code = $('option:selected', this).data('code');
            let osol_type_container = $('#osol_type_container');
            let btn_waran_type_container = $('#btn_waran_type_container');
            let btn_osol_type_container = $('#btn_osol_type_container');
            let btn_approve = $('[data-bs-target="#prompResearchMarketApproveModal"]');
            if(waran_type_code == '01'){
                getOsolType(id);
                osol_type_container.show();
                btn_waran_type_container.hide();

            } else {
                let url = '{{route('maintenance.job.vehicle.getVehicleForm.research.market.WaranType')}}';
                btn_waran_type_container.data('url', url+'?waran_type_code='+waran_type_code+'&preview=1');
                btn_waran_type_container.show();

                osol_type_container.hide();
                btn_osol_type_container.hide();
                btn_approve.prop('disabled', true);
            }

            if(!id){
                btn_waran_type_container.hide();
                btn_approve.prop('disabled', true);
            } else {
                btn_approve.prop('disabled', false);
            }

        });

        $('#osol_type_id').on('change', function(e){
            let id = this.value;
            let osol_type_code = $('option:selected', this).data('code');
            let btn_osol_type_container = $('#btn_osol_type_container');
            let url = '{{route('maintenance.job.vehicle.getVehicleForm.research.market.OsolType')}}';
            let btn_approve = $('[data-bs-target="#prompResearchMarketApproveModal"]');
            if(id){
                btn_osol_type_container.data('url', url+'?osol_type_code='+osol_type_code+'&preview=1');
                btn_osol_type_container.show();
                btn_approve.prop('disabled', false);
            } else {
                btn_osol_type_container.hide();
                btn_approve.prop('disabled', true);
            }

        });

    });
</script>
