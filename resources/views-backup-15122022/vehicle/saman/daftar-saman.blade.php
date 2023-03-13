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
use App\Http\Controllers\Vehicle\Summon\FormMaklumatKenderaan;
use App\Http\Controllers\Vehicle\Summon\FormMaklumatSaman;

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

$summon_id = $FormMaklumatSamanDAO->saman_id;
$vehicleDetail = $FormMaklumatSamanDAO->vehicleDetail;
$branchs = $FormMaklumatSamanDAO->branchs;
$states = $FormMaklumatSamanDAO->states;
$summonDetail = $FormMaklumatSamanDAO->informations;
$summon = $FormMaklumatSamanDAO->summon;
$summon_agencies = $FormMaklumatSamanDAO->summon_agencies;
$summon_types = $FormMaklumatSamanDAO->summon_types;

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
        /*.input-group-text {
            height: 42px !important;
            line-height:28px;
            background-color:#ffffff;
            border-radius: 0px 8px 8px 0px;
            -moz-border-radius: 0px 8px 8px 0px;
            -webkit-border-radius: 0px 8px 8px 0px;
            font-family: avenir;
            font-size: 12px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            border-color:#dcdcd8;
            border-width:2px;
            border-style:solid;
            cursor: pointer;
        }
        .input-group input {
            height: 38px !important;
            padding-top:5px !important;
        }*/

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
        .input-group-text {
            height: 39px;
            line-height:28px;
            background-color:#ffffff;
            border-radius: 0px 8px 8px 0px;
            -moz-border-radius: 0px 8px 8px 0px;
            -webkit-border-radius: 0px 8px 8px 0px;
            font-family: avenir;
            font-size: 12px;
            -webkit-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            -moz-box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            box-shadow: 0px 0px 16px -5px rgba(0,0,0,0.13);
            border-color:#dcdcd8;
            border-width:2px;
            border-style:solid;
            cursor: pointer;
        }
        .date {
            height: 50px !important;
        }

        .fancybox__content{
            height: 100vh !important;
        }
        .fs-info {
            font-size: 12px;
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
    <div class="mytitle">Rekod Saman</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('dsh_admin.htm');">
                    <i class="fal fa-home"></i></a>
            </li>
            <!--<li class="breadcrumb-item"><a href="#">Kenderaan</a></li>-->
            @if($roleAccessCode == '04')
            <li class="breadcrumb-item"><a href="{{ route('vehicle.saman.rekodbayar') }}">Rekod Pembayaran Saman</a></li>
                @else
                <li class="breadcrumb-item"><a href="{{ route('vehicle.saman.rekod') }}">Senarai</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Borang</li>
        </ol>
    </nav>
    <div class="main-content">
        @php
            $publicPath = "";
            if($vehicleDetail && $vehicleDetail->hashVehicleImagePrimary() && $vehicleDetail->hashVehicleImagePrimary()->doc_path_thumbnail){
                $publicPath = '/'.$vehicleDetail->hashVehicleImagePrimary()->doc_path_thumbnail.'/'.$vehicleDetail->hashVehicleImagePrimary()->doc_name;
            }
        @endphp

        <div class="row mb-2" id="vehicle_info">
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-4 line-r">
                <div class="polaroid">
                    <div class="box-left" style="background-image: url({{$publicPath}});">&nbsp;</div>
                    <div class="plet-no">{{$vehicleDetail->no_pendaftaran}}</div>
                </div>
            </div>

            <div class="col-xl-10 col-lg-10 col-sm-8 col-md-10">
                @if(env('APP_ENV') == 'local')
                {{-- <textarea name="" id="" cols="30" rows="10" class="form-control">
                    @json($vehicleDetail)
                </textarea> --}}
                @endif
                {{-- <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                        <div class="box-info">
                            <div class="rlabel">No Pendaftaran</div>
                            <div class="mytext">{{$vehicleDetail->no_pendaftaran?:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Tahun Dibeli</div>
                            <div class="mytext">{{$vehicleDetail->acqDt? \Carbon\Carbon::parse($vehicleDetail->acqDt)->format('d M Y'):'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Tahun Dibuat</div>
                            <div class="mytext">{{$vehicleDetail->hasMoreDetail->manufacture_year ? : '-'}}</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">
                        <div class="box-info">
                            <div class="rlabel">No Enjin</div>
                            <div class="mytext">{{$vehicleDetail->no_pendaftaran?:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">No Casis</div>
                            <div class="mytext">{{$vehicleDetail->acqDt? \Carbon\Carbon::parse($vehicleDetail->acqDt)->format('d M Y'):'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">No JKR</div>
                            <div class="mytext">{{$vehicleDetail->hasMoreDetail->manufacture_year ? : '-'}}</div>
                        </div>
                    </div>
                    <div class="col-12"></div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="box-info">
                            <div class="rlabel">Cawangan</div>
                            <div class="mytext">{{$vehicleDetail->cawangan ? $vehicleDetail->cawangan->name: '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Pengawai Bertanggungjawab</div>
                            <div class="mytext">{{$vehicleDetail->hasPersonIncharge ? $vehicleDetail->hasPersonIncharge->name: '-'}}</div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        {{-- <div class="box-info">
                            <div class="rlabel">No Pendaftaran</div>
                            <div class="mytext">{{$vehicleDetail->no_pendaftaran?:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Model</div>
                            <div class="mytext">{{$vehicleDetail->hasModel ? $vehicleDetail->hasModel->name:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Buatan</div>
                            <div class="mytext">{{$vehicleDetail->hasBrand ? $vehicleDetail->hasBrand->name:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Kategori</div>
                            <div class="mytext">{{$vehicleDetail->hasCategory() ? $vehicleDetail->hasCategory()->name:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Sub-Kategori</div>
                            <div class="mytext">{{$vehicleDetail->hasSubCategory() ? $vehicleDetail->hasSubCategory()->name:'-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Jenis</div>
                            <div class="mytext">{{$vehicleDetail->hasSubCategoryType() ? $vehicleDetail->hasSubCategoryType()->name:'-'}}</div>
                        </div> --}}
                        <div class="row pe-2 ps-3">
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">No Pendaftaran</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->no_pendaftaran?:'-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Model</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasModel ? $vehicleDetail->hasModel->name:'-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Buatan</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasBrand ? $vehicleDetail->hasBrand->name:'-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Kategori</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasCategory() ? $vehicleDetail->hasCategory()->name:'-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Sub-Kategori</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasSubCategory() ? $vehicleDetail->hasSubCategory()->name:'-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Jenis</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasSubCategoryType() ? $vehicleDetail->hasSubCategoryType()->name:'-'}}</div>
                            <hr>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        {{-- <div class="box-info">
                            <div class="rlabel">Hak Milik</div>
                            <div class="mytext">{{$vehicleDetail->hasOwnerType ? $vehicleDetail->hasOwnerType->desc_bm : '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Cawangan</div>
                            <div class="mytext">{{$vehicleDetail->cawangan ? $vehicleDetail->cawangan->name: '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Pegawai Bertanggungjawab</div>
                            <div class="mytext">{{$vehicleDetail->hasPersonIncharge ? $vehicleDetail->hasPersonIncharge->name: '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Negeri</div>
                            <div class="mytext">{{$vehicleDetail->hasState ? $vehicleDetail->hasState->desc : '-'}}</div>
                        </div>
                        <div class="box-info">
                            <div class="rlabel">Lokasi Penempatan</div>
                            <div class="mytext">{{$vehicleDetail->hasPlacement() ? $vehicleDetail->hasPlacement()->desc : '-'}}</div>
                        </div> --}}
                        <div class="row pe-2 ps-3">
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Hak Milik</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasOwnerType ? $vehicleDetail->hasOwnerType->desc_bm : '-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Cawangan</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->cawangan ? $vehicleDetail->cawangan->name: '-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Pegawai Bertanggungjawab</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasPersonIncharge ? $vehicleDetail->hasPersonIncharge->name: '-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Negeri</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasState ? $vehicleDetail->hasState->desc : '-'}}</div>
                            <hr>
                            <div class="col-6 fs-info">
                                <label for="" class="form-label">Lokasi Penempatan</label>
                            </div>
                            <div class="col-6 fs-info text-end">{{$vehicleDetail->hasPlacement() ? $vehicleDetail->hasPlacement()->desc : '-'}}</div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li class="cub-tab active" onClick="goTab(this, 'detail');" id="tab1">Saman</li>
                    @if($SummonFormVehicle && in_array($SummonFormVehicle->statusSaman->code, ['02','03','04','05']))
                        <li class="cub-tab" {{ empty($SummonFormVehicle)? 'disabled' : '' }} onClick="goTab(this, 'payment');" id="tab2">Pelunasan</li>
                    @endif
                </ul>
                <div class="under-active d-none d-sm-block d-md-block">&nbsp;</div>
            </div>
        </div>

        <div class="messages"></div>
        <section id="detail" class="tab-content">
            @include('vehicle.saman.tab.saman-detail')
        </section>
        @if($SummonFormVehicle && in_array($SummonFormVehicle->statusSaman->code, ['02','03','04','05']))
            <section id="payment" class="tab-content">
                @include('vehicle.saman.tab.saman-payment')
            </section>
        @endif

        {{-- <div class="modal fade" id="pemilikSearch" tabindex="-1" aria-labelledby="pemilikSearchLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <div class="modal-body">
                    <h3 class="text-dark">Pilih Pemilik vehicleaan</h3>
                    <p class="text-muted">Pilih vehicleaan daripada rekod vehicleaan yang berdaftar.</p><hr>
                    <div class="row">
                      <div class="col-6">
                        <input type="text" wire:model="owner" class="form-control" placeholder="cari vehicleaan">
                      </div>
                      <div class="col-12 mt-2">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>No Identiti</th>
                                <th>Kakitangan Kerajaan</th>
                                <th>Nama</th>
                                <th>No Telefon</th>
                                <th>Emel</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($pemiliks as $pemilik)
                                  <tr wire:click.prevent="pemilik({{$pemilik->user->id}})">
                                    <td>{{$pemilik->identity_no}}</td>
                                    <td>{{$pemilik->gov_staff ? 'Ya' : 'Tidak'}}</td>
                                    <td class="text-dark fw-bold">{{$pemilik->user->name}}</td>
                                    <td>{{$pemilik->telbimbit}}</td>
                                    <td>{{$pemilik->user->email}}</td>
                                  </tr>
                              @endforeach
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div> --}}

        <div class="modal fade" id="promptSubmitForPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="promptSubmitForPaymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body">
                    <h3 class="title"></h3>
                    <p class="sub-title">
                        Adakah maklumat saman telah lengkap?
                        Maklumat ini akan dihantar ke senarai menunggu proses pembayaran
                    </p>
                </div>
                <div class="modal-footer">
                  <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                  <button type="button" style="display: none" id="reload" class="btn btn-secondary" onclick="goToSummonList()">Tutup</button>
                  <button type="button" id="remove" class="btn btn-danger text-white" onclick="submitForPayment()">Ya</button>
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
                <div class="modal-footer">
                  <button type="button" id="close" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                  <button type="button" style="display: none" id="reload" class="btn btn-secondary" onclick="goToSummonList()">Tutup</button>
                  <button type="button" id="remove" class="btn btn-danger text-white" onclick="submitPaymentSaman()">Ya</button>
                </div>
              </div>
            </div>
        </div>

        @include('components.modal-enlarge-image')

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/fancybox/css/fancybox.css') }}">
    <script src="{{ asset('my-assets/plugins/fancybox/js/fancybox.umd.js') }}"></script>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/plugins/datepicker/locales/bootstrap-datepicker.ms.min.js') }}"></script>

    <script type="text/javascript">

        let selectedSuppDocId = null;

        var paramTab = {{Request('tab')? Request('tab') : 1}};

        function backToList(){
            window.location = "{{route('vehicle.list-alternate')}}";
        }

        const fancyView = function(url){
            const fancybox = new Fancybox([
            {
                src: url,
                type: "iframe",
            },
            ]);

            fancybox.on("done", (fancybox, slide) => {
            console.log(`done!`);
            });
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
            $.get("{{route('vehicle.saman.ajax.getVehicle')}}", {
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

            $.get("{{route('vehicle.saman.ajax.getVehicle.total')}}", {
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
                        $('#vehicleTotal').text('Tiada Rekod');
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
            let targetVehicleInput = $('#vehicle_id');
            let targetVehicleDisplay = $('#vehicle_display');
            targetVehicleInput.val(vehicle_id);
            targetVehicleDisplay.val(vehicle_no);
            $('#VehicleSearchModal').modal('hide');
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
                theme: "classic",
                placeholder: {
                    id: '-1', // the value of the option
                    text: 'Sila pilih'
                }
            });

        });

    </script>
</body>

</html>
