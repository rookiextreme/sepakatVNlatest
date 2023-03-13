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

<link href="{{asset('my-assets/plugins/datatables/datatables.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<!--<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">-->

<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<!--<script src="{{asset('my-assets/plugins/highcharts/code/modules/stock.js')}}"></script>-->
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>

{{--  lodash plugin  --}}
<script src="{{asset('my-assets/plugins/lodash/core.js')}}"></script>

<style type="text/css">
    .highcharts-figure, .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
        margin-left:0px;
    }
    #container {
        height: 400px;
    }
    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #EBEBEB;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }
    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }
    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
        padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
    .detailing {
        background-color:#ffffff;
        padding:20px;
        width:100%;
        /* max-width: 1030px; */
        -webkit-border-radius: 8px;
        -moz-border-radius: 8px;
        border-radius: 8px;
    }
    thead td {
        border-bottom-color:#999999;
        border-bottom-width:1px;
        border-bottom-style: solid;
        height:40px;
    }
    thead td.col-mth {
        font-family: mark-bold;
        color:#1b1b1b;
        font-size:14px;
        border-bottom-width:3px;
        vertical-align: bottom;
    }
    .col-focus {
        min-width: 70px;
        vertical-align: text-top;
        text-align: right;
        padding-right:5px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
    }
    .col-focus.link {
        font-family: mark-bold;
        font-size:16px;
        text-decoration: none;
        color:#454545;
        cursor:pointer;
        line-height:16px;
        transition: all 0.2s ease-in;
    }
    .col-focus.link:hover {
        font-size:20px;
        background-color:orange;
        line-height:16px;
        color:#ffffff;
    }
    .col-info {
        font-family: mark;
        font-size:14px;
        color:#454545;
        line-height:16px;
        text-align: right;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
        padding-right:5px;
    }
    .row-item {
        font-family: mark;
        font-size:14px;
        line-height: 14px;
        min-width:130px;
        color:#2c2c2c;
        padding-top:5px;
        padding-left:7px;
        padding-bottom:5px;
        background-color:#eeeded;
    }
    .end {
        width:15px;
    }
    .col-tren {
        padding-right:10px;
        border-right-color:#cdcdcd;
        border-right-width:1px;
        border-right-style: solid;
        text-align: right;
    }
    .shape-decline {
        float: right;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 15px solid red;
        border-right: 40px solid transparent;
    }
    .shape-incline {
        float: right;
        bottom:0px;
        width: 0;
        height: 0;
        border-bottom: 15px solid green;
        border-left: 40px solid transparent;
    }
    .shape-constant {
        float: right;
        bottom:0px;
        width: 40px;
        height: 15px;
        background-color: #40b293;
    }

    .col-mth.header-depreciation{
        background-color: lightgoldenrodyellow;
        border-right: 1px solid lightgrey;
        text-align: right;
        padding-right: 8px;

    }

    .header-depreciation.left{

        text-align: left;
        padding-left: 8px;
        font-size: 14px;

    }

    tr{
        border-bottom: 1px solid lightgrey !important;
    }

    .percentage-value{

        text-align: right !important;
    }

    .form-select.smaller{


        font-size: 12px !important;
        padding: 2px !important;
        padding-left: 6px !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
    }

</style>
<script type="text/javascript">

</script>
</head>



<body class="content">
<div class="sect-top">
    <div class="mytitle">Penilaian <span>Jadual Susut Nilai</span></div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{ route('access.admin.dashboard') }}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Am & Penetapan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jadual Susut Nilai</li>
        </ol>
    </nav>


    <div class="dropdown inline" style="display: inline;">
        <div class="btn-group">
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger" style='font-size:14px !important' type="button" onClick="triggerCLcikById('tab4');" >

                    &nbsp;+ model&nbsp;

                </a>

            </div>
            <div class="btn-group" role="group">
                <a class="btn cux-btn bigger"  style='font-size:14px !important' type="button" onClick="triggerCLcikById('tab5');">

                    &nbsp;+ kelas&nbsp;

                </a>

            </div>

        </div>
        <div class="dropdown inline float-end">
            <span class="btn cux-btn bigger"><i class="fal fa-print text-success"></i>&nbsp;Cetak</span>
        </div>
    </div>
