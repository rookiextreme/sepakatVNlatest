@php
   $search = request('search') ? request('search') : '';
   $offset = request('offset');
   $limit = 5;
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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
<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>

<style type="text/css">
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
</style>
<script>
    $(document).ready(function() {
    });
</script>
</head>

<body class="content">
<div class="mytitle">Jejak Pengguna</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('access.admin.dashboard')}}')"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Pengurusan Akses</a></li>
      <li class="breadcrumb-item active" aria-current="page">Jejak Pengguna</li>
    </ol>
</nav>
<div class="main-content">

    <div class="row">
        <div class="d-flex justify-content-end">
            <div class="col-md-3">
                <div class="input-group">
                    <input type="search" onkeyup="searching(this)" class="form-control spec-sch mt-0" placeholder="Carian Jejak Pengguna" value="{{$search}}">
                    <span class="input-group-text cux-btn" id="basic-addon2" style="height:38px;"><i class="fal fa-search fa-lg"></i></span>
                </div>
            </div>
        </div>
    </div>

<form class="form-submit" id="the_form">
    <table id="fleet-ls" class="table display compact stripe hover compact table-bordered">
        <thead>
            {{-- <th><input name="chkall" id="chkall" type="checkbox"></th> --}}
            <th>Modul</th>
            <th>Rujukan</th>
            <th class="text-center">Tarikh & Masa</th>
            <th class="text-center">Nama Pengguna</th>
            <th class="text-center">Transaksi</th>
            <th class="text-center">Data Sebelum</th>
            <th class="text-center">Data Selepas</th>
        </thead>
        <tbody id="sortable">
        @foreach ($audit_trail_list as $audit_trail)

        @php
            $isSame['no_pendaftaran'] = false;
            $isSame['placement'] = false;
            $isSame['owner_type'] = false;
            $isSame['no_jkr'] = false;
            $isSame['no_engine'] = false;
            $isSame['no_chasis'] = false;
            $isSame['username'] = false;
            $isSame['subcategorytype'] = false;
            $dataBefore = json_decode(collect($audit_trail->before));
            $dataBeforeFirst = [];
            foreach ($dataBefore as $key) {
                $dataBeforeFirst = json_decode($key, true);
            }

            $dataAfter = json_decode(collect($audit_trail->after));
            $dataAfterFirst = [];
            foreach ($dataAfter as $key) {
                $dataAfterFirst = json_decode($key, true);
            }

            \Log::info('before');
            \Log::info(count($dataBeforeFirst));
            \Log::info('after');
            \Log::info(count($dataAfterFirst));

            if(count($dataBeforeFirst)>0 && count($dataAfterFirst)> 0){
                if($dataBeforeFirst['no_pendaftaran'] != $dataAfterFirst['no_pendaftaran']){
                    $isSame['no_pendaftaran'] = true;
                }
                if($dataBeforeFirst['placement'] != $dataAfterFirst['placement']){
                    $isSame['placement'] = true;
                }
                if($dataBeforeFirst['owner_type'] != $dataAfterFirst['owner_type']){
                    $isSame['owner_type'] = true;
                }
                if($dataBeforeFirst['no_jkr'] != $dataAfterFirst['no_jkr']){
                    $isSame['no_jkr'] = true;
                }
                if($dataBeforeFirst['no_engine'] != $dataAfterFirst['no_engine']){
                    $isSame['no_engine'] = true;
                }
                if($dataBeforeFirst['no_chasis'] != $dataAfterFirst['no_chasis']){
                    $isSame['no_chasis'] = true;
                }
                if($dataBeforeFirst['subcategorytype'] != $dataAfterFirst['subcategorytype']){
                    $isSame['subcategorytype'] = true;
                }
            }
        @endphp
           <tr>
               {{-- <td><input type="checkbox" value="{{$audit_trail->id}}"></td> --}}
               <td>{{$audit_trail->submodul}}</td>
               <td>{{$audit_trail->reference}}</td>
               <td class="text-center">{{\Carbon\Carbon::parse($audit_trail->audit_ts)->format('d/m/Y h:m:s A')}}</td>
               @php
                   $dataBefore_Username = isset($dataBeforeFirst['username']) ?$dataBeforeFirst['username'] : '';
                   $dataAfter_Username = isset($dataAfterFirst['username']) ?$dataAfterFirst['username'] : '';
               @endphp
               <td>{{$audit_trail->operation == 'HAPUS' ? $dataBefore_Username : $dataAfter_Username}}</td>
               <td class="text-center">
                   @if ($audit_trail->operation == 'UPDATE')
                        @if(isset($dataAfterFirst['vapp_status']))
                            @switch($dataAfterFirst['vapp_status'])
                                @case(1)
                                    HAPUS
                                    @break
                                @default
                                    KEMASKINI

                            @endswitch
                            @else
                            KEMASKINI
                        @endif
                   @endif
                </td>
                <td>
                    <div>{{$isSame['no_pendaftaran']  ? ' No Pendaftaran : '.$dataBeforeFirst['no_pendaftaran'] : null}}</div>
                    <div>{{$isSame['placement']  ? ' Lokasi Penempatan : '.$dataBeforeFirst['placement'] : null}}</div>
                    <div>{{$isSame['owner_type']  ? ' Hak Milik : '.$dataBeforeFirst['owner_type'] : null}}</div>
                    <div>{{$isSame['no_jkr']  ? ' Nombor JKR : '.$dataBeforeFirst['no_jkr'] : null}}</div>
                    <div>{{$isSame['no_engine']  ? ' Nombor Enjin : '.$dataBeforeFirst['no_engine'] : null}}</div>
                    <div>{{$isSame['no_chasis']  ? ' Nombor Chasis : '.$dataBeforeFirst['no_chasis'] : null}}</div>
                    <div>{{$isSame['subcategorytype']  ? ' Jenis : '.$dataBeforeFirst['subcategorytype'] : null}}</div>
                </td>
                <td>
                    <div>{{$isSame['no_pendaftaran']  ? ' No Pendaftaran : '.$dataAfterFirst['no_pendaftaran'] : null}}</div>
                    <div>{{$isSame['placement']  ? ' Lokasi Penempatan : '.$dataAfterFirst['placement'] : null}}</div>
                    <div>{{$isSame['owner_type']  ? ' Hak Milik : '.$dataAfterFirst['owner_type'] : null}}</div>
                    <div>{{$isSame['no_jkr']  ? ' Nombor JKR : '.$dataAfterFirst['no_jkr'] : null}}</div>
                    <div>{{$isSame['no_engine']  ? ' Nombor Enjin : '.$dataAfterFirst['no_engine'] : null}}</div>
                    <div>{{$isSame['no_chasis']  ? ' Nombor Chasis : '.$dataAfterFirst['no_chasis'] : null}}</div>
                    <div>{{$isSame['subcategorytype']  ? ' Jenis : '.$dataAfterFirst['subcategorytype'] : null}}</div>
                </td>
           </tr>
        @endforeach
        </tbody>
        {{-- <tfoot>
            <th></th>
            <th></th>
            <th class="text-center">Tarikh & Masa</th>
            <th class="text-center">Nama Pengguna</th>
            <th class="text-center">Transaksi</th>
            <th class="text-center">Data Sebelum</th>
            <th class="text-center">Data Selepas</th>
        </tfoot> --}}
    </table>
</form>
{{ $audit_trail_list->links('pagination.default') }}
</div>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>

<script>
    jQuery(document).ready(function() {
        initTab();

        $('select').select2({
			width: '60px',
			theme: "classic",
			minimumResultsForSearch: -1
        });
    })
</script>
</body>
</html>

{"brand": "INOKOM", "model": "SANTA-FE 2.4 (A)", "state": "WP PUTRAJAYA", "no_jkr": "UVP20151", "category": "KENDERAAN PENUMPANG", "username": null, "no_chasis": "PL84C56GRB1100584", "no_engine": "G4KEBU449155", "placement": null, "owner_type": "PERSEKUTUAN", "subcategory": "KERETA", "owner_branch": null, "vehiclestatus": "AKTIF", "no_pendaftaran": "WWB9334", "subcategorytype": "PACUAN 4 RODA (4 X 4)"}
