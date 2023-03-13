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
    <div class="mytitle">Tetapan <span>Laporan Boleh Ubah</span></div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Laporan & Analisis</a></li>
      <li class="breadcrumb-item"><a href="{{ route('report.report_custom') }}">Tetapan Senaraian Boleh Ubah</a></li>
      <li class="breadcrumb-item active" aria-current="page" id="curr_title">Senarai Kenderaan WSP</li>
    </ol>
</nav>
<div class="main-content">
    <form class="form-submit" id="the_form_1">
    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'details');" id="tab1">Keterangan</li>
                <li class="cub-tab" onClick="goTab(this, 'presentation');" id="tab2">Persembahan</li>
            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>
    <section id="details" class="tab-content">
        <input type="hidden" name="section" value="definition"/>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-12 col-12">
                <div class="form-group">
                    <label for="ttl_196">Nama Laporan <em>*</em></label>
                    <input type="text" id="rpt_name" name="rpt_name" value="Senarai Kenderaan WSP">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                <div class="form-group">
                    <label for="ttl_196">Keterangan <em>*</em></label> <textarea id="desc" name="desc" rows="4" cols="50" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group center">
            <button type="submit" class="btn btn-module" >Simpan</button>
            <button class="btn btn-link" type="button"><i class="fal fa-eye"></i> Lihat Hasil Laporan</button>
        </div>
    </section>
    <section id="presentation" class="tab-content">
        <input type="hidden" name="section" value="definition"/>
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-3 col-sm-12 col-12">
                <div class="form-group">
                    <label for="ttl_196">Sumber Data <em>*</em></label>
                    <select class="form-control" id="src-table" name="src-table">
                        <option></option>
                        <optgroup label="Pengurusan Rekod">
                            <option value="mod_veh_ken" selected>&nbsp Rekod Kenderaan</option>
                            <option value="mod_veh_smn">&nbsp Rekod Saman</option>
                            <option value="mod_veh_smn">&nbsp Rekod Pembayaran</option>
                        </optgroup>
                        <optgroup label="Logistik">
                            <option value="mod_log_tem">&nbsp Tempahan Kenderaan</option>
                            <option value="mod_log_ben">&nbsp Tempahan Kenderaan Bencana</option>
                            <option value="mod_log_ben">&nbsp Kenderaan Siap Siaga</option>
                        </optgroup>
                        <optgroup label="Penilaian">
                            <option value="mod_pen_new">&nbsp Penilaian Kenderaan Baharu</option>
                            <option value="mod_pen_acc">&nbsp Penilaian Kemalangan</option>
                            <option value="mod_pen_saf">&nbsp Penilaian Keselamatan & Prestasi</option>
                            <option value="mod_pen_val">&nbsp Penilaian Harga Semasa</option>
                            <option value="mod_pen_lon">&nbsp Penilaian Pinjaman Kerajaan</option>
                            <option value="mod_pen_dis">&nbsp Penilaian Pelupusan</option>
                        </optgroup>
                        <optgroup label="Pemeriksaan & Penyenggaraan">
                            <option value="mod_ppp_pem">&nbsp Pemeriksaan Kenderaan</option>
                            <option value="mod_ppp_pny">&nbsp Penyenggaraan Kenderaan</option>
                            <option value="mod_ppp_war">&nbsp Pengurusan Waran</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-3 col-sm-12 col-12">
                <div class="form-group">
                    <label for="ttl_196">Pemilihan Kolum <em>*</em></label>

                    <div class="table-responsive" style="margin-top:0px">
                        <table class="table-custom stripe">
                            <thead>
                                <tr>
                                    <th class="col-1"><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="1"></th>
                                    <th>Medan</th>
                                    <th>Tapisan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="1"></td>
                                <td>No Pendaftaran</td>
                                <td class="p-1"><input type="text" id="filter1" name="filter1" value=""></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="1"></td>
                                <td>No JKR</td>
                                <td class="p-1"><input type="text" id="filter1" name="filter1" value=""></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="1"></td>
                                <td>Status</td>
                                <td class="p-1"><input type="text" id="filter1" name="filter1" value=""></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="1"></td>
                                <td>Hak Milik</td>
                                <td class="p-1"><input type="text" id="filter1" name="filter1" value=""></td>
                            </tr>
                            <tr>
                                <td><input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="1"></td>
                                <td>Cawangan / Bahagian</td>
                                <td class="p-1"><input type="text" id="filter1" name="filter1" value=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group center">
            <button type="submit" class="btn btn-module" >Simpan</button>
            <button class="btn btn-link" type="button"><i class="fal fa-eye"></i> Lihat Hasil Laporan</button>
        </div>
    </section>
    </form>
</div>
<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script>
    /*
    function selfUpdateAccess(self, module_sub_access_id){
        if(!$(self).is(':checked')){
            $('#mod_fleet_'+module_sub_access_id+'_a').prop('checked', false);
        } else {
            if($('#mod_fleet_'+module_sub_access_id+'_c').is(':checked') &&
            $('#mod_fleet_'+module_sub_access_id+'_r').is(':checked') &&
            $('#mod_fleet_'+module_sub_access_id+'_u').is(':checked') &&
            $('#mod_fleet_'+module_sub_access_id+'_d').is(':checked')){
                $('#mod_fleet_'+module_sub_access_id+'_a').prop('checked', true);
            }
        }
    }

    function initForm(number){
        $('#the_form_'+number).on('submit', function(e){
            e.preventDefault();

            var $formData = $(this).serialize();
            $formData +="&_token={{ csrf_token() }}";

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
                        if($('[name="'+key+'"]').parent().parent().find('.text-danger').length == 0){
                            if(key == 'role_access_id'){
                                $('[name="'+key+'"]').parent().parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            } else {
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }

                    });
                }
            });

        });
    }

    function selfChange(is_multi, content, self){
        if(is_multi == 0){
            $('#'+content).find('[type="checkbox"]').not(self).prop('checked', false);
        }

    }
    */

    jQuery(document).ready(function() {
        initTab();

        $('#modul, #src-table').select2({
            width: '100%',
            theme: "classic"
        });
    })
</script>
</body>
</html>
