@php
    session()->put('disasterready_current_detail_id', null);
   $AccessVehicle = auth()->user()->vehicle('04', '02');
   $TaskFlowAccessDisasterReady = auth()->user()->vehicleWorkFlow('04', '02');

   use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
   $DisasterReadyDAO = new DisasterReadyDAO();
   $DisasterReadyDAO->mount(Request());
   $booking_list = $DisasterReadyDAO->booking_list;
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
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">

.sect-top {
        position: fixed;
        left:0px;
        width:100%;
        z-index:4;
        padding-left:28px;
        background-color: #f2f4f0;
        padding-bottom:20px;
        border-bottom-color:#e7e7e7;
        border-bottom-style: solid;
        border-bottom-width:1px;
        margin-left:0px;
        margin-right:0px;
    }
    .sect-top-dummy {
        height:190px;
    }
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
    td.dt-center { text-align: center; }
    .dropdown-item {
        font-family: mark;
        font-size:14px;
    }
    .modal-header {
        font-family: avenir;
        text-transform: uppercase;
        letter-spacing:4px;
        color:black;
        font-size:10px;
    }
    ul.notice li {
        font-family:avenir;
        color:#383631;
        font-size:18px;
        margin-bottom:10px;
    }
    ul.notice li span {
        font-family:avenir-bold;
        color:#191816;
        font-size:18px;
    }
    .dropdown-item i.fa {
        min-width:40px !important;
        text-align:left;
    }
    .dropdown-header {
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:12px;
        color:#6d7466;
    }
    .header-highlight {
        background-color:#49575c;
        font-family: mark-bold;
        text-transform: uppercase;
        font-size:16px;
        color:#ffffff;
        height: 30px;
        line-height: 30px;
        padding-left:16px;
        border-radius: 4px 4px 6px 6px;
        -moz-border-radius: 4px 4px 6px 6px;
        -webkit-border-radius:  4px 4px 6px 6px;
    }
    .f1st-menu {
        /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#e7e7e7+0,ffffff+100 */
        margin-top:-5px;
        background: #e7e7e7; /* Old browsers */
        background: -moz-linear-gradient(top,  #e7e7e7 0%, #ffffff 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top,  #e7e7e7 0%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom,  #e7e7e7 0%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e7e7e7', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
    }
    .dropdown-menu {
        -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
        box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.23);
    }
    .catalogue {
        width:100%;
        max-width: 800px;
        padding-left:10px;
        padding-right:10px;
        padding-bottom:30px;
    }
    .catalogue .box-catalogue {
        background-color: #ffffff;
        margin-bottom:10px;
        border-radius: 6px 6px 6px 6px;
        -moz-border-radius: 6px 6px 6px 6px;
        -webkit-border-radius:  6px 6px 6px 6px;
        border-color:#d7d7de;
        border-width:2px;
        border-style:solid;
        min-height: 80px;
        height:105px;
    }
    .no-plet {
        font-family: avenir-bold;
        font-size:20px;
        line-height: 45px;
        text-transform: uppercase;
        color:#000000;
    }
    .lokasi {
        font-family: mark;
        font-size:12px;
        line-height:12px;
    }
    .subject {
        font-family: avenir-bold;
        font-size:10px;
        text-transform: uppercase;
        color:#404040;
        margin-top:5px;
    }
    .kategori {
        background-color:#404040;
        font-family: avenir-bold;
        color:#ffffff;
        font-size:12px;
        padding-left:5px;
        margin-bottom:3px;
    }
    .details {
        font-family: mark;
        font-size:14px;
        line-height:14px;
    }
    .line-t {
        border-top-style: solid;
        border-top-color:#e3e3eb;
        border-top-width:1px;
    }
    .box-left {
        position: absolute;
        left:10px;
        top:0px;
        margin-left:-8px;
        margin-top:3px;
        width:143px;
        height:95px;
        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;
        border-radius: 4px 4px 4px 4px;
        -moz-border-radius: 4px 4px 4px 4px;
        -webkit-border-radius: 4px 4px 4px 4px;
        transition: all .2s ease-in-out;
    }
    .box-left:hover {
        transform: scale(1.1);
    }
    .box-right {
        width:80%;
        padding-top:5px;
        margin-left:20px;
    }
    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
        .catalogue {
            width:100%;
            max-width: 1000px;
        }
	}
	@media (max-width: 1199.98px) {
		/*Large devices (desktops, less than 1200px)*/
		/*Large*/

	}
	@media (max-width: 991.98px) {
		/* Medium devices (tablets, less than 992px)*/
		/*medium*/
        .box-right {
            width:75%;
        }
	}
	@media (max-width: 767.98px) {
		/* Small devices (landscape phones, less than 768px)
		/*small*/
        .box-right {
            width:70%;
        }
        .data-extra {
            display: none;
        }
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
        .main-content {
            padding-left:20px;
            padding-right:20px;
        }
        .box-right {
            width:65%;
        }
        .sect-top {
            height:150px;
        }
        .sect-top .dropdown {
            margin-top:30px;
        }
        .sect-top nav {
            margin-top:40px;
        }
        .catalogue .box-catalogue {
            height: 100%;
        }
	}

