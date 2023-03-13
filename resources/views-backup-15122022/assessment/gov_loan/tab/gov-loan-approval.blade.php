
@php
$TaskFlowAccessAssessmentGovLoan = auth()->user()->vehicleWorkFlow('02', '01');
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
            <div class="col-md-12" id="assessment_gov_loan_vehicle_approval">

            </div>
        </div>
    </div>
    {{-- @if($detail->hasStatus->code == '05') --}}
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        {{-- <span class="btn btn-module" onclick="prompAssessmentGovLoanApproveModal()">Hantar</span> --}}
                        {{-- <button type="submit" class="btn btn-module">Muktamad</button> --}}
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentGovLoanRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    {{-- @endif --}}

</form>

{{-- <div class="modal fade" id="assessmentGovLoanApproveModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentGovLoanApproveModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-secondary text-white" onclick="assessmentVehicleApprove(this)">Ya</button>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade modal-asking" id="assessmentGovLoanApproveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assessmentGovLoanApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="row" id="frm_examination">
            @csrf
            <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-body pt-5">
                    <div class="asking">
                        Hantar hasil penilaian<br/>kepada Jurutera untuk kelulusan?
                    </div>
                    <input type="hidden" name="section" value="examination">
                </div>
                <div class="modal-footer justify-content-start">
                    <button class="btn btn-module" type="button" onclick="assessmentVehicleApprove(this)">Ya</button>
                    <button type="button" class="btn btn-link" id="close" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    prompAssessmentGovLoanApproveModal = function(){
        $('#assessmentGovLoanApproveModal').modal('show');
    }

    loadAssessmentGovLoanVehicleApproval = function() {
        $.get("{{ route('assessment.gov_loan.vehicle-approval.list') }}", function(result){
            $('#assessment_gov_loan_vehicle_approval').html(result);
        });
    }

    assessmentVehicleApprove = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.gov_loan.approve')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    // assessmentVehicleReject = function(){
    //     $.post('{{route('assessment.gov_loan.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }

    formApprovalEngineer =  function(data){
        $.ajax({
            url: "{{ route('assessment.gov_loan.approval') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_apppointment_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                window.location.href = response['url'];
                // loadAssessmentNewVehicleAppointment();
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
        loadAssessmentGovLoanVehicleApproval();

        $('#frm_approval').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formApprovalEngineer(formData);
        });
    })

</script>
