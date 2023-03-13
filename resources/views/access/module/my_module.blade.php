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
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">
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

    *, *::before, *::after {
        color: unset;
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
<script>
    $(document).ready(function() {
    });
</script>
</head>

<body class="content">
<div class="mytitle">Modul</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">Modul Akses</a></li>
      <li class="breadcrumb-item active" aria-current="page">Modul Saya</li>
    </ol>
</nav>
<div class="main-content">
    <div class="row">
        @foreach ($list as $module)
            <div class="col-md-4">
                <label for="" class="form-label">{{$module->name_bm}}</label>
                <ul class="list-group">
                    @foreach ($module->getListModuleSub as $submodule)
                        <li class="list-group-item">{{$submodule->name_bm}}
                            <ul class="list-group">
                                <li class="list-group-item">Tambah
                                    <i class="fa fa-{{$submodule->hasAccess->mod_fleet_c ? 'check text-success':'minus text-warning'}}"></i>
                                </li>
                                <li class="list-group-item">Baca
                                    <i class="fa fa-{{$submodule->hasAccess->mod_fleet_r ? 'check text-success':'minus text-warning'}}"></i>
                                </li>
                                <li class="list-group-item">Kemaskini
                                    <i class="fa fa-{{$submodule->hasAccess->mod_fleet_u ? 'check text-success':'minus text-warning'}}"></i>
                                </li>
                                <li class="list-group-item">Hapus
                                    <i class="fa fa-{{$submodule->hasAccess->mod_fleet_d ? 'check text-success':'minus text-warning'}}"></i>
                                </li>
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>

<script>
    jQuery(document).ready(function() {
        initTab();

        $('select').select2({
			width: '60px',
			theme: "classic",
			minimumResultsForSearch: -1
        });
    })
</script>
</body>
</html>