</div>
<br/>
<div class="sect-top-dummy"></div>
<div class="main-content">
    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'calculate');" id="tab0">Calculate</li>
                <li class="cub-tab" onClick="goTab(this, 'carta');" id="tab1">Carta</li>
                <li class="cub-tab" onClick="goTab(this, 'perincian');" id="tab2">Perincian Jadual</li>
                <li class="cub-tab" onClick="goTab(this, 'kelas');" id="tab3">Perincian Kelas Kenderaan</li>
                <li class="cub-tab" onClick="goTab(this, 'add_model');" id="tab4">+ Model Kenderaan</li>
                <li class="cub-tab" onClick="goTab(this, 'add_class');" id="tab5">+ Kelas Susut Nilai</li>
            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>
    <section id="calculate" class="tab-content">

        <div class="detailing">
            <div class="small-title" style='margin-bottom:15px'>Kalkulator Anggaran Susut Nilai</div>
            <div class='row'>
                <div class='col-xl-3 col-md-4 col-sm-6 col-12'>
                    <div class="form-group">
                        <label for="" class="form-label text-dark" >Model Kenderaan </label>
                        <select class="form-select smaller" id="selected_model" name="selected_model">
                            <option value="0">Please Select</option>
                            @foreach ($listBrand as $listData)
                                <option value="{{$listData -> id}}">{{$listData -> name}}</option>
                            @endforeach

                        </select>

                    </div>
                    <div class="form-group">
                        <label for="" class="form-label text-dark">Usia </label>
                        <select class="form-select smaller" id="selected_age" name="selected_age">
                            <option value="0">Please Select</option>
                            @for($i=1;$i<=15;$i++)
                                <option value="{{$i}}">{{$i}} TAHUN</option>
                            @endfor
                                <option value="15"> >15 TAHUN</option>

                        </select>

                    </div>
                    <div class="form-group" style='margin-top:10px;'>
                        <label for="" class="form-label text-dark">Harga Semasa (RM) </label>
                        <input onkeyup="this.value = this.value.toUpperCase()"  style='text-align:right' type="text" class="form-control" id='current_value' placeholder='0.00' value=''>
                    </div>

                    <div class="form-group" style='margin-top:20px;margin-bottom:20px;'>

                        <span class="btn btn-danger" style='font-family:mark !important' onclick='calculateDepreciationValue()' >Kira</span>

                    </div>

                </div>
                <div class='col-xl-3 col-md-4 col-sm-6 col-12 result-display' style='display:none'>
                    <div class="form-group" style=''>
                        <label for="" class="form-label text-dark" >Kelas </label>
                        <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" id='result_class' disabled value=''>
                    </div>
                    <div class="form-group" style=''>
                        <label for="" class="form-label text-dark" >Percentage </label>
                        <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" id='result_percentage' disabled value=''>
                    </div>
                    <div class="form-group" style=''>
                        <label for="" class="form-label text-dark" >Nilai Selepas Susut (RM) </label>
                        <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" style='text-align:right' disabled id='after_depreciation_value' value=''>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <section id="carta" class="tab-content">
        <div class="detailing">
            <div class="small-title">Carta Susut Nilai</div>
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </section>


    <section id="perincian" class="tab-content">
        <div class="detailing table-responsive">
            <div class="small-title" style='margin-bottom:15px'>Perincian Jadual Susut Nilai</div>
            <table>
                <thead>
                    {{-- <td class="end"></td> --}}
                    <td class="col-mth header-depreciation left">KELAS \ USIA</td>
                    @foreach ($listArrayKelas[0] as $listData)
                        <td class="col-mth header-depreciation">{{$listData->age}}</td>
                    @endforeach


                    {{-- <td class="end"></td> --}}
                </thead>
                <tbody>

                    @foreach ($listArrayKelas as $listData)
                    <tr>
                        {{-- <td class="end "></td> --}}
                        <td class="row-item" style="text-transform:uppercase">{{$listData[0]->class_name}}</td>
                        @foreach ($listData as $data)


                        <td class="col-focus link" xtype='class' style='font-family:mark !important;font-size:14px !important;padding:8px !important' id='percentageTarget_{{$data->class_number}}_{{$data->age}}'
                        classNumberRoman='{{$data->roman_numbering}}' classNumber='{{$data->class_number}}' xage='{{$data->age}}' xvalue='{{$data->percentage}}'>{{$data->percentage}}%</td>
                        @endforeach

                        {{-- <td class="end"></td> --}}
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </section>
    <section id="kelas" class="tab-content">
        <div class="detailing">
            <div class="small-title"  style='margin-bottom:15px'>Perincian Kelas Susut Nilai Kenderaan</div>
            <table>
                <thead>
                    {{-- <td class="end"></td> --}}
                    <td class="col-mth header-depreciation left">MODEL \ USIA</td>
                    @foreach ($listArrayKelas[0] as $listData)
                        <td class="col-mth header-depreciation">{{$listData->age}}</td>
                    @endforeach

                    {{-- <td class="end"></td> --}}
                </thead>
                <tbody>

                    @foreach ($listArrayKenderaan as $listData)
                    <tr>
                        {{-- <td class="end "></td> --}}
                        <td class="row-item" style="text-transform:uppercase">{{$listData[0]->vehicle_name}}</td>
                        @foreach ($listData as $data)


                        <td class="col-focus link" xtype='vehicle' style='font-family:mark !important;font-size:14px !important;padding:8px !important'
                        id='vehicleTarget_{{$data->vehicle_id}}_{{$data->age}}' vehicleId='{{$data->vehicle_id}}' vehicleName='{{$data->vehicle_name}}' xage='{{$data->age}}' xvalue='{{$data->class_number}}'>
                        {{$data->class_id}}</td>
                        @endforeach

                    </tr>
                    @endforeach

                </tbody>
            </table>



        </div>

    </section>

    <section id="add_class" class="tab-content">
        <div class="detailing">
            <div class="small-title"  style='margin-bottom:15px'>+ Tambah Kelas</div>
            <table>
                <thead>
                    {{-- <td class="end"></td> --}}
                    <td class="col-mth header-depreciation left">KELAS \ USIA</td>
                    @foreach ($listArrayKelas[0] as $listData)
                        <td class="col-mth header-depreciation">{{$listData->age}}</td>
                    @endforeach


                    {{-- <td class="end"></td> --}}
                </thead>
                <tbody>


                    <tr>
                        {{-- <td class="end "></td> --}}
                        <td class="row-item col-focus" style="text-transform:uppercase">

                                <select class="form-select smaller" id="latest_class" name="latest_class">
                                    <option value="{{$highestClass}}">Kelas {{$highestClassInRoman}}</option>
                                    {{-- get latest class --}}
                                </select>

                        </td>


                        @foreach ($listArrayKelas[0] as $listData)
                        <td class="col-focus " style='font-family:mark !important;font-size:14px !important;padding:8px !important'>
                                <input type="text" class=" percentage-value" id='percentage_value_{{$loop->index}}' name="percentage_value" value="">%
                        </td>
                        @endforeach

                        {{-- <td class="end"></td> --}}
                    </tr>


                </tbody>
            </table>

            <div class='row' style='margin-top:20px;'>
                <div class='col-6 col-sm-4 col-md-3'>
                    <div class="btn-group">
                        <div class="btn-group btn-action" role="group">
                            <a class="btn cux-btn bigger" style='font-size:14px !important' type="button" onClick="saveNewClass();" >

                                &nbsp;simpan&nbsp;

                            </a>

                        </div>

                    </div>

                </div>
                <div class='col-6 col-sm-4 col-md-3'>
                    <div class='form-group respond-msg'>
                        <label class="form-label"></label>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section id="add_model" class="tab-content">
        <div class="detailing">
            <div class="small-title"  style='margin-bottom:15px'>+ Model Kenderaan</div>
            <table>
                <thead>
                    {{-- <td class="end"></td> --}}
                    <td class="col-mth header-depreciation left">MODEL \ USIA</td>
                    @foreach ($listArrayKelas[0] as $listData)
                        <td class="col-mth header-depreciation">{{$listData->age}}</td>
                    @endforeach

                    {{-- <td class="end"></td> --}}
                </thead>
                <tbody>


                    <tr>
                        {{-- <td class="end "></td> --}}
                        <td class="row-item col-focus" style="text-transform:uppercase">

                                <select class="form-select smaller" id="new_model" name="new_model">
                                    <option value="0">Please Select</option>
                                    @foreach ($listKenderaanNotYetDefined as $listData)
                                        <option value="{{$listData -> vehicle_id}}">{{$listData -> vehicle_name}}</option>
                                    @endforeach

                                </select>
                                {{-- get list of car model that is not yet defined class --}}

                        </td>

                        @foreach ($listArrayKelas[0] as $listData)
                            <td class="col-focus " style='font-family:mark !important;font-size:14px !important;padding:8px !important'>
                                <div class="input-group">
                                    <select class="form-select smaller" id="vehicle_class_{{$loop->index}}" name="new_model_{{$loop->index}}">
                                        @foreach ($listKelas as $listData)
                                            <option value="{{$listData -> kelas_id}}">{{$listData->roman_numbering}}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </td>
                        @endforeach

                    </tr>


                </tbody>
            </table>

            <div class='row' style='margin-top:20px;'>
                <div class='col-6 col-sm-4 col-md-3'>
                    <div class="btn-group">
                        <div class="btn-group btn-action" role="group">
                            <a class="btn cux-btn bigger" style='font-size:14px !important' type="button" onClick="saveNewVehicle();" >

                                &nbsp;simpan&nbsp;

                            </a>

                        </div>

                    </div>

                </div>
                <div class='col-6 col-sm-4 col-md-3'>
                    <div class='form-group respond-msg' id='add_model_msg'>
                        <label class="form-label"></label>
                    </div>
                </div>


            </div>
        </div>

    </section>


