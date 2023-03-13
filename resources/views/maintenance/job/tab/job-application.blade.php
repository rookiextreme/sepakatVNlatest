
@php
    $is_repair_required = true;
    $is_service_required = false;

    // if($detail){
    //     foreach ($detail->hasVehicle as $index => $vehicle) {
    //         if($vehicle->hasRepair()){
    //             $is_repair_required = true;
    //         }
    //         if($vehicle->hasService()){
    //             $is_service_required = true;
    //         }
    //     }
    // }

@endphp
@if(env('APP_ENV') == 'local')
    @if($detail)
        {{-- @json($detail) --}}
        {{-- {{$is_repair_required}}
        {{$is_service_required}} --}}
    @endif
@endif

<form class="row" id="frm_application" enctype="multipart/form-data">

    @csrf

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    @if($detail && $detail->hasStatus->code == '02')
            {{-- Penolong jurutera / jurutera boleh lihat --}}
            @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance() || auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
            <fieldset>
                <legend>Tetapan Tugas</legend>
                <div class="row">
                    <div class="col-md-4">
                        <label for="" class="form-label">Tukar Woksyop <em class="text-danger">*</em></label>
                        @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                        <div class="input-group">
                            <select class="form-control form-select" id="change_workshop_id" name="change_workshop_id">
                                <option selected value="">Sila Pilih</option>
                                @foreach ($workshop_list as $workshop)
                                    <option {{$detail && $detail->hasEngineerWorkShop && $detail->hasEngineerWorkShop->id == $workshop->id ? 'selected'  : ($detail->hasWorkShop->id == $workshop->id ? 'selected':'' )}} value="{{$workshop->id}}">{{$workshop->desc}}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        {{$detail && $detail->hasEngineerWorkShop ? $detail->hasEngineerWorkShop->desc : ''}}
                        @endif
                    </div>
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Tetapan Penolong Jurutera</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Penolong Jurutera @if($is_repair_required) <em class="text-danger">*</em> @endif</label>
                                    {{-- <label for="" class="form-label">Penolong Jurutera <em class="text-danger">*</em></label> --}}
                                     {{--jurutera boleh assign --}}
                                    @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                                        <select class="form-control form-select" name="assist_engineer_repair_id" id="assist_engineer_repair_id">
                                            <option value="">Sila Pilih</option>
                                            @foreach ($assist_engineer_list as $assist_engineer)
                                                <option {{$detail->hasAssistantEngineerRepairBy && $detail->hasAssistantEngineerRepairBy->id == $assist_engineer->id ? 'selected' : ''}} value="{{$assist_engineer->id}}">{{$assist_engineer->name}}
                                                    @if(env('APP_ENV') == 'local')
                                                        - ({{$assist_engineer->detail->hasWorkshop->desc}})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="hasErr"></label>
                                        @else
                                        {{$detail->hasAssistantEngineerRepairBy ? $detail->hasAssistantEngineerRepairBy->name : 'Menunggu tetapan dari jurutera'}}
                                    @endif
                                </div>
                                {{--  <div class="col-md-4">
                                    <label for="" class="form-label">Penolong Jurutera (Servis) @if($is_service_required) <em class="text-danger">*</em> @endif </label>
                                    @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                                        <select class="form-control form-select" name="assist_engineer_service_id" id="assist_engineer_service_id">
                                            <option value="">Sila Pilih</option>
                                            @foreach ($assist_engineer_list as $assist_engineer)
                                                <option {{$detail->hasAssistantEngineerServiceBy && $detail->hasAssistantEngineerServiceBy->id == $assist_engineer->id ? 'selected' : ''}} value="{{$assist_engineer->id}}">{{$assist_engineer->name}}
                                                    @if(env('APP_ENV') == 'local')
                                                        - ({{$assist_engineer->detail->hasWorkshop->desc}})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="hasErr"></label>
                                        @else
                                        {{$detail->hasAssistantEngineerServiceBy ? $detail->hasAssistantEngineerServiceBy->name : 'Menunggu tetapan dari jurutera'}}
                                    @endif
                                </div>  --}}
                                @if(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                                    <div class="col-md-4 d-flex align-self-center flex-wrap mb-1">
                                        <button type="button" class="btn cux-btn bigger" onclick="prompAssignAssistantEngineer(this)"> Simpan </button>
                                    </div>
                                @endif
                            </div>
                        </fieldset>
                    </div>
                </div>
            </fieldset>
            @endif
        @endif
    <fieldset>
        <legend>Pemohon</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5">
                <label for="" class="form-label text-dark">Nama Pemohon<span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <input type="text" name="applicant_name" id="applicant_name" class="form-control" autocomplete="off"
                    onkeyup="this.value = this.value.toUpperCase()"
                    value="{{$detail ? $detail->applicant_name : strtoupper(auth()->user()->name)}}">
                @else
                    <div class="">{{$detail ? $detail->applicant_name : strtoupper(auth()->user()->name)}}</div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3">
                <label for="" class="form-label  text-dark">No Telefon<span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <input type="text" name="phone_no" id="phone_no" class="form-control" autocomplete="off"
                    value="{{$detail ? $detail->phone_no : auth()->user()->detail->telbimbit}}"
                    onkeyup="this.value = !isNaN(this.value) ? this.value : ''; ">
                @else
                    <div class="">{{$detail ? $detail->phone_no : auth()->user()->detail->telbimbit}}</div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4 col-sm-4">
                <label for="" class="form-label  text-dark">Emel <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <input type="text" name="email" id="email" class="form-control" autocomplete="off"
                    value="{{$detail ? $detail->email : auth()->user()->email}}">
                @else
                    <div class="">{{$detail ? $detail->email : auth()->user()->email}}</div>
                @endif
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Servis & Pembaikan</legend>
        <div class="row">
            @if($detail)
                <div class="col-12">
                    <label for="" class="form-label text-dark">No Rujukan <span class=""></span></label>
                    <div>
                        {{$detail->ref_number ? : null}}
                    </div>
                </div>
            @endif
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Woksyop Pilihan <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <select class="form-control form-select" id="" name="applicant_workshop_id">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($workshop_list as $workshop)
                                <option {{$detail && $detail->hasApplicantWorkShop && $detail->hasApplicantWorkShop->id == $workshop->id ? 'selected'  : ((!$detail || !$detail->hasApplicantWorkShop) && auth()->user()->detail->workshop_id == $workshop->id ? 'selected':'' )}} value="{{$workshop->id}}">{{$workshop->desc}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="">{{$detail && $detail->hasApplicantWorkShop ? $detail->hasApplicantWorkShop->desc : null}}</div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label class="form-label text-dark">Cadangan Tarikh & Masa Temujanji <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-md-12">

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group date form_datetime" id="date1Container" data-date="{{$detail && $detail->appointment_dt1 ? $detail->appointment_dt1 : ''}}" data-date-format="dd MM yyyy - H:ii P" data-link-field="date_1">
                                <input readonly class="form-control" size="16" id="date_1_input" type="text"
                                value="{{$detail && $detail->appointment_dt1 ? Carbon\Carbon::parse($detail->appointment_dt1 )->format('d F Y - g:i A') : ''}}"
                                placeholder="Pilihan 1" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <label class="input-group-addon input-group-text" for="date_1_input">
                                    <i class="fal fa-calendar-alt"></i>
                                </label>
                            </div>
                            <input type="hidden" name="date_1"  value="{{$detail && $detail->appointment_dt1 ? Carbon\Carbon::parse($detail->appointment_dt1 )->format('d F Y - g:i A') : ''}}" />
                        @else
                            <div class="">{{$detail && $detail->appointment_dt1 ? Carbon\Carbon::parse($detail->appointment_dt1 )->format('d F Y - g:i A') : ''}}</div>
                        @endif

                    </div>
                    <div class="col-md-12">

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group date form_datetime" id="date2Container" data-date="{{$detail && $detail->appointment_dt2 ? $detail->appointment_dt2 : ''}}" data-date-format="dd MM yyyy - H:ii P" data-link-field="date_2">
                                <input readonly class="form-control" size="16" id="date_2_input" type="text"
                                value="{{$detail && $detail->appointment_dt2 ? Carbon\Carbon::parse($detail->appointment_dt2 )->format('d F Y - g:i A') : ''}}"
                                placeholder="Pilihan 2" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <label class="input-group-text" for="date_2_input">
                                    <i class="fal fa-calendar-alt"></i>
                                </label>
                            </div>
                            <input type="hidden" name="date_2"  value="{{$detail && $detail->appointment_dt2 ? Carbon\Carbon::parse($detail->appointment_dt2 )->format('d F Y - g:i A') : ''}}" />
                        @else
                            <div class="">{{$detail && $detail->appointment_dt2 ? Carbon\Carbon::parse($detail->appointment_dt2 )->format('d F Y - g:i A') : ''}}</div>
                        @endif
                    </div>
                    <div class="col-md-12">

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group date form_datetime" id="date3Container" data-date="{{$detail && $detail->appointment_dt3 ? $detail->appointment_dt3 : ''}}" data-date-format="dd MM yyyy - H:ii P" data-link-field="date_3">
                                <input readonly class="form-control" size="16" id="date_3_input" type="text"
                                value="{{$detail && $detail->appointment_dt3 ? Carbon\Carbon::parse($detail->appointment_dt3 )->format('d F Y - g:i A') : ''}}"
                                placeholder="Pilihan 3" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                <label class="input-group-text" for="date_3_input">
                                    <i class="fal fa-calendar-alt"></i>
                                </label>
                            </div>
                            <input type="hidden" name="date_3"  value="{{$detail && $detail->appointment_dt3 ? Carbon\Carbon::parse($detail->appointment_dt3 )->format('d F Y - g:i A') : ''}}" />
                        @else
                            <div class="">{{$detail && $detail->appointment_dt3 ? Carbon\Carbon::parse($detail->appointment_dt3 )->format('d F Y - g:i A') : ''}}</div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <label name="app_dates">
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Pemilikan</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Kementerian  <span class="text-danger">*</span></label>
                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <select class="form-control form-select" id="agency_id" name="agency_id" >
                            <option selected value="">Sila Pilih</option>
                            @foreach ($agency_list as $agency)
                                <option {{$detail && $detail->hasAgency && $detail->hasAgency->id == $agency->id ? 'selected'  : ''}} value="{{$agency->id}}">{{$agency->desc}}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <div class="">{{$detail && $detail->hasAgency ? $detail->hasAgency->desc : null}}</div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Jabatan / Agensi <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <input type="text" class="form-control" id="department_name" name="department_name" onkeyup="this.value = this.value.toUpperCase()" value="{{$detail ? $detail->department_name : null}}">
                    </div>
                @else
                    <div class="">{{$detail ? $detail->department_name : null}}</div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <label for="" class="form-label text-dark">Ketua Jabatan (Gelaran) <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <input type="text" class="form-control" id="hod_name" name="hod_name" onkeyup="this.value = this.value.toUpperCase()" value="{{$detail ? $detail->hod_name : null}}" placeholder="Pegarah/Ketua Pegarah/Ketua Jabatan/dll">
                    </div>
                @else
                    <div class="">{{$detail ? $detail->hod_name : null}}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                <label for="" class="form-label text-dark">Alamat  <span class="text-danger">*</span></label>

                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                    <div class="input-group">
                        <textarea style="resize: none;" class="form-control" name="address" id="address" onkeyup="this.value = this.value.toUpperCase()" cols="30" rows="3">{{$detail ? $detail->address : null}}</textarea>
                    </div>
                @else
                    <div class="">{{$detail ? $detail->address : null}}</div>
                @endif
            </div>
            <div class="col-xl-6 col-lg-6 col-md-7 col-sm-6">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                        <label for="" class="form-label text-dark">Poskod <span class="text-danger">*</span></label>

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group">
                                <input type="text" class="form-control" id="postcode" onkeyup="this.value = !isNaN(this.value) ? this.value : ''; " name="postcode" value="{{$detail ? $detail->postcode : null}}">
                            </div>
                        @else
                            <div class="">{{$detail ? $detail->postcode : null}}</div>
                        @endif
                    </div>
                    <div class="col-xl-5 col-lg-7 col-md-6 col-sm-12">
                        <label for="" class="form-label text-dark">Negeri <span class="text-danger">*</span></label>

                        @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                            <div class="input-group">
                                <select class="form-control form-select" id="state_id" name="state_id" >
                                    <option value="">Sila Pilih</option>
                                    @foreach ($state_list as $state)
                                        <option {{$detail && $detail->state_id  == $state->id ? 'selected'  : (auth()->user()->detail->state_id == $state->id ? 'selected':'' )}} value="{{$state->id}}">{{$state->desc}}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" class="form-control" name="state_id" id="state_id" value="{{$detail ? $detail->state_id : null}}"> --}}
                            </div>
                        @else
                            <div class="">
                                @foreach ($state_list as $state)
                                    {{$detail && $detail->state_id  == $state->id ? $state->desc  : null}}
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <hr/>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @if($detail)
                @if($is_myApp || auth()->user()->isAdmin())
                    @if($detail->hasStatus->code == '01')
                    <button type="button" {{$detail->hasVehicle->count()>0 ? '':'disabled'}} id="" class="btn btn-module verify" data-id="{{$detail ? $detail->id : null}}">Hantar</button>
                    @endif
                    @if(in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <button class="btn btn-link" type="submit"><i class="fal fa-save"></i> Simpan sebagai Draf</button>
                    @endif
                @endif
            @else
                <button class="btn btn-module" type="submit"> Simpan </button>
            @endif
        </div>
    </div>
    <p>&nbsp;</p>
</form>

<div class="modal fade" id="prompChangeWorkshopModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompChangeWorkshopModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    Adakah anda ingin menukar woksyop untuk permohonan ini?
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-module" type="button" onclick="changeWorkshop();$(this).prop('disabled', true);$(this).next().prop('disabled', true);">Ya</button>
                <button type="button" class="btn btn-secondary" onclick="$('#change_workshop_id').val({{$detail && $detail->hasWorkshop ? $detail->hasWorkshop->id : null}}).trigger('change')" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="prompAssignAssistantEngineerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompAssignAssistantEngineerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    Adakah anda ingin meneruskan proses ini ?
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-module" type="button" id="assign_assistant" onclick="assignAssistantEngineer();$(this).text('Sila Tunggu.. Proses notifikasi kepada penolong jurutera.').prop('disabled', true);$(this).next().prop('disabled', true);">Ya</button>
                <button type="button" class="btn btn-secondary" id="assign_close" onclick="$('#assist_engineer_repair_id').val({{$detail && $detail->hasAssistantEngineerRepairBy ?$detail->hasAssistantEngineerRepairBy->id :'null'}}).trigger('change')" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    let currentAppDt1;
    let currentAppDt2;
    let currentAppDt3;
    let excludeDateApp = [];
    let selectedWorkshopId = null;
    let selectedEngginerRepairId = null;
    let selectedEngginerServiceId = null;

    @if($detail && $detail->hasAssistantEngineerRepairBy)
        selectedEngginerRepairId = {{$detail->hasAssistantEngineerRepairBy->id}};
    @endif

    @if($detail && $detail->hasAssistantEngineerServiceBy)
        selectedEngginerServiceId = {{$detail->hasAssistantEngineerServiceBy->id}};
    @endif

    function removeKey(arr, value){
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] === value) {
                arr = arr.splice(i, 1);
            }
        }
        return arr;
    }

    function reinitializeDatepicker(target){


        //console.log(target);
        //console.log(excludeDateApp);

       setTimeout(() => {
            $(target).datetimepicker('remove').datetimepicker(
                {
                    autoclose: 1,
                    todayHighlight: 1,
                    startDate: new Date(),
                    datesDisabled: excludeDateApp
                }
            );
       }, 500);


    }

    function submitApplication(data) {

        $('form').find('[type="submit"]').prop('disabled', true);

        $('#frm_application .hasErr').remove();

        $('[name="app_dates"]').html('');

            parent.startLoading();
            $.ajax({
                url: "{{ route('maintenance.job.register.save') }}",
                type: 'post',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    window.location = response['url'];
                },
                error: function(response) {
                    console.log(response);
                    var errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {

                        if(key == 'app_dates'){
                            if($('[name="'+key+'"]').find('.hasErr').length == 0){
                                console.log(value[0]);
                                $('[name="'+key+'"]').html('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                        else if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            console.log('masuk 1');
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            console.log('masuk 2');
                            if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });
                    $('form').find('[type="submit"]').prop('disabled', false);
                    parent.stopLoading();
                }
            });
        }

    const prompChangeWorkshop = function(workshop_id){
        if(workshop_id){
            selectedWorkshopId = workshop_id;
            $('#prompChangeWorkshopModal').modal('show');
        }
    }

    const changeWorkshop = function(){
        $.post('{{route('maintenance.job.changeWorkshop')}}', {
            workshop_id: selectedWorkshopId,
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = "{{route('maintenance.job.list')}}";
        });
    }

    const prompAssignAssistantEngineer = function(self){
        $('#assign_assistant').text('Ya').prop('disabled', false);
        $('#prompAssignAssistantEngineerModal').modal('show');
    }

    const assignAssistantEngineer = function(){

        $('.hasErr').html('');

        $.post('{{route('maintenance.job.assign.assistant.engineer')}}', {
            is_repair_required: {{$is_repair_required?:0}},
            is_service_required: {{$is_service_required?:0}},
            assist_engineer_repair_id: selectedEngginerRepairId,
            assist_engineer_service_id: selectedEngginerServiceId,
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = "{{route('maintenance.job.list')}}";
        }).fail(function(res) { 
            var errors = res.responseJSON.errors;
            console.log('errors', errors);

            $.each(errors, function(key, value) {
                console.log(key);
                $('[name="'+key+'"]').parent().find('.hasErr').text(value[0]).addClass('text-danger');
            });

            $('#prompAssignAssistantEngineerModal').modal('hide');
            $('#assign_close').prop('disabled', false);
        });
    }

    $(document).ready(function(){
        @if($detail && $detail->appointment_dt1)
            excludeDateApp.push('{{Carbon\Carbon::parse($detail->appointment_dt1)->format("Y-m-d")}}');

        @endif

        @if($detail && $detail->appointment_dt2)
            excludeDateApp.push('{{Carbon\Carbon::parse($detail->appointment_dt2)->format("Y-m-d")}}');

        @endif

        @if($detail && $detail->appointment_dt3)
            excludeDateApp.push('{{Carbon\Carbon::parse($detail->appointment_dt3)->format("Y-m-d")}}');

        @endif

            reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');


        $('#frm_application').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('app_dates', excludeDateApp);
            submitApplication(formData);

        });

        let app_dt_1_container = $('#date1Container').datetimepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );

        let app_dt_2_container = $('#date2Container').datetimepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );
        let app_dt_3_container = $('#date3Container').datetimepicker(
            {
                autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
            }
        );


        app_dt_1_container.on('changeDate', function(e){
            let val = $(this).datetimepicker('getDate');
            if(val){
                currentAppDt1 = new moment(val).format('YYYY-MM-DD');
            }
        });

        app_dt_2_container.on('changeDate', function(e){
            let val = $(this).datetimepicker('getDate');
            if(val){
                currentAppDt2 = new moment(val).format('YYYY-MM-DD');
            }
        });

        app_dt_3_container.on('changeDate', function(e){
            let val = $(this).datetimepicker('getDate');
            if(val){
                currentAppDt3 = new moment(val).format('YYYY-MM-DD');
            }
        });

        app_dt_1_container.on('changeDate', function(ev){

            let formatedValue = moment(ev.date).format('YYYY-MM-DD HH:mm');
            $('[name="date_1"]').val(formatedValue);

            removeKey(excludeDateApp, currentAppDt1);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');

        });

        app_dt_2_container.on('changeDate', function(ev){

            let formatedValue2 = moment(ev.date).format('YYYY-MM-DD HH:mm');
            $('[name="date_2"]').val(formatedValue2);

            removeKey(excludeDateApp, currentAppDt2);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');

        });

        app_dt_3_container.on('changeDate', function(ev){

            let formatedValue3 = moment(ev.date).format('YYYY-MM-DD HH:mm');
            $('[name="date_3"]').val(formatedValue3);

            removeKey(excludeDateApp, currentAppDt3);
            let date = new moment(ev.date).format('YYYY-MM-DD');
            console.log('prev Array ', excludeDateApp);
            if($.inArray(date, excludeDateApp) === -1){
                excludeDateApp.push(date);
                console.log('latest Key Array ', excludeDateApp);
            }

            reinitializeDatepicker('#date1Container');
            reinitializeDatepicker('#date2Container');
            reinitializeDatepicker('#date3Container');

        });

        $('#change_workshop_id').on('change', function(e){
            e.preventDefault();
            let workshop_id = this.value;
            prompChangeWorkshop(workshop_id);
        });

        $('#assist_engineer_repair_id').on('change', function(e){
            e.preventDefault();
            selectedEngginerRepairId = this.value;
            
        });

        $('#assist_engineer_service_id').on('change', function(e){
            e.preventDefault();
            selectedEngginerServiceId = this.value;
            
        });

    })
</script>
