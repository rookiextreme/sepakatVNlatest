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

    .content {
        background-color: transparent;
    }
    .highcharts-figure, .highcharts-data-table table {
        min-width: 312px;
        max-width: 800px;
        margin: 1em auto;
        margin-left:0px;
    }
    #container {
        height: 400px;
    }
    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 12px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    .detailing {
        background-color:#ffffff;
        padding:20px;
        width:100%;
        /* max-width: 1030px; */
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
    }
    thead td {
        border-bottom-color:#999999;
        border-bottom-width:1px;
        border-bottom-style: solid;
        height:40px;
    }
    tbody td {
        vertical-align: top;
    }
    thead td.col-mth {
        font-family: mark-bold;
        color:#1b1b1b;
        font-size:14px;
        border-bottom-width:3px;
        vertical-align: bottom;
    }
    .col-focus {
        min-width: 70px;
        vertical-align: text-top;
        text-align: right;
        padding-right:5px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
    }
    .col-focus.link {
        font-family: mark-bold;
        font-size:16px;
        text-decoration: none;
        color:#454545;
        cursor:pointer;
        line-height:16px;
        transition: all 0.2s ease-in;
    }
    .col-focus.link:hover {
        font-size:20px;
        background-color:orange;
        line-height:16px;
        color:#ffffff;
    }
    .col-info {
        font-family: mark;
        font-size:14px;
        color:#454545;
        line-height:16px;
        text-align: right;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
        padding-right:5px;
    }
    .row-item {
        font-family: mark;
        font-size:14px;
        line-height: 14px;
        min-width:130px;
        color:#2c2c2c;
        padding-top:5px;
        padding-left:7px;
        padding-bottom:5px;
        background-color:#eeeded;
    }
    .end {
        width:15px;
    }
    .col-tren {
        padding-right:12px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
        text-align: right;
    }
    .shape-decline {
        float: right;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 15px solid red;
        border-right: 40px solid transparent;
    }
    .shape-incline {
        float: right;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 15px solid green;
        border-left: 40px solid transparent;
    }
    .shape-constant {
        float: right;
        bottom:0px;
        width: 40px;
        height: 15px;
        background-color: #40b293;
    }

    .col-mth.header-depreciation{
        background-color: lightgoldenrodyellow;
        border-right: 1px solid lightgrey;
        text-align: right;
        padding-right: 8px;

    }

    .header-depreciation.left{

        text-align: left;
        padding-left: 8px;
        font-size: 14px;

    }

    #perihal_kerja td,#senarai_pembekal td, #disediakan_oleh td{
        padding:5px;
        padding-top:12px;
        padding-bottom:12px;
    }

    .percentage-value{

        text-align: right !important;
    }

    .form-select.smaller{


        font-size: 12px !important;
        padding: 2px !important;
        padding-left: 6px !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

    .table-1-title{

        font-family: mark-bold;
        width:10%;text-align:left;background-color:white;border:1px solid grey;
    }

    .table-1-value{
        width:40%;text-transform:uppercase;text-align:center;background-color:white;border:1px solid grey
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

        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
        }
    }

</style>
<script type="text/javascript">

</script>
</head>



<body class="content">
    <span class="btn cux-btn no-printme" onclick="window.print()">Cetak</span>
