
@php
$TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_apppointment_vehicle" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="set_appointment">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>MAKLUMAT TEMUJANJI</legend>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">JKR Woksyop  <em class="text-danger">*</em></label>
                                        @if($detail && $detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())
                                        <select class="form-control form-select" id="" name="workshop_id">
                                            <option selected value="">Sila Pilih</option>
                                            @foreach ($workshop_list as $jkr_workshop)
                                                <option {{$detail && $detail->hasWorkshop && $detail->hasWorkshop->id == $jkr_workshop->id ? 'selected': ''}} value="{{$jkr_workshop->id}}">{{$jkr_workshop->desc}}</option>
                                            @endforeach
                                        </select>
                                        @else
                                            <div class="txt-data ass_acc">{{$detail->hasWorkshop->desc}}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">TemuJanji <em class="text-danger">*</em></label>
                                        @if($detail && $detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())
                                            <select name="appointment_dt" id="appointment_dt">
                                                <option value="">Sila Pilih Temujanji</option>
                                                @if($detail && $detail->appointment_dt1)
                                                    <option {{$detail && $detail->appointment_dt1 == $detail->appointment_dt ? 'selected' : ''}}  value="{{\Carbon\Carbon::parse($detail->appointment_dt1)->format('Y-m-d H:i')}}" >{{\Carbon\Carbon::parse($detail->appointment_dt1)->format('d/m/Y - g:i A')}}</option>
                                                @endif
                                                @if($detail && $detail->appointment_dt2)
                                                    <option  {{$detail && $detail->appointment_dt2 == $detail->appointment_dt ? 'selected' : ''}} value="{{\Carbon\Carbon::parse($detail->appointment_dt2)->format('Y-m-d H:i')}}">{{\Carbon\Carbon::parse($detail->appointment_dt2)->format('d/m/Y - g:i A')}}</option>
                                                @endif
                                                @if($detail && $detail->appointment_dt3)
                                                    <option {{$detail && $detail->appointment_dt3 == $detail->appointment_dt ? 'selected' : ''}} value="{{\Carbon\Carbon::parse($detail->appointment_dt3)->format('Y-m-d H:i')}}">{{\Carbon\Carbon::parse($detail->appointment_dt3)->format('d/m/Y - g:i A')}}</option>
                                                @endif
                                                <option {{$detail && $detail->is_other_app_dt ? 'selected' : ''}} value="other_appointment_dt">Pilihan Lain</option>
                                            </select>
                                        @else
                                            <div class="txt-data ass_acc">{{$detail->appointment_dt ? \Carbon\Carbon::parse($detail->appointment_dt)->format('d/m/Y - g:i A') : 'MENUNGGU TEMUJANJI'}}</div>
                                        @endif
                                    </div>
                                </div>
                                @if($detail && $detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())
                                    {{-- <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12" style="display: {{ $detail && $detail->is_other_app_dt ? '' : 'none'}}" id="other_datetime_container">
                                        <label for="" class="form-label">Pilihan Lain <em></em></label>
                                        <div class="input-group date form_datetime" id="otherAppoinmentDtContainer" data-date="{{$detail && $detail->is_other_app_dt && $detail->appointment_dt ? $detail->appointment_dt : ''}}" data-date-format="dd MM yyyy - HH:ii p">
                                            <input class="form-control" size="16" id="date_3_input" type="text"
                                            value="{{$detail && $detail->is_other_app_dt && $detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('d M Y - g:i A') : ''}}"
                                            readonly>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                            <label class="input-group-text">
                                                <i class="fal fa-calendar-alt"></i>
                                            </label>
                                        </div>
                                        <input type="hidden" id="other_appoinment_dt" name="other_appoinment_dt" value="{{Carbon\Carbon::parse($detail->appointment_dt )->format('Y-m-d H:i')}}">
                                    </div> --}}
                                    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12" style="display: {{ $detail && $detail->is_other_app_dt ? '' : 'none'}}" id="other_datetime_container">
                                        <label class="form-label text-dark">Cadangan Tarikh & Masa Temujanji  <span class="text-danger">*</span></label>
                                        <div class="row">
                                            <div class="col-md-3" >
                                                <div class="input-group date" id="otherAppoinmentDt"
                                                    data-target-input="nearest">
                                                    <input id="input_other_date"
                                                    type="text" class="form-control datepicker" placeholder="Tarikh Lain"
                                                    autocomplete="off"
                                                    data-provide="datepicker" data-date-autoclose="true"
                                                    data-date-format="dd M yyyy" data-date-today-highlight="true"
                                                    value="{{isset($detail['appointment_dt']) ? Carbon\Carbon::parse($detail['appointment_dt'])->format('d M Y'): null}}"/>
                                                    <div class="input-group-text" for="input_other_date">
                                                        <i class="fal fa-calendar"></i>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="other_appoinment_dt" id="other_appoinment_dt" value="{{$detail && $detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('d M Y G:i:s') : ''}}" />
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control form-select appointment_time_othrs" id="time_other" name="time_other">
                                                    <option></option>
                                                @php
                                                    $mytime = '';
                                                    if($detail && $detail->appointment_dt) {
                                                        $mytime = sprintf('%02d', strval(Carbon\Carbon::parse($detail->appointment_dt )->format('g'))).strval(Carbon\Carbon::parse($detail->appointment_dt )->format(':i A'));
                                                    }
                                                    $arrBlock = array('12:45 PM','01:00 PM','01:15 PM','01:30 PM','01:45 PM','04:15 PM','04:30 PM','04:45 PM');
                                                    $arrMin = array('00','15','30','45');

                                                    for ($time = 9; $time <= 16; $time++) {
                                                        $ampm = $time < 12 ? 'AM' : 'PM';
                                                        $timedisplay = $time > 12 ? ($time - 12) : $time;
                                                        $showtime = sprintf('%02d', $timedisplay);

                                                        foreach ($arrMin as $value) {
                                                            $fulltime = $showtime.":".$value." ".$ampm;
                                                            if (in_array($fulltime, $arrBlock, TRUE)){

                                                            }else{
                                                                $selected = '';
                                                                if($mytime == $fulltime){
                                                                    $selected = "selected";
                                                                }else{
                                                                    $selected = "";
                                                                }
                                                                // echo $fulltime;
                                                                echo "<option value='{$fulltime}' {$selected}>{$fulltime}</option>";
                                                            }
                                                            $selected = "";
                                                        }
                                                    }
                                                @endphp
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(auth()->user()->isAssistEngineerAssessment())
                <div class="col-md-12" id="assessment_accident_vehicle_appointment">

                </div>
            @endif
        </div>
    </div>
    <hr class="mt-2"/>
    <div class="col-12 form-group">
        <div class="row">
            <div class="col-md-12 mt-2 mb-2">
                <div class="form-group center">
                    @if($detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())

                        <span id="proceed-appointment-container" style="display: {{$detail->appointment_dt ? '':'none'}};">
                            <a onclick="saveSilent()" id="proceed-appointment" class="btn btn-module examination" data-id="{{$detail ? $detail->id : null}}">Hantar</a>
                        </span>
                        <button class="btn btn-link" type="submit"><i class="fa fa-save"></i> Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">

