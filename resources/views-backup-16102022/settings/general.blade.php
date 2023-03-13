@php
    use App\Http\Controllers\Setting\SettingGeneralDAO;

    $SettingGeneralDAO = new SettingGeneralDAO();
    $SettingGeneralDAO->mount();
    $settingList = $SettingGeneralDAO->settingList;

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

        .leftline-b {
            border-left-style: solid;
            border-left-width: 2px;
            border-left-color: #d1d3cc;
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

        .cursor-pointer {
            cursor: pointer;
        }

    </style>
    <script>
        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Tetapan Umum</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.admin.dashboard') }}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Am & Penetapan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tetapan Umum</li>
        </ol>
    </nav>
    <div class="main-content">

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Ralat!</strong> Terdapat maklumat yang perlu diisi.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('settings.general.save') }}" method="POST" id="the_form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @foreach ($settingList as $setting)
                <input type="hidden" name="setting_ids[]" value="{{$setting->id}}">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">{{$setting->name}} 
                                @if($setting->is_required)
                                    <em>*</em>
                                @endif
                            </label>

                            @if($setting->element_type == 'checkbox')

                                @foreach($setting->hasSettingSub() as $settingSub)

                                    @if($settingSub->type == 'checkbox')
                                        <div class="form-check-inline">
                                            <input class="form-check-input cursor-pointer mt-2" type="checkbox" name="setting_sub_id_{{$setting->id}}[]" id="setting_id_{{$setting->id}}_sub_code_{{$settingSub->code}}"
                                                value="{{$settingSub->id}}" {{$settingSub->status == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label cursor-pointer" for="setting_id_{{$setting->id}}_sub_code_{{$settingSub->code}}">{{$settingSub->name}}</label>
                                        </div>
                                    @endif
                                    
                                @endforeach

                                @else

                                @foreach ($setting->hasSettingSub() as $settingSub)

                                    @if($settingSub->type == 'radio')
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input cursor-pointer" type="radio" name="setting_sub_id_{{$setting->id}}" id="setting_id_{{$setting->id}}_sub_code_{{$settingSub->code}}"
                                                value="{{$settingSub->id}}" {{$settingSub->status == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label cursor-pointer" for="setting_id_{{$setting->id}}_sub_code_{{$settingSub->code}}">{{$settingSub->name}}</label>
                                        </div>
                                    @endif
                                    @if($settingSub->type == 'switch')
                                        <div class="form-switch">
                                            <input class="form-check-input cursor-pointer mt-2" type="checkbox" name="setting_sub_id_{{$setting->id}}" id="setting_id_{{$setting->id}}_sub_code_{{$settingSub->code}}"
                                                value="{{$settingSub->id}}" {{$settingSub->status == 1 ? 'checked' : ''}}>
                                            <label class="form-check-label cursor-pointer" for="setting_id_{{$setting->id}}_sub_code_{{$settingSub->code}}">{{$settingSub->name}}</label>
                                        </div>
                                    @endif
                                @endforeach
                                
                            @endif


                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-group center">
                <button type="submit" class="btn btn-module">Simpan</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>

    <script>
        $(document).ready(function() {})

    </script>
</body>

</html>
