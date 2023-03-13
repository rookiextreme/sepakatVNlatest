<div class="container">
    <div class="row">
        @if(!auth()->user()->detail->hasWorkshop)
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pb-5" id="notify">
                <div class="alert alert-dismissible fade show" role="alert" style='background-color: #49575c;color:#ffffff'>
                        Anda tidak mempunyai woksyop. Sila hubungi pentadbir sistem untuk penetapan woksyop.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="$(this).alert('close')"><i class="fal fa-times" aria-hidden="true"></i></button>
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="position: relative;">
            <div class="spectitle">Dashboard Penilaian : <span>{{auth()->user()->name}}</span></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="my-date">{{date("d M Y")}}</div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="search" onkeyup="searching(this)" class="form-control search" placeholder="Carian Plat No" value="">
                        <span class="input-group-text" style="border-width:1px;"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 top-shelf">
                    <div class="top-shelf-wrap">
                        <div style="width: 100%;display: flex;overflow-x: scroll;height: 123px;padding-left: 10px;">
                            @foreach ($assessment_new_vehicle_active_list as $assessment_new_vehicle_active)
                                    <div class="active-box" style="{{strlen($assessment_new_vehicle_active->plate_no) > 7 ? "width:unset;": ""}}">
                                        @if($session_prev_id)
                                            <button class="btn cux-btn reset-assessment" type="button" data-id="{{$assessment_new_vehicle_active->id}}" data-assessment-code="01" data-plate-no="{{$assessment_new_vehicle_active->plate_no}}" onclick="prompResetAssessment(this)">X</button>
                                        @endif
                                        <small style="font-size: 7px; color:black; font-weight: bold">Penilaian Kenderaan Baharu</small>
                                        <div class="inside" onclick="generateFormExamination({{$assessment_new_vehicle_active->id}}, '01')">
                                            {{$assessment_new_vehicle_active->plate_no}}
                                        </div>
                                    </div>
                            @endforeach

                            @foreach ($assessment_safety_vehicle_active_list as $assessment_safety_vehicle_active)
                                <div class="active-box" style="{{strlen($assessment_safety_vehicle_active->plate_no) > 7 ? "width:unset;": ""}}">
                                    @if($session_prev_id)
                                        <button class="btn cux-btn reset-assessment" type="button" data-id="{{$assessment_safety_vehicle_active->id}}" data-assessment-code="02" data-plate-no="{{$assessment_safety_vehicle_active->plate_no}}" onclick="prompResetAssessment(this)">X</button>
                                    @endif
                                    <small style="font-size: 7px; color:black; font-weight: bold">Penilaian Keselamatan</small>
                                    <div class="inside" onclick="generateFormExamination({{$assessment_safety_vehicle_active->id}}, '02')">
                                        {{$assessment_safety_vehicle_active->plate_no}}
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($assessment_accident_vehicle_active_list as $assessment_accident_vehicle_active)
                                <div class="active-box">
                                    @if($session_prev_id)
                                        <button class="btn cux-btn reset-assessment" type="button" data-id="{{$assessment_accident_vehicle_active->id}}" data-assessment-code="03" data-plate-no="{{$assessment_accident_vehicle_active->plate_no}}" onclick="prompResetAssessment(this)">X</button>
                                    @endif
                                    <small style="font-size: 7px; color:black; font-weight: bold">Penilaian Kemalangan</small>
                                    <div class="inside" onclick="generateFormExamination({{$assessment_accident_vehicle_active->id}}, '03', {{$assessment_accident_vehicle_active->assessment_accident_id}}, {{$assessment_accident_vehicle_active->id}}, 4)">
                                        {{$assessment_accident_vehicle_active->plate_no}}
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($assessment_disposal_vehicle_active_list as $assessment_disposal_vehicle_active)
                                <div class="active-box">
                                    @if($session_prev_id)
                                        <button class="btn cux-btn reset-assessment" type="button" data-id="{{$assessment_disposal_vehicle_active->id}}" data-assessment-code="06" data-plate-no="{{$assessment_disposal_vehicle_active->plate_no}}" onclick="prompResetAssessment(this)">X</button>
                                    @endif
                                <small style="font-size: 7px; color:black; font-weight: bold">Pelupusan</small>
                                    <div class="inside" onclick="generateFormExamination({{$assessment_disposal_vehicle_active->id}}, '06')">
                                        {{$assessment_disposal_vehicle_active->plate_no}}
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($assessment_gov_loan_vehicle_active_list as $assessment_gov_loan_vehicle_active)
                                <div class="active-box">
                                    @if($session_prev_id)
                                        <button class="btn cux-btn reset-assessment" type="button" data-id="{{$assessment_gov_loan_vehicle_active->id}}" data-assessment-code="05" data-plate-no="{{$assessment_gov_loan_vehicle_active->plate_no}}" onclick="prompResetAssessment(this)">X</button>
                                    @endif
                                    <small style="font-size: 7px; color:black; font-weight: bold">Pinjaman Kerajaan</small>
                                    <div class="inside" onclick="generateFormExamination({{$assessment_gov_loan_vehicle_active->id}}, '05')">
                                        {{$assessment_gov_loan_vehicle_active->plate_no}}
                                    </div>
                                </div>
                            @endforeach
                            @foreach ($assessment_currvalue_vehicle_active_list as $assessment_currvalue_vehicle_active)
                                <div class="active-box">
                                    @if($session_prev_id)
                                        <button class="btn cux-btn reset-assessment" type="button" data-id="{{$assessment_currvalue_vehicle_active->id}}" data-assessment-code="04" data-plate-no="{{$assessment_currvalue_vehicle_active->plate_no}}" onclick="prompResetAssessment(this)">X</button>
                                    @endif
                                    <small style="font-size: 7px; color:black; font-weight: bold">Harga Semasa</small>
                                    <div class="inside" onclick="generateFormExamination({{$assessment_currvalue_vehicle_active->id}}, '04')">
                                        {{$assessment_currvalue_vehicle_active->plate_no}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="curve" style="background-image: url({{asset('my-assets/img/curve.png')}});">Sedang Diperiksa<br/><i class="fal fa-arrow-right mt-2"></i></div>
                </div>
            </div>
            @if(count($assessment_new_vehicle_list) > 0)
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#collapse_new">Penilaian Kenderaan Baharu <span id="assessment_new_total">{{count($assessment_new_vehicle_list)}}</span></div>
                        <div style="width: 100%;" id="collapse_new" class="collapse">
                        <div>
                            @foreach ($assessment_new_vehicle_list as $assessment_new_vehicle)
                                <div class="job-box" data-plate-no="{{$assessment_new_vehicle->plate_no}}" onclick="promptFormExamination({{$assessment_new_vehicle->id}}, '01', this)">
                                    <table style="width: 250px; height: 70px; white-space: initial;">
                                        <tr>
                                            <td style="width: 100px;vertical-align: bottom; {{strlen($assessment_new_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$assessment_new_vehicle->plate_no}}</td>
                                            <td style="{{strlen($assessment_new_vehicle->hasAssessmentDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                                {{$assessment_new_vehicle->hasAssessmentDetail->department_name}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($assessment_new_vehicle->hasAssessmentDetail->appointment_dt)->format('d/m/Y')}}</td>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>
            @endif
            @if(count($assessment_accident_vehicle_list) > 0)
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#collapse_accident">Penilaian Kemalangan <span id="assessment_accident_total">{{count($assessment_accident_vehicle_list)}}</span></div>
                    <div style="width: 100%;" id="collapse_accident" class="collapse">
                        @foreach ($assessment_accident_vehicle_list as $assessment_accident_vehicle)
                            <div class="job-box" data-plate-no="{{$assessment_accident_vehicle->plate_no}}" onclick="promptFormExamination({{$assessment_accident_vehicle->id}}, '03', this, {{$assessment_accident_vehicle->assessment_accident_id}}, {{$assessment_accident_vehicle->id}}, 4)">
                                <table style="width: 250px; height: 70px; white-space: initial;">
                                    <tr>
                                        <td style="width: 100px;vertical-align: bottom; {{strlen($assessment_accident_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$assessment_accident_vehicle->plate_no}}</td>
                                        <td style="{{strlen($assessment_accident_vehicle->hasAssessmentDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                            {{$assessment_accident_vehicle->hasAssessmentDetail->department_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($assessment_accident_vehicle->hasAssessmentDetail->appointment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(count($assessment_safety_vehicle_list) > 0)
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#collapse_safety">Penilaian Keselamatan & Prestasi <span id="assessment_safety_total">{{count($assessment_safety_vehicle_list)}}</span></div>
                    <div style="width: 100%;" id="collapse_safety" class="collapse">
                        @foreach ($assessment_safety_vehicle_list as $assessment_safety_vehicle)
                            <div class="job-box" data-plate-no="{{$assessment_safety_vehicle->plate_no}}" onclick="promptFormExamination({{$assessment_safety_vehicle->id}}, '02', this)">
                                <table style="width: 250px; height: 70px; white-space: initial;">
                                    <tr>
                                        <td style="width: 100px;vertical-align: bottom; {{strlen($assessment_safety_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$assessment_safety_vehicle->plate_no}}</td>
                                        <td style="{{strlen($assessment_safety_vehicle->hasAssessmentDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                            {{$assessment_safety_vehicle->hasAssessmentDetail->department_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($assessment_safety_vehicle->hasAssessmentDetail->appointment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(count($assessment_currvalue_vehicle_list) > 0)
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#collapse_currvalue">Penilaian Nilai Harga Semasa  <span id="assessment_currvalue_total">{{count($assessment_currvalue_vehicle_list)}}</span></div>
                    <div style="width: 100%;" id="collapse_currvalue" class="collapse">
                        <div>
                        @foreach ($assessment_currvalue_vehicle_list as $assessment_currvalue_vehicle)
                            <div class="job-box" data-plate-no="{{$assessment_currvalue_vehicle->plate_no}}" onclick="promptFormExamination({{$assessment_currvalue_vehicle->id}}, '04', this)">
                                <table style="width: 250px; height: 70px; white-space: initial;">
                                    <tr>
                                        <td style="width: 100px;vertical-align: bottom; {{strlen($assessment_currvalue_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$assessment_currvalue_vehicle->plate_no}}</td>
                                        <td style="{{strlen($assessment_currvalue_vehicle->hasAssessmentDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                            {{$assessment_currvalue_vehicle->hasAssessmentDetail->department_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($assessment_currvalue_vehicle->hasAssessmentDetail->appointment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(count($assessment_gov_loan_vehicle_list) > 0)
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#collapse_gov_loan">Penilaian Pinjaman Kerajaan <span id="assessment_gov_loan_total">{{count($assessment_gov_loan_vehicle_list)}}</span></div>
                    <div style="width: 100%;" id="collapse_gov_loan" class="collapse">
                        <div>
                        @foreach ($assessment_gov_loan_vehicle_list as $assessment_gov_loan_vehicle)
                            <div class="job-box" data-plate-no="{{$assessment_gov_loan_vehicle->plate_no}}" onclick="promptFormExamination({{$assessment_gov_loan_vehicle->id}}, '05', this)">
                                <table style="width: 250px; height: 70px; white-space: initial;">
                                    <tr>
                                        <td style="width: 100px;vertical-align: bottom; {{strlen($assessment_gov_loan_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$assessment_gov_loan_vehicle->plate_no}}</td>
                                        <td style="{{strlen($assessment_gov_loan_vehicle->hasAssessmentDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                            {{$assessment_gov_loan_vehicle->hasAssessmentDetail->department_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($assessment_gov_loan_vehicle->hasAssessmentDetail->appointment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(count($assessment_disposal_vehicle_list) > 0)
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 shelf">
                    <div class="jobtype nav-link collapsed" data-bs-toggle="collapse" href="#collapse_disposal">Penilaian Pelupusan <span id="assessment_disposal_total">{{count($assessment_disposal_vehicle_list)}}</span></div>
                    <div style="width: 100%;" id="collapse_disposal" class="collapse">
                        <div>
                        @foreach ($assessment_disposal_vehicle_list as $assessment_disposal_vehicle)
                            <div class="job-box" data-plate-no="{{$assessment_disposal_vehicle->plate_no}}" onclick="promptFormExamination({{$assessment_disposal_vehicle->id}}, '06', this)">
                                <table style="width: 250px; height: 70px; white-space: initial;">
                                    <tr>
                                        <td style="width: 100px;vertical-align: bottom; {{strlen($assessment_disposal_vehicle->plate_no) > 10 ? 'font-size:16px;' :''}}" class="plate-no text-start text-white">{{$assessment_disposal_vehicle->plate_no}}</td>
                                        <td style="{{strlen($assessment_disposal_vehicle->hasAssessmentDetail->department_name) > 30 ? 'font-size:10px;' :''}}" class="department-name text-white text-start ps-2" style="vertical-align: middle;" colspan="2" rowspan="2">
                                            {{$assessment_disposal_vehicle->hasAssessmentDetail->department_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;vertical-align: top;" class="department-dt text-start text-white">{{\Carbon\Carbon::parse($assessment_disposal_vehicle->hasAssessmentDetail->appointment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="assessmentConfirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assessmentConfirmationModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Menilai/Memeriksa Kenderaan
            </div>
            <div class="modal-body">
                <span id="modal_title">Adakah anda ingin menilai/memeriksa </span> bagi no kenderaan: <label for="" class="form-label fs-5" id="selected_plate_no"></label>
            </div>
            <div class="modal-footer float-start">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <span type="button" class="btn btn-module" onclick="generateFormExamination()" >Ya</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assessmentResetConfirmationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assessmentResetConfirmationModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Set semula penilaian/pemeriksaan
            </div>
            <div class="modal-body">
                <span id="modal_title">Adakah anda ingin set semula penilaian/pemeriksaan </span> bagi no kenderaan: <label for="" class="form-label fs-5" id="reset_selected_plate_no"></label>
            </div>
            <div class="modal-footer float-start">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <span type="button" class="btn btn-module" onclick="resetAssessment()" >Ya</button>
            </div>
        </div>
    </div>
</div>

<script>

    let selected_vehicle_id = null;
    let selected_assessment_id = null;
    let assessment_type_code = null;
    let selected_tab = null;

    // Reset assessment
    let reset_assessment_vehicle_id = null;
    let reset_assessment_code = null;

    searching = function(self, mode){
        let value = self.value;
        if(mode == 'clear'){
            value = '';
        }
        $('.job-box, .active-box').each(function(){
        if($(this).text().toUpperCase().indexOf(value.toUpperCase()) != -1){
            $(this).show();
        } else {$(this).hide()}
        });

        updateTotal();
    }

    updateTotal = function(self){

        let assessment_new_total = $('#assessment_new_total');
        assessment_new_total.text(assessment_new_total.parent().parent().find('.job-box:visible').length);

        let assessment_accident_total = $('#assessment_accident_total');
        assessment_accident_total.text(assessment_accident_total.parent().parent().find('.job-box:visible').length);

        let assessment_currvalue_total = $('#assessment_currvalue_total');
        assessment_currvalue_total.text(assessment_currvalue_total.parent().parent().find('.job-box:visible').length);

        let assessment_safety_total = $('#assessment_safety_total');
        assessment_safety_total.text(assessment_safety_total.parent().parent().find('.job-box:visible').length);

        let assessment_gov_loan_total = $('#assessment_gov_loan_total');
        assessment_gov_loan_total.text(assessment_gov_loan_total.parent().parent().find('.job-box:visible').length);

        let assessment_disposal_total = $('#assessment_disposal_total');
        assessment_disposal_total.text(assessment_disposal_total.parent().parent().find('.job-box:visible').length);
    }

    promptFormExamination = function(vehicle_id, assessment_type_code_selected, self, assessment_id, tab){

        let plate_no = $(self).data('plate-no');

        assessment_type_code = assessment_type_code_selected;
        selected_vehicle_id = vehicle_id;
        selected_assessment_id = assessment_id;
        selected_tab = tab;
        console.log(assessment_type_code_selected);
        $('#selected_plate_no').text(plate_no);
        //generateFormExamination();
        $('#assessmentConfirmationModal').modal('show');
    }

    generateFormExamination = function(vehicle_id, assessment_type_code_selected, assessment_id, tab){

        if(vehicle_id){
            selected_vehicle_id = vehicle_id;
        }
        if(assessment_type_code_selected){
            assessment_type_code = assessment_type_code_selected;
        }
        parent.startLoading();

        switch (assessment_type_code) {
            case '01':
                $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
                    assessment_type_code: assessment_type_code,
                    vehicle_id: selected_vehicle_id,
                    '_token': '{{ csrf_token() }}'
                },  function(result){
                    window.location.href = result.url;
                });
                break;
            case '02':
                $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
                    assessment_type_code: assessment_type_code,
                    vehicle_id: selected_vehicle_id,
                    '_token': '{{ csrf_token() }}'
                },  function(result){
                    window.location.href = result.url;
                });
                break;

            case '03':
                $.post("{{route('assessment.accident.foremen')}}", {
                    assessment_accident_id: selected_assessment_id ? selected_assessment_id : assessment_id,
                    assessment_accident_vehicle_id: selected_vehicle_id ? selected_vehicle_id : vehicle_id,
                    tab: selected_tab ? selected_tab : tab,
                    '_token': '{{ csrf_token() }}'
                },  function(result){
                    window.location.href = result.url;
                });
                break;

            case '04':
                $.post("{{route('assessment.vehicle-assessment-currvalue.generateForm')}}", {
                    assessment_type_code: assessment_type_code,
                    vehicle_id: selected_vehicle_id,
                    '_token': '{{ csrf_token() }}'
                },  function(result){
                    window.location.href = result.url;
                });
                break;

            case '05':
                $.post("{{route('assessment.vehicle-assessment-govloan.generateForm')}}", {
                    assessment_type_code: assessment_type_code,
                    vehicle_id: selected_vehicle_id,
                    '_token': '{{ csrf_token() }}'
                },  function(result){
                    window.location.href = result.url;
                });
                break;

            case '06':
                $.post("{{route('assessment.vehicle-assessment.generateForm')}}", {
                    assessment_type_code: assessment_type_code,
                    vehicle_id: selected_vehicle_id,
                    '_token': '{{ csrf_token() }}'
                },  function(result){
                    window.location.href = result.url;
                });
                break;

            default:
                break;
        }
    }

    @if ($session_prev_id)

    prompResetAssessment = function(self){

        let plate_no = $(self).data('plate-no');
        $('#reset_selected_plate_no').text(plate_no);

        reset_assessment_vehicle_id = $(self).data('id');
        reset_assessment_code = $(self).data('assessment-code');
        $('#assessmentResetConfirmationModal').modal('show');
    }

    resetAssessment = function(){
        $.post('{{route('assessment.vehicle.assessment.reset')}}', {
            _token: "{{ csrf_token() }}",
            code: reset_assessment_code,
            id: reset_assessment_vehicle_id,
        }, function(res){
            window.location.reload();
        });
    }

    @endif

    jQuery(document).ready(function() {
        @if (!auth()->user()->detail->hasWorkshop)
            $('#notify').slideDown();
        @endif

        $('input[type=search]').on('search', function () {
            searching(this, 'clear');
        });
    })
</script>
