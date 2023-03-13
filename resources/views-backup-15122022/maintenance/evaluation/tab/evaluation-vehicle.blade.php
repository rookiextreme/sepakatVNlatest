
@php
$TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
@endphp

<form class="row" id="frm_vehicle" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="set_appointment">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend>MAKLUMAT KENDERAAN / ASET</legend>
                        @if($detail->hasStatus->code == '01')
                        <p><i class="fas fa-info-circle"></i>  Sila masukkan maklumat kenderaan yang hendak diperiksa.</p>
                            <div class="col-md-12">
                                <div class="btn-group">
                                        {{-- <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#submitMaintenanceEvaluationVehicle"><i class="fal fa-plus"></i> Kenderaan</a> --}}
                                        <button type="button" class="btn cux-btn bigger" id="addVehicleBtn" xaction="add_vehicle" onclick="addMaintenanceVehicle()"><i class="fal fa-plus"></i> Kenderaan</button>
                                        <button class="btn cux-btn bigger" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#maintenanceEvaluationVehicleDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>

                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-10 col-lg-11 col-md-12 mb-4" id="maintenance_evaluation_vehicle">

            </div>
        </div>
    </div>
    <hr/>
    <div class="form-group center">
        @if($is_myApp && in_array($detail->hasStatus->code, ['01']))
            <button {{$detail->hasVehicle->count()>0 ? '':'disabled'}} class="btn btn-module verify" data-id="{{$detail ? $detail->id : null}}">Hantar</button>
        @endif
        @if($is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
            <button class="btn btn-link" type="submit"><i class="fal fa-save"></i> Simpan sebagai Draf</button>
        @endif
    </div>
</form>

<div class="modal fade" id="maintenanceEvaluationVehicleDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="maintenanceEvaluationVehicleDelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah anda ingin menghapuskan maklumat ini ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                {{-- <button type="button" style="display: none" id="reload" class="btn btn-secondary"
                    onclick="window.location.reload()">Tutup</button> --}}
                <button type="button" id="remove" class="btn btn-danger text-white"
                    onclick="remove()" onclick="window.location.reload()">Hapus</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="selectMaintenanceEvaluationVehicle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="selectMaintenanceEvaluationVehicleLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5>Pilih Tarikh, Masa dan Woksyop</h5>
          </div>
        <form id="frmselectMaintenanceEvaluationVehicle" action="">
            <input type="hidden" name="detail_id" id="detail_id"/>
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <label for="" class="form-label text-dark">Masa & Tarikh <span class="text-danger">*</span></label>
                        <div class="input-group date form_datetime" id="app_datetime_container" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="app_datetime">
                            <input class="form-control text-center" size="16" id="app_datetime_select" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <label class="input-group-text" for="app_datetime_select">
                                <i class="fal fa-calendar-alt fa-2x"></i>
                            </label>
                        </div>
                        <input type="hidden" name="app_datetime" id="app_datetime" value="" />
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label text-dark">Woksyop <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control form-select" id="workshop_id" name="workshop_id">
                                <option selected value="">Sila Pilih</option>
                                @foreach ($workshop_list as $jkr_workshop)
                                    <option value="{{$jkr_workshop->id}}">{{$jkr_workshop->desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-module">Simpan</button>
                <button type="button" onclick="loadMaintenanceEvaluationVehicle()" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="submitMaintenanceEvaluationVehicle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="submitMaintenanceEvaluationVehicleLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Kenderaan
                    <div>Kenderaan yang akan dinilai</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddMaintenanceVehicle" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                      </button>
                    <p>
                        <i class="fas fa-info-circle"></i>  Maklumat yang diberikan haruslah betul dan ruangan bertanda <span class="text-danger">*</span> hendaklah diisi.
                        <div class="ms-2 mt-2" id="response"></div>
                    </p>
                </div>
                <input type="hidden" name="maintenance_vehicle_id" id="maintenance_vehicle_id">
                <fieldset>
                    <legend>Pengkelasan</legend>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No. Pendaftaran <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="VBA112" xplate_no onkeyup="this.value = this.value.toUpperCase()">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="" class="form-label text-dark">Lokasi Semasa Kenderaan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <textarea style="resize: none;" class="form-control" name="current_loc" id="current_loc" onkeyup="this.value = this.value.toUpperCase()" cols="30" rows="3"></textarea>
                                </div>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Maklumat Dalam Geran / VOC</legend>
                <div class="row">
                    <!--<p><i class="fas fa-info-circle"></i> Sila pastikan maklumat di bawah sama dengan Sijil Pemilikan Kenderaan (geran / VOC) :</p>-->

                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="engine_no" id="engine_no" placeholder="4D56-EL0995" xengine_no onkeyup="this.value = this.value.toUpperCase()">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Chasis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="chasis_no" id="chasis_no" placeholder="52WVC10338" xchasis_no onkeyup="this.value = this.value.toUpperCase()">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Buatan <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="vehicle_brand_id" id="brand" onchange="getVehicleModel(this.value)" xbrand_name>
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
                            <input type="text" class="form-control" name="model_name" id="model_name" placeholder="SAGA" xmodel_name onkeyup="this.value = this.value.toUpperCase()">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">Bahan Bakar <span class="text-danger">*</span> </label>
                            <select class="form-control form-select" name="fuel_type_id" id="fuel_type_id" onchange="getVehicleModel(this.value)" xbrand_name>
                                <option value="">Sila Pilih</option>
                                @foreach ($fuel_type_list as $fuel_type )
                                    <option value="{{$fuel_type->id}}">{{$fuel_type->desc}}</option>
                                @endforeach
                            </select>
                            <div class="hasErr"></div>
                        </div>
                    </div>
                </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-between">
            
                <div class="btn-group">
                    <button type="button" id="addVehicleInfo" class="btn btn-module float-start add_vehicle me-1">Tambah dan tutup</button>
                    {{-- <button type="button" class="btn btn-module float-start add_next_vehicle">Tambah dan seterusnya</button> --}}
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-module float-start edit_vehicle" style="display:none;">Simpan</button>
                    <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>
                </div>
                
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="displayMaintenanceEvalVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="displayMaintenanceEvalVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Kenderaan
                    <div>Kenderaan yang akan dinilai</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <div class="modal-body">
                <fieldset>
                    <legend>Pengkelasan</legend>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No. Pendaftaran</label>
                                <div id="plate_no"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <label for="" class="form-label text-dark">Lokasi Semasa Kenderaan </label>
                            <div id="current_loc"></div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Maklumat Dalam Geran / VOC</legend>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Enjin</label>
                            <div id="engine_no"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Chasis</label>
                            <div id="chasis_no"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Buatan</label>
                            <div id="vehicle_brand_id"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Model</label>
                            <div id="model_name"></div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="form-group">
                            <label for="" class="form-label">Bahan Bakar</label>
                            <div id="fuel_type_id"></div>
                        </div>
                    </div>
                </div>
                </fieldset>
            </div>
            <div class="modal-footer justify-content-between">
            
                <div class="btn-group">
                    <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Tutup</button>
                </div>
                
            </div>
      </div>
    </div>
</div>

<script type="text/javascript">

    let categoryId = null;
    let subCategoryId = null;
    let subCategoryTypeId = null;
    let vehicleBrandId = null;
    let vehicleModelId = null;

    function hide(element) {
            $(element).hide();
        }

    function checked_button(className, obj) {
        var $input = $(obj);
        if ($input.prop('checked')) $(className).show();
        else $(className).hide();
    }

    function getSubCategory(category_id){

        $('#list_sub_category').html('<option value="">Sila Pilih</option>');
        $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategory')}}", {
            category_id: category_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;
            let display_list_sub_category = $('#display_list_sub_category');

            if(count == 0){
                display_list_sub_category.hide();
            }
            else{
                display_list_sub_category.show();
                result.forEach(element => {
                    $('#list_sub_category').append('<option value='+element.id+'>'+element.name+'</option>');
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
                $('#list_sub_category').val(subCategoryId).trigger("change");
            }

        });
    }

    function getSubCategoryType(sub_category_id){

        $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategoryType')}}", {
            sub_category_id: sub_category_id
        }, function(result){

            let count = result.length;
            let totalInit = 0;
            let same = false;
            let display_list_sub_category_type = $('#display_list_sub_category_type');

            if (count == 0){
                display_list_sub_category_type.hide();
            }
            else{
                display_list_sub_category_type.show();
                result.forEach(element => {
                    $('#list_sub_category_type').append('<option value='+element.id+'>'+element.name+'</option>');
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

                //$('#list_sub_category_type').val(data.sub_category_type_id).trigger("change");
                $('#list_sub_category_type').val(subCategoryTypeId).trigger("change");
            }

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

    const loadMaintenanceEvaluationVehicle = function() {

        let hasCheckedIds = $('[name="chkdel"]:checked').length;

        $.get("{{ route('maintenance.evaluation.vehicle.list') }}", function(result){
            $('#maintenance_evaluation_vehicle').html(result);
            if($('#maintenance_evaluation_vehicle [data-vehicle]').length > 0){
                $('.verify').prop('disabled', false);

                if(hasCheckedIds > 0){
                    $('[xaction="delete_all"]').prop('disabled', false);
                } else {
                    $('[xaction="delete_all"]').prop('disabled', true);
                }
                
                $('#addVehicleBtn').hide();
                $('#addVehicleBtn').parent().removeClass('btn-group');
                
            } else {
                $('.verify').prop('disabled', true);
                $('#addVehicleInfo').prop('disabled', true);
                $('[xaction="delete_all"]').prop('disabled', true);
                $('#addVehicleBtn').show();
                $('#addVehicleBtn').parent().addClass('btn-group');
                addVehicleInfo
            }

            $('#close').show();
            $('#remove').show();
            
            init_func_vehicle_list();
        });
    }

    const init_form_to_value_zero = function(){
        $("#frmAddMaintenanceVehicle #category").select2("val", 1);
        $("#frmAddMaintenanceVehicle #brand").select2("val", 1);
        $("#frmAddMaintenanceVehicle #fuel_type_id").select2("val", 1);
        $('#maintenance_vehicle_id').val("");
        $('.lo_no').show();
        $('#frmAddMaintenanceVehicle')[0].reset();
    }

    const init_func_vehicle_list = function(){

        $('[name="chkall"]').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(ids.length > 0){
                    $('#delete_all').prop('disabled', false);
                }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

        $('[name="chkall"]').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });
    }

    function remove(){
        $('#maintenanceEvaluationVehicleDelModal #remove').hide();
        $('#maintenanceEvaluationVehicleDelModal #close').hide();
        $.post("{{route('maintenance.evaluation.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(response){
            $('#frm_vehicle #response').html('<span class="text-warning">'+response.message+'</span>').fadeIn(50).fadeOut(5000);
            $('#maintenanceEvaluationVehicleDelModal').modal('hide');
            loadMaintenanceEvaluationVehicle();
        })
    }

    const submitMaintenanceEvaluationVehicle = function(data) {

        let form = $('#frmAddMaintenanceVehicle');
        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {

                $('#frmAddMaintenanceVehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                var bench = response.bench;
                if(bench == 'create'){
                    addNextVehicle();
                }
                loadMaintenanceEvaluationVehicle();

                if(response.total_vehicle > 0){
                    $('#frm_vehicle .verify').prop('disabled', true);
                    
                } else {
                    $('#frm_vehicle .verify').prop('disabled', false);
                }

                if(data.get('mode') == 'add_and_close'){
                    form.find('.add_vehicle').prop('disabled', true);
                    form.find('.add_next_vehicle').prop('disabled', true);
                    $('#submitMaintenanceEvaluationVehicle').modal('hide');
                } else if(data.get('mode') == 'add_and_next'){
                    form[0].reset();
                    $('#brand').val(null).trigger("change");
                    $('#fuel_type_id').val(null).trigger("change");
                    form.find('.add_vehicle').prop('disabled', true);
                    form.find('.add_next_vehicle').prop('disabled', true);
                };

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

    const selectMaintenanceEvaluationVehicle = function(id){
        $('#selectMaintenanceEvaluationVehicle').find('#detail_id').val(id);
    }

    const assignVehicleAppointment = function(data){
        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle.assignAppointment') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#selectMaintenanceEvaluationVehicle').modal('hide');
                loadMaintenanceEvaluationVehicle();
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

    function selectHash(self){
        $('.selected').removeClass('selected disabled');

        let hash = window.location.hash;
        $(self).addClass('selected disabled');
    }

    const init_func_vehicle_edit = function(){

        $('#frmEditMaintenanceVehicle').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitEditMaintenanceEvaluationVehicle(formData);

        });

        $('#frmEditMaintenanceVehicle select').select2({
            width: '100%',
            theme: "classic"
        });
    }

    const addMaintenanceVehicle = function(){
        init_form_to_value_zero();
        let submitMaintenanceEvaluationVehicle = $('#submitMaintenanceEvaluationVehicle');
        let display_list_sub_category = $('#display_list_sub_category');
        let display_list_sub_category_type = $('#display_list_sub_category_type');
        let add_vehicle = $('.add_vehicle');
        let add_next_vehicle = $('.add_next_vehicle');
        let edit_vehicle = $('.edit_vehicle');
        display_list_sub_category.hide();
        display_list_sub_category_type.hide();
        add_vehicle.show();
        add_next_vehicle.show();
        edit_vehicle.hide();

        submitMaintenanceEvaluationVehicle.modal('show');
    }

    const addNextVehicle = function() {
        $("#frmAddMaintenanceVehicle #plate_no").val("");
    }

    const displayMaintenanceEvalVehicle = function(self){
        let data = $(self).parent().parent().data('vehicle');
        let brand = $(self).parent().parent().data('brand');
        let purpose_type = $(self).parent().parent().data('purpose_type');
        let fuel_type = $(self).parent().parent().data('fuel_type');
        
        let targetModal = $('#displayMaintenanceEvalVehicleModal');
        
        targetModal.find('#purpose_type').html(purpose_type);
        targetModal.find('#complaint_damage').html(data.complaint_damage);
        targetModal.find('#last_service_dt').html(moment(data.last_service_dt).format('DD/MM/YYYY'));
        targetModal.find('#plate_no').html(data.plate_no);
        targetModal.find('#current_loc').html(data.current_loc);
        targetModal.find('#chasis_no').html(data.chasis_no);
        targetModal.find('#engine_no').html(data.engine_no);
        targetModal.find('#vehicle_brand_id').html(brand.name);
        targetModal.find('#model_name').html(data.model_name);
        targetModal.find('#fuel_type_id').html(fuel_type);
        targetModal.modal('show');
    }

    const editMaintenanceVehicle = function(vehicle_id){

        parent.startLoading();

        let editMaintenanceVehicleModal = $('#submitMaintenanceEvaluationVehicle');
        $('#display_list_sub_category').show();
        $('#display_list_sub_category_type').show();
        $.ajax({
            url: '{{Route("maintenance.evaluation.vehicle.getVehicleForm")}}',
            type: 'get',
            data: {
                "vehicleId": vehicle_id
            },
            dataType: 'json',
                success: function(data) {

                    $('.add_vehicle').hide();
                    $('.add_next_vehicle').hide();
                    $('.edit_vehicle').show();
                    $('#maintenance_vehicle_id').val(data.id);

                    categoryId = data.category_id;
                    subCategoryId = data.sub_category_id;
                    subCategoryTypeId = data.sub_category_type_id;

                    $('#category').val(data.category_id).trigger("change");
                    $('[xplate_no]').val(data.plate_no);
                    $('[xengine_no]').val(data.engine_no);
                    $('[xchasis_no]').val(data.chasis_no);
                    $('#brand').val(data.vehicle_brand_id).trigger("change");
                    $('[xmodel_name]').val(data.model_name);
                    $('#fuel_type_id').val(data.fuel_type_id).trigger("change");
                    $('#current_loc').val(data.current_loc);

                    init_func_vehicle_edit();

                    parent.stopLoading();
                }
            });
            editMaintenanceVehicleModal.modal('show');

    }

    function checkExistRegNumber(plate_no){
        $('.hasErr').html('');
        let vehicle_id = $('#maintenance_vehicle_id').val();
        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle.checkExistRegNumber') }}",
            type: 'post',
            data: {
                vehicle_id: vehicle_id,
                plate_no: plate_no,
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(isExist) {

                let errorsHtml = '';
                let addBtn = $('.add_vehicle');
                let addNextBtn = $('.add_next_vehicle');
                if(isExist == 1){
                    let key = 'plate_no';
                    if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                        $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">No Pendaftaran '+plate_no+' Telah Wujud</div>');
                        addBtn.prop('disabled', true);
                        addNextBtn.prop('disabled', true);
                    }
                } else {
                    addBtn.prop('disabled', false);
                    addNextBtn.prop('disabled', false);
                }
            }
        });
    }

    $(document).ready(function(){

        @if($detail)
        loadMaintenanceEvaluationVehicle();
        @endif

        let otherAppoinmentDtContainer = $('#otherAppoinmentDtContainer').datetimepicker({
            autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD h:m');
            $('#other_appoinment_dt').val(formatedValue);
        });

        let purchaseDt = $('#purchaseDt').datetimepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY-MM-DD'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD');
            $('#purchase_dt').val(formatedValue);
            console.log(formatedValue);
        });

        let registrationVehicleDt = $('#registrationVehicleDt').datetimepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY-MM-DD'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD');
            $('#registration_vehicle_dt').val(formatedValue);
            console.log(formatedValue);
        });

        let manufactureYear = $('#manufactureYear').datepicker({
            language:  'ms',
            keyboardNavigation: false,
            viewMode: "years",
            minViewMode: "years",
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY');
            $('#manufacture_year').val(formatedValue);
            console.log(formatedValue);
        });

        $('#appointment_dt').on('change', function(e){
            e.preventDefault();

            let other_datetime_container = $('#other_datetime_container');

            if(this.value == 'other_appointment_dt')
            {
                other_datetime_container.show();
            }else{
                other_datetime_container.hide();
            }
        });

        $('#plate_no').on('keyup', function (e) {
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

        $('#plate_no').on('change', function(e){
            e.preventDefault();
            checkExistRegNumber(this.value);
        });

        $('#frmAddMaintenanceVehicle').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitMaintenanceEvaluationVehicle(formData);

        });

        let app_datetime_container = $('#app_datetime_container').datetimepicker({
            language:  'ms',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1,
            startDate: moment().add(1,'days').format('YYYY-MM-DD 00:00:01')
        });

        $('.add_vehicle').on('click', function(e){
            e.preventDefault();

            let form = $('#frmAddMaintenanceVehicle');
            let formData = new FormData(form[0]);
            formData.append('mode','add_and_close');
            submitMaintenanceEvaluationVehicle(formData);
            $('#submitMaintenanceEvaluationVehicle').modal('hide');
            
        });

        $('.add_next_vehicle').on('click', function(e){
            e.preventDefault();

            let form = $('#frmAddMaintenanceVehicle');
            let formData = new FormData(form[0]);
            formData.append('mode','add_and_next');
            submitMaintenanceEvaluationVehicle(formData);
            
        });


        $('#frmselectMaintenanceEvaluationVehicle').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            assignVehicleAppointment(formData);
        });

    })

</script>
