@php

    $allowBtnSave = ['01','02','04'];
    $allowBtnSubmit = ['01','04'];
    $allowBtnVerify = ['02'];
    $allowBtnApproval = ['03'];
@endphp
<form class="row" id="frm_journey">

    @csrf

    <div class="messages"></div>

    <input type="hidden" name="section" value="journey">
    <input type="hidden" name="hasNewDocWorkInsLetter" id="hasNewDocWorkInsLetter" value={{$pathUrl=='' ? 1:0 }}>
<fieldset>
    <legend>Maklumat Perjalanan</legend>
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
            <label for="" class="form-label text-dark">Destinasi <span class="text-danger">*</span></label>
            <input type="text" onkeyup="this.value = this.value.toUpperCase();" name="destination" class="form-control" autocomplete="off"
            value="{{$detail ? $detail->destination : ''}}" maxlength="100" onchange="forceCaps(this);">
            <label for="" class="form-label mt-2">Surat Arahan Kerja <span class="text-danger">*</span></label>
            <input type="file" class="d-none" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf" name="work_ins_letter" id="work_ins_letter" value="{{$pathUrl}}">
            @if($detail && $detail->hasWorkInsLetter)
                <div class="mb-1 mt-1">
                    <a class="btn cux-btn bigger" onclick="downloadFile('{{$pathUrl}}', 'Surat Arahan Kerja {{\Carbon\Carbon::now()->format('d-m-Y')}}')">Muat Turun</a>
                    <label class="btn cux-btn small" for="work_ins_letter">Ganti</label>
                </div>
            @else
            <label for="work_ins_letter" type="button" class="btn cux-btn bigger">
                <i class="fa fa-upload"></i> Muat Naik Dokumen</label>
            @endif
            <div id="preview-file" class="form-group" style="display: {{$detail && $detail->hasWorkInsLetter ? 'block': 'none'}};">
                <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" height="200px" type="">
            </div>

        </div>
        <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
            <label for="" class="form-label">Tujuan tempahan <span class="text-danger">*</span></label>
            <textarea onkeyup="this.value = this.value.toUpperCase();" style="resize: none;" class="form-control" name="reason" id="reason" cols="30" rows="4" maxlength="200" style="height:120px" onchange="forceCaps(this);">{{$detail ? $detail->reason : ''}}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
            <label for="" class="form-label text-dark">Tempat Menunggu (Pergi) <span class="text-danger">*</span></label>
            <textarea onkeyup="this.value = this.value.toUpperCase();" style="resize: none;" class="form-control" name="start_destination" id="start_destination" cols="30" rows="2" onchange="forceCaps(this);" maxlength="100">{{$detail ? $detail->start_destination : ''}}</textarea>
        </div>
        <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
            <label for="" class="form-label text-dark">Tempat Menunggu (Balik) <span class="text-danger">*</span></label>
            <textarea onkeyup="this.value = this.value.toUpperCase();" style="resize: none;" class="form-control" name="end_destination" id="end_destination" cols="30" rows="2" onchange="forceCaps(this);" maxlength="100">{{$detail ? $detail->end_destination : ''}}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
            <label for="" class="form-label text-dark">Masa & tarikh Perjalanan (Pergi) <span class="text-danger">*</span></label>
            <div class="input-group date form_datetime" id="start_datetime_container" data-date="{{$detail && $detail->start_datetime ? $detail->start_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="start_datetime">
                <input class="form-control" size="16" type="text" id="start_datetime_input" value="" readonly>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                <label class="input-group-addon input-group-text" for="start_datetime_input">
                    <i class="fal fa-calendar-alt"></i>
                </label>
            </div>
            <input type="hidden" name="start_datetime" id="start_datetime" value="{{$detail && $detail->start_datetime ? $detail->start_datetime : ''}}" />
        </div>
        <div class="col-xl-3 col-lg-3 col-sm-4 col-md-4 col-12">
            <label for="" class="form-label text-dark">Masa & Tarikh Perjalanan (Balik) <span class="text-danger">*</span></label>
            <div class="input-group date form_datetime" id="end_datetime_container" data-date="{{$detail && $detail->end_datetime ? $detail->end_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="end_datetime">
                <input class="form-control" size="16" id="end_datetime_input" disabled type="text" value="" readonly>
                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                <label class="input-group-addon input-group-text" for="end_datetime_input">
                    <i class="fal fa-calendar-alt"></i>
                </label>
            </div>
            <input type="hidden" name="end_datetime" id="end_datetime" value="{{$detail && $detail->end_datetime ? $detail->end_datetime : ''}}" />
        </div>

        @if (auth()->user()->isAdmin() || $TaskFlowAccessLogistic->mod_fleet_approval)
            @if($detail && (auth()->user()->isAdmin()  || in_array($detail->hasBookingStatus->code, $allowBtnApproval)))
            <div class="col-md-12">

                <div class="form-group">
                    <label for="" class="form-label">Mod <span class="text-danger">*</span></label>
                    @foreach ($stay_status_list as $stay_status)
                        <div class="form-check form-check-inline mr-2">
                            <input {{$detail->hasStayStatus && $detail->hasStayStatus->id == $stay_status->id ? 'checked': ''}} class="form-check-input" id="stay_status_{{$stay_status->code}}" name="stay_status_id" type="radio" value="{{$stay_status->id}}">
                            <label for="stay_status_{{$stay_status->code}}" class="cursor-pointer form-check-label">{{$stay_status->desc}} <span class="text-danger">*</span></label>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="" class="form-label">Mod</label>
                        <div>{{$detail && $detail->hasStayStatus ? $detail->hasStayStatus->desc : '-'}}</div>
                    </div>
                </div>
            @endif
            @else
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="" class="form-label">Mod</label>
                        <div>{{$detail && $detail->hasStayStatus ? $detail->hasStayStatus->desc : '-'}}</div>
                    </div>
                </div>
            @endif
    </div>
    <hr/>
    <div class="form-group center">

        @if ($detail && $detail->destination)
            @if(in_array($detail->hasBookingStatus->code, $allowBtnSubmit))
                <button type="button" disabled class="btn btn-module btn-verify" id="btn-verify-journey" data-bs-toggle="modal" data-bs-target="#verifyBookingModal"><i class="fal fa-paper-plane icon-white"></i>&nbsp;Hantar</button>
            @endif
            @if (auth()->user()->isAdmin() || $TaskFlowAccessLogistic->mod_fleet_approval)
                @if(in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                    <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#rejectBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Tolak"><i class="fa fa-ban"></i>&nbsp;Tolak</button>
                    @if(count($detail->hasManyAssignedVehicle))
                        <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#approvalBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                    @endif
                @endif
            @endif
        @endif
        @if(auth()->user()->isAdmin() || !$detail || (in_array($detail->hasBookingStatus->code, $allowBtnSave)))
            <button class="btn btn-link" type="submit"><i class="fal fa-save"></i> Simpan</button>
        @endif
    </div>
</fieldset>


</form>

<script>
    function submitJourney(data) {
        parent.startLoading();

        let department = $('#department_id');

        $.ajax({
            url: "{{ route('logistic.booking.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);

                let department = $('#department_id');
                if(!department.val()){
                    if(department.parent().find('.hasErr').length == 0){
                        department.parent().append('<div class="hasErr text-danger col-12 fs-6">Sila Pilih Cawangan/Jabatan</div>');
                    }
                    $('#tab1').click();
                    return false;
                } else {
                    window.location = response['url'];
                }
                
            },
            error: function(response) {

                if(!department.val()){
                    if(department.parent().find('.hasErr').length == 0){
                        department.parent().append('<div class="hasErr text-danger col-12 fs-6">Sila Pilih Cawangan/Jabatan</div>');
                    }
                    $('#tab1').click();
                    return false;
                } else {

                    var errors = response.responseJSON.errors;

                    // var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                    // $.each(errors, function(key, value) {
                    //     errorsHtml += '<li>' + value[0] + '</li>';
                    // });
                    // errorsHtml += '</ul></div';

                    // $('.messages').html(errorsHtml);

                    $.each(errors, function(key, value) {
                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                                if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                    $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                                }
                            }
                    });
                
                    parent.stopLoading();

                }
            }
        });
    }

    $(document).ready(function(){

        $('#frm_journey').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            let detail = new FormData($('#frm_detail')[0]);

            detail.append('_token', '{{ csrf_token() }}');

            submitBookingDetail(detail);
            submitJourney(formData);

        });

    })
</script>
