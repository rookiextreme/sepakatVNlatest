@php
    $currentOwnerTypeId = 1;
    if(auth()->user()->detail->hasOwnerType){
        $currentOwnerTypeId = auth()->user()->detail->hasOwnerType->id;
    }
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
    optgroup {
        text-transform: uppercase !important;
    }
    .response-toast {
        position: fixed;
    }
    .preview-file-image-profile {
        width: 250px;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        transition: all .2s ease-in-out;
    }

    .preview-file-signature {
        width: 200px;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        transition: all .2s ease-in-out;
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
    <div class="mytitle">Profail Pengguna</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item active" aria-current="page" id="curr_title">Profail Pengguna</li>
    </ol>
</nav>
<div id="response" class="alert alert-spakat response-toast" role="alert"></div>
<div class="main-content">
    <form class="form-submit" id="the_form_1">
    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'details');" id="tab1">Profail Peribadi</li>
                <li class="cub-tab" onClick="goTab(this, 'presentation');" id="tab2">Tukar Kata Laluan</li>
            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>
    </form>
    <section id="details" class="tab-content">
        <form id="frm_details">
        @csrf

            <input type="hidden" name="user_id" value="{{auth()->user()->id}}"/>
            <input type="hidden" name="register_purpose" value="{{auth()->user()->detail->register_purpose}}">
            <input type="hidden" name="owner_type_id" value="{{$currentOwnerTypeId}}">
            <!--<span id="response"></span>-->
            <fieldset>
                <legend>Gambar</legend>
                <div class="row">
                    <input type="hidden" name="image_profile" value="image_profile"/>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group">
                            <label class="btn cux-btn bigger mb-3" for="doc_image"><i class="fas fa-cloud-upload"></i> {{auth()->user()->detail->doc_image ? 'Tukar Fail' : 'Muat Naik Gambar'}} </label>
                            <input type="file" onchange="changeImage(this)" accept="pdf,image/*" class="form-control d-none" name="doc_image" id="doc_image">

                            <div id="preview-file-image-profile" class="form-group mb-2" style="display: {{auth()->user()->detail->doc_image ? 'block' : 'none'}};height: 100%;">
                            @php
                                $pathUrl = '';
                                $doc_image = auth()->user()->detail->doc_image ? auth()->user()->detail->doc_image : null;
                                $doc_image_path = auth()->user()->detail->doc_image_path ? auth()->user()->detail->doc_image_path : null;
                                if($doc_image && $doc_image_path != null){
                                    $pathUrl =  $doc_image_path.$doc_image;
                                }
                            @endphp
                                <img src="{{$pathUrl}}" class="preview-file-image-profile" id="preview-file-image-profile-embed" type="">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Maklumat Peribadi</legend>
                <div class="row">
                    <input type="hidden" name="personal_info" value="personal_info"/>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="">Nama Penuh <em>*</em></label>
                            <input type="text" id="name" name="name" value="{{auth()->user()->name}}" onkeyup="this.value = this.value.toUpperCase()">
                        </div>
                        <div class="hasErr" id="user_profile_name"></div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="">Kad Pengenalan <em>*</em></label>
                            <input
                            maxlength="14"
                            onkeyup="updateFormat('identityNo', this)"
                            type="text" id="identityNo" name="identityNo" value="{{auth()->user()->detail->identity_no}}" onkeyup="this.value = this.value.toUpperCase()" placeholder="XXXXXX-XX-XXXX">
                        </div>
                        <div class="hasErr" id="user_profile_identityNo"></div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="">No Telefon <em>*</em></label>
                            <input type="text" id="telbimbit" name="telbimbit" value="{{auth()->user()->detail->telbimbit}}">
                        </div>
                        <div class="hasErr" id="user_profile_telbimbit"></div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="">Emel <em>*</em></label>
                            <input type="text" id="emel" name="emel" value="{{auth()->user()->email}}">
                        </div>
                        <div class="hasErr" id="user_profile_emel"></div>
                    </div>
                </div>
                <div class="row">
                    @if(auth()->user()->detail->register_purpose == 'is_jkr')

                    @php
                        if(auth()->user()->detail && auth()->user()->detail->jkrStaff){
                            $currentOwnerTypeId = auth()->user()->detail->jkrStaff->hasOwnerType->id;
                        }
                    @endphp

                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <label class="form-label">Pemilikan</label>
                        @foreach ($owner_type_list as $owner_type)
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" {{$currentOwnerTypeId == $owner_type->id ? 'checked': ''}} disabled id="is_ownership_{{$owner_type->code}}" value="{{$owner_type->id}}">
                                <label class="form-check-label" for="is_ownership_{{$owner_type->code}}">{{$owner_type['desc_bm']}}</label>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                        <label class="form-label">{{auth()->user()->detail->hasOwnerType ? auth()->user()->detail->hasOwnerType->desc_bm : 'Cawangan'}}</label>
                        <select class="form-select branch_id" id="branch_id" name="branch_id" data-placeholder="[Sila pilih]">
                            <option value="">Pilih</option>
                            @foreach ($owner_branch_list as $owner_branch )
                                <option value="{{$owner_branch->id}}" {{auth()->user()->detail->jkrStaff &&  auth()->user()->detail->jkrStaff->hasBranch && auth()->user()->detail->jkrStaff->hasBranch->id == $owner_branch->id ? 'selected': ''}}>{{$owner_branch->name}}</option>
                            @endforeach
                        </select>
                        <div class="hasErr" id="user_profile_branch_id"></div>
                    </div>
                    @elseif(auth()->user()->detail->register_purpose == 'is_gover_agency')
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                        <label for="" class="form-label text-dark">Agensi<span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="agency_id" id="agency_id">
                            @foreach ( $agency_list as $agency)
                                <option {{ auth()->user()->detail->govAgencyStaff && auth()->user()->detail->govAgencyStaff->hasAgency && auth()->user()->detail->govAgencyStaff->hasAgency->id == $agency->id ? 'selected' : ''}} value="{{$agency->id}}">{{strtoupper($agency->desc)}}</option>
                            @endforeach
                        </select>
                        <div class="hasErr" id="user_profile_agency_id"></div>
                        {{-- <input type="text" class="form-control" name="state" id="state"> --}}
                    </div>

                    @elseif(auth()->user()->detail->register_purpose == 'is_contractor')
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                            <label class="form-label">Nama Syarikat <em class="text-danger">*</em></label>
                            <input type="text" autocomplete="off" class="form-control" id="companyname" name="companyname" value="{{auth()->user()->detail->contractorStaff->company_name}}" placeholder="cth. Syarikat Maju Jaya Sdn Bhd">
                            <div class="hasErr" id="user_profile_companyname"></div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                            <label class="form-label">No Ssm <em class="text-danger">*</em></label>
                            <input type="text" autocomplete="off" class="form-control" id="ssm_no" name="ssm_no" value="{{auth()->user()->detail->contractorStaff->ssm_no}}" placeholder="cth. 1111111-X">
                            <div class="hasErr" id="user_profile_ssm_no"></div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                            <label class="form-label">Nama Projek Terkini <em class="text-danger">*</em></label>
                            <input type="text" autocomplete="off" class="form-control" id="latest_project_name" name="latest_project_name" value="{{auth()->user()->detail->contractorStaff->latest_project_name}}" placeholder="cth. Pembinaan 3 Blok Sekolah">
                            <div class="hasErr" id="user_profile_latest_project_name"></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                            <label class="form-label">Kementerian <em class="text-danger">*</em></label>
                            <select class="form-control form-select" name="ministry_id" id="ministry_id">
                                @foreach ( $ministry_list as $ministry)
                                    <option {{ auth()->user()->detail->contractorStaff->hasMinistry && auth()->user()->detail->contractorStaff->hasMinistry->id == $ministry->id ? 'selected' : ''}} value="{{$ministry->id}}">{{strtoupper($ministry->desc)}}</option>
                                @endforeach
                            </select>
                            <div class="hasErr" id="user_profile_ministry_id"></div>
                        </div>
                    @endif

                    @if(auth()->user()->detail->hasOwnerType && auth()->user()->detail->hasOwnerType->code == '01')

                    @endif

                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                        <label for="" class="form-label text-dark">Jabatan / Agensi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="department_name" name="department_name" value="{{auth()->user()->detail->department_name ? auth()->user()->detail->department_name : null}}" onkeyup="this.value = this.value.toUpperCase()">
                        <div class="hasErr" id="user_profile_department_name"></div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                        <label for="" class="form-label text-dark">Woksyop <span class="text-danger">*</span></label>
                        {{-- <select class="form-control form-select" name="workshop_id" id="workshop_id">
                            @foreach ( $workshop_list as $workshop)
                                <option {{ auth()->user()->detail->hasWorkShop && auth()->user()->detail->hasWorkShop->id == $workshop->id ? 'selected' : ''}} value="{{$workshop->id}}">{{$workshop->desc}}</option>
                            @endforeach
                        </select>
                        <div class="hasErr" id="user_profile_workshop_id"></div> --}}
                        {{auth()->user()->detail->hasWorkShop ? auth()->user()->detail->hasWorkShop->desc : 'Tetapan woksyop.Sila hubungi pentadbir sistem'}}
                        {{-- <input type="text" class="form-control" name="state" id="state"> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <label for="" class="form-label text-dark">Alamat  <span class="text-danger">*</span></label>
                        <textarea style="resize: none;" class="form-control" name="address" id="address" onkeyup="this.value = this.value.toUpperCase()" cols="30" rows="3">{{auth()->user()->detail->address}}</textarea>
                        <div class="hasErr" id="user_profile_address"></div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-7 col-sm-6">
                        <div class="row">
                            <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                                <label for="" class="form-label text-dark">Poskod <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="postcode" id="postcode" value="{{auth()->user()->detail->postcode}}">
                                <div class="hasErr" id="user_profile_postcode"></div>
                            </div>
                            <div class="col-xl-5 col-lg-7 col-md-6 col-sm-12">
                                <label for="" class="form-label text-dark">Negeri <span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="state_id" id="state_id">
                                    @foreach ( $state_list as $state)
                                        <option {{ auth()->user()->detail->state_id == $state->id ? 'selected' : ''}} value="{{$state->id}}">{{$state->desc}}</option>
                                    @endforeach
                                </select>
                                <div class="hasErr" id="user_profile_state_id"></div>
                                {{-- <input type="text" class="form-control" name="state" id="state"> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <input type="hidden" name="image_sign" value="image_sign"/>
                <legend>Imej Tandatangan</legend>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                    <div class="form-group">
                        <label class="btn cux-btn bigger mb-3" for="doc_signature"><i class="fas fa-cloud-upload"></i> {{auth()->user()->detail->doc_signature ? 'Tukar Tanda Tangan' : 'Muat Naik Tanda Tangan'}} </label>
                        <input type="file" onchange="changeDocument(this)" accept="image/*" class="form-control d-none" name="doc_signature" id="doc_signature">

                        <div id="preview-file-signature" class="form-group mb-2" style="display: {{auth()->user()->detail->doc_signature ? 'block' : 'none'}};height: 100%;">
                        @php
                            $pathUrl = '';
                            $doc_signature = auth()->user()->detail->doc_signature ? auth()->user()->detail->doc_signature : null;
                            $doc_signature_path = auth()->user()->detail->doc_signature_path ? auth()->user()->detail->doc_signature_path : null;
                            if($doc_signature && $doc_signature_path != null){
                                $pathUrl =  $doc_signature_path.$doc_signature;
                            }
                        @endphp
                            <img src="{{$pathUrl}}" class="preview-file-signature" id="preview-file-signature-embed" type="">
                        </div>
                    </div>
                </div>
            </fieldset>
            <br/>
            <div class="form-group center">
                <button type="submit" class="btn btn-module" >Simpan</button>
            </div>
        </form>
    </section>
    <section id="presentation" class="tab-content">
        <form action="">
            @csrf
            <input type="hidden" name="section" value="definition"/>
            <div class="row">
                <input type="hidden" name="personal_info" value="personal_info"/>
                <div class="col-2">
                    <div class="form-group">
                        <label for="">Kata Laluan Sekarang<em>*</em></label>
                        <input type="password" id="password" name="password" value="" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="">Kata Laluan Baru<em>*</em></label>
                        <input type="password" id="new_password" name="new_password" value="" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="">Ulang Kata Laluan Baru<em>*</em></label>
                        <input type="password" id="repeat_password" name="repeat_password" value="">
                    </div>
                </div>
            </div>

            <div class="row" id='returnMsg'>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">&nbsp; &nbsp;&nbsp; </label>
                    </div>
                </div>
            </div>


            <div class="form-group center">
                <button type="button" class="btn btn-module" onclick='changePassword()'>Kemaskini</button>
            </div>
        </form>
    </section>
</div>
<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script>

    function updateFormat(model, self){
        var key = event.keyCode || event.charCode;
        if(model == 'identityNo'){
            let x = $('#identityNo').val();

            if(key == 8){
                $('#identityNo').val(x);
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
                $('#identityNo').val(x);
            }

        }
    }

    function changeImage(self){
        event.preventDefault();
        let docType = self.id;
        let url = URL.createObjectURL(event.target.files[0]);
            $('#preview-file-image-profile-embed').attr('src', url);
            $('#preview-file-image-profile').show();
    }

    function changeDocument(self){
        event.preventDefault();
        let docType = self.id;
        let url = URL.createObjectURL(event.target.files[0]);
            $('#preview-file-signature-embed').attr('src', url);
            $('#preview-file-signature').show();
    }

    function submitDetail(formData) {
        $('.hasErr').html('');
        $.ajax({
            url: "{{ route('settings.save.details') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                // window.location.reload();
                $('#response').html('<span class="text-warning">Maklumat Berjaya Disimpan</span>').fadeIn(50).fadeOut(5000);
            },
            error: function(response) {
                console.log(response);
                    var errors = response.responseJSON.errors;

                    $.each(errors, function(key, value) {
                        console.log(key, value);
                        $('.hasErr#user_profile_'+key).html(value[0]);
                    });

                    parent.stopLoading();
            }
        });

    }

    function changePassword(){

        //alert('sdad')

        var currentPassword = $('#password').val();
        var newPassword = $('#new_password').val();
        var repeatPassword = $('#repeat_password').val();

        $('#returnMsg label').html('');

        if(newPassword != repeatPassword){

            $('#returnMsg label').css('color','red');
            $('#returnMsg label').html('Kata Laluan Baru Ulangan Tidak Tepat');
            $('#returnMsg label').show();
            return false;
        }

        if(currentPassword=='' || newPassword=='' || repeatPassword==''){

            $('#returnMsg label').css('color','red');
            $('#returnMsg label').html('Sila Isi Semua Field');
            $('#returnMsg label').show();
            return false;


        }

        if(currentPassword==newPassword){

            $('#returnMsg label').css('color','red');
            $('#returnMsg label').html('Kata Laluan Baru Tidak Boleh Sama Dengan Kata Laluan Sekarang');
            $('#returnMsg label').show();
            return false;


        }

        if(newPassword.length <8){

            $('#returnMsg label').css('color','red');
            $('#returnMsg label').html('Kata Laluan Baru Mesti Lebih Dari 8 Perkataan');
            $('#returnMsg label').show();
            return false;

        }


        var url = "{{ route('settings.update.password') }}";


        $.ajax({

            url: url,
            data: {currentPassword: currentPassword, newPassword : newPassword},
            cache: false,
            //contentType: false,
            //processData: false,
            dataType:'json',
            method: 'GET',
            success: function(data){


                if(data == 1){

                    //success
                    $('#returnMsg label').css('color','blue');
                    $('#returnMsg label').html('Penukaran Kata Laluan Berjaya');

                }else if(data == 2){

                    //password wrong
                    $('#returnMsg label').css('color','red');
                    $('#returnMsg label').html('Kata Laluan Salah');

                }else{

                    //password wrong
                    $('#returnMsg label').css('color','red');
                    $('#returnMsg label').html('Something Went Wrong');

                }


                $('#returnMsg label').show();

        },error: function (xhr, ajaxOptions, thrownError) {
                //alert(xhr.status);
                var err = eval("(" + xhr.responseText + ")");
                //alert(err.Message);


            }
        });

    }

    const updateIdentityNo = function(){
        let x = $('#identityNo').val();
        if(x.length !== 7 || x.length !== 9){
            x = x.replace(/[^\w\s]/gi, "");
        }

        if(x.length >= 6){
            x = x.substring(0, 6) + "-" + x.substring(6, x.length);
        }

        if(x.length >= 9){
            x = x.substring(0, 9) + "-" + x.substring(9, x.length);
        }
        $('#identityNo').val(x);
    }

    $(document).ready(function() {
        initTab();

        updateIdentityNo();

        $('select').select2({
            width: '100%',
            theme: "classic",
            placeholder: "[Sila pilih]"
        });

        $('#frm_details').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitDetail(formData);

        });

        $("#password, #new_password, #repeat_password").keypress(function (e) {
            var keyCode = e.keyCode || e.which;


            //Regex for Valid Characters i.e. Alphabets and Numbers.
            //var regex = '/^[A-Za-z0-9_-.$#!&*@%]+$/';
            var regex = /^[A-Za-z0-9_-_@_-]+$/;

            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));

            return isValid;
        });

    })
</script>
</body>
</html>
