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
<div class="mytitle">Komponen Kenderaan</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Daftar Rujukan </a></li>
      <li class="breadcrumb-item active" aria-current="page">Komponen Kenderaan</li>
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
                            <button class="btn cux-btn small" onclick="modalActionLvl1(this, 'insert')"
                                data-bs-toggle="modal" data-bs-target="#lvl1Modal" type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-plus"></i></button>
                        </div>
                    </th>
                    <th style="width: 40px">Kod</th>
                    <th class="cfoc">Nama</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($component as $lvl1)
                    <tr id="lvl1_{{$lvl1->id}}">
                        <td style="width: 80px;">
                            <div class="btn-group">
                                <span class="btn cux-btn small" onclick="modalActionLvl1(this, 'update')"
                                data-id="{{ $lvl1->id }}" data-code="{{ $lvl1->code }}"
                                data-name="{{ $lvl1->component }}" data-bs-toggle="modal"
                                data-bs-target="#lvl1Modal"><i
                                        class="fal fa-edit"></i></span>
                                <span onclick="deleteItemVehicleComponent({{$lvl1->id}})" class="btn cux-btn small" xaction="delete_selected_lvl1" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                        <td style="width: 40px">{{$lvl1->code}}</td>
                        <td class="cfoc key"><a href="#" onclick="modalActionLvl1(this, 'update')" data-id="{{$lvl1->id}}" data-code="{{$lvl1->code}}" data-name="{{$lvl1->component}}" data-bs-toggle="modal" data-bs-target="#lvl1Modal" data-toggle="popover" data-trigger="focus" data-placement="top">{{$lvl1->component}}</a></td>
                        <td style="width: 30px" class="text-end" onclick="displayLvl2(this, {{$lvl1->id}}, '{{$lvl1->code}}', '{{$lvl1->component}}')"><i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                    </tr>
                    <tr xlvl1list="lvl1_{{$lvl1->id}}_lvl2" id="sub_category" class="" style="display: none;"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="col-md-4 ps-3 pe-3" id="sub_category" style="display: none;"></div> --}}
    <div class="col-md-4 ps-3 pe-3" id="lvl3" style="display: none;"></div>
</form>

