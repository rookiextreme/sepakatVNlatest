
@php
$TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
@endphp
<link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">

</style>
<form class="row" id="frm_vehicle" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="section" value="set_appointment">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <fieldset>
        <legend>MAKLUMAT KENDERAAN</legend>
        @if($detail->hasStatus->code == '01')
        <div class="col-12 pt-2 mb-2">
            <div class="btn-group">
                    {{-- <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#addAssessmentVehicleModal"><i class="fal fa-plus"></i> Kenderaan</a> --}}
                    <a class="btn cux-btn bigger" onclick="addAssessmentVehicle()"><i class="fal fa-plus"></i> Kenderaan</a>
                    <button class="btn cux-btn bigger" id="delete_all" data-bs-toggle="modal" data-bs-target="#assessmentNewVehicleDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
            </div>
        </div>
        @endif
        <div class="col-xl-12 col-lg-12 col-md-12 mb-2" id="assessment_new_vehicle"></div>
    </fieldset>
    <hr/>
    <div class="form-group center">
        @if($is_myApp)
            @if($detail->hasStatus->code == '01')
                <button {{$detail && $detail->hasVehicle && $detail->hasVehicle->count()>0 ? '':'disabled'}} class="btn btn-module verify" data-id="{{$detail ? $detail->id : null}}"><i class="fal fa-paper-plane icon-white"></i>&nbsp;&nbsp;Hantar</button>

            @endif
        @endif
        @if($detail->hasStatus->code == '01')
            <button class="btn btn-link" type="submit" formnovalidate><i class="fal fa-save"></i>&nbsp;&nbsp;Simpan</button>
        @endif
    </div>
</form>

<div class="modal fade" id="assessmentNewVehicleDelModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="assessmentNewVehicleDelModalLabel" aria-hidden="true">
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
                <button type="button" style="display: none" id="reload" class="btn btn-secondary"
                    onclick="window.location.reload()">Tutup</button>
                <button type="button" id="remove" class="btn btn-danger text-white"
                    onclick="remove()">Hapus</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="assignAssessmentVehicleAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="assignAssessmentVehicleAppointmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5>Pilih Tarikh, Masa dan Woksyop</h5>
          </div>
        <form id="frmAssignAssessmentVehicleAppointment" action="">
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
                <button type="button" onclick="loadAssessmentNewVehicle()" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="addAssessmentVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addAssessmentVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Kenderaan
                    <div>Kenderaan baharu yang akan dinilai</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddAssessmentVehicle" action="">
            @csrf
            <div class="modal-body" style="width:97%">
                @if($detail->hasStatus->code == '01')
                <div class="row">
                    <p>
                        <i class="fas fa-info-circle"></i>  Maklumat yang diberikan haruslah betul dan ruangan bertanda <span class="text-danger">*</span> hendaklah diisi.
                    </p>
                </div>
                @endif
                <input type="hidden" name="assessment_vehicle_id" id="assessment_vehicle_id">
                <fieldset>
                    <legend>Maklumat Dalam Geran / VOC</legend>
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No. Pendaftaran <span class="text-danger">*</span></label>

                                <input type="text" class="{{$detail->hasStatus->code == '01' ? "form-control" : "txt-data"}}" name="plate_no" id="plate_no" placeholder="VBA112" xplate_no onchange="this.value = this.value.toUpperCase()" maxlength="20" {{$detail->hasStatus->code == '01' ? "" : "disabled"}}>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Enjin <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="engine_no" id="engine_no" placeholder="4D56-EL0995" xengine_no onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Chasis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="chasis_no" id="chasis_no" placeholder="52WVC10338" xchasis_no onchange="this.value = this.value.toUpperCase()" maxlength="30">
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
                                <input type="text" class="form-control" name="model_name" id="model_name" placeholder="SAGA" xmodel_name onchange="this.value = this.value.toUpperCase()" maxlength="30">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Tahun Dibuat <span class="text-danger">*</span> </label>

                                <div class="input-group date" id="manufactureYear" data-date="" data-date-format="yyyy" data-link-field="manufacture_year">
                                    <input class="form-control" size="16" id="manufactureYearInput" xmanufacture_year type="text" value="" placeholder="2021" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    <label class="input-group-text" for="manufactureYearInput">
                                        <i class="fal fa-calendar-alt"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="manufacture_year" id="manufacture_year" xmanufacture_year value="" />
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Tarikh Pendaftaran <span class="text-danger">*</span> </label>

                                <div class="input-group date" id="registrationVehicleDt" data-date="" data-date-format="dd/mm/yyyy">
                                    <input class="form-control" size="16" id="registrationVehicleDtInput"  type="text" value="" placeholder="TARIKH PENDAFTARAN" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    <label class="input-group-text" for="registrationVehicleDtInput">
                                        <i class="fal fa-calendar-alt"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="registration_vehicle_dt" id="registration_vehicle_dt"  value="" />
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Pengkelasan</legend>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" id="category" class="form-control form-select" onchange="getSubCategory(this.value)" >
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
                                <select name="sub_category_id" id="list_sub_category" class="form-control form-select" onchange="getSubCategoryType(this.value)" >
                                    <option value="">Sila Pilih</option>
                                </select>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Jenis <span class="text-danger">*</span></label>
                                <select name="sub_category_type_id" id="list_sub_category_type" class="form-control form-select" >
                                    <option value="">Sila Pilih</option>
                                </select>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Maklumat Perolehan</legend>
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Tarikh Pembelian <span class="text-danger">*</span> </label>
                                <div class="input-group date form_datetime" id="purchaseDt" data-date="" data-date-format="dd/mm/yyyy">
                                    <input class="form-control" size="16" id="purchaseDtInput" xpurchase_dt type="text" value="" placeholder="TARIKH BELI" readonly>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    <label class="input-group-text" for="purchaseDtInput">
                                        <i class="fal fa-calendar-alt"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="purchase_dt" id="purchase_dt" xpurchase_dt value="" />
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Nama Syarikat / Pembekal <span class="text-danger">*</span></label>
                                <input onchange="this.value = this.value.toUpperCase()" type="text" class="form-control" name="company_name" id="company_name" placeholder="SYARIKAT SDN BHD" xcompany_name>
                                <div class="hasErr"></div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Milik Kerajaan <span class="text-danger">&nbsp;</span></label>
                                <div class="form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_gover" name="is_gover" checked onclick="checked_button('.lo_no', this)">
                                </div>

                                <!--<div class="form-check-inline">
                                    <input type="radio" class="form-check-input mt-1 cursor-pointer" name="is_gover" id="is_gover" value="1"> <label class="cursor-pointer" for="is_gover"> Ya</label>
                                </div>
                                <div class="form-check-inline">
                                    <input type="radio" class="form-check-input mt-1 cursor-pointer" name="is_gover" id="is_non_gover" value="0"> <label class="cursor-pointer" for="is_non_gover"> Tidak</label>
                                </div>
                                <div class="hasErr"></div>-->
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4">
                            <div class="form-group lo_no" style="display:block;">
                                <label for="" class="form-label text-dark">No Pesanan Kerajaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lo_no" id="lo_no" placeholder="" xlo_no onchange="this.value = this.value.toUpperCase()" maxlength="25">
                                <div class="hasErr"></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            @if($detail->hasStatus->code == '01')
            <div class="modal-footer flex justify-content-start">
                <button type="submit" class="btn btn-module float-start add_vehicle" disabled style="display:block;" >Tambah</button>
                <button type="submit" class="btn btn-module float-start edit_vehicle" style="display:none;">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>-->
            </div>
            @else
            <div class="modal-footer flex justify-content-start">
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-times"></i> Tutup</button>
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>-->
            </div>
            @endif
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="viewVehicleInformation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="viewVehicleInformationLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Maklumat Kenderaan
                    <div>Kenderaan baharu yang akan dinilai</div>
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddAssessmentVehicle" action="">
            @csrf
            <div class="modal-body" style="width:97%">
                <input type="hidden" name="assessment_vehicle_id" id="assessment_vehicle_id">
                <fieldset>
                    <legend>Maklumat Dalam Geran / VOC</legend>
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No. Pendaftaran </label>
                                <div class="txt-data ass_new"><span id="no_pendaftaran" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Enjin </label>
                                <div class="txt-data ass_new"><span id="no_enjin" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">No Chasis </label>
                                <div class="txt-data ass_new"><span id="no_casis" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Buatan </label>
                                <div class="txt-data ass_new"><span id="nama_buatan" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Model </label>
                                <div class="txt-data ass_new"><span id="nama_model" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Tahun Dibuat  </label>
                                <div class="txt-data ass_new"><span id="tahun_dibuat" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Tarikh Pendaftaran  </label>
                                <div class="txt-data ass_new"><span id="tarikh_pendaftaran" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Pengkelasan</legend>
                    <div class="row">
                        <div class="col-xl-3 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Kategori </label>
                                <div class="txt-data ass_new"><span id="kategori" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" id="display_list_sub_category" style="display:none;">
                                <label for="" class="form-label text-dark">Sub Kategori </label>
                                <div class="txt-data ass_new"><span id="sub_kategori" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-md-4" xfunction="sub_category_type_id" id="display_list_sub_category_type" style="display:none;">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Jenis </label>
                                <div class="txt-data ass_new"><span id="jenis_kenderaan" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Maklumat Perolehan</legend>
                    <div class="row">
                        <div class="col-xl-2 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="" class="form-label">Tarikh Pembelian  </label>
                                <div class="txt-data ass_new"><span id="tarikh_pembelian" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Nama Syarikat / Pembekal </label>
                                <div class="txt-data ass_new"><span id="nama_syarikat" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-4">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Milik Kerajaan <span class="text-danger">&nbsp;</span></label>
                                <div class="form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="milik_kerajaan" name="milik_kerajaan" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4">
                            <div class="form-group lo_no" style="display:block;">
                                <label for="" class="form-label text-dark">No Pesanan Kerajaan </label>
                                <div class="txt-data ass_new"><span id="no_lo_ker" class="txt-data ass_new"></span></div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer flex justify-content-start">
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-times"></i> Tutup</button>
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>-->
            </div>
        </form>
      </div>
    </div>
</div>


<script type="text/javascript">

    let categoryId = null;
    let subCategoryId = null;
    let subCategoryTypeId = null;
    let vehicleBrandId = null;
    let vehicleModelId = null;
    let ids = [];
    let currentPage = 1;

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

    loadAssessmentNewVehicle = function() {
        let data = {
            'page': currentPage,
        }
        $.get("{{ route('assessment.new.vehicle.list') }}", data, function(result){
            $('#assessment_new_vehicle').html(result);
            let totalVehicle = $('#assessment_new_vehicle tbody tr.vehicle').length;
            let btnVerify = $('.verify');
            if(totalVehicle>0){
                btnVerify.prop('disabled', false);
            } else {
                btnVerify.prop('disabled', true);
            }
            init_func_vehicle_list();
        });
    }

    init_form_to_value_zero = function(){
        $("#frmAddAssessmentVehicle #category").select2("val", 1);
        $("#frmAddAssessmentVehicle #brand").select2("val", 1);
        $('#assessment_vehicle_id').val("");
        $('.lo_no').show();
        $('#frmAddAssessmentVehicle')[0].reset();
    }

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }

    init_func_vehicle_list = function(){

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
        $('#assessmentNewVehicleDelModal #remove').hide();
        $('#assessmentNewVehicleDelModal #close').hide();
        $.post("{{route('assessment.new.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(response){
            $('#frm_vehicle #response').html('<span class="text-warning">'+response.message+'</span>').fadeIn(50).fadeOut(5000);
            $('#assessmentNewVehicleDelModal').modal('hide');
            loadAssessmentNewVehicle();
        })
    }

    submitAssessmentNewVehicle = function(data) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('assessment.new.vehicle.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                $('#addAssessmentVehicleModal').modal('hide');
                addAssessmentVehicle();
                loadAssessmentNewVehicle();

                if(response.total_vehicle > 0){
                    $('#frm_vehicle .verify').prop('disabled', false);
                } else {
                    $('#frm_vehicle .verify').prop('disabled', true);
                }


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

    selectAssessmentAccidentVehicle = function(id){
        $('#assignAssessmentVehicleAppointment').find('#detail_id').val(id);
    }

    assignVehicleAppointment = function(data){
        $.ajax({
            url: "{{ route('assessment.accident.vehicle.assignAppointment') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#assignAssessmentVehicleAppointment').modal('hide');
                loadAssessmentNewVehicle();
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

    init_func_vehicle_edit = function(){

        $('#frmEditAssessmentVehicle').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            submitEditAssessmentNewVehicle(formData);

        });

        $('#frmEditAssessmentVehicle select').select2({
            width: '100%',
            theme: "classic"
        });
    }

    function checkExistRegNumber(plate_no){
        $('.hasErr').html('');
        let vehicle_id = $('#assessment_vehicle_id').val();
        $.ajax({
            url: "{{ route('assessment.new.vehicle.checkExistRegNumber') }}",
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
                if(isExist == 1){
                    let key = 'plate_no';
                    if($('[name="'+key+'"]').parent().find('.hasErr .text-danger').length == 0){
                        $('[name="'+key+'"]').parent().find('.hasErr').append('<div class="text-danger col-12 fs-6">No Pendaftaran '+plate_no+' Telah Wujud</div>');
                        addBtn.prop('disabled', true);
                    }
                } else {
                    addBtn.prop('disabled', false);
                }
            }
        });
    }

        addAssessmentVehicle = function(){
            init_form_to_value_zero();
            let addAssessmentVehicleModal = $('#addAssessmentVehicleModal');
            let display_list_sub_category = $('#display_list_sub_category');
            let display_list_sub_category_type = $('#display_list_sub_category_type');
            let add_vehicle = $('.add_vehicle');
            let edit_vehicle = $('.edit_vehicle');
            display_list_sub_category.hide();
            display_list_sub_category_type.hide();
            add_vehicle.show();
            edit_vehicle.hide();

            $('#frmAddAssessmentVehicle select').select2({
                width: '100%',
                theme: "classic"
            });

            addAssessmentVehicleModal.modal('show');
            $('#addAssessmentVehicleModal').on('shown.bs.modal', function(){
                $('#plate_no').focus();
            });
        }

        editAssessmentVehicle = function(vehicle_id, functional, self){

            currentPage = $(self).data('current-page');

            var functional = functional;
            parent.startLoading();
            let editAssessmentVehicleModal = $('#addAssessmentVehicleModal');
            $('#display_list_sub_category').show();
            $('#display_list_sub_category_type').show();
            $.ajax({
            url: '{{Route("assessment.new.vehicle.getVehicleForm")}}',
            type: 'get',
            data: {
                "vehicleId": vehicle_id
            },
            dataType: 'json',
                success: function(data){

                    categoryId = data.category_id;
                    subCategoryId = data.sub_category_id;
                    subCategoryTypeId = data.sub_category_type_id;

                    $('#category').val(data.category_id).trigger("change");

                    $('#purchaseDtInput').val(moment(moment(data.purchase_dt, 'YYYY-MM-DD')).format('DD/MM/YYYY'));
                    $('#purchase_dt').val(moment(data.purchase_dt).format('YYYY-MM-DD HH:mm'));
                    $('[xcompany_name]').val(data.company_name);
                    $('[xlo_no]').val(data.lo_no);
                    if(functional == 'duplicate'){
                        $('.add_vehicle').show();
                        $('.edit_vehicle').hide();
                        $('#assessment_vehicle_id').val("");
                        $('[xplate_no]').val("");
                        $('[xengine_no]').val("");
                        $('[xchasis_no]').val("");
                    }else{
                        $('.add_vehicle').hide();
                        $('.edit_vehicle').show();
                        $('#assessment_vehicle_id').val(data.id);
                        $('[xplate_no]').val(data.plate_no);
                        $('[xengine_no]').val(data.engine_no);
                        $('[xchasis_no]').val(data.chasis_no);
                    }

                    $('#brand').val(data.vehicle_brand_id).trigger("change");
                    $('[xmodel_name]').val(data.model_name);
                    $('[xmanufacture_year]').val(moment(moment(data.manufacture_year, 'YYYY')).format('YYYY'));
                    // $('[xregistration_vehicle_dt]').val(moment(moment(data.registration_vehicle_dt, 'YYYY-MM-DD')).format('DD/MM/YYYY'));
                    $('#registrationVehicleDtInput').val(moment(moment(data.registration_vehicle_dt, 'YYYY-MM-DD')).format('DD/MM/YYYY'));
                    $('#registration_vehicle_dt').val(moment(data.registration_vehicle_dt).format('YYYY-MM-DD HH:mm'));
                    let is_gover = data.is_gover;
                        if (is_gover == false){
                            $('#is_gover').prop("checked", false);
                            $('.lo_no').hide();
                        }else{
                            $('#is_gover').prop("checked", true);
                            $('.lo_no').show();
                        }

                    init_func_vehicle_edit();

                    parent.stopLoading();
                }
            });
            editAssessmentVehicleModal.modal('show');

        }

        viewVehicle = function(vehicle_id, functional){
            var functional = functional;
            parent.startLoading();
            let editAssessmentVehicleModal = $('#viewVehicleInformation');
            $('#display_list_sub_category').show();
            $('#display_list_sub_category_type').show();
            $.ajax({
            url: '{{Route("assessment.new.vehicle.getVehicleForm")}}',
            type: 'get',
            data: {
                "vehicleId": vehicle_id
            },
            dataType: 'json',
                success: function(data){
                    $('#no_pendaftaran').html(data.plate_no);
                    $('#no_enjin').html(data.engine_no);
                    $('#no_casis').html(data.chasis_no);
                    $('#nama_buatan').html(data.brand_name);
                    $('#nama_model').html(data.model_name);
                    $('#tahun_dibuat').html(data.manufacture_year);
                    $('#tarikh_pendaftaran').html(moment(data.registration_vehicle_dt).format('DD/MM/YYYY'));
                    $('#kategori').html(data.category_name);
                    $('#sub_kategori').html(data.subCat_name);
                    $('#jenis_kenderaan').html(data.subCatTy_name);
                    if(data.purchase_dt){
                        $('#tarikh_pembelian').html(moment(data.purchase_dt).format('DD/MM/YYYY'));
                    } else {
                        $('#tarikh_pembelian').html('-')
                    }
                    $('#nama_syarikat').html(data.company_name);
                    if(data.purchase_dt){
                        $('#registration_vehicle_dt').html(moment(data.registration_vehicle_dt).format('DD/MM/YYYY'));
                    } else {
                        $('#registration_vehicle_dt').html('-')
                    }
                    let is_gover = data.is_gover;
                        if (is_gover == false){
                            $('#milik_kerajaan').prop("checked", false);
                            $('.no_lo_ker').hide();
                        }else{
                            $('#milik_kerajaan').prop("checked", true);
                            $('.no_lo_ker').show();
                        }



                    parent.stopLoading();
                }
            });
            editAssessmentVehicleModal.modal('show');

        }

    $(document).ready(function(){

        @if($detail)
        loadAssessmentNewVehicle();
        @endif

        let otherAppoinmentDtContainer = $('#otherAppoinmentDtContainer').datetimepicker({
            autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD h:m');
            $('#other_appoinment_dt').val(formatedValue);
        });

        let purchaseDt = $('#purchaseDt').datepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: new Date(),
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD');
            $('#purchase_dt').val(formatedValue);
            console.log(formatedValue);
        });

        let registrationVehicleDt = $('#registrationVehicleDt').datepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            endDate: new Date()
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

        $('#plate_no').on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
            
        });

        $('#plate_no').on('change', function(e){
            e.preventDefault();
            checkExistRegNumber(this.value);
        });

        $('#frmAddAssessmentVehicle').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('assessment_new_id', {{$id}});
            submitAssessmentNewVehicle(formData);

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

        $('#frmAssignAssessmentVehicleAppointment').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            assignVehicleAppointment(formData);
        });

    })

</script>
