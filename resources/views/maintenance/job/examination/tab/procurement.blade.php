@php
    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;

    $can_edit_procurement = false;
    $can_delete_procurement = false;

    if(
        auth()->user()->isAssistEngineer() || 
        auth()->user()->isAssistEngineerMaintenance() ||
        auth()->user()->isEngineer() ||
        auth()->user()->isEngineerMaintenance() || 
        auth()->user()->isSeniorEngineer() || 
        auth()->user()->isSeniorEngineerMaintenance()
    ){

        if(in_array($MJobVehicleStatus->code, ['08', '09', '10'])){
            $can_edit_procurement = true;
            $can_delete_procurement = true;
        }
    }

@endphp

<style>
    #maintenance_job_vehicle_procurement_component_list table {
        border-collapse: collapse;
        border-spacing: 0;
    }
    #maintenance_job_vehicle_procurement_component_list thead, 
    #maintenance_job_vehicle_procurement_component_list tbody, 
    #maintenance_job_vehicle_procurement_component_list tfoot {
        display: table-cell;
    }
    #maintenance_job_vehicle_procurement_component_list thead, 
    #maintenance_job_vehicle_procurement_component_list tfoot {
        padding-bottom: 16px;
    }
    #maintenance_job_vehicle_procurement_component_list tbody {
        display: block;
        table-layout: fixed;
        width: 30vw;
        overflow-x: auto;
        border-left: 1px solid black;
        border-right: 2px solid black;
    }
    #maintenance_job_vehicle_procurement_component_list tr, 
    #maintenance_job_vehicle_procurement_component_list td {
        border: 1px solid grey;
        width: 100%;
    }
    #maintenance_job_vehicle_procurement_component_list td {
        padding: 1rem;
        /* white-space: nowrap; */
    }
</style>

<form id="frm_vehicle_procurement">
    @csrf
    <div class="fixed-submit">
        
        @if(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['08']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="procurement" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#prompVerificationModal">Hantar Untuk Semakan</button>
            @endif
        @endif

        @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['09']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="procurement" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#procurementPrompApprovalModal">Hantar Untuk Pengesahan</button>
            @endif
        @endif

        @if(auth()->user()->isSeniorEngineer() || auth()->user()->isSeniorEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['10']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="procurement" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#procurementPrompApproveModal">Sahkan</button>
            @endif
        @endif
    </div>
    <input type="hidden" name="section" id="section" value="procurement">
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <legend>Jadual Harga Senarai Pembekal</legend>
                <div>Sila isikan jadual harga di bawah untuk semua syarikat pembekal</div>
            </fieldset>
        </div>
        <div class="col-md-12" id="maintenance_job_vehicle_procurement_component_list"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <legend>Disediakan Oleh</legend>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama</label>
                                    <div class="text-uppercase">{{$detail->PROPreparedBy ? $detail->PROPreparedBy->name : (auth()->user()->isAssistEngineerMaintenance() ? auth()->user()->name : '-')}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Tarikh</label>
                                    <div class="text-uppercase">{{$detail->pro_prepared_dt ? \Carbon\Carbon::parse($detail->pro_prepared_dt)->format('d F Y') : (auth()->user()->isAssistEngineerMaintenance() ? \Carbon\Carbon::now()->format('d F Y') : '-')}}</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend>Disemak Oleh</legend>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="" class="form-label">Nama</label>
                                    <div class="text-uppercase">{{$detail->PROVerifiedBy ? $detail->PROVerifiedBy->name : (auth()->user()->isEngineerMaintenance() ? auth()->user()->name : '-')}}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Tarikh</label>
                                    <div class="text-uppercase">{{$detail->pro_verified_dt ? \Carbon\Carbon::parse($detail->pro_verified_dt)->format('d F Y') : (auth()->user()->isEngineerMaintenance() ? \Carbon\Carbon::now()->format('d F Y') : '-')}}</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-12">
                    <fieldset>
                        <legend>Pilihan Waran</legend>
                        @if($detail->hasJVEForm && $detail->hasJVEForm->hasWaranType)
                            <div class="col-md-8" id="osol_type_container">
                                {{$detail->hasJVEForm->hasWaranType ?  $detail->hasJVEForm->hasWaranType->desc : ''}}

                                    @if($detail->hasJVEForm->hasWaranType->code == '01')
                                        @if($detail->hasJVEForm->hasOsolType)
                                            {{$detail->hasJVEForm->hasOsolType ?  '- '.$detail->hasJVEForm->hasOsolType->desc : ''}}
                                            <button 
                                                id="btn_osol_type_container" 
                                                data-url="{{route('maintenance.job.vehicle.getVehicleForm.research.market.OsolType', ['osol_type_code' => $detail->hasJVEForm->hasOsolType->code])}}" 
                                                data-download="" 
                                                onclick="fancyView(this)" 
                                                style="border-radius: 5px;left: 7px;height: 42px;" 
                                                class="btn cux-btn col-4" type="button">Lihat Waran</button>
                                        @endif
                                        @else
                                        @if($detail->hasJVEForm->hasWaranType)
                                            <button 
                                                id="btn_osol_type_container" 
                                                data-url="{{route('maintenance.job.vehicle.getVehicleForm.research.market.WaranType', ['waran_type_code' => $detail->hasJVEForm->hasWaranType->code])}}" 
                                                data-download="" 
                                                onclick="fancyView(this)" 
                                                style="border-radius: 5px;left: 7px;height: 42px;" 
                                                class="btn cux-btn col-4" type="button">Lihat Waran</button>
                                        @endif
                                    @endif
                            </div>
                        @endif
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="prompVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompVerificationModalLabel" aria-hidden="true">
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
            <div class="modal-footer float-start">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="procurement" stage="procurement_verification" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="procurementPrompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompVerificationModalLabel" aria-hidden="true">
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
            <div class="modal-footer float-start">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="procurement" stage="procurement_approval" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="procurementPrompApproveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="procurementPrompApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Sahkan
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin mengesahkan maklumat perolehan ini?
                </div>
            </div>
            <div class="modal-footer float-start">
                <span class="btn btn-module" data-bs-dismiss="modal" xaction="procurement" stage="procurement_approve" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script>

    const loadMaintenanceJobVehicleProcurementComponentList = function(){
        $.get('{{route('maintenance.job.vehicle.getVehicleForm.procurement.component.list')}}', {
            form_id: '{{$form_id}}',
            repair_method_id: '{{$repair_method_id}}',
            can_edit: '{{$can_edit_procurement}}',
            can_delete: '{{$can_delete_procurement}}',
        }, function(result){
            $('#maintenance_job_vehicle_procurement_component_list').html(result);
        })
    }

    const ajaxLoadMaintenanceJobVehicleProcurementComponentPage = function(url){
        parent.startLoading();
        $.get(url, {
            form_id: {{$detail->id}},
            repair_method_id: '{{$repair_method_id}}'
        }, function(data){
            $('#maintenance_job_vehicle_procurement_component_list').html(data);
            parent.stopLoading();
        });
    }

    $(document).ready(function(){
        loadMaintenanceJobVehicleProcurementComponentList();
    });
</script>