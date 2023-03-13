@php
   $AccessMaintenance = auth()->user()->vehicle('03', '02');
   $TaskFlowAccessMaintenanceJob = auth()->user()->vehicleWorkFlow('03', '02');
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

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .cursor-pointer {
            cursor: pointer;
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
        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    <div class="mytitle">Penilaian</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('vehicle.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Penilaian</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekod Penilaian</li>
        </ol>
    </nav>

    <div class="quick-navigation" data-fixed-after-touch="">
        <div class="wrapper" style="position: relative">
            <ul id="tabActive">
                <li class="cub-tab active" onClick="goTab(this, 'vehicle');" id="tab1">Dalam Proses</li>

                <li class="cub-tab" onClick="goTab(this, 'detail');" id="tab2">Sejarah</li>
            </ul>
            <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
        </div>
    </div>

    <section id="vehicle" class="tab-content">
        @include('maintenance.nonjkr.tab.maintenance-job-record-inprogress')
    </section>

    <section id="detail" class="tab-content">
        @include('maintenance.nonjkr.tab.maintenance-job-record-history')
    </section>

    <script>

var paramTab = {{Request('tab')? Request('tab') : 1}};

        var vehicleLimit = 5;
        var vehicleOffset = 0;
        var vehicleSearch = null;
        var checkedList = [];

        function getCurrentChecked(){
            checkedList = [];
            $('#chkdel:checked').map(function() {
                checkedList.push(parseInt(this.value));
            });

            return checkedList;
        }

        function remove(){
            $('#maintenanceJobDelModal #remove').hide();
            $('#maintenanceJobDelModal #close').hide();
            $.post("{{route('maintenance.job.delete')}}", {
                checkedList: checkedList,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#maintenanceJobDelModal .sub-title').text(result.message);
                }
                $('#maintenanceJobDelModal #reload').show();
            })
        }

        function getVehicle(content, self){

            if(content == 'next'){
                vehicleOffset = vehicleOffset + 1;
                callAjaxVehicle();
            } else if(content == 'prev'){
                if(vehicleOffset > 0){
                    vehicleOffset = vehicleOffset - 1;
                    callAjaxVehicle();
                }
            }
            else if(content == 'search'){
                console.log(content, self.value);
                if(self.value != ''){
                    $('#enter').show();
                } else {
                    $('#enter').hide();
                }
                vehicleSearch = self.value;
                if(event.key === 'Enter' || self.value == '') {
                    if(vehicleSearch.length > 0){
                        vehicleOffset = 0;
                    }
                    callAjaxVehicle();
                }
            } else {
                callAjaxVehicle();
            }
        }

        function callAjaxVehicle(){
            $.get("{{route('maintenance.job.ajax.getVehicle')}}", {
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch
                }, function(data){
                    if(data.length > 0){
                        $('#pagination').show();
                    } else {
                        $('#pagination').hide();
                    }
                    $('#vehicleList').html(data);
            });

            $.get("{{route('maintenance.job.ajax.getVehicle.total')}}", {
                    limit: vehicleLimit,
                    offset: vehicleOffset,
                    search: vehicleSearch
                }, function(vehicle){
                    var totalCurrentPage = (vehicleOffset ? ((vehicleOffset+1)*vehicleLimit): vehicleLimit+1 );
                    if(vehicle.total  < totalCurrentPage){
                        totalCurrentPage = vehicle.total;
                    }

                    var totalFrom = vehicleLimit*vehicleOffset+1;
                    $('#vehicleTotal').text('Rekod '+ (vehicleOffset == 0 ? 1 : (vehicle.total > vehicleLimit ? (totalFrom) : vehicle.total) ) + ' - ' + ( totalCurrentPage ) + ' Daripada ' + vehicle.total);
                    if(vehicle.total == 0){
                        $('#vehicleTotal').html('<label>Tiada Rekod</label><label class="ms-2 cux-btn small" onclick="parent.openPgInFrame(\'{{route('vehicle.register')}}\')"><i class="fa fa-plus"> </i> &nbsp;Tambah Kenderaan</label>');
                    }

                    $('#pagination .next').prop('disabled', false);
                    $('#pagination .prev').prop('disabled', false);

                    if(vehicleOffset == 0){
                        $('#pagination .prev').prop('disabled', true);
                    }

                    if(totalFrom == totalCurrentPage || vehicleOffset > 0 && (totalCurrentPage == vehicle.total)){
                        $('#pagination .next').prop('disabled', true);
                    }

                    if(totalCurrentPage <= vehicleLimit){
                        $('#pagination .next').prop('disabled', true);
                        $('#pagination .prev').prop('disabled', true);
                    }

            });
        }

        function selectVehicle(vehicle_id, vehicle_no){
            window.location.href = "{{route('maintenance.job.nonjkr.register')}}?vehicle_id="+vehicle_id;
        }

        $(document).ready(function() {

            $('[name="chkall"]').change(function() {

                $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(checkedList.length > 0){
                    $('#delete_all').prop('disabled', false);
                }

            });

            $('[name="chkdel"]').change(function() {

                $('#delete_all').prop('disabled', true);

                getCurrentChecked();
                if(checkedList.length == $('[name="chkdel"]').length){
                    $('#chkall').prop('checked', true);
                } else {
                    $('#chkall').prop('checked', false);
                }

                if(checkedList.length > 0){
                    $('#delete_all').prop('disabled', false);
                }
            });

        })

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

        });

    </script>
</body>

</html>
