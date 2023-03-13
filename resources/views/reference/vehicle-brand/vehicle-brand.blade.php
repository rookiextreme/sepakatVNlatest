@php
    $search = Request('search') ? Request('search') : null;
@endphp
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

    .form-control.search {
        width: 260px;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
<div class="mytitle">Pengeluar Kenderaan</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Daftar Rujukan </a></li>
      <li class="breadcrumb-item active" aria-current="page">Pengeluar Kenderaan</li>
    </ol>
</nav>
<hr/>
<div class="main-content">

    <div class="row">
        <div class="col-md-12">
            <div class="float-end">
                <div class="input-group">
                    <input type="search" onkeyup="searching(this.value)" type="text" class="form-control search" placeholder="Carian Pengeluar Kenderaan" value="{{$search}}">
                    <span class="input-group-text" style="border-width:1px;"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>

<form class="form-submit row" id="the_form">
    <div class="col-md-6 ps-3 pe-3" id="brand">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th class="del" style="width: 80px">
                        <div class="btn-group">
                            <button class="btn cux-btn small" onclick="modalActionBrand(this, 'insert')"
                                data-bs-toggle="modal" data-bs-target="#brandModal" type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-plus"></i></button>
                        </div>
                    </th>
                    <th style="width: 40px">Kod</th>
                    <th class="cfoc">Nama</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($brands as $brand)
                    <tr id="brand_id_{{$brand->id}}">
                        <td style="width: 80px;">
                            <div class="btn-group">
                                <span class="btn cux-btn small" onclick="modalActionBrand(this, 'update')"
                                data-id="{{ $brand->id }}" data-code="{{ $brand->code }}"
                                data-name="{{ $brand->name }}" data-bs-toggle="modal"
                                data-bs-target="#brandModal"><i
                                        class="fal fa-edit"></i></span>
                                <span onclick="deleteItemBrand({{$brand->id}})" class="btn cux-btn small" xaction="delete_selected_brand" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                        <td style="width: 40px">{{$brand->code}}</td>
                        <td class="cfoc key"><a href="#" onclick="modalActionBrand(this, 'update')" data-id="{{$brand->id}}" data-code="{{$brand->code}}" data-name="{{$brand->name}}" data-bs-toggle="modal" data-bs-target="#brandModal" data-toggle="popover" data-trigger="focus" data-placement="top">{{$brand->name}}</a></td>
                        <td style="width: 30px" class="text-end" onclick="displayModel(this, {{$brand->id}}, '{{$brand->code}}', '{{$brand->name}}')"><i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                    </tr>
                    <tr xbrandlist="brand_id_{{$brand->id}}_model" id="model" class="" style="display: none;"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="col-md-4 ps-3 pe-3" id="model" style="display: none;"></div> --}}
    <div class="col-md-4 ps-3 pe-3" id="model" style="display: none;"></div>
</form>

