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
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>
<style type="text/css">
    body {
        background: rgb(255,255,255);
        background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
        background-attachment:fixed;
    }
    .container {
        margin-top:15%;
        width:550px;
        margin-left:auto;
        margin-right:auto;
    }
    .shadow-box {
        margin-top:2%;
        width:55%;
        margin-left:auto;
        margin-right:auto;
    }
    .round-point {
        position: relative;

        width:280px;
        height:295px;
        /*background: rgb(125,125,125);
        background: linear-gradient(307deg, rgba(125,125,125,1) 0%, rgba(193,198,189,1) 100%);*/
        /*background: rgb(242,244,240);
        background: radial-gradient(circle, rgba(242,244,240,1) 100%, rgba(228,229,226,1) 0%);*/
        margin-left:auto;
        margin-right:auto;
        padding-left:10px;
        padding-right:12px;

        border-radius: 15px 15px 15px 15px;
        -moz-border-radius: 15px 15px 15px 15px;
        -webkit-border-radius: 15px 15px 15px 15px;
        border-style: solid;
        border-color:#c8c8cc;
        border-width:1px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);

        background-color: #ffffff;

        /*background-image:url(my-assets/img/lori.png);
        background-repeat: no-repeat;
        background-position: left bottom;
        background-size: 55%;*/
    }
    .lori {
        background-image:url({{asset('my-assets/img/lori.png')}});
        background-repeat: no-repeat;
        background-position: left bottom;
        background-size: 55%;
    }
    .sch-point {
        position: relative;
        height:293px;
        width:140px;
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
    }
    .spectitle {
        position:absolute;
        top:-50px;
        left:0px;
        width: 100%;
        font-family: helvetica-bold;
        font-size:24px;
        letter-spacing: -1px;
        margin-bottom:20px;
    }
    .pointer {
        position:absolute;
        right:-70px;
        width:40px;
        top:120px;
    }
    .round-point .shadow-point {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        top:330px;
        width: 280px;
        height: 20px;
        background-color: rgba(106,106,106,0.2);
        border-radius: 100px / 50px;
        cursor: pointer;
         /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);
    }
    .sch-point .shadow-point-1 {
        position: absolute;
        margin-left:auto;
        margin-right:auto;
        top:330px;
        width: 140px;
        height: 20px;
        background-color: rgba(106,106,106,0.2);
        border-radius: 100px / 50px;
        cursor: pointer;
         /* Add the blur effect */
        filter: blur(8px);
        -webkit-filter: blur(8px);

    }
    .round-point .my-badge {
        position: absolute;
        top:-18px;
        right:-18px;
        background-color: #e9b600;
        -webkit-border-radius: 255px;
        -moz-border-radius: 255px;
        border-radius: 255px;
        height:30px;
        width: 30px;
        text-align: center;
        font-family: mark-bold;
        font-size: 16px;
        line-height: 28px;
        padding-right:0px;
        color:#ffffff;
    }
    .section {
        text-align: left;

        font-family:avenir;
        text-transform: uppercase;
        letter-spacing:1px;
        font-size:12px;
        line-height: 14px;
    }
    .txt {
        width:100%;
        color:#252525;
        padding:5px;
        height:100px;
    }
    .txt .txt-box {
        padding:10px;
        cursor: pointer;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
    }
    .txt .txt-box:hover {
        background: #cfd0cd;
    }
    .txt-big {
        color:#252525;
        padding:5px;
        margin:5px;
        height:135px;
        padding-top:20px;
        width:128px;
        padding-left:15px;
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        border-radius: 10px;
        cursor: pointer;
    }
    .txt-big:hover {
        background: rgba(207,208,205,0.8);
    }
    .sch-point .row {
        margin-left:-13px;
        margin-right:-13px;
    }
    .line-r {
        border-right-style: solid;
        border-right-color:#e3e3eb;
        border-right-width:1px;
    }
    .line-t {
        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
    }
    .count {
        font-size:30px;
        font-family:helve-bold;
        line-height: 30px;
        color:#212121;
        margin-top:10px;
        margin-bottom:0px;
    }
    .round-point .txt .terms {
        font-size:14px;
        font-family:avenir;
        line-height: 20px;
        color:#212121;
    }
    .crc {
        width:100%;
        height:90px;
        cursor: pointer;
        vertical-align: middle;
        text-align: center;
        -webkit-border-top-left-radius: 14px;
        -webkit-border-top-right-radius: 14px;
        -moz-border-radius-topleft: 14px;
        -moz-border-radius-topright: 14px;
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
        overflow: hidden;

        background-position: cover;
        background-repeat: no-repeat;
    }
    .lcal-2 {
        width:30px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:200px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }
    a.list {
        font-family: lato;
        cursor:pointer;
        color:#000000;
        text-decoration: none;
    }
    a.list:hover {
        color:darkseagreen;
    }
    .hemisphere-top {
        position: absolute;
        top:0px;
        left:0px;
        height:150px;
        width:100%;
        background-color:#dfe0dc;
    }
    .hemisphere-bottom {
        position: absolute;
        top:130px;
        left:0px;
        height:160px;
        width:100%;
        padding-top:50px;
        padding-left:50px;
        padding-right:50px;
    }
    .functitle {
        font-family: helve-bold;
        font-size:22px;
        line-height: 22px;
        letter-spacing: -1px;
        color:#2c5c6a;
    }
    .funccontent {
        margin-top:6px;
        font-family: mark;
        font-size:16px;
        line-height: 18px;
        color:#676767;
    }
    .highlight {
        background-color:#494949;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        border-radius: 15px;
        padding:20px;
        width:100%;
        margin-top:20px;
        min-height: 100px;
        padding-top:40px;
        /*background-repeat: repeat;
        background-size: 12px 11px;*/
        max-width: 185px;
        margin-right:auto;
        margin-left:auto;
    }
    .highlight .ctit {
        font-family: mark-bold;
        font-size:16px;
        line-height: 16px;
        color:#9eafb4;
    }
    .highlight .num {
        font-family: helve-bold;
        font-size:40px;
        line-height: 40px;
        color:#cfd0cd;
    }
    .highlight .jodoh {
        font-family: mark;
        font-size:14px;
        line-height: 14px;
        color:#9eafb4;
        margin-bottom:20px;
    }
    .theme-title {
        position: absolute;
        top:40px;
        left:50px;
        font-family: helve-bold;
        font-size:36px;
        line-height: 36px;
        color:#494949;
        letter-spacing: -2px;
    }
    .theme {
        position: absolute;
        top:30px;
        right:0px;
        width:350px;
    }
    .btn-local {
        background-color:#e3943e;
        font-family:mark;
        font-size:14px;
    }
    .btn-local:hover {
        background-color:#f7c66f;
    }
    .divlinesm {
		height:2px;width:50px;background-color:#afafaf;margin-top:20px;margin-bottom:20px;
	}
    .functitle.maintenance {
        color:#376864;
    }
    .service {
        margin-top:80px;
        margin-left:-50px;
        width:220px;
        position: absolute;
        bottom:-70px;
    }

    #notify {
        display: none;
    }

    .close {
        background:transparent;
        border:none;
        margin-top:-7px;
        margin-right:-7px;
        cursor: pointer;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .close:hover {
        background-color:#ffffff;
    }

    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
        .theme {
            width:250px;
        }
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
        body {
            background: rgb(255,255,255);
            background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(242,244,240,1) 50%, rgba(195,195,195,1) 100%);
            background-attachment:fixed
        }
        .theme-title {
            left:25px;
            font-size:26px;
            line-height: 26px;
        }
        .theme {
            top:80px;
            width:180px;
            z-index: 50;
        }
        .highlight {
            max-width:100%;
        }
        .content {
            margin-left:15px;
            margin-right:15px;
        }
        .hemisphere-bottom {
            padding-left:25px;
            padding-right:25px;
            overflow-y:scroll;
            height:65vh;
            margin-top:20px;
        }
	}
