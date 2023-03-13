@php
    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;

    if($repair_method_id){
        $MJobVehicleStatus = $detail->hasJVEForm->hasMaintenanceJobVehicleStatus;
    }
@endphp

<form id="frm_vehicle_monitoring">
    @csrf
    <div class="fixed-submit">
        <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
        @if(auth()->user()->isForemenMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['11']) && $detail->hasExternalRepairStatus && $detail->hasExternalRepairStatus->code == '04')
                <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompMonitoringVerificationModal" id="foremenSubmit" disabled>Hantar Untuk Semakan</button>
            @elseif(in_array($MJobVehicleStatus->code, ['11']))
            <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompMonitoringVerificationModal" id="foremenSubmit" disabled>Hantar Untuk Semakan</button>
            @endif
        @elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['11']) && $detail->hasExternalRepairStatus && $detail->hasExternalRepairStatus->code == '05')
                <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompMonitoringApprovalModal">Selesai</button>
            @endif
        @endif
    </div>
    <input type="hidden" name="section" id="section" value="monitoring">
    <div class="row">
        <p>
            PENGUJIAN SELEPAS PEMBAIKAN (CKM.J.02)
            <div> <i class="fas fa-info-circle"></i>&nbsp;Sila isikan butiran pengujian bagi kenderaan ini</div>
        </p>
    </div>
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <legend>Senarai Perihal Pemantauan</legend>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <span onclick="addMonitoringVehicleFormMonitoringInfo()" class="btn cux-btn small"> <i class="fa fa-plus"></i> Tambah</span>
                        </div>
                    </div>
                    <div class="col-md-12" id="monitoring_job_vehicle_monitoring_info_list"></div>
                </div>
            </fieldset>
        </div>
    </div>
    @if ($detail->is_research_market == 1)
        <div class="row">
            <table id="fleet-ls" class="table table-bordered" style="width:98%; margin-left:10px; margin-top:20px;">
                <thead>
                    <tr style="height: 70px; color:black;">
                        <td style="width: 50px;color:black;">Bil</td>
                        <td style="color:black;"> Perihal Kerja</td>
                        <td style="width: 400px; color:black;"> Catatan</td>
                    </tr>
                {{-- </thead> --}}
                <tbody>
                    @foreach ($detail->hasProcurementSelectedSupplier as $component)
                        <tr>
                            <td class="align-top" style="width: 50px;color: #8a8a8a;">{{$loop->index+1}}</td>
                            <td>
                                <div class="text-uppercase" style="height: 100px; overflow: auto; color:black;">
                                    {{$component->hasFormComponent->detail}}<br>
                                    SISTEM DIPILIH : {{$component->hasFormComponent->hasRefComponentLvl1->component}}
                                    
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
                                <textarea class="form-control" name="note_{{$component->hasFormComponent->id}}"  onkeyup="this.value = this.value.toUpperCase()" id="note" cols="30" rows="10">{{$component->hasFormComponent->note}}</textarea>
                            </td>
                            </tr>
                    @endforeach
                </thead>
                </tbody>
            </table>        
        </div>  
    @endif 
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <legend>Lain-lain Kerosakan</legend>
                <div class="form-group col-6">
                    <label for="" class="form-label"> Maklumat Kerosakan </label>
                    <textarea class="form-control" style="resize: none;" onkeyup="this.value = this.value.toUpperCase()" name="other_damages" id="other_damages" rows="6">{{$detail->other_damages}}</textarea>
                </div>
            </fieldset>
        </div>
    </div>  
