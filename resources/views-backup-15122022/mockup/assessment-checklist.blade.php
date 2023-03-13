@php
    use App\Models\Assessment\AssessmentNewVehicle;
    use App\Models\Assessment\AssessmentSafeTyVehicle;
    use App\Models\Assessment\AssessmentVehicleImage;
    use App\Models\Assessment\AssessmentType;
    use App\Models\Vehicle\Brand;
    use App\Models\RefCategory;

    $tab = Request('tab') ? Request('tab') : null;
    $assessment_type_id = Request('assessment_type_id') ? Request('assessment_type_id') : null;
    $vehicle_id = Request('vehicle_id');

    $AssessmentType = AssessmentType::find($assessment_type_id);
    $tableVehicle = new AssessmentNewVehicle;
    $tableVehicleImage = new AssessmentVehicleImage;

    if($AssessmentType){
        switch ($AssessmentType->code) {
            case '01':
                $tableVehicle = new AssessmentNewVehicle;
                break;

            case '02':
                $tableVehicle = new AssessmentSafetyVehicle;
                break;
        }
    }

    $AssessmentVehicle = $tableVehicle::find($vehicle_id);

    if(!$AssessmentVehicle){
        echo 'Dont Bypass';
        exit;
    }

    $OwnImage = $tableVehicleImage::where('vehicle_id', $AssessmentVehicle->id)
                                        ->whereHas('hasAssessmentType', function($q) use($AssessmentType){
                                            $q->where('code', $AssessmentType->code);
                                        })->get();
    $brand_list = Brand::where('status', 1)->orderBy('name')->get();
    $category_list = RefCategory::where('status', 1)->get();
    
