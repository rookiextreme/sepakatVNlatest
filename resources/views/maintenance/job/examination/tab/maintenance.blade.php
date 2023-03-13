@php
    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;

    if($repair_method_id){
        $MJobVehicleStatus = $detail->hasJVEForm->hasMaintenanceJobVehicleStatus;
    }
@endphp
{{-- @json($MJobVehicleStatus) --}}
<form id="frm_vehicle_maintenance">
    @csrf
    <div class="fixed-submit">

        @if(auth()->user()->isForemenMaintenance())
            @if($detail->hasJVEForm && $detail->hasJVEForm->hasInternalRepairStatus && in_array($detail->hasJVEForm->hasInternalRepairStatus->code, ['01', '07']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="maintenance" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#prompMaintenanceVerificationModal">Hantar Untuk Semakan</button>
            @elseif(in_array($MJobVehicleStatus->code, ['11']) && $detail->hasInternalRepairStatus && in_array($detail->hasInternalRepairStatus->code, ['01', '07']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="maintenance" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#prompMaintenanceVerificationModal">Hantar Untuk Semakan</button>
            @endif
        @elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['11']) && $detail->hasJVEForm && $detail->hasJVEForm->hasInternalRepairStatus && in_array($detail->hasJVEForm->hasInternalRepairStatus->code, ['02']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="maintenance" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#prompMaintenanceApprovalModal">Selesai</button>
            @elseif(in_array($MJobVehicleStatus->code, ['11']) && $detail->hasInternalRepairStatus && in_array($detail->hasInternalRepairStatus->code, ['02']))
                <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
                <button class="btn btn-module" data-save-as="maintenance" onclick="silentSave(this)" type="button" data-bs-toggle="modal" data-bs-target="#prompMaintenanceApprovalModal">Selesai</button>
            @endif
        @endif
    </div>
    <input type="hidden" name="section" id="section" value="maintenance">
    <div class="row">
        <p>
            PENGUJIAN SELEPAS PEMBAIKAN (CKM.J.02)
            <div> <i class="fas fa-info-circle"></i>&nbsp;Sila isikan butiran pengujian bagi kenderaan ini</div>
        </p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <fieldset>
                <legend>Pengujian</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Tarikh Pengujian</label>
                            <div>{{$detail->tested_dt ? \Carbon\Carbon::parse($detail->tested_dt)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y')}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Penguji</label>
                            <div>{{$detail->testedBy ? $detail->testedBy->name : auth()->user()->name}}</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Butiran Pengujian</label>
                            {{-- <textarea class="form-control" style="resize:none;" name="tested_detail" id="" cols="30" rows="5">{{$detail->tested_detail}}</textarea> --}}

                            @foreach ($inspect_type_list as $inspect_type)
                            <div class="form-check-inline">
                                <input data-code="{{$inspect_type->code}}" {{in_array($inspect_type->id, explode(',',$detail->inspect_type)) || (!$detail->inspect_type && $inspect_type->code == '03') ? 'checked': ''}} type="checkbox" class="form-check-input inspect_type" onchange="inspectType(this)" id="inspect_type_id_{{$inspect_type->id}}" value="{{$inspect_type->id}}">
                                <label class="cursor-pointer" for="inspect_type_id_{{$inspect_type->id}}">{{$inspect_type->desc}}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Catatan (had Aksara 100)</label>
                            <textarea class="form-control" style="resize: none;" maxlength="100" name="tester_note" id="tester_note" cols="30" rows="5">{{$detail->tester_note}}</textarea>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="col-md-8">
            <fieldset>
                <legend>Servis Seterusnya</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Tarikh</label>
                            <div class="input-group date" id="next_service_dt"
                                data-target-input="nearest">
                                    <input name="next_service_dt" id="next_service_dtInput"
                                    type="text" class="form-control datepicker" placeholder=""
                                    autocomplete="off"
                                    data-provide="datepicker" data-date-autoclose="true"
                                    data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                    value="{{$detail->next_service_dt ? \Carbon\Carbon::parse($detail->next_service_dt)->format('d/m/Y') : ''}}"/>

                                    <div class="input-group-text" for="next_service_dtInput">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Odometer (KM)</label>
                            <input type="text" name="next_service_odometer" class="form-control" value="{{$detail->next_service_odometer}}">
                        </div>
                    </div>
                </div>
            </fieldset>

            @if($detail->hasVehicle->hasManyPurposeType() && $detail->hasVehicle->hasManyPurposeType()->count() > 0)

            @if ($detail->is_research_market == 1)
                <div class="row">
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Borang Servis Kenderaan</legend>
                            <div class="row">
                                <table id="fleet-ls" class="table table-bordered" style="width:98%; margin-left:10px">
                                    <thead>
                                        <tr style="height: 70px;">
                                            <td style="width: 50px;">Bil</td>
                                            <td> Perihal Kerja</td>
                                            <td style="width: 300px;"> Catatan</td>
                                        </tr>
                                    {{-- </thead> --}}
                                    <tbody>
                                        @foreach ($detail->hasProcurementSelectedSupplier as $component)
                                            <tr>
                                                <td class="align-top" style="width: 50px;color: #8a8a8a;">{{$loop->index+1}}</td>
                                                <td>
                                                    <div style="height: 100px; overflow: auto;">
                                                        {{$component->hasFormComponent->detail}}
                                                            @if($component->hasFormComponent && $component->hasFormComponent->hasManyResearchMarketComponent->count()>0)
                                                                <ul class="sub-component mt-2">
                                                                    @foreach ($component->hasFormComponent->hasManyResearchMarketComponent as $componentSub)
                                                                        <li class="mb-1">
                                                                            <label for="" class="form-label d-inline" style="line-height: 22px;">
                                                                                @switch($componentSub->lvl)
                                                                                    @case(2)
                                                                                        {{$componentSub->hasCompLvl2->component}}
                                                                                        @break
                                                                                    @case(3)
                                                                                    {{$componentSub->hasCompLvl3->component}}
                                                                                        @break
                                                                                    @default

                                                                                @endswitch
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" name="note_{{$component->hasFormComponent->id}}" id="note" cols="30" rows="10">{{$component->hasFormComponent->note}}</textarea>
                                                </td>
                                                </tr>
                                        @endforeach
                                    </thead>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" style="width: 100%;">
                                <thead>
                                    <th style="width: 300px;" class="text-left">Perkara</th>
                                    <th class="text-center" style="width: 90px;">Ganti Semua
                                        <div class="form-switch">
                                            <input type="checkbox" class="form-check-input" id="check_all" name="check_all">
                                        </div>
                                    </th>
                                    <th></th>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive" style="height: 500px; overflow: auto;">
                            <table class="table table-bordered mt-0" style="width: 100%;">
                                <tbody>
                                    {{-- <tr class="no-record">
                                        <td colspan="3" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                                    </tr> --}}

                                    @php
                                        $indexLvl1 = 1;
                                        $indexLvl2 = 1;
                                    @endphp

                                    @foreach ($detail->hasManyMVFormCheckList as $checkList)
                                        @if($checkList->hasComplvl2)
                                            <tr>
                                                <td style="width: 300px;"><label for="" class="form-label ms-2">{{$indexLvl1-1}}.{{$indexLvl2++}}&nbsp;{{$checkList->hasComplvl2->component}}</label></td>
                                                <td class="text-center" style="width: 90px;">
                                                    <div class="form-switch">
                                                        <input type="checkbox" class="form-check-input checkMe" onchange="recheck()"  {{$checkList->is_pass == 1 ? 'checked':''}} name="is_pass_id_{{$checkList->id}}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <textarea class="form-control" style="resize: none;" name="note_id_{{$checkList->id}}" id="" cols="30" rows="5">{{$checkList->noted}}</textarea>
                                                </td>
                                            </tr>
                                            @else
                                            @php
                                                $indexLvl2 = 1;
                                            @endphp
                                            @if($checkList->hasComplvl1 && !$checkList->hasComplvl2)
                                                <tr>
                                                    <td style="width: 300px;">
                                                        <label for="" class="form-label">{{$indexLvl1++}}. {{$checkList->hasCompLvl1->component}}</label>
                                                    </td>
                                                    <td class="text-center" style="width: 90px;">
                                                        @if($checkList->hasCompLvl1->hasManyCheckListLvl2->count() == 0)
                                                            <div class="form-switch">
                                                                <input type="checkbox" class="form-check-input checkMe" onchange="recheck()" {{$checkList->is_pass == 1 ? 'checked':''}}  name="is_pass_id_{{$checkList->id}}">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($checkList->hasCompLvl1->hasManyCheckListLvl2->count() == 0)
                                                        <textarea class="form-control" style="resize: none;" name="note_id_{{$checkList->id}}" id="" cols="30" rows="5">{{$checkList->noted}}</textarea>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="3">
                                                        <label for="" class="form-label">{{$indexLvl1++}}. {{$checkList->hasCompLvl1->component}}</label>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @endif
        </div>
    </div>
</form>

<div class="modal fade" id="prompMaintenanceVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompMaintenanceVerificationModalLabel" aria-hidden="true">
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
            <div class="modal-footer float-start">
                <span class="btn btn-module" xaction="maintenance" stage="maintenance_verification" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompMaintenanceApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompMaintenanceApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-header" style="height:70px;">
                Selesai
                <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Adakah anda ingin meneruskan proses ini?
                </div>
            </div>
            <div class="modal-footer float-start">
                <button class="btn btn-module" xaction="maintenance" onclick="$(this).text('Sila Tunggu..').prop('disabled', true);" stage="maintenance_done" >Ya</button>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script>

    let insTypeCodeSelected = [];

    const recheck = function(){
        let checkMe = $('.checkMe').length;
        let checkMeChecked = $('.checkMe:checked').length;

        if(checkMe == checkMeChecked){
            $('#check_all').prop('checked', true);
        } else {
            $('#check_all').prop('checked', false);
        }
    }

    const inspectType = function(self){
        let insTypeId = self.value;
        let insTypeCode = $(self).data('code');
        let checkMeChecked = $('.inspect_type:checked').length;

        if(insTypeId && insTypeCode != '03' && checkMeChecked > 0){
            $('[data-code="03"]').prop('checked', false);
        } else if(insTypeId && insTypeCode == '03'){
            $('.inspect_type').not(self).prop('checked', false);
        } else if(checkMeChecked == 0){
            $('[data-code="03"]').prop('checked', true);
        }
    }

    $(document).ready(function(){

        recheck();

        let next_service_dtInput = $('#next_service_dtInput').datepicker();

        $('#check_all').on('click', function(e){
            console.log(this.checked);
            $('.checkMe').prop('checked', this.checked);
        })


    });
</script>
