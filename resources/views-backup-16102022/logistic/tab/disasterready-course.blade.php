@php

    $allowBtnSave = ['01', '02','04'];
    $allowBtnSubmit = ['01','04'];
    $allowBtnVerify = ['02'];
    $allowBtnApproval = ['03'];
@endphp
<div class="messages"></div>

<form id="frm_journey" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="journey">
    <div class="row">
        <fieldset>
            <legend>MAKLUMAT MISI</legend>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <label for="" class="form-label text-dark">Pusat Bencana <span class="text-danger">*</span></label>
                    <input type="text" name="disaster_center" class="form-control" autocomplete="off"
                    value="{{$detail ? $detail->disaster_center : ''}}" >
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <label for="" class="form-label text-dark">Destinasi <span class="text-danger">*</span></label>
                    <input type="text" name="destination" class="form-control" autocomplete="off"
                    value="{{$detail ? $detail->destination : ''}}" >
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                    <label for="" class="form-label text-dark">Tempat Berkumpul <span class="text-danger">*</span></label>
                    <textarea style="resize: none;" class="form-control" name="assembly_location" id="assembly_location" cols="30" rows="2">{{$detail ? $detail->assembly_location : ''}}</textarea>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-12">
                    <label for="" class="form-label text-dark">Masa & tarikh Berkumpul <span class="text-danger">*</span></label>
                    <div class="input-group date form_datetime" id="gather_datetime_container" data-date="{{$detail && $detail->assembly_datetime ? $detail->assembly_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="assembly_datetime">
                        <input id="assembly_datetime_input" class="form-control" size="16" type="text" value="{{$detail->assembly_datetime ? Carbon\Carbon::parse($detail->assembly_datetime)->format('d M Y - g:i A') : ''}}" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        <label class="input-group-addon input-group-text" for="assembly_datetime_input">
                            <i class="fal fa-calendar-alt"></i>
                        </label>
                    </div>
                    <input type="hidden" name="assembly_datetime" id="assembly_datetime" value="{{$detail && $detail->assembly_datetime ? $detail->assembly_datetime : ''}}" />
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-4 col-12">
                    <label for="" class="form-label text-dark">Masa & tarikh Mula Misi <span class="text-danger">*</span></label>
                    <div class="input-group date form_datetime" id="start_datetime_container" data-date="{{$detail && $detail->start_datetime ? $detail->start_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="start_datetime">
                        <input id="start_datetime_input" class="form-control" size="16" type="text" value="{{$detail->start_datetime ? Carbon\Carbon::parse($detail->start_datetime)->format('d M Y - g:i A') : ''}}" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        <label class="input-group-addon input-group-text" for="start_datetime_input">
                            <i class="fal fa-calendar-alt"></i>
                        </label>
                    </div>
                    <input type="hidden" name="start_datetime" id="start_datetime" value="{{$detail && Carbon\Carbon::parse($detail->start_datetime)->format('d M Y - g:i A') ? Carbon\Carbon::parse($detail->start_datetime )->format('d M Y - g:i A') : ''}}" />
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-12">
                    <label for="" class="form-label text-dark">Masa & tarikh Tamat Misi <span class="text-danger">*</span></label>
                    <div class="input-group date form_datetime" id="end_datetime_container" data-date="{{$detail && $detail->end_datetime ? $detail->end_datetime : ''}}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="end_datetime">
                        <input id="end_datetime_input" class="form-control" size="16" disabled type="text" value="{{$detail->end_datetime ? Carbon\Carbon::parse($detail->end_datetime)->format('d M Y - g:i A') : ''}}" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        <label class="input-group-addon input-group-text" for="end_datetime_input">
                            <i class="fal fa-calendar-alt"></i>
                        </label>
                    </div>
                    <input type="hidden" name="end_datetime" id="end_datetime" value="{{$detail && $detail->end_datetime ? $detail->end_datetime : ''}}" />
                </div>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-6 col-12" style="padding-top:0px">
                    <label for="" class="form-label text-dark">Persetujuan Tanggungan <span class="text-danger">*</span><br/>
                        <small>Pemohon bersetuju untuk menanggung perkara-perkara berikut</small>
                    </label>

                    <div class="form-check-inline">
                        <input class="form-check-input inline trip_expense_type mt-2" type="checkbox" {{in_array(1, explode(',',$detail->trip_expense_type)) ? 'checked': ''}} id="tng" value="1">
                        <label class="form-check-label cursor-pointer pt-0 m-0" for="tng">
                            Touch N Go
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <input class="form-check-input inline trip_expense_type mt-2" type="checkbox" id="oil" value="2"  {{in_array(2, explode(',',$detail->trip_expense_type)) ? 'checked': ''}}>
                        <label class="form-check-label inline cursor-pointer pt-0 m-0" for="oil">
                            Minyak
                        </label>
                    </div>

                    <div class="form-check-inline">
                        <input class="form-check-input inline trip_expense_type mt-2" type="checkbox" id="allowance" value="3"  {{in_array(3, explode(',',$detail->trip_expense_type)) ? 'checked': ''}}>
                        <label class="form-check-label inline cursor-pointer pt-0 m-0" for="allowance">
                            Tuntutan Elaun
                        </label>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                    <label for="" class="form-label text-dark">Surat Arahan Kerja 
                        {{-- <span class="text-danger">*</span> --}}
                    </label>
                        <input type="file" class="d-none" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf" name="work_ins_letter" id="work_ins_letter" value="{{$pathUrl}}">
                        {{-- <input type="hidden" name="has_work_ins_letter" value="{{$detail && $detail->hasWorkInsLetter ? 1 : 0}}"> --}}
                        @if($detail && $detail->hasWorkInsLetter)
                            <div class="mb-1 mt-1">
                                <a class="btn cux-btn bigger" onclick="downloadFile('{{$pathUrl}}', 'Surat Arahan Kerja {{\Carbon\Carbon::now()->format('d-m-Y')}}')">Muat Turun</a>
                                <label class="btn cux-btn small" for="work_ins_letter">Ganti</label>
                            </div>
                        @else
                        <div class="mb-1 mt-1">
                            <label for="work_ins_letter" class="btn cux-btn bigger">
                                <i class="fa fa-upload"></i> Muat Naik Dokumen</label>
                        </div>
                        @endif
                        <div id="preview-file" class="form-group" style="display: {{$detail && $detail->hasWorkInsLetter ? 'block': 'none'}};">
                            <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" height="200px" type="">
                        </div>
                </div>
            </div>
        </fieldset>
    </div>
    <hr/>
    <div class="col-md-12 mt-2 mb-2">
        <div class="form-group center">
            @if ($detail && $detail->destination)
                @if(in_array($detail->hasBookingStatus->code, $allowBtnSubmit))
                    <button type="button" disabled class="btn btn-module btn-verify" data-bs-toggle="modal" data-bs-target="#verifyBookingModal"><i class="fal fa-paper-plane icon-white"></i>&nbsp; Hantar</button>
                @endif
                @if (auth()->user()->isAdmin() || $TaskFlowAccessLogistic->mod_fleet_approval)
                    @if(in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                        <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#rejectBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Tolak"><i class="fa fa-ban"></i>&nbsp;Tolak</button>
                        <button disabled class="btn cux-btn bigger btn-approval" data-bs-toggle="modal" data-bs-target="#approvalBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                    @endif
                @endif
            @endif
            @if(auth()->user()->isAdmin() ||
                in_array($detail->hasBookingStatus->code, $allowBtnSave) ||
                ($TaskFlowAccessLogistic->mod_fleet_approval && in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                )
                <button class="btn btn-module" type="submit">Simpan</button>
            @endif
        </div>
    </div>

</form>

<script>
    function submitJourney(data) {
        parent.startLoading();
        $.ajax({
            url: "{{ route('logistic.disasterready.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                window.location = response['url'];
            },
            error: function(response) {
                console.log(response);
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
        });
    }

    $(document).ready(function(){

        let start_datetime_container = $('#start_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        let end_datetime_container = $('#end_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        let gather_datetime_container = $('#gather_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        @if ($detail && $detail->start_datetime)
            start_datetime_container.datetimepicker('setStartDate', new Date());
            start_datetime_container.datetimepicker('setDate', new Date("{{$detail->start_datetime}}"));
            end_datetime_container.datetimepicker('setStartDate', new Date("{{$detail->start_datetime}}"));
            @else
            start_datetime_container.datetimepicker('setStartDate', new Date());
        @endif
        @if ($detail && $detail->end_datetime)
            end_datetime_container.datetimepicker('setDate', new Date("{{$detail->end_datetime}}"));
            end_datetime_container.find('input').prop('disabled', false);
        @endif

        @if ($detail && $detail->assembly_datetime)
            gather_datetime_container.datetimepicker('setStartDate', new Date());
            gather_datetime_container.datetimepicker('setDate', new Date("{{$detail->assembly_datetime}}"));
        @endif


        $('#start_datetime_container').on('change', function(){
            var startDateTime = $('#start_datetime_container').datetimepicker('getDate');
            if(startDateTime){
                $('#end_datetime_container').find('input').prop('disabled', false);
            }
            $('#end_datetime_container').datetimepicker('setDate', startDateTime);
            $('#end_datetime_container').datetimepicker('setStartDate', startDateTime);
        });

        $('#gather_datetime_container').on('change', function(){
            var startDateTime = $('#gather_datetime_container').datetimepicker('getDate');
        });

        $('#frm_journey').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            let trip_expense_type = $.map($('.trip_expense_type:checked'), function(n, i){
                return n.value;
            }).join(',');

            if(trip_expense_type.length > 0){
                formData.append('trip_expense_type', trip_expense_type);
            }

            submitJourney(formData);

        });

    })
</script>
