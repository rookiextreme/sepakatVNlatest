@php
    $tab = Request('tab') ? Request('tab') : null;
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
    <link rel="stylesheet" href="{{ asset('my-assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">

    <script type="text/javascript" src="{{ asset('my-assets/plugins/moment/js/moment.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('my-assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.ms.js') }}"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
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
            margin-right: 3px;
            border: transparent;
            background: #dbdcd8;
        }

        .input-group.date .input-group-text {
            height: 39px;
            margin-left: 4px !important;
            border: transparent;
            background: #dbdcd8;
        }

        .select2-container--open {
            z-index:1060;
        }

        .inline-label {
            display: contents;
        }

        .scrollable-horizontal {
            width: 100%;
            height: 10vh;
            overflow-x: scroll;
            white-space: nowrap;
            border-left: 3px solid #969690;
            border-right: 3px solid #969690;
        }

        .scrollable-vertical {
            height: 400px;
            overflow-y: scroll;
            white-space: nowrap;
            scroll-behavior: smooth;
        }

        .item {
            padding: 5px;
            display: inline-block;
            border-radius: 15px;
            border: 1px solid #969690;
            color: #969690;
            text-decoration: none;
        }
        .item.selected, .item:hover {
            cursor: pointer;
            color: white;
            background: #969690;
        }

        body.modal-open {
            height: 100vh;
            overflow-y: hidden;
        }

        .table-custom-local {
            border-spacing: 0;
            border-collapse: separate !important;
            border-color:#d7d7de;
            border-width: 2px;
        }
        .table-custom-local thead th:first-of-type {
            border-color:#d7d7de;
            border-left-width: 0px;
            border-top-width: 0px;
            border-bottom-width: 2px;
            border-right-width: 0px;
            text-align: center;
        }

        .table-custom-local thead th {
            border-color:#d7d7de;
            border-left-width: 0px;
            border-right-width: 0px;

            border-top-width: 0px;
            border-bottom-width: 2px;
            text-align: center;
            font-family:avenir-bold !important;
            font-size: 12px !important;
            color:#393728 !important;
            text-align: left;
            line-height: 12px;
            font-weight:200;
            text-transform: uppercase;
            vertical-align: bottom;
        }
        .table-custom-local thead th:last-of-type {
            border-radius: 0px 8px 0px 0px;
            -moz-border-radius: 0px 8px 0px 0px;
            -webkit-border-radius: 0px 8px 0px 0px;
            border-color:#d7d7de;
            border-left-width: 0px;
            border-bottom-width: 2px;
            border-right-width: 0px;
        }
        .table-custom-local thead th.special {
            background-color:#ffffff;
            border-radius: 8px 8px 0px 0px;
            -moz-border-radius: 8px 8px 0px 0px;
            -webkit-border-radius: 8px 8px 0px 0px;
        }
        .table-custom-local tbody tr {
            border-top-style: none;
            border-top-color: none;
            border-top-width: 0px;
        }
        .table-custom-local tbody tr td {
            border-right-color:#d7d7de;
            border-right-width: 0px;
            border-right-style: solid;
            border-left-color:#d7d7de;
            border-left-width: 0px;
            border-left-style: solid;
            border-top-style: none !important;
            border-top-color: none !important;
            font-family: mark;
            font-size:14px;
            height:18px;
            vertical-align: top !important;
            line-height:16px;
            border-bottom-style: none;
            border-bottom-color: #d7d7de;
            border-bottom-width: 1px;
        }
        .table-custom-local tbody tr td.special {
            background-color:#ffffff;
        }
        .table-custom-local tbody tr td:last-of-type {
            border-right-style: none;
            border-right-color:#d7d7de;
            border-right-width: 0px;
        }
        .table-custom-local tbody tr td a {
            font-family: mark-bold;
            text-decoration: none;
            font-size:14px;
            height:18px;
            color:#393728;
            vertical-align: top !important;
            line-height:16px;
            cursor: pointer;
        }
        .table-custom-local tbody tr td a:hover {
            color:orange;
        }
        .table-custom-local tfoot td {
            height:10px;
            line-height:10px;
            border-left-width: 0px;
            border-right-width: 0px;
            background-color:transparent !important;
        }
        .table-custom-local tfoot td.special {
            background-color:#ffffff !important;
            border-radius: 0px 0px 8px 8px;
            -moz-border-radius: 0px 0px 8px 8px;
            -webkit-border-radius: 0px 0px 8px 8px;
        }

        tbody tr:hover {
            background-color: transparent;
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
</head>
<body class="content">

    @php
        $vehicleTypeName = "Proton Saga";
        $vehiclePlateNo = "BND2183";

        $postcode = "50614";
        $stateName = "Kuala Lumpur";

        $placementName = "JKR WORKSYOP PERSEKUTUAN";
        $appointmentDt = \Carbon\Carbon::now()->format('d M Y');

        $officerName = "En. Asmawe bin Abd Wahab";
        $officerTelno = "03-9206400";

        $signatureQoute = "\"WAWASAN KEMAKMURAN BERSAMA 2030\"";
        $officerName = auth()->user()->name;
        $officerDesignation = auth()->user()->hasRole()->designation;
        $officerAddress = auth()->user()->detail->address;
    @endphp

    <div class="table-responsive">
        <table class="table table-borderless" style="width: 100%">
            <tr>
                <td style="width: 50px"><img src="{{ asset('my-assets/img/logo_negara_small.png') }}" width="100%" alt=""></td>
                <td style="width: 300px;">
                    JABATAN KERJA RAYA MALAYSIA<br/>
                    Ketua Juruta Makenikal<br/>
                    (JKR Woksyop Persekutuan Mekanikal, Bahagian Perhidmatan Harta)<br/>
                    No. 2. Jalan Arowana , Cheras
                    55300 KUALA LUMPUR
                </td>
                <td style="width: 200px;">
                    <table class="float-end">
                        <tr>
                            <td>Telefon</td><td>:</td><td>03-92064000</td>
                        </tr>
                        <tr>
                            <td>Faks</td><td>:</td><td>03-92831285</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div style="border: 1px solid rgba(0, 0, 0, 0.30);"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table class="float-end">
                        <tr>
                            <td>Ruj. Kami</td><td>:</td><td>JKR.WSP.030-1/3 Jld . 34 (68)</td>
                        </tr>
                        <tr>
                            <td>Tarikh</td><td>:</td><td>25 Ogos 2021</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    {{-- todo govAgencyStaff / jkrStaff for division --}}
                    <table class="float-start">
                        <tr>
                            <td>{{auth()->user()->hasRole()->designation}}</td>
                        </tr>
                        <tr>
                            <td>{{(auth()->user()->detail->govAgencyStaff ? auth()->user()->detail->govAgencyStaff->division_desc : null) ?:
                                (auth()->user()->detail->jkrStaff ? auth()->user()->detail->jkrStaff->division_desc : null)}}</td>
                        </tr>
                        <tr>
                            <td>{{auth()->user()->detail->address}}</td>
                        </tr>
                        <tr>
                            <td><span class="" style="text-decoration: underline;">{{$postcode}} {{$stateName}}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    Tuan/Puan,
                </td>
            </tr>
            <tr>
                <td colspan="3" class="form-label fs-5" style="line-height: 21px">
                    PEMERIKSAAN DAN PENILAIAN KEROSAKAN KENDERAAN JABATAN JENIS {{$vehicleTypeName}} NO. PENDAFTARAN : {{$vehiclePlateNo}}
                    <div style="border: 1px solid rgb(71, 71, 71);"></div>
                </td>
            </tr>

            <tr>
                <td colspan="3" class="" style="line-height: 21px">
                    Dengan segala hormatnya, kami merujuk perkara di atas.
                </td>
            </tr>

            <tr>
                <td colspan="3" class="" style="line-height: 21px">
                    2. Untuk makluman pihak tuan, pihak kami telah melaksanakan pemeriksaan ke atas kenderaan berkenaan di
                    <label class="text-dark">{{$placementName}}</label> pada <label class="text-dark">{{$appointmentDt}}</label> dan mencadangkan kerja-kerja pembaikan berikut:
                </td>
            </tr>

            @php
                $totalBudget = 6300.00;
            @endphp

            <tr>
                <td colspan="3" class="">
                    <div class="form-group">
                        <span class="btn cux-btn small"> <i class="fa fa-plus"></i> Tambah</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%">
                            <thead>
                                <th class="align-top">Bil</th>
                                <th class="align-top">Perincian</th>
                                <th class="align-top">Simptom/Kerosakan</th>
                                <th class="align-top">Keperluan Penukaran Alat Ganti</th>
                                <th class="align-top">Anggaran</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="5">Tiada Rekod</td>
                                </tr>
                                {{-- <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>

            @php
                $f = new NumberFormatter("ms", NumberFormatter::SPELLOUT);
            @endphp
            <tr>
                <td colspan="3" class="" style="line-height: 21px">
                    3. Pihak kami telah menganggarkan kos pembaikan melibatkan alat ganti tulen dan
                    upah pemasangan adalah lebih kurang RM {{number_format($totalBudget,2)}} ( Ringgit Malaysia : {{ucwords($f->format($totalBudget))}} Sahaja ).
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    4.	Anggaran ini adalah berdasrkan pemeriksaan fizikal sahajja. Sekiranya terdapat pertambahan kerja-kerja pembaikan,pihak
                    tuan boleh merujuk semula kepada pihak kami untuk tujuan pengesahan semula.
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    5. Sekiranya ingin penjelasan lanjut mengenai perkara ini,
                    pihak tuan boleh menghubungi pegawai kami {{$officerName}}  di talian {{$officerTelno}}.
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    Sekian. Terima Kasih<br/>

                    <label for="" class="form-label">{{$signatureQoute}}</label><br/>

                    <label for="" class="mt-2">Saya yang menurut perintah,</label><br/>

                    <div class="mt-5" style="width: 200px; border-bottom: 1px solid black;"></div>
                    <br/>
                    {{-- {{$officerName}}<br/>
                    {{$officerDesignation}}<br/>
                    {{$officerAddress}}<br/> --}}
                    b.p KETUA JURUTERA MEKANIKAL<br/>

                </td>
            </tr>

        </table>
    </div>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script>

        function show(element){
            $(element).show();
        }

        function selectHash(self){

            $('.selected').removeClass('selected disabled');

            let hash = window.location.hash;
            $(self).addClass('selected disabled');
        }

        let currentOffset = 0;

        $(document).ready(function(){
            initTab();
            let tab = '{{$tab}}';
            $('#tab'+tab).trigger('click');

            $('select').select2({
                width: '100%',
                theme: "classic"
            });

        });

    </script>


</body>

</html>