</div>
<div class="modal fade" id="updateMaklumatSusutNilaiDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Kemaskini Maklumat Susut Nilai
        </div>
        <div class="modal-body">
            <form id='updateMaklumatSusutNilaiDetailsForm'>
                <input type='hidden' id='classNumberData' name='classNumberData' value=''/>
                <input type='hidden' id='classAgeData' name='classAgeData' value=''/>
                <div class='row'>
                    <div class='col-sm-6 col-12'>
                        <div class="form-group">
                            <label for="" class="form-label text-dark" >Kelas </label>
                            <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" disabled id='class-number' value=''>

                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Usia </label>
                            <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" disabled id='class-age' value=''>

                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Peratus susut nilai <span class="text-danger">*</span></label>
                            <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control"  placeholder="10" id='classPercentage' name='classPercentage' value=''>

                        </div>
                        <div class="form-group" id='respondMsg'>
                            <label for="" class="form-label "></label>
                        </div>
                    </div>
                </div>

            </form>


        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal" style='font-family:mark !important'>Tidak</span>
            <span class="btn btn-danger" style='font-family:mark !important' onclick='updateMaklumatSusutNilaiDetails()' >Ya</span>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="updateMaklumatKelasKenderaan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <input type="hidden" id="delete_for" value="">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Kemaskini Maklumat Kelas Kederaan
        </div>
        <div class="modal-body">
            <form id='updateMaklumatKelasKenderaanForm'>
                <input type='hidden' id='vehicleModelId' name='vehicleModelId' value=''/>
                <input type='hidden' id='vehicleAge' name='vehicleAge' value=''/>


                <div class='row'>
                    <div class='col-sm-6 col-12'>
                        <div class="form-group">
                            <label for="" class="form-label text-dark" >Model </label>
                            <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" disabled id='vehicle_model' value=''>

                        </div>
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Usia </label>
                            <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" disabled id='vehicle_age' value=''>

                        </div>
                        {{-- <div class="form-group">
                            <label for="" class="form-label text-dark">Kelas Susut Nilai <span class="text-danger">*</span></label>
                            <input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control"  placeholder="10" id='vehicle_class' name='vehicle_class' value=''>

                        </div> --}}
                        <div class="input-group">
                            <label for="" class="form-label text-dark">Kelas Susut Nilai <span class="text-danger">*</span></label>
                            <select class="form-select" id='vehicle_class' name='vehicle_class'>
                                @foreach ($listKelas as $listData)
                                    <option value="{{$listData -> kelas_id}}">{{$listData->roman_numbering}}</option>
                                @endforeach


                            </select>
                        </div>

                        <div class="form-group respond-msg'>
                            <label for="" class="form-label "></label>
                        </div>
                    </div>
                </div>

            </form>


        </div>
        <div class="modal-footer float-start">
            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal" style='font-family:mark !important'>Tidak</span>
            <span class="btn btn-danger" style='font-family:mark !important' onclick='updateMaklumatKelasKenderaan()' >Ya</span>
        </div>
    </div>
    </div>
