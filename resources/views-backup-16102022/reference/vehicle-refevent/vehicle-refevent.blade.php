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

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<link href="{{asset('my-assets/plugins/datatables/datatables.css')}}" rel="stylesheet" type="text/css">

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">

<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">


    .cursor-pointer {
        cursor: pointer;
    }

    a {
        font-family: lato;
        color:#718aa6;
        cursor:pointer;
        text-decoration: none;
    }
    a:hover {
        text-decoration: none;
        color:#000000;
    }
    body {
        background-color: #f4f5f2;
    }
    .lcal-2 {
        width:50px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:150px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
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

    /* th{

        vertical-align: middle !important;
        font-family: avenir-bold !important;
        font-size: 12px !important;
        color: #333333 !important;
        background-color: #eaeee7 !important;
    } */

    td{

        vertical-align:middle !important;
        font-size: 12px !important;
    }

    th.select-checkbox{

        width: 3% !important;
        text-align: center !important;
        margin-right: 0px !important;
        padding: 0px !important;
    }

    td.select-checkbox{
        text-align: center !important;
    }

    tbody {
        display: block;
        height: 100%;
        overflow: auto;
    }
    thead, tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;/* even columns width , fix width of table too*/
    }

    #angle {
        cursor: pointer;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
<div class="mytitle">Peristiwa</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Daftar Rujukan </a></li>
      <li class="breadcrumb-item active" aria-current="page">Peristiwa</li>
    </ol>
</nav>
<hr/>
<div class="main-content">
<form class="form-submit row" id="the_form">
    <div class="col-md-6 ps-3 pe-3" id="category">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th class="del" style="width: 80px">
                        <div class="btn-group">
                            <button class="btn cux-btn small" onclick="modalActionRefEvent(this, 'insert')"
                                data-bs-toggle="modal" data-bs-target="#refeventModal" type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-plus"></i></button>
                        </div>
                    </th>
                    <th style="width: 40px">Kod</th>
                    <th class="cfoc">Nama</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($RefEventS as $RefEvent)
                    <tr id="category_id_{{$RefEvent->id}}">
                        <td style="width: 80px;">
                            <div class="btn-group">
                                <span class="btn cux-btn small" onclick="modalActionRefEvent(this, 'update')"
                                data-id="{{ $RefEvent->id }}" data-code="{{ $RefEvent->code }}"
                                data-name="{{ $RefEvent->desc }}" data-bs-toggle="modal"
                                data-bs-target="#refeventModal"><i
                                        class="fal fa-edit"></i></span>
                                <span onclick="deleteItemRefEvent({{$RefEvent->id}})" class="btn cux-btn small" xaction="delete_selected_refevent" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                        <td style="width: 40px">{{$RefEvent->code}}</td>
                        <td class="cfoc key"><a href="#" onclick="modalActionRefEvent(this, 'update')" data-id="{{$RefEvent->id}}" data-code="{{$RefEvent->code}}" data-name="{{$RefEvent->desc}}" data-bs-toggle="modal" data-bs-target="#refeventModal" data-toggle="popover" data-trigger="focus" data-placement="top">{{$RefEvent->desc}}</a></td>
                        <td style="width: 30px" class="text-end" onclick="displaySubCategory(this, {{$RefEvent->id}}, '{{$RefEvent->code}}', '{{$RefEvent->desc}}')"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="col-md-4 ps-3 pe-3" id="sub_category" style="display: none;"></div> --}}
    <div class="col-md-4 ps-3 pe-3" id="sub_category_type" style="display: none;"></div>
</form>

<div class="modal fade" id="refeventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="refeventModalLabel" aria-hidden="true">
    <input type="hidden" id="refevent-id" name="refevent-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Kategori</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="refevent-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="refevent-code" name="refevent-code" readonly disabled value="{{$code}}">
                    </div>
                    <div class="col-8">
                        <label for="refevent-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="refevent-name" name="refevent-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_refevent" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_refevent" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            <div id="message">
                Adakah anda ingin menghapuskan data ini ?
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
            <span class="btn btn-danger" xaction="delete" >Ya</span>
        </div>
    </div>
    </div>
</div>

<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var  refevent_ids = [];

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

    function goTo(url){
        window.location.href = url;
    }

    function reloadPage(){
        parent.openPgInFrame("{{route('reference.vehicle-refevent')}}");
    }

    function modalActionRefEvent(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_refevent"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#refevent-code').val("{{$code}}");
                $(modalTarget).find('#refevent-name').val("");

                var subrRefEventCode = $('#current-subrefevent-code').val();
                $('[name="subrefevent-code"]').val(subrRefEventCode);
                break;
            case 'update':
                $(modalTarget).find('#refevent-id').val(id);
                $(modalTarget).find('#refevent-code').val(code);
                $(modalTarget).find('#refevent-name').val(name);
                break;
        }
    }

    function refeventAction(action, name, id){

        hide('[xaction="save_refevent"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.vehicle.refevent.action')}}", {
            '_token':crf,
            'name':name,
            'id':id,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_refevent"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="refevent-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="refevent-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_refevent"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteRefEvent(){
        $('input[name="chk_refevent"]:checked').map(function () {
             refevent_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.vehicle.refevent.action')}}", {
            'refevent_ids': refevent_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteItemRefEvent(id){
        refevent_ids = [id];
    }

    function initFuncCategory(){
        // Start init Category

        $('#chkall_refevent').change(function() {
             refevent_ids = [];

            $('[name="chk_refevent"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_refevent"]:checked').map(function () {
                 refevent_ids.push(parseInt(this.value));
            } );

            if( refevent_ids.length > 0){
                $('[xaction="delete_selected_refevent"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_refevent"]').prop('disabled', true);
            }
        });

        $('[name="chk_refevent"]').change(function() {

            refevent_ids = [];

            $('input[name="chk_refevent"]:checked').map(function () {
                 refevent_ids.push(parseInt(this.value));
            } );

            if( refevent_ids.length > 0){
                $('[xaction="delete_selected_refevent"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_refevent"]').prop('disabled', true);
            }

        });

        $('[xaction="save_refevent"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="refevent-id"]').val();
            let name = $('[name="refevent-name"]').val();
            let action =  $('#refeventModal').find('#action').val();
            refeventAction(action, name, id);
        });

        $('[xaction="delete_selected_refevent"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('refevent');
        });

        // End init Category
    }

    jQuery(document).ready(function() {
        initFuncCategory();

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteFor = $('#deleteModal #delete_for').val();
            switch (deleteFor) {
                case 'refevent':
                    deleteRefEvent();
                    break;
            }
        });
    });
</script>
</body>
</html>