<div class="modal fade" id="brandModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
    <input type="hidden" id="brand-id" name="brand-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Pengeluar Kenderaan</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="brand-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="brand-code" name="brand-code" readonly disabled value="">
                    </div>
                    <div class="col-8">
                        <label for="brand-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="brand-name" name="brand-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close_brand" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_brand" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="modelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modelModalLabel" aria-hidden="true">
    <input type="hidden" id="brand-id" name="brand-id" value="">
    <input type="hidden" id="model-id" name="model-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Model</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Pengeluar</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="brandCode" class="form-label">Kod Pengeluar</label>
                        <div id="brandCode"></div>
                    </div>
                    <div class="col-8">
                        <label for="brandName" class="form-label">Nama Pengeluar</label>
                        <div id="brandName"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="model-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="model-code" name="model-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="model-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="model-name" name="model-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close_model" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_model()" xaction="save_model" >Simpan</span>
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
        <div class="modal-footer float-start">
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

    function searching(value){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode ==  13 || !value){
            parent.openPgInFrame("{{route('reference.vehicle-brand')}}?search="+value);
        }
    }

    var  brand_ids = [];
    var  model_ids = [];

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
        parent.openPgInFrame("{{route('reference.vehicle-brand')}}");
    }

    function deleteItemBrand(id){
        brand_ids = [id];
    }

    function modalActionBrand(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_brand"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#brand-code').val("{{$code}}");
                $(modalTarget).find('#brand-name').val("");

                var subbrandCode = $('#current-model-code').val();
                $('[name="model-code"]').val(subbrandCode);
                break;
            case 'update':
                $(modalTarget).find('#brand-id').val(id);
                $(modalTarget).find('#brand-code').val(code);
                $(modalTarget).find('#brand-name').val(name);
                break;
        }
    }

    function modalActionModel(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_model"]');
        hide('#modelModal #message-container')

        switch (mode) {
            case 'insert':
                var subbrandCode = $('#current-model-code').val();
                $('[name="model-code"]').val(subbrandCode);
                show('[xaction="save_model"]');
                break;
            case 'update':
                $(modalTarget).find('#model-id').val(id);
                $(modalTarget).find('#model-code').val(code);
                $(modalTarget).find('#model-name').val(name);
                break;
        }
    }

    function getModel(brand_id){

        $('#model').hide();

        $.ajax({
            url: "{{route('reference.getModel')}}",
            data: {
                brand_id: brand_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('[xbrandlist="brand_id_'+brand_id+'_model"]').html(result);
                $('[xbrandlist="brand_id_'+brand_id+'_model"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function brandAction(action, name, id){

        hide('[xaction="save_brand"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.vehicle.brand.action')}}", {
            '_token':crf,
            'name':name,
            'id':id,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_brand"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="brand-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="brand-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_brand"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function modelAction(action, brand_id, id, name){

        hide('[xaction="save_model"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.vehicle.model.action')}}", {
            '_token':crf,
            'brand_id': brand_id,
            'id': id,
            'name':name,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#modelModal #message-container #result').text(result.message);
            $('#modelModal #message-container').show();
            getModel(brand_id);
            $('[xbrandlist="brand_id_'+brand_id+'_model"]').slideDown('fast');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="model-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="model-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_model"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function displayModel(self, brand_id, brand_code, brand_name){

        $('[xbrandlist]').slideUp('fast');
        $('[xbrandlist]').html('');

        $('#modelModal #brand-id').val(brand_id);
        $('#brandCode').text(brand_code);
        $('#brandName').text(brand_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('#brand').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getModel(brand_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
            $('#model').slideUp('fast');
        }
    }

    function deleteBrand(){
        $('input[name="chk_brand"]:checked').map(function () {
            brand_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.vehicle.brand.action')}}", {
            'brand_ids': brand_ids,
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

    function deleteModel(){

        let brand_id = $('#modelModal #brand-id').val();

        $('input[name="chk_model"]:checked').map(function () {
            model_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.vehicle.model.action')}}", {
            'model_ids': model_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                getModel(brand_id);
                $('[xbrandlist="brand_id_'+brand_id+'_model"]').slideDown('fast');
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function initFuncBrand(){
        // Start init brand

        $('#chkall_brand').change(function() {
             brand_ids = [];

            $('[name="chk_brand"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_brand"]:checked').map(function () {
                 brand_ids.push(parseInt(this.value));
            } );

            if( brand_ids.length > 0){
                $('[xaction="delete_selected_brand"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_brand"]').prop('disabled', true);
            }
        });

        $('[name="chk_brand"]').change(function() {

            brand_ids = [];

            $('input[name="chk_brand"]:checked').map(function () {
                 brand_ids.push(parseInt(this.value));
            } );

            if( brand_ids.length > 0){
                $('[xaction="delete_selected_brand"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_brand"]').prop('disabled', true);
            }

        });

        $('[xaction="save_brand"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="brand-id"]').val();
            let name = $('[name="brand-name"]').val();
            let action =  $('#brandModal').find('#action').val();
            brandAction(action, name, id);
        });

        $('[xaction="delete_selected_brand"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('brand');
        });

        // End init brand
    }

    jQuery(document).ready(function() {
        initFuncBrand();

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteFor = $('#deleteModal #delete_for').val();
            switch (deleteFor) {
                case 'brand':
                    deleteBrand();
                    break;
                case 'model':
                    deleteModel();
                    break;
            }
        });
    });
</script>
</body>
</html>


