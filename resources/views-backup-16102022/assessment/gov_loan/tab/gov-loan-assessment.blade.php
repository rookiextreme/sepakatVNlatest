
@php
$TaskFlowAccessAssessmentGovLoan = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_vehicle_assessment" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="vehicle_assessment">
    {{-- <fieldset>
        <legend>REKOD BAYARAN</legend>
        <p>Bukti bayaran</p>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6" style="max-width: 170px">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Amaun Perlu Dibayar<span class="text-danger"></span></label>
                    <!--hanya compulsory sekiranya ada amount-->
                    <div class="info">RM 60</div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                <div class="form-group">
                    <label for="" class="form-label text-dark">No Resit <span class="text-danger">*</span></label>
                    <!--hanya compulsory sekiranya ada amount-->
                    <input type="text" class="form-control text-end" name="resit" id="resit" placeholder="" onchange="this.value = this.value.toUpperCase()">
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-6">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Bukti Pembayaran <span class="text-danger">*</span></label>
                    <!--hanya compulsory sekiranya ada amount-->
                    <button class="btn cux-btn bigger" for="doc_voc" style="margin-top:2px"><i class="fas fa-cloud-upload"></i> Muat Naik</button>
                </div>
            </div>
        </div>
    </fieldset> --}}
    <fieldset>
        <legend>MAKLUMAT PENILAIAN</legend>
        <p>Hasil penilaian kenderaan</p>
        <div class="row">
            <div class="col-12" id="assessment_gov_loan_vehicle_assessment"></div>
        </div>
    </fieldset>
    @if($detail->hasStatus->code == '03')
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        <span class="btn btn-module"  onclick="promptSubmitForVerificationModal()">Hantar</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</form>

<div class="modal fade" id="assessmentGovLoanVehicleVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentGovLoanVehicleVerificationModalLabel" aria-hidden="true">
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

    promptSubmitForVerificationModal = function(){
        $('#assessmentGovLoanVehicleVerificationModal').modal('show');
    }

    submitForVerification = function(){
        $.post("{{ route('assessment.gov_loan.verification') }}", {
            '_token': '{{ csrf_token() }}'
        }, function(result){
            window.location.href = result.url;
        });
    }

    loadAssessmentGovLoanVehicleAssessment = function() {
        $.get("{{ route('assessment.gov_loan.vehicle-assessment.list') }}", function(result){
            $('#assessment_gov_loan_vehicle_assessment').html(result);
        });
    }

    $(document).ready(function(){

        @if($detail)
        loadAssessmentGovLoanVehicleAssessment();
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
