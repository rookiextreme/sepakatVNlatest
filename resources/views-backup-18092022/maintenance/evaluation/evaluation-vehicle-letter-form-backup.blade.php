@php
$tab = Request('tab') ? Request('tab') : null;
$template_type_id = Request('template_type_id') ? Request('template_type_id') : null;
$template_type_code = Request('template_type_code') ? Request('template_type_code') : null;
$evaluation_template_letter_id = Request('evaluation_template_letter_id') ? Request('evaluation_template_letter_id') : null;
$maintenance_evaluation_id = Request('maintenance_evaluation_id') ? Request('maintenance_evaluation_id') : null;
$vehicle_id = Request('vehicle_id') ? Request('vehicle_id') : null;
$is_preview = Request('is_preview') ? Request('is_preview') : 0;
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

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}">
    </script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .lcal-2 {
            width: 50px;
        }

        .lcal-3 {
            width: 100px;
        }

        .lcal-4 {
            width: 150px;
        }

        .cux-box {
            min-width: 400px;
            min-height: 300px;
            width: 60%;
            height: 50%;
        }

        .input-group-text {
            height: 39px;
            margin-left: 2px !important;
            margin-right: 3px;
            border: transparent;
            background: #dbdcd8;
        }

        .input-group.date .input-group-text {
            height: 39px;
            margin-left: 4px !important;
            border: transparent;
            background: #dbdcd8;
        }

        .select2-container--open {
            z-index: 1060;
        }

        .inline-label {
            display: contents;
        }

        .scrollable-horizontal {
            width: 100%;
            height: 10vh;
            overflow-x: scroll;
            white-space: nowrap;
            border-left: 3px solid #969690;
            border-right: 3px solid #969690;
        }

        .scrollable-vertical {
            height: 50vh;
            overflow-y: scroll;
            white-space: nowrap;
            scroll-behavior: smooth;
        }

        .item {
            padding: 5px;
            display: inline-block;
            border-radius: 15px;
            border: 1px solid #969690;
            color: #969690;
            text-decoration: none;
            cursor: pointer;
        }

        .item.selected,
        .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        html {
            scroll-behavior: smooth !important;
        }

        #is_preview_img {
            margin-left: auto;
            margin-right: auto;
        }

        .select2-hidden-accessible {
            height: 0px !important;
        }

        @media (max-width: 1399.98px) {
            /*X-Large devices (large desktops, less than 1400px)*/
            /*X-Large*/
        }

        @media (max-width: 1199.98px) {
            /*Large devices (desktops, less than 1200px)*/
            /*Large*/
        }

        @media (max-width: 991.98px) {
            /* Medium devices (tablets, less than 992px)*/
            /*medium*/
        }

        @media (max-width: 767.98px) {
            /* Small devices (landscape phones, less than 768px)
            /*small*/
        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
        }
    </style>
</head>

