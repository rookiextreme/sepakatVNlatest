@php
    $apptotal = 0;
    $acctotal = 0;
    $exmtotal = 0;
    $apptotal = 0;
    $govtotal = 0;
    $distotal = 0;
    $total = 0;
    $columnAppointment = 0;
    $columnAcc = 0;
    $columnExm = 0;
    $columnRMV = 0;
    $columnProv = 0;
    $columnCompleted = 0;
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
        min-width:120px;
        width:120px;
    }
    .data-col {
        min-width:120px;
        width:120px;
        text-align: right;
        font-size:16px;
        cursor: pointer;
    }
    .data-col:hover {
        background-color:#d7d7de;
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
    function jumpPage(mth){
        var year = $('#year').val();
        window.location.href = "{{route('report.report_maintenance_summary')}}?month="+mth+"&year="+year;
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
    $month = date('m');
    $txtMth = '';
    if(Request('month') == ''){
        $txtMth = sprintf( "%02d", $month);
    }else{
        $txtMth = Request('month');
    }
@endphp
<body class="content">
    <div class="mytitle">Ringkasan Penilaian <span>Seluruh CKM</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:openPgInFrame('{{route('assessment.report')}}');">Laporan &amp; Analisis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Seluruh CKM</li>
        </ol>
    </nav>
    <div></div>
    <input type="hidden" name="filter-opt" id="filter-opt" value="">
    <input type="hidden" name="year" id="year" value="{{Request('year')}}">
    <input type="hidden" name="mth" id="mth" value="{{$txtMth}}">
    @if (Auth::user()->detail->register_purpose == 'is_jkr')
    <div class="inline thin-underline" style="margin-top:15px;margin-right:30px;padding-bottom:4px;">
        Bulan
        <button type="button" class="btn cux-btn bigger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="mth-name">

        </button>
        <ul class="dropdown-menu" style="max-width: 50px !important">
            <li><a class="dropdown-item{{$txtMth == "00" ? ' active' : ''}}" data-month="00" value="00" onclick="jumpPage('00');">Seluruh</a></li>
            <li><a class="dropdown-item{{$txtMth == "01" ? ' active' : ''}}" data-month="01" value="01" onclick="jumpPage('01');">Januari</a></li>
            <li><a class="dropdown-item{{$txtMth == "02" ? ' active' : ''}}" data-month="02" value="02" onclick="jumpPage('02');">Februari</a></li>
            <li><a class="dropdown-item{{$txtMth == "03" ? ' active' : ''}}" data-month="03" value="03" onclick="jumpPage('03');">Mac</a></li>
            <li><a class="dropdown-item{{$txtMth == "04" ? ' active' : ''}}" data-month="04" value="04" onclick="jumpPage('04');">April</a></li>
            <li><a class="dropdown-item{{$txtMth == "05" ? ' active' : ''}}" data-month="05" value="05" onclick="jumpPage('05');">Mei</a></li>
            <li><a class="dropdown-item{{$txtMth == "06" ? ' active' : ''}}" data-month="06" value="06" onclick="jumpPage('06');">Jun</a></li>
            <li><a class="dropdown-item{{$txtMth == "07" ? ' active' : ''}}" data-month="07" value="07" onclick="jumpPage('07');">Julai</a></li>
            <li><a class="dropdown-item{{$txtMth == "08" ? ' active' : ''}}" data-month="08" value="08" onclick="jumpPage('08');">Ogos</a></li>
            <li><a class="dropdown-item{{$txtMth == "09" ? ' active' : ''}}" data-month="09" value="09" onclick="jumpPage('09');">September</a></li>
            <li><a class="dropdown-item{{$txtMth == "10" ? ' active' : ''}}" data-month="10" value="10" onclick="jumpPage('10');">Oktober</a></li>
            <li><a class="dropdown-item{{$txtMth == "11" ? ' active' : ''}}" data-month="11" value="11" onclick="jumpPage('11');">November</a></li>
            <li><a class="dropdown-item{{$txtMth == "12" ? ' active' : ''}}" data-month="12" value="12" onclick="jumpPage('12');">Disember</a></li>
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
            @foreach ($yearList as $year)
                <li><a href="{{route('report.report_maintenance_summary', ['year' => $year, 'month' => $month])}}" class="dropdown-item{{Request('year') == $year ? ' active' : ''}}" data-month="{{$year}}" value="{{$year}}">{{$year}}</a></li>
            @endforeach
        </ul>
        <div class="dropdown inline float-end">
            <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        </div>
    </div>
    @endif

@php
// $total = ($listing->new + $listing->safety + $listing->currvalue + $listing->gov + $listing->accident + $listing->disposal)
$rowtotal = 0;
$apptotal = 0;
$exmtotal = 0;
$rmvtotal = 0;
$provtotal = 0;
$completedtotal = 0;
$total = 0;
@endphp
<div class="main-content">
    <div class="table-responsive mt-0 pt-0">
        <table class="table-custom hover stripe" style="margin-top:20px">
            <thead>
                <tr>
                    <th class="col-del">Bil</th>
                    <th>Woksyop CKM</th>
                    <th class="lcal-3 text-end">Temujanji</th>
                    <th class="lcal-3 text-end">Semakan</th>
                    <th class="lcal-3 text-end">Pengesahan Kajian Pasaran</th>
                    <th class="lcal-3 text-end">Pengesahan Jadual Harga</th>
                    <th class="lcal-3 text-end">Selesai</th>
                    <th class="lcal-3 text-end">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workshop as $listing)
                @php
                    $rowtotal = 0;
                    $alltotal = 0;
                    $apptotal = 0;
                    $exmtotal = 0;
                    $rmvtotal = 0;
                    $provtotal = 0;
                    $completedtotal = 0;
                @endphp
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$listing->desc}}</td>
                        {{-- /////////////////////////// --}}
                        <td class="data-col">
                            @if($appointment)
                                @foreach ($appointment as $appoint)
                                    @if ($listing->id == $appoint->id)
                                        @php
                                            $apptotal = $apptotal + 1;
                                            $columnAppointment = $apptotal;
                                        @endphp
                                    @else
                                    @endif
                                @endforeach
                                @php
                                    $rowtotal = $rowtotal + $apptotal;
                                @endphp
                                @if($apptotal >0)
                                    {{$apptotal ? $apptotal : '0'}}
                                @else
                                    0
                                @endif
                            @else
                                {{$apptotal ? $apptotal : '0'}}
                            @endif
                        </td>
                        {{-- /////////////////////////// --}}
                        <td class="data-col">
                            @if($exam)
                                @foreach ($exam as $examination)
                                    @if ($listing->id == $examination->id)
                                        @php
                                            $exmtotal = $exmtotal + 1;
                                            $columnExm = $exmtotal;
                                        @endphp
                                    @else
                                    @endif
                                @endforeach
                                @php
                                    $rowtotal =  $rowtotal + $exmtotal;
                                @endphp
                                @if($exmtotal >0)
                                    {{$exmtotal}}
                                @else
                                    0
                                @endif
                            @else
                                {{$exmtotal ? $exmtotal : '0'}}
                            @endif
                        </td>
                        {{-- /////////////////////////// --}}
                        <td class="data-col">
                            @if($researchMarket)
                                @foreach ($researchMarket as $rm)
                                    @if ($listing->id == $rm->id)
                                        @php
                                            $rmvtotal = $rmvtotal + 1;
                                            $columnRMV = $rmvtotal;
                                        @endphp
                                    @else
                                    @endif
                                @endforeach
                                @php
                                    $rowtotal = $rowtotal + $rmvtotal;
                                @endphp
                                @if($rmvtotal > 0)
                                    {{$rmvtotal ? $rmvtotal : '0'}}
                                @else
                                    0
                                @endif
                            @else
                                {{$rmvtotal ? $rmvtotal : '0'}}
                            @endif
                        </td>
                        {{-- /////////////////////////// --}}
                        <td class="data-col">
                            @if($procurement)
                                @foreach ($procurement as $pro)
                                    @if ($listing->id == $pro->id)
                                        @php
                                            $provtotal = $provtotal + 1;
                                            $columnProv = $provtotal;
                                        @endphp
                                    @else
                                    @endif
                                @endforeach
                                @php
                                    $rowtotal = $rowtotal + $provtotal;
                                @endphp
                                @if($provtotal >0)
                                    {{$provtotal ? $provtotal : '0'}}
                                @else
                                    0
                                @endif
                            @else
                                {{$provtotal ? $provtotal : '0'}}
                            @endif
                        </td>
                        {{-- /////////////////////////// --}}
                        <td class="data-col">
                            @if ($completed)
                                @foreach ($completed as $complete)
                                    @if ($listing->id == $complete->id)
                                        @php
                                            $completedtotal = $completedtotal + 1;
                                            $columnCompleted = $completedtotal;
                                        @endphp
                                    @else
                                    @endif
                                @endforeach
                                @php
                                    $rowtotal = $rowtotal + $completedtotal;
                                @endphp
                                @if($completedtotal >0)
                                    {{$completedtotal ? $completedtotal : '0'}}
                                @else
                                    0
                                @endif
                            @else
                                {{$completedtotal ? $completedtotal : '0'}}
                            @endif
                        </td>
                        {{-- /////////////////////////// --}}
                        <td class="data-col">{{$rowtotal}}</td>
                        {{-- /////////////////////////// --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="col-del">Bil</th>
                    <th>Woksyop CKM</th>
                    <th class="lcal-3 text-end">{{$columnAppointment}}</th>
                    <th class="lcal-3 text-end">{{$columnExm}}</th>
                    <th class="lcal-3 text-end">{{$columnRMV}}</th>
                    <th class="lcal-3 text-end">{{$columnProv}}</th>
                    <th class="lcal-3 text-end">{{$columnCompleted}}</th>
                    <th class="lcal-3 text-end">Jumlah</th>
                </tr>
            </tfoot>
        </table>
    </div>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // $('select').select2({
    //             theme: "classic",
    //             placeholder: "[Sila pilih]"
    //         });


        $('#month').on('change', function(e) {
            e.preventDefault();

            let month = $('option:selected', this).data('month');
            console.log(month);
            let year = {{$year}};

            // window.location.href = "{{ route('report.report_appl_by_mth', ['month' => "+month+"]) }}";
            window.location.href = "{{route('report.report_appl_by_mth')}}?month="+month+"&year="+year;
        });
</script>
<script>
    jQuery(document).ready(function() {
        changeMth();
    })
</script>
</body>
</html>
