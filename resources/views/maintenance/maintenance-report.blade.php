@php

$filter = 'created_by = '.auth()->user()->id;
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

$totalVehicle = DB::table('kenderaans.pendaftarans')
                        ->join('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'kenderaans.pendaftarans.id')
                        ->where('kenderaans.status_semakans.vapp_status_id','!=','1');

$totalSummon = DB::table('kenderaans.pendaftarans')->join('saman.maklumat_kenderaan_saman', 'saman.maklumat_kenderaan_saman.pendaftaran_id', '=', 'kenderaans.pendaftarans.id')
                        ->where('saman.maklumat_kenderaan_saman.status_saman_id','!=','1');

if (in_array($roleAccessCode, array('01'))){
    // $totalVehicle = DB::table('kenderaans.pendaftarans')->count();
    $totalVehicle = DB::table('fleet.fleet_department')->count();
    $totalSummon = $totalSummon->count();
}

if (in_array($roleAccessCode, array('02'))){
    $totalVehicle = DB::table('kenderaans.pendaftarans')->count();
    $totalSummon = $totalSummon->count();
}

if (in_array($roleAccessCode, array('03'))){
    $totalVehicle = DB::table('kenderaans.pendaftarans')->count();
    $totalSummon = $totalSummon->count();
}

if (in_array($roleAccessCode, array('04'))){
    $totalVehicle->where('kenderaans.pendaftarans.user_id','=', Auth()->user()->id);
    $totalVehicle = $totalVehicle->count();

    $totalSummon->where('kenderaans.pendaftarans.user_id','=', Auth()->user()->id);
    $totalSummon = $totalSummon->count();
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

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">
    /*body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
        padding:20px;
    }*/
    .display {
        width:100%;
        padding-left:10px;
        padding-right:10px;
        padding-top:35px;
    }
    body {
        background-color: #f4f5f2;
    }
    .subtitle {
        font-family: mark;
        font-size:16px;
        line-height: 15px;
        color:#2c5c6a;
    }
    .rpt-box {
        position: relative;
        padding-top:18vh;
    }
    .sch-point {
        position: relative;
        height:30vh;
        width:100%;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);
        background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
        margin-left:auto;
        margin-right:auto;
        padding:0px;

        border-radius: 15px 15px 15px 15px;
        -moz-border-radius: 15px 15px 15px 15px;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-style: solid;
        border-color:#c8c8cc;
        border-width:1px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        transition: all .2s ease-in-out;

        background-color: #ffffff;
        padding-left:10px;
        padding-right:10px;
        vertical-align: baseline;
    }
    ul.menu li:first-of-type {
        font-family: avenir-bold;
        text-transform: uppercase;
        font-size: 14px;
        line-height: 16px;
        padding-top:5px;
        padding-bottom:5px;
        margin-top:10px;
        list-style-type: none;
        margin-left:-30px;
        color:#303030;

    }
    ul.menu li {
        line-height: 10px;
        list-style-type: none;
        margin-left:-30px;
        border-bottom-style: solid;
        border-bottom-color:rgba(0,0,0,0.04);
        border-bottom-width:1px;
        padding-top:5px;
        padding-bottom:5px;
    }
    ul.menu li a {
        font-family: mark;
        font-size: 14px;
        line-height:16px;
        color:#303030;
        text-decoration: none;
    }
    ul.menu li a:hover {
        color:#ffa124;
    }
    .rpt-link {
        height:32px;
        /*border-bottom-style: solid;
        border-bottom-color:rgba(0,0,0,0.13);
        border-bottom-width:1px;*/
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        cursor: pointer;
    }
    .rpt-link.boss {
        font-family: mark-bold;
    }
    .rpt-link-end {
        height:32px;
        line-height: 32px;
        text-decoration: none;
        width:100%;
        font-family: mark;
        font-size:15px;
        color:#313131;
        cursor: pointer;
    }
    .rpt-link:hover,  .rpt-link-end:hover {
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        color:#ffa124;
    }
    .ico-rpt {
        height:50px;
        margin-left:0px;
        margin-bottom:25px;
        margin-top:25px;
    }
    .rpt-title {
        position: absolute;
        left:75px;
        top: 35px;
        font-family: mark-bold;
        font-size:18px;
        color:#51574b;
    }
    .table {
        width:100%;
        margin-left:0px;
    }
    .table tbody tr {
        height:30px;
        background-color: transparent;
    }
    .table tbody tr td {
        font-family: mark;
        font-size:14px;
        line-height:30px;
        background-color: transparent;
    }
    .content-row {
        padding-left:20px;padding-right:20px;
    }
    .hailait {
        background-color:#eaede7
    }
    .hailait.end {
        border-radius: 0px 0px 10px 10px;
        -moz-border-radius: 0px 0px 10px 10px;
        -webkit-border-radius: 0px 0px 10px 10px;
        padding-bottom:20px;
    }
    .hailait.stt {
        border-radius: 10px 10px 0px 0px;
        -moz-border-radius: 10px 10px 0px 0px;
        -webkit-border-radius: 10px 10px 0px 0px;
    }
    .subsection {
        font-family: avenir;
        letter-spacing: 4px;
        text-transform: uppercase;
        font-size:10px;
        line-height: 32px;
        padding-left:20px;
        color:#3c3c3c;
        height: 34px;
        background-color: #ffffff;
        border-radius: 25px 25px 25px 25px;
        -moz-border-radius: 25px 25px 25px 25px;
        -webkit-border-radius: 25px 25px 25px 25px;
        border-color:#e2e2e1;
        border-width: 1px;
        border-style:solid;
        width:100%;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
    }
    .btn-spec {
        float: right;
        width:30px;
        height:30px;
        text-align: center;
        cursor: pointer;
        padding-top:3px;
        -webkit-border-radius: 6px;
        -moz-border-radius: 6px;
        border-radius: 6px;
    }
    .btn-spec:hover {
        background-color:#2c5c6a;
    }
    .sub-icon {
        position: relative;
        display:none;
        width:100%;
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
        .main-icon {
            display:none;
        }
        .sub-icon {
            display:block;
            border-bottom-width: 1px;
            border-bottom-color: #c8c0b8;
            border-bottom-style: solid;
            padding-bottom:5px;
        }
        ul.menu li:first-of-type {
            line-height: 12px;
            height:40px;
            padding-top:10px;
        }
        ul.menu li {
            line-height: 12px;
            height:40px;
            padding-top:10px;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .subsection {
            margin-top:20px;
            width:90%;
            margin-right:5%;
            margin-left:5%;
            border-radius: 10px 10px 10px 10px;
            -moz-border-radius: 10px 10px 10px 10px;
            -webkit-border-radius: 10px 10px 10px 10px;
        }
        .ico-rpt {
            margin-left:auto;
            margin-bottom:auto;
        }
        .content-row {
            padding-left:30px;padding-right:30px;
        }
        .header .hailait {
            background:none;
        }
        .header .col-3 {
            height:90px;
            text-align: center;
        }
        .spectitle {
            margin-left:20px;
        }
        ul.menu li:first-of-type {
            line-height: 12px;
            height:30px;
            padding-top:5px;
        }
        ul.menu li {
            line-height: 12px;
            height:30px;
            padding-top:5px;
        }
	}
</style>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
    <div class="mytitle">Laporan & Statistik <span>Pemeriksaan & Penyenggaraan</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a
                    href="javascript:openPgInFrame('{{ route('maintenance.overview') }}')">Pemeriksaan & Penyenggaraan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan &amp; Statistik</li>
        </ol>
    </nav>
    <div class="report-menu">
        <div class="row content-row header main-icon">
            {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 hailait stt" style="position: relative;">
                <img src="{{asset('my-assets/img/ico-rpt-komposisi.svg')}}" class="ico-rpt">
                <div class="rpt-title">Komposisi</div>
            </div> --}}
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" style="position: relative;">
                <img src="{{asset('my-assets/img/ico-rpt-trends.svg')}}" class="ico-rpt">
                <div class="rpt-title">Tren</div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 hailait stt" style="position: relative;">
                <img src="{{asset('my-assets/img/ico-rpt-taburan.svg')}}" class="ico-rpt">
                <div class="rpt-title">Taburan</div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12" style="position: relative;">
                <img src="{{asset('my-assets/img/ico-rpt-senaraian.svg')}}" class="ico-rpt">
                <div class="rpt-title">Senarai</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 subsection">
                Operasi Pemeriksaan & Penyenggaraan
            </div>
        </div>
        <div class="row content-row">
            {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 hailait">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-komposisi.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Komposisi</div>
                </div>
                <ul class="menu">
                    <li>Kerja mengikut Kategori</li>
                    <li><a href="{{ route('report.report_compositions')}}">Keseluruhan</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Jenis Penyelenggaraan</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Pembaikan</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Servis</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Agensi</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Alat Ganti</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Dalaman dan Luaran</a></li>
                </ul>
            </div> --}}
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-trends.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Tren</div>
                </div>
                <ul class="menu">
                    <li>Prestasi Kerja</li>
                    <li><a href="#" onclick="openPgInFrame('{{route('report.report_maintenance_evaluation')}}')">Pemeriksaan </a></li>
                    <li><a href="#" onclick="openPgInFrame('{{route('report.report_scheduled_maintenance_performance')}}')">Prestasi Servis & Pembaikan Berkala</a></li>
                    {{-- <li><a href="{{ route('report.report_spend')}}">Prestasi Belanja</a></li> --}}
                </ul>
                <ul class="menu">
                    <li>Tren</li>
                    <li><a href="{{ route('report.maintenance-trends')}}">Tren Penyenggaraan</a></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 hailait">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-taburan.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Taburan</div>
                </div>
                <ul class="menu">
                    <li>Kerja Senggaraan</li>
                    {{-- <li><a href="{{ route('report.report_map_peninsular')}}">Mengikut Woksyop</a></li> --}}
                    {{-- <li><a href="{{ route('report.report_appl_map_maintenance')}}">Mengikut Woksyop</a></li> --}}
                    <li><a href="{{route('report.report_maintenance_summary')}}">Jadual Ringkasan Penyenggaraan</a></li>
                    <li><a href="{{route('report.report_evaluation_summary')}}">Jadual Ringkasan Pemeriksaan</a></li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-senaraian.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Senaraian</div>
                </div>
                <ul class="menu">
                    <li>Senarai Penuh</li>

                    <li><a href="{{ route('report.report_detail_maintenance')}}">Perincian Kerja mengikut Kategori</a></li>
                    {{-- <li><a href="{{ route('report.report_map_state')}}">Kenderaan Lupus</a></li> --}}
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6 col-12 subsection">
                Pengurusan Waran
            </div>
        </div>
        <div class="row content-row">
            {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 hailait end">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-komposisi.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Komposisi</div>
                </div>
                <ul class="menu">
                    <li>Komposisi</li>
                    <li><a href="{{ route('report.report_compositions')}}">Peruntukan</a></li>
                    <li><a href="{{ route('report.report_compositions')}}">Perbelanjaan</a></li>
                </ul>
            </div> --}}
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-trends.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Tren</div>
                </div>
                <ul class="menu">
                    <li>Penggunaan</li>
                    {{-- <li><a href="{{ route('report.report_completion')}}">Peruntukan Waran</a></li> --}}
                    <li><a href="{{ route('report.report-mhpv-budget-expenditure-by-month')}}">Laporan Perbelanjaan Peruntukan</a></li>
                    <li><a href="{{ route('maintenance.warrant.table')}}?goToTab=4">Laporan Unjuran Peruntukan</a></li>

                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 hailait end">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-taburan.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Taburan</div>
                </div>
                <ul class="menu">
                    {{-- <li>Perbelanjaan</li> --}}
                    {{-- <li><a href="{{ route('report.report_completion')}}">Mengikut Woksyop</a></li> --}}
                </ul>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
                <div class="sub-icon">
                    <img src="{{asset('my-assets/img/ico-rpt-senaraian.svg')}}" class="ico-rpt">
                    <div class="rpt-title">Senaraian</div>
                </div>
                <ul class="menu">
                    <li>Peruntukan</li>
                    <li><a href="javascript:parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 1])}}')">Peruntukan MHPV</a></li>
                    {{-- <li><a href="javascript:parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 2])}}')">KKR</a></li>
                    <li><a href="javascript:parent.openPgInFrame('{{ route('maintenance.warrant.table', ['tab' => 3])}}')">Peruntukan Agensi Luar</a></li> --}}
                </ul>
            </div>
        </div>
    </div>
<script>
    jQuery(document).ready(function() {
    })
</script>
</body>
</html>