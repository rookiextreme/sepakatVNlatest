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
<div class="mytitle">Agensi</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Daftar Rujukan </a></li>
      <li class="breadcrumb-item active" aria-current="page">Agensi</li>
    </ol>
</nav>
<hr/>
<div class="main-content">
<form class="form-submit row" id="the_form">
    <div class="col-md-12 ps-3 pe-3" id="sector">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th class="del" style="width: 80px">
                        <div class="btn-group">
                            <button class="btn cux-btn small" onclick="modalActionSector(this, 'insert')"
                                data-bs-toggle="modal" data-bs-target="#sectorModal" type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-plus"></i></button>
                        </div>
                    </th>
                    <th>Sektor</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($sectors as $sector)
                    <tr id="sector_id_{{$sector->id}}">
                        <td style="width: 80px;">
                            <div class="btn-group">
                                <span class="btn cux-btn small" onclick="modalActionSector(this, 'update')"
                                data-id="{{ $sector->id }}" data-code="{{ $sector->code }}"
                                data-name="{{ $sector->desc }}" data-bs-toggle="modal"
                                data-bs-target="#sectorModal"><i
                                        class="fal fa-edit"></i></span>
                                <span onclick="deleteItemSector({{$sector->id}})" class="btn cux-btn small" xaction="delete_selected_sector" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                        <td style="width: 40px">{{$sector->code}}</td>
                        <td class="cfoc key"><a href="#" onclick="modalActionSector(this, 'update')" data-id="{{$sector->id}}" data-code="{{$sector->code}}" data-name="{{$sector->desc}}" data-bs-toggle="modal" data-bs-target="#sectorModal" data-toggle="popover" data-trigger="focus" data-placement="top">{{$sector->desc}}</a></td>
                        <td style="width: 30px" class="text-end" onclick="displayBranch(this, {{$sector->id}}, '{{$sector->code}}', '{{$sector->desc}}')"><i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                    </tr>
                    <tr xbranchlist="sector_id_{{$sector->id}}_branch" id="branch" class="" style="display: none;"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>

<div class="modal fade" id="sectorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sectorModalLabel" aria-hidden="true">
    <input type="hidden" id="sector-id" name="sector-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Sektor</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="sector-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="sector-code" name="sector-code" readonly disabled value="{{$code}}">
                    </div>
                    <div class="col-8">
                        <label for="sector-name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="sector-name" name="sector-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_sector" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_sector" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="branchModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="branchModalLabel" aria-hidden="true">
    <input type="hidden" id="sector-id" name="sector-id" value="">
    <input type="hidden" id="branch-id" name="branch-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Cawangan</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Sektor</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="sectorCode" class="form-label">Kod Sektor</label>
                        <div id="sectorCode"></div>
                    </div>
                    <div class="col-8">
                        <label for="sectorName" class="form-label">Nama Sektor</label>
                        <div id="sectorName"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="branch-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="branch-code" name="branch-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="branch-desc" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="branch-desc" name="branch-desc">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_branch" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_branch()" xaction="save_branch" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="divisionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="divisionModalLabel" aria-hidden="true">
    <input type="hidden" id="branch-id" name="branch-id" value="">
    <input type="hidden" id="division-id" name="division-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Bahagian</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Cawangan</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="branchCode" class="form-label">Kod Cawangan</label>
                        <div id="branchCode"></div>
                    </div>
                    <div class="col-8">
                        <label for="branchName" class="form-label">Nama Cawangan</label>
                        <div id="branchName"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="division-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="division-code" name="division-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="division-desc" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="division-desc" name="division-desc">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_subcategorytype" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_division()" xaction="save_division" >Simpan</span>
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

    var  sector_ids = [];
    var  branch_ids = [];
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
        parent.openPgInFrame("{{route('reference.agency')}}");
    }

    function modalActionSector(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_sector"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#sector-code').val("{{$code}}");
                $(modalTarget).find('#sector-name').val("");

                var branchCode = $('#current-branch-code').val();
                $('[name="branch-code"]').val(branchCode);
                break;
            case 'update':
                $(modalTarget).find('#sector-id').val(id);
                $(modalTarget).find('#sector-code').val(code);
                $(modalTarget).find('#sector-name').val(name);
                break;
        }
    }

    function getBranch(sector_id){

        $('#division').hide();

        $.ajax({
            url: "{{route('reference.getBranch')}}",
            data: {
                sector_id: sector_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                console.log('[xbranchlist="sector_id_'+sector_id+'_branch"]');
                $('[xbranchlist="sector_id_'+sector_id+'_branch"]').html(result);
                $('[xbranchlist="sector_id_'+sector_id+'_branch"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function displayBranch(self, sector_id, sector_code, sector_name){

        $('[xbranchlist]').slideUp('fast');
        $('[xbranchlist]').html('');

        $('#branchModal #sector-id').val(sector_id);
        $('#sectorCode').text(sector_code);
        $('#sectorName').text(sector_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('#sector').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getBranch(sector_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
        }
    }

    function sectorAction(action, desc, id){

        hide('[xaction="save_sector"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.sector.action')}}", {
            '_token':crf,
            'desc':desc,
            'id':id,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_sector"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="sector-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="sector-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_sector"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function deleteSector(){
        $('input[name="chk_sector"]:checked').map(function () {
             sector_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.sector.action')}}", {
            'sector_ids': sector_ids,
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

    function deleteItemSector(id){
        sector_ids = [id];
    }

    function initFuncSector(){
        // Start init Sector

        $('#chkall_sector').change(function() {
             sector_ids = [];

            $('[name="chk_sector"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_sector"]:checked').map(function () {
                 sector_ids.push(parseInt(this.value));
            } );

            if( sector_ids.length > 0){
                $('[xaction="delete_selected_sector"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_sector"]').prop('disabled', true);
            }
        });

        $('[name="chk_sector"]').change(function() {

            sector_ids = [];

            $('input[name="chk_sector"]:checked').map(function () {
                 sector_ids.push(parseInt(this.value));
            } );

            if( sector_ids.length > 0){
                $('[xaction="delete_selected_sector"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_sector"]').prop('disabled', true);
            }

        });

        $('[xaction="save_sector"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="sector-id"]').val();
            let desc = $('[name="sector-name"]').val();
            let action =  $('#sectorModal').find('#action').val();
            sectorAction(action, desc, id);
        });

        $('[xaction="delete_selected_sector"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('sector');
        });

        // End init Sector
    }

    jQuery(document).ready(function() {
        initFuncSector();

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteFor = $('#deleteModal #delete_for').val();
            switch (deleteFor) {
                case 'sector':
                    deleteSector();
                    break;
                case 'branch':
                    deleteBranch();
                    break;
                case 'division':
                    deleteDivision();
                    break;
            }
        });
    });
</script>
</body>
</html>