</div>

{{-- <script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script> --}}


<script type="text/javascript">
    $(document).ready(function() {

        //$('#latest_class').select2();
        initTab();




        $('.dropdown-item.type').click(function(e){
            var clickedItem = $(this).attr('xname');
            //alert(clickedItem);
            {{--location.replace('report_trend_analysis?current_year={{$currentYear}}&trend_on='+clickedItem);--}}


	  	});

          $('.dropdown-item.year').click(function(e){
            var clickedItem = $(this).attr('xname');
            //alert(clickedItem);
            {{--location.replace('report_trend_analysis?trend_on={{$trendOn}}&current_year='+clickedItem);--}}


	  	});

          $('.link').click(function(e){

              var type = $(this).attr('xtype');

              if(type == 'class'){
                var age = $(this).attr('xage');
                var classNumberRoman = $(this).attr('classNumberRoman');
                var classNumber = $(this).attr('classNumber');
                var percentage = $(this).attr('xvalue');

                $('#updateMaklumatSusutNilaiDetails #class-number').val('Kelas '+classNumberRoman);
                $('#updateMaklumatSusutNilaiDetails #class-age').val(age);
                $('#updateMaklumatSusutNilaiDetails #classPercentage').val(percentage);
                $('#updateMaklumatSusutNilaiDetails #classNumberData').val(classNumber);
                $('#updateMaklumatSusutNilaiDetails #classAgeData').val(age);


                $('#respondMsg').hide();
                $('#updateMaklumatSusutNilaiDetails').modal('show');

              }else if(type == 'vehicle'){

                var age = $(this).attr('xage');
                var vehicleId = $(this).attr('vehicleId');
                var classNumber = $(this).attr('xvalue');
                var vehicleName = $(this).attr('vehicleName');



                //alert(vehicleName);
                $('#updateMaklumatKelasKenderaan #vehicle_model').val(vehicleName);
                $('#updateMaklumatKelasKenderaan #vehicle_age').val(age);
                $('#updateMaklumatKelasKenderaan #vehicle_class').val(classNumber);

                $('#updateMaklumatKelasKenderaan #vehicleModelId').val(vehicleId);
                $('#updateMaklumatKelasKenderaan #vehicleAge').val(age);


                $('#respondMsg').hide();
                $('#updateMaklumatKelasKenderaan').modal('show');


              }


          });

    });

    function updateMaklumatSusutNilaiDetails(){


        $('#respondMsg').hide();
        //var form = document.getElementById('updateMaklumatSusutNilaiDetailsForm');
        var formData = $("#updateMaklumatSusutNilaiDetailsForm").serialize();

        var url = '{{route('settings.updatePercentageClass')}}';


        var classNumber = $('#updateMaklumatSusutNilaiDetails #classNumberData').val();
        var age = $('#updateMaklumatSusutNilaiDetails #classAgeData').val();
        var percentage = $('#updateMaklumatSusutNilaiDetails #classPercentage').val();

        $("#updateMaklumatSusutNilaiDetails .btn-danger").prop('disabled', true);

        $.ajax({

            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'GET',
            success: function(data){

                if(data == 1){

                    $('#updateMaklumatSusutNilaiDetails .respond-msg').show();
                    $('#updateMaklumatSusutNilaiDetails .respond-msg label').css('color', 'green');
                    $('#updateMaklumatSusutNilaiDetails .respond-msg label').html('Berjaya dikemaskini!');
                    $('#percentageTarget_'+classNumber+'_'+age).html(percentage+'%');
                    $('#percentageTarget_'+classNumber+'_'+age).attr('xvalue',percentage);

                    setTimeout(function(){
                        $('#updateMaklumatSusutNilaiDetails').modal('hide');
     			    }, 1000);


                }else{

                    $('#updateMaklumatSusutNilaiDetails .respond-msg').show();
                    $('#updateMaklumatSusutNilaiDetails .respond-msg label').css('color', 'red');
                    $('#updateMaklumatSusutNilaiDetails .respond-msg label').html('Gagal dikemaskini!');

                }

                $("#updateMaklumatSusutNilaiDetails .btn-danger").prop('disabled', false);

            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(xhr.status);
                var err = eval("(" + xhr.responseText + ")");
                //alert(err.Message);
                $('#updateMaklumatSusutNilaiDetails .respond-msg').show();
                $('#updateMaklumatSusutNilaiDetails .respond-msg label').css('color', 'red');
                $('#updateMaklumatSusutNilaiDetails .respond-msg label').html(err.Message);


                $("#updateMaklumatSusutNilaiDetails .btn-danger").prop('disabled', false);

            }
        });

    }

    function updateMaklumatKelasKenderaan(){


        $('#respondMsg').hide();
        //var form = document.getElementById('updateMaklumatSusutNilaiDetailsForm');
        var formData = $("#updateMaklumatKelasKenderaanForm").serialize();

        var url = '{{route('settings.updateVehicleClass')}}';


        var vehicleId = $('#updateMaklumatKelasKenderaan #vehicleModelId').val();

        var age = $('#updateMaklumatKelasKenderaan #vehicleAge').val();
        var vehicleClass = $('#updateMaklumatKelasKenderaan #vehicle_class').val();
        var vehicleClassRoman = $('#updateMaklumatKelasKenderaan #vehicle_class  option:selected').text();
        //alert('vehicleTarget_'+vehicleId+'_'+age);


        $("#updateMaklumatKelasKenderaan .btn-danger").prop('disabled', true);


        $.ajax({

            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            method: 'GET',
            success: function(data){

                if(data == 1){

                    $('#updateMaklumatKelasKenderaan .respond-msg').show();
                    $('#updateMaklumatKelasKenderaan .respond-msg label').css('color', 'green');
                    $('#updateMaklumatKelasKenderaan .respond-msg label').html('Berjaya dikemaskini!');
                    $('#vehicleTarget_'+vehicleId+'_'+age).html(vehicleClassRoman);
                    $('#vehicleTarget_'+vehicleId+'_'+age).attr('xvalue',vehicleClass);

                    setTimeout(function(){
                        $('#updateMaklumatKelasKenderaan').modal('hide');
                    }, 1000);


                }else{

                    $('#updateMaklumatKelasKenderaan .respond-msg').show();
                    $('#updateMaklumatKelasKenderaan .respond-msg label').css('color', 'red');
                    $('#updateMaklumatKelasKenderaan .respond-msg label').html('Gagal dikemaskini!');

                }

                $("#updateMaklumatKelasKenderaan .btn-danger").prop('disabled', false);


            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(xhr.status);
                var err = eval("(" + xhr.responseText + ")");
                //alert(err.Message);
                $('#updateMaklumatKelasKenderaan .respond-msg').show();
                $('#updateMaklumatKelasKenderaan .respond-msg label').css('color', 'red');
                $('#updateMaklumatKelasKenderaan .respond-msg label').html(err.Message);


                $("#updateMaklumatKelasKenderaan .btn-danger").prop('disabled', false);

            }
        });

}

