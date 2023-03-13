@php
    use App\Http\Controllers\Setting\SettingAnnounceDAO;

    $SettingAnnounceDAO = new SettingAnnounceDAO();
    $SettingAnnounceDAO->mount();
    $type_announce_list = $SettingAnnounceDAO->type_announce_list;
    $announce_list_with_paging = $SettingAnnounceDAO->announce_list_with_paging;
    $lang = request('lang') ? request('lang') : 'bm';

@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scaLabel=no" />
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
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

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

        .leftline-b {
            border-left-style: solid;
            border-left-width: 2px;
            border-left-color: #d1d3cc;
        }

        .memo-dte {
            color:#3a3a3a;
            font-size:0.8em;
            font-family: avenir;
            text-transform: uppercase;
            margin-bottom:10px;
            letter-spacing: 2px;
            margin-top:20px;
        }
        .memo-txt {
            color:#3a3a3a;
            font-size:1.1em;
            font-family: helve-bold;
            margin-bottom:10px;
        }
        .memo-sig {
            color:#3a3a3a;
            font-size:0.9em;
            font-family: helve-bold;
            margin-top:10px;
        }

        .date .input-group-text {
            height: 39px;
            margin-left: 2px !important;
            border: transparent;
            background: #dbdcd8;
        }

        .list-group-item {
            display: flex;
            align-items: center;
        }

        .highlight {
            background: #f7e7d3;
            min-height: 30px;
            list-style-type: none;
        }

        .handle {
            min-width: 18px;
            height: 15px;
            display: inline-block;
            cursor: move;
            margin-right: 10px;
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

        .cursor-pointer {
            cursor: pointer;
        }

    </style>
    <script>

        function hide(element){
            $(element).hide();
        }

        function show(element){
            $(element).show();
        }

        function block(element){
            $(element).prop('disabled', true);
        }

        function release(element){
            $(element).prop('disabled', false);
        }

        function alphanumeric()
        {
            var regex = new RegExp("^[a-zA-Z0-9]+$");
            return regex;
        }

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Pengumuman</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.admin.dashboard') }}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Am & Penetapan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notis Pengumuman</li>
        </ol>
    </nav>


    <div class="main-content">

        <div id="preview-announcement"></div>

    </div>

    <div class="divider-line mt-3"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="float-end">
                <span onclick="getList()" data-bs-toggle="modal" data-bs-target="#AnnouncementSortingModal" class="cux-btn small"> <i class="fal fa-list"></i> Susun</span>
                <span onclick="clearForm('#frmAddNewAnnouncement')" data-bs-toggle="modal" data-bs-target="#addNewAnnouncement" class="cux-btn small"> <i class="fal fa-plus"></i> Tambah Pengumuman</span>
            </div>
        </div>
        <div class="col-md-12 mt-2">
            <div id="table">
                <div class="table-responsive">
                    <table class="table-custom stripe">
                    <thead>
                        <tr>
                            <th class="lcal-2" style="width: 50px;"><input name="chkall" id="chkall" type="checkbox"/></th>
                            <th></th>
                            <th>Tajuk Dalam Bahasa Melayu</th>
                            <th>Tajuk Dalam Inggeris</th>
                            <th>Penerangan Dalam Bahasa Melayu</th>
                            <th>Penerangan Dalam Bahasa Inggeris</th>
                            <th>Tarikh Mula</th>
                            <th>Tarikh Tamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="sortable">

                        @foreach ($announce_list_with_paging as $announce)
                            <tr>
                                <td class="del" style="width: 50px;">
                                    <input name="chkdel" id="chkdel" type="checkbox" value="{{$announce->id}}"/>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <div class="btn-group dropend">
                                            <span class="btn cux-btn" data-self="{{$announce->toJson()}}" onclick="initEditData(this, '#addNewAnnouncement')" data-bs-toggle="modal" data-bs-target="#addNewAnnouncement" class="cux-btn small"> <i class="fa fa-pencil-alt"></i></span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$announce['title_bm']}}</td>
                                <td>{{$announce['title_en']}}</td>
                                <td>
                                    <div class="overflow-auto" style="height: 100px">{{$announce['desc_bm_1']}} {{$announce['desc_bm_2']}}</div>
                                </td>
                                <td>
                                    <div class="overflow-auto" style="height: 100px">{{$announce['desc_en_1']}} {{$announce['desc_en_2']}}</div>
                                </td>
                                <td>{{\Carbon\Carbon::parse($announce->start_dt)->format('d/m/Y')}}</td>
                                <td>{{$announce->end_dt ? \Carbon\Carbon::parse($announce->end_dt)->format('d/m/Y') : ''}}</td>
                                <td>
                                    <div class="form-switch">
                                        <input {{$announce->status == 1 ? 'checked' : ''}} class="form-check-input" type="checkbox" onchange="$(this).prop('checked') == true ? this.value = 1 : this.value = 0; setActive({{$announce->id}}, this.value)"  name="status" id="inlineRadio-{{$announce->id}}" value="{{$announce->status}}" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                {{ $announce_list_with_paging->links('pagination.default') }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="AnnouncementSortingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="AnnouncementSortingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div id="announce-list-sorting"></div>
                <div class="modal-footer">
                    <button class="cux-btn bigger" onclick="parent.openPgInFrame('{{route('settings.announce')}}')" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addNewAnnouncement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addNewAnnouncementLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="frmAddNewAnnouncement" action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tarikh Mula</label>
                                    <div class="input-group date" id="start_dt">
                                        <input name="start_dt" id="startDtInput"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-date-start-date="{{\Carbon\Carbon::now()->format('d/m/Y')}}"
                                        data-provide="datepicker" data-date-autoclose="true"
                                        data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                        value="{{\Carbon\Carbon::now()->format('d/m/Y')}}"/>

                                        <div class="input-group-text" for="startDtInput">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <div class="has-error"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tarikh Tamat</label>
                                    <div class="input-group date" id="end_dt">
                                        <input name="end_dt" id="endDtInput"
                                        type="text" class="form-control datepicker" placeholder=""
                                        autocomplete="off"
                                        data-provide="datepicker"
                                        data-date-start-date="{{\Carbon\Carbon::now()->format('d/m/Y')}}"
                                        data-date-autoclose="true"
                                        data-date-format="dd/mm/yyyy" data-date-today-highlight="true"
                                        value=""/>

                                        <div class="input-group-text" for="endDtInput">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <div class="has-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_bm">Jenis Pengunguman <em class="text-danger">*</em></label>
                                    <select class="form-control" name="type_announce_id" id="type_announce_id">
                                        <option value="">Sila Pilih</option>
                                        @foreach ($type_announce_list as $type_announce)
                                            <option value="{{$type_announce->id}}">{{$type_announce->desc}}</option>
                                        @endforeach
                                    </select>
                                    <div class="has-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_bm">Tajuk Dalam Bahasa Melayu <em class="text-danger">*</em></label>
                                    <input type="text" id="title_bm" name="title_bm" class="form-control" value="">
                                    <div class="has-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_en">Tajuk Dalam Bahasa Inggeris</label>
                                    <input type="text" id="title_en" name="title_en" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc_en">Penerangan Dalam Bahasa Melayu 1 <em class="text-danger">*</em></label>
                                    <textarea style="resize: none;" class="form-control" name="desc_bm_1" id="desc_bm_1" cols="30" rows="3"></textarea>
                                    <div class="has-error"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc_en">Penerangan Dalam Bahasa Melayu 2</label>
                                    <textarea style="resize: none;" class="form-control" name="desc_bm_2" id="desc_bm_2" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc_en">Penerangan Dalam Bahasa Inggeris 1</label>
                                    <textarea style="resize: none;" class="form-control" name="desc_en_1" id="desc_en_1" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc_en">Penerangan Dalam Bahasa Inggeris 2</label>
                                    <textarea style="resize: none;" class="form-control" name="desc_en_2" id="desc_en_2" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cux-btn bigger" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="cux-btn bigger" >Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script src="{{asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script>

        function updateToDatabase(idString){
    	   $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

    	   $.ajax({
              url:'{{route('settings.announce.update.sorting')}}',
              method:'POST',
              data:{ids:idString},
              success:function(){
               	 //do whatever after success
              }
           })
    	}

        function getList(){
            $.post("{{route('settings.announce.list')}}", {
                '_token': "{{csrf_token()}}"
            }, function(res){
                $('#announce-list-sorting').html(res);
                var target = $('.sort_menu');
                target.sortable({
                    handle: '.handle',
                    placeholder: 'highlight',
                    axis: "y",
                    update: function (e, ui){
                    var sortData = target.sortable('toArray',{ attribute: 'data-id'})
                    updateToDatabase(sortData.join(','))
                    }
                })
            });
        }

        function previewAnnouncement(){
            $.post("{{route('settings.announce.preview')}}", {
                '_token': "{{csrf_token()}}"
            }, function(res){
                $('#preview-announcement').html(res);
                $('#announcementIndicators').carousel({
                    interval: 3000,
                    cycle: true
                });
            });
        }

        function setActive(id, status){
            $.post("{{route('settings.announce.set.active')}}", {
                'id': id,
                'status': status,
                '_token': "{{csrf_token()}}"
            }).done(function(){
                previewAnnouncement();
            });
        }

        function clearForm(target){
            $('.has-error').html('');
            $(target)[0].reset();
            setSessionID('');
            $('#type_announce_id').val(null).select2(
                {
                    width: '100%',
                    theme: "classic",
                    dropdownParent: $("#addNewAnnouncement")
                }
            );
        }

        function setSessionID(id){
            $.post("{{route('settings.announce.set.sessionID')}}", {
                'id': id,
                '_token': "{{csrf_token()}}"
            });
        }

        function initEditData(self, target){

            let selfData = JSON.parse($(self).attr('data-self'));
            let form = $(target).find('form');

            setSessionID(selfData['id']);
            $('#type_announce_id').val(selfData['type_announce_id']).select2(
                {
                    width: '100%',
                    theme: "classic",
                    dropdownParent: $("#addNewAnnouncement")
                }
            );

            form.find('#startDtInput').val(moment(selfData['start_dt']).format('D/MM/YYYY'));
            if(selfData['end_dt']){
                form.find('#endDtInput').val(moment(selfData['end_dt']).format('D/MM/YYYY'));
            }


            form.find('#title_bm').val(selfData['title_bm']);
            form.find('#title_en').val(selfData['title_en']);

            form.find('#desc_bm_1').val(selfData['desc_bm_1']);
            form.find('#desc_bm_2').val(selfData['desc_bm_2']);

            form.find('#desc_en_1').val(selfData['desc_en_1']);
            form.find('#desc_en_2').val(selfData['desc_en_2']);

            console.log(selfData['title_bm']);
            console.log('form', form);

        }

        function submitData(formData){

            $('.has-error').html('');
            $.ajax({
                url: "{{route('settings.announce.save')}}",
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                async: false,
                data: formData,
                success: function(response) {
                    parent.openPgInFrame('{{route('settings.announce')}}');
                },
                error: function(response) {
                    console.log("false");
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {

                        let hasRegexDt = RegExp("dt(h?)$");

                        if(hasRegexDt.test(key)){
                            if($('[name="'+key+'"]').parent().find('.has-error.text-danger').length == 0){
                                $('[name="'+key+'"]').parent().find('.has-error').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        } else {
                            console.log($('[name="'+key+'"]').parent().find('.has-error').length);
                            if($('[name="'+key+'"]').parent().find('.has-error.text-danger').length == 0){
                                $('[name="'+key+'"]').parent().find('.has-error').append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        }
                    });

                    show('#frmAddNewAnnouncement [type="submit"]');

                }
            });
        }

        $(document).ready(function() {

            previewAnnouncement();

            $('#type_announce_id').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#addNewAnnouncement")
            });

            $('#frmAddNewAnnouncement').on('submit', function(e){
                e.preventDefault();

                let formData = new FormData(this);
                submitData(formData);
            })

        });

    </script>
</body>

</html>
