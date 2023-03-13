
@php
$TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
$assessment_id = Request('id');
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentVehicleImage;
$AssessmentVehicleDetail =  AssessmentAccidentVehicle::where('assessment_accident_id', $assessment_id)->first();

$OwnImage = AssessmentVehicleImage::where('vehicle_id', $AssessmentVehicleDetail->id)->where('assessment_type_id', 3)->get();
@endphp

<form class="row" id="frm_evaluation" enctype="multipart/form-data">

    @csrf

    <input type="hidden" name="section" value="approval">
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
                <div class="row">
                    <div class="col-md-12">
                        <legend>Maklumat Semakan</legend>
                        <p>Sila Semak terlebih dahulu.</p>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-12 pt-3">
                        <div class="btn-group">
                            {{-- <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#addAssessmentVehicleModal"><i class="fal fa-plus"></i> Kenderaan</a> --}}
                            @if($detail->hasVehicle->hasAssessmentVehicleStatus->code == '04')
                                <a class="btn cux-btn bigger" onclick="addDamageFormEvaluation()"><i class="fal fa-plus"></i> Kerosakan</a>
                                <button class="btn cux-btn bigger delete_all" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#assessmentStruckDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12" id="assessment_accident_vehicle_evaluation">

            </div>
            <div class="col-md-9">
                <div class="row">
                </div>
            </div>
        </div>
    </div>
    {{-- @if($detail->hasStatus->code == '04') --}}
        <div class="col-md-12 form-group">
            <div class="row">
                <div class="col-md-12 mt-2 mb-2">
                    <div class="form-group center" id="hantar-button">
                        {{-- @if($detail->hasVehicle->given_value == true && $detail->hasVehicle->hasAssessmentVehicleStatus->code == '04')
                            <span  class="btn btn-module" onclick="prompAssessmentAccidentEvaluateModal()">Hantar</span>
                        @endif --}}
                        @if($detail->hasVehicle->hasAssessmentVehicleStatus->code == '04')
                        <span  class="btn btn-module" onclick="prompAssessmentAccidentEvaluateModal()">Hantar</span>
                        <button class="btn btn-link" type="submit"><i class="fas fa-save"></i> Simpan</button>
                        {{-- <span class="btn btn-danger" onclick="prompAssessmentNewRevokeModal()">Tolak</a> --}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    {{-- @endif --}}

</form>

<div class="modal fade" id="addDamageEvaluationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addDamageEvaluationModalLabel" aria-hidden="true">
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
            <form id="frmAddDamageFormEvaluation" action="">
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
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-md-6">
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
                        <img src="" id="">
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
    <div class="modal fade" id="assessmentAccidentEvaluationModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="assessmentAccidentEvaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah anda ingin meneruskan untuk pengesahan?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-secondary text-white" onclick="assessmentVehicleEvaluate(this)">Ya</button> --}}
                    <button class="btn btn-module" xaction="approval">Ya</button>
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

    prompAssessmentAccidentEvaluateModal = function(){
        $('#assessmentAccidentEvaluationModal').modal('show');
    }

    loadAssessmentAccidentVehicleEvaluation = function() {
        $.get("{{ route('assessment.accident.vehicle-evaluation-damage.list') }}", function(result){
            $('#assessment_accident_vehicle_evaluation').html(result);
        });
    }

    assessmentVehicleEvaluate = function(self){
        $(self).parent().find('#close').hide();
        $(self).text('Sila tunggu...').prop('disabled', true);
        $.post('{{route('assessment.accident.approval')}}', {
            '_token': '{{ csrf_token() }}'
        }, function(response){
            window.location.href = response.url;
        })
    }

    const submitVehicleDamageFormEvaluation = function(data) {

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
                $('#frmAddDamageFormEvaluation #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                $('#addDamageEvaluationModal').modal('hide');
                // addAssessmentVehicle();
                loadAssessmentAccidentVehicleEvaluation();
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

    submitVehicleTotalAdditionalCostEvaluation = function(data, save_as) {

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
                // window.location.href = response.url;
                // console.log(response);
                // $('#frm_evaluation #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                if(save_as == 'approval'){
                    window.location.href = response.url;
                }
                console.log('berjaya');
                loadAssessmentAccidentVehicleEvaluation();
                // $('#hantar-button').load(document.URL + ' #hantar-button');
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                    if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);
                        }
                    } else {
                        console.log('key', key)
                        if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                            $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>').fadeIn(500).fadeOut(5000);
                        }
                    }
                });
            }
        });
    }

    addDamageFormEvaluation = function(){
        $('#frmAddDamageFormEvaluation')[0].reset();
        $('#damage_id').val("");
        let addDamageEvaluationModal = $('#addDamageEvaluationModal');

        addDamageEvaluationModal.modal('show');
    }

    editDamageFormEvaluation = function(damageID){
        $('#frmAddDamageFormEvaluation')[0].reset();
        $('#damage_id').val("");
        let addDamageEvaluationModal = $('#addDamageEvaluationModal');
        $.ajax({
        url: '{{Route("assessment.accident.vehicle.getDamageForm")}}',
        type: 'get',
        data: {
            "damageID": damageID
        },
        dataType: 'json',
            success: function(data) {
                addDamageEvaluationModal.find('#damage_id').val(data.list.id);
                addDamageEvaluationModal.find('#damage').val(data.list.damage);
                addDamageEvaluationModal.find('#damage_note').val(data.list.damage_note);
                addDamageEvaluationModal.find('#price_list').val(data.list.price_list);
                let is_repair = data.list.is_repair;
                    if (is_repair == false){
                        addDamageEvaluationModal.find('#is_repair').prop("checked", false);
                    }else{
                        addDamageEvaluationModal.find('#is_repair').prop("checked", true);
                    }
                let is_replace = data.list.is_replace;
                    if (is_replace == false){
                        addDamageEvaluationModal.find('#is_replace').prop("checked", false);
                    }else{
                        addDamageEvaluationModal.find('#is_replace').prop("checked", true);
                    }
            }
        });
        addDamageEvaluationModal.modal('show');

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

    const updateDamageEstimatePrice = function(self){
        let data = {
            '_token': '{{ csrf_token() }}',
            'estimate_price': self.value
        };
        $.post('{{route('assessment.accident.vehicle.damage.update.estimate.price')}}',data);
    }

    $(document).ready(function(){
        loadAssessmentAccidentVehicleEvaluation();
        $('#frmAddDamageFormEvaluation').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitVehicleDamageFormEvaluation(formData);

        });

        $('[xaction]').on('click', function(){
            save_as = $(this).attr('xaction');

            if(save_as == 'approval'){
                let formData = new FormData($('#frm_evaluation')[0]);
                submitVehicleTotalAdditionalCostEvaluation(formData, save_as);
            }
        });

        $('#frm_evaluation').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitVehicleTotalAdditionalCostEvaluation(formData);

        });
    })

</script>
