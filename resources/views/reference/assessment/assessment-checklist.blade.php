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
                            <button class="btn cux-btn small" onclick="modalActionCategory(this, 'insert')"
                                data-bs-toggle="modal" data-bs-target="#categoryModal" type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-plus"></i></button>
                        </div>
                    </th>
                    <th style="width: 40px">Kod</th>
                    <th class="cfoc">Nama</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($component as $category)
                    <tr id="category_id_{{$category->id}}">
                        <td style="width: 80px;">
                            <div class="btn-group">
                                <span class="btn cux-btn small" onclick="modalActionCategory(this, 'update')"
                                data-id="{{ $category->id }}" data-code="{{ $category->code }}"
                                data-name="{{ $category->component }}" data-bs-toggle="modal"
                                data-bs-target="#categoryModal"><i
                                        class="fal fa-edit"></i></span>
                                <span onclick="deleteItemCategory({{$category->id}})" class="btn cux-btn small" xaction="delete_selected_category" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                        <td style="width: 40px">{{$category->code}}</td>
                        <td class="cfoc key"><a href="#" onclick="modalActionCategory(this, 'update')" data-id="{{$category->id}}" data-code="{{$category->code}}" data-name="{{$category->component}}" data-bs-toggle="modal" data-bs-target="#categoryModal" data-toggle="popover" data-trigger="focus" data-placement="top">{{$category->component}}</a></td>
                        <td style="width: 30px" class="text-end" onclick="displaySubCategory(this, {{$category->id}}, '{{$category->code}}', '{{$category->component}}')"><i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                    </tr>
                    <tr xcategorylist="category_id_{{$category->id}}_sub_category" id="sub_category" class="" style="display: none;"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="col-md-4 ps-3 pe-3" id="sub_category" style="display: none;"></div> --}}
    <div class="col-md-4 ps-3 pe-3" id="sub_category_type" style="display: none;"></div>
</form>

