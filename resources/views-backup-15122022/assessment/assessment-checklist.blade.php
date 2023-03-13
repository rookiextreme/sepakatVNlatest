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
            '01' => 'Borang Pemeriksaan Kenderaan Baharu',
            '02' => 'Borang Pemeriksaan Keselamatan dan Prestasi',
            '03' => 'Borang Laporan Kerosakan Kemalangan',
            '04' => 'Borang Penilaian Harga Semasa Aset Terpakai',
            '05' => 'Borang Pemeriksaan Kenderaan Terpakai',
            '06' => 'Borang Pemeriksaan Dan Penilaian Aset Mekanikal Untuk Pelupusan'
        ]
    @endphp
    
    {{-- <span class="btn cux-btn no-printme" onclick="window.print()">Cetak</span> --}}
    <span class="btn cux-btn no-printme" onclick="window.open('{{route('jasperReport', [
        'title' => $mappingTitle[$checklist->first()->hasAssessmentType->code],
        'assessment_type_id' => $checklist->first()->hasAssessmentType->id,
        'vehicle_id' => $checklist->first()->vehicle_id,
        'report_name' => 'assessment_checklist',
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
                                        <td class="arial-12"><div class="page-number">121212</div></td>
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
                    @foreach ($checklist as $lvl1)
    
                    <ul style="list-style: none;">
                        @if(count($lvl1->hasFormComponentCheckListLvl2) > 0)
                        <li>
                            <label for="" class="form-label">{{$index + 1}}. {{$lvl1->hasComponentLvl1->component}}</label>
                        </li>
                            <ul style="list-style: none;">
                                @foreach ($lvl1->hasFormComponentCheckListLvl2 as $index2 => $lvl2)
                                <li>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="" class="form-label">{{$index + 1}}.{{$index2 + 1}}. {{$lvl2->hasComponentLvl2->component}}</label>
                                        </div>
                                        @if($lvl2->hasFormComponentCheckListLvl3->count() == 0)
                                        <div class="col-3 text-end pe-1">
                                            <label for="" class="form-label">Catatan</label>
                                            <div>
                                                {{$lvl2->note ?: '-'}}
                                            </div>
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="" class="form-label">Lulus</label>
                                            <div>
                                                @if($lvl2->is_pass)
                                                    <span class="text-success form-label">Ya</span> @else <span class="text-danger form-label">Tidak</span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                <ul style="list-style: none;">
                                    @foreach ($lvl2->hasFormComponentCheckListLvl3 as $index3 => $lvl3)
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="" class="form-label">{{$index + 1}}.{{$index2 + 1}}.{{$index3 + 1}}.{{$lvl3->hasComponentLvl3->component}}</label>
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="" class="form-label">Catatan</label>
                                            <div>
                                                {{$lvl3->note ?: '-'}}
                                            </div>
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="" class="form-label">Lulus</label>
                                            <div>
                                                @if($lvl3->is_pass)
                                                    <span class="text-success form-label">Ya</span> @else <span class="text-danger form-label">Tidak</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </ul>
                                @endforeach
                                
                            </ul>
                        @endif
                    </ul>
                        
                    @endforeach
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