@php
use App\Http\Controllers\Report\ReportVehicleCompositionDAO;

$composition_by = Request('composition_by') ? Request('composition_by') : '';
$composition_title = Request('composition_title') ? Request('composition_title') : '';
$graph_type = Request('graph_type') ? Request('graph_type') : null;
$category_id = Request('category_id') ?: -1;
$sub_category_id = Request('sub_category_id') ?: -1;

if($composition_by == 'vehicle_type'){
    $composition_title = "Laporan Mengikut Jenis Kenderaan";
}
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

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/datatables/datatables.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<!--<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">-->

<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<!--<script src="{{asset('my-assets/plugins/highcharts/code/modules/stock.js')}}"></script>-->
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>

{{--  lodash plugin  --}}
<script src="{{asset('my-assets/plugins/lodash/core.js')}}"></script>

<style type="text/css">
    .sect-top {
        position: fixed;
        left:0px;
        width:100%;
        z-index:4;
        padding-left:28px;
        background-color: #f2f4f0;
        padding-bottom:20px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height:140px;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    table.dataTable tbody tr td.combine {
        padding-top: 4px;
        width:30px;
        text-align: center;
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
    td.dt-center { text-align: center; }
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
        border-radius: 4px 4px 6px 6px;
        -moz-border-radius: 4px 4px 6px 6px;
        -webkit-border-radius:  4px 4px 6px 6px;
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
    .details {
        font-family: mark;
        font-size:14px;
        line-height:14px;
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
        margin-left: 2px !important;
        border: transparent;
        background: #dbdcd8;
    }

    #graph_type_list tbody {
        display: block;
        height: 200px;
        overflow: auto;
    }
    #graph_type_list thead, tbody tr {
        /* display: table; */
        width: 100%;
        table-layout: fixed;/* even columns width , fix width of table too*/
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

    td{

        border:1px solid black;
        padding:10px;
        font-size: 12px;
        text-align: center;
    }

    thead tr{

background-color:rgb(162, 210, 240);



}

tbody tr{

background-color:white;

}

tbody tr td{

font-size: 12px !important;
text-transform: uppercase;
color:black;
vertical-align: middle;

}



thead tr td{
    color:black !important; font-family:mark-bold;
    text-transform: uppercase;
}


</style>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
</head>

<body class="content">
<div class="sect-top">
    <div class="mytitle">Rekod Saman JKR Negeri (Belum Selesai)</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('vehicle.report')}}')">Laporan & Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Rekod Saman JKR Negeri (Belum Selesai)</li>
        </ol>
    </nav>
</div>
<div class="sect-top-dummy"></div>
<div class="dropdown inline float-end">
    <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
</div>
<div class="main-content" style='margin-top:50px;'>
    <div class="detailing">

        <table>
            <thead>
                <tr>
                    <td class="col-mth header-depreciation" rowspan="2" colspan="2">JKR Cawangan Negeri </td>
                    <td class="col-mth header-depreciation" colspan="3" >Jenis Saman</td>
                    <td class="col-mth header-depreciation" rowspan="2">No Plate</td>
                    <td class="col-mth header-depreciation" rowspan="2">No Notis Saman</td>
                    <td class="col-mth header-depreciation" rowspan="2">Tarikh Kesalahan</td>
                    <td class="col-mth header-depreciation" rowspan="2">Tarikh Terima Surat</td>
                    <td class="col-mth header-depreciation" rowspan="2">Tarikh Notis Saman</td>
                    <td class="col-mth header-depreciation" rowspan="2">Jenis Saman</td>
                    <td class="col-mth header-depreciation" rowspan="2">Status</td>
                </tr>
                <tr>

                    <td class="col-mth header-depreciation" >PDRM</td>
                    <td class="col-mth header-depreciation" >JPJ</td>
                    <td class="col-mth header-depreciation" >PBT</td>

                </tr>
            </thead>
            <tbody>
                @foreach ($samanList as $index => $saman)

                <tr>

                    <td class="col-mth header-depreciation" >{{$index+1}}</td>
                    <td class="col-mth header-depreciation" >{{$saman->state}}</td>
                    <td class="col-mth header-depreciation" >
                        @if ($saman->summon_agency_id == 1)
                            1
                        @endif
                    </td>
                    <td class="col-mth header-depreciation" >
                        @if ($saman->summon_agency_id == 2)
                            1
                        @endif
                    </td>
                    <td class="col-mth header-depreciation" >
                        @if ($saman->summon_agency_id == 3)
                            1
                        @endif
                    </td>
                    <td class="col-mth header-depreciation" >{{$saman->plate_no}}</td>
                    <td class="col-mth header-depreciation" >{{$saman->summon_notice_no}}</td>
                    <td class="col-mth header-depreciation" >{{$saman->mistake_date}}</td>
                    <td class="col-mth header-depreciation" >-</td>
                    <td class="col-mth header-depreciation" >{{$saman->notice_date}}</td>
                    <td class="col-mth header-depreciation" >{{$saman->summon_agency_desc}}</td>
                    <td class="col-mth header-depreciation" >Belum Selesai</td>

                </tr>
                @endforeach

                {{-- @foreach ($listArrayKelas as $listData) --}}
                {{-- <tr>

                    <td class="row-item" style="text-transform:uppercase">--</td>



                    <td class="col-focus link" xtype='class' style='font-family:mark !important;font-size:14px !important;padding:8px !important' id='percentageTarget'></td>

                </tr> --}}


            </tbody>
        </table>
    </div>

</div>
{{-- @json($data) --}}

<hr class="mt-1 mb-1 border-1 border-top border-dark">
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script>


    jQuery(document).ready(function() {


    });
</script>
<script>

    function hide(element){
        $(element).hide();
    }

    function show(element){
        $(element).show();
    }

    function block(element){
        $(element).prop('disabled', true);
    }

    function release(element){
        $(element).prop('disabled', false);
    }

    function goTo(url){
        window.location.href = url;
    }

    function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
            param,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
            params_arr = queryString.split("&");
            for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                param = params_arr[i].split("=")[0];
                if (param === key) {
                    params_arr.splice(i, 1);
                }
            }
            if (params_arr.length) rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
    }


    $(document).ready(function() {

        $('#test_jasper').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitTestJasper(formData);
        });

    });
</script>
</body>
</html>


