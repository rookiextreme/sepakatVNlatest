
@php
$TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
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
            <div class="col-md-12" id="assessment_safety_vehicle_approval">

            </div>
        </div>
    </div>
    {{-- @if($detail->hasStatus->code == '05') --}}
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        {{-- <span class="btn btn-module" onclick="prompassessmentSafetyApproveModal()">Hantar</span> --}}
                        {{-- <span id="muktamad-button" style="display:none;"> --}}
                            {{-- <button type="button" class="btn btn-module" data-bs-toggle="modal" data-bs-target="#assessmentSafetyApproveModal">Muktamad</button> --}}
                        {{-- </span> --}}
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentNewRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    {{-- @endif --}}

</form>
<div class="modal fade modal-asking" id="assessmentSafetyApproveModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assessmentSafetyApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top:12vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
        <div class="modal-content awas" style="height:250px;background-image: url({{asset('my-assets/img/awas.png')}});">
            <div class="modal-body pt-5" id="prompt-container">
                <div class="asking">
                        Selesaikan penilaian untuk kenderaan ini?<br/>
                        <small style="line-height:14px;margin-top:5px">Dengan selesainya penilaian ini,<br/>sijil boleh dikeluarkan untuk kenderaan ini.</small>
                </div>
            </div>
            <div class="modal-footer justify-content-start">
                <button type="submit" class="btn btn-secondary text-white" form="frm_approval">Ya</button>
                <span class="btn btn-reset" data-bs-dismiss="modal">Batal</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    prompassessmentSafetyApproveModal = function(){
        $('#assessmentSafetyApproveModal').modal('show');
    }

    loadAssessmentSafetyVehicleApproval = function() {
        $.get("{{ route('assessment.safety.vehicle-approval.list') }}", function(result){
            $('#assessment_safety_vehicle_approval').html(result);
        });
    }

    assessmentVehicleApprove = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.safety.approve')}}', {
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

    formApprovalEngineer =  function(data){
        parent.startLoading();
        $.ajax({
            url: "{{ route('assessment.safety.approval') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_apppointment_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                window.location.href = response.url;
                parent.stopLoading();
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
        loadAssessmentSafetyVehicleApproval();

        $('#frm_approval').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formApprovalEngineer(formData);
        });

        $('#v_status_code').on('change', function(e){
            e.preventDefault();
            console.log('here');
            var muktamad_button = $('#muktamad-button');
            muktamad_button.show();
        })
    })

</script>
