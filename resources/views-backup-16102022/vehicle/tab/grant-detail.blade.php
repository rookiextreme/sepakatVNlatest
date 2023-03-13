<form class="row" id="frm_detail_grant">

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <input type="hidden" name="current_fleet_table" value="{{$currentFleetTable}}">
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
                        <select class="form-select" name="state_id" id="state_id" onchange="getPlacement(this.value)">
                            <option selected value="">Sila Pilih</option>
                            @foreach ($states as $state)
                                <option
                                    {{ isset($detail['state_id']) && $detail['state_id'] == $state->id ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->desc }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div class="col-xl-4 col-lg-5 col-md-4 col-sm-6 col-12">
                <label for="" class="form-label text-dark">Lokasi Penempatan</label>

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
        
    </fieldset>

    <fieldset>
        <legend>Pemandu</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label text-dark">Pemandu</label>
                        <x-modal-user isDisplay="{{$is_display}}" filterByRole="06" title="Pemandu" subTitle="Sila pilih atau buat carian" fieldName="main_driver_id" fieldValue="{{ $detail && $detail->hasMainDriver ? $detail->hasMainDriver->id : '' }}" dataName="{{ $detail && $detail->hasMainDriver ? $detail->hasMainDriver->name : '' }}"></x-modal-user>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
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

        $('#frm_detail_grant').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();
            formData += "&_token={{ csrf_token() }}";
            formData += "&fleet_view={{$fleet_view}}";
            submitDetail(formData);

        });
    })

    changeToUpperCase = function(self){
        self.value = self.value.toLocaleUpperCase();
    }
</script>
