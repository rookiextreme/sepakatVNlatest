@php
$title = 'Daftar Kenderaan';
$subTitle = 'Pendaftaran Kenderaan Ke Dalam Sistem SPAKAT';
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;
@endphp

@if (request('id') > 0)
    @php
        $title = 'Maklumat Kenderaan';
        $subTitle = 'Maklumat Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php
use App\Http\Controllers\Vehicle\Summon\PembayaranSaman;
use App\Http\Controllers\Vehicle\Summon\FormMaklumatKenderaan;
use App\Http\Controllers\Vehicle\Summon\FormMaklumatSaman;

$PembayaranSamanDAO = new PembayaranSaman();

$PembayaranSamanDAO->saman_id = Request('id');
$PembayaranSamanDAO->mount();


$FormMaklumatKenderaanDAO = new FormMaklumatKenderaan();

$FormMaklumatKenderaanDAO->saman_id = Request('id');
$FormMaklumatKenderaanDAO->mount();
$SummonFormVehicle = $FormMaklumatKenderaanDAO->SummonFormVehicle;
$is_display = $FormMaklumatKenderaanDAO->is_display;

$informations = $FormMaklumatKenderaanDAO->informations;

$FormMaklumatSamanDAO = new FormMaklumatSaman();
$FormMaklumatSamanDAO->vehicle_id = request('vehicle_id');
$FormMaklumatSamanDAO->saman_id = $FormMaklumatKenderaanDAO->saman_id;
$FormMaklumatSamanDAO->mount();

$vehicleDetail = $FormMaklumatSamanDAO->vehicleDetail;
$branchs = $FormMaklumatSamanDAO->branchs;
$states = $FormMaklumatSamanDAO->states;
$summonDetail = $FormMaklumatSamanDAO->informations;
$summon = $FormMaklumatSamanDAO->summon;
$summon_agencies = $FormMaklumatSamanDAO->summon_agencies;
$summon_types = $FormMaklumatSamanDAO->summon_types;

$doc_path = isset($summonDetail['payment']) ? $summonDetail['payment']->dokumenPembayaran->path_dokumen : '';
    $doc_name = isset($summonDetail['payment']) ? $summonDetail['payment']->dokumenPembayaran->name_dokumen : '';
    $pathUrl = $doc_path != '' ? '/storage/'.$doc_path.'/'.$doc_name : '';

    $is_changeOwnerShip = isset($summonDetail['change_summon_owner']) && $summonDetail['hasSummonStatus']->code == '04' && $summonDetail['change_summon_owner'] ? true: false;

