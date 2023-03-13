
@php
$TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('03', '02');
@endphp

<form class="row" id="frm_apppointment_vehicle" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="set_appointment">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>MAKLUMAT TEMUJANJI</legend>
                        <p>{{$detail && $detail->hasStatus->code == '01' ? 'Sila set':'' }} Maklumat Temujanji untuk pemeriksaan kerosakan kenderaan</p>
                        <div class="col-md-12">
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="form-label">JKR Woksyop  <em class="text-danger">*</em></label>
                                        @if($detail && $detail->hasStatus->code == '02')
                                            @if($detail->hasAssistantEngineerBy && $detail->hasAssistantEngineerBy->id == Auth()->user()->id || Auth()->user()->isEngineer() || Auth()->user()->isAdmin())
                                            <select class="form-control form-select" id="" name="workshop_id">
                                                <option selected value="">Sila Pilih</option>
                                                @foreach ($workshop_list as $jkr_workshop)
                                                    <option {{$detail && $detail->hasWorkshop && $detail->hasWorkshop->id == $jkr_workshop->id ? 'selected': ''}} value="{{$jkr_workshop->id}}">{{$jkr_workshop->desc}}</option>
                                                @endforeach
                                            </select>
                                            @else
                                                <div>{{$detail->hasWorkshop->desc}}</div>
                                            @endif
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="form-label">TemuJanji <em class="text-danger">*</em></label>
                                        {{-- @if($detail && $detail->hasStatus->code == '02' && $TaskFlowAccessMaintenanceEvaluation->mod_fleet_appointment) --}}
                                        @if($detail && $detail->hasStatus->code == '02')
                                            @if($detail->hasAssistantEngineerBy && $detail->hasAssistantEngineerBy->id == Auth()->user()->id || Auth()->user()->isEngineer() || Auth()->user()->isAdmin())
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
                                                Menunggu temujanji
                                            @endif
                                        @else
                                            {{$detail->appointment_dt ? \Carbon\Carbon::parse($detail->appointment_dt)->format('d/m/Y - g:i A') : 'Menunggu temujanji'}}
                                        @endif
                                    </div>
                                </div>
                                @if($detail && $detail->hasStatus->code == '02')
                                    @if($detail->hasAssistantEngineerBy && $detail->hasAssistantEngineerBy->id == Auth()->user()->id || Auth()->user()->isEngineer() || Auth()->user()->isAdmin())
                                        <div class="col-md-4" style="display: {{ $detail && $detail->is_other_app_dt ? '' : 'none'}}" id="other_datetime_container">
                                            <label for="" class="form-label">Pilihan Lain <em></em></label>
                                            <div class="input-group date form_datetime" id="otherAppoinmentDtContainer" data-date="{{$detail && $detail->is_other_app_dt && $detail->appointment_dt ? $detail->appointment_dt : ''}}" data-date-format="dd MM yyyy - H:ii P">
                                                <input class="form-control" size="16" id="other_appoinment_dt_input" type="text"
                                                value="{{$detail && $detail->is_other_app_dt && $detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('d F Y - g:i A') : ''}}"
                                                readonly>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                <label class="input-group-text" for="other_appoinment_dt_input">
                                                    <i class="fal fa-calendar-alt"></i>
                                                </label>
                                            </div>
                                            <input type="hidden" id="other_appoinment_dt" name="other_appoinment_dt" value="{{Carbon\Carbon::parse($detail->appointment_dt)->format('Y-m-d H:i')}}">
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @if($TaskFlowAccessMaintenanceEvaluation->mod_fleet_appointment) --}}
            @if($detail->hasAssistantEngineerBy && $detail->hasAssistantEngineerBy->id == Auth()->user()->id || Auth()->user()->isEngineer() || Auth()->user()->isAdmin())
                <div class="col-md-12" id="maintenance_evaluation_vehicle_appointment">

                </div>
            @endif
        </div>
    </div>

    <div class="col-md-12 form-group">
        <div class="row">
            <div class="col-md-12 mt-2 mb-2">
                <div class="form-group center">
                    @if($detail->hasStatus->code == '02')
                        @if($detail->hasAssistantEngineerBy && $detail->hasAssistantEngineerBy->id == Auth()->user()->id || Auth()->user()->isEngineer() || Auth()->user()->isAdmin())
                            <button class="btn btn-module" type="submit">Simpan</button>
                            <span id="proceed-appointment-container" style="display: {{$detail->appointment_dt ? '':'none'}};">
                                <a onclick="saveSilent()" id="proceed-appointment" class="btn btn-module examination" data-id="{{$detail ? $detail->id : null}}">Hantar</a>
                            </span>
                        @endif
                    <span class="ms-2" id="response"></span>
                    @endif
                </div>
            </div>
        </div>
    </div>

</form>

<script type="text/javascript">

const saveSilent = function(){

    let data = $('#frm_apppointment_vehicle');
    let formData = new FormData(data[0]);
    $.ajax({
            url: "{{ route('maintenance.evaluation.register.save') }}",
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

    const loadMaintenanceEvaluationVehicleAppointment = function() {
        $.get("{{ route('maintenance.evaluation.vehicle-appointment.list') }}", function(result){
            $('#maintenance_evaluation_vehicle_appointment').html(result);
        });
    }

    const updateMaintenanceEvaluationVehicleAppointment =  function(data){
        $.ajax({
            url: "{{ route('maintenance.evaluation.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_apppointment_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                // loadMaintenanceEvaluationVehicleAppointment();
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

        @if($detail)
            @if($detail->hasAssistantEngineerBy && $detail->hasAssistantEngineerBy->id == Auth()->user()->id || Auth()->user()->isEngineer() || Auth()->user()->isAdmin())
            loadMaintenanceEvaluationVehicleAppointment();
            @endif
        @endif

        let otherAppoinmentDtContainer = $('#otherAppoinmentDtContainer').datetimepicker({
            autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD HH:mm');
            $('#other_appoinment_dt').val(formatedValue);
        });

        $('#appointment_dt').on('change', function(e){
            e.preventDefault();

            console.log(this.value);

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



        $('#frm_apppointment_vehicle').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            updateMaintenanceEvaluationVehicleAppointment(formData);
        });

    })

</script>
