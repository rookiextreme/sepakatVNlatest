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
<div class="mytitle">Lokasi Penempatan</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Daftar Rujukan </a></li>
      <li class="breadcrumb-item active" aria-current="page">Lokasi Penempatan</li>
    </ol>
</nav>
<hr/>
<div class="main-content">
<form class="form-submit row" id="the_form">
    <div class="col-md-6 ps-3 pe-3" id="placement">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th class="del" style="width: 80px">
                        <div class="btn-group">
                            <button class="btn cux-btn small" onclick="modalActionPlacement(this, 'insert')"
                                data-bs-toggle="modal" data-bs-target="#placementModal" type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-plus"></i></button>
                        </div>
                    </th>
                    <th style="width: 40px">Kod</th>
                    <th class="cfoc">Negeri</th>

                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($states as $state)
                    <tr id="placement_id_{{$state->id}}">
                        <td style="width: 80px;">
                            <div class="btn-group">
                                <span class="btn cux-btn small" onclick="modalActionPlacement(this, 'update')"
                                data-id="{{ $state->id }}" data-code="{{ $state->code }}"
                                data-name="{{$state->desc }}" data-bs-toggle="modal"
                                data-bs-target="#placementModal"><i
                                        class="fal fa-edit"></i></span>
                                <span onclick="deleteItemPlacement({{$state->id}})" class="btn cux-btn small" xaction="delete_selected_placement" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                                data-trigger="focus" data-placement="top" data-content="Some info"><i
                                    class="fal fa-trash-alt"></i></span>
                            </div>
                        </td>
                        <td style="width: 40px">{{$state->code}}</td>
                        <td class="cfoc key"><a href="#" onclick="modalActionPlacement(this, 'update')" data-id="{{$state->id}}" data-code="{{$state->code}}" data-name="{{$state->desc}}" data-bs-toggle="modal" data-bs-target="#placementModal" data-toggle="popover" data-trigger="focus" data-placement="top">{{$state->desc}}</a></td>
                        <td class="text-end" onclick="displayLocation(this, {{$state->id}}, '{{$state->code}}', '{{$state->desc}}')"><i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                    </tr>
                    <tr xplacementlist="placement_id_{{$state->id}}_location" id="sublocation" class="" style="display: none;"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-4 ps-3 pe-3" id="location" style="display: none;"></div>
</form>

