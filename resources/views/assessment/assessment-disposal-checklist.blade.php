<?php
use Carbon\Carbon;
?>
<html>
<head>
    <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <link rel="shortcut icon" href="{{ asset('my-assets/favicon/favicon.png') }}">

    <!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">

    <!--importing bootstrap-->
    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('my-assets/fontawesome-pro/css/light.min.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.js') }}"></script>
    <!--Importing Icons-->

    <link href="{{ asset('my-assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet" />
    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js') }}"></script>

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>
    <style>
        .display-logo-footer {
            display: none;
        }
        
        @media print {

            .page-number:nth-child() {
                background-color:black;
                color: green;
            }

            @page {
            size: A4 portrait;
            /* auto is default portrait; */
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
            .display-logo-footer {
                display: block;
                text-align: right;
            }

            .pageBreak {
                page-break-before: always;
                padding-bottom: 120px;
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

         .arial-12{
            font-size: 12px;
            font-family: Arial;
            color:black;
         }

         .header, .header-space,
         .footer, .footer-space {
            height: 100px;
        }

        .header {
            position: fixed;
            top: 0;
        }
        .footer {
            position: fixed;
            bottom: 0;
        }
      </style>
</head>
<body>

    @php
        $index = 0;
        $mappingTitle = [
            '06' => 'Borang Pemeriksaan Dan Penilaian Aset Mekanikal Untuk Pelupusan'
        ]
    @endphp
    
    {{-- <span class="btn cux-btn no-printme" onclick="window.print()">Cetak</span> --}}
    <span class="btn cux-btn no-printme" onclick="window.open('{{route('jasperReport', [
        'title' => $mappingTitle['06'],
        'assessment_type_id' => $checklist->first()->hasAssessmentType->id,
        'vehicle_id' => $checklist->first()->vehicle_id,
        'report_name' => 'assessment_disposal_checklist',
        'report_type' => 'pdf'
        ])}}')">Cetak</span>
    
    <div class="text-center">
        <h3>Senarai Semakan Pemeriksaan Kenderaan yang telah disemak</h3>
    </div>

    <table style = "margin:auto;display: table;" class="report-container">
        <thead class="report-header">
        <tr>
            <th>
                <table style="width: 100%; margin-bottom: 20px;display: table;" class="table-bordered" cellpadding="5">
                    <tr>
                        <td width="130px" align="center">
                            <div>
                                <img src="{{asset('my-assets/img/logo-min.png')}}" height="70px" alt=""><br/>
                                <label for="" class="form-label">JKR Malaysia</label>
                            </div>
                        </td>
                        <td align="center" style="font-weight: bold;color:black; font-family: arial">{{$mappingTitle[$checklist->first()->hasAssessmentType->code]}}</td>
                        <td>
                            <table style="width: 100%; display: table;">
                                <thead>
                                    <tr>
                                        <td class="arial-12">No Dokumen</td>
                                        <td class="arial-12">:</td>
                                        <td class="arial-12">{{$checklist->first()->hasAssessmentType->document_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="arial-12">No Keluaran</td>
                                        <td class="arial-12">:</td>
                                        <td class="arial-12">{{$checklist->first()->hasAssessmentType->produce_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="arial-12">No Pindaan</td>
                                        <td class="arial-12">:</td>
                                        <td class="arial-12">{{$checklist->first()->hasAssessmentType->amendment_no}}</td>
                                    </tr>
                                    <tr>
                                        <td class="arial-12">Tarikh</td>
                                        <td class="arial-12">:</td>
                                        <td class="arial-12">{{\Carbon\Carbon::parse($checklist->first()->hasAssessmentType->amendment_dt)->format('d/m/Y')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="arial-12">Muka Surat</td>
                                        <td class="arial-12">:</td>
                                        <td class="arial-12"><div class="page-number"></div></td>
                                    </tr>                                
                                </thead>
                            </table>
                        </td>
                    </tr>
                </table>
            </th>
        </tr>
        </thead>
        <tfoot class="report-footer">
            <tr>
                <td>
                    <div class="footer"></div>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>
                    <table style="width: 100%; margin-bottom: 20px;display: table;" cellpadding="5">
                        <tr>
                            <td>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-2">
                                        <label for="" class="form-label">No. Rujukan </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">: {{$disposalDetail->ref_number}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">Nama Penyemak </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">: {{$disposalDetail->hasAssistantEngineerBy->name}}</label>
                                    </div>
                                </div>
                                <div class="row" style="margin-top:20px;">
                                    <div class="col-md-2">
                                        <label for="" class="form-label">Nama Pemeriksa  </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">: {{$disposalVehicle->foremenBy->name}}</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">Tarikh Pemeriksaan  </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">: {{Carbon::parse($disposalVehicle->assessment_dt)->translatedFormat('d F Y')}}</label>
                                    </div>
                                </div>
                            </td>
                            <tr>
                                <td>
                                    <div class="row" style="margin-top:20px;">
                                        <div class="col-md-2">
                                            <label class="form-label">Maklumat</label>
                                            <label class="form-label">Kenderaan :</label>
                                        </div>
                                        <div class="col-md-10">
                                            <table style="width: 100%; margin-bottom: 20px;display: table;" class="table-bordered" cellpadding="5">
                                                <tr>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label" > No. Pendaftaran</label>
                                                    </td>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> No. Chasis</label>
                                                    </td>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> No. Enjin</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->plate_no}}</label>
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->chasis_no}}</label>
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->engine_no}}</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> Jenis</label>
                                                    </td>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> Pembuat</label>
                                                    </td>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> Model</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->hasSubCategoryType->name}}</label>
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->hasVehicleBrand->name}}</label>
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->model_name}}</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> Tahun Dibuat</label>
                                                    </td>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> Bacaan Odometer</label>
                                                    </td>
                                                    <td style="background: #c7c7c7">
                                                        <label class="form-label"> Bahan Bakar</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->manufacture_year}}</label>
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->odometer}}</label>
                                                    </td>
                                                    <td>
                                                        <label class="form-label">{{$disposalVehicle->fuel_type_id}}</label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%; margin-bottom: 20px;display: table;" class="table-bordered" cellpadding="5">
                        <tr>
                            <td style="background: #c7c7c7; padding-left:10px">
                                <label for="" class="form-label">Perkara </label>
                            </td>
                            <td style="background: #c7c7c7; padding-left:10px">
                                <label for="" class="form-label">Catatan </label>
                            </td>
                            <td style="background: #c7c7c7; text-align:center">
                                <label for="" class="form-label">Keadaan </label>
                            </td>
                            <td style="background: #c7c7c7; text-align:center">
                                <label for="" class="form-label">Tindakan </label>
                            </td>
                        </tr>
                    @foreach ($checklist as $lvl1)
                    @php
                        $index += 1;
                    @endphp
                    <tr>
                        <td style="padding-left:20px">
                            <label for="" class="form-label">{{$index}}. {{$lvl1->hasComponentLvl1->component}}</label>
                        </td>
                        <td>
                            <div class="row" style="margin-bottom: 10px">
                                <label class="form-label">{{$lvl1->note ?: '-'}}</label>
                            </div>
                        </td>
                        <td style="text-align: center">
                            <div class="row" style="margin-bottom: 10px">
                                <label class="form-label">{{$lvl1->hasDisposalPercentage->desc}}</label>
                            </div>
                        </td>
                        <td style="text-align: center">
                            @if ($lvl1->is_repair == true)
                                <label class="form-label">Baiki</label>
                            @elseif ($lvl1->is_repairs == true)
                                <label class="form-label">Baik Pulih</label>
                            @elseif ($lvl1->is_replacement == true)
                                <label class="form-label">Ganti</label>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                </table>
                </td>
            </tr>
        </tbody>
    </table>
    <footer>
        {{-- display-logo-footer --}}
        <div class="">
            <div>
                <div>
                    <table style="width: 100%">
                        <tr>
                            <td colspan="3">
                                <strong style="font-weight: bold; color:black; font-size: 14px;">Tandatangan</strong>
                                <div style="padding-top: 30px;padding-top: 20px;">..................................</div>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color:black; font-size: 14px;">Nama Pemeriksa</td>
                            <td style="font-weight: bold; color:black; font-size: 14px;">:</td>
                            <td style="font-weight: bold; color:black; font-size: 14px;">{{$checklist->first()->hasVehicle->foremenBy->name}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; color:black; font-size: 14px;">Tarikh Pemeriksaan</td>
                            <td style="font-weight: bold; color:black; font-size: 14px;">:</td>
                            <td style="font-weight: bold; color:black; font-size: 14px;">{{\Carbon\Carbon::parse($checklist->first()->hasVehicle->foremen_dt)->format('d F Y g:i:A')}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="float-end">
                <img src="{{asset('my-assets/img/spakat-small-min.png')}}" alt="">
            </div>
        </div>
    </footer>
</body>
</html>