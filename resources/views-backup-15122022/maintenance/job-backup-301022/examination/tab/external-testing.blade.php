@php
    $MJobVehicleStatus = $detail->hasMaintenanceJobVehicleStatus;
    $vehicle_id = $detail->hasVehicle->id;

    if($repair_method_id){
        $MJobVehicleStatus = $detail->hasJVEForm->hasMaintenanceJobVehicleStatus;
    }
@endphp
<style>
    #ref_info_id{
        width: 100% !important;
    }
</style>
<form id="frm_vehicle_external_testing">
    @csrf
    <div class="fixed-submit">
        <button class="btn btn-link" type="submit" xaction="draf"><i class="fa fa-save"></i> Simpan Sebagai Draf</button>
        @if(auth()->user()->isForemenMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['11']) && ($detail->hasExternalRepairStatus && $detail->hasExternalRepairStatus->code == '04'))
                <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompExternalTestingVerificationModal" id="foremenSubmitExternal">Hantar Untuk Semakan</button>
            @elseif(in_array($MJobVehicleStatus->code, ['11']))
            <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompExternalTestingVerificationModal" id="foremenSubmitExternal">Hantar Untuk Semakan</button>
            @endif
        @elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            @if(in_array($MJobVehicleStatus->code, ['11']) && ($detail->hasExternalRepairStatus && $detail->hasExternalRepairStatus->code == '05'))
                <button class="btn btn-module" type="button" data-bs-toggle="modal" data-bs-target="#prompExternalTestingMonitoringApprovalModal">Selesai</button>
            @endif
        @endif
    </div>
    <input type="hidden" name="section" id="section" value="external-testing">
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
                        <div class="btn-group" style="margin-bottom: 20px">
                            <span onclick="addExternalQuotationMonitoringVehicleFormMonitoringInfo()" class="btn cux-btn small"> <i class="fa fa-plus"></i> Tambah</span>
                        </div>
                    </div>
                    <div class="col-md-12" id="monitoring_job_vehicle_external_quotation_monitoring_info_list"></div>
                </div>
            </fieldset>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="externalTestingInfo" style="display: none">
            <fieldset>
                <legend>Butiran Pemeriksaan</legend>
                <div class="form-group col-6">
                    <label for="" class="form-label"> Maklumat Pemeriksaan Kenderaan </label>
                    <textarea class="form-control" style="resize: none;" onkeyup="this.value = this.value.toUpperCase()" name="testing_info" id="testing_info" rows="6">{{$detail->testing_info}}</textarea>
                </div>
            </fieldset>
        </div>
    </div>  
</form>
<div class="modal fade" id="addFormExternalQuotationMonitoringInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addFormExternalQuotationMonitoringInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Perihal Pemantauan
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddExternalQuotationFormMonitoringInfo" action="">
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
                            <div style="display: none">
                                <input type="hidden" name="repair_method_id" value="{{$repair_method_id}}">
                                <input type="hidden" name="vehicle_id" value="{{$vehicle_id}}">
                            </div>
                            <div class="col-md-6" style="position: relative">
                                <div class="form-group">
                                    <label for="" class="form-label">Perihal Pemantauan</label>
                                    <select name="ref_info_id" id="ref_info_id" class="form-control form-select">
                                        <option value="">Sila Pilih</option>
                                        @foreach ($monitoring_info_list as $monitoring)
                                            <option value="{{$monitoring->id}}">{{$monitoring->desc}}</option>
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
                                    <label for="monitoring_file_external" class="btn cux-btn bigger form-label" style="width: 50px;"><i class="fas fa-image"></i></label>
                                    <input class="form-control d-none" accept="image/*" name="monitoring_file" type="file" id="monitoring_file_external" />

                                    <div id="preview-file-external" class="form-group mb-2" style="display: none;height: 100px;overflow: auto;">
                                        <img class="cursor-pointer" id="preview-file-external-embed" data-url="" onclick="openEnlargeModal(this)" width="100%" type="">
                                    </div>
                                    <input type="hidden" name="has_new_file" id="hasNewExternalTestingMonitoringFile" value="0">

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

<div class="modal fade" id="delFormExternalQuotationMonitorInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delFormExternalQuotationMonitorInfoModalLabel" aria-hidden="true">
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
                <span class="btn btn-module" onclick="deleteExternalQuotationMonitorInfo()" >Ya</span>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompExternalTestingVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompExternalTestingVerificationModalLabel" aria-hidden="true">
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
                <button class="btn btn-module" onclick="$(this).prop('disabled', true)" xaction="external_testing" stage="testing_verification" >Ya</button>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompExternalTestingMonitoringApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompExternalTestingMonitoringApprovalModalLabel" aria-hidden="true">
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
                <button class="btn btn-module" xaction="external_testing" onclick="$(this).text('Sila Tunggu..').prop('disabled', true);" stage="testing_done" >Ya</button>
                <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
            </div>
        </div>
    </div>
</div>