<br/>
<div class="main-content">
    {{-- <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">

                <li class="cub-tab" onClick="goTab(this, 'perincian');" id="tab1">Perincian Jadual</li>

            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div> --}}


    <section id="perincian" class="tab-content">
        <div class="detailing">

            <table style='width:100%;border:none; margin-top:20px'>

                <tbody >


                    <tr >
                        <td class="row-item" style="width:12%;text-align:center;background-color:white;border:1px solid black;font-family:mark-bold !important;"><img style='width:100%;padding:10%' src='{{ asset('my-assets/img/logo-jkr.png') }}'/>JKR MALAYSIA</td>
                        <td class="row-item " style="width:49%;background-color:white;border:1px solid black; text-align:center; vertical-align:middle;font-family:mark-bold !important; font-size:14px;">REKOD PENYENGGARAAN KENDERAAN / JENTERA</td>
                    </tr>


                </tbody>
            </table>
            <div class="small-title" style='text-decoration: underline;width:100%;text-align:center;font-size:14spx !important;'>MAKLUMAT REKOD PENYENGGARAAN</div>
            <table style='width:100%;border:none; margin-top:20px'>
                {{-- <thead>
                    <td class="end"></td> --}}
                    {{-- <td class="col-mth header-depreciation left">KELAS \ USIA</td>
                    @foreach ($listArrayKelas[0] as $listData)
                        <td class="col-mth header-depreciation">{{$listData->age}}</td>
                    @endforeach --}}


                    {{-- <td class="end"></td> --}}
                {{-- </thead> --}}
                <tbody >
                    <table style="width:100%">
                        <tr>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">NO. KENDERAAN</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasVehicle->plate_no}}</td>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">NAMA JABATAN YANG MENYENGGARA</td>
                            {{-- <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasVehicle->hasMaintenanceDetail->department_name}}</td> --}}
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasVehicle->hasMaintenanceDetail->hasWorkShop->desc}}</td>

                        </tr>
                        <tr>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">KATEGORI</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasVehicle->hasCategory ? $hasVehicle->hasCategory->name : '-'}}</td>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">TARIKH</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{Carbon\Carbon::parse($hasVehicle->hasMaintenanceDetail->created_at)->format('d F Y')}}</td>
                        </tr>
                        <tr>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">MODEL</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasVehicle->model_name ? $hasVehicle->model_name : '-'}}</td>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">NO. BAUCER </td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasForm->lo_no}}</td>
                        </tr>
                        <tr>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">JENIS</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasVehicle->hasSubCategoryType ? $hasVehicle->hasSubCategoryType->name : '-'}}</td>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">TARIKH BAYARAN</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasForm->completed_dt ? Carbon\Carbon::parse($hasForm->completed_dt)->format('d F Y') : ''}}</td>
                        </tr>

                        @if ($hasForm->repair_method_id == 1);
                        <tr>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">TARIKH SERVIS SETERUSNYA</td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasForm->next_service_dt ? Carbon\Carbon::parse($hasForm->next_service_dt)->format('d F Y') : '-'}}</td>
                            <td style="width:15%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">ODOMETER SETERUSNYA </td>
                            <td style="width:35%;text-align:left;background-color:white;border:1px solid black;font-family:mark-bold;font-size:10px; color:black ">{{$hasForm->next_service_odometer ? $hasForm->next_service_odometer : '-'}}</td>
                        </tr>
                        @endif
                    </table>
                </tbody>
            </table>
            <div class="small-title" style='text-decoration: underline;width:100%;text-align:center;font-size:14px !important;'>PERIHAL KERJA</div>

            <table id='perihal_kerja'  style='width:100%;border:none; margin-top:20px'>
                <thead>
                    <tr>
                        <td class="" style='width:50%;background-color:yellow; color:black; text-align:center; font-family:mark-bold;border:1px solid black;font-size:12px;'>Perihal kerja</td>
                        <td class="" style='width:10%;background-color:yellow; color:black; text-align:center; font-family:mark-bold;border:1px solid black;font-size:12px;'>Kuantiti <br> LOT/PC</td>
                        <td class="" style='width:20%;background-color:yellow; color:black; text-align:center; font-family:mark-bold;border:1px solid black;font-size:12px;'>Harga <br> Seunit/Set</td>
                        <td class="" style='width:20%;background-color:yellow; color:black; text-align:center; font-family:mark-bold;border:1px solid black;font-size:12px;'>Jumlah Harga </td>
                    </tr>
                </thead>
                <tbody>
                    @if($hasForm)
                     @foreach ($hasForm->hasProcurementSelectedSupplierList as $component)
                            <tr>
                                <td style='color:black; border:1px solid black;font-size:12px;'>
                                    {{-- KERJA-KERJA MEMBUKA, MEROMBAK RAWAT,
                                    MENGENALPASTI DAN MEMASANG ALAT GANTI BARU BAGI
                                    {{$component->hasRefComponentLvl1?$component->hasRefComponentLvl1->component:''}}
                                    SEHINGGA SEMPURNA --}}
                                    {!! nl2br($component->hasFormComponent->detail) !!}
                                    @if($component->hasFormComponent->hasManyResearchMarketComponent->count()>0)
                                    <ul class="sub-component mt-2" style="list-style-type: upper-roman;">
                                       @foreach ($component->hasFormComponent->hasManyResearchMarketComponent as $componentSub)
                                       <li class="mb-1">
                                          <label for="" class="form-label d-inline" style="line-height: 20px">
                                          @switch($componentSub->lvl)
                                          @case(2)
                                          {{$componentSub->hasCompLvl2->component}}
                                          @break
                                          @case(3)
                                          {{$componentSub->hasCompLvl3->component}}
                                          @break
                                          @default
                                          @endswitch
                                          </label>
                                       </li>
                                       @endforeach
                                    </ul>
                                    @endif
                                 </td>
                                <td style="color: black; border:1px solid black;text-align:center;">{{$component->hasFormComponent->quantity}}</td>
                                <td style='color:black; text-align:center; border:1px solid black;font-size:12px;'>
                                    {{number_format($component->price, 2)}}
                                 </td>
                                 <td style='color:black; text-align:center; border:1px solid black;font-size:12px;'>
                                    {{number_format($component->hasFormComponent->quantity * $component->price, 2)}}
                                 </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="color: black; border:1px solid black; text-align:center;font-family:mark-bold;">JUMLAH HARGA (RM)</td>
                        <td style="color: black; border:1px solid black; text-align:center;font-family:mark-bold;"> {{number_format($hasForm->pro_budget_price, 2)}}</td>
                    </tr>
                </tfoot>
            </table>



            <div style='background-color:black;height:5px;width:100%;margin-top:50px;'>
            </div>
            <table id='footer'  style='width:100%;border:none;'>

                <tbody >



                    <tr>
                        <td style='width:70%;color:black; text-align:left; border:1px solid white;font-size:12px;font-family:mark-bold;'>
                            @ HAKCIPTA JABATAN KERJA RAYA
                        </td>
                        <td style='width:30%;color:black; text-align:center; border:4px solid red;font-size:12px;font-family:mark-bold;'>
                            DOKUMEN TERKAWAL
                        </td>

                    </tr>





                </tbody>
            </table>

        </div>


    </section>



</div>





<script type="text/javascript">
    $(document).ready(function() {

        //$('#latest_class').select2();
        initTab();




    });






</script>

</body>
