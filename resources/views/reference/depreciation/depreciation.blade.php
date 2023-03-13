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
</head>

<body class="content">
<div class="mytitle">Senarai Kenderaan Susut Nilai </div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Daftar Rujukan </a></li>
      <li class="breadcrumb-item active" aria-current="page">Senarai Kenderaan Susut Nilai</li>
    </ol>
</nav>
<hr/>
<div class="main-content">
<form class="form-submit row" id="the_form">
    @csrf
    <div class="col-md-6 ps-3 pe-3" id="category">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    
                    <th style="width: 40px">Kod</th>
                    <th class="cfoc">Pengeluar</th>
                    <th></th>
                    <th class="cfoc">Status</th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach ($Brand as $brand)
                    <tr>
                        <td style="width: 40px">{{$brand->brand_code}}</td>
                        <td class="cfoc key"><a href="#" data-placement="top">{{$brand->brand_name}} </a></td>
                        <td></td>
                        <td>
                            <div class="form-switch">
                                <input type="checkbox" class="form-check-input check_is_pass mt-2 me-2" name="is_active" id="is_active" data-brand-id={{$brand->brand_id}} {{$brand->active == true ? 'checked' : ''}} onchange="updateIsActiveValue(this)">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="col-md-4 ps-3 pe-3" id="sub_category" style="display: none;"></div> --}}
    <div class="col-md-4 ps-3 pe-3" id="sub_category_type" style="display: none;"></div>
</form>

<script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script>
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

    function goTo(url){
        window.location.href = url;
    }

    function reloadPage(){
        parent.openPgInFrame("{{route('reference.depreciation')}}");
    }

   function updateIsActiveValue(self){

        let token = '{{ csrf_token() }}'
        let brand_id = $(self).data('brand-id');
        var $active_value = $('#is_active').val();
        // let isChecked = $('#is_active [name="is_active"]').is(':checked');

        // if(isChecked){

        let isChecked = $(self).is(':checked');
        $('#is_active [name="is_active"]').prop('checked', isChecked);    

        if(self.checked){
            console.log("checked");
            $active_value = true;
        }
        else{
            console.log("unchecked");
            $active_value = false;
        }

        console.log("brand_id =>", brand_id);
        console.log("active_value =>", $active_value);

        var formData = new FormData();

        formData.append('brand_id', brand_id);
        formData.append('active_value', $active_value);
        formData.append('_token', token);

        parent.startLoading();
        $.ajax({
            url: "{{route('reference.depreciation.update')}}",
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            success: function(response) {
                console.log(response);
                $('#response').html('<span class="text-success">Maklumat berjaya dikemaskini</span>').fadeIn(500).fadeOut(5000);
            parent.stopLoading();
            },
            error: function(response) {
                var errors = response.responseJSON.errors;

                $.each(errors, function(key, value) {
                    $('#response').html('<span class="text-success">Maklumat gagal dikemaskini</span>').fadeIn(500).fadeOut(5000);
                });

                parent.stopLoading();
            }
        
        });
    }

    $(document).ready(function() {

    });
</script>
</body>
</html>