@php
$TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('03', '02');
@endphp

<form class="row" id="frm_generate_letter" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="generate_letter">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Maklumat 
                            @if($detail->hasStatus->code == '11')
                                Janaan Perihal Kerosakan
                                @else
                                Surat
                            @endif
                        </legend>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="maintenance_evaluation_vehicle_generate_letter">

            </div>
        </div>
    </div>

</form>

@php
    $is_myApp = $detail->created_by == auth()->user()->id ? true: false;
@endphp

@if($is_myApp)
    <div class="float-start">
        <div class="btn-group">
            <button disabled id="btn_proceed_to_mjob" onclick="prompProccedToMJob()" class="btn btn-lg cux-btn bigger">Teruskan penyenggaraan</button>
        </div>
    </div>
@endif

<div class="modal fade" id="maintenanceEvaluationLetterProceedToMJobModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationLetterProceedToMJobModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="frm_del_checklist">
                @csrf
                <div class="modal-content">
                    <div class="modal-body text-center">
                        Adakah anda ingin meneruskan untuk penyenggaraan di JKR?
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary text-white" onclick="proceedToMJob()">Ya</span>
                        <button type="button" id="close" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script type="text/javascript">

    let mjobVLetterids = [];

    const getLetterCurrentChecked = function(){
        mjobVLetterids = [];
        let btnMjob = $('#btn_proceed_to_mjob');
        $('#letter_chkdel:checked').map(function() {
            mjobVLetterids.push(parseInt(this.value));
        });

        if(mjobVLetterids.length > 0){
            btnMjob.prop('disabled', false);
        } else {
            btnMjob.prop('disabled', true);
        }

        return mjobVLetterids;
    }

    const loadMaintenanceEvaluationVehicleGenerateLetter = function() {
        $.get("{{ route('maintenance.evaluation.vehicle-generate-letter.list') }}", function(result){
            $('#maintenance_evaluation_vehicle_generate_letter').html(result);
            init_func_letter_vehicle_list();
        });
    }

    const init_func_letter_vehicle_list = function(){

        $('[name="letter_chkall"]').change(function() {
            $('[name="letter_chkdel"]').prop('checked', $(this).is(':checked'));
            getLetterCurrentChecked();
        });

        $('[name="letter_chkdel"]').change(function() {

            let btnMjob = $('#btn_proceed_to_mjob');

            getLetterCurrentChecked();
            if(mjobVLetterids.length == $('[name="letter_chkdel"]').length){
                $('#letter_chkall').prop('checked', true);
                $('#btnMjob').prop('disabled', true);
            } else {
                $('#letter_chkall').prop('checked', false);
            }
        });

    }

    const prompProccedToMJob = function(){
        $('#maintenanceEvaluationLetterProceedToMJobModal').modal('show');
    }

    const proceedToMJob = function(){
        $.post("{{ route('maintenance.evaluation.vehicle-proceedToMJob') }}", {
            'ids' : mjobVLetterids,
            '_token': '{{ csrf_token() }}'
        }, function(result){
            window.location.href = result.url;
        });
    }

    $(document).ready(function(){
        loadMaintenanceEvaluationVehicleGenerateLetter();

        $('#template_type_id').on('change', function(e){
            e.preventDefault();
            window.location.href = "?template_code="+this.value+"&tab=6";
        })
    })

</script>
