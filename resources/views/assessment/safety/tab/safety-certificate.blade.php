
@php
$TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_cerificate" enctype="multipart/form-data">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>

    @csrf

    <input type="hidden" name="section" value="generate_certificate">

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Maklumat Sijil</legend>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="assessment_safety_vehicle_certificate">

    </div>

</form>
<div class="modal fade" id="editCertificateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="editCertificateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Sijil
                    <div>Keselamatan & Prestasi kenderaan yang telah dinilai</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>

            </div>
            <form id="frmEditCertificate" action="">
            @csrf
            <div class="modal-body" style="width:97%">
                <input type="hidden" name="assessment_vehicle_id" id="assessment_vehicle_id" xvehicleId>
                {{-- <fieldset>
                    <legend>Maklumat Pemohon</legend>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Ketua Jabatan (Gelaran) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="ketua_jabatan" id="ketua_jabatan" xkjbtn onchange="this.value = this.value.toUpperCase()" maxlength="255">
                                <div class="hasErr"></div>
                                <span id="ketua_jabatan"></span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Jabatan / Agensi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="jabatan_agensi" id="jabatan_agensi" xjbtna onchange="this.value = this.value.toUpperCase()" maxlength="255">
                                <div class="hasErr"></div>
                                <span id="jabatan_agensi"></span>
                            </div>
                        </div>
                    </div>
                </fieldset> --}}
                <fieldset>
                    <legend>Maklumat Dalam Geran / VOC</legend>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No. Pendaftaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="plate_no" id="plate_no" xpendaftaran onchange="this.value = this.value.toUpperCase()" maxlength="12">
                                <div class="hasErr"></div>
                                <span id="no_pendaftaran2"></span>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Chasis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="chasis_no" id="chasis_no" xcasis_no placeholder="52WVC10338" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="engine_no" id="engine_no" xenjin_no placeholder="4D56-EL0995" onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Buatan <span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="vehicle_brand_id" id="brand" onchange="getVehicleModel(this.value)" xbrand>
                                    <option value="">Sila Pilih</option>
                                    @foreach ($brand_list as $brand )
                                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                                    @endforeach
                                </select>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Model <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="model_name" id="model_name" placeholder="SAGA" xmodelname onchange="this.value = this.value.toUpperCase()" maxlength="250">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Odometer (km) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="odometer" id="odometer" xodometer onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" id="category" class="form-control form-select" onchange="getSubCategory(this.value)" xkategori>
                                    <option value="">Sila Pilih</option>
                                    @foreach ($category_list as $category)
                                        <option value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                                    @endforeach
                                </select>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label for="" class="form-label text-dark">Sub Kategori <span class="text-danger">*</span></label>
                                <select name="sub_category_id" id="list_sub_category_2" class="form-control form-select" onchange="getSubCategoryType(this.value)" >
                                    <option value="">Sila Pilih</option>
                                </select>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Jenis <span class="text-danger">*</span></label>
                                <select name="sub_category_type_id" id="list_sub_category_type_2" class="form-control form-select" >
                                    <option value="">Sila Pilih</option>
                                </select>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9" >
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Sebab <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="reason_changed" id="reason_changed" cols="20" rows="4"></textarea>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer flex justify-content-start">
                <button type="submit" class="btn btn-module float-start">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-times"></i> Tutup</button>
            </div>
        </form>
      </div>
    </div>
</div>

<script type="text/javascript">

    loadAssessmentSafetyVehicleCertificate = function() {
        $.get("{{ route('assessment.safety.vehicle-certificate.list') }}", function(result){
            $('#assessment_safety_vehicle_certificate').html(result);
        });
    }

    function getVehicleModel(brand_id){

        $('#list_vehicle_model').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getVehicleModel')}}", {
            brand_id: brand_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;

            result.forEach(element => {
                $('#list_vehicle_model').append('<option value='+element.id+'>'+element.name+'</option>');
                totalInit++;
                if(vehicleModelId == element.id){
                    same = true;
                }
            });

            if(count == totalInit){
                if(!same){
                    vehicleModelId = null;
                }
                $('#list_vehicle_model').val(vehicleModelId).trigger("change");
            }

        });
    }

    function getSubCategory(category_id){

        $('#list_sub_category_2').html('<option value="">Sila Pilih</option>');
        $('#list_sub_category_type_2').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategory')}}", {
            category_id: category_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;

            if(count == 0){

            }
            else{

                result.forEach(element => {
                    $('#list_sub_category_2').append('<option value='+element.id+'>'+element.name+'</option>');
                    if(subCategoryId == element.id){
                        same = true;
                    }
                    totalInit++;
                });
            }

            if(count == totalInit){
                if(!same){
                    subCategoryId = null;
                }
                $('#list_sub_category_2').val(subCategoryId).trigger("change");
            }

        });
    }

    function getSubCategoryType(sub_category_id){

        $('#list_sub_category_type_2').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategoryType')}}", {
            sub_category_id: sub_category_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;


            if (count == 0){

            }
            else{

                result.forEach(element => {
                    $('#list_sub_category_type_2').append('<option value='+element.id+'>'+element.name+'</option>');
                    totalInit++;
                    if(subCategoryTypeId == element.id){
                        same = true;
                    }
                });
            }


            if(count == totalInit){
                if(!same){
                    subCategoryTypeId = null;
                }

                console.log('subCategoryTypeId', subCategoryTypeId);

                //$('#list_sub_category_type_2').val(data.sub_category_type_id).trigger("change");
                $('#list_sub_category_type_2').val(subCategoryTypeId).trigger("change");
            }

        });
    }

    editCertificate = function(vehicle_id, assessment_id){
        parent.startLoading();
        let editCertificateModal = $('#editCertificateModal');
        $.ajax({
        url: '{{Route("assessment.safety.vehicle.getCertificateDetails")}}',
        type: 'get',
        data: {
            "vehicleId": vehicle_id,
            "assessment_id": assessment_id,
        },
        dataType: 'json',
            success: function(data){

                categoryId = data.category_id;
                subCategoryId = data.sub_category_id;
                subCategoryTypeId = data.sub_category_type_id;
                $('[xvehicleId]').val(data.id);
                $('[xpendaftaran]').val(data.plate_no);
                $('[xenjin_no]').val(data.engine_no);
                $('[xcasis_no]').val(data.chasis_no);
                $('[xbrand]').val(data.vehicle_brand_id).trigger("change");
                $('[xmodelname]').val(data.model_name);

                $('[xkategori]').val(data.category_id).trigger("change");

                $('[xodometer]').val(data.odometer);

                $('[xkjbtn]').val(data.hod_title);

                $('[xjbtna]').val(data.department_name);

                parent.stopLoading();
            }
        });

        editCertificateModal.modal('show');

    }

    submitEditCertificate = function(data) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('assessment.safety.vehicle.editCertificate.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_cerificate #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                $('#frmEditCertificate')[0].reset();
                $('#editCertificateModal').modal('hide');
                loadAssessmentSafetyVehicleCertificate();
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

    $(document).ready(function(){
        loadAssessmentSafetyVehicleCertificate();

        $('#frmEditCertificate').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            submitEditCertificate(formData);
        });
    })

</script>
