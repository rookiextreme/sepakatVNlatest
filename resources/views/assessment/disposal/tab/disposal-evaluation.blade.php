
@php
$TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
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
            <div class="col-md-12" id="assessment_disposal_vehicle_evaluation">

            </div>
        </div>
    </div>
    @if($detail->hasStatus->code == '04')
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        {{-- <span class="btn btn-module" onclick="prompAssessmentDisposalEvaluateModal()">Hantar</span> --}}
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentNewRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    @endif

</form>

<div class="modal fade" id="assessmentDisposalEvaluationModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentDisposalEvaluationModalLabel" aria-hidden="true">
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

    prompAssessmentDisposalEvaluateModal = function(){
        $('#assessmentDisposalEvaluationModal').modal('show');
    }

    loadAssessmentDisposalVehicleEvaluation = function() {
        $.get("{{ route('assessment.disposal.vehicle-evaluation.list') }}", function(result){
            $('#assessment_disposal_vehicle_evaluation').html(result);
        });
    }

    assessmentVehicleEvaluate = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.disposal.approval')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    // assessmentVehicleReject = function(){
    //     $.post('{{route('assessment.disposal.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }

    $(document).ready(function(){
        loadAssessmentDisposalVehicleEvaluation();
    })

</script>
