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
            min-width: 310px;
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
            margin: 10px auto;
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
            /* max-width: 1030px;
            */
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
            min-width:40px;
            color:#2c2c2c;
            padding-top:5px;
            padding-left:5px;
            padding-bottom:5px;
            background-color:#eeeded;
        }
        .end {
            width:15px;
        }
        .col-tren {
            padding-right:10px;
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
            padding-top:10px;
            padding-bottom:10px;
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
            width:10%;
            text-align:left;
            background-color:white;
            border:1px solid grey;
        }
        .table-1-value{
            width:40%;
            text-transform:uppercase;
            text-align:center;
            background-color:white;
            border:1px solid grey 
        }

        .label-title {
            color: black;
            font-size: 12px;
            font-weight: 600;
         }
         .label-sub-title {
            color: black;
            font-size: 12px;
            font-weight: 600;
         }
        .head-title {
            font-size: 22px;
        }
        @media print {
            @page {
                size: 'A4' portrait;
                /* auto is default portrait;
                */
                margin-top: 0px;
            }
            .col-md-6 {
                width: 50%;
            }
            .head-title {
                font-size: 15px;
            }
            .no-printme {
                display: none;
            }
            .printme {
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
                -webkit-print-color-adjust: exact !important;
                /* Chrome, Safari, Edge */
                color-adjust: exact !important;
                /*Firefox*/
            }
        }

      </style>
      <script type="text/javascript"></script>
   </head>
   <body class="content">
      <span class="btn cux-btn no-printme" onclick="window.print()">Cetak</span>
      <br/>
      <div class="main-content">
         {{-- 
         <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
               <ul id="tabActive">
                  <li class="cub-tab" onClick="goTab(this, 'perincian');" id="tab1">Perincian Jadual</li>
               </ul>
               <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
         </div>
         --}}
         <section id="perincian" class="tab-content">
            <div class="detailing">
               <table style='width:100%;border:none; margin-top:20px'>
                  <tbody >
                     <tr >
                        <td class="row-item" style="width:12%;text-align:center;background-color:white;border:1px solid grey;font-family:mark-bold !important;"><img style='width:100%;padding:10%' src='{{ asset('my-assets/img/logo-jkr.png') }}'/>JKR MALAYSIA</td>
                        <td class="head-title row-item " style="line-height:1.0;width:55%;background-color:white;border:1px solid grey; text-align:center; vertical-align:middle;font-family:mark-bold !important;">MAKLUMAT SEBUT HARGA KENDERAAN / JENTERA</td>
                     </tr>
                  </tbody>
               </table>

               <h5 class="pt-2 pb-1 text-center text-uppercase text-decoration-underline">DATA KENDERAAN / JENTERA</h5>

               @if($detail)
                <table class="table table-bordered w-100">
                    <tr>
                    <td class="w-25 label-title">Model</td>
                    <td>{{$detail->model_name ? $detail->model_name : '-'}}</td>
                    <td class="w-25 label-title">No Rujukan Sistem</td>
                    <td>{{$detail->hasMaintenanceDetail->ref_number}}</td>
                    </tr>
                    <tr>
                    <td class="w-25 label-title">Jenis</td>
                    <td>{{$detail->hasSubCategoryType ? $detail->hasSubCategoryType->name : ''}}</td>
                    <td class="w-25 label-title">No Pendaftaran</td>
                    <td>{{$detail->plate_no}}</td>
                    </tr>
                    <tr>
                    <td class="w-25 label-title">Enjin</td>
                    <td>{{$detail->engine_no}}</td>
                    <td class="w-25 label-title">Waran</td>
                    <td>{{$detail->hasExamform->hasOsolType ? $detail->hasExamform->hasOsolType->desc : '-'}}</td>
                    </tr>
                    <tr>
                    <td class="w-25 label-title">Jabatan</td>
                    <td>{{$jobDetail->department_name}}</td>
                    <td class="w-25 label-title">&nbsp;</td>
                    <td>&nbsp;</td>
                    </tr>
                </table>

                <h5 class="pt-1 pb-1 text-center text-uppercase text-decoration-underline">DATA SEBUT HARGA</h5>

                <table class="table table-bordered w-100">
                    @if ($formRepair && $formRepair->hasRepairMethod->code == '01')
                        @if($detail->hasExamform->hasQuotationInternal->first())
                            <tr>
                                <td class="w-25 label-title">NO SEBUTHARGA</td>
                                <td>{{$detail->hasExamform->hasQuotationInternal->first()->quotation_no ? $detail->hasExamform->hasQuotationInternal->first()->quotation_no:''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">NAMA SYARIKAT PEMBEKAL</td>
                                <td>{{$detail->hasExamform->hasQuotationInternal->first()->company_name ? $detail->hasExamform->hasQuotationInternal->first()->company_name:''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">TARIKH SEBUTHARGA</td>
                                <td>{{$detail->hasExamform->hasQuotationInternal->first()->quotation_dt ? Carbon\Carbon::parse($detail->hasExamform->hasQuotationInternal->first()->quotation_dt)->format('d F Y'):''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">TARIKH SST</td>
                                <td>{{$detail->hasExamform->hasQuotationInternal->first()->sst_dt ? Carbon\Carbon::parse($detail->hasExamform->hasQuotationInternal->first()->sst_dt)->format('d F Y'):''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">JUMLAH HARGA (RM)</td>
                                <td>{{$detail->hasExamform->hasQuotationInternal->first()->total_price ? number_format($detail->hasExamform->hasQuotationInternal->first()->total_price, 2):''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">TARIKH SIAP</td>
                                <td>{{$detail->hasExamform->hasQuotationInternal->first()->end_dt ? Carbon\Carbon::parse($detail->hasExamform->hasQuotationInternal->first()->end_dt)->format('d F Y'):''}}</td>
                            </tr>
                            @else
                            <tr>
                                <td rowspan="2">Tiada Rekod</td>
                            </tr>
                        @endif

                    @elseif($formRepair && $formRepair->hasRepairMethod->code == '02')
                        @if($detail->hasExamform->hasQuotationExternal->first())
                            <tr>
                                <td class="w-25 label-title">NO SEBUTHARGA</td>
                                <td>{{$detail->hasExamform->hasQuotationExternal->first()->quotation_no ? $detail->hasExamform->hasQuotationExternal->first()->quotation_no : ''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">NAMA SYARIKAT PEMBEKAL</td>
                                <td>{{$detail->hasExamform->hasQuotationExternal->first()->company_name ? $detail->hasExamform->hasQuotationExternal->first()->company_name : ''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">TARIKH SEBUTHARGA</td>
                                <td>{{$detail->hasExamform->hasQuotationExternal->first()->quotation_dt ? Carbon\Carbon::parse($detail->hasExamform->hasQuotationExternal->first()->quotation_dt)->format('d F Y') : ''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">TARIKH SST</td>
                                <td>{{$detail->hasExamform->hasQuotationExternal->first()->sst_dt ? Carbon\Carbon::parse($detail->hasExamform->hasQuotationExternal->first()->sst_dt)->format('d F Y') : ''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">JUMLAH HARGA (RM)</td>
                                <td>{{$detail->hasExamform->hasQuotationExternal->first()->total_price ? number_format($detail->hasExamform->hasQuotationExternal->first()->total_price, 2): ''}}</td>
                            </tr>
                            <tr>
                                <td class="w-25 label-title">TARIKH SIAP</td>
                                <td>{{$detail->hasExamform->hasQuotationExternal->first()->end_dt ? Carbon\Carbon::parse($detail->hasExamform->hasQuotationExternal->first()->end_dt)->format('d F Y'): ''}}</td>
                            </tr>
                            @else
                            <tr>
                                <td rowspan="2">Tiada Rekod</td>
                            </tr>
                        @endif
                    @endif
                </table>
               @endif
               
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
