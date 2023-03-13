@php
    $tab = Request('tab') ? Request('tab') : null;
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
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

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
            z-index:1060;
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
        .item.selected, .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        html {
            scroll-behavior: smooth !important;
        }

        #preview_img {
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
    <div class="mytitle">Penilaian Kemalangan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('assessment.accident.register', [
                    'id' => Request('assessment_id'),
                    'tab' => 4
                ]) }}">Penilaian Kemalangan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Penilaian Kemalangan</li>
        </ol>
    </nav>

    <div class="main-contenct">
        <div class="row">
            <div class="col-md-3">

            </div>
        </div>
    </div>
    {{-- <div class="main-content">
        <form id="frm_examination_achievement_vehicle">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="col-md-12">
                        <h3>Semua Kriteria</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-switch">
                            <input type="checkbox" class="form-check-input mt-2 me-2" name="check_all" id="check_all">
                            <label class="form-check-label cursor-pointer" for="check_all">Lulus Semua</label>
                            <label class="ms-3" id="response"></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <div class="col-md-12">
                        <div class="btn-group float-end">
                            @if(auth()->user()->isForemenAssessment())
                            <button type="submit" xaction="draf" class="btn cux-btn small">Simpan</button>
                            @endif
                            <span xaction="approval" data-bs-toggle="modal" data-bs-target="#prompApprovalModal" class="btn cux-btn small">Selesai</span>
                        </div>
                    </div>
                </div>
                <hr/>
                <div style="height: 100vh; overflow: auto;">
                    <div class="col-md-12">
                        @foreach ($AssessmentFormCheckLvl1List as $AssessmentFormCheckLvl1)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="" class="form-label">{{$AssessmentFormCheckLvl1->hasComponentLvl1->component_shortname}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    @if($AssessmentFormCheckLvl1->hasManySelection->count()>0)
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach ($AssessmentFormCheckLvl1->hasManySelection as $hasSelection)
                                                @php
                                                    $tableList = DB::table($hasSelection->hasTableSelection->table)->get();
                                                @endphp
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="" class="form-label">{{$hasSelection->hasTableSelection->desc}}</label>
                                                        <div class="col-md-12">
                                                            <select class="form-select" name="form_selection_id_{{$hasSelection->id}}" id="form_selection_id_{{$hasSelection->id}}">
                                                                <option value="">Sila Pilih</option>
                                                                @foreach ($tableList as $item)
                                                                    <option {{$hasSelection->selected_id == $item->id ? 'selected': ''}} value="{{$item->id}}">{{$item->desc}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    <div class="table-responsive">
                                        <table class="table-custom stripe">
                                            <thead>
                                                <th style="width: 50px;">Lulus</th>
                                                <th class="w-50">Penilaian</th>
                                                <th class="w-auto">Catatan</th>
                                                <th class="text-center">Imej</th>
                                            </thead>
                                                <tbody>
                                                @foreach ($AssessmentFormCheckLvl1->hasFormComponentCheckListLvl2 as $AssessmentFormCheckLvl2)

                                                @if($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3->count() == 0 )
                                                <tr class="">
                                                    <td colspan="4" class="form-label">{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-switch">
                                                            <input {{$AssessmentFormCheckLvl2->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mt-2 me-2" name="form_check_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl2->id}}">
                                                        </div>
                                                    </td>
                                                    <td>{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                                    <td>
                                                        <textarea style="resize: none;" name="form_note_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl2->id}}" rows="2" class="form-control">{{$AssessmentFormCheckLvl2->note}}</textarea>
                                                    </td>
                                                    <td class="text-center">
                                                        <label for="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" class="btn cux-btn small form-label">{{$AssessmentFormCheckLvl2->hasDoc? 'Tukar Fail' : 'Muat naik'}}</label>
                                                        {{-- <input onchange="uploadFile(this)" class="form-control d-none" accept="image/*" name="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" /> --}}
                                                        {{--<input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl2->id}}" data-lvl="2" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl2_component_id_{{$AssessmentFormCheckLvl2->id}}" />
                                                        @php
                                                            $path = '';
                                                            $docName = '';
                                                            if($AssessmentFormCheckLvl2->hasDoc){
                                                                $path = $AssessmentFormCheckLvl2->hasDoc->doc_path;
                                                                $docName = $AssessmentFormCheckLvl2->hasDoc->doc_name;
                                                            }
                                                        @endphp
                                                        <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl2->hasDoc? 'block':'none'}}">
                                                    </td>
                                                </tr>

                                                @else

                                                <tr class="">
                                                    <td colspan="4" class="form-label">{{$AssessmentFormCheckLvl2->hasComponentLvl2->component}}</td>
                                                </tr>

                                                    @foreach ($AssessmentFormCheckLvl2->hasFormComponentCheckListLvl3 as $AssessmentFormCheckLvl3)
                                                    <tr>
                                                        <td>
                                                            <div class="form-switch">
                                                                <input {{$AssessmentFormCheckLvl3->is_pass == '1' ? 'checked' : ''}} type="checkbox" class="form-check-input check_is_pass mt-2 me-2" name="form_check_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" id="form_check_component_id_{{$AssessmentFormCheckLvl3->id}}">
                                                            </div>
                                                        </td>
                                                        <td>{{$AssessmentFormCheckLvl3->hasComponentLvl3->component}}</td>
                                                        <td>
                                                            <textarea style="resize: none;" name="form_note_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" id="form_note_component_id_{{$AssessmentFormCheckLvl3->id}}" rows="2" class="form-control">{{$AssessmentFormCheckLvl3->note}}</textarea>
                                                        </td>
                                                        <td class="text-center" style="text-align: center; vertical-align: middle;">
                                                            <label for="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" class="btn cux-btn small form-label">{{$AssessmentFormCheckLvl3->hasDoc? 'Tukar Fail' : 'Muat naik'}}</label>
                                                            {{-- <input onchange="uploadFile(this)" class="form-control d-none" accept="image/*" name="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" type="file" id="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" /> --}}
                                                            {{--<input onchange="uploadFile(this)" data-id="{{$AssessmentFormCheckLvl3->id}}" data-lvl="3" class="form-control d-none" accept="image/*" type="file" id="form_file_lvl3_component_id_{{$AssessmentFormCheckLvl3->id}}" />
                                                            @php
                                                                $path = '';
                                                                $docName = '';
                                                                if($AssessmentFormCheckLvl3->hasDoc){
                                                                    $path = $AssessmentFormCheckLvl3->hasDoc->doc_path;
                                                                    $docName = $AssessmentFormCheckLvl3->hasDoc->doc_name;
                                                                }
                                                            @endphp
                                                            <img id="preview_img" onclick="openEnlargeModal(this)" src="/storage/{{$path.'/'.$docName}}" alt="" width="100px" class="cursor-pointer" style="display: {{$AssessmentFormCheckLvl3->hasDoc ? 'block' :'none'}}">
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                @endif

                                                @endforeach
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}

    <div class="modal fade" id="prompApprovalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="prompApprovalModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top:22vh;-webkit-border-radius: 12px;-moz-border-radius: 12px;border-radius: 12px;">
            <div class="modal-content awas" style="background-image: url({{asset('my-assets/img/awas.png')}});">
                <div class="modal-header" style="height:70px;">
                    Pengesahan
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" xaction="no" data-bs-dismiss="modal">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body" id="prompt-container">
                    <div class="txt-memo">
                        Adakah semakan telah selesai dan ingin meneruskan proses ini?
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-module" xaction="approve" >Ya</span>
                    <span class="btn btn-reset" data-bs-dismiss="modal">Tutup</span>
                </div>
            </div>
        </div>
    </div>

    @include('components.modal-enlarge-image')

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        let save_as = "";

        function show(element){
            $(element).show();
        }

        submitExaminationAchievementVehicle = function(formData, save_as){

            formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
            formData.append('vehicle_id', "{{Request('vehicle_id')}}");
            formData.append('save_as', save_as);

            $.ajax({
                url: "{{ route('assessment.accident.vehicle-assessment.form.save') }}",
                type: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {

                    if(save_as == 'approve'){
                        //console.log(routeWhenApproved);
                        window.location.href = response.url;
                    }
                    console.log(response);
                    $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        if($('[name="'+key+'"]').attr('type') == 'radio' || $('[name="'+key+'"]').attr('type') == 'checkbox'){
                            if($('[name="'+key+'"]').parent().parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            if($('[name="'+key+'"]').parent().find('.hasErr').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });
                }
            });
        }

        function selectHash(self){
            $('.selected').removeClass('selected disabled');

            let hash = window.location.hash;
            $(self).addClass('selected disabled');
        }

        checkIfAllChecked = function(){
            let totalCheckBox = $('.check_is_pass').length;
            let totalChecked = $('.check_is_pass:checked').length;
            console.log(totalCheckBox, totalChecked);
            if(totalCheckBox == totalChecked){
                $('#check_all').prop('checked', true);
            }
        }

        // uploadFile = function(self){

        //     let url = URL.createObjectURL($(self)[0].files[0]);
        //     if(url){
        //         $(self).parent().find('.form-label').text('Tukar Fail')
        //         $(self).parent().find('#preview_img').attr('src', url).show();
        //     }

        //     let formData = new FormData();

        //     formData.append('_token', "{{ csrf_token() }}");
        //     formData.append('id', $(self).attr('data-id'));
        //     formData.append('lvl', $(self).attr('data-lvl'));
        //     formData.append('assessment_type_id', "{{Request('assessment_type_id')}}");
        //     formData.append('vehicle_id', "{{Request('vehicle_id')}}");
        //     formData.append('file', $(self)[0].files[0]);
        //     $.ajax({
        //         url: "{{ route('assessment.accident.vehicle-assessment.form-file.save') }}",
        //         type: 'post',
        //         data: formData,
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         method: 'POST',
        //         success: function(response) {
        //             console.log(response);
        //             $('#response').html('<span class="text-success">'+response.message+'</span>').fadeIn(500).fadeOut(5000);
        //         },
        //         error: function(response) {
        //             let errors = response.responseJSON.errors;
        //             $.each(errors, function(key, value) {

        //             });

        //         }

        //     });
        // }

        function openEnlargeModal(self){

            $('#enlargeImageModal img').attr('src', $(self).attr('src'));
            $('#enlargeImageModal').modal('show');
        }

        $(document).ready(function(){
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

             $('select').select2({
                 width: '100%',
                 theme: "classic"
             });

            checkIfAllChecked();

            $('#check_all').on('change', function(){
                $('.check_is_pass').prop('checked', this.checked);
            })

            $('[xaction]').on('click', function(){
                save_as = $(this).attr('xaction');

                if(save_as == 'approve'){
                    let formData = new FormData($('#frm_examination_achievement_vehicle')[0]);
                    submitExaminationAchievementVehicle(formData, save_as);
                }
            });

            $('#frm_examination_achievement_vehicle').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                submitExaminationAchievementVehicle(formData, save_as);
            });

            $('.item').on('click', function(e){

                let hasDisable = $(this).hasClass('disabled');
                let hash = this.hash;

                currentOffset = $(hash).offset().top;
                console.log('currentOffset ', currentOffset);

                if(!hasDisable){
                    if (hash !== "") {
                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    // console.log($(hash).offset().top);
                    // $('.scrollable-vertical').animate({
                    //     scrollTop: $(hash).offset().top
                    // }, 500, function(){

                    //     // Add hash (#) to URL when done scrolling (default click behavior)
                    //     // window.location.hash = hash;
                    // });

                    selectHash(this);

                    }
                }
            });

        });


    </script>


</body>

</html>
