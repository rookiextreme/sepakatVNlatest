
@php
$TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_approval" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="approval">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Maklumat Kelulusan</legend>
                        <p>Sila Semak terlebih dahulu sebelum membuat pengesahan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="maintenance_evaluation_vehicle_approval">

            </div>
        </div>
    </div>
    @if($detail->hasStatus->code == '05')
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        <span class="btn btn-module" onclick="prompmaintenanceEvaluationApproveModal()">Hantar</span>
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentNewRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    @endif

</form>

<div class="modal fade" id="maintenanceEvaluationApproveModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="maintenanceEvaluationApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin mengesahkan maklumat ini?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-secondary text-white" onclick="maintenanceVehicleApprove(this)">Ya</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    const prompmaintenanceEvaluationApproveModal = function(){
        $('#maintenanceEvaluationApproveModal').modal('show');
    }

    const loadMaintenanceEvaluationVehicleApproval = function() {
        $.get("{{ route('maintenance.evaluation.vehicle-approval.list') }}", function(result){
            $('#maintenance_evaluation_vehicle_approval').html(result);
        });
    }

    const maintenanceVehicleApprove = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('maintenance.evaluation.approve')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    // const assessmentVehicleReject = function(){
    //     $.post('{{route('maintenance.evaluation.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }

    $(document).ready(function(){
        loadMaintenanceEvaluationVehicleApproval();
    })

</script>
