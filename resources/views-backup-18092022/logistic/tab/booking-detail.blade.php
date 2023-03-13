@php

    $allowBtnSave = ['01', '02','04'];
    $allowBtnSubmit = ['01','04'];
    $allowBtnVerify = ['02'];
    $allowBtnApproval = ['03'];

    $is_owner_booking = $detail && $detail->created_by == auth()->user()->id ? true : false;
@endphp
<form class="row" id="frm_detail">

    @csrf

    <div class="messages"></div>

    <input type="hidden" name="section" value="detail">
    <fieldset>
        <legend>Maklumat Pemohon</legend>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-5 col-12">
                <label for="" class="form-label  text-dark">Nama <span class="text-danger">*</span></label>
                @if($detail && !$is_owner_booking)
                <input type="hidden" name="name"  value="{{$applicant['booking_person_name']}}"/>
                    <div class="text-capitalize theme-color-text">
                        {{$applicant['booking_person_name']}}
                    </div>
                @else
                <input type="text" name="name" id="name" class="form-control" autocomplete="off"
                value="{{$applicant['name']}}" onchange="forceCaps(this)">
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6">
                <label for="" class="form-label  text-dark">No.telefon <span class="text-danger">*</span></label>
                @if($detail && !$is_owner_booking)
                <input type="hidden" name="tel_no"  value="{{$applicant['tel_no']}}"/>
                <div class="text-capitalize theme-color-text">
                    {{$applicant['tel_no']}}
                </div>
                @else
                <input type="text" name="tel_no" id="tel_no" class="form-control" autocomplete="off"
                value="{{$applicant['tel_no']}}">
                @error('tel_no') <span class="error text-danger">{{ $message }}</span> @enderror
                @endif
            </div>
            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-3 col-6">
                <label for="" class="form-label  text-dark">Email <span class="text-danger">*</span></label>
                @if($detail && !$is_owner_booking)
                <input type="hidden" name="email"  value="{{$applicant['email']}}"/>
                <div class="text-capitalize theme-color-text">
                    {{$applicant['email']}}
                </div>
                @else
                <input type="text" name="email" id="email" class="form-control" autocomplete="off"
                value="{{$applicant['email']}}">
                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-5 col-md-5 col-sm-5 col-12">
                <label for="" class="form-label text-dark">Cawangan / Jabatan  <em class="text-danger">*</em></label>
                @if($detail && !$is_owner_booking)
                <input type="hidden" name="department_id" id="department_id" class="form-control" autocomplete="off"value="{{$applicant['department'] ? $applicant['department']->id : null}}">
                    <div class="text-capitalize theme-color-text">
                        {{ $applicant['department'] ? $applicant['department']->name : '' }}
                    </div>
                @else
                <select class="form-select" id="department_id" name="department_id">
                    <option value="">[Sila Pilih]</option>
                    @foreach ($department_list as $department)
                        <option {{$applicant['department'] && $applicant['department']->id == $department->id ? 'selected': ''}} xcode="{{$department->code}}" value="{{$department->id}}" {{$detail && $detail->hasDepartment && $detail->hasDepartment->id == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                    @endforeach
                </select>
                @endif
            </div>
            {{-- <div class="col-xl-6 col-lg-4 col-md-4 col-sm-4 col-12">
                <label for="" class="form-label text-dark">Jenis Tempahan  <em class="text-danger">*</em></label>
                <select class="form-select" id="booking_type_id" name="booking_type_id">
                    <option></option>
                    @foreach ($booking_type_list as $booking_type)
                        <option value="{{$booking_type->id}}">{{$booking_type->desc_bm}}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>
    </fieldset>
    @include('logistic.tab.booking-detail-jkr')
    <div class="col-md-12 mt-2 mb-2">
        <div class="form-group center">

            @if ($detail && $detail->destination)
                @if(in_array($detail->hasBookingStatus->code, $allowBtnSubmit))
                    <button disabled type="button" class="btn btn-module btn-verify" id="btn-verify-detail" data-bs-toggle="modal" data-bs-target="#verifyBookingModal"><i class="fal fa-paper-plane icon-white"></i>&nbsp;Hantar</button>
                @endif
                @if (auth()->user()->isAdmin() || $TaskFlowAccessLogistic->mod_fleet_approval)
                    @if(in_array($detail->hasBookingStatus->code, $allowBtnApproval))
                        <button class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#rejectBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Tolak"><i class="fa fa-ban"></i>&nbsp;Tolak</button>
                        {{-- @if(count($detail->hasManyAssignedVehicle)) --}}
                            <button disabled class="btn cux-btn bigger btn-approval" id="btn-approval-detail" data-bs-toggle="modal" data-bs-target="#approvalBookingModal" type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
                        {{-- @endif --}}
                    @endif
                @endif
            @endif
            @if(auth()->user()->isAdmin() || !$detail || (in_array($detail->hasBookingStatus->code, $allowBtnSave)))
                <button class="btn btn-link" type="submit"><i class="fal fa-save"></i> Simpan</button>
            @endif
        </div>
    </div>

</form>

{{-- <div class="modal fade" id="addLogisticBookingSupportDocsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLogisticBookingSupportDocsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frmLogisticBookingSupportDoc" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="SupportDoc" class="form-label">Muat naik dokumen sokongan (Word/Excel/Pdf) <span class="btn cux-btn">&nbsp;<i class="fa fa-upload fa-2x"></i></span> <span class="text-danger">*</span></label>
                        <input class="form-control d-none" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,application/pdf" name="support_doc" type="file" id="SupportDoc" />
                    </div>
                    <div class="form-group">
                        <textarea name="support_doc_desc" class="form-control" id="support_doc_desc" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" xaction="upload_image" >Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="deleteLogisitcBookingVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLogisitcBookingVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Pengesahan
            </div>
            <div class="modal-body">
                <div class="form-group text-center fs-5">
                    Adakah anda ingin menghapuskan maklumat tempahan kenderaan ini?
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" onclick="$(this).prop('disabled', true); deleteBookingVehicle()" class="btn btn-danger">Ya</button>
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
    let bookingVehicleCheckedIds = [];

    const silentSaveJourney = function(data, response){
        $.ajax({
            url: "{{ route('logistic.booking.register.save') }}",
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

    function submitBookingDetail(data) {

        $('.hasErr').remove();

        parent.startLoading();
        $.ajax({
            url: "{{ route('logistic.booking.register.save') }}",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {

                let journey = new FormData($('#frm_journey')[0]);

                journey.append('_token', '{{ csrf_token() }}');

                silentSaveJourney(journey, response);
            },
            error: function(response) {
                console.log(response);
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

    function getSupportDocs(){
        $.get("{{route('logistic.ajax.getSupportDocs')}}", {
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

    function loadBookingVehicle(){
        $.get("{{route('logistic.booking.vehicle-type.list')}}", function(result){
            $('#table_vehicle_type').html(result);
            let totalVehicle = $('#table_vehicle_type tbody tr.booking_vehicle').length;
            let totalAssignedVehicle = $('#table_vehicle_type tbody tr.booking_vehicle td.assigned-vehicle').length;
            
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

    const checkAll = function(self){

        let chkdels = $('.chkdel');
        let delete_all = $('#delete_all');
        let totalChecked = 0;

        bookingVehicleCheckedIds = [];

        chkdels.prop('checked', $(self).is(':checked'));

        totalChecked = $('.chkdel:checked').each(function() {
            bookingVehicleCheckedIds.push(this.value);
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

        bookingVehicleCheckedIds = [];

        totalCheckDelbox = $('.chkdel').each(function() {
            return this.value;
        });

        totalChecked = $('.chkdel:checked').each(function() {
            bookingVehicleCheckedIds.push(this.value);
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

    const editBookingVehicle = function(self){
        let placement_id =
        $('#placement_id').val()
    }

    const prompDeleteBookingVehicle = function(){
        $('#deleteLogisitcBookingVehicleModal').modal('show');
    }

    const deleteBookingVehicle = function(){

        let modal = $('#deleteLogisitcBookingVehicleModal');

        console.log('bookingVehicleCheckedIds => ', bookingVehicleCheckedIds);

        $.post('{{route('logistic.booking.vehicle.delete')}}', {
            '_token': "{{ csrf_token() }}",
            'ids': bookingVehicleCheckedIds
        }, function(response){
            console.log(response);
            $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
            modal.modal('hide');
            modal.find('form button').prop('disabled', false);
            loadBookingVehicle();
        });

    }

    $(document).ready(function() {

        loadBookingVehicle();

        let start_datetime_container = $('#start_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        let end_datetime_container = $('#end_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        @if ($detail && $detail->start_datetime)
            start_datetime_container.datetimepicker('setStartDate', new Date());
            start_datetime_container.datetimepicker('setDate', new Date("{{$detail->start_datetime}}"));
            end_datetime_container.datetimepicker('setStartDate', new Date("{{$detail->start_datetime}}"));
            @else
            start_datetime_container.datetimepicker('setStartDate', new Date());
        @endif
        @if ($detail && $detail->end_datetime)
            end_datetime_container.datetimepicker('setDate', new Date("{{$detail->end_datetime}}"));
            end_datetime_container.find('input').prop('disabled', false);
        @endif

        $('#start_datetime_container').on('change', function(){
            var startDateTime = $('#start_datetime_container').datetimepicker('getDate');
            if(startDateTime){
                $('#end_datetime_container').find('input').prop('disabled', false);
            }
            $('#end_datetime_container').datetimepicker('setDate', startDateTime);
            $('#end_datetime_container').datetimepicker('setStartDate', startDateTime);
        });

        $('#work_ins_letter').on('change', function(e){
            e.preventDefault();

            let url = URL.createObjectURL(e.target.files[0]);
            $('#preview-file-embed').attr('src', url);
            $('#preview-file').show();
            currentPreviewFile = url;
            $('#hasNewDocWorkInsLetter').val(1);
            console.log('url  file -> ', url);
        })

        $('#frm_detail').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitBookingDetail(formData);

        });

        $('#tab1').on('click', function(){
            if(currentPreviewFile){
                $('#preview-file-embed').attr('src', currentPreviewFile);
            }
        });

        $('#yes').on('change', function() {

                $('#driver_on').attr('style','display:show');

        });

        $('#no').on('change', function() {

                $('#driver_on').attr('style','display:none');

        });

    })
</script>