<div class="modal fade" id="placementModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="placementModalLabel" aria-hidden="true">
    <input type="hidden" id="placement-id" name="placement-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Lokasi Penempatan</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="placement-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="placement-code" name="placement-code" readonly disabled value="">
                    </div>
                    <div class="col-8">
                        <label for="" class="form-label text-dark">Negeri</label>
                        <input type="text" class="form-control" id="placement-name" name="placement-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_placement" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="save_placement" >Simpan</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="sublocationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sublocationModalLabel" aria-hidden="true">
    <input type="hidden" id="placement-id" name="placement-id" value="">
    <input type="hidden" id="sublocation-id" name="sublocation-id" value="">
    <input type="hidden" id="action" name="action" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">Lokasi</div>
        <div class="modal-body">
            <div class="form-group" id="message-container" style="display: none">
                <div class="text-success text-center" id="result">
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="">Negeri</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label for="placementCode" class="form-label">Kod Negeri</label>
                        <div id="placementCode"></div>
                    </div>
                    <div class="col-8">
                        <label for="placementName" class="form-label">Negeri</label>
                        <div id="placementName"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label for="sublocation-code" class="form-label">Kod</label>
                        <input type="text" class="form-control" id="sublocation-code" name="sublocation-code" readonly disabled>
                    </div>
                    <div class="col-8">
                        <label for="sublocation-name" class="form-label">Nama Lokasi</label>
                        <input type="text" class="form-control" id="sublocation-name" name="sublocation-name">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close_sublocation" data-bs-dismiss="modal">Batal</span>
            <span class="btn btn-module" xaction="reload_page" onclick="reloadPage()" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" onclick="save_sublocation()" xaction="save_sublocation" >Simpan</span>
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

    var  placement_ids = [];

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
        parent.openPgInFrame("{{route('reference.placement-location')}}");
    }

    function modalActionPlacement(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_placement"]');

        switch (mode) {
            case 'insert':
                $(modalTarget).find('#placement-code').val("{{$code}}");
                $(modalTarget).find('#placement-name').val("");

                
                break;
            case 'update':
                $(modalTarget).find('#placement-id').val(id);
                $(modalTarget).find('#placement-code').val(code);
                $(modalTarget).find('#placement-name').val(name);
                break;
        }
    }

    function modalActionSublocation(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_sublocation"]');
        hide('#sublocationModal #message-container')

        switch (mode) {
            case 'insert':
            var sublocationCode = $('#current-sublocation-code').val();
                $('[name="sublocation-code"]').val(sublocationCode);
                show('[xaction="save_sublocation"]');
                break;
            case 'update':
                $(modalTarget).find('#sublocation-id').val(id);
                $(modalTarget).find('#sublocation-code').val(code);
                $(modalTarget).find('#sublocation-name').val(name);
                break;
        }
    }

    function getSublocation(placement_id){
        $('#sublocation').hide();

        $.ajax({
            url: "{{route('reference.getSublocation')}}",
            data: {
                placement_id: placement_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('[xplacementlist="placement_id_'+placement_id+'_location"]').html(result);
                $('[xplacementlist="placement_id_'+placement_id+'_location"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
            }
        });
    }

    function placementAction(id, state, name, action){
        hide('[xaction="save_placement"]');

        let crf = "{{csrf_token()}}";
        $.post("{{route('reference.placement.location.action')}}",{
            '_token':crf,
            'id':id,
            'state':state,
            'name':name,
            'action': action
        }).done(function(result){
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#message-container #result').text(result.message);
            $('#message-container').show();
            hide('[xaction="close_placement"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response){
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="placement-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="placement-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_placement"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function sublocationAction(action, placement_id, id, name){

        hide('[xaction="save_sublocation"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.placement.sublocation.action')}}", {
            '_token':crf,
            'placement_id': placement_id,
            'id': id,
            'name':name,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#sublocationModal #message-container #result').text(result.message);
            $('#sublocationModal #message-container').show();
            getSublocation(placement_id);
            $('[xplacementlist="placement_id_'+placement_id+'_location"]').slideDown('fast');

            hide('[xaction="close_sublocation"]');
            show('[xaction="reload_page"]');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="sublocation-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="sublocation-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_sublocation"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
        }

        function displayLocation(self, placement_id, placement_code, placement_name){

        $('[xplacementlist]').slideUp('fast');
        $('[xplacementlist]').html('');
        
        $('#sublocationModal #placement-id').val(placement_id);
        $('#placementCode').text(placement_code);
        $('#placementName').text(placement_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('#placement').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getSublocation(placement_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
            $('#sublocation').slideUp('fast');
        }
    }

    function deletePlacement(){
        $('input[name="chk_placement"]:checked').map(function(){
            placement_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.placement.location.action')}}",{
            'placement_ids' : placement_ids,
            'action': 'delete',
            '_token': '{{csrf_token()}}'
        }).done(function(result){
            console.log('success/done', result);
            hide('[xaction="delete"');
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

    function deleteItemPlacement(id){
        placement_ids= [id];
    }

    function deleteSublocation(){

        let placement_id = $('#sublocationModal #placement-id').val();

        $('input[name="chk_sublocation"]:checked').map(function () {
            sublocation_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.placement.sublocation.action')}}", {
            'sublocation_ids': sublocation_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                getSublocation(placement_id);
                $('[xplacementlist="placement_id_'+placement_id+'_location"]').slideDown('fast');
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
        }


    function initFuncPlacement(){

        $('#chkall_placement').change(function() {
             placement_ids = [];

            $('[name="chk_placement"]').prop('checked', $(this).is(':checked'));
            $('input[name="chk_placement"]:checked').map(function () {
                 placement_ids.push(parseInt(this.value));
            } );

            if( placement_ids.length > 0){
                $('[xaction="delete_selected_placement"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_placement"]').prop('disabled', true);
            }
        });

        $('[name="chk_placement"]').change(function() {

            placement_ids = [];

            $('input[name="chk_placement"]:checked').map(function () {
                 placement_ids.push(parseInt(this.value));
            } );

            if( placement_ids.length > 0){
                $('[xaction="delete_selected_placement"]').prop('disabled', false);
            } else {
                $('[xaction="delete_selected_placement"]').prop('disabled', true);
            }

        });

        $('[xaction="save_placement"]').on('click', function(e){
            e.preventDefault();
            let id = $('[name="placement-id"]').val();
            let state = $('[name="placement-state"]').val();
            let name = $('[name="placement-name"]').val();
            let action = $('#placementModal').find('#action').val();
            placementAction(id, state, name, action);
        });

        $('[xaction="delete_selected_placement"]').on('click', function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
            $('#deleteModal #delete_for').val('placement');
        });

    }
    
        jQuery(document).ready(function() {
        initFuncPlacement();

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();
            let deleteFor = $('#deleteModal #delete_for').val();
            switch (deleteFor) {
                case 'placement':
                    deletePlacement();
                    break;
                case 'sublocation':
                    deleteSublocation();
                    break;
            }
        });
    });


</script>
</body>
</html>




