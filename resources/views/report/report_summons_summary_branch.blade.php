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
<link href="{{asset('my-assets/jquery-ui-1.13.0/jquery-ui.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('my-assets/plugins/lodash/core.js')}}"></script>

<script src="{{asset('my-assets/jquery-ui-1.13.0/jquery-ui.js')}}"></script>

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

        width: 100%;
        table-layout: fixed;even columns width , fix width of table too
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


    @media print {
        @page {
            size: 'A4' portrait; /* auto is default portrait; */
        }

        .col-md-6 {
            width: 50%;
        }

        .no-printme  {
            display: none;
        }
        .printme  {
            display: block;
        }
        .printme th, .printme td {
            padding-left: 10px;
        }
        .body,.content {
            background: transparent;
        }
        .box-info {
            border: none;
            height: 30px;
        }

        .rlabel, .mytext {
            line-height: unset;
        }

        .dragdrop {
            display: none;
        }

        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
        }
    }

    .ui-sortable-helper, .ui-sortable-placeholder {
        background: yellow  !important;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
</head>

<body class="content">
<div class="sect-top no-printme">
    <div class="mytitle">Ringkasan Saman</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('vehicle.report')}}')">Laporan & Analisis</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ringkasan Saman</li>
        </ol>
    </nav>
    <div class="dropdown inline float-end no-printme">
        <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        <a class="btn cux-btn bigger" href="{{route('report.report.summon.export.excel', ['view' => 'report_summons_summary_branch'])}}"> <i class="fa fa-file-export"></i> Excel</a>
    </div>
</div>
<div class="sect-top-dummy no-printme"></div>
<div class="main-content" style='margin-top:50px;'>
    <div class="detailing">
       <table>
            <thead>
                <tr>
                    <td class="col-mth header-depreciation" rowspan="2"> Bil</td>
                    {{-- JKR Cawangan Ibu Pejabat / Negeri --}}
                    <td class="col-mth header-depreciation" rowspan="2">Pemilik</td>
                    <td class="col-mth header-depreciation" colspan="3" >Pengeluar Saman</td>
                    <td class="col-mth header-depreciation" rowspan="2">Jumlah Bilangan Saman</td>
                    <td class="col-mth header-depreciation" colspan="2">Selesai</td>
                    <td class="col-mth header-depreciation" colspan="2">Belum Selesai</td>
                </tr>
                <tr>

                    <td class="col-mth header-depreciation" >PDRM</td>
                    <td class="col-mth header-depreciation" >JPJ</td>
                    <td class="col-mth header-depreciation" >PBT</td>
                    <td class="col-mth header-depreciation" >Bil</td>
                    <td class="col-mth header-depreciation" >%</td>
                    <td class="col-mth header-depreciation" >Bil</td>
                    <td class="col-mth header-depreciation" >%</td>
                </tr>
            </thead>
            <tbody id="sortable_summary_branch">

                @php
                    $grandTotalPDRM = 0;
                    $grandTotalJPJ = 0;
                    $grandTotalPBT = 0;
                    $grandTotalSummon = 0;
                    $grandTotalDone = 0;
                    $grandTotalNotYet = 0;
                @endphp

                @foreach ($list as $item)
                @php
                    $pdrm = $item->hasManySummon('pdrm');
                    $jpj = $item->hasManySummon('jpj');
                    $pbt = $item->hasManySummon('pbt');
                    $totalSummon = $pdrm+$jpj+$pbt;

                    $summon_done = $item->hasManySummon('done');
                    $summon_notyet = $item->hasManySummon('notyet');

                    $grandTotalPDRM += $pdrm;
                    $grandTotalJPJ += $jpj;
                    $grandTotalPBT += $pbt;
                    $grandTotalSummon += $totalSummon;
                    $grandTotalDone += $summon_done;
                    $grandTotalNotYet += $summon_notyet;

                @endphp
                <tr class="ui-state-default" data-id="{{$item->id}}">
                    @if(auth()->user()->isAdmin())
                    <td class="cursor-pointer"><span class="dragdrop ui-icon ui-icon-arrowthick-2-n-s"></span>{{$loop->index + 1}}</td>
                    @else
                    <td>{{$loop->index + 1}}</td>
                    @endif
                    <td class="col-mth header-depreciation" style="text-align: left;" >{{$item->name}}</td>
                    <td class="col-mth header-depreciation">
                        {{$pdrm}}
                    </td>
                    <td class="col-mth header-depreciation">
                        {{$jpj}}
                    </td>
                    <td class="col-mth header-depreciation">
                        {{$pbt}}
                    </td>
                    <td class="col-mth header-depreciation">
                        {{$totalSummon}}
                    </td>
                    <td class="col-mth header-depreciation">{{$summon_done}}</td>
                    <td class="col-mth header-depreciation">{{$summon_done > 0 ? round($summon_done/$totalSummon * 100) : 0}}</td>
                    <td class="col-mth header-depreciation">{{$summon_notyet}}</td>
                    <td class="col-mth header-depreciation">{{$summon_notyet > 0 ? round($summon_notyet/$totalSummon * 100) : 0}}</td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="2" class="text-right" style="text-align: right">
                        <label for="" class="form-label text-right">JUMLAH</label>
                    </td>
                    <td class="col-mth header-depreciation">{{$grandTotalPDRM}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalJPJ}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalPBT}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalSummon}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalDone}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalDone > 0 ? round($grandTotalDone/$grandTotalSummon * 100) : 0}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalNotYet}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalNotYet > 0 ? round($grandTotalNotYet/$grandTotalSummon * 100) : 0}}</td>
                </tr>

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

        @if (Auth()->user()->isAdmin())
        $( "#sortable_summary_branch" ).sortable({
            cursor: "move",
            update: function(event, ui) {
                //console.log(ui.item[0]);
                let id = $(ui.item).data('id');
                // console.log('id => ', id);
                // console.log('update: '+ui.item.index());
            },
            start: function(event, ui) {
                //console.log('start: ' + ui.item.index())
            },
            stop: function (evt) {
  				var itemEl = evt.item;  // dragged HTMLElement
  				evt.to;    // target list
  				evt.from;  // previous list
  				evt.oldIndex;  // element's old index within old parent
  				evt.newIndex;  // element's new index within new parent
  				evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
  				evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements
  				evt.clone // the clone element
  				evt.pullMode;  // when item is in another sortable: `"clone"` if cloning, `true` if moving

  				//console.log("evt.oldIndex --> " , evt.oldIndex);
  				//console.log("evt.newIndex " , evt.newIndex);

  				var id = $(evt.item).data("id");

  				var objParam = {
                    '_token' : '{{ csrf_token() }}'
                  };

  				for(var i = 0; i<$("#sortable_summary_branch tr.ui-state-default").length; i++){
  				var data = $("#sortable_summary_branch tr.ui-state-default")[i];
                  objParam["id_"+$(data).data("id")] = i;
  				}

                $.post('{{route('report.report_summons_summary.update_sorting')}}', objParam);
  			}
        });
        @endif

        $('#test_jasper').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            submitTestJasper(formData);
        });

    });
</script>
</body>
</html>


