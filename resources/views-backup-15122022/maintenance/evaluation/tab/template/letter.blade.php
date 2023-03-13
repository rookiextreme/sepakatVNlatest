@php
    // $vehicleBrandName = $detail->hasVehicle->hasVehicleBrand ? $detail->hasVehicle->hasVehicleBrand->name : '';
    // $vehicleModelName = $detail->hasVehicle->model_name ? $detail->hasVehicle->model_name : '';
    // $vehiclePlateNo = $detail->hasVehicle->plate_no;

@endphp

<style>

textarea.form-control {
    height: inherit !important;
}

</style>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <legend>
               Perihal Pemeriksaan 
            </legend>
            <p></p>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-borderless" id="letter" style="width: 100%">
        <tr>
            <td colspan="3" class="">
                <div class="form-group">
                    <span class="btn cux-btn small" onclick="addCheckList(this)"> <i class="fa fa-plus"></i> Tambah</span>
                </div>
                <div id="maintenance_evaluation_letter_checklist"></div>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">

    let letter_check_id = null;
    let template_type_id = null;
    let vehicle_id = null;

    @if ($template_type_id)
        template_type_id = {{$template_type_id}};
    @endif

    @if ($vehicle_id)
        vehicle_id = {{$vehicle_id}};
    @endif

    const saveElement = function(self){

        let fieldName  = $(self).attr('name');
        let fieldValue  = $(self).val();
        let _token = "{{ csrf_token() }}";

        console.log('fieldName  => ', fieldName);
        console.log('fieldValue  => ', fieldValue);

        $.post('{{ route('maintenance.evaluation.ajax.vehicle-maintenance.letter.field.save')}}', {
            '_token':_token,
            'field': fieldName,
            'value': fieldValue
        }, function(res){
            console.log(res);
        });

    }

    const addCheckList = function(self){
        letter_check_id = null;
        $('#maintenanceEvaluationAddCheckListModal #frm_add_checklist')[0].reset();
        $('#maintenanceEvaluationAddCheckListModal').modal('show');
    }

    const editLetterCheck = function(self){
        letter_check_id = $(self).attr('data-id');
        $('#job_detail').val($(self).attr('data-job-detail'));
        $('#syntom').val($(self).attr('data-syntom'));
        $('#accessories').val($(self).attr('data-accessories'));
        $('#budget').val($(self).attr('data-budget'));
        $('#maintenanceEvaluationAddCheckListModal').modal('show');
    }

    const delLetterCheck = function(self){
        letter_check_id = $(self).attr('data-id');
        $('#maintenanceEvaluationDelCheckListModal').modal('show');
    }

    const updateLetter = function () {
        $.get("{{ route('maintenance.evaluation.ajax.vehicle-maintenance.letter')}}", {
            // template_type_id : template_type_id,
            vehicle_id: vehicle_id
        } , function(result){
            console.log(result);
            console.log($('#appointmentDt_input').val());
            $('#total_budget').text(result.detail.total_budget_with_format);
            $('#total_budget_with_word').text(result.detail.total_budget_with_word);
        });
    }

    const loadMaintenanceEvaluationVehicleLetterChecklist = function() {
        $.get("{{ route('maintenance.evaluation.vehicle-maintenance.letter.checklist.list') }}", {
            evaluation_template_letter_id: {{$detail->id}},
            vehicle_id: vehicle_id
        }, function(result){
            $('#maintenance_evaluation_letter_checklist').html(result);
        });
    }

    const submitChecklist = function(formData){
        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle-maintenance.letter.checklist.save') }}",
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                loadMaintenanceEvaluationVehicleLetterChecklist();
                updateLetter();
                $('#maintenanceEvaluationAddCheckListModal').modal('hide');
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                $.each(errors, function(key, value) {
                });
            }
        });
    }

    const deleteChecklist = function(formData){
        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle-maintenance.letter.checklist.delete') }}",
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                loadMaintenanceEvaluationVehicleLetterChecklist();
                $('#maintenanceEvaluationDelCheckListModal').modal('hide');
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                $.each(errors, function(key, value) {
                });
            }
        });
    }

    const ajaxLoadMaintenanceEvalTemplateLetterPage = function(url){
        parent.startLoading();
        $.get(url, {
            evaluation_template_letter_id: {{$detail->id}}
        }, function(data){
            $('#maintenance_evaluation_letter_checklist').html(data);
            parent.stopLoading();
        });
    }

    $(document).ready(function(){
        loadMaintenanceEvaluationVehicleLetterChecklist();

        let app_dt_1_container = $('#appointmentDtContainer').datepicker(
            {
                autoclose: 1,
                todayHighlight: 1
            }
        );

        app_dt_1_container.on('changeDate', function(e){
            let val = $(this).datepicker('getDate');
            if(val){
                currentAppDt1 = new moment(val).format('YYYY-MM-DD');
                $('#appointment_dt').val(currentAppDt1);
            }
        });

        $('#frm_add_checklist').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            if(letter_check_id){
                formData.append('id', letter_check_id);
            }
            submitChecklist(formData);
        });

        $('#frm_del_checklist').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            if(letter_check_id){
                formData.append('id', letter_check_id);
            }
            deleteChecklist(formData);
        });
    });

</script>