</style>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
</head>

<body class="content">
    <div class="sect-top">
        <div class="mytitle">Siap Siaga Bencana <span>Tempahan</span></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('assessment.overview')}}');"><i class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Logistik</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tempahan Kenderaan Bencana</li>
            </ol>
        </nav>
        <div class="btn-group">
            {{-- <a class="btn cux-btn bigger spakat-tip" onclick="downloadExcel()" data-bs-toggle="tooltip" data-bs-placement="top" title="Muat turun rekod"><i class="fal fa-file-excel"></i> &nbsp;Muat Turun Data</a> --}}
            {{-- <a class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-cog"></i>&nbsp;Kolum</a> --}}
            <a class="btn cux-btn bigger" onClick="window.print()"><i class="fal fa-print text-success"></i>&nbsp;Cetak</a>
        </div>
    </div>
    <div class="sect-top-dummy"></div>
    <div class="main-content">
        <form class="form-submit" id="the_form">
        <table id="fleet-ls" class="table-custom no-footer stripe">
            <thead>
                <th class="col-del">Bil.</th>
                <th class="text-center">Destinasi</th>
                <th class="text-center">Tujuan</th>
                <th class="text-center">Tarikh Tempahan</th>
                <th class="text-center">Tarikh & Masa Pergi</th>
                <th class="text-center">Tarikh & Masa Balik</th>
                <th class="text-center">Status Tempahan</th>
                {{-- <th class="text-center">Slip Kelulusan</th> --}}
            </thead>
            <tbody id="sortable">
                @foreach ($booking_list as $booking)
                    <tr>
                        <td style="padding-top:2px;text-align:right">{{$loop->index+1}}.</td>
                        <td>{{$booking->destination}}</td>
                        <td>{{$booking->reason}}</td>
                        <td class="text-center">{{\Carbon\Carbon::parse($booking->created_at)->format('d/m/Y')}}</td>
                        <td class="text-center">{{\Carbon\Carbon::parse($booking->start_datetime)->format('d/m/Y h:m:s A')}}</td>
                        <td class="text-center">{{\Carbon\Carbon::parse($booking->end_datetime)->format('d/m/Y h:m:s A')}}</td>
                        <td class="text-center">{{$booking->hasBookingStatus->name}}</td>

                    </tr>
                @endforeach
                @if (count($booking_list) == 0)
                <tr class="no-record">
                    <td colspan="9" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                </tr>
                @endif
            </tbody>
        </table>
        {{ $booking_list->links('pagination.default') }}
        </form>

        <div class="modal fade" id="deleteDisasterReadyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteDisasterReadyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    Adakah anda ingin menghapuskan data ini ?
                </div>
                <div class="modal-footer float-start">
                    <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                    <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                    <span class="btn btn-danger" xaction="delete" >Ya</span>
                </div>
            </div>
            </div>
        </div>

        @if ($TaskFlowAccessDisasterReady->mod_fleet_verify)
            <div class="modal fade" id="verifyDisasterReadyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="verifyDisasterReadyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        Adakah anda sudah menyemak maklumat pendaftaran ini ?
                    </div>
                    <div class="modal-footer float-start">
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                        <span class="btn btn-danger" xaction="verify" >Ya</span>
                    </div>
                </div>
                </div>
            </div>
        @endif

        @if ($TaskFlowAccessDisasterReady->mod_fleet_approval)
            <div class="modal fade" id="approvalDisasterReadyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approvalDisasterReadyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    </div>
                    <div class="modal-body">
                        Adakah anda ingin mengesahkan maklumat ini?
                    </div>
                    <div class="modal-footer float-start">
                        <span class="btn btn-module" xaction="close" style="display: none" data-bs-dismiss="modal">Tutup</span>
                        <span class="btn btn-module" xaction="no" data-bs-dismiss="modal">Tidak</span>
                        <span class="btn btn-danger" xaction="approve" >Ya</span>
                    </div>
                </div>
                </div>
            </div>
        @endif

        <div class="modal fade" id="syaratTempahan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="syaratTempahanLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        PEMBERITAHUAN
                    </div>
                    <div class="modal-body p-3 text-start">
                        <div class="mytitle">Syarat-syarat Menggunakan Kenderaan Jabatan<div>
                        <hr>
                        <div class="text-start" style="letter-spacing: 0px;color:#383631">
                        <ul class="notice pe-5">
                            <li>Permohonan mesti diserahkan kepada Pegawai Kenderaan <span> selewat-lewatnya 3 hari  sebelum </span> tarikh  penggunaan bagi perjalanan  keluar daerah dan
                            <span> 1 hari sebelum </span> penggunaan bagi perjalanan / urusan tempatan. </li>
                            <li>Borang ini hendaklah diisi dengan <span>LENGKAP dan JELAS </span>. Semua perjalanan adalah atas urusan rasmi kerajaan sahaja.</li>
                            <li>Pemohon <span> PERLU melampirkan surat / memo arahan tugas / jemputan mesyuarat / kursus / aktiviti </span> daripada pihak berkaitan.</li>
                            <li>Borang permohonan yang tidak lengkap tidak akan diproses dan kelulusan tertakluk kepada keutamaan tugas dan kekosongan kenderaan.</li>
                        </ul>
                        <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <button class="btn btn-module bigger" type="button" onclick="openPgInFrame('{{route('logistic.disasterready.register')}}')">Setuju</button>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Tidak Setuju</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

{{-- <script src="{{asset('my-assets/plugins/datatables/datatables.js')}}"></script> --}}
<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    var ids = [];
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

        $('#chkall').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));

            var rows = $('[name="chkdel"]:checked').map(function () {
            return this.value;
            } );

            if(rows.length > 0){
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', false);
            } else {
                $('[xaction="delete_all"],[xaction="verify_all"], [xaction="approve_all"]').prop('disabled', true);
            }

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

            $('[name="chkdel"]:checked').map(function () {
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.disasterready.delete')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#deleteDisasterReadyModal .modal-body').text('Maklumat kenderaan berjaya dihapuskan');
                show('[xaction="close"]');
                //$('#deleteDisasterReadyModal').modal('hide');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

        $('[xaction="verify"]').on('click', function(e){
            e.preventDefault();

            hide('[xaction="verify"]');
            hide('[xaction="no"]');

           $('[name="chkdel"]:checked').map(function () {
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.disasterready.approval')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#verifyDisasterReadyModal .modal-body').text('Maklumat kenderaan berjaya dihantar untuk pengesahan');
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

            $('[name="chkdel"]:checked').map(function () {
                ids.push(parseInt(this.value));
            } );

            $.post('{{route('logistic.disasterready.approve')}}', {
                'ids': ids,
                '_token':'{{ csrf_token() }}'
            }, function($data){
                $('#approvalDisasterReadyModal .modal-body').text('Maklumat kenderaan berjaya disahkan');
                show('[xaction="close"]');
            });

            $('[xaction="close"]').on('click', function(){
                window.location.reload();
            })
        });

    });
</script>
</body>
</html>