</form>
<div class="modal fade" id="addFormMonitoringInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addFormMonitoringInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Perihal Pemantauan
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddFormMonitoringInfo" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <span class="ms-2 mt-2" id="response"></span>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Tarikh</label>
                                    <div class="input-group date" id="monitoring_dt"
                                        data-target-input="nearest">
                                            <input name="monitoring_dt" id="monitoring_dtInput"
                                            type="text" class="form-control datepicker" placeholder=""
                                            autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true"
                                            data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                            value=""/>

                                            <div class="input-group-text" for="monitoring_dtInput">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Perihal Pemantauan</label>
                                    <select name="ref_info_id" id="ref_info_id" class="form-control form-select">
                                        <option value="">Sila Pilih</option>
                                        @foreach ($monitoring_info_list as $monitoring_info)
                                            <option value="{{$monitoring_info->id}}">{{$monitoring_info->desc}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Catatan</label>
                                    <textarea class="form-control" style="resize: none;" onkeyup="this.value = this.value.toUpperCase()" name="note" id="note" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Imej</label>
                                    <label for="monitoring_file" class="btn cux-btn bigger form-label" style="width: 50px;"><i class="fas fa-image"></i></label>
                                    <input class="form-control d-none" accept="image/*" name="monitoring_file" type="file" id="monitoring_file" />

                                    <div id="preview-file" class="form-group mb-2" style="display: none;height: 100px;overflow: auto;">
                                        <img class="cursor-pointer" id="preview-file-embed" data-url="" onclick="openEnlargeModal(this)" width="100%" type="">
                                    </div>
                                    <input type="hidden" name="has_new_file" id="hasNewMonitoringFile" value="0">

                                    <div class="hasErr"></div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <label><span class="text-danger">*</span>Sila pilih "Kenderaan sedang diuji oleh pihak wokshop" pada perihal pemantauan sebelum menghantar maklumat semakan. </label>
                        </div>
                    </div>
                </div>
                
                
            </div>
            <div class="modal-footer justify-content-between">

                <button type="submit" class="btn btn-module float-start">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Tutup </button>
                
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="delFormMonitorInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delFormMonitorInfoModalLabel" aria-hidden="true">
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
                <span class="btn btn-module" onclick="deleteMonitorInfo()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompMonitoringVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompMonitoringVerificationModalLabel" aria-hidden="true">
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
                <button class="btn btn-module" onclick="$(this).prop('disabled', true)" xaction="monitoring" stage="monitoring_verification" >Ya</button>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompMonitoringApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompMonitoringApprovalModalLabel" aria-hidden="true">
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
            <div class="modal-footer">
                <button class="btn btn-module" xaction="monitoring" onclick="$(this).text('Sila Tunggu..').prop('disabled', true);" stage="monitoring_done" >Ya</button>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="promptIncompleteFormModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="promptIncompleteFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-body" id="prompt-container">
                <div class="txt-memo">
                    Maklumat perihal pemantauan tidak lengkap. Sila pilih "Kenderaan sedang diuji oleh pihak wokshop" pada perihal pemantauan. 
                </div>
            </div>
            <div class="modal-footer">
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script>

    let monitoringInfoIds = [];
    let monitoringInfoId = null;

    function openEnlargeModal(self){
        console.log(self);
        $('#enlargeImageModal img').attr('src', $(self).data('url'));
        $('#enlargeImageModal').modal('show');
    }

    const addMonitoringVehicleFormMonitoringInfo = function(){
        let frmAddFormMonitoringInfo = $('#addFormMonitoringInfoModal #frmAddFormMonitoringInfo');
        frmAddFormMonitoringInfo[0].reset();
        monitoringInfoId = null;
        $('#hasNewMonitoringFile').val(0);
        frmAddFormMonitoringInfo.find('#ref_info_id').val(null).trigger('change');
        frmAddFormMonitoringInfo.find('#preview-file').hide();
        $('#addFormMonitoringInfoModal').modal('show');
    }

    const submitMonitoringVehicleFormMonitoringInfo = function(data, form) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('maintenance.job.vehicle.getVehicleForm.monitoring.info.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                form.find('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                form.find('[type="submit"]').prop('disabled', false);
                loadMonitioringVehicleFormMonitoringInfoList();
                $('#addFormMonitoringInfoModal').modal('hide');
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);;
                        }
                    } else {
                        console.log('key', key)
                        if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);;
                        }
                    }
                });
                form.find('[type="submit"]').prop('disabled', false);
            }
        });
    }

    const loadMonitioringVehicleFormMonitoringInfoList = function(){
        $.get('{{route('maintenance.job.vehicle.getVehicleForm.monitoring.info.list')}}', {
            form_id: '{{$form_id}}',
            repair_method_id: '{{$repair_method_id}}'
        }, function(result){
            $('#monitoring_job_vehicle_monitoring_info_list').html(result);
            let hasInspectionFromWorkshop = $('#monitoring_job_vehicle_monitoring_info_list [data-ref-info-code="04"]');

            if(hasInspectionFromWorkshop.length > 0){
                $('#frm_vehicle_monitoring [name^="note"]').prop('disabled', false);
                $('#foremenSubmit').prop('disabled', false);
            } else {
                $('#frm_vehicle_monitoring [name^="note"]').prop('disabled', true);
                $('#foremenSubmit').prop('disabled', true);
            }
        })
    }

    const ajaxLoadMaintenanceJobFormMonitorInfoPage = function(url){
        parent.startLoading();
        $.get(url, {
            form_id: '{{$form_id}}',
            repair_method_id: '{{$repair_method_id}}'
        }, function(data){
            $('#monitoring_job_vehicle_monitoring_info_list').html(data);
            parent.stopLoading();
        });
    }

    const editMonitorInfo = function(self){
        let data = $(self).parent().data('monitorinfo');
        monitoringInfoId = data.id;
        let frmAddFormMonitoringInfo = $('#addFormMonitoringInfoModal #frmAddFormMonitoringInfo');
        frmAddFormMonitoringInfo.find('#monitoring_dtInput').val(moment(data.monitoring_dt).format('DD/MM/YYYY'));
        frmAddFormMonitoringInfo.find('#note').val(data.note);
        frmAddFormMonitoringInfo.find('#ref_info_id').val(data.ref_info_id).trigger('change');

        let thumbUrl = '/'+data.doc_path_thumbnail+'/'+data.doc_name;
        let url = '/'+data.doc_path+'/'+data.doc_name;

        if(data.doc_path_thumbnail){
            frmAddFormMonitoringInfo.find('#preview-file-embed').attr('src', thumbUrl).data('url', url);
            frmAddFormMonitoringInfo.find('#preview-file').show();
        }

        $('#addFormMonitoringInfoModal').modal('show');
    }

    const delMonitorInfo = function(id){
        monitoringInfoIds = [id];
        $('#delFormMonitorInfoModal').modal('show');
    }

    const deleteMonitorInfo = function(){
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.monitoring.info.delete') }}', {
            "_token": "{{ csrf_token() }}",
            'ids': monitoringInfoIds
        }, function(res){
            monitoringInfoIds = [];
            loadMonitioringVehicleFormMonitoringInfoList();
            $('#delFormMonitorInfoModal').modal('hide');
        });
    }

    $(document).ready(function(){

        loadMonitioringVehicleFormMonitoringInfoList();

        let monitoring_dtInput = $('#monitoring_dtInput').datepicker();

        $('#monitoring_file').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-embed').attr('src', url).data('url', url);
            $('#preview-file').show();
            currentPreviewFile = url;
            $('#hasNewMonitoringFile').val(1);
            console.log('url  file -> ', url);
        });

        $('#frmAddFormMonitoringInfo').on('submit', function(e){
            e.preventDefault();
            let form = $(this);
            form.find('[type="submit"]').prop('disabled', true);
            let formData = new FormData(this);
            let form_id = {{$form_id}};
            if(monitoringInfoId){
                formData.append('id', monitoringInfoId);
            }
            formData.append('form_id', form_id);
            formData.append('repair_method_id', '{{$repair_method_id}}');
            submitMonitoringVehicleFormMonitoringInfo(formData, form);
        });

    });
</script>
