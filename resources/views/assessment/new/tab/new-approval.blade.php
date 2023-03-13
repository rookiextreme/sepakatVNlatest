
@php
$TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
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
                        <legend>Maklumat Kelulusan</legend>
                        <p>Sila Semak terlebih dahulu sebelum membuat pengesahan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="assessment_new_vehicle_approval">

            </div>
        </div>
    </div>
    {{-- @if($detail->hasStatus->code == '05') --}}
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center">
                        {{-- <span class="btn btn-module" onclick="prompAssessmentNewApproveModal()">Muktamad</span> --}}
                        {{-- <button type="submit" class="btn btn-module">Muktamad</button> --}}
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentNewRevokeModal()">Tolak</a> --}}
                    </div>
                </div>
            </div>
        </div>
    {{-- @endif --}}

</form>

{{-- <div class="modal fade" id="assessmentNewApproveModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentNewApproveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin mengesahkan maklumat ini?
                </p>
            </div>
            <div class="modal-footer float-start">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-secondary text-white" onclick="assessmentVehicleApprove(this)">Ya</button>
            </div>
        </div>
    </div>
</div> --}}

<script type="text/javascript">

    prompAssessmentNewApproveModal = function(){
        $('#assessmentNewApproveModal').modal('show');
    }

    loadAssessmentNewVehicleApproval = function() {
        let data = {
            'status_code': '{{$status_code}}',
        };
        $.get("{{ route('assessment.new.vehicle-approval.list') }}", data, function(result){
            $('#assessment_new_vehicle_approval').html(result);
        });
    }
    
    assessmentVehicleApprove = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.new.approve')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    // assessmentVehicleReject = function(){
    //     $.post('{{route('assessment.new.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }

    formApprovalEngineer =  function(data){
        $.ajax({
            url: "{{ route('assessment.new.approval') }}",
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
        loadAssessmentNewVehicleApproval();

        $('#frm_approval').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            formApprovalEngineer(formData);
        });
    })

</script>
