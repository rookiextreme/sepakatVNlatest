@php

use App\Http\Controllers\User\Role;
use App\Http\Controllers\User\AppModule;
use App\Http\Controllers\User\AppTaskFlow;

$roleDAO = new Role();
$roleDAO ->mount();
$roleDAO ->loadDetail(request('id'));
$detail = $roleDAO ->detail;
$role_id = request('id');
$newCode = $roleDAO ->newCode;
$list_role_access = $roleDAO ->roles_access;
$workshop_list = $roleDAO->workshop_list;

$appModuleDAO = new AppModule();
$appModuleDAO->mount();
$list_module = $appModuleDAO ->list;

$appTaskFlowDAO = new AppTaskFlow();
$appTaskFlowDAO->mount();
$list_taskflow = $appTaskFlowDAO ->list;

$tab = Request('tab') ? Request('tab') : 1;

@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
{{-- import animate tooltip --}}
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>

<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">

    .lcal-1 {
        width:30px;
        max-width: 30px !important;
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
    .form-switch {
        padding-top:0px;
        padding-bottom: 0px;
    }
    .leftline-b {
        border-left-style: solid;
        border-left-width: 2px;
        border-left-color:#d1d3cc;
    }
    .bump {
        max-width:5px;
        width:5px;
        padding:0px !important;
    }
    .top-rad {
        -webkit-border-top-left-radius: 6px;
        -webkit-border-top-right-radius: 6px;
        -moz-border-radius-topleft: 6px;
        -moz-border-radius-topright: 6px;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
    }
    .bot-rad {
        -webkit-border-bottom-right-radius: 6px;
        -webkit-border-bottom-left-radius: 6px;
        -moz-border-radius-bottomright: 6px;
        -moz-border-radius-bottomleft: 6px;
        border-bottom-right-radius: 6px;
        border-bottom-left-radius: 6px;
    }
    .no-underline {
        border-bottom-style: none !important;
        border-bottom-color: #f4f5f2;
    }
    tr.thineight {
        height: 5px;
        max-height: 5px !important;
        line-height: 1px !important;
    }
    tr.thineight td {
        height: 5px;
        max-height: 5px !important;
        line-height: 1px !important;
    }
    .thineight:hover {
        background:none;
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
<script type="text/javascript">
	function chgAll(obj) {
        var fldName = $(obj).attr('id');
        fldName = fldName.slice(0, -2);
        if ($('#' + fldName + "_a").is(':checked')) {
            $('#' + fldName + '_c').prop("checked", true);
            $('#' + fldName + '_r').prop("checked", true);
            $('#' + fldName + '_u').prop("checked", true);
            $('#' + fldName + '_d').prop("checked", true);
            $('#' + fldName + '_report').prop("checked", true);
        }else{
            $('#' + fldName + '_c').prop("checked", false);
            $('#' + fldName + '_r').prop("checked", false);
            $('#' + fldName + '_u').prop("checked", false);
            $('#' + fldName + '_d').prop("checked", false);
            $('#' + fldName + '_report').prop("checked", false);
        }
	}
    function onlyThis(obj) {
        //only allow one options being selected for the same row
        var fldName = $(obj).attr('id');
        var asal = $('#' + fldName).is(':checked');
        var fld = fldName.substring(0, 11);
        $("[id^=" + fld + "]").prop("checked", false);
        if(asal == true){
            $('#' + fldName).prop("checked", true);
        }
    }
</script>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
<div class="mytitle">Peranan</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('access.admin.dashboard')}}')"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Pengurusan Akses</a></li>
      <li class="breadcrumb-item"><a href="{{route('access.roles.list')}}">Senarai Peranan</a></li>
      <li class="breadcrumb-item active" aria-current="page" id="curr_title">{{isset($detail) ? $detail->desc_bm : ''}}</li>
    </ol>
