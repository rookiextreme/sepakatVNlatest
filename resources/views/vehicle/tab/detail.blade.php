<form class="row" id="frm_detail">

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <input type="hidden" name="current_fleet_table" value="{{$currentFleetTable}}">
    {{-- <div class="row">
        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
            <div class="form-group">
                <label for="ttl_196">Rekod dibawah <em>*</em></label>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_department" id="inlineRadio-1" value="1"
                        >
                    <label class="form-check-label" for="inlineRadio-1">Jabatan</label>
                </div>
                <div class="form-check form-check-inline">
                    <input checked class="form-check-input" type="radio" name="is_department" id="inlineRadio-2" value="2">
                    <label class="form-check-label" for="inlineRadio-2">Bukan Jabatan</label>
                </div>
            </div>
        </div>
    </div> --}}
    <fieldset>
        <legend>Subjek</legend>
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
            <label for="" class="form-label text-dark">No Pendaftaran <em>*</em></label>
            @if (!empty($is_display) && $is_display == 1)
                <div class="text-capitalize theme-color-text">
                    {{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}
                </div>
            @else
                <input type="text" id="reg_no" name="reg_no" class="form-control" autocomplete="off"
                    value="{{ isset($detail['no_pendaftaran']) ? $detail['no_pendaftaran'] : '' }}" onkeyup="changeToUpperCase(this)">
            @endif

        </div>
        @if($currentFleetTable == 'department')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                <label for="" class="form-label text-dark">No JKR <i class="fa fa-info-circle"></i></label>
                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ $detail['no_jkr'] ? $detail['no_jkr'] : '' }}
                    </div>
                @else
                    <input type="text" name="reg_jkr" class="form-control" autocomplete="off"
                        value="{{ isset($detail['no_jkr']) ? $detail['no_jkr'] : '' }}">
                @endif
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                <label for="" class="form-label text-dark">Status <em>*</em></label>
                @if (!empty($is_display) && ($is_display == 1))
                <div class="text-capitalize theme-color-text">
                    {{isset($detail['status']) ? $detail['status'] : ''}}
                </div>
                @else
                <div class="input-group">
                    @if (!empty($is_display) && ($is_display == 1))
                        <div class="text-capitalize theme-color-text">
                            {{$detail && $detail->hasVehicleStatus ? $detail->hasVehicleStatus->desc:''}}
                        </div>
                    @else
                        @if($fleet_view == 'disposal')
                            <input type="text" name="vehicle_status_id" class="form-control" autocomplete="off"
                            value="{{ isset($detail->hasVehicleStatus) ? $detail->hasVehicleStatus->desc : '' }}" disabled>
                        @else
                            <select id="vehicle_status_id" class="form-select" name="vehicle_status_id" >
                                <option selected value="">Sila Pilih</option>
                                @foreach ($vehicleStatusList as $vstatus )
                                    @if($vstatus->desc !== 'LUPUS')
                                        <option
                                        {{$detail && $detail->hasVehicleStatus && $detail->hasVehicleStatus->id == $vstatus->id ? 'selected': ($vstatus->code == '01' ? 'selected': '')}}
                                        value="{{$vstatus->id}}">{{$vstatus->desc}}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    @endif
                </div>
                @endif
            </div>
        @endif
    </div>
    </fieldset>
    <fieldset>
        <legend>Pemilikan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4 col-12">
                <label for="" class="form-label text-dark">Hak Milik <em>*</em></label>

                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ $detail && $detail->hasOwnerType ? $detail->hasOwnerType->desc : '' }}
                    </div>
                @else
                    <div class="input-group">
                        <select class="form-control form-select" id="reg_hak" name="reg_hak">
                            <option></option>
                            @foreach ($owner_type_list as $owner_type)
                                <option xcode="{{$owner_type->code}}" value="{{$owner_type->id}}" {{$detail && $detail->hasOwnerType && $detail->hasOwnerType->id == $owner_type->id ? 'selected' : ''}}>{{$owner_type->desc_bm}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-12" id="branch_container" style="display:{{empty($detail) || $detail && $detail->hasOwnerType && $detail->hasOwnerType->code == '03' ? 'none' : 'block'}};">
                <label for="" class="form-label text-dark">Cawangan / Bahagian</label>
                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ isset($detail->cawangan->name) ? $detail->cawangan->name : '' }}
                        {{-- {{$detail->hasDivision()? $detail->hasDivision()->desc:''}} --}}
                    </div>
                @else
                    <div wire:ignore class="input-group">
                        <select class="form-select form-control" name="reg_cawangan" id="list_cawangan">
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12" id="project-name-container" style="display: {{$currentFleetTable == 'public' ? 'block': 'none'}};">
                <label for="" class="form-label text-dark">Nama Projek <em>*</em></label>
                @if (!empty($is_display) && $is_display == 1)
                <div class="text-capitalize theme-color-text">
                    {{ isset($detail->hasProject['project_name']) ? $detail->hasProject['project_name'] : '' }}
                </div>
                @else
                <textarea style="resize: none;" name="project_name" class="form-control" id="project_name" cols="30"
                    rows="3">{{ isset($detail->hasProject['project_name']) ? $detail->hasProject['project_name'] : '' }}</textarea>
                @endif

            </div>
            <div id="detail-project-container" style="display: {{$currentFleetTable == 'public' ? 'block': 'none'}};">
                @include('vehicle.tab.detail-project')
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Lokasi Penempatan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <!-- display IF "Negeri" being chosen in "HAK MILIK"-->
                <label for="" class="form-label text-dark">Negeri <em>*</em></label>
                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ isset($detail->hasState->desc) ? $detail->hasState->desc : '' }}
                    </div>
                @else
                    <div class="input-group">
                        <select class="form-select" name="state_id" id="state_id" onchange="getPlacement(this.value); getDistrict(this.value)">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($states as $state)
                                <option
                                    {{ isset($detail['state_id']) && $detail['state_id'] == $state->id ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Daerah</label>
                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ $detail->hasDistrict ? $detail->hasDistrict->desc : '' }}
                    </div>
                @else
                    <div class="input-group">
                        <select class="form-select" name="district_id" id="district_id">
                            <option selected value="">Tidak Berkenaan</option>
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Lokasi Penempatan <span id="district_desc" style="line-height: 14px;"></span></label>

                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ $detail->hasPlacement() && $detail->hasPlacement()->name ? $detail->hasPlacement()->name : '' }}
                    </div>
                @else
                    <div class="input-group">
                        <select class="form-select" name="reg_lokasi" id="list_lokasi">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($placement_list as $placement)
                                {{-- <option
                                    {{ isset($detail['cawangan_id']) && $detail['cawangan_id'] == $placement->id ? 'selected' : '' }}
                                    value="{{ $placement->id }}">{{ $placement->name }}</option> --}}
                                <option
                                {{ isset($detail['placement_id']) && $detail['placement_id'] == $placement->id ? 'selected' : '' }} value="{{ $placement->id }}">{{ $placement->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label text-dark" >Pegawai Bertanggungjawab</label>
                        <x-modal-user isDisplay="{{$is_display}}" id='pegtgjwb' filterByRole="" title="Pegawai" subTitle="Sila pilih atau buat carian" fieldName="person_incharge_id" fieldValue="{{ $detail && $detail->hasPersonIncharge ? $detail->hasPersonIncharge->id : '' }}" dataName="{{ $detail && $detail->hasPersonIncharge ? $detail->hasPersonIncharge->name : '' }}"></x-modal-user>
                    </div>
                </div>
            </div>
            @if($currentFleetTable == 'department')
                <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="" class="form-label text-dark">Pemandu</label>
                            <x-modal-user isDisplay="{{$is_display}}" filterByRole="06" title="Pemandu" subTitle="Sila pilih atau buat carian" fieldName="main_driver_id" fieldValue="{{ $detail && $detail->hasMainDriver ? $detail->hasMainDriver->id : '' }}" dataName="{{ $detail && $detail->hasMainDriver ? $detail->hasMainDriver->name : '' }}"></x-modal-user>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </fieldset>
    <!---->
    @if (empty($is_display) && $is_display == 0)
        <div class="row">
            @php
                $allowBtnSave = ['01', '02'];
                $allowBtnVerification = ['01'];
                $allowBtnVerify = ['02'];
                $allowBtnApproval = ['03'];
            @endphp

            <div class="col-12 mt-2 mb-2">
                <hr/>
                <div class="form-group center">
                    @if ((auth()->user()->isAdmin() && $detail) || !$detail || $detail->vAppStatus  && in_array($detail->vAppStatus->code, $allowBtnSave) || $TaskFlowAccessVehicle->mod_fleet_approval || $TaskFlowAccessVehicle->mod_fleet_can_edit_after_approve)
                        <button class="btn btn-module" type="submit">Simpan</button>
                    @endif
                    @if ($detail && $detail->vAppStatus())
                        @if (in_array($detail->vAppStatus->code, $allowBtnVerification))
                            <a class="btn btn-module" data-bs-toggle="modal"
                                data-bs-target="#submitVerificationModal">Hantar</a>
                        @endif

                        @if ($TaskFlowAccessVehicle->mod_fleet_verify)
                            @if (in_array($detail->vAppStatus->code, $allowBtnVerify))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal"
                                    data-bs-target="#verifyVehicleModal" type="button" data-toggle="popover"
                                    data-trigger="focus" data-placement="top" data-content="Semak"><i
                                        class="fa fa-check"></i>&nbsp;Semak</button>
                            @endif
                        @endif

                        @if ($TaskFlowAccessVehicle->mod_fleet_approval)
                            @if (in_array($detail->vAppStatus->code, $allowBtnApproval))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal"
                                    data-bs-target="#approvalVehicleModal" type="button" data-toggle="popover"
                                    data-trigger="focus" data-placement="top" data-content="Sah"><i
                                        class="fa fa-check"></i>&nbsp;Sah</button>
                            @endif
                        @endif

                    @endif
                </div>
            </div>
        </div>
    @endif

</form>

<script type="text/javascript">

    var sectorId = -1;
    var branchId = -1;
    // var subCategoryTypeId = -1;
    var divisionId = -1;
    var placementDivisionId = -1;
    let selected_state_id = null;
    let selected_district_id = null;

    @if ($detail && $detail->state_id)
        selected_state_id = '{{$detail->state_id}}';
        getDistrict(selected_state_id);
    @endif

    @if ($detail && $detail->district_id)
        selected_district_id = '{{$detail->district_id}}';
    @endif

    @if ($detail && $detail->cawangan)
        branchId = '{{$detail->cawangan->id}}';
    @endif

    function checkExistRegNumber(reg_no){

        $('.hasErr').remove();

        $.ajax({
            url: "{{ route('vehicle.checkExistRegNumber') }}",
            type: 'post',
            data: {
                reg_no: reg_no,
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(isExist) {

                let errorsHtml = '';
                if(isExist == 1){
                    $('[name="reg_no"]').parent().append('<div class="hasErr text-danger col-12 fs-6">No Pendaftaran '+reg_no+' Telah Wujud</div>');
                    $('[type="submit"]').prop('disabled', true);
                } else {
                    $('[type="submit"]').prop('disabled', false);
                }
            },
            error: function(response) {

                var errors = response.responseJSON.errors;

                $.each(errors, function(key, value) {
                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                            $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    } else {
                        if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                            $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    }
                });

                $('[type="submit"]').prop('disabled', true);
            }
        });
    }

    function getDistrict(state_id){

        $('#district_id').html('<option value="-1">Tidak Berkenaan</option>');

        $.get("{{route('vehicle.ajax.getDistrict')}}", {
            state_id: state_id
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {

                $('#district_id').append('<option value='+element.id+'>'+element.desc+'</option>');
                    if(selected_district_id == element.id){
                        same = true;
                    }
                    totalInit++;
                });

                if(count == totalInit){
                    if(!same){
                        selected_district_id = -1;
                    }
                    setTimeout(() => {
                        $('#district_id').val(selected_district_id).trigger("change");
                    }, 500);
                }

        });
    }

    function getPlacement(reg_negeri){

        $('#list_lokasi').html('<option value="-1">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getPlacement')}}", {
            reg_negeri: reg_negeri
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {

                $('#list_lokasi').append('<option value='+element.id+'>'+element.desc+'</option>');
                    if(divisionId == element.id){
                        same = true;
                    }
                    totalInit++;
                });

                if(count == totalInit){
                    if(!same){
                        divisionId = -1;
                    }
                    $('#list_lokasi').val(divisionId).trigger("change");
                }

        });
    }



    function getBranchOwner(owner_type_id){

        $('#list_cawangan').html('<option value="" selected>Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getBranchOwner')}}", {
            owner_type_id: owner_type_id
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {

                $('#list_cawangan').append('<option value='+element.id+'>'+element.name+'</option>');
                    if(branchId == element.id){
                        same = true;
                    }
                    totalInit++;
                });

                if(count == totalInit){
                    if(!same){
                        branchId = -1;
                    }
                    $('#list_cawangan').val(branchId).trigger("change");
                }

        });
    }

    function submitDetail(data) {

        $('.hasErr').remove();

        parent.startLoading();
        $.ajax({
            url: "{{ route('vehicle.register.save') }}",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                window.location = response['url'];
            },
            error: function(response) {

                var errors = response.responseJSON.errors;

                $.each(errors, function(key, value) {
                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                            $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    } else {
                        if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                            $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                        }
                    }
                });

                parent.stopLoading();
            }
        });
    }

    $(document).ready(function() {

        @if ($detail && $detail->hasOwnerType)
        getBranchOwner('{{$detail->hasOwnerType->id}}');
        @endif

        $('#reg_no').on('keyup', function (e) {
            var data= this.value;
            var checkRegex = /^[0-9]*$/;
            var isNumberAlpha = checkRegex.test(data);
            if(!isNumberAlpha){
                e.preventDefault();
                data = data.replace(/[^\w\s]/gi, '');
                $(this).val(data.trim());
                return false;
            }
        });

        $('#reg_no').on('change', function(e){
            e.preventDefault();
            checkExistRegNumber(this.value);
        });

        $('#reg_hak').on('change', function(e){
            e.preventDefault();
            const id =  this.value;
            const xcode =  $('option:selected', this).attr('xcode');
            let branch_container = $('#branch_container');
            let project_name_container = $('#project-name-container');
            let detail_project_container = $('#detail-project-container');
            console.log('xcode --> ', xcode);
            if(xcode == '01' || xcode == '02'){
                getBranchOwner(id);
                branch_container.show();
                project_name_container.hide();
                detail_project_container.hide();
            } else {
                detail_project_container.show();
                project_name_container.show();
                branch_container.hide();
            }
        });

        $('#frm_detail').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            formData += "&_token={{ csrf_token() }}";
            formData += "&fleet_view={{$fleet_view}}";
            submitDetail(formData);

        });

        $('#district_id').on('change', function(e){
            let value = $(':selected',this).text();
            $('#district_desc').html('('+value+')').addClass('form-label');
        });
    })

    changeToUpperCase = function(self){
        self.value = self.value.toLocaleUpperCase();
    }
</script>
