@php
   $AccessVehicle = auth()->user()->vehicle('01', '01');
   $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');
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

    table.dataTable tbody tr td.combine {
        padding-top: 4px;
        width:30px;
        text-align: center;
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

    th{

        vertical-align: middle !important;
        font-family: avenir-bold !important;
        font-size: 12px !important;
        color: #333333 !important;
        background-color: #eaeee7 !important;
    }

    td{

        vertical-align:middle !important;
        font-size: 12px !important;
    }

    .dataTables_info{
        margin-top: 10px !important;

    }

    .dataTables_filter label input{

        border-radius:5px !important;
    }

    .dataTables_length label div select{

        padding:5px !important;
        border: 2px solid #dbdcd8;
        border-radius: 5px;

    }

    .dataTables_paginate{

        margin-bottom:20px !important;
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

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
<div class="mytitle">Siap Siaga Bencana</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Logistik</a></li>
      <li class="breadcrumb-item active" aria-current="page">Siap Siaga Bencana</li>
    </ol>
</nav>
<div class="btn-group">
    @if ($AccessVehicle->mod_fleet_c == 1)
    <a class="btn cux-btn bigger" href="{{route('logistic.disasterready.register')}}" ><i class="fal fa-plus"></i> Kenderaan</a>
    @endif
    @if ($AccessVehicle->mod_fleet_d == 1)
    <button class="btn cux-btn bigger" xaction="delete_all" data-bs-toggle="modal" data-bs-target="#deleteVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Some info"><i class="fal fa-trash-alt"></i> Hapus</button>
    @endif
    @if ($TaskFlowAccessVehicle->mod_fleet_verify)
    <button class="btn cux-btn bigger" xaction="verify_all" data-bs-toggle="modal" data-bs-target="#verifyVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Semak"><i class="fa fa-check"></i>&nbsp;Semak</button>
    @endif

    @if ($TaskFlowAccessVehicle->mod_fleet_approval)
    <button class="btn cux-btn bigger" xaction="approve_all" data-bs-toggle="modal" data-bs-target="#approvalVehicleModal" disabled type="button" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Sah"><i class="fa fa-check"></i>&nbsp;Sah</button>
    @endif
</div>
<hr/>
<div class="main-content">
<form class="form-submit" id="the_form">
<table id="fleet-ls" class="table display compact stripe hover compact table-bordered">
    <thead>
        <th><input name="chkall" id="chkall" type="checkbox"></th>
        <th></th>
        <th class="text-center">No Pendaftaran</th>
        <th class="text-center">Tarikh Masuk Bengkel</th>
        <th class="text-center">Tarikh Dijangka Siap</th>
        <th class="text-center">Tarikh Siap</th>
        <th class="text-center">Status</th>
    </thead>
    <tbody id="sortable">
    </tbody>
    <tfoot>
        <th></th>
        <th></th>
        <th class="text-center">No Pendaftaran</th>
        <th class="text-center">Tarikh Masuk Bengkel</th>
        <th class="text-center">Tarikh Dijangka Siap</th>
        <th class="text-center">Tarikh Siap</th>
        <th class="text-center">Status</th>
    </tfoot>
</table>
</form>

<div class="modal fade" id="deleteVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        </div>
        <div class="modal-body">
            Adakah anda ingin menghapuskan data ini ?
        </div>
        <div class="modal-footer">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
            <span class="btn btn-danger" xaction="delete" >Ya</span>
        </div>
    </div>
    </div>
</div>

@if ($TaskFlowAccessVehicle->mod_fleet_verify)
    <div class="modal fade" id="verifyVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                Adakah anda sudah menyemak maklumat pendaftaran ini ?
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                <span class="btn btn-danger" xaction="verify" >Ya</span>
            </div>
        </div>
        </div>
    </div>
@endif

@if ($TaskFlowAccessVehicle->mod_fleet_approval)
    <div class="modal fade" id="approvalVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approvalVehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                Adakah anda ingin mengesahkan maklumat ini?
            </div>
            <div class="modal-footer">
                <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                <span class="btn btn-danger" xaction="approve" >Ya</span>
            </div>
        </div>
        </div>
    </div>
@endif

</div>

<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var vehicle_ids = [];
    var selfDataTable;

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

    jQuery(document).ready(function() {

        $('select').select2({
			width: '60px',
			theme: "classic",
			minimumResultsForSearch: -1
        });

        selfDataTable = $("#fleet-ls").on( 'page.dt',   function (data) {

         } )
        .DataTable({
            language: {
                "processing": "Sila tunggu...",
                "emptyTable": "Tiada data"
            },
            "searching": true,
            "lengthMenu": [10, 20, 30, 40, 50, 100],
            "processing": true, // for show progress bar
            "filter": false, // this is for disable filter (search box)
            "orderMulti": false, // for disable multiple column at once
        //     "ajax": {
        //         "url": "{{route('vehicle.ajax.list')}}",
        //         "type": "GET",
        //         "datatype": "json",
        //         "dataSrc": function ( json ) {
        //             return json;
        //         }
        //     },
        //     "columns": [
        //             {
        //                 "data": null,
        //                 "name": "first",
        //                 "defaultContent": '',
        //                 "autoWidth": true
        //             },
        //             {
        //                 "data": null,
        //                 "name": "second",
        //                 "defaultContent": '',
        //                 "autoWidth": true
        //             },
        //             { "data": "plat_number", "autoWidth": true },
        //             { "data": null, "defaultContent": '', "autoWidth": true },
        //             { "data": null, "defaultContent": '', "autoWidth": true },
        //             {
        //                 "data": null,
        //                 "defaultContent": '',
        //                 "autoWidth": true
        //             },
        //             {
        //                 "data": "status",
        //                 "defaultContent": '',
        //                 "autoWidth": true
        //             }
        //     ],

        //     "columnDefs":[
        //         {
        //             targets: 0,
        //             orderable: false,
        //             className: 'select-checkbox',
        //             render: function(data){
        //                 var detail_id = data['id'];
        //                 return '<input name="chkdel" id="chkdel" type="checkbox" value="'+detail_id+'"/>';
        //             }
        //         },
        //         {
        //             targets: 1, render:function(data){
        //                 var detail_id = data['id'];
        //                 var url = '{{route('vehicle.register')}}/'+detail_id;
        //                 var $elements = '';
        //                 var isUserAwam = false;
        //                 var editInfo = false;
        //                 var viewInfo = false;

        //                 @if(Auth()->user()->roleAccess()->code == '04')
        //                     isUserAwam = true;
        //                     viewInfo = true;
        //                 @endif

        //                 @if ($AccessVehicle->mod_fleet_u == 1)
        //                     editInfo = true;
        //                 @endif

        //                 @if ($TaskFlowAccessVehicle->mod_fleet_approval == 1)
        //                     viewInfo = true;
        //                 @endif

        //                 if(editInfo){
        //                     if(!(data.vehicle_status_code == '02' && isUserAwam) && data.vehicle_status_code !== '06'){
        //                         $elements += '<a class="btn cux-btn" href="'+url+'"><i class="fa fa-pen-square"></i></a>';
        //                     }
        //                 }

        //                 if(viewInfo){
        //                     url = url + '?is_display=1';
        //                     $elements += '<a class="btn cux-btn" href="'+url+'"><i class="fa fa-info"></i></a>';
        //                 }

        //                 return '<div class="btn-group">'+$elements;+'</div>';
        //             }
        //         },
        //         {   className: "text-center",
        //             targets: 2
        //         },
        //         {   className: "text-center",
        //             targets: 3, render:function(data){
        //                 var dataDetail = null;
        //                 if(data){
        //                     dataDetail = moment(data).format('DD/MM/YYYY');
        //                 }
        //                 return dataDetail;
        //             }
        //         },
        //         {   className: "text-center",
        //             targets: 4, render:function(data){
        //                 var dataDetail = null;
        //                 if(data){
        //                     dataDetail = moment(data).format('DD/MM/YYYY');
        //                 }
        //                 return dataDetail;
        //             }
        //         },
        //         {   className: "text-center",
        //             targets: 5, render:function(data){
        //                 var dataDetail = null;
        //                 if(data){
        //                     dataDetail = moment(data).format('DD/MM/YYYY');
        //                 }
        //                 return dataDetail;
        //             }
        //         },
        //         {   className: "text-center",
        //             targets: 6
        //         }
        //     ],
        //     select: true,
        //     "order": [[0, 'asc']]
        // }).on( 'draw', function (data) {

        //     var currentCheck = $('#chkdel:checked').length;

        //     if(currentCheck == selfDataTable.page.info().length){
        //         $('#chkall').prop("checked", true);
        //     }else {
        //         $('#chkall').prop("checked", false);
        //     }

        //     $('[name="chkdel"]').change(function() {
        //         let $checkboxes = $('[name="chkdel"]');
        //         let checkboxesArray = [].slice.call($checkboxes);

        //         $(this).prop('checked', $(this).is(':checked'));

        //         var currentCheck = $('#chkdel:checked').length;
        //         if(currentCheck == selfDataTable.page.info().length){
        //             $('#chkall').prop("checked", true);
        //         }else {
        //             $('#chkall').prop("checked", false);
        //         }

        //     });

        // } ).on( 'init.dt', function (data) {

        //     $('[name="chkdel"]').change(function() {

        //         var rows = $(selfDataTable.$('input[type="checkbox"]:checked').map(function () {
        //         return this.value;
        //         } ) );

        //         console.log(rows);

        //         if(rows.length > 0){
        //             $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', false);
        //         } else {
        //             $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', true);
        //         }

        //     });
        } );

        $('#chkall').change(function() {

            let $checkboxes = $('[name="chkdel"]');
            let checkboxesArray = [].slice.call($checkboxes);

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));

            var rows = $(selfDataTable.$('input[type="checkbox"]:checked').map(function () {
            return this.value;
            } ) );

            if(rows.length > 0){
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', false);
            } else {
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', true);
            }

            console.log(rows);

        });

        $('[xaction="delete_all"]').click(function(e){
            e.preventDefault();
            show('[xaction="delete"]');
            show('[xaction="no"]');
            hide('[xaction="close"]');
        });

        $('[xaction="delete"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="delete"]');
            hide('[xaction="no"]');

            $(selfDataTable.$('input[type="checkbox"]:checked').map(function () {
                vehicle_ids.push(parseInt(this.value));
            } ) );

            $.post('{{route('vehicle.delete')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#deleteVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihapuskan');
                show('[xaction="close"]');
                //$('#deleteVehicleModal').modal('hide');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('[xaction="verify"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="verify"]');
            hide('[xaction="no"]');

            $(selfDataTable.$('input[type="checkbox"]:checked').map(function () {
                vehicle_ids.push(parseInt(this.value));
            } ) );

            $.post('{{route('vehicle.approval')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#verifyVehicleModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('[xaction="approve"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="approve"]');
            hide('[xaction="no"]');

            $(selfDataTable.$('input[type="checkbox"]:checked').map(function () {
                vehicle_ids.push(parseInt(this.value));
            } ) );

            $.post('{{route('vehicle.approve')}}', {
                'vehicle_ids': vehicle_ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#approvalVehicleModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

{{--        selfDataTable.search('{{$searchParam}}').draw();
--}}
    });
</script>
</body>
</html>