function saveNewVehicle(){


    var arrayVehicleClass = [];

    @foreach ($listArrayKelas[0] as $listData)
        var vehicleClassOfAge = $('#vehicle_class_{{$loop->index}}').val();

        arrayVehicleClass.push(vehicleClassOfAge);

    @endforeach


    var vehicleId = $('#new_model').val();
    //alert('arrayVehicleClass : '+arrayVehicleClass.toString()+'----vehicleId : '+vehicleId.toString);

    var url = '{{route('settings.addVehicleClass')}}';

    $('#add_model_msg').show();
    $('#add_model_msg label').css('color', 'blue');
    $('#add_model_msg label').html('Maklumat sedang dikemaskini..');

    $('#add_model .btn-action').hide();

    $.ajax({

        url: url,
        data: {vehicleId: vehicleId, arrayVehicleClass: arrayVehicleClass.toString() },
        cache: false,
        //contentType: false,
        //processData: false,
        dataType:'json',
        method: 'GET',
        success: function(data){

            if(data == 1){

                $('#add_model_msg').show();
                $('#add_model_msg label').css('color', 'green');
                $('#add_model_msg label').html('Berjaya dikemaskini!');


                setTimeout(function(){
                    location.replace();
                }, 3000);


            }else{

                $('#add_model_msg').show();
                $('#add_model_msg label').css('color', 'red');
                $('#add_model_msg label').html('Gagal dikemaskini!');

            }

            $('#add_model .btn-action').show();

        },
        error: function (xhr, ajaxOptions, thrownError) {
            //alert(xhr.status);
            var err = eval("(" + xhr.responseText + ")");
            //alert(err.Message);
            $('#add_model_msg').show();
            $('#add_model_msg label').css('color', 'red');
            $('#add_model_msg label').html('Error : Duplicate Model Record or others');
            $('#add_model .btn-action').show();


        }
    });
}