<script>

    let externalQuotationMonitoringInfoIds = [];
    let externalQuotationMonitoringInfoId = null;

    function openEnlargeModal(self){
        console.log(self);
        $('#enlargeImageModal img').attr('src', $(self).data('url'));
        $('#enlargeImageModal').modal('show');
    }

    const addExternalQuotationMonitoringVehicleFormMonitoringInfo = function(){
        let frmAddExternalQuotationFormMonitoringInfo = $('#addFormExternalQuotationMonitoringInfoModal #frmAddExternalQuotationFormMonitoringInfo');
        frmAddExternalQuotationFormMonitoringInfo[0].reset();
        externalQuotationMonitoringInfoId = null;
        $('#hasNewExternalTestingMonitoringFile').val(0);
        frmAddExternalQuotationFormMonitoringInfo.find('#ref_info_id').val(null).trigger('change');
        frmAddExternalQuotationFormMonitoringInfo.find('#preview-file-external').hide();
        $('#addFormExternalQuotationMonitoringInfoModal').modal('show');
    }

    const submitExternalQuotationMonitoringVehicleFormMonitoringInfo = function(data, form) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('maintenance.job.vehicle.getVehicleForm.quotation.monitoring.info.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                form.find('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                form.find('[type="submit"]').prop('disabled', false);
                loadExternalTestingVehicleFormMonitoringInfoList();
                $('#addFormExternalQuotationMonitoringInfoModal').modal('hide');
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

    const loadExternalTestingVehicleFormMonitoringInfoList = function(){
        $.get('{{route('maintenance.job.vehicle.getVehicleForm.external.quotation.monitoring.info.list')}}', {
            form_id: '{{$form_id}}',
            repair_method_id: '{{$repair_method_id}}'
        }, function(result){
            $('#monitoring_job_vehicle_external_quotation_monitoring_info_list').html(result);
            let hasInspectionFromWorkshop = $('#monitoring_job_vehicle_external_quotation_monitoring_info_list [data-ref-info-code="04"]');
            if(hasInspectionFromWorkshop.length > 0){
                $('#foremenSubmitExternal').prop('disabled', false);
                $('#externalTestingInfo').show();
            } else {
                $('#foremenSubmitExternal').prop('disabled', true);
                $('#externalTestingInfo').hide();
            }
        })
    }

    const ajaxLoadMaintenanceJobFormExternalQuotationMonitorInfoPage = function(url){
        parent.startLoading();
        $.get(url, {
            form_id: '{{$form_id}}',
            repair_method_id: '{{$repair_method_id}}'
        }, function(data){
            $('#monitoring_job_vehicle_external_quotation_monitoring_info_list').html(data);
            parent.stopLoading();
        });
    }

    const editExternalQuotationMonitorInfo = function(self){
        let data = $(self).parent().data('monitorinfo');
        externalQuotationMonitoringInfoId = data.id;
        let frmAddExternalQuotationFormMonitoringInfo = $('#addFormExternalQuotationMonitoringInfoModal #frmAddExternalQuotationFormMonitoringInfo');
        frmAddExternalQuotationFormMonitoringInfo.find('#monitoring_dtInput').val(moment(data.monitoring_dt).format('DD/MM/YYYY'));
        frmAddExternalQuotationFormMonitoringInfo.find('#note').val(data.note);
        frmAddExternalQuotationFormMonitoringInfo.find('#ref_info_id').val(data.ref_info_id).trigger('change');

        let thumbUrl = '/'+data.doc_path_thumbnail+'/'+data.doc_name;
        let url = '/'+data.doc_path+'/'+data.doc_name;

        if(data.doc_path_thumbnail){
            frmAddExternalQuotationFormMonitoringInfo.find('#preview-file-external-embed').attr('src', thumbUrl).data('url', url);
            frmAddExternalQuotationFormMonitoringInfo.find('#preview-file-external').show();
        }

        $('#addFormExternalQuotationMonitoringInfoModal').modal('show');
    }

    const delExternalQuotationMonitorInfo = function(id){
        externalQuotationMonitoringInfoIds = [id];
        $('#delFormExternalQuotationMonitorInfoModal').modal('show');
    }

    const deleteExternalQuotationMonitorInfo = function(){
        $.post('{{ route('maintenance.job.vehicle.getVehicleForm.monitoring.info.delete') }}', {
            "_token": "{{ csrf_token() }}",
            'ids': externalQuotationMonitoringInfoIds
        }, function(res){
            externalQuotationMonitoringInfoIds = [];
            loadExternalTestingVehicleFormMonitoringInfoList();
            $('#delFormExternalQuotationMonitorInfoModal').modal('hide');
        });
    }

    $(document).ready(function(){
        $('#ref_info_id').select2({
            theme: "classic",
            placeholder: "Sila pilih",
            dropdownParent: $("#addFormExternalQuotationMonitoringInfoModal")
        });

        loadExternalTestingVehicleFormMonitoringInfoList();

        let monitoring_dtInput = $('#monitoring_dtInput').datepicker();

        $('#monitoring_file_external').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-external-embed').attr('src', url).data('url', url);
            $('#preview-file-external').show();
            currentPreviewFile = url;
            $('#hasNewExternalTestingMonitoringFile').val(1);
            console.log('url  file -> ', url);
        })

        $('#frmAddExternalQuotationFormMonitoringInfo').on('submit', function(e){
            e.preventDefault();
            let form = $(this);
            form.find('[type="submit"]').prop('disabled', true);
            let formData = new FormData(this);
            let form_id = {{$form_id}};
            if(externalQuotationMonitoringInfoId){
                formData.append('id', externalQuotationMonitoringInfoId);
            }
            formData.append('form_id', form_id);
            formData.append('repair_method_id', '{{$repair_method_id}}');
            submitExternalQuotationMonitoringVehicleFormMonitoringInfo(formData, form);
        });

    });
</script>
