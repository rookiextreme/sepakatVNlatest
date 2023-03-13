
@php
$TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('02', '01');
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

    <div class="col-md-12" id="maintenance_job_vehicle_certificate">

    </div>

</form>

<script type="text/javascript">

    const loadMaintenanceJobVehicleCertificate = function() {
        $.get("{{ route('maintenance.job.vehicle-certificate.list') }}", function(result){
            $('#maintenance_job_vehicle_certificate').html(result);
        });
    }

    $(document).ready(function(){
        loadMaintenanceJobVehicleCertificate();
    })

</script>
