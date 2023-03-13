@php
    use App\Http\Controllers\Vehicle\VehicleDAO;

   $AccessVehicle = auth()->user()->vehicle('01', '01');
   $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('01', '01');
   $totalByStatus = "";

   $xmode = Request('xmode') ? Request('xmode') : 'list';
   $fleet_view = Request('fleet_view') ?  Request('fleet_view') : 'department';
   $ownership = Request('ownership') ?  Request('ownership') : 'jkr';
   $locations = Request('locations.placement.name') ?  Request('locations.placement.name') : 'Persekutuan';

   $status = Request('status') ? Request('status') : null;
   $search = Request('search') ?  Request('search') : null;
   $xid = Request('xid') ? (int) Request('xid') : 0;

   $owner_id = Request('owner_id');
   $state_id = Request('state_id');
   $type_id = Request('type_id');

   $VehicleDAO = new VehicleDAO();
   $VehicleDAO->mount();

   $owner_type_list = $VehicleDAO->owner_type_list;
   $dispose_list = $VehicleDAO->dispose_list;
   $totalByStatus = $VehicleDAO->totalVehicleByStatus('all');
    if($xmode == 'catelog'){
        $vehicles = $VehicleDAO->vehicles;
    }

    $totaldraf = 0;
    $totalverification = 0;
    $totalapproval = 0;

@endphp
@if(!empty($totalByStatus))
@foreach ($totalByStatus as $v_status)
    @php
        switch ($v_status->code) {
            case '01':
            $totaldraf = $v_status->total;
                break;
            case '02':
            $totalverification = $v_status->total;
                break;
            case '03':
            $totalapproval = $v_status->total;
                break;
        }
    @endphp
@endforeach
@endif
<html>
    <head>
        <style>
            .text-center {
                text-align: center;
            }
        </style>
    </head>
<body>
    <table class="table-custom no-footer stripe" style="{{count($listFleets) == 1 ? 'height: calc(100vh / 2);' : ''}}">
        <thead>
            <tr>
                <td colspan="22" style="height: 30px; padding-bottom: 10px; font-size: 15px; font-weight: 900;border: 1px solid black;">
                    Senarai Kenderaan JKR - {{\Carbon\Carbon::now()->format('d.m.Y')}}
                </td>
            </tr>
            <tr>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">Bil</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NO.PENDAFTARAN</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">HAKMILIK</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NEGERI</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">CAWANGAN</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">LOKASI PENEMPATAN</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NO ID PEMUNYA</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">KATEGORI</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">SUB KATEGORI</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">JENIS</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">PEMBUAT</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">MODEL</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NO.JKR</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NO.LOJI</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NO ENGINE</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">NO CHASIS</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">STATUS</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">HARGA PEROLEHAN</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">TARIKH PEROLEHAN</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">TAHUN DIBUAT</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">USIA</th>
                <th style="text-align: center; font-weight: 700; height 100px;border: 1px solid black;">DIKEMASKINI OLEH</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listFleets as $index => $fleet)
            <tr>
                <td style="text-align: center;">{{$index + 1}}</td>
                <td style="text-align: center;">{{$fleet->no_pendaftaran}}</td>
                <td style="text-align: center;">{{$fleet->ownership}}</td>
                <td style="text-align: center;">{{$fleet->negeri}}</td>
                <td style="text-align: center;">{{$fleet->branch_name}}</td>
                <td style="text-align: center;">{{$fleet->placement_name}}</td>
                <td style="text-align: center;">{{$fleet->no_id_pemunya}}</td>
                <td style="text-align: center;">{{$fleet->kategori}}</td>
                <td style="text-align: center;">{{$fleet->sub_kategori}}</td>
                <td style="text-align: center;">{{$fleet->jenis}}</td>
                <td style="text-align: center;">{{$fleet->pembuat}}</td>
                <td style="text-align: center;">{{$fleet->model}}</td>
                <td style="text-align: center;">{{$fleet->no_jkr}}</td>
                <td style="text-align: center;">{{$fleet->no_loji}}</td>
                <td style="text-align: center;">{{$fleet->no_engine}}</td>
                <td style="text-align: center;">{{$fleet->no_chasis}}</td>
                <td style="text-align: center;">{{$fleet->status}}</td>
                <td style="text-align: center;">{{$fleet->harga_perolehan}}</td>
                <td style="text-align: center;">{{$fleet->tarikh_perolehan}}</td>
                <td style="text-align: center;">{{$fleet->manufacture_year}}</td>
                <td style="text-align: center;">{{$fleet->age}}</td>
                <td style="text-align: center;">{{$fleet->tarikh_kemaskini}}</td>
                
            </tr>
        @endforeach
        </tbody>
    </table>
    
</body>
</html>
