
@php
$TaskFlowAccessAssessmentGovLoan = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
<style type="text/css">
    .letter-a4 {
        /*width:2480px;
        height:3508px;*/
        padding-left:30px;
    }
    .letter-title {
        text-align: center;
        font-family: helve-bold;
        font-size:18px;
        color:black;
        text-transform: uppercase;
        margin-bottom:30px;
        margin-top:30px;
    }
    .inv-date {
        width:100%;
        text-align:right;
        font-family: avenir;
        font-size:14px;
        color:black;
    }
    .inv-date span {
        font-family: avenir;
        padding-left:10px;
        padding-right:10px;
        text-decoration:underline;
    }
    .bpk {
        position: absolute;
        top:10px;
        right:30px;
        font-family: helvetica;
        font-size:8px;
        color:black;
    }
    .inv-term {
        font-family: helve-bold;
        font-size:14px;
        color:black;
        max-width:120px;
        text-transform: uppercase;
    }
    .inv-term2 {
        font-family: helve-bold;
        font-size:14px;
        color:black;
        max-width:250px;
    }
    .inv-dot {
        font-family: helve-bold;
        font-size:14px;
        color:black;
        max-width:10px;
    }
    .inv-butir {
        border-bottom-style: dotted;
        border-bottom-color:grey;
        border-bottom-width: 1px;
        padding-left:30px;
        padding-right:30px;
        font-size:14px;
        font-family: helve-bold;
        color:#000000;
        max-width: 200px;
    }
    .inv-item {
        font-family: avenir;
        font-size:14px;
        color:black;
    }
    .inv-invoice {
        font-family: helve-bold;
        font-size:14px;
        color:black;
        text-transform: uppercase;
    }
    .letter-a4 .row {
        min-height: 30px;
        margin-bottom:15px;
    }
    .line-cross {
        position: relative;
        width:98%;
        height:1px;
        background-color:#000000;
    }
    .potong {
        position: absolute;
        left:0px;
        top:-15px;
        font-family: avenir;
        font-size:10px;
        color:#000000;
        width:auto;
    }
    .lcal-noplet {
        width:150px;
    }
    .lcal-120 {
        width:120px;
    }
    .lcal-assign {
        width:300px;
        min-width: 300px;
    }
</style>
<script type="text/javascript">

    function calculate() {

        var totalPoints = 0;
        $('.price-input input').each(function(){
                totalPoints = parseFloat($(this).val()) + totalPoints;
        });
        $('#totalprice').text(totalPoints - 1);
    }
