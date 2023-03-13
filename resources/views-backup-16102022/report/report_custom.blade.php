<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <link rel="shortcut icon" href="{{ asset('my-assets/favicon/favicon.png') }}">

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
        .lcal-6 {
            width:250px;
        }
        .cux-box {
            min-width:400px;
            min-height:300px;
            width:60%;
            height:50%;
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
    <div class="mytitle">Tetapan <span>Laporan Boleh Ubah</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Laporan & Statistik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tetapan Senaraian Laporan Boleh Ubah</li>
        </ol>
    </nav>
    <div class="main-content">
        <form class="form-submit" id="the_form">
        <div class="btn-group">
            <a onclick="#" aria-readonly="" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Laporan</a>
            <button data-bs-toggle="modal" data-bs-target="#summonDelModal" id="delete_all" disabled class="btn cux-btn bigger" type="button"><i class="fal fa-trash-alt"></i> Hapus</button>
        </div>
        <table id="ls-gov">
            <thead>
                <tr>
                    <th class="lcal-2 text-center"><input name="chkall" id="chkall" type="checkbox"/></th>
                    <th class="lcal-3">&nbsp;</th>
                    <th class="lcal-6">Tajuk</th>
                    <th>Keterangan</th>
                    <th>Pembuat</th>
                </tr>
            </thead>
            <tbody id="sortable">
                <tr>
                    <td class="del text-center" style="width: 50px;">
                        <input name="chkdel" id="chkdel" type="checkbox" value=""/>
                    </td>
                    <td class="edit text-center">
                        <a class="btn cux-btn" type="button" value="Edit" href="{{route('report.report_custom_data')}}">
                            <i class="fal fa-file-chart-line"></i> Laporan
                        </a>
                    </td>
                    <td class="key"><a href="{{route('report.report_custom_details')}}">Senarai Kenderaan WSP</a></td>
                    <td>Senarai kenderaan aktif di Woksyop Persekutuan sahaja </td>
                    <td>Yusman Yunus</td>
                </tr>
            </tbody>
        </table>
        </form>
    </div>
</body>
