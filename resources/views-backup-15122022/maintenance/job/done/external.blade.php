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
        .head-title {
            font-size: 22px;
        }
        @media print {
            @page {
                size: 'A4' portrait;
                /* auto is default portrait;
                */
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
                        <td class="head-title row-item " style="line-height:1.0;width:55%;background-color:white;border:1px solid grey; text-align:center; vertical-align:middle;font-family:mark-bold !important;">BORANG PEMERIKSAAN KERJA LUAR</td>
                        <td class="row-item " style="width:23%;background-color:white;border:1px solid grey">
                           <table style='width:100%;border:none; font-size:12px;padding:0px;'>
                              <tbody >
                                 <tr >
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       No. Dokumen
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       CKM.J.03
                                    </td>
                                 </tr>
                                 <tr >
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       No. Keluaran
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       01
                                    </td>
                                 </tr>
                                 <tr >
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       No. Pindaan
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       00
                                    </td>
                                 </tr>
                                 <tr >
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       Tarikh
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       11/07/2021
                                    </td>
                                 </tr>
                                 <tr >
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       Muka Surat
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       1
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               {{-- 
               <div class="small-title" style='text-decoration: underline;width:100%;text-align:center;font-size:12px !important;'>PERINCIAN KAJIAN PASARAN</div>
               --}}
               <table style='width:100%;border:none; margin-top:20px'>
                  <tbody >
                     <tr style=''>
                        <td class="row-item" style="width:28%;background-color:white">No. Kenderaan</td>
                        <td class="row-item" style="width:2%;background-color:white">:</td>
                        <td class="row-item" style="width:70%;background-color:white;border:2px solid black">{{$hasVehicle->plate_no}}</td>
                     </tr>
                     <tr style='height:10px'>
                     </tr>
                     <tr style=''>
                        <td class="row-item" style="width:28%;background-color:white">Model</td>
                        <td class="row-item" style="width:2%;background-color:white">:</td>
                        <td class="row-item" style="width:70%;background-color:white;border:2px solid black">{{$hasVehicle->hasVehicleBrand->name}}</td>
                     </tr>
                     <tr style='height:10px'>
                     </tr>
                     <tr style=''>
                        <td class="row-item" style="width:28%;background-color:white">Jabatan/Agensi</td>
                        <td class="row-item" style="width:2%;background-color:white">:</td>
                        <td class="row-item" style="width:70%;background-color:white;border:2px solid black">{{$hasMaintenanceDetail->hasAgency->desc}}</td>
                     </tr>
                     <tr style='height:10px'>
                     </tr>
                     <tr style='margin-top:20px'>
                        <td class="row-item" style="width:28%;background-color:white">Nama Woksyop</td>
                        <td class="row-item" style="width:2%;background-color:white">:</td>
                        <td class="row-item" style="width:70%;background-color:white;border:2px solid black">{{$hasMaintenanceDetail->hasWorkshop->desc}}</td>
                     </tr>
                  </tbody>
               </table>
               <table style='width:100%;border:none; margin-top:20px'>
                  <tbody >
                     <tr style=''>
                        <td class="row-item" style="text-align:center;width:2%;background-color:white;border:2px solid black">Bil.</td>
                        <td class="row-item" style="text-align:center;width:20%;background-color:white;border:2px solid black">Tarikh</td>
                        <td class="row-item" style="text-align:center;width:48%;background-color:white;border:2px solid black">Perihal Pemantauan*</td>
                        <td class="row-item" style="text-align:center;width:30%;background-color:white;border:2px solid black">Pemeriksa<br/>(JKR Woksyop)</td>
                     </tr>
                     @if($hasForm)
                     @foreach ($hasForm->hasManyMonitoringInfo as $mInfo)
                     <tr style=''>
                        <td class="row-item align-top" style="text-align:center;background-color:white;border:2px solid black">{{$loop->index+1}}.</td>
                        <td class="row-item align-top" style="text-align:center;background-color:white;border:2px solid black">{{Carbon\Carbon::parse($mInfo->monitoring_dt)->format('d F Y')}}</td>
                        <td class="row-item align-top" style="text-align:left;background-color:white;border:2px solid black">{{$mInfo->hasRefInfo->desc}}</td>
                        <td class="row-item" style="text-align:center;background-color:white;border:2px solid black">
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <div style='width:100%;border-bottom:1px dotted black'></div>
                           <div style='width:100%;'>Pembantu Kemahiran</div>
                        </td>
                     </tr>
                     @endforeach
                     @endif
                     {{-- <tr style=''>
                        <td class="row-item align-top" style="text-align:center;background-color:white;border:2px solid black">1</td>
                        <td class="row-item align-top" style="text-align:center;background-color:white;border:2px solid black">1</td>
                        <td class="row-item align-top" style="text-align:left;background-color:white;border:2px solid black">1</td>
                        <td class="row-item" style="text-align:center;background-color:white;border:2px solid black">
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <div style='width:100%;border-bottom:1px dotted black'></div>
                           <div style='width:100%;'>Pembantu Kemahiran</div>
                        </td>
                     </tr> --}}
                  </tbody>
               </table>
               <div style='margin-top:20px;font-size:12px;color:black'>
                  ..Sila tambah lampiran sekiranya ruang tidak mencukupi.
               </div>
               <div style='margin-top:20px;font-size:16px;color:black'>
                  Adalah kami dengan ini mengesahkan penyeggaraan yang dilaksanakan dan alat ganti-alat ganti yang dibekalkan menepati spesifikasi yang ditetapkan.
               </div>
               <table style='width:100%;border:none; margin-top:20px'>
                  <tbody >
                     <tr>
                        <td style='width:50%;color:black'>
                           Pembekal/Kontraktor
                           <br/>
                           <br/>
                           <br/>
                           <br/>
                           <div style='width:80%;border-bottom:1px dotted black'></div>
                           <div style='width:100%;font-size:14px;color:black;margin-top:10px'>Tandatangan & Cop Syarikat</div>
                        </td>
                        <td style='width:50%;color:black;font-size:12px;font-family:mark-bold'>
                           *Nota (Perihal Pemantauan)
                           <table style='width:100%;border:none; margin-top:5px'>
                              <tbody >
                                 <tr>
                                    <td style='width:5%;color:black;font-size:12px;vertical-align:top'>1.</td>
                                    <td style='width:95%;color:black;font-size:12px;vertical-align:top'>Proses merombak/melerai bahagian rosak pada kenderaan sedang dilaksanakan.</td>
                                 </tr>
                                 <tr>
                                    <td style='color:black;font-size:12px;vertical-align:top'>2.</td>
                                    <td style='color:black;font-size:12px;'>Alat ganti baru telah diterima dan mengikut spesifikasi.</td>
                                 </tr>
                                 <tr>
                                    <td style='color:black;font-size:12px;vertical-align:top'>3.</td>
                                    <td style='color:black;font-size:12px;'>Proses pemasangan alat ganti baharu siap dilaksanakan.</td>
                                 </tr>
                                 <tr>
                                    <td style='color:black;font-size:12px;vertical-align:top'>4.</td>
                                    <td style='color:black;font-size:12px;'>Kenderaan sedadng diuji olek pihak worksyop.</td>
                                 </tr>
                                 <tr>
                                    <td style='color:black;font-size:12px;vertical-align:top'>5.</td>
                                    <td style='color:black;font-size:12px;'>Lain-lain (nyatakan).</td>
                                 </tr>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <div style='background-color:black;height:5px;width:100%;margin-top:50px;'>
               </div>
               <table id='footer'  style='width:100%;border:none;'>
                  <tbody >
                     <tr>
                        {{-- <td style='width:70%;color:black; text-align:left; border:1px solid white;font-size:12px;font-family:mark-bold;'>
                           @ HAKCIPTA JABATAN KERJA RAYA
                        </td>
                        <td style='width:30%;color:black; text-align:center; border:4px solid red;font-size:12px;font-family:mark-bold;'>
                           DOKUMEN TERKAWAL
                        </td> --}}
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