@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .table {
            width: 100%;
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

        .input-group-text {
            height: 39px;
            margin-left: 2px !important;
            border: transparent;
            background: #dbdcd8;
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
        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var currentTab = 1;

        function hide(element) {
            $(element).hide();
        }

        function show(element) {
            $(element).show();
        }

        function block(element) {
            $(element).prop('disabled', true);
        }

        function release(element) {
            $(element).prop('disabled', false);
        }

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Bayaran Saman</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">Kenderaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle.saman.rekodbayar') }}">Rekod Saman</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bayaran Saman</li>
        </ol>
    </nav>
    <div class="main-content">

        <form class="row" id="frm_payment" enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="user" value="not_admin">
            <input type="hidden" name="hasNewDocument" id="hasNewDocument" value="{{$pathUrl == '' ? 1: 0}}">
            <input type="hidden" name="hasNewDocument1" id="hasNewDocument1" value="{{$pathUrl == '' ? 1: 0}}">
            <fieldset>
                <legend>Tindakan</legend>
                <div class="col-xl-3 col-lg-4 col-md-8 col-sm-8 col-12">
                    <div class="form-group">
                        <label for="" class="form-label text-dark">Kemaskini Maklumat Saman</label>
                        <div class="input-group">
                            <select id="saman_info" class="form-select">
                                <option {{$summonDetail['hasSummonStatus']->code == '05' ? 'selected': ''}} value="3" >Proses Rayuan Pengurangan Saman</option>
                                <option {{!$is_changeOwnerShip && $summonDetail['hasSummonStatus']->code != '05' ?  'selected': ''}} value="1">Kemaskini Pembayaran Saman</option>
                                <option {{$is_changeOwnerShip ?  'selected': ''}} value="2" >Tukar Milik Saman</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>

            <div id="kemaskini" class="form-row container row" style="display:{{!$is_changeOwnerShip ? 'block': 'none'}};">
            <fieldset>
                <legend>Pembayaran</legend>
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Nombor Resit <strong class="text-danger">*</strong> </label>
                            <input type="text" id="receipt_no" autocomplete="off" name="receipt_no" value="{{isset($summonDetail['payment']) ? $summonDetail['payment']->receipt_no : ''}}">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Jumlah Bayaran <strong class="text-danger">*</strong> </label>
                            <div class="input-group">
                                <input type="text" onkeypress="return isNumber(this)" class="form-control" id="total_payment" autocomplete="off" name="total_payment" value="{{isset($summonDetail['payment']) ? $summonDetail['payment']->total_payment : ''}}">
                                <span class="input-group-text">{{number_format((float)$summonDetail['total_compound'], 2)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-4 col-12">
                        <div class="form-group">
                            <label for="" class="form-label text-dark">Tarikh Bayaran <strong class="text-danger">*</strong> </label>
                            <div class="input-group date" id="payment_date">
                                <input autocomplete="off" name="payment_date" id="payment_date_input"
                                            type="text" class="form-control datepicker" placeholder=""
                                            autocomplete="off"
                                            data-provide="datepicker" data-date-autoclose="true"
                                            data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                                            value="{{isset($summonDetail['payment']) ? \Carbon\Carbon::parse($summonDetail['payment']->payment_date)->format('d/m/Y') : ''}}"/>
                                <div class="input-group-text" for="payment_date">
                                    <i class="fal fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                        <label for="" class="form-label text-dark">Kaedah Bayaran <strong class="text-danger">*</strong> </label>
                        <input type="text" id="payment_method" autocomplete="off" name="payment_method" value="{{isset($summonDetail['payment']) ? $summonDetail['payment']->payment_method : ''}}">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Bukti</legend>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5 col-12">
                    <label for="" class="form-label text-dark">Dokumen Pembayaran<strong class="text-danger">*</strong> </label>
                    <label class="btn cux-btn small mb-2" for="doc_payment">{{$pathUrl == '' ? 'Muat Naik' : 'Tukar Fail'}}</label>
                    <input type="file" class="form-control d-none" accept="application/pdf,image/*" name="dokumen_kemaskini" id="doc_payment">
                    <div id="preview-file" class="form-group mb-2" style="display: none;height: 200px;
                    overflow: auto;">
                        <embed src="{{$pathUrl}}" id="preview-file-embed" width="100%" type="">
                    </div>
                </div>
            </fieldset>
            </div>

            <div id="tukar" class="form-row container row" style="display:{{$is_changeOwnerShip ? 'block': 'none'}};">
                <div class="col-md-4" >
                    <label for="" class="form-label text-dark">Nama Pemandu <strong class="text-danger">*</strong> </label>
                    <input type="text" id="nama_pemandu" autocomplete="off" name="nama_pemandu" value="{{isset($summonDetail['nama_pemandu']) ? $summonDetail['nama_pemandu'] : ''}}">
                </div>
                <div class="col-md-8">
                    <div class="col-md-12">
                        <label for="" class="form-label text-dark">Dokumen Sokongan</label>
                            <span class="btn cux-btn bigger mb-2" data-bs-toggle="modal" data-bs-target="#addMoreSupportDocModal"> <i class="fa fa-plus"></i> Tambah</span>
                            <div id="support-docs" style="width: 400px; overflow-x: hidden; padding: 10px;">
                                {{-- @include('vehicle.tab.detail-support-docs') --}}
                            </div>
                    </div>
                </div>
            </div>

            <div></div>

            <div class="col-md-12">
                <div class="col-3 mt-4">
                    <div class="form-group center">
                        <button class="btn btn-module text-white" type="submit" xaction="simpan">Simpan</button>
                        <button class="btn btn-module text-white" type="submit" xaction="submitPrompt">Simpan</button>
                        {{-- @if(isset($summonDetail['change_summon_owner']) && !$summonDetail['change_summon_owner'])
                            <span class="btn cux-btn bigger" data-bs-toggle="modal" data-bs-target="#changeSummonOwnerModal">Tukar Milik Saman</span>
                        @endif --}}
                        {{-- @if($summonDetail && isset($summonDetail['dokument_pembayaran']) ? $summonDetail['dokument_pembayaran']->total_payment : '') --}}
                            <button class="btn btn-module" xaction="hantarPrompt" type="button" data-bs-toggle="modal" onclick="submitPaymentModal()" data-bs-target="#submitPaymentModal">Hantar</button>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>

        </form>
        @if(isset($summonDetail['change_summon_owner']) && !$summonDetail['change_summon_owner'])

        <div class="modal fade" id="changeSummonOwnerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeSummonOwnerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="frmChangeSummonOwner" action="" method="post">
                        @csrf
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <div>
                                Adakah anda ingin menukar pemilik saman ini ?
                            </div>
                            <div class="form-group">
                                <label for="note">Nota</label>
                                <textarea class="form-control" name="note" id="note" cols="30" rows="5"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer float-start">
                            <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                            <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                            <button class="btn btn-danger" xaction="change_summon_owner" type="submit" >Ya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endif

        <div class="modal fade" id="addMoreSupportDocModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addMoreSupportDocModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="frmSupportDoc" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="supportDoc" class="form-label">Muat naik dokument sokongan <span class="btn cux-btn">&nbsp;<i class="fa fa-upload fa-2x"></i></span></label>
                                <input class="form-control d-none" accept="image/*" name="support_doc" type="file" id="supportDoc" />
                            </div>
                            <div class="form-group">
                                <div id="preview-image" class="text-center" style="display: none;">
                                    <img src="" id="preview-image-output" width="100%"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="pic_desc" class="form-control" id="pic_desc" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer float-start">
                            <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-module" xaction="upload_image" >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="submitPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                <h3 class="title"></h3>
                <p class="sub-title">
                    Adakah maklumat saman telah lengkap?
                    Maklumat ini akan dihantar ke senarai menunggu proses pembayaran
                </p>
            </div>
            <div class="modal-footer float-start">
              <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
              <button type="button" style="display: none" id="reload" class="btn btn-secondary" onclick="goToSummonList()">Tutup</button>
              <button type="button" id="remove" class="btn btn-danger text-white" onclick="submitPaymentSaman()">Ya</button>
            </div>
          </div>
        </div>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">

        let is_existSupportDocs = false;

        var currentPreviewFile = "{{$pathUrl}}";
        var currentPreviewFile2 = "{{$pathUrl}}";


        function getSupportDocs(){
            $.get('{{route('vehicle.saman.ajax.getSupportDocs')}}', {
                'is_display': '{{$is_display}}'
            }, function(result){
                $('#support-docs').html(result)
            });
        }

        function checkExistSupportDocs(){
            $.get('{{route('vehicle.saman.ajax.checkExistSupportDocs')}}', function(result){
                is_existSupportDocs = result.is_existed;
                let targetBtnSubmit = $('#frm_payment').find('[xaction="simpan"]');
                let targetBtnHantar = $('#frm_payment').find('[xaction="hantarPrompt"]');
                if(is_existSupportDocs){
                    targetBtnSubmit.show();
                    targetBtnHantar.show();
                } else {
                    targetBtnSubmit.hide();
                    targetBtnHantar.hide();
                }
            });
        }

        function checkExistPaymentDocs(){
            $.get('{{route('vehicle.saman.ajax.checkExistPaymentDocs')}}', function(result){
                is_existSupportDocs = result.is_existed;
                let targetBtnSubmit = $('#frm_payment').find('[xaction="submitPrompt"]');
                let targetBtnHantar = $('#frm_payment').find('[xaction="hantarPrompt"]');
                if(is_existSupportDocs){
                    targetBtnSubmit.show();
                    targetBtnHantar.show();
                } else {
                    targetBtnSubmit.hide();
                    targetBtnHantar.hide();
                }
            });
        }

        function changeSummonOwner(formData){
            $.ajax({
                url: "{{ route('vehicle.saman.changeSummonOwner') }}",
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                method: 'POST',
                success: function(response) {
                    window.location.reload();
                },
                error: function(response) {
                    console.log(response);
                    var errors = response.responseJSON.errors;

                    var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div';

                    $('.messages').html(errorsHtml);
                }
            });
        }

        function submitPayment(data){

            parent.startLoading();
            $.ajax({
                url: "{{ route('vehicle.saman.receipt.upload.post') }}",
                type: 'post',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    window.location = response['url'];
                    checkExistPaymentDocs();
                },
                error: function(response) {
                    console.log(response);
                    var errors = response.responseJSON.errors;

                    var errorsHtml = '<div class="alert alert-danger mb-0 pb-0"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div';

                    $('.messages').html(errorsHtml);
                    parent.stopLoading();
                }
            });
        }

        function submitPaymentModal(){
            $('#submitPaymentModal #remove').show();
            $('#submitPaymentModal #close').show();
            console.log("This Modal");
        }

        function submitPaymentSaman(){
            $('#submitPaymentModal #remove').hide();
            $('#submitPaymentModal #close').hide();

            var saman_info = $('#saman_info').val();
            var formData = $('#frm_payment').serialize();

            formData += '&_token={{ csrf_token() }}';
            formData += '&saman_info='+saman_info;

            $.ajax({
                url: "{{route('vehicle.saman.submitForPaymentConfirm')}}",
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if(response.code == '200') {
                        $('#submitPaymentModal .sub-title').text(response.message);
                    }
                    $('#submitPaymentModal #reload').show();
                },
                error: function(response) {
                    console.log(response.responseJSON.exception);

                    $('#submitPaymentModal').modal('hide');

                    if(response.responseJSON.exception == "ErrorException"){

                        var errorsHtml = '<div class="alert alert-danger">'+response.responseJSON.message+'</div>';

                    } else {

                        var errors = response.responseJSON.errors;

                        var errorsHtml = '<div class="alert alert-danger mb-0 pb-0">Maklumat Saman <br/><ul>';

                        $.each(errors, function(key, value) {

                            if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }

                            errorsHtml += '<li>' + value[0] + '</li>';
                        });
                        errorsHtml += '</ul></div';

                        $('#tab2').click();
                    }
                    $('.messages').html(errorsHtml);
                }
            });
        }

        function goToSummonList(){
            window.location = "{{route('vehicle.saman.rekodbayar')}}";
        }

        function isNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $(document).ready(function() {

            checkExistSupportDocs();

            checkExistPaymentDocs();

            @if ($is_changeOwnerShip)
            getSupportDocs();
            @endif

            @if (!empty($pathUrl))
                $('#preview-file').show();
                $('#preview-file1').show();
            @endif

            $('#doc_payment').on('change', function(e){
                e.preventDefault();

                let url = URL.createObjectURL(e.target.files[0]);
                $('#preview-file-embed').attr('src', url);
                $('#preview-file').show();
                currentPreviewFile = url;
                $('#hasNewDocument').val(1);
                let btnSubmit = $('#frm_payment').find('[xaction="submitPrompt"]');
                if(currentPreviewFile)
                {
                    btnSubmit.show();
                }
                else
                {
                    btnSubmit.hide();
                }

            });

            $('#doc_paymenttukar').on('change', function(e){
                e.preventDefault();

                let url2 = URL.createObjectURL(e.target.files[0]);
                $('#preview-file-embed1').attr('src', url2);
                $('#preview-file1').show();
                currentPreviewFile2 = url2;
                $('#hasNewDocument1').val(1);
                console.log('url 2 file -> ', url2);
            });

            $('#frm_payment').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var saman_info = $("#saman_info").val();
                formData.append('saman_info', saman_info);
                if(saman_info == 2){
                    changeSummonOwner(formData);
                } else {
                    submitPayment(formData);
                }

            });

            //support-docs"

            $('#supportDoc').on('change', function(e){
                e.preventDefault();

                var output = document.getElementById('preview-image-output');
                output.src = URL.createObjectURL(e.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                    $('#preview-image').show();
                    $('#preview-image-output').show();
                }

            });

            $('#frmSupportDoc').on('submit', function(e){
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{route('vehicle.saman.upload.support_doc')}}",
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: false,
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if(response.status == '200') {
                            getsupportDocs();
                        }
                        $('#addMoreSupportDocModal').modal('hide');
                        $('#preview-image-output').attr('src', '').hide();
                        $('#frmSupportDoc')[0].reset();
                        getSupportDocs();
                        checkExistSupportDocs();
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        $.each(errors, function(key, value) {

                            if($('[name="'+key+'"]').parent().find('.text-danger').length == 0){
                                $('[name="'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                            }
                        });

                    }
                });
            });

            $('#frmChangeSummonOwner').on('submit', function(e){
                e.preventDefault();
                let formData = new FormData(this);
                changeSummonOwner(formData);
            });

            $('#tab2').on('click', function(){
                if(currentPreviewFile){
                    $('#preview-file-embed').attr('src', currentPreviewFile);
                }
                if(currentPreviewFile2){
                    $('#preview-file-embed1').attr('src', currentPreviewFile2);
                }
            });

            $('#saman_info').on('change', function() {

                var saman_info = $("#saman_info").val();

                if (saman_info == 1 || saman_info == 3){

                    $('#kemaskini').attr('style','display:block');
                    $('#tukar').attr('style','display:none');

                }
                else if (saman_info == 2){
                    console.log(saman_info);
                    $('#kemaskini').attr('style','display:none');
                    $('#tukar').attr('style','display:block');
                    getSupportDocs();

                }
                else {
                }
            });

        })

    </script>
</body>

</html>
