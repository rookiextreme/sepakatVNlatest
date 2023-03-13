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
    <div class="mytitle">Rekod Saman</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('/dashboard');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Kenderaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rekod Pembayaran Saman</li>
        </ol>
    </nav>
    <div class="main-content">
        <form class="form-submit" id="the_form">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <th class="align-top text-center"></th>
                        <th class="align-top">Status Saman</th>
                        <th class="align-top">Jenis Saman</th>
                        <th class="align-top">Nombor Kenderaan</th>
                        <th class="align-top">Nombor Rujukan Saman</th>
                        <th class="align-top">Kesalahan</th>
                        <th class="align-top">Tarikh Waktu Kesalahan</th>
                        <th class="align-top text-end">Jumlah Kompaun</th>
                    </thead>
                    <tbody id="sortable">
                        @foreach ($summon_list as $summon)
                            @php

                                $categoryName = '';
                                $subCategoryName = '';

                                if ($summon->pendaftaran->maklumat) {
                                    if ($summon->pendaftaran->maklumat->hasCategory()) {
                                        $categoryName = $summon->pendaftaran->maklumat->hasCategory()->name;
                                    }

                                    if ($summon->pendaftaran->maklumat->hasSubCategory()) {
                                        $subCategoryName = $summon->pendaftaran->maklumat->hasSubCategory()->name;
                                    }
                                }

                                $mistakeDate = $summon->maklumatSaman ? $summon->maklumatSaman->mistake_date : '';
                                if($mistakeDate){
                                    $mistakeDate = \Carbon\Carbon::createFromFormat('Y-m-d', $mistakeDate)->format('d/m/Y');
                                }

                                $mistakeTime = $summon->maklumatSaman ? $summon->maklumatSaman->mistake_time : '';
                                if($mistakeTime){
                                    $mistakeTime = \Carbon\Carbon::createFromFormat('H:m:s', $mistakeTime)->format('h:m A');
                                }

                            @endphp
                            <tr>
                                <td class="text-center align-top">
                                    @if($summon->statusSaman->code == '02')
                                    <a class="btn btn-module" href="{{route('vehicle.saman.daftarbayar', [ 'id' => $summon->id, 'vehicle_id' => $summon->pendaftaran->id, 'tab' => 2])}}"> Bayar Saman</a>
                                    @else
                                    {{-- <a class="btn cux-btn small" href="{{route('vehicle.saman.daftarbayar', [ 'summon_id' => $summon->id, 'vehicle_id' => $summon->pendaftaran->id, 'tab' => 1])}}"> <i class="fa fa-info"></i></a> --}}
                                    @endif
                                </td>
                                <td class="align-top">{{$summon->statusSaman->name}}</td>
                                <td class="text-uppercase align-top">
                                    {{ $summon->maklumatSaman ? $summon->maklumatSaman->hasSummonType->desc : '' }}</td>
                                <td><a class="text-uppercase"
                                        href="{{ route('vehicle.register', ['id' => $summon->pendaftaran->id, 'fleet_view' => $summon->pendaftaran->table_type, 'tab' => 1]) }}?is_display=1">{{ $summon->pendaftaran->no_pendaftaran }}</a>
                                </td>
                                <td class="align-top">{{ $summon->maklumatSaman ? $summon->maklumatSaman->summon_notice_no : '' }}</td>
                                <td class="align-top">{{ $summon->maklumatSaman->compound_reason }}</td>
                                <td class="align-top text-center">{{  $mistakeDate.' '. $mistakeTime}}</td>
                                <td class="align-top text-end">
                                    {{ number_format((float) $summon->maklumatSaman->total_compound, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $summon_list->links('pagination.default') }}
        </form>

    </div>

    <script>

        var checkedList = [];

        function getCurrentChecked(){
            checkedList = [];
            $('#chkdel:checked').map(function() {
                checkedList.push(parseInt(this.value));
            });

            return checkedList;
        }

        function remove(){
            $('#summonDelModal #remove').hide();
            $('#summonDelModal #close').hide();
            $.post("{{route('vehicle.saman.delete')}}", {
                checkedList: checkedList,
                '_token': '{{ csrf_token() }}'
            },  function(result){
                if(result.code == '200') {
                    $('#summonDelModal .sub-title').text(result.message);
                }
                $('#summonDelModal #reload').show();
            })
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

    </script>
</body>

</html>