<body class="content">
    <div class="mytitle">Pemeriksaan Kerosakan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('maintenance.evaluation.register', [
                    'id' => Request('maintenance_evaluation_id'),
                    'tab' => 6
                ]) }}">Pemeriksaan Kerosakan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Pemeriksaan Kerosakan</li>
        </ol>
    </nav>
    <div class="main-content">
        @php
        $TaskFlowAccessMaintenanceEvaluation = auth()->user()->vehicleWorkFlow('02', '01');
        $templateCode = Request('template_code') ? Request('template_code') : null;
        @endphp

        <form action="" id="frm_template_letter">
            @csrf
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <legend>
                                    @if(!$detail || $detail && $detail->hasMaintenanceDetail ?? ''->hasStatus->code == '11')
                                    Janaan Perihal Kerosakan
                                    @else
                                    Surat
                                    @endif
                                </legend>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="template_type_id" id="template_type_id">
                            <option value="">Pilih Janaan Surat</option>
                            @foreach ($letter_type_list as $letter_type)
                                <option data-code="{{$letter_type->code}}" {{$detail && $detail->hasLetterType && $detail->hasLetterType->id == $letter_type->id ? 'selected' : ($template_type_id == $letter_type->id ? 'selected' : '')}} value="{{$letter_type->id}}">{{$letter_type->desc}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-8">
                        @if($template_type_code)
                        <div class="btn-group">
                            @if($is_preview)
                            @else
                            <button type="submit" class="btn cux-btn bigger">Simpan</button>
                            @endif
                            @if($is_preview)
                                <span class="btn cux-btn bigger" onclick="un_previewLetter()">Janaan Perihal Kerosakan</span>
                                @else
                                <span class="btn cux-btn bigger" onclick="is_previewLetter()">Pra-Tonton</span>
                            @endif
                            @if($detail)
                                @if(auth()->user()->isForemenMaintenance())
                                    {{-- Pembantu Kemahiran --}}
                                    <span class="btn cux-btn bigger" onclick="prompVerificationLetter()">Hantar semakan</span>
                                @elseif(auth()->user()->isAssistEngineer() || auth()->user()->isAssistEngineerMaintenance())
                                    {{-- Penolong Jurutera --}}
                                    <span class="btn cux-btn bigger" onclick="prompApprovalLetter()">Hantar pengesahan</span>
                                @elseif(auth()->user()->isEngineer() || auth()->user()->isEngineerMaintenance())
                                    {{-- Jurutera --}}
                                    <span class="btn cux-btn bigger" onclick="prompApproveLetter()">Sahkan</span>
                                @endif
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        @if($template_type_code)
                            @include('maintenance.evaluation.tab.template.letter-'.$template_type_code, [
                                'is_preview' => $is_preview,
                                'template_type_id' => $template_type_id,
                                'detail' => $detail,
                                'vehicle_id' => $vehicle_id
                            ]);
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="maintenanceEvaluationAddCheckListModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationAddCheckListModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="frm_add_checklist">
                @csrf
                <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$vehicle_id}}">
                <input type="hidden" name="template_letter_type_id" id="template_letter_type_id" value="{{$template_type_id}}">
                <input type="hidden" name="evaluation_template_letter_id" id="evaluation_template_letter_id" value="{{$detail ? $detail->id: null}}">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Perincian Kerja</label>
                                    <textarea class="form-control" style="resize: none;" type="text" name="job_detail" id="job_detail" rows="3" cols="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Keperluan Penukaran Alat Ganti</label>
                                    <textarea class="form-control" style="resize: none;" type="text" name="syntom" id="syntom" rows="3" cols="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Simptom/Kerosakan</label>
                                    <textarea class="form-control" style="resize: none;" type="text" name="accessories" id="accessories" rows="3" cols="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="" class="form-label">Anggaran</label>
                                    <input type="text" name="budget" id="budget">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary text-white">Simpan</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="maintenanceEvaluationDelCheckListModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationDelCheckListModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="frm_del_checklist">
                @csrf
                <input type="hidden" name="template_letter_type_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <input type="hidden" name="evaluation_template_letter_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <div class="modal-content">
                    <div class="modal-body">
                        Adakah anda ingin menghapuskan maklumat ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary text-white">Ya</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="maintenanceEvaluationLetterVerificationModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationLetterVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="frm_del_checklist">
                @csrf
                <input type="hidden" name="template_letter_type_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <input type="hidden" name="evaluation_template_letter_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <div class="modal-content">
                    <div class="modal-body">
                        Adakah anda ingin menghantar untuk semakan?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary text-white" onclick="verificationLetter()">Ya</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="maintenanceEvaluationLetterApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationLetterApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="frm_del_checklist">
                @csrf
                <input type="hidden" name="template_letter_type_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <input type="hidden" name="evaluation_template_letter_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <div class="modal-content">
                    <div class="modal-body">
                        Adakah anda ingin menghantar untuk pengesahan?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary text-white" onclick="approvalLetter()">Ya</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="maintenanceEvaluationLetterApproveModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="maintenanceEvaluationLetterApproveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="frm_del_checklist">
                @csrf
                <input type="hidden" name="template_letter_type_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <input type="hidden" name="evaluation_template_letter_id" id="evaluation_template_letter_id" value="{{$template_type_id}}">
                <div class="modal-content">
                    <div class="modal-body">
                        Adakah anda ingin mengesahkan surat ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary text-white" onclick="approveLetter()">Ya</span>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('components.modal-enlarge-image')

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>
    let is_preview = 0;
    let categoryId = null;
    let subCategoryId = null;
    let subCategoryTypeId = null;

    let save_as = "";

    function show(element){
        $(element).show();
    }


    function selectHash(self){
        $('.selected').removeClass('selected disabled');

        let hash = window.location.hash;
        $(self).addClass('selected disabled');
    }

    const un_previewLetter = function(){
        is_preview = 0;
        window.location.href = "?maintenance_evaluation_id=&vehicle_id={{$vehicle_id}}&template_type_id={{$template_type_id}}&template_type_code={{$template_type_code}}&tab=6&is_preview="+is_preview;
    }

    const is_previewLetter = function(){
        is_preview = 1;
        window.location.href = "?maintenance_evaluation_id=&vehicle_id={{$vehicle_id}}&template_type_id={{$template_type_id}}&template_type_code={{$template_type_code}}&tab=6&is_preview="+is_preview;
    }

    const prompVerificationLetter = function(){
        $('#maintenanceEvaluationLetterVerificationModal').modal('show');
    }

    const verificationLetter = function(){

        saveSilent();

        let crf = "{{ csrf_token() }}";
        $.post("{{ route('maintenance.evaluation.vehicle-maintenance.letter.verification') }}", {
            _token: crf
        }, function(result){
            console.log('result => ' , result);
            window.location.href = result.url;
            //$('#maintenanceEvaluationLetterVerificationModal').modal('hide');
        });
    }

    const prompApprovalLetter = function(){
        $('#maintenanceEvaluationLetterApprovalModal').modal('show');
    }

    const approvalLetter = function(){

        saveSilent();

        let crf = "{{ csrf_token() }}";
        $.post("{{ route('maintenance.evaluation.vehicle-maintenance.letter.approval') }}", {
            _token: crf
        }, function(result){
            console.log('result => ' , result);
            window.location.href = result.url;
            //$('#maintenanceEvaluationLetterVerificationModal').modal('hide');
        });
    }

    const prompApproveLetter = function(){
        $('#maintenanceEvaluationLetterApproveModal').modal('show');
    }

    const approveLetter = function(){

        saveSilent();

        let crf = "{{ csrf_token() }}";
        $.post("{{ route('maintenance.evaluation.vehicle-maintenance.letter.approve') }}", {
            '_token': crf
        }, function(result){
            console.log('result => ' , result);
            window.location.href = result.url;
            // $('#maintenanceEvaluationLetterApproveModal').modal('hide');
        });
    }

    const saveSilent = function(){
        let form = $('#frm_template_letter')[0];
        let formData = new FormData(form);
        formData.append('mode', 'save_without_redirect');
        submitFormTemplateLetter(formData);
    }

    const submitFormTemplateLetter = function(data){
        parent.startLoading();
        $.ajax({
            url: "{{ route('maintenance.evaluation.vehicle-maintenance.letter.save') }}",
            type: 'post',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                if(data.mode == 'save_without_redirect'){

                }else {
                    window.location.reload();
                }
            },
            error: function(response) {
                console.log(response);
                var errors = response.responseJSON.errors;

                // $.each(errors, function(key, value) {

                //     if(key == 'app_dates'){
                //         if($('[name="'+key+'"]').find('.hasErr').length == 0){
                //             console.log(value[0]);
                //             $('[name="'+key+'"]').html('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                //         }
                //     }
                //     else if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                //         if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                //             $('[name="'+key+'"]').parent().parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                //         }
                //     } else {
                //         if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                //             $('[name="'+key+'"]').parent().append('<div class="hasErr text-danger col-12 fs-6">'+value[0]+'</div>');
                //         }
                //     }
                // });

                parent.stopLoading();
            }
        });
    }

    $(document).ready(function(){
        initTab();
        let tab = '{{$tab}}';
        $('#tab'+tab).trigger('click');

        $('select').select2({
            width: '100%',
            theme: "classic"
        });

        $('#template_type_id').on('change', function(e){
            e.preventDefault();
            is_preview = 0;
            let templateTypeCode = $('option:selected', this).data('code');
            if(templateTypeCode){
                window.location.href = "?maintenance_evaluation_id={{$maintenance_evaluation_id}}&vehicle_id={{$vehicle_id}}&template_type_id="+this.value+"&template_type_code="+templateTypeCode+"&tab=6&is_preview="+is_preview;
            }
        });

        $('#frm_template_letter').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            submitFormTemplateLetter(formData);
        });

    });

    </script>


</body>

</html>