let selected_other_app_dt = null;

    saveSilent = function(){

        let data = $('#frm_apppointment_vehicle');
            var hantar = 'hantar';
            let formData = new FormData(data[0]);
            formData.append('hantar', hantar);
        $.ajax({
                url: "{{ route('assessment.accident.register.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {

                }
        });
    }

    loadAssessmentNewVehicleAppointment = function() {
        $.get("{{ route('assessment.accident.vehicle-appointment.list') }}", function(result){
            $('#assessment_accident_vehicle_appointment').html(result);
        });
    }

    updateAssessmentNewVehicleAppointment =  function(data){
        $.ajax({
            url: "{{ route('assessment.accident.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_apppointment_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                // loadAssessmentNewVehicleAppointment();
                // window.location.reload();
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    } else {
                        console.log('key', key)
                        if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    }
                });
            }
        });
    }

    $(document).ready(function(){

        @if($detail && auth()->user()->isAssistEngineerAssessment())
        loadAssessmentNewVehicleAppointment();
        @endif

        // let otherAppoinmentDtContainer = $('#otherAppoinmentDtContainer').datetimepicker({
        //     autoclose: 1,
        //         todayHighlight: 1,
        //         startDate: new Date()
        // }).on('changeDate', function(e){
        //     let formatedValue = moment(e.date).format('YYYY-MM-DD h:m');
        //     $('#other_appoinment_dt').val(formatedValue);
        // });

        $('#appointment_dt').on('change', function(e){
            e.preventDefault();

            let proceed_appointment_container = $('#proceed-appointment-container');
            let other_datetime_container = $('#other_datetime_container');

            if(this.value){
                proceed_appointment_container.show();
            } else {
                proceed_appointment_container.hide();
            }

            if(this.value == 'other_appointment_dt')
            {
                other_datetime_container.show();
            }else{
                other_datetime_container.hide();
            }
        });

        let otherAppoinmentDtContainer = $('#input_other_date').datepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );

        $('.appointment_time_othrs, #input_other_date').add(".oth_appointment_date").change(function(){
            var ddate = $('#input_other_date').val();
            var dtime = $('#time_other').val();
            ddate = new moment(ddate, 'DD MMM YYYY').format('YYYY-MM-DD');

            if(dtime != ''){
                both = ddate + " " + dtime;
            }else{
                both = ddate;
            }
            $('#other_appoinment_dt').val(both);
        });


        $('#frm_apppointment_vehicle').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            updateAssessmentNewVehicleAppointment(formData);
        });

    })

</script>
