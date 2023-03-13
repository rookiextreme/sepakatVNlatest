
@php
$TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_cerificate" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="generate_certificate">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Maklumat Sijil</legend>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="assessment_disposal_vehicle_certificate">

    </div>

</form>

<script type="text/javascript">

    loadAssessmentDisposalVehicleCertificate = function() {
        $.get("{{ route('assessment.disposal.vehicle-certificate.list') }}", function(result){
            $('#assessment_disposal_vehicle_certificate').html(result);
        });
    }

    $(document).ready(function(){
        loadAssessmentDisposalVehicleCertificate();
    })

</script>
