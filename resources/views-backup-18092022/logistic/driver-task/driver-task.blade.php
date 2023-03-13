@php
$title = 'Daftar Tempahan Kenderaan';
$subTitle = 'Pendaftaran Tempahan Kenderaan Ke Dalam Sistem SPAKAT';
@endphp

@if (request('booking_id') > 0)
    @php
        $title = 'Maklumat Tempahan Kenderaan';
        $subTitle = 'Maklumat Tempahan Kenderaan Sistem SPAKAT';
    @endphp
@endif

@php

use App\Http\Controllers\Logistic\Task\LogisticTaskDriverDAO;

$tab = request('tab') ? request('tab') : '';
$LogisticTaskDriverDAO = new LogisticTaskDriverDAO();

$booking_id = request('booking_id');
$category = request('category');
$finger_print_id = request('fingger_print_id') ? request('fingger_print_id') : null;
$LogisticTaskDriverDAO->read($booking_id, $category);
$detail = $LogisticTaskDriverDAO->detail;
$is_display = $LogisticTaskDriverDAO->is_display;

$TaskFlowAccessLogistic= auth()->user()->vehicleWorkFlow('04', '01');

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
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }
        
        .rlabel {
            font-family:lato-bold;
            text-transform: uppercase;
            letter-spacing: 0px;
            color:#1f1f1f;
            font-size:14px;
            line-height: 36px;
            text-align: left;
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

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function downloadFile(filePath, name){
            var link=document.createElement('a');
            link.href = filePath;
            link.download = name+'-'+filePath.lastIndexOf('/') + 1;
            link.click();
        }

        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Maklumat Tugasan</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('logistic.driver-task') }}">Rekod Tugasan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Maklumat Tugasan</li>
        </ol>
    </nav>
    <div class="main-content">
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    @if(count($detail->hasManyAssignedVehicleWithDriver) == 0 && auth()->user()->isDriver())
                    @else
                    <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Maklumat Tugasan</li>
                    <li class="cub-tab"  onClick="goTab(this, 'update_task');" id="tab2">Kemaskini Tugasan</li>
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>

        @if(count($detail->hasManyAssignedVehicleWithDriver) == 0 && auth()->user()->isDriver())
            
        @else
        <section id="detail" class="tab-content">
            @include('logistic.driver-task.tab.driver-task-detail')
        </section>
        <section id="update_task" class="tab-content">
            @include('logistic.driver-task.tab.driver-update-task')
        </section>
        @endif

        <div id="resultScan"></div>

        {{-- driverTaskDoneModal --}}

        <div class="modal fade" id="driverTaskDoneModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="driverTaskDoneModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    Adakah tugasan anda sudah selesai?
                </div>
                <div class="modal-footer">
                    <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                    <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                    <span class="btn btn-danger" xaction="task_done" >Ya</span>
                </div>
            </div>
            </div>
        </div>
    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">

        function backToList(){
            window.location = "{{route('logistic.driver-task')}}";
        }

        function verifyTaskByQR(){
            @if ($finger_print_id)
                $.post('{{route('logistic.driver.task.scanqr')}}', {
                        'finger_print_id' : '{{$finger_print_id}}',
                        'booking_id': '{{request('booking_id')}}',
                        'category': '{{request('category')}}',
                        '_token':'{{ csrf_token() }}'
                    }, function(data){
                        if(data.is_scan == 1){
                            $('#resultScan').html('<div class="text-center text-uppercase mt-3"><span class="text-success">Sudah diimbas</span></div>')
                        } else if(data.isDriver == 0) {
                            $('#resultScan').html('<div class="text-center text-uppercase mt-3"><span class="text-danger">Bukan Pemandu</span></div>')
                        }
                });
            @endif
        }

        $(document).ready(function() {
            initTab();
            verifyTaskByQR();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic"
            });

            $('[xaction="task_done"]').on('click', function(e){
                e.preventDefault();

                hide('[xaction="task_done"]');
                hide('[xaction="no"]');

                var ids = [];

                @if($detail)
                    ids.push({{$detail->id}});
                @endif

                $.post('{{route('logistic.driver.task.done')}}', {
                    'ids': ids,
                    'category': '{{request('category')}}',
                    '_token':'{{ csrf_token() }}'
                }, function($data){
                    $('#driverTaskDoneModal .modal-body').text('Tugasan ini telah diselesaikan.');
                    show('[xaction="close"]');
                });

                $('[xaction="close"]').on('click', function(){
                    backToList();
                })
            });

            parent.stopLoading();
        })

    </script>
</body>

</html>
