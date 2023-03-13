<table><tr><td  colspan='4' ><div class="small-title" style='margin-bottom:15px'>{{$selectedWaran}} - PENYATA  PERBELANJAAN TAHUN {{$selectedYear}}</div></td></tr></table>
    <table>
        <tr>
            
            <td class="col-mth header-depreciation">PERKARA</td>
            <td class="col-mth header-depreciation" >TARIKH</td>
            <td class="col-mth header-depreciation" >PERBELANJAAN (RM)</td>
            <td class="col-mth header-depreciation" >TANGUNGAN (RM)</td>
        </tr>
        <tbody>

            @if(count($listStatement)> 0)
            @foreach ($listStatement as $item)
            <tr data-id = "" >
                <td  class="row-item table-item" style="text-transform:uppercase">{{$item->description}}</td> 
                <td class="row-item table-item " style="text-transform:uppercase">{{\Carbon\Carbon::parse($item->date)->format('d M Y')}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$item->expense != "" ? number_format($item->expense,2):""}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$item->advance != "" ? number_format($item->advance,2):""}}</td>
            </tr>
            @endforeach
            @else 
            <tr>
                <td class="row-item table-item" style="text-transform:uppercase" colspan='4'>Tiada Maklumat</td>
            </tr>
            @endif
            
        </tbody>
    </table>