</style>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
<div class="hemisphere-top">
    <div class="theme-title">Penilaian &<br/>Penyenggaraan</div>
    <img src="{{ asset('my-assets/img/theme-penyenggaraan-min.png') }}" class="theme">
</div>
<div class="hemisphere-bottom">
    <div class="row">
        @if (auth()->user()->detail->register_purpose == 'is_public_jkr')
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="notify">
                @if(!auth()->user()->detail->hasWorkshop)
                    <div class="alert alert-dismissible fade show" role="alert" style='background-color: #49575c;color:#ffffff'>
                            Anda tidak mempunyai woksyop/peranan. Sila hubungi pentadbir sistem untuk penetapan woksyop/peranan.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="$(this).alert('close')"><i class="fal fa-times" aria-hidden="true"></i></button>
                    </div>
                @endif

            </div>
        @endif
        <div class="col-xl-10 col-lg-10 col-md-9 col-12">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="functitle">Penilaian <br/>Kenderaan Baharu</div>
                    <div class="btn-group ms-1 me-1 pt-1 pb-1">
                        <button class="btn cux-btn small" type="button" data-url="{{route('access.public.dashboard.info', ['title' => 'Penilaian Kenderaan Baharu'])}}" onclick="infoModule(this)">Info Mockup</button>
                    </div>
                    <div class="funccontent">Penilaian kenderaan baharu bagi memastikan spesifikasi kenderaan memenuhi kehendak agensi.</div>
                    <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('assessment.new.register')}}')">Mula</button>
                    <div class="divlinesm"></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="functitle">Penilaian <br/>Harga Semasa</div>
                    <div class="funccontent">Perkhidmatan penilaian untuk menentukan harga semasa kenderaan.</div>
                    <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('assessment.currvalue.register')}}')">Mula</button>
                    <div class="divlinesm"></div>
                </div>
                {{-- @if (!(Auth()->user()->isPublic())) --}}
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="functitle">Penilaian <br/>Prestasi &amp; Keselamatan</div>
                        <div class="funccontent">Memastikan kenderaan Kerajaan berada pada tahap optimum dari segi keselamatan dan prestasi.</div>
                        <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('assessment.safety.register')}}')">Mula</button>
                        <div class="divlinesm"></div>
                    </div>
                {{-- @endif --}}
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="functitle">Penilaian <br/>Disebabkan Kemalangan</div>
                    <div class="funccontent">Penilaian kerosakan dan penentuan anggaran kos pembaikan akibat dari kemalangan.</div>
                    <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('assessment.accident.register')}}')">Mula</button>
                <div class="divlinesm"></div>
                </div>
                {{-- @if (!(Auth()->user()->isPublic())) --}}
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="functitle">Penilaian untuk<br/>Skim Pinjaman Kerajaan</div>
                        <div class="funccontent">Menentukan harga kenderaan terpakai bagi pegawai kerajaan yang ingin memohon pinjaman kenderaan.</div>
                                            <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('assessment.gov_loan.register')}}')">Mula</button>
                        <div class="divlinesm"></div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="functitle">Penilaian untuk<br/>Tujuan Pelupusan</div>
                        <div class="funccontent">Menilai aset alih kerajaan yang tidak digunakan atau tidak ekonomik untuk dibaiki.</div>
                            <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('assessment.disposal.register')}}')">Mula</button>
                        <div class="divlinesm"></div>
                    </div>
                {{-- @endif --}}
            </div>
            <hr/>
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="functitle maintenance">Pemeriksaan <br/>Kenderaan</div>
                    <div class="funccontent">Pemeriksaan kerosakan kenderaan secara berkala atau on-demand bagi memenuhi keperluan polisi jabatan.</div>
                        <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('maintenance.evaluation.register')}}')">Mula</button>
                    <div class="divlinesm"></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="functitle maintenance">Pembaikan<br/>Kerosakan</div>
                    <div class="funccontent">Perkhidmatan membaiki kerosakan yang telah dianalisa, disaran serta menukar komponen yang perlu.</div>
                        <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('maintenance.job.register')}}')">Mula</button>
                    <div class="divlinesm"></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="functitle maintenance">Servis<br/>Kenderaan</div>
                    <div class="funccontent">Perkhidmatan penyenggaraan secara rutin atau on-demand bagi membaiki kerosakan kenderaan.</div>
                        <button class="btn btn-local mt-4 text-white" onclick="openPgInFrame('{{route('maintenance.job.register')}}')">Mula</button>
                    <div class="divlinesm"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-3 col-12">
            {{--<div class="highlight row" style="position:relative;">
                <div class="col-xl-12 col-lg-12 col-md-12 col-4">
                    <div class="ctit">Mengelolakan</div>
                    <div class="num">4</div>
                    <div class="jodoh">kenderaan</div>
                    <div class="divlinesm"></div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-4">
                    <div class="ctit">Penilaian</div>
                    <div class="num">5</div>
                    <div class="jodoh">rekod</div>
                    <div class="divlinesm"></div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-4">
                    <div class="ctit">Senggaraan</div>
                    <div class="num">3</div>
                    <div class="jodoh" style="margin-bottom:40px">rekod</div>
                </div>
            </div>--}}
        </div>
    </div>
</div>
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style='border-radius: 10px; margin-top: 50%; border: 2px solid #6c757d96; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);'>

        <div class="modal-body">
            <form action="{{route('vehicle.list-alternate')}}">
                <input autocomplete="off" style='width: 100%;  text-align: center;  border: none; font-family: avenir; padding:10px; outline: none;' placeholder='search keyword' name="searchParam" value="">
            </form>
        </div>
    </div>
</div>
<script>

    const infoModule = function(self){

        let url = $(self).data('url');
        window.location.href = url;

    }

    jQuery(document).ready(function() {
        @if (!auth()->user()->detail->hasWorkshop)
            $('#notify').slideDown();
        @endif
    })
</script>
</body>
</html>