<div class="modal fade" id="lvl1Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="lvl1ModalLabel" aria-hidden="true">
    <input type="hidden" id="lvl1-id" name="lvl1-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Komponen</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="lvl1-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="lvl1-code" name="lvl1-code" readonly disabled value="{{$code}}">
                    </div>
                    <div class="col-8">
                        <label for="lvl1-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="lvl1-name" name="lvl1-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_lvl1" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_lvl1" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="lvl2Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="lvl2ModalLabel" aria-hidden="true">
    <input type="hidden" id="lvl1-id" name="lvl1-id" value="">
    <input type="hidden" id="lvl2-id" name="lvl2-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Lvl 2</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Lvl 1</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="lvl1Code" class="form-label">Kod Lvl 1</label>
                        <div id="lvl1Code"></div>
                    </div>
                    <div class="col-8">
                        <label for="lvl1Name" class="form-label">Nama Lvl 1</label>
                        <div id="lvl1Name"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="lvl2-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="lvl2-code" name="lvl2-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="lvl2-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="lvl2-name" name="lvl2-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_lvl2" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_lvl2()" xaction="save_lvl2" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="lvl3Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="lvl3ModalLabel" aria-hidden="true">
    <input type="hidden" id="lvl2-id" name="lvl2-id" value="">
    <input type="hidden" id="lvl3-id" name="lvl3-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Lvl 3</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Lvl 2</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="lvl2Code" class="form-label">Kod Lvl 2</label>
                        <div id="lvl2Code"></div>
                    </div>
                    <div class="col-8">
                        <label for="lvl2Name" class="form-label">Nama Lvl 2</label>
                        <div id="lvl2Name"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="lvl3-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="lvl3-code" name="lvl3-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="lvl3-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="lvl3-name" name="lvl3-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_lvl3" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_lvl3()" xaction="save_lvl3" >Simpan</span>
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

    var  comp_ids = [];
    let lvl2_code = null;
    let lvl3_code = null;

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
        parent.openPgInFrame("{{route('reference.vehicle-component')}}");
    }

    function modalActionLvl1(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_lvl1"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#lvl1-code').val("{{$code}}");
                $(modalTarget).find('#lvl1-name').val("");

                var lvl2Code = $('#current-lvl2-code').val();
                $('[name="lvl2-code"]').val(lvl2Code);
                break;
            case 'update':
                $(modalTarget).find('#lvl1-id').val(id);
                $(modalTarget).find('#lvl1-code').val(code);
                $(modalTarget).find('#lvl1-name').val(name);
                break;
        }
    }

    function modalActionLvl2(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_lvl2"]');
        hide('#lvl2Modal #message-container')

        switch (mode) {
            case 'insert':
                $('[name="lvl2-code"]').val(lvl2_code);
                show('[xaction="save_lvl2"]');
                break;
            case 'update':
                $(modalTarget).find('#lvl2-id').val(id);
                $(modalTarget).find('#lvl2-code').val(code);
                $(modalTarget).find('#lvl2-name').val(name);
                break;
        }
    }

    function modalActionLvl3(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_lvl3"]');

        switch (mode) {
            case 'insert':
                $('[name="lvl3-code"]').val(lvl3_code);
                show('[xaction="save_lvl3"]');
                break;
            case 'update':
                $(modalTarget).find('#lvl3-id').val(id);
                $(modalTarget).find('#lvl3-code').val(code);
                $(modalTarget).find('#lvl3-name').val(name);
                break;
        }
    }

    function getComponentLvl2(lvl1_id){

        $('#lvl3').hide();

        $.ajax({
            url: "{{route('reference.getComponentLvl2')}}",
            data: {
                lvl1_id: lvl1_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('[xlvl1list="lvl1_'+lvl1_id+'_lvl2"]').html(result);
                $('[xlvl1list="lvl1_'+lvl1_id+'_lvl2"]').slideDown('fast');
                $('#lvl2-code').val(lvl2_code);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function getComponentLvl3(lvl2_id){
        $('#lvl3').hide();
        $.ajax({
            url: "{{route('reference.getComponentLvl3')}}",
            data: {
                lvl2_id: lvl2_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('#lvl3').html(result);
                $('[xlvl2list="lvl2_id_'+lvl2_id+'_lvl3"]').html(result);
                $('[xlvl2list="lvl2_id_'+lvl2_id+'_lvl3"]').slideDown('fast');
                $('#lvl3-code').val(lvl3_code);
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function displayLvl2(self, lvl1_id, lvl1_code, lvl1_name){

        $('[xlvl1list]').slideUp('fast');
        $('[xlvl1list]').html('');

        $('#lvl2Modal #lvl1-id').val(lvl1_id);
        $('#lvl1Code').text(lvl1_code);
        $('#lvl1Name').text(lvl1_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('#lvl1').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getComponentLvl2(lvl1_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
            $('#lvl3').slideUp('fast');
        }
    }

    function displayLvl3(self, lvl1_id, lvl2_id, lvl2_code, lvl2_name){

        $('[xlvl2list]').slideUp('fast');
        $('[xlvl2list]').html('');

        $('#lvl3Modal #lvl2-id').val(lvl2_id);
        $('#lvl2Code').text(lvl2_code);
        $('#lvl2Name').text(lvl2_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('[xlvl1list="lvl1_'+lvl1_id+'_lvl2"]').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');
            getComponentLvl3(lvl2_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
            $('#lvl3').slideUp('fast');
        }
    }

    function vehicleComponentAction(data){
        let lvl = data.lvl;
        hide('[xaction="save_lvl'+lvl+'"]');

        let crf = "{{ csrf_token() }}";

        data['_token'] = crf;

        $.post("{{route('reference.vehicle.component.action')}}", data).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_lvl'+lvl+'"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="lvl'+lvl+'-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="lvl'+lvl+'-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_lvl'+lvl+'"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteVehicleComponent(lvl){

        $('input[name="chk_lvl'+lvl+'"]:checked').map(function () {
            comp_ids.push(parseInt(this.value));
        });

        let data = {
            'lvl': lvl,
            'action': 'delete',
            '_token':'{{ csrf_token() }}',
            'comp_ids': comp_ids
        };

        $.post("{{route('reference.vehicle.component.action')}}", data).done(function(result) {
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

    function deleteItemVehicleComponent(id){
        comp_ids = [id];
    }

    function initFuncVehicleComponent(){
        // Start init Category

        $('#chkall_lvl1').change(function() {
             comp_ids = [];

            $('[name="chk_lvl1"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_lvl1"]:checked').map(function () {
                 comp_ids.push(parseInt(this.value));
            } );

            if( comp_ids.length > 0){
                $('[xaction="delete_selected_lvl1"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_lvl1"]').prop('disabled', true);
            }
        });

        $('[name="chk_lvl1"]').change(function() {

            comp_ids = [];

            $('input[name="chk_lvl1"]:checked').map(function () {
                 comp_ids.push(parseInt(this.value));
            } );

            if( comp_ids.length > 0){
                $('[xaction="delete_selected_lvl1"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_lvl1"]').prop('disabled', true);
            }

        });

        $('[xaction="save_lvl1"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="lvl1-id"]').val();
            let name = $('[name="lvl1-name"]').val();
            let action =  $('#lvl1Modal').find('#action').val();
            let data = {
                lvl: 1,
                action: action, 
                name: name, 
                id: id
            };
            vehicleComponentAction(data);
        });

        $('[xaction="delete_selected_lvl1"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val(1);
        });

        // End init Category
    }

    jQuery(document).ready(function() {
        initFuncVehicleComponent();

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteForLvl = $('#deleteModal #delete_for').val();
            deleteVehicleComponent(deleteForLvl);
        });
    });
</script>
</body>
</html>


