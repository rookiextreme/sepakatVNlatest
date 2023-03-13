
@php
$TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
$assessment_id = Request('id');
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentVehicleImage;
$AssessmentVehicleDetail =  AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_id)->first();
$OwnImage = AssessmentVehicleImage::where('vehicle_id', $AssessmentVehicleDetail->id)->where('assessment_type_id', 3)->get();

@endphp

<form class="row" id="frm_approval" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="approve">
    <input type="hidden" name="assessment_id" value="{{$assessment_id}}">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <div class="col-md-12">
        <div class="row" id="reload_perdiv">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Gambar Kenderaan</legend>
                        <p></p>
                    </div>
                </div>
            </div>
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
                        <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$vehicleImage ? 'block' :'none'}}">
                    </div>
            @endforeach
        </div>
    </div>
    <fieldset></fieldset>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                @if(auth()->user()->isEngineerAssessment() || auth()->user()->isAdmin())
                    <div class="row">
                        <div class="col-md-12">
                            <legend>Maklumat Kelulusan</legend>
                            <p>Sila Semak terlebih dahulu sebelum membuat pengesahan.</p>
                        </div>
                    </div>
                @endif
                <div class="col-xl-12 col-lg-12 col-12 pt-3">
                    @if($detail->hasVehicle->hasAssessmentVehicleStatus->code == '05')
                    <div class="btn-group">
                        {{-- <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#addAssessmentVehicleModal"><i class="fal fa-plus"></i> Kenderaan</a> --}}
                        <a class="btn cux-btn bigger" onclick="addDamageFormApproval()"><i class="fal fa-plus"></i> Kerosakan</a>
                        <button class="btn cux-btn bigger delete_all" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#assessmentStruckDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-12" id="assessment_accident_vehicle_approval">

            </div>
        </div>
    </div>
    <div class="col-md-12 form-group">
        <div class="row">
            <div class="col-md-12 mt-2 mb-2">
                <div class="form-group center">
                    @if($detail->hasStatus->code == '05')
                        @if($detail->hasVehicle->hasAssessmentVehicleStatus->code == '05')
                            <span class="btn btn-module" onclick="prompassessmentAccidentApproveModal()">Sah</span>
                            <button class="btn btn-link" type="submit"><i class="fas fa-save"></i> Simpan</button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</form>

<div class="modal fade" id="addDamageApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addDamageApprovalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Butir Kerosakan
                    <div>Berikan butiran kerosakan pada kenderaan subjek</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddDamageFormApproval" action="">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="damage_id" id="damage_id" class="form-control">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Kerosakan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="damage" id="damage" placeholder="cth. Fender depan remuk" xplate_no onchange="this.value = this.value.toUpperCase()">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Nota</label>
                                <textarea name="damage_note" id="damage_note" class="form-control" cols="30" rows="3"></textarea>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Syor <span class="text-danger">*</span></label>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input mt-2 me-2" name="is_repair" id="is_repair">
                                    <label class="form-check-label cursor-pointer" for="check_all"> Baiki</label>
                                </div>
                                <div class="hasErr"></div>
                                <div class="form-switch">
                                    <input type="checkbox" class="form-check-input mt-2 me-2" name="is_replace" id="is_replace">
                                    <label class="form-check-label cursor-pointer" for="check_all"> Ganti</label>
                                </div>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        {{-- <div class="col-xl-4 col-lg-4 col-md-3">
                            <div class="form-group">
                                <br>
                                <label for="" class="form-label text-dark">Kiraan Harga (RM) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="price_list" id="price_list">
                                <div class="hasErr"></div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="damage" class="form-label text-dark">Gambar</label>
                                    <label type="button" for="damage_picture" class="btn cux-btn bigger" style="margin-top:2px"><i class="fa fa-file-image"></i> Muat Naik Foto</label>
                                    <input class="form-control d-none" accept="image/*" type="file" name="damage_picture" id="damage_picture" />
                                    {{-- <label for="" class="form-label  text-dark">Gambar <span class="text-danger">*</span></label>
                                    <div class="col-md-9"><label for="damage_picture" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Foto</label></div>
                                    <input class="form-control d-none" accept="image/*" type="file" id="damage_picture" /> --}}
                                </div>
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
    <div class="modal fade" id="assessmentAccidentApproveModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentAccidentApproveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah anda ingin mengesahkan maklumat ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-secondary text-white" onclick="assessmentVehicleApprove(this)">Ya</button> --}}
                    <button class="btn btn-module" xaction="approve">Ya</button>
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

    prompassessmentAccidentApproveModal = function(){
        $('#assessmentAccidentApproveModal').modal('show');
    }

    loadAssessmentNewVehicleApproval = function() {
        $.get("{{ route('assessment.accident.vehicle-approval-damage.list') }}", function(result){
            $('#assessment_accident_vehicle_approval').html(result);
        });
    }

    assessmentVehicleApprove = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.accident.approve')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    const submitVehicleDamageFormApproval = function(data) {

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
                $('#frmAddDamageFormApproval #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                $('#addDamageApprovalModal').modal('hide');
                // addAssessmentVehicle();
                loadAssessmentNewVehicleApproval();
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

    addDamageFormApproval = function(){
        $('#frmAddDamageFormApproval')[0].reset();
        $('#damage_id').val("");
        let addDamageApprovalModal = $('#addDamageApprovalModal');

        addDamageApprovalModal.modal('show');
    }

    submitVehicleTotalAdditionalCostApproval = function(data, save_as) {

        $('.hasErr').html('');
        data.append('save_as', save_as);

        $.ajax({
            url: "{{ route('assessment.accident.vehicle.damage.cost') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                if(save_as == 'approve'){
                        window.location.href = response.url;
                    }
                loadAssessmentNewVehicleApproval();
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

    editDamageFormApproval = function(damageID){
        $('#frmAddDamageFormApproval')[0].reset();
        $('#damage_id').val("");
        let addDamageApprovalModal = $('#addDamageApprovalModal');
        $.ajax({
        url: '{{Route("assessment.accident.vehicle.getDamageForm")}}',
        type: 'get',
        data: {
            "damageID": damageID
        },
        dataType: 'json',
            success: function(data) {
                addDamageApprovalModal.find(".add_vehicle").hide();
                addDamageApprovalModal.find(".edit_vehicle").show();
                addDamageApprovalModal.find('#damage_id').val(data.list.id);
                addDamageApprovalModal.find('#damage').val(data.list.damage);
                addDamageApprovalModal.find('#damage_note').val(data.list.damage_note);
                if(data.list.price_list){
                    addDamageApprovalModal.find('#price_list').val(data.list.price_list.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
                let is_repair = data.list.is_repair;
                    if (is_repair == false){
                        addDamageApprovalModal.find('#is_repair').prop("checked", false);
                    }else{
                        addDamageApprovalModal.find('#is_repair').prop("checked", true);
                    }
                let is_replace = data.list.is_replace;
                    if (is_replace == false){
                        addDamageApprovalModal.find('#is_replace').prop("checked", false);
                    }else{
                        addDamageApprovalModal.find('#is_replace').prop("checked", true);
                    }
                parent.stopLoading();
            }
        });
        addDamageApprovalModal.modal('show');

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

    function openEnlargeModal(self){

            $('#enlargeImageModal img').attr('src', $(self).attr('src'));
            $('#enlargeImageModal').modal('show');
        }

    // assessmentVehicleReject = function(){
    //     $.post('{{route('assessment.accident.reject')}}', {
    //         '_token': '{{ csrf_token() }}'
    //     }, function(response){
    //         window.location.href = response.url;
    //     })
    // }

    $(document).ready(function(){
        loadAssessmentNewVehicleApproval();

        $('#frmAddDamageFormApproval').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitVehicleDamageFormApproval(formData);

        });

        $('[xaction]').on('click', function(){
            save_as = $(this).attr('xaction');

            if(save_as == 'approve'){
                let formData = new FormData($('#frm_approval')[0]);
                submitVehicleTotalAdditionalCostApproval(formData, save_as);
            }
        });

        $('#frm_approval').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitVehicleTotalAdditionalCostApproval(formData);

        });
    })

</script>
