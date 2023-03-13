@php

use App\Http\Controllers\User\Detail\UserDetail;
$detail = null;

$title = 'Pendataran Pengguna';
$subTitle = '';
$roleAccessCode = Auth()
    ->user()
    ->roleAccess()
    ? Auth()
        ->user()
        ->roleAccess()->code
    : null;
    
@endphp

@if (request('id') > 0)
    @php
        $title = 'Maklumat Pengguna';
        $subTitle = '';

        $userDetailDAO = new UserDetail();
        $userDetailDAO->userId = request('id');
        $userDetailDAO->mount();
        $user = $userDetailDAO->detail;

    @endphp
@endif

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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
    </script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .table {
            width: 100%;
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
            border: transparent;
            background: #dbdcd8;
        }

        .bootstrap-datetimepicker-widget.dropdown-menu {
            display: block;
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
        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var currentTab = 1;

        function hide(element) {
            $(element).hide();
        }

        function show(element) {
            $(element).show();
        }

        function block(element) {
            $(element).prop('disabled', true);
        }

        function release(element) {
            $(element).prop('disabled', false);
        }

        $(document).ready(function() {});
    </script>
</head>

<body class="content">
    <div class="mytitle">{{ $title }}</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">Akses</a></li>
            <li class="breadcrumb-item"><a href="{{ route('access.user.registered') }}">Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekod Pengguna</li>
        </ol>
    </nav>
    <div class="main-content">

        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12">
                <div class="form-group">
                    <label for="" class="form-label text-dark">Nama Penuh</label>
                    <div class="text-capitalize theme-color-text">
                        {{$user['name']}}
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                <label for="" class="form-label text-dark">Kad Pengenalan</label>
                <div class="text-capitalize theme-color-text">
                    {{$user->detail->identity_no}}
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                <label for="" class="form-label text-dark">Emel</label>
                <div class="text-capitalize theme-color-text">
                    {{$user->email}}
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                <label for="" class="form-label text-dark">Tel Bimbit</label>
                <div class="text-capitalize theme-color-text">
                    {{$user->detail->telbimbit}}
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                <label for="" class="form-label text-dark">Tel Pejabat</label>
                <div class="text-capitalize theme-color-text">
                    {{$user->detail->telpejabat}}
                </div>
            </div>
            @if($user->detail->govStaff)
            <div id="is_gov">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                        <label for="" class="form-label text-dark">Jawatan</label>
                        <div class="text-capitalize theme-color-text">
                            {{$user->detail->govStaff->designation}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                        <label for="" class="form-label text-dark">Kementerian</label>
                        <div class="text-capitalize theme-color-text">
                            {{$user->detail->govStaff->hasMinistry()->name}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                        <label for="" class="form-label text-dark">Jabatan</label>
                        <div class="text-capitalize theme-color-text">
                            {{$user->detail->govStaff->hasDepartment()->jabatan}}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!$user->detail->govStaff)
            <div id="non_gov">
                <div id="is_contractor" style="display: {{$user->detail->jkrStaff ? 'block' : 'none'}}">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                            <label for="" class="form-label text-dark">Nama Syarikat</label>
                            <div class="text-capitalize theme-color-text">
                                {{$user->detail->jkrStaff ? $user->detail->jkrStaff->company_name : '-'}}
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                            <label for="" class="form-label text-dark">No SSM</label>
                            <div class="text-capitalize theme-color-text">
                                {{$user->detail->jkrStaff ? $user->detail->jkrStaff->ssm_no : '-'}}
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                            <label for="" class="form-label text-dark">Nama Projek Terkini</label>
                            <div class="text-capitalize theme-color-text">
                                {{$user->detail->jkrStaff ? $user->detail->jkrStaff->latest_project_name : ''}}
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 col-12 form-group">
                            <label for="" class="form-label text-dark">Kementerian</label>
                            <div class="text-capitalize theme-color-text">
                                {{$user->detail->jkrStaff && $user->detail->jkrStaff->hasMinistry() ? $user->detail->jkrStaff->hasMinistry()->name : '-'}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {

                $('select').select2({
                    width: '100%',
                    theme: "classic"
                });

            });
        </script>
</body>

</html>