function saveNewClass(){

    var latestClass = $('#latest_class').val();

    var arrayPercentage = [];

    @foreach ($listArrayKelas[0] as $listData)
        var arrayPercentageOfAge = $('#percentage_value_{{$loop->index}}').val();

        arrayPercentage.push(arrayPercentageOfAge);

    @endforeach

    var url = '{{route('settings.addNewClass')}}';

    $('#add_class .respond-msg').show();
    $('#add_class .respond-msg label').css('color', 'blue');
    $('#add_class .respond-msg label').html('Maklumat sedang dikemaskini..');

    $('#add_class .btn-action').hide();

    $.ajax({

        url: url,
        data: {latestClass: latestClass, arrayPercentage: arrayPercentage.toString() },
        cache: false,
        //contentType: false,
        //processData: false,
        dataType:'json',
        method: 'GET',
        success: function(data){

            if(data == 1){

                $('#add_class .respond-msg').show();
                $('#add_class .respond-msg label').css('color', 'green');
                $('#add_class .respond-msg label').html('Berjaya dikemaskini!');


                setTimeout(function(){
                    location.replace();
                }, 3000);


            }else{

                $('#add_class .respond-msg').show();
                $('#add_class .respond-msg label').css('color', 'red');
                $('#add_class .respond-msg label').html('Gagal dikemaskini!');

            }

            $('#add_class .btn-action').show();

        },
        error: function (xhr, ajaxOptions, thrownError) {
            //alert(xhr.status);
            var err = eval("(" + xhr.responseText + ")");
            //alert(err.Message);
            $('#add_class .respond-msg').show();
            $('#add_class .respond-msg label').css('color', 'red');
            $('#add_class .respond-msg label').html('Error : Duplicate Model Record or others');
            $('#add_class .btn-action').show();


        }
    });

}


