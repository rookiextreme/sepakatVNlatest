@php
$tab = Request('tab') ? Request('tab') : null;
$maintenance_type_id = Request('maintenance_type_id');
$maintenance_id = Request('maintenance_id');
$vehicle_id = Request('vehicle_id');
@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <link rel="shortcut icon" href="{{ asset('my-assets/favicon/favicon.png') }}">

    <!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">

    <!--importing bootstrap-->
    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('my-assets/fontawesome-pro/css/light.min.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.js') }}"></script>
    <!--Importing Icons-->

    <link href="{{ asset('my-assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet" />
    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}">
    </script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .lcal-2 {
            width: 50px;
        }

        .lcal-3 {
            width: 100px;
        }

        .lcal-4 {
            width: 150px;
        }

        .cux-box {
            min-width: 400px;
            min-height: 300px;
            width: 60%;
            height: 50%;
        }

        .input-group-text {
            height: 39px;
            margin-left: 2px !important;
            margin-right: 3px;
            border: transparent;
            background: #dbdcd8;
        }

        .input-group.date .input-group-text {
            height: 39px;
            margin-left: 4px !important;
            border: transparent;
            background: #dbdcd8;
        }

        .select2-container--open {
            z-index: 1060;
        }

        .inline-label {
            display: contents;
        }

        .scrollable-horizontal {
            width: 100%;
            height: 10vh;
            overflow-x: scroll;
            white-space: nowrap;
            border-left: 3px solid #969690;
            border-right: 3px solid #969690;
        }

        .scrollable-vertical {
            height: 50vh;
            overflow-y: scroll;
            white-space: nowrap;
            scroll-behavior: smooth;
        }

        .item {
            padding: 5px;
            display: inline-block;
            border-radius: 15px;
            border: 1px solid #969690;
            color: #969690;
            text-decoration: none;
            cursor: pointer;
        }

        .item.selected,
        .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        html {
            scroll-behavior: smooth !important;
        }

        .preview_img {
            margin-left: auto;
            margin-right: auto;
        }

        .select2-hidden-accessible {
            height: 0px !important;
        }

        .must-answer.hasErr {
            border: 1px solid red;
            padding: 10px;
        }

        @media (max-width: 1399.98px) {
            /*X-Large devices (large desktops, less than 1400px)*/
            /*X-Large*/
        }

        @media (max-width: 1199.98px) {
            /*Large devices (desktops, less than 1200px)*/
            /*Large*/
        }

        @media (max-width: 991.98px) {
            /* Medium devices (tablets, less than 992px)*/
            /*medium*/
        }

        @media (max-width: 767.98px) {
            /* Small devices (landscape phones, less than 768px)
            /*small*/
        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
        }
    </style>
</head>