</nav>
<div class="main-content">

    <div id="result"></div>

    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'definisi');" id="tab1">Definisi</li>
                <li class="cub-tab {{$detail ? '': 'disabled'}} " {{$detail ? '': 'disabled'}} onClick="goTab(this, 'keupayaan');" id="tab2">Aras</li>
                <li class="cub-tab {{$detail ? '': 'disabled'}} " {{$detail ? '': 'disabled'}} onClick="goTab(this, 'workflow');" id="tab3">Aliran Tugas</li>
            </ul>
            <div class="under-active">&nbsp;</div>
        </div>
    </div>
    <section id="definisi" class="tab-content">
        <form class="form-submit" id="the_form_1">
            <input type="hidden" name="section" value="definition"/>
            <div class="row">
                <div class="col-xl-1 col-lg-1 col-md-3 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">Kod <em class="text-danger">*</em></label> <input
                            type="text" class="form-control readonly disabled" name="kod"
                            id="kod" readonly disabled value="{{isset($detail) ? $detail->code : $newCode}}" required
                            value=""
                            placeholder="">
                            <div class="hasErr"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-8 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">Peranan <em class="text-danger">*</em></label> <input
                            type="text" class="form-control" name="role_name"
                            id="role_name" required autocomplete="off"
                            value="{{isset($detail) ? $detail->desc_bm : ''}}"
                            placeholder="">
                            <div class="hasErr"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-8 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">Woksyop Kawalan <em class="text-danger">*</em></label>
                        <select class="form-control form-select" id="" name="workshop_id">
                            <option value="">Sila Pilih</option>
                            @foreach ($workshop_list as $workshop)
                                <option {{$detail && $detail->hasWorkshop->id == $workshop->id ? 'selected': ''}} value="{{$workshop->id}}">{{$workshop->desc}}</option>
                            @endforeach
                        </select>
                        <div class="hasErr"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">Keterangan <em class="text-danger">*</em></label> <textarea id="desc" name="desc" rows="4" cols="50" class="form-control">{{isset($detail) ? $detail->task_desc_bm : ''}}</textarea>
                        <div class="hasErr"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">Akses <em class="text-danger">*</em></label>

                        @foreach ($list_role_access as $roleAccess)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="role_access_id" id="inlineRadio-{{$roleAccess->id}}" value="{{$roleAccess->id}}"
                                @if($detail && $detail->roleAccess && $detail->roleAccess->code == $roleAccess->code) checked @else @endif
                                >
                                <label class="form-check-label" for="inlineRadio-{{$roleAccess->id}}">{{$roleAccess->desc_bm}}</label>
                            </div>
                        @endforeach
                        <div class="hasErr"></div>
                    </div>
                </div>
            </div>
            <div class="form-group center">
                <button type="submit" class="btn btn-module" >Simpan</button>
                <button type="button" class="btn btn-reset" onclick="window.location.href='{{route('access.roles.list')}}'">Batal</button>
            </div>
            <p>&nbsp;</p>
        </form>
    </section>
    <section id="keupayaan" class="tab-content">
        <form class="form-submit" id="the_form_2">
            <input type="hidden" name="section" value="access_sub_module"/>
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-8 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">ARAS MODUL</label>
                        @php

                            $totalSubModule = 0;

                        @endphp
                        @foreach ($list_module as $module)
                            <table>
                                <thead>
                                    <tr>
                                        <th class="bump">&nbsp;</th>
                                        <th class="keyloc form-group top-rad"><label for="ttl_196">{{$module->name_bm}}</label></th>
                                        <th class="text-center form-group lcal-3"><label for="ttl_196">Semua</label></th>
                                        <th class="text-center form-group lcal-3 leftline"><label for="ttl_196">Tambah</label></th>
                                        <th class="text-center form-group lcal-3 leftline"><label for="ttl_196">Baca</label></th>
                                        <th class="text-center form-group lcal-3 leftline"><label for="ttl_196">Ubah</label></th>
                                        <th class="text-center form-group lcal-3 leftline"><label for="ttl_196">Hapus</label></th>
                                        <th class="text-center form-group lcal-3 leftline"><label for="ttl_196">Laporan</label></th>
                                        <th class="keyloc form-group lcal-3 text-center top-rad pr-0 pl-0"><label for="ttl_196">Woksyop Kawalan <i class="fas fa-question-circle cursor-pointer" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="top" title="Terhad" data-bs-content="Akses kepada data adalah terhad untuk cawangan sendiri sahaja. Cth: Pentadbir Operasi yang berada di JKR Negeri Kedah hanya boleh mengakses rekod kenderaan negeri Kedah sahaja."></i></label></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($module->getListModuleSub as $module_sub)
                                    <input type="hidden" name="module_sub_access_id_{{$module_sub->id}}" value="{{$module_sub->getAccess($role_id)->id}}">
                                        <tr>
                                            <td class="p-0">&nbsp;</td>
                                            <td class="keyloc">{{$module_sub->name_bm}}</td>
                                            <td class="text-center"><div class="form-switch"><input
                                                {{
                                                    $module_sub->getAccess($role_id)->mod_fleet_a == 1 &&
                                                    $module_sub->getAccess($role_id)->mod_fleet_c == 1 &&
                                                    $module_sub->getAccess($role_id)->mod_fleet_r == 1 &&
                                                    $module_sub->getAccess($role_id)->mod_fleet_u == 1 &&
                                                    $module_sub->getAccess($role_id)->mod_fleet_d == 1 &&
                                                    $module_sub->getAccess($role_id)->mod_fleet_report == 1
                                                ?
                                                'checked' : '' }}
                                                class="form-check-input" type="checkbox" id="mod_fleet_{{$module_sub->id}}_a" name="module_sub_access_id_{{$module_sub->id}}_mod_fleet_a" onchange="chgAll(this)"></div></td>
                                            <td class="text-center leftline-b"><div class="form-switch"><input onchange="selfUpdateAccess(this, {{$module_sub->id}})" {{$module_sub->getAccess($role_id)->mod_fleet_c == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="mod_fleet_{{$module_sub->id}}_c" name="module_sub_access_id_{{$module_sub->id}}_mod_fleet_c"></div></td>
                                            <td class="text-center leftline"><div class="form-switch"><input onchange="selfUpdateAccess(this, {{$module_sub->id}})" {{$module_sub->getAccess($role_id)->mod_fleet_r == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="mod_fleet_{{$module_sub->id}}_r" name="module_sub_access_id_{{$module_sub->id}}_mod_fleet_r"></div></td>
                                            <td class="text-center leftline"><div class="form-switch"><input onchange="selfUpdateAccess(this, {{$module_sub->id}})" {{$module_sub->getAccess($role_id)->mod_fleet_u == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="mod_fleet_{{$module_sub->id}}_u" name="module_sub_access_id_{{$module_sub->id}}_mod_fleet_u"></div></td>
                                            <td class="text-center leftline"><div class="form-switch"><input onchange="selfUpdateAccess(this, {{$module_sub->id}})" {{$module_sub->getAccess($role_id)->mod_fleet_d == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="mod_fleet_{{$module_sub->id}}_d" name="module_sub_access_id_{{$module_sub->id}}_mod_fleet_d"></div></td>
                                            <td class="text-center leftline"><div class="form-switch"><input onchange="selfUpdateAccess(this, {{$module_sub->id}})" {{$module_sub->getAccess($role_id)->mod_fleet_report == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="mod_fleet_{{$module_sub->id}}_report" name="module_sub_access_id_{{$module_sub->id}}_mod_fleet_report"></div></td>
                                            <td class="text-center keyloc lcal-3"><div class="form-switch"><input {{$module_sub->getAccess($role_id)->fleet_has_limit == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" id="fleet_has_{{$module_sub->id}}_limit" name="module_sub_access_id_{{$module_sub->id}}_fleet_has_limit"></div></td>
                                        </tr>
                                    @endforeach
                                    @php
                                        $totalSubModule = $totalSubModule + (count($module->getListModuleSub))
                                    @endphp
                                </tbody>
                            </table>
                        @endforeach
                        <input type="hidden" name="totalSubModule" value="{{$totalSubModule}}">
                    </div>
                </div>
            </div>
            <div class="form-group center">
                <button type="submit" class="btn btn-module" type="submit">Simpan</button>
                <button type="button" class="btn btn-reset" onclick="window.location.href='{{route('access.roles.list')}}'">Batal</button>
            </div>
            <p>&nbsp;</p>
        </form>
    </section>
    <section id="workflow" class="tab-content">
        <form class="form-submit" id="the_form_3">
            <input type="hidden" name="section" value="workflow"/>
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-8 col-sm-12 col-12">
                    <div class="form-group">
                        <label for="ttl_196">ARAS MODUL</label>
                        @php
                            $totalTaskFlowSub = 0;
                        @endphp
                        @foreach ($list_taskflow as $taskflow)
                            <table>
                                <thead>
                                    <tr>
                                        <th class="bump">&nbsp;</th>
                                        <th class="keyloc form-group top-rad"><label for="ttl_196">{{$taskflow->name_bm}}</label></th>
                                        @if($taskflow->is_appointment)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_appointment_bm}}
                                                </label>
                                            </th>
                                        @endif
                                        @if($taskflow->is_verify)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_verify_bm}}
                                                </label>
                                            </th>
                                        @endif
                                        @if($taskflow->is_approval)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_approval_bm}}
                                                </label>
                                            </th>
                                        @endif
                                        @if($taskflow->is_pass)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_pass_bm}}
                                                </label>
                                            </th>
                                        @endif
                                        @if($taskflow->is_can_edit_after_approve)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_can_edit_after_approve_bm}}
                                                </label>
                                            </th>
                                        @endif
                                        @if($taskflow->is_can_dispose_federal)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_can_dispose_federal_bm}}
                                                </label>
                                            </th>
                                        @endif
                                        @if($taskflow->is_can_dispose_state)
                                            <th class="text-center form-group lcal-3 leftline">
                                                <label for="ttl_196">
                                                    {{$taskflow->is_can_dispose_state_bm}}
                                                </label>
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taskflow->getListTaskFlowSub as $taskflow_sub)
                                    <input type="hidden" name="taskflow_sub_access_id_{{$taskflow_sub->id}}" value="{{$taskflow_sub->getAccess($role_id)->id}}">
                                        <tr id="taskflow_sub_access_id_{{$taskflow_sub->id}}">
                                            <td class="p-0">&nbsp;</td>
                                            <td class="keyloc">{{$taskflow_sub->name_bm}}</td>
                                            @if($taskflow->is_appointment)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_appointment == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_appointment">
                                                    </div>
                                                </td>
                                            @endif
                                            @if($taskflow->is_verify)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_verify == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_verify">
                                                    </div>
                                                </td>
                                            @endif
                                            @if($taskflow->is_approval)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_approval == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_approval">
                                                    </div>
                                                </td>
                                            @endif
                                            @if($taskflow->is_pass)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_pass == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_pass">
                                                    </div>
                                                </td>
                                            @endif
                                            @if($taskflow->is_can_edit_after_approve)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_can_edit_after_approve == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_can_edit_after_approve">
                                                    </div>
                                                </td>
                                            @endif
                                            @if($taskflow->is_can_dispose_federal)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_can_dispose_federal == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_can_dispose_federal">
                                                    </div>
                                                </td>
                                            @endif
                                            @if($taskflow->is_can_dispose_state)
                                                <td class="text-center">
                                                    <div class="form-switch">
                                                        <input class="form-check-input" type="checkbox" id="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet" {{$taskflow_sub->getAccess($role_id)->mod_fleet_can_dispose_state == 1 ? 'checked' : '' }} onchange="selfChange({{$taskflow_sub->is_multi ? 1 : 0}}, 'taskflow_sub_access_id_{{$taskflow_sub->id}}', this)" name="taskflow_sub_access_id_{{$taskflow_sub->id}}_mod_fleet_can_dispose_state">
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    @php
                                        $totalTaskFlowSub = $totalTaskFlowSub + (count($taskflow->getListTaskFlowSub))
                                    @endphp
                                </tbody>
                            </table>
                        @endforeach
                        <input type="hidden" name="totalTaskFlowSub" value="{{$totalTaskFlowSub}}">
                    </div>
                </div>
            </div>
            <div class="form-group center">
                <button type="submit" class="btn btn-module">Simpan</button>
                <button type="button" class="btn btn-reset" onclick="window.location.href='{{route('access.roles.list')}}'">Batal</button>
            </div>
            <p>&nbsp;</p>
        </form>
    </section>
