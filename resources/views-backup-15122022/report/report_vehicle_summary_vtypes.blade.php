@php
    use App\Models\RefState;
    $status = Request('status') ? Request('status') : null;
    $ownership = Request('ownership') ?  Request('ownership') : 'jkr';
    $search = Request('search') ?  Request('search') : null;
    $fleet_view = Request('fleet_view') ?  Request('fleet_view') : 'department';
    if($fleet_view == 'department'){
        $title_span = 'Milik JKR';
    }elseif($fleet_view == 'public'){
        $title_span = 'Awam / Projek';
    }else{
        $title_span = 'Lupus';
    }
    $xmode = Request('xmode') ? Request('xmode') : 'list';
    $xid = Request('xid') ? Request('xid') : 0;
    $limit = Request('limit') ? Request('limit') : 5;
    $optdesc = 'Semua';
    if($xid == 1){
        $optdesc = 'No Pendaftaran';
    }else if($xid == 2){
        $optdesc = 'No JKR';
    }else if($xid == 3){
        $optdesc = 'Lokasi';
    }else if($xid == 4){
        $optdesc = 'Milik';
    }else if($xid == 5){
        $optdesc = 'Jenis';
    }else if($xid == 6){
        $optdesc = 'Pengeluar';
    }else if($xid == 7){
        $optdesc = 'Negeri';
    }else if($xid == 8){
        $optdesc = 'Cawangan';
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
<link href="{{ asset('my-assets/css/datareport.css') }}" rel="stylesheet" type="text/css">
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
    .shadow-top {
        box-shadow: -7px 16px 35px -7px rgba(0,0,0,0.27);
        -webkit-box-shadow: -7px 16px 35px -7px rgba(0,0,0,0.27);
        -moz-box-shadow: -7px 16px 35px -7px rgba(0,0,0,0.27);
        transition: transform 0.3s ease-out;
    }
    .content {
        padding-left:0px !important;
        padding-right:0px !important;
    }
    .main-content {
        padding-top:20px;
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
    .lcal-5 {
        width:250px;
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
    .dropdown-item a {
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
        width:auto;
        text-align: center;
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
        padding-left:10px;
        padding-right:10px;
    }
    .filter-btn span {
        font-family: helvetica;
        color:#000000;
        font-size:14px;
        line-height: 0px;
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
    #fleet_search {
        width:140px;
    }
    .form-check-label {
        line-height: 12px;
        margin-top:5px;
    }
    .pagin {
        margin-left:25px;
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
            padding-left:0px;
            padding-right:20px;
        }
        .box-right {
            width:65%;
        }
        .sect-top {
            height:180px;
            padding-left:23px;
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

        .sect-top-dummy {
            height:160px;
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
    @media print {
        nav * {
            display: none !important;
        }
        .sect-top {
            display: none !important;
        }
        .sect-top-dummy {
            display: none !important;
        }
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>
<script type="text/javascript">
    // var hideableCol = 25;
    // function putUpColumnName() {
    //     var myColSet = readCookie('cMyColSet');
    //     if(myColSet == null){
    //         myColSet = "111111111000000000000000";
    //         setCookie('cMyColSet', myColSet);
    //     }

    //     //23 is total column that can be hide/show
    //     for (let i = 0; i < hideableCol; i++) {
    //         var colName = $('#head' + i).text();
    //         $('#labelName' + i).text(colName);
    //         if(myColSet.charAt(i) == '1'){
    //             $('.col' + i).show();
    //             $('#checkFor' + i).prop( "checked", true);
    //         }else{
    //             $('.col' + i).hide();
    //             $('#checkFor' + i).prop( "checked", false);
    //         }
    //     }
    // }
    // function readCookie(name) {
    //     var nameEQ = name + "=";
    //     var ca = document.cookie.split(';');
    //     for(var i=0;i < ca.length;i++) {
    //         var c = ca[i];
    //         while (c.charAt(0)==' ') c = c.substring(1,c.length);
    //         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    //     }
    //     return null;
    // }
    // function setCookie(variable, value, expires_seconds) {
    //     var d = new Date();
    //     d = new Date(d.getTime() + 1000 * expires_seconds);
    //     document.cookie = variable + '=' + value + '; expires=' + d.toGMTString() + ';';
    // }
    // function updateColumnSettings() {
    //     var newStatement = "";
    //     for (let i = 0; i < hideableCol; i++) {
    //         if($('#checkFor' + i).is(":checked")){
    //             newStatement = newStatement + "1";
    //         }else{
    //             newStatement = newStatement + "0";
    //         }
    //     }
    //     setCookie('cMyColSet', newStatement);
    // }
    // function setSchFilter(obj) {
    //     var objid = $(obj).attr('id');
    //     if(objid == 'flt-all') {
    //         $('#sch-opt').text('Bebas');
    //     }else if(objid == 'flt-noplate') {
    //         $('#sch-opt').text('No Pendaftaran');
    //     }else if(objid == 'flt-nojkr') {
    //         $('#sch-opt').text('No JKR');
    //     }else if(objid == 'flt-lokasi') {
    //         $('#sch-opt').text('Lokasi');
    //     }else if(objid == 'flt-milik') {
    //         $('#sch-opt').text('Milik');
    //     }else if(objid == 'flt-jenis') {
    //         $('#sch-opt').text('Jenis');
    //     }else if(objid == 'flt-pengeluar') {
    //         $('#sch-opt').text('Pengeluar');
    //     }else if(objid == 'flt-negeri') {
    //         $('#sch-opt').text('Negeri');
    //     }else if(objid == 'flt-cawangan') {
    //         $('#sch-opt').text('Cawangan');
    //     }

    //     $('.search-filter').removeClass('active');
    //     $('#' + objid).addClass('active');

    //     $('#filter-opt').val(objid);
    //     var xid = $(obj).attr('xid');
    //     $('#schFilterValue').val(xid);
    //     $('#fleet_search').attr('placeholder', $(obj).html());
    // }
</script>
</head>
<body class="content">
    <div class="sect-top no-printme">
        <div class="mytitle">Laporan Siap Siaga Bencana</div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a onclick="openPgInFrame('{{route('logistic.report')}}')">Laporan & Analisis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kenderaan Dan Jentera Siap Siaga Didaftarkan oleh setiap JKR Negeri</li>
            </ol>
        </nav>
        <div class="dropdown btn-group inline float-end no-printme">
            <span class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
            <a class="btn cux-btn bigger" href="{{route('report.report.disaster_ready.export.excel', ['view' => 'report_vehicle_summary_vtypes'])}}"> <i class="fa fa-file-export"></i> Excel</a>
        </div>
    </div>
<div class="sect-top-dummy"></div>
<div class="title-report">Laporan Senaraian Kenderaan <span>Milik JKR</span></div>
    <div class="main-content" style="padding:0px;">
        <div class="table-responsive" style="width:100%;padding-left:25px;padding-right:25px;margin-top:10px;padding-bottom:5px">
            @php
                $totalKeseluruhan = 0;
            @endphp
            <table class="table-report stripe" style="width:auto">
                <thead>
                    <tr>
                        <th class="lcal-2" class="col-del" style="background-color: #BDD7EE;">Bil.</th>
                        <th class="lcal-5" style="background-color: #BDD7EE">Jenis / JKR Woksyop</th>
                        @foreach ($state_list as $state)
                            <th class="lcal-4" style="background-color: #BDD7EE">{{$state->desc}}</th>
                        @endforeach
                        <th style="background-color: #BDD7EE">JUMLAH KESELURUHAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td colspan="{{$total_state+3}}" style="background-color: #5B9BD5; font-weight: bolder; padding: 10px; text-align: left !important;">{{$category['cat_name']}}</td>
                        </tr>
                        @foreach ($category['has_many_type'] as $type)
                            <tr>
                                <td>{{$loop->index +1}}</td>
                                <td>{{$type['name']}}</td>
                                {{-- @foreach ($type['has_many_state'] as $state) --}}
                                @foreach ($state_list as $ref_state_list)
                                    @php
                                        $total = 0;
                                    @endphp
                                    <td style="align-self: right">
                                        @foreach ($type['has_many_state'] as $state)
                                            @php
                                                if ($state->state_id == $ref_state_list->id){
                                                    $total += $state->total;
                                                }
                                            @endphp
                                        @endforeach
                                        {{$total}}
                                    </td>
                                @endforeach
                                <td>{{$type['total']}}</td>
                                @php
                                    $totalKeseluruhan += $type['total'];
                                @endphp
                            </tr>
                        @endforeach
                    @endforeach
                        <tr>
                            <td colspan="2" style="background-color: #FCDF5E; font-weight: bold">JUMLAH</td>
                            @foreach ($listByState as $totalState)
                                <td style="background-color: #FCDF5E;">{{$totalState['total']}}</td>
                            @endforeach
                            <td style="background-color: #FCDF5E; font-weight: bold">{{$totalKeseluruhan}}</td>
                        </tr>
                </tbody>
            </table>
        </div>
                <br/>
                <p>&nbsp;</p>
    </div>

{{--<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>--}}

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
{{--<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>--}}

</body>
</html>
