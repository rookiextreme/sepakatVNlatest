@php
    $module = Request('module') ? Request('module') : 'assessment';
    $assessmentTypeCode = Request('assement_type_code') ? Request('assement_type_code') : null;
    $maintenanceTypeCode = Request('maintenance_type_code') ? Request('maintenance_type_code') : '01';
    $last_id_lvl1 = Request('last_id_lvl1') ? Request('last_id_lvl1') : null;
    $last_id_lvl2 = Request('last_id_lvl2') ? Request('last_id_lvl2') : null;
    $last_id_lvl3 = Request('last_id_lvl3') ? Request('last_id_lvl3') : null;
    $hasTag = Request('hasTag') ? Request('hasTag') : null;
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">

<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<link href="{{ asset('my-assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet" />
<script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>

<link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

<style type="text/css">

    .datepicker-dropdown {
        width: 190px;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    a {
        font-family: lato;
        color:#718aa6;
        cursor:pointer;
        text-decoration: none;
    }
    a:hover {
        text-decoration: none;
        color:#000000;
    }
    body {
        background-color: #f4f5f2;
    }
    .lcal-2 {
        width:50px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:150px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }
    .sect-top {
        position: fixed;
        left:0px;
        width:100%;
        z-index:4;
        padding-left:28px;
        background-color: #f2f4f0;
        padding-bottom:20px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height:190px;
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

    /* th{

        vertical-align: middle !important;
        font-family: avenir-bold !important;
        font-size: 12px !important;
        color: #333333 !important;
        background-color: #eaeee7 !important;
    } */

    td{

        vertical-align:middle !important;
        font-size: 12px !important;
    }

    th.select-checkbox{

        width: 3% !important;
        text-align: center !important;
        margin-right: 0px !important;
        padding: 0px !important;
    }

    td.select-checkbox{
        text-align: center !important;
    }

    tbody {
        display: block;
        height: 100%;
        overflow: auto;
    }
    thead, tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;/* even columns width , fix width of table too*/
    }

    #angle {
        cursor: pointer;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
<div class="sect-top">
    <div id="response" class="alert alert-spakat response-toast" role="alert"></div>
    <div class="mytitle">Senarai Semak</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href=""><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Tetapan </a></li>
        <li class="breadcrumb-item active" aria-current="page">Senarai Semak</li>
        </ol>
    </nav>
    <div class="dropdown inline" style="display: inline;">
        @php
            $mapingAssessmentLabel = [
                '01' => 'Penilaian Kenderaan Baharu',
                '02' => 'Penilaian Keselamatan & Prestasi',
                '03' => 'Penilaian Harga Semasa',
                '04' => 'Penilaian Pelupusan',
                '05' => 'Penilaian Pinjaman Kerajaan'
            ];

            $mapingMaintenanceLabel = [
                '01' => 'Pemeriksaan'
            ];
        @endphp
        <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fal fa-folder"></i>
            @switch($module)
                @case('assessment')
                    {{$mapingAssessmentLabel[$assessmentTypeCode]}}
                    @break
                @case('maintenance')
                    {{$mapingMaintenanceLabel[$maintenanceTypeCode]}}
                    @break
                @default
                    
            @endswitch
        </span>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><h6 class="dropdown-header">Penilaian</h6></li>
            <li><a class="dropdown-item {{$assessmentTypeCode == '01' ? 'active' : ''}}" href="javascript:parent.openPgInFrame('{{route('reference.component.checklist', ['module' => 'assessment', 'assement_type_code' => '01'])}}')">Kenderaan Baharu</a></li>
            <li><a class="dropdown-item {{$assessmentTypeCode == '02' ? 'active' : ''}}" href="javascript:parent.openPgInFrame('{{route('reference.component.checklist', ['module' => 'assessment', 'assement_type_code' => '02'])}}')">Keselamatan & Prestasi</a></li>
            <li><a class="dropdown-item {{$assessmentTypeCode == '03' ? 'active' : ''}}" href="javascript:parent.openPgInFrame('{{route('reference.component.checklist', ['module' => 'assessment', 'assement_type_code' => '03'])}}')">Harga Semasa</a></li>
            <li><a class="dropdown-item {{$assessmentTypeCode == '04' ? 'active' : ''}}" href="javascript:parent.openPgInFrame('{{route('reference.component.checklist', ['module' => 'assessment', 'assement_type_code' => '04'])}}')">Pelupusan</a></li>
            <li><a class="dropdown-item {{$assessmentTypeCode == '05' ? 'active' : ''}}" href="javascript:parent.openPgInFrame('{{route('reference.component.checklist', ['module' => 'assessment', 'assement_type_code' => '05'])}}')">Pinjaman Kerajaan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><h6 class="dropdown-header">Penyenggaraan</h6></li>
            <li><a class="dropdown-item {{!$assessmentTypeCode && $maintenanceTypeCode == '01' ? 'active' : ''}}" href="{{route('reference.component.checklist', ['module' => 'maintenance', 'maintenance_type_code' => '01'])}}">Pemeriksaan</a></li>

        </ul>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="main-content">
    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend>Maklumat Semak</legend><br/>
                <div class="btn btn-group">
                    <button class="btn cux-btn small" 
                        onclick="modalActionCheckListLvl1(this, 'insert')" 
                        data-bs-toggle="modal" data-bs-target="#checkListLvl1Modal">
                        <i class="fa fa-plus"></i> Tambah Semakan lvl 1
                    </button>
                </div>
                @foreach ($components as $compLvl1)
                    <ul style="list-style: none;">
                        <li>
                            <div class="btn-group">
                                <span 
                                data-id="{{$compLvl1->id}}"
                                data-code="{{$compLvl1->code}}"
                                data-name="{{$compLvl1->component}}"
                                onclick="modalActionCheckListLvl1(this, 'update')" 
                                data-bs-toggle="modal" data-bs-target="#checkListLvl1Modal"
                                class="btn cux-btn small"><i class="fa fa-pencil"></i></span>
                                <span 
                                onclick="deleteItemCheckListLvl1({{$compLvl1->id}})"
                                xaction="delete_selected_checkListLvl1" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target=""
                                class="btn cux-btn small"><i class="fa fa-trash"></i></span>
                            </div>
                            <label for="" class="form-label cursor-pointer d-inline" data-lvl=1 id="id_collapse_lvl1_{{$compLvl1->id}}" onclick="collapsible(this)" data-bs-toggle="collapse" href="#collapse_lvl1_{{$compLvl1->id}}">{{$loop->index+1}}. {{$compLvl1->component}} <i id="angle" class="pt-2 fa fa-angle-up fa-2x"></i></label>
                            <div class="collapse" id="collapse_lvl1_{{$compLvl1->id}}">
                                <div class="btn btn-group">
                                    <button class="btn cux-btn small"
                                    data-compLvl1="{{$compLvl1}}"
                                    onclick="modalActionCheckListLvl2(this, 'insert')" 
                                    data-bs-toggle="modal" data-bs-target="#checkListLvl2Modal"
                                    ><i class="fa fa-plus"></i> Tambah Semakan lvl 2</button>
                                </div>
                                <ul xchecklistlvl1list="checklistlvl1_id_{{$compLvl1->id}}_checklist_lvl2" id="checklist_lvl2" style="list-style: none;">
                                    @foreach ($compLvl1->hasManyComponentChecklistLvl2 as $compLvl2)
                                        <li class="mb-2">
                                            <div class="btn-group">
                                                <span 
                                                data-compLvl1="{{$compLvl1}}"
                                                data-id="{{$compLvl2->id}}"
                                                data-code="{{$compLvl2->code}}"
                                                data-name="{{$compLvl2->component}}"
                                                onclick="modalActionCheckListLvl2(this, 'update')" 
                                                data-bs-toggle="modal" data-bs-target="#checkListLvl2Modal"
                                                class="btn cux-btn small"><i class="fa fa-pencil"></i></span>
                                                <span 
                                                onclick="deleteItemCheckListLvl2({{$compLvl2->id}})"
                                                xaction="delete_selected_checkListLvl2" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-bs-target=""
                                                class="btn cux-btn small"><i class="fa fa-trash"></i></span>
                                            </div>
                                            <label for="" class="form-label cursor-pointer d-inline" data-lvl=2 id="id_collapse_lvl2_{{$compLvl2->id}}" onclick="collapsible(this)" data-bs-toggle="collapse" href="#collapse_lvl2_{{$compLvl2->id}}">{{$loop->index+1}}. {{$compLvl2->component}} <i id="angle" class="pt-2 fa fa-angle-up fa-2x"></i></label>
                                            <br/>
                                            <div class="collapse" id="collapse_lvl2_{{$compLvl2->id}}">
                                                <div class="btn btn-group">
                                                    <button class="btn cux-btn small"
                                                    data-lvl=3
                                                    data-compLvl2="{{$compLvl2}}"
                                                    onclick="modalActionCheckListLvl3(this, 'insert')" 
                                                    data-bs-toggle="modal" data-bs-target="#checkListLvl3Modal"
                                                    ><i class="fa fa-plus"></i> Tambah Semakan lvl 3</button>
                                                </div>
                                                <ul style="list-style: none;">
                                                    @foreach ($compLvl2->hasManyComponentChecklistLvl3 as $compLvl3)
                                                        <li class="mb-2">
                                                            <div class="btn-group">
                                                                <span 
                                                                data-id="{{$compLvl3->id}}"
                                                                data-code="{{$compLvl3->code}}"
                                                                data-name="{{$compLvl3->component}}"
                                                                onclick="modalActionCheckListLvl3(this, 'update')" 
                                                                data-bs-toggle="modal" data-bs-target="#checkListLvl3Modal"
                                                                class="btn cux-btn small"><i class="fa fa-pencil"></i></span>
                                                                <span 
                                                                onclick="deleteItemCheckListLvl3({{$compLvl3->id}})"
                                                                xaction="delete_selected_checkListLvl3" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal" data-bs-target=""
                                                                class="btn cux-btn small"><i class="fa fa-trash"></i></span>
                                                            </div>
                                                            <label for="" class="form-label cursor-pointer d-inline">{{$loop->index+1}}. {{$compLvl3->component}}</label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        @if($compLvl1->hasManyComponentChecklistLvl2->count() == $loop->index+1)
                                            @php
                                                $currentCheckListLvl2Code = $compLvl2->code;
                                            @endphp
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div>
                                <ul style="list-style: none;">
                                    @foreach ($compLvl1->hasManySelection as $selection)
                                        <li>
                                            <div class="col-md-5">
                                                <label for="" class="form-label">{{$selection->hasTableSelection->desc}}</label>
                                                <select class="custom-select selection_type" id="selection_type_id_{{$selection->id}}" name="selection_type_id" onchange="updateSelectionType({{$selection->id}}, this)">
                                                    @foreach ($ref_selection_list as $ref_selection)
                                                        <option {{$selection->hasSelectionType->id == $ref_selection->id ? 'selected':''}} value="{{$ref_selection->id}}">{{$ref_selection->desc}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </li>
                    </ul>
                @endforeach
            </fieldset>
        </div>
        @if($assessmentType)
        <div class="col-md-6">
            <fieldset>
                <legend>Maklumat Pindaan</legend>
                <form id="frm_amendment_assessment">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="document_no" class="form-label">No. Dokumen</label>
                            <input type="text" name="document_no" id="document_no" value="{{$assessmentType->document_no}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="produce_no" class="form-label">No. Keluaran</label>
                            <input type="text" name="produce_no" id="produce_no" value="{{$assessmentType->produce_no}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amendment_no" class="form-label">No. Pindaan</label>
                            <input type="text" name="amendment_no" id="amendment_no" value="{{$assessmentType->amendment_no}}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="amendment_dt" class="form-label">Tarikh Pindaan</label>
                            <div class="input-group date" id="amendment_dt">
                                <input autocomplete="off" name="amendment_dt" id="amendment_dt_input"
                                            type="text" class="form-control datepicker" placeholder=""
                                            autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true"
                                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                            value="{{isset($assessmentType->amendment_dt) ? \Carbon\Carbon::parse($assessmentType->amendment_dt)->format('d/m/Y') : ''}}"/>
                                <div class="input-group-text" for="amendment_dt">
                                    <i class="fal fa-calendar"></i>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-module"> Simpan </button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
        @endif
    </div>
</div>

<div class="pb-5"></div>

<div class="modal fade" id="checkListLvl1Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkListLvl1ModalLabel" aria-hidden="true">
    <input type="hidden" id="checkListLvl1-id" name="checkListLvl1-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Semakan Lvl 1</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="checkListLvl1-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="checkListLvl1-code" name="checkListLvl1-code" readonly disabled value="{{$code}}">
                    </div>
                    <div class="col-8">
                        <label for="checkListLvl1-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="checkListLvl1-name" name="checkListLvl1-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_checkListLvl1" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_checkListLvl1" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="checkListLvl2Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkListLvl2ModalLabel" aria-hidden="true">
    <input type="hidden" id="checkListLvl1-id" name="checkListLvl1-id" value="">
    <input type="hidden" id="checkListLvl2-id" name="checkListLvl2-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Semakan Lvl 2</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Semakan Lvl 1</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="checkListLvl1Code" class="form-label">Kod Semakan Lvl 1</label>
                        <div id="checkListLvl1Code"></div>
                    </div>
                    <div class="col-8">
                        <label for="checkListLvl1Name" class="form-label">Nama Semakan Lvl 1</label>
                        <div id="checkListLvl1Name"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="checkListLvl2-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="checkListLvl2-code" name="checkListLvl2-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="checkListLvl2-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="checkListLvl2-name" name="checkListLvl2-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_checkListLvl2" onclick="reloadPage()" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_checkListLvl2()" xaction="save_checkListLvl2" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="checkListLvl3Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="checkListLvl3ModalLabel" aria-hidden="true">
    <input type="hidden" id="checkListLvl2-id" name="checkListLvl2-id" value="">
    <input type="hidden" id="checkListLvl3-id" name="checkListLvl3-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Jenis</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Semakan Lvl 2</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="checkListLvl2Code" class="form-label">Kod Semakan Lvl 2</label>
                        <div id="checkListLvl2Code"></div>
                    </div>
                    <div class="col-8">
                        <label for="checkListLvl2Name" class="form-label">Nama Semakan Lvl 2</label>
                        <div id="checkListLvl2Name"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="checkListLvl3-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="checkListLvl3-code" name="checkListLvl3-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="checkListLvl3-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="checkListLvl3-name" name="checkListLvl3-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_checkListLvl3" onclick="reloadPage()" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_checkListLvl3()" xaction="save_checkListLvl3" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <div id="message">
                Adakah anda ingin menghapuskan data ini ?
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
            <span class="btn btn-danger" xaction="delete" >Ya</span>
        </div>
    </div>
    </div>
</div>

<script>

    let checkListLvl1_ids = [];
    let checkListLvl2_ids = [];
    let checkListLvl3_ids = [];

    let last_id_lvl1 = '{{$last_id_lvl1 ?: null}}';
    let last_id_lvl2 = '{{$last_id_lvl2 ?: null}}';
    let last_id_lvl3 = '{{$last_id_lvl3 ?: null}}';

    let hasTag = '{{$hasTag ?: null}}';

    function hide(element){
        $(element).hide();
    }

    function show(element){
        $(element).show();
    }

    function block(element){
        $(element).prop('disabled', true);
    }

    function release(element){
        $(element).prop('disabled', false);
    }

    function goTo(url){
        window.location.href = url;
    }

    function reloadPage(){
        
        let module = '{{$module}}';
        let assement_type_code = '{{$assessmentTypeCode}}';
        let maintenance_type_code = '{{$maintenanceTypeCode}}';

        let url = "{{route('reference.component.checklist')}}";

        hasTag = last_id_lvl1;

        if(last_id_lvl2) {
            hasTag = last_id_lvl2;
        }

        if(last_id_lvl3) {
            hasTag = last_id_lvl3;
        }

        parent.openPgInFrame(url+"?module="+module+"&assement_type_code="+assement_type_code+"&maintenance_type_code="+maintenance_type_code+"&last_id_lvl1="+last_id_lvl1+"&last_id_lvl2="+last_id_lvl2+"&last_id_lvl3="+last_id_lvl3+"&hasTag="+hasTag);
    }

    function collapsible(self){

        if($(self).data('lvl') == 1) {
            last_id_lvl1 = self.id;
        } else if($(self).data('lvl') == 2) {
            last_id_lvl2 = self.id;
        }

        $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');
        $('.collapsed').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
    }

    function modalActionCheckListLvl1(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_checkListLvl1"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#checkListLvl1-code').val("{{$code}}");
                $(modalTarget).find('#checkListLvl1-name').val("");

                var checkListLvl2Code = $('#current-subcheckListLvl1-code').val();
                $('[name="subcheckListLvl1-code"]').val(checkListLvl2Code);
                break;
            case 'update':
                $(modalTarget).find('#checkListLvl1-id').val(id);
                $(modalTarget).find('#checkListLvl1-code').val(code);
                $(modalTarget).find('#checkListLvl1-name').val(name);
                break;
        }
    }

    function checkListLvl1Action(action, name, id){

        hide('[xaction="save_checkListLvl1"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.component.checklist.lvl1.action')}}", {
            '_token':crf,
            'name':name,
            'module': "{{$module}}",
            'assessment_type_code': "{{$assessmentTypeCode}}",
            'maintenance_type_code': "{{$maintenanceTypeCode}}",
            'id':id,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_checkListLvl1"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="checkListLvl1-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="checkListLvl1-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_checkListLvl1"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }
    
    function deleteCheckListLvl1(){
        $('input[name="chk_checkListLvl1"]:checked').map(function () {
             checkListLvl1_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.component.checklist.lvl1.action')}}", {
            'ids': checkListLvl1_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteItemCheckListLvl1(id){
        checkListLvl1_ids = [id];
    }

    function getLastLvl2Code(comLvl1Id){
        $.get('{{route('reference.component.checklist.lvl2.lastcode')}}', { 'comLvl1Id': comLvl1Id}, function(res){
            $('[name="checkListLvl2-code"]').val(res.code);
            console.log(res);
        });
    }

    function modalActionCheckListLvl2(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_checkListLvl2"]');
        hide('#checkListLvl2Modal #message-container');

        let compLvl1 = $(self).data('complvl1');

        if(compLvl1){

            $('#checkListLvl2Modal #checkListLvl1-id').val(compLvl1.id);

            $('#checkListLvl1Code').text(compLvl1.code);
            $('#checkListLvl1Name').text(compLvl1.component);
        }

        switch (mode) {
            case 'insert':
                getLastLvl2Code(compLvl1.id);
                show('[xaction="save_checkListLvl2"]');
                break;
            case 'update':
                $(modalTarget).find('#checkListLvl2-id').val(id);
                $(modalTarget).find('#checkListLvl2-code').val(code);
                $(modalTarget).find('#checkListLvl2-name').val(name);
                break;
        }
    }

    function deleteCheckListLvl2(){
        $('input[name="chk_checkListLvl2"]:checked').map(function () {
             checkListLvl2_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.component.checklist.lvl2.action')}}", {
            'ids': checkListLvl2_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteItemCheckListLvl2(id){
        checkListLvl2_ids = [id];
    }

    function save_checkListLvl2(){
        let id = $('[name="checkListLvl2-id"]').val();
        let com_lvl1_id = $('#checkListLvl2Modal #checkListLvl1-id').val();
        let name = $('[name="checkListLvl2-name"]').val();
        let action = $('#checkListLvl2Modal #action').val();
        console.log(action);
        checkListLvl2Action(action, com_lvl1_id, id, name);
    }

    function checkListLvl2Action(action, com_lvl1_id, id, name){

        hide('[xaction="save_checkListLvl2"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.component.checklist.lvl2.action')}}", {
            '_token':crf,
            'com_lvl1_id': com_lvl1_id,
            'id': id,
            'name':name,
            'action': action,
            'last_id_lvl1' : last_id_lvl1
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#checkListLvl2Modal #message-container #result').text(result.message);
            $('#checkListLvl2Modal #message-container').show();
            // getSubCategory(com_lvl1_id);
            // $('[xchecklistlvl1list="com_lvl1_id_'+com_lvl1_id+'_sub_category"]').slideDown('fast');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="checkListLvl2-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="checkListLvl2-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_checkListLvl2"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function getLastLvl3Code(comLvl2Id){
        $.get('{{route('reference.component.checklist.lvl3.lastcode')}}', { 'comLvl2Id': comLvl2Id}, function(res){
            $('[name="checkListLvl3-code"]').val(res.code);
            console.log(res);
        });
    }

    function modalActionCheckListLvl3(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_checkListLvl3"]');

        let compLvl2 = $(self).data('complvl2');

        if(compLvl2){

            $('#checkListLvl3Modal #checkListLvl2-id').val(compLvl2.id);

            $('#checkListLvl2Code').text(compLvl2.code);
            $('#checkListLvl2Name').text(compLvl2.component);
        }

        switch (mode) {
            case 'insert':
                getLastLvl3Code(compLvl2.id);
                show('[xaction="save_checkListLvl3"]');
                break;
            case 'update':
                $(modalTarget).find('#checkListLvl3-id').val(id);
                $(modalTarget).find('#checkListLvl3-code').val(code);
                $(modalTarget).find('#checkListLvl3-name').val(name);
                break;
        }
    }

    function deleteCheckListLvl3(){
        $('input[name="chk_checkListLvl3"]:checked').map(function () {
             checkListLvl3_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.component.checklist.lvl3.action')}}", {
            'ids': checkListLvl3_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteItemCheckListLvl3(id){
        checkListLvl3_ids = [id];
    }

    function checkListLvl3Action(action, com_lvl2_id, id, name){

        hide('[xaction="save_checkListLvl3"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.component.checklist.lvl3.action')}}", {
            '_token':crf,
            'com_lvl2_id': com_lvl2_id,
            'id': id,
            'name':name,
            'action': action,
            'last_id_lvl1' : last_id_lvl1,
            'last_id_lvl2' : last_id_lvl2
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#checkListLvl3Modal #message-container #result').text(result.message);
            $('#checkListLvl3Modal #message-container').show();
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="checkListLvl3-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="checkListLvl3-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_checkListLvl3"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });

    }

    function save_checkListLvl3(){
        let id = $('[name="checkListLvl3-id"]').val();
        let com_lvl2_id = $('#checkListLvl3Modal #checkListLvl2-id').val();
        let name = $('[name="checkListLvl3-name"]').val();
        let action = $('#checkListLvl3Modal #action').val();
        console.log(action);
        checkListLvl3Action(action, com_lvl2_id, id, name);
    }

    const updateSelectionType = function(selection_id, self){
        $.post('{{route('reference.component.checklist.lvl1.update_selection_type')}}', {
            '_token':'{{ csrf_token() }}',
            'id' : selection_id,
            'selection_type_id' : self.value
        });
        console.log($('#selection_type_id_'+selection_id));
        $('#selection_type_id_'+selection_id).parent().append('<span class="message_selection_type text-success">Berjaya dikemaskini</span>');
        setTimeout(function() {
        $('.message_selection_type').remove();
        }, 2000);
    }

    submitAmmendmentForm = function(formData){
        $.post('{{route('reference.component.update.ammendment')}}', {
            '_token' : '{{ csrf_token() }}',
            'document_no' : formData.get('document_no'),
            'produce_no' : formData.get('produce_no'),
            'amendment_no' : formData.get('amendment_no'),
            'amendment_dt' : formData.get('amendment_dt')
        }, function(res){
            $('#response').html('<span class="text-success">'+res.message+'</span>').fadeIn(500).fadeOut(5000);
        });
    }

    $(document).ready(function(){

        @if($last_id_lvl1)
            $('#'+last_id_lvl1).click();
            @if($last_id_lvl2)
                setTimeout(function(){
                    $('#'+last_id_lvl2).click();
                }, 0);
            @endif
        @endif

        @if($hasTag)
            $('html, body').animate({
                scrollTop: $('#'+hasTag).offset().top
            }, 300);
        @endif
        $('.selection_type').select2({
            width: '100%',
            theme: "classic"
        });

        $('#chkall_checkListLvl1').change(function() {
             checkListLvl1_ids = [];

            $('[name="chk_checkListLvl1"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_checkListLvl1"]:checked').map(function () {
                 checkListLvl1_ids.push(parseInt(this.value));
            } );

            if( checkListLvl1_ids.length > 0){
                $('[xaction="delete_selected_checkListLvl1"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_checkListLvl1"]').prop('disabled', true);
            }
        });

        $('[name="chk_checkListLvl1"]').change(function() {

            checkListLvl1_ids = [];

            $('input[name="chk_checkListLvl1"]:checked').map(function () {
                 checkListLvl1_ids.push(parseInt(this.value));
            } );

            if( checkListLvl1_ids.length > 0){
                $('[xaction="delete_selected_checkListLvl1"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_checkListLvl1"]').prop('disabled', true);
            }

        });

        $('[xaction="save_checkListLvl1"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="checkListLvl1-id"]').val();
            let name = $('[name="checkListLvl1-name"]').val();
            let action =  $('#checkListLvl1Modal').find('#action').val();
            checkListLvl1Action(action, name, id);
        });

        $('[xaction="delete_selected_checkListLvl1"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('checkListLvl1');
        });

        $('[xaction="delete_selected_checkListLvl2"]').on('click', function(e) {
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('checkListLvl2');
        });

        $('[xaction="delete_selected_checkListLvl3"]').on('click', function(e) {
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('checkListLvl3');
        });

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteFor = $('#deleteModal #delete_for').val();
            switch (deleteFor) {
                case 'checkListLvl1':
                    deleteCheckListLvl1();
                    break;
                case 'checkListLvl2':
                    deleteCheckListLvl2();
                    break;
                case 'checkListLvl3':
                    deleteCheckListLvl3();
                    break;
            }
        });

        $('#frm_amendment_assessment').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            submitAmmendmentForm(formData);
        });

        parent.stopLoading();

    });

</script>
</body>
</html>