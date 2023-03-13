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
        padding-bottom:6px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height:220px;
    }
    .title-report {
        display: none;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .btnBoxRight {
        position: absolute;right:25px;top:80px;
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
    .paper {
        background-color: #ffffff;
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
        border-color:#d2d0da;
        border-width: 2px;
        border-style:solid;
        max-width: 1200px;
        padding:10px;
        padding-left:15px;
        min-height: 500px;
    }
    .cux-btn.active {
        background-color:#f2f4f0;
    }
    .date .input-group-text {
        height: 39px;
        margin-left: 2px !important;
        border: transparent;
        background: #dbdcd8;
    }
    .inChartTitle {
        font-family: lato-bold;
        font-size:16px;
        color:#000000;
        margin-top:10px;
        margin-bottom:20px;
    }
    #graph_type_list tbody {
        display: block;
        height: auto;
        max-height:400px;
        overflow: auto;
    }
    #graph_type_list thead, tbody tr {
        display: table;
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
    @media print {
        .title-report {
            display:block;
            font-family: lato-bold;
            font-size:20px;
            margin-bottom: 10%;
        }
        #column_name, .table-responsive .table thead tr .text-end {
            font-family: lato-bold;
            font-size:20px;
        }
        .sect-top {
            display: none;
        }
        .sect-top-dummy {
            display: none;
        }
        .state-shutter {
            display:none !important;
        }
        .info-daerah {
            line-height:8px !important;
        }
        .tab-content {
            display:contents;
        }
        .quick-navigation {
            display: none;
        }
        #graph_type_list tbody {
            max-height:none;
            overflow:unset;
        }
        .paper {
            border-style:none;
            padding-left:0px;
        }
        .inChartTitle {
            display: none;
        }
        #graph_type_list {
            width:400px;
        }
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
</head>

<body class="content">
<div class="sect-top">
    <div class="mytitle">Komposisi Kenderaan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('vehicle.report')}}')">Laporan & Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Komposisi Kenderaan</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-xl-2 col-lg-2 col-md-3">
            <div class="form-group">
                <label for="" class="form-label">Komposisi</label>
                <select class="form-select" name="" id="vehicle_report_composition">
                    <option></option>
                    <option title="Laporan Mengikut Jenis Kenderaan" value="vehicle_type" {{$composition_by == 'vehicle_type' ? 'selected' : ''}}>Jenis Kenderaan</option>
                    <option title="Laporan Mengikut Pengeluar" value="ownership" {{$composition_by == 'ownership' ? 'selected' : ''}}>Pengeluar</option>
                    <option title="Laporan Mengikut Usia" value="age" {{$composition_by == 'age' ? 'selected' : ''}}>Usia</option>
                    <option title="Laporan Mengikut Cawangan" value="branch" {{$composition_by == 'branch' ? 'selected' : ''}}>Cawangan</option>
                    <option title="Laporan Mengikut Negeri" value="state" {{$composition_by == 'state' ? 'selected' : ''}}>Negeri</option>
                </select>
            </div>
        </div>
    @if($composition_by == 'vehicle_type')
        @php

            $ReportVehicleCompositionDAO = new ReportVehicleCompositionDAO();
            $ReportVehicleCompositionDAO->mount();
            $categoryList = $ReportVehicleCompositionDAO->categoryList;
        @endphp
        <div class="col-xl-2 col-lg-2 col-md-3">
            <label for="" class="form-label text-dark">Kategori</label>
            <div class="input-group">
                <select id="category_id" class="form-select" name="category_id" onchange="getSubCategory(this.value)">
                    <option value="">Sila Pilih</option>
                    @foreach ($categoryList as $category )
                        <option
                        {{ $category_id == $category->id ? 'selected': ''}}
                        value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach

                </select>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-3">
            <label for="" class="form-label text-dark">Sub Kategori</label>
            <div class="input-group">
                {{-- todo wired issue --}}
                <select class="form-select" name="sub_category_id" id="list_sub_category">
                    <option value="" selected>Sila Pilih</option>
                </select>
            </div>
        </div>
    @endif
        <div class="col-xl-2 col-lg-2 col-md-3">
            <div class="form-group">
                <label for="" class="form-label">Carta</label>
                <div class="btn-group">
                    <button type="button" id="btn-bar" class="btn cux-btn bigger{{$graph_type == 'bar' ? ' active' : ''}}" onclick="changeChrt('bar')"><i class="fa fa-chart-bar" id="icon-bar"></i></button>
                    <button type="button" id="btn-pie" class="btn cux-btn bigger{{$graph_type == 'pie' ? ' active' : ''}}" onclick="changeChrt('pie')"><i class="fa fa-chart-pie" id="icon-pie"></i></button>
                    <button type="button" id="btn-line" class="btn cux-btn bigger{{$graph_type == 'line' ? ' active' : ''}}" onclick="changeChrt('line')"><i class="fa fa-chart-line" id="icon-line"></i></button>
                </div>
                {{--<select {{empty($composition_by) ? 'disabled' : ''}} class="form-select {{empty($composition_by) ? 'disabled' : ''}}" name="" id="vehicle_report_composition_graph_type">
                    <option value="">Pilih Graf Persembahan </option>
                    <option value="bar" {{$graph_type == 'bar' ? 'selected' : ''}}>Carta Bar</option>
                    <option value="pie" {{$graph_type == 'pie' ? 'selected' : ''}}>Carta Pai</option>
                    <option value="line" {{$graph_type == 'line' ? 'selected' : ''}}>Carta Garis</option>
                </select>--}}
            </div>
        </div>
        <input type="hidden" id="vehicle_report_composition_graph_type" value="{{$graph_type}}">

    </div>
    <div class="btnBoxRight">
        <button type="button" class="btn cux-btn" onClick="window.print();"><i class="fal fa-print"></i>&nbsp;Cetak</button>
    </div>
