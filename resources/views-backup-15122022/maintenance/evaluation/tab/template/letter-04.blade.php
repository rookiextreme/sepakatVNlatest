@php
    $vehicleBrandName = $detail->hasVehicle->hasVehicleBrand ? $detail->hasVehicle->hasVehicleBrand->name : '';
    $vehicleModelName = $detail->hasVehicle->model_name ? $detail->hasVehicle->model_name : '';
    $vehiclePlateNo = $detail->hasVehicle->plate_no;

@endphp

<style>

#letter{{$template_type_code}} tbody tr:hover {
            background-color: transparent;
        }

#letter{{$template_type_code}} td {
    border: none !important;
}

</style>
<div class="table-responsive">
    <table class="table table-borderless" id="letter{{$template_type_code}}" style="width: 100%">
        <tr>
            <td colspan="3">
                <div style="border: 1px solid rgba(0, 0, 0, 0.30);"></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class="float-end" style="width: 400px;">
                    <tr>
                        <td>Ruj. Kami</td><td>:</td><td>
                            @if($is_preview)
                                {{$detail->ref_number}}
                            @else
                                <input onchange="saveElement(this)"  type="text" name="ref_number" id="ref_number" value="{{$detail->ref_number}}">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Tarikh</td><td>:</td><td>
                            @if($is_preview)
                                {{\Carbon\Carbon::parse($detail->date)->format('d F Y')}}
                            @else
                                <input onchange="saveElement(this)" type="text" name="date" id="date" value="{{$detail->date ? \Carbon\Carbon::parse($detail->date)->format('d F Y') : \Carbon\Carbon::now()->format('d F Y')}}">
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {{-- todo govAgencyStaff / jkrStaff for division --}}
                <table class="float-start" style="width:{{$is_preview ? '400px': '100%';}}">
                    <tr>
                        <td>
                            @if($is_preview)
                            <div style="margin-left:-8px">
                            {!! nl2br($detail->address_to) !!}
                            </div>
                            @else
                            <label for="" class="form-label">Butiran Penerima</label>
                            <textarea maxlength="200" onchange="saveElement(this)"  onchange="saveElement(this)"  onchange="saveElement(this)"  onchange="saveElement(this)" style="width: 400px; resize: none;" name="address_to" id="" cols="30" rows="7" class="form-control" placeholder="Butiran Penerima Surat">{{$detail->address_to}}</textarea>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Tuan/Puan,
            </td>
        </tr>
        <tr>
            <td colspan="3" class="form-label fs-5" style="line-height: 21px">
                PEMERIKSAAN DAN PENILAIAN KEROSAKAN KENDERAAN JABATAN JENIS {{$vehicleBrandName}} {{$vehicleModelName}} NO. PENDAFTARAN : {{$vehiclePlateNo}}
                <div style="border: 1px solid rgb(71, 71, 71);"></div>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="" style="line-height: 21px">
                Dengan segala hormatnya, kami merujuk perkara di atas.
            </td>
        </tr>

        <tr>
            <td colspan="3" class="" style="line-height: 21px">
                2. Untuk makluman pihak tuan, pihak kami telah melaksanakan pemeriksaan ke atas kenderaan berkenaan di
                @if($is_preview)
                    {{$detail->placement_name}}
                @else
                    <input onchange="saveElement(this)" style= "width:200px" type="text" placeholder="Sila isi nama Woksyop" name="placement_name" id="placement_name" value="{{$detail->placement_name}}">
                @endif
                pada
                <label>
                    <div class="">
                    @if($is_preview)
                        <div class="text-dark">{{$detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt)->format('d F Y') : ''}}</div>
                    @else
                        <div class="input-group date form_datetime" id="appointmentDtContainer" data-date-format="dd MM yyyy" data-link-field="appointment_dt">
                            <input class="form-control" size="16" id="appointmentDt_input" type="text"
                            value="{{$detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('d F Y') : ''}}"
                            placeholder="Sila Pilih Tarikh" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <label class="input-group-text">
                                <i class="fal fa-calendar-alt"></i>
                            </label>
                        </div>
                        <input type="hidden" name="appointment_dt" id="appointment_dt" value="{{$detail->appointment_dt ? Carbon\Carbon::parse($detail->appointment_dt )->format('Y-m-d') : ''}}" />
                    @endif
                    </div>
                </label> dan bersetuju dengan kerja-kerja yang dicadang oleh
                @if($is_preview)
                    {{$detail->body_detail}}
                @else
                    <input onchange="saveElement(this)" placeholder="Sila isi cadangan pihak" style= "width:200px" type="text" name="body_detail" id="body_detail" value="{{$detail->body_detail}}">
                @endif.
            </td>
        </tr>

        @php
            $totalBudget = $detail->total_budget;
        @endphp

        @php
            $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
        @endphp
        <tr>
            <td colspan="3" class="" style="line-height: 21px">
                3. Merujuk sebutharga dilampir, penggantian alat ganti OEM adalah tidak digalakkan. Pihak JKR hanya mengesyorkan penggunaan alat ganti TULEN untuk dipasang pada kenderaan kerajaan.
                Bagaimanapun, pihak kami tidak mengeluarkan anggaran atau mengesahkan kos pembaikan bagi kerja-kerja tersebut.
            </td>
        </tr>

        <tr>
            <td colspan="3">
                4. Sekiranya ingin penjelasan lanjut mengenai perkara ini,
                pihak tuan boleh menghubungi pegawai kami
                @if($is_preview)
                    {{$detail->officer_name}}
                @else
                    <input onchange="saveElement(this)" style= "width:200px" type="text" name="officer_name" id="officer_name" value="{{$detail->officer_name}}">
                @endif di talian
                @if($is_preview)
                    {{$detail->officer_phone}}
                @else
                    <input onchange="saveElement(this)" style= "width:200px" type="text" name="officer_phone" id="officer_phone" value="{{$detail->officer_phone}}">
                @endif
                .
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Sekian. Terima Kasih<br/><br/>

                @if($is_preview)
                <div>
                    {!! nl2br($detail->signature_quote) !!}
                </div>
                @else
                <label for="" class="form-label">Slogan</label>
                <textarea onchange="saveElement(this)"  onchange="saveElement(this)"  onchange="saveElement(this)"  onchange="saveElement(this)" style="width: 300px; resize: none;" name="signature_quote" id="" cols="30" rows="3" class="form-control" placeholder="PRIHATIN RAKYAT: DARURAT MEMERANGI COVID-19">{{$detail->signature_quote}}</textarea>
                @endif

                <br/>

                <label for="" class="mt-2">Saya yang menjalankan amanah,</label><br/><br/>

                {{-- <div class="mt-5" style="width: 200px; border-bottom: 1px solid black;"></div> --}}
                <br/>
                    @if($is_preview)
                    <div class="row">
                        {{-- <div class="col-2" style="width:30px">b.p</div>  --}}
                        <div class="col-10">
                        {!! nl2br($detail->officer_designation) !!}
                        </div>
                    </div>
                    @else
                    {{-- <div class="d-inline">b.p</div>  --}}
                    <textarea onchange="saveElement(this)"  onchange="saveElement(this)"  onchange="saveElement(this)"  onchange="saveElement(this)" style="width: 300px; resize: none;" name="officer_designation" id="" cols="30" rows="4" class="form-control" placeholder="Ketua Jurutera Mekanikal&#10JKR Woksyop Persekutuan">{{$detail->officer_designation}}</textarea>
                    @endif<br/>
            </td>
        </tr>

    </table>
</div>

<script type="text/javascript">

    let letter_check_id = null;

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

    const addCheckList = function(){
        letter_check_id = null;
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
            template_type_id : {{$template_type_id}},
            vehicle_id: {{$vehicle_id}}
        } , function(result){
            console.log(result);
            $('#total_budget').text(result.detail.total_budget_with_format);
            $('#total_budget_with_word').text(result.detail.total_budget_with_word);
        });
    }

    const loadMaintenanceEvaluationVehicleLetterChecklist = function() {
        $.get("{{ route('maintenance.evaluation.vehicle-maintenance.letter.checklist.list') }}", {
            evaluation_template_letter_id: {{$template_type_code}},
            is_preview: {{$is_preview}}
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
            evaluation_template_letter_id: {{$template_type_code}}
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