<div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <input type="hidden" id="category-id" name="category-id" value="">
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
                        <label for="category-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="category-code" name="category-code" readonly disabled value="{{$code}}">
                    </div>
                    <div class="col-8">
                        <label for="category-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="category-name" name="category-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close_category" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_category" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="subCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="subCategoryModalLabel" aria-hidden="true">
    <input type="hidden" id="category-id" name="category-id" value="">
    <input type="hidden" id="subcategory-id" name="subcategory-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Sub-Kategori</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Kategori</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="categoryCode" class="form-label">Kod Kategori</label>
                        <div id="categoryCode"></div>
                    </div>
                    <div class="col-8">
                        <label for="categoryName" class="form-label">Nama Kategori</label>
                        <div id="categoryName"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="subcategory-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="subcategory-code" name="subcategory-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="subcategory-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="subcategory-name" name="subcategory-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close_subcategory" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_subcategory()" xaction="save_subcategory" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="subCategoryTypeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="subCategoryTypeModalLabel" aria-hidden="true">
    <input type="hidden" id="subcategory-id" name="subcategory-id" value="">
    <input type="hidden" id="subcategorytype-id" name="subcategorytype-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Jenis</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Sub-Kategori</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="subCategoryCode" class="form-label">Kod Sub-Kategori</label>
                        <div id="subCategoryCode"></div>
                    </div>
                    <div class="col-8">
                        <label for="subCategoryName" class="form-label">Nama Sub-Kategori</label>
                        <div id="subCategoryName"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="subcategorytype-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="subcategorytype-code" name="subcategorytype-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="subcategorytype-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="subcategorytype-name" name="subcategorytype-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close_subcategorytype" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_subcategorytype()" xaction="save_subcategorytype" >Simpan</span>
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

    var  category_ids = [];
    var  subcategory_ids = [];
    var  subcategorytype_ids = [];

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
        parent.openPgInFrame("{{route('reference.vehicle-category')}}");
    }

    function modalActionCategory(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_category"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#category-code').val("{{$code}}");
                $(modalTarget).find('#category-name').val("");

                var subCategoryCode = $('#current-subcategory-code').val();
                $('[name="subcategory-code"]').val(subCategoryCode);
                break;
            case 'update':
                $(modalTarget).find('#category-id').val(id);
                $(modalTarget).find('#category-code').val(code);
                $(modalTarget).find('#category-name').val(name);
                break;
        }
    }

    function modalActionSubCategory(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_subcategory"]');
        hide('#subCategoryModal #message-container')

        switch (mode) {
            case 'insert':
                var subCategoryCode = $('#current-subcategory-code').val();
                $('[name="subcategory-code"]').val(subCategoryCode);
                show('[xaction="save_subcategory"]');
                break;
            case 'update':
                $(modalTarget).find('#subcategory-id').val(id);
                $(modalTarget).find('#subcategory-code').val(code);
                $(modalTarget).find('#subcategory-name').val(name);
                break;
        }
    }

    function modalActionSubCategoryType(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_subcategorytype"]');

        switch (mode) {
            case 'insert':
                var subCategoryTypeCode = $('#current-subcategorytype-code').val();
                $('[name="subcategorytype-code"]').val(subCategoryTypeCode);
                show('[xaction="save_subcategorytype"]');
                break;
            case 'update':
                $(modalTarget).find('#subcategorytype-id').val(id);
                $(modalTarget).find('#subcategorytype-code').val(code);
                $(modalTarget).find('#subcategorytype-name').val(name);
                break;
        }
    }

    function getComponentLvl2(category_id){

        $('#sub_category_type').hide();

        $.ajax({
            url: "{{route('reference.getComponentLvl2')}}",
            data: {
                category_id: category_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('[xcategorylist="category_id_'+category_id+'_sub_category"]').html(result);
                $('[xcategorylist="category_id_'+category_id+'_sub_category"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function getSubCategoryType(sub_category_id){
        $('#sub_category_type').hide();
        $.ajax({
            url: "{{route('reference.getComponentLvl3')}}",
            data: {
                sub_category_id: sub_category_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('#sub_category_type').html(result);
                $('[xsubcategorylist="subcategory_id_'+sub_category_id+'_sub_category_type"]').html(result);
                $('[xsubcategorylist="subcategory_id_'+sub_category_id+'_sub_category_type"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function displaySubCategory(self, category_id, category_code, category_name){

        $('[xcategorylist]').slideUp('fast');
        $('[xcategorylist]').html('');

        $('#subCategoryModal #category-id').val(category_id);
        $('#categoryCode').text(category_code);
        $('#categoryName').text(category_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('#category').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getComponentLvl2(category_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
            $('#sub_category_type').slideUp('fast');
        }
    }

    function displaySubCategoryType(self, category_id, sub_category_id, sub_category_code, sub_category_name){

        $('[xsubcategorylist]').slideUp('fast');
        $('[xsubcategorylist]').html('');

        $('#subCategoryTypeModal #subcategory-id').val(sub_category_id);
        $('#subCategoryCode').text(sub_category_code);
        $('#subCategoryName').text(sub_category_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('[xcategorylist="category_id_'+category_id+'_sub_category"]').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');
            getSubCategoryType(sub_category_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
            $('#sub_category_type').slideUp('fast');
        }
    }

    function categoryAction(action, name, id){
        hide('[xaction="save_category"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.vehicle.component.action')}}", {
            '_token':crf,
            'name':name,
            'id':id,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_category"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="category-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="category-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_category"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function subCategoryAction(action, category_id, id, name){

        hide('[xaction="save_subcategory"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.vehicle.subCategory.action')}}", {
            '_token':crf,
            'category_id': category_id,
            'id': id,
            'name':name,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#subCategoryModal #message-container #result').text(result.message);
            $('#subCategoryModal #message-container').show();
            getComponentLvl2(category_id);
            $('[xcategorylist="category_id_'+category_id+'_sub_category"]').slideDown('fast');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="subcategory-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="subcategory-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_subcategory"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function subCategoryTypeAction(action, sub_category_id, id, name){

        hide('[xaction="save_subcategorytype"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.vehicle.subCategoryType.action')}}", {
            '_token':crf,
            'sub_category_id': sub_category_id,
            'id': id,
            'name':name,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#subCategoryTypeModal #message-container #result').text(result.message);
            $('#subCategoryTypeModal #message-container').show();
            getSubCategoryType(sub_category_id);
            $('[xsubcategorylist="subcategory_id_'+sub_category_id+'_sub_category_type"]').slideDown('fast');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="subcategorytype-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="subcategorytype-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_subcategorytype"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });

    }

    function deleteCategory(){
        $('input[name="chk_category"]:checked').map(function () {
             category_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.vehicle.category.action')}}", {
            'category_ids': category_ids,
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

    function deleteSubCategory(){

        let category_id = $('#subCategoryModal #category-id').val();

        $('input[name="chk_subcategory"]:checked').map(function () {
             subcategory_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.vehicle.subCategory.action')}}", {
            'subcategory_ids': subcategory_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                getComponentLvl2(category_id);
                $('[xcategorylist="category_id_'+category_id+'_sub_category"]').slideDown('fast');
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteSubCategoryType(){

        let sub_category_id = $('#subCategoryTypeModal #subcategory-id').val();

        $('input[name="chk_subcategorytype"]:checked').map(function () {
            subcategorytype_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.vehicle.subCategoryType.action')}}", {
            'subcategorytype_ids': subcategorytype_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                getSubCategoryType(sub_category_id);
                $('[xsubcategorylist="subcategory_id_'+sub_category_id+'_sub_category_type"]').slideDown('fast');
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteItemCategory(id){
        category_ids = [id];
    }

    function initFuncCategory(){
        // Start init Category

        $('#chkall_category').change(function() {
             category_ids = [];

            $('[name="chk_category"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_category"]:checked').map(function () {
                 category_ids.push(parseInt(this.value));
            } );

            if( category_ids.length > 0){
                $('[xaction="delete_selected_category"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_category"]').prop('disabled', true);
            }
        });

        $('[name="chk_category"]').change(function() {

            category_ids = [];

            $('input[name="chk_category"]:checked').map(function () {
                 category_ids.push(parseInt(this.value));
            } );

            if( category_ids.length > 0){
                $('[xaction="delete_selected_category"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_category"]').prop('disabled', true);
            }

        });

        $('[xaction="save_category"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="category-id"]').val();
            let name = $('[name="category-name"]').val();
            let action =  $('#categoryModal').find('#action').val();
            categoryAction(action, name, id);
        });

        $('[xaction="delete_selected_category"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('category');
        });

        // End init Category
    }

    jQuery(document).ready(function() {
        initFuncCategory();

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteFor = $('#deleteModal #delete_for').val();
            switch (deleteFor) {
                case 'category':
                    deleteCategory();
                    break;
                case 'subcategory':
                    deleteSubCategory();
                    break;
                case 'subcategorytype':
                    deleteSubCategoryType();
                    break;
            }
        });
    });
</script>
</body>
</html>