</script>
<script type="text/javascript">


    var percentageList = [];
    var percentageValues = [];
    @foreach ($listArrayKelas as $listKelas)

        @foreach ($listKelas as $data)

            percentageValues.push([{{$data->percentage}}]);

        @endforeach
        percentageList.push(percentageValues);

        percentageValues = [];

    @endforeach

   // var xxxx = JSON.stringify(percentageList[0]);
    //alert('percentageList[0] : '+percentageList[0]);
    //alert('percentageList[1] : '+percentageList[1]);

	var pieColors = ["#988992","#5e7485","#832c2d","#77615a","#e9a386","#d9a751","#bfbfaa","#ca6174","#6aa5ab","#427ba6","#fab8ac"];
	Highcharts.chart('container', {
        chart: {
            zoomType: 'xy',
            marginTop: 30
        },
        title: {
            text: ''
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: ['1', '2', '3', '4', '5', '6',
                '7', '8', '9', '10', '11', '12','13','14','15'],
            crosshair: true,
            title: {
                text: 'usia (tahun)',
                style: {
                    color: '#5e7485'
                }
            }

        },
        yAxis: { // Secondary yAxis
            labels: {
                format: '{value}%',
                style: {
                    color: '#5e7485'
                }
            },
            title: {
                text: '% dari harga asal',
                style: {
                    color: '#5e7485'
                }
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            //y: 0,
            verticalAlign: 'top',
            //x: 110,
            floating: true,
            backgroundColor:
                Highcharts.defaultOptions.legend.backgroundColor || // theme
                'rgba(255,255,255,0.25)'
        },
        series: [{
                name: 'Kelas I',
                data: percentageList[0],
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: 'Kelas II',
                data: percentageList[1],
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: 'Kelas III',
                data: percentageList[2],
                tooltip: {
                    valueSuffix: '%'
                }
            },
            {
                name: 'Kelas IV',
                data: percentageList[3],
                tooltip: {
                    valueSuffix: '%'
                }
            }

        ]
    });
        //alert(eachMonthTotal.length);


    function triggerCLcikById(idDesc){

        $('#'+idDesc).click();
    }


    function calculateDepreciationValue(){

        var selectedAge = $('#selected_age').val();
        var selectedBrand = $('#selected_model').val();
        var currentValue = $('#current_value').val();

        var url = '{{route('settings.calculateDepreciationValue')}}';
        $('.result-display').hide();

        //alert('selectedBrand : '+selectedBrand);
        $.ajax({

            url: url,
            data: {selectedAge: selectedAge, selectedBrand: selectedBrand },
            cache: false,
            //contentType: false,
            //processData: false,
            dataType:'json',
            method: 'GET',
            success: function(data){

                $('#result_class').val(data.classname);
                $('#result_percentage').val(data.percentage+'%');

                var afterDepreciationValue = (parseInt(data.percentage)/100)*parseInt(currentValue);

                afterDepreciationValue = (afterDepreciationValue).toLocaleString('en',{'minimumFractionDigits':2,'maximumFractionDigits':2});

                $('#after_depreciation_value').val(afterDepreciationValue);

                $('.result-display').show();



            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(xhr.status);
                var err = eval("(" + xhr.responseText + ")");
                //alert(err.Message);



            }
            });


    }

</script>
<script type="text/javascript">

</script>
</body>