</script>
<form class="row" id="frm_apppointment_vehicle" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="set_appointment">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <fieldset>
    <legend>MAKLUMAT TEMUJANJI</legend>
    <p>{{$detail && $detail->hasStatus->code == '01' ? 'Sila set':'' }} Sila tetapkan jadual temujanji untuk penilaian kenderaan di bawah</p>
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-4 col-12">
            <div class="form-group">
                <label for="" class="form-label">JKR Woksyop <em class="text-danger">*</em></label>
                @if($detail && $detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())
                <select class="form-control form-select" id="" name="workshop_id">
                    <option selected value="">Sila Pilih</option>
                    @foreach ($workshop_list as $jkr_workshop)
                        <option {{$detail && $detail->hasWorkshop && $detail->hasWorkshop->id == $jkr_workshop->id ? 'selected': ''}} value="{{$jkr_workshop->id}}">{{$jkr_workshop->desc}}</option>
                    @endforeach
                </select>
                @else
                    <div class="txt_data ass_gov">{{$detail->hasWorkshop ? $detail->hasWorkshop->desc : ''}}</div>
                @endif
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-12" style="min-width:270px;">
            <div class="form-group">
                <label for="" class="form-label">Temujanji <em class="text-danger">*</em></label>
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
                    <div class="txt_data ass_gov">{{$detail->appointment_dt ? \Carbon\Carbon::parse($detail->appointment_dt)->format('d/m/Y - g:i A') : 'Menunggu temujanji'}}</div>
                @endif
            </div>
        </div>
        @if($detail && $detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())
        {{-- <div class="col-xl-2 col-lg-3 col-md-4 col-sm-5 col-12" style="min-width:270px;display: {{ $detail && $detail->is_other_app_dt ? '' : 'none'}}" id="other_datetime_container">
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
                                {{-- <div class="input-group date form_datetime" id="otherAppoinmentDtContainer" data-date="{{$detail && $detail->appointment_dt ? $detail->appointment_dt : ''}}" data-date-format="dd M yyyy">
                                    <input class="form-control oth_appointment_date" size="16" id="input_other_date" type="text"
                                    value="{{$detail && $detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('d M Y') : ''}}" placeholder="Tarikh Lain" onkeypress="return false;" >
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    <label class=" input-group-text" for="other_appoinment_dt">
                                        <i class="fal fa-calendar-alt"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="other_appoinment_dt" id="other_appoinment_dt" value="{{$detail && $detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('d M Y G:i:s') : ''}}" /> --}}
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
    </fieldset>
    @if(auth()->user()->isAssistEngineerAssessment())
    <fieldset>
        <legend>BAYARAN</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-12">
                <div class="form-group">
                    <label for="" class="form-label">No Pesanan Kerja  <em class="text-danger">*</em></label>
                    <input type="text" class="form-control" onchange="this.value = this.value.toUpperCase()" name="bpk_no" id="bpk_no" value="{{$detail->hasBpkNo->code}}" disabled>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-1 col-sm-2 col-12">
                <div class="form-group">
                    <label for="" class="form-label">No. PTJ</label>
                    <input type="text" id="ptj_no" name="ptj_no" class="input-sm form-control" placeholder="No PTJ" value="">
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-4 col-12">
                <div class="form-group">
                    <label for="" class="form-label">Preview</label>
                    <button type="button" class="btn cux-btn bigger" style="margin-top:2px" onclick="checkJob({{$detail->id}})"><i class="fa fa-eye"></i> Lihat Janaan BPK 1/94</button>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>MAKLUMAT KENDERAAN</legend>
            <div class="col-12 pt-2 mb-2">
                <div class="btn-group">
                        <button class="btn cux-btn bigger" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#assessmentGovLoanVehicleDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
                </div>
            </div>
        @if((auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerAssessment()))
            <div class="col-xl-12 col-lg-12 col-md-12" id="assessment_gov_loan_vehicle_appointment">

            </div>
        @endif
    </fieldset>
    @else
    <fieldset>
        <legend>PEMBAYARAN</legend>
        <p>Sila cetak borang untuk membuat pembayaran sebelum menghantar kenderaan untuk penilaian</p>
        <div class="col-xl-12 col-lg-12 col-md-12">
        <button type="button" class="btn cux-btn bigger"><i class="fa fa-print"></i> Cetak Borang Pesanan Kerja</button>
        </div>
    </fieldset>
    @endif
    @if(auth()->user()->isAssistEngineerAssessment())
        <div class="col-md-12" id="assessment_gov_loan_vehicle_appointment">

        </div>
    @endif

    {{--<div class="col-md-12 form-group">
        <div class="row">
            <div class="col-md-12 mt-2 mb-2">
                <div class="form-group center">
                    @if($detail->hasStatus->code == '02' && auth()->user()->isAssistEngineerAssessment())

                        <span id="proceed-appointment-container" >
                            <button type="button" onclick="saveSilent()" id="proceed-appointment" class="btn btn-module examination" data-id="{{$detail ? $detail->id : null}}" style="display: {{$detail->appointment_dt ? 'inline-block':'none'}};">Hantar</button>
                        </span>
                        <button class="btn btn-link" type="submit"><i class="fas fa-save"></i> Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>--}}


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

<div class="modal fade modal-asking" id="assessmentGovLoanVehicleDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentGovLoanVehicleDelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-body pt-5">
                <div class="asking">
                    Adakah anda pasti untuk<br/>menghapus maklumat ini?
                </div>
                <input type="hidden" name="section" value="examination">
            </div>
            <div class="modal-footer justify-content-start">
                <button class="btn btn-module" type="button" onclick="remove()">Hapus</button>
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

let selected_other_app_dt = null;

function checkJob(assessment_id) {
        var assessment_id = assessment_id;
        var bpk_no = $('#bpk_no').val().trim();
        var totalprice = $('#grandtotal').text();
        let ptj_no = $('#ptj_no').val();
        if(totalprice == 0){
            alert("Borang Pesanan Kerja BPK 1/94 hanya dicetak sekiranya ada bayaran yang perlu dibuat");
        }else{
            if(bpk_no != ''){
                window.open("{{route('jasperReport')}}?format=pdf&title=BorangPesananKerja&report_name=borang_pesanan_kerja_gov_loan&assessment_gov_loan_id="+assessment_id+"&ptj_no="+ptj_no);
            }else{
                alert("Sila masukkan No Pesanan Kerja");
                $('#bpk_no').focus();
            }
        }
    }

    saveSilent = function(){

        let data = $('#frm_apppointment_vehicle');
        var hantar = 'hantar';
        let formData = new FormData(data[0]);
        formData.append('hantar', hantar);
        $.ajax({
                url: "{{ route('assessment.gov_loan.register.save') }}",
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

    loadAssessmentGovLoanVehicleAppointment = function() {
        $.get("{{ route('assessment.gov_loan.vehicle-appointment.list') }}", function(result){
            $('#assessment_gov_loan_vehicle_appointment').html(result);
        });
    }

    updateAssessmentGovLoanVehicleAppointment =  function(data){

        $.ajax({
            url: "{{ route('assessment.gov_loan.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_apppointment_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                // loadAssessmentGovLoanVehicleAppointment();
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

    function remove(){
        $('#assessmentGovLoanVehicleDelModal #remove').hide();
        $('#assessmentGovLoanVehicleDelModal #close').hide();
        $.post("{{route('assessment.gov_loan.vehicle.cancel')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(response){
            $('#frm_vehicle #response').html('<span class="text-warning">'+response.message+'</span>').fadeIn(50).fadeOut(5000);
            $('#assessmentGovLoanVehicleDelModal').modal('hide');
            loadAssessmentGovLoanVehicleAppointment();
        })
    }

    $(document).ready(function(){

        @if($detail && auth()->user()->isAssistEngineerAssessment())
        loadAssessmentGovLoanVehicleAppointment();
        @endif

        // let otherAppoinmentDtContainer = $('#otherAppoinmentDtContainer').datetimepicker({
        //     autoclose: 1,
        //         todayHighlight: 1,
        //         startDate: new Date()
        // }).on('changeDate', function(e){
        //     let formatedValue = moment(e.date).format('YYYY-MM-DD HH:mm');
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
            updateAssessmentGovLoanVehicleAppointment(formData);
        });

    })

</script>
