
@php
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentVehicleImage;
$TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
$id = Request('id');
$AssessmentVehicleDetail =  AssessmentAccidentVehicle::where('assessment_accident_id', $id)->first();
$OwnImage = AssessmentVehicleImage::where('vehicle_id', $AssessmentVehicleDetail->id)->where('assessment_type_id', 3)->get();

@endphp
<form class="row" id="frm_vehicle_assessment" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="vehicle_assessment">
    <input type="hidden" name="assessment_accident_id" value="{{$id}}">
    <style>
         .show-plet-no {
            top:-25px;
            box-shadow: rgba(0, 0, 0, 0.04) 0px 4px 18px, rgba(0, 0, 0, 0.06) 0px 5px 5px;
        }
    </style>
    <fieldset style="position: relative;">
        <div class="show-plet-no">{{$detail && $detail->hasVehicle ? $detail->hasVehicle->plate_no : ''}}</div>
        <legend>MAKLUMAT FIZIKAL KENDERAAN</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-3 col-sm-4 col-md-3 col-12">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Odometer</label>
                    <input type="number" class="form-control text-end" name="odometer" id="odometer" value="{{$AssessmentVehicleDetail->odometer}}" maxlength="7" placeholder=""
                        value="000000" onchange="forceNumeric(this)">
                    <div class="hasErr"></div>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3 col-sm-4 col-md-3 col-12">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Syor Umum</label>
                    <textarea class="form-control" style="resize: none;" type="text" onchange="this.value = this.value.toUpperCase()" name="general_note" id="general_note" rows="1" cols="3">{{$AssessmentVehicleDetail->general_note}}</textarea>
                    <div class="hasErr"></div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 col-sm-4 col-md-6 col-12" >
                <div class="form-group">
                    {{-- <label for="" class="form-label text-dark">Foto Keseluruhan</label>
                    <button type="button" class="btn cux-btn bigger" style="margin-top:2px;"><i class="fa fa-file-image"></i> Muat Naik</button> --}}
                    <div class="form-group" id="reload_button">
                        {{-- <label for="" class="form-label  text-dark">Laporan VTL <span class="text-danger">*</span></label>
                        <button type="button" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Laporan</button> --}}
                        <label for="" class="form-label text-dark">Imej Kenderaan <span class="text-danger"></span></label>
                        @if($OwnImage->count() < 5)
                            <div class="col-md-9">
                                <label for="vtl_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Foto Keseluruhan</label>
                                <input onchange="uploadFile(this)" class="form-control d-none" accept="image/*" type="file" id="vtl_doc" />
                            </div>
                        @endif
                    </div>
                    <div class="row" id="reload_perdiv">
                        @foreach ( $OwnImage as $vehicleImage)
                            @php
                                $path = '';
                                $docName = '';
                                if($vehicleImage){
                                    $path = $vehicleImage->doc_path;
                                    $docName = $vehicleImage->doc_name;
                                }
                            @endphp

                                <div class="col-md-2">
                                    <button
                                        type="button" class="btn small" style="display: {{$vehicleImage ? 'show' :'none'}}"
                                        onclick="deleteVehicleImage({{$vehicleImage->id}}, 'owner')"><i class="fas fa-trash"></i>
                                    </button>
                                    <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$vehicleImage ? 'block' :'none'}}">
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </fieldset>
    <fieldset>
        <legend>PENILAIAN KEROSAKAN</legend>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-12 pt-3">
                <div class="btn-group">
                    {{-- <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#addAssessmentVehicleModal"><i class="fal fa-plus"></i> Kenderaan</a> --}}
                    <a class="btn cux-btn bigger" onclick="addDamageFormAssessment()"><i class="fal fa-plus"></i> Kerosakan</a>
                    <button class="btn cux-btn bigger delete_all" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#assessmentStruckDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-4" id="assessment_accident_vehicle_assessment">

            </div>
        </div>
    </fieldset>
    @if($detail->hasStatus->code == '03')
    <hr/>
        <div class="form-group center">
            <span class="btn btn-module" onclick="promptSubmitForVerificationModal()">Hantar</span>
            <button type="submit" class="btn btn-link" xaction="draf" formnovalidate>Simpan</button>
        </div>
    @endif
</form>
<div class="modal fade" id="addDamageAssessmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addDamageAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Butir Kerosakan
                    <div>Berikan butiran kerosakan pada kenderaan subjek</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddDamageFormAssessment" action="" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="damage_id" id="damage_id" class="form-control">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Kerosakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="damage" id="damage" placeholder="cth. Fender depan remuk" xplate_no onchange="this.value = this.value.toUpperCase()">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Nota</label>
                                <textarea name="damage_note" id="damage_note" class="form-control" cols="30" rows="3"></textarea>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Syor <span class="text-danger">*</span></label>
                                <div class="form-switch form-check-inline">
                                    <input type="checkbox" class="form-check-input mt-2 me-2" name="is_repair" id="is_repair">
                                    <label class="form-check-label cursor-pointer" for="check_all"> Baiki</label>
                                </div>
                                <div class="form-switch form-check-inline">
                                    <input type="checkbox" class="form-check-input mt-2 me-2" name="is_replace" id="is_replace">
                                    <label class="form-check-label cursor-pointer" for="check_all"> Ganti</label>
                                </div>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="damage" class="form-label text-dark">Gambar</label>
                                <label type="button" for="damage_picture" class="btn cux-btn bigger" style="margin-top:2px"><i class="fa fa-file-image"></i> Muat Naik Foto</label>
                                <input class="form-control d-none" accept="image/*" type="file" name="damage_picture" id="damage_picture" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex justify-content-start">
                    <button type="submit" class="btn btn-module float-start add_vehicle" style="display:block;" >Tambah</button>
                    <button type="submit" class="btn btn-module float-start edit_vehicle" style="display:none;">Simpan</button>
                    <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>
                    <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>-->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="assessmentAccidentVehicleVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentAccidentVehicleVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin menghantar untuk semakan maklumat ini?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                {{-- <span id="verification" class="btn btn-primary text-white" onclick="submitForVerification()" xaction="verify">Ya</span> --}}
                <button class="btn btn-module" xaction="verify">Ya</button>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="assessmentStruckDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentStruckDelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah anda ingin menghapuskan maklumat kerosakan ini ?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" style="display: none" id="reload" class="btn btn-secondary"
                        onclick="window.location.reload()">Tutup</button>
                    <button type="button" id="remove" class="btn btn-danger text-white"
                        onclick="removeSStruck()">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    @include('components.modal-enlarge-image')
<script type="text/javascript">
    promptSubmitForVerificationModal = function(){
        $('#assessmentAccidentVehicleVerificationModal').modal('show');
    }

    submitForVerification = function(formData, save_as){

        formData.append('save_as', save_as);
        // $.post("{{ route('assessment.accident.verification') }}", {
        //     '_token': '{{ csrf_token() }}'
        // }, function(result){
        //     window.location.href = result.url;
        // });
        parent.startLoading();
            $.ajax({
                url: "{{ route('assessment.accident.verification') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    window.location.href = response.url;
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });
                }
            });
    }

    loadAssessmentNewVehicleAssessment = function() {
        $.get("{{ route('assessment.accident.vehicle-assessment-damage.list') }}", function(result){
            $('#assessment_accident_vehicle_assessment').html(result);
        });
    }

    const submitVehicleDamageFormAssessment = function(data) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('assessment.accident.vehicle.damage.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frmAddDamageFormAssessment #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                $('#addDamageAssessmentModal').modal('hide');
                // addAssessmentVehicle();
                loadAssessmentNewVehicleAssessment();
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);;
                        }
                    } else {
                        console.log('key', key)
                        if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);;
                        }
                    }
                });
            }
        });
    }


    submitAssesmentAccidentForm = function(data) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('assessment.accident.vehicle.information.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                window.location.reload();
                // $('#frmAddDamageFormAssessment #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                // $('#addDamageAssessmentModal').modal('hide');
                // // addAssessmentVehicle();
                // loadAssessmentNewVehicleAssessment();
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);;
                        }
                    } else {
                        console.log('key', key)
                        if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);;
                        }
                    }
                });
            }
        });
    }

    function openEnlargeModal(self){

            $('#enlargeImageModal img').attr('src', $(self).attr('src'));
            $('#enlargeImageModal').modal('show');
        }

    uploadFile = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('#preview_img').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('assessment_id', "{{Request('id')}}");
            formData.append('vehicle_id', "{{$AssessmentVehicleDetail->id}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.accident.vehicle.information.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_perdiv').load(document.URL + ' #reload_perdiv');
                    $('#reload_button').load(document.URL + ' #reload_button');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

        uploadDamageFile = function(self){

            let url = URL.createObjectURL($(self)[0].files[0]);
            if(url){
                $(self).parent().find('.form-label').text('Tukar Fail')
                $(self).parent().find('#preview_img').attr('src', url).show();
            }

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('assessment_id', "{{Request('id')}}");
            formData.append('file', $(self)[0].files[0]);
            $.ajax({
                url: "{{ route('assessment.accident.vehicle.information.damage.form-file.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                    $('#reload_perdiv').load(document.URL + ' #reload_perdiv');
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                    });

                }

            });
        }

    addDamageFormAssessment = function(){
        $('#frmAddDamageFormAssessment')[0].reset();
        $('#damage_id').val("");
        let addDamageAssessmentModal = $('#addDamageAssessmentModal');

        addDamageAssessmentModal.modal('show');
    }

    editDamageFormAsessment = function(damageID){
        $('#frmAddDamageFormAssessment')[0].reset();
        $('#damage_id').val("");
        let addDamageAssessmentModal = $('#addDamageAssessmentModal');
        $.ajax({
        url: '{{Route("assessment.accident.vehicle.getDamageForm")}}',
        type: 'get',
        data: {
            "damageID": damageID
        },
        dataType: 'json',
            success: function(data) {
                addDamageAssessmentModal.find(".add_vehicle").hide();
                addDamageAssessmentModal.find(".edit_vehicle").show();
                addDamageAssessmentModal.find('#damage_id').val(data.list.id);
                addDamageAssessmentModal.find('#damage').val(data.list.damage);
                addDamageAssessmentModal.find('#damage_note').val(data.list.damage_note);
                addDamageAssessmentModal.find('#price_list').val(data.list.price_list);
                let is_repair = data.list.is_repair;
                    if (is_repair == false){
                        addDamageAssessmentModal.find('#is_repair').prop("checked", false);
                    }else{
                        addDamageAssessmentModal.find('#is_repair').prop("checked", true);
                    }
                let is_replace = data.list.is_replace;
                    if (is_replace == false){
                        addDamageAssessmentModal.find('#is_replace').prop("checked", false);
                    }else{
                        addDamageAssessmentModal.find('#is_replace').prop("checked", true);
                    }
                parent.stopLoading();
            }
        });
        addDamageAssessmentModal.modal('show');

    }

    deleteVehicleImage = function(vehicle_id, section){
        $.post("{{route('assessment.accident.deleteVehiclePicture')}}", {
            vehicle_id: vehicle_id,
            image_id: vehicle_id,
            section: section,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#reload_perdiv').load(document.URL + ' #reload_perdiv');
            $('#reload_button').load(document.URL + ' #reload_button');
        })
    }

    function removeSStruck(){
            $('#assessmentStruckDelModal #remove').hide();
            $('#assessmentStruckDelModal #close').hide();
            $.post("{{route('assessment.accident.deleteVehicleDamageForm')}}", {
                ids: ids,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#assessmentStruckDelModal .sub-title').text(result.message);
                }
                $('#assessmentStruckDelModal #reload').show();
            })
        }

    $(document).ready(function(){

        @if($detail)
        loadAssessmentNewVehicleAssessment();
        @endif

        $('.item').on('click', function(e){

            let hasDisable = $(this).hasClass('disabled');
            let hash = this.hash;

            currentOffset = $(hash).offset().top;
            console.log('currentOffset ', currentOffset);

            if(!hasDisable){
                if (hash !== "") {
                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                // console.log($(hash).offset().top);
                // $('.scrollable-vertical').animate({
                //     scrollTop: $(hash).offset().top
                // }, 500, function(){

                //     // Add hash (#) to URL when done scrolling (default click behavior)
                //     // window.location.hash = hash;
                // });

                selectHash(this);

                }
            }

            setTimeout(() => {
                let body = $("body,html");
                body.stop().animate({scrollTop:0}, 300, 'swing', function() {
                // alert("Finished animating");
                });
            }, 300);
        });

        $('#frmAddDamageFormAssessment').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitVehicleDamageFormAssessment(formData);

        });



        $('[xaction]').on('click', function(){
            save_as = $(this).attr('xaction');

            if(save_as == 'verify'){
                let formData = new FormData($('#frm_vehicle_assessment')[0]);
                submitForVerification(formData, save_as);
            }
        });

        $('#frm_vehicle_assessment').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            submitAssesmentAccidentForm(formData);
        });

    })

</script>