</div>
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>

<script>

    function selfUpdateAccess(self, module_sub_access_id){
        if(!$(self).is(':checked')){
            $('#mod_fleet_'+module_sub_access_id+'_a').prop('checked', false);
        } else {
            if(
                $('#mod_fleet_'+module_sub_access_id+'_c').is(':checked') &&
                $('#mod_fleet_'+module_sub_access_id+'_r').is(':checked') &&
                $('#mod_fleet_'+module_sub_access_id+'_u').is(':checked') &&
                $('#mod_fleet_'+module_sub_access_id+'_d').is(':checked') &&
                $('#mod_fleet_'+module_sub_access_id+'_report').is(':checked')
            ){
                $('#mod_fleet_'+module_sub_access_id+'_a').prop('checked', true);
            }
        }
    }

    function initForm(number){
        $('#the_form_'+number).on('submit', function(e){
            e.preventDefault();

            var $formData = $(this).serialize();
            $formData +="&_token={{ csrf_token() }}";

            parent.startLoading();

            $.ajax({
                url: "{{route('access.roles.detail.save')}}",
                type: 'post',
                data: $formData,
                dataType: 'json',
                success: function(response) {
                    window.location.href =  response['back_to_url'];
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        console.log($('[name="'+key+'"]').parent());
                        if($('[name="'+key+'"]').parent().parent().find('.hasErr .text-danger').length == 0){
                            if(key == 'role_access_id'){
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            } else {
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }

                    });
                    parent.stopLoading();
                }
            });

        });
    }

    function selfChange(is_multi, content, self){
        if(is_multi == 0){
            $('#'+content).find('[type="checkbox"]').not(self).prop('checked', false);
        }

    }

    let tab = {{$tab}};

    jQuery(document).ready(function() {
        initTab();
        $('#tab'+tab).trigger('click');
        initForm(tab);

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
        })

        var inputs = $('#role_name').find('input[type="text"]');
        inputs.keyup(function() {
            console.log($(this));
        });

        $('#role_name').keyup(function() {
            var dInput = this.value;
            $('#curr_title').text(dInput);
        });

        $('select').select2({
			theme: "classic",
			minimumResultsForSearch: -1
        });

        $('#tab2').on('click', function(){
            initForm(2);
        });

        $('#tab3').on('click', function(){
            initForm(3);
        });

    })
</script>
</body>
</html>