</div>
<div class="sect-top-dummy"></div>
<div class="title-report">Komposisi Kenderaan <span>Pecahan Kenderaan mengikut Kategori</span></div>
{{--  <div class="main-content">
        <div class="col-md-3">
            <div class="form-group">
                <label for="button" class="form-label"></label>
                <label for="button" class="form-label">
                    <form class="row" id="test_jasper" method="POST" enctype="multipart/form-data">
                        @csrf
                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-download"></i></button>
                    </form>
                </label>
            </div>
        </div>
    </div>
</div>--}}
@if($composition_by)
<div class="quick-navigation" data-fixed-after-touch="">
    <div class="wrapper" style="position: relative">
        <ul id="tabActive">
            <li class="cub-tab active" onClick="goTab(this, 'chart');" id="tab1">Carta</li>
            <li class="cub-tab active" onClick="goTab(this, 'details');" id="tab2">Perincian</li>
        </ul>
        <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
    </div>
</div>
<section id="chart" class="tab-content">
    <div class="paper">
        <div id="graph_type_bar_chart" class="graph_type" style="display: {{$graph_type == 'bar' ? 'block': 'none'}}">
            @include('report.grap_type.graph_type_barchart', [
                'title' => $composition_title,
                'composition_by' => $composition_by,
                'list' => $data
            ])
        </div>

        <div id="graph_type_pie_chart" class="graph_type" style="display: {{$graph_type == 'pie' ? 'block': 'none'}}">
            @include('report.grap_type.graph_type_piechart', [
                'title' => $composition_title,
                'composition_by' => $composition_by,
                'list' => $data
            ])
        </div>

        <div id="graph_type_line_chart" class="graph_type" style="display: {{$graph_type == 'line' ? 'block': 'none'}}">
            @include('report.grap_type.graph_type_linechart', [
                'title' => $composition_title,
                'composition_by' => $composition_by,
                'list' => $data
            ])
        </div>
    </div>
