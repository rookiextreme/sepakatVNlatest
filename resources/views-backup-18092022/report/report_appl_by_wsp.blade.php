@php
$total = 0;
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

<script src="{{ asset('my-assets/bootstrap/js/popper.js') }}" type="text/javascript"></script>

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>


<style type="text/css">
    .sect-top {
        position: fixed;
        left:0px;
        width:100%;
        z-index:4;
        padding-left:28px;
        background-color: #f2f4f0;
        padding-bottom:6px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height:165px;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    table.dataTable tbody tr td.combine {
        padding-top: 4px;
        width:30px;
        text-align: center;
    }
    .modal-header {
        font-family: helvetica-bold;
        font-size:18px;
        color:#303030;
		letter-spacing:0px;
		letter-spacing: -1px;
		font-size: 18px;
		line-height: 18px;
    }
    .awas {
        background-position:top right;
        background-size:150px 160px;
        background-repeat: no-repeat;
        min-height: 400px;
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
    td.dt-center {
        text-align: center;
    }
    .dropdown-item {
        font-family: mark;
        font-size:14px;
    }
    .dropdown-item i.fa {
        min-width:40px !important;
        text-align:left;
    }
    .dropdown-header {
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:12px;
        color:#6d7466;
    }
    .header-highlight {
        background-color:#49575c;
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:16px;
        color:#ffffff;
        height: 30px;
        line-height: 30px;
        padding-left:16px;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius:  4px 4px 4px 4px;
    }
    .f1st-menu {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#e7e7e7+0,ffffff+100 */
        margin-top:-5px;
        background: #e7e7e7; /* Old browsers */
        background: -moz-linear-gradient(top,  #e7e7e7 0%, #ffffff 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #e7e7e7 0%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #e7e7e7 0%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e7e7e7', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
    }
    .dropdown-menu {
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
    }
    .catalogue {
        width:100%;
        max-width: 800px;
        padding-left:10px;
        padding-right:10px;
        padding-bottom:30px;
    }
    .catalogue .box-catalogue {
        background-color: #ffffff;
        margin-bottom:10px;
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius:  6px 6px 6px 6px;
        border-color:#d7d7de;
        border-width:2px;
        border-style:solid;
        min-height: 80px;
        height:105px;
    }
    .no-plet {
        font-family: avenir-bold;
        font-size:20px;
        line-height: 45px;
        text-transform: uppercase;
        color:#000000;
    }
    .lokasi {
        font-family: mark;
        font-size:12px;
        line-height:12px;
    }
    .subject {
        font-family: avenir-bold;
        font-size:10px;
        text-transform: uppercase;
        color:#404040;
        margin-top:5px;
    }
    .kategori {
        background-color:#404040;
        font-family: avenir-bold;
        color:#ffffff;
        font-size:12px;
        padding-left:5px;
        margin-bottom:3px;
    }
    .text-uppercase {
        line-height:16px !important;
        margin-top:10px;
    }
    .details {
        font-family: mark;
        font-size:14px;
    }
    .line-t {
        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
    }
    .box-left {
        position: absolute;
        left:10px;
        top:0px;
        margin-left:-8px;
        margin-top:3px;
        width:143px;
        height:95px;
        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        transition: all .2s ease-in-out;
    }
    .box-left:hover {
        transform: scale(1.1);
    }
    .box-right {
        width:80%;
        padding-top:5px;
        margin-left:20px;
    }
    .date .input-group-text {
        height: 39px;
        line-height:28px;
        background-color:#ffffff;
        border-radius: 0px 8px 8px 0px;
        -moz-border-radius: 0px 8px 8px 0px;
        -webkit-border-radius: 0px 8px 8px 0px;
        font-family: avenir;
        font-size: 12px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        border-color:#dcdcd8;
        border-width:2px;
        border-style:solid;
        cursor: pointer;
    }
    .filter-btn {
        height: 42px !important;
        width:42px;
        text-align: center;
        line-height:28px;
        background-color:#ffffff;
        border-radius: none;
        -moz-border-radius: none;
        -webkit-border-radius: none;
        font-family: avenir;
        font-size: 12px;
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
        border-bottom-color:#dcdcd8;
        border-bottom-width:2px;
        border-bottom-style:solid;
        border-top-color:#dcdcd8;
        border-top-width:2px;
        border-top-style:solid;
        border-left-color:#dcdcd8;
        border-left-width:1px;
        border-left-style:solid;
        border-right-style:none;
        cursor: pointer;
        padding-left:0px;
        padding-right:0px;
        line-height:38px;
    }
    .select2-container--open {
        z-index:1060;
    }
    .txt-memo, .txt-memo span {
        font-family: mark;
        font-size:20px;
        line-height: 20px;
        color:#16829b;
    }
    .txt-memo span {
        font-family: mark-bold;
        text-decoration: underline;
        font-size:20px;
        line-height: 20px;
        color:#16829b;
    }
    .txt-memo .confirm {
        font-family: mark-bold;
        font-size:20px;
        line-height: 20px;
        color:#16829b;
    }
    .modal-body {
        vertical-align: middle;
        padding-left:20px;
        padding-right:20px;
    }
    #prompt-container {
        padding-left:30px;
        padding-right:30px;
    }
    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
        .catalogue {
            width:100%;
            max-width: 1000px;
        }
	}
	@media (max-width: 1199.98px) {
		/*Large devices (desktops, less than 1200px)*/
		/*Large*/

	}
	@media (max-width: 991.98px) {
		/* Medium devices (tablets, less than 992px)*/
		/*medium*/
        .box-right {
            width:75%;
        }
	}
	@media (max-width: 767.98px) {
		/* Small devices (landscape phones, less than 768px)
		/*small*/
        .box-right {
            width:70%;
        }
        .data-extra {
            display: none;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .main-content {
            padding-left:20px;
            padding-right:20px;
        }
        .box-right {
            width:65%;
        }
        .sect-top {
            height:150px;
        }
        .sect-top .dropdown {
            margin-top:30px;
        }
        .sect-top nav {
            margin-top:40px;
        }
        .catalogue .box-catalogue {
            height: 100%;
        }
	}
    .nav-btn{
        font-family: mark-bold !important;
        font-size: 12px !important;
        text-transform: uppercase;
        color:rgba(53, 51, 51, 0.637);

    }
    .nav-text{
        font-family: mark !important;
        font-size: 12px !important;
        color:rgba(53, 51, 51, 0.993);

    }
</style>
<script type="text/javascript">
function jumpPage(){
    var year = $('#year').val();
    window.location.href = "{{route('report.report_appl_by_wsp')}}?month="+mth+"&year="+year;
}
function jumpPageWSP(wsp) {
    var year = $('#year').val();
    var mth = $('#mth').val();
    var type = $('#type').val();
    window.location.href = "{{route('report.report_appl_by_wsp')}}?month="+mth+"&year="+year+"&workshop_id="+wsp+"&assessment_type="+type;
}
function jumpPageType(type) {
    var year = $('#year').val();
    var mth = $('#mth').val();
    var id = $('#id').val();
    window.location.href = "{{route('report.report_appl_by_wsp')}}?month="+mth+"&year="+year+"&workshop_id="+id+"&assessment_type="+type;
}
function goCKM() {
    var year = $('#year').val();
    var mth = $('#mth').val();
    window.location.href = "{{route('report.report_appl_by_mth')}}?month="+mth+"&year="+year;
}
function jumpPageMonth(mth)  {
    var year = $('#year').val();
    var id = $('#id').val();
    var type = $('#type').val();
    window.location.href = "{{route('report.report_appl_by_wsp')}}?month="+mth+"&year="+year+"&workshop_id="+id+"&assessment_type="+type;
}
function changeMth() {
    var txtMth = $('#mth').val();
    switch (txtMth) {
        case '00':
            mth = "Seluruh";
            break;
        case '01':
            mth = "Januari";
            break;
        case '02':
            mth = "Februari";
            break;
        case '03':
            mth = "Mac";
            break;
        case '04':
            mth = "April";
            break;
        case '05':
            mth = "Mei";
            break;
        case '06':
            mth = "Jun";
            break;
        case '07':
            mth = "Julai";
            break;
        case '08':
            mth = "Ogos";
            break;
        case '09':
            mth = "September";
            break;
        case '10':
            mth = "Oktober";
            break;
        case '11':
            mth = "November";
            break;
        case '12':
            mth = "Disember";
    }
    $('#mth-name').text(mth);
}
</script>
</head>
@php
    $txtMth = '';
    if(Request('month') == ''){
        $txtMth = sprintf( "%02d", $month);
    }else{
        $txtMth = Request('month');
    }

    $jenis = 'Kenderaan Baharu';
    if($assessment_type == 'new'){
        $jenis = 'Kenderaan Baharu';
    }else if($assessment_type == 'gov'){
        $jenis = 'Pinjaman Kerajaan';
    }else if($assessment_type == 'accident'){
        $jenis = 'Kemalangan';
    }else if($assessment_type == 'safety'){
        $jenis = 'Keselamatan & Prestasi';
    }else if($assessment_type == 'currvalue'){
        $jenis = 'Harga Semasa';
    }else if($assessment_type == 'disposal'){
        $jenis = 'Pelupusan';
    }

    $wspdesc = 'new';
    foreach ( $workshop_list as $workshop){
        if($workshop->id == Request('workshop_id')){
            $wspdesc = $workshop->desc;
        }
    }
@endphp

<body class="content">
    <div class="mytitle">Laporan Woksyop CKM <span>Ringkasan Penilaian</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('assessment.report')}}');">Laporan &amp; Analisis</a></li>

            <li class="breadcrumb-item " aria-current="page"><a href="javascript:goCKM();">Seluruh CKM</a></li>
            <li class="breadcrumb-item active">{{$wspdesc}}</li>
        </ol>
    </nav>
    <input type="hidden" name="year" id="year" value="{{$year}}">
    <input type="hidden" name="mth" id="mth" value="{{$txtMth}}">
    <input type="hidden" name="type" id="type" value="{{$assessment_type}}">
    <input type="hidden" name="id" id="id" value="{{$workshop_id}}">
    @if (Auth::user()->detail->register_purpose == 'is_jkr')
    <div class="inline thin-underline" style="margin-top:15px;margin-right:30px;padding-bottom:4px;">
        Bulan
        <button type="button" class="btn cux-btn bigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="mth-name">

        </button>
        <ul class="dropdown-menu" style="max-width: 50px !important">
            <li><a class="dropdown-item{{$txtMth == "00" ? ' active' : ''}}" data-month="00" value="00" onclick="jumpPageMonth('00');">Seluruh</a></li>
            <li><a class="dropdown-item{{$txtMth == "01" ? ' active' : ''}}" data-month="01" value="01" onclick="jumpPageMonth('01');">Januari</a></li>
            <li><a class="dropdown-item{{$txtMth == "02" ? ' active' : ''}}" data-month="02" value="02" onclick="jumpPageMonth('02');">Februari</a></li>
            <li><a class="dropdown-item{{$txtMth == "03" ? ' active' : ''}}" data-month="03" value="03" onclick="jumpPageMonth('03');">Mac</a></li>
            <li><a class="dropdown-item{{$txtMth == "04" ? ' active' : ''}}" data-month="04" value="04" onclick="jumpPageMonth('04');">April</a></li>
            <li><a class="dropdown-item{{$txtMth == "05" ? ' active' : ''}}" data-month="05" value="05" onclick="jumpPageMonth('05');">Mei</a></li>
            <li><a class="dropdown-item{{$txtMth == "06" ? ' active' : ''}}" data-month="06" value="06" onclick="jumpPageMonth('06');">Jun</a></li>
            <li><a class="dropdown-item{{$txtMth == "07" ? ' active' : ''}}" data-month="07" value="07" onclick="jumpPageMonth('07');">Julai</a></li>
            <li><a class="dropdown-item{{$txtMth == "08" ? ' active' : ''}}" data-month="08" value="08" onclick="jumpPageMonth('08');">Ogos</a></li>
            <li><a class="dropdown-item{{$txtMth == "09" ? ' active' : ''}}" data-month="09" value="09" onclick="jumpPageMonth('09');">September</a></li>
            <li><a class="dropdown-item{{$txtMth == "10" ? ' active' : ''}}" data-month="10" value="10" onclick="jumpPageMonth('10');">Oktober</a></li>
            <li><a class="dropdown-item{{$txtMth == "11" ? ' active' : ''}}" data-month="11" value="11" onclick="jumpPageMonth('11');">November</a></li>
            <li><a class="dropdown-item{{$txtMth == "12" ? ' active' : ''}}" data-month="12" value="12" onclick="jumpPageMonth('12');">Disember</a></li>
        </ul>
        &nbsp;&nbsp;&nbsp;Tahun
        <button type="button" class="btn cux-btn bigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{$year}}
        </button>
        <ul class="dropdown-menu" style="max-width: 50px !important">
            @php
                $yearList = [];
                $yearRange = range(date('Y') - 5, date('Y'));
                foreach ($yearRange as $key) {
                    array_push($yearList,$key);
                }
            @endphp
            @foreach ($yearList as $byYear)
                <li><a href="{{route('report.report_appl_by_wsp', ['workshop_id' => $workshop_id, 'year' => $byYear, 'month' => $month, 'assessment_type' => $assessment_type])}}" class="dropdown-item{{$year == $byYear ? ' active' : ''}}" data-month="{{$byYear}}" value="{{$byYear}}">{{$byYear}}</a></li>
            @endforeach
        </ul>
        &nbsp;&nbsp;&nbsp;JKR Woksyop
        <button type="button" class="btn cux-btn bigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">{{$wspdesc}}
        </button>
        <ul class="dropdown-menu">
            @foreach ( $workshop_list as $workshop)
            <li><a class="dropdown-item{{$workshop->id == Request('workshop_id') ? ' active' : ''}}" data-type="{{$workshop->desc}}" value="{{$workshop->id}}" onclick="jumpPageWSP({{$workshop->id}})">{{$workshop->desc}}</a></li>
            @endforeach
        </ul>
        &nbsp;&nbsp;&nbsp;Jenis Penilaian
        <button type="button" class="btn cux-btn bigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            {{$jenis}}
        </button>
        <ul class="dropdown-menu">
            {{-- <li><a class="dropdown-item{{$assessment_type == 'all' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="all" onclick="jumpPageType('all');">Semua</a></li> --}}
            <li><a class="dropdown-item{{$assessment_type == 'new' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="new" onclick="jumpPageType('new');">Kenderaan Baharu</a></li>
            <li><a class="dropdown-item{{$assessment_type == 'accident' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="accident" onclick="jumpPageType('accident');">Kemalangan</a></li>
            <li><a class="dropdown-item{{$assessment_type == 'safety' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="safety" onclick="jumpPageType('safety');">Keselamatan & Prestasi</a></li>
            <li><a class="dropdown-item{{$assessment_type == 'currvalue' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="currvalue" onclick="jumpPageType('currvalue');">Harga Semasa</a></li>
            <li><a class="dropdown-item{{$assessment_type == 'gov' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="gov" onclick="jumpPageType('gov');">Pinjaman Kerajaan</a></li>
            <li><a class="dropdown-item{{$assessment_type == 'disposal' ? ' active' : ''}}" data-type="{{$assessment_type}}" value="disposal" onclick="jumpPageType('disposal');">Pelupusan</a></li>
        </ul>
        <div class="dropdown inline float-end">
            <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        </div>
    </div>
    @endif
<div class="main-content">
    <div class="table-responsive">
        <div class='row' style='margin-top:10px;margin-bottom:10px;display:none'>
            <div class='col-3'>
                <div class='btn-group'>
                    <button class='btn cux-btn nav-btn' ><i class="fa fa-arrow-left"></i></button>
                    <button class='btn cux-btn nav-btn' ><i class="fa fa-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table-custom no-footer stripe">
            <thead>
                <tr>
                    <th class="lcal-2">Bil</th>
                    <th class="lcal-3">No Rujukan</th>
                    @if($assessment_type == 'all')
                        <th>
                            Jenis Penilaian
                        </th>
                    @endif
                    <th>Pemohon</th>
                    <th class="lcal-3">Tel</th>
                    <th>Kementerian</th>
                    <th>Agensi</th>
                    <th class="lcal-2 text-center">Bilangan Kenderaan</th>
                    <th class="lcal-3">Status Permohonan</th>
                    <th class="lcal-3">Tarikh Temujanji</th>
                </tr>
            </thead>
            <tbody>
                @if ($assessment_type !== 'all')
                    @foreach ($data as $listing)
                        <tr>
                            <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $listing->id, 'ref_number' =>  $listing->ref_number, 'assessment_type' => $assessment_type])}}">{{$data->firstItem()+$loop->index}}</a></td>
                            <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $listing->id, 'ref_number' =>  $listing->ref_number, 'assessment_type' => $assessment_type])}}">{{$listing->ref_number}}</a></td>
                            <td>{{$listing->applicant_name}}</td>
                            <td>{{$listing->phone_no}}</td>
                            <td>{{$listing->hasAgency ? $listing->hasAgency->desc : '-'}}</td>
                            <td>{{$listing->department_name}}</td>
                            <td class="text-center">
                                @if($assessment_type == 'accident')

                                @else
                                    {{$listing->hasVehicleMany ? $listing->hasVehicleMany->count() : 0}}
                                @endif
                            </td>
                            <td>{{$listing->hasStatus ? $listing->hasStatus->desc : '-'}}</td>
                            <td>{{Carbon\Carbon::parse($listing->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($listing->appointment_dt)->format('g:i A')}}</small></td>
                        </tr>
                    @endforeach
                @else
                    @if($assessment_type == 'new')
                        @foreach ($data->hasNew as $New)
                            <tr>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $New->id, 'ref_number' =>  $New->ref_number, 'assessment_type' => 'new'])}}">{{$data->firstItem()+$loop->index}}</a></td>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $New->id, 'ref_number' =>  $New->ref_number, 'assessment_type' => 'new'])}}">{{$New->ref_number}}</a></td>
                                @if($assessment_type == 'all')
                                    <td>
                                        Kenderaan Baharu
                                    </td>
                                @endif
                                <td>{{$New->applicant_name}}</td>
                                <td>{{$New->phone_no}}</td>
                                <td>{{$New->hasAgency->desc}}</td>
                                <td>{{$New->department_name}}</td>
                                <td class="text-center">{{$New->hasVehicle ? $New->hasVehicle->count() : 0}}</td>
                                <td>{{$New->hasStatus->desc}}</td>
                                <td>{{Carbon\Carbon::parse($New->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($New->appointment_dt)->format('g:i A')}}</small></td>
                            </tr>
                        @endforeach
                    @endif
                    @if($assessment_type == 'accident')
                        @foreach ($data->hasAccident as $Accident)
                            <tr>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Accident->id, 'ref_number' =>  $Accident->ref_number, 'assessment_type' => 'accident'])}}">{{$data->firstItem()+$loop->index}}</a></td>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Accident->id, 'ref_number' =>  $Accident->ref_number, 'assessment_type' => 'accident'])}}">{{$Accident->ref_number}}</a></td>
                                @if($assessment_type == 'all')
                                    <td>
                                        Kemelangan Kerosakan
                                    </td>
                                @endif
                                <td>{{$Accident->applicant_name}}</td>
                                <td>{{$Accident->phone_no}}</td>
                                <td>{{$Accident->hasAgency ? $Accident->hasAgency->desc : '-'}}</td>
                                <td>{{$Accident->department_name}}</td>
                                <td class="text-center">{{$Accident->hasVehicle ? $Accident->hasVehicle->count() : 0}}</td>
                                <td>{{$Accident->hasStatus->desc}}</td>
                                <td>{{Carbon\Carbon::parse($Accident->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($Accident->appointment_dt)->format('g:i A')}}</small></td>
                            </tr>
                        @endforeach
                    @endif
                    @if($assessment_type == 'currvalue')
                        @foreach ($data->hasCurrvalue as $Currvalue)
                            <tr>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Currvalue->id, 'ref_number' =>  $Currvalue->ref_number, 'assessment_type' => 'currvalue'])}}">{{$data->firstItem()+$loop->index}}</a></td>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Currvalue->id, 'ref_number' =>  $Currvalue->ref_number, 'assessment_type' => 'currvalue'])}}">{{$Currvalue->ref_number}}</a></td>
                                @if($assessment_type == 'all')
                                    <td>
                                        Harga Semasa
                                    </td>
                                @endif
                                <td>{{$Currvalue->applicant_name}}</td>
                                <td>{{$Currvalue->phone_no}}</td>
                                <td>{{$Currvalue->hasAgency->desc}}</td>
                                <td>{{$Currvalue->department_name}}</td>
                                <td class="text-center">{{$Currvalue->hasVehicle ? $Currvalue->hasVehicle->count() : 0}}</td>
                                <td>{{$Currvalue->hasStatus->desc}}</td>
                                <td>{{Carbon\Carbon::parse($Currvalue->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($Currvalue->appointment_dt)->format('g:i A')}}</small></td>
                            </tr>
                        @endforeach
                    @endif
                    @if($assessment_type == 'disposal')
                        @foreach ($data->hasDisposal as $Disposal)
                            <tr>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Disposal->id, 'ref_number' =>  $Disposal->ref_number, 'assessment_type' => 'disposal'])}}">{{$data->firstItem()+$loop->index}}</a></td>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Disposal->id, 'ref_number' =>  $Disposal->ref_number, 'assessment_type' => 'disposal'])}}">{{$Disposal->ref_number}}</a></td>
                                @if($assessment_type == 'all')
                                    <td>
                                        Pelupusan
                                    </td>
                                @endif
                                <td>{{$Disposal->applicant_name}}</td>
                                <td>{{$Disposal->phone_no}}</td>
                                <td>{{$Disposal->hasAgency->desc}}</td>
                                <td>{{$Disposal->department_name}}</td>
                                <td class="text-center">{{$Disposal->hasVehicle ? $Disposal->hasVehicle->count() : 0}}</td>
                                <td>{{$Disposal->hasStatus->desc}}</td>
                                <td>{{Carbon\Carbon::parse($Disposal->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($Disposal->appointment_dt)->format('g:i A')}}</small></td>
                            </tr>
                        @endforeach
                    @endif
                    @if($assessment_type == 'gov_loan')
                        @foreach ($data->hasGovLoan as $GovLoan)
                            <tr>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $GovLoan->id, 'ref_number' =>  $GovLoan->ref_number, 'assessment_type' => 'gov'])}}">{{$data->firstItem()+$loop->index}}</a></td>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $GovLoan->id, 'ref_number' =>  $GovLoan->ref_number, 'assessment_type' => 'gov'])}}">{{$GovLoan->ref_number}}</a></td>
                                @if($assessment_type == 'all')
                                    <td>
                                        Pinjaman Kerajaan
                                    </td>
                                @endif
                                <td>{{$GovLoan->applicant_name}}</td>
                                <td>{{$GovLoan->phone_no}}</td>
                                <td>{{$GovLoan->hasAgency->desc}}</td>
                                <td>{{$GovLoan->department_name}}</td>
                                <td class="text-center">{{$GovLoan->hasVehicle ? $GovLoan->hasVehicle->count() : 0}}</td>
                                <td>{{$GovLoan->hasStatus->desc}}</td>
                                <td>{{Carbon\Carbon::parse($GovLoan->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($GovLoan->appointment_dt)->format('g:i A')}}</small></td>
                            </tr>
                        @endforeach
                    @endif
                    @if($assessment_type == 'safety')
                        @foreach ($data->hasSafety as $Safety)
                            <tr>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Safety->id, 'ref_number' =>  $Safety->ref_number, 'assessment_type' => 'safety'])}}">{{$data->firstItem()+$loop->index}}</a></td>
                                <td><a href="{{route('report.report_assessment_stmt', [ 'id' =>  $Safety->id, 'ref_number' =>  $Safety->ref_number, 'assessment_type' => 'safety'])}}">{{$Safety->ref_number}}</a></td>
                                @if($assessment_type == 'all')
                                    <td>
                                        Keselamatan & Prestasi
                                    </td>
                                @endif
                                <td>{{$Safety->applicant_name}}</td>
                                <td>{{$Safety->phone_no}}</td>
                                <td>{{$Safety->hasAgency->desc}}</td>
                                <td>{{$Safety->department_name}}</td>
                                <td class="text-center">{{$Safety->hasVehicle ? $Safety->hasVehicle->count() : 0}}</td>
                                <td>{{$Safety->hasStatus->desc}}</td>
                                <td>{{Carbon\Carbon::parse($Safety->appointment_dt)->format('d M Y')}}<br/><small>{{Carbon\Carbon::parse($Safety->appointment_dt)->format('g:i A')}}</small></td>
                            </tr>
                        @endforeach
                    @endif
                @endif
                @if(count($data) == 0)
                    <tr class="no-record">
                        <td colspan="10" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                    </tr>
                @endif
            </tbody>
        </table>
        </div>
        <div class="pagination">{{$data->links('pagination.default')}}</div>
    </div>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        // $('select').select2({
        //         theme: "classic",
        //         placeholder: "[Sila pilih]"
        //     });

        $(document).ready(function(){
            changeMth();

            $('#type').on('change', function(e) {
                e.preventDefault();

                let type = $('option:selected', this).data('type');
                let id = $('option:selected', this).data('id');
                console.log(type, id);
                    parent.startLoading();
                    window.location.href = "{{route('report.report_appl_by_wsp')}}?workshop_id="+{{Request('workshop_id')}}+"&assessment_type="+type;
            });
            $('#workshop').on('change', function(e) {
                e.preventDefault();

                let id = $('option:selected', this).data('id');
                let type = $('option:selected', this).data('type');
                console.log(id, type);
                    parent.startLoading();
                    window.location.href = "{{route('report.report_appl_by_wsp')}}?workshop_id="+id+"&assessment_type="+type;
            });
        });
</script>
</body>
</html>
