
@php
// $total_struck = $detail->hasVehicle->hasStruckVehicle->count();
$TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
use App\Models\Assessment\AssessmentAccidentVehicle;

$AccidentVehicle = AssessmentAccidentVehicle::where('assessment_accident_id', $detail->id)->first();
$StruckVehicle = $AccidentVehicle->hasStruckVehicle->count();
@endphp

<form class="row" id="frm_vehicle" enctype="multipart/form-data">

    @csrf
    <input type="hidden" name="section" value="set_appointment">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <fieldset>
        <legend>Laporan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">No Laporan Polis <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <input type="text" class="form-control" name="report_no" id="report_no" maxlength="40" placeholder="cth. TRAFIK / 01063 / 21"
                        xreport_no onchange="this.value = this.value.toUpperCase()"
                        value="{{$detail && $detail->report_no ? $detail->report_no : ''}}" required>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail && $detail->report_no ? $detail->report_no : ''}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Tarikh Laporan <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <div class="input-group date form_datetime" id="reportDt" data-date="{{$detail && $detail->hasVehicle && $detail->hasVehicle->report_dt ? $detail->hasVehicle->report_dt : ''}}" data-date-format="dd/mm/yyyy">
                            <input class="form-control" size="16" id="reportDtInput" xreport_dt type="text"
                            value="{{$detail && $detail->hasVehicle && $detail->hasVehicle->report_dt ? Carbon\Carbon::parse($detail->hasVehicle->report_dt)->format('d M Y') : ''}}"
                            placeholder="DD/MM/YYYY"  onkeypress="return false;">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            <label class="input-group-text" for="reportDtInput">
                                <i class="fal fa-calendar-alt"></i>
                            </label>
                        </div>
                        <input type="hidden" name="report_dt" id="report_dt" xpurchase_dt value="{{$detail && $detail->hasVehicle && $detail->hasVehicle->report_dt ? Carbon\Carbon::parse($detail->hasVehicle->report_dt)->format('d M Y - g:i A') : ''}}" required/>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail && $detail->hasVehicle && $detail->hasVehicle->report_dt ? Carbon\Carbon::parse($detail->hasVehicle->report_dt)->format('d M Y - g:i A') : ''}}</div>
                    @endif
                </div>
            </div>
            <div class="col">
                <label for="" class="form-label">Kenderaan yang hendak dinilai<span class="text-danger">*</span></label>
                @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                <div class="radio">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="is_gover" id="is_gover1" value="1" {{$detail && $detail->hasVehicle && $detail->hasVehicle->is_gover == true ? 'checked' : ''}}>
                        <label class="form-check-label" for="is_gover1">Milik Kerajaan</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_gover" id="is_gover2" {{$detail && $detail->hasVehicle && $detail->hasVehicle->is_gover == false ? 'checked' : ''}}>
                        <label class="form-check-label" for="is_gover2">Milik Persendirian</label>
                    </div>
                </div>
                @else
                    <div class="txt-data ass_acc"></div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Nama Pemandu <i class="fa fa-info-circle spakat-tip" data-bs-toggle="tooltip" data-bs-placement="right" title="Nama pemandu yang mengendalikan kenderaan Kerajaan ketika kemalangan berlaku"></i> <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <input type="text" class="form-control" name="driver_name" id="driver_name" placeholder="cth. MOHD SAMEON"
                        xreport_no onchange="this.value = this.value.toUpperCase()"
                        value="{{$detail && $detail->hasVehicle && $detail->hasVehicle->driver_name ? $detail->hasVehicle->driver_name  : null}}" required>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail && $detail->hasVehicle && $detail->hasVehicle->driver_name ? $detail->hasVehicle->driver_name  : null}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">MyKad <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <input type="text" class="form-control" name="driver_mykad" id="driver_mykad" placeholder="XXXXXX-XX-XXXX"
                        xreport_no onchange="this.value = this.value.toUpperCase()" onkeyup="updateFormat('driver_mykad', this);"
                        value="{{$detail && $detail->hasVehicle && $detail->hasVehicle->driver_mykad ? $detail->hasVehicle->driver_mykad  : null}}" maxlength="14" required>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail && $detail->hasVehicle && $detail->hasVehicle->driver_mykad ? $detail->hasVehicle->driver_mykad  : null}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">No Tel Pemandu <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <input type="tel" class="form-control" name="driver_phone" id="driver_phone" placeholder="01X XXXXXXX"
                        xreport_no onchange="this.value = this.value.toUpperCase()" onkeyup="this.value = !isNaN(this.value) ? this.value : ''; "
                        value="{{$detail && $detail->hasVehicle && $detail->hasVehicle->driver_phone ? $detail->hasVehicle->driver_phone  : null}}" maxlength="10" required>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail && $detail->hasVehicle && $detail->hasVehicle->driver_phone ? $detail->hasVehicle->driver_phone  : null}}</div>
                    @endif
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Kenderaan Jabatan</legend>
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">No Pendaftaran <i class="fa fa-info-circle spakat-tip" data-bs-toggle="tooltip" data-bs-placement="right" title="No pendaftaran kenderaan Kerajaan yang memerlukan penilaian kerosakan"></i> <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="VBA112" value="{{$detail && $detail->hasVehicle ? $detail->hasVehicle->plate_no : ''}}" xplate_no onchange="this.value = this.value.toUpperCase()" maxlength="14" required>
                        <div class="hasErr"></div>
                        <input type="hidden" name="assessment_vehicle_id" value="{{$detail && $detail->hasVehicle && $detail->hasVehicle ? $detail->hasVehicle->id : ''}}">
                    @else
                        <div class="txt-data ass_acc">{{$detail && $detail->hasVehicle ? $detail->hasVehicle->plate_no : ''}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Buatan <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <select class="form-control form-select required" name="vehicle_brand_id" id="vehicle_brand_id" onchange="getVehicleModel(this.value)" xbrand_name>
                            <option></option>
                            @foreach ($brand_list as $brand )
                                <option {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasVehicleBrand && $detail->hasVehicle->hasVehicleBrand->id == $brand->id ? 'selected' : '' }} value="{{$brand->id}}">{{$brand->name}}</option>
                            @endforeach
                        </select>
                        <div id="vehicle_brand_id_msg" class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail->hasVehicle->hasVehicleBrand ? $detail->hasVehicle->hasVehicleBrand->name : '-'}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Model <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <input type="text" class="form-control" name="model_name" id="model_name" placeholder="SAGA" xmodel_name onchange="this.value = this.value.toUpperCase()" maxlength="25" value="{{$detail && $detail->hasVehicle && $detail->hasVehicle->model_name ? $detail->hasVehicle->model_name : '' }}" required>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail->hasVehicle->model_name}}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Kategori <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <select name="category_id" id="category_main" class="form-control form-select required" onchange="getSubCategory(this.value)">
                            <option value="">Sila Pilih</option>
                            @foreach ($category_list as $category)
                                <option {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasCategory->id == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{strtoupper($category->name)}}</option>
                            @endforeach
                        </select>
                        <div class="hasErr"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail->hasVehicle->hasCategory->name}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4">
                <div class="form-group" id="display_list_sub_category" style="display:none;">
                    <label for="" class="form-label ">Sub Kategori <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <select name="sub_category_id" id="list_sub_category_main" class="form-control form-select required" onchange="getSubCategoryType(this.value)">
                            <option></option>
                        </select>
                        <div class="hasErr" id="list_sub_category_main_msg"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail->hasVehicle->hasSubCategory ? $detail->hasVehicle->hasSubCategory->name : '-'}}</div>
                    @endif
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4" xfunction="sub_category_type_id" id="display_list_sub_category_type" style="display:none;">
                <div class="form-group">
                    <label for="" class="form-label">Jenis <span class="text-danger">*</span></label>
                    @if(!$detail ||$is_myApp && in_array($detail->hasStatus->code, ['01']) || auth()->user()->isAdmin())
                        <select name="sub_category_type_id" id="list_sub_category_main_type" class="form-control form-select required" >
                            <option></option>
                        </select>
                        <div class="hasErr" id="list_sub_category_main_type_msg"></div>
                    @else
                        <div class="txt-data ass_acc">{{$detail->hasVehicle->hasSubCategory ? $detail->hasVehicle->hasSubCategory->name : '-'}}</div>
                    @endif
                </div>
            </div>
        </div>
    </fieldset>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <legend onclick="formClearToGo()">BERLANGGAR DENGAN</legend>
                        @if($detail->hasStatus->code == '01')
                        <div class="col-12 pt-2">
                            <div class="btn-group">
                                {{-- <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"data-bs-target="#addAssessmentVehicleModal"><i class="fal fa-plus"></i> Kenderaan</a> --}}
                                <a class="btn cux-btn" onclick="addAssessmentVehicle()"><i class="fal fa-plus"></i> Kenderaan lain yang terlibat</a>
                                <button class="btn cux-btn" xaction="delete_all" data-del-type="struck" onclick="prompDel(this)" data-bs-toggle="modal" data-bs-target="#assessmentNewVehicleDelModal" id="delete_all" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
                            </div><span class="text-danger">*</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-12 mb-4" id="assessment_accident_struck_vehicle">

            </div>
        </div>
    </div>
    <hr/>
    <div class="form-group center">
        @if($is_myApp  && $detail && in_array($detail->hasStatus->code, ['01']))
        {{--detail && $detail->hasStatus && $detail->hasStatus->code == '01' && $detail->hasVehicle && $detail->hasVehicle->plate_no != '' ? '' : 'disabled'--}}
            <button type="button" class="btn btn-module verify dim" id="show-hantar" data-id="{{$detail ? $detail->id : null}}">Hantar</button>
            <button class="btn btn-link" type="submit" formnovalidate><i class="fas fa-save"></i> Simpan sebagai Draf</button>
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

{{--<div class="modal fade" id="assignAssessmentVehicleAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="assignAssessmentVehicleAppointmentLabel" aria-hidden="true">
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
                <button type="submit" class="btn btn-module"><i class="fas fa-save"></i> Simpan sebagai Draf</button>
                <button type="button" onclick="loadAssessmentAccidentStruckVehicle()" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </form>
      </div>
    </div>
</div>--}}

<div class="modal fade" id="addAssessmentVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="" aria-labelledby="addAssessmentVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <div class="small-title">Berlanggar Dengan
                </div>
                <span>
                    <button class="btn btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </span>
            </div>
            <form id="frmAddAssessmentVehicle" action="">
            @csrf
            <div class="modal-body">
                <div class="row">
                      </button>
                    <p>
                        <i class="fas fa-info-circle"></i>  Maklumat yang diberikan haruslah betul dan ruangan bertanda <span class="text-danger">*</span> hendaklah diisi.
                    </p>
                </div>
                <div class="row">
                    <!--<p><i class="fas fa-info-circle"></i> Sila pastikan maklumat di bawah sama dengan Sijil Pemilikan Kenderaan (geran / VOC) :</p>-->
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <div class="form-group mb-0">
                            <label for="" class="form-label text-dark">No. Pendaftaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-0" name="accwit_regno" id="accwit_regno" placeholder="cth. SMC4234" onchange="this.value = this.value.toUpperCase()" maxlength="14">
                            <div class="hasErr"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-7 col-md-6">
                        <div class="form-group mb-0">
                            <label for="" class="form-label text-dark">Jenis Kenderaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-0" name="vehicle_desc" id="vehicle_desc" placeholder="cth. Motosikal Yamaha 135 LC" onchange="this.value = this.value.toUpperCase()" maxlength="40">
                            <div class="hasErr"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer flex justify-content-start">
                <button type="submit" class="btn btn-module float-start add_vehicle"  style="display:block;" >Tambah</button>
                <button type="submit" class="btn btn-module float-start edit_vehicle" style="display:none;">Simpan</button>
                <button type="button" class="btn btn-link float-start" data-bs-dismiss="modal"><i class="fal fa-undo"></i> Batal</button>
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>-->
            </div>
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
                                    <input class="form-check-input" type="checkbox" id="milik_kerajaan" name="milik_kerajaan" checked onclick="checked_button('.lo_no', this)" disabled>
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
    let del_type = "";
    let currentPage = 1;

    function hide(element) {
        $(element).hide();
    }

    function checked_button(className, obj) {
        var $input = $(obj);
        if ($input.prop('checked')) $(className).show();
        else $(className).hide();
    }

    function updateFormat(model, self){
        var key = event.keyCode || event.charCode;
        console.log('key' , key);
        if(model == 'driver_mykad'){
            let x = $('#driver_mykad').val();

            if(key == 8){
                $('#driver_mykad').val(x);
            } else {
                if(x.length !== 7 || x.length !== 9){
                    x = x.replace(/[^\w\s]/gi, "");
                }

                if(x.length >= 6 && key !== 8){
                    x = x.substring(0, 6) + "-" + x.substring(6, x.length);
                }

                if(x.length >= 9 && key !== 8){
                    x = x.substring(0, 9) + "-" + x.substring(9, x.length);
                }
                $('#driver_mykad').val(x);
            }

        }
    }

    function getSubCategory(category_id){

        $('#list_sub_category_main').html('<option value="">Sila Pilih</option>');
        $('#list_sub_category_main_type').html('<option value="">Sila Pilih</option>');

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
                    $('#list_sub_category_main').append('<option value='+element.id+'>'+element.name+'</option>');
                    if(subCategoryId == element.id){
                        same = true;
                    }
                    totalInit++;
                });
            }

            var currentSelectedCategoryId = {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasCategory && $detail->hasVehicle->hasCategory->id ? $detail->hasVehicle->hasCategory->id : -1}};

            if(count == totalInit){
                if(!same){
                    subCategoryId = null;
                }
                $('#list_sub_category_main').val(subCategoryId).trigger("change");
            }

        });
    }

    function getSubCategoryType(sub_category_id){

        $('#list_sub_category_main_type').html('<option value="">Sila Pilih</option>');

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
                    $('#list_sub_category_main_type').append('<option value='+element.id+'>'+element.name+'</option>');
                    totalInit++;
                    if(subCategoryTypeId == element.id){
                        same = true;
                    }
                });
            }

            var currentSelectedSubCategoryId = {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasCategory && $detail->hasVehicle->hasCategory->id ? $detail->hasVehicle->hasCategory->id : -1}};

            if(count == totalInit){
                if(!same){
                    subCategoryTypeId = null;
                }

                console.log('subCategoryTypeId', subCategoryTypeId);

                //$('#list_sub_category_main_type').val(data.sub_category_type_id).trigger("change");
                $('#list_sub_category_main_type').val(subCategoryTypeId).trigger("change");
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

    loadAssessmentAccidentStruckVehicle = function() {
        let data = {
            'page': currentPage,
        }
        $.get("{{ route('assessment.accident.struck.vehicle.list') }}", data, function(result){
            $('#assessment_accident_struck_vehicle').html(result);
            let totalVehicle = $('#assessment_accident_struck_vehicle tbody tr.vehicle').length;
            let btnVerify = $('.verify');
            if(totalVehicle>0){
                btnVerify.prop('disabled', false);
            } else {
                btnVerify.prop('disabled', true);
            }
            init_func_vehicle_list();
            @if($StruckVehicle > 0)
                $('.verify').removeClass("dim");
            @endif
        });
    }

    init_form_to_value_zero = function(){
        $("#frmAddAssessmentVehicle #category").select2("val", 1);
        $("#frmAddAssessmentVehicle #brand").select2("val", 1);
        $('#assessment_vehicle_id').val("");
        $('.lo_no').show();
        $('#frmAddAssessmentVehicle')[0].reset();
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

    prompDel = function(self){
        del_type = $(self).data('del-type');
        $('#close').show();
        $('#remove').show();
    }

    function remove(){
        $('#assessmentNewVehicleDelModal #remove').hide();
        $('#assessmentNewVehicleDelModal #close').hide();
        $.post("{{route('assessment.accident.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}',
            'del_type': del_type
        },  function(response){
            $('#frm_vehicle #response').html('<span class="text-warning">'+response.message+'</span>').fadeIn(50).fadeOut(5000);
            $('#assessmentNewVehicleDelModal').modal('hide');
            loadAssessmentAccidentStruckVehicle();
        })
    }

    saveVehicleForm = function(data) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('assessment.accident.form.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#frm_vehicle #response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                window.location.href = response['url'];

            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#verifyApplicationModal').hide();
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

    submitAssessmentAccidentStruckVehicle = function(data) {

        $('.hasErr').html('');

        $.ajax({
            url: "{{ route('assessment.accident.vehicle.save') }}",
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
                loadAssessmentAccidentStruckVehicle();
                $('.verify').removeClass("dim");
                /*if(response.total_vehicle > 0){
                    $('#frm_vehicle .verify').prop('disabled', false);
                } else {
                    $('#frm_vehicle .verify').prop('disabled', true);
                }*/
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
                loadAssessmentAccidentStruckVehicle();
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

    function applicantCheck(){
        //check applicant type (police, driver, office)
        var checked_button = $('input[name="as-who"]:checked').val();
        // alert(checked_button);

        if(checked_button == 'driver'){
            var drv_name = $('#driver_name').val();
            if(drv_name == ''){
                $('#driver_name').val($('#applicant_name').val());
            }
        }
    }

    addAssessmentVehicle = function(){
        $('#frmAddAssessmentVehicle')[0].reset();
        let addAssessmentVehicleModal = $('#addAssessmentVehicleModal');
        let show_hantar = $('#show-hantar');
        show_hantar.prop("dim", false);
        // let display_list_sub_category = $('#display_list_sub_category');
        // let display_list_sub_category_type = $('#display_list_sub_category_type');
        // let add_vehicle = $('.add_vehicle');
        // let edit_vehicle = $('.edit_vehicle');
        // display_list_sub_category.hide();
        // display_list_sub_category_type.hide();
        // add_vehicle.show();
        // edit_vehicle.hide();

        addAssessmentVehicleModal.modal('show');
    }

    editAssessmentVehicle = function(vehicle_id, self){
        
        let type = $(self).data('type');
        parent.startLoading();
        currentPage = $(self).data('current-page');
        let editAssessmentVehicleModal = $('#addAssessmentVehicleModal');
        $('#display_list_sub_category').show();
        $('#display_list_sub_category_type').show();
        $.ajax({
        url: '{{Route("assessment.accident.vehicle.getVehicleForm")}}',
        type: 'get',
        data: {
            "vehicleId": vehicle_id,
            "type": type
        },
        dataType: 'json',
            success: function(data) {
                $('.add_vehicle').hide();
                $('.edit_vehicle').show();
                $('#assessment_vehicle_id').val(data.id);

                categoryId = data.category_id;
                subCategoryId = data.sub_category_id;
                subCategoryTypeId = data.sub_category_type_id;

                $('#category_main').val(data.category_id).trigger("change");

                $('[xpurchase_dt]').val(moment(moment(data.purchase_dt, 'YYYY-MM-DD')).format('DD/MM/YYYY'));
                $('[xcompany_name]').val(data.company_name);
                $('[xlo_no]').val(data.lo_no);
                $('[xplate_no]').val(data.plate_no);
                $('[xengine_no]').val(data.engine_no);
                $('[xchasis_no]').val(data.chasis_no);
                $('#brand').val(data.vehicle_brand_id).trigger("change");
                $('[xmodel_name]').val(data.model_name);
                $('#accwit_regno').val(data.accwit_regno);
                $('#vehicle_desc').val(data.vehicle_desc);
                $('[xmanufacture_year]').val(moment(moment(data.manufacture_year, 'YYYY')).format('YYYY'));
                $('[xregistration_vehicle_dt]').val(moment(moment(data.registration_vehicle_dt, 'YYYY-MM-DD')).format('DD/MM/YYYY'));
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
            url: '{{Route("assessment.accident.vehicle.getVehicleForm")}}',
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
            loadAssessmentAccidentStruckVehicle();
        @endif

        // $('.verify').click(function (event) {
        //     if(formClearToGo() == true){
        //         $('.verify').removeClass("dim");
        //     }else{
        //         alert("Sila isikan maklumat-maklumat yang diperlukan");
        //     }
        // }):

        $('.spakat-tip').tooltip();

       /* var inputs = $('#frm_vehicle').find('input[type="text"], input[type="email"]');
        inputs.change(function() {
            if(formClearToGo() == true){
                $('.verify').prop('disabled', false);
            }else{
                $('.verify').prop('disabled', true);
            }
        });
        $('.form-select').change(function() {
            if(formClearToGo() == true){
                $('.verify').prop('disabled', false);
            }else{
                $('.verify').prop('disabled', true);
            }
        });*/

        categoryId = {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasCategory ? $detail->hasVehicle->hasCategory->id : -1}};
        subCategoryId = {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasSubCategory ? $detail->hasVehicle->hasSubCategory->id : -1}};
        subCategoryTypeId = {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasSubCategoryType ? $detail->hasVehicle->hasSubCategoryType->id : -1}};
        vehicleBrandId = {{$detail && $detail->hasVehicle && $detail->hasVehicle->hasVehicleBrand ? $detail->hasVehicle->hasVehicleBrand->id : -1}};

        //applicantCheck();

        if(categoryId != -1){
            getSubCategory(categoryId);
        }

        let otherAppoinmentDtContainer = $('#otherAppoinmentDtContainer').datetimepicker({
            autoclose: 1,
                todayHighlight: 1,
                startDate: new Date()
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD h:m');
            $('#other_appoinment_dt').val(formatedValue);
        });

        let reportDt = $('#reportDt').datetimepicker({
            language:  'ms',
            todayBtn:  1,
            todayHighlight: 1,
            autoclose: 1,
            minView: 2,
            endDate: moment().format('YYYY-MM-DD'),
            pickerPosition: "top-right"
        }).on('changeDate', function(e){
            let formatedValue = moment(e.date).format('YYYY-MM-DD');
            $('#report_dt').val(formatedValue);
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

        $('#plate_no').on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
        });
        
        $('#accwit_regno').on({
            keydown: function(e) {
                if (e.which === 32)
                return false;
            },
            change: function() {
                this.value = this.value.replace(/\s/g, "");
            }
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

        $('#accwit_regno').on('keyup', function (e) {
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

        $('#accwit_regno').on('change', function(e){
            e.preventDefault();
            checkExistRegNumber(this.value);
        });

        $('#frmAddAssessmentVehicle').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            formData.append('assessment_accident_id', {{$id}});
            submitAssessmentAccidentStruckVehicle(formData);

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

        $('#frm_vehicle').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            saveVehicleForm(formData);
        });

    })

</script>
