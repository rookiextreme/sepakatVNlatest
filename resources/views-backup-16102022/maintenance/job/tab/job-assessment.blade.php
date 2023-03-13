
@php
$TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_vehicle_assessment" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="vehicle_assessment">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>MAKLUMAT PENILAIAN</legend>
                        <p>Maklumat kenderaan atau aset untuk penilaian</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="maintenance_job_vehicle_assessment">

            </div>
        </div>
    </div>

    {{-- @if($detail->hasStatus->code == '03' && (auth()->user()->isAdmin() || auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance() || auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance()))
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        <span class="btn btn-module"  onclick="promptSubmitForVerificationModal()">Hantar</span>
                    </div>
                </div>
            </div>
        </div>
    @endif --}}
</form>

<div class="modal fade" id="maintenanceJobVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="maintenanceJobVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin menghantar untuk semakan maklumat ini?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <span id="verification" class="btn btn-primary text-white" onclick="submitForVerification()">Ya</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    const promptSubmitForVerificationModal = function(){
        $('#maintenanceJobVerificationModal').modal('show');
    }

    const submitForVerification = function(){
        $.post("{{ route('maintenance.job.verification') }}", {
            '_token': '{{ csrf_token() }}'
        }, function(result){
            window.location.href = result.url;
        });
    }

    const loadMaintenanceJobVehicleAssessment = function() {
        $.get("{{ route('maintenance.job.vehicle-assessment.list') }}", function(result){
            $('#maintenance_job_vehicle_assessment').html(result);
        });
    }

    $(document).ready(function(){

        @if($detail)
        loadMaintenanceJobVehicleAssessment();
        @endif

        $('.item').on('click', function(e){

            let hasDisable = $(this).hasClass('disabled');
            let hash = this.hash;

            currentOffset = $(hash).offset().top;
            console.log('currentOffset ', currentOffset);

            if(!hasDisable){
                if (hash !== "") {
                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                // console.log($(hash).offset().top);
                // $('.scrollable-vertical').animate({
                //     scrollTop: $(hash).offset().top
                // }, 500, function(){

                //     // Add hash (#) to URL when done scrolling (default click behavior)
                //     // window.location.hash = hash;
                // });

                selectHash(this);

                }
            }

            setTimeout(() => {
                let body = $("body,html");
                body.stop().animate({scrollTop:0}, 300, 'swing', function() {
                // alert("Finished animating");
                });
            }, 300);
        });

    })

</script>
