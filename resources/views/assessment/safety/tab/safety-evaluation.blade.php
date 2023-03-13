
@php
$TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
$status_code = Request('status_code') ? Request('status_code') : 'all_inprogress';

@endphp

<form class="row" id="frm_approval" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="approval">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Maklumat Semakan</legend>
                        <p>Sila Semak terlebih dahulu.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="assessment_safety_vehicle_evaluation">

            </div>
        </div>
    </div>
    @if($detail->hasStatus->code == '04')
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        {{-- <span class="btn btn-module" onclick="prompAssessmentSafetyEvaluateModal()">Hantar</span> --}}
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentNewRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    @endif

</form>

<div class="modal fade" id="assessmentSafetyEvaluationModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentSafetyEvaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin meneruskan untuk pengesahan?
                </p>
            </div>
            <div class="modal-footer float-start">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-secondary text-white" onclick="assessmentVehicleEvaluate(this)">Ya</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    prompAssessmentSafetyEvaluateModal = function(){
        $('#assessmentSafetyEvaluationModal').modal('show');
    }

    loadAssessmentSafetyVehicleEvaluation = function() {
        let data = {
            'status_code': '{{$status_code}}'
        };
        $.get("{{ route('assessment.safety.vehicle-evaluation.list') }}", data, function(result){
            $('#assessment_safety_vehicle_evaluation').html(result);
        });
    }
    

    assessmentVehicleEvaluate = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.safety.approval')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    // assessmentVehicleReject = function(){
    //     $.post('{{route('assessment.safety.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }

    $(document).ready(function(){
        loadAssessmentSafetyVehicleEvaluation();
    })

</script>
