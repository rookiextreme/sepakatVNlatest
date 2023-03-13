@php
$title = 'Daftar Kenderaan';
$subTitle = 'Pendaftaran Kenderaan Ke Dalam Sistem SPAKAT';
$roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

if(Request('id') > 0){
    $title = 'Maklumat Kenderaan';
    $subTitle = 'Maklumat Kenderaan Sistem SPAKAT';
}

use App\Http\Controllers\Maintenance\NonJKR\MaintenanceNonJKRDAO;

$MaintenanceNonJKRDAO = new MaintenanceNonJKRDAO();
$MaintenanceNonJKRDAO->mount(Request());
$id = $MaintenanceNonJKRDAO->id;
$vehicleDetail = $MaintenanceNonJKRDAO->vehicleDetail;
$detail = $MaintenanceNonJKRDAO->detail;
$is_display = $MaintenanceNonJKRDAO->is_display;
$maintenance_type_list = $MaintenanceNonJKRDAO->maintenance_type_list;
$states = $MaintenanceNonJKRDAO->states;
$categoryList = $MaintenanceNonJKRDAO->categoryList;
$brands = $MaintenanceNonJKRDAO->brands;
$vehicle = $MaintenanceNonJKRDAO->vehicle;

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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

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

        .bootstrap-datetimepicker-widget.dropdown-menu {
            display: block;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        /* Start Vehicle Detail Style */

        .polaroid {
            background-color:#ffffff;
            padding:5px;
            max-width:200px;
            height:165px;
            text-align: center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
            border-style: solid;
            border-color:#c8c8cc;
            border-width:1px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
            transition: all .2s ease-in-out;
        }
        .polaroid .plet-no {
            font-family: mark-bold;
            font-size:16px;
            color:#272624;
            text-align: left;
            margin-left:5px;
            line-height: 35px;
        }
        .plate-highlight {
            font-family: avenir-bold;
            font-size:14px;
            color:#595959;
            text-transform: uppercase;
        }
        .box-left {
            margin-left:auto;
            margin-right:auto;
            margin-top:3px;
            max-width:180px;
            height:120px;
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center center;
            border-radius: 4px 4px 4px 4px;
            -moz-border-radius: 4px 4px 4px 4px;
            -webkit-border-radius: 4px 4px 4px 4px;
        }
        .box-right {
            float:left;
            width:80%;
            padding-top:5px;
            margin-left:20px;
        }

        .box-info .rlabel {
            float:left;
            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:12px;
            line-height: 30px;
            text-align: left;
            width:auto;
        }
        .box-info .mytext {
            float:right;
            font-family: mark;
            font-size:12px;
            width:auto;
            line-height: 30px;
            text-align: right;
        }
        .box-info {
            width:100%;
            border-bottom-style: solid;
            border-bottom-color:#e3e3eb;
            border-bottom-width:1px;
            padding-left:0px;
            padding-right:0px;
            height:30px;
        }
        /* End Vehicle Detail */

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

            .polaroid {
                margin-left: 15px;
            }

            .box-info{
                padding-left:15px;
                padding-right:15px;
            }

        }

        @media (max-width: 575.98px) {
            /*X-Small devices (portrait phones, less than 576px)*/
            /*x-small*/
        }

    </style>
    <script>

        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var currentTab = 1;

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

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Penilaian</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item"><a href="#">Penilaian</a></li>
            {{-- <li class="breadcrumb-item"><a href="{{ route('maintenance.job.list') }}">Penyengaraan</a></li> --}}
            <li class="breadcrumb-item active" aria-current="page">Permohonan</li>
        </ol>
    </nav>
    <div class="main-content">
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active" onClick="goTab(this, 'vehicle');" id="tab1">Kenderaan</li>

                        <li class="cub-tab" onClick="goTab(this, 'detail');" id="tab2">Penilaian</li>

                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>

        <section id="vehicle" class="tab-content">
            @include('assessment.job-vehicle')
        </section>

        <section id="detail" class="tab-content">
            @include('assessment.job-detail')
        </section>

        <div class="modal fade" id="submitForAppointmentNonJKRModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitForAppointmentNonJKRModalLabel" aria-hidden="true" style="background-color: #f4f5f2;">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    Anda pasti untuk menghantar ? tekan butang hantar untuk teruskan
                </div>
                <div class="modal-footer float-start">
                    <button type="button" class="btn btn-secondary" id="close_action_modal" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-secondary" id="back_to_list" onclick="backToList()" style="display: none;" data-bs-dismiss="modal">Tutup</button>
                    <span type="button" class="btn btn-module" xaction="appointment" >Hantar</button>
                </div>
            </div>
            </div>
        </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">

        var paramTab = {{Request('tab')? Request('tab') : 1}};

        function backToList(){
            window.location = "{{route('vehicle.list-alternate')}}";
        }

        function goToSummonList(){
        window.location = "{{route('vehicle.saman.rekod')}}";
    }

    function promptSubmitForPaymentModal(){
        $('#promptSubmitForPaymentModal #remove').show();
        $('#promptSubmitForPaymentModal #close').show();
    }

    function submitForPayment(){
        $('#promptSubmitForPaymentModal #remove').hide();
        $('#promptSubmitForPaymentModal #close').hide();

        var formData = $('#frm_detail').serialize();

        formData += '&_token={{ csrf_token() }}';

        $.ajax({
            url: "{{route('vehicle.saman.submitForPayment')}}",
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if(response.code == '200') {
                    $('#promptSubmitForPaymentModal .sub-title').text(response.message);
                }
                $('#promptSubmitForPaymentModal #reload').show();
            },
            error: function(response) {
                console.log(response.responseJSON.exception);

                $('#promptSubmitForPaymentModal').modal('hide');

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

        $(document).ready(function() {
            initTab();

            var hash = window.location.hash;

            switch (paramTab) {
                case 2:
                $('#tab2').click();
                    break;
                case 3:
                $('#tab3').click();
                    break;

                default:
                    break;
            }
            $('select').select2({
                width: '100%',
                theme: "classic"
            });

            $('[xaction="appointment"]').on('click', function(e){
                e.preventDefault();

                $('#submitForAppointmentNonJKRModal .modal-body').text('Sila tunggu...');
                hide('#close_action_modal');
                hide('[xaction="appointment"]');

                $.post("{{route('maintenance.job.submitForAppointmentNonJKR')}}", {
                    '_token': '{{ csrf_token() }}'
                }, function(result){
                    if(result==1){
                        var message = 'Maklumat berjaya dihantar';
                        $('#submitForAppointmentNonJKRModal .modal-body').text(message);
                        show('#back_to_list');
                    }
                });

            });


        });

    </script>
</body>

</html>