@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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

    <style type="text/css">

    .text-theme {
        color:chocolate;
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

        .tbl_lvl2_lvl3 {
            width: 100%;
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .tbl_lvl2_lvl3 .is_pass {
            width: 10%;
        }
        
        .tbl_lvl2_lvl3 .assessment {
            width: 60%;
        }

        .tbl_lvl2_lvl3 .note {
            width: 30%;
        }

        .tbl_lvl2_lvl3_footer {
            /* padding-bottom: 50px; */
        }
    }

    </style>
    <script type="text/javascript">
    </script>
</head>
<body class="content">
<div class="main-content ">
    <div class="btn-group pt-2 pb-2 no-printme">
        <button class="btn cux-btn" onclick="window.print()"> <i class="fa fa-print"></i> Cetak</button>
    </div>
    <div class="paper" id="assess-form">
        <div class="row">
            <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                <div class="the-section main">UMUM</div>
            </div>
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                <div class="row">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-4">
                        <div class="switch">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Odometer</label>
                                <div class="text-theme">
                                    {{$AssessmentVehicle->odometer}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-xl-3 col-lg-2 col-md-3 col-sm-3 col-12">
                        <div class="form-group" id="own_image">
                            @if($OwnImage->count() < 5)
                                <label for="" class="form-label text-dark">Imej Kenderaan<span class="text-danger"></span></label>
                                <div class="col-md-9"><label for="veh_img_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik</label></div>
                                <input onchange="uploadFileVehicle(this)" data-id="{{$AssessmentVehicle->id}}" data-lvl="veh_img_doc" class="form-control d-none" accept="image/*" type="file" id="veh_img_doc" />
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-10 col-md-9 col-sm-9 col-12" id="reload_veh">
                        <!--imej di sini-->
                            @if (count($OwnImage) > 0)
                                @foreach ( $OwnImage as $vehicleImage)
                                    @php
                                        $path = '';
                                        $docName = '';
                                        if($vehicleImage){
                                            $path = $vehicleImage->doc_path;
                                            $docName = $vehicleImage->doc_name;
                                        }
                                    @endphp
                                    <div  style="position:relative; width:150px;">
                                        <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentVehicle->id}}, 'veh_img_doc', {{$vehicleImage->id}})"><i class="fa fa-times icon-white"></i></div>
                                        <img id="preview_vehicle" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$OwnImage ? 'block' :'none'}}">
                                    </div>
                                @endforeach
                            @endif
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                        <div class="switch">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Kategori</label>
                                <div class="text-theme">
                                    {{$AssessmentVehicle->hasCategory ? $AssessmentVehicle->hasCategory->name : '-'}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                        <div class="switch">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Sub Kategori</label>
                                <div class="text-theme">
                                    {{$AssessmentVehicle->hasSubCategory ? $AssessmentVehicle->hasSubCategory->name : '-'}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                        <div class="switch">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Jenis</label>
                                <div class="text-theme">
                                    {{$AssessmentVehicle->hasSubCategoryType ? $AssessmentVehicle->hasSubCategoryType->name : '-'}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                        <div class="switch">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Buatan</label>
                                <div class="text-theme">
                                    {{$AssessmentVehicle->hasVehicleBrand ? $AssessmentVehicle->hasVehicleBrand->name : '-'}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4">
                        <div class="switch">
                            <div class="form-group">
                                <label for="" class="form-label text-dark">Model</label>
                                <div class="text-theme">
                                    {{$AssessmentVehicle->model_name ? $AssessmentVehicle->model_name : '-'}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="row thin-topline" id="row-payment">
            <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                <div class="the-section">PEMBAYARAN</div>
            </div>
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Jumlah Bayaran</label>
                            <div class="txt-data ass_gov"><small>RM</small> {{$AssessmentVehicle->price}}</div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-3 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">No Resit</label>
                            <div class="text-theme">
                                {{$AssessmentVehicle->receipt_no ? $AssessmentVehicle->receipt_no : '-'}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5 col-6">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Resit Bayaran <span class="text-danger">{{$AssessmentVehicle->receipt_doc > 0 ? "*" : " "}}</span></label>
                            <div class="col-md-9"><label for="receipt_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Gambar</label></div>
                            <input onchange="uploadFileReceipt(this)" data-id="{{$vehicle_id}}" data-lvl="receipt_doc" class="form-control d-none" accept="image/*" type="file" id="receipt_doc" />
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-6" id="reload_receipt">
                        @if ($AssessmentVehicle->hasReceiptDoc)
                            @php
                                $path = '';
                                $docName = '';
                                if($AssessmentVehicle->hasReceiptDoc){
                                    $path = $AssessmentVehicle->hasReceiptDoc->doc_path;
                                    $docName = $AssessmentVehicle->hasReceiptDoc->doc_name;
                                }
                            @endphp
                            <input type="hidden" name="receipt_file" id="receipt_file" value="{{$docName}}">
                            <div  style="position:relative; width:150px; height:60px">
                                <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentVehicle->id}}, 'receipt_doc', {{$AssessmentVehicle->receipt_doc}})"><i class="fa fa-times icon-white"></i></div>
                                <img id="preview_receipt" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentVehicle->hasReceiptDoc ? 'block' :'none'}}">
                            </div>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row thin-topline" id="KAEDAH">
            <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                <div class="the-section">KAEDAH</div>
            </div>
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                        <div class="form-group">
                        <label for="" class="form-label  text-dark">Kaedah Pemeriksaan</label>
                            <div class="text-theme">{{$AssessmentVehicle->evaluation_type ? $AssessmentVehicle->evaluation_type : '-'}}</div>
                        </div>
                    </div>
                    {{-- <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6" id="row_vtl" style="display: {{$AssessmentVehicle->evaluation_type == 'Manual' ? 'none' : 'show'}}">
                        <div class="form-group">
                            <label for="" class="form-label  text-dark">Laporan VTL</label>
                            <div class="col-md-9"><label for="vtl_doc" class="btn cux-btn bigger"><i class="fas fa-image"></i> Muat Naik Laporan</label></div>
                            <input onchange="uploadFileVTL(this)" data-id="{{$vehicle_id}}" data-lvl="vtl_doc" class="form-control d-none" accept="image/*" type="file" id="vtl_doc" />
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-2 col-md-3 col-sm-3 col-12" id="reload_vtl" style="display: {{$AssessmentVehicle->evaluation_type == 'Manual' ? 'none' : 'show'}}">
                        @if ($AssessmentVehicle->hasVtlDoc)
                            @php
                                $path = '';
                                $docName = '';
                                if($AssessmentVehicle->hasVtlDoc){
                                    $path = $AssessmentVehicle->hasVtlDoc->doc_path;
                                    $docName = $AssessmentVehicle->hasVtlDoc->doc_name;
                                }
                            @endphp
                            <div style="position:relative" id="vtl_img_for">
                                <div class="img-del"><i class="fa fa-times icon-white"></i></div>
                                <div class="img-del" onclick="deleteRelatedDoc({{$AssessmentVehicle->id}}, 'vtl_doc', {{$AssessmentVehicle->vtl_doc}})"><i class="fa fa-times icon-white"></i></div>
                                <img id="preview_vtl" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="200px" class="cursor-pointer" style="display: {{$AssessmentVehicle->hasVtlDoc ? 'block' :'none'}};margin-bottom:10px" >
                            </div>
                        @endif
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row thin-topline">
            <div class="col-xl-3 col-lg-2 col-md-12 col-12">
                <div class="the-section main"></div>
            </div>
            {{-- <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                <div class="row thin-underline">
                    <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5 col-8 pt-3">
                        <div class="form-switch form-group">
                            <input type="checkbox" class="form-check-input mt-2" name="check_all" id="check_all">
                            <label class="form-check-label cursor-pointer" for="check_all" style="margin-top:-5px;font-size:14px">&nbsp;&nbsp;Lulus Semua</label>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
        <div class="row {{$loop->index > 0 ? "thin-topline" : ""}}">
            <div class="col-xl-3 col-lg-2 col-md-12 col-sm-12 col-12" id="{{str_replace(' ', '', $AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname)}}">
                <div class="the-section">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</div>
            </div>
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 col-12 pt-2">
                <!--start of content-->
                @if($AssessmentFormCheckLvl1->hasManySelection->count()>0)
                    <div class="row">
                        @foreach ($AssessmentFormCheckLvl1->hasManySelection as $hasSelection)
                            @php
                                $tableList = DB::table($hasSelection->hasTableSelection->table)->get();
                            @endphp
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
                                <div class="form-group must-answer">
                                    <label for="" class="form-label">{{$hasSelection->hasTableSelection->desc}}</label>
                                    @foreach ($tableList as $item)
                                    {{$hasSelection->selected_id == $item->id ? $item->desc: ''}}
                                    @endforeach
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif

                @foreach ($AssessmentFormCheckLvl1->hasFormComponentCheckListLvl2 as $AssessmentFormCheckLvl2)
                    <div class="form-group mb-0" style="line-height:10px;"><label>{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</label></div>
                    <div class="col-10">
                    <table class="table-custom stripe no-footer tbl_lvl2_lvl3">
                        <thead>
                            <th class="is_pass" style="width: 50px;">Lulus</th>
                            <th class="assessment">Penilaian</th>
                            <th style="width: 40%" class="note">Catatan</th>
                            {{-- <th class="text-center w-imej">Imej</th> --}}
                        </thead>
                        <tbody class="no-footer tbl_lvl2_lvl3_footer">
                            @if($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3->count() == 0)
                            <tr class="must-answer">
                                <td>
                                    @if ($AssessmentFormCheckLvl2->is_pass == '1')
                                        <i class="fa fa-check"></i>
                                        @else
                                    @endif
                                </td>
                                <td>{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                <td>
                                    <div class="text-theme">{{$AssessmentFormCheckLvl2->note ? $AssessmentFormCheckLvl2->note : '-'}}</div>
                                </td>
                                <div class="hasErr"></div>
                                {{-- <td class="text-center">
                                    <label for="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" class="btn cux-btn bigger"><i class="fas fa-image"></i></label>
                                    <input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl2->id}}" data-lvl="2" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" />
                                    @php
                                        $path = '';
                                        $docName = '';
                                        if($AssessmentFormCheckLvl2->hasDoc){
                                            $path = $AssessmentFormCheckLvl2->hasDoc->doc_path;
                                            $docName = $AssessmentFormCheckLvl2->hasDoc->doc_name;
                                        }

                                    @endphp
                                    <div id="reload_img_lvl2_{{$AssessmentFormCheckLvl2->id}}">
                                        <div style="position:relative; display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}; width:150px; height:60px" >
                                            <div class="img-del"><i class="fa fa-times icon-white"></i></div>
                                            <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl2->doc_id}}, 'lvl2', {{$AssessmentFormCheckLvl2->id}})"><i class="fa fa-times icon-white"></i></div>
                                            <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}">
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                            @else
                            @foreach ($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3 as $AssessmentFormCheckLvl3)
                            <tr class="must-answer">
                                <td>
                                    @if ($AssessmentFormCheckLvl3->is_pass == '1')
                                        <i class="fa fa-check"></i>
                                        @else
                                    @endif
                                </td>
                                <td>{{$AssessmentFormCheckLvl3->hasComponentLvl3->component}}</td>
                                <td>
                                    <div class="text-theme">{{$AssessmentFormCheckLvl3->note ? $AssessmentFormCheckLvl3->note : '-'}}</div>
                                </td>
                                <div class="hasErr"></div>
                                {{-- <td class="text-center" style="text-align: center; vertical-align: middle;">
                                    <label for="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" class="btn cux-btn bigger"><i class="fas fa-image"></i></label>
                                    <input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl3->id}}" data-lvl="3" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" />
                                    @php
                                        $path = '';
                                        $docName = '';
                                        if($AssessmentFormCheckLvl3->hasDoc){
                                            $path = $AssessmentFormCheckLvl3->hasDoc->doc_path;
                                            $docName = $AssessmentFormCheckLvl3->hasDoc->doc_name;
                                        }
                                    @endphp
                                    <div id="reload_img_lvl3_{{$AssessmentFormCheckLvl3->id}}">
                                        <div style="position:relative; display: {{$AssessmentFormCheckLvl3->hasDoc? 'block':'none'}}; width:150px; height:60px" id="reload_img_lvl3">
                                            <div class="img-del"><i class="fa fa-times icon-white"></i></div>
                                            <div class="img-del" onclick="deleteFile({{$AssessmentFormCheckLvl3->doc_id}}, 'lvl3', {{$AssessmentFormCheckLvl3->id}})"><i class="fa fa-times icon-white"></i></div>
                                            <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl3->hasDoc? 'block':'none'}}">
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    </div>
                @endforeach
               <!--end of content-->
            </div>
        </div>
        @endforeach
        <div style="height:100px"></div>
    </div>
</div>

    @include('components.modal-enlarge-image')

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>
    </script>


</body>

</html>
