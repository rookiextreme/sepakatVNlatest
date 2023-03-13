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
         tbody tr:hover {
         background-color: unset;
         }
         .highcharts-figure,
         .highcharts-data-table table {
         min-width: 312px;
         max-width: 800px;
         margin: 1em auto;
         margin-left: 0px;
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
         .highcharts-data-table td,
         .highcharts-data-table th,
         .highcharts-data-table caption {
         padding: 0.5em;
         }
         .highcharts-data-table thead tr,
         .highcharts-data-table tr:nth-child(even) {
         background: #f8f8f8;
         }
         .highcharts-data-table tr:hover {
         background: #f1f7ff;
         }
         .detailing {
         background-color: #ffffff;
         padding: 20px;
         width: 100%;
         /* max-width: 1030px; */
         -webkit-border-radius: 8px;
         -moz-border-radius: 8px;
         border-radius: 8px;
         }
         thead td {
         border-bottom-color: #999999;
         border-bottom-width: 1px;
         border-bottom-style: solid;
         height: 40px;
         }
         tbody td {
         vertical-align: top;
         }
         thead td.col-mth {
         font-family: mark-bold;
         color: #1b1b1b;
         font-size: 14px;
         border-bottom-width: 3px;
         vertical-align: bottom;
         }
         .col-focus {
         min-width: 70px;
         vertical-align: text-top;
         text-align: right;
         padding-right: 5px;
         border-right-color: #cdcdcd;
         border-right-width: 1px;
         border-right-style: solid;
         }
         .col-focus.link {
         font-family: mark-bold;
         font-size: 16px;
         text-decoration: none;
         color: #454545;
         cursor: pointer;
         line-height: 16px;
         transition: all 0.2s ease-in;
         }
         .col-focus.link:hover {
         font-size: 20px;
         background-color: orange;
         line-height: 16px;
         color: #ffffff;
         }
         .col-info {
         font-family: mark;
         font-size: 14px;
         color: #454545;
         line-height: 16px;
         text-align: right;
         border-right-color: #cdcdcd;
         border-right-width: 1px;
         border-right-style: solid;
         padding-right: 5px;
         }
         .row-item {
         font-family: mark;
         font-size: 14px;
         line-height: 14px;
         min-width: 130px;
         color: #2c2c2c;
         padding-top: 5px;
         padding-left: 7px;
         padding-bottom: 5px;
         background-color: #eeeded;
         }
         .end {
         width: 15px;
         }
         .col-tren {
         padding-right: 12px;
         border-right-color: #cdcdcd;
         border-right-width: 1px;
         border-right-style: solid;
         text-align: right;
         }
         .shape-decline {
         float: right;
         bottom: 0px;
         width: 0;
         height: 0;
         border-bottom: 15px solid red;
         border-right: 40px solid transparent;
         }
         .shape-incline {
         float: right;
         bottom: 0px;
         width: 0;
         height: 0;
         border-bottom: 15px solid green;
         border-left: 40px solid transparent;
         }
         .shape-constant {
         float: right;
         bottom: 0px;
         width: 40px;
         height: 15px;
         background-color: #40b293;
         }
         .col-mth.header-depreciation {
         background-color: lightgoldenrodyellow;
         border-right: 1px solid lightgrey;
         text-align: right;
         padding-right: 8px;
         }
         .header-depreciation.left {
         text-align: left;
         padding-left: 8px;
         font-size: 14px;
         }
         #perihal_kerja td,
         #senarai_pembekal td,
         #disediakan_oleh td {}
         .percentage-value {
         text-align: right !important;
         }
         .form-select.smaller {
         font-size: 12px !important;
         padding: 2px !important;
         padding-left: 6px !important;
         padding-top: 6px !important;
         padding-bottom: 6px !important;
         }
         .table-1-title ps-1 {
         font-family: mark-bold;
         width: 10%;
         text-align: left;
         background-color: white;
         border: 1px solid grey;
         }
         .table-1-value {
         width: 40%;
         text-transform: uppercase;
         text-align: center;
         background-color: white;
         border: 1px solid grey
         }
         @media print {
         @page {
         size: portrait;
         /* auto is default portrait; */
         margin: 5%;
         }
         .col-md-6 {
         width: 50%;
         }
         .no-printme {
         display: none;
         }
         .printme {
         display: block;
         }
         .printme th,
         .printme td {
         padding-left: 10px;
         }
         .body,
         .content {
         background: transparent;
         }
         .box-info {
         border: none;
         height: 30px;
         }
         .rlabel,
         .mytext {
         line-height: unset;
         }
         * {
         -webkit-print-color-adjust: exact !important;
         /* Chrome, Safari, Edge */
         color-adjust: exact !important;
         /*Firefox*/
         }
         #page:after {
         counter-increment: page;
         content: counter(page);
         }
         }
         ul.marking {
         list-style: none;
         }
         ul li.marked:before {
         content: '[/]';
         }
         ul li.unmarked:before {
         content: '[x]';
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
         .checkbox-custom {
         width: 40px;
         height: 25px;
         border: 1px solid black;
         margin: 5px
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

         .cellpadding-1 tr td, .cellpadding-1 th{
            padding: 1px;
         }
         .cellpadding-2 tr td, .cellpadding-1 th{
            padding: 2px;
         }
         .cellpadding-3 tr td, .cellpadding-1 th {
            padding: 3px;
         }
      </style>
      <script type="text/javascript"></script>
   </head>
   <body class="content">
      <span class="btn cux-btn no-printme" onclick="window.print()">Cetak</span>
      <div class="main-content">
         <section id="perincian" class="tab-content">
            <div class="detailing">
               <table class="table table-borderless w-100 mb-0 cellpadding-3">
                  <tbody>
                     <tr>
                        <td class="row-item"
                           style="width:12%;text-align:center;background-color:white;border:1px solid black;font-family:mark-bold !important;">
                           <img style='width:100%;padding:10%'
                           src='{{ asset('my-assets/img/logo-jkr.png') }}' />JKR MALAYSIA
                        </td>
                        <td class="row-item "
                           style="width:49%;background-color:white;border:1px solid black; text-align:center; vertical-align:middle;font-family:mark-bold !important; font-size:14px;">
                           BORANG JUSTIFIKASI PELAKSANAAN DAN PENGUJIAN
                        </td>
                        <td class="row-item " style="width:29%;background-color:white;border:1px solid black">
                           <table class="table table-borderless w-100 mb-0">
                              <tbody>
                                 <tr>
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       No. Dokumen
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       CKM.J.02
                                    </td>
                                 </tr>
                                 <tr>
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
                                 <tr>
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
                                 <tr>
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       Tarikh
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       {{Carbon\Carbon::now()->format('d/m/Y')}}
                                    </td>
                                 </tr>
                                 <tr>
                                    <td style='width:48%;font-size:12px;color:black;border:none'>
                                       Muka Surat
                                    </td>
                                    <td style='width:2%;font-size:12px;color:black'>
                                       :
                                    </td>
                                    <td style='width:50%;font-size:12px;color:black'>
                                       <div id="page"></div>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <table class="table table-borderless w-100 mb-0 cellpadding-3" style="border-left: 1px solid black; border-right: 1px solid black;">
                  <tr>
                     <td class="label-title ps-1"> No. Kenderaan</td>
                     <td class="label-sub-title ps-1"> : {{$hasVehicle->plate_no ? $hasVehicle->plate_no : ''}}</td>
                     <td class="label-title ps-1">Pemilik</td>
                     <td class="label-sub-title ps-1"> :
                        {{$hasMaintenanceDetail->department_name ? $hasMaintenanceDetail->department_name : ''}}
                     </td>
                  </tr>
                  <tr>
                     <td class="label-title ps-1">Model</td>
                     <td class="label-sub-title ps-1"> :
                        {{$hasVehicle->model_name ? $hasVehicle->model_name : ''}}
                     </td>
                     <td class="label-title ps-1">Tarikh Keluar</td>
                     <td class="label-sub-title ps-1"> :
                        {{$hasForm->tested_done_dt ? Carbon\Carbon::parse($hasForm->tested_done_dt)->format('d F Y') : ''}}
                     </td>
                  </tr>
                  <tr>
                     <td class="label-title ps-1">Tarikh Masuk</td>
                     <td class="label-sub-title ps-1"> :
                        {{$hasMaintenanceDetail->appointment_dt ? Carbon\Carbon::parse($hasMaintenanceDetail->appointment_dt)->format('d F Y'): ''}}
                     </td>
                     <td class="label-title ps-1">Tarikh Servis Seterusnya</td>
                     <td class="label-sub-title ps-1"> :
                        {{$hasForm->next_service_dt ? Carbon\Carbon::parse($hasForm->next_service_dt)->format('d F Y') : ''}}
                     </td>
                  </tr>
               </table>
               <table class="table table-bordered w-100 mb-0 border-bottom-0 cellpadding-3" style="border: 1px solid black;">
                   <tr style="background-color: yellow;">
                       <td colspan="2" class="text-center label-title">PENGUJIAN SELEPAS PEMBAIKAN</td>
                   </tr>
               </table>
               @if ($hasForm && $hasForm->is_research_market == 1 || ($hasForm->repair_method_id == 1 && $hasForm->is_research_market == 0))
                  <table class="table table-bordered w-100 mb-0 border-top-0 cellpadding-2" style="border: 1px solid black;">
                  <tr style="background-color: yellow;">
                     <td class="text-center label-title text-uppercase">Butiran Pengujian</td>
                  </tr>
                  </table>
                  <table class="table table-bordered w-100 mb-0" style="border-left: 0px solid black;border-right: 0px solid black;border-bottom: 0px solid black;">
                     <tr style="background-color: gray;">
                        <td class="text-center label-title w-50 p-1 m-1">PEMBAIKAN / SERVIS</td>
                        <td class="text-center label-title w-50 p-1 m-1">BUTIRAN PEMBAIKAN</td>
                     </tr>
                     @if ($hasForm && $hasForm->is_research_market == 1)
                        @foreach ($hasForm->hasProcurementSelectedSupplier as $component)
                           <tr>
                              <td class="label-title w-50 text-uppercase p-1 m-1" style="border-left: 1px solid black;border-top: 1px solid black;">
                                 <label for="" class="label-sub-title ">{{$loop->index+1}}. {{$component->hasFormComponent->detail}}</label>
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
                              <td class="label-title w-50 text-uppercase p-1 m-1" style="border-right: 1px solid black;border-top: 1px solid black;">
                                 <label for="" class="label-sub-title">{{$component->hasFormComponent->note}}</label>
                              </td>
                           </tr>
                        @endforeach                     
                     @elseif ($hasForm && $hasForm->is_research_market == 0)
                        @foreach ($hasForm->hasManyMVFormCheckList->where('is_pass', 1) as $component)
                        <tr>
                           <td class="label-title text-uppercase p-1 m-1" style="border-left: 1px solid black;border-top: 1px solid black;">
                              <label for="" class="label-sub-title ">{{$loop->index+1}}. {{$component->detail}}</label>
                              @if ($component->lvl == 1)
                                 {{$component->hasCompLvl1->component}}
                              @elseif($component->lvl == 2)
                                 {{$component->hasCompLvl2->component}}
                              @elseif($component->lvl == 3)
                                 {{$component->hasCompLvl3->component}}
                              @endif
                           </td>
                           <td class="label-title text-uppercase p-1 m-1" style="border-right: 1px solid black;border-top: 1px solid black;">
                              <label for="" class="label-sub-title">{{$component->noted}}</label>
                           </td>
                        </tr>
                        @endforeach
                     @endif
                  </table>
               @endif
            <table class="table table-bordered w-100 mb-0 cellpadding-3" style="border: 1px solid black;border-top: 0px;">
                <tr style="background-color: yellow;">
                   
                    @if (($hasForm->repair_method_id == 2 && $hasForm->is_research_market == 0) || ($hasForm->repair_method_id == 2 && $hasForm->is_research_market == 1))
                        <td colspan="2" class="text-center label-title text-uppercase">Lain-lain kerosakan</td>
                     @elseif (($hasForm->repair_method_id == 1 && $hasForm->is_research_market == 2)||($hasForm->repair_method_id == 2 && $hasForm->is_research_market == 2))
                        <td colspan="2" class="text-center label-title text-uppercase">Butiran Pemeriksaan</td>
                     @else
                        <td colspan="2" class="text-center label-title text-uppercase">Catatan Pemeriksa</td>
                     @endif
                </tr>
                <tr>
                    <td colspan="2" class="label-title text-uppercase">
                     @if (($hasForm->repair_method_id == 2 && $hasForm->is_research_market == 1) || ($hasForm->repair_method_id == 2 && $hasForm->is_research_market == 0))
                        {{$hasForm->other_damages ? $hasForm->other_damages : ''}} 
                        @elseif (($hasForm->repair_method_id == 1 && $hasForm->is_research_market == 2)||($hasForm->repair_method_id == 2 && $hasForm->is_research_market == 2))
                        {{$hasForm->testing_info ? $hasForm->testing_info : ''}} 
                     @else
                        {{$hasForm->tester_note ? $hasForm->tester_note : ''}}
                     @endif
                     </td>
                </tr>
               <tr style="background-color: yellow;">
                  <td class="text-center label-title text-uppercase">Pemeriksa</td>
                  <td class="text-center label-title text-uppercase">Penyemak</td>
              </tr>
              <tr>
                  <td class="label-title text-uppercase">Nama : {{$hasForm->InspectedBy ? $hasForm->InspectedBy->name : ''}}</td>
                  @if ($hasJVEForm)
                     <td class="label-title text-uppercase">Nama : {{$hasJVEForm->InspectedDoneBy ? $hasJVEForm->InspectedDoneBy->name : ''}}</td>
                  @else
                     <td class="label-title text-uppercase">Nama : {{$hasForm->InspectedDoneBy ? $hasForm->InspectedDoneBy->name : ''}}</td>
                  @endif
              </tr>

              <tr>
                  <td class="label-title w-50 text-uppercase">Jawatan : {{$hasForm->InspectedBy ? $hasForm->InspectedBy->hasRole()->designation : ''}}</td>
                  {{-- @if ($hasJVEForm) --}}
                     <td class="label-title w-50 text-uppercase">Jawatan : {{$hasJVEForm->InspectedDoneBy ? $hasJVEForm->InspectedDoneBy->hasRole()->designation : ''}}</td>
                  {{-- @else --}}
                     {{-- <td class="label-title w-50 text-uppercase">Jawatan : {{$hasForm->InspectedDoneBy ? $hasForm->InspectedDoneBy->hasRole()->designation : ''}}</td> --}}
                  {{-- @endif --}}
               </tr>
              <tr>
                  <td class="label-title w-50 text-uppercase">Tarikh Pemeriksaan : {{$hasForm->inspected_dt ? Carbon\Carbon::parse($hasForm->inspected_dt)->format('d F Y') : ''}}</td>
                  {{-- @if ($hasJVEForm)   --}}
                     <td class="label-title w-50 text-uppercase">Tarikh Semak : {{$hasJVEForm->inspected_done_dt ? Carbon\Carbon::parse($hasJVEForm->inspected_done_dt)->format('d F Y') : ''}}</td>
                  {{-- @else --}}
                     {{-- <td class="label-title w-50 text-uppercase">Tarikh Semak : {{$hasForm->inspected_done_dt ? Carbon\Carbon::parse($hasForm->inspected_done_dt)->format('d F Y') : ''}}</td> --}}
                  {{-- @endif --}}
            </tr>
            
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