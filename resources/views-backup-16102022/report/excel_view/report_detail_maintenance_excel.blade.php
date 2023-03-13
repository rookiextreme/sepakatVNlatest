<table>
    <tr><td class='small-title' style='border-left:2px solid white;border-top:2px solid white' colspan='12'>{{$selectedWorkshop}}  BULAN {{strtoupper($monthDesc[$selectedMonth])}} {{$selectedYear}}</td></tr>
   <tr>
        <td class="col-mth purple">Bil.</td>
        <td class="col-mth purple" style='min-width:200px !important;'>Nama Syarikat</td>
        <td class="col-mth purple">Perkhidmatan / Bekalan</td>
        <td class="col-mth purple" style='min-width:100px !important;'>Kenderaan</td>
        <td class="col-mth purple" style='min-width:100px !important;'>Jenis Kenderaan</td>
        <td class="col-mth purple" style='min-width:200px !important;'>Pelanggan</td>
        <td class="col-mth purple" style='min-width:300px !important;'>Perihal Kerja</td>
        <td class="col-mth purple">Bulan</td>
        <td class="col-mth purple">Amaun (RM)</td>
        <td class="col-mth purple">PJM</td>
        <td class="col-mth purple">Servis / Pembaikan</td>
        <td class="col-mth purple">Peruntukan</td>
   </tr>
    <tbody>

        @if(count($listReport)> 0)
        @foreach ($listReport as $item)
        <tr>
            <td class="col-focus ">{{$loop->index+1}}</td>
            <td class="col-focus ">{{$item->company_name}}</td>
            <td class="col-focus ">{{$item->company_servis}}</td>
            <td class="col-focus ">{{$item->plate_no}}</td>
            <td class="col-focus ">{{$item->vehicle_type}}</td>
            <td class="col-focus ">{{$item->customer}}</td>
            <td class="col-focus ">{{$item->work_detail}}</td>
            <td class="col-focus ">{{$item->month}}</td>
            <td class="col-focus ">{{str_replace(',','', $item->amount)}}</td>
            <td class="col-focus ">{{$item->pjm_name}}</td>
            <td class="col-focus ">{{$item->maintenance_type}}</td>
            <td class="col-focus ">{{$item->warrant_type}}</td>
        </tr>

        @endforeach
        @else 
        <tr>
            <td class="col-focus " colspan='12'>Tiada Maklumat</td>
        </tr>
        @endif
    </tbody>
</table>