</section>
<section id="details" class="tab-content">
    <div class="paper">
        @php
            $compsDesc = [
                'age' => 'Usia',
                'vehicle_type' => 'Nama',
                'ownership' => 'Jenis Jenama',
                'branch' => 'Nama Cawangan',
                'state' => 'Negeri'
            ]
        @endphp
        <div class="table-responsive" id="graph_type_list" style="display: {{$graph_type ? 'block': 'none'}}">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width:30px"></th>
                        <th id="column_name">{{$compsDesc[$composition_by]}}</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td style="width:30px;text-align:right;font-size:12px;padding-top:10px">{{$loop->index+1}}</td>
                            <td>{{$item->name}}</td>
                            <td class="text-end">{{number_format($item->total, 0)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr/>
        <div style="font-family: mark;font-size:12px;margin-bottom:4px">{{$data->count()}} rekod</div>
    </div>
</section>
{{-- @json($data) --}}
@endif
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script>

    let subCategoryId = {{$sub_category_id}};
    function changeChrt(chrtType) {
        $('#vehicle_report_composition_graph_type').val(chrtType);

        $('.cux-btn #icon-' + chrtType).addClass('icon-white');

        let category_id = '{{$category_id}}';
        let sub_category_id = '{{$sub_category_id}}';
        let composition_by = '{{$composition_by}}';
        let composition_title = '{{$composition_title}}';
        let graph_type = chrtType;

        openPgInFrame("{{route('report.report_compositions')}}?composition_by="+composition_by+"&composition_title="+composition_title+"&category_id="+category_id+"&sub_category_id="+sub_category_id+"&graph_type="+graph_type);
    }
    function getSubCategory(category_id){

        $('#list_sub_category').html('<option value="-1">Sila Pilih</option>');

        $.get("{{route('vehicle.ajax.getSubCategory')}}", {
            category_id: category_id
        }, function(result){

            var count = result.length;
            var totalInit = 0;
            var same = false;

            result.forEach(element => {
                $('#list_sub_category').append('<option value='+element.id+'>'+element.name+'</option>');
                if(subCategoryId == element.id){
                    same = true;
                }
                totalInit++;
            });

            if(count == totalInit){
                if(!same){
                    subCategoryId = -1;
                }
                console.log(subCategoryId);
                $('#list_sub_category').val(subCategoryId).trigger("change");
            }

        });
    }
    jQuery(document).ready(function() {
        initTab();
        @if ($category_id)
            getSubCategory({{$category_id}});
        @endif

        $('#vehicle_report_composition').select2({
            width: '100%',
			theme: "classic",
            placeholder: "[Sila pilih]"
        }).on('select2:select', function (e) {
            let type = this.value;
            let composition_title =  $('option:selected', this).attr('title');
            openPgInFrame("{{route('report.report_compositions')}}?composition_by="+type+"&composition_title="+composition_title);
        });

        $('#category_id').select2({
            width: '100%',
			theme: "classic"
        }).on('select2:select', function (e) {
            let category_id = this.value;
            let composition_by = '{{$composition_by}}';
            let composition_title = '{{$composition_title}}';
            let graph_type = '{{$graph_type}}';

            openPgInFrame("{{route('report.report_compositions')}}?composition_by="+composition_by+"&composition_title="+composition_title+"&category_id="+category_id+"&graph_type="+(category_id ? graph_type : ''));

        });

        $('#list_sub_category').select2({
            width: '100%',
			theme: "classic"
        }).on('select2:select', function (e) {

            let category_id = '{{$category_id}}';
            let sub_category_id = this.value;
            let composition_by = '{{$composition_by}}';
            let composition_title = '{{$composition_title}}';
            let graph_type = '{{$graph_type}}';

            openPgInFrame("{{route('report.report_compositions')}}?composition_by="+composition_by+"&composition_title="+composition_title+"&category_id="+category_id+"&sub_category_id="+sub_category_id+"&graph_type="+graph_type);

        });

        /*$('#vehicle_report_composition_graph_type').select2({
            width: '100%',
			theme: "classic"
        }).on('select2:select', function (e) {

            let category_id = '{{$category_id}}';
            let sub_category_id = '{{$sub_category_id}}';
            let composition_by = '{{$composition_by}}';
            let composition_title = '{{$composition_title}}';
            let graph_type = this.value;

            openPgInFrame("{{route('report.report_compositions')}}?composition_by="+composition_by+"&composition_title="+composition_title+"&category_id="+category_id+"&sub_category_id="+sub_category_id+"&graph_type="+graph_type);
        });*/
    })
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