<body class="content">
    <div class="mytitle">Pemeriksaan Kerosakan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('access.operation.dashboard', ['dashboard_type' => 'maintenance']) }}">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">

                @if(auth()->user()->isForemenMaintenance())
                    <a href="{{ route('access.operation.dashboard', ['dashboard_type' => 'maintenance']) }}">Dashboard</a>
                    @else
                    <a href="{{ route('maintenance.evaluation.register', [
                    'id' => $VehicleDetail->hasMaintenanceDetail->id,
                    'tab' => 4
                ]) }}">Pemeriksaan Kerosakan</a>
                @endif

            </li>
            <li class="breadcrumb-item active" aria-current="page">Pemeriksaan Kerosakan</li>
        </ol>
    </nav>
    <div class="main-content">
        <form id="frm_examination_achievement_vehicle">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{Request('vehicle_id')}}">
            <input type="hidden" name="maintenance_id" value="{{Request('maintenance_evaluation_id')}}">
            <input type="hidden" name="maintenance_type_id" value="{{Request('maintenance_type_id')}}">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <h3>Pemeriksaan Dan Pengujian Kenderaan</h3>
                        <label class="ms-3 text-success" id="response"></label>
                    </div>
                </div>
                {{-- <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-switch">
                            <input type="checkbox" class="form-check-input mt-2 me-2" name="check_all" id="check_all">
                            <label class="form-check-label cursor-pointer" for="check_all"> Semua</label>

                        </div>
                    </div>
                </div> --}}
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="col-md-12">
                        <div class="btn-group float-end">
                            @if(auth()->user()->isForemenMaintenance() || auth()->user()->isAssistEngineerMaintenance())
                            <button type="submit" xaction="draf" class="btn cux-btn small">Simpan</button>
                            @endif
                            @if(auth()->user()->isForemenMaintenance())
                                <span data-bs-toggle="modal" data-bs-target="#prompVerificationModal" class="btn cux-btn small">Hantar Semakan</span>
                            @elseif(auth()->user()->isAssistEngineerMaintenance())
                                <span data-bs-toggle="modal" data-bs-target="#prompApprovalModal" class="btn cux-btn small">Selesai</span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr />
                <div style="height: 100vh; overflow: auto;">
                    <div class="col-md-12">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="" class="form-label">
                                                    <h4>A. DATA KENDERAAN</h4>
                                                </label>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">No. Pendaftaran</label>
                                                    <div>
                                                        {{$VehicleDetail->plate_no}}
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">Kategori</label>
                                                    <select name="category_id" id="category"
                                                        class="form-control form-select"
                                                        onchange="getSubCategory(this.value)">
                                                        <option value="">Sila Pilih</option>
                                                        @foreach ($category_list as $category)
                                                        <option data-code="{{$category->code}}"
                                                            {{$VehicleDetail->hasCategory && $VehicleDetail->hasCategory->id == $category->id ? 'selected': ''}}
                                                            value="{{$category->id}}"
                                                            >{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="hasErr"></div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">Sub-Kategori</label>
                                                    <select name="sub_category_id" id="list_sub_category"
                                                        class="form-control form-select"
                                                        onchange="getSubCategoryType(this.value)">
                                                        <option value="">Sila Pilih</option>
                                                    </select>
                                                    <div class="hasErr"></div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">Jenis</label>
                                                    <select name="sub_category_type_id" id="list_sub_category_type"
                                                        class="form-control form-select">
                                                        <option value="">Sila Pilih</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">Odometer (KM)</label>
                                                    <input type="text" class="form-control" name="odometer"
                                                        id="odometer" value="{{$VehicleDetail->odometer ? $VehicleDetail->odometer : ''}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <label for="" class="form-label">
                                                    <h4>B. DATA PELANGGAN</h4>
                                                </label>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">Jabatan</label>
                                                    <div>
                                                        {{$VehicleDetail->hasMaintenanceDetail->department_name}}
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <label for="" class="form-label text-dark">No Rujukan Sistem</label>
                                                    <div>
                                                        {{$VehicleDetail->hasMaintenanceDetail->ref_number}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="" class="form-label text-dark">Tarikh Masuk</label>
                                                    <div class="input-group date form_datetime" id="date1Container" data-date="{{$VehicleDetail && $VehicleDetail->date_entry ? $VehicleDetail->date_entry : ''}}" data-date-format="dd MM yyyy" data-link-field="date_entry">
                                                        <input class="form-control" size="16" id="date_entry_input" type="text"
                                                        value="{{$VehicleDetail && $VehicleDetail->date_entry ? \Carbon\Carbon::parse($VehicleDetail->date_entry)->format('d F Y') : ''}}"
                                                        placeholder="Pilihan 1" readonly>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                                        <label class="input-group-addon input-group-text">
                                                            <i class="fal fa-calendar-alt"></i>
                                                        </label>
                                                    </div>
                                                    <input type="hidden" name="date_entry"  value="{{$VehicleDetail && $VehicleDetail->date_entry ? \Carbon\Carbon::parse($VehicleDetail->date_entry)->format('d F Y') : ''}}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4>Senarai Semak Pemeriksaan Dan Pengujian Kenderaan</h4>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table-custom stripe">
                                        <thead>
                                            <th style="width: 40%">Perkara</th>
                                            <th style="width: 20%">Bermasalah/Rosak</th>
                                            <th style="width: 10%">Muat Naik</th>
                                            <th>Catatan</th>
                                        </thead>
                                        <tbody>
                                            @foreach ( $CheckLvl1List as $lvl1)
                                            @php
                                                $indexLvl1 = $loop->index+1;
                                            @endphp
                                                <tr>
                                                    <td>{{$indexLvl1}}. {{$lvl1->hasComponentLvl1->component}}</td>
                                                    <td>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        @if($lvl1->hasManySelection->count()>0)
                                                            <div class="row">
                                                                @foreach ($lvl1->hasManySelection as $hasSelection)
                                                                    @php
                                                                        $tableList = DB::table($hasSelection->hasTableSelection->table)->get();
                                                                    @endphp
                                                                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                                                        <div class="form-group must-answer">
                                                                            <label for="" class="form-label">{{$hasSelection->hasTableSelection->desc}}</label>
                                                                            <select class="form-select mustcheck mustselect" name="form_selection_id_{{$hasSelection->id}}" id="form_selection_id_{{$hasSelection->id}}">
                                                                                <option value="">Sila Pilih</option>
                                                                                @foreach ($tableList as $item)
                                                                                    <option {{$hasSelection->selected_id == $item->id ? 'selected': ''}} value="{{$item->id}}">{{$item->desc}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @foreach ( $lvl1->hasFormComponentCheckListLvl2 as $lvl2 )
                                                    @php
                                                        $indexLvl2 = $loop->index+1;
                                                    @endphp
                                                    <tr>
                                                        <td style="padding-left: 2em;">{{$indexLvl1}}.{{$indexLvl2}}&nbsp;{{$lvl2->hasComponentLvl2->component}}</td>
                                                        <td>
                                                            @if($lvl2->hasFormComponentCheckListLvl3->count()==0)
                                                                <div class="form-switch">
                                                                    <input type="checkbox"
                                                                    {{$lvl2->is_pass == '1' ? 'checked' : ''}}
                                                                        class="form-check-input mt-2 me-2 check_is_pass"
                                                                        name="form_check_lvl2_component_id_{{$lvl2->id}}" id="form_check_lvl2_component_id_{{$lvl2->id}}">
                                                                    <label class="form-check-label cursor-pointer"
                                                                        for="form_check_lvl2_component_id_{{$lvl2->id}}"></label>

                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($lvl2->hasFormComponentCheckListLvl3->count()==0)
                                                                <div class="">
                                                                    <label for="form_label_lvl2_component_id_{{$lvl2->id}}"
                                                                        class="btn cux-btn small form-label">{{$lvl2->hasDoc ? 'Tukar Fail': 'Muat naik'}}</label>
                                                                    <input
                                                                        onchange="uploadFile(this)" data-id="{{$lvl2->id}}" data-lvl="2"
                                                                        class="form-control d-none" accept="image/*"
                                                                        name="form_file_lvl2_component_id_{{$lvl2->id}}" type="file"
                                                                        id="form_label_lvl2_component_id_{{$lvl2->id}}" />
                                                                    @php
                                                                        $path = '';
                                                                        $pathThumb = '';
                                                                        $docName = '';
                                                                        if($lvl2->hasDoc){
                                                                            $path = 'storage/'.$lvl2->hasDoc->doc_path;
                                                                            $pathThumb = $lvl2->hasDoc->doc_path_thumbnail;
                                                                            $docName = $lvl2->hasDoc->doc_name;
                                                                        }
                                                                    @endphp
                                                                    <span id="btn_delete_lvl_2_id_{{$lvl2->id}}" data-lvl="2" data-id="{{$lvl2->id}}" data-doc_id="{{$lvl2->hasDoc ? $lvl2->hasDoc->id: ''}}" onclick="promptDeleteFile(this)" style="position: relative;width: 20px;height: 20px;padding: 0px;float: right;margin-bottom: -10px;right: -10px;border-radius: 15px;display: {{$lvl2->hasDoc? 'block':'none'}}" class="btn btn-danger">X</span>
                                                                    <img id="preview_img_lvl_2_id_{{$lvl2->id}}" class="preview_img" onclick="openEnlargeModal(this)" data-lvl="2" data-url="/{{$path.'/'.$docName}}" src="/{{$pathThumb.'/'.$docName}}" alt="" width="100%" class="cursor-pointer" style="display: {{$lvl2->hasDoc? 'block':'none'}}">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($lvl2->hasFormComponentCheckListLvl3->count()==0)
                                                                <textarea style="resize: none;" class="form-control" name="form_note_lvl2_component_id_{{$lvl2->id}}" id="form_note_lvl2_component_id_{{$lvl2->id}}" cols="30" rows="5">{{$lvl2->note}}</textarea>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @foreach ( $lvl2->hasFormComponentCheckListLvl3 as $lvl3)
                                                        <tr>
                                                            <td style="padding-left: 4em;"> {{$indexLvl1}}.{{$indexLvl2}}.{{$loop->index+1}}.&nbsp;{{$lvl3->hasComponentLvl3->component}}</td>
                                                            <td>
                                                                <div class="form-switch">
                                                                    <input type="checkbox"
                                                                    {{$lvl3->is_pass == '1' ? 'checked' : ''}}
                                                                        class="form-check-input mt-2 me-2 check_is_pass"
                                                                        name="form_check_lvl3_component_id_{{$lvl3->id}}" id="form_check_lvl3_component_id_{{$lvl3->id}}">
                                                                    <label class="form-check-label cursor-pointer"
                                                                        for="check_all"></label>

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="">
                                                                    <label for="form_label_lvl3_component_id_{{$lvl3->id}}"
                                                                        class="btn cux-btn small form-label">{{$lvl3->hasDoc ? 'Tukar Fail': 'Muat naik'}}</label>
                                                                    <input
                                                                        onchange="uploadFile(this)" data-id="{{$lvl3->id}}" data-lvl="3"
                                                                        class="form-control d-none" accept="image/*"
                                                                        name="form_file_lvl3_component_id_{{$lvl3->id}}" type="file"
                                                                        id="form_label_lvl3_component_id_{{$lvl3->id}}" />
                                                                    @php
                                                                        $path = '';
                                                                        $pathThumb = '';
                                                                        $docName = '';
                                                                        if($lvl3->hasDoc){
                                                                            $path = 'storage/'.$lvl3->hasDoc->doc_path;
                                                                            $pathThumb = $lvl3->hasDoc->doc_path_thumbnail;
                                                                            $docName = $lvl3->hasDoc->doc_name;
                                                                        }
                                                                    @endphp
                                                                    <div style="width: 100px;">
                                                                        <span id="btn_delete_lvl_3_id_{{$lvl3->id}}" data-lvl="3" data-id="{{$lvl3->id}}" data-doc_id="{{$lvl3->hasDoc? $lvl3->hasDoc->id: ''}}" onclick="promptDeleteFile(this)" style="position: relative;width: 20px;height: 20px;padding: 0px;float: right;margin-bottom: -10px;right: -10px;border-radius: 15px;display: {{$lvl3->hasDoc? 'block':'none'}}" class="btn btn-danger">X</span>
                                                                        <img id="preview_img_lvl_3_id_{{$lvl3->id}}" class="preview_img" onclick="openEnlargeModal(this)" data-lvl="3" data-url="/{{$path.'/'.$docName}}" src="/{{$pathThumb.'/'.$docName}}" alt="" width="100%" class="cursor-pointer" style="display: {{$lvl3->hasDoc? 'block':'none'}}">
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea style="resize: none;" class="form-control" name="form_note_lvl3_component_id_{{$lvl3->id}}" id="form_note_lvl3_component_id_{{$lvl3->id}}" cols="30" rows="5">{{$lvl3->note}}</textarea>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>

    <div class="modal fade" id="prompVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="prompVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog"
            style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
            <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-header" style="height:70px;">
                    Hantar Semakan Semakan
                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no"
                        data-bs-dismiss="modal">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="prompt-container">
                    <div class="txt-memo">
                        Adakah anda ingin menghantar untuk semakan?
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <span class="btn btn-module" xaction="approval">Ya</span>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Tidak</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog"
            style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
            <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-header" style="height:70px;">
                    Pengesahan
                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no"
                        data-bs-dismiss="modal">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="prompt-container">
                    <div class="txt-memo">
                        Adakah semakan telah selesai dan ingin meneruskan proses ini?
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-module" onclick="$(this).prop('disabled', true)" xaction="approve">Ya</button>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Tidak</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="prompDeleteFormFileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="prompDeleteFormFileModalLabel" aria-hidden="true">
        <div class="modal-dialog"
            style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
            <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-header" style="height:70px;">
                    Pengesahan
                    <button type="button" class="btn close" data-dismiss="modal" aria-label="Close" xaction="no"
                        data-bs-dismiss="modal">
                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="prompt-container">
                    <div class="txt-memo">
                        Adakah anda ingin menghapuskan gambar ini?
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <span class="btn btn-module" onclick="deleteFormfile()">Ya</span>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Tidak</span>
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-enlarge-image')

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>
    let categoryId = null;
    let subCategoryId = null;
    let subCategoryTypeId = null;
    let excludeDateApp = [];

    let selectedFormCompLvl = null;
    let selectedFormCompId = null;
    let selectedFormFileId = null;

    let save_as = "";

    function show(element){
        $(element).show();
    }


    function selectHash(self){
        $('.selected').removeClass('selected disabled');

        let hash = window.location.hash;
        $(self).addClass('selected disabled');
    }

    const checkIfAllChecked = function(){
        let totalCheckBox = $('.check_is_pass').length;
        let totalChecked = $('.check_is_pass:checked').length;
        // console.log(totalCheckBox, totalChecked);
        if(totalCheckBox == totalChecked){
            $('#check_all_1').prop('checked', true);
        }
    }

    const uploadFile = function(self){

        let url = URL.createObjectURL($(self)[0].files[0]);
        let lvl = $(self).attr('data-lvl');
        let id = $(self).attr('data-id');
        if(url){
            $(self).parent().find('.form-label').text('Tukar Fail');
            $(self).parent().find('#btn_delete_lvl_'+lvl+'_id_'+id).show();
            $(self).parent().find('#preview_img_lvl_'+lvl+'_id_'+id).attr('src', url).show();
        }

        let formData = new FormData();

        formData.append('_token', "{{ csrf_token() }}");
        formData.append('id', id);
        formData.append('lvl', lvl);
        formData.append('vehicle_id', "{{Request('vehicle_id')}}");
        formData.append('maintenance_type_id', "{{Request('maintenance_type_id')}}");
        formData.append('file', $(self)[0].files[0]);
        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle-maintenance.form-file.save') }}",
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                $('#preview_img_lvl_'+lvl+'_id_'+id).parent().show();
                $('#preview_img_lvl_'+lvl+'_id_'+id).data('url', response.imgUrl)
                $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {

                });

            }

        });
    }


    function openEnlargeModal(self){
        console.log($(self).data('url'));
        $('#enlargeImageModal img').attr('src', $(self).data('url'));
        $('#enlargeImageModal').modal('show');
    }

    function getSubCategory(category_id){

        $('#list_sub_category').html('<option value="">Sila Pilih</option>');
        $('#list_sub_category_type').html('<option value="">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategory')}}", {
            category_id: category_id
        }, function(result){
                console.log(result);
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

        const submitCheckFormList = function(formData, save_as){

            formData.append('save_as', save_as);

            $.ajax({
                url: "{{ route('maintenance.evaluation.vehicle-maintenance.form.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {

                    if(save_as == 'approval' || save_as == 'approve'){
                        //console.log(routeWhenApproved);
                        window.location.href = response.url;
                    }
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
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

        function removeKey(arr, value){
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] === value) {
                    arr = arr.splice(i, 1);
                }
            }
            return arr;
        }

        function reinitializeDatepicker(target){
            setTimeout(() => {
                    $(target).datetimepicker('remove').datetimepicker(
                        {
                            autoclose: 1,
                            todayHighlight: 1,
                            startDate: new Date(),
                            datesDisabled: excludeDateApp
                        }
                    );
            }, 500);
        }

        generateFormExamination = function(vehicle_id, maintenance_type_code_selected){
            parent.startLoading();
            $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
                maintenance_type_code: maintenance_type_code,
                vehicle_id: selected_vehicle_id,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                window.location.href = result.url;

            })
        }

        const promptDeleteFile = function(self){

            let lvl = $(self).data('lvl');
            let id = $(self).data('id');
            let fileId = $(self).data('doc_id');

            selectedFormCompLvl = lvl;
            selectedFormCompId = id;
            selectedFormFileId = fileId;
            $('#prompDeleteFormFileModal').modal('show');
        }

        const deleteFormfile = function(){
            let _token = '{{ csrf_token() }}';
            $.post('{{ route('maintenance.evaluation.vehicle-maintenance.form-file.delete') }}', {
                comp_lvl: selectedFormCompLvl,
                comp_id: selectedFormCompId,
                id: selectedFormFileId,
                _token: _token
            }, function(){

                $('[for="form_label_lvl'+selectedFormCompLvl+'_component_id_'+selectedFormCompId+'"]').text('Muat Naik');
                $('#preview_img_lvl_'+selectedFormCompLvl+'_id_'+selectedFormCompId).parent().hide();
                $('#prompDeleteFormFileModal').modal('hide');
            })
        }

        $(document).ready(function(){

            @if($VehicleDetail && $VehicleDetail->date_entry)
                excludeDateApp.push('{{$VehicleDetail->date_entry}}');
            @endif

            // reinitializeDatepicker('#date1Container');

            let app_dt_1_container = $('#date1Container').datepicker(
                {
                    autoclose: 1,
                    todayHighlight: 1
                }
            );

            app_dt_1_container.on('changeDate', function(e){
                let val = $(this).datepicker('getDate');
                if(val){
                    currentAppDt1 = new moment(val).format('YYYY-MM-DD');
                    $('[name="date_entry"]').val(currentAppDt1);
                }
            });

            // app_dt_1_container.on('changeDate', function(ev){

            //     let formatedValue = moment(ev.date).format('YYYY-MM-DD hh:mm');
            //     $('[name="date_entry"]').val(formatedValue);

            //     removeKey(excludeDateApp, currentAppDt1);
            //     let date = new moment(ev.date).format('YYYY-MM-DD');
            //     console.log('prev Array ', excludeDateApp);
            //     if($.inArray(date, excludeDateApp) === -1){
            //         excludeDateApp.push(date);
            //         console.log('latest Key Array ', excludeDateApp);
            //     }

            //     reinitializeDatepicker('#date1Container');

            // });

            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

             $('select').select2({
                 width: '100%',
                 theme: "classic"
             });

             @if($VehicleDetail)
                @if ($VehicleDetail->hasCategory)
                    categoryId = {{$VehicleDetail->hasCategory->id}};
                    @if($VehicleDetail->hasSubCategory)
                        subCategoryId = {{$VehicleDetail->hasSubCategory->id}};
                        @if($VehicleDetail->hasSubCategoryType)
                            subCategoryTypeId = {{$VehicleDetail->hasSubCategoryType->id}};
                        @endif
                    @endif
                    getSubCategory({{$VehicleDetail->hasCategory->id}});
                @endif
             @endif

            checkIfAllChecked();

            $('#check_all_1').on('change', function(){
                $('.check_is_pass').prop('checked', this.checked);
            })

            $('[xaction]').on('click', function(){
                save_as = $(this).attr('xaction');

                if(save_as == 'approval' || save_as == 'approve'){
                    let formData = new FormData($('#frm_examination_achievement_vehicle')[0]);
                    let totalMustSelect = $('.mustselect').length;
                    let totalMustSelectDone = 0;

                    $(".mustselect").each(function(){
                        if($(this).val() != ''){
                            totalMustSelectDone = totalMustSelectDone + 1;
                            $(this).parent().removeClass('hasErr');
                        } else {
                            $('#prompVerificationModal').modal('hide');
                            $('#prompApprovalModal').modal('hide');
                            $(this).parent().addClass('hasErr');
                            $(this).focus();
                        }
                    });
                    if(totalMustSelect == totalMustSelectDone){
                        submitCheckFormList(formData, save_as);
                    }
                }
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                let totalMustSelect = $('.mustselect').length;
                let totalMustSelectDone = 0;

                $(".mustselect").each(function(){
                    if($(this).val() != ''){
                        totalMustSelectDone = totalMustSelectDone + 1;
                        $(this).parent().removeClass('hasErr');
                    } else {
                        $(this).parent().addClass('hasErr');
                        $(this).focus();
                    }
                });
                if(totalMustSelect == totalMustSelectDone){
                    submitCheckFormList(formData, save_as);
                }
                
            });

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
            });

            $('#category').on('change', function(e) {
                e.preventDefault();

                let category_code = $('option:selected', this).data('code');
                selected_vehicle_id = {{$vehicle_id}};


                switch (category_code) {
                    case '02':
                    maintenance_code = "03";
                    parent.startLoading();
                        $.post("{{route('maintenance.vehicle-maintenance.generateForm')}}", {
                            maintenance_type_code: maintenance_code,
                            vehicle_id: selected_vehicle_id,
                            '_token': '{{ csrf_token() }}'
                        },  function(result){
                            window.location.href = result.url;

                        })
                        break;
                    default:
                        break;
                }
            });

        });


    </script>


</body>

</html>
