@php
    $doc_path = $detail && $detail->hasWorkInsLetter ? $detail->hasWorkInsLetter->doc_path : '';
    $doc_name = $detail && $detail->hasWorkInsLetter ? $detail->hasWorkInsLetter->doc_name : '';
    $pathUrl = $detail && $detail->hasWorkInsLetter ? '/storage/'.$doc_path.$doc_name : '';

    $allowBtnSave = ['01', '02','04'];
    $allowBtnSubmit = ['01','04'];
    $allowBtnVerify = ['02'];
    $allowBtnApproval = ['03'];

@endphp
<form class="row" id="frm_detail" enctype="multipart/form-data">

    @csrf

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <input type="hidden" name="hasNewDocWorkInsLetter" id="hasNewDocWorkInsLetter" value={{$pathUrl=='' ? 1:0 }}>
    <fieldset>
        <legend>MAKLUMAT PEMOHON</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-5 col-12">
                <label for="" class="form-label  text-dark">Nama <span class="text-danger">*</span></label>
                <input type="text" name="booking_person_name" id="booking_person_name" class="form-control" autocomplete="off"
                value="{{$detail && isset($detail->booking_person_name) ? $detail->booking_person_name : auth()->user()->name}}">
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6">
                <label for="" class="form-label  text-dark">No.telefon <span class="text-danger">*</span></label>
                        <input type="text" name="tel_no" id="tel_no" class="form-control" autocomplete="off"
                        value="{{$detail && (isset($detail->tel_no)) ? $detail->tel_no : auth()->user()->detail->telbimbit }}">
                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6">
                <label for="" class="form-label  text-dark">Email <span class="text-danger">*</span></label>
                        <input type="text" name="booking_person_email" id="booking_person_email" class="form-control" autocomplete="off"
                        value="{{$detail && (isset($detail->booking_person_email)) ? $detail->booking_person_email : auth()->user()->email}}">
                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-xl-7 col-lg-5 col-md-5 col-sm-5 col-12">
                <label for="" class="form-label text-dark">Agensi  <span class="text-danger">*</span></label>
                @if (!empty($is_display) && $is_display == 1)
                    <div class="text-capitalize theme-color-text">
                        {{ $detail && $detail->hasDepartment ? $detail->hasDepartment->name : '' }}
                    </div>
                @else
                    <div class="input-group">
                        <select class="form-select" id="agency" name="agency">
                            <option></option>
                            @foreach ($agency_list as $agency)
                                <option
                                {{$detail && $detail->hasAgency && $detail->hasAgency->id == $agency->id ? 'selected': ''}}
                                xcode="{{$agency->code}}"
                                value="{{$agency->id}}" {{$detail && $detail->hasDepartment && $detail->hasDepartment->id == $agency->id ? 'selected' : ''}}
                                >{{$agency->desc}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>MAKLUMAT KENDERAAN</legend>
        <div class="row">
            <div class="col-12 pt-2">
                @if(!$detail || 
                        in_array($detail->hasBookingStatus->code, $allowBtnSave) ||
                        ($TaskFlowAccessLogistic->mod_fleet_approval && in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                        )
                <div class="btn-group">
                    <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal" data-bs-target="#addVehicleTypeModal">
                        <i class="fal fa-plus"></i> Jenis Kenderaan
                    </a>
                    <button onclick="prompDeleteDisasterreadyVehicle()" class="btn cux-btn bigger" type="button" id="delete_all" disabled><i class="fal fa-trash-alt"></i> Hapus</button>
                </div>
                @endif
            </div>
            <div class="col-12" id="table_vehicle_type"></div>
        </div>
    </fieldset>
    <div class="col-md-12 form-group">
        <div class="row">
            <div class="col-md-12 mt-2 mb-2">
                <div class="form-group center">
                    @if ($detail && $detail->destination)
                        @if(in_array($detail->hasBookingStatus->code, $allowBtnSubmit))
                            <button disabled type="button" class="btn btn-module btn-verify" data-bs-toggle="modal" data-bs-target="#verifyBookingModal"><i class="fal fa-paper-plane icon-white"></i>&nbsp; Hantar</button>
                        @endif
                        @if ($TaskFlowAccessLogistic->mod_fleet_approval)
                            @if(in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                                <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#rejectBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Tolak"><i class="fa fa-ban"></i>&nbsp;Tolak</button>
                                <button disabled class="btn cux-btn bigger btn-approval" data-bs-toggle="modal" data-bs-target="#approvalBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                            @endif
                        @endif
                    @endif
                    @if(!$detail || 
                        in_array($detail->hasBookingStatus->code, $allowBtnSave) ||
                        ($TaskFlowAccessLogistic->mod_fleet_approval && in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                        )
                        <button class="btn btn-module" type="submit">Simpan</button>
                    @endif
                </div>
            </div>
        </div>
    </div>


</form>

<div class="modal fade" id="deleteLogisitcDisasterreadyVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLogisitcDisasterreadyVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Pengesahan
            </div>
            <div class="modal-body">
                <div class="form-group text-center fs-5">
                    Adakah anda ingin menghapuskan maklumat kenderaan ini?
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" onclick="$(this).prop('disabled', true); deleteDisasterreadyVehicle()" class="btn btn-danger">Ya</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var sectorId = -1;
    var branchId = -1;
    // var subCategoryTypeId = -1;
    var divisionId = -1;
    var placementDivisionId = -1;
    var currentPreviewFile = "{{$pathUrl}}";
    let disasterreadyVehicleCheckedIds = [];

    const silentSaveJourney = function(data, response){
        $.ajax({
            url: "{{ route('logistic.disasterready.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function() {
                window.location = response['url'];
            },
            error: function(response) {
                $('#tab2').click();
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

    function submitDetail(data) {
        parent.startLoading();
        $.ajax({
            url: "{{ route('logistic.disasterready.register.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);

                let journey = new FormData($('#frm_journey')[0]);

                journey.append('_token', '{{ csrf_token() }}');

                let trip_expense_type = $.map($('.trip_expense_type:checked'), function(n, i){
                    return n.value;
                }).join(',');

                if(trip_expense_type.length > 0){
                    journey.append('trip_expense_type', trip_expense_type);
                }

                silentSaveJourney(journey, response);

                //window.location = response['url'];
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;
                // $('.messages').html(errorsHtml);
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

    function getSupportDocs(){
        $.get("{{route('logistic.ajax.getDRSupportDocs')}}", {
            'is_display': '{{$is_display}}'
        }, function(result){
            $('#support-docs').html(result)
        });
    }

    function ajaxLoadVehicleTypePage(url){
        parent.startLoading();
        $.get(url, function(data){
            $('#table_vehicle_type').html(data);
            parent.stopLoading();
        });
    }

    function loadDisasterreadyVehicle(){
        $.get("{{route('logistic.disasterready.vehicle-type.list')}}", function(result){
            $('#table_vehicle_type').html(result);
            let totalVehicle = $('#table_vehicle_type tbody tr.disasterready_vehicle').length;
            let totalAssignedVehicle = $('#table_vehicle_type tbody tr.disasterready_vehicle td.assigned-vehicle').length;
            
            let btnVerify = $('.btn-verify');
            if(totalVehicle > 0){
                btnVerify.prop('disabled', false);
            } else {
                btnVerify.prop('disabled', true);
            }

            let btnApproval = $('.btn-approval');
            if(totalAssignedVehicle > 0){
                btnApproval.prop('disabled', false);
            } else {
                btnApproval.prop('disabled', true);
            }
        });
    }

    function checkNeedDriver(vehicleTypeDetailId){
        let is_need_driver_container = $('#is-need-drive-container');
        $.post("{{route('logistic.disasterready.vehicle.checkIsNeedDriver')}}", {
            id: vehicleTypeDetailId,
            '_token': "{{ csrf_token() }}"
        }, function(result){
            if(result.is_need_driver){
                is_need_driver_container.show();
            } else {
                is_need_driver_container.hide();
            }
        });
    }

    function selectVehicleTypeDetail(id, vehicle_type_id, state_id, placement_id, self){
        checkNeedDriver(id);
        selectedAssignVehicleTypeId = vehicle_type_id;
        selectedAssignVehicleStateId = state_id;
        selectedAssignVehiclePlacementId = placement_id;

        let assignedVehicle = $(self).data('assigned-vehicle');
        let assignedDriver = $(self).data('assigned-driver');
        let assignedDriverPhoneNo = $(self).data('driver-phoneno');

        $('#vehicle_id').val(assignedVehicle.id);
        $('#driver_id').val(assignedDriver.id);
        $('#driver_phone_no').val(assignedDriverPhoneNo);
        
        $('#user_display_driver_id').val(assignedDriver.name);
        $('#vehicle_display').val(assignedVehicle.no_pendaftaran);
        $('#assignVehicleModal #vehicle_type_id').val(id);
    }

    const checkAll = function(self){

        let chkdels = $('.chkdel');
        let delete_all = $('#delete_all');
        let totalChecked = 0;

        disasterreadyVehicleCheckedIds = [];

        chkdels.prop('checked', $(self).is(':checked'));

        totalChecked = $('.chkdel:checked').each(function() {
            disasterreadyVehicleCheckedIds.push(this.value);
            return this.value;
        });

        if(totalChecked.length > 0){
            delete_all.prop('disabled', false);
        } else {
            delete_all.prop('disabled', true);
        }
    }

    const checkDel = function(self){

        let chkdel = self;
        let delete_all = $('#delete_all');
        let totalCheckDelbox = 0;
        let totalChecked = 0;

        disasterreadyVehicleCheckedIds = [];

        totalCheckDelbox = $('.chkdel').each(function() {
            return this.value;
        });

        totalChecked = $('.chkdel:checked').each(function() {
            disasterreadyVehicleCheckedIds.push(this.value);
            return this.value;
        });

        if(totalCheckDelbox.length == totalChecked.length){
            $('#chkall').prop('checked', true);
        } else {
            $('#chkall').prop('checked', false);
        }

        if(totalChecked.length > 0){
            delete_all.prop('disabled', false);
        } else {
            delete_all.prop('disabled', true);
        }
    }

    const prompDeleteDisasterreadyVehicle = function(){
        $('#deleteLogisitcDisasterreadyVehicleModal').modal('show');
    }

    const deleteDisasterreadyVehicle = function(){

        let modal = $('#deleteLogisitcDisasterreadyVehicleModal');

        console.log('disasterreadyVehicleCheckedIds => ', disasterreadyVehicleCheckedIds);

        $.post('{{route('logistic.disasterready.vehicle.delete')}}', {
            '_token': "{{ csrf_token() }}",
            'ids': disasterreadyVehicleCheckedIds
        }, function(response){
            console.log(response);
            $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
            modal.modal('hide');
            modal.find('form button').prop('disabled', false);
            loadDisasterreadyVehicle();
        });

    }

    $(document).ready(function() {

        loadDisasterreadyVehicle();

        $('#work_ins_letter').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-embed').attr('src', url);
            $('#preview-file').show();
            currentPreviewFile = url;
            console.log('url  file -> ', url);
        })

        $('#frm_detail').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitDetail(formData);

        });

        $('#tab1').on('click', function(){
            if(currentPreviewFile){
                $('#preview-file-embed').attr('src', currentPreviewFile);
            }
        })

    })
</script>
